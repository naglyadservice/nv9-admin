<?php

namespace App\Console\Commands;

use App\Models\Device;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class Fiscalize extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fiscalize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fiscalize sales';

    /** The error string instead cheque number
     *
     * @var string
     */
    protected $errorFiscalize = null;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $log = Log::build(['driver' => 'single', 'path' => storage_path('logs/'.date('Y-m-d').'_fiscalize.log')]);

        $now = Carbon::now();
        $time = $now->format('H:i');
        $log->info('time: '.$time.' '.__FILE__.':'.__LINE__);
        if($time >= '23:40' || $time <= '00:05'){
            return Command::SUCCESS;
        }

        //Проверяем еще необходимость фискализировать по включенной фискализации на устройстве
        $need_fiscalize = DB::table('fiskalization_table')
            ->where('fiskalized', false)
            ->where('date', '>=', Carbon::now()->subMinutes(40))
            ->orderBy('date', 'ASC')
            ->get();

        //Проверка необходимости фискализации
        foreach ($need_fiscalize as $order) {
            $log->info('fiscalization ID : '.$order->id.' '.__FILE__.':'.__LINE__);
            print_r($order->id);
            $device = Device::where('factory_number', $order->factory_number)
                ->orWhereHas('serialNumbers', function($q) use ($order) {
                    $q->where('serial_number', $order->factory_number);
                })
                ->first();

            if($device && $device->enabled_fiscalization && $device->cashier_token && $device->fiscalization_key_id)
            {
                try{
                    //Фискализируем продажу
                    $fiskal = $device->not_fiscal_cash && $order->cash == 1;
                    if($order->sales_cashe <= 0 || $fiskal)
                    {
                        DB::table('fiskalization_table')
                            ->where('id', $order->id)
                            ->update([
                                'fiskalized' => true
                            ]);
                        continue;
                    }

                    $resp = $device->createReceipt( $device, $order);
                    $check = $resp['check'];
                    $shift = $resp['shift'];

                    $checkField = $this->errorFiscalize;
                    $err = null;

                    if(isset($check->id) && $check->id)
                    {
                        $checkField = $check->id;
                    } elseif (isset($check->message)) {
                        $err = $check->message;
                        if($shift && isset($shift->message)){
                            $err .= ' '.$shift->message;
                        }
                        print_r($err);
                    }

                    $fiskalized = true;
                    if (isset($check->message) && ($check->message == "Зміну не відкрито" || str_starts_with($check->message, "Зміну відкрито понад")))
                    {
                        $fiskalized = false;
                    }

                    DB::table('fiskalization_table')
                        ->where('id', $order->id)
                        ->update([
                            'check_code' => $checkField,
                            'fiskalized' => $fiskalized,
                            'error' => $err
                        ]);

                    sleep(1);

                } catch (\Exception $e)
                {
                    $log->error('Exception: '.$e->getMessage().__FILE__.':'.__LINE__);
                    print_r($e->getMessage());
                    continue;
                }

            } else {

                $log->warning('fiscalization not enabled: '.__FILE__.':'.__LINE__);

                DB::table('fiskalization_table')
                    ->where('id', $order->id)
                    ->update([
                        'fiskalized' => true
                    ]);
            }
        }

        return Command::SUCCESS;

    }
}
