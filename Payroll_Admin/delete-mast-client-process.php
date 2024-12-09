<?php
session_start();
error_reporting(0);
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');
$payrollAdmin = new payrollAdmin();
  $cid = addslashes($_REQUEST['cid']);
  $result = $payrollAdmin->deleteClient($cid);
?>

