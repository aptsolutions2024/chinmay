<?php

$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');
$comp_id=$_SESSION['comp_id'];


$fildt = explode('#',$_POST['otherid']);

$empid = $_POST['empid'];
 $fldv = $_POST[$fildt[1]];


if($fildt[1]!='mast_bank'){
$i=0;

foreach($empid as $emp){
$payrollAdmin->updateEmpOtherData($fildt[0],$fldv[$i],$emp,$comp_id);
  $i++;  
}
}
else
{
    $bank_no = $_POST['bank_no'];
   $i=0;

foreach($empid as $emp){
$payrollAdmin->updateBankEmpOtherData($fildt[0],$fldv[$i],$bank_no[$i],$emp,$comp_id);
  $i++;  
} 
}
echo "<script>window.location.href='/edit-all-employee';</script>";exit();

?>