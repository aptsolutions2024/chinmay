<?php

include ('../../include_payroll_admin.php');
//error_Reporting(E_ALL);
$payrollAdmin = new payrollAdmin();

if($_SESSION['log_type']==2)
{
    
}else
{
    echo "<script>window.location.href='/payroll-logout';</script>";exit();
}
$month=$_SESSION['month'];
$clintid=$_SESSION['clintid'];
// $emp=$_SESSION['emp'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$clientGrp=$_SESSION['clientGrp'];
$frdt=$_SESSION['frdt'];
// print_r($_SESSION);
$group[]='';
$resclt='';
// echo $clientGrp;
if ($clientGrp!=''){   
    // echo "1111111111";
    $group=$payrollAdmin->displayClientGroupById($clientGrp);
    $grpClientIds=$payrollAdmin->getGroupClientIds($clientGrp)  ;
    $grpClientIdsOnly=$payrollAdmin->getGroupClientIdsOnly($clientGrp);
    $resclt=$payrollAdmin->displayClient($grpClientIds[0]['mast_client_id']);
     if ($clientGrp == 1) {
        // echo "!!!!!!!1";
        $clientids = $payrollAdmin->displayclientbyComp($comp_id);
        // print_r($clientids);
        $resclt = $payrollAdmin->displayClient($clientids['client_id']);
        $clientid=$clientids['client_id'];
    }
}

else {
    $resclt=$payrollAdmin->displayClient($clintid);
}

if ($month == 'current') {
    // echo "current";
    $frdt = date('Y-m-t', strtotime($resclt['current_month']));
} else if ($month == 'previous') {
    // echo "previous";
    $frdt = date('Y-m-t', strtotime($_SESSION['frdt']));
}
$client_name = ($clientGrp=='') ? $resclt['client_name']: "Group : ".$group['group_name']; 
//echo $frdt;
$frdt=$payrollAdmin->lastDay($frdt);
$monthtit =  date('F Y',strtotime($frdt));
$todt=$frdt;    

if($month!=''){
    $reporttitle="SALARY SUMMARY FOR THE MONTH ".$monthtit;
}
$_SESSION['client_name']=$client_name;
$_SESSION['reporttitle']=strtoupper($reporttitle);
?>

<!DOCTYPE html>

<html lang="en-US">
<head>

    <meta charset="utf-8"/>


    <title> &nbsp;</title>

    
    <style>
        .thheading{
            text-transform: uppercase;
            font-weight: bold;
            background-color: #fff;
        }
        .heading{
            margin: 10px 20px;
        }
        .btnprnt{
            margin: 10px 20px;
        }
        .page-bk {
            position: relative;

            /*display: block;*/
            page-break-after: always;
            z-index: 0;

        }
      
        table {
            border-collapse: collapse;
            width: 100%;

        }

        table, td, th {
            padding: 6px!important;
            border: 1px solid black!important;
            font-size:15px !important;
            font-family: monospace;

        }
		
					table#appletter ,table#appletter tr,table#appletter td,#tabltit table,#tabltit tr,#tabltit td {
			border: 0 !important;
		}

        @media print
        {
            .btnprnt{display:none}
            .header_bg{
                background-color:#7D1A15;
                border-radius:0px;
            }
            .heade{
                color: #fff!important;
            }
            #header, #footer {
                display:none!important;
            }
            #footer {
                display:none!important;
            }
            .body { padding: 10px; }
            /*body{
                margin-left: 50px;
            }*/
        }

        @media all {
            #watermark {
                display: none;

                float: right;
            }

            .pagebreak {
                display: none;
            }

            #header, #footer {

                display:none!important;

            }
            #footer {
                display:none!important;
            }

        }


    </style>
	
	

	
</head>
<body class="container">
<div class="btnprnt">
    <button class="submitbtn" onclick="myFunction()">Print</button>
    <button class="submitbtn"  onclick="location.href='/report-salary'">Cancel</button>
</div>

    <div class="header_bg"></div>
        <?php include ('printheader3.php');?>
	<div >
    <table width="100%" id="appletter"border="none">
	<thead>
	<tr>
	
	<td align="right"   style="text-align:left">
	<div style="width:50%; float:right">

	</div></td></tr></thead>
</table></div>

<!--	</thead>
</table></div>

-->
    <div class="row body" >
    <table >
    <tr>
        <td class='thheading' width="12%">Details of Days</td>
        <td  class='thheading' width="8%" align='right'> Days</td>
        <td  class='thheading' width="13%">Income </td>
         <td class='thheading' width="7%">STD PAY</td> 
        <td class='thheading' width="13%" align='right'>Earnings </td>
        <td  class='thheading' width="14%">Deduction </td>
        <td  class='thheading' class='thheading' width="9%" align='right'>Std.Salary</td>
        <td class='thheading' width="10%" align='right'>Deductions</td>
        <td class='thheading' width="10%" align='right'>Contributions</td>
    </tr>


       <?php

        //Query for Tran Employee
         $client_id = ($clintid)?$clintid:$grpClientIdsOnly['client_id'];
         
        $rowtotal1=$payrollAdmin->getSummaryTranEmp($client_id,$frdt,$clientGrp);
        $rowtotal=$rowtotal1[0];

        //Query for Tran income
        $row1=$payrollAdmin->getSummaryTranIncome($client_id,$frdt,$clientGrp);
     	$i = 1;
        $restotalstdpay=0;
		foreach($row1 as $row_inc ){
		    		
					$arr_inc_name[$i] = $row_inc['income_heads_name'];
    		        $arr_inc_std[$i] = number_format($row_inc['std_amt'],2,".",",");
				    $restotalstdpay = $restotalstdpay+$row_inc['std_amt'];
		    	    if($row_inc['amount'] > 0 ){
			    	        $arr_inc_amt[$i] = number_format($row_inc['amount'],2,".",",");
				        }
        			    else{
				                $arr_inc_amt[$i]  = ' ';
			            }
			        $i++;
		}


       //Query for Deduction
       $row1=$payrollAdmin->getSummaryTranDeduct($client_id,$frdt,$clientGrp);
		$j = 1;
		foreach($row1 as $row_ded){
			    $arr_ded_name[$j] = $row_ded['deduct_heads_name'];
			if($row_ded['amount'] != 0){
				$arr_ded_amt[$j] = $row_ded['amount'];
				if ($row_ded['deduct_heads_name'] == "P.F." || $row_ded['deduct_heads_name'] == "E.S.I." ){
				$arr_ded_std_amt[$j] = number_format($row_ded['std_amt'],0,".",",");
				}
				ELSE
				{
				    $arr_ded_std_amt[$j] = "";
				    
				}
				
			    IF ($row_ded['employer_contri_1'] > 0){
				$arr_ded_emp_contri1_amt[$j] = number_format( $row_ded['employer_contri_1'],2,".",",");}
				ELSE 
				{
					$arr_ded_emp_contri1_amt[$j] = "";
				}
				
				IF ($row_ded['employer_contri_2']!= 0 ){
				$arr_ded_emp_contri2_amt[$j] = number_format($row_ded['employer_contri_2'],2,".",",");}
				ELSE
				{
					$arr_ded_emp_contri2_amt[$j] = "";
				}
				}
			else{
				$arr_ded_name[$j] ="";
				$arr_ded_amt[$j]  = ' ';
				$j--;
			}

			$j++;
		}

       //Query for salary advance
	   $row1=$payrollAdmin->getSummaryTranAdv($client_id,$frdt,$clientGrp);
        foreach($row1 as $row_ded){
 
            $arr_ded_name[$j] = $row_ded['advance_type_name'];

            if($row_ded['amount'] > 0){
                $arr_ded_amt[$j] =  number_format($row_ded['amount'],2,".",",");
            }else{
                $arr_ded_amt[$j]  = ' -';
            }
           $j++;
        }
      
        //Tran Daysec
    	 $row1=$payrollAdmin->getSummaryTranDays($client_id,$frdt,$clientGrp);
       	$k = 1;
        foreach($row1 as $row_days){
                   $arr_days_name[$k] = "Present Days";
                   $arr_days_value[$k] = $row_days['present'];
                   $k++;
                   $arr_days_name[$k] = "Absent Days";
                   $arr_days_value[$k] = $row_days['absent'];
                   $k++;
                   $arr_days_name[$k] = "Weekly Off";
                   $arr_days_value[$k] = $row_days['weeklyoff'];
                   $k++;
                   $arr_days_name[$k] = "Earn Leave";
                   $arr_days_value[$k] = $row_days['pl'];
                   $k++;
                   $arr_days_name[$k] = "SL Leave";
                   $arr_days_value[$k] = $row_days['sl'];
                   $k++;
                   $arr_days_name[$k] = "Casual Leave";
                   $arr_days_value[$k] = $row_days['cl'];
                   $k++;
                   $arr_days_name[$k] = "Other Leave";
                   $arr_days_value[$k] = $row_days['otherleave'];
                   $k++;
                   $arr_days_name[$k] = "Paid Holiday";
                   $arr_days_value[$k] = $row_days['paidholiday'];
                   $k++;
                   $arr_days_name[$k] = "Addi. Days";
                   $arr_days_value[$k] = $row_days['additional'];
   -               $k++;
                   $arr_days_name[$k] = "Payabledays";
                   $arr_days_value[$k] = $rowtotal['payabledays'];
                   $k++;
                   $arr_days_name[$k] = "OT Hours";
                   $arr_days_value[$k] = $row_days['othours'];
                   $k++;
                   $arr_days_name[$k] = "Night SFT.";
                   $arr_days_value[$k] = $row_days['nightshifts'];
                   $k++;
       }
		if($i-1>=$j)
        {$maxrows = $i-1;}
        else
        {$maxrows = $j-1;}

		if ($maxrows>=$k-1)
        {}
        else
        {$maxrows = $k-1;}
        $maxrows=12;	

		for($l=1;$maxrows>=$l;$l++){
            echo "<tr>";
            if ($l < $k){
             echo "<td>". $arr_days_name[$l]."</td>
				<td  align='right'> ".$arr_days_value[$l]."</td>";
				}
            else
            {
                echo "<td width='15%'> </td>
				<td width='8%'> </td>";
				}

            if ($l < $i){         //checking array subscript
                echo "<td>".$arr_inc_name[$l]."</td>
              <td align='right'>".$arr_inc_std[$l]."</td>
            <td align='right'>".$arr_inc_amt[$l]."</td>";
				}
            else
            {
                echo "<td></td>
                <td></td>
				<td></td>";
				}

            if ($l < $j){      //checking array subscript

                echo "<td>".$arr_ded_name[$l]."</td>
				<td align='right'>". round(str_replace( ',', '',$arr_ded_std_amt[$l]))."</td>
				<td align='right'>". round(str_replace( ',', '',$arr_ded_amt[$l]))."</td>";
				//print_r($arr_ded_emp_contri2_amt);
				if ($arr_ded_emp_contri2_amt[$l]>0)
				    {    echo "<td align='center'>".round(str_replace( ',', '',$arr_ded_std_amt[$l])*0.13,0)."</td>";}
				else if ($arr_ded_name[$l]=="E.S.I.")    
				{
				    echo "<td align='center'>".round(str_replace( ',', '',$arr_ded_std_amt[$l])*0.0325,0)."</td>";
				}
				    else echo "<td></td>";
				//echo "<td align='center'>". $arr_ded_emp_contri2_amt[$l]."</td>";
				}
            else
            {
            	echo "<td></td>";
				//<td></td>";
			    echo "<td></td>
				<td></td>
				<td></td>";
				}

            echo "</tr>";
        }



       ?>

   <tr>
           <td class='thheading'>Total No of Employee</td>
           <td class='thheading' align='right'><?php echo $rowtotal['totalemp'];?></td>
           <td class='thheading'>Gross Salary</td>
           <td class='thheading'><?php echo number_format( $restotalstdpay,2,".",",");?></td> 
           <td class='thheading'align='right' ><?php echo number_format( round($rowtotal['gross_salary'],2),2,".",",");?></td>
			<td>Total Dedud.</td>
            <td class='thheading'align='right'><?php echo "-";?></td>
		    <td class='thheading'align='right'><?php echo number_format( round($rowtotal['tot_deduct'],2),2,".",",");?></td>
		   <td></td>
			</tr>
			<tr>
			<td></td><td></td><td></td><td></td><td></td><td></td>
           <td class='thheading'>NET SALARY</td>
           <td class='thheading'align='right'><?php echo number_format( round($rowtotal['netsalary'],0),2,".",",");?></td>
            <td></td>
       </tr>

</table>


        </div>
<br/><br/>
    </div>

<!-- content end -->

<script>
    function myFunction() {
        window.print();
    }
</script>


</body>
</html>