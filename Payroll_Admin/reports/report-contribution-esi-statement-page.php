<?php

include ('../../include_payroll_admin.php');
error_reporting(E_ALL);
$month=$_SESSION['month'];
$clientid=$_SESSION['clientid'];
// $emp=$_REQUEST['emp'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];

//$res=$payrollAdmin->showEmployeereport($comp_id,$user_id);

$resclt=$payrollAdmin->displayClient($clientid);
$mon = $_REQUEST['mon'];
 $frdt = $_REQUEST['frdt'];
 $todt = $_REQUEST['todt'];
if($mon =='current'){
 $cmonth=$resclt['current_month'];
 $frdt =$resclt['current_month'];
 
 $tab_days='tran_days';
    $tab_emp='tran_employee';   
    $tab_empded='tran_deduct';	
}else{
    $monthtit =  date('F Y',strtotime($frdt));
    $tab_emp='hist_employee';
    $tab_empded='hist_deduct';
 }
 echo $todt;
$frdt = date('Y-m-d',strtotime($frdt));
$todt = date('Y-m-t',strtotime($frdt));
 $res=$payrollAdmin->getWithoutESI1($comp_id,$frdt,$todt,$clientid);
	$res_tot=$payrollAdmin->getWithoutESI2($comp_id,$frdt,$todt,$clientid);
	

if($_REQUEST['todt']!=''){
    $reporttitle="ESI Contribution Statement FOR THE period  ".date('d/m/Y',strtotime($frdt))." To ".date('d/m/Y',strtotime($todt));
}else{
	$reporttitle="ESI Contribution Statement FOR THE period  ".date('F Y',strtotime($frdt));
}
 
$_SESSION['client_name']=$resclt['client_name'];
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
<body class="container">
<div class="btnprnt">
    <button class="submitbtn" onclick="myFunction()">Print</button>
    <button class="submitbtn"  onclick="history.go(-1);" >Cancel</button>
</div>


<div class="header_bg">
<?php
include('printheader3.php');
?>
</div>
 
    <div class="row" >

<table width='100%'>

 <tr>	<th class='thheading' width='7%'>Sr. No.</th>
        <th class='thheading' >ESI NO</th>
        <th class='thheading' >Name </th>
        <th class='thheading' >No. Of Days For Which Wages Paid</th>
        <th class='thheading' >Total Amount Of Wages Paid</th>
        <th class='thheading' >Employee's Contri. Deducted</th>
		<th class='thheading' >Daily Wages</th>
        <th class='thheading' width="20%">Whether Still Working & Drawing Wages Within Insurable Wage Ceiling</th>
		 <th class='thheading' >Remark</th>
    </tr>

<?php 
	$sr=1;
	foreach($res as $rows){ 
  ?>
 <tr><td><?php echo $sr;?></td>
        <td ><?php echo $rows['esino'];?> </td>
        <td ><?php echo $rows['first_name']." ".$rows['middle_name']." ".$rows['last_name'];?>  </td>
        <td ><?php echo $rows['payabledays'];?>  </td>
        <td > <?php echo $rows['wages'];?></td>
        <td ><?php echo $rows['employee_contri'];?> </td>
		<td ><?php echo $rows['daiily_wages'];?> </td>
		<td ><?php  
		$frdt1 = date('ymd',strtotime($frdt));
		$todt1 = date('ymd',strtotime($todt));
		if(date('ymd',strtotime($rows['joindate'])) >= $frdt1 && date('ymd',strtotime($rows['joindate'])) <= $todt1){ echo "A ".date('Y-m-d',strtotime($rows['joindate'])) ;}
		if(date('ymd',strtotime($rows['leftdate'])) >= $frdt1 && date('ymd',strtotime($rows['leftdate'])) <= $todt1){
			echo " L ".date('Y-m-d',strtotime($rows['leftdate']));
		} 
		if(date('ymd',strtotime($rows['joindate'])) <= $frdt1 && date('ymd',strtotime($rows['leftdate'])) >= $todt1){
			echo "YES";
		}
		
		//echo "(j:".$rows['joindate']; echo "L:".date('Y-m-d',strtotime($rows['leftdate'])).")";?> </td>
		<td >NR </td>
    </tr>
<?php $sr++;} 

$rows = $res_tot;?>
		<td > </td>
        <td > </td>
        <td >Total </td>
        <td ><?php echo $rows['payabledays'];?>  </td>
        <td > <?php echo $rows['wages'];?></td>
        <td ><?php echo $rows['employee_contri'];?> </td>
		<td ><?php echo $rows['daiily_wages'];?> </td>
		

</table>

        </div>
<br/><br/>
    
<!-- content end -->
<script>
    function myFunction() {
        window.print();
    }
</script>
</body>
</html>