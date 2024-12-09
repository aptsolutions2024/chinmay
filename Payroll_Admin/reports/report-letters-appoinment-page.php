<?php
session_start();
// print_r($_REQUEST);
error_reporting(0);
$month=$_SESSION['month'];
$clientid=$_SESSION['clientid'];
$emp=$_REQUEST['emp'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];

// print_r($_SESSION);
$doc_path=$_SERVER["DOCUMENT_ROOT"];
include ($doc_path.'/include_payroll_admin.php');

$compdetails = $payrollAdmin->showCompdetailsById($comp_id);

$res=$payrollAdmin->showEmployeereport($comp_id,$user_id);

$resclt=$payrollAdmin->displayClient($clientid);


$cmonth=$resclt['current_month'];

?>

<!DOCTYPE html>

<html lang="en-US">

<head>

	<meta charset="utf-8" />
	<title> &nbsp;</title>
	<!-- Included CSS Files -->
	<link rel="stylesheet" href="../css/responsive.css">
	<link rel="stylesheet" href="../css/style.css">
	<style>
		.header {
			overflow: hidden;
			background-color: #f1f1f1;
			padding: 30px 10px;
		}

		.thheading {
			text-transform: uppercase;
			font-weight: bold;
			background-color: #fff;
		}

		.heading {
			margin: 10px 20px;
		}

		.btnprnt {
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

		table,
		td,
		th {
			padding: 14px !important;
			border: 0 !important;
			/*border: 1px dotted black!important;
            font-size:30px !important;*/
			font-family: Arial;

		}

		#format1 table,
		#format1 td,
		#format1 th,
		#format1 li,
		#format1 div {
			font-size: 16px !important;
		}

		#format1 div {
			font-size: 16px !important;
			line-height: 23px
		}

		#format2 table,
		#format2 td,
		#format2 th {
			font-size: 16px !important;
		}

		#form3 table,
		#form3 td,
		#form3 th {
			font-size: 16px !important;
		}

		#format1 ol,
		#format1 li {
			margin-left: 15px;
			text-align: justify
		}

		< !--.flr {
			float: right
		}

		-->#appletter {
			appletter
		}

		.tjust {
			text-align: justify
		}

		.tbtit1 {
			font-weight: 900
		}

		.tbtit2 {
			font-weight: 500
		}

		table.paydtl,
		.paydtl td {
			border: 1px solid black !important
		}

		.bggray {
			background: #ccc;
		}

		#format2 table,
		#format2 td,
		#format2 th {
			padding: 3px !important;
			border: 0 !important;
			/*border: 1px dotted black!important;*/

			font-family: Arial;

		}

		footer {
			page-break-after: auto;
		}

		.padd20 {
			padding-left: 20px !important
		}

		@media print {


			footer {
				page-break-after: auto;
			}

			.btnprnt {
				display: none
			}

			.header_bg {
				background-color: #7D1A15;
				border-radius: 0px;
			}

			.heade {
				color: #fff !important;
			}

			#header,
			#footer {
				display: none !important;
			}

			#footer {
				display: none !important;
			}

			.body {
				padding: 10px;
			}

			body {
				margin-left: 50px;
			}

			@page {
				margin: 20px;
				padding: 0
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

			#header,
			#footer {

				display: none !important;

			}

			#footer {
				display: none !important;
			}

			footer {
				page-break-after: always;
			}
		}
	</style>

<body>
	<div class="btnprnt">
		<button class="submitbtn" onclick="myFunction()">Print</button>
		<button class="submitbtn" onclick="history.go(-1);">Cancel</button>
	</div>
	<!-- content starts -->


	<div>
		<?php
			
//include('printheader.php');
		?>
	</div>
	<div class="row body">

		<?php if($_REQUEST['typeapp'] =="1"){
		//////////////////////////////// type 1 format //////////////////////////////////
		
	if($_REQUEST['emp']==1){
	$res1 = $payrollAdmin->showEployeedetailsQ($_REQUEST['employee']);
	
	}else{
	$res1 = $payrollAdmin->getEmployeeDetailsByClientIdAppont($clientid,$cmonth);	
	}
	
// 	print_r($_REQUEST);
//	while($row1 = mysql_fetch_array($res1)){
foreach($res1 as $key1=>$row1){
	    //echo "<pre>";print_r($row1);echo "</pre>";
	?>

		<div id="format2" class="page-bk">
			<table width="100%">
				<tr>

					<td align="right" style="text-align:left">
						<div style="width:45%; float:right">
							<?php echo $resclt['client_name'];?><br>
							<?php echo $resclt['client_add1'];?>,
						    <br>E-mail:
							<?php echo $resclt['email'];?>
							<br>
							<?php 
													
							echo date('d/m/Y', strtotime('-7 day', strtotime($row1['joindate'])));?>
						</div>
					</td>
				</tr>
				<tr>
					<td>Ref.No :
						<?php echo $row1['emp_id'];?> <span style="float:right">
							<?php 	
						?>
						</span>
					</td>
				</tr>
				<tr>
					<td>To,</td>
				</tr>
				<tr>
					<td>
						<?php echo ucfirst(strtolower($row1['first_name'])). " ".ucfirst(strtolower($row1['middle_name'])). " ".ucfirst(strtolower($row1['last_name']));?>
						<br>
						<table style="width:50%">
							<tr>
								<td>
									<?php echo nl2br(ucwords(strtolower(rtrim($row1['emp_add1']))))." ".trim($row1['pin_code']);?>
								</td>
							</tr>
						</table>
					</td>
					<td></td>
				</tr>
				<tr>
					<td>Sub :- Appointment Letter
						<?php if ( $row1['desg_id']!= '1') {echo 'as a '. ucfirst(strtolower($row1['mast_desg_name']));}else {echo " ";} ?>
					</td>
				</tr>
				<tr>
					<td class="tjust"><br>Dear
						<?php if($row1['gender']=='M'){echo "Mr. ";}else{echo "Ms/Mrs.  ";} echo ucfirst( strtolower( $row1['first_name']));?>
						,<br>
						With reference to your application, and the subsequent interview, we are pleased to inform you
						that, you have been appointed as a Contractual Employee with effect from
						<?php echo date('d/m/Y', strtotime($row1['joindate']));?>
						<!--to -->
						<?php //echo date('d/m/Y', strtotime('+6 month -1 day', strtotime($row1['joindate'])))?>
						<?php //echo date('d/m/Y', strtotime('+6 month -1 day', strtotime($row1['joindate'])))?>
						<!--(both days inclusive).Your last working day shall be <?php //date('d/m/Y', strtotime('+6 month -1 day', strtotime($row1['joindate'])))?>.-->

					</td>
				</tr>
				<tr>
					<td class="tjust">You are deputed to work on the premises of
						<?php echo $resclt['client_name'];?>
						at
						<?php echo $resclt['client_add1'];?>.
					</td>
				</tr>
				<tr>
					<td style="text-align:right" class="tjust"><span style="float:left">Your starting monthly salary
							shall be as follows :</span><br>
						<table style="width:50%; float:left">
							<br>
							<?php $emid =$row1['emp_id']; 
						$emptot =0;
						$res2 = $payrollAdmin->getEmployeeIncome($emid);
				//		while($result2 = mysql_fetch_array($res2)){ 
				foreach($res2 as $result2){ 
								if(strtolower($result2['income_heads_name'])!="night sft." && strtolower($result2['income_heads_name']!="overtime" && $result2['income_heads_name'])!="LEAVE ENCASHMENT" && $result2['std_amt'] > 0 &&  $result2['income_heads_name']!="OVERTIME"){
						?>

							<tr>
								<td style="text-align:left">
									<?php echo $result2['income_heads_name'];?>
								</td>
								<td><span style="float:left">Rs </span>
									<?php echo $result2['std_amt'];?>
								</td>
							</tr>
							<?php $emptot += $result2['std_amt']; }} ?>
							<tr>
								<td style="text-align:left;">Total rupees per month</td>
								<td
									style="border-top:1px dashed #000 !important;border-bottom:1px dashed #000 !important;">
									<?php 
												echo number_format($emptot,2,".",",");?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2"><span style="float:left">(Rupees
							<?php 
				
					
					
				
				            $money= number_format($emptot,2,".","");
				            $stringmoney="";
							$stringmoney=$payrollAdmin->convertNumberTowords($money);
				// 				echo $stringmoney;
				// 			echo "**************";
				            echo ucwords(strtolower($stringmoney));
				            
				           if (preg_match('/./',$money)) {
				            $decimalNum=explode(".",$money);
    				            if($decimalNum[1]>0){
        				            $dstringmoney=$payrollAdmin->convertNumberTowords($decimalNum[1]);
        				             echo ' and paise '.ucwords(strtolower($dstringmoney));
    				            }
				            }
				          
				            ?> only)
						</span></td>
				</tr>

				<tr>
					<td class="tjust"></td>
				</tr>
				<tr>
					<td class="tjust">You will not be entitled to any allowances or facilities which are given to the
						regular
						employees of the company / establishment where you are deputed, since you shall not
						be an employee of the said company/establishment. </td>
				</tr>
				<tr>
					<td class="tjust">You are liable to be transferred from one establishment/company to another,
						anywhere, at our sole discretion.</td>
				</tr>
				<tr>
					<td class="tjust">You are liable to be transferred from one job to another, one section to another,
						one
						department to another, one unit to another, located anywhere, at the sole discretion of
						the company where you are deputed. </td>
				</tr>
				<tr>
					<td class="tjust">If the company/establishment, where you shall be deputed, tells us to deduct any
						amount from your monthly salary, for certain expenses incurred, we shall deduct the
						same from your monthly salary. </td>
				</tr>
				<tr>
					<td class="tjust">Your contractual employment shall automatically come to an end, as per the date
						given herein above, and you shall be relieved immediately thereafter.</td>
				</tr>
				<tr>
					<td class="tjust">If the above mentioned company terminates our contract for the supply of
						contractual
						manpower to them, prior to the date of completion of your employment, stated herein
						above, your employment will automatically come to an end, immediately at that time.</td>
				</tr>

				<tr>
					<td class="tjust">The model standing orders of the State Government shall be applicable to you.</td>
				</tr>
				<tr>
					<td class="tjust">
						Please sign and return the duplicate copy of this letter as a token of your acceptance
						of the conditions stipulated herein above.</td>
				</tr>
				<tr>
					<td>Yours faithfully,</td>
				</tr>
				<tr>
					<td>For
						<?php echo $resclt['client_name'];?>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>

				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>Authorised Signatory</td>
				</tr>

			</table>
		</div>
		<?php } } else if($_REQUEST['typeapp'] =="2"){
		//////////////////////////////// type 2 format (Baker,Sakal.Others)//////////////////////////////////
		
	if($_REQUEST['emp']==1){
	$res1 = $payrollAdmin->showEployeedetailsQ($_REQUEST['employee']);
	}else{
	$res1 = $payrollAdmin->getEmployeeDetailsByClientIdAppont($clientid,$cmonth);	
	}
//	while($row1 = mysql_fetch_array($res1)){
foreach($res1 as $key1=>$row1){
	    //echo "<pre>";print_r($row1);echo "</pre>";
	?>

		<div id="format2" class="page-bk">
			<table width="100%">
				<tr>

					<td align="right" style="text-align:left">
						<div style="width:45%; float:right">
								<?php echo $resclt['client_name'];?><br>
							<?php echo $resclt['client_add1'];?>,
						    <br>E-mail:
							<?php echo $resclt['email'];?>
							<br>
							<?php 
													
							echo date('d/m/Y', strtotime('-7 day', strtotime($row1['joindate'])));?>
						</div>
					</td>
				</tr>
				<tr>
					<td>Ref.No :
						<?php echo $row1['emp_id'];?> <span style="float:right">
							<?php 	
						?>
						</span>
					</td>
				</tr>
				<tr>
					<td>To,</td>
				</tr>
				<tr>
					<td>
						<?php echo ucfirst(strtolower($row1['first_name'])). " ".ucfirst(strtolower($row1['middle_name'])). " ".ucfirst(strtolower($row1['last_name']));?>
						<br>
						<table style="width:50%">
							<tr>
								<td>
									<?php echo nl2br(ucwords(strtolower(rtrim($row1['emp_add1']))))." ".trim($row1['pin_code']);?>
								</td>
							</tr>
						</table>
					</td>
					<td></td>
				</tr>
				<tr style="text-transform:uppercase;">
					<td>Sub :- Appointment Letter
						<?php if ( $row1['desg_id']!= '1') {echo" as a". ucfirst(strtolower($row1['mast_desg_name']));}else {echo "Contractual Employee";} ?>
					</td>
				</tr>
				<tr>
					<td class="tjust"><br>Dear
						<?php if($row1['gender']=='M'){echo "Mr. ";}else{echo "Ms/Mrs.  ";} echo ucfirst( strtolower( $row1['first_name']));?>
						,<br>
						With reference to your application, and the subsequent interview, we are pleased to appoint you
						as contractual
						<?php if ( $row1['mast_desg_name']!= '') {echo ucfirst(strtolower($row1['mast_desg_name']));}else {echo "Contractual Employee";} ?>
						on the premises of
						<?php echo $resclt['client_name'];?>
						AT
						<?php echo $resclt['client_add1'];?> with effect from
						<?php echo date('d/m/Y', strtotime($row1['joindate']));?>
						<!--to -->
						<?php //echo date('d/m/Y', strtotime('+6 month -1 day', strtotime($row1['joindate'])))?>.

					</td>
				</tr>
				<tr>
					<td style="text-align:right" class="tjust"><span style="float:left">Your starting monthly salary
							shall be as follows :</span><br>
						<table style="width:50%; float:left">
							<br>
							<?php $emid =$row1['emp_id']; 
						$emptot =0;
						$res2 = $payrollAdmin->getEmployeeIncome($emid);
					//	while($result2 = mysql_fetch_array($res2)){ 
						foreach($res2 as $result2)		{  
								if(strtolower($result2['income_heads_name'])!="night sft." && strtolower($result2['income_heads_name']!="overtime" && $result2['income_heads_name'])!="LEAVE ENCASHMENT" && $result2['std_amt'] > 0 &&  $result2['income_heads_name']!="OVERTIME"){
						?>

							<tr>
								<td style="text-align:left">
									<?php echo $result2['income_heads_name'];?>
								</td>
								<td><span style="float:left">Rs </span>
									<?php echo $result2['std_amt'];?>
								</td>
							</tr>
							<?php $emptot += $result2['std_amt']; }} ?>
							<tr>
								<td style="text-align:left;">Total rupees per month</td>
								<td
									style="border-top:1px dashed #000 !important;border-bottom:1px dashed #000 !important;">
									<?php 
												echo number_format($emptot,2,".",",");?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2"><span style="float:left">(Rupees
							<?php 
				
					
					
				
				            $money= number_format($emptot,2,".","");
				            $stringmoney="";
							$stringmoney=$payrollAdmin->convertNumberTowords($money);
				// 				echo $stringmoney;
				// 			echo "**************";
				            echo ucwords(strtolower($stringmoney));
				            
				           if (preg_match('/./',$money)) {
				            $decimalNum=explode(".",$money);
    				            if($decimalNum[1]>0){
        				            $dstringmoney=$payrollAdmin->convertNumberTowords($decimalNum[1]);
        				             echo ' and paise '.ucwords(strtolower($dstringmoney));
    				            }
				            }
				          
				            ?> only)
						</span></td>
				</tr>

				<tr>
					<td class="tjust"></td>
				</tr>
				<tr>
					<td class="tjust">You will not be entitled to any allowances or facilities which are given
						to the regular employees of the company / establishment where you
						are deputed, since you are not an employee of the said
						company/establishment. </td>
				</tr>
				<tr>
					<td class="tjust">You are liable to be transferred from one job to another, one section
						to another, one department to another, one unit to another, and one
						location to another, at the sole discretion of the company where you
						are deputed.</td>
				</tr>
				<tr>
					<td class="tjust">Your services can be terminated at any time, by giving you one
						month’s notice, or salary in lieu thereof. If the Principal Employer
						discontinues our contract with them, at any time, your employment
						will automatically come to an end, immediately, at that time. </td>
				</tr>

				<tr>
					<td class="tjust">If you wish to leave the job, you shall have to give us one month’s
						written notice, failing which you shall have to give us an amount
						which is equal to your one month’s gross salary at the time of
						leaving. </td>
				</tr>

				<tr>
					<td class="tjust">The model standing orders of the State Government shall be
						applicable to you.</td>
				</tr>
				<tr>
					<td class="tjust">Please sign and return the duplicate copy of this letter and the
						enclosures as a token of your acceptance of the conditions
						stipulated herein above.</td>
				</tr>


				<tr>
					<td>Yours faithfully,</td>
				</tr>
				<tr>
					<td>For
						<?php echo $resclt['client_name'];?>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>

				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>Authorised Signatory</td>
				</tr>

			</table>
		</div>
		<?php } } ?>
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