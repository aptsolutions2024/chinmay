<?php
ini_set('max_input_vars', 0);
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

//echo "<pre>";print_r($_REQUEST);die;

$compid= $_SESSION['comp_id'];
$empid= $_REQUEST['empid'];
$preday= $_REQUEST['preday'];
$obday= $_REQUEST['obday'];
$earned= $_REQUEST['earned'];
$enjoyed= $_REQUEST['enjoyed'];
$balance= $_REQUEST['balance'];
$encashed= $_REQUEST['encashed'];
$rate= $_REQUEST['rate'];
$amount= $_REQUEST['amount'];
$chkbox = $_REQUEST['chkbox'];


$client= $_REQUEST['client'];
$payrollAdmintype= $_REQUEST['leavetype'];
$frdt= $_REQUEST['frdt'];
$todt= $_REQUEST['todt'];
$payment_date= $_REQUEST['payment_date'];


$i=0;

foreach($empid as $emp){

	 if (in_array($emp, $chkbox)){
    	$bankdetail = $payrollAdmin->getBankDetails($emp,$client);
    	$bid = $bankdetail['bank_id'];
    	$bankacno = $bankdetail['bankacno'];
    	$paymode = $bankdetail['pay_mode'];
   
    	$chkbankdtl = $payrollAdmin->checkEncashment($frdt,$todt,$emp,$client,$payrollAdmintype);
    
    	  $chkbankdtl1 = $payrollAdmin->checkEncashmentRow($frdt,$todt,$emp,$client,$payrollAdmintype); 
    	 
    	  if($chkbankdtl1!=NULL){
    	  //echo "<br>1 - ".$emp." update **** <br>";	
    		$payrollAdmin->updateEncashment($emp,$preday[$i],$obday[$i],$earned[$i],$enjoyed[$i],$balance[$i],$encashed[$i],$rate[$i],$amount[$i],$bid,$bankacno,$paymode,$client,$payrollAdmintype,$frdt,$todt,$compid,$payment_date);
    	}else{
    	 //echo "<br>2 - ".$emp."insert *****<br>";
    		$payrollAdmin->insertEncashment($emp,$preday[$i],$obday[$i],$earned[$i],$enjoyed[$i],$balance[$i],$encashed[$i],$rate[$i],$amount[$i],$bid,$bankacno,$paymode,$client,$payrollAdmintype,$frdt,$todt,$compid,$payment_date);
    	}
    }
 $i++;
 }

 if(count($empid)==$i){
    echo "<script type='text/javascript'>window.location.href='/leave-encashment';</script>";
 }
?>