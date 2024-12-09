<?php 
$dtimezone = date_default_timezone_get();
$ip =$_SERVER['REMOTE_ADDR'];
$data = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
$timezone_name = $data['timezone'];
if($timezone_name==''){ 
	date_default_timezone_set('Asia/Kolkata');
}else{
	//date_default_timezone_set($timezone_name);
	date_default_timezone_set('Asia/Kolkata');
}
$currdate = date("Y-m-d");
$currTime =  date("H:i:s");
$currentDateTime = $currdate." ".$currTime;

?>




 

