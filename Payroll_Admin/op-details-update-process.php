<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');
error_reporting(0);
$id = $_POST['id'];

$amount=addslashes($_POST['amount']);
$result = $payrollAdmin->updateOtherPaymentDetails($id,$amount);
if($result){
   echo 'Record Successfully Updated'; 
}else{
    echo 'Error While Updating Record';
}
?>

