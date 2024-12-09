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
$group_name = addslashes(strtoupper($_POST['group_name']));
$esicode = addslashes($_POST['esicode']);
$pfcode = addslashes($_POST['pfcode']);
$lwf_no = addslashes($_POST['lwf_no']);
$id = intval($_POST['editid']); // Ensure ID is passed from the form
$updated_by = $_SESSION['log_id']; // Assuming 'log_id' holds the ID of the user updating the entry


// Update the client group in the database
$result = $payrollAdmin->updateClientGroup($id, $group_name, $esicode, $pfcode, $updated_by,$lwf_no);

// Ensure the result is an array
if (is_array($result)) {
    echo json_encode($result);
} else {
    echo json_encode(['success' => false, 'message' => 'Unknown error occurred.']);
}
?>
