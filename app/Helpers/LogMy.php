<?php

namespace App\Helpers;

class LogMy
{
    public static function info($message,$fileName)
    {
        $fileName = date('Y-m-d').'_'.$fileName;
        ob_start();
        var_dump('------------'.date('Y-m-d H:i:s').'--------------');
        var_dump($message);
        $text = ob_get_clean();
        $fp = fopen(storage_path('/app/public/logs/').$fileName, "a+");
        fwrite($fp, $text);
        fclose($fp);
    }
}
