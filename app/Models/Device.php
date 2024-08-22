<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    const STANDART = 1;
    const MONO = 2;
    const MONO125 = 3;
    const STANDART_TEXT = 'Стандарт';
    const MONO_TEXT = 'Моно';
    const MONO125_TEXT = 'MONO125';

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

        $resp = curl_exec($ch);
        curl_close($ch);
        $resp = json_decode($resp);
        return $resp;
    }

    private function createShift($token, $licenseKey)
    {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://api.checkbox.in.ua/api/v1/shifts");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $token",
            "X-License-Key: $licenseKey"
        ]);
        $resp = curl_exec($ch);
        curl_close($ch);
        $resp = json_decode($resp);
        file_put_contents(public_path()."/shift.json", print_r($resp, true));
        return $resp;
    }

    public function createReceipt($token, $amount, $licenseKey, $device, $cashType = "CASH")
    {

        $total = $amount;
//        $total = round($total, 2);
//        $total = (int)($total * 100);
//
//        $amount = round(number_format($amount, 2, '.', '') * 100);

        //$liters = round(number_format($liters, 2, '.', '') * 1000);

        $ch = curl_init();

        $data = [
            "goods" => [
                [
                    "good" => [
                        "code" => "1",
                        "name" => $device->service ?? "Послуга",
                        "price" => $total
                    ],
                    "quantity" => 1000, // 1 шт
                    "is_return" => false
                ]
            ],
            "rounding" => true,
            "payments" => [
                [
                    "type" => $cashType,
                    "value" => (int)$total
                ]
            ]
        ];

        //dd($data);

        $data = json_encode($data);

        curl_setopt($ch, CURLOPT_URL, "https://api.checkbox.in.ua/api/v1/receipts/sell");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIEJAR, '');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $token"
        ]);
        $resp = curl_exec($ch);
        curl_close($ch);
        $resp = json_decode($resp);

        file_put_contents("fiscalize.txt", print_r($resp, true));

        // if(isset($resp->message))
        // {
        //     return ["success" => false, "err" => $resp->message];
        // }

        // if($again)
        // {
        //     return $resp;
        // }

        //file_put_contents(public_path()."/receipt.txt", print_r($resp, true));
        if(isset($resp->message) && $resp->message == "Зміну не відкрито") //Если прилетает ошибка по смене
        {

            $this->createShift($token, $licenseKey); //Открываем смену на кассе.
            //sleep(3);
            //$this->createReceipt($token, $amount, $licenseKey, $device, true);
        }
        if(isset($resp->message) && str_starts_with($resp->message, "Зміну відкрито понад")) //Если прилетает ошибка по смене
        {
            $this->createShift($token, $licenseKey); //Открываем смену на кассе.

            //sleep(5);

            //$this->createReceipt($token, $amount, $licenseKey, $device);
         }
        return $resp;
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
        ];
    }

    public static function getLastFiskalizationError($number)
    {
        $item = Fiscalization::where(['factory_number'=>$number])->orderBy('id','DESC')->first();

        return $item;
    }


}
