<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');


if($_SESSION['log_type']==2)
{
    
}else
{
    echo "<script>window.location.href='/payroll-logout';</script>";exit();
}
$client_id = $_REQUEST['clientid'];


$cl_name = $payrollAdmin->displayClient($client_id);

$cmonth = date("Y-m-t",strtotime($cl_name['current_month']));
$endmth=$cmonth;
$monthdays = $payrollAdmin->lastDay($cmonth);
$startmth = $payrollAdmin->firstDay($cmonth);

$sql = "update tran_employee te INNER JOIN employee e ON  e.emp_id = te.emp_id set te.client_id = e.client_id where e.client_id !=te.client_id";
$row= $payrollAdmin->updateTranday($sql);

$sql = "update tran_advance tadv INNER JOIN employee e ON  e.emp_id = tadv.emp_id set tadv.client_id = e.client_id where e.client_id !=tadv.client_id";
$row= $payrollAdmin->updateTranday($sql);

$sql = "update tran_days td INNER JOIN employee e ON  e.emp_id = td.emp_id set td.client_id = e.client_id where e.client_id !=td.client_id";
$row= $payrollAdmin->updateTranday($sql);


$SQL = "DELETE FROM tran_days td INNER JOIN employee e ON  e.emp_id = td.emp_id where td.client_id = '".$client_id."' and e.job_status = 'L'" ;
$row= $payrollAdmin->updateTranday($sql);

//echo "************";


// Checking data validity
      $sql = "update tran_days set invalid = '' where client_id ='".$client_id."'";
    $row= $payrollAdmin->updateTranday($sql);
	  
// step 1. checking for left employees in tran_days
	$sql = "SELECT emp_id,first_name,middle_name,last_name from `employee` emp WHERE  emp.client_id = '".$client_id."' and emp.job_status ='L' and emp.emp_id in (SELECT emp_id FROM tran_days)" ;
	$row1= $payrollAdmin->executeQuery($sql);
	
	if(count($row1))
		{echo "\n Days details are available for left employees.Records will be deleted.".chr(13).chr(10);
			foreach($row1 as $res){
				echo $res['first_name']." ".$res['middle_name']." ".$res['last_name'].chr(13).chr(10);
				$sql  = "delete from  tran_days  where emp_id ='".$res['emp_id']."'"; 
            	$row= $payrollAdmin->updateTranday($sql);
			}
		};


// step 1. checking for left employees in tran_employee
	$sql = "SELECT emp_id,first_name,middle_name,last_name from `employee` emp WHERE  emp.client_id = '".$client_id."' and emp.job_status ='L' and emp.emp_id in (SELECT emp_id FROM tran_employee)" ;
	$row1= $payrollAdmin->executeQuery($sql);
	
	if(count($row1))
		{echo "\n Days details are available for left employees.Records will be deleted.".chr(13).chr(10);
			foreach($row1 as $res){
				echo $res['first_name']." ".$res['middle_name']." ".$res['last_name'].chr(13).chr(10);
				$sql  = "delete from  tran_employee  where emp_id ='".$res['emp_id']."'"; 
            	$row= $payrollAdmin->updateTranday($sql);
			}
		};



  	$sql = "SELECT emp_id,first_name,middle_name,last_name from `employee`  emp WHERE  emp.client_id = '".$client_id."' and emp.job_status !='L' and joindate>= '$startmth' and emp.emp_id not in (SELECT emp_id FROM tran_days)" ;
	$row1= $payrollAdmin->executeQuery($sql);
	
	if(count($row1))
		{echo "\n Records will be added for following employee.".chr(13).chr(10);
			foreach ($row as $res){
				echo $res['first_name']." ".$res['middle_name']." ".$res['last_name'].chr(13).chr(10);
				$sql  = "insert into tran_days (emp_id,sal_month,client_id,comp_id,user_id,updatedby values ('".$res['emp_id']."','".$endmth."','".$client_id."','".$comp_id."','".$user_id."','".$user_id."'"; 
            	$row= $payrollAdmin->updateTranday($sql);
			}
		};

		
	//(presentday=0 .and. othours>0)
	$sql = "SELECT trd_id from tran_days WHERE  client_id = '".$client_id."' and present = 0 and othours >0" ;
	$row1= $payrollAdmin->executeQuery($sql);
	
	if(count($row1))
		{echo "\nInvalid Othours.Please Check Transction Days Details.";
			foreach($row1 as $res){
				$sql  = "update tran_days set invalid = concat(invalid,'OtHours-') where trd_id ='".$res['trd_id']."'"; 
            	$row= $payrollAdmin->updateTranday($sql);
			}
		};
	//All days calculation - Regular emloyees
												
     $sql = "SELECT trd_id FROM tran_days td inner join employee  emp  on emp.emp_id=td.emp_id where td.present+td.weeklyoff+td.paidholiday+td.sl+td.cl+td.pl+td.absent+td.otherleave != '".$monthdays."' and td.leftdate ='0000-00-00' and  td.client_id = '".$client_id."' and emp.joindate< '".$startmth."'" ;
	$row1= $payrollAdmin->executeQuery($sql);
	
	if(count($row1))
		{echo "\nInvalid Total Days for Regular Employee.Please Check Transaction Days Details.";
			foreach($row1 as $res){
				$sql  = "update tran_days set invalid = concat(invalid,'Days Total(R)-') where trd_id ='".$res['trd_id']."'"; 
            	$row= $payrollAdmin->updateTranday($sql);
			}
		};
		

	//All days calculation - Newly joined emloyees
												
 $sql = "SELECT trd_id FROM tran_days td inner join employee  emp  on emp.emp_id=td.emp_id where td.present+td.weeklyoff+td.paidholiday+td.sl+td.cl+td.pl+td.absent+td.otherleave != ('".$monthdays ."'-day(emp.joindate))+1 and td.leftdate ='0000-00-00' and  td.client_id = '".$client_id."'and  emp.joindate> '".$startmth."'"; 
	$row1= $payrollAdmin->executeQuery($sql);
	
	if(count($row1))
		{echo " Invalid Total Days.Please Check Transaction Days Details.";
			foreach($row1 as $res){
				$sql  = "update tran_days set invalid = concat(invalid,'Days Total(N)-') where trd_id ='".$res['trd_id']."'"; 
            	$row= $payrollAdmin->updateTranday($sql);
			}
		};

	//All days calculation - left emloyees
												
	$sql = "SELECT trd_id FROM tran_days td inner join employee  emp  on emp.emp_id=td.emp_id where td.present+td.weeklyoff+td.paidholiday+td.sl+td.cl+td.pl+td.absent+td.otherleave != ( day(td.leftdate) - day('".$startmth."'))+1 and td.leftdate !='0000-00-00' and  td.client_id = '".$client_id."' and  emp.joindate< '".$startmth."'" ;
	$row1= $payrollAdmin->executeQuery($sql);
	
	if(count($row1))
		{echo "Invalid Total Days.Please Check Transaction Days Details.";
			foreach($row1 as $res){
				$sql  = "update tran_days set invalid = concat(invalid,'Days Total(L)-') where trd_id ='".$res['trd_id']."'"; 
            	$row= $payrollAdmin->updateTranday($sql);
			}
		};
		
	

// Days checking is over.

//echo "$$$$$$$$$$$$$";

//Salary Calculation
	$sql = "select trd_id from tran_days where client_id = '".$client_id."' and invalid != ''";
	$row1= $payrollAdmin->executeQuery($sql);
	
	if(count($row1))
	{ ?>
		<br/>
	<?php 
		//echo   "Invalid flag. Can not Proceed.";
		//exit;
		}
//temp tables creation
$sql= "DROP TABLE IF EXISTS tab_inc".$user_id ;
$row= $payrollAdmin->updateTranday($sql);

$sql = "DROP TABLE IF EXISTS tab_ded".$user_id ;
$row= $payrollAdmin->updateTranday($sql);

$sql = "DROP TABLE IF EXISTS tab_emp".$user_id ;
$row= $payrollAdmin->updateTranday($sql);

$sql = "create table   tab_inc".$user_id ." as (select * from  tran_income where 1=2)";
$row= $payrollAdmin->updateTranday($sql);

$sql = "create table   tab_ded".$user_id ." as (select * from  tran_deduct where 1=2)";
$row= $payrollAdmin->updateTranday($sql);



$sql = "create table   tab_emp".$user_id ." as (select * from  tran_employee where 1=2)";
$row= $payrollAdmin->updateTranday($sql);




//insertion of data into temp tables.
$sql = "update tran_days td inner join emp_leave el on el.emp_id = td.emp_id  set td.plbal = el.ob-el.enjoyed  where el.leave_type_id = 5";
$row= $payrollAdmin->updateTranday($sql);

$sql = "update tran_days td inner join emp_leave el on el.emp_id = td.emp_id  set td.clbal = el.ob-el.enjoyed  where el.leave_type_id = 4";
$row= $payrollAdmin->updateTranday($sql);

 $sql = "insert into tab_inc".$user_id ." (`emp_id`, `sal_month`, `head_id`, `calc_type`, `std_amt`,`amount`)  select `emp_id`, '".$cmonth."', `head_id`, `calc_type`, `std_amt`,'0' from emp_income where emp_id in (select emp_id from tran_days where client_id = '".$client_id."')";
$row= $payrollAdmin->updateTranday($sql);

$sql = "insert into tab_ded".$user_id ." ( `emp_id`, `sal_month`, `head_id`, `calc_type`, `std_amt`,`amount`,bank_id)  select `emp_id`, '".$cmonth."', `head_id`, `calc_type`, `std_amt`,'0',bank_id from emp_deduct where emp_id in (select emp_id from tran_days where client_id = '".$client_id."')";
$row= $payrollAdmin->updateTranday($sql);

$sql = "select emp_id from tran_days where emp_id not in (select emp_id from tab_ded".$user_id ." where head_id = 1 or head_id =20) and  client_id = '".$client_id."'";
$row1= $payrollAdmin->executeQuery($sql);
if(count($row1) !=0)
		{
		    echo "<br><b>No PF Record for emp_id -  ".$row1[0]['emp_id']."</b><br>";//exit;
		}
	
$sql = "select emp_id from tran_days where emp_id not in (select emp_id from tab_ded".$user_id ." where head_id = 3 or head_id =23) and  client_id = '".$client_id."'";
$row1= $payrollAdmin->executeQuery($sql);
if(count($row1) !=0)
		{
			echo "<br><b>No Prof Tax Record for emp_id - ".$row1[0]['emp_id']."</b><br>";
		}
	

 $sql = "INSERT INTO tab_emp".$user_id ." (`emp_id`,`sal_month`, `client_id`, `desg_id`, `dept_id`, `qualif_id`, `bank_id`, `loc_id`, `paycode_id`, `bankacno`, `esistatus`,`esino`, `comp_ticket_no`, `married_status`, `comp_id`, `user_id`,`pfno`,`pay_mode`) select `emp_id`, '".$cmonth."', `client_id`, `desg_id`, `dept_id`, `qualif_id`, `bank_id`, `loc_id`, `paycode_id`, `bankacno`, `esistatus`,`esino`, `comp_ticket_no`, `married_status` ,'".$comp_id."','".$user_id."',`pfno`,`pay_mode` from employee where emp_id in  (select emp_id from tran_days where client_id = '".$client_id."')";
$row1= $payrollAdmin->updateTranday($sql);


//* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  
//payable days calculation ******************************************
// echo '#######';
$sql= "update tab_emp".$user_id." te inner join tran_days td  on td.emp_id = te.emp_id set te.payabledays =td.PRESENT+td.paidholiday+td.pl+td.cl+td.sl+td.additional+td.otherleave+td.weeklyoff where td.emp_id in (select emp_id from tab_inc".$user_id." inner join mast_income_heads on mast_income_heads.mast_income_heads_id = tab_inc".$user_id.".head_id where (mast_income_heads.`income_heads_name` LIKE '%BASIC%'  or mast_income_heads.`income_heads_name` LIKE '%CONSOLIDATED SALARY%') and mast_income_heads.comp_id = '".$comp_id."' and tab_inc".$user_id.".calc_type in( 2,4))  and te.client_id = '".$client_id."'" ;
$row1= $payrollAdmin->updateTranday($sql);

$sql= "update  tab_emp".$user_id." te inner join tran_days td  on td.emp_id = te.emp_id set te.payabledays =td.pl+td.cl+td.sl+td.additional+td.otherleave+td.PRESENT+td.paidholiday where td.emp_id in (select emp_id from tab_inc".$user_id." inner join mast_income_heads on mast_income_heads.mast_income_heads_id = tab_inc".$user_id.".head_id where (mast_income_heads. `income_heads_name` LIKE '%BASIC%'   or mast_income_heads.`income_heads_name` LIKE '%CONSOLIDATED SALARY%')and mast_income_heads.comp_id = '".$comp_id."' and tab_inc".$user_id.".calc_type in( 1,3,5,14) )  and te.client_id = '".$client_id."'" ;
$row1= $payrollAdmin->updateTranday($sql);
	

	
	
//**************************************************************************************************************************
//income calculation ******************************************
//type -1 26/27	
$sql = "update  tab_inc".$user_id." ti inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id   set ti.amount = round(ti.std_amt/26*te.payabledays,0)  where ti.calc_type= 1 and td.weeklyoff <4 and te.client_id = '".$client_id ."' and te.payabledays >0  ";
$row1= $payrollAdmin->updateTranday($sql);

$sql = "update  tab_inc".$user_id." ti inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id  set ti.amount = round(ti.std_amt/(day('".$endmth."')-td.weeklyoff)*te.payabledays,0)  where ti.calc_type= 1 and te.client_id = '".$client_id ."' and te.payabledays >0 " ;
$row1= $payrollAdmin->updateTranday($sql);

$sql = "update  tab_inc".$user_id." ti inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id   set ti.amount = 0  where  te.client_id = '".$client_id ."' and te.payabledays =0  ";
$row1= $payrollAdmin->updateTranday($sql);

//type -2 30/31	

$sql = "update tab_inc".$user_id."  ti inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id   set ti.amount = round(ti.std_amt/day('".$endmth."')*te.payabledays,0) where ti.calc_type= 2 and te.client_id = '".$client_id ."'";
// $sql = "update tab_inc".$user_id."  ti inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id   set ti.amount = round((ti.std_amt/30)*te.payabledays,2) where ti.calc_type= 2 and te.client_id = '".$client_id ."'";
$row1= $payrollAdmin->updateTranday($sql);


//type -14 26 days fixed 	
$sql = "update  tab_inc".$user_id." ti inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id   set ti.amount = round(ti.std_amt/26*te.payabledays,0)  where ti.calc_type=14  and te.client_id = '".$client_id ."'";
$row1= $payrollAdmin->updateTranday($sql);


//type -3Consolidated  
$sql = "update tab_inc".$user_id."  ti  inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id  set ti.amount = ti.std_amt where ti.calc_type= 3 and  te.client_id = '".$client_id ."'";
$row1= $payrollAdmin->updateTranday($sql);

//type -5 Daily wages
  $sql = "update tab_inc".$user_id."  ti  inner join tab_emp".$user_id ." te  on te.emp_id = ti.emp_id   set ti.amount = round(ti.std_amt*te.payabledays,0)  where ti.calc_type= 5 and te.client_id = '".$client_id ."'";
$row1= $payrollAdmin->updateTranday($sql);

//type -16 per presnt Day
 $sql = "update tab_inc".$user_id."  ti  inner join tran_days te on te.emp_id = ti.emp_id   set ti.amount = round(ti.std_amt*te.present,0)  where ti.calc_type= 16 and te.client_id = '".$client_id ."'";
$row1= $payrollAdmin->updateTranday($sql);

//type -14 26 days per month
 $sql = "update tab_inc".$user_id."  ti inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id   set ti.amount = round(ti.std_amt/26*te.payabledays,0) where ti.calc_type= 14 and te.client_id = '".$client_id ."'";
$row1= $payrollAdmin->updateTranday($sql);
 

//grosssalary updation in tab_emp for overtime calculation- 7 or 12 (GROSS-WASHING-(PAP ALL+PERTOL aLL))/8*2   /  (GROSS-WASHING-PAP ALL)/8 
$sql = "update tab_emp".$user_id ." te inner join (select emp_id,sum(amount) as amt from tab_inc".$user_id ." ti  where ti.head_id not in (select mast_income_heads_id from mast_income_heads  where  (`income_heads_name` LIKE '%PAP. ALW%' or `income_heads_name` LIKE '%WASHING ALW%' or `income_heads_name` LIKE '%PETROL ALW%') and comp_id = '".$comp_id."'  )  group by emp_id ) ti on te.emp_id = ti.emp_id  set te.gross_salary = ti.amt where te.client_id ='".$client_id ."'";


$row1= $payrollAdmin->updateTranday($sql);

//* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  

//Overtime Calculation - calc_type 7or 12

//calc_type -15 per hour 
$sql = "update tab_inc".$user_id."  ti  inner join tran_days td on td.emp_id = ti.emp_id   set ti.amount = round(ti.std_amt*td.othours,2)  where ti.calc_type in (4, 15) and td.client_id = '".$client_id ."'";
$row1= $payrollAdmin->updateTranday($sql);
 

$sql2 = "update tab_inc".$user_id ." ti inner join tab_emp".$user_id." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id      set std_amt = round((te.gross_salary*2)/(te.payabledays*8),0) ,amount = (round((te.gross_salary*2)/(te.payabledays*8),0 )) *td.othours  where ti.head_id in (select mast_income_heads_id from mast_income_heads  where  (`income_heads_name` LIKE '%OVERTIME%' ) and comp_id = '".$comp_id."'  ) and calc_type = 7"; 
$row1= $payrollAdmin->updateTranday($sql);

$sql2 = "update tab_inc".$user_id ." ti inner join tab_emp".$user_id." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id      set std_amt = round((te.gross_salary)/(te.payabledays*8),0 ) ,amount = (round((te.gross_salary)/(te.payabledays*8),0 )) *td.othours  where ti.head_id in (select mast_income_heads_id from mast_income_heads  where  (`income_heads_name` LIKE '%OVERTIME%' ) and comp_id = '".$comp_id."'  ) and calc_type = 12"; 
$row1= $payrollAdmin->updateTranday($sql);


//grosssalary updation in tab_emp for overtime calculation-11 (GROSS-CONVEYANCE)/8*2


$sql = "update tab_emp".$user_id ." te inner join (select emp_id,sum(amount) as amt from tab_inc".$user_id ." ti  where ti.head_id not in (select mast_income_heads_id from mast_income_heads  where  (`income_heads_name` LIKE '%CONVEYANCE%' ) and comp_id = '".$comp_id."'  )  group by emp_id ) ti on te.emp_id = ti.emp_id  set te.gross_salary = ti.amt where te.client_id ='".$client_id ."'";
$row1= $payrollAdmin->updateTranday($sql);



$sql2 = "update tab_inc".$user_id ." ti inner join tab_emp".$user_id." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id      set std_amt = round((te.gross_salary*2)/(te.payabledays*8),0 ) ,amount = (round((te.gross_salary*2)/(te.payabledays*8),0 )) *td.othours  where ti.head_id in (select mast_income_heads_id from mast_income_heads  where  (`income_heads_name` LIKE '%OVERTIME%' ) and comp_id = '".$comp_id."'  ) and calc_type = 11"; 
$row1= $payrollAdmin->updateTranday($sql);



//grosssalary updation in tab_emp for overtime calculation-13 (BASIC+DA)/8*2

$sql = "update tab_emp".$user_id ." te inner join (SELECT sum(amount) as amt,emp_id FROM tab_inc".$user_id." WHERE   head_id in (select mast_income_heads_id from mast_income_heads  where  (`income_heads_name` LIKE '%BASIC%' or `income_heads_name` LIKE '%D.A.%' OR `income_heads_name` LIKE '%wage%' ) and comp_id = '".$comp_id."') GROUP BY EMP_ID  ) ti on te.emp_id = ti.emp_id  set te.gross_salary = ti.amt where te.client_id ='".$client_id ."'";
$row1= $payrollAdmin->updateTranday($sql);

$sql2 = "update tab_inc".$user_id ." ti inner join tab_emp".$user_id." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id      set std_amt = round((te.gross_salary*2)/(te.payabledays*8),0 ) ,amount = (round((te.gross_salary*0)/(te.payabledays*8),0 )) *td.othours  where ti.head_id in (select mast_income_heads_id from mast_income_heads  where  (`income_heads_name` LIKE '%OVERTIME%' ) and comp_id = '".$comp_id."'  ) and calc_type = 13"; 
$row1= $payrollAdmin->updateTranday($sql);
	


//Overtime Calculation over * * * * * * * * * * * * * * * * * * * 





//* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  

//Night Shifts Calculation
 $sql = "update  tab_inc".$user_id." ti inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id   set ti.amount = round(20*td.nightshifts,2)  where ti.calc_type= 8 and td.nightshifts <= 15  and te.client_id = '".$client_id ."' and te.payabledays >0  ";

$row1= $payrollAdmin->updateTranday($sql);

$sql = "update  tab_inc".$user_id." ti inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id   set ti.amount = round(27*td.nightshifts,2)  where ti.calc_type= 8 and td.nightshifts > 15  and te.client_id = '".$client_id ."' and te.payabledays >0  ";
$row1= $payrollAdmin->updateTranday($sql);

$sql = "update  tab_inc".$user_id." ti inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id   set ti.amount = round(25*td.nightshifts,2)  where ti.calc_type= 9 and td.nightshifts <= 15  and  te.client_id = '".$client_id ."' and te.payabledays >0  ";
$row1= $payrollAdmin->updateTranday($sql);

$sql = "update  tab_inc".$user_id." ti inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id   set ti.amount = round(34.5*td.nightshifts,2)  where ti.calc_type= 9 and td.nightshifts > 15  and  te.client_id = '".$client_id ."' and te.payabledays >0  ";
$row1= $payrollAdmin->updateTranday($sql);


$sql = "update  tab_inc".$user_id." ti inner join tab_emp".$user_id ." te on te.emp_id = ti.emp_id  inner join tran_days td on td.emp_id = ti.emp_id   set ti.amount = round(ti.std_amt*td.nightshifts,2)  where ti.calc_type= 10 and td.nightshifts > 0  and  te.client_id = '".$client_id ."' and te.payabledays >0  ";
$row1= $payrollAdmin->updateTranday($sql);

//Night Shifts Calculation * * * * * * * * * * * * * * * * * * * * * 



$sql='';

//* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  

//Adding records of extra income1income2,extra deduction1,extra deduction2 to respective tables 
$sql = "select mast_income_heads_id as head_id from mast_income_heads  where  `income_heads_name` LIKE '%Income-1%' and  comp_id = '".$comp_id."'";
$row1= $payrollAdmin->executeQuery($sql);

$sql = "select emp_id,extra_inc1 from tran_days where client_id = '".$client_id ."' and extra_inc1 >0 ";
$row1tran= $payrollAdmin->executeQuery($sql);
foreach($row1tran as $row2)
{
  $sql = "insert into tab_inc".$user_id ." (emp_id,head_id,std_amt,amount,sal_month,calc_type) values ('".$row2['emp_id']."' ,'".$row1[0]['head_id']."','0','".$row2['extra_inc1']."','".$cmonth."','0')";
  $row3= $payrollAdmin->updateTranday($sql);
}

$sql='';
$sql = "select mast_income_heads_id as head_id from mast_income_heads  where  `income_heads_name` LIKE '%Income-2%' and  comp_id = '".$comp_id."'";
$row1= $payrollAdmin->executeQuery($sql);

$sql = "select emp_id,extra_inc2 from tran_days where client_id = '".$client_id ."' and extra_inc2 >0 ";
$row1tran= $payrollAdmin->executeQuery($sql);
foreach($row1tran as $row2 )
{
  $sql = "insert into tab_inc".$user_id ." (emp_id,head_id,std_amt,amount,sal_month,calc_type) values ('".$row2['emp_id']."' ,'".$row1[0]['head_id']."','0','".$row2['extra_inc2']."','".$cmonth."','0')";
  $row3= $payrollAdmin->updateTranday($sql);
	
}



$sql='';
$sql = "select mast_income_heads_id as head_id from mast_income_heads  where  `income_heads_name` LIKE '%LEAVE ENCASH.%' and  comp_id = '".$comp_id."'";
$row1= $payrollAdmin->executeQuery($sql);

$sql = "select emp_id,leave_encash from tran_days where client_id = '".$client_id ."' and leave_encash >0 ";
$row1tran= $payrollAdmin->executeQuery($sql);
foreach($row1tran as $row2)
{
  $sql = "insert into tab_inc".$user_id ." (emp_id,head_id,std_amt,amount,sal_month,calc_type) values ('".$row2['emp_id']."' ,'".$row1[0]['head_id']."','0','".$row2['leave_encash']."','".$cmonth."','0')";
  $row3= $payrollAdmin->updateTranday($sql);
	
}



//* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  

/*

//Adding records of wagediff  to respective tables 

if ($_REQUEST['wagediff']>0) 
	
	{
			$wagediffrate= $_REQUEST['wagediff'];

			 $sql2 = "SELECT last_day(date_Add('".$cmonth."',interval -1 month)) AS prev_month";
			$res1= mysql_query($sql2);
			$res2 = mysql_fetch_assoc($res1);

			 $res2['prev_month'];
		
			
			$sql11 = "select mast_income_heads_id as head_id from mast_income_heads  where  `income_heads_name` LIKE '%Wage Diff' and  comp_id = '".$comp_id."'";
			$row21= mysql_query($sql11);
			$row31 = mysql_fetch_assoc($row21);

			 $sql1 = "select td.emp_id,he.payabledays  from tran_days td inner join hist_employee he on he.emp_id = td.emp_id where td.client_id = '".$client_id ."' and he.sal_month = '".$res2['prev_month']." '";
			$row1= mysql_query($sql1);
			
			//$sql1= "SELECT sum(amount) as amount FROM hist_income WHERE   emp_id = '".$row1["emp_id"]."' and head_id in (select mast_income_heads_id from mast_income_heads  where  (`income_heads_name` LIKE '%BASIC%' or `income_heads_name` LIKE '%D.A.%'  ) and comp_id = '".$comp_id."'  )";
			
		
			while($row2 = mysql_fetch_assoc($row1))
			{
		   if ($row2['payabledays']>0)
		   {
						 $sql21 = "insert into tab_inc".$user_id ." (emp_id,head_id,std_amt,amount,sal_month,calc_type) values ('".$row2['emp_id']."' ,'".$row31['head_id']."','$wagediffrate','".round($row2['payabledays']*$wagediffrate,2)."','".$cmonth."','0')";
						$row22= mysql_query($sql21);						}
		   
			} 
		
		
	}
else*/
	
	{

        $sql='';
		$sql = "select mast_income_heads_id as head_id from mast_income_heads  where  `income_heads_name` LIKE '%Wage Diff' and  comp_id = '".$comp_id."'";
        $row1= $payrollAdmin->executeQuery($sql);

		$sql = "select emp_id,wagediff from tran_days where client_id = '".$client_id ."' and wagediff >0 ";
	 $row1tran= $payrollAdmin->executeQuery($sql);
	    foreach($row1tran as $row2)
		{
		   $sql = "insert into tab_inc".$user_id ." (emp_id,head_id,std_amt,amount,sal_month,calc_type) values ('".$row2['emp_id']."' ,'".$row1[0]['head_id']."','0','".$row2['wagediff']."','".$cmonth."','0')";
          $row3= $payrollAdmin->updateTranday($sql);
			
		}
	}
//* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  
//Adding records of allow_arrears to respective tables 
/*if ($_REQUEST['allowdiff']>0) 
	
	{
			$allowdiffrate= $_REQUEST['allowdiff'];
			$sql2 = "SELECT last_day(date_Add('".$cmonth."',interval -1 month)) AS prev_month";
			$res1= mysql_query($sql2);
			$res2 = mysql_fetch_assoc($res1);
			
		 $sql11 = "select mast_income_heads_id as head_id from mast_income_heads  where  `income_heads_name` LIKE '%ALW ARREARS' and  comp_id = '".$comp_id."'";
			$row21= mysql_query($sql11);
			$row31 = mysql_fetch_assoc($row21);

			 $sql1 = "select td.emp_id,he.payabledays  from tran_days td inner join hist_employee he on he.emp_id = td.emp_id where td.client_id = '".$client_id ."' and he.sal_month = '".$res2['prev_month']." '";
			$row1= mysql_query($sql1);
			
			//$sql1= "SELECT sum(amount) as amount FROM hist_income WHERE   emp_id = '".$row1["emp_id"]."' and head_id in (select mast_income_heads_id from mast_income_heads  where  (`income_heads_name` LIKE '%BASIC%' or `income_heads_name` LIKE '%D.A.%'  ) and comp_id = '".$comp_id."'  )";
			
		
			while($row2 = mysql_fetch_assoc($row1))
			{
		      if ($row2['payabledays']>0){
			   $sql21 = "insert into tab_inc".$user_id ." (emp_id,head_id,std_amt,amount,sal_month,calc_type) values ('".$row2['emp_id']."' ,'".$row31['head_id']."','$allowdiffrate','".round($row2['payabledays']*$allowdiffrate,2)."','".$cmonth."','0')";
				$row22= mysql_query($sql21);	
			}
		
		
	}}
else*/
	
	{
        $sql='';
		$sql = "select mast_income_heads_id as head_id from mast_income_heads  where  `income_heads_name` LIKE '%ALW ARREARS' and  comp_id = '".$comp_id."'";
		$row1= $payrollAdmin->executeQuery($sql);
		
		 $sql = "select emp_id,Allow_arrears from tran_days where client_id = '".$client_id ."' and Allow_arrears >0 ";
        $row1tran= $payrollAdmin->executeQuery($sql);
				foreach($row1tran as $row2)
		{
			$sql = "insert into tab_inc".$user_id ." (emp_id,head_id,std_amt,amount,sal_month,calc_type) values ('".$row2['emp_id']."' ,'".$row1[0]['head_id']."','0','".$row2['Allow_arrears']."','".$cmonth."','0')";
            $row3= $payrollAdmin->updateTranday($sql);
					
		}
	}
	
//* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  
	
//Adding records of ot arrears  to respective tables 

/*if ($_REQUEST['otdiff']>0) 
	
	{
			$otdiffrate= $_REQUEST['otdiff'];
			$sql2 = "SELECT last_day(date_Add('".$cmonth."',interval -1 month)) AS prev_month";
			$res1= mysql_query($sql2);
			$res2 = mysql_fetch_assoc($res1);
			
			$sql11 = "select mast_income_heads_id as head_id from mast_income_heads  where  `income_heads_name` LIKE '%OT. Aarrears' and  comp_id = '".$comp_id."'";
			$row21= mysql_query($sql11);
			$row31 = mysql_fetch_assoc($row21);

			$sql1 = "select td.emp_id,hd.othours  from tran_days td inner join hist_days hd on hd.emp_id = td.emp_id where td.client_id = '".$client_id ."' and hd.sal_month = '".$res2['prev_month']." '";
			$row1= mysql_query($sql1);
			
			
			while($row2 = mysql_fetch_assoc($row1))
			{ 
		
		      if ($row2['othours']>0){
					 $sql21 = "insert into tab_inc".$user_id ." (emp_id,head_id,std_amt,amount,sal_month,calc_type) values ('".$row2['emp_id']."' ,'".$row31['head_id'].		"','$otdiffrate','".round($row2['othours']*$otdiffrate,2)."','".$cmonth."','0')";
					$row22= mysql_query($sql21);	
					}
			  
			}
		
		
	}
else*/
	
	{

        $sql='';
		$sql = "select mast_income_heads_id as head_id from mast_income_heads  where  `income_heads_name` LIKE '%OT. Aarrears' and  comp_id = '".$comp_id."'";
		$row1= $payrollAdmin->executeQuery($sql);
		
		 $sql = "select emp_id,Allow_arrears from tran_days where client_id = '".$client_id ."' and Ot_arrears >0 ";
        $row1tran= $payrollAdmin->executeQuery($sql);
				foreach($row1tran as $row2)
		{
			$sql = "insert into tab_inc".$user_id ." (emp_id,head_id,std_amt,amount,sal_month,calc_type) values ('".$row2['emp_id']."' ,'".$row1[0]['head_id']."','0','".$row2['Allow_arrears']."','".$cmonth."','0')";
            $row3= $payrollAdmin->updateTranday($sql);
					
		}


	}


//grosssalary updation in tab_emp
$sql = "update tab_emp".$user_id ." te inner join (select emp_id,sum(amount) as amt from tab_inc".$user_id ." group by emp_id ) ti on te.emp_id = ti.emp_id  set te.gross_salary = ti.amt where te.client_id ='".$client_id ."'";
$row1= $payrollAdmin->updateTranday($sql);

//* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  


//PF Calculation
$sql = "SELECT e.bdate,t.*,e.desg_id  FROM tab_ded".$user_id." t inner join employee e on e.emp_id = t.emp_id inner join mast_deduct_heads md on md.mast_deduct_heads_id = t.head_id  WHERE md.`deduct_heads_name` LIKE '%P.F.%'  and md.comp_id = '".$comp_id."' and e.client_id = '".$client_id."'";
$row11= $payrollAdmin->executeQuery($sql);


foreach ($row11 as $row1) 
{ 

     $sql= "SELECT sum(amount) as amount FROM tab_inc".$user_id." WHERE   emp_id = '".$row1["emp_id"]."' and head_id in (select mast_income_heads_id from mast_income_heads  where  (`income_heads_name` LIKE '%BASIC%' or `income_heads_name` LIKE '%F.D.A.%' or `income_heads_name` LIKE '%V.D.A.%'  or `income_heads_name` LIKE '%wage%'  ) and comp_id = '".$comp_id."'  )";
    if($client_id==31 || $client_id==42){
     $sql= "SELECT sum(amount) as amount FROM tab_inc".$user_id." WHERE   emp_id = '".$row1["emp_id"]."' and head_id in (select mast_income_heads_id from mast_income_heads  where  (`income_heads_name` LIKE '%BASIC%'  or `income_heads_name` LIKE '%F.D.A.%' or `income_heads_name` LIKE '%V.D.A.%' or  `income_heads_name` LIKE '%wage%'  ) and comp_id = '".$comp_id."'  )";
      }
   $row3= $payrollAdmin->executeQuery($sql);

	$std_amt = '0';
	$employer_contri_2 = '0';
	$employer_contri_1 = '0';

	 if(intval($row3[0]["amount"]) > '15000' )
	{
		$std_amt = 15000;
		
	}
	else
	 {
		 $std_amt = round($row3[0]["amount"],0);
	}
		$amount = ROUND(($std_amt)*(12/100),0);
	$employer_contri_2 = ROUND(($std_amt)*0.0833,0);
	

    if($employer_contri_2 > 1250)
	{
		$employer_contri_2='1250';
	}
	
	
	
	$datediff =0;
//echo $endmth." *** ". $row1['bdate']."<br>";
	$datediff = $endmth - $row1['bdate'];
	 
	$todt1 = date('Y-m-d', strtotime($row1['bdate']. '-1 days'));
	$date1 = new DateTime($endmth);
	$date2 = $date1->diff(new DateTime($todt1));
	$date2->d.' days'."\n";
	 $year = $date2->y;
		
  if ($year >=58 ){ 	$employer_contri_2 = 0; 	}
	$employer_contri_1 = $amount - $employer_contri_2;
	
       $sql = "update tab_ded".$user_id." set std_amt = '".$std_amt."',amount = '".$amount."',employer_contri_1 ='".$employer_contri_1."',employer_contri_2 ='".$employer_contri_2."' where emp_id = '".$row1["emp_id"]."'and head_id = '".$row1["head_id"]."'"; 
        $row1= $payrollAdmin->updateTranday($sql);
	
	
	
}

// end of pf calculation

//* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  
//ESI Calculation


$d = explode("-", $cmonth);
$month =  $d['1'];



if( $month == '04' or  $month == '10')
{
$sql = "DROP TABLE IF EXISTS tab_esi".$user_id ;
$row1= $payrollAdmin->updateTranday($sql);


$sql = "DROP TABLE IF EXISTS tab_esi2".$user_id ;
$row1= $payrollAdmin->updateTranday($sql);

$sql = "create table   tab_esi".$user_id ." as (select * from  emp_income where 1=2)";
$row1= $payrollAdmin->updateTranday($sql);


//to find std income	
$sql = "insert into tab_esi".$user_id." select ei.* from emp_income ei inner join employee e on e.emp_id =ei.emp_id inner join mast_income_heads mi on ei.head_id = mi.mast_income_heads_id where e.client_id = '".$client_id ."' and e.job_status != 'L' and mi.deduct_esi is null";
$row1= $payrollAdmin->updateTranday($sql);
	
$sql = "update 	tab_esi".$user_id." set std_amt = std_amt*26 where calc_type = 4";
$row1= $payrollAdmin->updateTranday($sql);

$sql = "update 	tab_esi".$user_id." set std_amt = 0 where calc_type in (8,9,10)";
$row1= $payrollAdmin->updateTranday($sql);


$sql = "update tab_emp".$user_id ." te inner join (select emp_id,sum(std_amt) as amt from tab_esi".$user_id ." group by emp_id ) tesi on te.emp_id = tesi.emp_id  set te.esistatus = 'Y' where te.client_id ='".$client_id ."' and tesi.amt <=21000  ";
$row1= $payrollAdmin->updateTranday($sql);

$sql = "update tab_emp".$user_id ." te inner join (select emp_id,sum(std_amt) as amt from tab_esi".$user_id ." group by emp_id ) tesi on te.emp_id = tesi.emp_id  set te.esistatus = 'N' where te.client_id ='".$client_id ."' and tesi.amt >21000  ";
$row1= $payrollAdmin->updateTranday($sql);
}


// updating  totgrsal-OVERTIME in totdeduct field 
 $sql = "update tab_emp".$user_id ."  te inner join (select emp_id,sum(amount) as amt from tab_inc".$user_id ." where head_id  in(select mast_income_heads_id from mast_income_heads  where deduct_esi is null   and comp_id = '".$comp_id."'   ) group by emp_id) ti on ti.emp_id = te.emp_id  set te.tot_deduct = ti.amt where te.client_id = '".$client_id ."'";
 
/* IF (($client_id == 2 or $client_id == 25 or $client_id == 26) AND $comp_id ==1 )
 {
	$sql = "update tab_emp".$user_id ."  te inner join (select emp_id,sum(amount) as amt from tab_inc".$user_id ." where head_id  in(select mast_income_heads_id from mast_income_heads  where deduct_esi is null   and comp_id = '".$comp_id."' and mast_income_heads_id <>41   ) group by emp_id) ti on ti.emp_id = te.emp_id  set te.tot_deduct = ti.amt where te.client_id = '".$client_id ."'";
  
 }*/
$row1= $payrollAdmin->updateTranday($sql);

  //updating employee`s contribution

//echo $sql = "update tab_ded".$user_id ."  tdd inner join (select emp_id,tot_deduct,client_id  from tab_emp".$user_id ." where client_id =  '".$client_id ."' and  esistatus = 'Y' ) te on te.emp_id = tdd.emp_id  set tdd.std_amt =round(te.tot_deduct,0), tdd.amount = round((te.tot_deduct*0.0075)+0.49,0),tdd.employer_contri_1 = round((te.tot_deduct*0.0325),2) where te.client_id = '".$client_id ."' and  tdd.head_id  in(select mast_deduct_heads_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%E.S.I.%' and comp_id = '".$comp_id." ' )";
$sql = "update tab_ded".$user_id ."  tdd inner join (select emp_id,tot_deduct,client_id  from tab_emp".$user_id ." where client_id =  '".$client_id ."' and  esistatus = 'Y' ) te on te.emp_id = tdd.emp_id  set tdd.std_amt =round(te.tot_deduct,0), tdd.amount = round((te.tot_deduct*0.0075),0),tdd.employer_contri_1 = round((te.tot_deduct*0.0325),2) where te.client_id = '".$client_id ."' and  tdd.head_id  in(select mast_deduct_heads_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%E.S.I.%' and comp_id = '".$comp_id." ' )";
$row1= $payrollAdmin->updateTranday($sql);


///////End of esino`********************


//* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  
//Calculation of profession tax 
	

$sql = "update tab_ded".$user_id ."  tdd inner join (select temp.emp_id,temp.gross_salary,e.gender from tab_emp".$user_id ." temp INNER join employee e on e.emp_id = temp.emp_id  where temp.client_id = '".$client_id ."' )  te on tdd.emp_id = te.emp_id  set amount = 175  where te.gross_salary >=7501 and te.gross_salary < 10000 and te.gender = 'M' and head_id in (select mast_deduct_heads_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%PROF. TAX%'  and comp_id = '".$comp_id."')";
$row1= $payrollAdmin->updateTranday($sql);

$sql = "update tab_ded".$user_id ."  tdd inner join (select temp.emp_id,temp.gross_salary,e.gender from tab_emp".$user_id ." temp INNER join employee e on e.emp_id = temp.emp_id where temp.client_id = '".$client_id ."' ) te on tdd.emp_id = te.emp_id  set amount = 200  where te.gross_salary >=10000 and month('".$cmonth."')!=2  and head_id in (select mast_deduct_heads_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%PROF. TAX%' and comp_id = '".$comp_id."')";
$row1= $payrollAdmin->updateTranday($sql);

$sql = "update tab_ded".$user_id ."  tdd inner join (select temp.emp_id,temp.gross_salary,e.gender from tab_emp".$user_id ." temp INNER join employee e on e.emp_id = temp.emp_id where temp.client_id = '".$client_id ."' )  te on tdd.emp_id = te.emp_id  set amount = 300  where te.gross_salary >=10000 and month('".$cmonth."')=2 and head_id in (select mast_deduct_heads_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%PROF. TAX%'  and comp_id = '".$comp_id."') ";
$row1= $payrollAdmin->updateTranday($sql);

$sql = "update tab_ded".$user_id ."  tdd inner join (select temp.emp_id,temp.gross_salary,e.gender from tab_emp".$user_id ." temp INNER join employee e on e.emp_id = temp.emp_id  where temp.client_id = '".$client_id ."' )  te on tdd.emp_id = te.emp_id  set amount = 0  where te.gross_salary <25000  and te.gender = 'F' and head_id in (select mast_deduct_heads_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%PROF. TAX%'  and comp_id = '".$comp_id."')";
$row1= $payrollAdmin->updateTranday($sql);

//* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  
//Calculation of LABOURFUND welfare

$sql = "update tab_ded".$user_id ."  tdd inner join (select emp_id,gross_salary from tab_emp".$user_id ." where client_id ='".$client_id ."' ) te on tdd.emp_id = te.emp_id  set amount = 12,employer_contri_1 = 36  where te.gross_salary <=3000 and (month('".$cmonth."')=12 or month('".$cmonth."')=6 )and head_id in (select mast_deduct_heads_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%L.W.F.%' and comp_id = '".$comp_id."') and te.gross_salary> 0 ";
$row1= $payrollAdmin->updateTranday($sql);

$sql = "update tab_ded".$user_id ."  tdd inner join (select emp_id,gross_salary from tab_emp".$user_id ." where client_id= '".$client_id ."' ) te on tdd.emp_id = te.emp_id  set amount = 12,employer_contri_1 = 36  where te.gross_salary >3000 and (month('".$cmonth."')=12 or month('".$cmonth."')=6 )and head_id in (select mast_deduct_heads_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%L.W.F.%' and comp_id = '".$comp_id."') and te.gross_salary> 0 ";
$row1= $payrollAdmin->updateTranday($sql);


//* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  
//Calculation of tds10%

$sql = "update tab_ded".$user_id ."  tdd inner join (select emp_id,gross_salary from tab_emp".$user_id ." where client_id= '".$client_id ."' ) te on tdd.emp_id = te.emp_id  set amount = round(te.gross_salary*0.1,0),std_amt =te.gross_salary  where te.gross_salary >0 and  head_id in (select mast_deduct_heads_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%TDS (10%)%' and comp_id = '".$comp_id."') ";
$row1= $payrollAdmin->updateTranday($sql);

//* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  
//type -4 Consolidated  
 $sql = "update tab_ded".$user_id."  tdd  inner join tab_emp".$user_id ." te on te.emp_id = tdd.emp_id  set tdd.amount = tdd.std_amt where tdd.calc_type= 3 and  te.client_id = '".$client_id ."'";
$row1= $payrollAdmin->updateTranday($sql);


//* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  
//type -5 Daily wages
$sql = "update tab_ded".$user_id."  tdd inner join tab_emp".$user_id ." te on te.emp_id = tdd.emp_id   set tdd.amount = round(tdd.std_amt*te.payabledays,2)  where tdd.calc_type= 5 and te.client_id = '".$client_id ."'";
$row1= $payrollAdmin->updateTranday($sql);


//* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  
//Adding records of extra deduction1 extra deduction2 to respective tables 

$sql='';
$sql = "select mast_deduct_heads_id as head_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%Deduct-1%' and comp_id = '".$comp_id."'";
$row1= $payrollAdmin->executeQuery($sql);

$sql = "select emp_id,extra_ded1 from tran_days where client_id = '".$client_id ."' and extra_ded1 >0 ";
$row1tran= $payrollAdmin->executeQuery($sql);
foreach($row1tran as $row2)
{
	 $emp = $row2['emp_id'];
$sql = "insert into tab_ded".$user_id ." (emp_id,head_id,std_amt,amount,sal_month,calc_type) values ('".$emp."' ,'".$row1[0]['head_id']."','0','".$row2['extra_ded1']."','".$cmonth."','0')";
    $row3= $payrollAdmin->updateTranday($sql);
	
}



//* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  
//extra_deduct2

$sql='';
$sql = "select mast_deduct_heads_id as head_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%Deduct2%' and comp_id = '".$comp_id."'";
$row1= $payrollAdmin->executeQuery($sql);

$sql = "select emp_id,extra_ded1 from tran_days where client_id = '".$client_id ."' and extra_ded2 >0 ";
$row1tran= $payrollAdmin->executeQuery($sql);
foreach($row1tran as $row2)
{
	 $emp = $row2['emp_id'];
    $sql = "insert into tab_ded".$user_id ." (emp_id,head_id,std_amt,amount,sal_month,calc_type) values ('".$emp."' ,'".$row1[0]['head_id']."','0','".$row2['extra_ded2']."','".$cmonth."','0')";
    $row3= $payrollAdmin->updateTranday($sql);
	
}


//* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  
//Income Tax Deduction


$sql='';
$sql = "select mast_deduct_heads_id as head_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%INCOMETAX%' and comp_id = '".$comp_id."'";
$row1= $payrollAdmin->executeQuery($sql);

$sql = "select emp_id,extra_ded1 from tran_days where client_id = '".$client_id ."' and incometax >0 ";
$row1tran= $payrollAdmin->executeQuery($sql);
foreach($row1tran as $row2)
{
	 $emp = $row2['emp_id'];
    $sql = "insert into tab_ded".$user_id ." (emp_id,head_id,std_amt,amount,sal_month,calc_type) values ('".$emp."' ,'".$row1[0]['head_id']."','0','".$row2['incometax']."','".$cmonth."','0')";
    $row3= $payrollAdmin->updateTranday($sql);
	
}

//* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  
//Canteen Deduction



$sql='';
$sql = "select mast_deduct_heads_id as head_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%CANTEEN%' and comp_id = '".$comp_id."'";
$row1= $payrollAdmin->executeQuery($sql);

$sql = "select emp_id,canteen from tran_days where client_id = '".$client_id ."' and canteen >0 ";
$row1tran= $payrollAdmin->executeQuery($sql);
foreach($row1tran as $row2)
{
	 $emp = $row2['emp_id'];
    $sql = "insert into tab_ded".$user_id ." (emp_id,head_id,std_amt,amount,sal_month,calc_type) values ('".$emp."' ,'".$row1[0]['head_id']."','0','".$row2['canteen']."','".$cmonth."','0')";
    $row3= $payrollAdmin->updateTranday($sql);
	
}


//* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  
//deduction calculation 
//type -1 26/27	


$sql = "update  tab_ded".$user_id." tdd inner join tab_emp".$user_id ." te on te.emp_id = tdd.emp_id  inner join tran_days td on tdd.emp_id = td.emp_id   set tdd.amount = round(tdd.std_amt/26*te.payabledays,2)  where tdd.calc_type= 1 and td.weeklyoff <4 and te.client_id = '".$client_id ."' and te.payabledays >0  ";
$row1= $payrollAdmin->updateTranday($sql);

 $sql = "update  tab_ded".$user_id." tdd inner join tab_emp".$user_id ." te on te.emp_id = tdd.emp_id  inner join tran_days td on tdd.emp_id = td.emp_id  set tdd.amount = round(tdd.std_amt/(day('".$endmth."')-td.weeklyoff)*te.payabledays,2)  where tdd.calc_type= 1 and td.weeklyoff >=4 and te.client_id = '".$client_id ."' and te.payabledays >0 " ;
$row1= $payrollAdmin->updateTranday($sql);


//type -2 30/31	

$sql = "update tab_ded".$user_id."  tdd inner join tab_emp".$user_id ." te on te.emp_id = tdd.emp_id   set tdd.amount = round(tdd.std_amt/day('".$endmth."')*te.payabledays,0) where tdd.calc_type= 2 and te.client_id = '".$client_id ."'";
$row1= $payrollAdmin->updateTranday($sql);


$sql = "update  tab_ded".$user_id." tdd inner join tab_emp".$user_id ." te on te.emp_id = tdd.emp_id  inner join tran_days td on tdd.emp_id = td.emp_id   set tdd.amount = 0  where te.client_id = '".$client_id ."' and te.payabledays =0  and te.gross_salary = 0 ";
$row1= $payrollAdmin->updateTranday($sql);


//* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  
//Calculation of advances

$sql = "DROP TABLE IF EXISTS tab_adv".$user_id ;
$row1= $payrollAdmin->updateTranday($sql);

$sql = "create table   tab_adv".$user_id ." as (select * from  tran_advance where 1=2)";
$row1= $payrollAdmin->updateTranday($sql);

$sql = "INSERT INTO tab_adv".$user_id ." (`emp_id`, `comp_id`,`client_id`, `sal_month`, `head_id`, `calc_type`, `std_amt`, `amount`, `paid_amt`, `emp_advance_id` ) select `emp_id`, '".$comp_id."', '".$client_id."',  '".$cmonth."',`advance_type_id`,'0',adv_amount,`adv_installment`,'0',`emp_advnacen_id` from emp_advnacen where adv_installment > 0 and adv_amount-received_amt >0 and closed_on < '2001-01-01' and emp_id in  (select emp_id from tran_days where client_id = '".$client_id."')";
$row1= $payrollAdmin->updateTranday($sql);

$sql = "update tab_adv".$user_id ." tadv inner join (select emp_id,sum(amount) as amt,emp_advance_id  from hist_advance group by emp_id,emp_advance_id ) hadv on tadv.emp_id = hadv.emp_id and  tadv.emp_advance_id = hadv.emp_advance_id  set tadv.paid_amt = hadv.amt ";
$row1= $payrollAdmin->updateTranday($sql);

$sql = "update tab_adv".$user_id ." tadv set tadv.amount = std_amt-paid_amt where amount >=  std_amt-paid_amt";
//$row1= $payrollAdmin->updateTranday($sql);

$sql = "update tab_adv".$user_id ." tadv inner join tran_employee te on te.emp_id = tadv.emp_id  set tadv.amount = 0 where te.netsalary < tadv.amount";
$row1= $payrollAdmin->updateTranday($sql);

//* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  


// total_deductions  = 0 for netsalary = 0 or payabledays = 0;
$sql = "update  tab_ded".$user_id." tdd inner join tab_emp".$user_id ." te on te.emp_id = tdd.emp_id  set tdd.amount = 0  where te.client_id = '".$client_id ."' and te.payabledays =0  and te.gross_salary=0 ";
$row1= $payrollAdmin->updateTranday($sql);

$sql = "update  tab_adv".$user_id." tadv inner join tab_emp".$user_id ." te on te.emp_id = tadv.emp_id  set tadv.amount = 0  where te.client_id = '".$client_id ."' and te.payabledays =0  and te.gross_salary=0";
$row1= $payrollAdmin->updateTranday($sql);



//* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  
//totdeduct updation in tab_emp from tab_ded

$sql = "update tab_emp".$user_id ." te   set te.tot_deduct = 0 where te.client_id ='".$client_id ."'";
$row1= $payrollAdmin->updateTranday($sql);

$sql = "update tab_emp".$user_id ." te inner join (select emp_id,sum(amount) as amt from tab_ded".$user_id ." group by emp_id ) tdd on te.emp_id = tdd.emp_id  set te.tot_deduct = tdd.amt where te.client_id ='".$client_id ."'";
$row1= $payrollAdmin->updateTranday($sql);


$sql = "update tab_emp".$user_id ." te inner join (select emp_id,sum(amount) as amt from tab_adv".$user_id ." group by emp_id ) tadv on te.emp_id = tadv.emp_id  set te.tot_deduct = te.tot_deduct+tadv.amt where te.client_id ='".$client_id ."'";
$row1= $payrollAdmin->updateTranday($sql);


//* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  
//Calculation of netsalary


$sql = "update tab_emp".$user_id ." te  inner join tran_days td on te.emp_id = td.emp_id set te.netsalary = round(te.gross_salary - te.tot_deduct,0) where  te.client_id ='".$client_id ."'";
$row1= $payrollAdmin->updateTranday($sql);




/*
//Rounded Off Deduction
$sql11 = "select mast_deduct_heads_id as head_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%R.OFF%' and comp_id = '".$comp_id."'";
$row21= mysql_query($sql11);
$row31 = mysql_fetch_assoc($row21);

$sql1 = "select emp_id,    (( netsalary - (gross_salary-tot_deduct))*-1) as roundoff  from tab_emp".$user_id ." te  wherete.client_id = '".$client_id ."' and netsalary - (gross_salary-tot_deduct) != 0 ";
$row1= mysql_query($sql1);
while($row2 = mysql_fetch_assoc($row1))
{
	$sql21 = "insert into tab_ded".$user_id ." (emp_id,head_id,std_amt,amount,sal_month,calc_type) values ('". $row2['emp_id']."' ,'".$row31['head_id']."','0','".$row2['roundoff']."','".$cmonth."','0')";
	$row22= mysql_query($sql21);

	$sql = "update tab_emp".$user_id ." te   set te.tot_deduct = te.tot_deduct + ".$row2['roundoff']."  where  te.emp_id ='".$row2['emp_id']."'";
	$row= mysql_query($sql);
	
}*/

//*************************************
//Updating data into tran files

$sql = "DELETE FROM tran_employee WHERE emp_id IN ( SELECT emp_id FROM tran_days WHERE client_id= '".$client_id. "')";
$row1= $payrollAdmin->updateTranday($sql);

$sql = "DELETE FROM tran_deduct WHERE emp_id IN ( SELECT emp_id FROM tran_days WHERE client_id= '".$client_id. "')";
$row1= $payrollAdmin->updateTranday($sql);

$sql = "DELETE FROM tran_income WHERE emp_id IN ( SELECT emp_id FROM tran_days WHERE client_id= '".$client_id. "')";
$row1= $payrollAdmin->updateTranday($sql);

$sql = "DELETE FROM tran_advance WHERE emp_id IN ( SELECT emp_id FROM tran_days WHERE client_id= '".$client_id. "')";
$row1= $payrollAdmin->updateTranday($sql);



$sql = "DELETE FROM tran_employee WHERE emp_id  not IN ( SELECT emp_id FROM tran_days) ";
$row1= $payrollAdmin->updateTranday($sql);

$sql = "DELETE FROM tran_deduct WHERE emp_id  not IN ( SELECT emp_id FROM tran_days) ";
$row1= $payrollAdmin->updateTranday($sql);

$sql = "DELETE FROM tran_income WHERE emp_id  not IN ( SELECT emp_id FROM tran_days) ";
$row1= $payrollAdmin->updateTranday($sql);

$sql = "DELETE FROM tran_advance WHERE emp_id  not IN ( SELECT emp_id FROM tran_days) ";
$row1= $payrollAdmin->updateTranday($sql);


$sql = "insert into tran_employee select * from tab_emp".$user_id ;
$row1= $payrollAdmin->updateTranday($sql);

$sql = "insert into tran_income select * from tab_inc".$user_id ;
$row1= $payrollAdmin->updateTranday($sql);

$sql = "insert into tran_deduct select * from tab_ded".$user_id;
$row1= $payrollAdmin->updateTranday($sql);

$sql = "insert into tran_advance select * from tab_adv".$user_id;
$row1= $payrollAdmin->updateTranday($sql);

/*
//temp tables creation
$sql= "DROP TABLE IF EXISTS tab_inc".$user_id ;
$row= $payrollAdmin->updateTranday($sql);

$sql = "DROP TABLE IF EXISTS tab_ded".$user_id ;
$row= $payrollAdmin->updateTranday($sql);

$sql = "DROP TABLE IF EXISTS tab_emp".$user_id ;
$row= $payrollAdmin->updateTranday($sql);

$sql = "DROP TABLE IF EXISTS tab_adv".$user_id ;
$row1= $payrollAdmin->updateTranday($sql);
*/

echo "<b>Finished.</b>";
exit;




?>