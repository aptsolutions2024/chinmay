<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

$client = $_REQUEST['client'];
$leavetype = $_REQUEST['leavetype'];

$row = $payrollAdmin->getOpeningTypeDate($client,$leavetype);
?>
 <div class="four padd0 columns"  >
	
		<div class="five  columns " >
			<span class="labelclass1"> &nbsp; From Date</span>
		</div>
		<div class="seven columns">
			<input type="text" name="frdt" id="frdt" class="textclass" value="">
			<span class="errorclass hidecontent" id="frdterror"></span>
		</div> 
</div>
 <div class="four padd0 columns"  >
 <div class="five  columns pdl10p" id = "prv_to" >
			<span> To Date</span>
		</div>
		<div class="seven columns" >
			<input type="text" name="todt" id="todt" class="textclass" >
			<span class="errorclass hidecontent" id="todterror"></span>
		</div>
		
</div>