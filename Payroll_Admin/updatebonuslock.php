<?php
session_start();
error_reporting(0);
echo "!!!";
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

$client_id = $_REQUEST['client'];
$result = $payrollAdmin->updateBonusLock($client_id,$_SESSION['startbonusyear'],$_SESSION['endbonusyear']);
if ($result>0)
{
    echo "Data locked successfully!!!";
}
?>

