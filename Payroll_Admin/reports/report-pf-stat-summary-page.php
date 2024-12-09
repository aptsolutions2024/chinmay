<?php
$doc_path=$_SERVER["DOCUMENT_ROOT"];
include ($doc_path.'/include_payroll_admin.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(0);

// print_r($_SESSION);
$month=$_SESSION['month'];
$clientid=$_SESSION['clintid'];
 $emp=$_REQUEST['emp'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];




$clientGrp=$_SESSION['clientGrp'];
$frdt=$_SESSION['frdt'];

$group[]='';
$resclt='';
if ($clientGrp!='')
{   $group=$payrollAdmin->displayClientGroupById($clientGrp);
    $grpClientIds=$payrollAdmin->getGroupClientIds($clientGrp)  ;
    // print_r($grpClientIds);
    $grpClientIdsOnly=$payrollAdmin->getGroupClientIdsOnly($clientGrp);
    $resclt=$payrollAdmin->displayClient($grpClientIds[0]['mast_client_id']);
    $setExcelName = "Paysheet_Group".$clientGrp;
   $clientid =$grpClientIdsOnly['client_id'];
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

$monthtit =  date('F Y',strtotime($frdt));
$todt=$frdt;
// echo "#$$$$$$$$$$$".$frdt;

$reporttitle="P.F. Summary Statement FOR THE MONTH ".$monthtit;

$_SESSION['client_name']=$client_name;
$_SESSION['reporttitle']=strtoupper($reporttitle);
$res14 =$payrollAdmin->getCharges($frdt);
// echo $clientid."^^^^^^";
			$res12 =$payrollAdmin->getPFSummary($res14['acno2'],$clientid,$comp_id,$frdt);
			$tcount= sizeof($res12);

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


    <div class="row body" >







        <table width="100%">



    <tr>
        <th align="center" width="7%" class="thheading" >Client No </th>
        <th align="left" colspan="10" class="thheading">Name Of the Client </th>
    <!--/tr>
        <tr-->
        <th width="7%" align="center" class="thheading">PF-Wages   </th>
        <th width="7%" align="center"  class="thheading">P.F  <br />
            <?php echo number_format($res14['acno1_employee'],2,".",","); ?> % <br />
            (1)</th>

        <th align="center" width="7%" class="thheading">P.F  <br />
            <?php echo number_format($res14['acno1_employer'],2,".",",");?> % <br />

            (1)</th>
        <!--th align="center" width="7%" class="thheading">P.F Total  <br />
             <?php echo number_format($res14['acno1_employer']+$res14['acno1_employee'],2,".",",");?>% <br />

            (Ac.No.1)</th-->
			
        <th align="center" width="7%" class="thheading">Pension  <br />
        <?php echo number_format($res14['acno10'],2,".",",");?>% <br />
            (Ac.No.10)</th>
        <th align="center" width="7%" class="thheading">Total.
            <br />  <?php echo number_format($res14['acno1_employer']+$res14['acno1_employee']+$res14['acno10'],2,".",",");?>% <br />
            (I+X)</th>
        <th align="center" width="7%" class="thheading">ADM Cha
            <br />  0.50% <br />
               (Ac.No.2)</th>
        <th align="center" width="7%" class="thheading">Link Insur.
            <br />  0.5% <br />
               (Ac.No.21)</th>
        <th align="center" width="7%" class="thheading">ADM Chr Ins
            <br />  0.00% <br />
               (Ac.No.22)</th>
        <th align="center" width="7%" class="thheading">Total
            <br />Payble</th>
        <th align="center" width="7%" class="thheading">Cov
            <br />Emp</th>
        <th align="center" width="7%" class="thheading">NonCov
            <br />Emp</th>


    </tr>

<?php
$totalamt=0;
$totalco1=0;
$ttotalco1=0;


$ttotalco2=0;
$totalpf1=0;
$totalpf2=0;
$totpf2=0;
$totalpf3=0;
$totalpf4=0;
$totalpf5=0;
$totalpf6=0;
$totalpf7=0;
$totalco2 =0;
$totalstdam=0;

$c[]='';
$i=0;
foreach($res12 as $row) {
    $total1=0;
	$totemp1=$payrollAdmin->getPFSummary1($row['client_id'],$comp_id,$frdt);
    $totemp=$row['totemp'];
    
    
    $totpfemp1=$payrollAdmin->getPFSummary2($row['client_id'],$comp_id,$frdt);
    $totpfemp=$totpfemp1['totpfemp'];

    ?>
    <tr>
        <td align="center">
            <?php
            
            $rowclient=$payrollAdmin->displayClient($row["client_id"]);
            echo $rowclient['short_name'];
      ?>
        </td>

        <td colspan="10">
            <?php
			/*if ($emp = "Parent")
			{ echo $_SESSION['client_name'];}
		    else{*/
            echo $row["client_name"];
       ?>
        </td>
    <!--/tr>
    <tr-->
        <td align="center">
            <?php
            echo $row['std_amt'];
            $totalstdam=$totalstdam+$row['std_amt'];
            ?>
        </td>

        <td align="center">
            <?php


            echo $pf1=$row['amount'];
            $totalpf1=$totalpf1+$pf1;
            ?>
        </td>
        <td align="center">
            <?php
            echo $pf2=$row['employer_contri_1'];
            $totalpf2=$totalpf2+$pf2;
            ?>
        </td>
		
		<!--td align="center">
            <?php
            echo $totpf2=$row['employer_contri_1']+$row['amount'];
            $totpf2=$totalpf2+$pf2+$row['amount'];
            ?>
        </td-->
		
        <td align="center">
            <?php
             echo $pf3=$row['employer_contri_2'];
            $totalpf3=$totalpf3+$pf3;
            ?>
        </td>
        <td align="center">
            <?php
            echo $pf4=$pf3+$pf2+$pf1;
            $totalpf4=$totalpf4+$pf4;
            ?>
        </td>

        <td align="center">
            <?php
            echo $pf5=round($row['acno2'],0);
            $totalpf5=$totalpf5+$pf5;
            ?>
        </td>
        <td align="center">
            <?php
            echo $pf6=round($row['acno2'],0);
            $totalpf6=$totalpf6+$pf6;
            ?>
        </td>
        <td align="center">
            <?php
            echo $pf7=round($pf4*0.0001/100,0);
            $totalpf7=$totalpf7+$pf7;
            ?>
        </td>
       <td align="center">
            <?php
            echo $pf4+$pf5+$pf6+$pf7;
            $totalco2=$totalco2+$pf4+$pf5+$pf6+$pf7;
            ?>
        </td>

            <td align="center">
            <?php
            echo $totpfemp;
            $ttotalco1=$ttotalco1+$totpfemp;
            ?>
        </td>
  <td align="center">
            <?php
            echo $totemp-$totpfemp;
            $ttotalco2=$ttotalco2+$totemp-$totpfemp;
            ?>
        </td>


    </tr>
            <?php
    $i++;

}


$s=array_count_values($c);

?>
<tr>
<td>TOTAL </td>
<!--/tr>

            <tr-->
            <td colspan="10"></td>
                <td align="center" class="thheading">
                    <?php
                    echo $totalstdam;

                    ?>
                </td>

                <td align="center" class="thheading">
                    <?php


                    echo $totalpf1;

                    ?>
                </td>
                <td align="center" class="thheading">
                    <?php
                    echo $totalpf2;
                    ?>
                </td>
                <!--td align="center" class="thheading">
                    <?php
                    echo $totalpf2+$totalpf1;
                    ?>
                </td-->
                <td align="center" class="thheading">
                    <?php
                    echo $totalpf3;
                    ?>
                </td>
                <td align="center" class="thheading">
                    <?php
                    echo $totalpf2+$totalpf1+$totalpf3;
                    ?>
                </td>

                <td align="center" class="thheading">
                    <?php
                    echo $totalpf5;
                    ?>
                </td>
                <td align="center" class="thheading">
                    <?php
                    echo $totalpf6;
                    ?>
                </td>
                <td align="center" class="thheading">
                    <?php
                    echo $totalpf7;
                    ?>
                </td>
                <td align="center" class="thheading">
                    <?php
                    echo $totalco2;
                    ?>
                </td>

                <td align="center" class="thheading">
                    <?php
                    echo $ttotalco1;
                    ?>
                </td>
                <td align="center" class="thheading">
                    <?php
                    echo $ttotalco2;
                    ?>
                </td>


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