<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// include the required payroll_admin class
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include_once($doc_path . '/lib/class/payroll_admin.php');

$payrollAdmin = new payrollAdmin();

// Get form inputs
$user = addslashes($_REQUEST['username']);
$old_pass = addslashes($_REQUEST['old_password']);
$new_pass = addslashes($_REQUEST['new_password']);

echo $user . " , " . $old_pass . " , " . $new_pass; // Debugging

// Check if the username exists
$userData = $payrollAdmin->checkUsernameExists($user);

if ($userData === false) {
    $_SESSION['error'] = "Username is incorrect.";
    header("Location: /view-change-password"); // Redirect back to the form
    exit;
}

// If username exists, check the password
$passwordCheck = $payrollAdmin->checkPassword($user, $old_pass);

if ($passwordCheck === false) {
    $_SESSION['error'] = "Password is incorrect.";
    header("Location: /view-change-password"); // Redirect back to the form
    exit;
} else {
    // Proceed with password change
    $changePass = $payrollAdmin->changPassword($user, $new_pass);
    if ($changePass) {
        $_SESSION['message'] = "Password changed successfully.";
    } else {
        $_SESSION['error'] = "Failed to change password.";
    }
    header("Location: /view-change-password"); // Redirect back to the form
    exit;
}

exit;
?>
