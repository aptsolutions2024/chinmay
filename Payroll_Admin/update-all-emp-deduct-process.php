<?php
session_start();
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

if($_SESSION['log_type']==2)
{
    
}else
{
    echo "<script>window.location.href='/payroll-logout';</script>";exit();
}

$emp_de_id=$_REQUEST['emp_de_id'];
$texta=$_REQUEST['texta'];

$textc=$_REQUEST['textc'];
$caltype=$_REQUEST['caltype'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
//print_r($_REQUEST);
$rows=$payrollAdmin->updateAllempeduct($emp_de_id,$texta,$caltype,$textc,$comp_id,$user_id);
 
if ($rows) {
    echo json_encode(['status' => 'success', 'emp_de_id' => $emp_de_id]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update deduct.']);
}?>

