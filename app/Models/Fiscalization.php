<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fiscalization extends Model
{
    use HasFactory;

    protected $table = 'fiskalization_table';

    public $timestamps = false;

    public function device()
    {
        return $this->belongsTo(Device::class, 'factory_number', 'factory_number');
    }

}
