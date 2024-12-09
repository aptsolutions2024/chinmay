<?php
session_start();
ob_start();
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
//error_reporting(E_ALL);
$doc_path=$_SERVER["DOCUMENT_ROOT"];
include ($doc_path.'/include_payroll_admin.php');

$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];

$id = $_REQUEST['id'];
$flag=$_REQUEST['flag'];


$resultee = $payrollAdmin->displayemployeeClientbyID($id);
// print_r($resultee);
// $setRec = $payrollAdmin->exportEmpData($comp_id,$user_id);
// $setCounter = mysqli_num_fields($setRec);
$setMainHeader="";
$setData="";

$wodaysstr='';

$result2 = $payrollAdmin->displayClient($id);
  // print_r($result2);

//echo "**************".$result2['short_name']."_".$result2['current_month'];
$setExcelName = "datewise_employee_details(". $result2['client_name'] ."_"  . date("M Y", strtotime($result2['current_month'])) .  ")";
//$setExcelName = "datewise_employee_details";
$setMainHeader .= "sal_month\temp_id\t emp_name\t";
$heading=array('day1', 'day2', 'day3', 'day4', 'day5', 'day6', 'day7', 'day8', 'day9', 'day10', 'day11', 'day12', 'day13', 'day14', 'day15', 'day16', 'day17', 'day18', 'day19', 'day20', 'day21', 'day22', 'day23', 'day24', 'day25', 'day26', 'day27', 'day28', 'day29', 'day30', 'day31', 'ot1', 'ot2', 'ot3', 'ot4', 'ot5', 'ot6', 'ot7', 'ot8', 'ot9', 'ot10', 'ot11', 'ot12', 'ot13', 'ot14', 'ot15', 'ot16', 'ot17', 'ot18', 'ot19', 'ot20', 'ot21', 'ot22', 'ot23', 'ot24', 'ot25', 'ot26', 'ot27', 'ot28', 'ot29', 'ot30', 'ot31');

    foreach ($heading as $head){
       
        $setMainHeader .= $head."\t";
    }

   $dt=$result2['current_month'];

 $current_month=date("M Y", strtotime($dt));
// echo  "Set Header-".$setMainHeader;exit;
 //echo "CURRENT_MONTH-". $current_month; exit;
if($flag!='YES' && $flag!='Existing'){
    foreach($resultee as $key=>$rec){
//	while($rec = $resultee->fetch_assoc())  {
        $rowLine = '';
        if($rec['emp_id'] || $rec['emp_id'] != "")  {
       
              //It escape all the special charactor, quotes from the data.
               $value1 = $rec['first_name']." ".$rec['middle_name']." ".$rec['last_name'];
               $value1 = strip_tags(str_replace('"', '""', $value1));
               $value1 = '"' . $value1 . '"' . "\t";
            
               $value2=$rec['emp_id'];
               $value2 = strip_tags(str_replace('"', '""', $value2));
               $value2 = '"' . $value2 . '"' . "\t";
               
               $value3 = '"' . $current_month . '"' . "\t";
               
               $rowLine .= $value3.$value2.$value1;
               $setData .= trim($rowLine)."\n";
        }
    }
}elseif($flag=='YES'){
   
    $WoDays=$result2['weekly_off'];
    $WoDaysarray=explode(",",$WoDays);
   // print_r($WoDaysarray);
    $wodaysstr='WO';
    $num_days = date("d", strtotime($result2['current_month']));
    $for_month = date("m",strtotime($result2['current_month']));
    $for_year = date("Y",strtotime($result2['current_month']));
   
               
       

   // echo "Number of days in the current month: $num_days";
 //  	while($rec = $resultee->fetch_assoc())  {
   foreach($resultee as $key=>$rec){
        $rowLine = '';
        if($rec['emp_id'] || $rec['emp_id'] != "")  {
       
                $value3 = '"' . $current_month . '"' . "\t";
                
              //It escape all the special charactor, quotes from the data.
               $value1 = $rec['first_name']." ".$rec['middle_name']." ".$rec['last_name'];
               $value1 = strip_tags(str_replace('"', '""', $value1));
               $value1 = '"' . $value1 . '"' . "\t";
            
               $value2=$rec['emp_id'];
               $value2 = strip_tags(str_replace('"', '""', $value2));
               $value2 = '"' . $value2 . '"' . "\t";
               
              
               
               $rowLine .= $value3.$value2.$value1;
               
               for($i=1;$i<=31;$i++){
                $dayname=strtolower(date('l',strtotime(date("$for_year-$for_month-$i"))));
                if (in_array($dayname, $WoDaysarray)) {
                   // echo "<br>EXIST :Week Day $i ".$dayname;  
                      $rowLine .= '"' . $wodaysstr . '"' . "\t";
                }else{
                        $rowLine .= '"PP"' . "\t";
                }
              
                
               }
               
               $setData .= trim($rowLine)."\n";
               
        }
    }
   

}elseif($flag=='Existing'){
   

    $num_days = date("d", strtotime($result2['current_month']));
    $for_month = date("m",strtotime($result2['current_month']));
    $for_year = date("Y",strtotime($result2['current_month']));

  // echo "Number of days in the current month: $num_days"."Current-month:".$result2['current_month'];exit;
   	//while($rec = $resultee->fetch_assoc())  {
   	  foreach($resultee as $key=>$rec){
   
    
        if($rec['emp_id'] || $rec['emp_id'] != "")  {
       
            $empDataRes = $payrollAdmin->exportTDDEmpData($rec['emp_id'],$result2['current_month']);
            $current_month='';
         // echo "<pre>";  print_r($empDataRes);echo "</pre>";exit;
        if(!empty($empDataRes)){
        //	foreach($empDataRes as $rec11){   
        	         $rowLine = '';
        	    
        	   $current_month=date("M Y", strtotime($empDataRes['sal_month']));
        	
               $value1 = '"' . $current_month . '"' . "\t";
               
               $value2=$empDataRes['emp_id'];
               $value2 = strip_tags(str_replace('"', '""', $value2));
               $value2 = '"' . $value2 . '"' . "\t";
               
              //It escape all the special charactor, quotes from the data.
               $value3 = $rec['first_name']." ".$rec['middle_name']." ".$rec['last_name'];
               $value3 = strip_tags(str_replace('"', '""', $value3));
               $value3 = '"' . $value3 . '"' . "\t";
              
               
               $rowLine .= $value1.$value2.$value3;
               
               for($i=1;$i<=31;$i++){
                   
                    $rowLine .= '"' . $empDataRes['day'.$i] . '"' . "\t";
               }
               for($i=1;$i<=31;$i++){
                   
                     $rowLine .= '"' . $empDataRes['ot'.$i] . '"' . "\t";
               }
               
               $setData .= trim($rowLine)."\n";
               
        	//}
        }
        }
    }
   
//exit;
}
    
$setData = str_replace("\r", "", $setData);

if ($setData == "") {
    $setData = "\nno matching records found\n";
}
// Flush and clean the buffer before outputting
ob_clean();
//This Header is used to make data download instead of display the data
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=".$setExcelName.".xls");
header("Pragma: no-cache");
header("Expires: 0");



//It will print all the Table row as Excel file row with selected column name as header.
echo ucwords($setMainHeader)."\n".$setData."\n";


?>

