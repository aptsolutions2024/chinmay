<?php
error_reporting(0);
$doc_path=$_SERVER["DOCUMENT_ROOT"];
include ($doc_path.'/include_payroll_admin.php');
$name = addslashes(strtoupper($_REQUEST['name']));
$action = $_REQUEST['action'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
if($action=='Insert')
{
$result = $payrollAdmin->insertOtherPayment($name,$comp_id,$user_id);
}else
{
    $did = addslashes($_REQUEST['did']);
    $result = $payrollAdmin->updateOtherPayment($did,$name);
}
?>

