<?php
include ('../../include_payroll_admin.php');

$month=$_SESSION['month'];
$clientid=$_SESSION['clientid'];
if(isset($_REQUEST['emp'])){
$emp=$_REQUEST['emp'];
}else{
	$emp=1;
}
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];

$compdetails = $payrollAdmin->showCompdetailsById($comp_id);

$resclt=$payrollAdmin->displayClient($clientid);
$cmonth=$resclt['current_month'];

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
            font-size:17px !important;
            font-family: Arial;

        }
		#npadd td{
			padding:0 !important
		}
		footer {page-break-after: always;}
		.tjust{text-align:justify}
		.inc:last-child{padding-bottom:10px}
        @media print
        { footer {page-break-after: always;}
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
	<?php if($_REQUEST['type'] =="1"){ 
	//////////////////////////////// type 1 format //////////////////////////////////
	
	if($emp==1){
	$res1 = $payrollAdmin->showEployeedetailsQ($_REQUEST['employee']);
	}else{
	$res1 = $payrollAdmin->getEmployeeDetailsByClientIdAppont($clientid);	
	}
	foreach($res1 as $row1)
	{
		
	?>
	<div class="page-bk">
    <table width="100%" id="appletter">
	<thead>
	<tr>
	
	<td align="right"   style="text-align:left;;font-weight:bold">
	<div style="width:45%; float:right; ">	
	<?php echo $compdetails['comp_name'];?><br>	
	1117/5A, Off Ganeshkhind Road,<br>Pune 411 016<br>Tel. :25660360 / 25652095 Fax:25656144<br>E-mail:shaconpvt@gmail.com
	<br><br>	<br><br>	<br><br>
	<?php 	
	 echo date('d/m/Y');
	//echo date('dS F Y', strtotime(date()))
	?>
	</div>
	</td></tr></thead>
    <tr>
	<td class="flr" colspan="2">
	</td>
	
	</tr>
	<tr><td style="text-align:center">TO WHOM IT MAY CONCERN</td></tr>
	<tr><td class="tjust">This is to certify that <?php if($row1['gender']=='M'){echo "Mr.";}else{echo "Ms/Mrs";}?> <?php echo ucfirst(strtolower($row1['first_name'])). " ".ucfirst(strtolower($row1['middle_name'])). " ".ucfirst(strtolower($row1['last_name']));?>  deployed by us as 
	
	<?php  $desg = $payrollAdmin-> displayDesignation($row1['desg_id']); if ( $desg['mast_desg_name']!='N.A.'){ echo $desg['mast_desg_name'];}?> in a <?php echo $resclt['client_name'];?> from <?php 	
	
	
	if($row1['joindate'] !=""){echo date('d/m/Y', strtotime($row1['joindate'])); }?> to <?php 
	if($row1['leftdate'] !=""){echo date('d/m/Y', strtotime($row1['leftdate']));}else {echo "NA";}?> (both days inclusive).  </td></tr>
	
	<tr>
	<td colspan="2" class="tjust"><?php if($row1['gender']=='M'){echo "He";}else{echo "She";}?> was deployed in the accounting assistance services department of the said company, and his/her last drawn monthly salary was as follows:                
	</td>
	</tr>
	<tr><td width="50%">
	<table width="100%" id="npadd" style="width:50%">
	<?php $emid =$row1['emp_id']; 
		$emptot =0;
		$res2 = $payrollAdmin->getEmployeeIncome($emid);
		foreach($res2 as $result2)
		{
			if(strtolower($result2['income_heads_name'])!="night sft." && strtolower($result2['income_heads_name'])!="overtime" && $result2['income_heads_name']!= "LEAVE ENCASHMENT" && $result2['std_amt'] > 0 ){
		?>
		<tr>
		<td><?php echo $result2['income_heads_name'];?> :</td><td>
	
		<span id="inc<?php $emid;?>" style="float:right"><?php echo $result2['std_amt'];?></span></td>
		</tr>
		<?php $emptot += $result2['std_amt']; }} ?>			
		
		<tr><td></td><td style="float:right">--------------------</td></tr>
		<tr>
		<td>Total</td>
		<td style="float:right"><?php echo number_format($emptot,2);?></td>
		</tr>
		<tr><td></td><td style="float:right">--------------------</td></tr>
		<tr><td colspan="2">&nbsp;</td></tr>
	<tr><td height="30" colspan="2">P.F.   No. : <?php echo $resclt['pfcode']." / ".$row1['pfno'];?></td></tr>
	<tr><td height="30" colspan="2">ESI   No.  : <?php if($row1['esistatus']=='N'){echo "NOT APPLICABLE";}else{echo $row1['esino'];}?></td></tr>
	<tr><td height="30" colspan="2">UAN No.  : <?php echo $row1['uan']."<br><br><br>";?></td></tr>
		
	<tr><td colspan="2"><?php if($row1['gender']=='M'){echo "His";}else{echo "Her";}?> work was excellent.</td></tr>
	
	</table>
	</td>
	
	</tr>
	<tr><td colspan="2" class="tjust">We wish <?php if($row1['gender']=='M'){echo "him";}else{echo "her";}?> all the best for the future.<br><br><br></td></tr>
	


	
	<tr><td colspan="2">					For <?php echo $compdetails['comp_name'];?>. <br>                
					</td>
				</tr>
				<tr><td></td></tr>
				<tr><td></td></tr>
		<tr><td colspan="2">&nbsp;</td></tr>
			
				<tr><td colspan = 2>Authorised Signatory</td></tr>
	
	<tr><td>&nbsp;</td></tr>
	<tr><td>&nbsp;</td></tr>
	
	
</table></div>
	<?php }} else{
		//////////////////////////////// type 2 format //////////////////////////////////
		
	if($emp==1){
	$res1 = $payrollAdmin->showEployeedetailsQ($_REQUEST['employee']);
	/*}else{
	//$res1 = $payrollAdmin->getEmployeeDetailsByClientId($clientid);	
	}*/
	foreach($res1 as $row1)
	{
	?>
		<div id="format2" class="page-bk">
		<table width="100%" id="appletter">
		<thead>
	<tr>
	<td width="40%"></td>
	<td align="right"   style="text-align:left;font-weight:bold" width="60%">
	<div style=" float:right">	
	<?php echo $compdetails['comp_name'];?><br>	
	1117/5A, Off Ganeshkhind Road,<br>Pune 411 016<br>Tel. :25660360 / 25652095 Fax:25656144<br>E-mail:shaconpvt@gmail.com
		<br><br>	<br><br>	<br><br>
	</div>
	</td></tr></thead>
		
    <tr>
	<td class="flr" colspan="2">
	<?php 	
	//echo date('dS F Y', strtotime($row1['joindate']))?>
	
	
	</td>
	
	</tr>
	<?php  if ($clintid == 12 || $clintid == 13 || $clintid == 14 || $clintid == 15 || $clintid == 16)
{
    echo '  <tr><td style="text-align:center" colspan="2"><br><br>TRAINING CERTIFICATE</td></tr>';
}
else
{
        echo '  <tr><td style="text-align:center" colspan="2"><br><br>CERTIFICATE</td></tr>';
}?>
	<tr><td style="text-align:center" colspan="2">======================</td></tr>
	<tr><td>Name</td> <td>: <?php echo $row1['first_name']." ".$row1['middle_name']." ".$row1['last_name'];?></td></tr>
	
	<tr>
	<td > Employee No.               
	</td><td>: <?php echo $num_padded = sprintf("%04d", $row1['emp_id']); ?></td>
	</tr>
	<tr>
	<?php  if ($clintid == 12 || $clintid == 13 || $clintid == 14 || $clintid == 15 || $clintid == 16)
    { 
        echo "<td > Date of commencement of training";
    }
    else
    {
        echo "<td > Date of commencement of service";
        
    }
    ?>
	</td><td>: <?php 	
	echo date('d/m/Y', strtotime($row1['joindate']))?></td>
	</tr>
	<tr>
	<td > Date of Resignation                
	</td><td>: <?php 	
	 if($row1['leftdate'] !=""){echo date('d/m/Y', strtotime($row1['leftdate']));}?></td>
	</tr>
	<tr>
	<td > Place of Deputation                
	</td>
	<td>: 
	<?php echo ucwords(strtolower($resclt['client_name']));?><br>
	<div style="padding-left:10px"><?php 	
	$client = $payrollAdmin->displayClient($clientid);
	echo ucwords(strtolower($client['client_add1']));
	
	?></div></td>
	</tr>
	
	<?php $dept = $payrollAdmin->displayDepartment($row1['dept_id']); if ( $dept['mast_dept_name']!='N.A.'){?>
	
	
	<tr>
	<td > Department                
	</td><td>: 
	<?php //$dept = $payrollAdmin->displayDepartment($row1['dept_id']);

if ($clientid == 12 || $clientid == 13 || $clientid == 14 || $clientid == 15 || $clientid == 16)
						{	
							$dept1= substr($dept['mast_dept_name'],7, strpos(substr($dept['mast_dept_name'],7), "/"));

								//$dept1= substr($dept['mast_dept_name'],7);

						}
						else{
						$dept1= $dept['mast_dept_name'];
						}
				
	echo $dept1;
	?></td>
	</tr>
	
	
	<?php }?>
	
	
	<tr>
	<td>&nbsp;</td>
	</tr>
	<tr>
	<td colspan="2">
	<table style="width:100%" id="npadd">
	<?php $emid =$row1['emp_id']; 
		$emptot =0;
		$inc=1;
		$res2 = $payrollAdmin->getEmployeeIncome($emid);
		foreach($res2 as $result2)
		{
			if(strtolower($result2['income_heads_name'])!="night sft." && strtolower($result2['income_heads_name'])!="overtime" && $result2['income_heads_name']!= "LEAVE ENCASHMENT" && $result2['std_amt'] > 0 ){
		?>
	<tr class="inc<?php echo $inc;?>">
	<td width="40%"><?php echo $result2['income_heads_name'];?></td>
	<td width="30%">: Rs. <span style="float:right; text-align:right"><?php echo number_format($result2['std_amt'],2);?> per month</span></td>
	<td></td>
	</tr>
		<?php $emptot += $result2['std_amt']; $inc++;}} ?>
	<tr><td></td><td height="0" >
	<div style="border-top:1px dashed #000 !important; margin-top:5px; padding-top:5px;"></div>
	</td></tr>
	<tr><td >GROSS SALARY</td><td >: Rs. <span style="float:right; text-align:right"><?php echo number_format($emptot,2);?> per month</span></td></tr>
	<tr><td></td><td height="0" >
	<div style="border-top:1px dotted #000 !important; margin-top:5px; padding-top:5px;"></div>
	</td></tr>
	<tr><td height="30">P.F. No.</td><td>: <?php echo $resclt['pfcode']." / ".$row1['pfno'];?></td></tr>
	<tr><td height="30" >ESI No.</td><td>: <?php if($row1['esistatus']=='N'){echo "NOT APPLICABLE";}else{echo $row1['esino'];}?></td></tr>
	<tr><td height="30">UAN No.</td><td>: <?php echo $row1['uan'];?></td></tr>
	</table>
	</td>
	</tr>
	
		
	
	
	<tr><td colspan="2">FOR <?php echo $compdetails['comp_name'];?></td></tr>
	<tr><td>&nbsp;</td></tr>
	<tr><td colspan="2">AUTHORISED SIGNATORY</td></tr>
	<tr><td>&nbsp;</td></tr>
	<tr><td colspan="2">Place : Pune</td></tr>
	<tr><td colspan="2">Date &nbsp; <?php echo date('d/m/Y');?></td></tr>
	<tr><td>&nbsp;</td></tr>
	
</table>
		</div>
	<?php } } }?>
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