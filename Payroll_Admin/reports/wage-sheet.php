<?php
$doc_path=$_SERVER["DOCUMENT_ROOT"];
include ($doc_path.'/include_payroll_admin.php');
// print_r($_SESSION);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(0);
$setCounter = 0;
$month=$_SESSION['month'];
$comp_id=$_SESSION['comp_id'];
$clintid=$_SESSION['clintid'];
$user_id=$_SESSION['log_id'];
$valid_users=$_SESSION['valid_users'];
$setExcelName = "payslip";
$client_id=$_REQUEST['cal'];

$clientGrp=$_SESSION['clientGrp'];
$frdt=$_SESSION['frdt'];

$group[]='';
$resclt='';
if ($clientGrp!='')
{   $group=$payrollAdmin->displayClientGroupById($clientGrp);
    $grpClientIds=$payrollAdmin->getGroupClientIds($clientGrp)  ;
    
    $grpClientIdsOnly=$payrollAdmin->getGroupClientIdsOnly($clientGrp);
    $resclt=$payrollAdmin->displayClient($grpClientIds[0]['mast_client_id']);
    $setExcelName = "Paysheet_Group".$clientGrp;
    $client_id =$grpClientIdsOnly['client_id'];
     if ($clientGrp == 1) {
        // echo "!!!!!!!1";
        $clientids = $payrollAdmin->displayclientbyComp($comp_id);
        // print_r($clientids);
        $resclt = $payrollAdmin->displayClient($clientids['client_id']);
        $client_id=$clientids['client_id'];
    }
}
else
{
    $resclt=$payrollAdmin->displayClient($clintid);
    $setExcelName = "Paysheet_".$client_id;

}

if ( $month=='current')
{
    $frdt=$resclt['current_month'];
}


$client_name = ($clientGrp=='') ? $resclt['client_name']: "Group : ".$group['group_name']; 
$frdt=$payrollAdmin->lastDay($frdt);
$monthtit =  date('F Y',strtotime($frdt));
$todt=$frdt;    



$inhdar = array();
$inh_sh = array();
$inhd =0;
$std_inhdar = array();
$std_inhd =0;
$advhd = 0;
$advhdar = array();

$dedhdar = array();
$dedhd =0;
$noofper = $_REQUEST['noofper'];

if($month=='current'){
    $tab_emp='tran_employee';
    $tab_empded='tran_deduct';
	$tab_days = 'tran_days';
	$tab_inc = 'tran_income';
	$tab_adv = 'tran_advance';
  }
else{
    $tab_emp='hist_employee';
    $tab_empded='hist_deduct';
	$tab_days = 'hist_days';
	$tab_inc = 'hist_income';
	$tab_adv = 'hist_advance';
  }
 $tab = "`tab_".$user_id."`";

$sqltab = "DROP TABLE IF EXISTS $tab" ;
$rowtab= $payrollAdmin->updateTranday($sqltab);
$i = 0;
$days[]=0;
 $sql = "create table $tab (  `client_id` int not null, `desg_id` int not null, `dept_id` int not null, `qualif_id` int not null, `bank_id` int not null, `loc_id` int not null, `paycode_id` int not null,  `pay_mode` varchar(1) not null ,bankacno varchar(30) not null,emp_id int not null, `client_name` VARCHAR(50), `sal_month` DATE NOT NULL, `emp_name` VARCHAR(50)";


 $sql_days = "select  sum(`fullpay`) as fullpay, sum(`halfpay`) as halfpay, sum(`leavewop`) as leavewop, sum(`present`) as present, sum(`absent`) as absent, sum(`weeklyoff`) as weeklyoff, sum(`pl`) as pl, sum(`sl`) as sl, sum(`cl`) as cl, sum(`otherleave`) as otherleave, sum(`paidholiday`) as paidholiday, sum(`additional`) as additional, sum(`othours`) as othours, sum(`nightshifts`)as nightshifts, sum(`extra_inc1`) as extra_inc1, sum(`extra_inc2`) as extra_inc2, sum(`extra_ded1`) as extra_ded1, sum(`extra_ded2`) as extra_ded2, sum(`wagediff`) as wagediff, sum(`Allow_arrears`) as allow_arrears , sum(`Ot_arrears`) as ot_arrears from $tab_days where client_id in ($client_id) and comp_id = '$comp_id' and sal_month >= '$frdt' and sal_month <= '$todt' ";
// and  FIND_IN_SET(user_id,$valid_users) 
$rowtab= $payrollAdmin->executeQuery($sql_days);
$dayshd = 0;

foreach($rowtab as $rowtab1){
	
	if ($rowtab1['present'] >0){$sql=$sql.",`present` float not null";$days[$dayshd]='present';$dayshd++;}
	if ($rowtab1['weeklyoff'] >0){$sql=$sql.",`weeklyoff` float not null";$days[$dayshd]='weeklyoff';$dayshd++;}
	if ($rowtab1['absent'] >0){$sql=$sql.",`absent` float not null";$days[$dayshd]='absent';$dayshd++;}
	if ($rowtab1['paidholiday'] >0){$sql=$sql.",`paidholiday` float not null";$days[$dayshd]='paidholiday';$dayshd++;}
	if ($rowtab1['pl'] >0){$sql=$sql.",`pl` float not null";$days[$dayshd]='pl';$dayshd++;}
	if ($rowtab1['sl'] >0){$sql=$sql.",`sl` float not null";$days[$dayshd]='sl';$dayshd++;}
	if ($rowtab1['cl'] >0){$sql=$sql.",`cl` float not null";$days[$dayshd]='cl';$dayshd++;}
	if ($rowtab1['additional'] >0){$sql=$sql.",`additional` float not null";$days[$dayshd]='additional';$dayshd++;}
	if ($rowtab1['othours'] >0){$sql=$sql.",`othours` float not null";$days[$dayshd]='othours';$dayshd++;}
	if ($rowtab1['nightshifts'] >0){$sql=$sql.",`nightshifts` float not null";$days[$dayshd]='nightshifts';$dayshd++;}
	if ($rowtab1['fullpay'] >0){$sql=$sql.",`fullpay` float not null";$days[$dayshd]='fullpay';$dayshd++;}
	if ($rowtab1['halfpay'] >0){$sql=$sql.",`halfpay` float not null";$days[$dayshd]='halfpay';$dayshd++;}
	if ($rowtab1['leavewop'] >0){$sql=$sql.",`leavewop` float not null";$days[$dayshd]='leavewop';$dayshd++;}
	if ($rowtab1['otherleave'] >0){$sql=$sql.",`otherleave` float not null";$days[$dayshd]='otherleave';$dayshd++;}
	break;
}
$sql=$sql.",`payabledays` float not null";

$sql_inc = "select distinct ti.head_id,trim(mi.income_heads_name) as income_heads_name,short_name from $tab_inc  ti inner join mast_income_heads mi on ti.head_id = mi.mast_income_heads_id  inner join $tab_emp  te on te.emp_id = ti.emp_id and te.sal_month = ti.sal_month  where ti.amount > 0 and te.client_id in ($client_id) and te.comp_id = '$comp_id' and  ti.sal_month >= '$frdt' and ti.sal_month <= '$todt' order by ti.head_id"; 
// echo $sql_inc;
//te.user_id = '$user_id' and
$rowtab= $payrollAdmin->executeQuery($sql_inc);

$inc_head[]=0;
$j= 0;
foreach($rowtab as $rowtab1){
	$sql=$sql.",`".strtolower($rowtab1['income_heads_name'])."` float not null";
	$sql=$sql.",`std_".strtolower($rowtab1['income_heads_name'])."` float not null";
	$inhdar[$inhd] = $rowtab1['income_heads_name'];
	$inh_sh[$inhd] = $rowtab1['short_name'];
	//$std_inhdar[$inhd] = "STD_".$rowtab1['income_heads_name'];
	
	$inhd++;
}
$sql=$sql.",`gross_salary` float not null";


 $sql_ded = "select distinct tdd.head_id,trim(md.deduct_heads_name) as deduct_heads_name from $tab_empded  tdd inner join mast_deduct_heads md on tdd.head_id = md.mast_deduct_heads_id  inner join $tab_emp  te on te.emp_id = tdd.emp_id and te.sal_month = tdd.sal_month  where tdd.amount > 0 and te.client_id in ($client_id) and te.comp_id = '$comp_id'  and tdd.sal_month >= '$frdt' and tdd.sal_month <= '$todt' order by tdd.head_id";   
 //and te.user_id = '$user_id'
$rowtabd= $payrollAdmin->executeQuery($sql_ded);
foreach($rowtabd as $rowtabd1){
	$sql=$sql.",`".strtolower($rowtabd1['deduct_heads_name'])."` float not null";
	
	$dedhdar[$dedhd] = $rowtabd1['deduct_heads_name'];
	$dedhd++;
}

 $sql_adv = "select distinct tadv.head_id,trim(madv.advance_type_name) as advance_type_name from $tab_adv  tadv inner join mast_advance_type madv on tadv.head_id = madv.mast_advance_type_id    where tadv.amount > 0 and tadv.client_id in ($client_id) and tadv.comp_id = '$comp_id'  and tadv.sal_month >= '$frdt' and tadv.sal_month <= '$todt' order by tadv.head_id";   
$rowtaba= $payrollAdmin->executeQuery($sql_adv);
foreach($rowtaba as $rowtaba1){
	$sql=$sql.",`".strtolower($rowtaba1['advance_type_name'])."` float not null";
	
	$advhdar[$advhd] = $rowtaba1['advance_type_name'];
	$dedhdar[$dedhd] = $rowtaba1['advance_type_name'];
	$dedhd++;
}




$sql=$sql.",`tot_deduct` float not null";
$sql=$sql.",`netsalary` float not null";

$sql=$sql.",`bankname` varchar(150) not null";

$sql=$sql.",`deptname` varchar(100) not null";
$sql=$sql.",`designation` varchar(100) not null";
$sql=$sql.",`qualification` varchar(100) not null";
$sql=$sql.",`location` varchar(100) not null";
$sql=$sql.",`cc_code` varchar(100) not null";
$sql = $sql." ) ENGINE = InnoDB";


$row= $payrollAdmin->updateTranday($sql);

//* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 

//tran/hist employee

 $sql = "insert into $tab ( `client_id`, `desg_id` , `dept_id` , `qualif_id` , `bank_id` , `loc_id`, `paycode_id` ,`pay_mode`,bankacno ,emp_id,`sal_month`, payabledays,`gross_salary`,`tot_deduct`, `netsalary`)  select `client_id`, `desg_id` , `dept_id` , `qualif_id` , `bank_id` , `loc_id`, `paycode_id` ,`pay_mode`,bankacno ,emp_id,`sal_month`,payabledays, `gross_salary`,`tot_deduct`, `netsalary`  from $tab_emp where client_id in ($client_id) and comp_id = '$comp_id' and sal_month >= '$frdt' and sal_month <= '$todt'";
 //and user_id = '$user_id' 
$row= $payrollAdmin->updateTranday($sql);

 $sql= "update $tab t inner join mast_client mc on mc.mast_client_id = t.client_id set t.client_name = mc.client_name";
$row= $payrollAdmin->updateTranday($sql);
 
$sql= "update $tab t inner join mast_desg md on md.mast_desg_id = t.desg_id set  t.designation = md.mast_desg_name";
$row= $payrollAdmin->updateTranday($sql);

$sql= "update $tab t inner join mast_dept md on md.mast_dept_id = t.dept_id set  t.deptname = md.mast_dept_name";
$row= $payrollAdmin->updateTranday($sql);

$sql= "update $tab t inner join mast_qualif mq on mq.mast_qualif_id = t.qualif_id set  t.qualification = mq.mast_qualif_name";
$row= $payrollAdmin->updateTranday($sql);

$sql= "update $tab t inner join mast_location ml on ml.mast_location_id = t.loc_id set  t.location = ml.mast_location_name";
$row= $payrollAdmin->updateTranday($sql);

$sql= "update $tab t inner join paycode mp on mp.mast_paycode_id = t.paycode_id set  t.cc_code = mp.mast_paycode_name";
//$row= $payrollAdmin->updateTranday($sql);

$sql= "update $tab t inner join mast_bank mb on mb.mast_bank_id = t.bank_id set  t.bankname = concat(mb.bank_name,' ',mb.branch,' ',mb.ifsc_code)";
$row= $payrollAdmin->updateTranday($sql);

$sql= "update $tab t inner join employee e on e.emp_id = t.emp_id set  t.emp_name =concat( e.first_name,' ',e.middle_name,' ' , e.last_name) ";
$row= $payrollAdmin->updateTranday($sql);

//Tran/hist days
$sql= "update $tab t inner join $tab_days td on t.emp_id=td.emp_id and t.sal_month= td.sal_month set ";
for ($j =0;$j<$dayshd;$j++){
	$sql = $sql. "t.`".$days[$j]."` = td.`".$days[$j]."`,";
}
$sql = $sql." t.present= td.present where td.client_id in ($client_id) and td.comp_id = '$comp_id' and td.sal_month >= '$frdt' and td.sal_month <= '$todt'";
// and td.user_id = '$user_id'

$row= $payrollAdmin->updateTranday($sql);


//tran_hist income

$rowtab= $payrollAdmin->executeQuery($sql_inc);
foreach($rowtab as $rowtab1){
	 $sql = "update $tab t inner join (select ti.emp_id,ti.sal_month,ti.head_id,ti.std_amt,ti.amount,mih.income_heads_name as head_name from $tab_inc  ti inner join mast_income_heads mih on ti.head_id=mih.mast_income_heads_id   inner join $tab_emp  te on te.emp_id = ti.emp_id and te.sal_month = ti.sal_month  where ti.amount > 0 and te.client_id in ($client_id) and te.comp_id = '$comp_id' and ti.sal_month >= '$frdt' and ti.sal_month <= '$todt' and  mih.income_heads_name like '%".strtolower($rowtab1['income_heads_name'])."%'  ) inc on t.emp_id = inc.emp_id and t.sal_month = inc.sal_month set t.`".strtolower($rowtab1['income_heads_name'])."` = inc.amount,t.`std_".strtolower($rowtab1['income_heads_name'])."` = inc.std_amt";
	 //and te.user_id = '$user_id' 
     $row= $payrollAdmin->updateTranday($sql);
}


////tran_hist income deduction updation
$rowtabd= $payrollAdmin->executeQuery($sql_ded);
foreach($rowtabd as $rowtabd1){
	 $sql = "update $tab t inner join (select tdd.emp_id,tdd.sal_month,tdd.head_id,tdd.amount,mdh.deduct_heads_name as head_name from $tab_empded  tdd inner join mast_deduct_heads mdh on tdd.head_id=mdh.mast_deduct_heads_id   inner join $tab_emp  te on te.emp_id = tdd.emp_id and te.sal_month = tdd.sal_month  where tdd.amount > 0 and te.client_id in ($client_id) and te.comp_id = '$comp_id' and tdd.sal_month >= '$frdt' and tdd.sal_month <= '$todt' and  mdh.deduct_heads_name like '%".strtolower($rowtabd1['deduct_heads_name'])."%'  ) ded on t.emp_id = ded.emp_id and t.sal_month = ded.sal_month set t.`".strtolower($rowtabd1['deduct_heads_name'])."` = ded.amount";
	 // and te.user_id = '$user_id'
     $row= $payrollAdmin->updateTranday($sql);
}


/*
////tran_hist income deduction updation
$rowtabd= mysql_query($sql_ded);
while($rowtabd1 = mysql_fetch_array($rowtabd)){
	
	 $sql = "update $tab t inner join (select tdd.emp_id,tdd.sal_month,tdd.head_id,tdd.amount,mdh.deduct_heads_name as head_name from $tab_empded  tdd inner join mast_deduct_heads mdh on tdd.head_id=mdh.mast_deduct_heads_id   inner join $tab_emp  te on te.emp_id = tdd.emp_id and te.sal_month = tdd.sal_month  where tdd.amount > 0 and te.client_id in ($client_id) and te.comp_id = '$comp_id' and te.user_id = '$user_id' and tdd.sal_month >= '$frdt' and tdd.sal_month <= '$todt' and  mdh.deduct_heads_name like '%".strtolower($rowtabd1['deduct_heads_name'])."%'  ) ded on t.emp_id = ded.emp_id and t.sal_month = ded.sal_month set t.`".strtolower($rowtabd1['deduct_heads_name'])."` = ded.amount";
	$row= mysql_query($sql);
}

*/


////tran_hist advance updation
$rowtaba= $payrollAdmin->executeQuery($sql_adv);
foreach($rowtaba as $rowtaba1){
	 $sql = "update $tab t inner join (select tadv.emp_id,tadv.sal_month,tadv.head_id,tadv.amount,mah.advance_type_name  as head_name from $tab_adv  tadv inner join mast_advance_type  mah on tadv.head_id=mah.mast_advance_type_id     where tadv.amount > 0 and tadv.client_id in ($client_id) and tadv.comp_id = '$comp_id'  and tadv.sal_month >= '$frdt' and tadv.sal_month <= '$todt' and  mah.advance_type_name  like '%".strtolower($rowtaba1['advance_type_name'])."%'  ) adv on t.emp_id = adv.emp_id and t.sal_month = adv.sal_month set t.`".strtolower($rowtaba1['advance_type_name'])."` = adv.amount";
     $row= $payrollAdmin->updateTranday($sql);
}




$setSql1= "select * from $tab order by emp_id,sal_month ";
$setRec= $payrollAdmin->executeQuery($setSql1);

if($month!=''){
$reporttitle="MONTH : ".date('F Y',strtotime($frdt));
$reporttitle = $reporttitle."<br> WAGE REGISTER FORM II (SEE RULE 27 (1))";
}

$_SESSION['client_name']=$client_name;

$_SESSION['reporttitle']=strtoupper($reporttitle);
//print_r($inhdar);
?>
<!DOCTYPE html>

<html lang="en-US">
<head>
<meta charset="utf-8"/>
<title> &nbsp;</title>


<style>
.row {width: 1340px;
    margin-left: -52px !important;
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
    display: block;
    page-break-after: always;
    z-index: 0;
    /*padding-right: 10px;*/

}

table {
border-collapse: collapse;
/*width: 100%;*/
padding: 5px!important;
border:none;
font-size:13px !important;
font-family: monospace;

}

table2 {
border:0px;

}
.tot{
cellpadding:0;
cellspacing:0;
}


td, th {
padding: 3px!important;
border: 1px solid black!important;
font-size:13px !important;
font-family: monospace;

}
div{font-size:11px !important;}

table.padd0imp ,.padd0imp tr{border:0 !important}
.per20inl{width:20%; display:inline-block; align:left;font-size:11px !important;
font-family: monospace;}
.textlower{text-transform: lowercase;}
.textupper{text-transform: uppercase;}

.date{
    font-size:13px !important;
    font-weight:bold;
}

@media print
{
.row {width: 1200px;}

table{
    width:100%;
    padding: 0px !important;
    display:block;
}

table td, th {
 font-size:13px !important;   
}
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
}

@media print {
    body {-webkit-print-color-adjust: exact;}
}
h3 {
/*position: absolute;*/
page-break-before: always;
page-break-after: always;
bottom: 0;
right: 0;
}
h3::before {
/*position: relative;*/
bottom: -20px;
counter-increment: section;
content: counter(section);
}		
.abc{
    background-color: yellow !important;
        print-color-adjust: exact;
   
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

}

</style>

</head>
<body class="container">
   
<div class="btnprnt">
    <button class="submitbtn" onclick="myFunction()">Print</button>
    <button class="submitbtn"  onclick="location.href='/report-salary'" >Cancel</button>
</div>
 <div class="header_bg">
    <?php
        include('printheader2.php');
        ?>
</div>

<?php 

$totnetsalary= 0;
$totpayable=0;
$totgrosssal=0;
$tottotded=0;
$maxcol = max($inhd,$dayshd,$dedhd);

$totaldayscol=count($days);
$totalIncomeCol = count($inhdar);
$totalDedCol = count($dedhdar);
$totalCol = $totaldayscol+ $totalIncomeCol+$totalDedCol+5;
$colwidth= intval(65/$totalCol); ?>

<!-- row body -->
<div class="container page-bk textupper" cellspacing="0" cellpadding="0">

    <!--<p class="date">Date : <?= date('d/m/Y')?></p>-->

<table style="width:100%">
		<tr> 
			<td width="2%" rowspan = "2" align="center"><b>sr no</b> </td>
			<td width="3%" rowspan = "2" align="center"><b>Emp Id</b></td>

			<td width="15%" rowspan = "2" align="center"><b>Name</b></td>
			<td colspan=<?=$totaldayscol+1;?>  align="center"><b>Days</b></td>
			<td colspan=<?=$totalIncomeCol+3;?> align="center"><b>Salary Earned</b>

			</td>
			<td colspan=<?=$totalDedCol+1;?> align="center"><b>Deductions</b></td>
			<td rowspan="2"><b>Net Salary</b></td>
		</tr>
		<tr>
			
			<?php 
			//Days headings
			for ($j= 0 ;$j <$totaldayscol;$j++)
			{	echo '<td  width="'. $colwidth.'%" align="center"><b>';
			if (strtoupper($days[$j])=='PRESENT'){echo 'PRES'.'</b></td>';}
			else if (strtoupper($days[$j])=='OTHOURS'){echo 'OT HRs'.'</b></td>';}
			else if (strtoupper($days[$j])=='NIGHTSHIFTS'){echo 'NIGHT SFT.'.'</b></td>';}
			else if (strtoupper($days[$j])=='WEEKLYOFF'){echo 'WEEKLY OFF'.'</b></td>';}
			else if (strtoupper($days[$j])=='PAIDHOLIDAY'){echo 'PAID HOLID'.'</b></td>';}
			else {echo $days[$j].'</td>';}
			//substr($days[$j],6).'</td>';
			}?>
			<td width="2%"><b>Payable<br>Days</b></td>
			<?php
			//Income headings
		
			for ($j= 0 ;$j <=2;$j++)
			{	echo '<td  width="'. $colwidth.'%" align="center" text-transform: uppercase;><b>'.$inhdar[$j].'</b></td>'; }
			
		
			echo '<td width="' . $colwidth . '%" align="center" style="text-transform: uppercase; background-color: #fff192;"class="abc"><b>TOTAL</b></td>';

// 		echo $j;
			if($j==3){
				echo '<td  width="'. $colwidth.'%" align="center" text-transform: uppercase;><b>'.$inhdar[$j].'</b></td>';
					$j++;
			}
		
		
		   for ($j=4;$j<$totalIncomeCol;$j++)
                { echo '<td  width="'. $colwidth.'%" align="center" text-transform: uppercase;><b>';
    			if($j>3 && $j<8){
        			$head_name = explode(" ",$inhdar[$j]);
        			$acronym = "";
        			foreach ($head_name as $w) {
                        $acronym .= mb_substr($w, 0, 1);
                    }
                    echo $acronym;
			    }
			    if($j==8){
    			   echo substr($inhdar[$j],0,4).'.'; 
    			}
    		   echo '</b></td>';
			}?>
			<td width="<?= $colwidth.'%';?>" ><b>Total<br>Allo.</b></td>
			<td class="abc"><b>GR.<br>SALARY</b></td>
			

			<?php 
			//Deductions headings
			for ($j= 0 ;$j <$totalDedCol;$j++)
			{	echo '<td  width="'. $colwidth.'%" align="center"><b>'.substr($dedhdar[$j],0,6).'</br>'.substr($dedhdar[$j],6).'</b></td>';
			}?><td><b>Tot. Ded.</b></td>
			
		</tr> 

		<?php
		$incarray = array();
		$sr=0; 
		$count=0; 
		$total=0;
		$tabletotalallo=0;
		$tabletotal=0;
		foreach($setRec as $rec) 
		{ $count++;
		$total=0;
		$totalallo=0;
		if($sr%$noofper==0 && $sr>0)
		{?>

</table>

</div>

<div class="container page-bk textupper" cellspacing="0" cellpadding="0">
  <div class="header_bg">
    <?php
        include('printheader2.php');
        ?>
</div> 
<table width="100%" >
		<tr> 
			<td width="2%" rowspan = "2" align="center"><b>sr no</b> </td>
			<td width="3%" rowspan = "2" align="center"><b>Emp Id</b></td>

			<td width="15%" rowspan = "2" align="center"><b>Name</b></td>
			<td colspan=<?=$totaldayscol+1;?>  align="center"><b>Days</b></td>
			<td colspan=<?=$totalIncomeCol+3;?> align="center"><b>Salary Earned</b></td>
			<td colspan=<?=$totalDedCol+1;?> align="center"><b>Deductions</b></td>
			<td  rowspan="2"><b>Net Salary</b></td>
		</tr>
	
		<tr>
			
			<?php 
			//Days headings
			for ($j= 0 ;$j <$totaldayscol;$j++)
			{	echo '<td width="'. $colwidth.'%" align="center"><b>';
			if (strtoupper($days[$j])=='PRESENT'){echo 'PRES'.'</b></td>';}
			else if (strtoupper($days[$j])=='OTHOURS'){echo 'OT HRs'.'</b></td>';}
			else if (strtoupper($days[$j])=='NIGHTSHIFTS'){echo 'NIGHT SFT.'.'</b></td>';}
			else if (strtoupper($days[$j])=='WEEKLYOFF'){echo 'WEEKLY OFF'.'</b></td>';}
			else if (strtoupper($days[$j])=='PAIDHOLIDAY'){echo 'PAID HOLID'.'</b></td>';}
			else {echo $days[$j].'</td>';}
			//substr($days[$j],6).'</td>';
			}?>
			<td width="2%"><b>Payable<br>Days</b></td>
			<?php
			//Income headings
			for ($j= 0 ;$j <=2;$j++)
			{	echo '<td  width="'. $colwidth.'%" align="center" text-transform: uppercase;><b>'.$inhdar[$j].'</b></td>'; }
			echo '<td  width="'. $colwidth.'%" align="center" text-transform: uppercase; style="background-color: #fff192;"class="abc"><b>TOTAL</b></td>';
// 		echo $j;
			if($j==3){
				echo '<td  width="'. $colwidth.'%" align="center" text-transform: uppercase;><b>'.$inhdar[$j].'</b></td>';
					$j++;
			}
			  for ($j=4;$j <$totalIncomeCol;$j++)
                {	echo '<td  width="'. $colwidth.'%" align="center" text-transform: uppercase; ><b>';
			    if($j>3 && $j<8){
        			$head_name = explode(" ",$inhdar[$j]);
        			$acronym = "";
        			foreach ($head_name as $w) {
                        $acronym .= mb_substr($w, 0, 1);
                    }
                    echo $acronym;
			    }if($j==8){
			        
    			   echo substr($inhdar[$j],0,4).'.';  
    			}
    			 echo '</b></td>';
			}?>
			<td width="<?= $colwidth.'%';?>" ><b>Total<br>Allo.</b></td>
			<td class="abc"><b>GR.<br>SALARY</b></td>

			<?php 
			//Deductions headings
			for ($j= 0 ;$j <$totalDedCol;$j++)
			{	echo '<td  width="'. $colwidth.'%" align="center"><b>'.substr($dedhdar[$j],0,6).'</br>'.substr($dedhdar[$j],6).'</b></td>';
			}?><td><b>Tot.Ded.</b></td>
		
		</tr> 
	
		<?php }?>
		
			<tr> 
			<td width="2%" align="center"><b><?php $sr++;echo $sr;?> </b> </td>
			<td width="3%" align="center"><b><?php echo $rec['emp_id'];?></b></td>

			<td  width="15%" align="left"><b><?php 
			$emp_name= '';
			    $name = explode(" ",$rec['emp_name']);
			     if(count($name)==1){
			         $emp_name = str_replace(' .', '', $name[0]);;
			     }
			     if(count($name)==2){
			         $emp_name = $name[0].' '.$name[1];
			     }
			     if(count($name)==3){
			          $emp_name = $name[0].' '.substr($name[1],0,1).'. '.$name[2];
			     }
			     /*if(count($name)==4){
			          $emp_name = $name[0].' '.substr($name[1],0,1).substr($name[2],0,1).'. '.$name[3];
			     }*/
			     echo $emp_name;
			?></b></td>


			<?php for ($j= 0 ;$j <$totaldayscol;$j++)
			{	echo '<td  width="'. $colwidth.'%" align="right" >';
			    if($rec[strtolower($days[$j])]==0){
			        echo '-';
			    }else{
			        echo number_format(round($rec[strtolower($days[$j])],2),0,'.','');
			   }'</td>';

			}?>	<td align="right"><?php 
			    if(round($rec["payabledays"])==0){
			        echo '-';
			    }else{
			        echo round($rec["payabledays"],2);
			     }
			 ?></td>
			<?php for ($j= 0 ;$j <=2;$j++)
			{	
			    $total = $total + round($rec[strtolower($inhdar[$j])],2);
			    echo '<td width="'. $colwidth.'%" align="right" >';
			        if($rec[strtolower($inhdar[$j])]==0){
			            echo '-';
			         }else{
			              echo number_format(round($rec[strtolower($inhdar[$j])],2),0,'.','');
			        }
			       echo '</td>';
			}
// 			if($j==4){
			    echo '<td width="'. $colwidth.'%" align="right"style="background-color: #fff192;" class="abc" >'.$total.'</td>';
			 //   $j++;
// 			}
$totalallo=0;
				if($j==3){
			
				$hratotal = round($rec[strtolower($inhdar[$j])],2);
				 echo '<td width="'. $colwidth.'%" align="right" >';
			        if($rec[strtolower($inhdar[$j])]==0){
			            echo '-';
			         }else{
			              echo number_format(round($rec[strtolower($inhdar[$j])],2),0,'.','');
			        }
			       echo '</td>';
			       $j++;
			}
// 			echo  $hratotal;
			 for ($j=4;$j <$totalIncomeCol;$j++)
                {
                //echo $j."*****".$hratotal."-------".round($rec[strtolower($inhdar[$j])],2)."<br>";
			    $totalallo = $totalallo + round($rec[strtolower($inhdar[$j])],2);
			  //  echo "Total allowance : ".$totalallo."<br>";
                    echo '<td width="'. $colwidth.'%" align="right" >';
			        if($rec[strtolower($inhdar[$j])]==0){
			            echo '-';
			         }else{
			              echo number_format(round($rec[strtolower($inhdar[$j])],2),0,'.','');
			        }
			       echo '</td>';
                }
			?>
			<td width="<?php echo $colwidth; ?>" align="right"  ><?php echo $totalallo+$hratotal; ?></td>

			
			<td width="3%" align="right" class="abc"><?php echo round($rec["gross_salary"],2); ?></td>

			<?php for ($j= 0 ;$j <$totalDedCol;$j++)
			{	echo '<td width="'. $colwidth.'%" align="right">';
			    if($rec[strtolower($dedhdar[$j])]==0){
			        echo '-';
			    }else{
			        echo number_format(round($rec[strtolower($dedhdar[$j])],2),0,'.','');
			    }
			    echo '</td>';
			}?><td width="2%" align="right"><?php echo round($rec["tot_deduct"],2); ?></td>
			<td width="2%" align="right"><b><?php echo round($rec["netsalary"],2); ?></b></td> 
			</tr>
			
			<?php  
		   $tabletotalallo=$tabletotalallo+$totalallo +$hratotal;
		   $tabletotal=$tabletotal + $total;
		}
			?>


               
			
				<tr> 
				<td   align="center"><b> </b> </td>
				<td align="center"><b></b></td>
				<td align="right"><b>Total</b></td>
				<?php
				$sql_tot = "select sum(payabledays) as payabledays,sum(gross_salary) as gross_salary,sum(tot_deduct) as tot_deduct ,sum(netsalary) as netsalary from $tab t ";
			    $rec1_tot= $payrollAdmin->executeQuery($sql_tot);
                $rec_tot= $rec1_tot[0];
			
			
                $rec1= $payrollAdmin->executeQuery($sql_days);
                $rec=$rec1[0];
                

				for ($j= 0 ;$j <$totaldayscol;$j++)
				{	echo '<td  width="'. $colwidth.'%" align="right" >'.$rec[strtolower($days[$j])].'</td>';

				}?>	<td align="right"><?php echo round($rec_tot["payabledays"],2); ?></td>

				<?php 

				for ($j= 0 ;$j <=2;$j++)
				
				{	
    				$sql_inc = "select sum(`".$inhdar[$j]."`) as amount from $tab t";
                    $rec1= $payrollAdmin->executeQuery($sql_inc);
                    $rec=$rec1[0];
                    echo '<td  width="'. $colwidth.'%" align="right" >'.round($rec['amount'],2).'</td>';
    			}
    			 echo '<td  width="'. $colwidth.'%" align="right" class="abc" >'.$tabletotal.'</td>';
    		
    			 for ($j=3;$j <$totalIncomeCol;$j++)
                {
                    $sql_inc = "select sum(`".$inhdar[$j]."`) as amount from $tab t";
                    $rec1= $payrollAdmin->executeQuery($sql_inc);
                    $rec=$rec1[0];
                    echo '<td  width="'. $colwidth.'%" align="right" >'.round($rec['amount'],2).'</td>';
    			
                   } ?>
    			<td width="3%" align="right"><?php echo $tabletotalallo; ?></td>
				<td width="3%" class="abc" align="right"><?php echo round($rec_tot["gross_salary"],2); ?></td>
			
				<?php   for ($j= 0 ;$j <$totalDedCol;$j++)
				{	
				    $sql_ded = "select sum(`".$dedhdar[$j]."`) as amount from $tab t";
                    $rec1= $payrollAdmin->executeQuery($sql_ded);
                    $rec=$rec1[0];
			    	echo '<td  width="'. $colwidth.'%" align="right">'.round($rec['amount'],2).'</td>';
				}?>
				<td width="2%" align="right"><?php echo round($rec_tot["tot_deduct"],2); ?></td>       	 
				<td  width="2%" align="right" rowspan = "3"><b><?php echo round($rec_tot["netsalary"],2); ?></b></td>
				</tr>
</table>

	</div>

	<br>
	<script>
	function myFunction() {
	  window.print();
	}

	</script>



	</body>
	</html>
