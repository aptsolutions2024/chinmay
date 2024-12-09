<?php
session_start();
//error_reporting(0);
$month=$_SESSION['month'];
$client_id=$_REQUEST['client'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
include ('../../include_payroll_admin.php');

$res=$payrollAdmin->showEmployeereport($comp_id,$user_id);

$resclt=$payrollAdmin->displayClient($client_id);

$sql="SELECT leave_details.*,concat(employee.first_name,' ' ,employee.middle_name,' ',employee.last_name) as name,employee.joindate FROM leave_details INNER JOIN employee ON leave_details.emp_id=employee.emp_id WHERE employee.client_id= '".$client_id."' AND leave_details.from_date ='".date('Y-m-d',strtotime($_REQUEST['frdt1']))."' AND leave_details.to_date ='".date('Y-m-d',strtotime($_REQUEST['todt1']))."' order by  employee.emp_id";
	$res =$payrollAdmin->executeQuery($sql) ;
   $monthtit =  date('d-m-Y',strtotime($_REQUEST['frdt1'])) ." TO ".date('d-m-Y',strtotime($_REQUEST['todt1']));
	$frdt=date("Y-m-d", strtotime($_REQUEST['frdt1']));
    $todt=date("Y-m-d", strtotime($_REQUEST['todt1']));

$reporttitle = "LEAVE ENCASHMENT PERIOD : ".$monthtit;
$_SESSION['client_name']=$resclt['client_name'];
$_SESSION['reporttitle']=strtoupper($reporttitle);

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

<br>
    <div class="row body" >
 
	<table width="100%">
	<?php 
//echo "<tr rowspan = 2> <td colspan ='13' align ='center'> <b>Payment Date : ".date('d-m-Y',strtotime($frdt))."</b></td></tr>"; ?> 
    <tr>
	    <th class="thheading" >SR. No.</th>
	    <th class="thheading" >EMP. ID</th>
        <th class="thheading" >NAME OF THE EMPLOYEE
        </th>
        <th class="thheading" >JN.DATE</th>
		<th class="thheading">PR.DAYS</th>
        <th class="thheading" >OPEING BAL.</th>
        <th class="thheading" >Eligible</th>
        <th class="thheading" >TOTAL</th>
     	<th class="thheading" >Availed</th>
		
     	<th class="thheading" >BALANCE</th>
			<th class="thheading" >ENCASHMENT</th>
    </tr>

<?php
$totalenjoyed=0;
$totalbalanced=0;


$c[]='';
$i=1;

	$totamt = 0;
	$totcnt = 0;
	$srno=0;
	
foreach($res as $row1){
	   
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
            echo $row1['emp_id'];
            ?>
        </td>

        <td align="left">
            <?php
            echo $row1["name"];
       ?>
        </td>
        <td align="center">
            <?php
                echo date("d-m-Y",strtotime($row1['joindate']));
            ?>
        </td>
		<td  align="right"> <?php echo $row1["present"];?></td>
		<td  align="right"> <?php echo $row1["ob"];?></td>
		
		<td  align="right"> <?php echo $row1["earned"];?></td>	
		<td  align="right"> <?php echo $row1["ob"]+$row1["earned"];?></td>
		<td  align="right"> <?php echo $row1["enjoyed"];$totalenjoyed+=$row1["enjoyed"];?></td>
	
		<td  align="right"> <?php echo $row1["balanced"]; $totalbalanced+=$row1["balanced"];?></td>
			<td  align="left"> <?php echo $row1["encashed"]; $totalbalanced+=$row1["encashed"];?></td>
	</tr>
             <?php
               }
			  

?>
<tr>
	<td   colspan = "8" align = "right" ><b><?php echo "TOTAL";?></b></td>
		<td   align = "right"> <?php echo $totalenjoyed; ?></td>
		
		<td   align = "right"> <?php echo$totalbalanced;?></td>
			<td  align="left"> <?php echo $row1["encashed"]; $totalbalanced+=$row1["encashed"];?></td>
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