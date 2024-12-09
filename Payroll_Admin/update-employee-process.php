<?php

$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

if($_SESSION['log_type']==2)
{
    
}else
{
    echo "<script>window.location.href='/payroll-logout';</script>";exit();
}
  $id = $_REQUEST['id'];
$fname=addslashes(strtoupper($_REQUEST['fname']));
$mname=addslashes(strtoupper($_REQUEST['mname']));
$lname=addslashes(strtoupper($_REQUEST['lname']));
if($_REQUEST['lodate']!=''){
	$lodate=date("Y-m-d", strtotime($_REQUEST['lodate']));
}
else{
	$lodate='';
	}
if($_REQUEST['incdate']!=''){
$incdate=date("Y-m-d", strtotime($_REQUEST['incdate']));
}
else{
	$incdate='';
	}
if($_REQUEST['perdate']!=''){	
$perdate=date("Y-m-d", strtotime($_REQUEST['perdate']));
}
else{
	$perdate='';
	}
if($_REQUEST['pfdate']!=''){
$pfdate=date("Y-m-d", strtotime($_REQUEST['pfdate']));
}
else{
	$pfdate='';
	}
$client=addslashes($_REQUEST['client']);
$uname=addslashes($_REQUEST['uname']);
$password=addslashes($_REQUEST['password']);
$design=addslashes($_REQUEST['design']);
$depart=addslashes($_REQUEST['depart']);
$category=addslashes($_REQUEST['category']);

$qualifi=addslashes($_REQUEST['qualifi']);
$bank=addslashes($_REQUEST['bank'] );
$location=addslashes($_REQUEST['location']);
$bankacno=addslashes($_REQUEST['bankacno']);
$paycid=addslashes($_REQUEST['paycid']);
$esistatus=addslashes($_REQUEST['esistatus']);
$namerel=addslashes(strtoupper($_REQUEST['namerel']));
$prnsrno=addslashes($_REQUEST['prnsrno']);
$esicode=addslashes($_REQUEST['esicode']);
$pfcode=addslashes($_REQUEST['pfcode']);

$adhaar=addslashes($_REQUEST['adhaar']);
$drilno=addslashes($_REQUEST['drilno']);
$uan=addslashes($_REQUEST['uan']);
$votid=addslashes($_REQUEST['votid']);
$jobstatus=addslashes($_REQUEST['jobstatus']);
$gentype=addslashes($_REQUEST['gentype']);
 $bdate=date("Y-m-d", strtotime($_REQUEST['bdate']));
$joindate=date("Y-m-d", strtotime($_REQUEST['joindate']));
$add1=addslashes($_REQUEST['add1']);
$panno=addslashes($_REQUEST['panno']);
$emailtext=addslashes($_REQUEST['emailtext']);
$phone=addslashes($_REQUEST['phone']);
$lwf_no=addslashes($_REQUEST['lwf_no']);

if($_REQUEST['duedate']!='' && date("Y-m-d", strtotime($_REQUEST['duedate'])) != "1970-01-01" ){
$duedate=date("Y-m-d", strtotime($_REQUEST['duedate']));
}
else{
	$duedate='';
	}
//$duedate=date("Y-m-d", strtotime($_REQUEST['duedate']));
$ticket_no=addslashes($_REQUEST['ticket_no']);
$comp_ticket_no=addslashes($_REQUEST['comp_ticket_no']);
$married_status=addslashes($_REQUEST['married_status']);
$pay_mode=addslashes($_REQUEST['pay_mode']);
$pin_code=addslashes($_REQUEST['pin_code']);
$handicap=addslashes($_REQUEST['handicap']);
$nation=addslashes(strtoupper($_REQUEST['nation']));
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$qualiDetails = $payrollAdmin->displayQualification($qualifi);
$qualification=$qualiDetails['mast_qualif_name'];
 $deptDetails = $payrollAdmin->displayDepartment($depart);
  $deptDetails = $payrollAdmin->displayCategory($depart);

 $department=$deptDetails['mast_dept_name'];
  $department=$deptDetails['category_id'];
echo $result = $payrollAdmin->updateEmployee($id, $fname, $mname, $lname, $uname, $password, $gentype, $bdate, $joindate, $lodate, $incdate, $add1, $panno, $perdate, $pfdate, $client, $design, $depart, $category, $qualifi, $bank, $location, $bankacno, $paycid, $esistatus, $namerel, $prnsrno, $esicode, $pfcode, $adhaar, $drilno, $uan, $votid, $jobstatus, $emailtext, $phone, $duedate, $ticket_no, $comp_ticket_no, $married_status, $pay_mode, $pin_code, $handicap, $nation, $comp_id, $user_id, $qualification, $department,$lwf_no);
exit;
?>

