<?php

namespace App\Http\Controllers;

use App\Helpers\LiqPay;
use App\Helpers\LogMy;
use App\Models\Device;
use App\Models\Fiscalization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

            return view('fiscalization.check', compact('last_three','user'));
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
            ->orderBy('id', 'DESC')
            ->take(3)
            ->get();
        $device_code = substr($device->factory_number, 5, 4);
        $post_number = $device->id;
        $address = $device->address;
        $placeName = $device->place_name;
        $user = User::where(['id'=>$device->user_id])->first();

        if($device->design == Device::STANDART) {
            return view('fiscalization.check', compact('last_three', 'device', 'device_code', 'hash', 'user'));
        }
        else if($device->design == Device::MONO)
        {
            return view('fiscalization.check_mono', compact('last_three', 'device', 'device_code', 'hash', 'user'));
        }
        else if($device->design == Device::MONO125)
        {
            return view('fiscalization.check_mono125', compact('last_three', 'device', 'device_code', 'hash', 'user'));
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
            ->where('factory_number', $device->factory_number)
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

            $webHookUrl = "https://ip-91-227-40-101-96078.vps.hosted-by-mvps.net/monoproxy";
            if($hash == '48F027772B')
                $webHookUrl = route('payment.monopay.callback_test');


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

    public function monopay_callback_test(Request $request)
    {
        try{

            $tmp1 = file_get_contents('php://input');
            $tmp2 = $request->all();
            $tmp3 = $request->post();
            $tmp4 = $request->getContent();

            LogMy::info([
                'tmp1' => $tmp1,
                'tmp2' => $tmp2,
                'tmp3' => $tmp3,
                'tmp4' => $tmp4,
            ], 'monopay_callback_______TEST.txt');

        } catch (\Exception $e) {
            LogMy::info([
                'data' => $e->getMessage(),
            ], 'monopay_callback___________error.txt');
            return response()->json(["success" => true], 200);
        }
    }

    public function monopay_callback(Request $request)
	{
        try{

            $data = (object)$request->post();

            LogMy::info([
                'data' => $data,
            ], 'monopay_callbackTEST.txt');


            $data = $request->getContent();
            $data = json_decode($data);
            LogMy::info(['data' => $data], 'monopay_callback.txt');
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
            LogMy::info([
                'data' => $e->getMessage(),
            ], 'monopay_callback_error.txt');
            return response()->json(["success" => true], 200);
        }
	}

    public function liqpay_callback(Request $request)
    {
        //Заглушка callback для liqpay
        $data = $request->data;
        $data = json_decode(base64_decode($data));
        LogMy::info(['data' => $data], 'liqpay_callback.txt');

        if($data->action != "pay")
        {
            return;
        }
        if( !in_array($data->status, ["success", "wait_secure"])){
            return;
        }

        $f = Fiscalization::where('sales_code', $data->order_id)->where('factory_number', $data->info)->first();
        if($f)
        {
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


}
