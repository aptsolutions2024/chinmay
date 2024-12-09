<?php
$doc_path=$_SERVER["DOCUMENT_ROOT"];
include ($doc_path.'/include_payroll_admin.php');
// Check if the request is to generate a username
if (isset($_POST['action']) && $_POST['action'] == 'generateUsername') {
    $first_Name = $_POST['fname'];
    $username = $payrollAdmin->generateUsername($first_Name);
    echo $username; // Output the generated username
}

// Check if the request is to generate a password
if (isset($_POST['action']) && $_POST['action'] == 'generatePassword') {
    $last_Name = $_POST['lname'];
    $password = $payrollAdmin->generatePassword($last_Name);
    echo $password; // Output the generated password
}
?>
