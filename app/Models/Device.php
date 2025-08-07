<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Log;

class Device extends Model
{
    use HasFactory;

    const STANDART = 1;
    const MONO = 2;
    const MONO125 = 3;
    const STANDART_NOT_DEWASH = 4;
    const STANDART_NOT_IMPUT = 5;
    const STANDART_TEXT = 'Стандарт';
    const STANDART_TEXT_NOT_IMPUT = 'Стандарт без поля вводу';
    const STANDART_NOT_DEWASH_TEXT = 'Стандарт без логотипу';
    const MONO_TEXT = 'Моно';
    const MONO125_TEXT = 'MONO125';

    const CHECKBOX_HEADER = [
        "X-Client-Name: NV9",
        "X-Client-Version: V.1.9"
    ];

    protected $fillable = ['factory_number', 'user_id', 'address', 'place_name','service','design','divide_by'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function fiscalization_key()
    {
        return $this->belongsTo(FiskalizationKey::class, 'fiscalization_key_id');
    }

    public function payment_system()
    {
        return $this->belongsTo(PaymentGateway::class, 'payment_system_id');
    }

    public function serialNumbers(): HasMany
    {
        return $this->hasMany(DeviceSerialNumber::class);
    }

    public function GetFiszalizationStatusAttribute()
    {
        $status = "";
        if($this->enabled_fiscalization && $this->cashier_token && $this->fiscalization_key_id)
        {
            $status = "Включена. Токен получен";
        } else {
            $status = "Выключена.";
        }
        if($this->enabled_fiscalization && !$this->cashier_token)
        {
            $status = "Включена. (Токен не получен)";
        }
        return $status;
    }

    /* Get fiscalization token */

    public function updateFiskalizationToken()
    {
        $currentKey = $this->fiscalization_key;
        if($currentKey && $currentKey->cashier_login && $currentKey->cashier_password)
        {
            $new_cashier_token = $this->get_cashier_token($currentKey->cashier_login, $currentKey->cashier_password);
            if(isset($new_cashier_token->access_token))
            {
                $this->cashier_token = $new_cashier_token->access_token;
            } else {
                $this->cashier_token = null;
            }
            $this->update();
        }
    }

    private function get_cashier_token($login, $password)
    {
        $ch = curl_init();

        $data = [
            "login" => $login,
            "password" => $password
        ];
        $data = json_encode($data);

        curl_setopt($ch, CURLOPT_URL, "https://api.checkbox.in.ua/api/v1/cashier/signin");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, self::CHECKBOX_HEADER);

        $resp = curl_exec($ch);
        curl_close($ch);
        $resp = json_decode($resp);

        try {
            $log = Log::build(['driver' => 'single', 'path' => storage_path('logs/'.date('Y-m-d').'_fiscalize.log')]);
            $log->notice('авторизація касира: '.$login.' '. json_encode($resp, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT).' дата: '. $data . ' '.__FILE__.':'.__LINE__);
        }catch (\Throwable $e){}


        return $resp;
    }

    private function createShift($token, $licenseKey)
    {

        $ch = curl_init();

        $header = self::CHECKBOX_HEADER;
        $header[] = "Authorization: Bearer $token";
        $header[] = "X-License-Key: $licenseKey";

        curl_setopt($ch, CURLOPT_URL, "https://api.checkbox.in.ua/api/v1/shifts");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $resp = curl_exec($ch);
        curl_close($ch);
        $resp = json_decode($resp);

        $log = Log::build(['driver' => 'single', 'path' => storage_path('logs/'.date('Y-m-d').'_fiscalize.log')]);
        $log->notice('відкриття зміни: '.$licenseKey.' '. json_encode($resp, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT).' '.__FILE__.':'.__LINE__);


        return $resp;
    }

    public function createReceipt($device, $order)
    {

        switch ($order->cash) {
            case 1:
                $cashType = "CASH";
                $label = 'Готівка';
                $code = 0;
                break;
            case 2:
                $cashType = "CASHLESS";
                $label = 'Картка';
                $code = 1;
                break;
            case 0:
                $cashType = "CASHLESS";
                $label = 'LiqPay';
                $code = 1;
                break;
        }

        $fiscalizationKey = $device->fiscalization_key;
        $good = [
            "code" => "1",
            "name" => $device->service ?? "Послуга",
            "price" => $order->sales_cashe,
        ];
        if ($fiscalizationKey && $fiscalizationKey->is_tax_enabled && $fiscalizationKey->tax_code) {
            $good['tax'] = [$fiscalizationKey->tax_code];
        }


        $payment = [
            "type" => $cashType,
            "value" => (int)$order->sales_cashe,
            "label" => $label,
            "code" => $code,
        ];
        if(!empty($order->rrn))
            $payment['rrn'] = $order->rrn;
        if(!empty($order->paysys))
            $payment['payment_system'] = $order->paysys;
        if(!empty($order->paysys))
            $payment['auth_code'] = $order->auth_code;
        if(!empty($order->merchant_id))
            $payment['terminal'] = $order->merchant_id;
        if(!empty($order->bank_card))
            $payment['card_mask'] = $order->bank_card;


        $data1 = [

            "goods" => [
                [
                    "good" => $good,
                    "quantity" => 1000, // 1 шт
                    "is_return" => false,
                ]
            ],
            "payments" => [
                $payment
            ]
        ];

        $data = json_encode($data1);
        $header = self::CHECKBOX_HEADER;
        $header[] = "Authorization: Bearer $device->cashier_token";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.checkbox.in.ua/api/v1/receipts/sell");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIEJAR, '');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $resp = curl_exec($ch);
        curl_close($ch);
        $resp = json_decode($resp);

        $log = Log::build(['driver' => 'single', 'path' => storage_path('logs/'.date('Y-m-d').'_fiscalize.log')]);
        $log->notice('fiskalization: '. json_encode($resp, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT).' дата: '. json_encode($data1, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . ' '.__FILE__.':'.__LINE__);


        $respShift = null;
        if(isset($resp->message) && $resp->message == "Зміну не відкрито") //Если прилетает ошибка по смене
        {
            $respShift = $this->createShift($device->cashier_token, $device->fiscalization_key->cashier_license_key); //Открываем смену на кассе.
        }
        if(isset($resp->message) && str_starts_with($resp->message, "Зміну відкрито понад")) //Если прилетает ошибка по смене
        {
            $respShift = $this->createShift($device->cashier_token, $device->fiscalization_key->cashier_license_key); //Открываем смену на кассе.
        }
        if (isset($resp->message) && $resp->message == "Невірний токен доступу"){
            $this->updateFiskalizationToken();
            $respShift = $this->createShift($this->cashier_token, $device->fiscalization_key->cashier_license_key); //Открываем смену на кассе.
        }
        return ['check'=>$resp, 'shift'=>$respShift];
    }

    public function my_hash()
    {
        $hash = hash('SHA1', $this->factory_number);
        $hash_len = strlen($hash);
        $take_num = 10;
        $len_from = $hash_len - $take_num;
        $device_hash = substr($hash, $len_from, $take_num);
        $device_hash = strtoupper($device_hash);
        return $device_hash;
    }

    public static function getDesigns()
    {
        return [
            self::STANDART => self::STANDART_TEXT,
            self::MONO => self::MONO_TEXT,
            self::MONO125 => self::MONO125_TEXT,
            self::STANDART_NOT_DEWASH => self::STANDART_NOT_DEWASH_TEXT,
            self::STANDART_NOT_IMPUT => self::STANDART_TEXT_NOT_IMPUT,
        ];
    }

    public static function getLastFiskalizationError($number)
    {
        $item = Fiscalization::where(['factory_number'=>$number])->orderBy('id','DESC')->first();

        return $item;
    }


}
