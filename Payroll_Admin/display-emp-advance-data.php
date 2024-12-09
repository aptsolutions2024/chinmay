<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

if($_SESSION['log_type']==2)
{
    
}else
{
    echo "<script>window.location.href='/payroll-logout';</script>";exit();
}


include("../lib/class/advance.php");
include("../lib/class/common.php");
$advance =new advance();
$common = new common();
$advid = $_REQUEST['advid'];
$clientid = $_REQUEST['clientid'];
$date = date('Y-m-d',strtotime($_REQUEST['advdate']));
?>

<div class="twelve" id="margin1" >
    <div class="one columns bgColor1 Color3"><b>Sr. No</b></div>
    <div class="three columns bgColor1 Color3"><b>Employee Name</b></div>
    <div class="two columns bgColor1 Color3"><b>Advance Amount</b></div>
    <div class="three columns bgColor1 Color3"><b>Advance Installment</b></div>
	<div class="three columns bgColor1 Color3"><b>Received Amt</b></div>
	
<!--/*     <div class="three columns bgColor1 Color3"><b>Close On</b></div> -->

</div>


<form action="/display-emp-advance-data-process"  method="post" name="advance" id="advance">
<input type="hidden" name="advtype" id="advtype" value="<?=$advid;?>">
<input type="hidden" name="advdate" id="advdate" value="<?=$date;?>">
<?php
//$sqlalladv = $advance->getListAllAdvance($advid,$clientid);

$sqlalladv = $common->displayemployeeClient($clientid);
$numdata = $sqlalladv->rowCount();

$i=1;
//while($row = mysql_fetch_array($res)){
	foreach($sqlalladv as $row){
		$advid = $advance->getAdvanceDetailsByEmpId($row['emp_id'],$date,$advid);
		//print_r($advid);
		
?>
<input type="hidden" name="emp_adv_id[]" value="<?php echo $row['emp_id'];?>">


	<div class="twelve bgColor2" >
        <div class="one columns"  class="centered"><?php echo $i;?></div>
        <div class="three columns"> <?php 
echo $row['first_name']." "; echo strtoupper(substr($row['middle_name'], 0, 1)).". "; echo $row['last_name']." - ";  echo $i; 
?></div>
        
       
        <div class="two columns">
            <input class="textclass" type="number" name="advamt[]" id="text1<?php echo $row['emp_id'];?>" value="<?php echo $advid['adv_amount'];?>" style="width: 100%;">
        </div>
        <div class="three columns">
            <input class="textclass" type="number" name="advinstall[]" id="text2<?php echo $row['emp_id'];?>" value="<?php echo $advid['adv_installment'];?>"> 
        </div>
        <div class="three columns">
            <input class="textclass advdate" type="text" name="received_amt[]" id="text3<?php echo $row['emp_id'];?>" value="<?php if(isset($advid['received_amt'])) { echo $advid['received_amt']; }?>">
        </div>

        <div class="clearFix"></div>
	</div>

    <div class="clearFix"></div>
	
<?php
    $i++; }
    if($numdata!=0) {?>
    <div class="twelve" >
        <br/>
       <input type="submit" value="Update" name="submit"  class="btnclass"  >
    </div>

<?php }?>
</form>
<?php if($numdata==0) {?>
<div class="twelve bgColor2">
<span class="errorclass">&nbsp;No Record Found</span>
</div>

<?php }?>
<div id="succsmg" class="successclass" style="display:none">Record Successfuly added/updated</div>
<script>
    $( document ).ready(function() {		
		$( ".advdate" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat:'dd-mm-yy'
        });
	
    $('#advance').on('submit',function(){   
	var advid = $("#advid").val();  
	var date = $("#date").val(); 
	$("#advtype").val(advid);
	$("#advdate").val(date);
	

        var form = $(this);
        $.ajax({
            type:'post',
            url:'/display-emp-advance-data-process',
            dataType: "text",
            data: form.serialize(),
            success: function(result){
               // alert(result);
			   $("#succsmg").show();
            }
        });

        // Prevents default submission of the form after clicking on the submit button. 
        return false;   
    });
});
	</script>