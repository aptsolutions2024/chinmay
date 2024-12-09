<?php
include ('../../include_payroll_admin.php');

error_reporting(0);
$month=$_SESSION['month'];
$clientid=$_SESSION['clientid'];
//$emp=$_REQUEST['emp'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];


$month = $_REQUEST['mon'];
$frdt = $_REQUEST['frdt'];
 $todt = $_REQUEST['todt'];


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
    // echo "client Group";
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
    // echo "Client";
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

$client_name = ($clientGrp=='') ? $resclt['client_name']: "Group : ".$group['group_name']; 
$frdt=$payrollAdmin->lastDay($frdt);
$monthtit =  date('F Y',strtotime($frdt));
$todt=$frdt; 


$res=$payrollAdmin->getESICode2($frdt,$comp_id,$client_id);



if($month!=''){
    $reporttitle="Without ESI Summery Statement FOR THE MONTH ".$monthtit;
}
$_SESSION['client_name']=$client_name;
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

<div class="container">
<div class="header_bg">
<?php
include('printheader3.php');
?>
</div>
 
    <div class="row body" >

<table width='90%'>

 <tr>	<th class='thheading' width='7%'>Sr. No.</th>
        <th class='thheading' width='5%'>Salary Month</th>
        <th class='thheading' width='5%'>Client Id </th>
        <th class='thheading' width='7%'>Emp Id </th>
        <th class='thheading' width='25%'>Name of The Employee</th>
        <th class='thheading' width='5%'>Gross Salary</th>
		 <th class='thheading' width='18%'>Client</th>
		
        
    </tr>

<?php 
	$sr=1;
	$total=sizeof($res);
	if($total!=0){
foreach($res as $client){
  ?>
 <tr><td><?php echo $sr;?></td>
        <td ><?php echo date('M Y',strtotime($client['sal_month']));?> </td>
        <td ><?php echo $client['mast_client_id'];?>  </td>
        <td ><?php echo $client['emp_id'];?>  </td>
        <td ><?php echo $client['first_name']." ".$client['middle_name']." ".$client['last_name'];?> </td>
        <td ><?php echo $client['gross_salary'];?> </td>
        <td ><?php echo $client['client_name'];?> </td>
    </tr>
	<?php $sr++;}}else{ ?> 
	<tr><td colspan="7" align="center">No record found.</td></tr>
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