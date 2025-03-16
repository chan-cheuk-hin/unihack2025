<?php

class Util {
    public static function Log($message){

        date_default_timezone_set('Australia/Melbourne');
        $time = date('Y-m-d H:i:s');
        $line = '[' . $time . '] ' . $message . PHP_EOL;
        $file = fopen("logs.txt", 'a');
        fwrite($file, $line); 
        fclose($file);

    }

}