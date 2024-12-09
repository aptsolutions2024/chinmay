<?php
session_start();
$_SESSION['clintid']=$_REQUEST['clientid'];
$_SESSION['clientid']=$_REQUEST['clientid'];
$_SESSION['month']=$_REQUEST['month_value'];
$_SESSION['frdt']=$_REQUEST['frdt'];
$_SESSION['todt']=$_REQUEST['todt'];
$_SESSION['days']=$_REQUEST['days'];

print_r($_SESSION);
?>

