<?php
error_reporting(E_ALL);
if(isset($_SESSION['log_id'])&&$_SESSION['log_id']==''){
    header("location:../index.php");
}
?>
<!--Header starts here-->


<header class="twelve header_bg">

    <div class="row" >

        <div class="twelve padd0 columns" >

            <div class="six padd0 columns mobicenter text-left " id="container1">

                <!-- Modify top header1 start here -->
<br/>
<!--                <a href="index.php"><div class="logo" ><img src="../images/logo.png"></div></a>-->
<?php 
    $doc_path=$_SERVER["DOCUMENT_ROOT"];
include_once($doc_path.'/lib/class/payroll_admin.php');
$payrollAdmin = new payrollAdmin();
$co_id=$_SESSION['comp_id'];
$rowcomp=$payrollAdmin->displayCompany($co_id);
$crmonth = $payrollAdmin->getClientMonth($co_id);
$row=$payrollAdmin->getLoginDetails($_SESSION['log_id']);
$role='';
if($row['login_type']==1){
    $role = 'Developer';
}elseif($row['login_type']==2){
    $role = 'Admin';
}elseif($row['login_type']==3){
    $role = 'Attandance';
}elseif($row['login_type']==4){
    $role= 'Supervisor';
}elseif($row['login_type']==5){
    $role= 'Accountant';
}
echo ' <h4 class="Color2" >'.$rowcomp['comp_name'].' </h4>';
?>
                <br/>
                <!-- Modify top header1 ends here -->

            </div>
<div class="two padd0 columns cmoncl" valign="center" > </div>

<div class="four padd0 columns text-right text-center" id="container3">

                <!-- Modify top header3  Navigation start here -->


                <div class="mobicenter text-right" id="margin1" >
                    
        <div style="display: flex; align-items: center; justify-content: flex-start;">
    <p style="margin: 0; color: white;"><?php echo $row['fname'].' - '.$role; ?></p>
    <a class="btn" href="/payroll-logout" style="margin-left: 20px;">Logout</a>
</div>
                </div>

            </div>




        </div>

</header>

<style>
    .dataTables_filter, label {display: flex !important;}
    .dataTables_filter, table {padding: 0px !important;}
</style>

 <link rel="stylesheet" href="Payroll/css/responsive.css">
  <link rel="stylesheet" href="Payroll/css/style.css">
  <script type="text/javascript" src="Payroll/js/jquery.min.js"></script>
  
 <link href="Payroll/css/jquery.dataTables.min.css" rel="stylesheet">
	<link href="Payroll/css/buttons.dataTables.min.css" rel="stylesheet">

<!--Header end here-->


<?php

 if ($_SESSION['log_type']==2)
        include('menu.php');
else if ( $_SESSION['log_type']==3)
        include('menu_attendance.php');
else if ( $_SESSION['log_type']==4)
        include('menu_supervisor.php');
else if ( $_SESSION['log_type']==5)
        include('menu_accounts.php');

?>
