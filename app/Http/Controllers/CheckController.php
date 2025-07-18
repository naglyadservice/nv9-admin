<?php

namespace App\Http\Controllers;

use App\Helpers\LiqPay;
use App\Helpers\LogMy;
use App\Models\Device;
use App\Models\Fiscalization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CheckController extends Controller
{
    public function check(Request $request)
    {
        if ($request->has('id'))
        {
            $deviceID = (int)$request->id;
            $device = Device::where('id', $deviceID)->firstOrFail();
            $last_three = DB::table('fiskalization_table')
                ->where('factory_number', $device->factory_number)
                ->where('fiskalized', true)
                ->whereNotNull('check_code')
                ->orderBy('id', 'DESC')
                ->take(3)
                ->get();

            $user = User::where(['id'=>$device->user_id])->first();

           // dd($user);

            return view('fiscalization.check_dewash', compact('last_three','user'));
        } else {
            abort(404);
        }
    }

    public function check_hash(Request $request, $hash)
    {
        $deviceID = (int)$request->id;
        $device = Device::where('device_hash', $hash)->firstOrFail();
        $serialNumbers = $device->serialNumbers()->pluck('serial_number')->toArray();
        $serialNumbers[] = $device->factory_number;

        $last_three = DB::table('fiskalization_table')
            ->whereIn('factory_number', $serialNumbers)
           // ->where('fiskalized', true)
         //   ->whereNotNull('check_code')
           ->where('sales_cashe', '<>', 0)
            ->where('date', '>=', now()->subMinutes(10))
            ->orderBy('id', 'DESC')
            ->take(3)
            ->get();
        $device_code = substr($device->factory_number, 5, 4);
        $post_number = $device->id;
        $address = $device->address;
        $placeName = $device->place_name;
        $user = User::where(['id'=>$device->user_id])->first();

        if($device->design == Device::STANDART) {
            return view('fiscalization.check_dewash', compact('last_three', 'device', 'device_code', 'hash', 'user'));
        }
        else if($device->design == Device::MONO)
        {
            return view('fiscalization.check_mono', compact('last_three', 'device', 'device_code', 'hash', 'user'));
        }
        else if($device->design == Device::MONO125)
        {
            return view('fiscalization.check_mono125', compact('last_three', 'device', 'device_code', 'hash', 'user'));
        }
        else if($device->design == Device::STANDART_NOT_DEWASH){
            return view('fiscalization.check', compact('last_three', 'device', 'device_code', 'hash', 'user'));
        }
    }

    public function user_page(Request $request, $userHash)
    {
        $user = User::whereRaw('MD5(email) LIKE ?', [$userHash . "%"])->first();
        $devices = Device::where('user_id', $user->id)->get();
        return view('fiscalization.user_page', compact('user', 'devices'));
    }

    public function check_partner(Request $request, $hash)
    {
        $userId = $hash;
        $user = User::where('id', $userId)->firstOrFail();
        $devices = Device::where(['user_id'=>$user->id])->get();
        return view('fiscalization.partner_check',[
            'user' => $user,
            'devices' => $devices,
        ]);
    }

    public function tempReceipt(Request $request, $hash,$id)
    {
        $deviceID = (int)$request->id;
        $device = Device::where('device_hash', $hash)->firstOrFail();
        $fisk = DB::table('fiskalization_table')
//            ->where('factory_number', $device->factory_number)
            ->where('id', $id)
            // ->where('fiskalized', true)
         //   ->orderBy('id', 'DESC')
            // ->take(3)
            ->first();
        $device_code = substr($device->factory_number, 5, 4);
        $post_number = $device->id;
        $address = $device->address;
        $placeName = $device->place_name;
        $user = User::where(['id'=>$device->user_id])->first();
        return view('fiscalization.fake', compact('fisk', 'device', 'device_code', 'hash','user'));
    }

    private function new_system_message(Device $device, $message)
    {
        DB::table('system_messages')
        ->where('factory_number', $device->factory_number)
        ->delete();


        $message = json_encode($message);

        DB::table('system_messages')->insert([
            'factory_number' => $device->factory_number,
            'message' => $message,
        ]);
    }

    public function ajax_check_allow_payment(Request $request, $hash)
    {
        $device = Device::where('device_hash', $hash)->firstOrFail();

        $data = ["success" => false];

        $resp = DB::table('system_messages')->where('factory_number', $device->factory_number)->first();

        if($resp)
        {
            $response = $resp->response;
            if($response)
            {

                $data = ["success" => true, 'msg' => $response];
            }
        }

        return response()->json($data);
    }

    public function ajax_reserve_payment(Request $request, $hash)
    {
        $device = Device::where('device_hash', $hash)->firstOrFail();

        if($device->enable_payment)
        {
            $message = [
                "factory_number" => $device->factory_number,
                "payment" => "allow"
            ];
            $this->new_system_message($device, $message);

        }

        $data = ["success" => true];

        return response()->json($data);
    }

    public function go_payment(Request $request, $hash)
    {
        $device = Device::where('device_hash', $hash)->firstOrFail();

        $amount = (int)$request->amount;
        $system = (int)$request->system;

		$data = $device->payment_system->data;
		$data = unserialize($data);

		if($system == 0) // LiqPay
		{

			$publicKey = $data["public_key"];
			$privateKey = $data["private_key"];

			// $publicKey = 'i76469586488';
			// $privateKey = 'qr9ABkEHJniEm4JkEvg7CJHFWcrzhDpNk79l8tOk';

			$payment_id = time();

			$json_string =
				array(
					'version'        => '3',
					'action'         => 'pay',
					'result_url'     => route('check_hash', $hash),
					'server_url'     => route('payment.liqpay.callback'),
					'amount'         => $amount,
					'currency'       => 'UAH',
					'description'    => 'Поповнення балансу для '. $device->place_name,
					'info'           => $device->id,
					'order_id'       => $payment_id,
					'language'		 =>	'ua',
					'public_key'     => $publicKey,
					'private_key'    => $privateKey,
				);

			$liqpay = new LiqPay($publicKey, $privateKey);
			$payurl = $liqpay->cnb_pay_url($json_string);
			return redirect()->to($payurl);
		}
		if($system == 1) // Monopay
		{

            $webHookUrl = "https://nv9-mono.iotapps.net/mono-proxy";
            if(config('app.env') != 'production')
                $webHookUrl = route('payment.monopay.callback');


			$token = $data["private_key"];
			$ref = md5(microtime());
			$send = [
				"amount" => (int)$amount * 100,
				"ccy" => 980,
				"merchantPaymInfo" => [
					 "reference" => $ref,
					 "destination" => (string)$device->id,
					 "comment" => 'Поповнення балансу для '. $device->place_name,
				  ],
				"redirectUrl" => route('check_hash', $hash),
				"webHookUrl" => $webHookUrl,
				"validity" => 3600,
				"paymentType" => "debit",
			];

			$send = json_encode($send);

			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, "https://api.monobank.ua/api/merchant/invoice/create");
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $send);
			curl_setopt($ch, CURLOPT_HTTPHEADER, [
				'X-Token: '.$token,
				'X-Cms: '.config('services.x_cms'),
			]);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$server_output = curl_exec($ch);

			curl_close($ch);

			$resp = json_decode($server_output);

            if(isset($resp->pageUrl))
            {
                return redirect()->to($resp->pageUrl);
            }

			return redirect()->back()->withErrors(['msg' => 'Вибачте помилка зі сторони банку, спробуйте пізніше']);
		}
    }

    public function monopay_callback(Request $request)
	{
        $log = Log::build(['driver' => 'single', 'path' => storage_path('logs/monopay_callback.log')]);
        try{

            $data = $request->getContent();
            $data = json_decode($data);
            $log->notice('request: '. json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT).' '.__FILE__.':'.__LINE__);


            $status = $data->status;

            if($status == "success")
            {
                $deviceID = $data->destination;
                $payment_id = $data->invoiceId;
                $amount = $data->amount / 100;

                $device = Device::where('id', $deviceID)->firstOrFail();

                $message = [
                    "factory_number" => $device->factory_number,
                    "payment" => [
                        "order_id" => $payment_id,
                        "amount" => $amount * 100,
                    ]
                ];

                //Отправляем на фискализацию
                $fisc = new Fiscalization();
                $fisc->factory_number = $device->factory_number;
                $fisc->sales_code = $payment_id;
                $fisc->sales_cashe = $amount * 100;
                $fisc->cash = 0;
                $fisc->save();

                $this->new_system_message($device, $message);
            }
        } catch (\Exception $e) {
            $log->error('Exception: '. $e->getMessage().' '.__FILE__.':'.__LINE__);
            return response()->json(["success" => true], 200);
        }
	}

    public function liqpay_callback(Request $request)
    {
        $log = Log::build(['driver' => 'single', 'path' => storage_path('logs/liqpay_callback.log')]);

        //Заглушка callback для liqpay
        $data = $request->data;
        $data = json_decode(base64_decode($data));

        $log->notice('request: '. json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT).' '.__FILE__.':'.__LINE__);

        if($data->action != "pay")
        {
            return;
        }
        if( !in_array($data->status, ["success", "wait_secure"])){
            return;
        }
        if(Fiscalization::where('sales_code', $data->order_id)->where('factory_number', $data->info)->first()) {
            return;
        }

        $deviceID = $data->info;
        $amount = $data->amount;
        $payment_id = $data->order_id;

        $device = Device::where('id', $deviceID)->firstOrFail();

        $message = [
            "factory_number" => $device->factory_number,
            "payment" => [
                "order_id" => $payment_id,
                "amount" => $amount * 100,
            ]
        ];
         //Отправляем на фискализацию
        $fisc = new Fiscalization();
        $fisc->factory_number = $device->factory_number;
        $fisc->sales_code = $payment_id;
        $fisc->sales_cashe = $amount * 100;
        $fisc->cash = 0;
        $fisc->save();

        $this->new_system_message($device, $message);
    }


    public function privacyPolicy(Request $request)
    {


        if (!empty($request->id))
        {
            $userId = (int)$request->id;

            $user = User::where(['id'=>$userId])->first();
            if(empty($user)){
                abort(404);
            }

            return view('fiscalization.privacy_policy', compact('user'));
        } else {
            abort(404);
        }
    }
    public function oferta(Request $request)
    {
        if (!empty($request->id))
        {
            $userId = (int)$request->id;
            $user = User::where(['id'=>$userId])->first();
            if(empty($user)){
                abort(404);
            }

            return view('fiscalization.oferta', compact('user'));
        } else {
            abort(404);
        }
    }

    public function aboutUs(Request $request)
    {
        if (!empty($request->id))
        {
            $userId = (int)$request->id;
            $user = User::where(['id'=>$userId])->first();
            if(empty($user)){
                abort(404);
            }

            return view('fiscalization.about_us', compact('user'));
        } else {
            abort(404);
        }
    }

    public function fiscalization_check(Request $request)
    {
        $log = Log::build(['driver' => 'single', 'path' => storage_path('logs/'.date('Y-m-d').'_fiscalize.log')]);
        $order = Fiscalization::where('id', $request->post('id'))->first();
        $device = $order->device;
        $link = route('temp-receipt',['hash'=>$device->device_hash,'id'=>$order->id]);
        if ($order->check_code){
            return response()->json([
                'link' => $link,
            ]);
        }

        if($device && $device->cashier_token && $device->fiscalization_key_id)
        {
            $log->notice('web start fiskalization_table.id: '.$order->id.' '.__FILE__.':'.__LINE__);
            try{
                $resp = $device->createReceipt( $device, $order);
                $check = $resp['check'];
                $shift = $resp['shift'];

                $checkField = $err = null;

                if(isset($check->id) && $check->id)
                {
                    $link = 'https://check.checkbox.ua/'.$check->id;
                    $checkField = $check->id;
                } elseif (isset($check->message)) {
                    $err = $check->message;
                    if($shift && isset($shift->message)){
                        $err .= ' '.$shift->message;
                    }
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
            } catch (\Exception $e) {
                $log->error('web Exception: '.$e->getMessage().__FILE__.':'.__LINE__);
            }

        } else {
            $log->warning('web fiscalization  not enabled: '.__FILE__.':'.__LINE__);
        }

        return response()->json([
            'link' => $link,
        ]);
    }

}
