<?php
include ('../../include_payroll_admin.php');
error_reporting(0);
//echo "<pre>";print_r($_REQUEST);die;


$month=$_SESSION['month'];
$clientid=$_SESSION['clientid'];
$emp=$_REQUEST['emp'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];

$pfper = $_REQUEST['pf'];
$esiper = $_REQUEST['esi'];
$gstper = $_REQUEST['gst'];
$service_desc = $_REQUEST['service_desc'];


$res=$payrollAdmin->showEmployeereport($comp_id,$user_id);

$resclt=$payrollAdmin->displayClient($clientid);
$cmonth=$resclt['current_month'];
 $serchargesper=$resclt['ser_charges'];

//echo $serchargesper;
$comapnydtl = $payrollAdmin->showCompdetailsById($comp_id);

$compbankdtl = $payrollAdmin->displayBank($comapnydtl['bank_id']);

if($month=='current'){
	$monthtit =  date('F Y',strtotime($cmonth));
    $frdt=$cmonth;
    $todt=$cmonth;
    $tab_emp='tran_employee';
    $tab_empded='tran_deduct';
	$tab_empinc='tran_income';
    $esifrdt=$cmonth;
	$tab_days='tran_days';
    
 }
else{

    $monthtit =  date('F Y',strtotime($_SESSION['frdt']));
	$frdt=date("Y-m-d", strtotime($_SESSION['frdt']));
    $todt=date("Y-m-d", strtotime($_SESSION['frdt']));
    $tab_emp='hist_employee';
    $tab_empded='hist_deduct';
	$tab_empinc='hist_income';
	$tab_days='hist_days';

 }

	
	// canteen
$rowcanteen = $payrollAdmin->sqlcanteen($tab_empded,$tab_emp,$clientid,$frdt);
$canteen = round($rowcanteen['canteen']);

	// transport
$rowtransport = $payrollAdmin->sqltransport($tab_empded,$tab_emp,$clientid,$frdt);
$transport = round($rowtransport['trans']);


	// LWF
$rowlwf = $payrollAdmin->sqllwf($tab_empded,$tab_emp,$clientid,$frdt);
$lwf = round($rowlwf['lwfs']);

/// for calculate wages
$rowcontlabw = $payrollAdmin->sqlcontlabw($tab_emp,$clientid,$frdt);
$laborwages = round($rowcontlabw['gsal']);

/// for calculate esi
$rowesi = $payrollAdmin->sqlesi($tab_empded,$tab_emp,$clientid,$frdt);
$esi = round($rowesi['esi']);
if($esi ==""){ $esi=0;}

/// for calculate pf
$rowpf = $payrollAdmin->sqlpf($tab_empded,$tab_emp,$clientid,$frdt);
$pf = round($rowpf['pfsum']);
if($pf ==""){ $pf=0;}

/// for calculate overtime
$rowot = $payrollAdmin->sqlovertime($tab_empinc,$tab_emp,$clientid,$frdt);
$ot = round($rowot['ot']);
if($ot ==""){ $ot=0;}

// esi amount
$esiamount = $esi*$esiper/100; //4.75
$esiamount = round($esiamount);
// pf amount
$pfamount = $pf*$pfper/100; //13.5
$pfamount = round($pfamount);

$seramt = 0;















if ($lwf >0)

{
    $seramt=$seramt+$lwf;
}
//$perrate =$serchargesper/100; //10.5

if($clientid ==1 || $clientid ==6  )
	{ //lokmat
	$seramt= $seramt+$laborwages+$pfamount+$esiamount;
	
	
	
	}
else if($clientid ==2 || $clientid ==25 || $clientid ==26) { // l&t group 
		$seramt= $seramt+$laborwages+$pfamount+$esiamount;
}
	
else if($clientid ==3 || $clientid ==10 || $clientid ==5 || $clientid ==17 ||$clientid ==7 || $clientid ==8 || 			$clientid ==9||  $clientid ==23   || $clientid ==24  || $clientid ==4){
	// BAKER GAUGES, WIKAS PRINTING & CARRIERS,//SAKAL PAPERS LTD., NASHIK

		$seramt= $seramt+$laborwages;
	}
else if($clientid ==11){ //MAHINDRA TSUBAKI 
	$seramt = $seramt+$laborwages-$ot;
	
	}
else{
	$seramt= $seramt+$laborwages+$pf+$esi;
	// $service charge per
}


$servicecharge = ($seramt)*$serchargesper/100;
$servicecharge = round($servicecharge);


 $gstamt = $laborwages+$pfamount+$esiamount+$servicecharge+$lwf;

/// $service charge amount
$servicechargeamt =  $servicecharge*10.50/100;
$servicechargeamt = round($servicechargeamt);

$sgst = $servicecharge+$servicechargeamt;
$sgst = round($sgst);

// SGST/CGST per
$sgstamount = $gstamt *$gstper/100; //9
$sgstamount = round($sgstamount);

/// total
$total =$gstamt+$sgstamount+$sgstamount;
$total = round($total);
if($month!=''){
    $reporttitle="GST Statement FOR THE MONTH ".$monthtit;
}
$p='';
if($emp=='Parent'){
    $p="(P)";
}
$_SESSION['client_name']=$resclt['client_name'].$p;
$_SESSION['reporttitle']=strtoupper($reporttitle);

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
<!-- header starts -->
<!-- header end -->
<!-- content starts -->
<div>
<!--<div class="header_bg">
<?php
//include('printheader.php');
?>
</div>-->
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
				<td><?php echo $_REQUEST['invoice'];?></td>
				<td><?php echo date('d/m/Y',strtotime($_REQUEST['invdate']));?></td>
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
<!--<tr>
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
			<?php  $srno=0; if ($laborwages >0 ) {$srno++; ?>
			<tr>
			<td align="center"><?php  echo $srno; ?></td>
			<td>Contract Labour Wages</td>
			<td align="center">9985</td>
			<td align="right"></td>
			<td align="right"></td>
			<td align="right"><?php echo number_format($laborwages,2,'.',',');?></td>
			</tr>
			<?php } ?> 
			
			<?php  if ($esi >0 ) { $srno++;?>
			<tr>
			<td align="center"><?php echo $srno; ?></td>
			<td>E.S.I</td>
			<td align="center">9985</td>
			<td align="right"><?php echo number_format($esi,2,'.',',');?></td>
			<td align="right"><?php echo $esiper ; //4.75?>%</td>
			<td align="right"><?php echo number_format($esiamount,2,'.',',');?></td>
			</tr>
			<?php } ?> 
			
			<?php  if ($pf >0 ) { $srno++; ?>
			
			<tr>
			<td align="center"><?php echo $srno; ?></td>
			<td>P.F.</td>
			<td align="center">9985</td>
			<td align="right"><?php echo number_format($pf,2,'.',',');?></td>
			<td align="right"><?php echo $pfper; //13.15?>%</td>
			<td align="right"><?php echo number_format($pfamount,2,'.',',');?></td>
			</tr>
				<?php } ?> 
				
				
				
				
			<?php   if ($lwf >0 ) {$srno++; ?>
			<tr>
			<td align="center"><?php  echo $srno; ?></td>
			<td>L.W.F.</td>
			<td align="center">9985</td>
			<td align="right"></td>
			<td align="right"></td>
			<td align="right"><?php echo number_format($lwf,2,'.',',');?></td>
			</tr>
			<?php } ?> 
			
			
			<tr>
			<td align="center"><?php $srno++; echo $srno;  ?></td>
			<td>Service Charges</td>
			<td align="center">9985</td>
			<td align="right"><?php echo number_format($seramt,2,'.',',');//$servicecharge; ?></td>
			<td align="right"><?php echo $serchargesper;?>%</td>
			<td align="right"><?php echo number_format($servicecharge,2,'.',',');// $servicechargeamt;?></td>
			</tr>
			<tr>
			<td align="center"><?php $srno++; echo $srno;  ?></td>
			<td>SGST</td>
			<td align="center">9985</td>
			<td align="right"><?php echo number_format($gstamt,2,'.',',');?></td>
			<td align="right"><?php echo $gstper; //9?>%</td>
			<td align="right"><?php echo number_format($sgstamount,2,'.',',');?></td>
			</tr>
			<tr>
			<td align="center"><?php  $srno++; echo $srno; ?></td>
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
			<td align="right"><?php $total=$laborwages+$esiamount+$pfamount+$servicecharge+($sgstamount*2)+$lwf;
			echo number_format($total,2,'.',',')?> </td>
			</tr>
			
			
		
		</table>
		Amount Chargeable (in words) <br> (Indian Rupees  <?php echo       $stringmoney=makewords($total);  ?> Only )
		</div>
		</td>
	</tr>-->
	
	
	
	
	<tr>
		<td colspan="2" class="bordpadd0" >
		<div>
		
		<?php
		
		$PerValue=$esi+$pf+$seramt;
		 
		 $TotaltaxValue=$laborwages+$esiamount+$pfamount+$servicecharge;
		?>
		
		<table >
			<tr>
			<td class="thheading" align="center">SrNo</td>
			<td class="thheading" align="center" width="42.7%">Description</td>
			<td class="thheading" align="center" width="18%">Per</td>
			<td class="thheading" align="center" width="12%">Rate</td>
			<td class="thheading" align="center">Taxable Value</td>
			</tr>
		
			<tr>
			<td align="center">1</td>
			<td align="center" >
    Invoice for providing services for
    the month of July 2022 pursuant to
    the Services Agreement dated                                                                                                                                      
    (01/04/2021) entered into
    between you and us
			</td>
			<td align="right" ><?php echo number_format($PerValue,2,'.',',');?></td>
			<td align="right"><?=$esiper+$pfper+$serchargesper.'%';?></td>
			<td align="right"><?=number_format($TotaltaxValue,2,'.',',');?></td>
			</tr>
			<tr>
			<td align="center">2</td>
			<td align="center">
                SGST
			</td>
			<td align="right"><?php echo number_format($gstamt,2,'.',',');?></td>
			<td align="right"><?=$gstper.'%';?></td>
			<td align="right"><?php echo number_format($sgstamount,2,'.',',');?></td>
			</tr>
			<tr>
			<td align="center">3</td>
			<td align="center">
             CGST
			</td>
			<td align="right"><?php echo number_format($gstamt,2,'.',',');?></td>
			<td align="right"><?=$gstper.'%';?></td>
			<td align="right"><?php echo number_format($sgstamount,2,'.',',');?></td>
			</tr>
			<tr>
			<td align="right" colspan="4">Total</td>
			<td align="right"><?php $total=$laborwages+$esiamount+$pfamount+$servicecharge+($sgstamount*2)+$lwf;
			echo number_format($total,2,'.',',')?> </td>
			</tr>
			
		</table>
		 (Indian Rupees  <?php echo       $stringmoney=makewords($total);  ?> Only )
		</div>
		</td>
	</tr>
	
	
	
<tr >
<td width="50%" style="border-right: solid 1px #FFF !important;border-bottom: solid 1px #FFF !important;">
<br>
<?=$resclt['client_name'];?>
<br>
PAN NO. <?=$resclt['panno'];?>
</td>
<td width="50%" align="center" style="border-bottom: solid 1px #FFF !important;">
    <br>
For Khalipe Hopes Solutions Pvt Ltd.
 <br>
</td>

</tr>	
<tr >
<td width="50%" style="border-right: solid 1px #FFF !important;">
<br><br><br>
KHALIPE HOPES SOLUTIONS PVT LTD
<br>
PAN NO. AAGCK7001G
<br>
</td>
<td width="50%" align="center">
    <br><br><br><br><br>
Authorised Signatory
 <br><br>
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