<?php
session_start();
error_reporting(0);
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');
include("../lib/connection/db-config.php");
$payrollAdmin = new payrollAdmin();

$setCounter = 0;
$month=$_SESSION['month'];

$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$client_id=$_REQUEST['cal'];

$clientGrp = $_REQUEST['calGrp'];
//echo $clientGrp;
if ($clientGrp != '') {
    $group = $payrollAdmin->displayClientGroupById($clientGrp);
    $grpClientIds = $payrollAdmin->getGroupClientIds($clientGrp);
    $grpClientIdsOnly = $payrollAdmin->getGroupClientIdsOnly($clientGrp);
    $rowclient = $payrollAdmin->displayClient($grpClientIds[0]['mast_client_id']);
    $setExcelName = "_Export_Paysheet_Group" . $clientGrp;
    $client_id = $grpClientIdsOnly['client_id'];
     if ($clientGrp == 1) {
        // echo "!!!!!!!1";
        $clientids = $payrollAdmin->displayclientbyComp($comp_id);
        // print_r($clientids);
        $resclt = $payrollAdmin->displayClient($clientids['client_id']);
        $clientid=$clientids['client_id'];
    }
} else {
    $rowclient = $payrollAdmin->displayClient($client_id);
    $setExcelName = "Export_Paysheet_" . $client_id;
}
$cmonth=$rowclient['current_month'];

 if($month=='current'){
	$monthtit =  date('F Y',strtotime($cmonth));
    $tab_emp='tran_employee';
    $tab_empded='tran_deduct';
	$tab_days = 'tran_days';
	$tab_inc = 'tran_income';
	$tab_adv = 'tran_advance';
    $frdt=$cmonth;
    $todt=$cmonth;
  }else{ 
    $monthtit =  date('F Y',strtotime($_SESSION['frdt']));
    $tab_emp='hist_employee';
    $tab_empded='hist_deduct';
	$tab_days = 'hist_days';
	$tab_inc = 'hist_income';
	$tab_adv = 'hist_advance';
	$frdt=date("Y-m-d", strtotime($_SESSION['frdt']));
    $todt=date("Y-m-t", strtotime($_SESSION['frdt']));

  }

 $tab = "`tab_".$user_id."`";

$i = 0;
$days[]=0;
$advhd =0;

$sqltab = "DROP TABLE IF EXISTS $tab" ;
$rowtab= $payrollAdmin->executeQuery($sqltab);
$i = 0;
$days[]=0;

 $sql = "create table $tab (  `client_id` int not null, `desg_id` int not null, `dept_id` int not null, `qualif_id` int not null, `bank_id` int not null, `loc_id` int not null, `paycode_id` int not null,  `pay_mode` varchar(1) not null ,bankacno varchar(30) not null,emp_id int not null, `client_name` VARCHAR(50), `sal_month` DATE NOT NULL, `emp_name` VARCHAR(50)";


 $sql_days = "select  sum(`fullpay`) as fullpay, sum(`halfpay`) as halfpay, sum(`leavewop`) as leavewop, sum(`present`) as present, sum(`absent`) as absent, sum(`weeklyoff`) as weeklyoff, sum(`pl`) as pl, sum(`sl`) as sl, sum(`cl`) as cl, sum(`otherleave`) as otherleave, sum(`paidholiday`) as paidholiday, sum(`additional`) as additional, sum(`othours`) as othours, sum(`nightshifts`)as nightshifts, sum(`extra_inc1`) as extra_inc1, sum(`extra_inc2`) as extra_inc2, sum(`extra_ded1`) as extra_ded1, sum(`extra_ded2`) as extra_ded2, sum(`wagediff`) as wagediff, sum(`Allow_arrears`) as allow_arrears , sum(`Ot_arrears`) as ot_arrears from $tab_days where FIND_IN_SET(client_id,'$client_id') and comp_id = '$comp_id' and sal_month >= '$frdt' and sal_month <= '$todt' ";
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

$sql_inc = "select distinct ti.head_id,trim(mi.income_heads_name) as income_heads_name,short_name from $tab_inc  ti inner join mast_income_heads mi on ti.head_id = mi.mast_income_heads_id  inner join $tab_emp  te on te.emp_id = ti.emp_id and te.sal_month = ti.sal_month  where ti.amount > 0 and FIND_IN_SET(te.client_id,'$client_id') and te.comp_id = '$comp_id' and  ti.sal_month >= '$frdt' and ti.sal_month <= '$todt' order by ti.head_id"; 
//te.user_id = '$user_id' and

$rowtab= $payrollAdmin->executeQuery($sql_inc);

$inc_head[]=0;
$j= 0;
foreach($rowtab as $rowtab1){
	$sql=$sql.",`".strtolower($rowtab1['income_heads_name'])."` float not null";
//	$sql=$sql.",`std_".strtolower($rowtab1['income_heads_name'])."` float not null";
	$inhdar[$inhd] = $rowtab1['income_heads_name'];
	$inh_sh[$inhd] = $rowtab1['short_name'];
	//$std_inhdar[$inhd] = "STD_".$rowtab1['income_heads_name'];
	
	$inhd++;
}
$sql=$sql.",`gross_salary` float not null";


 $sql_ded = "select distinct tdd.head_id,trim(md.deduct_heads_name) as deduct_heads_name from $tab_empded  tdd inner join mast_deduct_heads md on tdd.head_id = md.mast_deduct_heads_id  inner join $tab_emp  te on te.emp_id = tdd.emp_id and te.sal_month = tdd.sal_month  where tdd.amount > 0 and FIND_IN_SET(te.client_id,'$client_id') and te.comp_id = '$comp_id'  and tdd.sal_month >= '$frdt' and tdd.sal_month <= '$todt' order by tdd.head_id";   
 //and te.user_id = '$user_id'
$rowtabd= $payrollAdmin->executeQuery($sql_ded);
foreach($rowtabd as $rowtabd1){
	$sql=$sql.",`".strtolower($rowtabd1['deduct_heads_name'])."` float not null";
	
	$dedhdar[$dedhd] = $rowtabd1['deduct_heads_name'];
	$dedhd++;
}

 $sql_adv = "select distinct tadv.head_id,trim(madv.advance_type_name) as advance_type_name from $tab_adv  tadv inner join mast_advance_type madv on tadv.head_id = madv.mast_advance_type_id    where tadv.amount > 0 and FIND_IN_SET(tadv.client_id,'$client_id') and tadv.comp_id = '$comp_id'  and tadv.sal_month >= '$frdt' and tadv.sal_month <= '$todt' order by tadv.head_id";   
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

 $sql = "insert into $tab ( `client_id`, `desg_id` , `dept_id` , `qualif_id` , `bank_id` , `loc_id`, `paycode_id` ,`pay_mode`,bankacno ,emp_id,`sal_month`, payabledays,`gross_salary`,`tot_deduct`, `netsalary`)  select `client_id`, `desg_id` , `dept_id` , `qualif_id` , `bank_id` , `loc_id`, `paycode_id` ,`pay_mode`,bankacno ,emp_id,`sal_month`,payabledays, `gross_salary`,`tot_deduct`, `netsalary`  from $tab_emp where FIND_IN_SET(client_id,'$client_id') and comp_id = '$comp_id' and sal_month >= '$frdt' and sal_month <= '$todt'";
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
	 $sql = "update $tab t inner join (select ti.emp_id,ti.sal_month,ti.head_id,ti.std_amt,ti.amount,mih.income_heads_name as head_name from $tab_inc  ti inner join mast_income_heads mih on ti.head_id=mih.mast_income_heads_id   inner join $tab_emp  te on te.emp_id = ti.emp_id and te.sal_month = ti.sal_month  where ti.amount > 0 and te.client_id in ($client_id) and te.comp_id = '$comp_id' and ti.sal_month >= '$frdt' and ti.sal_month <= '$todt' and  mih.income_heads_name like '%".strtolower($rowtab1['income_heads_name'])."%'  ) inc on t.emp_id = inc.emp_id and t.sal_month = inc.sal_month set t.`".strtolower($rowtab1['income_heads_name'])."` = inc.amount";
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
$setSql1= "select * from $tab ";
if(isset($_SESSION['empid']) && $_SESSION['empid']!=''){
    $setSql1 .= " where emp_id ='".$_SESSION['empid']."'";
}
$setSql1 .= " order by emp_id,sal_month";
$setRec = $payrollAdmin->executeQuery($setSql1);

$setCounter = count($setRec);
$setMainHeader .= "Srno\tclient_id\tDesgination\tDepartment\tQualification\tBank\tLocation\tPaycode id\tPaymode\tbankacno\temp_id\tclient name\tsal month\temp name\tpresent\tweeklyoff\tpayabledays\tBasic\tF.D.A.\tV.D.A.\tH.R.A.\tTechnical Allowance\tAttendance allowance\tWashing Allowance\tPetrol Reimb.\tCommi.\tGross Salary\tE.S.I.\tP.F.\tProf.tax\tSalary Adv.\tTotal Ded.\tnetsalary\tBankName\tDepartment\tDesignation\tQualification\tLocation\tcc_code";
//$setMainHeader .= "Srno\tClient_id\tClient_name\tEmp_id\tSal_month\tEmp_name\tGender\tJoindate\tPresent\tWeeklyoff\tPaidholiday\tPayabledays\tStd_basic\tStd_d.a.\tStd_h.r.a.\tStd_other Alw\tStd_rate_total\tBasic\tD.a.\tH.r.a.\tOther Alw\tGross_salary\tPf_wages\tEsi_wages\tP.f.\tE.s.i.\tProf. Tax\tR.off\tTot_deduct\tNetsalary\tEr_pf\tEr_esi\tPay_mode\tBankacno\tBankname\tBranch\tIfsc_code\tDeptname\tDesignation\tQualification\tLocation\tCc_code\tUan\tPfno\tEsino\tMobile_no";
$srno=0;
 
foreach($setRec as $rec)  {$srno++;
    $rowLine = $srno."\t";
    $k=0;
    foreach($rec as $value)       {
        $k++;
      //  if ($k<7){continue;}
        
        if(!isset($value) || $value == "")  {
            $value = "\t";
        }   else  {
            $value = strip_tags(str_replace('"', '""', $value));
            $value = '"' . $value . '"' . "\t";
        }
        $rowLine .= $value;
    }
    $setData .= trim($rowLine)."\n";
}
$setData = str_replace("\r", "", $setData);
//print_r($setData);
if ($setData == "") {
    $setData = "\nno matching records found\n";
}
ob_end_clean();
//This Header is used to make data download instead of display the data
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=".$setExcelName.".xls");

header("Pragma: no-cache");
header("Expires: 0");
//It will print all the Table row as Excel file row with selected column name as header.
echo ucwords($setMainHeader)."\n".$setData."\n";
$_SESSION['empid']='';
?>
