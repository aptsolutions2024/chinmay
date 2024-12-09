<?php
//error_reporting(0);
session_start();
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
//$userObj=new user();
ob_end_clean();
//print_r($_SESSION);

$setRec = $payrollAdmin->exportAllEmployee($comp_id,$_POST['cal']);
//print_r($setRec);

  //$setCounter = sizeof($setRec);
 // echo "SetCounter-".$setCounter;
$setMainHeader="";
$setData="";

foreach ($setRec[0] as $key=>$value) {
   
     $setMainHeader .=$key."\t";
  
}
//echo $setMainHeader;

$result = array();
         $table = array();
         $field = array();

         
//while($rec = $setRec->fetch_assoc())  {
foreach($setRec as $rec) {
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

//This Header is used to make data download instead of display the data
header("Content-type: application/octet-stream");

header("Content-Disposition: attachment; filename=".$setExcelName.".xls");

header("Pragma: no-cache");
header("Expires: 0");

//It will print all the Table row as Excel file row with selected column name as header.
echo ucwords($setMainHeader)."\n".$setData."\n";
?>







