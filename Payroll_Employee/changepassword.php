<?php 
session_start();
ini_set('session.gc_maxlifetime', 3600);
ini_set('session.cookie_lifetime', 3600);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Define document path and include necessary files
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include_once($doc_path . '/lib/class/payroll_emp.php');

// Initialize the payrollEmp object
$payrollEmp = new payrollEmp();


    $username = htmlspecialchars($_POST['uname']);
    $oldpass = htmlspecialchars($_POST['oldpass']);
    $newpass = htmlspecialchars($_POST['newpass']);

  // Get form inputs
$user = addslashes($_POST['uname']);
$old_pass = addslashes($_POST['oldpass']);
$new_pass = addslashes($_POST['newpass']);

echo $user . " , " . $old_pass . " , " . $new_pass; // Debugging

// Check if the username exists
$userData = $payrollEmp->checkUsernameExists($user);
// print_r($userData);exit;
if ($userData === false) {
    $_SESSION['error'] = "Username is incorrect.";
    header("Location: /emp-view-change-password"); // Redirect back to the form
    exit;
}

// If username exists, check the password
$passwordCheck = $payrollEmp->checkPassword($user, $old_pass);

if ($passwordCheck === false) {
    $_SESSION['error'] = "Old Password is incorrect.";
    header("Location: /emp-view-change-password"); // Redirect back to the form
    exit;
} else {
    // Proceed with password change
    $changePass = $payrollEmp->changPassword($user, $new_pass);
    if ($changePass) {
        $_SESSION['message'] = "Password changed successfully.";
    } else {
        $_SESSION['error'] = "Failed to change password.";
    }
    header("Location: /emp-view-change-password"); // Redirect back to the form
    exit;
}

exit;
?>
