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

if($text == '/start'){
    if(!file_exists($lang_path)){
        $key = json_encode(['inline_keyboard' => [
            [['text' => 'English🇬🇧' , 'callback_data' => 'lang-en']],
            [['text' => 'Persian🇮🇷' , 'callback_data' => 'lang-fa']]
        ]]);
        $telegram->sendMessage($chat_id ,$txt['s_lang'], $key );
    }
    if($chat_id == $admin){
        $telegram->sendMessage($chat_id , $txt['h_admin']);
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
        $telegram->answerCallbackQuery($cb_id , $txt['lang_changed'],true);
        $telegram->sendMessage($userid , $txt['restart']);
    }
    if($data == 'rem' && $userid == $admin){
        $telegram->edit_replay($userid , $mid,null); 
}

if($chat_id == $admin){
    if(isset($message->reply_to_message->reply_markup)){
        $btn = $message->reply_to_message->reply_markup;
        $text = $btn->inline_keyboard[0][0]->text;
        $ex = explode(':',$text);
        $userid = $ex[0];
        $msg_id = $ex[1];
        $telegram->copyMessage($chat_id,$userid, $message_id,null,$msg_id);
        $telegram->sendMessage($chat_id , $txt['m_sent']);
    }
}


