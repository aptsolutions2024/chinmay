<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

$incomeid=addslashes($_REQUEST['incomeid']);
$ct=addslashes($_REQUEST['caltype']);
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$filename=$_FILES["file"]["tmp_name"];
//$income = $_REQUEST['incomeid'];
	if($_FILES["file"]["size"] > 0)
	{
       $count=0;  
		$file = fopen($filename, "r");
	    while ($emapData = fgetcsv($file, 10000, ","))
			
	    {
			
			//print_r($emapData);
			      
			if($count!=0){
			    $emp_id=addslashes($emapData[0]);
			 	$countch=$payrollAdmin->countEmpIncome($emp_id,$incomeid);
			    $std_amt=addslashes($emapData[4]);
			    $remark=addslashes($emapData[5]);
			  
				$result=$payrollAdmin->updateEmpIncome($std_amt,$ct,$remark,$emp_id,$incomeid,$comp_id,$user_id,$countch);
				//echo "******Result------".$result;
			}
			$count++;
	    }


	    fclose($file);

		if($count>1)
		{
			echo "<script type=\"text/javascript\">
					alert(\"CSV File has been successfully Imported.\");
				</script>";
               echo "<script>window.location.href='/import-income';</script>";exit();
			
		}
		
	}	
?>
