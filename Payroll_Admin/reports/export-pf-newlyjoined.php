<?php
$doc_path=$_SERVER["DOCUMENT_ROOT"];
include ($doc_path.'/include_payroll_admin.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(0);

$setExcelName = "Newly join Employee";
 $month=$_SESSION['month'];
$clintid=$_SESSION['clintid'];
$emp=$_REQUEST['emp'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
//print_r($_SESSION);

/*$resclt=$payrollAdmin->displayClient($clintid);
$cmonth=$resclt['current_month'];
if($month=='current'){
    $monthtit =  date('F Y',strtotime($cmonth));
    $frdt=$cmonth;
    $todt=$cmonth;
 }
else{
    
    $frdt=date("Y-m-d", strtotime($_SESSION['frdt']));
    $todt=date("Y-m-d", strtotime($_SESSION['frdt']));
	
    $res=$payrollAdmin->lastDay($frdt);
	$frdt = $res['last_day'];
	
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
    $setExcelName = "Newly join Employee";
    $clintid =$grpClientIdsOnly['client_id'];
    if ($clientGrp == 1) {
        echo "!!!!!!!1";
        $clientids = $payrollAdmin->displayclientbyComp($comp_id);
        print_r($clientids);
        $resclt = $payrollAdmin->displayClient($clientids['client_id']);
        $clintid=$clientids['client_id'];
    }
}
else
{
    $resclt=$payrollAdmin->displayClient($clintid);
    $setExcelName = "Newly join Employee";

}

if ( $month=='current')
{
    $frdt=$resclt['current_month'];
}


$client_name = ($group=='') ? $resclt['client_name']: "Group : ".$group['group_name']; 
$frdt=$payrollAdmin->lastDay($frdt);
$monthtit =  date('F Y',strtotime($frdt));
$todt=$frdt;   

$setRec=$payrollAdmin->getnewlyjoined($frdt,$clintid,$comp_id);

$setCounter = sizeof($setRec);
$setMainHeader="";
$setData="";
//for ($i = 0; $i < $setCounter; $i++) {
foreach ($setRec[0] as $k=>$v) {
    //$setMainHeader .= mysql_field_name($setRec, $i)."\t";
    $setMainHeader .= $k."\t";
}

foreach($setRec as $rec)
{
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







