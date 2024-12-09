<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');
error_reporting(0);
$setCounter = 0;
$setCounter = 0;
$month=$_SESSION['month'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$clintid=$_SESSION['clientid'];

$setExcelName = "leave_detail";

//$res=$payrollAdmin->showEmployeereport($comp_id,$user_id);
$resclt=$payrollAdmin->displayClient($clintid);
$frdt=date("Y-m-d", strtotime($_REQUEST['frdt1']));
$todt=date("Y-m-d", strtotime($_REQUEST['todt1']));

$setRec=$payrollAdmin->getEmpExportDetails($clintid,$frdt,$todt);   

$setMainHeader="";
$setData="";
$i=0;

foreach($setRec[0] as $k=>$v) {
    $i++;
    if($i%2==0){ }else{
    //$setMainHeader .= mysql_field_name($setRec, $i)."\t";
        $setMainHeader .= $k."\t";
    }
}

$flag=0;

foreach($setRec as $rec)
{
   $j=0;
     $rowLine = '';
    foreach($rec as $value)       {
      
        $j++;
        // echo 'j : '.$j.'#'.$value;
       if($j%2==0){}else{
          // echo $value;
            if(!isset($value) || $value == "")  {
                $value = "\t";
            }   else  {
    //It escape all the special charactor, quotes from the data.
                $value = strip_tags(str_replace('"', '""', $value));
                $value = '"' . $value . '"' . "\t";
            }
            $rowLine .= $value;
          }
         // echo $rowLine;
         
    }
     $setData .= trim($rowLine)."\n";
    
}
$setData = str_replace("\r", "", $setData);

if ($setData == "") {
    $setData = "\nno matching records found\n";
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







