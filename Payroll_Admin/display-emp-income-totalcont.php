<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

if($_SESSION['log_type']==2)
{
    
}else
{
    echo "<script>window.location.href='/payroll-logout';</script>";exit();
}

$id = $_REQUEST['id'];

$row = $payrollAdmin->getEmpIncome($id);
echo $row['total'];
?>