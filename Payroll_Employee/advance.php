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
            <div class="twelve" id="margin1"> <h3>Advanve</h3></div>

            <div class="clearFix"></div>

            <div class="twelve" id="margin1">
                <div class="boxborder">
          
            <!--<form>-->
           <form id="payslip-form" method="POST" action="/r-report-adv-employee-page" autocomplete="off">
    <div class="pfmaing">
        <div class="row" style="padding:10px;">
            <!-- Month: Current/Previous Row -->
            <div style="display: flex; align-items: center; gap: 5px;">
                <!-- Container for Select Date -->
                <div id="advdate1" class="" style="width: 30%;">
                    <label for="advdate">Select Date:</label>
                    <select name="advdate" id="advdate" class="textclass">
                        <option value="">-- Select Date --</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="form-group" style="margin-top:25px;width:5%">
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
    <script>
function advdates(empId) {
    $.post('/emp-show_adv_dates', { 'emp_id': empId }, function(data) {
       // console.log('Response from server:', data);;
        if (data) {
            $('#advdate').html(data);
        } else {
            console.error('No data returned from server.');
        }
    });
}

$(document).ready(function() {
    const empId = '<?php echo $_SESSION['log_id']; ?>'; 
    advdates(empId); 
});


    </script>
 
        <?php include('footer.php');?>
  

    <!-- JavaScript for AJAX Submission -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


</body>
</html>
