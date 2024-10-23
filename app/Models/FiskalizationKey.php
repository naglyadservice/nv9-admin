<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FiskalizationKey extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'cashier_login', 'cashier_password', 'cashier_license_key', 'is_tax_enabled', 'tax_code'];
}
