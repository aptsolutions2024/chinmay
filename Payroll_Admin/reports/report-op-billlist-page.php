<?php
include ('../../include_payroll_admin.php');

error_reporting(0);
//print_r($_REQUEST);
$clientid=$_REQUEST['clientid'];
$billno=$_POST['billno'];

$resclt=$payrollAdmin->displayClient($clientid);

$getoptype = $payrollAdmin->getOptype($clientid,$_POST['billno']);
$getoptypehead1 = $payrollAdmin->getOptype1($clientid,$_POST['billno']);


?>
<table width = "80%">
<tr>
<td>SrNo</td>
<td>EmpId</td>
<td>Name of the Employee</td>
<td>Amount</td>
<td></td>
</tr>

<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8"/>
    <title> &nbsp;</title>
  
    <style>
        .thheading{
            text-transform: uppercase;
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


        table {
            border-collapse: collapse;
            width: 100%;

        }

        table, td, th {
            padding: 5px!important;
            border: 1px solid black!important;
            font-size:16px !important;
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
.logo .head1{font-size:27px !important}

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
    <div class="row body" >
<?php
//include('printheader.php');
$gtotal =0 ;
$reporttitle="Payment Details of Bill - no  ".$_POST['billno']." Dated ".date("d/m/Y",strtotime($getoptypehead1['payment_date']));
$_SESSION['client_name']=$resclt['client_name'];
$_SESSION['reporttitle']=strtoupper($reporttitle);
include('printheader3.php');
?>

<?php 
foreach($getoptype as $getoptype1)
{
		echo "<tr><td colspan = 5> Payment For - ".$getoptype1['op_name']."</td></tr>";
		$getopdetails = $payrollAdmin->getEmpOpdetails($clientid,$_POST['billno'],$getoptype1['op_id']);
		$srno= 1;
		foreach($getopdetails as $getopdetails1)
		{
			
				echo "<tr><td>".$srno."</td>";
				$srno++;
				echo "<td>".$getopdetails1['emp_id'] ."</td>";
				echo "<td>".$getopdetails1['emp_name'] ."</td>";
				echo "<td style='text-align:right;'>".number_format($getopdetails1['amount'] ,2,'.',',')."</td>";
				echo "<td></td>";
				
			}
	    echo "</tr><tr><td colspan =3 style='text-align:right;'>".$getoptype1['op_name']." Total</td><td style='text-align:right;'>".number_format ($getoptype1['amount'],2,'.',',')."</td><td></td></tr>";
	    $gtotal = $gtotal+$getoptype1['amount'];
	    echo "<tr><td colspan =4 style='text-align:right;'></td><td></td></tr>";
	//    $gtotal = $gtotal+$getoptype1['amount'];
	
}
echo "</tr><tr><td colspan =3 style='text-align:right;'>Grand Total</td><td style='text-align:right;'>".number_format($gtotal,2,'.',',')."</td><td></td></tr>";

echo "</table></div><br/><br/>";
?>

<script>
    function myFunction() {
        window.print();
    }
</script>
</body>
</html>