<?php 
session_start();
//print_r($_SESSION);
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
//ini_set('max_execution_time',900);
//set_time_limit(900);
error_reporting(0);
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');
//  echo "HELLO";

$startday = $_SESSION['startbonusyear'];
$endday = $_SESSION['endbonusyear'];
$user = $_SESSION['log_id'];
$compid = $_SESSION['comp_id'];

$client = $_REQUEST['client'];
$type = $_REQUEST['type'];
$comptype = $_REQUEST['comptype'];


 $exgratia = $_REQUEST['exgratia'];
 $bonusrate = $_REQUEST['bonusrate'];
 $amount = $_REQUEST['amount'];
// print_r($_REQUEST);
 
// $sql = "select count(emp_id) as cnt from bonus where client_id='".$client."' and from_date = '".$startday."' and todate ='".$endday."' and locked='1'";
$sql = "select count(emp_id) as cnt from bonus where client_id='".$client."' and from_date >= '".$startday."' and todate <='".$endday."' ";

// echo $sql;

$res2 = $payrollAdmin->executeQuery($sql);
// print_r($res2);exit;
if ($res2['cnt'] >0)
 {
     echo "Data is locked. Bonus Calculation cannot be done.";
     exit;
 }
// echo "ERRORRRRRRR";
 
$sqlchk ="delete from bonus where client_id='".$client."' and from_date = '".$startday."' and todate ='".$endday."'";
// echo $sqlchk;
$rowchk = $payrollAdmin->executeQuery($sqlchk);
	
 if ($comptype=="new"){
 $sql2 = "select distinct(e.emp_id),e.client_id,e.bank_id,e.bankacno,e.pay_mode from employee e inner join hist_employee he on e.emp_id=he.emp_id where e.client_id='".$client."' and he.sal_month>= '".$startday."' and he.sal_month <= '".$endday."' order by he.emp_id,he.sal_month";
 }
 else
 {$sql2 = "select distinct(e.emp_id),e.client_id, e.bank_id,e.bankacno,e.pay_mode from employee e inner join hist_employee he on e.emp_id=he.emp_id where he.client_id='".$client."' and he.sal_month>= '".$startday."' and he.sal_month <= '".$endday."'  order by he.emp_id,he.sal_month";

     
 }
// echo $sql2;
$row2 =$payrollAdmin->executeQuery($sql2);
// print_r($row2);

// while($res2 = mysql_fetch_array($row2)){
    foreach($row2 as $res2){
        // echo "##############";
	
	
// 	echo "111111";
	if($res2['emp_id'] !=0){
		 echo " Record has been deleted for  Employee  : ".$res2['emp_id'] ." from Client : ".$res2['client_id']." <br>";
		$sqlchk ="delete from bonus where emp_id='".$res2['emp_id']."' and from_date = '".$startday."' and todate ='".$endday."' and client_id='".$client."'";
		$rowchk = $payrollAdmin->executeQuery($sqlchk);
		
	 	 $sql1 = "insert into bonus(from_date,todate,emp_id,bank_id,bankacno,pay_mode,calc_type,bonus_rate,exgratia_rate,user_id,comp_id,updated,client_id) values ('".$startday."','".$endday."','".$res2['emp_id']."','".$res2['bank_id']."','".$res2['bankacno']."','".$res2['pay_mode']."','".$type."','".$bonusrate."','".$exgratia."','".$user."','".$compid."',now(),'$client')";
// echo $sql;
		$res1 = $payrollAdmin->insertQuery($sql1);
// 		echo($res1);
		 $lastinsid = $res1;
	
		$condition= ' id = '.		$lastinsid;
		
		
	}
// echo "!!!!!!!!";
     if ($comptype=="new"){
	     $sql3 ="select sum(ti.amount) amount,te.emp_id empid, mih.income_heads_name head_name,
		    te.sal_month sal_month,te.payabledays  payabledays ,td.* from hist_employee te
		    inner join hist_income ti on te.emp_id = ti.emp_id and ti.sal_month=te.sal_month
		    inner join hist_days td on te.emp_id = td.emp_id and td.sal_month=te.sal_month		
		    inner join mast_income_heads mih on mih.mast_income_heads_id = ti.head_id
		    where te.emp_id ='".$res2['emp_id']."' and (mih.income_heads_name like '%Basic%' or mih.income_heads_name like '%D.A.%' or mih.income_heads_name like '%WAGE DIFF%' ) and mih.comp_id ='".$_SESSION['comp_id']."' and  te.sal_month between '".$startday."' and '".$endday."' group by te.sal_month"; 
        }
     else{
         	 $sql3 ="select sum(ti.amount) amount,te.emp_id empid, mih.income_heads_name head_name,
		        te.sal_month sal_month,te.payabledays payabledays  from hist_employee te
		        inner join hist_income ti on te.emp_id = ti.emp_id and ti.sal_month=te.sal_month
		        inner join mast_income_heads mih on mih.mast_income_heads_id = ti.head_id
		        where te.emp_id ='".$res2['emp_id']."' and (mih.income_heads_name like '%Basic%' or mih.income_heads_name like '%D.A.%' or mih.income_heads_name like '%WAGE DIFF%' ) and mih.comp_id ='".$_SESSION['comp_id']."' and  te.sal_month between '".$startday."' and '".$endday."' and te.client_id = '$client' group by te.sal_month
		        union select sum(ti.amount) amount,te.emp_id empid, mih.income_heads_name head_name,
        		te.sal_month sal_month,te.payabledays payabledays from tran_employee te
        		inner join tran_income ti on te.emp_id = ti.emp_id and ti.sal_month=te.sal_month 
		    	inner join mast_income_heads mih on mih.mast_income_heads_id = ti.head_id
		        where te.emp_id ='".$res2['emp_id']."' and (mih.income_heads_name like '%Basic%' or mih.income_heads_name like '%D.A.%' or mih.income_heads_name like '%WAGE DIFF%' ) and mih.comp_id ='".$_SESSION['comp_id']."' and  te.sal_month between '".$startday."' and '".$endday."' and te.client_id = '$client' group by te.sal_month"; 
        } 
       
		$res3 = $payrollAdmin->executeQuery($sql3) ;		
// 		print_r($res3);exit;
		$bonusamttot =0;
		$exgratiatot =0;
		
		$sql1="update bonus set ";
		
			$totbonus =0;
			$totexgra=0;
			$totpayable=0;
			
		foreach($res3 as $row3){
			$month = date('m',strtotime($row3['sal_month']));
			$monthstr = strtolower(date('M',strtotime($row3['sal_month'])));
			$monthdays = 0;
			$monthdays2 =0;
			if($month == 1 ||$month == 3 || $month == 5||$month == 7||$month == 8||$month == 10||$month == 12){
				
				$monthdays = 26;
				$monthdays2 = 31;
			}else if($month == 4 ||$month == 6 || $month == 9||$month == 11){
				
				$monthdays = 25;
				$monthdays2 =30;
			}else if($month == 2){
				$year= date("Y",strtotime($row3['sal_month']));
				if ((($year % 4) == 0) && ((($year % 100) != 0) || (($year % 400) == 0))) 
					{$monthdays = 25;$monthdays2 = 29; }
				else
					{$monthdays = 24;$monthdays2 = 28;}
			}
			$amt = $row3['amount'];
		
		
			if($type =='2' &&  $row3['amount'] != $amount){
				$amt = $amount;	
				$amt = round($amt*$row3['payabledays']/$monthdays2,2);
				if ($amt > $amount){$amt = $amount;}
			}
			else if($type =='3'){
				$amt = $amount;
				
			//	$monthdays=26;//new addition for Apr2020-Mar2021
                $amt = $amount; //new addition for Apr2020-Mar2021
	  	    	if ($month==4 and 	date('Y',strtotime($row3['sal_month']))=="2020" and $res2['emp_id']!=7 ) { $amt=7000;$monthdays=30;}
	   			if ($month==11 and 	date('Y',strtotime($row3['sal_month']))=="2020" and $res2['emp_id']!=7 ) { $amt=7000;$monthdays=25;}
	   			if ($month==02 and 	date('Y',strtotime($row3['sal_month']))=="2021" and $res2['emp_id']!=7 ) { $amt=7000;$monthdays=24;}
	   			if (
	   			    (     (($month==12 || $month==10 ||$month==07 )and 	date('Y',strtotime($row3['sal_month']) )=="2020" ) || ($month==03 and 	date('Y',strtotime($row3['sal_month'])) =="2021" ) ) 
	   			    
	   			    
	   			    and $res2['emp_id']!=7
	   			    ) { $amt=7000;$monthdays=27;}
	   		    if ($month==02 and 	date('Y',strtotime($row3['sal_month']))!="2024"  ) { $amt=7000;$monthdays=24;}
	   		   if ($month==02 and 	date('Y',strtotime($row3['sal_month']))=="2024"  ) { $amt=7000;$monthdays=25;}
	   			
	   		 /*   Mar dec oct jul 27
	   		    Feb- 24
	   		    jan sep aug jun may 26
	   		    nov 25
	   		    apr 30 */
	   		    $amt = round($amt*$row3['payabledays']/$monthdays,2);
	     	if ($amt > $amount   ){$amt = $amount;}
	     	}
			else{
				$amt = $row3['amount'];
				
			}
			
	    	$bonusamt = ($amt)*$bonusrate/100;
			$exgratiaamt = $amt*$exgratia/100; //default 11.67
			$totbonus= $totbonus+$bonusamt;
			$totexgra =$totexgra+$exgratiaamt;
			$totpayable=$totpayable+$row3['payabledays'];
			$sql1 = $sql1. $monthstr."_wages = '".$row3['amount']."',".$monthstr."_bonus_wages = '".$amt."',".$monthstr."_payable_days = '".$row3['payabledays']."',".$monthstr."_bonus_amt = '".$bonusamt."',".$monthstr."_exgratia_amt = '".$exgratiaamt."',";
			
		}	
		$sql1 = $sql1."tot_bonus_amt = '".round($totbonus,0)."',tot_exgratia_amt = '".round($totexgra,0)."',tot_payable_days ='".$totpayable."'   where emp_id ='".$res2['emp_id']."' and  from_date = '".$startday ."' and todate = '".$endday."' and  client_id = '$client'";			
	    $payrollAdmin->executeQuery($sql1);
	
		$update6 = "update bonus set tot_payable_days = apr_payable_days + may_payable_days+jun_payable_days+jul_payable_days+aug_payable_days+sep_payable_days+oct_payable_days+nov_payable_days+dec_payable_days+jan_payable_days+feb_payable_days+mar_payable_days where   from_date = '".$startday ."' and todate = '".$endday."' and  client_id = '$client' ";
		$payrollAdmin->executeQuery($update6);		
			
}
 $update6 = "update bonus set tot_bonus_amt = 7000 where tot_bonus_amt = 6997 and  from_date = '".$startday ."' and todate = '".$endday."' ";
$payrollAdmin->executeQuery($update6);		

if ($type =="3"){
	  $update6 = "update bonus set tot_bonus_amt = tot_bonus_amt - ((tot_bonus_amt+tot_exgratia_amt)-16800) where tot_bonus_amt+tot_exgratia_amt >16800 and  from_date = '".$startday ."' and todate = '".$endday."' and  client_id = '$client' ";
    $payrollAdmin->executeQuery($update6);		
	  $update6 = "update bonus set tot_bonus_amt = tot_bonus_amt - ((tot_bonus_amt+tot_exgratia_amt)-16800) where tot_bonus_amt+tot_exgratia_amt >16800 and  from_date = '".$startday ."' and todate = '".$endday."' ";
    $payrollAdmin->executeQuery($update6);		
			
	
}


?>