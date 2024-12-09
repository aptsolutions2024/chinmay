<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$doc_path = $_SERVER['DOCUMENT_ROOT'];
include_once($doc_path.'/Payroll/lib/class/payroll_admin.php');
$payrollAdmin = new payrollAdmin();

$username=$_REQUEST['username'];
$userpass=$_REQUEST['userpass'];
$newuserpass=$_REQUEST['newuserpass'];

if($_REQUEST['username'] && $_REQUEST['userpass'] && $_REQUEST['newuserpass']){
 
   $empdetails=$payrollAdmin->updateempPwdbyunamepass($username,$userpass,$newuserpass);
   echo $empdetails;
}else{
    echo 'Invalid Usename/Password....';
}


?>