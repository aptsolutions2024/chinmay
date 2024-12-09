<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

  $empid = addslashes($_REQUEST['empid']);
  $id = addslashes($_REQUEST['id']);
  $advamt = addslashes($_REQUEST['advamt']);
  $advins = addslashes($_REQUEST['advins']);
$advdate = date("Y-m-d", strtotime($_REQUEST['advdate']));
$advtype = addslashes($_REQUEST['advtype']);
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];

      $result = $payrollAdmin->updateEmployeeadvances($id, $advamt, $advins,$comp_id,$user_id,$advdate,$advtype);
 
?>

