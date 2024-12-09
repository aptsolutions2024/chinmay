<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

if($_SESSION['log_type']==2 || $_SESSION['log_type']==3 )
{}else{
    echo "<script>window.location.href='/payroll-logout';</script>";exit();
}
//print_r($_REQUEST);
$client=$_REQUEST['client'];
$tr_id=$_REQUEST['tr_id'];
$emp=$_REQUEST['emp_id'];
$smonth=$_REQUEST['cm'];
 $smonth = date("Y-m-t",strtotime($smonth)); 

$fp=$_REQUEST['fp'];
$hp=$_REQUEST['hp'];
$lw=$_REQUEST['lw'];
$wo=$_REQUEST['wo'];
$pr=$_REQUEST['pr'];
$ab=$_REQUEST['ab'];
$pl=$_REQUEST['pl'];
$sl=$_REQUEST['sl'];
$cl=$_REQUEST['cl'];
$ol=$_REQUEST['ol'];
$ph=$_REQUEST['ph'];
$add=$_REQUEST['add'];
$oh=$_REQUEST['oh'];
$ns=$_REQUEST['ns'];
$extra_inc1=$_REQUEST['extra_inc1'];
$extra_ded1=$_REQUEST['extra_ded1'];
$extra_ded2=$_REQUEST['extra_ded2'];
$extra_inc2=$_REQUEST['extra_inc2'];
$leave_encash =$_REQUEST['leave_encash'];
$reward =$_REQUEST['reward'];

$wagediff=$_REQUEST['wagediff'];
$Allow_arrears=$_REQUEST['Allow_arrears'];
$Ot_arrears=$_REQUEST['Ot_arrears'];


$leftdate=$_REQUEST['leftdate'];
$income_tax=$_REQUEST['incometax'];
$society=$_REQUEST['society'];
$canteen=$_REQUEST['canteen'];
$remarks=$_REQUEST['remarks'];
$invalid=$_REQUEST['invalid'];

$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$_SESSION['clintid']=$client;

 $result=$payrollAdmin->insertTranday($client,$tr_id,$emp,$smonth,$fp,$hp,$lw,$wo,$pr,$ab,$pl,$sl,$cl,$ol,$ph,$add,$oh,$ns,$extra_inc1,$extra_inc2,$leave_encash,$reward,$extra_ded1,$extra_ded2,$leftdate,$invalid,$comp_id,$user_id,$wagediff,$Allow_arrears,$Ot_arrears,$income_tax,$society,$canteen,$remarks);




if($result>0) {
    echo "<script>window.location.href='/tran-day?msg=update';</script>";exit();
}
else{
    echo "<script>window.location.href='/tran-day?msg=fail';</script>";exit();
}
?>

