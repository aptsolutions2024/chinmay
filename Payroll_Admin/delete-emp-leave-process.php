<?php
session_start();
error_reporting(0);
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');
  $id = addslashes($_REQUEST['id']);
  $result = $payrollAdmin->deleteEmpleave($id);
?>

