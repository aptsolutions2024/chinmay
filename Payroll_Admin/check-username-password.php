<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

$payrollAdmin = new payrollAdmin();

$username=$_REQUEST['username'];
$password=$_REQUEST['userpass'];

if($_REQUEST['username'] && $_REQUEST['userpass']){
   $empdetails=$payrollAdmin->checkempUnamepass($username,$password);
   if($empdetails=='success'){ ?>
        <div class="twelve midbodyadm columns  margb10" >
            <div class="four columns paddl0 labaltext padd0">
                Enter New Password :
            </div>
            <div class="eight respopadd0 columns padd0">
              <input type="text" name="newpass" id="newpass" placeholder="Enter Password" class="textclass" onkeyup="return">
            </div> 
             <div class="clearFix"></div>
             <div id="password-strength-status"></div>
        </div>
       	<div class="twelve midbodyadm columns margb10 "  style="text-align:center;">
                           
    							    <input type="button" class="submitbtn" value="Submit" onclick="updatePassowrd();">
                            
        </div>
   <?php }elseif($empdetails=='failure'){
        echo '<div class="error_class">Please Enter Correct Username/Password..</div>';
   }
}else{
    echo '<div class="error_class">Enter Username/Password..</div>';
}

?>