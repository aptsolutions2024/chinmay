<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

$deductid=addslashes($_REQUEST['deductid']);
$ct=addslashes($_REQUEST['decaltype']);
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$filename=$_FILES["file"]["tmp_name"];


	if($_FILES["file"]["size"] > 0)
	{
       $count=0;  
		$file = fopen($filename, "r");
	    while ($emapData = fgetcsv($file, 10000, ","))
	    {
			
				
							//print_r($emapData);
			  
			if($count!=0){
			 	$countch=$payrollAdmin->countEmpDeduct(addslashes($emapData[0]),$deductid);
			   
				$result=$payrollAdmin->updateEmpDeduct(addslashes($emapData[4]),$ct,addslashes($emapData[5]),addslashes($emapData[0]),$deductid,$comp_id,$user_id,$countch);
			}
			
			
			
			$count++;
	    }


	    fclose($file);

		if($count>1)
		{
			echo "<script type=\"text/javascript\">
					alert(\"CSV File has been successfully Imported.\");
				</script>";
				 echo "<script>window.location.href='/import-deduct';</script>";exit();
			
		}else{
		    echo "<script type=\"text/javascript\">
					alert(\"Something wrong happened while uploading file..\");
				</script>";
				 echo "<script>window.location.href='/import-deduct';</script>";exit();
		}
		
	}	
?>
