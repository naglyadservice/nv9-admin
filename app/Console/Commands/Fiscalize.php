<?php

namespace App\Console\Commands;

use App\Models\Device;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
        //Проверяем еще необходимость фискализировать по включенной фискализации на устройстве
        $need_fiscalize = DB::table('fiskalization_table')
            ->where('fiskalized', false)
            ->where('date', '>=', Carbon::now()->subMinutes(10))
            ->get();
        
        //Проверка необходимости фискализации
        foreach ($need_fiscalize as $order) {
            print_r($order->id);
            $device = Device::where('factory_number', $order->factory_number)
                ->first();

            if($device && $device->enabled_fiscalization && $device->cashier_token && $device->fiscalization_key_id)
            {
                try{
                    //Фискализируем продажу
                    if($order->sales_cashe <= 0)
                    {
                        DB::table('fiskalization_table')
                            ->where('id', $order->id)
                            ->update([
                                'fiskalized' => true
                            ]);
                        continue;
                    }

                    $cashType = "CASH";

                    if($order->cash == 0)
                    {
                        $cashType = "CASHLESS";
                    }


                    $check = $device->createReceipt($device->cashier_token, $order->sales_cashe, $device->fiscalization_key->cashier_license_key, $device, $cashType);

                    // if(isset($check["err"]))
                    // {
                    //     $order->error = $check["err"];
                    //     $order->update();
                    //     continue;
                    // }
                    //file_put_contents(public_path()."/fisc.txt", print_r($check, true));

                    $checkField = $this->errorFiscalize;
                    $err = null;

                    if(isset($check->id) && $check->id)
                    {
                        $checkField = $check->id;
                    } elseif (isset($check->message)) {
                        $err = $check->message;
                        print_r($check->message);
                    }

                    DB::table('fiskalization_table')
                        ->where('id', $order->id)
                        ->update([
                            'check_code' => $checkField,
                            'fiskalized' => true,
                            'error' => $err
                        ]);

                    sleep(1);

                } catch (\Exception $e)
                {
                    print_r($e->getMessage());
                    continue;
                }

            } else {

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
