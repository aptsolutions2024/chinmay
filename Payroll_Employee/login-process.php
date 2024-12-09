<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(0);

// Define document path
$doc_path = $_SERVER["DOCUMENT_ROOT"];
// Include the payroll employee class
include_once($doc_path . '/lib/class/payroll_emp.php');

// Create a new payroll employee instance
$payrollEmp = new payrollEmp();

// Retrieve and sanitize input
$user_name = addslashes($_REQUEST['username']);
$pass = addslashes($_REQUEST['password']);
$result_logins = $payrollEmp->login($user_name, $pass);
// print_r($result_logins);
$total = $result_logins[1];

// Debugging: Print $total

if ($total == 1) {
    $result_login = $result_logins[0];
    $role = $result_login['role']; // Get the user's role
    
    // Debugging: Print role
   // $emp_login_id=$result_login['emp_id'];
    
    $_SESSION['log_id'] = $result_login['emp_id'];
    $_SESSION['clientid'] = $result_login['clientid'];
    $_SESSION['log_type'] = $result_login['role'];
    
    
    $_SESSION['log_id']=$result_login['emp_id'];
   $_SESSION['log_type']='5'; 
    $_SESSION['fname']=$result_login['first_name']." ".$result_login['middlet_name']." ".$result_login['last_name'];
    $_SESSION['comp_id']=$result_login['comp_id'];
    $_SESSION['emp_login_id']=$result_login['emp_id'];
  
   
    // Check the user's role
    if ($role == 5) {
      
        // echo "Redirecting to /employee-home<br>";
        echo "<script>window.location.href='/employee-home';</script>";exit();
    } else {
      
        $_SESSION['error_code'] = '0014';
        echo "Redirecting to /Emp-payroll<br>";
        echo "<script>window.location.href='/Emp-payroll';</script>";exit;
    }
    exit();
} else {
    $_SESSION['error_code'] = '0014';
    // echo "Redirecting to /Emp-payroll<br>";
    // echo "<script>window.location.href='/Emp-payroll';</script>";
    exit();
}
?>
