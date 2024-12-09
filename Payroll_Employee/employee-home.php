<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(0);

$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_emp.php');


//$payrollEmp = new payrollEmp();



// Retrieve user information from session
$emp_login_id = $_SESSION['log_id'];
$employeeName = $_SESSION['fname'] ?? 'Employee';
// echo $emp_login_id;
// Fetch employee details
$empdetails = $payrollEmp->showEployeedetails($emp_login_id);
  $_SESSION['clientid'] =$empdetails['client_id'];
$clientData = $payrollEmp->displayClient($empdetails['client_id']);

 
$_SESSION['client_name']=$clientData['client_name'];


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width"/>
    <title>Salary | HR Head Home</title>
    <link rel="stylesheet" href="/Payroll/css/responsive.css">
    <link rel="stylesheet" href="/Payroll/css/style.css">
    <style>
    
         body {
            font-family: "Times New Roman", Times, serif;  }

        .userdetailsdiv {
            padding-top: 0.5rem !important;
            text-transform: uppercase;
            margin: auto;
        }

        .maindiv {
            background-color: white;
            height: 100%;
            width: 100%;
            font-family: "Arial", "Helvetica", sans-serif; /* Clean and professional font */
        }

        .userdetails {
            font-weight: normal; /* Make sure the font is not bold */
            font-size: 14px; /* Adjust font size for better readability */
            color: #333; /* Dark grey color for a professional look */
        }

        .four h6, .eight h6 {
            font-size: 14px; /* Ensure a unified font size */
            color: #555; /* Slightly lighter grey for labels */
            margin: 0; /* Remove default margins for a clean look */
        }

        h2.h2 {
            font-weight: 500; /* Semi-bold for the welcome message */
        }
        .menu {
        height: 50px;
        width: 100%;
        background-color:#aeb5b6;
        display: flex; /* Align items horizontally */
        justify-content: center; /* Center items horizontally */
        align-items: center; /* Center items vertically */
    }

    .menucontent a {
        text-decoration: none;
        color: black; /* White color text */
        margin: 0 20px; /* Add gap between links */
        font-size: 18px; /* Increase font size */
        
    }
    </style>
</head>
<body>
    <!-- Header starts here -->
    <?php include('header.php'); ?>
    <!-- Header end here -->
<?php include('menu.php');?>
    <div class="clearFix"></div>
    <!-- Menu starts here -->
    <!-- Menu ends here -->

    <div class="clearFix"></div>
    <!-- Slider part starts here -->
    <div class="twelve mobicenter innerbg">
        <div class="row maindiv">
            <div class="twelve" id="margin1"  style="text-align: center;"> <h1>Employee Home Page</h1></div>
            <div class="clearFix"></div>
            <div class="twelve" id="margin1">
                <div class="three columns" id="margin4">
                    <img src="/Payroll/images/no-profile-pic.jpg" height="320">
                </div>
                <div class="nine columns" id="margin4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row" style="min-height:400px;margin:auto;">
                               <h4 style="text-transform: uppercase; text-align: center; color: #13c3a6;">
    Welcome <?= htmlspecialchars($employeeName) ?>
</h4> <div class="borderdiv"></div>
                                <div class="col-sm-8 userdetailsdiv">
                                    <div class="twelve" id="margin1">
                                        <div class="four columns"><h6>Full Name:</h6></div>
                                        <div class="eight columns"><h6 class="userdetails"><?= htmlspecialchars($empdetails['first_name']." ".$empdetails['middle_name']." ".$empdetails['last_name']) ?></h6></div>
                                        <div class="clearFix"></div>
                                        <div class="four columns"><h6>Client Name:</h6></div>
                                        <div class="eight columns"><h6 class="userdetails"><?= htmlspecialchars($clientData['client_name']) ?></h6></div>
                                        <div class="clearFix"></div>
                                        <div class="four columns"><h6>Joining Date:</h6></div>
                                        <div class="eight columns"><h6 class="userdetails"><?= ($empdetails['joindate'] && $empdetails['joindate'] != "0000-00-00") ? date('d-m-Y', strtotime($empdetails['joindate'])) : "" ?></h6></div>
                                        <div class="clearFix"></div>
                                        <div class="four columns"><h6>Mobile No.:</h6></div>
                                        <div class="eight columns"><h6 class="userdetails"><?= htmlspecialchars($empdetails['mobile_no']) ?></h6></div>
                                        <div class="clearFix"></div>
                                        <div class="four columns"><h6>Email ID:</h6></div>
                                        <div class="eight columns"><h6 class="userdetails"><?= htmlspecialchars($empdetails['email']) ?></h6></div>
                                        <div class="clearFix"></div>
                                        <div class="four columns"><h6>Department:</h6></div>
                                        <div class="eight columns"><h6 class="userdetails"><?= htmlspecialchars($empdetails['dept']) ?></h6></div>
                                        <div class="clearFix"></div>
                                        <div class="four columns"><h6>Address:</h6></div>
                                        <div class="eight columns"><h6 class="userdetails"><?= htmlspecialchars($empdetails['emp_add1']) ?></h6></div>
                                        <div class="clearFix"></div>
                                        <div class="four columns"><h6>Aadhar No:</h6></div>
                                        <div class="eight columns"><h6 class="userdetails"><?= htmlspecialchars($empdetails['adharno']) ?></h6></div>
                                        <div class="clearFix"></div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br/>
        </div>
    </div>
    <!-- Slider part ends here -->
    <div class="clearFix"></div>
    <!-- Footer start -->
    <?php include('footer.php'); ?>
    <!-- Footer end -->
</body>
</html>
