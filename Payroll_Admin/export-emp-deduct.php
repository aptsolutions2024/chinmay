<?php

session_start();
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

$setCounter = 0;
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$setExcelName = "employee_deduct";
$clint_id=$_REQUEST['cid'];
 
 $setRec=$payrollAdmin->getIncomeEmpDetails($comp_id,$user_id,$clint_id);

// echo "<pre>";print_r($setRec);echo "</pre>";
//$setCounter = mysql_num_fields($setRec);
$setCounter = sizeof($setRec);
$columnCounter= sizeof($setRec[0]);
$setMainHeader="";
$setData="";

//for ($i = 0; $i < $columnCounter/2; $i++) {
foreach ($setRec[0] as  $key=>$val) {
        //$setMainHeader .= mysql_field_name($setRec, $i)."\t";
        $setMainHeader .= $key."\t";
}
/*$setMainHeader .="STD Amount \t";
 $setMainHeader .="Remark \t";*/
 $flag=0;
foreach($setRec as $rec)
  {
      if($flag==0){ $flag=1;continue;}
    $rowLine = '';
    $j=0;
    foreach($rec as $value)       {
        if(!isset($value) || $value == "")  {
            $value = "\t";
        }   else  {
//It escape all the special charactor, quotes from the data.
            $value = strip_tags(str_replace('"', '""', $value));
            if($j>3) {
                $value = '" "' . "\t";
            } else{
                $value = '"' . $value . '"' . "\t";
            }

     $j++;
        }
        $rowLine .= $value;
    }
    $setData .= trim($rowLine)."\n";
}
$setData = str_replace("\r", "", $setData);

if ($setData == "") {
   // $setData = "\nno matching records found\n";
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