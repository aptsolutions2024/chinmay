<?php
session_start();
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$setExcelName = "employee_detail_trandays";
 $client_id = $_SESSION['clientid'];



if($client_id!=''){
						
	$head = $payrollAdmin->getmastcomptdstring();

	$exhd = explode(',',$head);
	$j= count($exhd);
	    
	$setRec= $payrollAdmin->exportTrandayTransaction($client_id,$exhd,$j,$comp_id,$user_id);
   // echo "<pre>";  print_r($setRec);echo "</pre>";
    $setMainHeader = "";
    $setData = "";

   // while($fld =mysqli_fetch_field($setRec)){
   foreach($setRec[0] as $key=>$fld){
    $setMainHeader .= $key."\t";
}

  //  while ($rec = $setRec->fetch_assoc()) {
    foreach($setRec as $rec){
        $rowLine = '';
        foreach ($rec as $value) {
            if (!isset($value) || $value == "") {
                $value = "\t";
            } else {
              //It escape all the special charactor, quotes from the data.
                $value = strip_tags(str_replace('"', '""', $value));
                $value = '"' . $value . '"' . "\t";
            }
            $rowLine .= $value;
        }
        $setData .= trim($rowLine) . "\n";
    }
    $setData = str_replace("\r", "", $setData);

    if ($setData == "") {
        $setData = "\nno matching records found\n";
    }


}
else{

    if ($setData == "") {
        $setData = "\nno matching records found\n";
    }
}
	ob_end_clean();
//This Header is used to make data download instead of display the data
header("Content-type: application/octet-stream");

header("Content-Disposition: attachment; filename=" . $setExcelName . ".xls");

header("Pragma: no-cache");
header("Expires: 0");

//It will print all the Table row as Excel file row with selected column name as header.
echo ucwords($setMainHeader) . "\n" . $setData . "\n";
?>







