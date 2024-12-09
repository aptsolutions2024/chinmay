<?php
session_start();
include ('../../include_payroll_admin.php');

ini_set('output_buffering', true); // no limit

error_reporting(0);
$month=$_SESSION['month'];

//$name=$_REQUEST['name'];
$empid=$_REQUEST['empid'];
$frdt=$_REQUEST['frmd2'];
$todt=$_REQUEST['tod2'];
//$presentday=$_REQUEST['presentday'];

//$empdetails = $userObj->showEployeedetails($empid);


// print_r($_REQUEST);
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
//echo '11111';
$start    = (new DateTime($frdt))->modify('first day of this month');
$end      = (new DateTime($todt))->modify('first day of next month');
$interval = DateInterval::createFromDateString('1 month');
$period   = new DatePeriod($start, $interval, $end);
$gtallmonth =array();
//echo '2222';
foreach ($period as $dt) {
    //echo $dt->format("Y-m") . "<br>\n";
	$gtallmonth[] = $dt->format("Y-m");
}
 $cmonth = date('Y-m');
//print_r($gtallmonth);
if (in_array($cmonth, $gtallmonth)){
		$month ='current';
}else{$month ='lll';}
	//echo $month;

if($month=='current'){
	$tab_days='tran_days';
}else{
	$tab_days='hist_days';
 }

$date = str_replace('/', '-', $frdt);
$frdt1 = date('Y-m-d', strtotime($date));

$date = str_replace('/', '-', $todt);
$todt1 = date('Y-m-d', strtotime($date));

$rdcomp=$payrollAdmin->displayCompany($comp_id);
$compname=$rdcomp['comp_name'];

$empdetails = $payrollAdmin->showEployeedetails($empid);
//print_r($empdetails);
$client = $payrollAdmin->displayClient($empdetails['client_id']);

$resclt=$payrollAdmin->displayClient($client['mast_client_id']);
$cmonth=$resclt['current_month'];

if ($comp_id==1){
    //echo '2';
    $leavedetails = $payrollAdmin->checkEncashment($frdt1,$todt1,$empid,$empdetails['client_id'],'1');
}else
{
    //echo '1';
    $leavedetails = $payrollAdmin->checkEncashment($frdt1,$todt1,$empid,$empdetails['client_id'],'4');
}
//echo "<pre>";print_r($leavedetails);

if($year!=''){
    $reporttitle="Form 16 year- ".$year;
}

$name1=explode(" ",$name);

$_SESSION['client_name']=$name1[4].' '.$name1[5].' '.$name1[6];
$_SESSION['reporttitle']=strtoupper($reporttitle);

  $sqlfile1 ="SELECT year(sal_month) as year ,month(sal_month) as month FROM hist_days WHERE emp_id = '".$empid."' and sal_month between '".$frdt1."' and  '".$todt1."' UNION SELECT year(sal_month) as year ,month(sal_month) as month FROM tran_days WHERE emp_id = '".$empid."' and sal_month between '".$frdt1."' and  '".$todt1."' group by month(sal_month) order by year, month";
$resfile1 = $payrollAdmin->executeQuery($sqlfile1);
?>


<!DOCTYPE html>

<html lang="en-US">
<head>
    <meta charset="utf-8"/>
    <title> &nbsp;</title>
    <!-- Included CSS Files -->
    <link rel="stylesheet" href="../css/responsive.css">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .thheading{
            text-transform: uppercase;
            font-weight: bold;
            background-color: #fff;
        }
        .heading{
            margin: 20px 20px;
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
			margin-left : 12px;
			margin-lright : 10px;
            width: 98%;
			padding : 7px;
        }

        table, td, th {
            padding: 7px!important;
            border: 1px dotted black!important;
            font-size:13px !important;
            font-family: monospace;
        }
		.innertable{padding:0 !important;margin:0; }
		.innertable1 table {margin:0; padding:0 !important; width: 100%;}
		.innertable table td{padding:0 !important;margin:0 !important; }
		ol{ list-style: lower-roman;}
		div,li{list-style: lower-roman;font-size:14px !important;
            font-family: monospace;}
			div{padding:5px}
		.innertable{float:right;width: 80%; margin-top:5px}
		.bord0{border:0 !important;}
		.alcenter{text-align:center}
		.spanbr {border-bottom:1px dotted #000;     clear: both;}
		.bordr {border-right:1px dotted #000;}
		.paddtb5px{padding-top:5px; padding-bottom:5px}
		.diw50per{width:50%; display:inline}
		.padd0{padd0}
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
                display:block!important;
            }
            #footer {
                display:none!important;
            }
            .body { padding: 10px; }
            body{
                margin-left: 50px;
				margin-top :50px;
            }
        }
		@page {
   
				margin: 27mm 16mm 27mm 16mm;
			}


        @media all {
			 
           #watermark {
                display: none;
                float: right;
            }

            .pagebreak {
                display: none;
				margin-top :50px;
            }

            #header, #footer {
                display:none!important;
                margin-left: 50px;
				margin-top :10px;

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



<?php 


if($empdetails['leftdate'] !="0000-00-00"){
	$leftdate = date('d M Y',strtotime($empdetails['leftdate']));
}
 $joindate = date('d M Y',strtotime($empdetails['joindate']));

$tablehtml='
<div>
<div> </div>';
/* from 16 part a */
$tablehtmlparta.='
	<table style="width:99%">
	<tr>
	<td>'.$compname.'</td>
	<td class="alcenter thheading" colspan="2">LEAVE WITH WAGES REGISTER <br> FORM NO. 20 (Rule 105)</td>
	<td>DISCHARGE WORKER</td>
	</tr>
	<tr>
	<td>Name Of Worker: <b>'.$empdetails['first_name'].' '.$empdetails['middle_name'].'  '.$empdetails['last_name'].'</b></td>
	<td class="" colspan="2">Father\'s Name: <b>'.$empdetails['middle_name'].'  '.$empdetails['last_name'].'</b></td>
	<td>Date Of Leaving: '.$leftdate.'</td>
	</tr>
	<tr>
	<td colspan="4">Ticket No.  &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;Occupation: &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; Date and amount of payment mode: &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; Date: &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; Payment:</td>
	</tr>
	<tr>
	<td colspan="3">Name Of the factory: <b>'.$client['client_name'].'</b>&nbsp; &nbsp; Address : <b>'.$client['client_add1'].'</b></td>
	<td class=" thheading" colspan="1">Department:'.$empdetails['department'].'</td>
	</tr>
	<tr>
	<td colspan="4" class="innertable1" style="padding:0 !important">
		<table cellspacing="0" cellpadding="0">
		<tr>
			<td>Serial No: &nbsp; &nbsp; &nbsp; From Adult/children Worker Registered</td>
			<td >Date of entry into service:'.$joindate.' &nbsp; &nbsp; &nbsp; Remarks:</td>
		</tr>
		</table>
	</td>
	
	
	</tr>
	</table>	
        <table  style="width:99%">';
		

$tablehtmlparta.='<tr>';
$tablehtmlparta.='<td class="thheading" valign="top" colspan="2"></td>';
$tablehtmlparta.='<td class="thheading" valign="top" colspan="5">No of days works during this calender year</td>';
$tablehtmlparta.='<td class="thheading" valign="top" colspan="3">Leave with wages to creadit</td>';
$tablehtmlparta.='<td class="thheading" valign="top" colspan="2">&nbsp;</td>';
$tablehtmlparta.='<td class="thheading" valign="top" colspan="2">Leave&nbsp;with&nbsp;wages enjoyed</td>';
$tablehtmlparta.='<td class="thheading" valign="top" colspan="4">&nbsp;</td>';
$tablehtmlparta.='</tr>';

$tablehtmlparta.='<tr>';
$tablehtmlparta.='<td class="thheading" align="center" valign="top">Year</td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top">Month</td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top">No. of days worked performed</td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top">No. of days of lay off</td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top">No. of days of maternity leave with wages</td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top">No. of days leave with wages enjoyed</td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top">Total</td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top">Balance of leave with wages from preciding year</td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top">leave with wages earned during this year</td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top">Total</td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top">whether leave with wages refused</td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top">whether leave with wages not desired during the next calender year</td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top">From</td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top">To</td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top">Balance to creadit</td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top">Normal rate of wages</td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top">Cash eqivalent or advantage acuring through concessional sale of footgrains or other articles</td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top">Rate of wages for leave wages period</td>';
$tablehtmlparta.='</tr>';
foreach($resfile1 as $rowfile1){
$monname = date("M", mktime(0, 0, 0, $rowfile1["month"], 10));
if (date("m",strtotime($cmonth))==$rowfile1['month'] && date("Y",strtotime($cmonth))==$rowfile1['year']){
	  $sql2 ="select sum(pl) as tleave, sum(present+sl+additional) as present from tran_days where month(sal_month)=".$rowfile1['month']." and year(sal_month)=".$rowfile1['year']." and emp_id =".$empid;
 }else{
    $sql2 ="select sum(pl) as tleave, sum(present+sl+additional) as present from hist_days where month(sal_month)=".$rowfile1['month']." and year(sal_month)=".$rowfile1['year']." and emp_id =".$empid;
 }
// echo $sql2;
$res2 = $payrollAdmin->executeQuery($sql2);
//$row2 = mysql_fetch_object($res2);
$cnt = 0;
$cnt=count($res2);

if ($cnt== 0){
    $sql2 ="select sum(pl) as tleave, sum(present+sl+additional) as present from tran_days where month(sal_month)=".$rowfile1['month']." and year(sal_month)=".$rowfile1['year']." and emp_id =".$empid;
    $res2 = $payrollAdmin->executeQuery($sql2);
}
if(count($res2)>0){
    $res2 = $res2[0];
}
$tleave = $res2['present'] + $res2['tleave'];
$totpre += $res2['present'];
$totleave += $res2['tleave'];
$tablehtmlparta.='<tr>';
$tablehtmlparta.='<td class="thheading" align="center" valign="top">'.$rowfile1['year'].'</td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top">'.$monname.'</td>';
$tablehtmlparta.='<td align="center"  valign="top">'.$res2['present'].'</td>';

$tablehtmlparta.='<td align="center"  valign="top"></td>';
$tablehtmlparta.='<td align="center"  valign="top"></td>';
$tablehtmlparta.='<td align="center"  valign="top">'.$res2['tleave'].'</td>';
$tablehtmlparta.='<td align="center"  valign="top">'.$tleave.'</td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top"></td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top"></td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top"></td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top"></td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top"></td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top"></td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top"></td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top"></td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top"></td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top"></td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top"></td>';

$tablehtmlparta.='</tr>';
}
$sqlemp ="select * from hist_employee where emp_id='".$empid."'"; 
//and leftdate!='0000-00-00'";
$resemp =$payrollAdmin->executeQuery($sqlemp);

$tot = $totpre + $totleave;
$remleave =$tot/$presentday;
if($remleave > 12){$remleave = 23;}
$reml = $remleave-$presentday;
$remainingd = $leavedetails['earned'] - $totleave;

$cashor =0;
//$nettot = $cashor*
$gtotoal= $remainingd*$leavedetails['rate'];
$tablehtmlparta.='<tr>';
$tablehtmlparta.='<td class="thheading" align="center" valign="top">Total</td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top"></td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top">'.$totpre.'</td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top"></td>';

$tablehtmlparta.='<td class="thheading" align="center"  valign="top"></td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top">'.number_format($totleave,2,".",",") .'</td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top">'.$tot.'</td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top">'.$leavedetails['ob'].'</td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top">'.$leavedetails['earned'].'</td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top"></td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top"></td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top" colspan="3">Payable leave days:</td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top" >'.$leavedetails['balanced'].'</td>';

$tablehtmlparta.='<td class="thheading" align="center"  valign="top">Rate</td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top">'.$leavedetails['rate'].'</td>';

$tablehtmlparta.='<td class="thheading" align="center"  valign="top">'.$leavedetails['amount'].'</td>';
$tablehtmlparta.='</tr>';
$tablehtmlparta.='<tr>';
$tablehtmlparta.='<td colspan="17" align="right" class="thheading">NET ENCASHMENT</td>';
$tablehtmlparta.='<td class="thheading" align="center"  valign="top">'.$leavedetails['amount'].'</td>';
$tablehtmlparta.='</tr>';
$tablehtmlparta.='
</table>
';

$tablehtml3 .=$varification1.'</table>
    </div>
<br/><br/>
    </div>
        ';
$tablehtml2 .='
        ';
echo $allhtml = $tablehtmlparta.$tablehtml.$tablehtmlh1.$tablehtml1.$varification.$tablehtml2;

$compname='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size:30px;">'.strtoupper($rowcomp['comp_name']).'</span>  -  '. $reporttitle;
$compname1='<img src="http://localhost/images/JSM-logo1.jpg" align="absmiddle"> <span style="font-size:30px;">'.strtoupper($rowcomp['comp_name']).'</span>  -  '. $reporttitle;

?>
<script>
    function myFunction() {
        window.print();
    }
</script>
<?php
function rome($N){
    $c='IVXLCDM';
    for($a=5,$b=$s='';$N;$b++,$a^=7)
        for($o=$N%$a,$N=$N/$a^0;$o--;$s=$c[$o>2?$b+$N-($N&=-2)+$o=1:$b].$s);
    return $s;
}

/*
$pdf=new PDF_HTML_Table();
$pdf->AddPage();
$pdf->SetFont('Arial','',8);
$pdf->Image('http://localhost/images/JSM-logo.jpg',10,10,15);

$pdf->WriteHTML("<br><br>$compname<br>$tablehtml$tablehtmlh2.$tablehtml1.$tablehtml3<br><br>");
$temp=$name1[0]."-".$name1[1]."-".$name1[2];
$name='../pdffiles/Form16/'.$temp.'.pdf';
$pdf->Output($name,'F');
$docfilename='../docfiles/Form16/'.$temp.'.doc';
$myfile = fopen($docfilename, "w") or die("Unable to open file!");
fwrite($myfile, "$compname1<br>$tablehtml.$tablehtmlh1.$tablehtml1.$varification.$tablehtml2<br><br>");
fclose($myfile);*/

require_once '../dompdf/autoload.inc.php';
$html = file_get_contents($_SERVER['HTTP_REFERER']);
// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();

$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
//$dompdf->stream();

// Output the generated PDF (1 = download and 0 = preview)
$dompdf->stream("codex",array("Attachment"=>0)); 
//$stuff = ob_get_clean(); //ending

?>


<!-- content end -->


</body>
</html>