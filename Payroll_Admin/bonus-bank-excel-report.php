<?php
session_start();
error_reporting(0);
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

$payrollAdmin = new payrollAdmin();

if ($_SESSION['log_type'] != 2) {
    echo "<script>window.location.href='/payroll-logout';</script>";
    exit();
}

$comp_id = $_SESSION['comp_id'];
$user_id = $_SESSION['log_id'];
$month = $_SESSION['month'];
$setExcelName = "employee_detail";
$client_id = $_SESSION['clientid'];

$rowcomp = $payrollAdmin->displayCompany($comp_id);
$comp = $rowcomp['comp_name'];

$clientGrp = $_SESSION['clientGrp'];
$frdt = $_SESSION['frdt'];
$group[] = '';
$resclt = '';
//print_r($_POST);
if ($clientGrp != '') {
    $group = $payrollAdmin->displayClientGroupById($clientGrp);
    $grpClientIds = $payrollAdmin->getGroupClientIds($clientGrp);
    $grpClientIdsOnly = $payrollAdmin->getGroupClientIdsOnly($clientGrp);

    $resclt = $payrollAdmin->displayClient($grpClientIds[0]['mast_client_id']);
    $setExcelName = "bonus-bank-excelGroup_" . $clientGrp;
    $client_id = $grpClientIdsOnly['client_id'];
    $client_name = "Group: " . $group['group_name'];
} else {
    $resclt = $payrollAdmin->displayClient($client_id);
    $setExcelName = "bonus-bank-excel_" . $client_id;
    $client_name = "Client: " . $resclt['client_name'];
}

if ($month == 'current') {
    $frdt = $resclt['current_month'];
} else {
    $frdt = date('Y-m', strtotime($_SESSION['frdt'])) . '-31';
}

$monthtit = date('F Y', strtotime($frdt));
$todt = date('Y-m-', strtotime($frdt)) . '31';

$debitacno = $rowcomp['bankacno'];
$desc = "Salary for " . $monthtit;
$row = $payrollAdmin->bonu_bank_excel($client_id, $frdt);

$setTitleLines = $client_name . "\nSALARY PAYMENT FOR THE MONTH OF " . strtoupper($monthtit) . "\n";

// Set header based on the format submitted
if (isset($_POST['submit_format1'])) {
    $setMainHeader = "Sr No\tA/C No\tC/D\tA/C Type\tName\tAmount"; // Header for Format 1
} elseif (isset($_POST['submit_format2'])) {
    $setMainHeader = "Sr No\tC/D\tAmount\tIFSC Code\tA/C No\tName"; // Header for Format 2
} else {
    $setMainHeader = ""; // for default
}

$setData = "";
$srNo = 1;
$totalAmount = 0;

if (count($row)) {
    foreach ($row as $rec) {
        $netsalary = $rec['tot_bonus_amt'] + $rec['tot_exgratia_amt'];
        if (isset($_POST['submit_format1'])) {
            if (empty($rec['bankacno'])) {
                continue;
            }

            $setData .= $srNo . "\t" . $rec['bankacno'] . "\tC\tSB\t" . $rec['empname'] . "\t" . $netsalary . "\n";
            $totalAmount += $netsalary;
            $setData = str_replace("\r", "", $setData);

        } elseif (isset($_POST['submit_format2'])) {
            if (empty($rec['bankacno'])) {
                continue;
            }

            // Include IFSC code in the output for Format 2
            $setData .= $srNo . "\tC\t" . $netsalary . "\t" . $rec['ifsc_code'] . "\t" . $rec['bankacno'] . "\t" . $rec['empname'] . "\n"; // Adjusted data format for Format 2
            $totalAmount += $netsalary;
            $setData = str_replace("\r", "", $setData);
        }

        $srNo++;
    }

    // Add Total Row for Format 1 and Format 2
    if (isset($_POST['submit_format2'])) {
        $setData .= "\n\tD\t" . $totalAmount . "\t510101000269394\tTotal\t\n"; // Total row for Format 2
    } else {
        // Regular total row for Format 1
        $setData .= "\n\t\t\t\tTotal\t" . $totalAmount . "\n";
    }

} else {
    $setData = "\nNo matching records found\n";
}

// Output the data to an Excel file
ob_end_clean();
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=" . $setExcelName . ".xls");
header("Pragma: no-cache");
header("Expires: 0");

echo $setTitleLines . "\n" . ucwords($setMainHeader) . "\n" . $setData . "\n";
?>
