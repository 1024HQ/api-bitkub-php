<?php 
// CONFIG //
$usd_server = 1; //  0 = free.currconv.com | 1 = api.currencylayer.com
$type = 1; // 0 = USD Price | 1 = THB Price
// API-KEY //
// สามารถไปสมัคร ใส่ API ของตัวเองได้ เพราะ มันจำกัดการใช้งานแล้วแต่เว็บผู้ให้บริการ
$key1 = "5d56876a070feef0811c6fd252e714dd";// currencylayer.com
$key2 = "2d9c96bce0dc65d4db62";// currconv.com
///////////////////////////////////////////////////////////////////////

// BITCOIN API
$content = file_get_contents("https://api.bitkub.com/api/market/ticker?sym=USD_BTC"); // ดึงข้อมูล
$obj = json_decode($content); //decode json data
// USD-THB API
if($usd_server == 0){
		$content2 = file_get_contents("http://api.currencylayer.com/live?access_key=5d56876a070feef0811c6fd252e714dd&format=1&currencies=THB");
		$obj2 = json_decode($content2);
		$usd = $obj2->quotes->USDTHB; // USD:THB ดึงข้อมูล หัวข้อ quotes ฟิลด์ USDTHB
}else if($usd_server == 1){
		$content2 = file_get_contents("https://free.currconv.com/api/v7/convert?q=USD_THB&compact=ultra&apiKey=2d9c96bce0dc65d4db62");
		$obj2 = json_decode($content2);
		$usd = $obj2->USD_THB; // USD:THB อันนี้ API เป็นแบบชั้นเดียวง่าย ๆ เลยดึงจากชื่อมาได้เลย USD_THB
}


$thbbitcoin = $obj->THB_BTC->last; // BTC
if($type == 0){
	$cookie = $thbbitcoin;
}else if($type == 1){
	$cookie = $thbbitcoin / $usd;
}
$cookie = $thbbitcoin / $usd;
echo $cookie; // แสดงผล ราคา BTC ปัจจุบัน (THB)

?>