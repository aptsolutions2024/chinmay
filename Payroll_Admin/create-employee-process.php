<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$doc_path = $_SERVER['DOCUMENT_ROOT'];
include_once($doc_path.'/Payroll/lib/class/payroll_admin.php');
$payrollAdmin = new payrollAdmin();

$passcode=$_REQUEST['passcode'];
$mobile_no=$_REQUEST['mobile_no'];
//print_r($_REQUEST);exit;

$empdetails=$payrollAdmin->checkPasscodeMobInEmp($passcode,$mobile_no);
//echo "*****Result-".$empdetails['emp_id'];



if($empdetails['emp_id']){
	
    $count=$payrollAdmin->checkEmpIdValid($empdetails['emp_id']);
    $res=$payrollAdmin->checkEmpIdValidDetail($empdetails['emp_id']);
    $fullname=$empdetails['first_name']." ".$empdetails['last_name'];
      $empid=base64_encode($empdetails['emp_id']);
    if($count=='1')    //if exit in login master
    {
  
    ?>
      
                	<div class="success_class">Already having an account, Please update/change password ...</div>
                       <div class="twelve midbodyadm columns  margb10" >
                            <div class="four columns paddl0 labaltext padd0">
                                Password :
                            </div>
                            <div class="eight respopadd0 columns padd0">
                                 <input type="hidden" name="emp_id" id="emp_id"  class="textclass" value="<?=$empid;?>">
                              <input type="text" name="upass" id="upass" placeholder="Enter Password" class="textclass" onkeyup="checkPasswordStrength();" maxlength="20" >
                            </div> 
                             <div class="clearFix"></div>
                              <div id="password-strength-status"></div>
                        </div>
                        	<div class="twelve midbodyadm columns margb10 " style="text-align:center;">
                           
    							    <input type="button" class="submitbtn" value="Update Password" onclick="updatePasswwordofEmp();" >
                             
                            </div>
        
   <?php }
    else {   //if not exist in login master ?>
        
       <input type="hidden" name="emp_id" id="emp_id"  class="textclass" value="<?=$empid;?>">
    
    	<div class="success_class">Verified Employee, Please Set Username and Password to create an account...</div>
    	        <div class="twelve midbodyadm columns  margb10" >
                            <div class="four columns paddl0 labaltext padd0">
                                Username :
                            </div>
                            <div class="eight respopadd0 columns padd0">
                              <input type="text" name="uname" id="uname" placeholder="Enter Username" class="textclass" onkeyup="return checkusername();" maxlength="20">
                            </div> 
                        </div> 
                         <div class="twelve midbodyadm columns  margb10" >
                            <div class="four columns paddl0 labaltext padd0">
                                Password :
                            </div>
                            <div class="eight respopadd0 columns padd0">
                              <input type="text" name="upass" id="upass" placeholder="Enter Password" class="textclass" onkeyup="checkPasswordStrength();" maxlength="20">
                            </div> 
                             <div class="clearFix"></div>
                              <div id="password-strength-status"></div>
                        </div>
                        	<div class="twelve midbodyadm columns margb10 "  style="text-align:center;">
                           
    							    <input type="button" class="submitbtn" value="Create" onclick="createAccountofEmp();">
                            
                            </div>
    	
  
   <?php }
}else{
	echo '<div class="error_class">Invalid Passcode,Mobile No. / Currently not working employee, Please Try Again.</div>';	
}






/* $getsection=$officestaff->showEployeedetailsByID($editempid);
$section=$getsection['section'];

 $countEmp=$officestaff->selectEmployeename($username);
 if($countEmp=='0')
 {
 $last_insertId=$officestaff->createEmployee($editempid,$fname,$mname,$lname,$phoneno,$username,$password,$section);

 echo "<script>window.location.href='/create-payroll-employee?msg=001';</script>";exit();	
 } else { 
  echo "<script>window.location.href='/create-payroll-employee?msg=002';</script>";exit();	
 }
 */
?>