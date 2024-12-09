<?php
session_start();
error_reporting(0);

ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);

$doc_path=$_SERVER["DOCUMENT_ROOT"];
include ($doc_path.'/include_payroll_admin.php');
$setCounter = 0;
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$setExcelName = "employee_detail";
$clientid=$_SESSION['clientid'];
$emp = $_POST['emp'];
$clientid = $_POST['clientid'];
//print_r($_SESSION);
$setRec1 = $payrollAdmin->exportActiveEmployee($clientid,$comp_id,$user_id,$emp);
//echo "<pre>***************";print_r($setRec);echo "</pre>";exit;
//exit;
$setMainHeader="";
$setData="";

foreach($setRec1[0] as $key=>$fld){
   
    $setMainHeader .= $key."\t";
}
$setRec = $payrollAdmin->exportActiveEmployee($clientid,$comp_id,$user_id,$emp);
foreach($setRec as $rec)  {
    $rowLine = '';
    foreach($rec as $value)       {
        if(!isset($value) || $value == "")  {
            $value = "\t";
        }   else  {
          //It escape all the special charactor, quotes from the data.
            $value = strip_tags(str_replace('"', '""', $value));
            $value = '"' . $value . '"' . "\t";
        }
        $rowLine .= $value;
    }
    $setData .= trim($rowLine)."\n";
}
$setData = str_replace("\r", "", $setData);

if ($setData == "") {
    $setData = "\nno matching records found\n";
}
ob_end_clean();
//This Header is used to make data download instead of display the data
header("Content-type: application/octet-stream");

header("Content-Disposition: attachment; filename=".$setExcelName.".xls");

header("Pragma: no-cache");
header("Expires: 0");

//It will print all the Table row as Excel file row with selected column name as header.
echo ucwords($setMainHeader)."\n".$setData."\n";
?>






