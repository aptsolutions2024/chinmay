<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(0 & ~E_DEPRECATED & ~E_USER_DEPRECATED);

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Debugging: Check if session variables are properly set
if (!isset($_SESSION['log_type'])) {
    echo "Error: Log type not set. Please log in.";
    exit();
}


$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_emp.php');

// Debugging: Display session log type
echo "Session Log Type: " . $_SESSION['log_type'] . "<br>";

// If the log type is not 2, redirect to logout
if ($_SESSION['log_type'] != 2 && $_SESSION['log_type'] != 5) {
    echo "<script>window.location.href='/emp-payroll-logout';</script>";
    exit();
}

$emp_login_id = $_SESSION['log_id'];
$employeeName = $_SESSION['fname'] ?? 'Employee';
 echo "00000000000".$emp_login_id."1234567890";
 $month=$_SESSION['month'];
$clientid=$_SESSION['clientid'];
$emp=$_REQUEST['emp'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$zerosal = $_REQUEST['zerosal'];
$noofpay = $_REQUEST['noofpay'];

include('../fpdf/html_table.php');

$pdfHtml='';

$res=$payrollEmp->showEmployeereport($comp_id,$user_id);
$resclt=$payrollEmp->displayClient($clientid);
//print_r($resclt);
$cmonth=$resclt['current_month'];
if($month=='current'){
    $monthtit =  date('F Y',strtotime($cmonth));
    $tab_days='tran_days';
    $tab_emp='tran_employee';
    $tab_empinc='tran_income';
    $tab_empded='tran_deduct';
    $tab_adv='tran_advance';
    $frdt=$cmonth;
    $todt=$cmonth;
echo $frdt;
 }
else{
    $tab_days='hist_days';
    $tab_emp='hist_employee';
    $tab_empinc='hist_income';
    $tab_empded='hist_deduct';
    $tab_adv='hist_advance';

	
echo"##############";
	$monthtit =  date('F Y',strtotime($_SESSION['frdt']));


    $frdt=date("Y-m-d", strtotime($_SESSION['frdt']));
    $todt=date("Y-m-d", strtotime($_SESSION['todt']));
	
	/*$sql = "SELECT LAST_DAY('".$frdt."') AS last_day";
	$row= mysql_query($sql);
	$res = mysql_fetch_assoc($row);
	$frdt = $res['last_day'];*/
	$frdt=$payrollEmp->lastDay($frdt);
	
	/*$sql = "SELECT LAST_DAY('".$todt."') AS last_day";
	$row= mysql_query($sql);
	$res = mysql_fetch_assoc($row);
	$todt = $res['last_day'];*/
	$todt=$payrollEmp->lastDay($todt);
	
 }


echo"1111111";
$empid=$emp_login_id;
echo($empid);

echo "3333########";
$empid=$emp_login_id;
$res=$payrollEmp->getSalMonthData($comp_id,$user_id,$zerosal,$empid,$emp,$tab_days,$tab_emp,$clientid,$frdt,$todt);

$tcount= sizeof($res);

if($month!=''){
    $reporttitle="PAYSLIP FOR THE MONTH ".strtoupper($monthtit);
}
$_SESSION['client_name']=$resclt['client_name'];
$_SESSION['reporttitle']=$reporttitle;

?>

<!DOCTYPE html>

<html lang="en-US">
<head>

    <meta charset="utf-8"/>


    <title> &nbsp;</title>

    <!-- Included CSS Files -->
   <!-- <link rel="stylesheet" href="../css/responsive.css">
    <link rel="stylesheet" href="../css/style.css">-->
    <style>
	body{font-family:arial}
        .thheading{
            text-transform: uppercase;
            font-weight: bold;
            background-color: #fff;
        }
		.logo span.head11 {
			font-size: 17px !important;
		}
		
		span.head13 {
			font-size: 20px !important;
		}
        .heading{
            margin: 10px 20px;
        }
        .btnprnt{
            margin: 10px 20px;
        }
        .page-bk {
            position: relative;

            /*display: block;*/
            page-break-after: always;
            z-index: 0;

        }
		


        table {
            border-collapse: collapse;
            width: 100%;

        }

        table, td, th {
            padding: 3px!important;
            border: 1px solid black!important;
            font-size:12px !important;
            font-family:arial;
			
        }
		@page {margin :27mm 16mm 22mm 16mm;}
        @media print
        {
            .btnprnt{display:none}
            .header_bg{
                background-color:#7D1A15;
                border-radius:0px;
            }
            .heade{
                color: #fff!important;
            }
            #header, #footer {
                display:none!important;
            }
            #footer {
                display:none!important;
            }
            .body { margin: 0 30px 10px 10px; }
        }

        @media all {
            #watermark {
                display: none;

                float: right;
            }

            .pagebreak {
                display: none;
            }

            #header, #footer {

                display:none!important;

            }
            #footer {
                display:none!important;
            }

        }



    </style>
</head>
<body>
<div class="btnprnt">
    <button class="submitbtn" onclick="myFunction()">Print</button>
    <button class="submitbtn"  onclick="history.go(-1);" >Cancel</button>
</div>
<!-- header starts -->


<!-- header end -->

<!-- content starts -->

<?php
$count=0;
$per=$noofpay;
$no1= 1;
foreach($res as $row) {
	
	include "payslip.php";
	
} ?>
<!-- content end -->

<script>
    function myFunction() {
        window.print();
    }
</script>


</body>
</html>