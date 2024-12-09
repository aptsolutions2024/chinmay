<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');
$empid = $_REQUEST['editempid'];
$uploaded_photo = $_REQUEST['uploaded_photo'];
$result = $payrollAdmin->deleteProfilePhoto($empid);
if($result==1){
    if($uploaded_photo!=''){
        unlink('../'.$uploaded_photo);
        echo 1;
    }else{
        $payrollAdmin->updateEmployeeProfile($empid,$uploaded_photo);
         echo 0;
    }
}else{
    echo 0;
}
?>

