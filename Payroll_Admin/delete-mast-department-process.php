<?php
session_start();
error_reporting(E_ALL);
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');
$payrollAdmin = new payrollAdmin();
  $did = $_REQUEST['did'];
  echo $result = $payrollAdmin->deleteDepartment($did);
?>

