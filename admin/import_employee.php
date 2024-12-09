<?php       
$con=mysql_connect("localhost","root","");
 mysql_select_db("trial",$con)
or die("Could not connect trial");

if(!$con){
    die('Could not connect: '.mysql_error());
}

 $filename ='c:/jsm/employee1610.csv';
		$count=0;  
		$file = fopen($filename, "r");
		echo "Please wait.File is being uploaded.";
		$sql = "delete from employee";
		$result = mysql_query($sql);
		$sql = "delete from emp_income";
		$result = mysql_query($sql);
		$sql = "delete from emp_deduct";
		$result = mysql_query($sql);
		
			
	    while ($emapData = fgetcsv($file,10000, ",")) 
			
	    {
			if($count>=5){
				
				echo $sql = "insert into employee (ticket_no,first_name,middle_name,last_name,emp_add1,pin_code,gender,dept,location,desgcode,permanentdate,bdate,joindate,leftdate,job_status,bankcode,bankacno,panno,pfno,esistatus,esino,prnsrno)
                       values (	'".addslashes($emapData[1])."','".addslashes($emapData[2])."','".addslashes($emapData[3])."','".addslashes($emapData[4])."','".addslashes($emapData[5]).addslashes($emapData[6])."','".addslashes($emapData[8])."','".addslashes($emapData[9])."','".addslashes($emapData[10])."','".addslashes($emapData[11])."','".addslashes($emapData[12])."','".addslashes($emapData[13])."','".addslashes($emapData[14])."','".addslashes($emapData[15])."','".addslashes($emapData[16])."','".addslashes($emapData[17])."','".addslashes($emapData[18])."','".addslashes($emapData[19])."','".addslashes($emapData[36])."','".addslashes($emapData[37])."','".addslashes($emapData[39])."','".addslashes($emapData[40])."','".addslashes($emapData[43])."')";			
//																								employee	ticket_no-1	first_name-2	middle_name-3	last_name-4	emp_add1-5+6			pin_code-8	gender-9	dept-10	location-11	desgcode-12	permanentdate-13																																					bdate-14	joindate-15	leftdate-16	job_status-17	bankcode-18	bankacno-19																	panno-36																							pfno-37		esistatus-39	esino-40			prnsrno-43					
				$result = mysql_query($sql);
				  $empid=mysql_insert_id();
				
//emp_income	15-head_id 20-basic	9-head_id 21-hra	10-head_id 22-conveyance	11-head_id 23-cca	12-head_id 24-washing	13-head_id 25 -otheralw																							

				 //BASIC
				echo $sql = " insert into emp_income (emp_id,  `comp_id`, `ticket_no`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark`  )
				                       values     ($empid,'3', '".addslashes(intval($emapData[1]))."','4',15,2,".addslashes($emapData[20]).",'') ";
				 $result = mysql_query($sql);
				 //HRA
				 $sql = " insert into emp_income ( emp_id, `comp_id`, `ticket_no`,  `user_id`, `head_id`, `calc_type`, `std_amt`, `remark`  )
				                       values     ($empid,'3', '".addslashes(intval($emapData[1]))."','4',9,2,".addslashes($emapData[21]).",'') ";
				 $result = mysql_query($sql);
				 //conveyance
				 $sql = " insert into emp_income ( emp_id, `comp_id`, `ticket_no`,  `user_id`, `head_id`, `calc_type`, `std_amt`, `remark`  )
				                       values     ($empid,'3', '".addslashes(intval($emapData[1]))."','4',10,2,".addslashes($emapData[22]).",'') ";
				 $result = mysql_query($sql);
				 
				 //City Comp. Allow
						 $sql = " insert into emp_income ( emp_id, `comp_id`, `ticket_no`,  `user_id`, `head_id`, `calc_type`, `std_amt`, `remark`  )
				                       values     ($empid,'3', '".addslashes(intval($emapData[1]))."','4',11,2,".addslashes($emapData[23]).",'') ";
				 $result = mysql_query($sql);
		 
				 //washing
				echo  $sql = " insert into emp_income (emp id,  `comp_id`, `ticket_no`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark`  )
				                       values     ($empid,,'3', '".addslashes(intval($emapData[1]))."','4',12,2,".addslashes($emapData[24]).",'') ";
				 $result = mysql_query($sql);
				 // Other Allow.
				 $sql = " insert into emp_income ( emp_id, `comp_id`, `ticket_no`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark`  )
				                       values     ($empid,'3', '".addslashes(intval($emapData[1]))."','4',13,2,".addslashes($emapData[25]).",'') ";
				 $result = mysql_query($sql);
			
			}
			$count++;
	    }
	    fclose($file);

		if($count>1)
		{
			echo "<script type=\"text/javascript\">
					alert(\"CSV File has been successfully Imported.\");
 				</script>";
			
		}
		
		?>