<?php
session_start();
// echo "111111";
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(0);
// print_r($_SESSION);
$month = $_SESSION['month'];
$clientid = $_SESSION['clientid'];
$comp_id = $_SESSION['comp_id'];
$user_id = $_SESSION['log_id'];
$emp = $_REQUEST['emp'];

$clientGrp = $_SESSION['clientGrp'];
$frdt = $_SESSION['frdt'];

$group[] = '';
$resclt = '';

// Retrieve employee report and client details from payrollAdmin class
$res = $payrollAdmin->showEmployeereport($comp_id, $user_id);
$resclt = $payrollAdmin->displayClient($clientid);

$cmonth = $resclt['current_month'];
$pfcode = $resclt['pfcode'];

// Clear uan_ecr_calc table using payrollAdmin function
$payrollAdmin->clearUanEcrCalc();

if ($clientGrp != '') {
    $group = $payrollAdmin->displayClientGroupById($clientGrp);
    $grpClientIds = $payrollAdmin->getGroupClientIds($clientGrp);
    $grpClientIdsOnly = $payrollAdmin->getGroupClientIdsOnly($clientGrp);
    $resclt = $payrollAdmin->displayClient($grpClientIds[0]['mast_client_id']);
    $setExcelName = "Paysheet_Group" . $clientGrp;
    $clientid = $grpClientIdsOnly['client_id'];
} else {
    $resclt = $payrollAdmin->displayClient($clientid);
    $setExcelName = "Paysheet_" . $clientid;
}
// echo $frdt."<br>";
if ($month == 'current') {
    // echo "current";
    $frdt = date('Y-m-t', strtotime($resclt['current_month']));
} else if ($month == 'previous') {
    // echo "previous";
    $frdt = date('Y-m-t', strtotime($_SESSION['frdt']));
}
$client_name = ($clientGrp=='') ? $resclt['client_name']: "Group : ".$group['group_name']; 

$monthtit =  date('F Y',strtotime($frdt));
// $todt=$frdt;
// Fetch employee deduction data using payrollAdmin function
$row = $payrollAdmin->fetchEmployeeDeductionData($clientid, $frdt, $comp_id);
// print_r($row);
$res14 = $payrollAdmin->fetchPfCharges($frdt);
// print_r($res14);
// Ensure the row set is not empty before processing
if (count($row)>0) {
    // echo "DDDDDDDD";
    foreach ($row as $row1) {
        if ($row1['client_id'] == null) {
            continue;
        }
// echo "!!!!!!!!!!!!!!";
        // Insert UAN ECR calculation using PDO
        $sql1 = $payrollAdmin->insertUanEcrCalc(
            $row1['uan'],
            $row1['first_name'],
            $row1['middle_name'],
            $row1['last_name'],
            $row1['gross_salary'],
            $row1['std_amt'],
            $row1['amount'],
            $row1['employer_contri_2'],
            $row1['employer_contri_1'],
            $row1['absent'],
            $row1['client_id']
        );
// print_r($sql1);
        // Execute the prepared statement
        // mysqli_query($this->connection, $sql1);
        // if (!$stmt->execute()) {
        //     echo "Error executing query: " . implode(", ", $stmt->errorInfo());
        // }
    }
}
// echo "$$$$$$$$$$";
// Fetch UAN calculation summary using payrollAdmin function
$res_uan1 = $payrollAdmin->fetchUanEcrCalcSummary($res14['acno2']);
                          
// Fetch EPF contributions using payrollAdmin function
$res_uan22 = $payrollAdmin->fetchEpfContributionSummary();
$res_uan2 = $payrollAdmin->fetchEpfContributionSummary();

$totadmin_pf = 0;
$totlink_ins = 0;

// Set session variables
if ($month != '') {
    $reporttitle = "PF CODE SUMMARY " . $monthtit;
}

$_SESSION['client_name'] = $client_name;
$_SESSION['reporttitle'] = strtoupper($reporttitle);
?>

<!DOCTYPE html>

<html lang="en-US">
<head>

    <meta charset="utf-8"/>


    <title> &nbsp;</title>

    <!-- Included CSS Files -->
    <link rel="stylesheet" href="../css/responsive.css">
    <link rel="stylesheet" href="../css/style.css">
<script>
    function myFunction() {
        window.print();
    }
</script>

    <style>
	    .message {
              color: #FF0000;
              text-align: center;
              width: 100%;
              
            }

	  
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



       .table-wrapper {
    padding: 50px; /* Adds padding around the table */
}

table {
    border: 1px solid black;
    width: 70%; /* Adjust width as needed */
    margin: 20px; /* Centers the table */
    border-collapse: collapse;
    font-size: 18px;
    font-family: monospace;
    padding: 20px;
}

td, th {
    padding: 20px; /* Increased padding inside cells for more space */
    text-align: left;
    border: 1px solid black; /* Adds borders around each cell */
}

tr {
    border-bottom: 1px solid black; /* Adds spacing between rows */
}

			
			
			@td1 {
            padding: 20px!important;
            border: 1px solid black!important;
            font-size:24px !important;
            font-family: monospace;
			align:'center';
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
            .body { padding: 10px;
			}
            body{
                margin-left: 150px;
            }
			
			@page {
   
				margin: 27mm 16mm 27mm 16mm;
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




<div class="page">
<div class="header_bg">
<?php
include('printheader4.php');


?>
</div>

<br><br><br>
    <div class="row body page table-wrapper" >
     <center>
	<table width="70%" >

    <tr>
	    <td class='td1' align='center!important'colspan ='5' style="padding: 8px;"><b>PF Code : <?php echo $pfcode;?></b></td>
		
    </tr>
    <tr>
	    <td  align='right!important' style="padding: 8px;">No. OF EMPLOYEE</td>
		<td colspan="4" align="right" style="padding: 8px;"><h5><?php echo $res_uan1['cnt'];?></h5> </td>
    </tr>
	<tr>
	    <td  align='right!important' style="padding: 8px;">EPF WAGES</td>
		<td colspan="4" align="right" style="padding: 8px;"><h5><?php echo number_format($res_uan1['epf_wages'],2,".",",");?></h5>
		</td>
    </tr>
	<tr>
        <td  align='right!important' style="padding: 8px;">EPS WAGES</td>
		<td colspan="4" align="right" style="padding: 8px;"><h5><?php echo number_format($res_uan1['eps_wages'],2,".",",");?></h5></td>
    </tr>
	<tr>
        <td  align='right!important' style="padding: 8px;">EDLI WAGES</td>
		<td colspan="4" align="right" style="padding: 8px;"><h5><?php echo number_format($res_uan1['edli_wages'],2,".",",");?></h5></td>
    </tr
	<tr>
        <td  align='right!important' style="padding: 8px;">ACCOUNT NO. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(<?php echo $res14['acno1_employee'];?>%) &nbsp;&nbsp;&nbsp;&nbsp; 01 </tD>
		<td colspan="4" align="right" style="padding: 8px;"><h5> <?php echo number_format($res_uan1['epf_contribution'],2,".",",");?></h5></td>
	</tr>
	
	<tr>
        <td  align='right!important' style="padding: 8px;">ACCOUNT NO. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(<?php echo $res14['acno1_employer'];?>%) &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 01</tD>
		<td colspan="4" align="right" style="padding: 8px;"><h5><?php echo number_format($res_uan1['epf_eps_d'],2,".",",");?></h5></td>
	</tr>
	
	<tr>
        <td  align='right!important' style="padding: 8px;">ACCOUNT NO. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(<?php echo $res14['acno10'];?>%) &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 10 </td>
		<td colspan="4" align="right" style="padding: 8px;"><h5><?php echo number_format($res_uan1['eps_contribution'],2,".",",");?></h5></td>
	</tr>
	
	
	<tr>
        <td  align='right!important' style="padding: 8px;">TOTAL </td>
		<td colspan="4" align="right" style="padding: 8px;"><h5><?php echo  number_format( ($res_uan1['epf_contribution']+ $res_uan1['eps_contribution']+$res_uan1['epf_eps_d']),2,".",",");?></h5></td>
	</tr>
	
	
	
	<tr>
        <td  align='right!important' style="padding: 8px;">ACCOUNT NO.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (<?php echo number_format($res14['acno2'],2,".",",");?>%) &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 02</td>
		<td colspan="4"align="right" style="padding: 8px;"><h5><?php 
		echo  number_format($res_uan2['acno2'],2,".",",");
		$ac02 = $res_uan2['acno2'];
		?></h5></td>
	</tr>
	<tr>
       <td  align='right!important'style="padding: 8px;">ACCOUNT NO.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (<?php echo number_format($res14['acno21'],2,".",",");?>%) &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 21 </td>
		<td colspan="4"align="right"style="padding: 8px;"><h5><?php 
		//print_r($res_uan2);
		echo number_format($res_uan2['acno21'],2,".",",");
		$ac21= $res_uan2['acno21'];
		?></h5></td>
	</tr>
	<tr>
        <td  align='right!important' style="padding: 8px;">ACCOUNT NO. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(0.00%) &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 22</td>
		<td colspan="4"align="right" style="padding: 8px;"><h5><?php echo number_format(round( $res_uan1['epf_wages']*.00000,2),2,".",",");
		$ac22=round($res_uan1['epf_wages']*.00000,2);?></h5></td>
	</tr>
	
	
	<tr>
        <td  align='right!important' style="padding: 8px;"> TOTAL   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(<?php echo number_format($res14['acno1_employee']+$res14['acno1_employer']+$res14['acno10']+$res14['acno2']+$res14['acno21'],2,".",",");?>%) </td>
		<td colspan="4" align="right" style="padding: 8px;"><h5><?php echo number_format(round($ac22+$ac21+$ac02+$res_uan1['epf_eps_d']+$res_uan1['eps_contribution']+$res_uan1['epf_contribution']),2,".",",");?></h5></td>
	</tr>
	
	
    <tr>
       <td  align='right!important' colspan = "6"style="padding: 8px;">TRRN NO.</td>
		
	
	<tr>
        <td  align='right!important'  colspan = "6" style="padding: 8px;">TRRN DATE</td>
	
	</tr>
    
	<tr>	
		<td  align='right!important' colspan = "6"style="padding: 8px;" >TIME</td>
		

<?php
/*$totalamt=0;
$totalleave=0;
$rate=0;

/*$ttotalco2=0;
$totalco2=0;
$totalstdam=0;*/
$c[]='';
$i=1;
 
      /* echo $payment_date;
       echo $client_id;
	   */

/* $sql="SELECT leave_details.emp_id,leave_details.client_id,leave_details.payment_date,leave_details.encashed,leave_details.rate,leave_details.amount,employee.emp_id,employee.client_id,employee.first_name,employee.middle_name,employee.last_name,employee.joindate,employee.leftdate FROM leave_details INNER JOIN employee ON leave_details.emp_id=employee.emp_id WHERE employee.client_id= '".$client_id."' AND leave_details.payment_date='".$payment_date."' ";
$res = mysql_query($sql) or die(mysql_error());

if(mysql_affected_rows()==0)
{  
?>
	<div class="message"><?php echo "Record Not Found"; ?></div><br>
<?php	
}

while($row = mysql_fetch_array($res)){ */
	
?>
	
	


</table></center>
        </div>
<br/><br/>
    </div>

<!-- content end -->


</body>
</html>