<?php   

$mysqli = new mysqli("localhost","hrnewsuser","asfreshasever7!","hopes_payroll");

// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

/*---------------------------------Company Id 2---------------------------*/

 /*$filename ='../DBF/EMPLOYEE_Solution.csv';
		$count=0;  
		$file = fopen($filename, "r");
		//echo "Please wait.File is being uploaded.";
		$sql = "truncate table employee";
		$result = mysqli_query($mysqli,$sql);
		$sql = "truncate table emp_income";
		$result = mysqli_query($mysqli,$sql);
		$sql = "truncate table emp_deduct";
		$result = mysqli_query($mysqli,$sql);
		
		
	    while ($emapData = fgetcsv($file,10000, ",")) 
			
	    {
	        echo "<pre>";print_r($emapData);die;
			if($count>=5){
				
				echo $sql = "insert into employee (ticket_no,first_name,middle_name,last_name,emp_add1,pin_code,gender,dept,location,desgcode,permanentdate,bdate,joindate,leftdate,job_status,bankcode,bankacno,panno,pfno,esistatus,esino,adharno,uan,pay_mode,qualif,clientno)
                       values ('".addslashes($emapData[0])."','".addslashes($emapData[2])."','".addslashes($emapData[3])."','".addslashes($emapData[4])."','".addslashes($emapData[5])."','".addslashes($emapData[8])."','".addslashes($emapData[10])."','".addslashes($emapData[28])."','','".addslashes($emapData[50])."','','".addslashes(date("Y-m-d",strtotime($emapData[17])))."','".addslashes(date("Y-m-d",strtotime($emapData[18])))."','".addslashes(date("Y-m-d",strtotime($emapData[20])))."','C','".addslashes($emapData[15])."','".addslashes($emapData[16])."','".addslashes($emapData[49])."','".addslashes($emapData[23])."','".addslashes($emapData[25])."','".addslashes($emapData[26])."','".addslashes($emapData[52])."','".addslashes($emapData[57])."','".addslashes($emapData[14])."','".addslashes($emapData[29])."','".addslashes($emapData[1])."')";			
              
				$result = mysqli_query($mysqli,$sql);
				 $empid=mysqli_insert_id($mysqli);																						
				
				 
				 //deduct PF
				echo $sql = " INSERT INTO `emp_deduct`(`comp_id`, `emp_id`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark`, `db_addate`, `db_update`, `ticket_no`) VALUES ('2','".$empid."','4','1','7','12.00','',now(),now(),'".addslashes(intval($emapData[0]))."')";
				$result = mysqli_query($mysqli,$sql);
				
				 //deduct ESI
				echo $sql = " INSERT INTO `emp_deduct`(`comp_id`, `emp_id`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark`, `db_addate`, `db_update`, `ticket_no`) VALUES ('2','".$empid."','4','2','7','0.00','',now(),now(),'".addslashes(intval($emapData[0]))."')";
				$result = mysqli_query($mysqli,$sql);
				
				 //deduct PT
				echo $sql = " INSERT INTO `emp_deduct`(`comp_id`, `emp_id`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark`, `db_addate`, `db_update`, `ticket_no`) VALUES ('2','".$empid."','4','3','7','0.00','',now(),now(),'".addslashes(intval($emapData[0]))."')";
				 $result = mysqli_query($mysqli,$sql);
				 
				 //BASIC
				echo $sql = " insert into emp_income (emp_id,  `comp_id`, `ticket_no`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark`  ) values ($empid,'2', '".addslashes(intval($emapData[0]))."','4',1,2,".addslashes($emapData[30]).",'') ";
			
				 $result = mysqli_query($mysqli,$sql);
				 //HRA
				 $sql = " insert into emp_income (emp_id,  `comp_id`, `ticket_no`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark`  ) values ($empid,'2', '".addslashes(intval($emapData[0]))."','4',3,2,".addslashes($emapData[32]).",'') ";
				 $result = mysqli_query($mysqli,$sql);
				 
				//washing
				$sql = " insert into emp_income (emp_id,  `comp_id`, `ticket_no`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark`  ) values ($empid,'2', '".addslashes(intval($emapData[0]))."','4',6,2,".addslashes($emapData[40]).",'') ";
				 $result = mysqli_query($mysqli,$sql);
				 
				//DA
				$sql = " insert into emp_income (emp_id,  `comp_id`, `ticket_no`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark`  ) values ($empid,'2', '".addslashes(intval($emapData[0]))."','4',2,2,".addslashes($emapData[31]).",'') ";
				 $result = mysqli_query($mysqli,$sql);
				 
				 // Other Allow.
				 $sql = " insert into emp_income (emp_id,  `comp_id`, `ticket_no`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark`  ) values ($empid,'2', '".addslashes(intval($emapData[0]))."','4',5,2,".addslashes($emapData[41]).",'') ";
				 $result = mysqli_query($mysqli,$sql);
			
			}
			$count++;
	    }
		
		 $sql1 = " update employee set bdate=NULL where bdate='1970-01-01'";
		$result1 = mysqli_query($mysqli,$sql1);
		 $sql2 = " update employee set joindate=NULL where joindate='1970-01-01'";
		$result2 = mysqli_query($mysqli,$sql2);
		 $sql3 = " update employee set leftdate=NULL where leftdate='1970-01-01'";
		$result3 = mysqli_query($mysqli,$sql3);
		 $sql4 = " update employee set permanentdate=NULL ";
		$result3 = mysqli_query($mysqli,$sql4);
		
		 $sql5 = "update employee e INNER JOIN mast_dept md ON md.dept=e.dept set e.dept_id=md.mast_dept_id";
		$result3 = mysqli_query($mysqli,$sql5);
		
		 $sql6 = "update employee e INNER JOIN mast_qualif mq ON mq.qualif=e.qualif set e.qualif_id=mq.mast_qualif_id";
		$result3 = mysqli_query($mysqli,$sql6);
		
		 $sql7 = "update employee e INNER JOIN mast_bank mb ON mb.bankcode=e.bankcode set e.bank_id=mb.mast_bank_id";
		$result3 = mysqli_query($mysqli,$sql7);
		
		 $sql7 = "update employee e INNER JOIN mast_client mc ON mc.clientno=e.clientno set e.client_id=mc.mast_client_id";
		$result3 = mysqli_query($mysqli,$sql7);
		
		 $sql7 = "DELETE  FROM `emp_income` WHERE `std_amt` = 0.00";
		$result3 = mysqli_query($mysqli,$sql7);
		
		 $sql8 = "update employee set pay_mode='T'";
		$result3 = mysqli_query($mysqli,$sql8);
		
		 $sql8 = "UPDATE `employee` SET `married_status` = 'U'";
		$result3 = mysqli_query($mysqli,$sql8);
		
		
	    fclose($file);

		if($count>1)
		{
			echo "<script type=\"text/javascript\">
					alert(\"CSV File has been successfully Imported.\");
 				</script>";
			
		}
		
		
		*/
		
		
		
		
		
		/*---------------------------------Company Id 1---------------------------*/
		
		
		
		
		$filename ='../DBF/EMPLOYEE.csv';
		$count=0;  
		$file = fopen($filename, "r");
		//echo "Please wait.File is being uploaded.";
		/*$sql = "truncate table employee";
		$result = mysqli_query($mysqli,$sql);
		$sql = "truncate table emp_income";
		$result = mysqli_query($mysqli,$sql);
		$sql = "truncate table emp_deduct";
		$result = mysqli_query($mysqli,$sql);
		die;*/
	
	    while ($emapData = fgetcsv($file,10000, ",")) 
			
	    {
	        //echo "<pre>";print_r($emapData);die;
			if($count>=5){
				
				echo $sql = "insert into employee (ticket_no,first_name,middle_name,last_name,emp_add1,pin_code,gender,dept,location,desgcode,permanentdate,bdate,joindate,leftdate,job_status,bankcode,bankacno,panno,pfno,esistatus,esino,adharno,uan,pay_mode,qualif,clientno)
                       values ('".addslashes($emapData[0])."','".addslashes($emapData[2])."','".addslashes($emapData[3])."','".addslashes($emapData[4])."','".addslashes($emapData[5])."','".addslashes($emapData[8])."','".addslashes($emapData[10])."','".addslashes($emapData[28])."','','".addslashes($emapData[50])."','','".addslashes(date("Y-m-d",strtotime($emapData[17])))."','".addslashes(date("Y-m-d",strtotime($emapData[18])))."','".addslashes(date("Y-m-d",strtotime($emapData[20])))."','C','".addslashes($emapData[15])."','".addslashes($emapData[16])."','".addslashes($emapData[49])."','".addslashes($emapData[23])."','".addslashes($emapData[25])."','".addslashes($emapData[26])."','".addslashes($emapData[52])."','".addslashes($emapData[57])."','".addslashes($emapData[14])."','".addslashes($emapData[29])."','".addslashes($emapData[1])."')";			
              
				$result = mysqli_query($mysqli,$sql);
				 $empid=mysqli_insert_id($mysqli);																						
				
				 
				 //deduct PF
				echo $sql = " INSERT INTO `emp_deduct`(`comp_id`, `emp_id`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark`, `db_addate`, `db_update`, `ticket_no`) VALUES ('1','".$empid."','5','20','7','12.00','',now(),now(),'".addslashes(intval($emapData[0]))."')";
				$result = mysqli_query($mysqli,$sql);
				
				 //deduct ESI
				echo $sql = " INSERT INTO `emp_deduct`(`comp_id`, `emp_id`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark`, `db_addate`, `db_update`, `ticket_no`) VALUES ('1','".$empid."','5','21','7','0.00','',now(),now(),'".addslashes(intval($emapData[0]))."')";
				$result = mysqli_query($mysqli,$sql);
				
				 //deduct PT
				echo $sql = " INSERT INTO `emp_deduct`(`comp_id`, `emp_id`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark`, `db_addate`, `db_update`, `ticket_no`) VALUES ('1','".$empid."','5','22','7','0.00','',now(),now(),'".addslashes(intval($emapData[0]))."')";
				$result = mysqli_query($mysqli,$sql);
				
				 //deduct LWF
				echo $sql = " INSERT INTO `emp_deduct`(`comp_id`, `emp_id`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark`, `db_addate`, `db_update`, `ticket_no`) VALUES ('1','".$empid."','5','23','7','0.00','',now(),now(),'".addslashes(intval($emapData[0]))."')";
				 $result = mysqli_query($mysqli,$sql);
				 
				 //BASIC
				echo $sql = " insert into emp_income (emp_id,  `comp_id`, `ticket_no`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark`  ) values ($empid,'1', '".addslashes(intval($emapData[0]))."','5',17,2,".addslashes($emapData[30]).",'') ";
			
				 $result = mysqli_query($mysqli,$sql);
				 //HRA
				 $sql = " insert into emp_income (emp_id,  `comp_id`, `ticket_no`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark`  ) values ($empid,'1', '".addslashes(intval($emapData[0]))."','5',19,2,".addslashes($emapData[32]).",'') ";
				 $result = mysqli_query($mysqli,$sql);
				 
				//washing
				$sql = " insert into emp_income (emp_id,  `comp_id`, `ticket_no`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark`  ) values ($empid,'1', '".addslashes(intval($emapData[0]))."','5',31,2,".addslashes($emapData[40]).",'') ";
				 $result = mysqli_query($mysqli,$sql);
				 
				//DA
				$sql = " insert into emp_income (emp_id,  `comp_id`, `ticket_no`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark`  ) values ($empid,'1', '".addslashes(intval($emapData[0]))."','5',18,2,".addslashes($emapData[31]).",'') ";
				 $result = mysqli_query($mysqli,$sql);
				 
				 // Other Allow.
				 $sql = " insert into emp_income (emp_id,  `comp_id`, `ticket_no`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark`  ) values ($empid,'1', '".addslashes(intval($emapData[0]))."','5',21,2,".addslashes($emapData[41]).",'') ";
				 $result = mysqli_query($mysqli,$sql);
				 
			
			}
			$count++;
	    }
		
		 $sql1 = " update employee set bdate=NULL where bdate='1970-01-01'";
		$result1 = mysqli_query($mysqli,$sql1);
		 $sql2 = " update employee set joindate=NULL where joindate='1970-01-01'";
		$result2 = mysqli_query($mysqli,$sql2);
		 $sql3 = " update employee set leftdate=NULL where leftdate='1970-01-01'";
		$result3 = mysqli_query($mysqli,$sql3);
		 $sql4 = " update employee set permanentdate=NULL ";
		$result3 = mysqli_query($mysqli,$sql4);
		
		 $sql5 = "update employee e INNER JOIN mast_dept md ON md.dept=e.dept set e.dept_id=md.mast_dept_id";
		$result3 = mysqli_query($mysqli,$sql5);
		
		 $sql6 = "update employee e INNER JOIN mast_qualif mq ON mq.qualif=e.qualif set e.qualif_id=mq.mast_qualif_id";
		$result3 = mysqli_query($mysqli,$sql6);
		
		 $sql7 = "update employee e INNER JOIN mast_bank mb ON mb.bankcode=e.bankcode set e.bank_id=mb.mast_bank_id";
		$result3 = mysqli_query($mysqli,$sql7);
		
		 $sql7 = "update employee e INNER JOIN mast_client mc ON mc.clientno=e.clientno set e.client_id=mc.mast_client_id";
		$result3 = mysqli_query($mysqli,$sql7);
		
		 $sql7 = "DELETE  FROM `emp_income` WHERE `std_amt` = 0.00";
		$result3 = mysqli_query($mysqli,$sql7);
		
		 $sql8 = "update employee set pay_mode='T'";
		$result3 = mysqli_query($mysqli,$sql8);
		
		 $sql8 = "UPDATE `employee` SET `married_status` = 'U'";
		$result3 = mysqli_query($mysqli,$sql8);
		
		 $sql8 = "UPDATE `employee` SET `job_status` = 'L' where not isNULL (leftdate)";
		$result3 = mysqli_query($mysqli,$sql8);
		
		
	    fclose($file);

		if($count>1)
		{
			echo "<script type=\"text/javascript\">
					alert(\"CSV File has been successfully Imported.\");
 				</script>";
			
		}
		
		
		?>