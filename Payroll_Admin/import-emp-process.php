<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');
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
<?php $comp_id = $_SESSION['comp_id'];
$user_id = $_SESSION['log_id'];
$clientid = $_REQUEST['clientid'];
$filename = $_FILES["file"]["tmp_name"];

$res1 = $payrollAdmin->getEmpHeads($comp_id);

$headid = array();
foreach ($res1 as $row111) {
    $headid[] = $row111['mast_deduct_heads_id'];
}

$pfid = $headid[0];
$esiid = $headid[1];
$proftaxid = $headid[2];
$lwfid = $headid[3];

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
        
        $firstName  =  trim(addslashes($emapDataOrg[0])); // First name
        $middleName = trim(addslashes($emapDataOrg[1])); // Middle name
        $lastName   =   trim(addslashes($emapDataOrg[2])); // Last name
        $gender     = trim(addslashes($emapDataOrg[3])); // Gender
        $dept = addslashes($emapDataOrg[12]); // Department
        $category_name = addslashes($emapDataOrg[13]); // Category
        $qualif = addslashes($emapDataOrg[14]); // Qualification
        $mobile_no  =   trim(addslashes($emapDataOrg[15]));
        $pay_mode   =   trim(addslashes($emapDataOrg[16]));
        $bank = addslashes($emapDataOrg[17]); // Bank
        $desg = addslashes($emapDataOrg[25]); // Designation
        $errorMsgTemp='';
        if($firstName==""){
          $errorMsgTemp.="<p class='rownosubHead'>Employee Firstname should be required.</p>"; 
        }
        if($middleName==""){
          $errorMsgTemp.="<p class='rownosubHead'>Employee Middlename should be required.</p>"; 
        }
        if($lastName==""){
          $errorMsgTemp.="<p class='rownosubHead'>Employee Lastname should be required.</p>"; 
        }
        if($gender){
                if($gender!='M' && $gender!='F' && $gender!='f' && $gender!='m'){         ;
                  $errorMsgTemp.="<p class='rownosubHead'>Employee Gender should be Male/Female -> <b>$gender</b></p>"; 
                }
          }
        if($mobile_no){
            if(strlen($mobile_no)!=10){
             $errorMsgTemp.="<p class='rownosubHead'>Employee Mobile Number Should be 10 digit -> <b>$mobile_no</b></p>"; 
            }
        }
         if($pay_mode!=""){
             if($pay_mode!='Cheque' && $pay_mode!='Transfer' && $pay_mode!='NEFT'){
               $errorMsgTemp.="<p class='rownosubHead'>Employee Pay Mode Should be (Cheque/Transfer/NEFT) -> <b>$pay_mode</b> </p>"; 
             }
         }
       
        if($dept){
             $dept_id = $payrollAdmin->getDeptId($dept, $comp_id);
             if(empty($dept_id)){
                $errorMsgTemp.="<p class='rownosubHead'>Incorrect Employee Department / Not Exist -> <b>$dept</b></p>";
             }
        }
        if($category_name){
             $category_id = $payrollAdmin->getCategorytId($category_name, $comp_id);
             if(empty($category_id)){
                $errorMsgTemp.="<p class='rownosubHead'>Incorrect Employee Category / Not Exist -><b>$category_name</b></p>";
             }
        }
        if($qualif){
            $qualif_id = $payrollAdmin->getQualifId($qualif, $comp_id);
             if(empty($qualif_id)){
                $errorMsgTemp.="<p class='rownosubHead'>Incorrect Employee Qualification / Not Exist -> <b>$qualif</b></p>";
             }
        }
        if($bank){
             $bank_id = $payrollAdmin->getBankId($bank, $comp_id);
             if(empty($bank_id)){
                $errorMsgTemp.="<p class='rownosubHead'>Incorrect Employee Bank Name / Not Exist -> <b>$bank</b></p>";
             }
        }
   
         if($desg){
                 $desg_id = $payrollAdmin->getDesgIdNew($desg, $comp_id);
             if(empty($desg_id)){
                $errorMsgTemp.="<p class='rownosubHead'>Incorrect Employee Bank Name / Not Exist -> <b>$bank</b></p>";
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
        //print_r($emapData);exit;
    //foreach ($csvData as $index => $emapData) {
      
        // Extract and sanitize data from the CSV
        $firstName = addslashes($emapData[0]); // First name
        $middleName = addslashes($emapData[1]); // Middle name
        $lastName = addslashes($emapData[2]); // Last name

        $gender = addslashes($emapData[3]); // Gender
        $bdate = !empty($emapData[4]) ? date('Y-m-d', strtotime(str_replace('/', '-', $emapData[4]))) : "2001-01-01"; // Birthdate
        $joindate = !empty($emapData[5]) ? date('Y-m-d', strtotime(str_replace('/', '-', $emapData[5]))) : "2001-01-01"; // Join date
        $due_date = !empty($emapData[6]) ? date('Y-m-d', strtotime(str_replace('/', '-', $emapData[6]))) : "2001-01-01"; // Due date
        $leftdate = !empty($emapData[7]) ? date('Y-m-d', strtotime(str_replace('/', '-', $emapData[7]))) : "0000-00-00"; // Left date
        $pfdate = !empty($emapData[8]) ? date('Y-m-d', strtotime(str_replace('/', '-', $emapData[8]))) : "2001-01-01"; // PF date
        $pfno = addslashes($emapData[9]); // PF number
        $esistatus = addslashes($emapData[10]); // ESI status
        $esino = addslashes($emapData[11]); // ESI number
        $dept = addslashes($emapData[12]); // Department
        $dept_id = $payrollAdmin->getDeptId($dept, $comp_id);
        $category_name = addslashes($emapData[13]); // Category
        $category_id = $payrollAdmin->getCategorytId($category_name, $comp_id);
        $qualif = addslashes($emapData[14]); // Qualification
        $qualif_id = $payrollAdmin->getQualifId($qualif, $comp_id);
        $mobile_no=addslashes($emapData[15]);
        $pay_mode=addslashes($emapData[16]);
        $bank = addslashes($emapData[17]); // Bank
        $bank_id = $payrollAdmin->getBankId($bank, $comp_id);
        $bankacno = addslashes($emapData[18]); // Bank account number
        $comp_ticket_no = addslashes($emapData[19]); // Company ticket number
        $panno = addslashes($emapData[20]); // PAN number
        $adharno = addslashes($emapData[21]); // Aadhar number
        $uan = addslashes($emapData[22]); // UAN number
        $married_status = addslashes($emapData[23]); // Married status
        $emp_add1 = addslashes($emapData[24]); // Address
        $desg = addslashes($emapData[25]); // Designation
        $desg_id = $payrollAdmin->getDesgIdNew($desg, $comp_id);

       
        // Set default password
        $password = 'chinmay123';
        $user_name = $payrollAdmin->generateUsername($firstName);

            // Print for debugging
            //echo "Generated Username: " . $user_name . "<br>";
            //echo "Default Password: " . $password . "<br>";

            // Insert employee data
            $empid = $payrollAdmin->insertCSVWiseEmployee(
                $comp_id,             // 1: $comp_id
                $user_id,             // 2: $user_id
                $user_name,           // 3: $user_name
                $password,            // 4: $password (default)
                $firstName,           // 5: $first_name
                $middleName,          // 6: $middle_name
                $lastName,            // 7: $last_name
                $gender,              // 8: $gender
                $bdate,               // 9: $bdate
                $joindate,            // 10: $joindate
                $due_date,            // 11: $due_date
                $leftdate,            // 12: $leftdate
                $pfdate,              // 13: $pfdate
                $pfno,                // 14: $pfno
                $esistatus,           // 15: $esistatus
                $esino,               // 16: $esino
                $dept_id,             // 17: $dept_id
                $category_id,         // 18: $category_id
                $qualif_id,           // 19: $qualif_id
                $mobile_no, // 20: $mobile_no
                $pay_mode, // 21: $pay_mode
                $bank_id,             // 22: $bank_id
                $bankacno,            // 23: $bankacno
                $comp_ticket_no,      // 24: $comp_ticket_no
                $panno,               // 25: $panno
                $adharno,             // 26: $adharno
                $uan,                 // 27: $uan
                $married_status,      // 28: $married_status
                $emp_add1,            // 29: $emp_add1
                $desg_id,             // 30: $desg_id
                $clientid             // 31: $clientid
            );
            //echo "******************".$empid;
            if($empid){
               $recCnt++; 
                $respf = $payrollAdmin->insertCSVWiseDeduct($comp_id, $empid, $user_id, $pfid, $esiid, $proftaxid, $lwfid);
            }
            // Insert employee deduction data
            
            
            // Print result of deduction insert for debugging
           // echo "Deduction Insert Result: " . $respf . "<br>";
             
        //}
    //}
}
echo "<p class='successMsg'>Record Inserted Successfully.  Count -".$recCnt."</p>";
}else{
    echo $errorMsg;
   
}
 echo '<button class="submitbtn" onclick="history.go(-1);">Back</button>';
fclose($file);
}
//header("Location: import-emp");
//die();
?>
