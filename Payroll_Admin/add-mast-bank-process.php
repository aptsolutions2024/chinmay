<?php
$doc_path=$_SERVER["DOCUMENT_ROOT"];
include ($doc_path.'/include_payroll_admin.php');

  $name = $_REQUEST['name'];
 $add = $_REQUEST['add'];
$branch = $_REQUEST['branch'];
$pincode = $_REQUEST['pincode'];
$city = $_REQUEST['city'];
$ifsccode = $_REQUEST['ifsccode'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];

$action = $_REQUEST['action'];
if($action=='Insert')
{
  $result = $payrollAdmin->insertBank($name,$add,$branch,$pincode,$city,$ifsccode,$comp_id,$user_id);
 if($result){
       echo "Record Inserted Successfully.<br/><br/>";  
 }else{
        echo "Record Not Inserted.<br/><br/>";  
 }
}else
{
   $bid = addslashes($_REQUEST['bid']);
   $result = $payrollAdmin->updateBank($bid,$name,$add,$branch,$pincode,$city,$ifsccode,$comp_id,$user_id);
   if($result){
       echo "Record Updated Successfully.<br/><br/>";  
   }else{
        echo "Record Not Updated.<br/><br/>";  
 }
}


	 ?>

