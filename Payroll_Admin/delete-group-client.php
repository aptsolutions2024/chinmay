<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1); 
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

$payrollAdmin = new payrollAdmin();

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $result = $payrollAdmin->deleteGroupClient($id);
    echo $result; 
} else {
    echo "ID not set"; 
}
?>
