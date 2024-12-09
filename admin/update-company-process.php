<?php
session_start();
error_reporting(0);
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");

include("../lib/class/admin-class.php");

$adminObj=new admin();

    $comp_id = $_REQUEST['comp_id'];
    $name = $_REQUEST['name'];
    $add = $_REQUEST['add'];
    $phno = $_REQUEST['phno'];
    $sellogo = $_REQUEST['sellogo'];










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

            $result = $adminObj->updateCompany($comp_id,$name,$add,$phno,$logo);
            header('Location:edit-company.php?msg=1');
        }

    }else{
        $result = $adminObj->updateCompany($comp_id,$name,$add,$phno,$sellogo);
        header('Location:edit-company.php?msg=2');
    }
}else{
    header('Location:edit-company.php?msg=3');
}



	 ?>

