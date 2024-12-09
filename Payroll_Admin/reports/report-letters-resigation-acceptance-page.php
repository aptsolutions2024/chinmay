<?php
$doc_path=$_SERVER["DOCUMENT_ROOT"];
include ($doc_path.'/include_payroll_admin.php');

$month=$_SESSION['month'];
$clientid=$_SESSION['clientid'];
if(isset($_REQUEST['emp'])){
$emp=$_REQUEST['emp'];
}else{
	$emp=1;
}
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];

$resclt=$payrollAdmin->displayClient($clientid);
$cmonth=$resclt['current_month'];
$comapnydtl = $payrollAdmin->showCompdetailsById($comp_id);

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
            page-break-after: auto;
            z-index: 0;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        table, td, th {
            padding: 2px!important;
			border:0 !important;
            /*border: 1px dotted black!important;*/
            font-size:17px !important;
            font-family: Arial;

        }
		.flr{float:right}
		#appletter{appletter}
		.tjust{text-align:justify}
		.tbtit1{font-weight:900}
		.tbtit2{font-weight:500}
		table.paydtl,.paydtl td{border:1px solid black !important}
		.bggray{
			background:#ccc;
		}
		#format2 table,#format2 td,#format2 th {
            padding: 5px!important;
			border:0 !important;
            /*border: 1px dotted black!important;*/
            font-size:13px !important;
            font-family: Arial;

        }
		footer {page-break-after: auto;}
		.tjust{text-align:justify}
        @media print
        { footer {page-break-after: auto;}
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
			
			footer {page-break-after: always;}
        }
    </style>
</head>
<body>
<div class="btnprnt">
    <button class="submitbtn" onclick="myFunction()">Print</button>
    <button class="submitbtn"  onclick="history.go(-1);" >Cancel</button>
</div>
<!-- content starts -->

<div>
<div class="header_bg">
<?php
//include('printheader.php');
?>
</div>
    <div class="row body" >
	<?php 
	//////////////////////////////// type 1 format //////////////////////////////////
	
	if($emp==1){
	$res1 = $payrollAdmin->showEployeedetailsQ($_REQUEST['employee']);
	}else{
	//$res1 = $payrollAdmin->getEmployeeDetailsByClientIdAppont($clientid);	
	}
	foreach($res1 as $row1)
	{
	?>
	<div class="page-bk">
    <table width="100%" id="appletter">
	<thead>
	<tr>
	
	<td align="right"   style="text-align:left;font-weight:bold;">
	<div style="width:45%; float:right">
<?php echo $comapnydtl['comp_name'];?><br>
	<?php echo $comapnydtl['address'];?>,<?php echo $comapnydtl['addr_1'];?><br>Tel. :<?php echo $comapnydtl['tel'];?><br>E-mail:<?php echo $comapnydtl['email'];?>
	<br><br>
	<?php 	
	echo date('d/m/Y', strtotime('-4 day', strtotime($row1['leftdate'])))?>
	<br><br><br><br><br><br><br>
	</div>
	</td></tr></thead>
    <tr>
	<td class="flr" colspan="2">
	
	</td>
	
	</tr>
	<tr><td >To,</td></tr>
	<tr><td ><?php echo ucwords(strtolower($row1['first_name']. " ".$row1['middle_name']. " ".$row1['last_name']));?></td></tr>
	<tr><td> <?php echo ucwords(strtolower (nl2br($row1['emp_add1'])));?> <br><?php echo ucwords(strtoupper($row1['pin_code']));?></td></tr>
	<tr><td >&nbsp;</td></tr>
	<tr><td> SUB : - ACCEPTANCE OF YOUR RESIGNATION </td></tr>
	<tr><td >&nbsp;</td></tr>
	<tr>
	<td colspan="2">Dear Sir,                
	</td>
	</tr>
	<tr><td colspan="2" class="tjust">
	With reference to your letter of resignation, this is to inform you that your resignation has been accepted with effect from the <?php 	
	//echo $row1['leftdate']; //date('dS F Y', strtotime('Y-m-d',$res1['leftdate']))?><?php 	
	echo date('dS F Y', strtotime('+1 day', strtotime($row1['leftdate'])))?>.  Your last working day shall be the  <?php 	
	echo  date('dS F Y',  strtotime($row1['leftdate']))?>.<br><br>
	</td>
	</tr>
	
	<tr><td colspan="2"class="tjust">
	Kindly arrange to collect your dues, if any, from our office on any working day.  <br><br>
	</td>
	</tr>
	<tr><td colspan="2">
	We wish you all the best for the future.  <br><br>
	</td>
	</tr>
	<tr><td colspan="2">
	Yours faithfully,
	</td>
	</tr>
	<tr><td colspan="2">For 
	<?php echo $comapnydtl['comp_name'];?> 
	</td>
	</tr>
	<tr><td colspan="2">
	&nbsp;  
	</td>
	</tr>
	<tr><td colspan="2">
	&nbsp; 
	</td>
	</tr>
	
	<tr><td colspan="2">
	AUTHORISED SIGNATORY<br>  
	</td>
	</tr>
	

	<tr><td>&nbsp;</td></tr>
	<tr><td>&nbsp;</td></tr>
	
	
</table></div>
	<?php } ?>
 </div>
    </div>
<!-- content end -->

<script>
    function myFunction() {
        window.print();
    }
	
</script>


</body>
</html>