<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

error_reporting(0);
ob_end_clean();
// Fetch and convert inputs to uppercase
$name = strtoupper(addslashes($_REQUEST['name']));
$add1 = strtoupper(addslashes($_REQUEST['add1']));
$esicode = strtoupper(addslashes($_REQUEST['esicode']));
$pfcode = strtoupper(addslashes($_REQUEST['pfcode']));
$tanno = strtoupper(addslashes($_REQUEST['tanno']));
$panno = strtoupper(addslashes($_REQUEST['panno']));
$gstno = strtoupper(addslashes($_REQUEST['gstno']));
$lwf_no = strtoupper(addslashes($_REQUEST['lwf_no']));
//echo $lwf_bo;exit;
$sc = strtoupper(addslashes($_REQUEST['sc']));
$email = strtoupper($_REQUEST['email']); // Ensure email is also uppercase if required
$mont = date("Y-m-d", strtotime($_REQUEST['cm'])); // Assuming `cm` is in `MM-YYYY` format
if (isset($_REQUEST['daywise_details'])) {
    $daywise_details = $_REQUEST['daywise_details'];
} else {
    $daywise_details = "Not Set"; // Debugging fallback
}


// Handle parent value
$parent = !empty($_REQUEST['parent']) ? strtoupper(addslashes($_REQUEST['parent'])) : '';

$comp_id = $_SESSION['comp_id'];
$user_id = $_SESSION['log_id'];

// Insert the client with uppercase values
$result = $payrollAdmin->insertClient($name, $add1, $esicode, $pfcode, $tanno, $panno, $gstno, $mont, $parent, $comp_id, $user_id, $sc, $email,$daywise_details,$lwf_no);

if($result){
  echo "Record Inserted Successfully";  
}else{
     echo "Record Insert Failure."; 
}
?>
