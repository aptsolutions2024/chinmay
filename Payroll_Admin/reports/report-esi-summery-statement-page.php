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
$_SESSION['client_name'] = $client_name;
$monthtit =  date('F Y',strtotime($frdt));
$todt=$frdt; 
// echo "client id ".$client_id;
$resesiclient2=$payrollAdmin->getESICodeClient($client_id,$frdt);
    
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

<div>
</div>
 

<?php 
 
$frdt = date('Y-m-d',strtotime($frdt));
$todt = date('Y-m-d',strtotime($todt));



$res = $payrollAdmin->getEsicode($comp_id, $client_id);
// print_r($res);
// echo " <br>*****************";   
$grwages=0;
$grEE=0;
$grER=0;
$grEMP= 0;
$totwages=0;
$totEE=0;
$totER=0;
$totEMP= 0;


if($month!=''){
    $reporttitle="ESI Summary Statement FOR THE MONTH ".$monthtit;
}
$_SESSION['reporttitle']=strtoupper($reporttitle);

?>
<div class="header_bg">
<?php

include('printheader3.php');
?>
</div>
<div class="container">
<?php
// print_r($res);
$name = '';
foreach($res as $esicode1) {
    $totwages=0;
    $totEE=0;
    $totER=0;
    $totEMP= 0;
    //echo $comp_id.'-------'.$frdt.'---------'.$esicode1['esicode'];
    $resesiclient=$payrollAdmin->getESICode1($comp_id,$frdt,$esicode1['esicode']);
    
    $num_rows = sizeof($resesiclient);
    
    
$clname=explode('$',$esicode1['client_name']);
if (count($clname) > 1){
    foreach($clname as $cl){
        $name=$name.$cl.'<br>';
        
    }
    
    
}
    
else{
       $name = $clname[0];
    }
// print_r($clname);
    if ($num_rows > 0) {
        
?>

        <div class="row body">
            <div>
                <?php
                echo "ESI CODE: ".$esicode1['esicode'];
                ?>
            </div>

            <table width='100%'>
                <tr>
                    <th class='thheading' width='5%'>Client NO</th>
                    <th class='thheading' width='25%'>Client Name</th>
                    <th class='thheading' width='10%'>Total Rs.</th>
                    <th class='thheading' width='10%'>Employee</th>
                    <th class='thheading' width='10%'>Employer</th>
                    <th class='thheading' width='15%'>Total</th>
                    <th class='thheading' width='10%'>No. Of Employee</th>
                </tr>
                <?php 
                foreach($resesiclient as $client) { 
                ?>
                    <tr>
                        
                        <td><?php echo $esicode1['client_id1']; ?></td>
                        <td><?php echo $name; ?></td>
                        <td><?php echo $client['std_amt']; ?></td>
                        <td><?php echo $client['amount']; ?></td>
                        <td><?php echo $client['employer']; ?></td>
                        <td><?php echo number_format($client['amount'] + $client['employer'], 2, ".", ","); ?></td>
                        <td><?php echo $client['cnt']; ?></td>
                    </tr>
                <?php 
                    $grwages += $client['std_amt'];
                    $grEE += $client['amount'];
                    $grER += $client['employer'];
                    $grEMP += $client['cnt'];
                    $totwages += $client['std_amt'];
                    $totEE += $client['amount'];
                    $totER += $client['employer'];
                    $totEMP += $client['cnt'];
                } 
                ?>
                <tr>
                    <td></td>
                    <td>Total</td>
                    <td><?php echo number_format($totwages, 2, ".", ","); ?></td>
                    <td><?php echo number_format($totEE, 2, ".", ","); ?></td>
                    <td><?php echo number_format($totER, 2, ".", ","); ?></td>
                    <td><?php echo number_format($totEE + $totER, 2, ".", ","); ?></td>
                    <td><?php echo $totEMP; ?></td>
                </tr>
            </table>
            <br>
        </div>
<?php
    }
}
?>

<!-- Grand Total Section -->
<div class="row body">
    <table width='100%'>
        <tr>
            <th class='thheading' width='5%'>Client NO</th>
            <th class='thheading' width='25%'>Client Name</th>
            <th class='thheading' width='10%'>Total Rs.</th>
            <th class='thheading' width='10%'>Employee</th>
            <th class='thheading' width='10%'>Employer</th>
            <th class='thheading' width='15%'>Total</th>
            <th class='thheading' width='10%'>No. Of Employee</th>
        </tr>
        <tr>
            <td></td>
            <td>Grand Total</td>
            <td><?php echo number_format($grwages, 2, ".", ","); ?></td>
            <td><?php echo number_format($grEE, 2, ".", ","); ?></td>
            <td><?php echo number_format($grER, 2, ".", ","); ?></td>
            <td><?php echo number_format($grEE + $grER, 2, ".", ","); ?></td>
            <td><?php echo $grEMP; ?></td>
        </tr>
    </table>
</div></div>
<br>


<?php


    $totwages=0;
    $totEE=0;
    $totER=0;
    $totEMP= 0;
    
    $num_rows = sizeof($resesiclient2);

    if ($num_rows > 0) {
?>
<div class="container">
        <div class="row body">
            <h4> Client Wise Summary</h4>
            <div>
                <?php
                // echo "ESI CODE: ".$esicode11['esicode'];
                ?>
            </div>

            <table width='100%'>
                <tr>
                    <th class='thheading' width='5%'>Client NO</th>
                    <th class='thheading' width='10%'>ESI COde</th>
                    <th class='thheading' width='30%'>Client Name</th>
                    
                    <th class='thheading' width='10%'>Total Rs.</th>
                    <th class='thheading' width='10%'>Employee</th>
                    <th class='thheading' width='10%'>Employer</th>
                    <th class='thheading' width='10%'>Total</th>
                    <th class='thheading' width='10%'>No. Of Employee</th>
                </tr>
                <?php 
                foreach($resesiclient2 as $client1) { 
                ?>
                    <tr>
                        <td><?php echo $client1['client_id']; ?></td>
                        <td><?php echo $client1['ESI_code']; ?></td>
                        <td><?php echo $client1['client_name']; ?></td>
                        <td><?php echo $client1['sat_amt']; ?></td>
                        <td><?php echo $client1['employee_75']; ?></td>
                        <td><?php echo $client1['employer_25_']; ?></td>
                        <td><?php echo number_format($client1['employee_75'] + $client1['employer_25_'], 2, ".", ","); ?></td>
                        <td><?php echo $client1['empcount']; ?></td>
                    </tr>
                <?php 
                    $grwages += $client1['sat_amt'];
                    $grEE += $client1['employee_75'];
                    $grER += $client1['employer_25_'];
                    $grEMP += $client1['employer_25_'];
                    $totwages += $client1['sat_amt'];
                    $totEE += $client1['employee_75'];
                    $totER += $client1['employer_25_'];
                    $totEMP += $client1['empcount'];
                } 
                ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td>Total</td>
                    <td><?php echo number_format($totwages, 2, ".", ","); ?></td>
                    <td><?php echo number_format($totEE, 2, ".", ","); ?></td>
                    <td><?php echo number_format($totER, 2, ".", ","); ?></td>
                    <td><?php echo number_format($totEE + $totER, 2, ".", ","); ?></td>
                    <td><?php echo $totEMP; ?></td>
                </tr>
            </table>
            <br>
        </div>
<?php
    }

?>




    </div>
    
    
    
    
<!-- content end -->
<script>
    function myFunction() {
        window.print();
    }
</script>
</body>
</html>