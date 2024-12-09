<?php
session_start();
error_reporting(0);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);

$doc_path=$_SERVER["DOCUMENT_ROOT"];
include ($doc_path.'/include_payroll_admin.php');

$setCounter = 0;

//$userObj=new user();
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
//$setExcelName = "employee_income";
$setExcelName = "employee_deduct";
$client=$_POST['cal'];
$left=$_POST['left'];
$rowclient=$payrollAdmin->displayClient($client);
$setRec1 =$payrollAdmin->exportEmpDeduct1($comp_id,$user_id,$client,$left);


//$setCounter1 = mysqli_num_fields($setRec1);
$setMainHeader ="Employee Id";$setMainHeader .="\t";
$setMainHeader .="Client Name";$setMainHeader .="\t";

$setMainHeader .="Name";
$setMainHeader .="\t";
$setData="";
$k=0;
$temp[]='';

//while($tRec1 = $setRec1->fetch_assoc()) {
foreach($setRec1 as $tRec1) {
    $setMainHeader .= $tRec1['deduct_heads_name'];
    $setMainHeader.="\t";
    $temp[$k]= $tRec1['mast_deduct_heads_id'];
    $k++;
}
$setMainHeader .="Total";
$setMainHeader .="\t";

 $tocount=sizeof($temp);

$setRec =$payrollAdmin->exportEmpDeduct2($comp_id,$user_id,$client);
//while($recq = $setRec->fetch_assoc()) {
foreach($setRec as $recq) {
    $rowLine = '';
    $value='';
    $fvalue = '"' . $recq['emp_id'] . '"' . "\t";
    $fvalue .= '"' . $rowclient['client_name'] . '"' . "\t";
    $fvalue .= '"' . $recq['name'] . '"' . "\t";

    $vtotal=0;
    for($j = 0; $tocount > $j; $j++){
         $setRec22 = $payrollAdmin->exportEmpDeduct3($temp [$j],$recq ['emp_id'],$comp_id,$user_id);
       // $setReccount = mysqli_num_rows($setRec22);
       // if($setReccount>0) {
       if(!empty($setRec22)) {
            foreach ($setRec22 as $rec22) {
                if( $rec22['calc_type'] =='7'){
                    $value1 = strip_tags(str_replace('"', '""', 'Yes')); 
                
                }
                else
                {
                $value1 = strip_tags(str_replace('"', '""', $rec22['std_amt']));
                }
                $value = '"' . $value1 . '"' . "\t";
                $vtotal=$vtotal+$rec22['std_amt'];
            }
        }
        else{
            $value = "\t";
        }
        $rowLine .=  $value;

        }
//    $setData .= trim($fvalue.$rowLine.$vtotal)."\n";
    $setData .= trim($fvalue.$rowLine.'0')."\n";
    }



$setData = str_replace("\r", "", $setData);

if ($setData == "") {
    $setData = "\nno matching records found\n";
}

ob_end_clean();


//This Header is used to make data download instead of display the data
header("Content-type: application/octet-stream");

header("Content-Disposition: attachment; filename=".$setExcelName.".xls");

header("Pragma: no-cache");
header("Expires: 0");

//It will print all the Table row as Excel file row with selected column name as header.
echo ucwords($setMainHeader)."\n".$setData."\n";
?>
