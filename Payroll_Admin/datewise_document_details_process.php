<?php
session_start();
//error_reporting(0);
ini_set('display_errors', 1);
error_reporting(E_ALL);

$doc_path=$_SERVER["DOCUMENT_ROOT"];
include ($doc_path.'/include_payroll_admin.php');

$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$clientid=$_POST['client']; 
$filename=$_FILES["file"]["tmp_name"];
$_SESSION['errorMsg']='';
$_SESSION['successMsg']='';


$empRes = $payrollAdmin->displayClientEmployeebyID($clientid);
$employeelist=[];
$headslist=array('PP','HD','WO','CO','PH','PL','AB','-');
//echo "<pre>";print_r($empRes);echo "</pre>";
//	while($e = $empRes->fetch_assoc())  {
   foreach($empRes as $key=>$e)  {
	   $employeelist[]=$e['emp_id']; 
	}


	if($_FILES["file"]["size"] > 0)
	{
	 
       $count=0;  
		$file = fopen($filename, "r");
		$errorMsg='';
	    while ($emapData = fgetcsv($file, 10000, ","))
	    {
	     
    			if($count==0){
    		 		$count++;
    		 		continue;
            	}
            	
            	$day=[];
            	$ot=[];
				$day[1] = trim(strtoupper($emapData[3]));   $day[2] = trim(strtoupper($emapData[4]));   $day[3] = trim(strtoupper($emapData[5]));	$day[4] = trim(strtoupper($emapData[6]));
				$day[5] = trim(strtoupper($emapData[7]));   $day[6] = trim(strtoupper($emapData[8]));   $day[7] = trim(strtoupper($emapData[9]));	$day[8] = trim(strtoupper($emapData[10]));
				$day[9] = trim(strtoupper($emapData[11]));  $day[10] = trim(strtoupper($emapData[12])); $day[11] = trim(strtoupper($emapData[13])); $day[12] = trim(strtoupper($emapData[14]));
				$day[13] = trim(strtoupper($emapData[15]));	$day[14] = trim(strtoupper($emapData[16]));	$day[15] = trim(strtoupper($emapData[17]));	$day[16] = trim(strtoupper($emapData[18]));
				$day[17] = trim(strtoupper($emapData[19]));	$day[18] = trim(strtoupper($emapData[20]));	$day[19] = trim(strtoupper($emapData[21]));	$day[20] = trim(strtoupper($emapData[22]));
				$day[21] = trim(strtoupper($emapData[23]));	$day[22] = trim(strtoupper($emapData[24]));	$day[23] = trim(strtoupper($emapData[25]));	$day[24] = trim(strtoupper($emapData[26]));
				$day[25] = trim(strtoupper($emapData[27]));	$day[26] = trim(strtoupper($emapData[28]));	$day[27] = trim(strtoupper($emapData[29]));	$day[28] = trim(strtoupper($emapData[30]));
				$day[29] = trim(strtoupper($emapData[31]));	$day[30] = trim(strtoupper($emapData[32]));
				$day[31] = trim(strtoupper($emapData[33]));	
				
				$ot[1] = trim($emapData[34]);   $ot[2] = trim($emapData[35]);   $ot[3] = trim($emapData[36]);	$ot[4] = trim($emapData[37]);
				$ot[5] = trim($emapData[38]);   $ot[6] = trim($emapData[39]);   $ot[7] = trim($emapData[40]);	$ot[8] = trim($emapData[41]);
				$ot[9] = trim($emapData[42]);   $ot[10] = trim($emapData[43]);  $ot[11] = trim($emapData[44]);  $ot[12] = trim($emapData[45]);
				$ot[13] = trim($emapData[46]);	$ot[14] = trim($emapData[47]);	$ot[15] = trim($emapData[48]);	$ot[16] = trim($emapData[49]);
				$ot[17] = trim($emapData[50]);	$ot[18] = trim($emapData[51]);	$ot[19] = trim($emapData[52]);	$ot[20] = trim($emapData[53]);
				$ot[21] = trim($emapData[54]);	$ot[22] = trim($emapData[55]);	$ot[23] = trim($emapData[56]);	$ot[24] = trim($emapData[57]);
				$ot[25] = trim($emapData[58]);	$ot[26] = trim($emapData[59]);	$ot[27] = trim($emapData[60]);	$ot[28] = trim($emapData[61]);
				$ot[29] = trim($emapData[62]);	$ot[30] = trim($emapData[63]);	$ot[31] = trim($emapData[64]);	
				
				$emp_id=trim($emapData[1]);
                $sal_month=trim($emapData[0]);
                $emp_name=$emapData[2];
                $errorMsgtemp='';
                if (!in_array($emp_id, $employeelist)) { 
                    $errorMsgtemp.="<br><br><span class='errormsgspan'><b>EMP_ID-$emp_id EMP_Name-$emp_name</b> Not From Selected Client</span>";
                } 
                if($emp_id==""){
    			     $errorMsgtemp.="<br><br><span class='errormsgspan'>EMP_ID</b> should be there/not empty</span>";
    			    
    			 }
    			 if($sal_month==""){
    			     
    			      $errorMsgtemp.="<br><br><span class='errormsgspan'>Sal_month</b> should be there</span>";
    			 }
    		foreach($day as $key=>$val){
    			
    		     if (!in_array($day[$key], $headslist)) { 
                   $errorMsgtemp.="<br><br><span class='errormsgspan'><b>Day$key=$val</b> does not match</span>";
                  } 
    			if($ot[$key]){
    			    if(is_numeric( $ot[$key] ) === false){
    			         $errorMsgtemp.="<br><br><span class='errormsgspan'><b>Ot".$key."</b> should be Numeric/Decimal </span>";
    			    }
    			}
    			 if(($day[$key]!="PP" && $day[$key]!="HD") && $ot[$key]>0){
    			     
    			      $errorMsgtemp.="<br><br><span class='errormsgspan'><b>Ot".$key."</b> should be empty for <b>Day$key=$val</b></span>";
    			 }
    			 
    			}
    			if($errorMsgtemp && $errorMsgtemp!=""){
    			    $errorMsg.="<br><br><b>***** ROW - $count </b> EMP_ID - $emp_id EMP_NAME - $emp_name *******".$errorMsgtemp;
    			}
            	
    			
			$count++;
	    } 
		
	    //fclose($file);
	     echo "<br>Test3";
        if($errorMsg!='' || $errorMsg){
                        $_SESSION['errorMsg']=$errorMsg;
                      header('Location:datewise-details');
            //	echo "<script type='text/javascript'>alert('CSV File has been successfully Imported.'); window.location ='/datewise-details.php?errorMsg='+$errorMsg;	</script>";
        }else{
            
        $count=0;  
		$file = fopen($filename, "r");
		$errorMsg='';
		$sucesscnt=0;
		$transdayscnt=0;
	    while ($emapData = fgetcsv($file, 10000, ","))
	    {
	            echo "Test4";
    			if($count==0){
    		 		$count++;
    		 		continue;
            	}
            	
            	$day=[];
            	$ot=[];
			    $day[1] = trim(strtoupper($emapData[3]));   $day[2] = trim(strtoupper($emapData[4]));   $day[3] = trim(strtoupper($emapData[5]));	$day[4] = trim(strtoupper($emapData[6]));
				$day[5] = trim(strtoupper($emapData[7]));   $day[6] = trim(strtoupper($emapData[8]));   $day[7] = trim(strtoupper($emapData[9]));	$day[8] = trim(strtoupper($emapData[10]));
				$day[9] = trim(strtoupper($emapData[11]));  $day[10] = trim(strtoupper($emapData[12])); $day[11] = trim(strtoupper($emapData[13])); $day[12] = trim(strtoupper($emapData[14]));
				$day[13] = trim(strtoupper($emapData[15]));	$day[14] = trim(strtoupper($emapData[16]));	$day[15] = trim(strtoupper($emapData[17]));	$day[16] = trim(strtoupper($emapData[18]));
				$day[17] = trim(strtoupper($emapData[19]));	$day[18] = trim(strtoupper($emapData[20]));	$day[19] = trim(strtoupper($emapData[21]));	$day[20] = trim(strtoupper($emapData[22]));
				$day[21] = trim(strtoupper($emapData[23]));	$day[22] = trim(strtoupper($emapData[24]));	$day[23] = trim(strtoupper($emapData[25]));	$day[24] = trim(strtoupper($emapData[26]));
				$day[25] = trim(strtoupper($emapData[27]));	$day[26] = trim(strtoupper($emapData[28]));	$day[27] = trim(strtoupper($emapData[29]));	$day[28] = trim(strtoupper($emapData[30]));
				$day[29] = trim(strtoupper($emapData[31]));	$day[30] = trim(strtoupper($emapData[32]));	$day[31] = trim(strtoupper($emapData[33]));	
				
				$ot[1] = trim($emapData[34]);   $ot[2] = trim($emapData[35]);   $ot[3] = trim($emapData[36]);	$ot[4] = trim($emapData[37]);
				$ot[5] = trim($emapData[38]);   $ot[6] = trim($emapData[39]);   $ot[7] = trim($emapData[40]);	$ot[8] = trim($emapData[41]);
				$ot[9] = trim($emapData[42]);   $ot[10] = trim($emapData[43]);  $ot[11] = trim($emapData[44]);  $ot[12] = trim($emapData[45]);
				$ot[13] = trim($emapData[46]);	$ot[14] = trim($emapData[47]);	$ot[15] = trim($emapData[48]);	$ot[16] = trim($emapData[49]);
				$ot[17] = trim($emapData[50]);	$ot[18] = trim($emapData[51]);	$ot[19] = trim($emapData[52]);	$ot[20] = trim($emapData[53]);
				$ot[21] = trim($emapData[54]);	$ot[22] = trim($emapData[55]);	$ot[23] = trim($emapData[56]);	$ot[24] = trim($emapData[57]);
				$ot[25] = trim($emapData[58]);	$ot[26] = trim($emapData[59]);	$ot[27] = trim($emapData[60]);	$ot[28] = trim($emapData[61]);
				$ot[29] = trim($emapData[62]);	$ot[30] = trim($emapData[63]);	$ot[31] = trim($emapData[64]);	
			
			
			$month=date('m',strtotime($sal_month));
        echo          $year=date('Y',strtotime($sal_month));
                 if ($month=='04' || $month=='06' || $month=='09' || $month='11')
                 {
                    	$day[31] = "-"; $ot[31] ="0";
                 }
                 else if ($month=='02' && mod($year/4)!=0)
                 {
                    	$day[29] = "-"; $ot[29] ="0";
                    	$day[30] = "-"; $ot[30] ="0";
                    	$day[31] = "-"; $ot[31] ="0";
                     
                 }elseif ($month=='02' && mod($year/4)==0)
                 {
                    	$day[30] = "-"; $ot[30] ="0";
                    	$day[31] = "-"; $ot[31] ="0";
                     
                 } 
    		
				
				$emp_id=trim($emapData[1]);
                $sal_month1=trim($emapData[0]);
                $explodate=explode("-",$sal_month1);
                $cur_month=date("M Y", strtotime($sal_month1));
                $year='20'.$explodate[1];
                $sal_month=date($year.'-m-t',strtotime($cur_month));
             //  echo "Sal_month-".$sal_month;
                $checkexist=$payrollAdmin->checkIfUserExistbySalmonthEmpid($emp_id,$sal_month);
              
                //'PP','HD','WO','CO','PH','PL','AB'
                $PPTotal=0;  $HDTotal=0; $WOTotal=0; $COTotal=0; $PHTotal=0; $PLTotal=0; $ABTotal=0;
                $ottotal=0;
                $daytotal=0;
                
                if(isset($checkexist['emp_id'])){
                    //update user
                 
                	 $sql = "Update tran_days_details set ";
                   
                     foreach($day as $key=>$val){
    	   	           // `ot_total`, `day_total`, `created_by`, `created_on`)";
    	   	           switch ($day[$key]) {
                          case "PP":
                            $PPTotal++;
                            break;
                          case "HD":
                            $HDTotal++;
                            break;
                          case "WO":
                            $WOTotal++;
                            break;
                          case "CO":
                            $COTotal++;
                            break;
                          case "PH":
                            $PHTotal++;
                            break;
                          case "PL":
                            $PLTotal++;
                            break;
                         case "AB":
                            $ABTotal++;
                            break;
                        }
                        
                	//  $daytotal++;
    	   	          $sql.="day$key='".$val."',";
    	   	          
    	   	          if($day[$key]=="PP"){
    	   	               $daytotal=$daytotal+1;
    	   	          }elseif($day[$key]=="HD"){
    	   	               $daytotal=$daytotal+0.5; 
    	   	          }
                     
    			     }
    			        $ABTotal=$ABTotal+$HDTotal/2;
                        $PPTotal=$PPTotal+$COTotal+$HDTotal/2;
                        
    			     foreach($ot as $key1=>$val1){
    	   	       
    	   	          $sql.="ot$key1='".$val1."',";
    	   	          $ottotal =$ottotal+$val1;
    			     }
    			     $sql.=" day_total='".$daytotal."'";
    			      $sql.=",ot_total=".$ottotal."";
    			      $sql.=",updated_by=".$user_id;
    			      $sql.=",updated_on=NOW()";
    			   
    			     $sql.=" Where emp_id='$emp_id' and sal_month='$sal_month'";
    			      echo "<br>*****".$sql;
    			     $row=$payrollAdmin->insertUpdateNewEmpTranDaysDetails($sql);
        			    if($row){
        			        $sucesscnt++;
        			    }
                    
                }else{
                    //insert user
                	 $sql = "insert into tran_days_details (`client_id`,`emp_id`, `sal_month`, `day1`, `day2`, `day3`, `day4`, `day5`, `day6`, `day7`, `day8`, `day9`, `day10`, `day11`, `day12`, `day13`, `day14`, `day15`, `day16`, `day17`, `day18`, `day19`, `day20`, `day21`, `day22`, `day23`, `day24`, `day25`, `day26`, `day27`, `day28`, `day29`, `day30`, `day31`, `ot1`, `ot2`, `ot3`, `ot4`, `ot5`, `ot6`, `ot7`, `ot8`, `ot9`, `ot10`, `ot11`, `ot12`, `ot13`, `ot14`, `ot15`, `ot16`, `ot17`, `ot18`, `ot19`, `ot20`, `ot21`, `ot22`, `ot23`, `ot24`, `ot25`, `ot26`, `ot27`, `ot28`, `ot29`, `ot30`, `ot31`, `ot_total`, `day_total`, `created_by`, `created_on`)";
                	 $sql.="values('$clientid','$emp_id','$sal_month'";
                
                     foreach($day as $key=>$val){
                         switch ($day[$key]) {
                          case "PP":
                            $PPTotal++;
                            break;
                          case "HD":
                            $HDTotal++;
                            break;
                          case "WO":
                            $WOTotal++;
                            break;
                          case "CO":
                            $COTotal++;
                            break;
                          case "PH":
                            $PHTotal++;
                            break;
                          case "PL":
                            $PLTotal++;
                            break;
                         case "AB":
                            $ABTotal++;
                            break;
                        }
    	   	          $sql.=",'".$val."'";
    	   	          
    	   	          if($day[$key]=="PP"){
    	   	               $daytotal=$daytotal+1;
    	   	          }elseif($day[$key]=="HD"){
    	   	               $daytotal=$daytotal+0.5; 
    	   	          }
                     
    			     }
    			     $ABTotal=$ABTotal+$HDTotal/2;
                     $PPTotal=$PPTotal+$COTotal+$HDTotal/2;
                        
    			     foreach($ot as $key1=>$val1){
    	   	          $sql.=",'".$val1."'";
    	   	          $ottotal =$ottotal+$val1;
    			     }
    			      $sql.=",".$ottotal."";
    			      $sql.=",'".$daytotal."'";
    			      $sql.=",'".$user_id."'";
    			      $sql.=",NOW()";
    			      $sql.=")";
    			      
    			      echo "<br>*****".$sql;
    			      $row=$payrollAdmin->insertUpdateNewEmpTranDaysDetails($sql);
        			    if($row){
        			         $sucesscnt++;
        			    }
    			   
                }//end of else
                
                  $checkintrandays=$payrollAdmin->checkIfUserExistInTran_days($emp_id,$sal_month);
                      if(isset($checkintrandays['emp_id'])){
            //`fullpay`, `halfpay`, `leavewop`, `present`, `absent`, `weeklyoff`, `pl`, `sl`, `cl`, `otherleave`, `paidholiday`, `additional`,
            // $PPTotal=0;  $HDTotal=0; $WOTotal=0; $COTotal=0; $PHTotal=0; $PLTotal=0; $ABTotal=0;
                        $updatesql="update tran_days set present='$PPTotal',absent='$ABTotal',weeklyoff='$WOTotal',paidholiday='$PHTotal',pl='$PLTotal',othours='$ottotal' 
                        where emp_id='$emp_id' and sal_month='$sal_month'";		    
                      }else{
                        $updatesql  = "insert into tran_days (emp_id,sal_month,client_id,comp_id,user_id,updated_by,present,absent,weeklyoff,paidholiday,pl,othours)
                        values ('".$emp_id."','".$sal_month."','".$clientid."','".$comp_id."','".$user_id."','".$user_id."','".$PPTotal."','".$ABTotal."','".$WOTotal."','".$PHTotal."','".$PLTotal."','".$ottotal."')";
                      }
                      echo "<br>************".$updatesql;
                     $rowss=$payrollAdmin->insertUpdateTranDay($updatesql);
                     if($rowss){
                      $transdayscnt++;   
                     }
		        	$count++;
	    } 
	    
                $_SESSION['successMsg']=$sucesscnt." Records of CSV File has been successfully Imported";
            header('Location:datewise-details');
        	
        			
        }
		
}else{
               $_SESSION['errorMsg']="File should not be empty";
                     header('Location:datewise-details');
}	
?>
