<?php
session_start();
error_reporting(0);
include("../lib/connection/db-config.php");

include("../lib/class/admin-class.php");

$adminObj=new admin();

    $name = $_REQUEST['name'];
    $add = $_REQUEST['add'];
    $phno = $_REQUEST['phno'];



$target_dir = "../images/";
$logo=basename($_FILES["fileToUpload"]["name"]);
$target_file = $target_dir . $logo;
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

            $result = $adminObj->insertCompany($name, $add, $phno, $logo);
            header('Location:add-company.php?msg=1');
        }

    }else{
        header('Location:add-company.php?msg=3');
    }
}else{
    header('Location:add-company.php?msg=2');
}



?>

