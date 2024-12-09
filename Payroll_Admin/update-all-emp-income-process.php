<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

if($_SESSION['log_type']==2)
{
    
}else
{
    echo "<script>window.location.href='/payroll-logout';</script>";exit();
}
$emp_ic_id=$_REQUEST['emp_ic_id'];
$texta=$_REQUEST['textaincome'];

$textc=$_REQUEST['textcincome'];
$caltype=$_REQUEST['caltype'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
 $rows=$payrollAdmin->updateAllempincome($emp_ic_id,$texta,$caltype,$textc,$comp_id,$user_id);
if ($rows) {
    echo json_encode(['status' => 'success', 'emp_ic_id' => $emp_ic_id]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update income.']);
}?>

