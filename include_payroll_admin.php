<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

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
   $doc_path=$_SERVER["DOCUMENT_ROOT"];
   include_once($doc_path.'/lib/class/payroll_admin.php');
   $payrollAdmin = new payrollAdmin();
  
   
   include $doc_path.'/lib/class/error.php';
   include $doc_path.'/lib/connection/timezone.php';
   
   $comp_id=$_SESSION['comp_id'];
   $user_id=$_SESSION['log_id'];
   
   if(isset($_SERVER['HTTPS'])){
        $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";    }
    else{
        $protocol = 'http';
    }
    $global_base_url= $protocol . "://" . $_SERVER['HTTP_HOST'];
        // Enter the name of directory 

   ?>