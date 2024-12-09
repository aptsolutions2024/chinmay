<?php    
exit;
   $doc_path=$_SERVER["DOCUMENT_ROOT"];
 include_once($doc_path.'/lib/class/admin.php');
 $admin = new Admin();
  

 $filename =$doc_path."/admin/Data/Chinamay_employee_data.csv";
		$count=0;  
		$file = fopen($filename, "r");
		echo "Please wait.File is being uploaded.";
		/*$sql = "delete from employee";
		$result = mysql_query($sql);
		$sql = "delete from emp_income";
		$result = mysql_query($sql);
		$sql = "delete from emp_deduct";
		$result = mysql_query($sql);*/
		$comp_id = 1;
		$user_id = 5;
			
	    while ($emapData = fgetcsv($file,10000, ",")) 
			
	    {
			if($count>=7){
				
				if($emapData[39]!=''){
					$bdate=date("Y-m-d", strtotime($emapData[39]));
						}
				else{
					$bdate='0000-00-00';
				}
				
				
				if($emapData[40]!=''){
						$jdate=date("Y-m-d", strtotime($emapData[40]));
					}
				else{
						$jdate='0000-00-00';
				}
				
				if($emapData[43]!=''){
					$ldate=date("Y-m-d", strtotime($emapData[43]));
						}
				else{
					$ldate='0000-00-00';
				}
		

				$sql = "insert into employee (ticket_no, clientno, first_name, middle_name, last_name, emp_add1, pin_code, mobile_no, gender,pay_mode,bankcode,bankacno,bdate,joindate,leftdate,pfno,esistatus,esino,dept,qualif,comp_ticket_no,panno,adharno,uan,married_status,middlename_relation,comp_id,user_id) values (	'".addslashes($emapData[1])."','".addslashes($emapData[2])."','".addslashes($emapData[3])."','".addslashes($emapData[4])."','".addslashes($emapData[5])."','".addslashes($emapData[6])." ". addslashes($emapData[7])."','".addslashes($emapData[8])." ". addslashes($emapData[9])."','".addslashes($emapData[10])."','".addslashes($emapData[12])."','".addslashes($emapData[17])."','".addslashes($emapData[18])."','".addslashes($emapData[19])."','".$bdate ."','".$jdate."','".$ldate ."','".addslashes($emapData[46])."','".addslashes($emapData[48])."','".addslashes($emapData[49])."','".addslashes($emapData[51])."','".addslashes($emapData[52])."','".addslashes($emapData[73])."','".addslashes($emapData[90])."','".addslashes($emapData[91])."','".addslashes($emapData[92])."','".addslashes($emapData[94])."','".addslashes($emapData[96])."','".$comp_id."','".$user_id."')";			
				
					$result = mysql_query($sql);
					$empid=mysql_insert_id();
				  
				  if ($emapData[13] =="D"){$calc_type = 5;}
				  if ($emapData[13] =="S"){$calc_type = 14;}
				  if ($emapData[13] =="M"){$calc_type = 2;}
				 //BASIC
					 $sql = " insert into emp_income (emp_id,  `comp_id`, `ticket_no`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark`  ) values     ($empid,'".$comp_id."', '".addslashes(intval($emapData[1]))."','".$user_id."',25,".$calc_type.",".addslashes($emapData[53]).",'') ";
					 $result = mysql_query($sql);
				 //DA
					if ($emapData[54]>0){				
					$sql = " insert into emp_income (emp_id,  `comp_id`, `ticket_no`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark`) values     ($empid,'".$comp_id."', '".addslashes(intval($emapData[1]))."','".$user_id."',26,".$calc_type.",".addslashes($emapData[54]).",'') ";
					$result = mysql_query($sql);}
				
				 //HRA
					if ($emapData[55]>0){				
					$sql = " insert into emp_income (emp_id,  `comp_id`, `ticket_no`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark` )	values   ($empid,'".$comp_id."', '".addslashes(intval($emapData[1]))."','".$user_id."',27,".$calc_type.",".addslashes($emapData[55]).",'') ";
					$result = mysql_query($sql);}
				 //canteen
					if ($emapData[56]>0){				
					$sql = " insert into emp_income (emp_id,  `comp_id`, `ticket_no`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark` )	values   ($empid,'".$comp_id."', '".addslashes(intval($emapData[1]))."','".$user_id."',34,".$calc_type.",".addslashes($emapData[56]).",'') ";
					$result = mysql_query($sql);}
				 //travel
					if ($emapData[57]>0){				
					$sql = " insert into emp_income (emp_id,  `comp_id`, `ticket_no`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark` )	values   ($empid,'".$comp_id."', '".addslashes(intval($emapData[1]))."','".$user_id."',35,".$calc_type.",".addslashes($emapData[57]).",'') ";
					$result = mysql_query($sql);}
				 //CCalw
					if ($emapData[58]>0){				
					 $sql = " insert into emp_income (emp_id,  `comp_id`, `ticket_no`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark`  ) values     ($empid,'".$comp_id."', '".addslashes(intval($emapData[1]))."','".$user_id."',36,".$calc_type.",".addslashes($emapData[58]).",'') ";
					$result = mysql_query($sql);}
				 //attend
					if ($emapData[61]>0){				
					$sql = " insert into emp_income (emp_id,  `comp_id`, `ticket_no`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark`) values     ($empid,'".$comp_id."', '".addslashes(intval($emapData[1]))."','".$user_id."',37,".$calc_type.",".addslashes($emapData[61]).",'') ";
					$result = mysql_query($sql);}
				 //edu
					if ($emapData[62]>0){				
					$sql = " insert into emp_income (emp_id,  `comp_id`, `ticket_no`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark` )	values   ($empid,'".$comp_id."', '".addslashes(intval($emapData[1]))."','".$user_id."',38,".$calc_type.",".addslashes($emapData[62]).",'') ";
					$result = mysql_query($sql);}
				 //washing
					if ($emapData[63]>0){				
					$sql = " insert into emp_income (emp_id,  `comp_id`, `ticket_no`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark` )	values   ($empid,'".$comp_id."', '".addslashes(intval($emapData[1]))."','".$user_id."',39,".$calc_type.",".addslashes($emapData[63]).",'') ";
					$result = mysql_query($sql);}
				 //other
					if ($emapData[66]>0){				
					$sql = " insert into emp_income (emp_id,  `comp_id`, `ticket_no`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark` )	values   ($empid,'".$comp_id."', '".addslashes(intval($emapData[1]))."','".$user_id."',29,".$calc_type.",".addslashes($emapData[66]).",'') ";
					$result = mysql_query($sql);}
				 //P.F.
					if ($emapData[47]>0){				
					$sql = " insert into emp_deduct (emp_id,  `comp_id`, `ticket_no`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark` )	values   ($empid,'".$comp_id."', '".addslashes(intval($emapData[1]))."','".$user_id."',20,7,12,'') ";
					$result = mysql_query($sql);}

				 //esi
					if ($emapData[49]>0){				
					$sql = " insert into emp_deduct (emp_id,  `comp_id`, `ticket_no`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark` )	values   ($empid,'".$comp_id."', '".addslashes(intval($emapData[1]))."','".$user_id."',21,7,0,'') ";
					$result = mysql_query($sql);}
				 //prof.Tax.
					if ($emapData[50]=='Y'){				
					$sql = " insert into emp_deduct (emp_id,  `comp_id`, `ticket_no`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark` )	values   ($empid,'".$comp_id."', '".addslashes(intval($emapData[1]))."','".$user_id."',22,7,0,'') ";
					$result = mysql_query($sql);}
				//Society
					if ($emapData[22]>0){				
					$sql = " insert into emp_deduct (emp_id,  `comp_id`, `ticket_no`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark` )	values   ($empid,'".$comp_id."', '".addslashes(intval($emapData[1]))."','".$user_id."',26,3,".addslashes($emapData[22]).",'') ";
					$result = mysql_query($sql);}
				//bankloan
					if ($emapData[29]>0){				
					$sql = " insert into emp_deduct (emp_id,  `comp_id`, `ticket_no`, `user_id`, `head_id`, `calc_type`, `std_amt`, `remark` )	values   ($empid,'".$comp_id."', '".addslashes(intval($emapData[1]))."','".$user_id."',27,3,".addslashes($emapData[29]).",'') ";
					$result = mysql_query($sql);}





		}
			$count++;
		//	if ($count>15){break;}
	    }
	    fclose($file);
		
		$sql = "update employee e inner join mast_client mc on mc.clientno = e.clientno set e.client_id = mc.mast_client_id,desg_id = 1";
		$result = mysql_query($sql);

		$sql = "update employee e inner join mast_dept md pn md.dept = e.dept and  md.comp_id = e.comp_id    set e.dept_id = md.mast_dept_id";
		$result = mysql_query($sql);

		$sql = "update employee e inner join mast_bank mb on mb.bankcode = e.bankcode and mb.comp_id = e.comp_id  set e.bank_id = mb.mast_bank_id";
		$result = mysql_query($sql);
		
		$sql = "update employee e set e.pay_mode = 'C' where comp_id = 1 and bankcode = '010'";
		$result = mysql_query($sql);
		
		$sql = "update employee e set e.pay_mode = 'T' where comp_id = 1 and bankcode <> '010'";
		$result = mysql_query($sql);
		
		$sql = "update employee e inner join mast_qualif md on md.qualif = e.qualif and  md.comp_id = e.comp_id  set e.qualif_id = md.mast_qualif_id";
		$result = mysql_query($sql);
		
		if($count>1)
		{
			echo "<script type=\"text/javascript\">
					alert(\"CSV File has been successfully Imported.\");
 				</script>";
			
		}
		
		?>