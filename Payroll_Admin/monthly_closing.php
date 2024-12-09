<?php
echo "Inside - Monthly Closing<br>"; 

$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');
$comp_id=$_SESSION['comp_id'];


if($_REQUEST['clientGroup']!=1){ //parent selected
    $groupid=$_REQUEST['clientGroup'];
    $groupClientList= $payrollAdmin->getGroupClientIdsOnly($groupid);
   // echo "Client ID:".$groupClientList['client_id'];
    $client_id=$groupClientList['client_id'];
    $client_name=$groupClientList['client_name'];
    
}elseif($_REQUEST['clientGroup']==1 && $_REQUEST['clientid']){ //client selected
    $client_id=$_REQUEST['clientid'];
    $clientDetails= $payrollAdmin->displayClient($client_id);
    $client_name=$clientDetails['client_name'];
}
 if($client_id){
    $row=$payrollAdmin->insertHistEmp($client_id);
	$row1=$payrollAdmin->insertHistDaysDetails($client_id);
	$row1=$payrollAdmin->insertHistDays($client_id);
	$row2=$payrollAdmin->insertHistIncome($client_id);
	$row3=$payrollAdmin->insertHistDeduct($client_id);
	$row4=$payrollAdmin->insertHistAdvance($client_id);
	$row5=$payrollAdmin->updateEmployeeMonthC($client_id);


//die;
	//Deleting data from  tran files

	$row6=$payrollAdmin->deleteTranTables($client_id,'tran_employee');
	$row7=$payrollAdmin->deleteTranTables($client_id,'tran_deduct');
	$row8=$payrollAdmin->deleteTranTables($client_id,'tran_income');
	$row9=$payrollAdmin->deleteTranTables($client_id,'tran_advance');
	$row10=$payrollAdmin->deleteTranDays($client_id); //tran_days
	$row11=$payrollAdmin->deleteTranDaysDetails($client_id); //tran_days_details
	$row12=$payrollAdmin->UpdateMastClients($client_id); //mast_client
	
	echo "<br><br><h4 class='hideonclintchange resuccofmonthlyclose'>Monthly Closing Have Done For This Client.<br><p>".$client_name."</p></h4><br><br>";
}else{
    echo "<br><br><h4 class='hideonclintchange resfailofmonthlyclose'>Client Not Selected.</h4><br><br>";
}


?>