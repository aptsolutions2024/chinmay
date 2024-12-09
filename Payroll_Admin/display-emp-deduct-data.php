<?php
$doc_path=$_SERVER["DOCUMENT_ROOT"];
include ($doc_path.'/include_payroll_admin.php');

$payrollAdmin = new payrollAdmin();
error_reporting(E_ALL);

if($_SESSION['log_type']==2)
{
    
}else
{
    echo "<script>window.location.href='/payroll-logout';</script>";exit();
}
$destid = $_REQUEST['destid'];
$clientid = $_REQUEST['clientid'];
include("../lib/class/common.php");
$common = new common;
$caltype = $common->deductCalculationType();
?>
<div class="twelve" id="margin1" >
    <div class="one columns bgColor1 Color3"><b>Sr. No</b></div>
    <div class="three columns bgColor1 Color3"><b>Employee Name</b></div>
    <div class="two columns bgColor1 Color3"><b>STD Amount</b></div>
    <div class="three columns bgColor1 Color3"><b>Calculation Type</b></div>
    <div class="three columns bgColor1 Color3"><b>Remark</b></div>

</div>



<?php
$res = $payrollAdmin->deductEmpData($destid,$clientid);


$i=1;
foreach ($res as  $row ){
?>
<input type="hidden" name="emp_de_id[]" value="<?php echo $row['emp_deduct_id'];?>">

	<div class="twelve bgColor2" >
        <div class="one columns"  class="centered"><?php echo $i;?></div>
        <div class="three columns"><?php 
echo $row['fn']." "; echo strtoupper(substr($row['mn'], 0, 1)).". "; echo $row['ln']." - ";  echo $row['emp_id']; 
?></div>
        <div class="two columns">
            <input class="textclass" type="text" name="textdeducta[]" id="text1<?php echo $row['emp_deduct_id'];?>" value="<?php echo $row[0];?>" style="width: 100%;">
        </div>
        <div class="three columns">
            <select name="dedcaltype[]" id="caltype" class="textclass">
                <option value="0">--select-</option>
				<?php foreach($caltype as $type){?>
				<option value="<?php echo $type['id'];?>" <?php if($row[1]==$type['id']){ echo "selected" ;} ?>><?php echo $type['name'];?></option>
				<?php }?>
                <!--<option value="1" <?php if($row[1]=='1'){ echo "selected" ;} ?>>Month's Days - Weeklyoff(26/27)</option>
                <option value="2" <?php if($row[1]=='2'){ echo "selected" ;} ?>>Month's Days - (30/31)</option>
                <option value="3" <?php if($row[1]=='3'){ echo "selected" ;} ?>>Consolidated</option>
                <option value="4" <?php if($row[1]=='4'){ echo "selected" ;} ?>>Hourly Basis</option>
                <option value="5" <?php if($row[1]=='5'){ echo "selected" ;} ?>>Daily Basis</option>
                <option value="6" <?php if($row[1]=='6'){ echo "selected" ;} ?>>Quarterly</option>
                <option value="7" <?php if($row[1]=='7'){ echo "selected" ;} ?>>As per Govt. Rules</option>-->
            </select>
        </div>
        <div class="three columns">
            <input class="textclass" type="text" name="textdeductc[]" id="text3<?php echo $row['emp_deduct_id'];?>" value="<?php echo $row[2];?>">
        </div>

        <div class="clearFix"></div>
	</div>

    <div class="clearFix"></div>
	
<?php

    $i++; }
if(count($res)==0) {?>
<div class="twelve bgColor2">
<span class="errorclass">&nbsp;No Record Found</span>
</div>

<?php }
    if(count($res)!=0) {?>
    <div class="twelve" >
        <br/>
       <input type="submit" value="Update" name="submit"  class="btnclass"  >
    </div>

<?php } ?>