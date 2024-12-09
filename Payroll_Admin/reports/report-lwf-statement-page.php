<?php
session_start();
include ('../../include_payroll_admin.php');

error_reporting(0);
$month=$_SESSION['month'];
$clientid=$_SESSION['clientid'];
// $emp=$_REQUEST['emp'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
// print_r($_SESSION);
//$res=$payrollAdmin->showEmployeereport($comp_id,$user_id);



// $cmonth=$resclt['current_month'];
// if($month=='current'){
// 	$monthtit =  date('F Y',strtotime($cmonth));
//     $tab_emp='tran_employee';
//     $tab_empded='tran_deduct';
// 	$tab_days = 'tran_days';
//     $frdt=$cmonth;
//     $todt=$cmonth;
//   }
// else{
//     $monthtit =  date('F Y',strtotime($_SESSION['frdt']));
//     $tab_emp='hist_employee';
//     $tab_empded='hist_deduct';
// 	$tab_days = 'hist_days';
// 	$frdt=date("Y-m-d", strtotime($_SESSION['frdt']));
//     $todt=date("Y-m-d", strtotime($_SESSION['frdt']));
	
// 	$frdt=$payrollAdmin->lastDay($frdt);
//   }

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
    
    // print_r($group); echo "<br>";
    // print_r($client_id);
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
    $setExcelName = "Paysheet_".$clientid;

}
if ($month == 'current') {
    // echo "current";
    $frdt = date('Y-m-t', strtotime($resclt['current_month']));
} else if ($month == 'previous') {
    // echo "previous";
    $frdt = date('Y-m-t', strtotime($_SESSION['frdt']));
}

$client_name = ($clientGrp=='') ? $resclt['client_name']: "Group : ".$group['group_name']; 
$frdt=$payrollAdmin->lastDay($frdt);
$monthtit =  date('F Y',strtotime($frdt));
$todt=$frdt; 
// echo "<br>from date:".$frdt ."<br>********";

$res12=$payrollAdmin->getlwfStatement($client_id,$comp_id,$frdt);
//echo"$$$$$$$$$$$$";print_r($res12);
// $tcount= sizeof($res12);



if($month!=''){
    $reporttitle="L.W.F. Statement FOR ".$monthtit;
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

            display: block;
            page-break-after: always;
            z-index: 0;

        }

      
        table, td, th {
            padding: 5px!important;
            border: 1px dotted black!important;
            font-size:13px !important;
            font-family: monospace;

        }
		table#appletter ,table#appletter tr,table#appletter td,#tabltit table,#tabltit tr,#tabltit td {
			border: 0 !important;
		}
		
		div{padding-right: 20px!important;padding-left: 20px!important;
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
					height:50px;
                display:none!important;
            }
            .body { padding: 10px; }
            body{
                margin-left: 70px;
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

                display:block!important;

            }
            #footer {
			
                display:block!important;
            }

        }

		@page {
   
				margin: 27mm 16mm 27mm 16mm;
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
</div>


    <div class="row body page " >
        <table width="100%">
    <tr>
        <th class="thheading" width="7%">SR. NO.</th>
        <th class="thheading" width="10%">Emp. ID </th>
        <th class="thheading" colspan="3">Name Of the Employee </th>
        <th class="thheading" width="10%">Employee's Contribution</th>
        <th class="thheading" width="10%">Employer's Contribution</th>
        <th class="thheading" width="10%">Total</th>
    </tr>

<?php
$totalamt=0;
$totalco1=0;
$totalco2=0;

$ttotalco1=0;


$ttotalco2=0;
$totalco2=0;
$totalstdam=0;
$tabsent = 0;
$c[]='';
$amount= 0;
$i=0;
foreach($res12 as $row)
{
    $total1=0;
	$i++;
    ?>
    <tr>
        <td align="center" >           <?php  echo $i;?>        </td>
        <td align="center" >           <?php  echo $row["emp_id"];?>        </td>
        <td colspan="3"> <?php echo $row["first_name"]." ".$row["middle_name"]." ".$row["last_name"];?></td>
		<td align="center" > <?php  echo NUMBER_FORMAT($row['amount'],0," ",",");
									$totalamt=$totalamt+$row['amount'];
								?> </td>
        <td align="center" > <?php  echo NUMBER_FORMAT($row['employer_contri_1'],0," ",",");
									$totalco1=$totalco1+$row['employer_contri_1'];
								?>  </td>
        <td align="center" > <?php  echo NUMBER_FORMAT($row['employer_contri_1']+$row['amount'],0," ",",");
									$totalco2=$totalco2+$row['employer_contri_1']+$row['amount'];
								?>  </td>
 </tr>
            <?php
}
?>

            <tr>
                
				<td></td>
				<td></td>
                <td class="thheading"  colspan="3" >  Total  </td>
                <td class="thheading" align="center" ><?php echo NUMBER_FORMAT($totalamt,0," ",","); ?> </td>
                <td class="thheading"align="center"  ><?php echo NUMBER_FORMAT($totalco1,0," ",","); ?> </td>
                <td class="thheading"align="center"  ><?php echo NUMBER_FORMAT($totalco2,0," ",","); ?> </td>
            </tr>
			
			<tr>
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