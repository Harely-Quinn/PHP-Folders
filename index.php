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



if($text == '/start' and $chat_id == $admin){
        $lang_btn = json_encode(['inline_keyboard' => [
            [['text' => 'English🇬🇧' , 'callback_data' => 'lang-en']],
            [['text' => 'Persian🇮🇷' , 'callback_data' => 'lang-fa']]
        ]]);
        $telegram->sendMessage($chat_id ,"hello", $lang_btn );
    }else{
        $aboutBTn = json_encode(['keyboard' => [
            [ ['text' => $txt['about_btn']] ]
        ],'resize_keyboard' => true]);
        $telegram->sendMessage($chat_id,$txt['h_user'],$aboutBTn);
    }
}elseif($text == $txt['about_btn']){
    $telegram->sendMessage($chat_id , $txt['about']);
}elseif(isset($message) && $chat_id != $admin){
    $infoBtn = json_encode(['inline_keyboard' => [
        [ ['text' => $chat_id.':'.$message_id, 'callback_data' => 'rem'] ]
    ]]);
    $telegram->copyMessage($chat_id , $admin , $message_id,$infoBtn);
    $telegram->sendMessage($chat_id , $txt['m_sent']);
}

if($data != null){
    $userid = $update->callback_query->from->id;
    $mid = $update->callback_query->message->message_id;
       
        $cb_id = $update->callback_query->id;
        $telegram->answerCallbackQuery($cb_id , "Ok",true);
        $telegram->sendMessage($userid , $txt['restart']);
    }


