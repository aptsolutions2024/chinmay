<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

 $client = $_SESSION['clintid'];
$row = $payrollAdmin->getEmployeeDetailsByClientId($client);
?>
<select id="employee" name="employee" class="textclass">
<option>-- select --</option >
<?php foreach($row as $res) {?>	
	<option value="<?php echo $res['emp_id'];?>"><?php echo $res['first_name']." ".$res['middle_name']." ".$res['last_name'];?></option >	
<?php }
?>
</select>