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


?>
