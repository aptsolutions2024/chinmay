<?php
session_start();
ob_start();
error_reporting(0);
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

$comp_id = $_SESSION['comp_id'];
$user_id = $_SESSION['log_id'];
$clintid = $_SESSION['clintid'];
$client = $_REQUEST['client'];
$startyear = date('Y-m-d', strtotime($_SESSION['startbonusyear']));
$endyear = date('Y-m-d', strtotime($_SESSION['endbonusyear']));
$setExcelName = "bonus_detail";
$check_ex_amt = $payrollAdmin->getExgratiaAmount($client, $startyear, $endyear);
$setCounter = $payrollAdmin->exportEmpData($client, $startyear, $endyear, $check_ex_amt['exgratia']);
$setRec = $payrollAdmin->exportEmployeeData($client, $startyear, $endyear);
$sethed = array_keys($setRec[0]);
$setMainHeader = "Srno\t";
$setData = "";
for ($i = 0; $i < $setCounter; $i++) {
    $setMainHeader .= $sethed[$i] . "\t";
}
$srno = 1;
foreach ($setRec as $rec) {
    $rowLine = $srno . "\t";
    $srno++;
    $columnIndex = 0;

    foreach ($rec as $key => $value) {
        if ($columnIndex >= $setCounter) {
            break;
        }

        // Special case for bank account number
        if ($key == 'bankacno') {
            $value = '\'' . $value;
        }

        if (!isset($value) || $value == "") {
            $value = "\t"; // Empty cell
        } else {
            $value = strip_tags(str_replace('"', '""', $value));
            $value = '"' . $value . '"' . "\t";
        }

        $rowLine .= $value;
        $columnIndex++;
    }
    $setData .= trim($rowLine) . "\n";
}

$setData = str_replace("\r", "", $setData);

if ($setData == "") {
    $setData = "\nno matching records found\n";
}

// Output the file headers and data
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=" . $setExcelName . ".xls");
header("Pragma: no-cache");
header("Expires: 0");

// Flush and clean the buffer before outputting
ob_end_clean();

echo ucwords(trim($setMainHeader)) . "\n" . trim($setData) . "\n";
?>

