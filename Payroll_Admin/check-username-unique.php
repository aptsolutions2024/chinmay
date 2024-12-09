<?php
session_start();
//error_reporting(E_ALL); // Capture all errors

$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

// Retrieve and sanitize input
$uname = isset($_POST['uname']) ? trim($_POST['uname']) : '';

// Check if the username exists
if ($payrollAdmin->isUsernameExists($uname)>0) {
    echo 'Username already exists';
} else {
    echo 'Username is unique.';
}
?>
