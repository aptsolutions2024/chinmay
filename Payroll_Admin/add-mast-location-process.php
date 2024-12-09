<?php
session_start();
error_reporting(0);
$doc_path=$_SERVER["DOCUMENT_ROOT"];
include ($doc_path.'/include_payroll_admin.php');
$action = $_REQUEST['action'];
$name = addslashes(strtoupper($_REQUEST['name']));
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];

if($action=='Insert')
{
 echo $result = $payrollAdmin->insertLocation($name,$comp_id,$user_id);
}else
{
  $id = addslashes($_REQUEST['id']);
  echo $result = $payrollAdmin->updateLocation($id,$name,$comp_id,$user_id); 
}


?>

