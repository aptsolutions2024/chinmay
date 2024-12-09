<?php
ob_start();
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$setExcelName = "employee_detail";
$client_id = $_SESSION['clientid'];
$head = $payrollAdmin->blankExportTranDays($comp_id,$client_id);
$setCounter=count($head[1]);
$setMainHeader = "Client_id \tClient_name\tSal_month\t Emp_id\tEmployee_NAME\t";
$setData = "";
$cnt=count($head[0]);
for ($i = 0; $i < $cnt; $i++) {
    $setMainHeader .= $head[0][$i] . "\t";
}
$setMainHeader .="ticket_no\t Dept_Name\t comp_ticket_no\t";

foreach ($head[1] as $rec) {
    $rowLine = '';
    foreach ($rec as $value) {
        if (!isset($value) || $value == "") {
            $value = "\t";
        } else {
            $value = strip_tags(str_replace('"', '""', $value));
            $value = '"' . $value . '"' . "\t";
        }
        $rowLine .= $value;
    }
    $setData .= trim($rowLine) . "\n";
}
    $setData = str_replace("\r", "", $setData);
if ($setData == "") {
    $setData = "\nno matching records found";
}else{
    if ($setData == "") {
        $setData = "\nno matching records found";
    }
}
ob_clean();
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=" . $setExcelName . ".xls");
header("Content-Type: application/ms-excel");
header("Pragma: no-cache");
header("Expires: 0");
echo $setMainHeader."\n".$setData;
?>