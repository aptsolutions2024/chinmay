<?php
session_start();
echo "1111111111";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

$payrollAdmin = new payrollAdmin();

// Sanitize input
$group_name = addslashes(strtoupper($_REQUEST['group_name']));
$esicode = addslashes($_REQUEST['esicode']);
$pfcode = addslashes($_REQUEST['pfcode']);
$created_by = $_SESSION['log_id']; // Assuming 'log_id' holds the ID of the user creating the entry
echo "1111111111";
// Insert the data into the database
$result = $payrollAdmin->insertClientGroup($group_name, $esicode, $pfcode, $created_by);

// Check if the insertion was successful
if ($result) {
    echo "Record inserted successfully.......";
} else {
    echo "Error inserting record.....";
}
?>
