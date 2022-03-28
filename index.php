<?php
include 'class/Telegram.class.php';

$input = file_get_contents('php://input');
$update = json_decode($input);
$admin = 989174330;// your id
$token = '1958377342:AAEFm3uVHvabDKSHEz3w_M3MomabsmAaKxo'; //bot token
$telegram = new Telegram($token);
$message = $update->message;
$chat_id = $message->chat->id;
$message_id = $message->message_id;
$text = $message->text;
$data = $update->callback_query->data;
$lang_path = 'data/'. $chat_id . '.txt';
$lang = 'en';
if(file_exists($lang_path)){
    $lang = file_get_contents($lang_path);
}

include 'lang/'.$lang.'.php';

if($text == '/start' and $chat_id == $admin){{
        $lang_btn = json_encode(['inline_keyboard' => [
            [['text' => 'English🇬🇧' , 'callback_data' => 'lang-en']],
            [['text' => 'Persian🇮🇷' , 'callback_data' => 'lang-fa']]
        ]]);
        $telegram->sendMessage($chat_id ,$txt['s_lang'], $lang_btn );
    }

if($data != null){
    $userid = $update->callback_query->from->id;
    $mid = $update->callback_query->message->message_id;
       
        $cb_id = $update->callback_query->id;
        $telegram->answerCallbackQuery($cb_id , $txt['lang_changed'],true);
        $telegram->sendMessage($userid , $txt['restart']);
    }


