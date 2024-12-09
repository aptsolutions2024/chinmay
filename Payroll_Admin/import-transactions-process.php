<?php
session_start();
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

require('library/php-excel-reader/excel_reader2.php');
require('library/SpreadsheetReader.php');


if($_SESSION['log_type']==2)
{
    
}else
{
    echo "<script>window.location.href='/payroll-logout';</script>";exit();
}
//echo "<br>!clientid - ";
$client_id=addslashes($_REQUEST['client']);
$row_cl= $payrollAdmin->displayClient($client_id);
//echo "<br>!client date : ";
$client_date = $row_cl['current_month'];


 
 //$mimes = array('application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.oasis.opendocument.spreadsheet','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','Content-type: text/csv');
  $mimes = array('application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.oasis.opendocument.spreadsheet','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','text/comma-separated-values','text/x-comma-separated-values','text/csv', 'application/csv');

    if(in_array($_FILES["file"]["type"],$mimes))
    {
         $uploadFilePath = 'uploads/'.basename($_FILES['file']['name']);
    	move_uploaded_file($_FILES['file']['tmp_name'], $uploadFilePath);
        $Reader = new SpreadsheetReader($uploadFilePath);

		 $totalSheet = count($Reader->sheets());
		
        $count=0;
        $update_cnt=0;
        $insert_cnt= 0;
		/* For Loop for all sheets */
        for($i=0;$i<$totalSheet;$i++)
        {  
             
            $Reader->ChangeSheet($i);
			$count =0;
		
            foreach ($Reader as $emapData)
            {
                 
                if($count!=0){
                    
                   // $empdate=trim($emapData[2]);
                    $empdate=explode("-",trim($emapData[2]));  //File Employee date format: 31-07-2023   Client date format: 2023-07-31
                      $tempdate=$empdate[2]."-".$empdate[1]."-".$empdate[0];
                      $lastDate = date('Y-m-t',strtotime($tempdate));
                    $yearlen=strlen($empdate[2]);
                    if($yearlen==2){
                    $year=substr($client_date, 0, 2);
                      $tempdate=$year.$empdate[2]."-".$empdate[1]."-".$empdate[0];
                    }
                  
			       //echo "<br>EMP Date:". $tempdate."    Client date:".$client_date."    Year:".$year."   lastDate :".$lastDate."<br>";
			        
			    
                     if ($tempdate == $client_date) {
						$head = $payrollAdmin->gettd_string($comp_id);
						$exhd = explode(',',$head);
						$j= count($exhd);
						$emp_id= "'".addslashes($emapData[3])."'";
                        $row =$payrollAdmin->getTranDayEmpCount($emp_id); 
                        $cnt = $row['cnt'];
                        $trd_id=$row['trd_id'];
                       
						if($cnt>0) {
						 
								 $sql1 = "update tran_days set sal_month = '".$lastDate."', ";
								 
                                for($i=0; $i<$j; $i++ ){
										$sql1 =$sql1.$exhd[$i]." = '".addslashes($emapData[$i+5])."',";
								}
                                $sql1= $sql1."`db_update` =now() where emp_id = '".addslashes($emapData[3])."'";
                                //echo "<br>___In Update :".$sql1;
								$cnt = $payrollAdmin->updateTranday($sql1);  
								if ($cnt=='1'){
								    $update_count++;
								     //echo "<br>___In Update :";
					   	                $sql2 = "update tran_days td inner join employee emp on emp.emp_id = td.emp_id set td.sal_month = '".$lastDate."',td.`client_id` =  emp.`client_id`,td.`user_id` = emp.`user_id`,td.`comp_id` = emp.`comp_id` ,td.`sal_month` = td.`sal_month`  where td.emp_id =  '".addslashes($emapData[3])."'";
								     $cntresult = $payrollAdmin->updateTranday($sql2); 
								}
							 
						}
						else
						{
								$sqlstr = "";
                                $sqlval = "";
                                for($i=0; $i<$j; $i++ ){
										$sqlstr =$sqlstr.",`".trim($exhd[$i])."`";
										$sqlval =$sqlval.",'".addslashes($emapData[$i+4])."'";
									}
									echo $sqlstr.'--------';
							   /* $sql = "INSERT INTO `tran_days`(sal_month,`emp_id`".$sqlstr.",`db_adddate`, `db_update`) VALUES ('".$lastDate."','".addslashes($emapData[3])."'".$sqlval.", NOW(),NOW())";
 							
 								$cnt = $payrollAdmin->updateTranday($sql);  
								if ($cnt=='1'){
								    $insert_count++;
								    //echo "<br>___In Insert :";
 						        	 $sql2 = "update tran_days td inner join employee emp on emp.emp_id = td.emp_id set td.`client_id` =  emp.`client_id`,td.`user_id` = emp.`user_id`,td.`comp_id` = emp.`comp_id` ,td.`sal_month` = td.`sal_month`  where td.emp_id =  '".addslashes($emapData[3])."'";
								   $cntresult = $payrollAdmin->updateTranday($sql2); 
								}*/
							 
						}
                    }
				}
				$count++;
	    
	

            }
            
        }

if($insert_count>0 || $update_count>0){
    echo "CSV File has been Imported successfully.<br>". $insert_count ." records inserted.<br>".$update_count." records have been updated.";
}else{
     echo "Something wrong while uploading file.<br>". $insert_count ." records inserted.".$update_count." records have been updated.";
}
		
			
	}	
?>
