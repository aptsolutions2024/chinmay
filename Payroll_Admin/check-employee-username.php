<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$doc_path = $_SERVER['DOCUMENT_ROOT'];
include_once($doc_path.'/Payroll/lib/class/payroll_admin.php');
$payrollAdmin = new payrollAdmin();

$username=$_REQUEST['username'];
if($_REQUEST['username']){
   $empdetails=$payrollAdmin->checkEmployeeusername($username);
   echo $empdetails;
}else{
    echo 'Enter Username..';
}

?>