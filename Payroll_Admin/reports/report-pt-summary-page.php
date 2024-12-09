<?php
session_start();
include ('../../include_payroll_admin.php');
error_reporting(0);
$month=$_SESSION['month'];
$clintid=$_SESSION['clintid'];
$emp=$_REQUEST['emp'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];

//$res=$payrollAdmin->showEmployeereport($comp_id,$user_id);

$resclt=$payrollAdmin->displayClient($clintid);
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
        $clientid=$clientids['client_id'];
    }
}
else
{
    $client_id= $clintid;
    $resclt=$payrollAdmin->displayClient($client_id);
    $setExcelName = "Paysheet_".$client_id;

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
// echo "frdt=".$frdt;
$res=$payrollAdmin->getptSummary($comp_id,$frdt);

$cl_name = array();
$gender = array();
$z_emp = array();
$z_sal= array();
$z_amt= array();
$o_emp = array();
$o_sal= array();
$o_amt= array();
$t_emp = array();
$t_sal= array();
$t_amt= array();
$i= 0;

foreach($res as $row)
{
	if ($cl_name[$i]== $row['client_name']){
		if($gender[$i]== $row['gender']){
			
		}
		else{
			$i++;
			$cl_name[$i] ="";
			$gender[$i]= $row['gender'];
  		
	}}
		else{
			$i++;
			$i++;
			$cl_name[$i] ='';
			$gender[$i]= $row['gender'];
			
	}
   $cl_name[$i] =$row['client_name'];
   $gender[$i]= $row['gender'];
   if ($row['slab'] == 0){
		$z_emp[$i] = $row['count'];
		$z_sal[$i]= $row['ssalary'];
		$z_amt[$i]= $row['amount'];
	   
   }
   
   if ($row['slab'] == 175){
		$o_emp[$i] = $row['count'];
		$o_sal[$i]= $row['ssalary'];
		$o_amt[$i]= $row['amount'];
	   
   }
   if ($row['slab'] == 200|| $row['slab'] == 300){
		$t_emp[$i] = $row['count'];
		$t_sal[$i]= $row['ssalary'];
		$t_amt[$i]= $row['amount'];
	   
   }

	
}



// t1= tran_deduct          t2 = employee       t3 = mast_client    t4 = tran_employee
  
if($month!=''){
    $reporttitle="Profession Tax Summary FOR THE MONTH ".$monthtit;
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
    <div class="row body" >
        <table width="100%">
    <tr>
        <th  align="left" colspan="3"  class="thheading">Name Of the Client</th>
        <th  align="left" class="thheading">Gender</th>
		<th  align="centre" colspan = "2" class="thheading" >Rs. 0</th>
		<th  align="centre" colspan = "2" class="thheading"align="centre" >Rs. 175</th>
		<th  align="centre" colspan = "2" class="thheading"align="centre" >Rs. 200/300</th>
		<th  align="centre" colspan = "2" class="thheading"align="centre" >TOTAL</th>
		</tr>
		<tr>
        <th  align="left" colspan="3"  class="thheading"></th>
        <th  align="left" class="thheading"></th>
        <th  align="left" class="thheading">No of Emp</th>
        <th width="10%" class="thheading" >Amount</th>
        <th  align="left" class="thheading">No of Emp</th>
        <th width="10%" class="thheading" >Amount</th>
        <th  align="left" class="thheading">No of Emp</th>
        <th width="10%" class="thheading" >Amount</th>
        <th  align="centre" class="thheading">Wages</th>
        <th width="10%" class="thheading" >Amount</th>

    </tr>

<?php
$z_count = 0;
$z_amount = 0;
$o_count = 0;
$o_amount = 0;
$t_count = 0;
$t_amount = 0;
$tot_sal = 0;
for ($j=0;$j<=$i;$j++){
 	$x=$t_sal[$j]+$z_sal[$j]+$o_sal[$j];
	$y=$t_amt[$j]+$z_amt[$j]+$o_amt[$j];
	if ($x>0 ){
	echo "<tr><td colspan = '3'>".$cl_name[$j]."</td>";
	echo "<td>".$gender[$j]."</td>";
	
	echo "<td align='right'>".$z_emp[$j]."</td>";
	//echo "<td>".$z_sal[$j]."</td>";
	echo "<td  align='right'>".$z_amt[$j]."</td>";
	
	echo "<td  align='right'>".$o_emp[$j]."</td>";
	//echo "<td>".$o_sal[$j]."</td>";
	echo "<td align='right'>".$o_amt[$j]."</td>";

	echo "<td align='right'>".$t_emp[$j]."</td>";
	//echo "<td>".$t_sal[$j]."</td>";
	echo "<td align='right'>".$t_amt[$j]."</td>";

	$x=$t_sal[$j]+$z_sal[$j]+$o_sal[$j];
	echo "<td align='right'>".$x."</td>";
	echo "<td align='right'>".number_format($y,2,'.',',')."</td></tr>";
	
	$z_count += $z_emp[$j];
	$z_amount+= $z_amt[$j];
	$o_count += $o_emp[$j];
	$o_amount+= $o_amt[$j];
	$t_count += $t_emp[$j];
	$t_amount+= $t_amt[$j];
	$tot_sal +=$t_sal[$j]+$z_sal[$j]+$o_sal[$j];
	}
}
	echo "<tr><td colspan = '3'></td>";
	echo "<td>Total</td>";
	
	echo "<td align='right'>".$z_count."</td>";
	//echo "<td></td>";
	echo "<td align='right'>".number_format($z_amount,2,'.',',')."</td>";
	
	echo "<td align='right'>".$o_count."</td>";
	//echo "<th></th>";
	echo "<td align='right'>".number_format($o_amount,2,'.',',')."</td>";

	echo "<td align='right'>".$t_count."</td>";
	//echo "<td></th>";
	echo "<td align='right'>".number_format($t_amount,2,'.',',')."</td>";

	echo "<td align='right'>".number_format($tot_sal,2,'.',',')."</td>";
	//echo "<td></th>";
	$y=$t_amount+$z_amount+$o_amount;
	echo "<td align='right'>".number_format($y,2,'.',',')."</td>";
	


echo "</tr></table>";


    ?>

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