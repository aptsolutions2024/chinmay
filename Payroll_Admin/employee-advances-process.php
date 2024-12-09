<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

  $empid = addslashes($_REQUEST['empid']);
  $advamt = addslashes($_REQUEST['advamt']);
  $advins = addslashes($_REQUEST['advins']);
if($_REQUEST['advdate']!='') {
    $advdate = date("Y-m-d", strtotime($_REQUEST['advdate']));
}
else{
    $advdate=addslashes($_REQUEST['advdate']);
}

  $advtype = addslashes($_REQUEST['advtype']);
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];


$result = $payrollAdmin->insertEmployeeadvances($empid,$advamt,$advins,$comp_id,$user_id,$advdate,$advtype);
?>

