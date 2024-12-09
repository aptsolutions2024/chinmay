<?php
//print_r($_REQUEST);exit;
session_start();
$doc_path=$_SERVER["DOCUMENT_ROOT"];
include ($doc_path.'/include_payroll_admin.php');

$cid = addslashes($_REQUEST['cid']);
$name = addslashes(strtoupper($_REQUEST['name']));
$add1 = addslashes($_REQUEST['add1']);
$esicode = addslashes($_REQUEST['esicode']);
$pfcode =addslashes($_REQUEST['pfcode']);
$tanno = addslashes($_REQUEST['tanno']);
$panno = addslashes($_REQUEST['panno']);
$gstno = addslashes($_REQUEST['gstno']);
$lwf_no = strtoupper(addslashes($_REQUEST['lwf_no']));

$mont=date("Y-m-d", strtotime($_REQUEST['cm']));

$comp_id = $_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$sc = addslashes($_REQUEST['sc']);
$email = addslashes($_REQUEST['email']);
//$parent_comp=$_REQUEST['parent_comp'];
// if($parent_comp=='Y'){
if($_REQUEST['parent']==''){
$parent='';
}else{
$parent = addslashes($_REQUEST['parent']);
}

if (isset($_REQUEST['daywise_details'])) {
    $daywise_details = $_REQUEST['daywise_details'];
} else {
    $daywise_details = "Not Set"; // Debugging fallback
}
// print_r($_REQUEST);exit;
$result = $payrollAdmin->updateClient($cid,$name,$add1,$esicode,$pfcode,$tanno,$panno,$gstno,$mont,$parent,$sc,$email,$comp_id,$user_id,$daywise_details,$lwf_no);
print_r($result);exit;
?>

