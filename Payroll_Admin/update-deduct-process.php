<?php
error_reporting(0);
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

  $id = $_REQUEST['id'];
  $decaltype = addslashes($_REQUEST['decaltype']);
  $destdamt= addslashes($_REQUEST['destdamt']);
$empid = addslashes($_REQUEST['empid']);

$destdremark = addslashes($_REQUEST['destdremark']);
$destid = addslashes($_REQUEST['destid']);
$selbank = addslashes($_REQUEST['selbank']);

$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
if($id!='') {
    $result = $payrollAdmin->updateEmployeeeduct($id,$decaltype,$destdamt,$destid, $destdremark,$comp_id,$user_id,$selbank);
}
else{
    $result = $payrollAdmin->insertEmployeeeduct($empid,$decaltype,$destdamt,$destid, $destdremark,$comp_id,$user_id,$selbank);
}
?>

