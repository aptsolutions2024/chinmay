<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

$user_id = $_SESSION['log_id'];

$clientid = $_REQUEST['client'];

$optype = $_REQUEST['optype'];
$billno = $_REQUEST['billno'];
 $billdate = $_REQUEST['billdate'];
?>

<script>
 function delrow(id) {
	    //alert(1);
        if(confirm('Are you You Sure want to delete this record?')) {
            $.post('/delete-other-payment-details', {
                'id': id
            },function(data){ 
			//$("#row"+id).css("background-color", "#fff");
			//$("#amountinp"+id).val("");
			//$("#del"+id).hide();
                $("#success2").html("Recourd Delete Successfully!");
				showList1();
              // alert('Recourd Deleted Successfully');
              });
        }
 }
 function update(id){
	 var amount = $("#editamountinp"+id).val();
	 //alert(amount);
	 $.ajax({
            type:'post',
            url:'/op-details-update-process',
            dataType: "text",
            data: {'amount':amount,'id':id},
            success: function(result){	 //alert(result);	
			$("#test").html(result);
			//showList1();
			//console.log(result);
		
                $("#success").html(result);
				 $("#up"+id+" img").css("border","1px solid #50a335");
				 $("#up"+id+" img").css("background","rgb(241, 255, 236)");
            }
        });
 }
 function lockBill(billid,op,clientid){
	 $.ajax({
            type:'post',
            url:'op-details-lock.php',
            dataType: "text",
            data: {'billid':billid,'op':op,'clientid':clientid},
            success: function(result){	 //alert(result);	
			$("#test").html(result);
			showList1();
                $("#success").html("Record Are Locked Successfully");				 
            }
        });
 }
</script>
 	<script>
$(document).ready(function() {
    $('#submitopdetails').on('submit',function(e){ 
         e.preventDefault();
        var form = $(this);
        $.ajax({
            type:'post',
            url:'/op-details-process',
            dataType: "text",
            data: form.serialize(),
            success: function(result){
            alert(result.trim()+" Record Successfully Added/Updated");	
			$("#test").html(result.trim()+" Record Successfully Added/Updated");
             //$("#test").text(result);			
           showList1();
                $("#success").html(result.trim()+" Record Successfully Added/Updated");
            }
        });
        // Prevents default submission of the form after clicking on the submit button. 
        return false;   
    });
}); 
	 
</script>	
<?php 


/* $calculationfrm = $_REQUEST['calculationfrm'];
$calculationfrm = date('Y-m-d',strtotime($calculationfrm));
$calculationto = $_REQUEST['calculationto'];
$calculationto = date('Y-m-d',strtotime($calculationto));
 */
$compid =$_SESSION['comp_id'];

$empdate = $payrollAdmin->showOtherPaymentEmployee($clientid);
//print_r($empate);
//$num = $empdate->rowCount();

$clientdtl = $payrollAdmin->displayClient($clientid);
 $clientdtl['current_month'];

 
?><div id="test"></div>
<form action="/op-details-process" id="submitopdetails" method="post">
<input type="hidden" name="client" value="<?php echo $clientid;?>">
<input type="hidden"  name="optype" value="<?php echo $optype;?>">
<input type="hidden"  name="billno" value="<?php echo $billno;?>">
<input type="hidden"  name="billdate" value="<?php echo $billdate;?>">
<table width="100%" class="bgColor3">
 <tr>
	<th>Sr. No <input type="checkbox" name="allcheck[]" value="all" id ="allcheck" onclick="checkAll(this.val)" > All</th>
	<th>Emp Id</th>
	<th>Name</th>	 
	
	<th>Amount</th>
	<th>Action</th>
 </tr>
 <?php $i =0;
 $j=1;
       
    
 //foreach($empdate as $emp){
	$recordno =  sizeof($empdate); 
	$rec =0;
	$lockflag = 0;
	if($recordno >0){
	  foreach($empdate as $emp){  
	 
		 $checkuser = $payrollAdmin->checkEmpDetailsinOP($emp['emp_id'],$billno,$optype,$clientid);
			 
			//echo $getemp['amount'];
			 if($checkuser !=0){ 
			 $getemp = $payrollAdmin->getOtherPaymentEmployee($emp['emp_id'],$billno,$optype,$clientid);
			  $recopemp = sizeof($empdate);
			  $rec++;
	 ?>
	
 <tr <?php if($getemp['amount']!=""){?>style="background:#ffebeb"<?php }?> id="row<?php echo  $getemp['id'];?>">
	 <td><?php echo $j; ?> <!--<input type="checkbox" value="<?php //echo $emp['emp_id'];?>" name="chkbox[]" class="selectchk"  disabled>--></td>
	 <td ><?php echo $emp['emp_id'];?></td>
	 <td><?php echo $emp['first_name']." ".$emp['middle_name']." ".$emp['last_name'];?></td>
	<!-- <td><?php //echo $chkbankdtl['ob']; ?>  <input type="text" value="<?php //echo date('d-m-Y',strtotime($getemp['payment_date']));?>" name="pdate[]" class="textclass payment_date"  onfocus="calbala(<?php //echo $i;?>);" onkeyup="calbala(<?php ///echo $i;?>);" id="ob<?php //echo $i;?>"> </td>-->
	 <td><span id="amounttxt<?php echo $i;?>"></span> <input type="text" value="<?php echo $getemp['amount'];?>" name="amount1[]"  id="editamountinp<?php echo $getemp['id'];?>" class="textclass" <?php  if($getemp['loc']=='1'){echo "disabled"; $lockflag = 1;}?>></td>
	 <td>  
	 <?php if($getemp['amount']!=""){?>
	 <?php  if($getemp['loc']!='1'){?>
	 <a href="javascrip:void()" onclick="delrow(<?php echo  $getemp['id'];?>)" id="del<?php echo $getemp['id'];?>">
	 <img src="Payroll/images/delete-icon.png"/></a> <a onclick="update(<?php echo $getemp['id']; ?>)" id="up<?php echo $getemp['id']; ?>"><img src="Payroll/images/edit-icon.png"/> </a><?php } }?>
</td>
 </tr>
	<?php }else{?>
		 <tr style="background:#fff">
	 <td><?php echo $j; ?> <input type="checkbox" value="<?php echo $i;?>" name="chkbox[]" class="selectchk"  ></td>
	 <td><?php echo $emp['emp_id'];?><input type="hidden" value="<?php echo $emp['emp_id'];?>" name="chkemp[]" class="selectchk"  ></td>
	 <td><?php echo $emp['first_name']." ".$emp['middle_name']." ".$emp['last_name'];?></td>
	 <!--<td><?php //echo $chkbankdtl['ob']; ?>  <input type="text" value="<?php //echo $billdate;?>" name="pdate[]" class="textclass payment_date"  onfocus="calbala(<?php //echo $i;?>);" onkeyup="calbala(<?php //echo $i;?>);" id="ob<?php //echo $i;?>"> </td>-->
	 <td><input type="text" value="" name="amount[]"  id="amountinp<?php echo $i;?>"  class="textclass"></td>
	 <td>  
	 
	 
</td>
 </tr>
	<?php $i++;} $j++;} }//else {?>
<!--<tr style="background:#ffebeb">
	 <td><?php //echo $i; ?> <input type="checkbox" value="<?php //echo $emp['emp_id'];?>" name="chkbox[]" class="selectchk"  ></td>
	 <td><?php //echo $emp['first_name']." ".$emp['middle_name']." ".$emp['last_name'];?> <input type="hidden" value="<?php //echo $emp['emp_id'];?>" name="empid[]"></td>
	 <td><?php //echo $chkbankdtl['present'];?> <input type="hidden" name="preday[]" value="<?php //echo $chkbankdtl['present'];?>"></td>
	 <td><?php //echo $chkbankdtl['present'];?> <input type="hidden" name="preday[]" value="<?php //echo $chkbankdtl['present'];?>"></td>
	 <td><?php //echo $chkbankdtl['ob']; ?>  <input type="text" value="<?php //echo $chkbankdtl['ob'];?>" name="obday[]" class="textclass"  onfocus="calbala(<?php //echo $i;?>);" onkeyup="calbala(<?php echo $i;?>);" id="ob<?php echo $i;?>"> </td>
	 <td><span id="amounttxt<?php //echo $i;?>"><?php //echo $emp['amount'];?></span> <input type="hidden" value="<?php //echo $chkbankdtl['amount'];?>" name="amount[]"  id="amountinp<?php echo $i;?>"></td>
	 <td>  
	 
	 <a href="javascrip:void()" onclick="delrow(<?php //
	 echo  $chkbankdtl2['leave_details_id'];?>)">
                                <img src="../images/delete-icon.png"/></a>
</td>
 </tr>-->
<?php //}?>
 <?php $i++; //} 
 if($i ==1){?>
<tr align="center">
	<td colspan="10" class="tdata errorclass">
		<span class="norec">No Record found</span>
	</td>
<tr>
 <?php }?>
 <tr>
 <td></td>
<td ><input type="submit" value="Submit" class="btnclass" <?php if ($lockflag == 1){echo "disabled";} ?> ></td>
<td colspan="2" class="successclass" id="success"></td>
<td><?php if($rec >0){?><input type="button" value="Lock" class="btnclass"  onclick="lockBill(<?php echo $billno.",".$optype.",".$clientid; ?>)"><?php }?></td>
</tr>
 </table>
 </form>
  <script>
        $( function() {
            $(".payment_date").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat:'dd-mm-yy'
            });
            
			
        } );</script>
 <div id="test"></div>
