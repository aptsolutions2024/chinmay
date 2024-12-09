    <?php
include ('../../include_payroll_admin.php');

error_reporting(0);
$month=$_SESSION['month'];
$clientid=$_SESSION['clientid'];
// $emp=$_REQUEST['emp'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];

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
    $setExcelName = "Paysheet_Group".$clientGrp;
    $client_id =$grpClientIdsOnly['client_id'];
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
    $resclt=$payrollAdmin->displayClient($clientid);
    $setExcelName = "Paysheet_".$clientid;

}
if ($month == 'current') {
    // echo "current";
    $frdt = date('Y-m-t', strtotime($resclt['current_month']));
} else if ($month == 'previous') {
    // echo "previous";
    $frdt = date('Y-m-t', strtotime($_SESSION['frdt']));
}

$client_name = ($clientGrp=='')?  $resclt['client_name']:   "Group : ".$group['group_name']; 
$frdt=$payrollAdmin->lastDay($frdt);
$monthtit =  date('F Y',strtotime($frdt));
$todt=$frdt; 


// $tcount= sizeof($res12);

if($month!=''){
    $reporttitle="ESI Statement FOR THE MONTH ".$monthtit;
}
$res_code = $payrollAdmin->getEsicode($comp_id,$client_id);
$tcount= sizeof($res_code);


if($month!=''){
    $reporttitle="ESI Statement FOR THE MONTH ".$monthtit;
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
    
		.tdtext{
            text-transform: uppercase;
			 align-content: center;
			 
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

        .page-bk_before {
            position: relative;

            /*display: block;*/
			page-bk_before:auto;
            z-index: 0;

        }

        table {
            border-collapse: collapse;
            width: 100%;

        }

        table, td, th {
            padding: 5px!important;
            border: 1px dotted black!important;
            font-size:14px !important;
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
@page {
   
				margin: 27mm 16mm 27mm 16mm;
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




<div class="container">
<div class="header_bg">
<?php
include('printheader3.php');
?>
</div>
 
   
 <div class="row body " >


<?php 
$prev_esicode = "";
$cnt = 0;
		$totalempcnt = 0;
				$totalamt=0;
				$totalsamt=0;
				$totalco=0;
				$tot_attend = 0;

foreach($res_code as $rowcode)
	{ ?>
				 
				 
			<?php 
                $res12=$payrollAdmin->getESIstatement($rowcode['client_id1'],$comp_id,$frdt);
                // print_r($res12);exit;
    	    	$i=0;

			    $tot_cl_attend = 0;
    			$total_cl_amt = 0;
	    		$total_cl_samt=0;
		    	$total_cl_co = 0;
			    $tot_cl_empcnt = 0;
			
			    echo    " <div class = 'page-bk' >
			    <table width='100%'>";
		
			echo "<div align='centre'!important > <h5> ESI STATEMENT FOR  : ". $rowcode['esicode']."<BR> MONTH : ".$monthtit. "</h5></div>";
// 	echo "
// 			<tr>
// 				<th class='thheading' width='3%'>Emp. ID </th>
// 				<th class='thheading' width='3%'>Clnt No </th>
// 				<th class='thheading' width='7%'>ESI No </th>
// 				<th class='thheading' width='28%'>Name Of the Employee</th>
// 				<th class='thheading' width='9%'>Birthdate</th>
// 				<th class='thheading' width='9%'>Joindate</th>
// 				<th class='thheading' width='3%'>Working Days</th>
// 				<th class='thheading' width='7%'>Total Rs.</th>
// 				<th class='thheading' width='7%'>Empesi <br /> Contri.</th>
// 				<th class='thheading' width='5%'>Emyr's <br />Contri.</th>
// 			</tr>";
echo "
    <tr>
        <th class='thheading' width='3%'>Emp. ID </th>
        <th class='thheading' width='3%'>Clnt No </th>
        <th class='thheading' width='7%'>ESI No </th>
        <th class='thheading' width='28%'>Name Of the Employee</th>
        <th class='thheading' ></th>
        <th class='thheading' width='3%'>Working Days</th>
        <th class='thheading' width='7%'>Total Rs.</th>
        <th class='thheading' width='7%'>Empesi <br /> Contri.</th>
        <th class='thheading' width='5%'>Emyr's <br />Contri.</th>
    </tr>";

			
			
            foreach($res12 as $row)
            {    
                $cnt++;
				?>			

		 
			
			<tr>
    <td align="center"><?php echo $row["emp_id"]; $tot_cl_empcnt++; $totalempcnt++; ?></td>
    <td align="center"><?php echo $row["client_id"]; ?></td>
    <td align="center"><?php echo $row["esino"]; ?></td>
    <td><?php echo $row["first_name"]." ".$row["middle_name"]." ".$row["last_name"]; ?></td>
    <td align="center"></td>
    <td align="center"><?php echo $row["present"]; $tot_attend += $row["present"]; $tot_cl_attend += $row["present"]; ?></td>
    <td align="center"><?php echo $row['std_amt']; $totalsamt += $row['std_amt']; $total_cl_samt += $row['std_amt']; ?></td>
    <td align="center"><?php echo number_format($row['amount'], 0, ".", ","); $totalamt += $row['amount']; $total_cl_amt += $row['amount']; ?></td>
    <td align="center"><?php echo number_format($row['employer_contri_1'], 2, ".", ","); $totalco += $row['employer_contri_1']; $total_cl_co += $row['employer_contri_1']; ?></td>
</tr>
						<?php
				$i++;
			}
		
?>
	   <tr>
			<td class='thheading' colspan="3">No. of Employees</td>
			<td class='thheading' align="left" ><?php echo $tot_cl_empcnt; ?> </td>
			 
			<td align="right"  class='thheading' > Client Total</td>
			<td class='thheading' align="center" ><?php echo NUMBER_FORMAT( $tot_cl_attend,2,".",","); ?> </td>
			<td class='thheading' align="center" ><?php echo NUMBER_FORMAT( $total_cl_samt,2,".",","); ?> </td>
			<td class='thheading' align="center" ><?php echo NUMBER_FORMAT($total_cl_amt,2,".",","); ?> </td>
			<td class='thheading' align="center" ><?php echo NUMBER_FORMAT($total_cl_co,2,".",","); ?> </td>
		</tr> 
		
		<tr>
			<td class='thheading' colspan="3">Total Wages :</td>
			<td class='thheading'align="right" ><h5><?php echo $totalsamt; ?> </h5></td>
			<td colspan="9"></td>
		</tr>
		<tr>

		  <td class='thheading' colspan="3">Employees' Contri.:</td>

					<td  class='thheading'align="right"  ><h5><?php echo $totalamt; ?></h5> </td>
		  <td class='thheading' colspan="9"></td>
				</tr>

		<tr>

				  <td  class='thheading' colspan="3">Employer's Contri.:</td>
				  <td class='thheading' align="right" ><h5><?php echo round($totalco+0.5,0); ?> </h5></td>
				  <td colspan="9"></td>
		</tr>
        <tr>
					<td class='thheading' colspan="3"><h5>Total Contri.:</h5></td>
				  <td class='thheading' align="right" ><h5><?php echo round(round($totalco+0.5,0)+$totalamt,0); ?></h5> </td>
				  <td colspan="9"></td>

		</tr>
		</table> </div>
	<?php 
	}
	

    echo    "<table width='100%'>

	<tr>
        <th class='thheading' width='3%'>Emp. ID </th>
        <th class='thheading' width='3%'>Clnt No </th>
        <th class='thheading' width='7%'>ESI No </th>
        <th class='thheading' width='28%'>Name Of the Employee</th>
        <th class='thheading' width='9%'>Birthdate</th>
        <th class='thheading' width='9%'>Joindate</th>
        <th class='thheading' width='3%'>Working Days</th>
        <th class='thheading' width='7%'>Total Rs.</th>
        <th class='thheading' width='7%'>Empesi <br /> Contri.</th>
        <th class='thheading' width='5%'>Emyr's <br />Contri.</th>
    </tr>";
	?>
	</div>
        <tr>
                <td class='thheading' colspan="2">No. of Employees***</td>
                <td class='thheading' align="center" ><?php echo $tcount; ?> </td>
                <td colspan="2"></td>
                <td align="right"  class='thheading' > Total</td>
                <td class='thheading' align="center" ><?php echo NUMBER_FORMAT( $tot_attend,2,".",","); ?> </td>
                <td class='thheading' align="center" ><?php echo NUMBER_FORMAT( $totalsamt,2,".",","); ?> </td>
                <td class='thheading' align="center" ><?php echo NUMBER_FORMAT($totalamt,2,".",","); ?> </td>
                <td class='thheading' align="center" ><?php echo NUMBER_FORMAT($totalco,2,".",","); ?> </td>
            </tr>


	</table></div>
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