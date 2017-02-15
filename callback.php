<?php
$accessToken = 'wlNrSUFmCkGXpi9p6+x33dIEfdFZ8Bo3Y1ZgtuqsBSeBpQNZxyIOm9dWmjb0mxJegxmY5SIUdZ+urqdFtl0yXDjTkk8duV4MQ3C8IibtmDhu5Yxdetl8qH3/Ro4bgfFzWZajNsqXCWQjUD1HJmY5CQdB04t89/1O/w1cDnyilFU=';


//ユーザーからのメッセージ取得
$json_string = file_get_contents('php://input');
$jsonObj = json_decode($json_string);

$type = $jsonObj->{"events"}[0]->{"message"}->{"type"};
//メッセージ取得
$text = $jsonObj->{"events"}[0]->{"message"}->{"text"};
//ReplyToken取得
$replyToken = $jsonObj->{"events"}[0]->{"replyToken"};

//メッセージ以外のときは何も返さず終了
if($type != "text"){
	exit;
}

//返信データ作成
$response_format_text = [
	"type" => "text",
	"text" => "テキストを返す"
	];
$post_data = [
	"replyToken" => $replyToken,
	"messages" => [$response_format_text]
	];

$ch = curl_init("https://api.line.me/v2/bot/message/reply");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json; charser=UTF-8',
    'Authorization: Bearer ' . $accessToken
    ));
$result = curl_exec($ch);
curl_close($ch);
