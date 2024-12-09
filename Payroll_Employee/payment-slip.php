<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(0);

$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_emp.php');

// Retrieve user information from session
$emp_login_id = $_SESSION['log_id'];
$employeeName = $_SESSION['fname'] ?? 'Employee';

// Fetch employee details
$empdetails = $payrollEmp->showEployeedetails($emp_login_id);
$clientData = $payrollEmp->displayClient($empdetails['client_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Salary | HR Head Home</title>
    <link rel="stylesheet" href="/Payroll/css/responsive.css">
    <link rel="stylesheet" href="/Payroll/css/style.css">
    <style>
        /* Main container styling */
        .main-container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            font-family: "Arial", sans-serif;
        }

        .form-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
            align-items: center;
        }

        .form-group label {
            font-size: 14px;
            color: #333;
            text-align: left;
            width: 100%;
            max-width: 350px;
        }

        .form-group input {
            width: 100%;
            max-width: 350px;
            padding: 8px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-family: "Arial", sans-serif;
        }

        .form-group button {
            background-color: #008b8b;
            text-align: center;
            color: white;
            border: none;
            padding: 8px 16px;
            font-size: 14px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .form-group button:hover {
            background-color: #0056b3;
        }

        .footer {
            padding-top: 300px;
        }

        /* Responsive Design for Small Screens */
        @media (max-width: 768px) {
            .main-container {
                padding: 15px;
                margin: 19px;
                margin-bottom: 20px;
            }

            .form-group {
                width: 100%;
                flex-direction: column;
                align-items: center;
            }

            .form-group input,
            .form-group button {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .boxborder {
                margin: 19px;
                align-items: center;
            }

            .form-group label {
                font-size: 12px;
            }

            .form-group input {
                font-size: 12px;
                padding: 6px;
            }

            .form-group button {
                font-size: 12px;
                padding: 6px 12px;
            }

            .footer {
                padding: 10px;
                font-size: 10px;
            }
        }
    </style>
</head>
<body>
    <!-- Header starts here -->
    <?php include('header.php'); ?>
    <!-- Header end here -->

    <?php include('menu.php'); ?>

    <div class="twelve mobicenter innerbg">
        <div class="row">
            <div class="twelve" id="margin1">
                <h3>Salary Slip</h3>
            </div>

            <div class="clearFix"></div>

            <div class="twelve" id="margin1">
                <div class="boxborder">
                    <form id="payslip-form" autocomplete="off" method="post" action="/r-report-payslip-page">
                        <div class="pfmaing">
                            <div class="row">
                                <!-- Month: Current/Previous Row -->
                                <div style="display: flex; align-items: center; gap: 5px;">
                                    <!-- Container for From Date -->
                                    <div class="form-group" style="flex: 1;">
                                        <label for="from-date">Select From Date:</label>
                                        <input id="from-date" name="from_date" type="month" min="2001-04" max="2025-03" required>
                                    </div>

                                    <!-- Container for To Date -->
                                    <div class="form-group" style="flex: 1;">
                                        <label for="to-date">Select To Date:</label>
                                        <input id="to-date" name="to_date" type="month" min="2001-04" max="2025-03" required>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="form-group" style="flex: 1;">
                                        <label for="to-date"></label>
                                        <button type="submit">Show</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="clearFix"></div><div class="clearFix"></div>
                    <br/>
                </div>
            </div>

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        </div>
    </div>
    <div class="footer">
        <?php include('footer.php'); ?>
    </div>
</body>
</html>
