<?php

$doc_path=$_SERVER["DOCUMENT_ROOT"];
include ($doc_path.'/include_payroll_admin.php');
$payrollAdmin = new payrollAdmin();
$name = addslashes(strtoupper($_REQUEST['name']));
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
ob_end_clean();
$result = $payrollAdmin->insertDepartment($name,$comp_id,$user_id);
if($result){
  echo "Record Inserted Successfully";  
}else{
     echo "Record Insert Failure."; 
}
?>

