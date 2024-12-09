 <?php
include ('../../include_payroll_admin.php');

//error_reporting(0);
$month=$_SESSION['month'];
$clientid=$_SESSION['clientid'];
// $emp=$_REQUEST['emp'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];


$result1 = $payrollAdmin->showClient1($comp_id,$user_id);
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


// ******************
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


// ******************



if($month!=''){
    $reporttitle="L.W.F. Summary FOR ".$monthtit;
}

//$_SESSION['client_name']=$resclt['client_name'].$p;
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
        <th class="thheading" width="7%">Sr. No.</th>
        <th class="thheading" width="10%">Client Id </th>
        <th class="thheading" >Name of the Client </th>
		<th class="thheading" >Amount Rs. </th>
        <th class="thheading" >Total Employees </th>
        <th class="thheading" width="10%">Employee's Contribution</th>
        <th class="thheading" width="10%">Employer's Contribution</th>
        <th class="thheading" width="10%">Total</th>
    </tr>

<?php
$totalco3=0;
$totalco1=0;
$totalco2=0;
$totalco4=0;
$c[]='';
$amount= 0;
$i=0;
foreach($result1 as $row1){
	  $i++;
	  if  ($row1['mast_client_id']==21 or $row1['mast_client_id'] == 22 or $row1['mast_client_id']==25 or $row1['mast_client_id'] == 26  or $row1['mast_client_id']==19  or $row1['mast_client_id']==5){

	$clientid=$row1['mast_client_id'];
 
  
  $res12=$payrollAdmin->getlwfSummary($frdt,$clientid);

$cnt = sizeof($res12);
$ctotalco3=0;
$ctotalco1=0;
$ctotalco2=0;
$ctotalco4=0;
if ($cnt >0){
?>

<tr>
        <td align="right" >           <?php  echo $i;?>        </td>
        <td align="right" >           <?php  echo $row1["mast_client_id"];?>        </td>
        <td > <?php echo $row1["client_name"];?></td>
		<td > </td> <td > </td><td > </td><td > </td><td > </td>
		</tr>

<?php  } 

foreach($res12 as $res121) {
?>
       <tr><td > </td><td > </td><td > </td>
	   <td align="right" >           <?php  echo $res121['amount1'];?>        </td>
			<td align="right" >           <?php  echo $res121['cnt'];?>        </td>
		    <td align="right" >           <?php  echo number_format($res121['amount1'],2,".",",");?>        </td>
	        <td align="right" >           <?php  echo  number_format($res121['employer_contri_1'],2,".",",");?>        </td>
	        <td align="right" >           <?php  echo  number_format($res121['amount1']+$res121['employer_contri_1'],2,".",",");?>        </td></tr>
 <?php
$ctotalco1+=$res121["cnt"];
$ctotalco2+=$res121["amount1"];
$ctotalco3+=$res121["employer_contri_1"];
$ctotalco4+=$res121["amount1"]+$res121["employer_contri_1"];

 }
 
 if  ( $ctotalco1 >0 || $ctotalco2 >0  ||$ctotalco1 >3 || $ctotalco4 >0){ ?>
       <tr> </td><td > </td><td > </td><td > </td>
	   <td align="right"  >   Total        </td>
			<td align="right" >           <?php  echo  number_format($ctotalco1,0,".",",");?>        </td>
		    <td align="right" >           <?php  echo  number_format($ctotalco2,2,".",",");?>        </td>
	        <td align="right" >           <?php  echo  number_format($ctotalco3,2,".",",");?>        </td>
			 <td align="right" >           <?php  echo  number_format($ctotalco4,2,".",",");?>        </td></tr>
 <?php }
$totalco3+=$ctotalco3;
$totalco1+=$ctotalco1;
$totalco2+=$ctotalco2;
$totalco4+=$ctotalco4;
 }
  
 ?>
 
       <tr><td > </td><td > </td><td > </td>
	   <td align="right"  >  Grand Total        </td>
			<td align="right" >           <?php  echo number_format($totalco1,0,".",",");?>        </td>
		    <td align="right" >           <?php  echo number_format($totalco2,2,".",",");?>        </td>
	        <td align="right" >           <?php  echo number_format($totalco3,2,".",",");?>        </td>
			<td align="right" >           <?php  echo number_format($totalco4,2,".",",");?>        </td>
			</tr>
 
<?php } ?> 
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