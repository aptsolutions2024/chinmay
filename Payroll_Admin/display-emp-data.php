<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

error_reporting(0);
if($_SESSION['log_type']==2)
{
    
}else
{
    echo "<script>window.location.href='/payroll-logout';</script>";exit();
}
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$clientid = $_REQUEST['cid'];
$fielda = $_REQUEST['fielda'];
$fieldb = $_REQUEST['fieldb'];
$fieldc = $_REQUEST['fieldc'];
$fieldd = $_REQUEST['fieldd']; 
$limitfrom = $_REQUEST['limitfrom']; 
$limitto = $_REQUEST['limitto'];
?>
<div class="twelve" id="margin1" >
	<div class="one columns bgColor1 Color3 test-upper"><b>Sr. No</b></div>
	<div class="three columns bgColor1 Color3 test-upper"><b>Emp Name</b></div>
	<div class="two columns bgColor1 Color3 test-upper"><b><?php echo $fielda;?></b></div>
	<div class="two columns bgColor1 Color3 test-upper"><b><?php echo $fieldb;?></b></div>
	<div class="two columns bgColor1 Color3 test-upper"><b><?php echo $fieldc;?></b></div>
	<div class="two columns bgColor1 Color3 test-upper"><b><?php echo $fieldd;?></b></div>
</div>

<div style="min-height:235px;max-height:235px;  border: 1px solid gray; padding-bottom: 20px; overflow-y: scroll;">

<input type="hidden" name="fielda" value="<?php if($fielda!=''){echo $fielda;}?>">
<input type="hidden" name="fieldb" value="<?php if($fielda!=''){echo $fieldb;}?>">
<input type="hidden" name="fieldc" value="<?php if($fielda!=''){echo $fieldc;}?>">
<input type="hidden" name="fieldd" value="<?php if($fielda!=''){echo $fieldd;}?>">
<?php
//$res = $payrollAdmin->getEmpData($clientid,$fielda,$fieldb,$fieldc,$fieldd);
$res = $payrollAdmin->getEmpDataFromTo($clientid,$fielda,$fieldb,$fieldc,$fieldd,$limitfrom,$limitto);

$i=($limitfrom==0)?1:$limitfrom+1;

foreach($res as $row){
    
?>

<input type="hidden" name="empid[]" value="<?php echo $row['emp_id'];?>">

    <div class="twelve bgColor2">
        <div class="one columns "><span><?php echo $i;?></span></div>
        <div class="three columns"><span><?php 
echo $row['fn']." "; echo strtoupper(substr($row['mn'], 0, 1)).". "; echo $row['ln']." - ";  echo $i; 
?></span></div>
        <?php 
        if($fielda=='uan' ||  $fieldb =='uan' || $fieldc=='uan' || $fieldc=='uan'){
            
        }?>
        <div class="two columns"><input class="textclass" type="text" name="texta[]" id="text1<?php echo $row['emp_id'];?>" value="<?php if($row[0]!=''){ echo $row[0]; } ?>" /></div>
        <div class="two columns"><input class="textclass" type="text" name="textb[]" id="text2<?php echo $row['emp_id'];?>" value="<?php if($row[1]!=''){ echo $row[1]; } ?>" /></div>
        <div class="two columns"><input class="textclass" type="text" name="textc[]" id="text3<?php echo $row['emp_id'];?>" value="<?php if($row[2]!=''){ echo $row[2]; } ?>" /></div>
		<div class="two columns"><input class="textclass" type="text" name="textd[]" id="text4<?php echo $row['emp_id'];?>" value="<?php if($row[3]!=''){ echo $row[3]; } ?>" />	</div>
        <div class="clearFix"></div>
	</div>

	<div class="clearfix"></div>
	
<?php

    $i++; }
if(count($res)==0) {?>
<div class="twelve bgColor2">
<span class="errorclass">&nbsp;No Record Found</span>
</div>

<?php }
    if(count($res)!=0) {?>
    <div class="twelve " style="background-color: #fff;">
        <br/>
      &nbsp; &nbsp; <input type="submit" value="Update" name="submit"  class="btnclass"  >
    </div>

<?php } ?>
</div>