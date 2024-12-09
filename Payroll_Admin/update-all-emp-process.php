<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

if($_SESSION['log_type']==2)
{
    
}else
{
    echo "<script>window.location.href='/payroll-logout';</script>";exit();
}
//print_r($_REQUEST['empid']);
$fielda=$_REQUEST['fielda'];
$fieldb=$_REQUEST['fieldb'];
$fieldc=$_REQUEST['fieldc'];
$fieldd=$_REQUEST['fieldd'];
$empid=$_REQUEST['empid'];
$texta=$_REQUEST['texta'];
$textb=$_REQUEST['textb'];
$textc=$_REQUEST['textc'];
$textd=$_REQUEST['textd'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$rows=$payrollAdmin->updateAllemp($empid,$fielda,$fieldb,$fieldc,$fieldd,$texta,$textb,$textc,$textd,$comp_id,$user_id);
echo "<script>window.location.href='/edit-all-employee';</script>";exit();
?>

