<?php
session_start();
include ('../../include_payroll_admin.php');

error_reporting(0);
$month=$_SESSION['month'];
$clientid=$_SESSION['clientid'];
$emp=$_REQUEST['emp'];
$advtype= $_REQUEST['advtype'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
// print_r($_SESSION);
//$res=$payrollAdmin->showEmployeereport($comp_id,$user_id);

$resclt=$payrollAdmin->displayClient($clientid);
$cmonth=$resclt['current_month'];

// if($month=='current'){
// 	$monthtit =  date('F Y',strtotime($cmonth));
//     $tab_emp='tran_employee';
//     $tab_empded='tran_deduct';
// 	$tab_adv = 'tran_advance';
//     $frdt=$cmonth;
//     $todt=$cmonth;
//   }
// else{
//     $monthtit =  date('F Y',strtotime($_SESSION['frdt']));
//     $tab_emp='hist_employee';
//     $tab_empded='hist_deduct';
// 	$tab_adv = 'hist_advance';
// 	$frdt=date("Y-m-d", strtotime($_SESSION['frdt']));
//     $todt=date("Y-m-d", strtotime($_SESSION['frdt']));
//   }

// ************************
$clientGrp=$_SESSION['clientGrp'];
$frdt=$_SESSION['frdt'];

$group[]='';
$resclt='';
$client_id='';
if ($clientGrp!='')
{   $group=$payrollAdmin->displayClientGroupById($clientGrp);
    $grpClientIds=$payrollAdmin->getGroupClientIds($clientGrp)  ;
    $grpClientIds[0]['mast_client_id'];
    $resclt=$payrollAdmin->displayClient($grpClientIds[0]['mast_client_id']);
    
    $grpClientIdsOnly=$payrollAdmin->getGroupClientIdsOnly($clientGrp);
    // $setExcelName = "Paysheet_Group".$clientGrp;
    $client_id =$grpClientIdsOnly['client_id'];
    // print_r($group);echo "!!!!!!!!!<br>"; 
     if ($clientGrp == 1) {
        // echo "!!!!!!!1";
        $clientids = $payrollAdmin->displayclientbyComp($comp_id);
        // print_r($clientids);
        $resclt = $payrollAdmin->displayClient($clientids['client_id']);
        $client_id=$clientids['client_id'];
    }
}
else
{
    $client_id= $clientid;
    $resclt=$payrollAdmin->displayClient($client_id);
    // $setExcelName = "Paysheet_".$clientid;

}
if ($month == 'current') {
   // echo "current";
    $frdt = date('Y-m-t', strtotime($resclt['current_month']));
} else if ($month == 'previous') {
    // echo "previous";
    $frdt = date('Y-m-t', strtotime($_SESSION['frdt']));
}


$client_name = ($clientGrp=='')?  $resclt['client_name']:   "Group : ".$group['group_name']; 
$monthtit =  date('F Y',strtotime($frdt));
$todt = $frdt;
$res12 = $payrollAdmin->getAdvancesList($client_id,$comp_id,$month,$frdt,$todt);
//print_r($res12);echo"@@@@@@@@@@@@";
$tcount= sizeof($res12);

	
  $row22 = $payrollAdmin->getadvanceTypeName($advtype);  

if($month!=''){
    $reporttitle=$row22['advance_type_name']." Statement for the month ".$monthtit;
}
$p='';
if($emp=='Parent'){
    $p="(P)";
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
            padding: 5px!important;
            border: 1px dotted black!important;
            font-size:12px !important;
            font-family: monospace;

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
            body{
                margin-left: 50px;
            }
        }

        @media all {
            #watermark {
                display: none;

                float: right;
            }

            .pagebreak {
                display: none;
            }
	div{padding-right: 20px!important;padding-left: 20px!important;
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
<body>
<div class="btnprnt">
    <button class="submitbtn" onclick="myFunction()">Print</button>
    <button class="submitbtn"  onclick="history.go(-1);" >Cancel</button>
</div>
<!-- header starts -->


<!-- header end -->

<!-- content starts -->




<div>
<div class="header_bg">


<?php
include('printheader3.php');
?>
    <div class="row body" >

    <table width="100%">
    <tr>
	    <th class="thheading" >SrNo.</th>
    
        <th class="thheading" colspan="3">NAME OF THE EMPLOYEE
        </th>
        <th class="thheading" >ADV. DATE
        </th>
        <th class="thheading" >ADV.AMOUNT RS.
        </th>
        <th class="thheading" >INST.AMT. RS.
        </th>
        <th class="thheading" >DETAILS of Paid Amt.
        </th>
        <th class="thheading" >AMOUNT PAID<br> So far
        </th>
        <th class="thheading" >BALANCE RS.
        </th>
    </tr>

<?php
$totalamt=0;
$totalbal=0;


$ttotalco2=0;
$totalco2=0;
$totalstdam=0;
$c[]='';
$i=1;
$tot_inst= 0;
$tot_bal = 0;
$adv_amount=0;
foreach($res12 as $row)
{
    $totaltype=0;
	$advid=$row['emp_advance_id'];
	
    
   $row22 = $payrollAdmin->getadvanceTypeName1($advid);  	
    ?>
    <tr>
        <td align="center" >
            <?php
            echo $i;
      ?>
        </td>

        <td colspan="3">
            <?php
            echo $row["first_name"]." ".$row["middle_name"]." ".$row["last_name"]." (".$row["emp_id"].")";
       ?>
        </td>
       
        <td align="center" >
            <?php
            echo date('d-m-y',strtotime($row22['date']));
            ?>
        </td>       
		<td align="right" >
            <?php
            echo number_format($row22['adv_amount'],2,".",",");
			$adv_amount = $adv_amount+$row22['adv_amount'];
            ?>
        </td>
        <td align="right" >
            <?php
                     echo number_format($row['amount'],2,".",",");
					$totalamt +=$row['amount'];
            ?>
        </td>
 <td align="right" >
            <?php
            //echo $row['paid_amt']."<br>";
			$empId=$row['emp_id'];
			$emp_advance_id=$row['emp_advance_id'];
 	$row222 = $payrollAdmin->getadvanceTypeName2($empId,$frdt,$emp_advance_id); 
	foreach($row222 as $row2)
	{
		echo date("M y", strtotime($row2['sal_month']))."-".$row2['amount']."&nbsp&nbsp&nbsp ";
	}
	
	
			
            ?>
        </td>
		<td align="right" >
            <?php
            echo number_format($row['paid_amt']+$row['amount'],2,".",",");;
?>
</td>
		<td align="right" >
            <?php
            echo number_format($row22['adv_amount']-($row['paid_amt']+$row['amount']),2,".",",");
			$tot_bal+= $row22['adv_amount']-($row['paid_amt']+$row['amount']);
            ?>
        </td>

	</tr>
            <?php
    $i++;

}
?>
    <tr>
	    <td class="thheading" colspan="5" align = 'right'>Total 
        </td>
        <td class="thheading" align = "right"><?php echo number_format($adv_amount,2,".",","); ?>
        </td>
        <td class="thheading" align = "right"><?php echo number_format($totalamt,2,".",","); ?>
        </td>
        <th class="thheading" >
        </td>
		  <th class="thheading" >
        </td>
      
        <td class="thheading" align = "right"><?php echo number_format($tot_bal,2,".",","); ?>
        </td>
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