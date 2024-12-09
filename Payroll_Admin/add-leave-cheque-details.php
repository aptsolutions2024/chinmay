<?php
$doc_path=$_SERVER["DOCUMENT_ROOT"];
include ($doc_path.'/include_payroll_admin.php');

$empid = $_REQUEST['emp_id'];
$chkdate = $_REQUEST['chkdate'];
 $chkdate = date('Y-m-d',strtotime($chkdate));
$amount = $_REQUEST['amount'];
$check_no = $_REQUEST['check_no'];
$date1 = $_REQUEST['date'];

$i=0;
$curmonth = date('m');
$curyear = date('Y');
//$cmonth = $_REQUEST['$cmonth'];
$payment_date = $_REQUEST['payment_date'];




$clientid = $_SESSION['clintid'];
$resclt=$payrollAdmin->displayClient($clientid);
$cmonth=$resclt['current_month'];
//print_r($_REQUEST);
$i=0;
	foreach($empid as $emp){
		$num = $payrollAdmin->chkLeaveChequeRowDetails($emp,$payment_date,'L');
		if($num == 0){
			$payrollAdmin->insertLeaveCheckDetail($emp,$check_no[$i],$payment_date,$amount[$i],date('Y-m-d',strtotime($date1[$i])),'L');
		}else{			
			$payrollAdmin->updateLeaveCheckDetail($emp,$check_no[$i],$payment_date,$amount[$i],date('Y-m-d',strtotime($date1[$i])),'L');		   
		}
		
		$i++;
	}

?>