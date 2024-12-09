<?php
$doc_path=$_SERVER["DOCUMENT_ROOT"];
include ($doc_path.'/include_payroll_admin.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(0);


$setCounter = 0;
//print_r($_SESSION);die;
$clientid=$_SESSION['clientid'];
$month=$_SESSION['month'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$clintid=$_SESSION['clintid'];
$setExcelName = "employee_detail";
$emp=$_REQUEST['emp'];


//$res=$payrollAdmin->showEmployeereport($comp_id,$user_id);
/*$resclt=$payrollAdmin->displayClient($clintid);
$cmonth=$resclt['current_month'];
if($month=='current'){
    $monthtit =  date('F Y',strtotime($cmonth));
    $tab_days='tran_days';	
    $tab_emp='tran_employee';
    $tab_empinc='tran_income';
    $tab_empded='tran_deduct';
    $frdt=$cmonth;
    $todt=$cmonth;
 }
else{
    $monthtit =  date('F Y',strtotime($_SESSION['frdt']));
    $tab_days='hist_days';
    $tab_emp='hist_employee';
    $tab_empinc='hist_income';
    $tab_empded='hist_deduct';

    $frdt=date("Y-m-d", strtotime($_SESSION['frdt']));
    $todt=date("Y-m-d", strtotime($_SESSION['frdt']));
	
// 	$res=$payrollAdmin->lastDay($frdt);
// 	$frdt = $res['last_day'];
	
echo $frdt=$payrollAdmin->lastDay($frdt);
	
 }*/
$clientGrp=$_SESSION['clientGrp'];
$frdt=$_SESSION['frdt'];

$group[]='';
$resclt='';
if ($clientGrp!='')
{   $group=$payrollAdmin->displayClientGroupById($clientGrp);
    $grpClientIds=$payrollAdmin->getGroupClientIds($clientGrp)  ;
    
    $grpClientIdsOnly=$payrollAdmin->getGroupClientIdsOnly($clientGrp);
    $resclt=$payrollAdmin->displayClient($grpClientIds[0]['mast_client_id']);
    $setExcelName = "UAN_ECR_Group".$clientGrp;
    $clintid =$grpClientIdsOnly['client_id'];
    if ($clientGrp == 1) {
        // echo "!!!!!!!1";
        $clientids = $payrollAdmin->displayclientbyComp($comp_id);
        // print_r($clientids);
        $resclt = $payrollAdmin->displayClient($clientids['client_id']);
        $clintid=$clientids['client_id'];
    }
    
}
else
{
    $resclt=$payrollAdmin->displayClient($clintid);
    $setExcelName = "UAN_ECR_".$clintid;

}

if ( $month=='current')
{
    $frdt=$resclt['current_month'];
}


$client_name = ($clientGrp=='') ? $resclt['client_name']: "Group : ".$group['group_name']; 
$frdt=$payrollAdmin->lastDay($frdt);
$monthtit =  date('F Y',strtotime($frdt));
$todt=$frdt;    


$setExcelName = "uan_ecr";

$rows=$payrollAdmin->deleteUAN();

$row = $payrollAdmin->getPFUAN($comp_id,$frdt,$clintid);
foreach($row as $row1)
{   
$row2 = $payrollAdmin->getPFUAN1($row1['uan'],$row1['first_name'],$row1['middle_name'],$row1['last_name'],$row1['gross_salary'],$row1['std_amt'],$row1['amount'],$row1['employer_contri_2'],$row1['employer_contri_1'],$row1['absent']);
}


$setRec = $payrollAdmin->getAllFUAN();


$setCounter = sizeof($setRec);
$setMainHeader="";
$setData="";
//for ($i = 0; $i < $setRec[0]; $i++) {
foreach ($setRec[0] as $k=>$v) {
    //$setMainHeader .= mysql_field_name($setRec, $i)."\t";
    $setMainHeader .= $k."\t";
}
$setRec1 = $payrollAdmin->getAllFUAN();
foreach($setRec1 as $rec)
{
    $rowLine = '';
    foreach($rec as $value)       {
        if(!isset($value) || $value == "")  {
            $value = "\t";
        }   else  {
//It escape all the special charactor, quotes from the data.
            $value = strip_tags(str_replace('"', '""', $value));
            $value =  number_format($value,0,'.',''). "#~#";
			     //$value = '#' . $value . '"' ;
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

header("Content-Disposition: attachment; filename=".$setExcelName.".csv");

header("Pragma: no-cache");
header("Expires: 0");

//It will print all the Table row as Excel file row with selected column name as header.
echo ucwords($setMainHeader)."\n".$setData."\n";
?>







