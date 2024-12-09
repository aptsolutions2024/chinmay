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
if ($_FILES["file"]["size"] > 0) {
  
    // Open the file and read all data into an array
    $file = fopen($filename, "r");
   // $csvData = [];
   $incheads=[];
   $dedheads=[];
   $dedcol=[];
   $inccol=[];
    $row == 0;
    $errorMsg='';
    $recCnt=0;
    $skiprow=0;
    $inccnt = 0;
    $dedcnt =0 ;
    if($errorMsg==""){
        $file = fopen($filename, "r");
    while ($emapData = fgetcsv($file, 10000, ",")) {
        if ($skiprow < 6) {
            $skiprow++;
            if($skiprow==5){
                for($i=7;$i<=18;$i++){
                    if($i==10 || $i==17 || $i==18){continue;}
                    
                    if($i>6 && $i<19){
                       $incheads[$inccnt]=$payrollAdmin->getHeadIdFromName(strtoupper($emapData[$i]),"mast_income_heads","mast_income_heads_id","I");
                        $inccol[$inccnt]= $i;
                        $inccnt++;
                    }
                    /*if($i>17 && $i<23){
                        $colName = strtoupper($emapData[$i]);
                        if($i==18){
                            $colName = "ESI";
                        }
                        if($i==19){
                            $colName = "PF";
                        }
                        $colName='';
                       $dedheads[$dedcnt] = $payrollAdmin->getHeadIdFromName($colName,"mast_deduct_heads","mast_deduct_heads_id","D");
                       $dedcol[$dedcnt]=$i;
                       $dedcnt++;
                   }*/
                }
            }
            continue; // Skip the first 4 row (header)
        }
        $colName='';
        for($j=1;$j<=5;$j++){
            $dedheads[$j] = $payrollAdmin->getHeadIdFromName($j,"mast_deduct_heads","mast_deduct_heads_id","D");
        }
       
        // Extract and sanitize data from the CSV
        $remark = '';
        $emp_name = trim(addslashes($emapData[1])); // Excel Name column
        
        $name_arr = explode(" ",$emp_name); // split to get three names
        
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
        ////echo $firstName.'$$$$';
        $cat_name = trim(addslashes($emapData[6]));  //Excel Category column
        $emp_id = $payrollAdmin->getEmpId($firstName,$middleName,$lastName,$clientid);
        $cat_id = $payrollAdmin->getCatIdFromName(strtoupper($cat_name));
        //echo '<br>'.$emp_id.'-------';
        //echo $cat_id.'#';
        $cnt =0;
        $dcnt =0;
        foreach($incheads as $inc){
                $calc_type=2;
              $empIncId = $payrollAdmin->insertEmployeeIncome($comp_id,$user_id,$emp_id,$inc,$calc_type,addslashes($emapData[$inccol[$cnt]]),$remark);
                $cnt++;
        }
        foreach($dedheads as $ded){
                $calc_type=7;
                $empDedId = $payrollAdmin->insertEmployeeDeduct($comp_id,$user_id,$emp_id,$dedheads[$ded],$calc_type,0,$remark);
                $dcnt++;
        }
       if($cat_id!='' && $cat_id!=0 && $cat_id!=NULL){
            $empCatId = $payrollAdmin->updateCategoryInEmp($cat_id,$emp_id);
        }else{
            $empCatId = $payrollAdmin->updateCategoryInEmp(1,$emp_id);
        }
       
     $recCnt++; 
}
    echo "<p class='successMsg'>Record Inserted Successfully.  Count -".$recCnt."</p>";
}else{
    echo $errorMsg;
   
}
 echo '<button class="submitbtn" onclick="history.go(-1);">Back</button>';
fclose($file);
}
?>