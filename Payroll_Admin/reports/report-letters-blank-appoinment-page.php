<?php
include ('../../include_payroll_admin.php');

$comp_id=$_SESSION['comp_id'];

$compdetails = $payrollAdmin->showCompdetailsById($comp_id);
$compdet = $_REQUEST['compdet'];
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

       table, td,th {
            padding: 5px!important;
			border:0 !important;
            /*border: 1px dotted black!important;
            font-size:30px !important;*/
            font-family: Arial;

        }
		 #format1 table,  #format1 td,  #format1 th, #format1 li,#format1 div{font-size:18px !important;}
		 #format1 div{line-height:22px}
		 #format2 table,  #format2 td,  #format2 th {font-size:12px !important; line-height:20px}
		 
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
            padding: 5px!important;
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
				margin: 0;
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

<div>
<div  >
<?php
//include('printheader.php');
?>
</div>
    <div class="row body" >
	<?php if($_REQUEST['type'] =="1"){ 
	//////////////////////////////// type 1 format //////////////////////////////////
	
	
	

	?>
	<div class="page-bk" id="format1">
    <table width="100%" id="appletter">
	</head>
	<thead>
	<tr>
	<td></td>
	<td align="right" colspan="2" width="50%" style="text-align:left">
		<?php if ($compdet==1){ echo $compdetails['comp_name']."<br>";	
		    echo "1117/5A, Off Ganeshkhind Road,<br>Pune 411 016<br>Tel. :25660360 / 25652095 Fax:25656144<br>E-mail:shaconpvt@gmail.com";}?>
	</td></tr></thead>
    <tr>
	<td colspan="2">
	REF: EMPLOYEE NO. 
	<span class="flr"></span>
	</td>
	
	</tr>
	<tr>
	<td ><br>
		<br>
		<br>
	</td>
	<td></td>
	</tr>
	<tr>
	<td colspan="2">Dear                 
	</td>
	</tr>
	<tr>
	<td colspan="2">SUB:  APPOINTMENT LETTER                
	</td>
	</tr>
	<tr>
	<td colspan="2">With reference to your application and subsequent interview, we are pleased to appoint you on the following terms and conditions:                
	</td>
	</tr>
	<tr>
	<td colspan="2">
	
	<div >1. You are hereby offered employment, and you will be deployed at _________________________________ against a contract of accounting assistance services, awarded to us.</div>
	<div>2. Your service shall be purely on a contractual basis from ______________ to _______________ (both days inclusive).  However they can be terminated at any time, prior to the termination of this contract, without assigning any reason, by giving you one month’s notice or salary in lieu thereof, if the said contract is not terminated earlier by the said company.</div>
	<div>3. If the department, or the company, where you are deployed, closes down, or if the company discontinues their agreement with us, prior to the date on which this contract ends, which is stated herein above, then your services shall automatically come to an end from such date. If our client renews the contract with us regarding providing accounting assistance services, your contract  may be renewed, subject to your performance and behaviour being found satisfactory, accordingly.</div>
	<div>4. Your employment will be continued  with clients based on passing the test conducted after completion of your Induction Training. During the period of this assignment, if you wish to resign, you may do so by giving us one month’s notice or forego salary in lieu thereof.</div>
	<div>5. Your monthly  C.T.C. salary  is enclosed herewith.</div>
	<div>6. You shall not be entitled to the wages, allowances and facilities    that are given to the employees of the establishment / company where you are deployed to work, as you  shall not  be an employee of the said establishment / company, and also you shall not be entitled to claim any employment with them.</div>
	<div>7. During the course of your deployment to the establishment / company where you work, you shall maintain absolute secrecy and confidentiality  of all the information that you come across in the said  establishment / company, and shall not reveal it to any third person or party.</div>
	<div>8. You shall be expected to work in any department, section, job, etc. as per the programme fixed by the establishment / company, and you shall report to such department, section, job as directed.</div>
	<div>9. All disputes, if any, pertaining to this appointment, shall be subject to Pune Jurisdiction only.</div>
	
	</td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	
	<tr>
	<td colspan="2" class="tjust ">Please sign and return to us the duplicate copy of this letter, enclosed herewith, duly signifying that you understand and accept this offer of appointment as per the terms and conditions stipulated herein above.</td>
	</tr>
	<tr><td class="tjust">
Thanking you,<br><br><br>
Yours faithfully,<br>

For <?php echo $compdetails['comp_name'];?>. <br>                
	</td>
	</tr>
	
	
	<tr><td>&nbsp;</td></tr>
	<tr>
	<td class="page-bk">
	<table width="100%" >
	<tr >
	<td >
	REF: EMPLOYEE  NO.          
	</td>
	<td></td>
	</tr>
	<tr>
	<td >
	<br>
		
       
	<td>
	<td></td>
	</tr>
	
	</table>
	<table width="100%" class="paydtl" cellpadding="1" cellspacing="1" >
	
		<tr>
		<td class="tbtit1">PARTICULAR</td>
		<td class="tbtit2" >AMOUNT</td>
		</tr>
		<!-- income --->
		
		<tr>
		<td class="tbtit1" height="150"></td>
		<td ></td>
		</tr>
		
			<!-- income end --->
		<tr>
		
		<tr>
		<td class="tbtit1">Gross Sal PM</td>
		<td class="bggray "><span class="flr"></span></td>
		</tr>
		
		
		<tr>
		<td class="tbtit1">PF Dedn</td>
		<td ><span class="flr"></span></td>
		</tr>
		
		
		<tr>
		<td class="tbtit1">ESI Dedn</td>
		<td ><span class="flr"></span></td>
		</tr>
		
	
		
		<tr>
		<td class="tbtit1">PT Dedn</td>
		<td ><span class="flr"></span></td>
		</tr>
		
		<tr>
		<td class="tbtit1">Total dedn</td>
		<td ><span class="flr"></span></td>
		</tr>
		
		<tr>
		<td class="tbtit1">Net Salary PM</td>
		<td class="bggray "><span class="flr"></span></td>
		</tr>
		<tr>
		<td class="tbtit1">PF 13.15% Comp</td>
		<td ><span class="flr"></span></td>
		</tr>
		<tr>
		<td class="tbtit1">ESI 4.75% Comp</td>
		<td ><span class="flr"></span></td>
		</tr>
		<tr>
		<td class="tbtit1">GPA 2 lac Premium</td>
		<td ><span class="flr"> </span></td>
		</tr>
		<tr>
		<td class="tbtit1">Total Company Contrn PM</td>
		<td><span class="flr"></span></td>
		</tr>
		<tr>
		<td class="tbtit1">CTC PM</td>
		<td class="bggray "><span class="flr"></span></td>
		</tr>
		<tr>
		<td class="tbtit1">CTC PA</td>
		<td ><span class="flr"></span></td>
		</tr>
		
	</table>
	</td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	
	<tr><td>FOR  IMCON ASSOCIATES</td></tr>	
	
</table></div>
	<?php } elseif($_REQUEST['type'] =="2"){
		//////////////////////////////// type 2 format //////////////////////////////////
		
	
	
	?>
		<div id="format2" class="page-bk">
		<table width="100%">
		<thead>
	<tr>
	
	<td align="right"   style="text-align:left">
	<div style="width:45%; float:right">	
			<?php  if ($compdet==1){ echo $compdetails['comp_name']."<br>";	
		    echo "1117/5A, Off Ganeshkhind Road,<br>Pune 411 016<br>Tel. :25660360 / 25652095 Fax:25656144<br>E-mail:shaconpvt@gmail.com";}?>

	</div>
	</td></tr></thead>
			<tr>
			<td>Ref.No : <span style="float:right"></span></td>
			</tr>
			<tr>
			<td>To,</td>
			</tr>
			<tr>
			<td >  <br>
			<table style="width:50%"> 
			<tr><td></td></tr>
			</table>
		
		</td><td></td>
			<tr>
			<td>Sub :- Appointment As a Trainee </td>
			</tr>
			<tr>
			<td class="tjust">Dear Sir,<br>This has reference to your application dated ______________ for training facilities and  the  subsequent  interview  you  had  with us. We are pleased to offer you training facilities with  effect from ______________ at the premises of _________________________________ for a period from ______________
			</td>
			</tr>
			<tr>
			<td style="text-align:right" class="tjust"><span style="float:left">You will be paid stipend per month as shown herein.</span>
			<table style="width:50%; float:right">
			
			
			<tr>
			<td height="30px"></td>
			</tr>
			<tr>
				<td style="text-align:left"></td>
				<td><span style="float:left">Rs </span>&nbsp;&nbsp;&nbsp;&nbsp;</td>				
			</tr>
			
			<tr><td style="text-align:left;">Total rupees per month</td><td style="border-top:1px dashed #000 !important"></td></tr>			
			</table>           
			 </td>
			</tr>
			<tr><td colspan="2"><span style="float:left">(Rupees __________________________________________)</span></td></tr>
			
			<tr><td class="tjust">All the payment to you will be made by a crossed cheque.</td></tr>
			<tr><td class="tjust">You will not be entitled to any other allowances or facilities offered to the regular employees by ____________________________________ since you are not the employee of the said company.</td></tr>
	<tr><td class="tjust">You are bound by Model Standing Orders of the State Government.</td></tr>
	<tr><td class="tjust">You are liable to be transferred from one section to another, one department to  another department, one unit  to  any other unit located within the same premises/precincts at the  sole discretion of  the company, if it feels that you are required to acquire  additional skills/training and  that you will be required to do small jobs that are within your capacity.</td></tr>
	<tr><td class="tjust">In case,our Company/Firm is asked by the principal employer,either orally or in writing, to cover our workmen under a suitable Mediclaim Insurance Policy or Group Accident Insurance Policy,we shall be entitled to deduct an  amount  equivalent to yearly insurance  premium  from your monthly wages payable,and that you shall not raise any dispute before any forum,legal or otherwise, during or after tenure  of your training. Similarly,if the Principal Employer asks us to provide uniforms to our workmen, we shall be entitled to deduct an amount equivalent to the charges claimed by the provider from your stipend in one installment or six equal monthly installments and you shall not raise any dispute about it as mentioned above.</td></tr>
	<tr><td class="tjust">The training facilities will be liable to be  withdrawn  at  any time without any notice,and/or without assigning any reason for the same,during the above mentioned training period.</td></tr>
	<tr><td class="tjust">Your training programme will automatically cease at the end of the stipulated period and that  you would  be relieved of the training automatically.</td></tr>
	<tr><td class="tjust">Your training is also liable to  be  automatically  terminated on the day when our contract/agreement with ____________________________________ comes to an end before the date of completion of your training.</td></tr>
	<tr><td class="tjust">In case of any dispute concerning the terms and conditions of training,the Labour Court or the Industrial Court or the other courts,(including the Civil Court, the Revenue Tribunal)located at Pune will be treated as proper Legal Forum for the purpose of settling any dispute.</td></tr>
	
	<tr><td class="tjust">Please sign and return the duplicate copy of this letter and the enclosures as a token of your acceptance of the conditions  stipulated in the same.</td></tr>
	<tr><td>Yours faithfully,</td></tr>
	<tr><td>&nbsp;</td></tr>
	<tr><td>For <?php echo $compdetails['comp_name'];?></td></tr>	
	
		</table>
		</div>
	<?php } else{
		
		//////////////////////////////// type 3 format //////////////////////////////////
		?>
	<table width="100%" id="form3">
		
	<tr>
	
	<td align="right"   style="text-align:left">
	<div>&nbsp;</div>
	<div style="float:right">	
			<?php  if ($compdet==1){ echo $compdetails['comp_name']."<br>";	
		    echo "1117/5A, Off Ganeshkhind Road,<br>Pune 411 016<br>Tel. :25660360 / 25652095 Fax:25656144<br>E-mail:shaconpvt@gmail.com";}?>

	</td></tr>
			<tr>
			<td>Ref.No : </td>
			</tr>
			<tr>
			<td>To,</td>
			</tr>
			<tr>
			<td >  <br>
			<table style="width:50%"> 
			<tr><td></td></tr>
			</table>
		
		</td><td></td>
			<tr>
			<td>Sub :- Appointment As a Trainee </td>
			</tr>
			<tr>
			<td>&nbsp; &nbsp;  &nbsp;  &nbsp;   &nbsp; &nbsp;====================</td>
			</tr>
			<tr>
			<td class="tjust">Dear Sir,<br><br>With reference to your application dated --------------------- and the subsequent interview, we are pleased to offer you training facilities at the premises of --------------------------- for a period from----------- to -----------(both days inclusive).

			</td>
			</tr>
			<tr>
			<td style="text-align:right" class="tjust"><span style="float:left">During the training your monthly stipend shall be as follows :</span><br>
			<table style="width:50%; float:left">
			
			
			
			<tr>
				<td style="text-align:left">&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td><span style="float:left">Rs </span>---------</td>				
			</tr>
			<tr>
				<td style="text-align:left">&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td><span style="float:left">Rs </span>---------</td>				
			</tr>
			<tr>
				<td style="text-align:left">&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td><span style="float:left">Rs </span>---------</td>				
			</tr>
			<tr>
				<td style="text-align:left">&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td><span style="float:left">Rs </span>---------</td>				
			</tr>
			<tr>
				<td style="text-align:left">&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td><span style="float:left">Rs </span>---------</td>				
			</tr>
			<tr>
				<td style="text-align:left">&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td><span style="float:left">Rs </span>---------</td>				
			</tr>
		
			<tr><td style="text-align:left;">Total rupees per month</td><td style="border-top:1px dashed #000 !important; border-bottom:1px dashed #000 !important">&nbsp;&nbsp;&nbsp;</td></tr>			
			</table>           
			 </td>
			</tr>
			<tr><td colspan="2"><span style="float:left">(Rupees ---------------------------------------------------------)</span></td></tr>
			
			<tr><td class="tjust">All the payment to you will be made by a crossed cheque.</td></tr>
			<tr><td class="tjust">You will not be entitled to any other allowances or facilities which are given to the regular employees of the above mentioned company since you will not be an employee of the said company.</td></tr>
	<tr><td class="tjust">The model standing orders of the State Government shall be applicable to you.</td></tr>
	<tr><td class="tjust">During the training period you are liable to be transferred from one job to another, one section to another, from one department to another, from one unit to another located within the same premises/precincts, at the sole discretion of the company where you shall train.</td></tr>
	<tr><td class="tjust">The training facilities may be withdrawn at any time, without any notice or without assigning any reason, during the period of the training.</td></tr>
	<tr><td class="tjust">Your training programme shall automatically come to an end as per the date given herein above, and you shall be relieved immediately thereafter.</td></tr>
	<tr><td class="tjust">If the above mentioned company terminates our contract with them, prior to the date of termination of your training, your training will automatically come to an end, immediately at that time.</td></tr>
	
	
	<tr><td class="tjust">Please sign and return the duplicate copy of this letter and the enclosures as a token of your acceptance of the conditions stipulated herein above.</td></tr>
	<tr><td>Yours faithfully,</td></tr>
	<tr><td>&nbsp;</td></tr>
	<tr><td>For <?php echo $compdetails['comp_name'];?></td></tr>	
	
		</table>
	
	
	<?php }?>
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