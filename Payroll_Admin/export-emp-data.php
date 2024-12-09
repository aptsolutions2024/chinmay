<?php
ob_start();
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(0);


$setCounter = 0;
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$setExcelName = "employee_detail";


$setRec=$payrollAdmin->getEmpImportDetails($comp_id);
//echo "<pre>";print_r($setRec[0]);die;
$setCounter = sizeof($setRec);
$columnCounter= sizeof($setRec[0]);


$setExcelName = "sample.xls";
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=$setExcelName");


$setMainHeader="";
$setData="";





for ($i = 0; $i < $columnCounter; $i++) {

        $setMainHeader .= $setRec[0][$i]."\t";


}




//This Header is used to make data download instead of display the data
//header("Content-type: application/octet-stream");

//header("Content-Disposition: attachment; filename=".$setExcelName.".xls");

//header("Pragma: no-cache");
//header("Expires: 0");
ob_clean();
//It will print all the Table row as Excel file row with selected column name as header.
echo ucwords($setMainHeader)."\n";
?>







