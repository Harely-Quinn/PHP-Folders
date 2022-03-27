<?php

$token = "1958377342:AAEFm3uVHvabDKSHEz3w_M3MomabsmAaKxo"; // TOKEN of BOT
define('API_KEY',"$token"); // Username of BOT
$admin = "989174330"; // Admin Telegram ID


class Telegram {
    private $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    private function bot($method , $data){
        $url = 'https://api.telegram.org/bot'.$this->token.'/'.$method;
        $ch = curl_init($url);

        curl_setopt($ch,CURLOPT_RETURNTRANSFER , TRUE);
        curl_setopt($ch , CURLOPT_POSTFIELDS , $data);

        $res = curl_exec($ch);
        curl_close($ch);
        return json_decode($res);
    }



// Include Files
require "include/functions.php"; // Telegram API Method
require "include/config.php"; // Bot and Administrator datas
require "include/keyboards.php"; // Keyboards
require "include/connect.php"; // DataBase Connect
require "include/varibles.php"; // Variables [php://input]

// Ini Set [Turn off Display errors and reports]
ini_set('error_reporting', 'off');
ini_set('display_errors', 'off');
ini_set('display_startup_errors', 'off');

// Time [Asia/Tashkent]
date_default_timezone_set('Asia/Tashkent');
$time = date('H:i');
$date = date('d.m.Y');


?>
