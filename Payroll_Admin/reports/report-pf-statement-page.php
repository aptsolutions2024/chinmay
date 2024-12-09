<?php
session_start();
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

// Disable error reporting for production (optional)
error_reporting(0);

// Retrieve session and request variables
$month = $_SESSION['month'];
$clientid = $_SESSION['clientid'];
$emp = $_REQUEST['emp'];
$comp_id = $_SESSION['comp_id'];
$user_id = $_SESSION['log_id'];

// Initialize variables
$clientGrp = $_SESSION['clientGrp'];
$frdt = $_SESSION['frdt'];
$group = [];
$resclt = '';

// Process client group if it exists
if ($clientGrp != '') {
    $group = $payrollAdmin->displayClientGroupById($clientGrp);
    $grpClientIds = $payrollAdmin->getGroupClientIds($clientGrp);
    $grpClientIdsOnly = $payrollAdmin->getGroupClientIdsOnly($clientGrp);
    $resclt = $payrollAdmin->displayClient($grpClientIds[0]['mast_client_id']);
    $setExcelName = "Paysheet_Group" . $clientGrp;
    $clientid = $grpClientIdsOnly['client_id'];

    // Special case for client group 1
    if ($clientGrp == 1) {
        // echo "!!!!!!!1";
        $clientids = $payrollAdmin->displayclientbyComp($comp_id);
        // print_r($clientids);
        $resclt = $payrollAdmin->displayClient($clientids['client_id']);
        $clientid=$clientids['client_id'];
    }
} else {
    $resclt = $payrollAdmin->displayClient($clientid);
    $setExcelName = "Paysheet_" . $clientid;
}

// Handle month-related date calculations
if ($month == 'current') {
    // For current month, set the last day of the current month
    $frdt = date('Y-m-t', strtotime($resclt['current_month']));
} else if ($month == 'previous') {
    // For previous month, use the stored 'frdt' session date
    $frdt = date('Y-m-t', strtotime($_SESSION['frdt']));
}

// Set the client name for the report title
$client_name = ($clientGrp == '') ? $resclt['client_name'] : "Group : " . $group['group_name'];
$frdt = $payrollAdmin->lastDay($frdt);  // Get last day of the month
$monthtit = date('F Y', strtotime($frdt));  // Format month and year
$todt = $frdt;  // Set the 'to' date as the last day of the month
// echo "frdt".$frdt;
// Fetch PF statement data

$res12 = $payrollAdmin->getPFstatement($clientid, $comp_id, $frdt);
// print_r($res12);
$tcount = sizeof($res12);

// Set report title based on the month
if ($month != '') {
    $reporttitle = "PF Statement FOR THE MONTH " . $monthtit;
}

// Store client name and report title in session for later use
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
    <button class="submitbtn"  onclick="history.go(-1);" >Cancel</button>
</div>
<!-- header starts -->


<!-- header end -->

<!-- content starts -->




<div>
<div class="header_bg">
<?php
include('pfprintheader4.php');
?>
</div>


    <div class="row body">
        
    <table width="100%">

		<?php
			
		/*	$sql2 = "select * from pf_charges where '".$frdt."' >=from_date and '".$frdt."' <= to_date";
			$res13 = mysql_query($sql2);
			$res14 = mysql_fetch_array($res13);*/
			
			$res14=$payrollAdmin->getCharges($frdt);
?>
	





    <tr>
        <th class="thheading" width="4%">Clnt No </th>
        <th class="thheading" width="4%">EmpID  </th>
        <th class="thheading" width="5%">PF No  </th>
		<th class="thheading" width="7%">UAN No </th>
        <th class="thheading" width="7%" colspan = '3'>Name Of the Employee </th>
        <th class="thheading" width="7%">P.F. Wages</th>
        <th class="thheading" width="7%">Employee's P.F.<?php echo number_format($res14['acno1_employee'],2,".",","); ?> %</th>
        <th class="thheading" width="7%">Employer's P.F. <?php echo number_format($res14['acno1_employer'],2,".",","); ?>%</th>
        <th class="thheading" width="7%">Pension <?php echo number_format($res14['acno10'],2,".",","); ?>% </th>
		<th class="thheading" width="7%">Total 24%</th>
        
        <th class="thheading" width="7%">PFAdmin <?php echo number_format(trim($res14['acno2']),2,".",","); ?>% </th>
        <th class="thheading" width="7%">DLIS <?php echo number_format(trim($res14['acno21']),2,".",","); ?>% </th>
        <th class="thheading" width="7%">DLIS Admin <?php echo number_format($res14['acno22'],2,".",","); ?>% </th>

        <th class="thheading" width="7%">Total</th>
        <th class="thheading" width="7%">NCP Days</th>
    </tr>

<?php
 
$totalamt = 0;
$totalco1 = 0;
$ttotalco1 = 0;
$totalco833 = 0;
$ttotalco2 = 0;
$totalco2 = 0;
$totalstdam = 0;
$tabsent = 0;
$totac2 = 0;
$totac21 = 0;
$totac22 = 0;
$c[] = '';
$i = 0;

$empIdsDisplayed = []; // Array to keep track of displayed empIDs

foreach ($res12 as $row) {
    if (in_array($row["emp_id"], $empIdsDisplayed)) {
        // Skip this row if empID has already been displayed
        continue;
    }

    // Add the empID to the list of displayed empIDs
    $empIdsDisplayed[] = $row["emp_id"];
    
    $total1 = 0;
    ?>
    <tr>
        <td align="center">
             <?php
            
            $rowclient=$payrollAdmin->displayClient($row["client_id"]);
            echo $rowclient['short_name'];
      ?>
             
             </td>
        <td align="center"> <?php echo $row["emp_id"]; ?> </td>
        <td align="center"> <?php echo $row["pfno"]; ?> </td>
        <td align="center"> <?php echo $row["uan"]; ?> </td>
        <td colspan="3"> <?php echo $row["first_name"] . " " . $row["middle_name"] . " " . $row["last_name"]; ?> </td>
        <td align="center">
            <?php
            echo NUMBER_FORMAT($row['std_amt'], 0, " ", ",");
            $totalstdam += $row['std_amt'];
            $c[$i] = $row['amount'];
            ?>
        </td>
        <td align="center">
            <?php
            echo NUMBER_FORMAT($row['amount'], 0, " ", ",");
            $totalamt += $row['amount'];
            $c[$i] = $row['amount'];
            $total1 = $row['amount'];
            ?>
        </td>
        <td align="center">
            <?php
            echo NUMBER_FORMAT($row['employer_contri_1'], 0, " ", ",");
            $totalco1 += $row['employer_contri_1'];
            ?>
        </td>
        <td align="center">
            <?php
            echo NUMBER_FORMAT($row['employer_contri_2'], 0, " ", ",");
            $totalco833 += $row['employer_contri_2'];
            ?>
        </td>
        <td align="center">
            <?php
            echo NUMBER_FORMAT($row['employer_contri_2'] + $row['employer_contri_1'] + $row['amount'], 0, " ", ",");
            $ttotalco2 += $row['employer_contri_2'] + $row['employer_contri_1'] + $row['amount'];
            ?>
        </td>
        <td align="center">
            <?php
            $ac2 = round($row['std_amt'] * $res14['acno2'] / 100, 0);
            echo NUMBER_FORMAT($ac2, 0, " ", ",");
            $totac2 += $ac2;
            ?>
        </td>
        <td align="center">
            <?php
            $ac21 = round($row['std_amt'] * $res14['acno21'] / 100, 0);
            echo NUMBER_FORMAT($ac21, 0, " ", ",");
            $totac21 += $ac21;
            ?>
        </td>
        <td align="center">
            <?php
            $ac22 = round($row['std_amt'] * $res14['acno22'] / 100, 0);
            echo NUMBER_FORMAT($ac22, 0, " ", ",");
            $totac22 += $ac22;
            ?>
        </td>
        <td align="center">
            <?php
            echo NUMBER_FORMAT($row['employer_contri_2'] + $row['employer_contri_1'] + $row['amount'] + $ac2 + $ac21 + $ac22, 0, " ", ",");
            ?>
        </td>
        <td align="center">
            <?php
            echo NUMBER_FORMAT($row['absent'], 0, " ", ",");
            $tabsent += $row['absent'];
            ?>
        </td>
    </tr>
    <?php
    $i++;
}
?>

<?php
$s=array_count_values($c);

?>

            <tr>
                

                <td class="thheading" colspan = 7 >  Total  </td>
                <td class="thheading" align="center" ><?php echo NUMBER_FORMAT($totalstdam,0," ",","); ?> </td>
                <td class="thheading" align="center" ><?php echo NUMBER_FORMAT($totalamt,0," ",","); ?> </td>
                <td class="thheading"align="center"  ><?php echo NUMBER_FORMAT($totalco1,0," ",","); ?> </td>
                <td class="thheading" align="center" ><?php echo NUMBER_FORMAT($totalco833,0," ",","); ?> </td>
                 <td class="thheading" align="center" ><?php echo NUMBER_FORMAT($ttotalco2,0," ",","); ?> </td>
                 <td class="thheading" align="center" ><?php echo NUMBER_FORMAT($totac2,0," ",","); ?> </td>
                 <td class="thheading" align="center" ><?php echo NUMBER_FORMAT($totac2,0," ",","); ?> </td>
                 <td class="thheading" align="center" ><?php echo NUMBER_FORMAT($totac22,0," ",","); ?> </td>
				 
                 <td class="thheading" align="center" ><?php echo NUMBER_FORMAT($totalamt+$totalco1+$totalco833+$totac2+$totac21+$totac22,0," ",","); ?> </td>
                 <td class="thheading" align="center" ><?php echo NUMBER_FORMAT($tabsent,0," ",","); ?> </td>
				 
				 
            </tr>
			
			<tr>
			<td   class="thheading" colspan="17" >No. of Employees :<?php echo $tcount; ?></td>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</tr>
			
            <!--<tr>
                <td colspan="12"  class="thheading">Pf Admin Charges (<?php //echo "  ". $res14['acno2']?>%)</td>
                <td class="thheading" align="center" ><?php //echo $ac=round($totalstdam*$res14['acno2']/100,0); ?></td>
            </tr>
            <tr>
                <td class="thheading" colspan="12">D.L.I.S. Contribution (<?php //echo $res14['acno21']?>%)</td>
                <td class="thheading" align="center" ><?php //echo $dlisc=round($totalstdam*$res14['acno21']/100,0); ?></td>
            </tr>
            <tr>
                <td class="thheading" colspan="12">D.L.I.S. Admin Charges (<?php //echo $res14['acno22']?>%)</td>
                <td class="thheading" align="center" ><?php //echo $dlisac=round($totalstdam*$res14['acno22']/100,0); ?>
            </tr> <tr>
                <td class="thheading" colspan="12"></td>
                <td class="thheading" align="center" ><?php //echo NUMBER_FORMAT( round($totalamt+$totalco1+$totalco2+$dlisac+$dlisc+$ac,2),0,".",","); ?>
            </tr>-->

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