<?php
session_start();

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');


 $name=strtoupper($_REQUEST['name']);
if($name!=''){
$arr=explode(" ",$name);

    $comp_id=$_SESSION['comp_id'];
    $user_id=$_SESSION['log_id'];
    $client_id=$_SESSION['clientid'];
    // echo "client id".$client_id;
// print_r($_SESSION);
$res=$payrollAdmin->SearchEmployeeNew($comp_id,$name);
 
$count = sizeof($res);
if($count!=0) {
    foreach($res as $rows)
    {
        $rest=$payrollAdmin->displayClient($rows['client_id']);
        if($rest['client_name']!='') {
            $cname = $rest['client_name'];
        }
        else {
            $cname = '-';
        }
        ?>
        <li class="searchli"  onclick="showTabdata('<?php echo $rows['emp_id'];?>','<?php echo trim($rows['first_name']) . ' ' . trim($rows['middle_name']) . ' ' . trim($rows['last_name']).' ['. $rows['emp_id'] .'] ('.$cname.')'; ?>')"><?php echo $rows['first_name'] . ' ' . $rows['middle_name'] . ' ' . $rows['last_name'].' ['. $rows['emp_id'] .'] ('.$cname.')';
            ?> </li>
    <?php
    }
}
else{
    echo "<span class='spanclass'>Please Enter the Valid Name</span>";
}
}
else{
    echo "<span class='spanclass'>Please Enter the Name</span>";
}
?>
