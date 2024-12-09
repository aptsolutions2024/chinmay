<?php
session_start();
include ('../../include_payroll_admin.php');
error_reporting(0);
$month=$_SESSION['month'];
$clientid=$_SESSION['clientid'];
 $emp=$_REQUEST['emp'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
// print_r($_SESSION);
//$res=$payrollAdmin->showEmployeereport($comp_id,$user_id);
// echo "!!!!!!!!!!!!";
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
    // $setExcelName = "Paysheet_Group".$clientGrp;
    $client_id =$grpClientIdsOnly['client_id'];
    
    // print_r($group);echo "@@@@@@@@@@@@@@@";
    // print_r($client_id);echo "!!!!!!!!!!!!!!!!!<br><br>";
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
    // echo $client_id;
    $resclt=$payrollAdmin->displayClient($client_id);
    // $setExcelName = "Paysheet_".$clientid;
    // echo "11111";
    // print_r($resclt);
    

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
// echo $frdt;

// $cmonth=$resclt['current_month'];



// if($month=='current'){
//     $monthtit =  date('F Y',strtotime($cmonth));
//     $tab_emp='tran_employee';
//     $tab_empded='tran_deduct';
//     $frdt=$cmonth;
//     $todt=$cmonth;
//  }
// else{

//     $tab_emp='hist_employee';
//     $tab_empded='hist_deduct';
// print_r($_SESSION);
//     $frdt=date("Y-m-d", strtotime($_SESSION['frdt']));
//     $todt= $frdt;
//     echo "from date:".$frdt;
//         echo "from date:".$todt;

    
//  }


// echo "!!!!!!!!!!!!!!!!";

// echo $frdt."&&&&&&&&&&&&&&&&".$todt."<br><br>";
$res12=$payrollAdmin->professionTax($client_id,$comp_id,$frdt,$todt);
// print_r($res12);echo"%%%%%%%%%%%%%%%";
$tcount= sizeof($res12);



if($month!=''){
    $reporttitle="Profession Tax FOR THE MONTH ".$monthtit;
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
    <button class="submitbtn"  onclick="history.go(-1);" cancelAndSave() >Cancel</button>
</div>
<!-- header starts -->


<!-- header end -->

<!-- content starts -->




<div class="container">
    <div>
        <?php include('printheader3.php'); ?>
    </div>

    <div class="row body">
        <table width="100%">
            <tr>
                <th align="left" width="5%" class="thheading">Sr No</th>
                <th align="left" colspan="4" width="75%" class="thheading">Name Of the Employee</th>
                <th width="10%" class="thheading">Amount</th>
            </tr>

            <?php
            $totalamt = 0;
            $totalco = 0;
            $c[] = '';
            $i = 0;
            $sr_no = 1; // Initialize Sr No
            foreach ($res12 as $row) {
                ?>
                <tr>
                    <td align="center"><?php echo $sr_no++; // Display and increment Sr No ?></td>
                    <td colspan="4">
                        <?php
                        $emp = $payrollAdmin->showEployeedetails($row['emp_id']);
                        echo $row["first_name"] . " " . $row["middle_name"] . " " . $row["last_name"];
                        ?>
                    </td>
                    <td align="center">
                        <?php
                        echo $row['amount'];
                        $totalamt = $totalamt + $row['amount'];
                        $c[$i] = $row['amount'];
                        ?>
                    </td>
                </tr>
                <?php
                $i++;
            }

            $s = array_count_values($c);
            ?>

            <tr>
                <td width="5%" class="thheading"></td>
                <td width="15%" class="thheading">No. of Employees</td>
                <td width="5%" class="thheading"><?php echo $tcount; ?></td>
                <td width="50%" colspan="1"></td>
                <td width="10%" align="right" class="thheading">Total</td>
                <td width="10%" class="thheading" align="center"><?php echo $totalamt; ?></td>
            </tr>
        </table>

        <table width="100%">
            <tr>
                <?php
                if (is_array($s)) {
                    foreach ($s as $k => $value) {
                        echo "<td width='10%' class='thheading'>Rate Rs.</td><td width='10%' class='thheading'>" . $k . "</td>";
                        echo "<td width='10%' class='thheading'>No. of Emp.</td><td width='10%' class='thheading'>" . $s[$k] . "</td>";
                    }
                }
                ?>
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