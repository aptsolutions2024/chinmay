<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

  $empid = addslashes($_REQUEST['empid']);
  $decaltype = addslashes($_REQUEST['decaltype']);
  $destdamt = addslashes($_REQUEST['destdamt']);
  $destdremark= addslashes($_REQUEST['destdremark']);
  $destid= addslashes($_REQUEST['destid']);
  $selbank= addslashes($_REQUEST['selbank']);
  $comp_id=$_SESSION['comp_id'];
  $user_id=$_SESSION['log_id'];

$result = $payrollAdmin->insertEmployeeeduct($empid,$decaltype,$destdamt,$destid, $destdremark,$comp_id,$user_id,$selbank);
?>

