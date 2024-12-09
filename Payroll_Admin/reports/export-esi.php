<?php
include ('../../include_payroll_admin.php');

error_reporting(E_ALL);
$setCounter = 0;
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$setExcelName = "esi_export";
$clintid=$_SESSION['clintid'];
$month=$_SESSION['month'];


$clientGrp=$_SESSION['clientGrp'];
$frdt=$_SESSION['frdt'];

$group[]='';
$resclt='';
$client_id='';
if ($clientGrp!='')
{   $group=$payrollAdmin->displayClientGroupById($clientGrp);
    $grpClientIds=$payrollAdmin->getGroupClientIds($clientGrp)  ;
    $grpClientIds[0]['mast_client_id'];
    $resclt=$payrollAdmin->displayClient($grpClientIds[0]['mast_client_id']);
    
    $grpClientIdsOnly=$payrollAdmin->getGroupClientIdsOnly($clientGrp);
    $setExcelName = "Paysheet_Group".$clientGrp;
    $client_id =$grpClientIdsOnly['client_id'];
    if ($clientGrp == 1) {
        // echo "!!!!!!!1";
        $clientids = $payrollAdmin->displayclientbyComp($comp_id);
        // print_r($clientids);
        $resclt = $payrollAdmin->displayClient($clientids['client_id']);
        $client_id=$clientids['client_id'];
    }
}
else
{
    $client_id= $clintid;
    $resclt=$payrollAdmin->displayClient($clintid);
    $setExcelName = "Paysheet_".$clintid;

}
if ( $month=='current')
{
    $frdt=$resclt['current_month'];
}

$client_name = ($clientGrp=='')?  $resclt['client_name']:   "Group : ".$group['group_name']; 
$frdt=$payrollAdmin->lastDay($frdt);
$monthtit =  date('F Y',strtotime($frdt));
$todt=$frdt; 







$srno = 1;

$setRec=$payrollAdmin->ESIStatement($comp_id,$frdt);
    	    

$setCounter = sizeof($setRec);
$setMainHeader="";
$setData="";
$setMainHeader="ESICode\t S.no\t ESINO \t Nanme \t Days \t Wages \t EE Con \t ER Con \t Total\n";

$res_code = $payrollAdmin->getEsicode($comp_id,$client_id);
$tcount= sizeof($res_code);
foreach($res_code as $rowcode)
	{
	    $setRec=$payrollAdmin->getESIstatement($rowcode['client_id1'],$comp_id,$frdt);
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


//This Header is used to make data download instead of display the data
}
if ($setData == "") {
    $setData = "\nno matching records found\n";
}


header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=".$setExcelName.".xls");
header("Pragma: no-cache");
header("Expires: 0");

//It will print all the Table row as Excel file row with selected column name as header.
echo ucwords($setMainHeader)."\n".$setData."\n";
?>







