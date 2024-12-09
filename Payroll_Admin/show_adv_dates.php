<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

$advdate = $payrollAdmin->getadvdates($_REQUEST['emp_id']);
?>
 <select name="advdate" class="textclass" id="advdate" >
		   <option value="">-- Select Date --</option>
		   <?php foreach($advdate as $advdate1) {?>
		   <option value="<?php echo $advdate1['date'];?>"><?php echo date('d-m-Y',strtotime($advdate1['date']));?></option>
		   <?php }?>
		   </select>
	
