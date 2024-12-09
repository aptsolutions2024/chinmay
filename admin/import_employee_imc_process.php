<?php
session_start();
error_reporting(E_ALL);
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include_once($doc_path.'/lib/class/admin.php');
$payrollAdmin = new Admin();
?>
<style>

    .rownoHead{
        font-weight:600;
            color: red;
                 margin: 8px 0px;
    }
    .rownosubHead{
            color: chocolate;
                margin: 3px;
    }
    .successMsg{
        font-weight:600;
            color: green;
                 margin: 8px 0px;
    }
</style>
<?php 
//$comp_id = $_SESSION['comp_id'];
$comp_id = 1;
$user_id = $_SESSION['log_id'];
$clientid = $_REQUEST['clientid'];
$filename = $_FILES["file"]["tmp_name"];
//print_r($_REQUEST);exit;
//echo $_FILES["file"]["size"];

if ($_FILES["file"]["size"] > 0) {
  
    // Open the file and read all data into an array
    $file = fopen($filename, "r");
   // $csvData = [];
    $row == 0;
    $errorMsg='';
    while ($emapDataOrg = fgetcsv($file, 10000, ",")) {
       if ($row == 0) {
           $row++;
            continue; // Skip the first row (header)
        }
        $name = trim(addslashes($emapDataOrg[3])); //name
        $gender     = trim(addslashes($emapDataOrg[4])); // Gender
        $mobile_no  =   trim(addslashes($emapDataOrg[10])); //mobileno
        $errorMsgTemp='';
        if($name==""){
          $errorMsgTemp.="<p class='rownosubHead'>Employee Firstname should be required.</p>"; 
        }
        if($gender){
                if($gender!='MALE' && $gender!='FEMALE' && $gender!='female' && $gender!='male'){         ;
                  $errorMsgTemp.="<p class='rownosubHead'>Employee Gender should be Male/Female -> <b>$gender</b></p>"; 
                }
          }
        if($mobile_no){
            if($mobile_no!='NOT AVAILABLE' && strlen($mobile_no)!=10){
             $errorMsgTemp.="<p class='rownosubHead'>Employee Mobile Number Should be 10 digit -> <b>$mobile_no</b></p>"; 
            }
        }
        if($errorMsgTemp){
            $errorMsg.="<h3 class='rownoHead'>Row No - ".$row."</h3>";
            $errorMsg.=$errorMsgTemp;
        }
        
        $row++;
    }

    // Process each row
    $recCnt=0;
    $skiprow=0;
    if($errorMsg==""){
        $file = fopen($filename, "r");
    while ($emapData = fgetcsv($file, 10000, ",")) {
       if ($skiprow == 0) {
           $skiprow++;
            continue; // Skip the first row (header)
        }
        // Extract and sanitize data from the CSV
        $name = trim(addslashes($emapData[3])); // Excel Name column
       
       if(strpos($name,'Mr.')!== false){
           //echo 1;
           $name1 = trim(str_replace('Mr.','',$name)); 
       }elseif(strpos($name,'Mrs.')!== false){
            //echo 2;
            $name1 = trim(str_replace('Mrs.','',$name)); 
       }elseif(strpos($name,'Ms.')!== false){
            //echo 3;
           $name1 = trim(str_replace('Ms.','',$name));
       }else{
           $name1=$name;
       }
        $name_arr = explode(" ",$name1); // split to get three names
       
        if(count($name_arr)==2){
            $firstName = $name_arr[0]; //First name
            $lastName = $name_arr[1]; // Middle name
            $middleName='';
        }elseif(count($name_arr)==3){
            $firstName = $name_arr[0]; //First name
            $middleName = $name_arr[1]; // Middle name
            $lastName = $name_arr[2]; // Last name
        }else{
            $firstName = $name_arr[0]; //First name
            $lastName='';
            $middleName='';
        }
       
        $gender = addslashes($emapData[4]); // Gender
        $bdate = !empty($emapData[5]) ? date('Y-m-d', strtotime(str_replace('/', '-', $emapData[5]))) : "2001-01-01"; // Birthdate
        $joindate = !empty($emapData[6]) ? date('Y-m-d', strtotime(str_replace('/', '-', $emapData[6]))) : "2001-01-01"; // Join date
        $esino = addslashes($emapData[1]); // ESI number
        $pfno = addslashes($emapData[2]); // ESI number
        $mobile_no=addslashes($emapData[10]);
        $bank = trim(addslashes($emapData[14])); // Bank
        $middlename_relation = trim(addslashes($emapData[8])); // Bank
        $bankacno = $ifscno = $bank_id='';
      if($bank=="NOT AVAILABLE"){
            $bank_id=1;
        }else{
            $bankColArr = explode(",",$bank);
            $bankacno =$bankColArr[0];     //bank account no
            $ifsc_details = explode(":",$bankColArr[1]);
            $ifscno = $ifsc_details[1];
            $bank_id = $payrollAdmin->getBankDetailsByIfsc($ifscno);
        }
         if($gender){
                if($gender=='MALE'){         
                $gender="M";
                }elseif($gender=='FEMALE'){
                   $gender="F"; 
                }
          }
        $panno = addslashes($emapData[13]); // PAN number
        $adharno = addslashes($emapData[12]); // Aadhar number
        $uan = addslashes($emapData[0]); // UAN number
        $married_status = addslashes($emapData[9]); // Married status
        if($married_status =='MARRIED'){
            $married_status='M';
        }elseif($married_status =='UN-MARRIED'){
            $married_status='U';
        }else{
            $married_status='N';
        }
            // Set default password
        $password = 'chinmay123';
        $user_name = $payrollAdmin->generateUsername($firstName);
        
        $dept_id=1;
        $category_id=1;$qualif_id=1; $desg_id=1;
        
        $due_date ="2001-01-01"; // Due date
        $leftdate ="0000-00-00"; // Left date
        $pfdate ="2001-01-01"; // PF date
        $esistatus="Y";
        $pay_mode="";
        $comp_ticket_no="";
        $emp_add1="";
        $result_arr = array("comp_id"=>$comp_id,            
            "user_id" => $user_id,
            "firstname"=>$firstName,
            "middlename"=>$middleName,          
            "lastname"=>$lastName,
            "gender"=>$gender,
            "bdate"=>$bdate,
            "joindate"=>$joindate, 
            "esino"=>$esino,
            "mobile_no"=>$mobile_no, 
            "bank_acc_no"=>$bankacno,
            "ifsc_no"=>$ifscno,
            "bank_id"=>$bank_id,
            "adharno"=>$adharno,
            "uan_no"=> $uan, 
            "marries_status"=>$married_status,
            "panno"=>$panno,
            "middlename_relation"=>$middlename_relation
            );
       // print_r($result_arr);
       // echo '<pre>';
        //
        /*$empid = $payrollAdmin->insertCSVWiseEmployee( $comp_id, $user_id, $user_name, $password, 
    $firstName, $middleName, $lastName, 
    $gender, $bdate, $joindate, $due_date, $leftdate, 
    $pfdate, $pfno, $esistatus, $esino,
    $dept_id, $category_id, $qualif_id, 
    $mobile_no, $pay_mode, $bank_id, $bankacno, 
    $comp_ticket_no, $panno, $adharno, $uan, 
    $married_status, $emp_add1, $desg_id, $clientid,$middlename_relation);
    if($empid){
        $recCnt++; 
    }
    */
    
    //added by Shraddha on 21-10-2024
    //please uncomment update query while there is exponential form for uan number , and comment insert query --- vice versa
   //$recCnt = $payrollAdmin->updateUanNumber($firstName,$middleName,$lastName,$uan,$clientid);
   
}
    echo "<p class='successMsg'>Record Inserted Successfully.  Count -".$recCnt."</p>";
}else{
    echo $errorMsg;
   
}
 echo '<button class="submitbtn" onclick="history.go(-1);">Back</button>';
fclose($file);
}
?>