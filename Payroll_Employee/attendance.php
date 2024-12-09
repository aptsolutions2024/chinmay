<?php
session_start();
// print_r($_SESSION);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_emp.php');

// Retrieve user information from session
$emp_login_id = $_SESSION['log_id'];
$employeeName = $_SESSION['fname'] ?? 'Employee';
// echo $$emp_login_id;
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
            font-family: "Arial", sans-serif; /* Clean, modern font */
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
            font-size: 14px; /* Reduced font size */
            color: #333;
            text-align: left;
            width: 100%;
            max-width: 350px;
        }

        .form-group input {
            width: 100%;
            max-width: 350px;
            padding: 8px; /* Reduced padding for a more compact look */
            font-size: 14px; /* Smaller input font size */
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-family: "Arial", sans-serif;
        }

        .form-group button {
            background-color: #008b8b;
            text-align:center;
            color: white;
            border: none;
            align-items: center;
            padding: 8px 16px; /* Smaller padding to match font size */
            font-size: 14px; /* Reduced button font size */
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .form-group button:hover {
            background-color: #0056b3;
        }

        .footer{
            padding-top:300px;
        }

        /* Responsive Design for Small Screens */
        @media (max-width: 768px) {
            .main-container {
                padding: 15px;
                margin-bottom:20px;
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
            .boxborder{
                margin:20px;
            }
            .form-group label {
                font-size: 12px; /* Smaller font size for smaller screens */
            }

            .form-group input {
                font-size: 12px;
                padding: 6px;
            }

            .form-group button {
                font-size: 12px;
                padding: 6px 12px; /* Reduced padding for smaller screens */
            }

            .footer {
                padding: 10px;
                font-size: 10px; /* Even smaller footer font size */
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
            <div class="twelve" id="margin1"> <h3>Attendance</h3></div>

            <div class="clearFix"></div>

            <div class="twelve" id="margin1">
                <div class="boxborder">
            <!--<form id="payslip-form"   method="POST" action ="/emp-attendance" autocomplete="off">-->
            <!--    <div class="form-group" column =6>-->
            <!--        <label for="from-date">Select From Date:</label>-->
            <!--        <input id="from-date" name="from_date" type="month" min="2001-04" max="2025-03" required>-->
            <!--    </div>-->
            <!--    <div class="form-group" column = 6>-->
            <!--        <label for="to-date">Select To Date:</label>-->
            <!--        <input id="to-date" name="to_date" type="month" min="2001-04" max="2025-03" required>-->
            <!--        </div>-->
            <!--    <div class="form-group">-->
            <!--        <button type="submit">Show</button>-->
            <!--    </div>-->
                
                
            <!--</form>-->
            <form id="payslip-form" method="POST" action ="/emp-attendance" autocomplete="off" >
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
                                    
                                    <div class="form-group" style="flex: 1;">
                                        <label for="to-date"></label>
                                        <div style="justify-content: center; margin-bottom: 10px; background-color: #008b8b;">
                                           <button type="submit">Show</button>
                                           </div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
</div></div>
           </div>
        </div>
    </div>
 
        <?php include('footer.php');?>
  

    <!-- JavaScript for AJAX Submission -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
<script>
// $(document).ready(function() {
//     $('#payslip-form').on('submit', function(e) {
//         e.preventDefault(); // Prevent default form submission

//         var frdt = $('#from-date').val(); // Append '-01' for the first day of the month
//         var todt = $('#to-date').val(); // Same for the to-date

//         var empid = '<?= $emp_login_id ?>'; // Make sure this is correct
//         console.log("From date: " + frdt);
//         console.log("To date: " + todt);
//         console.log("Employee ID: " + empid);

//         if (empid === '' || empid === null) {
//             alert("Employee ID is missing");
//             return;
//         }

//         // Debug form data before sending
//         console.log("Sending From Date: " + frdt);
//         console.log("Sending To Date: " + todt);
        
//         // Validate date inputs
//         if (!frdt || !todt) {
//             alert('Please select both From Date and To Date');
//             return;
//         }

//       $.ajax({
//     url: '/emp-attendance',
//     method: 'POST',
//     data: {
//         frdt: frdt,
//         todt: todt,
//         empid: empid
//     },
//     success: function(response) {
//         console.log(response); // Log the response to see what’s coming back

//         // Optionally handle any returned data from the server here
//         // window.location.href = '/emp-attendance';
//     },
//     error: function(xhr, status, error) {
//         console.error('An error occurred: ' + error);
//         alert('There was an error processing your request.');
//     }
// });

//     });
// });

</script>

</body>
</html>
