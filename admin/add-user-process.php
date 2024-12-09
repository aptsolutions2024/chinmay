<?php
session_start();
error_reporting(0);
include("../lib/connection/db-config.php");

include("../lib/class/admin-class.php");

$adminObj=new admin();

    $fname = $_REQUEST['fname'];
    $mname = $_REQUEST['mname'];
    $lname = $_REQUEST['lname'];
    $uname = $_REQUEST['uname'];
    $pwd = $_REQUEST['pwd'];
    $type = $_REQUEST['type'];
    $comp_id = $_REQUEST['comp_id'];
    $result = $adminObj->insertUser($fname,$mname,$lname,$uname,$pwd,$type,$comp_id);
//     header('Location:add-user.php?msg=1');



?>

