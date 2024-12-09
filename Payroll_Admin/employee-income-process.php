<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');
//echo "<pre>";print_r($_REQUEST);die;
  $empid = addslashes($_REQUEST['empid']);
  $caltype = addslashes($_REQUEST['caltype']);
  $stdamt = addslashes($_REQUEST['stdamt']);
  $incomeid = addslashes($_REQUEST['incomeid']);
  $inremark = addslashes($_REQUEST['inremark']);
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$result = $payrollAdmin->insertEmployeeincome($empid,$caltype,$stdamt,$incomeid,$inremark,$comp_id,$user_id);
?>

