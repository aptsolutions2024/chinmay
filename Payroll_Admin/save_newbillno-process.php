<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

$user_id = $_SESSION['log_id'];

$clientid = $_REQUEST['client'];
$optype = $_REQUEST['optype'];
 $billno = $_REQUEST['billno'];
 $billdate = date("Y-m-d",strtotime($_REQUEST['billdate']));
$newbillno = $_REQUEST['newbillno'];
 $newbilldate = date("Y-m-d",strtotime($_REQUEST['newbilldate']));

  $result = $payrollAdmin->savenewbillno($billno,$billdate,$newbillno,$newbilldate);

?>
