<?php
session_start();
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

$payrollAdmin = new payrollAdmin();

// Retrieve and sanitize input
$group_name = strtoupper(trim($_POST['group_name']));
$esicode = trim($_POST['esicode']);
$pfcode = trim($_POST['pfcode']);
$id = intval($_POST['editid']); // Ensure ID is passed from the form
$updated_by = $_SESSION['log_id']; // Assuming 'log_id' holds the ID of the user updating the entry

// Log the input data for debugging
error_log("Received data - ID: $id, Group Name: $group_name, ESI Code: $esicode, PF Code: $pfcode");

// Update the client group in the database
$result = $payrollAdmin->updateClientGroup($id, $group_name, $esicode, $pfcode, $updated_by);

// Ensure the result is an array
if (is_array($result)) {
    echo json_encode($result);
} else {
    echo json_encode(['success' => false, 'message' => 'Unknown error occurred.']);
}
?>
