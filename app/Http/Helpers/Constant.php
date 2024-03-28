<?php

namespace App\Http\Helpers;


class Constant
{
    public static function now() {
        return time();
    }

    public static function zero() {
        return 0;
    }

    public static function blank() {
        return "";
    }

    //啟用狀態對照檔
    private static $enableMap=array(0=>'Undefined',1=>'Enabled',2=>'Disabled');
    public static function enable($str) {
        return  __(self::$enableMap[$str]);
    }

    //完成狀態對照檔
    private static $doneMap=array(0=>'Undefined',1=>'Enabled',2=>'Disabled');
    public static function done($str) {
        return time();
    }
}
