<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

//print_r($_REQUEST);die;

//$compid= $_SESSION['comp_id'];
$chkb= $_REQUEST['chkbox'];
$amount= $_REQUEST['amount'];
$billno = $_REQUEST['billno'];


$client= $_REQUEST['client'];
$opid= $_REQUEST['optype'];
$paymentdate= date('Y-m-d',strtotime($_REQUEST['billdate'])); 
$chkbox = $_REQUEST['chkbox'];
$chkemp = $_REQUEST['chkemp'];

$i=1;
$succ=0;
//exit;
foreach($chkb as $chkbid){
	//$getcnt = $payrollAdmin->checkopdetails($amount[$chkbid],$billno,$chkemp[$chkbid],$client,$opid,$paymentdate);
	//print_r($getcnt['id']);
	
	  // echo "<br>2 - ".$emp."insert *****<br>".$chkbid."-".$chkemp[$chkbid];	
		$result=$payrollAdmin->insertopdetails($amount[$chkbid],$billno,$chkemp[$chkbid],$client,$opid,$paymentdate);
		if($result){
		  $succ++;  
		}
		
	
	
 
$i++;
 }
 echo $succ;
?>