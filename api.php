<?php
// GET KEY SYSTEM //
$type = addslashes(trim($_GET['type'])); // type
$market = addslashes(trim($_GET['market'])); // sym
$gui = addslashes(trim($_GET['gui'])); // gui
$limit = addslashes(trim($_GET['limit'])); // gui


// API SYSTEM //
if($type == 1){
	$url = 'https://api.bitkub.com/api/market/ticker?sym='.$market.'';
	
}elseif($type == 2){
	$url = 'https://api.bitkub.com/api/market/trades?sym='.$market.'&lmt='.$limit.'';
}
// TEXT SAMPLE //
$text = "
<h3>กรุณากรอก พารามิเตอร์</h3> <br>
<hr>
type 1 = เช็คตลาดปัจจุบัน | type 2 = trade api<br>
<hr>
market : THB_BTC , THB_ETH , THB_DOGE , THB_BCH , THB_USDT , THB_XRP , THB_LTC , THB_EVX
<hr>
gui 0 = เปิด GUI Mode | gui 1 = json output | gui 2 = Array output
<hr>
ตัวอย่าง type 1: <a href='https://hi.in.th/api/api?type=1&market=THB_BTC&gui=0'>https://hi.in.th/api/api?type=1&market=THB_BTC&gui=0</a><br>
ตัวอย่าง type 2: <a href='https://hi.in.th/api/api?type=2&market=THB_BTC&gui=1&limit=10'>https://hi.in.th/api/api?type=2&market=THB_BTC&gui=1&limit=10</a><br>
<hr>";
/////////////////


//gui
if($gui == 0){
	if($type <> null || $market <> null || $gui <> null){
	  if($type == 1){
		$obj = json_decode(file_get_contents($url), true);
		echo "<hr>";
		echo "ราคาล่าสุด : ".$obj['THB_BTC']['last']."<br>";
		echo "ราคารับซื้อสูงสุด : ".$obj['THB_BTC']['lowestAsk']."<br>";
		echo "ราคาขายต่ำสุด : ".$obj['THB_BTC']['lowestAsk']."<br>";
		echo "% : ".$obj['THB_BTC']['percentChange']."<br>";
		echo "baseVolume : ".$obj['THB_BTC']['baseVolume']."<br>";
		echo "quoteVolume : ".$obj['THB_BTC']['quoteVolume']."<br>";
		echo "high24hr : ".$obj['THB_BTC']['high24hr']."<br>";
		echo "low24hr : ".$obj['THB_BTC']['low24hr']."<br>";
		echo "change : ".$obj['THB_BTC']['change']."<br>";
		echo "prevClose : ".$obj['THB_BTC']['prevClose']."<br>";
		echo "prevOpen : ".$obj['THB_BTC']['prevOpen']."<br>";
		echo "<hr>";
	  }elseif($type == 2){
			echo "ไม่มี ขี้เกียจทำ";
	  }
	}else{ // no พารามิเตอร์
		echo $text;
	}
}else if($gui == 1){ // json mode

	if($type <> null || $market <> null || $gui <> null){
	print_r(file_get_contents($url));
	
	}else{ // no พารามิเตอร์
		echo $text;
	}
	
	
}else{ // GUI 2 คือ ถอด json code
	if($type <> null || $market <> null || $gui <> null){
	print_r(json_decode(file_get_contents($url), true));
	}else{ // no พารามิเตอร์
		echo $text;
	}
	
}