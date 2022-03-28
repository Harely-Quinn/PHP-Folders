<?php
// Include Files


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


if($text == '/start'){
        $lang_btn = json_encode(['inline_keyboard' => [
            [['text' => 'English🇬🇧' , 'callback_data' => 'lang-en']],
            [['text' => 'Persian🇮🇷' , 'callback_data' => 'lang-fa']]
        ]]);
        $telegram->sendMessage($chat_id ,$txt['s_lang'], $lang_btn );
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



// Time [Asia/Tashkent]
date_default_timezone_set('Asia/Tashkent');
$time = date('H:i');
$date = date('d.m.Y');


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

    public function sendMessage($chat_id , $text , $reply = null , $parse_mode = 'MarkDown'){
        return $this->bot('sendMessage' , [
            'chat_id' => $chat_id,
            'text' => $text,
            'reply_markup' => $reply,
            'parse_mode' => $parse_mode
        ]);
    }

    public function forwardMessage($from , $to , $message_id){
        return $this->bot('forwardMessage' , [
            'chat_id'  => $to,
            'from_chat_id' => $from,
            'message_id' => $message_id,
        ]);
    }
    public function copyMessage($from , $to , $message_id , $reply = null,$reply_to_message_id = null){
        return $this->bot('copyMessage' , [
            'chat_id'  => $to,
            'from_chat_id' => $from,
            'message_id' => $message_id,
            'reply_markup' => $reply,
            'reply_to_message_id' => $reply_to_message_id
        ]);
    }

    public function answerCallbackQuery($cb_id , $text , $alert){
        return $this->bot('answerCallbackQuery',[
            'callback_query_id' => $cb_id,
            'text' => $text,
            'show_alert' => $alert
        ]);
    }
    function edit_replay($chatid , $msgid ,$reply){
		return $this->bot('editMessageReplyMarkup',[
            'chat_id'=>$chatid,
            'message_id'=>$msgid,
            'reply_markup'=>$reply
		]);
	}

    
}


?>
