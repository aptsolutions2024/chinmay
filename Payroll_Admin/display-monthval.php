<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

if($_SESSION['log_type']==2 || $_SESSION['log_type']==3 )
{
    
}else
{
    echo "<script>window.location.href='/payroll-logout';</script>";exit();
}
  $id = $_REQUEST['id'];

  $result2 = $payrollAdmin->displayClient($id);
  $dt=$result2['current_month'];

echo "<b>".date("M Y", strtotime($dt))."</b>";

	 ?><input type="hidden" id="cm" name="cm" value="<?php echo $dt; ?>">