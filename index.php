<?php

http_response_code(200);
fastcgi_finish_request();
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
$time = strtotime("+5 minutes");
$us = bot('getChatMembersCount',[
'chat_id'=>$chat_id,
]);
$count = $us->result;
$day = date('d-M Y',strtotime('0 hour'));
$clock = date('H:i', strtotime('0 hour'));
$new_time = date("Y-m-d H:i:s", strtotime('+0 hours'));
$channel= "@College_Of_Technical_Engineering";
$random_msg_top = array("Hello 👋","Thanks for using me 💛");
$Random = $random_msg_top[array_rand($random_msg_top,1)];
$getstatus = bot('getChatMember', [
'chat_id' => $chat_id,
'user_id' => $user_id,
]);

$caption = $message->caption;
$document = $message->document; 
$animation = $message->animation;
$photo = $message->photo;
$video = $message->video;
$sticker = $message->sticker;
$file = $message->document;
$audio = $message->audio;
$voice = $message->voice;
$photo_id = $message->photo[0]->file_id;
$video_id= $message->video->file_id;
$sticker_id = $message->sticker->file_id;
$file_id = $message->document->file_id;
$music_id = $message->audio->file_id;
$voice_id = $message->voice->file_id;

$forward = $message->forward_from_chat;
$forward_id = $message->forward_from_chat->id;
$title = $message->chat->title;
$mention = "<a href='tg://user?id=$from_id'>$first_name</a>";
$type = $message->chat->type;
$message->from->first_name;
$user = $message->from->username;
$reply= $message->reply_to_message->text;
$replyid = $message->reply_to_message->from->id;
$replyname = $message->reply_to_message->from->first_name;
$title = $message->chat->title;

$new = $message->new_chat_member;
$new_id = $new->id;
$new_name = $new->first_name;
$left = $message->left_chat_member;


if($text == '/start' and $chat_id == $admin){
        $lang_btn = json_encode(['inline_keyboard' => [
            [['text' => 'English🇬🇧' , 'callback_data' => 'lang-en']],
            [['text' => 'Persian🇮🇷' , 'callback_data' => 'lang-fa']]
        ]]);
        $telegram->sendMessage($chat_id ,"hello", $lang_btn );
    }else{
        $aboutBTn = json_encode(['keyboard' => [
            [ ['text' => "Help"] ]
        ],'resize_keyboard' => true]);
        $telegram->sendMessage($chat_id,"Aha",$aboutBTn);
    }
if($text == "Help"){
    $telegram->sendMessage($chat_id , "Got it");
}elseif(isset($message) && $chat_id != $admin){
    $infoBtn = json_encode(['inline_keyboard' => [
        [ ['text' => 'Hello', 'callback_data' => 'rem'] ]
    ]]);
    $telegram->copyMessage($chat_id , $admin , $message_id, $infoBtn);
    $telegram->sendMessage($chat_id , "Ok");
}

if($data != null){
    $userid = $update->callback_query->from->id;
    $mid = $update->callback_query->message->message_id;
       
        $cb_id = $update->callback_query->id;
        $telegram->answerCallbackQuery($cb_id , "Ok",true);
        $telegram->sendMessage($userid , $txt['restart']);
    }


