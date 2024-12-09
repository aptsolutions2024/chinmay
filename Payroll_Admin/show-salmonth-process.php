<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');
$payrollAdmin = new payrollAdmin();

// Debugging: Output the contents of the $_POST array
// print_r($_POST);

// Retrieve form inputs
$client = $_POST['client'] ?? null;
$date = $_POST['date'] ?? null;
$yes_no = $_POST['yes_no'] ?? null;
$clientGroup = $_POST['clientGroup'] ?? null;

// Validate inputs
if ((!$client && !$clientGroup) || !$date || !$yes_no) {
    die("All fields are required.");
}

// Prepare data for insertion
$created_by = $_SESSION['user_id'] ?? null; // Assuming user ID is stored in session
$updated_by = $created_by; // Assuming the same user is updating
$sal_month = date('Y-m-01', strtotime($date)); // Convert month input to first day of the month
$created_by = $_SESSION['log_id'];
$flag = ($yes_no === 'Yes') ? 'Y' : 'N';
echo $flag;
if ($clientGroup != '') {  
    echo "!!!!!!!!!!!!!!!";
    $result = $payrollAdmin->insertShowSalmonthCgroup($clientGroup, $sal_month, $created_by, $updated_by, $flag);

} else {
    
   
    $result = $payrollAdmin->insertShowSalmonth($client, $sal_month, $created_by, $updated_by, $flag);

    
    if ($result) {
        echo "Record inserted successfully!";
    } else {
        echo "Error inserting record.";
    }
}


if ($result) {
    echo "<script>
        alert('Data added successfully!');
        window.location.href = '/show-salmonth';
    </script>";
    exit(); // Terminate the script to ensure no further code is executed
} else {
    echo "Error inserting record.";
}
?>
