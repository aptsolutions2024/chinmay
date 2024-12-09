<?php
session_start();
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(0);
//print_r($_POST);die;

//error_reporting(0);
//include_once('../source/lib/class/payroll_admin.php');
  $doc_path=$_SERVER["DOCUMENT_ROOT"];
include_once($doc_path.'/lib/class/payroll_admin.php');


$payrollAdmin = new payrollAdmin();
//echo "1111111111111";

  $user = addslashes($_REQUEST['username']);
  $pass = addslashes($_REQUEST['password']);
$result_logins = $payrollAdmin->login($user,$pass);
$total=$result_logins[1];


if($total==1){
    $result_login=$result_logins[0];
    $_SESSION['log_id']=$result_login['log_id'];
    $_SESSION['valid_users']='7,'.$result_login['log_id'];
    
    
    $_SESSION['log_type']=$result_login['login_type'];
    $_SESSION['fname']=$result_login['fname'];
    $_SESSION['comp_id']=$result_login['comp_id'];
    $_SESSION['emp_login_id']=$result_login['emp_id'];
    //added by Shraddha on 21-10-2024
    if($result_login['login_type']){
        $_SESSION['active_emp']="'T','P','C'";
        $_SESSION['inactive_emp']="'L','D'"; 
    }
    if($result_login['login_type']==1){
        header("location:admin/index.php");exit;
    }
    else if($result_login['login_type']!=6){
         echo "<script>window.location.href='/user-home';</script>";exit();
    }else{
          echo "<script>window.location.href='/employee-home';</script>";exit(); 
    }
 
 }else{
       $_SESSION['error_code']='0014';
       echo "<script>window.location.href='/payroll';</script>";exit();
}
	 ?>

