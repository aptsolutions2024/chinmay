<?php    
exit;
$con=mysql_connect("localhost","root","");
 mysql_select_db("new_imcon_salary",$con)
or die("Could not connect trial");

if(!$con){
    die('Could not connect: '.mysql_error());
}

 $filename ='d:/Ics_sal.csv';
		$count=0;  
		$file = fopen($filename, "r");
		echo "Please wait.File is being uploaded.";
/*		$sql = "TRUNCATE `hist_employee`;";
		$result = mysql_query($sql);
		$sql = "TRUNCATE hist_income";
		$result = mysql_query($sql);
		$sql = "TRUNCATE  hist_deduct";
		$result = mysql_query($sql);
		$sql = "TRUNCATE  hist_days";
		$result = mysql_query($sql);*/
		
			
	    while ($emapData = fgetcsv($file,10000000, ",")) 
			
	    {
			
			if($count>0)
			{
				echo $emapData[0];
				echo  $sqlemp = "select * from employee where ticket_no = lpad('".$emapData[0]."',6,'0')";
				$resemp = mysql_query($sqlemp);
                 $resemp1 = mysql_fetch_array($resemp);
				 $x = mysql_num_rows($resemp);
				 
				if ($x > 0)
				{
                    				
					if($emapData[1]!='')
					{
							$sdate=date("Y-m-d", strtotime($emapData[1]));
								}
					else{
							$sdate='0000-00-00';
					}
					//echo "<br>";
					//print_r($emapData);
//echo "<br>".$emapData[81]."<br>";
				
					if ($emapData[2]>0)
					{
						echo $sql = "update hist_deduct hi set amount = '".addslashes( ($emapData[2]))."' where emp_id = 
						'".$resemp1['emp_id']."' and sal_month= '".$sdate."' and head_id = '3'";
					    echo "<br>";
						
						$resemp = mysql_query($sql);
						if ($count > 3)
						{exit;}
					}
					else
					{	
						echo "<br> Not Found - ".$emapData[3]."<br>";}
			
					}
			}
				$count++;
		}
	
			fclose($file);
		
	
		 
		?>
		
