<?php
session_start();
error_reporting(0);
$month=$_SESSION['month'];
$clientid=$_SESSION['clientid'];
$emp=$_REQUEST['emp'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$doc_path=$_SERVER["DOCUMENT_ROOT"];
include ($doc_path.'/include_payroll_admin.php');
$compdetails = $payrollAdmin->showCompdetailsById($comp_id);

//$res=$payrollAdmin->showEmployeereport($comp_id,$user_id);

$resclt=$payrollAdmin->displayClient($clientid);
$cmonth=$resclt['current_month'];

?>

<!DOCTYPE html>

<html lang="en-US">
<head>

    <meta charset="utf-8"/>
    <title> &nbsp;</title>

    <style>
		.header {
			overflow: hidden;
			background-color: #f1f1f1;
			padding: 30px 10px;
			}
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

       table, td,th {
            padding: 14px!important;
			border:0 !important;
            /*border: 1px dotted black!important;
            font-size:30px !important;*/
            font-family: Arial;

        }
		 #format1 table,  #format1 td,  #format1 th, #format1 li,#format1 div{font-size:16px !important;}
		 #format1 div{font-size:16px !important; line-height:23px}
		 #format2 table,  #format2 td,  #format2 th {font-size:12px !important;}
		 #form3 table,  #form3 td,  #form3 th {font-size:16px !important;}
		 #format1 ol,#format1 li{margin-left:15px; text-align:justify}
		<!--.flr{float:right}-->
		#appletter{appletter}
		.tjust{text-align:justify}
		.tbtit1{font-weight:900}
		.tbtit2{font-weight:500}
		table.paydtl,.paydtl td{border:1px solid black !important}
		.bggray{
			background:#ccc;
		}
		#format2 table,#format2 td,#format2 th {
            padding: 3px!important;
			border:0 !important;
            /*border: 1px dotted black!important;*/
           
            font-family: Arial;

        }
		
		footer {page-break-after: auto;}
		.padd20{padding-left:20px !important}
	
        @media print
        {
	

		footer {page-break-after: auto;}
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
			@page {   
				margin: 20px;
				padding:0				
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

<body>
<div class="btnprnt">
    <button class="submitbtn" onclick="myFunction()">Print</button>
    <button class="submitbtn"  onclick="history.go(-1);" >Cancel</button>
</div>
<!-- content starts -->


	<div  >
		<?php
//include('printheader.php');
		?>
	</div>
    <div class="row body" >
			<?php if($_REQUEST['type'] =="1"){ 
	//////////////////////////////// type 1 format //////////////////////////////////
	
			if($_REQUEST['emp']==1){
				$res1 = $payrollAdmin->showEployeedetailsQ($_REQUEST['employee']);
				}else{
				$res1 = $payrollAdmin->getEmployeeDetailsByClientIdAppont($clientid,$cmonth);	
				}
			foreach($res1 as $row1)
			{
			?>
				<div class="page-bk" id="format1">
				<table width="100%" id="appletter">
				</head>
			<thead>
				<tr>
					<td></td>
					<td align="right" colspan="2" width="50%" style="text-align:left">
					<?php echo $compdetails['comp_name'];?><br>	
						1117/5A, Off Ganeshkhind Road,<br>Pune 411 016<br>Tel. :25660360 / 25652095 Fax:25656144<br>E-mail:shaconpvt@gmail.com<br><br>
					<?php 	
					echo date('dS F Y', strtotime('-7 day', strtotime($row1['joindate'])))?>
					</td>
				</tr>
			</thead>
			<tr>
				<td colspan="2">
				REF: EMPLOYEE NO. <?php echo $row1['emp_id'];?>
				</td>
		
			</tr>
			<tr>
				<td ><?php if($row1['gender']=='M'){echo "Mr.";}else{echo "Ms/Mss";}?> <?php echo ucfirst( strtolower( $row1['first_name'])). " ".ucfirst( strtolower($row1['middle_name'])). " ".ucfirst( strtolower($row1['last_name']));?><br>
				At Post :  <?php echo nl2br(ucwords(strtolower($row1['emp_add1'])));?><br>
				<?php echo $row1['pin_code'];?><br>
				</td>
				<td></td>
			</tr>
			<tr>
				<td colspan="2">Dear  <?php if($row1['gender']=='M'){echo "Mr.";}else{echo "Ms/Mss";}?>  <?php echo ucfirst( strtolower($row1['last_name']));?>               
				</td>
			</tr>
			<tr>
				<td colspan="2">SUB:  APPOINTMENT LETTER <br>                 
				</td>
			</tr>
			</table>
			<table>
				<tr> 
					<td width = "5%"></td> <td width = "95%"></td>
				</tr>
				<tr>
					<td colspan="2">With reference to your application and subsequent interview, we are pleased to appoint you on the following terms and conditions:                
					</td>
				</tr>
				<tr>
					<td></td>
					<td >
						1. You are hereby offered employment, and you will be deployed at <?php echo $resclt['client_name'];?> against a contract of accounting assistance services, awarded to us.<br>
					</td>
				</tr>
	
				<tr>	
					<td></td>
					<td >2. Your service shall be purely on a contractual basis from <?php  $row1['joindate']; echo date('d/m/Y', strtotime($row1['joindate']))?> to <?php 	
					echo date('d/m/Y', strtotime('+ 1 year - 1 day', strtotime($row1['joindate'])))?> (both days inclusive).  However they can be terminated at any time, prior to the termination of this contract, without assigning any reason, by giving you one month’s notice or salary in lieu thereof, if the said contract is not terminated earlier by the said company.<br>
					</td>
				</tr>
	
	
				<tr>
					<td></td>
					<td >
					3. If the department, or the company, where you are deployed, closes down, or if the company discontinues their agreement with us, prior to the date on which this contract ends, which is stated herein above, success your services shall automatically come to an end from such date. If our client renews the contract with us regarding providing accounting assistance services, your contract  may be renewed, subject to your performance and behaviour being found satisfactory, accordingly.
					</td>
				</tr>
	
				<tr>
					<td></td>
					<td >4. Your employment will be continued  with clients based on passing the test conducted after completion of your Induction Training. During the period of this assignment, if you wish to resign, you may do so by giving us one month’s notice or forego salary in lieu thereof.
					</td>
				</tr>
	
				<tr>
					<td></td>
					<td >5. Your monthly  C.T.C. salary  is enclosed herewith.
					</td>
				</tr>
	
				<tr><td></td>
					<td >6. You shall not be entitled to the wages, allowances and facilities    that are given to the employees of the establishment / company where you are deployed to work, as you  shall not  be an employee of the said establishment / company, and also you shall not be entitled to claim any employment with them.
					</td></tr>
	
	
				<tr><td></td>
					<td >7. During the course of your deployment to the establishment / company where you work, you shall maintain absolute secrecy and confidentiality  of all the information that you come across in the said  establishment / company, and shall not reveal it to any third person or party.
					</td></tr>
	
	
				<tr><td></td>
					<td >	<div class="header"></div>
					
					8. You shall be expected to work in any department, section, job, etc. as per the programme fixed by the establishment / company, and you shall report to such department, section, job as directed.
					</td></tr>
	
	
	
				<tr><td></td>
					<td >9. All disputes, if any, pertaining to this appointment, shall be subject to Pune Jurisdiction only.
					</td></tr>
	
				<tr>
					<td colspan="2">Please sign and return to us the duplicate copy of this letter, enclosed herewith, duly signifying that you understand and accept this offer of appointment as per the terms and conditions stipulated herein above.                
					</td>
				</tr>
	
	
				<tr>
					<td colspan="2" class="tjust "></td>
					</tr>
					<tr><td class="tjust" colspan = "2" >
					Thanking you,<br><br><br>
					Yours faithfully,<br>
					For <?php echo $compdetails['comp_name'];?>. <br>                
					</td>
				</tr>
				<tr><td></td></tr>
				<tr><td></td></tr>
				
				<tr><td colspan = 2>Authorised Signatory</td></tr>
	
	
				<tr><td>&nbsp;</td></tr>
				</table>
	</div>
	<div class="header"></div>
</div>
	<td >
	<table width="100%" >
	<tr >
	<td >
	REF: EMPLOYEE  NO.  <?php echo $row1['emp_id'];?>        
	</td>
	<td></td>
	</tr>
	<tr>
	<td >
	<?php if($row1['gender']=='M'){echo "Mr.";}else{echo "Ms/Mss";}?> <?php echo $row1['first_name']. " ".$row1['middle_name']. " ".$row1['last_name'];?><br>
		<?php echo $row1['emp_add1'];?><br>
		<?php echo $row1['pin_code'];?><br>
       
	<td>
	<td></td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	</table>
	<table width="100%" class="paydtl" ><!--cellpadding="1" cellspacing="1" -->
	
		<tr>
		<td class="tbtit1">PARTICULAR</td>
		<td class="tbtit2" align = "right" >AMOUNT</td>
		</tr>
		<!-- income --->
		<?php $emid =$row1['emp_id']; 
		$incomesadd =0;
		$basic =0;
		$dbda=0;
		$esided =0;
		$res2 = $payrollAdmin->getEmployeeIncome($emid);
		foreach($res2 as $result2)
		{
			if(strtolower($result2['income_heads_name'])!="night sft." && strtolower($result2['income_heads_name']!="overtime" && $result2['income_heads_name'])!="LEAVE ENCASHMENT" && $result2['std_amt'] > 0 ){
		?>
		<tr>
		<td class="tbtit1"><?php echo $result2['income_heads_name'];?></td>
		<td ><span class="flr"><?php echo number_format($result2['std_amt'],2); 
		if($result2['head_id']==5){ $basicdb = $result2['std_amt'];}
		if($result2['head_id']==6){ $dbda = $result2['std_amt'];} 
		if($result2['head_id']==43){  $bonus= $result2['std_amt'];} 
		
		?></span></td>
		</tr>
		<?php $incomesadd += $result2['std_amt'];}} ?>
			<!-- income end --->
		<tr>
		
		<tr>
		<td class="tbtit1">Gross Sal PM</td>
		<td class="bggray "><span class="flr"><?php echo number_format($incomesadd,2);?></span></td>
		</tr>
		<!-- deduction start --
		<?php $res3 = $payrollAdmin->getEmployeeDeduction($emid);
		foreach($res3 as $result3)
		{
		?>
		<tr>
		<td class="tbtit1"><?php echo $result3['deduct_heads_name'];?></td>
		<td><?php echo number_format($result3['std_amt']);?></td>
		</tr>
		<?php } ?>
		-- deduction end -->
		<?php $da = $payrollAdmin->pfDed($emid); if($da!=0){?>
		<tr>
		<td class="tbtit1">PF Dedn</td>
		<td ><span class="flr"><?php  $pfded = ($basicdb+$dbda)*12/100; echo number_format($pfded,2);//$pfded = $payrollAdmin->pfDed($emid);?></span></td>
		</tr>
		<?php } ?>
		<?php if($row1['esistatus'] =='Y'){?>
		<tr>
		<td class="tbtit1">ESI Dedn</td>
		<td ><span class="flr"><?php $esided = $incomesadd * 1.75/100; echo number_format($esided,2);?></span></td>
		</tr>
		<?php }?>
	
		<?php $ptdedamt=0; $ptded = $payrollAdmin->ptDed($emid); if($ptded !=""){?>
		<tr>
		<td class="tbtit1">PT Dedn</td>
		<td ><span class="flr"><?php if($ptded !=""){$ptdedamt = 200; echo number_format($ptdedamt,2);  }?></span></td>
		</tr>
		<?php }?>
		<tr>
		<td class="tbtit1">Total dedn</td>
		<td ><span class="flr"><?php  $totded = $pfded+$esided+$ptdedamt; echo number_format($totded,2);?></span></td>
		</tr>
		
		<tr>
		<td class="tbtit1">Net Salary PM</td>
		<td class="bggray "><span class="flr"><?php $netsalpm = $incomesadd-$totded; echo number_format($netsalpm,2);?></span></td>
		</tr>
		<tr>
		<td class="tbtit1">PF 13.00% Comp</td>
		<td ><span class="flr"><?php  $pfcomp = ($basicdb+$dbda)*(13.00/100); echo number_format($pfcomp,2);?></span></td>
		</tr>
		<tr>
		<td class="tbtit1">ESI 4.75% Comp</td>
		<td ><span class="flr"><?php $esicomp = $incomesadd*4.75/100;  echo number_format($esicomp,2);?></span></td>
		</tr>
		<tr>
		<td class="tbtit1">GPA 2 lac Premium</td>
		<td ><span class="flr">14.00 </span></td>
		</tr>
		<tr>
		<td class="tbtit1">Total Company Contrn PM</td>
		<td><span class="flr"><?php $totalcompanycontrn = $pfcomp+$esicomp+14;  echo number_format($totalcompanycontrn,2);?></span></td>
		</tr>
		<tr>
		<td class="tbtit1">CTC PM</td>
		<td class="bggray "><span class="flr"><?php  $ctcpm = $totalcompanycontrn+$incomesadd; echo number_format($ctcpm,2);?></span></td>
		</tr>
		<tr>
		<td class="tbtit1">CTC PA</td>
		<td ><span class="flr"><?php  $ctcpa = $ctcpm*12; echo number_format($ctcpa,2);?></span></td>
		</tr>
		
	</table>
	</td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	<tr><td>&nbsp;</td></tr>
	<tr><td>FOR  <?php echo $compdetails['comp_name'];?></td></tr>	
	
</table></div>

	<td >	<div class="header">

	<?php }} else if($_REQUEST['type'] =="2"){
		//////////////////////////////// type 2 format //////////////////////////////////
		
	if($_REQUEST['emp']==1){
	$res1 = $payrollAdmin->showEployeedetailsQ($_REQUEST['employee']);
	}else{
	$res1 = $payrollAdmin->getEmployeeDetailsByClientIdAppont($clientid,$cmonth);	
	}
	foreach($res1 as $row1)
	{
	?>
		<div id="format2" class="page-bk">
			<table width="100%">
				<tr>
		
					<td align="right"   style="text-align:left">
					 	<div style="width:45%; float:right">	
							<?php echo $compdetails['comp_name'];?><br>	
							1117/5A, Off Ganeshkhind Road,<br>Pune 411 016<br>Tel. :25660360 / 25652095 Fax:25656144<br>E-mail:shaconpvt@gmail.com
							<br><br>
							<?php 
													
							echo date('d/m/Y', strtotime('-7 day', strtotime($row1['joindate'])));?>
						</div>
					</td>
				</tr>
				<tr>
					<td>Ref.No : <?php echo $row1['emp_id'];?> <span style="float:right"><?php 	
						?></span></td>
				</tr>
				<tr>
					<td>To,</td>
				</tr>
				<tr>
					<td ><?php echo ucfirst(strtolower($row1['first_name'])). " ".ucfirst(strtolower($row1['middle_name'])). " ".ucfirst(strtolower($row1['last_name']));?>  <br>
						<table style="width:50%"> 
							<tr><td><?php echo nl2br(ucwords(strtolower($row1['emp_add1'])));?></td></tr>
						</table>
		
						<?php echo $row1['pin_code'];?></td><td></td>
				</tr>
				<tr>
					<td>Sub :- Appointment As a  <?php if ( $row1['mast_desg_name']!= '') {echo ucfirst(strtolower($row1['mast_desg_name']));}else {echo "Trainee";} ?> </td>
				</tr>
				<tr>
					<td class="tjust"><br>Dear Sir,<br><br>
					With reference to your application dated <?php 	
					echo date('d/m/Y', strtotime('-14 day', strtotime($row1['joindate'])))?> and the subsequent interview, we are pleased to offer you training facilities at the premises of  <?php echo $resclt['client_name'];?>  from <?php echo date('d/m/Y', strtotime($row1['joindate']));?>  to <?php echo date('d/m/Y', strtotime('+6 month -1 day', strtotime($row1['joindate'])))?> (both days inclusive).Your last day of training shall be <?=date('d/m/Y', strtotime('+6 month -1 day', strtotime($row1['joindate'])))?>.

					</td>
				</tr>
				<tr>
					<td style="text-align:right" class="tjust"><span style="float:left">During the training your monthly stipend shall be as follows :</span>
					<table style="width:50%; float:right">
			
						<?php $emid =$row1['emp_id']; 
						$emptot =0;
						$res2 = $payrollAdmin->getEmployeeIncome($emid);
						foreach($res2 as $result2)
						{ 
								if(strtolower($result2['income_heads_name'])!="night sft." && strtolower($result2['income_heads_name']!="overtime" && $result2['income_heads_name'])!="LEAVE ENCASHMENT" && $result2['std_amt'] > 0 &&  $result2['income_heads_name']!="OVERTIME"){
						?>
			
						<tr>
							<td style="text-align:left"><?php echo $result2['income_heads_name'];?></td>
							<td><span style="float:left">Rs </span><?php echo $result2['std_amt'];?></td>				
						</tr>
							<?php $emptot += $result2['std_amt']; }} ?>
						<tr><td style="text-align:left;">Total rupees per month</td><td style="border-top:1px dashed #000 !important;border-bottom:1px dashed #000 !important;"><?php 
												echo number_format($emptot,2,".",",");?></td></tr>			
					</table>           
					</td>
				</tr>
				<tr>
				<td colspan="2"><span style="float:left">(Rupees <?php 
				
						//$money=$emptot;
						$money= number_format($emptot,2,".","");
							$stringmoney=$payrollAdmin->convertNumberTowords($money);
 
				
				echo ucwords(strtolower($stringmoney));?>)</span></td></tr>
			
				<tr><td class="tjust"></td></tr>
					<tr>	<td class="tjust">You will not be entitled to any allowances or facilities which are given to the regular employees of the company / establishment where you shall be undergoing training, since you shall not be an employee of the said company/establishment. <br><br> 


During the training period you are liable to be transferred from one job to another, one section to another, one department to another, one unit to another, located within the same premises/precincts, at the sole discretion of the company where you shall be training.  <br><br>

If the company/establishment, where you shall be deputed for training, tells us to deduct any amount from your monthly stipend, for certain expenses incurred, such as premiums for insurance policies, uniforms, and any other such expenses, we shall deduct the same from your monthly stipend.   <br><br>

The training facilities may be withdrawn, at any time, without any notice, or without assigning any reason, during the period of the training.  <br><br>

Your training programme shall automatically come to an end as per the date stated herein above, and you shall be relieved immediately thereafter.   <br><br>

If the above mentioned company terminates our contract with them, prior to the date of the end of your training, your training will automatically come to an end, immediately at that time. <br><br>

The model standing orders of the State Government shall be applicable to you.   <br><br>


Please sign and return the duplicate copy of this letter and the enclosures as a token of your acceptance of the conditions stipulated herein above. <br><br>

Yours faithfully, <br><br>



</td></tr>
	<tr><td>For <?php echo $compdetails['comp_name'];?></td></tr>	
	<tr><td>&nbsp;</td></tr>
	
	<tr><td>&nbsp;</td></tr>
	<tr><td>&nbsp;</td></tr>
	<tr><td>Authorised Signatory</td></tr>
	
			</table>
		</div>
	<?php } }else if($_REQUEST['type'] =="3"){
	//////////////////////////////// type 3 format //////////////////////////////////
		
	if($_REQUEST['emp']==1){
	$res1 = $payrollAdmin->showEployeedetailsQ($_REQUEST['employee']);
	}else{
	$res1 = $payrollAdmin->getEmployeeDetailsByClientIdAppont($clientid,$cmonth);	
	}
	foreach($res1 as $row1)
	{
	?>
		<div id="format2" class="page-bk">
		<table width="100%" id="form3">
		
	<tr>
	
	<td align="right"   style="text-align:left">
	<div>&nbsp;</div>
	<!-- <div class= "header"> </div>-->
	<div style="float:right">	
	<?php echo $compdetails['comp_name'];?><br>	
	1117/5A, Off Ganeshkhind Road,<br>Pune 411 016<br>Tel. :25660360 / 25652095 Fax:25656144<br>E-mail:shaconpvt@gmail.com<br><br>Date : <?php 	
	echo date('d/m/Y', strtotime('-7 day', strtotime($row1['joindate'])))?>
	</div>
	</td></tr>
			<tr>
			<td>Ref.No : <?php echo $row1['emp_id'];?></td>
			</tr>
			<tr>
			<td>To,</td>
			</tr>
			<tr>
			<td ><?php echo ucfirst(strtolower( $row1['first_name'])). " ".ucfirst(strtolower($row1['middle_name'])). " ".ucfirst(strtolower($row1['last_name']));?>  <br>
			<table style="width:50%"> 
			<tr><td><?php echo nl2br(ucwords(strtolower(trim($row1['emp_add1']))));?> <?php echo ucwords(strtolower($row1['pin_code']));?></td></tr>
			</table>
		
		</td><td></td>
			<tr>
			<td><b>Sub :- Appointment As a <?php if ( $row1['mast_desg_name']!= '') {echo ucfirst(strtolower($row1['mast_desg_name']));}else {echo "Trainee";} ?></b><br><br></td>
			</tr>
			<td class="tjust">Dear Sir,<br><br>With reference to your application dated <?php 	
	echo date('d/m/Y', strtotime('-14 day', strtotime($row1['joindate'])))?> and the subsequent interview, we are pleased to offer you training facilities at the premises of <?php echo $resclt['client_name'];?> for a period from <?php echo date('d/m/Y', strtotime($row1['joindate']));?> to <?php echo  date('d/m/Y', strtotime($row1['due_date']))?>(both days inclusive).

			</td>
			</tr>
			<tr>
			<td style="text-align:right" class="tjust"><span style="float:left">During the training your monthly stipend shall be as follows :</span><br><br>
			<table style="width:50%; float:left">
			
			<?php $emid =$row1['emp_id']; 
		$emptot =0;
		$res2 = $payrollAdmin->getEmployeeIncome($emid);
		foreach($res2 as $result2)
		{
			if(strtolower($result2['income_heads_name'])!="night sft." && strtolower($result2['income_heads_name']!="overtime" && $result2['income_heads_name'])!="LEAVE ENCASHMENT" && $result2['std_amt'] > 0  && strtolower($result2['income_heads_name'])!="night sft."){
		?>
			
			<tr>
				<td style="text-align:left"><?php echo $result2['income_heads_name'];?></td>
				<td><span style="float:left">Rs </span><?php echo $result2['std_amt'];?></td>				
			</tr>
		<?php $emptot += $result2['std_amt']; } } ?>
			<tr><td style="text-align:left;">Total rupees per month</td><td style="border-top:1px dashed #000 !important; border-bottom:1px dashed #000 !important"><?php echo number_format($emptot,2,".",",");?></td></tr>			
			</table>           
			 </td>
			</tr>
			<tr><td colspan="2"><span style="float:left">(Rupees <?php 
				
						//$money=$emptot;
						$money= number_format($emptot,2,".","");
							$stringmoney=$payrollAdmin->convertNumberTowords($money);
 
				
				echo ucwords(strtolower($stringmoney));?>)</span></td></tr>
			
			<tr><td class="tjust">You will not be entitled to any other allowances or facilities which are given to the regular employees of the above mentioned company since you will not be an employee of the said company.</td></tr>
	<tr><td class="tjust">The model standing orders of the State Government shall be applicable to you.</td></tr>
	<tr><td class="tjust">During the training period you are liable to be transferred from one job to another, one section to another, from one department to another, from one unit to another located within the same premises/precincts, at the sole discretion of the company where you shall train.</td></tr>
	<tr><td class="tjust">The training facilities may be withdrawn at any time, without any notice or without assigning any reason, during the period of the training.</td></tr>
	<tr><td class="tjust">Your training programme shall automatically come to an end as per the date given herein above, and you shall be relieved immediately thereafter.</td></tr>
	<tr><td class="tjust">If the above mentioned company terminates our contract with them, prior to the date of termination of your training, your training will automatically come to an end, immediately at that time.</td></tr>
	
	
	<tr><td class="tjust">Please sign and return the duplicate copy of this letter and the enclosures as a token of your acceptance of the conditions stipulated herein above.</td></tr>
	<tr><td>Yours faithfully,</td></tr>
	<tr><td>For <?php echo $compdetails['comp_name'];?></td></tr>	
	<tr><td>&nbsp;</td></tr>
	
	<tr><td>&nbsp;</td></tr>
	<tr><td>&nbsp;</td></tr>
	<tr><td>Authorised Signatory</td></tr>
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