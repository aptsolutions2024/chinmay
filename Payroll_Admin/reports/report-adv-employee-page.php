<?php
include ('../../include_payroll_admin.php');

$month=$_SESSION['month'];
$clientid=$_SESSION['clientid'];

$advdate1= date("Y-m-d",strtotime($_REQUEST['advdate']));
$doc_path = $_SERVER["DOCUMENT_ROOT"];
    include($doc_path . '/include_payroll_admin.php');
 $selectedDate = $_REQUEST['advdate'] ?? null;    
// echo $selectedDate;
$resclt=$payrollAdmin->displayClient($clientid);
$cmonth=$resclt['current_month'];

if ($_SESSION['log_type'] == 2) {
    // Logic for log_type 2
    // echo "11111";
    
    $month = $_SESSION['month'];
    $clientid = $_SESSION['clientid'];
    $clientGrp = $_SESSION['clientGrp'];
    $emp=$_REQUEST['eid'];
    $comp_id = $_SESSION['comp_id'];
    $user_id = $_SESSION['log_id'];
    $zerosal = $_REQUEST['zerosal'];
    $noofpay = $_REQUEST['noofpay'];
    $empid = $_REQUEST['empid'];
    $per = $noofpay;

    if (isset($_SESSION['frdt'])) {
        $frdt = date('Y-m-01', strtotime($_SESSION['frdt'] . '-01'));
        $todt = date('Y-m-t', strtotime($_SESSION['frdt'] . '-01'));
        $monthtit = date('F Y', strtotime($frdt));
    } else {
        echo "Session dates are not set properly.";
    }

    if ($month == 'current') {
        $monthtit = date('F Y', strtotime($cmonth));
        $tab_emp = 'tran_employee';
        $tab_empded = 'tran_deduct';
        $tab_adv = 'tran_advance';
        $frdt = $cmonth;
        $todt = $cmonth;
    } else {
        $monthtit = date('F Y', strtotime($_SESSION['frdt']));
        $tab_emp = 'hist_employee';
        $tab_empded = 'hist_deduct';
        $tab_adv = 'hist_advance';
        $frdt = date("Y-m-d", strtotime($_SESSION['frdt']));
        $todt = date("Y-m-d", strtotime($_SESSION['frdt']));
    }

 $res122 = $payrollAdmin->empAdvanceList($advdate1, $emp);

 $res = $payrollAdmin->getHistAdvance($res122['emp_advnacen_id']);
  
    $res1 = $payrollAdmin->getTranAdvance($res122['emp_advnacen_id']);
// print_r($res122);
    if ($month != '') {
        $reporttitle = "Statement For Advance taken of Rs." . $res122['adv_amount'] . " on " . date("d-m-Y", strtotime($advdate1)) . " By " . $res122['first_name'] . " " . $res122['middle_name'] . " " . $res122['last_name'];
    }
    $_SESSION['client_name'] = $resclt['client_name'];
    $_SESSION['reporttitle'] = strtoupper($reporttitle);

}

else if ($_SESSION['log_type'] == 5) {
    // Logic for log_type 5
    include('../../include_payroll_admin.php');
    $payrollAdmin = new payrollAdmin();

    $clientid = $_SESSION['clientid'];
    $emp = $_SESSION['emp_login_id'];
    $comp_id = $_SESSION['comp_id'];
    $user_id = $_SESSION['log_id'];
    $zerosal = '';
    $noofpay = '';
    $empid = $_SESSION['emp_login_id'];
    
    
   
     $frdt = date('Y-m-01', strtotime($_REQUEST['frdt'] . '-01'));
        $todt = date('Y-m-t', strtotime($_REQUEST['frdt'] . '-01'));
    $monthtit = date('F Y', strtotime($frdt));
    $per = 1;
    // echo "@@@@@@@@222";
     $res122 = $payrollAdmin->empAdvanceList($selectedDate, $emp);
 $res = $payrollAdmin->getHistAdvance($res122['emp_advnacen_id']);
    $res1 = $payrollAdmin->getTranAdvance($res122['emp_advnacen_id']);
//   echo $res122['adv_amount'];
        $reporttitle = "Statement For Advance taken of Rs." . $res122['adv_amount'] . " on " . date("d-m-Y", strtotime($advdate1)) . " By " . $res122['first_name'] . " " . $res122['middle_name'] . " " . $res122['last_name'];
     $_SESSION['reporttitle'] = strtoupper($reporttitle);
}


else {
    echo "<script>window.location.href='/payroll-logout';</script>";
    exit();
}
   

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
//include('printheader3.php');
?>
</div>
<?php
include('printheader3.php');
?>

    <div class="row body" >







        <table width="100%">

    <tr>
	    <th class="thheading" >SrNo.</th>
    
        <th class="thheading" >Date</th>
        <th class="thheading" >INST.AMT. RS.
        </th>
        </th>
        <th class="thheading" >Earlier Paid Amount RS.<br> (Excluding current Inst.)
        </th>
        <th class="thheading" >BALANCE RS.
        </th>
    </tr>

<?php
 $i=1;
//print_r($res);
foreach($res as $row)
{?>
    <tr>
        <td align="center" >
            <?php
            echo $i;
      ?>
        </td>
    <td align="center" >
            <?php
            echo date("d-m-Y",strtotime($row['sal_month']));
      ?>
        </td>
        <td align="right" >
            <?php
                     echo number_format($row['amount'],2,".",",");
            ?>
        </td>

        <td align="right" >
            <?php
            echo $row['paid_amt']."<br>";
            ?>
        </td>
		<td align="right" >
            <?php
            echo number_format($res122['adv_amount']-($row['paid_amt']+$row['amount']),2,".",",");
			
            ?>
        </td>

	</tr>
            <?php
    $i++;

}
foreach($res1 as $row)
{?>
    <tr>
        <td align="center" >
            <?php
            echo $i;
      ?>
        </td>
    <td align="center" >
            <?php
            echo  date("d-m-Y",strtotime($row['sal_month']));
      ?>
        </td>
        <td align="right" >
            <?php
                     echo number_format($row['amount'],2,".",",");
            ?>
        </td>

        <td align="right" >
            <?php
            echo $row['paid_amt']."<br>";
            ?>
        </td>
		<td align="right" >
            <?php
            echo number_format($res122['adv_amount']-($row['paid_amt']+$row['amount']),2,".",",");
			
            ?>
        </td>

	</tr>
            <?php
    $i++;

}

?>
    
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