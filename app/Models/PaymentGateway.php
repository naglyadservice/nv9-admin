<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    use HasFactory;

    public static function systems()
    {
        return [
            0 => "LiqPay",
            1 => "Monopay",
        ];
    }
}
