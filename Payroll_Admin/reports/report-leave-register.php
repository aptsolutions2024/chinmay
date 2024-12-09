<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');
error_reporting(0);
$month=$_SESSION['month'];
$clientid=$_SESSION['clientid'];
$emp=$_REQUEST['emp'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];

$resclt=$payrollAdmin->displayClient($clientid);
$_SESSION['reporttitle']='';
// print_r($_SESSION);

 $clientGrp=$_SESSION['clientGrp'];
$frdt=$_SESSION['frdt'];

$group[]='';
$resclt='';
if ($clientGrp!='')
{   $group=$payrollAdmin->displayClientGroupById($clientGrp);
    $grpClientIds=$payrollAdmin->getGroupClientIds($clientGrp)  ;
    
    $grpClientIdsOnly=$payrollAdmin->getGroupClientIdsOnly($clientGrp);
    $resclt=$payrollAdmin->displayClient($grpClientIds[0]['mast_client_id']);
    $setExcelName = "Paysheet_Group".$clientGrp;
    $clientid =$grpClientIdsOnly['client_id'];
    
}
else
{
    $resclt=$payrollAdmin->displayClient($clientid);
    $setExcelName = "Paysheet_".$clientid;

}

$client_name = ($clientGrp=='') ? $resclt['client_name']: "Group : ".$group['group_name']; 


$row=$payrollAdmin->getLDFTdate($clientid,$_REQUEST['frdt1']);

  
	$frdt=date("Y-m-d", strtotime($_REQUEST['frdt1']));
    $todt=date("Y-m-d", strtotime($_REQUEST['todt1']));
 $monthtit =  date('d-m-Y',strtotime($_REQUEST['frdt1'])) ." TO ".date('d-m-Y',strtotime($_REQUEST['todt1']));
    $reporttitle="LEAVE ENCASHMENT PERIOD : ".$monthtit;
	//$reportdate="Date: ".$payment_date;
//}
 
$_SESSION['client_name']=$client_name;
$_SESSION['reporttitle']=$_SESSION['reporttitle'].strtoupper($reporttitle);

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
            .body { padding: 10px;
			}
            body{
                margin-left: 50px;
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




<div class="page container">
<div class="header_bg">
<?php
include('printheader3.php');
?>
</div>


    <div class="row body" >
 
	<table width="100%">
	<?php 
echo "<tr rowspan = 2> <td colspan ='8' align ='center'> <b>Payment Date : ".date('d-m-Y',strtotime($frdt))."</b></td></tr>"; ?> 
    <tr>
	    <th class="thheading"  width= "5%">SN</th>
	    <th class="thheading"  width= "8%">EMP ID</th>
        <th class="thheading"  width= "30%">NAME OF THE EMPLOYEE</th>
        <th class="thheading"  width= "18%" >JOIN DT</th>
		<th class="thheading"  width= "18%">LAST DT</th>
        <th class="thheading"  width= "8%">LEAVE</th>
        <th class="thheading"  width= "10%">RATE Rs.</th>
        <th class="thheading"  width= "10%">AMOUNT Rs.</th>
     	<!--th class="thheading" >CHEQUE NO.</th-->
    </tr>

<?php
$totalamt=0;
$totalleave=0;
$rate=0;

/*$ttotalco2=0;
$totalco2=0;
$totalstdam=0;*/
$c[]='';
$i=1;

$resdate=$payrollAdmin->getPaymentDate($clientid,$frdt,$todt);
$total=sizeof($resdate);
if($total==0)
	{echo '<div class="message">Record Not Found</div><br>';
		exit;
	}
	$totamt = 0;
	$totcnt = 0;
	
foreach($resdate as $row1)	
{
	   
	$res=$payrollAdmin->getPaymentDate2($clientid,$row1['payment_date']);
	$total1=sizeof($res);
	if($total1==0)
		{  echo '<div class="message">Record Not Found</div><br>';
		}
	$dateamt =0;
	$srno =0;
	foreach($res as $row)
	{
	    //echo "<pre>";print_r($row);
	
?>
	
	
    <tr>
	
        <td align="center" >
            <?php $srno++;
			$totcnt++;
            echo $srno;
            ?>
        </td>
        <td align="center" >
            <?php
            echo $row['emp_id'];
            ?>
        </td>

        <td align="left">
            <?php
            echo $row["first_name"]." ".$row["middle_name"]." ".$row["last_name"];
       ?>
        </td>
        <td align="center">
            <?php
                echo date("d-m-Y",strtotime($row['joindate']));
            ?>
        </td>
        <td align="center">
            <?php
			    if ($row['leftdate']!='0000-00-00' && $row['leftdate']!='1970-01-01' && $row['leftdate']!='')
					{echo date('d-m-Y',strtotime($row['leftdate']));}
				else
					{echo "-";}	
            ?>
        </td>

        <td align="right" >
            <?php
            echo $row['encashed'];
            ?>
        </td>       
		<td align="right" >
            <?php
            echo number_format($row['rate'],2,".",",");
            ?>
        </td>
        <td align="right" >
            <?php
            echo number_format($row['amount'],2,".",",");
			$dateamt+=$row['amount'];
			$totalamt+=$row['amount'];
			?>
	     </td>
<!--		<td align="center" >
            <?php
            echo $row['payment_date'];
            ?>
        </td>88>
		<td align="center" >
            
        </td-->

	</tr>
             <?php
               }
			  

?>
<!--<tr rowspan = 2><td colspan=11 align='right'>Date Total </td><td align="right"> <?php echo number_format($dateamt,2,".",",");?> </td><td></td></tr> -->
<?php }?>
<td colspan=7  align='right'>Grand Total</td><td align="right"> <?php echo number_format($totalamt,2,".",",");?> </td></tr>
 
 
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