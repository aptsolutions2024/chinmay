<?php
session_start();
//error_reporting(0);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);

$doc_path=$_SERVER["DOCUMENT_ROOT"];
include ($doc_path.'/include_payroll_admin.php');
//$userObj=new user();
$setCounter = 0;
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$setExcelName = "employee_income";
$client=$_POST['cal'];
$left=$_POST['left'];
$rowclient=$payrollAdmin->displayClient($client);
$setRec1 = $payrollAdmin->getExportIncome($comp_id,$user_id,$client,$left);

// $setCounter1 = mysqli_num_fields($setRec1);

$setData="";
$k=0;
$temp[]='';
$setMainHeader ="Employee Id";$setMainHeader .="\t";
$setMainHeader .="Client Name";$setMainHeader .="\t";

$setMainHeader .="Name";$setMainHeader .="\t";
$setMainHeader .="Join Date";
$setMainHeader .="\t";
//while($tRec1 = $setRec1->fetch_assoc()) {
//print_r($setRec1);exit;
foreach($setRec1 as $tRec1) {
    $setMainHeader .= $tRec1['income_heads_name'];
    $setMainHeader.="\t";
    $temp[$k]= $tRec1['mast_income_heads_id'];
    $k++;
}
$setMainHeader .="Total";
$setMainHeader .="\t";

  $tocount=sizeof($temp);
  $setRec = $payrollAdmin->getExportIncome1($comp_id,$user_id,$client,$left);
/*$setSql= "SELECT emp_id, concat(first_name,' ',middle_name,' ',last_name) as name,joindate FROM employee WHERE `comp_id`='".$comp_id."' AND `user_id`='".$user_id."' ";
if($client!='all' && $client!='0'){
    $setSql .= " AND client_id='".$client."'";
}



if($left=='no'){
    $setSql .= " AND job_status!='L'";
}

$setSql .= " order by emp_id,client_id,first_name,middle_name,last_name ";

$setRec = mysql_query($setSql);*/

//while($recq = $setRec->fetch_assoc()) {
foreach($setRec as $recq) {
    $rowLine = '';
    $value='';
    $fvalue = '"' . $recq['emp_id'] . '"' . "\t";
    $fvalue .= '"' . $rowclient['client_name'] . '"' . "\t";
    $fvalue .= '"' . $recq['name'] . '"' . "\t";
	$fvalue .= '"' . $recq['joindate'] . '"' . "\t";

    $vtotal=0;
    for($j = 0; $tocount > $j; $j++){
        /*$setSql22 = "SELECT std_amt FROM emp_income WHERE `head_id`= '" . $temp [$j] . "'  AND emp_id='" . $recq ['emp_id'] . "'  AND `comp_id`='" . $comp_id . "' AND `user_id`='" . $user_id . "' ";
        $setRec22 = mysql_query($setSql22);*/
        $setRec22 = $payrollAdmin->getExportIncome2($temp [$j],$recq ['emp_id'],$comp_id,$user_id);
        
        // $setReccount = mysqli_num_rows($setRec22);
        $setReccount = sizeof($setRec22);
        if(!empty($setRec22)) {
            // while ($rec22 = $setRec22->fetch_assoc()) {
             foreach ($setRec22 as $rec22) {
                $value1 = strip_tags(str_replace('"', '""', $rec22['std_amt']));
                $value = '"' . $value1 . '"' . "\t";
                $vtotal=$vtotal+$rec22['std_amt'];
            }
        }
        else{
            $value = "\t";
        }
        $rowLine .=  $value;

        }
    $setData .= trim($fvalue.$rowLine.$vtotal)."\n";
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
