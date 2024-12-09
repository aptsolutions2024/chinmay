<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');
 $empid = $_REQUEST['empid'];
if(isset($_FILES['file']['name'])){
      $filename = $_FILES['file']['name'];
      $extension = pathinfo($filename,PATHINFO_EXTENSION);
    $extension = strtolower($extension);
    $allowed_extensions = array("jpg","jpeg","png");
    $response = array();
      $status = 0;
      $newFileName = $empid.'-'.rand();
      $location = "../emp_imgs/".$newFileName.'.'.$extension;
      $db_path = "emp_imgs/".$newFileName.'.'.$extension;
      if(file_exists($location)) { unlink($location);}
    
    if(in_array(strtolower($extension), $allowed_extensions)) {
        if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){  
            $result =  $payrollAdmin->updateEmployeeProfile($empid,$db_path);
            if($result==1){
                $response['status'] = 1; 
                $response['path'] = $location;
                $response['db_path'] = $db_path;
                $response['ext'] = $extension;
                $response['message'] = 'File uploaded successfully';
            }else{
                unlink($location);
                 $response['status'] = 0; 
                $response['message'] = 'Failed to upload file';
            }
        }else{
            $response['status'] =0;
             $response['message'] = 'Failed to upload file';
        }
      }else{ 
          $response['status'] =0;
          $response['message'] = 'Sorry, only '.implode('/', $allowed_extensions).' files are allowed to upload.';
      }
      echo json_encode($response);
      exit;
}
?>