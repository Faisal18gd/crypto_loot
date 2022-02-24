<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use DB;
use Auth;

class InterConnect extends Controller
{
    protected static function saltKey()
    {
        $count = 0;
        $sKey = env('ENC_KEY');
        for ($i = 0; $i < strlen($sKey); $i++) {
            $count += ord($sKey[$i]);
        }
        return $count;
    }
    
    public static function encKey()
    {
        $data = '';
        $padding = 0;
        $salt = 0;
        $sKey = 'string_str';
        for ($i = 0; $i < strlen($sKey); $i++) {
            $salt += ord($sKey[$i]);
        }
        $str = env('ENC_KEY');
        for ($i = 0; $i < strlen($str); $i++) {
            $data .= ord($str[$i]) + $salt + $padding . 'x';
            $padding += 1;
        }
        return substr($data, 0, -1);
    }
    
    public static function enc($str)
    {
        $data = '';
        $padding = 0;
        $salt = InterConnect::saltKey();
        for ($i = 0; $i < strlen($str); $i++) {
            $data .= ord($str[$i]) + $salt + $padding . 'x';
            $padding += 1;
        }
        return substr($data, 0, -1);
    }
    
    public static function dec($str)
    {
        $data = '';
        $salt = InterConnect::saltKey();
        $arrayData = explode("x", $str);
        for ($i = 0; $i < sizeof($arrayData); $i++) {
            $data .= chr((int)$arrayData[$i] - $salt - $i);
        }
        return $data;
    }
}
