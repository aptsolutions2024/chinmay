<?php

session_start();
error_reporting(0);
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

 $id = addslashes($_REQUEST['id']);
  $empid = addslashes($_REQUEST['empid']);
  $caltype = addslashes($_REQUEST['caltype']);
  $stdamt = addslashes($_REQUEST['stdamt']);
$incomeid = addslashes($_REQUEST['incomeid']);
$inremark = addslashes($_REQUEST['inremark']);
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
if($id!='') {
   echo $result = $payrollAdmin->updateEmployeeincome($id, $caltype, $stdamt,$incomeid,$inremark,$comp_id,$user_id);

}
else{

    $result = $payrollAdmin->insertEmployeeincome($empid,$caltype,$stdamt,$incomeid,$inremark,$comp_id,$user_id);
}
?>

