<?php 
// CONFIG //
$usd_server = 1; //  0 = free.currconv.com | 1 = api.currencylayer.com www.currencyconverterapi.com
$type = 1; // 0 = USD Price | 1 = THB Price
// API-KEY //
// สามารถไปสมัคร ใส่ API ของตัวเองได้ เพราะ มันจำกัดการใช้งานแล้วแต่เว็บผู้ให้บริการ
$key1 = "5d56876a070feef0811c6fd252e714dd";// currencylayer.com
$key2 = "f0bac32223bf440f2600";// currconv.com
///////////////////////////////////////////////////////////////////////
$get_use = addslashes(trim($_GET['v'])); // get key 1
$get_format = addslashes(trim($_GET['f'])); // get key 2
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
	if ($get_format == 1){
		$cookie = number_format($thbbitcoin / $usd,2,".","");
	}else{
		$cookie = $thbbitcoin / $usd;
	}
}else if($get_use == "thb"){
	if ($get_format == 1){
		$cookie = number_format($thbbitcoin,2,".","");
	}else{
		$cookie = $thbbitcoin;	
	}
}else if($get_use == "currency"){
	if ($get_format == 1){
		$cookie = number_format($usd,2,".","");
	}else{
			$cookie = $usd;
	}
}
// OUTPUT
echo $cookie; // แสดงผล ราคา BTC ปัจจุบัน (THB)

?>
