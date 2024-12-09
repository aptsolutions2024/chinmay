<?php 
   error_reporting(0);
   if(isset($_SESSION)){
   }
   else
   {
       session_start();
   }
   
   if($_SESSION['log_id']=='' && $_SESSION['comp_id']==''){
       header("location:/payroll");
   }
   include_once('lib/class/payroll_admin.php');
   $payrollAdmin = new payrollAdmin();
   include 'lib/class/error.php';
   include 'lib/connection/timezone.php';
   
   $comp_id=$_SESSION['comp_id'];
   $user_id=$_SESSION['log_id'];

   ?>
   
<!--<link rel="stylesheet" href="Payroll/css/jquery-ui.css">
<script type="text/javascript" src="Payroll/js/jquery.min.js"></script>
<script type="text/javascript" src="Payroll/js/jquery-ui.js"></script>  -->