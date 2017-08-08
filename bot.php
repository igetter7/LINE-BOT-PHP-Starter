<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');


require_once __DIR__.'/vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;

use LINE\LINEBot;

class Bot
{

	public $bot = null;
	
	function __construct()
	{

		$logger = new Logger('LineBot');
		$logger->pushHandler(new StreamHandler('php://stderr', Logger::DEBUG));

		$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient('U5ddac8a518939a9f0a2efba0b2f3818b');
		$this->bot = new \LINE\LINEBot($httpClient, ['channelSecret' => '29m4MYSWqUiJG+cv9rpX3mb+G+JAZ+m7Wq5UKgeKiKJzLZELncR8PLH8/6MHt7/hndfFH0B7kGe9dPiObjLyID3o3h1yajodmF+yMVTsrIBhuglvPVrCeed2+YjDgi57+PFe1pCJ4XgW7oCPElbUBgdB04t89/1O/w1cDnyilFU=']);
	}

	public function push($text='')
	{
		$textMessageBuilder = new \LINEBot\MessageBuilder\TextMessageBuilder('hello');
		$response = $this->bot->pushMessage('<to>', $textMessageBuilder);

		echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
	}

	public function reply($replyToken,$text)
	{

		$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('hello');
		$response = $this->bot->replyMessage($replyToken, $textMessageBuilder);

		echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
	}
}





// $bots = new Bot();
// // Get POST body content
// $content = file_get_contents('php://input');
// $events = json_decode($content, true);
// if (!is_null($events['events'])) {
// 	if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
// 			$text = $event['message']['text'];
// 			$replyToken = $event['replyToken'];

// 			$messages = [
// 				'type' => 'text',
// 				'text' => $text
// 			];

// 			$replyToken = "sss";
// 			$text ="sssss";

// 			$bots->reply($replyToken,$text);
// 	}
// }

public function getWeather()
  {
    //$url = "http://api.openweathermap.org/data/2.5/weather?q=Bangkok&appid=ec1f7da303ae60f6e839fc6d55973804&units=metric";
    $url = "http://api.openweathermap.org/data/2.5/weather?q=Lat%20Krabang&appid=ec1f7da303ae60f6e839fc6d55973804&units=metric";
    $resp_arr = null;
    
    $response = $this->http->request('GET', $url);
    $resp_arr = json_decode($response->getBody());

    $id = $resp_arr->weather[0]->id;
    $main = $resp_arr->weather[0]->main;
    $description = $resp_arr->weather[0]->description;
    $temp = $resp_arr->main->temp;
    $descriptions = $main ." / ".$description;
    $arr_weathercode = array(
      200 => "มีพายุฝนฟ้านะนองและฝนตกปรอยๆ",
      201 => "มีพายุฝนฟ้านะนองและฝนตก",
      202 => "มีพายุฝนฟ้านะนองและฝนตกหนัก",
      210 => "มีพายุฝนฟ้านะนอง",
      211 => "มีพายุฝนฟ้านะนองฟ้าแลบฟ้าร้อง",
      212 => "มีพายุฝนฟ้านะนองฟ้าแลบฟ้าร้องอย่างมาก",
      221 => "มีพายุฝนฟ้านะนองฟ้าแลบฟ้าร้องอย่างหนักและมีอันตรายจากฟ้าผ่า",
      230 => "มีพายุฝนฟ้านะนองและฝนตกปรอยๆ",
      231 => "มีพายุฝนฟ้านะนองและฝนตก",
      232 => "มีพายุฝนฟ้านะนองและฝนตกหนัก",
      500 => "มีฝนตกพรำๆ",
      501 => "มีฝนตก",
      502 => "มีฝนตกค่อนข้างหนัก",
      503 => "มีฝนตกหนัก",
      504 => "มีฝนตกหนักมาก",
      520 => "มีฝนตกปรอยๆเบาๆ",
      521 => "มีฝนตก",
      522 => "มีฝนตกหนัก",
      741 => "มีหมอก",
      800 => "อากาศแจ่มใส",
      801 => "มีเมฆเล็กน้อย",
      802 => "มีเมฆบางส่วน",
      803 => "มีเมฆมาก",
      804 => "มีเมฆเต็มท้องฟ้า",
      901 => "มีพายุ",
      903 => "อากาศหนาว",
      904 => "อากาศร้อน",
      905 => "มีลมแรง",
      );


    if(array_key_exists($id, $arr_weathercode)) {
      $descriptions = $arr_weathercode[$id];
    } else if(strtolower($main) == "rain") {
      $descriptions = $descriptions;
    }

    print_r($resp_arr);

    if($id >= 800 && $id != 901) {
       $this->condition = "อากาศดีไปหาอะไรกินข้างนอกกันมั้ยครับ :)";
    }
    return "สภาพอากาศ ณ ขณะนี้ข้างนอก ".$descriptions." อุณหภูมิ ". $temp ." องศาเซลเซียส";

  }


public function analystInput($text='')
{
	$firstlevel = array(
		'อากาศ' => 'weather', 
		'ฝน' => 'weather', 
		'ร้อน' => 'weather', 
		'หนาว' => 'weather', 
		'กี่โมง' => 'time', 
		'เวลา' => 'time', 
		'รถติด' => 'traffic', 
		'จราจร' => 'traffic', 

		);

	$secondlevel = array(
		'ชื่ออะไร' => 'name', 
		'อายุ' => 'weather', 
		'มีแฟน' => 'weather', 
		'ง่วง' => 'weather', 
		'กินข้าว' => 'time', 
		'หิว' => 'time', 
		'ยังไง' => 'traffic', 

		);

	$when = array(
		'ตอนนี้' => 'now', 
		'วันนี้' => 'now', 
		'เดี๋ยวนี้' => 'now', 
		'ขณะนี้' => 'now', 
		'พรุ่งนี้' => '+1d', 
		'เมื่อวาน' => '-1d', 

		);

	$question = '';

	foreach ($firstlevel as $key => $value) {
		if (strpos($text, $key) !== false) {
			$question = $value;
		    break;
		}
	}

	if($question == 'weather') {
		$resp_text = getWeather();
	}

	else
		$resp_text = "ขอโทดค้าบบบ ไดโน่ไม่รู้จริงๆ";

	

	return $resp_text;
}





$access_token = '29m4MYSWqUiJG+cv9rpX3mb+G+JAZ+m7Wq5UKgeKiKJzLZELncR8PLH8/6MHt7/hndfFH0B7kGe9dPiObjLyID3o3h1yajodmF+yMVTsrIBhuglvPVrCeed2+YjDgi57+PFe1pCJ4XgW7oCPElbUBgdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			$text = $event['message']['text'];
			$replyToken = $event['replyToken'];



			$messages = [
				'type' => 'text',
				'text' => analystInput($text)
			];

			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);

			echo $result . "\r\n";
		}
	}
}
echo "OK";