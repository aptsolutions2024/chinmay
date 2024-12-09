<?php
echo "Inside - Update Adv"; die;

$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');
$comp_id=$_SESSION['comp_id'];

 $row=$payrollAdmin->updateEmpAdv($comp_id);
 $row11=$payrollAdmin->getEmpAdv($comp_id);
foreach($row11 as $row1)
	{
		echo "<br> ".$row1['emp_advnacen_id'];
		
		$row3=$payrollAdmin->getHistAdv($row1['emp_advnacen_id']);
		$row4=$payrollAdmin->updateEmpadvnacen($row3['sal_month'],$row1['emp_advnacen_id']);
		;
	}

?>