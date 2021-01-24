<?php 
// CONFIG //
$usd_server = 1; //  0 = free.currconv.com | 1 = api.currencylayer.com
$type = 1; // 0 = USD Price | 1 = THB Price
// API-KEY //
// สามารถไปสมัคร ใส่ API ของตัวเองได้ เพราะ มันจำกัดการใช้งานแล้วแต่เว็บผู้ให้บริการ
$key1 = "5d56876a070feef0811c6fd252e714dd";// currencylayer.com
$key2 = "2d9c96bce0dc65d4db62";// currconv.com
///////////////////////////////////////////////////////////////////////
$get_use = addslashes(trim($_GET['v']));
// BITCOIN API
$content = file_get_contents("https://api.bitkub.com/api/market/ticker?sym=USD_BTC"); // ดึงข้อมูล
$obj = json_decode($content); //decode json data
// USD-THB API
if($usd_server == 0){
		$content2 = file_get_contents("http://api.currencylayer.com/live?access_key=".$key1."&format=1&currencies=THB");
		$obj2 = json_decode($content2);
		$usd = $obj2->quotes->USDTHB; // USD:THB ดึงข้อมูล หัวข้อ quotes ฟิลด์ USDTHB
}else if($usd_server == 1){
		$content2 = file_get_contents("https://free.currconv.com/api/v7/convert?q=USD_THB&compact=ultra&apiKey=".$key2."");
		$obj2 = json_decode($content2);
		$usd = $obj2->USD_THB; // USD:THB อันนี้ API เป็นแบบชั้นเดียวง่าย ๆ เลยดึงจากชื่อมาได้เลย USD_THB
}


$thbbitcoin = $obj->THB_BTC->last; // BTC

//กรณีเรียกใช้ ?v= เพื่อเปลี่ยนผลลัพธ์
if($get_use == null){
	// ระบบแสดงผลตาม config
	if($type == 0){
	$cookie = $thbbitcoin;
	}else if($type == 1){
	$cookie = $thbbitcoin / $usd;
	}
// แสดงผลตาม key ผ่านลิ้ง ?v=usd หรือ ?v=thb
}else if($get_use == "usd"){
	$cookie = $thbbitcoin / $usd;
}else if($get_use == "thb"){
	$cookie = $thbbitcoin;
}
// OUTPUT
echo $cookie; // แสดงผล ราคา BTC ปัจจุบัน (THB)

?>
