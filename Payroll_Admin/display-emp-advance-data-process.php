<?php
error_reporting(E_ALL);
session_start();
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

if($_SESSION['log_type']==2)
{
    
}else
{
    echo "<script>window.location.href='/payroll-logout';</script>";exit();
}

include("../lib/class/advance.php");
include("../lib/class/common.php");
$advance =new advance();
$common = new common();

  $advtype = $_POST['advtype'];
// $_REQUEST['advdate'];
 $advdate = date('Y-m-d',strtotime($_POST['advdate']));
 

$advamt = $_REQUEST['advamt'];
$advinstall = $_REQUEST['advinstall'];
//$closeon = $_REQUEST['closeon'];
$received_amt= $_REQUEST['received_amt'];

$user = $_SESSION['log_id'];
$comp = $_SESSION['comp_id'];

$empid = $_REQUEST['emp_adv_id'];
$i=0;
foreach($empid as $emp){
 $num = $advance->checkAdvances($_REQUEST['emp_adv_id'][$i],$advtype,$advdate); 
$date = "1970-01-01";
if($num == '0'){
    $advance->insertAdvances($advtype,$advdate,$user,$comp,$empid[$i],$advamt[$i],$advinstall[$i],$date);
}else{
    $advance->updateAdvances($advtype,$advdate,$user,$comp,$empid[$i],$advamt[$i],$advinstall[$i],$date);	
}	
$i++;
}
echo "<script>window.location.href='/edit-all-employee';</script>";exit();
?>