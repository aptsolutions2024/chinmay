<?php
session_start();
error_reporting(E_ALL);
include($_SERVER["DOCUMENT_ROOT"] . '/include_payroll_admin.php');

// Retrieve and sanitize input
$uname = isset($_POST['uname']) ? trim($_POST['uname']) : '';
$emp_id = isset($_POST['emp_id']) ? intval($_POST['emp_id']) : 0;
echo $uname;
echo $emp_id;
// Check if the username exists for other users
if ($payrollAdmin->isUsernameExistsForOtherUser($uname, $emp_id)) {
    echo 'Username already exists. Please choose another.';
} else {
    echo 'Username is unique.';
}
?>
