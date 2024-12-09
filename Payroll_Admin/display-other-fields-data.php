<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');
//print_r($_POST);die;
$getiddata = explode('#',$_POST['otherid']);

$prid = $getiddata[0];
$table = $getiddata[1];
$tableprid = $getiddata[2];
 $namefld = $getiddata[3];
 
if($table =="mast_bank"){
	$expfld = explode('|',$namefld);	
	$selname = $table.".".$expfld[0].",".$table.".".$expfld[1];
}else{
	 $selname = $table.".".$namefld;
}


$cl_id = $_POST['clientid'];
?>
<?php





$comp_id=$_SESSION['comp_id'];
//$user_id=$_SESSION['$user_id'];

?>

<input type="hidden" name="fielda" value="<?php if($fielda!=''){echo $fielda;}?>">
<?php
 
  $res = $payrollAdmin->displayOtherFieldsData($selname,$table,$prid,$tableprid,$comp_id,$cl_id);
  $tcount =sizeof($res);
 
  ?>
  <div class="twelve" id="margin1" >
    <div class="two columns paddl0 tbldfrm tit1"><b>Sr. No</b></div>
    <div class="five columns paddl0 tbldfrm tit1"><b>Employee Name</b></div>
    <div class="five columns paddl0 tbldfrm tit1"><b>Field Name</b></div>
   

</div>
<div style="min-height:235px;max-height:530px;  border: 1px solid gray; padding-bottom: 20px; overflow-y: scroll;">

  <?php
$i=1;
foreach($res as $row)
{
   // print_r($row);
?>
<input type="hidden" name="empid[]" value="<?php echo $row['emp_id'];?>">

<div class="twelve bgColor2" >
        <div class="two columns paddl0 tbldfrm tit"  class="centered"><?php echo $i;?></div>
        <div class="five columns paddl0 tbldfrm tit"  class="centered"><?php 
echo $row['fn']." "; echo strtoupper(substr($row['mn'], 0, 1)).". "; echo $row['ln']." - ";  echo $i; 
?></div>
        <?php if($table !="mast_bank"){?>
        <div class="five columns paddl0 tbldfrm tit"  class="centered">
        <select name="<?php echo $table;?>[]" class="textclass">
		<option value=""> Please select <?php echo $namefld;?></option>
		<?php
		$res1 = $payrollAdmin->gettabdataOther($table,$comp_id);
		
		
		foreach($res1 as $row1)
		{
		?>

		<option value="<?php echo $row1[$tableprid]; ?>" <?php if( $row[$prid]==$row1[$tableprid]){echo "selected";} ?>><?php echo $row1[$namefld]; ?></option>
		
	
		<?php }?>
		</select>
        </div>
        <?php } else {?>
        <div class="clear"></div>
        <div class="three columns paddl0 tbldfrm tit"  class="centered">
        <select name="<?php echo $table;?>[]" class="textclass">
		<option value=""> Please select <?php echo $expfld[0];?></option>
		<?php		
		 
		$res12 = $payrollAdmin->gettabdataOther($table,$comp_id);
		
		foreach($res12 as $row12)
		{
			
		?>
		<option value="<?php echo $row12[$tableprid]; ?>" <?php if($row[$prid]==$row12[$tableprid]){echo "selected";}?>><?php echo $row12['ifsc_code']." - ".$row12[$expfld[0]]." - ".$row12['branch']?></option>
		<?php }?>
		</select>
		</div>
		<div class="two columns paddl0 tbldfrm tit"  class="centered">
			<input type="text" name="bank_no[]" id="bank_no" class="textclass" placeholder="Please Enter Bank Account Number." value="<?=$row['bankacno']?>">
			</div>
		<?php } ?>
        
 </div>  


	<div class="clearFix"></div>
	
<?php

    $i++; }

 if($tcount==0) {
?>
 
<div class="twelve bgColor2">
<span class="errorclass">&nbsp;No Record Found</span>
</div>

<?php }
    if($tcount!=0) {
   
    ?>
   
 </div>  

<div style="text-align:center;" id="margin1">
       <input type="submit" value="Update" name="submit"  class="submitbtn"  onclick="saveotherdetails()">
    </div>
    <?php } ?>

