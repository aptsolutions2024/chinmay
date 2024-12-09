<?php
session_start();
error_reporting(0);
include("../lib/connection/db-config.php");
include("../lib/class/admin-class.php");
$adminObj=new admin();
  $id = $_REQUEST['id'];
  $result = $adminObj->deleteCompany($id);
?>

