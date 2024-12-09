<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');
$payrollAdmin = new payrollAdmin();
$name = addslashes(strtoupper($_REQUEST['name']));
$did = addslashes($_REQUEST['did']);
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
echo $result = $payrollAdmin->updateDepartment($did,$name,$comp_id,$user_id);
?>

