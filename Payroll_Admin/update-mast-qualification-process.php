<?php
error_reporting(0);
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');
$name = addslashes(strtoupper($_REQUEST['name']));
$id = addslashes($_REQUEST['id']);
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
echo $result = $payrollAdmin->updateQualification($id,$name,$comp_id,$user_id);
?>

