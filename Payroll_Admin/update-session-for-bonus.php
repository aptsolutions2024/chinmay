<?php
session_start();
//error_reporting(0);
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

$bonusyear=$_REQUEST['bonusyear'];
$byear=explode("-",$bonusyear);
//print_r($byear);
$startday=$byear[0]."-04-30";
$endday =$byear[1]."-03-31";
$_SESSION['startbonusyear'] = $startday;
$_SESSION['endbonusyear'] = $endday;
echo "Bonus year saved successfully";
?>