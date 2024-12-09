<?php
session_start();
error_reporting(0);
include("../lib/connection/db-config.php");

include("../lib/class/admin-class.php");

$adminObj=new admin();

    $logid = $_REQUEST['logid'];
    $fname = $_REQUEST['fname'];
    $mname = $_REQUEST['mname'];
    $lname = $_REQUEST['lname'];
    $uname = $_REQUEST['uname'];
    $pwd = $_REQUEST['pwd'];
    $type = $_REQUEST['type'];
    $comp_id = $_REQUEST['comp_id'];
    $result = $adminObj->updateUser($logid,$fname,$mname,$lname,$uname,$pwd,$type,$comp_id);




?>

