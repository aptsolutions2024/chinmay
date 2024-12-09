<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(0);

$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_emp.php');

// Retrieve the client_id from the session
$client_id = $_SESSION['clientid'] ?? null;
//$data = json_decode(file_get_contents('php://input'), true);
//$frdt = $_POST['frdt'];
// Format the date to YYYY-MM-DD
$frdt = date('Y-m-d', strtotime($_POST['frdt'] ?? null));
$todt = date('Y-m-t', strtotime($_POST['todt'] ?? null));
$_SESSION['from_date'] = $frdt;
$_SESSION['to_date'] = $todt;
// Check if the client_id and from_date are valid
if ($client_id && $frdt) {
    // Check if the date is present in the show_salmonth table
    $isDatePresent = $payrollEmp->checkDateExistsInShowSalmonth($client_id, $frdt);
    if (!$isDatePresent) {
        // Indicate the date is not present
        echo json_encode(['flag' => 'date_not_present']);
        exit; // Stop script execution after sending response
    }else{
        // Check the flag status based on client_id and from_date
        $result = $payrollEmp->getClientFlagStatus($client_id, $frdt);
        
        if ($result && $result['flag'] == 'N') {
            // Not visible, respond with an error
            echo json_encode(['flag' => 'N']);
        } else {
           echo json_encode(['flag' => 'Y']);
        }
    }
} else {
    // Invalid input
    echo json_encode(['flag' => 'error']);
}
?>
