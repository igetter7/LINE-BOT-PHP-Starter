<?php

require __DIR__ . './vendor/autoload.php';

$bot = new \LINE\LINEBot(new CurlHTTPClient('29m4MYSWqUiJG+cv9rpX3mb+G+JAZ+m7Wq5UKgeKiKJzLZELncR8PLH8/6MHt7/hndfFH0B7kGe9dPiObjLyID3o3h1yajodmF+yMVTsrIBhuglvPVrCeed2+YjDgi57+PFe1pCJ4XgW7oCPElbUBgdB04t89/1O/w1cDnyilFU='), [
    'channelSecret' => 'cc07034a217a0a432686937e5fc6203e'
]);

$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('hello');
$response = $bot->replyMessage('your-reply-token', $textMessageBuilder);




// $access_token = '29m4MYSWqUiJG+cv9rpX3mb+G+JAZ+m7Wq5UKgeKiKJzLZELncR8PLH8/6MHt7/hndfFH0B7kGe9dPiObjLyID3o3h1yajodmF+yMVTsrIBhuglvPVrCeed2+YjDgi57+PFe1pCJ4XgW7oCPElbUBgdB04t89/1O/w1cDnyilFU=';

// // Get POST body content
// $content = file_get_contents('php://input');
// // Parse JSON
// $events = json_decode($content, true);
// // Validate parsed JSON data
// if (!is_null($events['events'])) {
// 	// Loop through each event
// 	foreach ($events['events'] as $event) {
// 		// Reply only when message sent is in 'text' format
// 		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
// 			// Get text sent
// 			$text = $event['message']['text'];
// 			// Get replyToken
// 			$replyToken = $event['replyToken'];

// 			// Build message to reply back
// 			$messages = [
// 				'type' => 'text',
// 				'text' => $text
// 			];

// 			// Make a POST Request to Messaging API to reply to sender
// 			$url = 'https://api.line.me/v2/bot/message/reply';
// 			$data = [
// 				'replyToken' => $replyToken,
// 				'messages' => [$messages],
// 			];
// 			$post = json_encode($data);
// 			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

// 			$ch = curl_init($url);
// 			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
// 			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// 			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
// 			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
// 			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
// 			$result = curl_exec($ch);
// 			curl_close($ch);

// 			echo $result . "\r\n";
// 		}
// 	}
// }
// echo "OK";