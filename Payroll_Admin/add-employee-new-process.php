<?php
session_start();
error_reporting(1);


$doc_path=$_SERVER["DOCUMENT_ROOT"];
include ($doc_path.'/include_payroll_admin.php');

$fname=addslashes(strtoupper($_REQUEST['fname']));
$mname=addslashes(strtoupper($_REQUEST['mname']));
$lname=addslashes(strtoupper($_REQUEST['lname']));

$uname = trim($_REQUEST['uname']);
$password = trim($_REQUEST['password']);

$client=addslashes($_REQUEST['client']);
$add1=addslashes($_REQUEST['add1']);
$pin_code=addslashes($_REQUEST['pin_code']);
 $gender = $_REQUEST['gender'];  // Assuming gender is passed from form
$esistatus = $_REQUEST['esistatus'];  // Assuming ESI status is passed from form
$joindate = $_REQUEST['joindate'];  // Assuming join date is passed from form
$lwf_no = $_REQUEST['lwf_no'];
// print_r($_REQUEST);exit;
//echo $lwf_no;
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$role=5;
 $qualiDetails = $payrollAdmin->displayQualification($qualifi);
 $qualification=$qualiDetails['mast_qualif_name'];
 //echo $result = $payrollAdmin->insertEmployee($fname,$mname,$lname,$gentype,$bdate,$joindate,$lodate,$incdate,$add1,$panno,$perdate,$pfdate,$client,$design,$depart,$qualifi,$bank,$location,$bankacno,$paycid,$esistatus,$namerel,$prnsrno,$esicode,$pfcode,$adhaar,$drilno,$uan,$votid,$jobstatus,$email,$phoneno,$duedate,$ticket_no,$comp_ticket_no,$married_status,$pay_mode,$pin_code,$handicap,$nation,$comp_id,$user_id,$qualification,$department);

 echo $result = $payrollAdmin->insertEmployeeNew($fname,$mname,$lname,$uname,$password,$add1,$client,$pin_code,$comp_id,$user_id,$role,$gender,$esistatus,$joindate,$lwf_no);
 

 ?>

