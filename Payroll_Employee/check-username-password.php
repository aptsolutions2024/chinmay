<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"] . '/include_payroll_emp.php');



$username = isset($_GET['username']) ? $_GET['username'] : '';
$password = isset($_GET['userpass']) ? $_GET['userpass'] : '';

if ($username && $password) {
    $empdetails = $payrollEmp->checkempUnamepass($username, $password);

    if ($empdetails === 'success') {
        echo 'success';
    } else {
        echo 'failure';
    }
} else {
    echo 'error'; // For cases where username or password is not provided
}
?>
