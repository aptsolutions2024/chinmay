<?php
session_start();
error_reporting(E_ALL);
$client = $_REQUEST['client'];
$emp_id=$_REQUEST['employee'];

//print_r($_SESSION);

//print_r($_REQUEST);
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

$resclt=$payrollAdmin->displayClient($client);
$startyear = date('Y-m-d',strtotime($_SESSION['startbonusyear']));
$endyear = date('Y-m-d',strtotime($_SESSION['endbonusyear']));

//$row = $payrollAdmin->getEmployeeDetailsByClientId($client);
//$sql = "s
$days= 0;
$days = $_REQUEST['days'];

  
if ($days==0 && $_SESSION['days'] >0)
{ $days = $_SESSION['days'];}

if ($_REQUEST['employee']>0)
{
 //echo '1';
   // $row = $payrollAdmin->getemployeeBonusByClientByEmpId($client,$startyear,$endyear,$days,$emp_id);
    $rowhold = $payrollAdmin->getemployeeBonusByClientHoldEmpId($client,$startyear,$endyear,$days,$emp_id);
   // $rowless = $payrollAdmin->getemployeeBonusByClientlessdaysByEmpId($client,$startyear,$endyear,$days,$emp_id);
    
   // $rowholdtotal = $payrollAdmin->getemployeeBonusByClientHoldTotalByID($client,$startyear,$endyear,$days,$emp_id);
    //$rowholdtotal = mysql_fetch_array($rowholdtotal);

}
else
{

    $row = $payrollAdmin->getemployeeBonusByClient($client,$startyear,$endyear,$days);
  
    $rowhold = $payrollAdmin->getemployeeBonusByClientHold($client,$startyear,$endyear,$days);
    //$rowless = $payrollAdmin->getemployeeBonusByClientlessdays($client,$startyear,$endyear,$days);
  
    $rowholdtotal = $payrollAdmin->getemployeeBonusByClientHoldTotal($client,$startyear,$endyear,$days);
    
}

$explyr = explode('-',$startyear);
$yr = $explyr[0];
$yr = substr($yr,2,2);
 $reporttitle="Bonus For ".date('F Y',strtotime($_SESSION['startbonusyear']))." To ".date('F Y',strtotime($_SESSION['endbonusyear']));


$_SESSION['client_name']=$resclt['client_name'];
$_SESSION['reporttitle']=strtoupper($reporttitle);
?><!DOCTYPE html>

<html lang="en-US">
<head>
    <meta charset="utf-8"/>
    <title> &nbsp;</title>
    <!-- Included CSS Files -->
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
      
       table {
border-collapse: collapse;
/*width: 100%;*/
padding: 5px!important;
border:1px solid;
font-size:13px !important;
font-family: monospace;

}
        table, td, th {
            padding: 3px!important;
            border:1px solid;
            font-size:10px !important;
            font-family: monospace;
			text-align:right;
        }
		ol{ list-style: lower-roman;}
		div,li{list-style: lower-roman;font-size:13px !important;
            font-family: monospace;}
			div{padding:5px}
		.innertable{float:right;width: 80%; margin-top:5px}
		.bord0{border:0 !important;}
		.alcenter{text-align:center}
		.spanbr {border-bottom:1px solid #000;     clear: both;}
		.bordr {border-right:1px solid #000;}
		.paddtb5px{padding-top:5px; padding-bottom:5px}
		.diw50per{width:50%; display:inline}
		.padd0{padding:0 !important}
		span.heade.head1{font-size:27px !important}
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
            .body { padding: 5px; }
            body{
                margin-left: 10px;
            }
        .page-bk {
            position: relative;
            display: block;
            page-break-before: always;

            z-index: 0;
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
    <script>
    function myFunction() {
        window.print();
    }
</script>
	</head>
	
<body class="">
<div class="btnprnt">
    <button  onclick="myFunction()">Print</button>
    <button   onclick="history.go(-1);" >Cancel</button>
</div>

 <?php 
 //echo $_REQUEST['employee'];
 if($_REQUEST['employee']==''){ ?>
<div class="row body " style="margin-left: 10px;width: 1160px;">
<div class=" ">

<table width="100%" cellspacing="0" cellpadding="0">
<tr>
<!--<th width="2%">SNo</th> -->
<th width="2%">SR</th>
<th width="4%">Name</th>
<th colspan="14" class="padd0" width="83%">
<table width="100%" cellspacing="0" cellpadding="0">
<tr>
<th width="5%"></th>
<th width="6.4%">Apr <?php echo $yr; ?></th>
<th width="6.4%">May <?php echo $yr; ?></th>
<th width="6.4%">Jun <?php echo $yr; ?></th>
<th width="6.4%">Jul <?php echo $yr; ?></th>
<th width="6.4%">Aug <?php echo $yr; ?></th>
<th width="6.4%">Sep <?php echo $yr; ?></th>
<th width="6.4%">Oct <?php echo $yr; ?></th>
<th width="6.4%">Nov <?php echo $yr; ?></th>
<th width="6.4%">Dec <?php echo $yr; ?></th>
<th width="6.4%">Jan <?php echo $yr+1; ?></th>
<th width="6.4%">Feb <?php echo $yr+1; ?></th>
<th width="6.4%">Mar <?php echo $yr+1; ?></th>
<th width="12.4%" colspan="2">Total</th>
</tr>
</table></th>
</tr>
<?php $i=1; 

//wages by month
$yearwagtot=0; 
$aprwag=0;
$maywag=0;
$junwag=0;
$julwag=0;
$augwag=0;
$sepwag=0;
$octwag=0;
$novwag=0;
$decwag=0;
$janwag=0;
$febwag=0;
$marwag=0;

//bonus wages by month
$yearbonwag =0;
$aprbonwag=0;
$maybonwag=0;
$junbonwag=0;
$julbonwag=0;
$augbonwag=0;
$sepbonwag=0;
$octbonwag=0;
$novbonwag=0;
$decbonwag=0;
$janbonwag=0;
$febbonwag=0;
$marbonwag=0;

//Payable Days by month
$yearpayable_daystot =0;
$aprpayable_days=0;
$maypayable_days=0;
$junpayable_days=0;
$julpayable_days=0;
$augpayable_days=0;
$seppayable_days=0;
$octpayable_days=0;
$novpayable_days=0;
$decpayable_days=0;
$janpayable_days=0;
$febpayable_days=0;
$marpayable_days=0;

//Payable Days by month
$yearbonextot =0;
$aprbonex=0;
$maybonex=0;
$junbonex=0;
$julbonex=0;
$augbonex=0;
$sepbonex=0;
$octbonex=0;
$novbonex=0;
$decbonex=0;
$janbonex=0;
$febbonex=0;
$marbonex=0;

$i=1;
$page = 1;
$cnt=0;
//print_r($row);
//echo "employee count".count($row);

//echo '<pre>'.print_r($empbon);
foreach($row as $res){
    $bonusDetails = $payrollAdmin->getemployeeBonusById($res['emp_id'],$startyear,$endyear,$client);
	$cnt++;
	//echo "emp id : ".$res['emp_id'];
	if ($cnt>5){
		$page++;
		$cnt = 1;
	}
	if ($page>1 & $cnt==1)
	{ 
	    $nexty=$yr+1;
	 echo "</div><br>";
	  echo 	'<div class="page-bk ">';
	 
include('printheader3.php');

		echo '<table width="100%" cellspacing="0" cellpadding="0">
			<tr>
			<!--<th width="2%">SNo</th> -->
			<th width="2%">SR</th>
			<th width="4%">Name</th>
			<th colspan="14" class="padd0" width="83%">
			<table width="100%" cellspacing="0" cellpadding="0">
			<tr>
			<th width="5%"></th>
			<th width="6.4%">Apr '.$yr.'</th>
			<th width="6.4%">May '.$yr.'</th>
			<th width="6.4%">Jun '.$yr.'</th>
			<th width="6.4%">Jul '.$yr.'</th>
			<th width="6.4%">Aug '.$yr.'</th>
			<th width="6.4%">Sep '.$yr.'</th>
			<th width="6.4%">Oct '.$yr.'</th>
			<th width="6.4%">Nov '.$yr.'</th>
			<th width="6.4%">Dec '.$yr.'</th>
			<th width="6.4%">Jan '.$nexty.'</th>
			<th width="6.4%">Feb '.$nexty.'</th>
			<th width="6.4%">Mar '.$nexty.'</th>
			<th width="12.4%" colspan="2">Total</th>
			</tr>
			</table></th>
			</tr>';

		
	}
	?>
<tr>
<!--<td width="2%"><?php echo $i;?></td> -->
<td width="2%"><?php echo $i;?></td>
<td width="6%"> <b style="font-size: 13px;"><?php echo $res['first_name']." ".$res['middle_name']." ".$res['last_name']."(". $res['emp_id'].")";?></b></td>
<td colspan="15" class="padd0" width="80%">
<table width="100%" cellspacing="0" cellpadding="0">
<?php 


foreach($bonusDetails as $res1){

 ?>
 <tr>
<td width="5%" style="width:100px">S. Wages</td>
<td width="6.4%"><?php $aprwag = $res1['apr_wages']; echo number_format($aprwag, 2, '.', '');?></td>
<td width="6.4%"><?php  $maywag = $res1['may_wages']; echo number_format($maywag, 2, '.', '');?></td>
<td width="6.4%"><?php  $junwag = $res1['jun_wages']; echo number_format($junwag, 2, '.', '');?></td>
<td width="6.4%"><?php  $julwag = $res1['jul_wages']; echo number_format($julwag, 2, '.', '');?></td>
<td width="6.4%"><?php  $augwag = $res1['aug_wages']; echo number_format($augwag, 2, '.', '');?></td>
<td width="6.4%"><?php  $sepwag = $res1['sep_wages']; echo number_format($sepwag, 2, '.', '');?></td>
<td width="6.4%"><?php  $octwag = $res1['oct_wages']; echo number_format($octwag, 2, '.', '');?></td>
<td width="6.4%"><?php  $novwag = $res1['nov_wages']; echo number_format($novwag, 2, '.', '');?></td>
<td width="6.4%"><?php  $decwag = $res1['dec_wages']; echo number_format($decwag, 2, '.', '');?></td>
<td width="6.4%"><?php  $janwag = $res1['jan_wages']; echo number_format($janwag, 2, '.', '');?></td>
<td width="6.4%"><?php  $febwag = $res1['feb_wages']; echo number_format($febwag, 2, '.', '');?></td>
<td width="6.4%"><?php  $marwag = $res1['mar_wages']; echo number_format($marwag, 2, '.', '');?></td>
<td width="6.4%"><?php  echo $yearwag = $res1['apr_wages']+$res1['may_wages']+$res1['jun_wages']+$res1['jul_wages']+$res1['aug_wages']+$res1['sep_wages']+$res1['oct_wages']+$res1['nov_wages']+$res1['dec_wages']+$res1['jan_wages']+$res1['feb_wages']+$res1['mar_wages'];?></td>
<td width="6.4%"></td>

</tr>
 <tr>
<td width="5%">B. Wages</td>
<td width="6.4%"><?php 
$aprbonwag = $res1['apr_bonus_wages']; number_format($febwag, 2, '.', ''); if($aprbonwag==0){echo "00.00";}else{echo number_format($aprbonwag, 2, '.', '');}
//echo "April B.Wages-$aprbonwag****";
?></td>
<td width="6.4%"><?php  $maybonwag = $res1['may_bonus_wages']; echo  number_format($maybonwag, 2, '.', ''); ?></td>
<td width="6.4%"><?php  $junbonwag = $res1['jun_bonus_wages']; echo   number_format($junbonwag, 2, '.', ''); ?></td>
<td width="6.4%"><?php  $julbonwag = $res1['jul_bonus_wages']; echo   number_format($julbonwag, 2, '.', ''); ?></td>
<td width="6.4%"><?php  $augbonwag = $res1['aug_bonus_wages']; echo   number_format($augbonwag, 2, '.', ''); ?></td>
<td width="6.4%"><?php  $sepbonwag = $res1['sep_bonus_wages']; echo   number_format($sepbonwag, 2, '.', ''); ?></td>
<td width="6.4%"><?php  $octbonwag = $res1['oct_bonus_wages']; echo   number_format($octbonwag, 2, '.', ''); ?></td>
<td width="6.4%"><?php  $novbonwag = $res1['nov_bonus_wages']; echo   number_format($novbonwag, 2, '.', ''); ?></td>
<td width="6.4%"><?php  $decbonwag = $res1['dec_bonus_wages']; echo   number_format($decbonwag, 2, '.', ''); ?></td>
<td width="6.4%"><?php  $janbonwag = $res1['jan_bonus_wages']; echo   number_format($janbonwag, 2, '.', ''); ?></td>
<td width="6.4%"><?php  $febbonwag = $res1['feb_bonus_wages'];  echo  number_format($febbonwag, 2, '.', ''); ?></td>
<td width="6.4%"><?php  $marbonwag = $res1['mar_bonus_wages'];  echo  number_format($marbonwag, 2, '.', ''); ?></td>
<td width="6.4%"><?php echo $yearbonwag = $res1['apr_bonus_wages']+$res1['may_bonus_wages']+$res1['jun_bonus_wages']+$res1['jul_bonus_wages']+$res1['aug_bonus_wages']+$res1['sep_bonus_wages']+$res1['oct_bonus_wages']+$res1['nov_bonus_wages']+$res1['dec_bonus_wages']+$res1['jan_bonus_wages']+$res1['feb_bonus_wages']+$res1['mar_bonus_wages'];?></td>
<td width="6.4%">&nbsp;</td>

</tr>
 <tr>
<td width="5%">PayDays</td>
<td width="6.4%"><?php  $aprpayable_days = $res1['apr_payable_days']; echo  number_format($aprpayable_days, 2, '.', '');?></td>
<td width="6.4%"><?php  $maypayable_days = $res1['may_payable_days']; echo  number_format($maypayable_days, 2, '.', '');?></td>
<td width="6.4%"><?php  $junpayable_days = $res1['jun_payable_days']; echo  number_format($junpayable_days, 2, '.', '');?></td>
<td width="6.4%"><?php  $julpayable_days = $res1['jul_payable_days']; echo  number_format($julpayable_days, 2, '.', '');?></td>
<td width="6.4%"><?php  $augpayable_days = $res1['aug_payable_days']; echo  number_format($augpayable_days, 2, '.', '');?></td>
<td width="6.4%"><?php  $seppayable_days = $res1['sep_payable_days']; echo  number_format($seppayable_days, 2, '.', '');?></td>
<td width="6.4%"><?php  $octpayable_days = $res1['oct_payable_days']; echo  number_format($octpayable_days, 2, '.', '');?></td>
<td width="6.4%"><?php  $novpayable_days = $res1['nov_payable_days']; echo  number_format($novpayable_days, 2, '.', '');?></td>
<td width="6.4%"><?php  $decpayable_days = $res1['dec_payable_days']; echo  number_format($decpayable_days, 2, '.', '');?></td>
<td width="6.4%"><?php  $janpayable_days = $res1['jan_payable_days']; echo  number_format($janpayable_days, 2, '.', '');?></td>
<td width="6.4%"><?php  $febpayable_days = $res1['feb_payable_days']; echo  number_format($febpayable_days, 2, '.', '');?></td>
<td width="6.4%"><?php  $marpayable_days = $res1['mar_payable_days']; echo  number_format($marpayable_days, 2, '.', '');?></td>
<td width="6.4%"><?php echo $yearpayable_days = $res1['apr_payable_days']+$res1['may_payable_days']+$res1['jun_payable_days']+$res1['jul_payable_days']+$res1['aug_payable_days']+$res1['sep_payable_days']+$res1['oct_payable_days']+$res1['nov_payable_days']+$res1['dec_payable_days']+$res1['jan_payable_days']+$res1['feb_payable_days']+$res1['mar_payable_days'];?></td>
<td width="6.4%"></td>

</tr>
 <tr>
<td width="5%">Bonus+Ex</td>
<td width="6.4%"><?php $bonex11=0; 
						$aprbonex = $res1['apr_bonus_amt'] + $res1['apr_exgratia_amt']; 
						$aprbonus =$res1['apr_bonus_amt'] ;
						$aprexgra =$res1['apr_exgratia_amt'] ;
						
						//echo  number_format($aprbonex, 2, '.', '');
						$bonex11+=$aprbonex;
						echo  number_format($res1['apr_bonus_amt'], 2, '.', ''); 
						if ($res1['apr_exgratia_amt'] >0) {echo  "<br>".number_format($res1['apr_exgratia_amt'], 2, '.', ''); }
						?></td>
<td width="6.4%"><?php $maybonex = $res1['may_bonus_amt'] + $res1['may_exgratia_amt']; 
						echo  number_format($res1['may_bonus_amt'], 2, '.', ''); 
						
						if ($res1['may_exgratia_amt'] >0) {echo  "<br>".number_format($res1['may_exgratia_amt'], 2, '.', ''); }
						$bonex11+=$maybonex;
						$maybonus =$res1['may_bonus_amt'] ;
						$mayexgra =$res1['may_exgratia_amt'] ;
?></td>
<td width="6.4%"><?php $junbonex = $res1['jun_bonus_amt'] + $res1['jun_exgratia_amt']; 
						$bonex11+=$junbonex;
						$junbonus =$res1['jun_bonus_amt'] ;
						$junexgra =$res1['jun_exgratia_amt'] ;
						echo  number_format($res1['jun_bonus_amt'], 2, '.', ''); 
						if ($res1['jun_exgratia_amt'] >0) {echo  "<br>".number_format($res1['jun_exgratia_amt'], 2, '.', ''); }
						?></td>
<td width="6.4%"><?php $julbonex = $res1['jul_bonus_amt'] + $res1['jul_exgratia_amt'];
						$bonex11+=$julbonex;
						$julbonus =$res1['jul_bonus_amt'] ;
						$julexgra =$res1['jul_exgratia_amt'] ;

						echo  number_format($res1['jul_bonus_amt'], 2, '.', ''); 
						if ($res1['jul_exgratia_amt'] >0) {echo  "<br>".number_format($res1['jul_exgratia_amt'], 2, '.', ''); }
								
						?></td>
<td width="6.4%"><?php $augbonex = $res1['aug_bonus_amt'] + $res1['aug_exgratia_amt']; 
						$bonex11+=$augbonex;
						$augbonus =$res1['aug_bonus_amt'] ;
						$augexgra =$res1['aug_exgratia_amt'] ;
						
						echo  number_format($res1['aug_bonus_amt'], 2, '.', ''); 
						if ($res1['aug_exgratia_amt'] >0) {echo  "<br>".number_format($res1['aug_exgratia_amt'], 2, '.', ''); }?></td>
<td width="6.4%"><?php $sepbonex = $res1['sep_bonus_amt'] + $res1['sep_exgratia_amt'];	
						$bonex11+=$sepbonex;
						$sepbonus =$res1['sep_bonus_amt'] ;
						$sepexgra =$res1['sep_exgratia_amt'] ;
						
						echo  number_format($res1['sep_bonus_amt'], 2, '.', ''); 
						if ($res1['sep_exgratia_amt'] >0) {echo  "<br>".number_format($res1['sep_exgratia_amt'], 2, '.', ''); }?></td>
<td width="6.4%"><?php $octbonex = $res1['oct_bonus_amt'] + $res1['oct_exgratia_amt']; 
						$bonex11+=$octbonex;
						$octbonus =$res1['oct_bonus_amt'] ;
						$octexgra =$res1['oct_exgratia_amt'] ;
						
						echo  number_format($res1['oct_bonus_amt'], 2, '.', ''); 
						if ($res1['oct_exgratia_amt'] >0) {echo  "<br>".number_format($res1['oct_exgratia_amt'], 2, '.', ''); }?></td>
<td width="6.4%"><?php $novbonex = $res1['nov_bonus_amt'] + $res1['nov_exgratia_amt']; 
						$bonex11+=$novbonex;
						$novbonus =$res1['nov_bonus_amt'] ;
						$novexgra =$res1['nov_exgratia_amt'] ;
						
						echo  number_format($res1['nov_bonus_amt'], 2, '.', ''); 
						if ($res1['nov_exgratia_amt'] >0) {echo  "<br>".number_format($res1['nov_exgratia_amt'], 2, '.', ''); }?></td>
<td width="6.4%"><?php $decbonex = $res1['dec_bonus_amt'] + $res1['dec_exgratia_amt'];	
						$bonex11+=$decbonex;
						$decbonus =$res1['dec_bonus_amt'] ;
						$decexgra =$res1['dec_exgratia_amt'] ;
						
						echo  number_format($res1['dec_bonus_amt'], 2, '.', ''); 
						if ($res1['dec_exgratia_amt'] >0) {echo  "<br>".number_format($res1['dec_exgratia_amt'], 2, '.', ''); }?></td>
<td width="6.4%"><?php $janbonex = $res1['jan_bonus_amt'] + $res1['jan_exgratia_amt']; 
						$bonex11+=$janbonex;
						$janbonus =$res1['jan_bonus_amt'] ;
						$janexgra =$res1['jan_exgratia_amt'] ;
						
						echo  number_format($res1['jan_bonus_amt'], 2, '.', ''); 
						if ($res1['jan_exgratia_amt'] >0) {echo  "<br>".number_format($res1['jan_exgratia_amt'], 2, '.', ''); }?></td>
<td width="6.4%"><?php $febbonex = $res1['feb_bonus_amt'] + $res1['feb_exgratia_amt'];
						$bonex11+=$febbonex;
						$febbonus =$res1['feb_bonus_amt'] ;
						$febexgra =$res1['feb_exgratia_amt'] ;
						
						echo  number_format($res1['feb_bonus_amt'], 2, '.', ''); 
						if ($res1['feb_exgratia_amt'] >0) {echo  "<br>".number_format($res1['feb_exgratia_amt'], 2, '.', ''); }?></td>
<td width="6.4%"><?php $marbonex = $res1['mar_bonus_amt'] + $res1['mar_exgratia_amt'];
						$bonex11+=$marbonex;
						$marbonus =$res1['mar_bonus_amt'] ;
						$marexgra =$res1['mar_exgratia_amt'] ;
						
						echo  number_format($res1['mar_bonus_amt'], 2, '.', ''); 
						if ($res1['mar_exgratia_amt'] >0) {echo  "<br>".number_format($res1['mar_exgratia_amt'], 2, '.', ''); }?></td>
<td width="6.4%"><?php //echo round($bonex11);
//echo number_format(($res1['apr_bonus_amt']+$res1['may_bonus_amt']+$res1['jun_bonus_amt']+$res1['jul_bonus_amt']+$res1['aug_bonus_amt']+$res1['sep_bonus_amt']+$res1['oct_bonus_amt']+$res1['nov_bonus_amt']+$res1['dec_bonus_amt']+$res1['jan_bonus_amt']+$res1['feb_bonus_amt']+$res1['mar_bonus_amt']), 2, '.', '');
echo number_format(($res1['tot_bonus_amt']), 2, '.', '');

/*if ( ($res1['apr_exgratia_amt']+$res1['may_exgratia_amt']+$res1['jun_exgratia_amt']+$res1['jul_exgratia_amt']+$res1['aug_exgratia_amt']+$res1['sep_exgratia_amt']+$res1['oct_exgratia_amt']+$res1['nov_exgratia_amt']+$res1['dec_exgratia_amt']+$res1['jan_exgratia_amt']+$res1['feb_exgratia_amt']+$res1['mar_exgratia_amt'])>0)
{
		echo "<br>".number_format(($res1['apr_exgratia_amt']+$res1['may_exgratia_amt']+$res1['jun_exgratia_amt']+$res1['jul_exgratia_amt']+$res1['aug_exgratia_amt']+$res1['sep_exgratia_amt']+$res1['oct_exgratia_amt']+$res1['nov_exgratia_amt']+$res1['dec_exgratia_amt']+$res1['jan_exgratia_amt']+$res1['feb_exgratia_amt']+$res1['mar_exgratia_amt']), 2, '.', '');
	
}*/
if ( ($res1['tot_exgratia_amt'])>0)
{
		echo "<br>".number_format(($res1['tot_exgratia_amt']), 2, '.', '');
	
}
 ?></td>
 </td>
<td width="6.0%">
	<?php echo "<h6>".number_format(($res1['tot_exgratia_amt']+$res1['tot_bonus_amt']), 0, '.', '')."</h6>"; ?>
	
</td>
</tr>

<?php 
//wages by month
$aprwagtot += $aprwag;
$maywagtot += $maywag;
$junwagtot += $junwag;
$julwagtot += $julwag;
$augwagtot += $augwag;
$sepwagtot += $sepwag;
$octwagtot += $octwag;
$novwagtot += $novwag;
$decwagtot += $decwag;
$janwagtot += $janwag;
$febwagtot += $febwag;
$marwagtot += $marwag;

//bonus wages by month
//$aprbonwagtot += $aprbonwag;
//$maybonwagtot += $maybonwag;
//$junbonwagtot += $junbonwag;
//$julbonwagtot += $julbonwag;
//$a
} ?></td>

</tr>

<?php 

//bonus wages by month
$aprbonwagtot += $aprbonwag;
$maybonwagtot += $maybonwag;
$junbonwagtot += $junbonwag;
$julbonwagtot += $julbonwag;
$augbonwagtot += $augbonwag;
$sepbonwagtot += $sepbonwag;
$octbonwagtot += $octbonwag;
$novbonwagtot += $novbonwag;
$decbonwagtot += $decbonwag;
$janbonwagtot += $janbonwag;
$febbonwagtot += $febbonwag;
$marbonwagtot += $marbonwag;

//Payable Days by month
$aprpayable_daystot += $aprpayable_days;
$maypayable_daystot += $maypayable_days;
$junpayable_daystot += $junpayable_days;
$julpayable_daystot += $julpayable_days;
$augpayable_daystot += $augpayable_days;
$seppayable_daystot += $seppayable_days;
$octpayable_daystot += $octpayable_days;
$novpayable_daystot += $novpayable_days;
$decpayable_daystot += $decpayable_days;
$janpayable_daystot += $janpayable_days;
$febpayable_daystot += $febpayable_days;
$marpayable_daystot += $marpayable_days;

//Payable Days by month
$aprbonextot += $aprbonex;
$maybonextot += $maybonex;
$junbonextot += $junbonex;
$julbonextot += $julbonex;
$augbonextot += $augbonex;
$sepbonextot += $sepbonex;
$octbonextot += $octbonex;
$novbonextot += $novbonex;
$decbonextot += $decbonex;
$janbonextot += $janbonex;
$febbonextot += $febbonex;
$marbonextot += $marbonex;


$aprbonustot += $aprbonus;
$maybonustot += $maybonus;
$junbonustot += $junbonus;
$julbonustot += $julbonus;
$augbonustot += $augbonus;
$sepbonustot += $sepbonus;
$octbonustot += $octbonus;
$novbonustot += $novbonus;
$decbonustot += $decbonus;
$janbonustot += $janbonus;
$febbonustot += $febbonus;
$marbonustot += $marbonus;

$aprexgratot += $aprexgra;
$mayexgratot += $mayexgra;
$junexgratot += $junexgra;
$julexgratot += $julexgra;
$augexgratot += $augexgra;
$sepexgratot += $sepexgra;
$octexgratot += $octexgra;
$novexgratot += $novexgra;
$decexgratot += $decexgra;
$janexgratot += $janexgra;
$febexgratot += $febexgra;
$marexgratot += $marexgra;



?>

</table>
</td>
</tr>

<?php $i++;
} ?>

<?php 	echo "</div>";
	  echo 	'<div class="page-bk ">';
	 include('printheader3.php');
	  $nexty=$yr+1;
		echo '<table width="100%" cellspacing="0" cellpadding="0">
			<tr>
			<!--<th width="2%">SNo</th> -->
			<th width="2%">SR</th>
			<th width="4%">Name</th>
			<th colspan="14" class="padd0" width="83%">
			<table width="100%" cellspacing="0" cellpadding="0">
			<tr>
			<th width="6%"></th>
			<th width="6%">Apr '.$yr.'</th>
			<th width="6%">May '.$yr.'</th>
			<th width="6%">Jun '.$yr.'</th>
			<th width="6%">Jul '.$yr.'</th>
			<th width="6%">Aug '.$yr.'</th>
			<th width="6%">Sep '.$yr.'</th>
			<th width="6%">Oct '.$yr.'</th>
			<th width="6%">Nov '.$yr.'</th>
			<th width="6%">Dec '.$yr.'</th>
			<th width="6%">Jan '.$nexty.'</th>
			<th width="6%">Feb '.$nexty.'</th>
			<th width="6%">Mar '.$nexty.'</th>
			<th width="6%" >Total</th>
			</tr>
			</table></th>
			</tr>';
	?>
<tr>
<!--<td width="3%"></td> -->
<td width="2%"></td>
<td width="6%">Total</td>
<td colspan="15" class="padd0" width="83%">
<table width="100%" cellspacing="0" cellpadding="0">
<tr>
<td width="5%" style="width:100px">Wages</td>
<td width="6.5%"><?php  echo number_format($aprwagtot, 2, '.', '')?></td>
<td width="6.5%"><?php echo  number_format($maywagtot, 2, '.', '')?></td>
<td width="6.5%"><?php echo  number_format($junwagtot, 2, '.', '')?></td>
<td width="6.5%"><?php echo  number_format($julwagtot, 2, '.', '')?></td>
<td width="6.5%"><?php echo  number_format($augwagtot, 2, '.', '')?></td>
<td width="6.5%"><?php echo  number_format($sepwagtot, 2, '.', '')?></td>
<td width="6.5%"><?php echo  number_format($octwagtot, 2, '.', '')?></td>
<td width="6.5%"><?php echo  number_format($novwagtot, 2, '.', '')?></td>
<td width="6.5%"><?php echo  number_format($decwagtot, 2, '.', '')?></td>
<td width="6.5%"><?php echo  number_format($janwagtot, 2, '.', '')?></td>
<td width="6.5%"><?php echo  number_format($febwagtot, 2, '.', '')?></td>
<td width="6.5%"><?php echo  number_format($marwagtot, 2, '.', '')?></td>
<td width="6.5%"><?php echo $aprwagtot+$maywagtot+$junwagtot+$julwagtot+$augwagtot+$sepwagtot+$octwagtot+$novwagtot+$decwagtot+$janwagtot+$febwagtot+$marwagtot; ?></td>
<td width="6.5%"></td>
</tr>
<tr>
<td width="5%" style="width:100px">B.Wages</td>
<td width="6.5%"><?php echo  number_format($aprbonwagtot, 2, '.', '');?></td>
<td width="6.5%"><?php echo  number_format($maybonwagtot, 2, '.', '');?></td>
<td width="6.5%"><?php echo  number_format($junbonwagtot, 2, '.', '');?></td>
<td width="6.5%"><?php echo  number_format($julbonwagtot, 2, '.', '');?></td>
<td width="6.5%"><?php echo  number_format($augbonwagtot, 2, '.', '');?></td>
<td width="6.5%"><?php echo  number_format($sepbonwagtot, 2, '.', '');?></td>
<td width="6.5%"><?php echo  number_format($octbonwagtot, 2, '.', '');?></td>
<td width="6.5%"><?php echo  number_format($novbonwagtot, 2, '.', '');?></td>
<td width="6.5%"><?php echo  number_format($decbonwagtot, 2, '.', '');?></td>
<td width="6.5%"><?php echo  number_format($janbonwagtot, 2, '.', '');?></td>
<td width="6.5%"><?php echo  number_format($febbonwagtot, 2, '.', '');?></td>
<td width="6.5%"><?php echo  number_format($marbonwagtot, 2, '.', '');?></td>
<td width="6.5%"><?php echo $aprbonwagtot+$maybonwagtot+$junbonwagtot+$julbonwagtot+$augbonwagtot+$sepbonwagtot+$octbonwagtot+$novbonwagtot+$decbonwagtot+$janbonwagtot+$febbonwagtot+$marbonwagtot;?></td>
<td width="6.5%"></td>

</tr>
<tr>
<td width="5%">PayDays</td>
<td width="6.5%"><?php  echo  number_format($aprpayable_daystot, 2, '.', '');?></td>
<td width="6.5%"><?php  echo  number_format($maypayable_daystot, 2, '.', '');?></td>
<td width="6.5%"><?php  echo  number_format($junpayable_daystot, 2, '.', '');?></td>
<td width="6.5%"><?php  echo  number_format($julpayable_daystot, 2, '.', '');?></td>
<td width="6.5%"><?php  echo  number_format($augpayable_daystot, 2, '.', '');?></td>
<td width="6.5%"><?php  echo  number_format($seppayable_daystot, 2, '.', '');?></td>
<td width="6.5%"><?php  echo  number_format($octpayable_daystot, 2, '.', '');?></td>
<td width="6.5%"><?php  echo  number_format($novpayable_daystot, 2, '.', '');?></td>
<td width="6.5%"><?php  echo  number_format($decpayable_daystot, 2, '.', '');?></td>
<td width="6.5%"><?php  echo  number_format($janpayable_daystot, 2, '.', '');?></td>
<td width="6.5%"><?php  echo  number_format($febpayable_daystot, 2, '.', '');?></td>
<td width="6.5%"><?php echo  number_format($marpayable_daystot, 2, '.', '');?></td>
<td width="6.5%"><?php echo $aprpayable_daystot+$maypayable_daystot+$junpayable_daystot+$julpayable_daystot+$augpayable_daystot+$seppayable_daystot+$octpayable_daystot+$novpayable_daystot+$decpayable_daystot+$janpayable_daystot+$febpayable_daystot+$marpayable_daystot;?></td>
<td width="6.5%"></td>
</tr>
<tr>
<td width="5%">Bonus+Ex</td>
<td width="6.4%"><?php // echo round($aprbonextot);
						 echo round($aprbonustot);
							if ( $aprexgratot>0) {echo "<br>".round($aprexgratot);};

?></td>
<td width="6.4%"><?php //echo  round($maybonextot);
						 echo round($maybonustot);
							if ( $mayexgratot>0) {echo "<br>".round($mayexgratot);};
?></td>
<td width="6.4%"><?php  //echo round($junbonextot);
						 echo round($junbonustot);
							if ( $junexgratot>0) {echo "<br>".round($junexgratot);};
?></td>
<td width="6.4%"><?php  //echo round($julbonextot);
						 echo round($julbonustot);
							if ( $julexgratot>0) {echo "<br>".round($julexgratot);};
?></td>
<td width="6.4%"><?php  //echo round($augbonextot);
						 echo round($augbonustot);
							if ( $augexgratot>0) {echo "<br>".round($augexgratot);};
?></td>
<td width="6.4%"><?php  //echo round($sepbonextot);
						 echo round($sepbonustot);
							if ( $sepexgratot>0) {echo "<br>".round($sepexgratot);};
?></td>
<td width="6.4%"><?php  //echo round($octbonextot);
						 echo round($octbonustot);
							if ( $octexgratot>0) {echo "<br>".round($octexgratot);};
?></td>
<td width="6.4%"><?php // echo round($novbonextot);
						 echo round($novbonustot);
							if ( $novexgratot>0) {echo "<br>".round($novexgratot);};
?></td>
<td width="6.4%"><?php  //echo round($decbonextot);
						 echo round($decbonustot);
							if ( $decexgratot>0) {echo "<br>".round($decexgratot);};
?></td>
<td width="6.4%"><?php  //echo round($janbonextot);
						 echo round($janbonustot);
							if ( $janexgratot>0) {echo "<br>".round($janexgratot);};
?></td>
<td width="6.4%"><?php  //echo round($febbonextot);
						 echo round($febbonustot);
							if ( $febexgratot>0) {echo "<br>".round($febexgratot);};
?></td>
<td width="6.4%"><?php  //echo round($marbonextot);
						 echo round($marbonustot);
							if ( $marexgratot>0) {echo "<br>".round($marexgratot);};
?></td>
<td width="6.5%"><?php echo number_format(round($aprbonustot+$maybonustot+$junbonustot+$julbonustot+$augbonustot+$sepbonustot+$octbonustot+$novbonustot+$decbonustot+$janbonustot+$febbonustot+$marbonustot),0,".",",");
if ($aprexgratot+$mayexgratot+$junexgratot+$julexgratot+$augexgratot+$sepexgratot+$octexgratot+$novexgratot+$decexgratot+$janexgratot+$febexgratot+$marexgratot > 0) {echo "<br>".number_format(round($aprexgratot+$mayexgratot+$junexgratot+$julexgratot+$augexgratot+$sepexgratot+$octexgratot+$novexgratot+$decexgratot+$janexgratot+$febexgratot+$marexgratot ),0,".",",");}?>
</td>
<td width="6.5%">
<?php
// if ($aprexgratot+$mayexgratot+$junexgratot+$julexgratot+$augexgratot+$sepexgratot+$octexgratot+$novexgratot+$decexgratot+$janexgratot+$febexgratot+$marexgratot > 0) {
if ($_REQUEST['employee']>0)
{
    $row = $payrollAdmin->getTotBonusByClientByEmpId($client,$startyear,$endyear,$days,$emp_id);

}else{
   $row = $payrollAdmin->getTotBonusByClient($client,$startyear,$endyear,$days); 
}
$row1 = $payrollAdmin->executeQuery($row);

	//echo number_format(round($aprexgratot+$mayexgratot+$junexgratot+$julexgratot+$augexgratot+$sepexgratot+$octexgratot+$novexgratot+$decexgratot+$janexgratot+$febexgratot+$marexgratot+$aprbonustot+$maybonustot+$junbonustot+$julbonustot+$augbonustot+$sepbonustot+$octbonustot+$novbonustot+$decbonustot+$janbonustot+$febbonustot+$marbonustot) ,0,".",",");
	echo "<h6>".number_format(round($row1['amount']) ,0,".",",")."<h6>";
	
	
	?>

</td>
</tr>



</table>
</td>

</tr>
</table>
<br>
Total no of employees : <?php echo $i-1;?>
<br><br>
<?php } ?>
</div>
</div>

<!-- ********************************************   Hold ***************************-->


<div class="row body ">

<table width="100%" cellspacing="0" cellpadding="0">
<tr>
<!--<th width="2%">SNo</th> -->
<th width="2%">SR</th>
<th width="4%">Name</th>
<th colspan="14" class="padd0" width="83%">
<table width="100%" cellspacing="0" cellpadding="0">
<tr>
<th width="5%"></th>
<th width="6.4%">Apr <?php echo $yr; ?></th>
<th width="6.4%">May <?php echo $yr; ?></th>
<th width="6.4%">Jun <?php echo $yr; ?></th>
<th width="6.4%">Jul <?php echo $yr; ?></th>
<th width="6.4%">Aug <?php echo $yr; ?></th>
<th width="6.4%">Sep <?php echo $yr; ?></th>
<th width="6.4%">Oct <?php echo $yr; ?></th>
<th width="6.4%">Nov <?php echo $yr; ?></th>
<th width="6.4%">Dec <?php echo $yr; ?></th>
<th width="6.4%">Jan <?php echo $yr+1; ?></th>
<th width="6.4%">Feb <?php echo $yr+1; ?></th>
<th width="6.4%">Mar <?php echo $yr+1; ?></th>
<th width="12.4%" colspan="2">Total</th>
</tr>
</table></th>
</tr>
<?php $i=1; 

//wages by month
$yearwagtot=0; 
$aprwag=0;
$maywag=0;
$junwag=0;
$julwag=0;
$augwag=0;
$sepwag=0;
$octwag=0;
$novwag=0;
$decwag=0;
$janwag=0;
$febwag=0;
$marwag=0;

$aprwagtot=0;$maywagtot=0; $junwagtot=0;$julwagtot=0;$augwagtot =0;$sepwagtot=0;$octwagtot=0;$novwagtot=0;$decwagtot=0;$janwagtot=0;$febwagtot=0;$marwagtot=0;

$aprbonwagtot=0;$maybonwagtot=0;$junbonwagtot=0;$julbonwagtot=0;$augbonwagtot=0;$sepbonwagtot=0;$octbonwagtot=0;$novbonwagtot=0;$decbonwagtot=0;$janbonwagtot=0;$febbonwagtot=0;$marbonwagtot=0;

$aprpayable_daystot=0;$maypayable_daystot=0;$junpayable_daystot=0;$julpayable_daystot=0;$augpayable_daystot=0;$seppayable_daystot=0;$octpayable_daystot=0;$novpayable_daystot=0;$decpayable_daystot=0;$janpayable_daystot=0;$febpayable_daystot=0;$marpayable_daystot=0;

$aprbonustot=0;$maybonustot=0;$junbonustot=0;$julbonustot=0;$augbonustot=0;$sepbonustot=0;$octbonustot=0;$novbonustot=0;$decbonustot=0;$janbonustot=0;$febbonustot=0;$marbonustot=0;

$aprexgratot=0;$mayexgratot=0;$junexgratot=0;$julexgratot=0;$augexgratot=0;$sepexgratot=0;$octexgratot=0;$novexgratot=0;$decexgratot=0;$janexgratot=0;$febexgratot=0;$marexgratot =0;



//bonus wages by month
$yearbonwag =0;
$aprbonwag=0;
$maybonwag=0;
$junbonwag=0;
$julbonwag=0;
$augbonwag=0;
$sepbonwag=0;
$octbonwag=0;
$novbonwag=0;
$decbonwag=0;
$janbonwag=0;
$febbonwag=0;
$marbonwag=0;

//Payable Days by month
$yearpayable_daystot =0;
$aprpayable_days=0;
$maypayable_days=0;
$junpayable_days=0;
$julpayable_days=0;
$augpayable_days=0;
$seppayable_days=0;
$octpayable_days=0;
$novpayable_days=0;
$decpayable_days=0;
$janpayable_days=0;
$febpayable_days=0;
$marpayable_days=0;

//Payable Days by month
$yearbonextot =0;
$aprbonex=0;
$maybonex=0;
$junbonex=0;
$julbonex=0;
$augbonex=0;
$sepbonex=0;
$octbonex=0;
$novbonex=0;
$decbonex=0;
$janbonex=0;
$febbonex=0;
$marbonex=0;




$i=1;
$page = 1;
$cnt=0;
$reporttitle="";
 if($_REQUEST['employee']==''){ 
     $reporttitle=" Bonus For ".date('F Y',strtotime($_SESSION['startbonusyear']))." To ".date('F Y',strtotime($_SESSION['endbonusyear']))." -  Left List ";
 } 
$_SESSION['reporttitle']=strtoupper($reporttitle);
foreach ($rowhold as $res) {
	$cnt++;
	if ($cnt>7){
		$page++;
		$cnt = 1;
	}
	if ($page>1 & $cnt==1)
	{ echo "</div>";
	  echo 	'<div class="page-bk ">';
	  include('printheader3.php');
	  $nexty=$yr+1;
		echo '<table width="100%" cellspacing="0" cellpadding="0">
			<tr>
			<!--<th width="2%">SNo</th> -->
			<th width="2%">SR</th>
			<th width="4%">Name</th>
			<th colspan="14" class="padd0" width="83%">
			<table width="100%" cellspacing="0" cellpadding="0">
			<tr>
			<th width="5%"></th>
			<th width="6.4%">Apr $yr </th>
			<th width="6.4%">May $yr </th>
			<th width="6.4%">Jun '.$yr.'</th>
			<th width="6.4%">Jul '.$yr.'</th>
			<th width="6.4%">Aug '.$yr.'</th>
			<th width="6.4%">Sep '.$yr.'</th>
			<th width="6.4%">Oct '.$yr.'</th>
			<th width="6.4%">Nov '.$yr.'</th>
			<th width="6.4%">Dec '.$yr.'</th>
			<th width="6.4%">Jan '.$nexty.'</th>
			<th width="6.4%">Feb '.$nexty.'</th>
			<th width="6.4%">Mar '.$nexty.'</th>
			<th width="12.4%" colspan="2">Total</th>
			</tr>
			</table></th>
			</tr>';

		
	}
	?>
<tr>
<!--<td width="2%"><?php echo $i;?></td>-->
<td width="2%"><?php echo $i;?></td>
<td width="6%"> <?php echo $res['first_name']." ".$res['middle_name']." ".$res['last_name']."(". $res['emp_id'].")";?></td>
<td colspan="15" class="padd0" width="80%">
<table width="100%" cellspacing="0" cellpadding="0">
<?php 
$empbon = $payrollAdmin->getemployeeBonusById($res['emp_id'],$startyear,$endyear,$client);

foreach($empbon as $res1){	

 ?>
 <tr>
<td width="5%" style="width:100px">S. Wages</td>
<td width="6.4%"><?php $aprwag = $res1['apr_wages']; echo number_format($aprwag, 2, '.', '');?></td>
<td width="6.4%"><?php  $maywag = $res1['may_wages']; echo number_format($maywag, 2, '.', '');?></td>
<td width="6.4%"><?php  $junwag = $res1['jun_wages']; echo number_format($junwag, 2, '.', '');?></td>
<td width="6.4%"><?php  $julwag = $res1['jul_wages']; echo number_format($julwag, 2, '.', '');?></td>
<td width="6.4%"><?php  $augwag = $res1['aug_wages']; echo number_format($augwag, 2, '.', '');?></td>
<td width="6.4%"><?php  $sepwag = $res1['sep_wages']; echo number_format($sepwag, 2, '.', '');?></td>
<td width="6.4%"><?php  $octwag = $res1['oct_wages']; echo number_format($octwag, 2, '.', '');?></td>
<td width="6.4%"><?php  $novwag = $res1['nov_wages']; echo number_format($novwag, 2, '.', '');?></td>
<td width="6.4%"><?php  $decwag = $res1['dec_wages']; echo number_format($decwag, 2, '.', '');?></td>
<td width="6.4%"><?php  $janwag = $res1['jan_wages']; echo number_format($janwag, 2, '.', '');?></td>
<td width="6.4%"><?php  $febwag = $res1['feb_wages']; echo number_format($febwag, 2, '.', '');?></td>
<td width="6.4%"><?php  $marwag = $res1['mar_wages']; echo number_format($marwag, 2, '.', '');?></td>
<td width="6.4%"><?php  echo $yearwag = $res1['apr_wages']+$res1['may_wages']+$res1['jun_wages']+$res1['jul_wages']+$res1['aug_wages']+$res1['sep_wages']+$res1['oct_wages']+$res1['nov_wages']+$res1['dec_wages']+$res1['jan_wages']+$res1['feb_wages']+$res1['mar_wages'];?></td>
<td width="6.4%"></td>

</tr>
 <tr>
<td width="5%">B. Wages</td>
<td width="6.4%"><?php  $aprbonwag = $res1['apr_bonus_wages']; number_format($febwag, 2, '.', ''); if($aprbonwag==0){echo "00.00";}else{echo number_format($aprbonwag, 2, '.', '');}?></td>
<td width="6.4%"><?php  $maybonwag = $res1['may_bonus_wages']; echo  number_format($maybonwag, 2, '.', ''); ?></td>
<td width="6.4%"><?php  $junbonwag = $res1['jun_bonus_wages']; echo   number_format($junbonwag, 2, '.', ''); ?></td>
<td width="6.4%"><?php  $julbonwag = $res1['jul_bonus_wages']; echo   number_format($julbonwag, 2, '.', ''); ?></td>
<td width="6.4%"><?php  $augbonwag = $res1['aug_bonus_wages']; echo   number_format($augbonwag, 2, '.', ''); ?></td>
<td width="6.4%"><?php  $sepbonwag = $res1['sep_bonus_wages']; echo   number_format($sepbonwag, 2, '.', ''); ?></td>
<td width="6.4%"><?php  $octbonwag = $res1['oct_bonus_wages']; echo   number_format($octbonwag, 2, '.', ''); ?></td>
<td width="6.4%"><?php  $novbonwag = $res1['nov_bonus_wages']; echo   number_format($novbonwag, 2, '.', ''); ?></td>
<td width="6.4%"><?php  $decbonwag = $res1['dec_bonus_wages']; echo   number_format($decbonwag, 2, '.', ''); ?></td>
<td width="6.4%"><?php  $janbonwag = $res1['jan_bonus_wages']; echo   number_format($janbonwag, 2, '.', ''); ?></td>
<td width="6.4%"><?php  $febbonwag = $res1['feb_bonus_wages'];  echo  number_format($febbonwag, 2, '.', ''); ?></td>
<td width="6.4%"><?php  $marbonwag = $res1['mar_bonus_wages'];  echo  number_format($marbonwag, 2, '.', ''); ?></td>
<td width="6.4%"><?php echo $yearbonwag = $res1['apr_bonus_wages']+$res1['may_bonus_wages']+$res1['jun_bonus_wages']+$res1['jul_bonus_wages']+$res1['aug_bonus_wages']+$res1['sep_bonus_wages']+$res1['oct_bonus_wages']+$res1['nov_bonus_wages']+$res1['dec_bonus_wages']+$res1['jan_bonus_wages']+$res1['feb_bonus_wages']+$res1['mar_bonus_wages'];?></td>
<td width="6.4%">&nbsp;</td>

</tr>
 <tr>
<td width="5%">PayDays</td>
<td width="6.4%"><?php  $aprpayable_days = $res1['apr_payable_days']; echo  number_format($aprpayable_days, 2, '.', '');?></td>
<td width="6.4%"><?php  $maypayable_days = $res1['may_payable_days']; echo  number_format($maypayable_days, 2, '.', '');?></td>
<td width="6.4%"><?php  $junpayable_days = $res1['jun_payable_days']; echo  number_format($junpayable_days, 2, '.', '');?></td>
<td width="6.4%"><?php  $julpayable_days = $res1['jul_payable_days']; echo  number_format($julpayable_days, 2, '.', '');?></td>
<td width="6.4%"><?php  $augpayable_days = $res1['aug_payable_days']; echo  number_format($augpayable_days, 2, '.', '');?></td>
<td width="6.4%"><?php  $seppayable_days = $res1['sep_payable_days']; echo  number_format($seppayable_days, 2, '.', '');?></td>
<td width="6.4%"><?php  $octpayable_days = $res1['oct_payable_days']; echo  number_format($octpayable_days, 2, '.', '');?></td>
<td width="6.4%"><?php  $novpayable_days = $res1['nov_payable_days']; echo  number_format($novpayable_days, 2, '.', '');?></td>
<td width="6.4%"><?php  $decpayable_days = $res1['dec_payable_days']; echo  number_format($decpayable_days, 2, '.', '');?></td>
<td width="6.4%"><?php  $janpayable_days = $res1['jan_payable_days']; echo  number_format($janpayable_days, 2, '.', '');?></td>
<td width="6.4%"><?php  $febpayable_days = $res1['feb_payable_days']; echo  number_format($febpayable_days, 2, '.', '');?></td>
<td width="6.4%"><?php  $marpayable_days = $res1['mar_payable_days']; echo  number_format($marpayable_days, 2, '.', '');?></td>
<td width="6.4%"><?php echo $yearpayable_days = $res1['apr_payable_days']+$res1['may_payable_days']+$res1['jun_payable_days']+$res1['jul_payable_days']+$res1['aug_payable_days']+$res1['sep_payable_days']+$res1['oct_payable_days']+$res1['nov_payable_days']+$res1['dec_payable_days']+$res1['jan_payable_days']+$res1['feb_payable_days']+$res1['mar_payable_days'];?></td>
<td width="6.4%"></td>

</tr>
 <tr>
<td width="5%">Bonus+Ex</td>
<td width="6.4%"><?php $bonex11=0; 
						$aprbonex = $res1['apr_bonus_amt'] + $res1['apr_exgratia_amt']; 
						$aprbonus =$res1['apr_bonus_amt'] ;
						$aprexgra =$res1['apr_exgratia_amt'] ;
						
						//echo  number_format($aprbonex, 2, '.', '');
						$bonex11+=$aprbonex;
						echo  number_format($res1['apr_bonus_amt'], 2, '.', ''); 
						if ($res1['apr_exgratia_amt'] >0) {echo  "<br>".number_format($res1['apr_exgratia_amt'], 2, '.', ''); }
						?></td>
<td width="6.4%"><?php $maybonex = $res1['may_bonus_amt'] + $res1['may_exgratia_amt']; 
						echo  number_format($res1['may_bonus_amt'], 2, '.', ''); 
						
						if ($res1['may_exgratia_amt'] >0) {echo  "<br>".number_format($res1['may_exgratia_amt'], 2, '.', ''); }
						$bonex11+=$maybonex;
						$maybonus =$res1['may_bonus_amt'] ;
						$mayexgra =$res1['may_exgratia_amt'] ;
?></td>
<td width="6.4%"><?php $junbonex = $res1['jun_bonus_amt'] + $res1['jun_exgratia_amt']; 
						$bonex11+=$junbonex;
						$junbonus =$res1['jun_bonus_amt'] ;
						$junexgra =$res1['jun_exgratia_amt'] ;
						echo  number_format($res1['jun_bonus_amt'], 2, '.', ''); 
						if ($res1['jun_exgratia_amt'] >0) {echo  "<br>".number_format($res1['jun_exgratia_amt'], 2, '.', ''); }
						?></td>
<td width="6.4%"><?php $julbonex = $res1['jul_bonus_amt'] + $res1['jul_exgratia_amt'];
						$bonex11+=$julbonex;
						$julbonus =$res1['jul_bonus_amt'] ;
						$julexgra =$res1['jul_exgratia_amt'] ;

						echo  number_format($res1['jul_bonus_amt'], 2, '.', ''); 
						if ($res1['jul_exgratia_amt'] >0) {echo  "<br>".number_format($res1['jul_exgratia_amt'], 2, '.', ''); }
								
						?></td>
<td width="6.4%"><?php $augbonex = $res1['aug_bonus_amt'] + $res1['aug_exgratia_amt']; 
						$bonex11+=$augbonex;
						$augbonus =$res1['aug_bonus_amt'] ;
						$augexgra =$res1['aug_exgratia_amt'] ;
						
						echo  number_format($res1['aug_bonus_amt'], 2, '.', ''); 
						if ($res1['aug_exgratia_amt'] >0) {echo  "<br>".number_format($res1['aug_exgratia_amt'], 2, '.', ''); }?></td>
<td width="6.4%"><?php $sepbonex = $res1['sep_bonus_amt'] + $res1['sep_exgratia_amt'];	
						$bonex11+=$sepbonex;
						$sepbonus =$res1['sep_bonus_amt'] ;
						$sepexgra =$res1['sep_exgratia_amt'] ;
						
						echo  number_format($res1['sep_bonus_amt'], 2, '.', ''); 
						if ($res1['sep_exgratia_amt'] >0) {echo  "<br>".number_format($res1['sep_exgratia_amt'], 2, '.', ''); }?></td>
<td width="6.4%"><?php $octbonex = $res1['oct_bonus_amt'] + $res1['oct_exgratia_amt']; 
						$bonex11+=$octbonex;
						$octbonus =$res1['oct_bonus_amt'] ;
						$octexgra =$res1['oct_exgratia_amt'] ;
						
						echo  number_format($res1['oct_bonus_amt'], 2, '.', ''); 
						if ($res1['oct_exgratia_amt'] >0) {echo  "<br>".number_format($res1['oct_exgratia_amt'], 2, '.', ''); }?></td>
<td width="6.4%"><?php $novbonex = $res1['nov_bonus_amt'] + $res1['nov_exgratia_amt']; 
						$bonex11+=$novbonex;
						$novbonus =$res1['nov_bonus_amt'] ;
						$novexgra =$res1['nov_exgratia_amt'] ;
						
						echo  number_format($res1['nov_bonus_amt'], 2, '.', ''); 
						if ($res1['nov_exgratia_amt'] >0) {echo  "<br>".number_format($res1['nov_exgratia_amt'], 2, '.', ''); }?></td>
<td width="6.4%"><?php $decbonex = $res1['dec_bonus_amt'] + $res1['dec_exgratia_amt'];	
						$bonex11+=$decbonex;
						$decbonus =$res1['dec_bonus_amt'] ;
						$decexgra =$res1['dec_exgratia_amt'] ;
						
						echo  number_format($res1['dec_bonus_amt'], 2, '.', ''); 
						if ($res1['dec_exgratia_amt'] >0) {echo  "<br>".number_format($res1['dec_exgratia_amt'], 2, '.', ''); }?></td>
<td width="6.4%"><?php $janbonex = $res1['jan_bonus_amt'] + $res1['jan_exgratia_amt']; 
						$bonex11+=$janbonex;
						$janbonus =$res1['jan_bonus_amt'] ;
						$janexgra =$res1['jan_exgratia_amt'] ;
						
						echo  number_format($res1['jan_bonus_amt'], 2, '.', ''); 
						if ($res1['jan_exgratia_amt'] >0) {echo  "<br>".number_format($res1['jan_exgratia_amt'], 2, '.', ''); }?></td>
<td width="6.4%"><?php $febbonex = $res1['feb_bonus_amt'] + $res1['feb_exgratia_amt'];
						$bonex11+=$febbonex;
						$febbonus =$res1['feb_bonus_amt'] ;
						$febexgra =$res1['feb_exgratia_amt'] ;
						
						echo  number_format($res1['feb_bonus_amt'], 2, '.', ''); 
						if ($res1['feb_exgratia_amt'] >0) {echo  "<br>".number_format($res1['feb_exgratia_amt'], 2, '.', ''); }?></td>
<td width="6.4%"><?php $marbonex = $res1['mar_bonus_amt'] + $res1['mar_exgratia_amt'];
						$bonex11+=$marbonex;
						$marbonus =$res1['mar_bonus_amt'] ;
						$marexgra =$res1['mar_exgratia_amt'] ;
						
						echo  number_format($res1['mar_bonus_amt'], 2, '.', ''); 
						if ($res1['mar_exgratia_amt'] >0) {echo  "<br>".number_format($res1['mar_exgratia_amt'], 2, '.', ''); }?></td>
<td width="6.4%"><?php //echo round($bonex11);
//echo number_format(($res1['apr_bonus_amt']+$res1['may_bonus_amt']+$res1['jun_bonus_amt']+$res1['jul_bonus_amt']+$res1['aug_bonus_amt']+$res1['sep_bonus_amt']+$res1['oct_bonus_amt']+$res1['nov_bonus_amt']+$res1['dec_bonus_amt']+$res1['jan_bonus_amt']+$res1['feb_bonus_amt']+$res1['mar_bonus_amt']), 2, '.', '');
echo number_format(($res1['tot_bonus_amt']), 2, '.', '');

/*if ( ($res1['apr_exgratia_amt']+$res1['may_exgratia_amt']+$res1['jun_exgratia_amt']+$res1['jul_exgratia_amt']+$res1['aug_exgratia_amt']+$res1['sep_exgratia_amt']+$res1['oct_exgratia_amt']+$res1['nov_exgratia_amt']+$res1['dec_exgratia_amt']+$res1['jan_exgratia_amt']+$res1['feb_exgratia_amt']+$res1['mar_exgratia_amt'])>0)
{
		echo "<br>".number_format(($res1['apr_exgratia_amt']+$res1['may_exgratia_amt']+$res1['jun_exgratia_amt']+$res1['jul_exgratia_amt']+$res1['aug_exgratia_amt']+$res1['sep_exgratia_amt']+$res1['oct_exgratia_amt']+$res1['nov_exgratia_amt']+$res1['dec_exgratia_amt']+$res1['jan_exgratia_amt']+$res1['feb_exgratia_amt']+$res1['mar_exgratia_amt']), 2, '.', '');
	
}*/
if ( ($res1['tot_exgratia_amt'])>0)
{
		echo "<br>".number_format(($res1['tot_exgratia_amt']), 2, '.', '');
	
}
 ?></td>
 </td>
<td width="6.0%">
	<?php echo "<h6>".number_format(($res1['tot_exgratia_amt']+$res1['tot_bonus_amt']), 0, '.', '')."</h6>"; ?>
	
</td>
</tr>

<?php 
//wages by month
$aprwagtot += $aprwag;
$maywagtot += $maywag;
$junwagtot += $junwag;
$julwagtot += $julwag;
$augwagtot += $augwag;
$sepwagtot += $sepwag;
$octwagtot += $octwag;
$novwagtot += $novwag;
$decwagtot += $decwag;
$janwagtot += $janwag;
$febwagtot += $febwag;
$marwagtot += $marwag;


 ?></td>

</tr>

<?php 
//wages by month
$aprwagtot += $aprwag;
$maywagtot += $maywag;
$junwagtot += $junwag;
$julwagtot += $julwag;
$augwagtot += $augwag;
$sepwagtot += $sepwag;
$octwagtot += $octwag;
$novwagtot += $novwag;
$decwagtot += $decwag;
$janwagtot += $janwag;
$febwagtot += $febwag;
$marwagtot += $marwag;

//bonus wages by month
$aprbonwagtot += $aprbonwag;
$maybonwagtot += $maybonwag;
$junbonwagtot += $junbonwag;
$julbonwagtot += $julbonwag;
$augbonwagtot += $augbonwag;
$sepbonwagtot += $sepbonwag;
$octbonwagtot += $octbonwag;
$novbonwagtot += $novbonwag;
$decbonwagtot += $decbonwag;
$janbonwagtot += $janbonwag;
$febbonwagtot += $febbonwag;
$marbonwagtot += $marbonwag;

//Payable Days by month
$aprpayable_daystot += $aprpayable_days;
$maypayable_daystot += $maypayable_days;
$junpayable_daystot += $junpayable_days;
$julpayable_daystot += $julpayable_days;
$augpayable_daystot += $augpayable_days;
$seppayable_daystot += $seppayable_days;
$octpayable_daystot += $octpayable_days;
$novpayable_daystot += $novpayable_days;
$decpayable_daystot += $decpayable_days;
$janpayable_daystot += $janpayable_days;
$febpayable_daystot += $febpayable_days;
$marpayable_daystot += $marpayable_days;

//Payable Days by month
$aprbonextot += $aprbonex;
$maybonextot += $maybonex;
$junbonextot += $junbonex;
$julbonextot += $julbonex;
$augbonextot += $augbonex;
$sepbonextot += $sepbonex;
$octbonextot += $octbonex;
$novbonextot += $novbonex;
$decbonextot += $decbonex;
$janbonextot += $janbonex;
$febbonextot += $febbonex;
$marbonextot += $marbonex;


$aprbonustot += $aprbonus;
$maybonustot += $maybonus;
$junbonustot += $junbonus;
$julbonustot += $julbonus;
$augbonustot += $augbonus;
$sepbonustot += $sepbonus;
$octbonustot += $octbonus;
$novbonustot += $novbonus;
$decbonustot += $decbonus;
$janbonustot += $janbonus;
$febbonustot += $febbonus;
$marbonustot += $marbonus;

$aprexgratot += $aprexgra;
$mayexgratot += $mayexgra;
$junexgratot += $junexgra;
$julexgratot += $julexgra;
$augexgratot += $augexgra;
$sepexgratot += $sepexgra;
$octexgratot += $octexgra;
$novexgratot += $novexgra;
$decexgratot += $decexgra;
$janexgratot += $janexgra;
$febexgratot += $febexgra;
$marexgratot += $marexgra;



} ?>

</table>
</td>
</tr>

<?php $i++;} ?>



<?php
	  if($_REQUEST['employee']==''){ 
echo "</div>";


	  echo 	'<div class="page-bk ">';
	  }
	  include('printheader3.php');
	  if($_REQUEST['employee']==''){ 
	     $nexty=$yr+1;
		  echo '<table width="100%" cellspacing="0" cellpadding="0">
			<tr>
			<th width="2%">SR</th>
			<th width="4%">Name</th>
			<th colspan="14" class="padd0" width="83%">
			<table width="100%" cellspacing="0" cellpadding="0">
			<tr>
			<th width="5%"></th>
			<th width="6.4%">Apr '.$yr.'</th>
			<th width="6.4%">May '.$yr.'</th>
			<th width="6.4%">Jun '.$yr.'</th>
			<th width="6.4%">Jul '.$yr.'</th>
			<th width="6.4%">Aug '.$yr.'</th>
			<th width="6.4%">Sep '.$yr.'</th>
			<th width="6.4%">Oct '.$yr.'</th>
			<th width="6.4%">Nov '.$yr.'</th>
			<th width="6.4%">Dec '.$yr.'</th>
			<th width="6.4%">Jan '.$nexty.'</th>
			<th width="6.4%">Feb '.$nexty.'</th>
			<th width="6.4%">Mar '.$nexty.'</th>
			<th width="12.4%" colspan="2">Total</th>
			</tr>
			</table></th>
			</tr>';
	?>
	 
<tr>
  
<!--<td width="3%"></td> -->
<td width="2%"></td>
<td width="6%">Total</td>
<td colspan="15" class="padd0" width="83%">
<table width="100%" cellspacing="0" cellpadding="0">
<tr>
<td width="5%" style="width:100px">Wages</td>
<td width="6.5%"><?php  echo number_format($aprwagtot, 2, '.', '')?></td>
<td width="6.5%"><?php echo  number_format($maywagtot, 2, '.', '')?></td>
<td width="6.5%"><?php echo  number_format($junwagtot, 2, '.', '')?></td>
<td width="6.5%"><?php echo  number_format($julwagtot, 2, '.', '')?></td>
<td width="6.5%"><?php echo  number_format($augwagtot, 2, '.', '')?></td>
<td width="6.5%"><?php echo  number_format($sepwagtot, 2, '.', '')?></td>
<td width="6.5%"><?php echo  number_format($octwagtot, 2, '.', '')?></td>
<td width="6.5%"><?php echo  number_format($novwagtot, 2, '.', '')?></td>
<td width="6.5%"><?php echo  number_format($decwagtot, 2, '.', '')?></td>
<td width="6.5%"><?php echo  number_format($janwagtot, 2, '.', '')?></td>
<td width="6.5%"><?php echo  number_format($febwagtot, 2, '.', '')?></td>
<td width="6.5%"><?php echo  number_format($marwagtot, 2, '.', '')?></td>
<td width="6.5%"><?php echo $aprwagtot+$maywagtot+$junwagtot+$julwagtot+$augwagtot+$sepwagtot+$octwagtot+$novwagtot+$decwagtot+$janwagtot+$febwagtot+$marwagtot; ?></td>
<td width="6.5%"></td>
</tr>
<tr>
<td width="5%" style="width:100px">B.Wages</td>
<td width="6.5%"><?php echo  number_format($aprbonwagtot, 2, '.', '');?></td>
<td width="6.5%"><?php echo  number_format($maybonwagtot, 2, '.', '');?></td>
<td width="6.5%"><?php echo  number_format($junbonwagtot, 2, '.', '');?></td>
<td width="6.5%"><?php echo  number_format($julbonwagtot, 2, '.', '');?></td>
<td width="6.5%"><?php echo  number_format($augbonwagtot, 2, '.', '');?></td>
<td width="6.5%"><?php echo  number_format($sepbonwagtot, 2, '.', '');?></td>
<td width="6.5%"><?php echo  number_format($octbonwagtot, 2, '.', '');?></td>
<td width="6.5%"><?php echo  number_format($novbonwagtot, 2, '.', '');?></td>
<td width="6.5%"><?php echo  number_format($decbonwagtot, 2, '.', '');?></td>
<td width="6.5%"><?php echo  number_format($janbonwagtot, 2, '.', '');?></td>
<td width="6.5%"><?php echo  number_format($febbonwagtot, 2, '.', '');?></td>
<td width="6.5%"><?php echo  number_format($marbonwagtot, 2, '.', '');?></td>
<td width="6.5%"><?php echo $aprbonwagtot+$maybonwagtot+$junbonwagtot+$julbonwagtot+$augbonwagtot+$sepbonwagtot+$octbonwagtot+$novbonwagtot+$decbonwagtot+$janbonwagtot+$febbonwagtot+$marbonwagtot;?></td>
<td width="6.5%"></td>
</tr>
<tr>
<td width="5%">PayDays</td>
<td width="6.5%"><?php  echo  number_format($aprpayable_daystot, 2, '.', '');?></td>
<td width="6.5%"><?php  echo  number_format($maypayable_daystot, 2, '.', '');?></td>
<td width="6.5%"><?php  echo  number_format($junpayable_daystot, 2, '.', '');?></td>
<td width="6.5%"><?php  echo  number_format($julpayable_daystot, 2, '.', '');?></td>
<td width="6.5%"><?php  echo  number_format($augpayable_daystot, 2, '.', '');?></td>
<td width="6.5%"><?php  echo  number_format($seppayable_daystot, 2, '.', '');?></td>
<td width="6.5%"><?php  echo  number_format($octpayable_daystot, 2, '.', '');?></td>
<td width="6.5%"><?php  echo  number_format($novpayable_daystot, 2, '.', '');?></td>
<td width="6.5%"><?php  echo  number_format($decpayable_daystot, 2, '.', '');?></td>
<td width="6.5%"><?php  echo  number_format($janpayable_daystot, 2, '.', '');?></td>
<td width="6.5%"><?php  echo  number_format($febpayable_daystot, 2, '.', '');?></td>
<td width="6.5%"><?php echo  number_format($marpayable_daystot, 2, '.', '');?></td>
<td width="6.5%"><?php echo $aprpayable_daystot+$maypayable_daystot+$junpayable_daystot+$julpayable_daystot+$augpayable_daystot+$seppayable_daystot+$octpayable_daystot+$novpayable_daystot+$decpayable_daystot+$janpayable_daystot+$febpayable_daystot+$marpayable_daystot;?></td>
<td width="6.5%"></td>
</tr>
<tr>
<td width="5%">Bonus+Ex</td>
<td width="6.4%"><?php // echo round($aprbonextot);
						 echo round($aprbonustot);
							if ( $aprexgratot>0) {echo "<br>".round($aprexgratot);};

?></td>
<td width="6.4%"><?php //echo  round($maybonextot);
						 echo round($maybonustot);
							if ( $mayexgratot>0) {echo "<br>".round($mayexgratot);};
?></td>
<td width="6.4%"><?php  //echo round($junbonextot);
						 echo round($junbonustot);
							if ( $junexgratot>0) {echo "<br>".round($junexgratot);};
?></td>
<td width="6.4%"><?php  //echo round($julbonextot);
						 echo round($julbonustot);
							if ( $julexgratot>0) {echo "<br>".round($julexgratot);};
?></td>
<td width="6.4%"><?php  //echo round($augbonextot);
						 echo round($augbonustot);
							if ( $augexgratot>0) {echo "<br>".round($augexgratot);};
?></td>
<td width="6.4%"><?php  //echo round($sepbonextot);
						 echo round($sepbonustot);
							if ( $sepexgratot>0) {echo "<br>".round($sepexgratot);};
?></td>
<td width="6.4%"><?php  //echo round($octbonextot);
						 echo round($octbonustot);
							if ( $octexgratot>0) {echo "<br>".round($octexgratot);};
?></td>
<td width="6.4%"><?php // echo round($novbonextot);
						 echo round($novbonustot);
							if ( $novexgratot>0) {echo "<br>".round($novexgratot);};
?></td>
<td width="6.4%"><?php  //echo round($decbonextot);
						 echo round($decbonustot);
							if ( $decexgratot>0) {echo "<br>".round($decexgratot);};
?></td>
<td width="6.4%"><?php  //echo round($janbonextot);
						 echo round($janbonustot);
							if ( $janexgratot>0) {echo "<br>".round($janexgratot);};
?></td>
<td width="6.4%"><?php  //echo round($febbonextot);
						 echo round($febbonustot);
							if ( $febexgratot>0) {echo "<br>".round($febexgratot);};
?></td>
<td width="6.4%"><?php  //echo round($marbonextot);
						 echo round($marbonustot);
							if ( $marexgratot>0) {echo "<br>".round($marexgratot);};
?></td>
<td width="6.5%"><?php echo number_format(round($aprbonustot+$maybonustot+$junbonustot+$julbonustot+$augbonustot+$sepbonustot+$octbonustot+$novbonustot+$decbonustot+$janbonustot+$febbonustot+$marbonustot),0,".",",");
if ($aprexgratot+$mayexgratot+$junexgratot+$julexgratot+$augexgratot+$sepexgratot+$octexgratot+$novexgratot+$decexgratot+$janexgratot+$febexgratot+$marexgratot > 0) {echo "<br>".number_format(round($aprexgratot+$mayexgratot+$junexgratot+$julexgratot+$augexgratot+$sepexgratot+$octexgratot+$novexgratot+$decexgratot+$janexgratot+$febexgratot+$marexgratot ),0,".",",");}?>
</td>
<td width="6.5%">
<?php
// if ($aprexgratot+$mayexgratot+$junexgratot+$julexgratot+$augexgratot+$sepexgratot+$octexgratot+$novexgratot+$decexgratot+$janexgratot+$febexgratot+$marexgratot > 0) {
	


	echo "<h6>".$rowholdtotal['amount']."</h6>";

	
	//echo number_format(round($aprexgratot+$mayexgratot+$junexgratot+$julexgratot+$augexgratot+$sepexgratot+$octexgratot+$novexgratot+$decexgratot+$janexgratot+$febexgratot+$marexgratot+$aprbonustot+$maybonustot+$junbonustot+$julbonustot+$augbonustot+$sepbonustot+$octbonustot+$novbonustot+$decbonustot+$janbonustot+$febbonustot+$marbonustot) ,0,".",",");
	?>

</td>
</tr>



</table>
</td>

</tr>
<?php } ?>
</table>
 <?php if($_REQUEST['employee']==''){ ?>
<br>
Total no of employees : <?php echo $i-1;?>
<br><br>
</div>
<?php } ?>








<!-- ******************** Less than days  ********************************-->

<?php if($_REQUEST['employee']==''){ ?>
<div class="row body ">
<div class="page-bk ">

<table width="100%" cellspacing="0" cellpadding="0">
<tr>
<!--<th width="2%">SNo</th> -->
<th width="2%">SR</th>
<th width="4%">Name</th>
<th colspan="14" class="padd0" width="83%">
<table width="100%" cellspacing="0" cellpadding="0">
<tr>
<th width="5%"></th>
<th width="6.4%">Apr <?php echo $yr; ?></th>
<th width="6.4%">May <?php echo $yr; ?></th>
<th width="6.4%">Jun <?php echo $yr; ?></th>
<th width="6.4%">Jul <?php echo $yr; ?></th>
<th width="6.4%">Aug <?php echo $yr; ?></th>
<th width="6.4%">Sep <?php echo $yr; ?></th>
<th width="6.4%">Oct <?php echo $yr; ?></th>
<th width="6.4%">Nov <?php echo $yr; ?></th>
<th width="6.4%">Dec <?php echo $yr; ?></th>
<th width="6.4%">Jan <?php echo $yr+1; ?></th>
<th width="6.4%">Feb <?php echo $yr+1; ?></th>
<th width="6.4%">Mar <?php echo $yr+1; ?></th>
<th width="12.4%" colspan="2">Total</th>
</tr>
</table></th>
</tr>
<?php $i=1; 

//wages by month
$yearwagtot=0; 
$aprwag=0;
$maywag=0;
$junwag=0;
$julwag=0;
$augwag=0;
$sepwag=0;
$octwag=0;
$novwag=0;
$decwag=0;
$janwag=0;
$febwag=0;
$marwag=0;

//bonus wages by month
$yearbonwag =0;
$aprbonwag=0;
$maybonwag=0;
$junbonwag=0;
$julbonwag=0;
$augbonwag=0;
$sepbonwag=0;
$octbonwag=0;
$novbonwag=0;
$decbonwag=0;
$janbonwag=0;
$febbonwag=0;
$marbonwag=0;

//Payable Days by month
$yearpayable_daystot =0;
$aprpayable_days=0;
$maypayable_days=0;
$junpayable_days=0;
$julpayable_days=0;
$augpayable_days=0;
$seppayable_days=0;
$octpayable_days=0;
$novpayable_days=0;
$decpayable_days=0;
$janpayable_days=0;
$febpayable_days=0;
$marpayable_days=0;

//Payable Days by month
$yearbonextot =0;
$aprbonex=0;
$maybonex=0;
$junbonex=0;
$julbonex=0;
$augbonex=0;
$sepbonex=0;
$octbonex=0;
$novbonex=0;
$decbonex=0;
$janbonex=0;
$febbonex=0;
$marbonex=0;


$aprwagtot=0;$maywagtot=0; $junwagtot=0;$julwagtot=0;$augwagtot =0;$sepwagtot=0;$octwagtot=0;$novwagtot=0;$decwagtot=0;$janwagtot=0;$febwagtot=0;$marwagtot=0;

$aprbonwagtot=0;$maybonwagtot=0;$junbonwagtot=0;$julbonwagtot=0;$augbonwagtot=0;$sepbonwagtot=0;$octbonwagtot=0;$novbonwagtot=0;$decbonwagtot=0;$janbonwagtot=0;$febbonwagtot=0;$marbonwagtot=0;

$aprpayable_daystot=0;$maypayable_daystot=0;$junpayable_daystot=0;$julpayable_daystot=0;$augpayable_daystot=0;$seppayable_daystot=0;$octpayable_daystot=0;$novpayable_daystot=0;$decpayable_daystot=0;$janpayable_daystot=0;$febpayable_daystot=0;$marpayable_daystot=0;

$aprbonustot=0;$maybonustot=0;$junbonustot=0;$julbonustot=0;$augbonustot=0;$sepbonustot=0;$octbonustot=0;$novbonustot=0;$decbonustot=0;$janbonustot=0;$febbonustot=0;$marbonustot=0;

$aprexgratot=0;$mayexgratot=0;$junexgratot=0;$julexgratot=0;$augexgratot=0;$sepexgratot=0;$octexgratot=0;$novexgratot=0;$decexgratot=0;$janexgratot=0;$febexgratot=0;$marexgratot =0;



$i=1;
$page = 1;
$cnt=0;
$reporttitle="Bonus For ".date('F Y',strtotime($_SESSION['startbonusyear']))." To ".date('F Y',strtotime($_SESSION['endbonusyear'])). " ( LESS THAN :".$days." days )";
$_SESSION['reporttitle']=strtoupper($reporttitle);

while($res = mysql_fetch_array($rowless)){
	
	$cnt++;
	if ($cnt>7){
		$page++;
		$cnt = 1;
	}
	if ($page>1 & $cnt==1)
	{ echo "</div>";
	  echo 	'<div class="page-bk ">';
	  include('printheader3.php');
	  $nexty=$yr+1;
		echo '<table width="100%" cellspacing="0" cellpadding="0">
			<tr>
			<!--<th width="2%">SNo</th> -->
			<th width="2%">SR</th>
			<th width="4%">Name</th>
			<th colspan="14" class="padd0" width="83%">
			<table width="100%" cellspacing="0" cellpadding="0">
			<tr>
			<th width="5%"></th>
			<th width="6.4%">Apr '.$yr.'</th>
			<th width="6.4%">May '.$yr.'</th>
			<th width="6.4%">Jun '.$yr.'</th>
			<th width="6.4%">Jul '.$yr.'</th>
			<th width="6.4%">Aug '.$yr.'</th>
			<th width="6.4%">Sep '.$yr.'</th>
			<th width="6.4%">Oct '.$yr.'</th>
			<th width="6.4%">Nov '.$yr.'</th>
			<th width="6.4%">Dec '.$yr.'</th>
			<th width="6.4%">Jan '.$nexty.'</th>
			<th width="6.4%">Feb '.$nexty.'</th>
			<th width="6.4%">Mar '.$nexty.'</th>
			<th width="12.4%" colspan="2">Total</th>
			</tr>
			</table></th>
			</tr>';

		
	}
	?>
<tr>
<!--<td width="2%"><?php echo $i;?></td> -->
<td width="2%"><?php echo $i;;?></td>
<td width="6%"> <?php echo $res['first_name']." ".$res['middle_name']." ".$res['last_name'] ."(". $res['emp_id'].")";?></td>
<td colspan="15" class="padd0" width="80%">
<table width="100%" cellspacing="0" cellpadding="0">
<?php $empbon = $payrollAdmin->getemployeeBonusById($res['emp_id'],$startyear,$endyear,$client);

while($res1 = mysql_fetch_array($empbon)){	

 ?>
 <tr>
<td width="5%" style="width:100px">S. Wages</td>
<td width="6.4%"><?php $aprwag = $res1['apr_wages']; echo number_format($aprwag, 2, '.', '');?></td>
<td width="6.4%"><?php  $maywag = $res1['may_wages']; echo number_format($maywag, 2, '.', '');?></td>
<td width="6.4%"><?php  $junwag = $res1['jun_wages']; echo number_format($junwag, 2, '.', '');?></td>
<td width="6.4%"><?php  $julwag = $res1['jul_wages']; echo number_format($julwag, 2, '.', '');?></td>
<td width="6.4%"><?php  $augwag = $res1['aug_wages']; echo number_format($augwag, 2, '.', '');?></td>
<td width="6.4%"><?php  $sepwag = $res1['sep_wages']; echo number_format($sepwag, 2, '.', '');?></td>
<td width="6.4%"><?php  $octwag = $res1['oct_wages']; echo number_format($octwag, 2, '.', '');?></td>
<td width="6.4%"><?php  $novwag = $res1['nov_wages']; echo number_format($novwag, 2, '.', '');?></td>
<td width="6.4%"><?php  $decwag = $res1['dec_wages']; echo number_format($decwag, 2, '.', '');?></td>
<td width="6.4%"><?php  $janwag = $res1['jan_wages']; echo number_format($janwag, 2, '.', '');?></td>
<td width="6.4%"><?php  $febwag = $res1['feb_wages']; echo number_format($febwag, 2, '.', '');?></td>
<td width="6.4%"><?php  $marwag = $res1['mar_wages']; echo number_format($marwag, 2, '.', '');?></td>
<td width="6.4%"><?php  echo $yearwag = $res1['apr_wages']+$res1['may_wages']+$res1['jun_wages']+$res1['jul_wages']+$res1['aug_wages']+$res1['sep_wages']+$res1['oct_wages']+$res1['nov_wages']+$res1['dec_wages']+$res1['jan_wages']+$res1['feb_wages']+$res1['mar_wages'];?></td>
<td width="6.4%"></td>

</tr>
 <tr>
<td width="5%">B. Wages</td>
<td width="6.4%"><?php  $aprbonwag = $res1['apr_bonus_wages']; number_format($febwag, 2, '.', ''); if($aprbonwag==0 ){echo "00.00";}else{echo number_format($aprbonwag, 2, '.', '');}?></td>
<td width="6.4%"><?php  $maybonwag = $res1['may_bonus_wages']; echo  number_format($maybonwag, 2, '.', ''); ?></td>
<td width="6.4%"><?php  $junbonwag = $res1['jun_bonus_wages']; echo   number_format($junbonwag, 2, '.', ''); ?></td>
<td width="6.4%"><?php  $julbonwag = $res1['jul_bonus_wages']; echo   number_format($julbonwag, 2, '.', ''); ?></td>
<td width="6.4%"><?php  $augbonwag = $res1['aug_bonus_wages']; echo   number_format($augbonwag, 2, '.', ''); ?></td>
<td width="6.4%"><?php  $sepbonwag = $res1['sep_bonus_wages']; echo   number_format($sepbonwag, 2, '.', ''); ?></td>
<td width="6.4%"><?php  $octbonwag = $res1['oct_bonus_wages']; echo   number_format($octbonwag, 2, '.', ''); ?></td>
<td width="6.4%"><?php  $novbonwag = $res1['nov_bonus_wages']; echo   number_format($novbonwag, 2, '.', ''); ?></td>
<td width="6.4%"><?php  $decbonwag = $res1['dec_bonus_wages']; echo   number_format($decbonwag, 2, '.', ''); ?></td>
<td width="6.4%"><?php  $janbonwag = $res1['jan_bonus_wages']; echo   number_format($janbonwag, 2, '.', ''); ?></td>
<td width="6.4%"><?php  $febbonwag = $res1['feb_bonus_wages'];  echo  number_format($febbonwag, 2, '.', ''); ?></td>
<td width="6.4%"><?php  $marbonwag = $res1['mar_bonus_wages'];  echo  number_format($marbonwag, 2, '.', ''); ?></td>
<td width="6.4%"><?php echo $yearbonwag = $res1['apr_bonus_wages']+$res1['may_bonus_wages']+$res1['jun_bonus_wages']+$res1['jul_bonus_wages']+$res1['aug_bonus_wages']+$res1['sep_bonus_wages']+$res1['oct_bonus_wages']+$res1['nov_bonus_wages']+$res1['dec_bonus_wages']+$res1['jan_bonus_wages']+$res1['feb_bonus_wages']+$res1['mar_bonus_wages'];?></td>
<td width="6.4%">&nbsp;</td>

</tr>
 <tr>
<td width="5%">PayDays</td>
<td width="6.4%"><?php  $aprpayable_days = $res1['apr_payable_days']; echo  number_format($aprpayable_days, 2, '.', '');?></td>
<td width="6.4%"><?php  $maypayable_days = $res1['may_payable_days']; echo  number_format($maypayable_days, 2, '.', '');?></td>
<td width="6.4%"><?php  $junpayable_days = $res1['jun_payable_days']; echo  number_format($junpayable_days, 2, '.', '');?></td>
<td width="6.4%"><?php  $julpayable_days = $res1['jul_payable_days']; echo  number_format($julpayable_days, 2, '.', '');?></td>
<td width="6.4%"><?php  $augpayable_days = $res1['aug_payable_days']; echo  number_format($augpayable_days, 2, '.', '');?></td>
<td width="6.4%"><?php  $seppayable_days = $res1['sep_payable_days']; echo  number_format($seppayable_days, 2, '.', '');?></td>
<td width="6.4%"><?php  $octpayable_days = $res1['oct_payable_days']; echo  number_format($octpayable_days, 2, '.', '');?></td>
<td width="6.4%"><?php  $novpayable_days = $res1['nov_payable_days']; echo  number_format($novpayable_days, 2, '.', '');?></td>
<td width="6.4%"><?php  $decpayable_days = $res1['dec_payable_days']; echo  number_format($decpayable_days, 2, '.', '');?></td>
<td width="6.4%"><?php  $janpayable_days = $res1['jan_payable_days']; echo  number_format($janpayable_days, 2, '.', '');?></td>
<td width="6.4%"><?php  $febpayable_days = $res1['feb_payable_days']; echo  number_format($febpayable_days, 2, '.', '');?></td>
<td width="6.4%"><?php  $marpayable_days = $res1['mar_payable_days']; echo  number_format($marpayable_days, 2, '.', '');?></td>
<td width="6.4%"><?php echo $yearpayable_days = $res1['apr_payable_days']+$res1['may_payable_days']+$res1['jun_payable_days']+$res1['jul_payable_days']+$res1['aug_payable_days']+$res1['sep_payable_days']+$res1['oct_payable_days']+$res1['nov_payable_days']+$res1['dec_payable_days']+$res1['jan_payable_days']+$res1['feb_payable_days']+$res1['mar_payable_days'];?></td>
<td width="6.4%"></td>

</tr>
 <tr>
<td width="5%">Bonus+Ex</td>
<td width="6.4%"><?php $bonex11=0; 
						$aprbonex = $res1['apr_bonus_amt'] + $res1['apr_exgratia_amt']; 
						$aprbonus =$res1['apr_bonus_amt'] ;
						$aprexgra =$res1['apr_exgratia_amt'] ;
						
						//echo  number_format($aprbonex, 2, '.', '');
						$bonex11+=$aprbonex;
						echo  number_format($res1['apr_bonus_amt'], 2, '.', ''); 
						if ($res1['apr_exgratia_amt'] >0) {echo  "<br>".number_format($res1['apr_exgratia_amt'], 2, '.', ''); }
						?></td>
<td width="6.4%"><?php $maybonex = $res1['may_bonus_amt'] + $res1['may_exgratia_amt']; 
						echo  number_format($res1['may_bonus_amt'], 2, '.', ''); 
						
						if ($res1['may_exgratia_amt'] >0) {echo  "<br>".number_format($res1['may_exgratia_amt'], 2, '.', ''); }
						$bonex11+=$maybonex;
						$maybonus =$res1['may_bonus_amt'] ;
						$mayexgra =$res1['may_exgratia_amt'] ;
?></td>
<td width="6.4%"><?php $junbonex = $res1['jun_bonus_amt'] + $res1['jun_exgratia_amt']; 
						$bonex11+=$junbonex;
						$junbonus =$res1['jun_bonus_amt'] ;
						$junexgra =$res1['jun_exgratia_amt'] ;
						echo  number_format($res1['jun_bonus_amt'], 2, '.', ''); 
						if ($res1['jun_exgratia_amt'] >0) {echo  "<br>".number_format($res1['jun_exgratia_amt'], 2, '.', ''); }
						?></td>
<td width="6.4%"><?php $julbonex = $res1['jul_bonus_amt'] + $res1['jul_exgratia_amt'];
						$bonex11+=$julbonex;
						$julbonus =$res1['jul_bonus_amt'] ;
						$julexgra =$res1['jul_exgratia_amt'] ;

						echo  number_format($res1['jul_bonus_amt'], 2, '.', ''); 
						if ($res1['jul_exgratia_amt'] >0) {echo  "<br>".number_format($res1['jul_exgratia_amt'], 2, '.', ''); }
								
						?></td>
<td width="6.4%"><?php $augbonex = $res1['aug_bonus_amt'] + $res1['aug_exgratia_amt']; 
						$bonex11+=$augbonex;
						$augbonus =$res1['aug_bonus_amt'] ;
						$augexgra =$res1['aug_exgratia_amt'] ;
						
						echo  number_format($res1['aug_bonus_amt'], 2, '.', ''); 
						if ($res1['aug_exgratia_amt'] >0) {echo  "<br>".number_format($res1['aug_exgratia_amt'], 2, '.', ''); }?></td>
<td width="6.4%"><?php $sepbonex = $res1['sep_bonus_amt'] + $res1['sep_exgratia_amt'];	
						$bonex11+=$sepbonex;
						$sepbonus =$res1['sep_bonus_amt'] ;
						$sepexgra =$res1['sep_exgratia_amt'] ;
						
						echo  number_format($res1['sep_bonus_amt'], 2, '.', ''); 
						if ($res1['sep_exgratia_amt'] >0) {echo  "<br>".number_format($res1['sep_exgratia_amt'], 2, '.', ''); }?></td>
<td width="6.4%"><?php $octbonex = $res1['oct_bonus_amt'] + $res1['oct_exgratia_amt']; 
						$bonex11+=$octbonex;
						$octbonus =$res1['oct_bonus_amt'] ;
						$octexgra =$res1['oct_exgratia_amt'] ;
						
						echo  number_format($res1['oct_bonus_amt'], 2, '.', ''); 
						if ($res1['oct_exgratia_amt'] >0) {echo  "<br>".number_format($res1['oct_exgratia_amt'], 2, '.', ''); }?></td>
<td width="6.4%"><?php $novbonex = $res1['nov_bonus_amt'] + $res1['nov_exgratia_amt']; 
						$bonex11+=$novbonex;
						$novbonus =$res1['nov_bonus_amt'] ;
						$novexgra =$res1['nov_exgratia_amt'] ;
						
						echo  number_format($res1['nov_bonus_amt'], 2, '.', ''); 
						if ($res1['nov_exgratia_amt'] >0) {echo  "<br>".number_format($res1['nov_exgratia_amt'], 2, '.', ''); }?></td>
<td width="6.4%"><?php $decbonex = $res1['dec_bonus_amt'] + $res1['dec_exgratia_amt'];	
						$bonex11+=$decbonex;
						$decbonus =$res1['dec_bonus_amt'] ;
						$decexgra =$res1['dec_exgratia_amt'] ;
						
						echo  number_format($res1['dec_bonus_amt'], 2, '.', ''); 
						if ($res1['dec_exgratia_amt'] >0) {echo  "<br>".number_format($res1['dec_exgratia_amt'], 2, '.', ''); }?></td>
<td width="6.4%"><?php $janbonex = $res1['jan_bonus_amt'] + $res1['jan_exgratia_amt']; 
						$bonex11+=$janbonex;
						$janbonus =$res1['jan_bonus_amt'] ;
						$janexgra =$res1['jan_exgratia_amt'] ;
						
						echo  number_format($res1['jan_bonus_amt'], 2, '.', ''); 
						if ($res1['jan_exgratia_amt'] >0) {echo  "<br>".number_format($res1['jan_exgratia_amt'], 2, '.', ''); }?></td>
<td width="6.4%"><?php $febbonex = $res1['feb_bonus_amt'] + $res1['feb_exgratia_amt'];
						$bonex11+=$febbonex;
						$febbonus =$res1['feb_bonus_amt'] ;
						$febexgra =$res1['feb_exgratia_amt'] ;
						
						echo  number_format($res1['feb_bonus_amt'], 2, '.', ''); 
						if ($res1['feb_exgratia_amt'] >0) {echo  "<br>".number_format($res1['feb_exgratia_amt'], 2, '.', ''); }?></td>
<td width="6.4%"><?php $marbonex = $res1['mar_bonus_amt'] + $res1['mar_exgratia_amt'];
						$bonex11+=$marbonex;
						$marbonus =$res1['mar_bonus_amt'] ;
						$marexgra =$res1['mar_exgratia_amt'] ;
						
						echo  number_format($res1['mar_bonus_amt'], 2, '.', ''); 
						if ($res1['mar_exgratia_amt'] >0) {echo  "<br>".number_format($res1['mar_exgratia_amt'], 2, '.', ''); }?></td>
<td width="6.4%"><?php //echo round($bonex11);
//echo number_format(($res1['apr_bonus_amt']+$res1['may_bonus_amt']+$res1['jun_bonus_amt']+$res1['jul_bonus_amt']+$res1['aug_bonus_amt']+$res1['sep_bonus_amt']+$res1['oct_bonus_amt']+$res1['nov_bonus_amt']+$res1['dec_bonus_amt']+$res1['jan_bonus_amt']+$res1['feb_bonus_amt']+$res1['mar_bonus_amt']), 2, '.', '');
echo number_format(($res1['tot_bonus_amt']), 2, '.', '');

/*if ( ($res1['apr_exgratia_amt']+$res1['may_exgratia_amt']+$res1['jun_exgratia_amt']+$res1['jul_exgratia_amt']+$res1['aug_exgratia_amt']+$res1['sep_exgratia_amt']+$res1['oct_exgratia_amt']+$res1['nov_exgratia_amt']+$res1['dec_exgratia_amt']+$res1['jan_exgratia_amt']+$res1['feb_exgratia_amt']+$res1['mar_exgratia_amt'])>0)
{
		echo "<br>".number_format(($res1['apr_exgratia_amt']+$res1['may_exgratia_amt']+$res1['jun_exgratia_amt']+$res1['jul_exgratia_amt']+$res1['aug_exgratia_amt']+$res1['sep_exgratia_amt']+$res1['oct_exgratia_amt']+$res1['nov_exgratia_amt']+$res1['dec_exgratia_amt']+$res1['jan_exgratia_amt']+$res1['feb_exgratia_amt']+$res1['mar_exgratia_amt']), 2, '.', '');
	
}*/
if ( ($res1['tot_exgratia_amt'])>0)
{
		echo "<br>".number_format(($res1['tot_exgratia_amt']), 2, '.', '');
	
}
 ?></td>
 </td>
<td width="6.0%">
	<?php echo "<h6>".number_format(($res1['tot_exgratia_amt']+$res1['tot_bonus_amt']), 0, '.', '')."</h6>"; ?>
	
</td>
</tr>

<?php 
//wages by month
$aprwagtot += $aprwag;
$maywagtot += $maywag;
$junwagtot += $junwag;
$julwagtot += $julwag;
$augwagtot += $augwag;
$sepwagtot += $sepwag;
$octwagtot += $octwag;
$novwagtot += $novwag;
$decwagtot += $decwag;
$janwagtot += $janwag;
$febwagtot += $febwag;
$marwagtot += $marwag;

 ?></td>

</tr>

<?php 
//wages by month
$aprwagtot += $aprwag;
$maywagtot += $maywag;
$junwagtot += $junwag;
$julwagtot += $julwag;
$augwagtot += $augwag;
$sepwagtot += $sepwag;
$octwagtot += $octwag;
$novwagtot += $novwag;
$decwagtot += $decwag;
$janwagtot += $janwag;
$febwagtot += $febwag;
$marwagtot += $marwag;

//bonus wages by month
$aprbonwagtot += $aprbonwag;
$maybonwagtot += $maybonwag;
$junbonwagtot += $junbonwag;
$julbonwagtot += $julbonwag;
$augbonwagtot += $augbonwag;
$sepbonwagtot += $sepbonwag;
$octbonwagtot += $octbonwag;
$novbonwagtot += $novbonwag;
$decbonwagtot += $decbonwag;
$janbonwagtot += $janbonwag;
$febbonwagtot += $febbonwag;
$marbonwagtot += $marbonwag;

//Payable Days by month
$aprpayable_daystot += $aprpayable_days;
$maypayable_daystot += $maypayable_days;
$junpayable_daystot += $junpayable_days;
$julpayable_daystot += $julpayable_days;
$augpayable_daystot += $augpayable_days;
$seppayable_daystot += $seppayable_days;
$octpayable_daystot += $octpayable_days;
$novpayable_daystot += $novpayable_days;
$decpayable_daystot += $decpayable_days;
$janpayable_daystot += $janpayable_days;
$febpayable_daystot += $febpayable_days;
$marpayable_daystot += $marpayable_days;

//Payable Days by month
$aprbonextot += $aprbonex;
$maybonextot += $maybonex;
$junbonextot += $junbonex;
$julbonextot += $julbonex;
$augbonextot += $augbonex;
$sepbonextot += $sepbonex;
$octbonextot += $octbonex;
$novbonextot += $novbonex;
$decbonextot += $decbonex;
$janbonextot += $janbonex;
$febbonextot += $febbonex;
$marbonextot += $marbonex;


$aprbonustot += $aprbonus;
$maybonustot += $maybonus;
$junbonustot += $junbonus;
$julbonustot += $julbonus;
$augbonustot += $augbonus;
$sepbonustot += $sepbonus;
$octbonustot += $octbonus;
$novbonustot += $novbonus;
$decbonustot += $decbonus;
$janbonustot += $janbonus;
$febbonustot += $febbonus;
$marbonustot += $marbonus;

$aprexgratot += $aprexgra;
$mayexgratot += $mayexgra;
$junexgratot += $junexgra;
$julexgratot += $julexgra;
$augexgratot += $augexgra;
$sepexgratot += $sepexgra;
$octexgratot += $octexgra;
$novexgratot += $novexgra;
$decexgratot += $decexgra;
$janexgratot += $janexgra;
$febexgratot += $febexgra;
$marexgratot += $marexgra;


} ?>

</table>
</td>
</tr>
<?php $i++;} ?>
<?php 
      echo "</div>";
	  echo 	'<div class="page-bk ">';
	  include('printheader3.php');
	  $nexty=$yr+1;
		echo '<table width="100%" cellspacing="0" cellpadding="0">
			<tr>
			<!--<th width="2%">SNo</th> -->
			<th width="2%">SR</th>
			<th width="4%">Name</th>
			<th colspan="14" class="padd0" width="83%">
			<table width="100%" cellspacing="0" cellpadding="0">
			<tr>
			<th width="5%"></th>
			<th width="6.4%">Apr '.$yr.'</th>
			<th width="6.4%">May '.$yr.'</th>
			<th width="6.4%">Jun '.$yr.'</th>
			<th width="6.4%">Jul '.$yr.'</th>
			<th width="6.4%">Aug '.$yr.'</th>
			<th width="6.4%">Sep '.$yr.'</th>
			<th width="6.4%">Oct '.$yr.'</th>
			<th width="6.4%">Nov '.$yr.'</th>
			<th width="6.4%">Dec '.$yr.'</th>
			<th width="6.4%">Jan '.$nexty.'</th>
			<th width="6.4%">Feb '.$nexty.'</th>
			<th width="6.4%">Mar '.$nexty.'</th>
			<th width="12.4%" colspan="2">Total</th>
			</tr>
			</table></th>
			</tr>';

		
	
	?>


<tr>
<!--<td width="3%"></td> -->
<td width="2%"></td>
<td width="6%">Total</td>
<td colspan="15" class="padd0" width="83%">
<table width="100%" cellspacing="0" cellpadding="0">
<tr>
<td width="5%" style="width:100px">Wages</td>
<td width="6.5%"><?php  echo number_format($aprwagtot, 2, '.', '')?></td>
<td width="6.5%"><?php echo  number_format($maywagtot, 2, '.', '')?></td>
<td width="6.5%"><?php echo  number_format($junwagtot, 2, '.', '')?></td>
<td width="6.5%"><?php echo  number_format($julwagtot, 2, '.', '')?></td>
<td width="6.5%"><?php echo  number_format($augwagtot, 2, '.', '')?></td>
<td width="6.5%"><?php echo  number_format($sepwagtot, 2, '.', '')?></td>
<td width="6.5%"><?php echo  number_format($octwagtot, 2, '.', '')?></td>
<td width="6.5%"><?php echo  number_format($novwagtot, 2, '.', '')?></td>
<td width="6.5%"><?php echo  number_format($decwagtot, 2, '.', '')?></td>
<td width="6.5%"><?php echo  number_format($janwagtot, 2, '.', '')?></td>
<td width="6.5%"><?php echo  number_format($febwagtot, 2, '.', '')?></td>
<td width="6.5%"><?php echo  number_format($marwagtot, 2, '.', '')?></td>
<td width="6.5%"><?php echo $aprwagtot+$maywagtot+$junwagtot+$julwagtot+$augwagtot+$sepwagtot+$octwagtot+$novwagtot+$decwagtot+$janwagtot+$febwagtot+$marwagtot; ?></td>
<td width="6.5%"></td>
</tr>
<tr>
<td width="5%" style="width:100px">B.Wages</td>
<td width="6.5%"><?php echo  number_format($aprbonwagtot, 2, '.', '');?></td>
<td width="6.5%"><?php echo  number_format($maybonwagtot, 2, '.', '');?></td>
<td width="6.5%"><?php echo  number_format($junbonwagtot, 2, '.', '');?></td>
<td width="6.5%"><?php echo  number_format($julbonwagtot, 2, '.', '');?></td>
<td width="6.5%"><?php echo  number_format($augbonwagtot, 2, '.', '');?></td>
<td width="6.5%"><?php echo  number_format($sepbonwagtot, 2, '.', '');?></td>
<td width="6.5%"><?php echo  number_format($octbonwagtot, 2, '.', '');?></td>
<td width="6.5%"><?php echo  number_format($novbonwagtot, 2, '.', '');?></td>
<td width="6.5%"><?php echo  number_format($decbonwagtot, 2, '.', '');?></td>
<td width="6.5%"><?php echo  number_format($janbonwagtot, 2, '.', '');?></td>
<td width="6.5%"><?php echo  number_format($febbonwagtot, 2, '.', '');?></td>
<td width="6.5%"><?php echo  number_format($marbonwagtot, 2, '.', '');?></td>
<td width="6.5%"><?php echo $aprbonwagtot+$maybonwagtot+$junbonwagtot+$julbonwagtot+$augbonwagtot+$sepbonwagtot+$octbonwagtot+$novbonwagtot+$decbonwagtot+$janbonwagtot+$febbonwagtot+$marbonwagtot;?></td>
<td width="6.5%"></td>

</tr>
<tr>
<td width="5%">PayDays</td>
<td width="6.5%"><?php  echo  number_format($aprpayable_daystot, 2, '.', '');?></td>
<td width="6.5%"><?php  echo  number_format($maypayable_daystot, 2, '.', '');?></td>
<td width="6.5%"><?php  echo  number_format($junpayable_daystot, 2, '.', '');?></td>
<td width="6.5%"><?php  echo  number_format($julpayable_daystot, 2, '.', '');?></td>
<td width="6.5%"><?php  echo  number_format($augpayable_daystot, 2, '.', '');?></td>
<td width="6.5%"><?php  echo  number_format($seppayable_daystot, 2, '.', '');?></td>
<td width="6.5%"><?php  echo  number_format($octpayable_daystot, 2, '.', '');?></td>
<td width="6.5%"><?php  echo  number_format($novpayable_daystot, 2, '.', '');?></td>
<td width="6.5%"><?php  echo  number_format($decpayable_daystot, 2, '.', '');?></td>
<td width="6.5%"><?php  echo  number_format($janpayable_daystot, 2, '.', '');?></td>
<td width="6.5%"><?php  echo  number_format($febpayable_daystot, 2, '.', '');?></td>
<td width="6.5%"><?php echo  number_format($marpayable_daystot, 2, '.', '');?></td>
<td width="6.5%"><?php echo $aprpayable_daystot+$maypayable_daystot+$junpayable_daystot+$julpayable_daystot+$augpayable_daystot+$seppayable_daystot+$octpayable_daystot+$novpayable_daystot+$decpayable_daystot+$janpayable_daystot+$febpayable_daystot+$marpayable_daystot;?></td>
<td width="6.5%"></td>
</tr>
<tr>
<td width="5%">Bonus+Ex</td>
<td width="6.4%"><?php // echo round($aprbonextot);
						 echo round($aprbonustot);
							if ( $aprexgratot>0) {echo "<br>".round($aprexgratot);};

?></td>
<td width="6.4%"><?php //echo  round($maybonextot);
						 echo round($maybonustot);
							if ( $mayexgratot>0) {echo "<br>".round($mayexgratot);};
?></td>
<td width="6.4%"><?php  //echo round($junbonextot);
						 echo round($junbonustot);
							if ( $junexgratot>0) {echo "<br>".round($junexgratot);};
?></td>
<td width="6.4%"><?php  //echo round($julbonextot);
						 echo round($julbonustot);
							if ( $julexgratot>0) {echo "<br>".round($julexgratot);};
?></td>
<td width="6.4%"><?php  //echo round($augbonextot);
						 echo round($augbonustot);
							if ( $augexgratot>0) {echo "<br>".round($augexgratot);};
?></td>
<td width="6.4%"><?php  //echo round($sepbonextot);
						 echo round($sepbonustot);
							if ( $sepexgratot>0) {echo "<br>".round($sepexgratot);};
?></td>
<td width="6.4%"><?php  //echo round($octbonextot);
						 echo round($octbonustot);
							if ( $octexgratot>0) {echo "<br>".round($octexgratot);};
?></td>
<td width="6.4%"><?php // echo round($novbonextot);
						 echo round($novbonustot);
							if ( $novexgratot>0) {echo "<br>".round($novexgratot);};
?></td>
<td width="6.4%"><?php  //echo round($decbonextot);
						 echo round($decbonustot);
							if ( $decexgratot>0) {echo "<br>".round($decexgratot);};
?></td>
<td width="6.4%"><?php  //echo round($janbonextot);
						 echo round($janbonustot);
							if ( $janexgratot>0) {echo "<br>".round($janexgratot);};
?></td>
<td width="6.4%"><?php  //echo round($febbonextot);
						 echo round($febbonustot);
							if ( $febexgratot>0) {echo "<br>".round($febexgratot);};
?></td>
<td width="6.4%"><?php  //echo round($marbonextot);
						 echo round($marbonustot);
							if ( $marexgratot>0) {echo "<br>".round($marexgratot);};
?></td>
<td width="6.5%"><?php echo number_format(round($aprbonustot+$maybonustot+$junbonustot+$julbonustot+$augbonustot+$sepbonustot+$octbonustot+$novbonustot+$decbonustot+$janbonustot+$febbonustot+$marbonustot),0,".",",");
if ($aprexgratot+$mayexgratot+$junexgratot+$julexgratot+$augexgratot+$sepexgratot+$octexgratot+$novexgratot+$decexgratot+$janexgratot+$febexgratot+$marexgratot > 0) {echo "<br>".number_format(round($aprexgratot+$mayexgratot+$junexgratot+$julexgratot+$augexgratot+$sepexgratot+$octexgratot+$novexgratot+$decexgratot+$janexgratot+$febexgratot+$marexgratot ),0,".",",");}?>
</td>
<td width="6.5%">
<?php 
//if ($aprexgratot+$mayexgratot+$junexgratot+$julexgratot+$augexgratot+$sepexgratot+$octexgratot+$novexgratot+$decexgratot+$janexgratot+$febexgratot+$marexgratot > 0) {
echo "<br>"."<h6>".number_format(round($aprexgratot+$mayexgratot+$junexgratot+$julexgratot+$augexgratot+$sepexgratot+$octexgratot+$novexgratot+$decexgratot+$janexgratot+$febexgratot+$marexgratot+$aprbonustot+$maybonustot+$junbonustot+$julbonustot+$augbonustot+$sepbonustot+$octbonustot+$novbonustot+$decbonustot+$janbonustot+$febbonustot+$marbonustot) ,0,".",",")."<h6>";



?>

</td>

</tr>



</table>
</td>

</tr>
</table>

<br>
Total no of employees : <?php echo $i-1;?>
<br><br>
</div>
</div>
<?php } ?>

</body>
</html>
