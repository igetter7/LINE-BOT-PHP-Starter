<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');
date_default_timezone_set("Asia/Bangkok");


require_once __DIR__.'/vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;

use GuzzleHttp\Client;
use LINE\LINEBot;

class Bot
{

	public $bot = null;
	
	function __construct()
	{
		$this->http = new Client();
		// $logger = new Logger('LineBot');
		// $logger->pushHandler(new StreamHandler('php://stderr', Logger::DEBUG));

		// $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient('U5ddac8a518939a9f0a2efba0b2f3818b');
		// $this->bot = new \LINE\LINEBot($httpClient, ['channelSecret' => '29m4MYSWqUiJG+cv9rpX3mb+G+JAZ+m7Wq5UKgeKiKJzLZELncR8PLH8/6MHt7/hndfFH0B7kGe9dPiObjLyID3o3h1yajodmF+yMVTsrIBhuglvPVrCeed2+YjDgi57+PFe1pCJ4XgW7oCPElbUBgdB04t89/1O/w1cDnyilFU=']);
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

	    return "".$descriptions." อุณหภูมิ ". $temp ." องศาเซลเซียสครัชชช";

	  }

	 public function getTime()
	 {
	 	$time = time();
    	$thai_date_return = " เวลา ".date("H โมง i นาที",$time)."";

    	return $thai_date_return;
	 }

	 public function getDate()
	 {
	 	$time = time();
	 	$thai_day_arr=array("อาทิตย์","จันทร์","อังคาร","พุธ","พฤหัสบดี","ศุกร์","เสาร์");
		$thai_month_arr=array(
		    "0"=>"",
		    "1"=>"มกราคม",
		    "2"=>"กุมภาพันธ์",
		    "3"=>"มีนาคม",
		    "4"=>"เมษายน",
		    "5"=>"พฤษภาคม",
		    "6"=>"มิถุนายน", 
		    "7"=>"กรกฎาคม",
		    "8"=>"สิงหาคม",
		    "9"=>"กันยายน",
		    "10"=>"ตุลาคม",
		    "11"=>"พฤศจิกายน",
		    "12"=>"ธันวาคม"                 
		);

		$thai_date_return="วัน".$thai_day_arr[date("w",$time)];
    	$thai_date_return.= "ที่ ".date("j",$time);
    	$thai_date_return.=" ".$thai_month_arr[date("n",$time)];
    	$thai_date_return.= " พ.ศ.".(date("Y",$time)+543);

    	return $thai_date_return;
	 }

	 public function sayHi()
	 {
	 	$hi = [
	 	'หวัดดีครับ',
	 	'ดีครับ',
	 	'ฮาโหลค้าบ',
	 	'สวัสดีครับ',
	 	'ค้าบ',
	 	'ครัช',

	 	];
	 	$hiArraySize = sizeof($hi)-1;
    	return $hi[rand(0,$hiArraySize)];
	 }

	 public function sayYourwelcome()
	 {
	 	$hi = [
		 	'ไม่เป็นไรครับ',
		 	'ด้วยความยินดีครับ',
		 	'ยินดีจ้าดนักครับ',
		 	'เล็กน้อยครับ',
		 	'ค้าบ',
		 	'ครัช',
		 	':)',

	 	];
	 	$hiArraySize = sizeof($hi)-1;
    	return $hi[rand(0,$hiArraySize)];
	 }

	 public function sayBye($text)
	 {
	 	$bye = [
		 	'หวัดดีครับ',
		 	'ดีครับ',
		 	'ฮาโหลค้าบ',
		 	'สวัสดีครับ',
		 	'ค้าบ',
		 	'ครัช',

	 	];
	 	$byeArraySize = sizeof($bye)-1;
    	return $text;
	 }

	 public function sayRude($level,$text="")
	 {
	 	$resp = [];

	 	if($level == 1) {
	 		$resp = [
		 		'T^T ไม่หยาบคายกับไดโน่สิครับ',
		 		'......',
		 		'ไม่หยาบคายสิครับบบ'
	 		];
	 	} else if($level == 2) {
	 		$resp = [
		 		'T^T ไม่หยาบคายสิครับ',
		 		'ทำไมหยาบคายจุง',
		 		'เพื่อนเล่นเหรอครัช'
	 		];
	 	}  else if($level == 3) {
	 		$resp = [
		 		'ทำไมหยาบคายจุง',
		 		'เพื่อนเล่นเหรอ',
		 		'นี่น้องไดเองนะ',
		 		'ใจเยดๆสิ',
		 		'โหยยยย หยาบคาย',
		 		'ไม่หยาบคายสิ',
		 		'ว่างเหรอครับ',
		 		'อะไรนะ',
		 		'ทำไมพูดจาอย่างงั้นล่ะครับ ไม่เอาไม่พูด',
		 		$text.'คืออะไรครับไดโน่เกิดไม่ทัน',
		 		$text.'คืออะไรครับไดโน่เรียนมาน้อย',
		 		$text.'เช่นกันค้าบบบ',
	 		];
	 	}

	 	$resparrsize = sizeof($resp)-1;
    	return $resp[rand(0,$resparrsize)];
	 }

	 public function sayThankyou($found='')
	 {
	 	$resp = [
		 		'สบายดีครับ',
		 		'ก็ดีครับ',
		 		'ก็เรื่อยๆครับ',
		 		'ก็ดีครับ ขอบคุณคร้าบ',
		 		'แฮ่ะๆๆ',
	 		];
	 	$resparrsize = sizeof($resp)-1;
    	return $resp[rand(0,$resparrsize)];
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




function analystInput($text='')
{

	$funnytext = array(
		'สัส' => 'rude3', 
		'เหี้ย' => 'rude2', 
		'เชี่ย' => 'rude2', 
		'ควย' => 'rude1', 
		'ฟาย' => 'rude3', 
		'พ่อง' => 'rude3', 
		'แม่ง' => 'rude3', 
		'แม้ง' => 'rude3', 
		'ตีน' => 'rude3', 
		'กวนตีน' => 'rude3', 
		'โพ่ง' => 'rude3', 
		);

	$firstlevel = array(
		'อากาศ' => 'weather', 
		'ฝน' => 'weather', 
		'ร้อน' => 'weather', 
		'หนาว' => 'weather', 
		'กี่โมง' => 'time', 
		'เวลา' => 'time', 
		'วันที่เท่าไหร่' => 'date', 
		'วันอะไร' => 'date', 
		'วันที่่' => 'date', 
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
		'หวัดดี' => 'greeting',
		'ว่าไง' => 'greeting',
		'โหล' => 'greeting',

		'สบายดีมั้ย' => 'howareyou',
		'สบายดี' => 'howareyou',
		'สบายดี' => 'howareyou',

		'ทำอะไร' => 'whatareyoudoing',
		'ว่างมั้ย' => 'whatareyoudoing',

		'ขอบคุณ' => 'thx',
		'thx' => 'thx',
		'ขอบใจ' => 'thx',
		'ใจมาก' => 'thx',
		'thank' => 'thx',
		'กิ้ว' => 'thx',
		'แต้ง' => 'thx',

		'บาย' => 'bye',
		'ลาก่อย' => 'bye',
		'ลาก่อน' => 'bye',
		'bye' => 'bye',
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
	$whentext = '';
	$found = '';


	foreach ($secondlevel as $key => $value) {
		if (strpos($text, $key) !== false) {
			$question = $value;
			$found = $key;
		    break;
		}
	}


	foreach ($firstlevel as $key => $value) {
		if (strpos($text, $key) !== false) {
			$question = $value;
		    break;
		}
	}

	foreach ($when as $key => $value) {
		if (strpos($text, $key) !== false) {
			$whentext = $key;
		    break;
		}
	}

	foreach ($funnytext as $key => $value) {
		if (strpos($text, $key) !== false) {
			$question = $value;
			$found = $key;
		    break;
		}
	}



	$a_bot = new Bot();

	if($question == 'weather') {
		$resp_text = 'สภาพอากาศ'.$whentext.$a_bot->getWeather();
	} else if($question == 'time') {
		$resp_text = 'ตอนนี้'.$a_bot->getTime().' ครับ';
	} else if($question == 'date') {
		$resp_text = 'วันนี้'.$a_bot->getDate().' ครับ';
	}  else if($question == 'greeting') {
		$resp_text = $a_bot->sayHi();
	}  else if($question == 'bye') {
		$resp_text = $a_bot->sayBye($found)."ค้าบ";
	} else if($question == 'rude1') {
		$resp_text = $a_bot->sayRude(1,$found);
	}  else if($question == 'rude2') {
		$resp_text = $a_bot->sayRude(2,$found);
	}  else if($question == 'rude3') {
		$resp_text = $a_bot->sayRude(3,$found);
	}   else if($question == 'howareyou') {
		$resp_text = $a_bot->sayThankyou($found);
	} else if($question == 'thx') {
		$resp_text = $a_bot->sayYourwelcome($found);
	} 





	else
		$resp_text = $text."คืออะไรค้าบบบ ไดโน่ไม่รู้จริงๆเรียนมาน้อย";

	

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
// echo "OK";

// $text = $_GET['test'];
// print_r(analystInput($text));