<?php

namespace App\Helpers;

class Helper
{
    static function versioned_asset($path, $secure = null): string
    {
        $timestamp = @filemtime(public_path($path)) ?: 0;
        return asset($path, $secure) . '?' . $timestamp;
    }
}
