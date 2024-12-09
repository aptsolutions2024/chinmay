<?php
session_start();
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');
$emp_id = $_POST['emp_id'] ?? null;
if ($emp_id) {
    $advdate = $payrollAdmin->getAdvDate($emp_id);
    if (is_array($advdate) && count($advdate) > 0) {
        $html = '<select name="advdate" class="textclass" id="advdate">';
        $html .= '<option value="">-- Select Date --</option>';
        foreach ($advdate as $advdate1) {
            $formattedDate = date('d-m-Y', strtotime($advdate1['date']));  
            $html .= "<option value='{$advdate1['date']}'>$formattedDate</option>";
        }

        $html .= '</select>';
        echo $html; 
    } else {
        echo 'No dates found for the selected employee.';
    }
} else {
    echo 'Error: emp_id not provided.';
}
?>
