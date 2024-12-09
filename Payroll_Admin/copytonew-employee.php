<?php
//ob_start();
session_start();
error_reporting(0);
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');
$comp_id=$_SESSION['comp_id'];
$editempid =$_POST['editempid'];
$result = $payrollAdmin->CopyToNewEmployee($editempid);
echo "Record Inserted Successfully.";
//ob_end_clean();
?>

