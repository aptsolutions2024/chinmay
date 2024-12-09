<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"] . '/include_payroll_emp.php');

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $emp_id = $_POST['empid'];
    $from_date = $_POST['frdt'];
    $to_date = $_POST['todt'];

    // Fetch attendance data
    $payrollEmp = new PayrollEmp();
    $attendanceData = $payrollEmp->getAttendanceReport($emp_id, $from_date, $to_date);

    if (!empty($attendanceData)) {
        // Prepare Excel file for download
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=attendance_report_$emp_id.xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        // Output column headers
        echo "Present\tWeeklyof\tAbsent\tPL\tCL\tSI\tPaidhold\tAdditional\tOthours\tNightshifts\n";

        // Output rows
        foreach ($attendanceData as $row) {
            echo implode("\t", $row) . "\n";
        }
        exit;
    } else {
        echo 'No attendance data found for the selected period.';
    }
} else {
    echo 'Invalid request method.';
}
?>
