<?php
include ('../../include_payroll_admin.php');
error_reporting(0);
$clientid= $_REQUEST['clientid'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];

$serchar =$_POST['serchar'];
$serchargesper=$_POST['serchar'];

$pfper = $_POST['pf'];
$esiper = $_POST['esi'];
$gstper = $_POST['gst']/2;

$invoiceno = $_POST['invoice'];

$otherpayment = $payrollAdmin->getOpdetails($clientid,$invoiceno);
$otherpayment12 = $payrollAdmin->getOpdetails($clientid,$invoiceno);
foreach($otherpayment12 as $oprows12)
{
	$optot += $oprows12['total'];
}

//$res=$payrollAdmin->showEmployeereport($comp_id,$user_id);
 $billdate =$payrollAdmin->getOpbildate($_POST['invoice']);
 $billdate = date("d-m-Y",strtotime($billdate));

$resclt=$payrollAdmin->displayClient($clientid);
$comapnydtl = $payrollAdmin->showCompdetailsById($comp_id);
$compbankdtl = $payrollAdmin->displayBank($comapnydtl['bank_id']);
	

$pf=0;
$esi=0;
/// for calculate esi
if ($esiper >0)
{
	$esi = round($optot*$esiper/100,0);
}

if ($pfper >0)
{
	$pf = round($optot*$pfper/100,0);
}
$servicecharge1 = round(($optot+$pf+$esi)*($serchargesper/100),0);
$servicecharge = $optot + $servicecharge1;//321.9;
$seramt = $optot+$pf+$esi;
$gstamt = $optot+$pf+$esi+$servicecharge1;
$sgstamount = round(($gstamt)*($gstper/100),0);
$cgstamount = round(($gstamt)*($gstper/100),0);

$_SESSION['client_name']=$resclt['client_name'];
$_SESSION['reporttitle']=strtoupper($reporttitle);
/************************************** for calculate nmber to words ****************************/
function makewords($numval)
{
    $moneystr = "";	
// handle the millions
    $milval = (integer)($numval / 10000000);
    if($milval > 0)
    {
        $moneystr = getwords($milval) . " CRORE ";
    }
	  $numval = $numval - ($milval * 10000000); // get rid of millions

	// handle the lakh
    $lacval = (integer)($numval / 100000);
/*    if($lacval > 0)
    {
        $moneystr = getwords($lacval) . " Lac ";
    }
*/
    if($lacval > 0)
    {
        $workword = getwords($lacval);
        if ($moneystr == "")
        {
            $moneystr = $workword . " Lac ";
        }
        else
        {
            $moneystr .= " " . $workword . " LAC ";
        }
    }
    $workval = $numval - ($lacval * 100000); // get rid of millions

// handle the thousands
    //$workval = $numval - ($milval * 100000); // get rid of millions
    $thouval = (integer)($workval / 1000);
    if($thouval > 0)
    {
        $workword = getwords($thouval);
        if ($moneystr == "")
        {
            $moneystr = $workword . " Thousand";
        }
        else
        {
            $moneystr .= " " . $workword . " Thousand";
        }
    }

// handle all the rest of the dollars
    $workval = $workval - ($thouval * 1000); // get rid of thousands
    $tensval = (integer)($workval);
    if ($moneystr == "")
    {
        if ($tensval > 0)
        {
            $moneystr = getwords($tensval);
        }
        else
        {
            $moneystr = "Zero";
        }
    }
    else // non zero values in hundreds and up
    {
        $workword = getwords($tensval);
        $moneystr .= " " . $workword;
    }

// done - let's get out of here!
    return $moneystr;
}
//*************************************************************
// this function creates word phrases in the range of 1 to 999.
// pass it an integer value
//*************************************************************
function getwords($workval)
{
    $numwords = array(
        1 => "One",
        2 => "Two",
        3 => "Three",
        4 => "Four",
        5 => "Five",
        6 => "Six",
        7 => "Seven",
        8 => "Eight",
        9 => "Nine",
        10 => "Ten",
        11 => "Eleven",
        12 => "Twelve",
        13 => "Thirteen",
        14 => "Fourteen",
        15 => "Fifteen",
        16 => "Sixteen",
        17 => "Seventeen",
        18 => "Eightteen",
        19 => "Nineteen",
        20 => "Twenty",
        30 => "Thirty",
        40 => "Forty",
        50 => "Fifty",
        60 => "Sixty",
        70 => "Seventy",
        80 => "Eighty",
        90 => "Ninety");

// handle the 100's
    $retstr = "";
    $hundval = (integer)($workval / 100);
    if ($hundval > 0)
    {
        $retstr = $numwords[$hundval] . " Hundred";
    }

// handle units and teens
    $workstr = "";
    $tensval = $workval - ($hundval * 100); // dump the 100's
    if (($tensval < 20) && ($tensval > 0))// do the teens
    {
        $workstr = $numwords[$tensval];
    }
    else // got to break out the units and tens
    {
        $tempval = ((integer)($tensval / 10)) * 10; // dump the units
        $workstr = $numwords[$tempval]; // get the tens
        $unitval = $tensval - $tempval; // get the unit value
        if ($unitval > 0)
        {
            $workstr .= " " . $numwords[$unitval];
        }
    }

// join all the parts together and leave
    if ($workstr != "")
    {
        if ($retstr != "")
        {
            $retstr .= " " . $workstr;
        }
        else
        {
            $retstr = $workstr;
        }
    }
    return $retstr;
}
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8"/>
    <title> &nbsp;</title>
    
    <style>
        .thheading{
            text-transform: uppercase;
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
            border: 1px solid black!important;
            font-size:16px !important;
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
.logo .head1{font-size:27px !important}

    </style>
</head>
<body>
<div class="btnprnt">
    <button class="submitbtn" onclick="myFunction()">Print</button>
    <button class="submitbtn"  onclick="history.go(-1);" >Cancel</button>
</div>
<!-- content starts -->
<div>
    <div class="row body" >
	<div  class="thheading" style="text-align:center">Tax Invoice</div>
	<div>&nbsp;</div>
        <table>
		
<tr>
<td width="50%" >
<div style="border-bottom:1px solid #000; margin-bottom:5px; padding-bottom:5px"><span class="thheading">
<?php echo $comapnydtl['comp_name'];?>
</span><?php if($comapnydtl['address'] !=""){ ?><br><?php echo $comapnydtl['address']; } if($comapnydtl['addr_1'] !=""){?><br><?php echo $comapnydtl['addr_1']; } if($comapnydtl['addr_2']!=""){?><br><?php echo $comapnydtl['addr_2']; }?><br>Maharashtra,    Code : 27<br>Tel. <?php echo $comapnydtl['tel']; ?><br>Email: <?php echo $comapnydtl['email']; ?><br>GSTIN :    <?php echo $comapnydtl['gstin']; ?></div>
		<div><span class="thheading">Buyer</span><br>
		<span class="thheading"><?php echo $resclt['client_name'];?></span><br>
		<?php echo $resclt['client_add1']; ?><br>
		Maharashtra, Code : 27<br>
		GSTIN : <?php echo $resclt['gstno']; ?><br></div>
</td>
<td width="50%" valign="top" class="bordpadd0">
<table style="border:0">
			<tr>
				<td class="thheading">Invoice No.</td>
				<td class="thheading">Date</td>
			</tr>
			<tr>
				<td><?php echo $_POST['invoice'];?></td>
				<td><?php echo date('d/m/Y',strtotime($billdate));?></td>
			</tr>
			</table>
			<?php if($clientid ==11){echo "<br>"."Original for Receipient";}?>
			
			<br><br><br>
            <div style="border-top: 1px solid #000;padding-top: 10px;">
                <span class="thheading">Description of service : <?=$service_desc;?></span>
                <br>
                SAC Code : 998519
                <br>
                Place of supply : PUNE
                <br>
                State Code : 27
                <br>
            </div>
			
</td>
</tr>
<tr>
		<td colspan="2" class="bordpadd0" >
		<div>
		
		<div> <?php  if ( date('Y',strtotime($monthtit)) >=2017){ echo "Being Service Rendered for ". date('F-Y',strtotime($monthtit)); }?></div>
		<div>&nbsp;</div>
		<table >
			<tr>
			<td class="thheading" align="center">SrNo</td>
			<td class="thheading" align="center">Particulars</td>
			<td class="thheading" align="center">HSN/SAC</td>
			<td class="thheading" align="center">Per</td>
			<td class="thheading" align="center">Rate</td>
			<td class="thheading" align="center">Amount</td>
			</tr>
			<?php
				$srno=1; 
				$stotal =0;
				foreach($otherpayment as $oprows)
				{
			?>
			<tr>
			<td align="center"><?php  echo $srno;$srno++; ?></td>
			<td><?php echo $oprows['name'];?></td>
			<td align="center">9985</td>
			<td align="right"></td>
			<td align="right"></td>
			<td align="right"><?php echo number_format($oprows['total'],2,'.',','); ?></td>
			</tr>
			<?php }
			if ($esi >0 ) { ?>
			<tr>
			<td align="center"><?php echo $srno;$srno++; ?></td>
			<td>E.S.I</td>
			<td align="center">9985</td>
			<td align="right"><?php echo number_format($optot,2,'.',',');?></td>
			<td align="right"><?php echo $esiper; //4.75?>%</td>
			<td align="right"><?php echo number_format($esi,2,'.',',');?></td>
			</tr>
			<?php } ?> 
			
			<?php  if ($pf >0 ) {  ?>
			
			<tr>
			<td align="center"><?php echo $srno;$srno++; ?></td>
			<td>P.F.</td>
			<td align="center">9985</td>
			<td align="right"><?php echo number_format($optot,2,'.',',');?></td>
			<td align="right"><?php echo $pfper; //13.15?>%</td>
			<td align="right"><?php echo number_format($pf,2,'.',',');?></td>
			</tr>
				<?php }  ?> 
			
			<!----- income and deduction rows end-->
			
			
			<?php if ($servicecharge1>0){?>
			<tr>
			<td align="center"><?php  echo $srno; $srno++; ?></td>
			<td>Service Charges</td>
			<td align="center">9985</td>
			<td align="right"><?php echo number_format(  $optot+$pf+$esi,2,'.',',');//$servicecharge; ?></td>
			<td align="right"><?php echo $serchargesper;?>%</td>
			<td align="right"><?php echo number_format($servicecharge1,2,'.',',');// $servicechargeamt;?></td>
			</tr><?php   }?>
			<tr>
			<td align="center"><?php  echo $srno; $srno++; ?></td>
			<td>SGST</td>
			<td align="center">9985</td>
			<td align="right"><?php echo number_format($gstamt,2,'.',',');?></td>
			<td align="right"><?php echo $gstper; //9?>%</td>
			<td align="right"><?php echo number_format($sgstamount,2,'.',',');?></td>
			</tr>
			<tr>
			<td align="center"><?php  echo $srno;$srno++; ?></td>
			<td>CGST</td>
			<td align="center"> 9985</td>
			<td align="right"><?php echo number_format($gstamt,2,'.',',');?></td>
			<td align="right"><?php echo $gstper; //9?>%</td>
			<td align="right"><?php echo number_format($sgstamount,2,'.',',');?></td>
			</tr>
			<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td align="right"><?php
			// $total=$laborwages+$esiamount+$pfamount+$servicecharge+($sgstamount*2)+$inc_amt1+$inc_amt2;
			 $total = $optot+$pf+$esi+$servicecharge1+$sgstamount+$cgstamount;
			echo number_format($total,2,'.',',')?> </td>
			</tr>
			
			
			<!-- <tr>
			<td  class="thheading" colspan="6">Amount Chargeable (in words) <br> (Indian Rupees  <?php echo       $stringmoney=makewords($total);  ?> Only ) </td>
			</tr> -->
		</table>
		Amount Chargeable (in words) <br> (Indian Rupees  <?php echo       $stringmoney=makewords($total);  ?> Only )
		</div>
		</td>
	</tr>
	<tr><td colspan="2" class="bordpadd0" >
	<table cellpadding="0" cellspacing="0" style = "border:none;">
	<tr>
			<td class="thheading" width="30%" align="center"> HSN/SAC</td>
			<td class="thheading" align="center" width="20%">Taxable value</td>
			<td class="thheading" colspan="2" align="center" width="25%">Central Tax</td>
			<td class="thheading" colspan="2" align="center" width="25%">State Tax</td>
			<td class="thheading" align="center" width="25%">Total Tax</td>
			
			</tr>
			<tr>
			<td > </td>
			<td ></td>
			<td width="12.5%" align="center">Rate</td>
			<td width="12.5%" align="right">Amount</td>
			<td width="12.5%" align="center">Rate</td>
			<td width="12.5%" align="right">Amount</td>
			<td width="12.5%" align="right">Amount</td>
			</tr>
			<tr>
			<td > 9985</td>
			<td  align="right"> <?php echo number_format($gstamt,2,'.',',');?></td>
			<td align="center"><?php echo $gstper; //9?>%</td>
			<td  align="right"> <?php echo number_format($sgstamount,2,'.',',');?> </td>
			<td align="center"><?php echo $gstper; //9?>%</td>
			<td  align="right"> <?php echo number_format($sgstamount,2,'.',',');?> </td>
			<td  align="right"> </td>
			</tr>
			<tr>
			<td > &nbsp; Total</td>
			<td  align="right"> <?php echo number_format($gstamt,2,'.',',');?></td>
			<td align="center"></td>
			<td  align="right"> <?php echo number_format($sgstamount,2,'.',',');?> </td>
			<td align="center"></td>
			<td  align="right"> <?php echo number_format($sgstamount,2,'.',',');?> </td>
			<td  align="right"> <?php echo number_format($sgstamount+$sgstamount,2,'.',',');?> </td>
			
			</tr>	
			<tr>
			<td  class="thheading" colspan="7">Tax Amount (in words)  : <br> (Indian Rupees <?php echo makewords($sgstamount*2); ?> ) </td>
			</tr>
			<tr>
			<td  class="thheading" colspan="6">Total Bill Amount </td><td align="right"><?php echo number_format($total,2,'.',',');?>
</td>
			</tr>
			
			
			
			
			
			<tr>
			
			<td colspan="2">
			<div>Bank Details</div>
				<div style="width:25%; float:left">Bank </div><div>:-  <?php echo $compbankdtl['bank_name']; ?></div>
				<div style="width:25%; float:left">Branch </div><div>:-  <?php echo $compbankdtl['branch']; ?></div>
				<div style="width:25%;  float:left">A/c No</div><div>:-  <?php echo $comapnydtl['bankacno']; ?></div>
				<div style="width:25%;  float:left">IFSC </div><div>:-  <?php echo $compbankdtl['ifsc_code']; ?></div>
				<div style="clear:both">&nbsp; </div>
			
			</td>
			<td colspan="2"></td>
			<td colspan="3" align="center" style="font-size:12px!important;" >For  <?php echo $comapnydtl['comp_name'];?> <br><br><br><br> Authorised Signatory</td>			
			</tr>
			<tr>
			<td colspan="7">			
			PAN NO.: <?php echo $comapnydtl['pan_no']; ?>
			</td>			
			</tr>
	</table>	
	</td></tr>
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