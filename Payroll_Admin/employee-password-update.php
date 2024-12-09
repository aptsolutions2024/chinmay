<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$doc_path = $_SERVER['DOCUMENT_ROOT'];
include_once($doc_path.'/Payroll/lib/class/payroll_admin.php');
$payrollAdmin = new payrollAdmin();

$password=$_REQUEST['password'];
if($_REQUEST['emp_id'] && $_REQUEST['password']){
   $emp_id=base64_decode($_REQUEST['emp_id']);
   $empdetails=$payrollAdmin->updateempPasswordbyId($emp_id,$password);
   echo $empdetails;
}else{
    echo '<br><div class="error_class">Employee Not found.</div>';
}
//print_r($_REQUEST);exit;

//$empdetails=$payrollAdmin->checkPasscodeMobInEmp($passcode,$mobile_no);

?>