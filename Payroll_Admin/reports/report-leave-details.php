<?php
include ('../../include_payroll_admin.php');
error_reporting(E_ALL);
$month=$_SESSION['month'];
$clintid=$_REQUEST['clintid'];
$frdt=date('Y-m-d',strtotime($_REQUEST['from_date']));
$todt=date('Y-m-d',strtotime($_REQUEST['to_date']));



//print_r($_REQUEST);

$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
//$resclt=$payrollAdmin->displayClient($clintid);
//print_r($resclt);

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
                width: 1px;
              white-space: nowrap;
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
            width: 80%;
             margin: auto;

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




<div>
<div >
<?php
//include('printheader3.php');
?>
</div>

    <div class="row body" >
        <h4 style="text-align: center;">
          <?php  echo "LEAVE RECORD FOR THE PERIOD ".date("F y",strtotime($frdt))." TO ".date("F y",strtotime($todt));?>
        </h4>
        <table width="100%">
    <tr>
        <th  align="left"  class="thheading">Sr No</th>
        <th  align="left" class="thheading">Name Of the Employee</th>
        <?php 
        
            $start    = new DateTime($frdt);
            $start->modify('first day of this month');
            $end      = new DateTime($todt);
            $end->modify('first day of next month');
            $interval = DateInterval::createFromDateString('1 month');
            $period   = new DatePeriod($start, $interval, $end);
            foreach ($period as $dt) {
                echo "<th align='left'  class='thheading'>".$dt->format("M y") . "</th>";
            }
        
        
        // $month=$frdt;
        // while(1)
        // {
        //     echo "<th>".date("m-y", strtotime( $month))."</th>";
        //     $month = date("Y-m-d", strtotime("+1 month", $month));
        //     if ($month>$todt){break;}
        // }
        ?>
        <th class="thheading" >Total</th>

    </tr>

<?php
$totalamt=0;
$totalco=0;
$c[]='';
$i=0;
$srno=1;

$res=$payrollAdmin->showEmployeeleave($clintid,$frdt,$todt);
//echo "<pre>";print_r($res);echo "</pre>";


$empidarr=[];

foreach($res as $r)
{
  if (!in_array($r['emp_id'], $empidarr))  
  {
    $empidarr[] = $r['emp_id'];
  }
}
$tcount= sizeof($empidarr);
//$prevemp='';
for ($j = 0; $j <= $tcount; $j++) {
    $totalplamt = 0;

    // Check if $i exists in $empidarr to avoid undefined offset
    if (isset($empidarr[$i])) {
        $empdetail = $payrollAdmin->showEmployeeleavebyempID($clintid, $frdt, $todt, $empidarr[$i]);
// print_r($empdetail);
        ?>
        <tr>
            <td><?php echo $srno; ?></td>
            <td>
                <?php
                $emp = $payrollAdmin->showEployeedetails($empidarr[$i]);
                echo $empidarr[$i] . " - " . $emp["first_name"] . " " . $emp["middle_name"] . " " . $emp["last_name"];
                ?>
            </td>
            <?php 
            foreach ($period as $dt) {
                $found = 0;
                foreach ($empdetail as $row) {
                    if ($dt->format("M y") == date("M y", strtotime($row['sal_month']))) {
                        echo "<td>";
                        echo ($row['PL'] > 0) ? $row['PL'] : " - ";
                        echo "</td>"; 
                        $found = 1;
                        $totalplamt += $row['PL'];
                    }
                }
                if ($found == 0) {
                    echo "<td> - </td>";  
                }
            } ?>
            <td align="center">
                <?php
                echo ($totalplamt) ? $totalplamt : " - ";
                $totalamt += $totalplamt;
                ?>
            </td>
        </tr>
        <?php
    }

    $srno++;
    $i++;
}


$s=array_count_values($c);

?>

            <!--<tr>-->
            <!--    <td width="15%" class="thheading">No. of Employees</td>-->
            <!--    <td  width="5%" class="thheading"><?php echo $tcount; ?> </td>-->
            <!--    <td  width="50%" colspan="2"></td>-->
            <!--    <td  width="10%" align="right" class="thheading">Total</td>-->
            <!--    <td  width="10%" class="thheading" align="center"><?php echo $totalamt; ?> </td>-->
            <!--</tr>-->

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