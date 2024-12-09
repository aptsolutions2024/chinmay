<?php
ob_start();
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');
error_reporting(0);
$setCounter = 0;
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$clint_id=$_REQUEST['cid'];
$setExcelName = "employee_income";
$file =  "c:/salary/empinc_".$clint_id.chr(46)."csv";
  if (file_exists($file)) {
        unlink($file);
    }

$setRec=$payrollAdmin->getIncomeEmpDetails_import($comp_id,$user_id,$clint_id);
// echo "<pre>";print_r($setRec);
//die;
//$setCounter = mysql_num_fields($setRec);
$setCounter = sizeof($setRec);
$columnCounter= sizeof($setRec[0]);
$setMainHeader="";
$setData="";
for ($i = 0; $i < $columnCounter/2; $i++) {
        //$setMainHeader .= mysql_field_name($setRec, $i)."\t";
        $setMainHeader .= $setRec[0][$i]."\t";
}
$setMainHeader ="Emp_id\tfirst_name\tmiddle_name\tlast_name\tStd_amt\tRemark\t";
// echo $setMainHeader;exit;
foreach($setRec as $rec)
  {
    
    $rowLine = '';
    $j=0;
    foreach($rec as $value)       {
        print_r($res);
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
//  print_r($setData);exit;
if ($setData == "") {
   // $setData = "\nno matching records found\n";
}

ob_clean();
//This Header is used to make data download instead of display the data
header("Content-type: application/octet-stream");

header("Content-Disposition: attachment; filename=".$setExcelName.".xls");

header("Pragma: no-cache");
header("Expires: 0");

//It will print all the Table row as Excel file row with selected column name as header.
echo ucwords($setMainHeader)."\n".$setData."\n";
?>







