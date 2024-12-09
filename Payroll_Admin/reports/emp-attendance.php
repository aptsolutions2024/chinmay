<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include payroll admin class
include ('../../include_payroll_admin.php');
$payrollAdmin = new payrollAdmin();

if (!isset($_SESSION['log_type'])) {
    header("Location: /payroll-logout");
    exit();
}

$frdt = date('Y-m-01', strtotime($_POST['from_date'])); // First date of the month
$todt = date('Y-m-t', strtotime($_POST['to_date']));    // Last date of the month
$monthtit = date('F Y', strtotime($frdt));

// Variables to store client, company, user, and employee details
$empid = $clientid = $comp_id = $user_id = '';
$attendanceData = [];

// Check log_type to determine whether it's admin or employee
if ($_SESSION['log_type'] == 2) {
     $clientGrp=$_SESSION['clientGrp'];
$frdt=$_SESSION['frdt'];

$group[]='';
$resclt='';
if ($clientGrp!='')
{   $group=$payrollAdmin->displayClientGroupById($clientGrp);
    $grpClientIds=$payrollAdmin->getGroupClientIds($clientGrp)  ;
    
    $grpClientIdsOnly=$payrollAdmin->getGroupClientIdsOnly($clientGrp);
    $resclt=$payrollAdmin->displayClient($grpClientIds[0]['mast_client_id']);
    $setExcelName = "Paysheet_Group".$clientGrp;
    $clientid =$grpClientIdsOnly['client_id'];
    
}
else
{
    $resclt=$payrollAdmin->displayClient($clientid);
    

}

if ( $month=='current')
{
    $frdt=$resclt['current_month'];
}


$client_name = ($clientGrp=='') ? $resclt['client_name']: "Group : ".$group['group_name']; 
$frdt=$payrollAdmin->lastDay($frdt);
$monthtit =  date('F Y',strtotime($frdt));
$todt=$frdt; 


    
    echo "!!!!!!!!!!".$frdt.$todt;
    $attendanceData = $payrollAdmin->getAttendanceReportAllEmployees($comp_id, $frdt, $todt);
} elseif ($_SESSION['log_type'] == 5) {
    // Employee session
    $clientid = $_SESSION['clientid'];
    $empid = $_SESSION['emp_login_id']; // Logged-in employee
    $comp_id = $_SESSION['comp_id'];
    $user_id = $_SESSION['log_id'];

      
    $attendanceData = $payrollAdmin->getAttendanceReport($comp_id, $empid, $frdt, $todt);
} else {
    header("Location: /payroll-logout");
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }
        h2 {
            text-align: center;
            margin-bottom: 10px;
        }
        p {
            text-align: center;
            font-size: 1.1em;
            color: #333;
        }
        .btnprnt {
            text-align: center;
            margin-bottom: 20px;
        }
        .btnprnt button {
            padding: 10px 20px;
            margin: 5px;
            font-size: 1em;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }
        .btnprnt button:hover {
            background-color: #45a049;
        }
        .btnprnt button.cancel {
            background-color: #f44336;
        }
        .btnprnt button.cancel:hover {
            background-color: #e53935;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
            font-size: 1.1em;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #333;
        }
        td {
            background-color: #fff;
            font-size: 1em;
            color: #555;
        }
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tbody tr:hover {
            background-color: #f1f1f1;
        }
        
        /* Responsive design for small screens */
        @media (max-width: 768px) {
            h2 {
                font-size: 1.5em;
            }
            p {
                font-size: 1em;
            }
            table {
                font-size: 0.9em;
            }
            .btnprnt button {
                font-size: 0.9em;
                padding: 8px 16px;
            }
            th, td {
                padding: 8px;
            }
        }

        /* Ensure the table can scroll horizontally if it overflows */
        @media (max-width: 600px) {
            table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
        }

        @media print {
            .btnprnt {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="btnprnt">
    <button onclick="window.print()">Print</button>
    <button class="cancel" onclick="history.go(-1);">Cancel</button>
</div>

<h2>Attendance Report</h2>
<p>Period: <?php echo date('F d, Y', strtotime($frdt)); ?> to <?php echo date('F d, Y', strtotime($todt)); ?></p>

<table>
    <thead>
        <tr>
            <?php if ($_SESSION['log_type'] == 2) { ?> <!-- Display Employee Name for admin only -->
                <th>Employee Name</th>
            <?php } ?>
            <th>Date</th>
            <th>Present</th>
            <th>Weekly Off</th>
            <th>Absent</th>
            <th>PL</th>
            <th>CL</th>
            <th>SL</th>
            <th>Paid Holiday</th>
            <th>OT Hours</th>
            <th>Night Shifts</th>
        </tr>
    </thead>
    <tbody>
    <?php
    // If attendance data exists
    if (!empty($attendanceData)) {
        foreach ($attendanceData as $row) {
            ?>
            <tr>
               <?php if ($_SESSION['log_type'] == 2) { ?> <!-- Show Employee Name for admin only -->
                    <td><?php echo $row['first_name'] . " " . $row['last_name']; ?></td>
                <?php } ?>
                <td><?php echo date('F , Y', strtotime($row['sal_month'])); ?></td>
                <td><?php echo ucfirst($row['present']); ?></td>
                <td><?php echo $row['weeklyoff']; ?></td>
                <td><?php echo $row['absent']; ?></td>
                <td><?php echo $row['pl']; ?></td>
                <td><?php echo $row['cl']; ?></td>
                <td><?php echo $row['sl']; ?></td>
                <td><?php echo $row['paidholiday']; ?></td>
                <td><?php echo $row['othours']; ?></td>
                <td><?php echo $row['nightshifts']; ?></td>
            </tr>
            <?php
        }
    } else {
        ?>
        <tr>
            <td colspan="11">No attendance data found for the selected period.</td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>

</body>
</html>

