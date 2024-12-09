<?php 
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');
error_reporting(E_ALL);
ini_set('max_input_vars', 0);
$user_id = $_SESSION['log_id'];
$lmt = $_REQUEST['lmt'];

 $clintid = $_REQUEST['client'];
$emp = $_REQUEST['emp'];
$empid = $_REQUEST['empid'];
$leave_type = $_REQUEST['leavetype'];
$frdt = $_REQUEST['frdt'];
$frdt = date('Y-m-d',strtotime($frdt));
$todt = $_REQUEST['todt'];
$todt = date('Y-m-d',strtotime($todt));
$payment_date = $_REQUEST['payment_date'];
$payment_date = date('Y-m-d',strtotime($payment_date));


?>

<script>
 function delrow(id) {
	    //alert(1);
        if(confirm('Are you You Sure want to delete this record?')) {
            $.post('/delete-leave-record', {
                'id': id
            },function(data){
                $("#success2").html("Recourd Delete Successfully!");
              // alert('Recourd Deleted Successfully');
              });
        }
 }
</script>
 	<script>
$(document).ready(function() {
    $('#encashment').on('submit',function(){
        var form = $(this);
        $.ajax({
            type:'post',
            url:'/encashment-process',
            dataType: "text",
            data: form.serialize(),
            success: function(result){	 alert(result);	
//$("#test").text(result);			
                $("#success").html("Record Successfully Added/Updated");
            }
        });
        // Prevents default submission of the form after clicking on the submit button. 
        return false;   
    });
});



function calbala(id){ //alert(id);
		 var ob = Number($("#ob"+id).val());
		 var calcul = Number($("#calcul"+id).val());
		 var enjoy = Number($("#enjoy"+id).val());
		 var balval = parseFloat(ob)+parseFloat(calcul)-parseFloat(enjoy);
		 var rate = $("#rate"+id).val();
		 $("#bal"+id).val(balval);
		 $("#baltext"+id).text(balval);
		  $("#encash"+id).val(balval);
		  var amountt = parseFloat(rate)*parseFloat(balval);
		  $("#amounttxt"+id).text(amountt);
		  $("#amountinp"+id).val(amountt);
		 
		 
		 
		 
	 }
	 
function checkEmp()
{
    var checkboxes = document.getElementsByName('chkbox[]');
    var checkedvals = "";
    for (var i=0, n=checkboxes.length;i<n;i++) 
    {
    if (checkboxes[i].checked) 
    {
    checkedvals += ","+checkboxes[i].value;
    }
    }
    if (checkedvals) checkedvals = checkedvals.substring(1);
    if(checkedvals=='')
    {
        alert("Please select employee.");
        return false;
    }
    //return false;
}
	 
</script>	
<?php 


/* $calculationfrm = $_REQUEST['calculationfrm'];
$calculationfrm = date('Y-m-d',strtotime($calculationfrm));
$calculationto = $_REQUEST['calculationto'];
$calculationto = date('Y-m-d',strtotime($calculationto));
 */$presentday = $_REQUEST['presentday'];
$compid =$_SESSION['comp_id'];

$empdates = $payrollAdmin->showleaveEmployee($frdt,$todt,$clintid,$leave_type,$emp,$empid,$lmt);
$empdate=$empdates[0];
 $tcounts = $payrollAdmin->showleaveEmployee($frdt,$todt,$clintid,$leave_type,$emp,$empid,$lmt);
 $tcount=$tcounts[1];
// $num = $empdate->rowCount();

$clientdtl = $payrollAdmin->displayClient($clintid);
 $clientdtl['current_month'];
 $lock =0;
 if($presentday==20){
	 $lock =21;
 }
 if($presentday==11.43){
	 $lock =21;
 }
 
?>
<form action="/encashment-process" id="encashment" method="post" onsubmit="return checkEmp();">
<input type="hidden" name="client" value="<?php echo $clintid;?>">
<input type="hidden"  name="leavetype" value="<?php echo $leave_type;?>">
<input type="hidden"  name="frdt" value="<?php echo $frdt;?>">
<input type="hidden"  name="todt" value="<?php echo $todt;?>">

<input type="hidden"  name="payment_date" value="<?php echo $payment_date;?>">
<input type="hidden" id="checkedValues" name="checkedValues" value="">
<table width="100%" class="bgColor3">
 <tr>
	 <th>Sr. No <input type="checkbox" name="allcheck[]" value="all" id ="allcheck" onclick="checkAll(this.val)" > All</th>
	<th>Name</th>
	<th>JoinDate</th>
	 <th>Present Day</th>
	 <th>Ob</th>
	 <th>Earned</th>
	 <th>Enjoyed</th>
	 <th>Balanced</th>
	 <th>Encashed</th>
	 <th>Rate Rs.</th>
	 <th>Amount</th>
	 <th>Action</th>
 </tr>
 
 <?php $i =1;
       
      if( $clientdtl['current_month'] <= $todt){$tab = 'tran_income';$tab_emp = 'tran_employee';$calc_month = $clientdtl['current_month'];}
	  else {$tab='hist_income';$tab_emp = 'hist_employee';$calc_month = $todt;}
 foreach($empdate as $emp){
	 //while($emp=mysql_fetch_array($empdate)){
	     //print_r($emp);
		//echo $emp['emp_id'];
	 $getcalculated = $payrollAdmin->getCalculated($frdt,$todt,$emp['emp_id'],$clintid);
	 $getcalculated_curr = $payrollAdmin->getCalculated_curr($frdt,$todt,$emp['emp_id'],$clintid);
	 $present=$getcalculated+$getcalculated_curr;
	  
	           if ($presentday >0 ){
				
    				$getcalculated = round($present/$presentday,0);
				
				if ($getcalculated>21 && $presentday=="11.43" ) $getcalculated= 21;}
				
			   else{
					$getcalculated = 0;
			   }
			   //echo "<pre>";print_r(job_status);
			 	if($emp['job_status'] =="C" || $emp['job_status'] =="P"){
					
						$rate = $payrollAdmin->GetAmountForEncashmentNoLeftEmp($emp['emp_id'],$todt,$compid,$tab,$tab_emp,$clintid,$calc_month);
				   
				}else{
					 
				    $rate = $payrollAdmin->getAmountForEncashmentLeftEmp($emp['emp_id'],$frdt,$todt);
				}
				
				if ($rate['amount']==0||$rate['amount']=='' || $rate['amount']== null){
					   
							$rate = $payrollAdmin->getAmountForEncashmentLeftEmp($emp['emp_id'],$frdt,$todt);
				}
				
				$amt = $rate['amount'];
				$rate = $amt ;

			   
			  $obdtl = $payrollAdmin->getOB($emp['emp_id'],$clintid,$leave_type,$frdt,$todt);
			  $obdtlday = $payrollAdmin->getDetailsFromLDays($emp['emp_id'],$clintid,$leave_type,$frdt,$todt);
			  $obdtlday21 = $payrollAdmin->getDetailsFromLDays_curr($emp['emp_id'],$clintid,$leave_type,$frdt,$todt);
			  
			  
			  
			 
			 $pday =$obdtlday['presentsum'];  
			//echo $obdtlday['sumt']; 
			  
		$chkbankdtl = $payrollAdmin->checkEncashment($frdt,$todt,$emp['emp_id'],$clintid,$leave_type);
		$chkbankdtl2 = $payrollAdmin->checkEncashmentRow($frdt,$todt,$emp['emp_id'],$clintid,$leave_type);
	
	 if ($leave_type == 1 or $leave_type==4 ){
	    
if($chkbankdtl2!=null){	
	 ?>
	 <tr style="background:#ffebeb">
	 <td><?php echo $i; ?> <input type="checkbox" value="<?php echo $emp['emp_id'];?>" name="chkbox[]" class="selectchk"  ></td>
	 <td><?php echo $emp['first_name']." ".$emp['middle_name']." ".$emp['last_name'].' - '.$emp['emp_id'];?> <input type="hidden" value="<?php echo $emp['emp_id'];?>" name="empid[]"></td>
	  <td><?php echo date("d-m-y",strtotime($emp['joindate'])); ?></td>
	 <td><?php echo $chkbankdtl['present'];?> <input type="hidden" name="preday[]" value="<?php echo $chkbankdtl['present'];?>"></td>
	 <td><?php //echo $chkbankdtl['ob']; ?>  <input type="text" value="<?php echo $chkbankdtl['ob'];?>" name="obday[]" class="textclass"  onfocus="calbala(<?php echo $i;?>);" onkeyup="calbala(<?php echo $i;?>);" id="ob<?php echo $i;?>"> </td>
	 <td><?php $earned = $chkbankdtl['earned']; if($presentday==12 && $earned >21){$earned =21;} echo $earned; ?> <input type="hidden" value="<?php echo $earned;?>" name="earned[]" id="calcul<?php echo $i;?>"></td>
	 <td><?php echo $chkbankdtl['enjoyed'];?> <input type="hidden" value="<?php echo $chkbankdtl['enjoyed'];?>" name="enjoyed[]" id="enjoy<?php echo $i;?>"></td>
	 <td><span id="baltext<?php echo $i;?>"><?php echo $chkbankdtl['balanced'];?><span> <input type="hidden" value="<?php echo $chkbankdtl['balanced'];?>" name="balance[]" id="bal<?php echo $i;?>"> </td>
	 <td> <input type="text" value="<?php echo $chkbankdtl['encashed'];?>" name="encashed[]" class="textclass " id="encash<?php echo $i;?>"onfocus="rateCal(<?php echo $i;?>);" onkeyup="rateCal(<?php echo $i;?>);"></td>
	 <td><input type="text" value="<?php echo $chkbankdtl['rate'];?>" name="rate[]" class="textclass " id="rate<?php echo $i;?>" onfocus="rateCal(<?php echo $i;?>);" onkeyup="rateCal(<?php echo $i;?>);"></td>
	 <td><span id="amounttxt<?php echo $i;?>"><?php echo $chkbankdtl['amount'];?></span> <input type="hidden" value="<?php echo $chkbankdtl['amount'];?>" name="amount[]"  id="amountinp<?php echo $i;?>"></td>
	 <td>  
	 
	 <a href="javascrip:void()" onclick="delrow(<?php echo  $chkbankdtl2['leave_details_id'];?>)">
                                <img src="Payroll/images/delete-icon.png"/></a>
</td>
 </tr>
<?php } else {  ?>
 <tr >
	 <td><?php echo $i; ?> <input type="checkbox" value="<?php echo $emp['emp_id'];?>" name="chkbox[]" class="selectchk"  ></td>
	 <td><?php echo $emp['first_name']." ".$emp['middle_name']." ".$emp['last_name'].' - '.$emp['emp_id'];?> <input type="hidden" value="<?php echo $emp['emp_id'];?>" name="empid[]"></td>
	  <td><?php echo date("d-m-y",strtotime($emp['joindate'])); ?></td>
	 <td><?php echo $present;?> <input type="hidden" name="preday[]" value="<?php echo $present;?>"></td>
	 
	 <td><?php //echo $obdtl;?>  <input type="text" value="<?php echo $obdtl;?>" name="obday[]" class="textclass" onfocus="calbala(<?php echo $i;?>);" onkeyup="calbala(<?php echo $i;?>);" id="ob<?php echo $i;?>"></td>
	 
	 <td><?php //echo $getcalculated; 
	 if($presentday==12 && $getcalculated >21){$getcalculated =21;} echo $getcalculated;?> <input type="hidden" value="<?php echo $getcalculated;?>" name="earned[]" id="calcul<?php echo $i;?>"></td>
	 
	 <td><?php   $enjoyed = $obdtlday['sumt']+$obdtlday21['sumt']; echo round($enjoyed,2); ?> <input type="hidden" value="<?php echo round($enjoyed,2);?>" name="enjoyed[]" id="enjoy<?php echo $i;?>"></td>
	 
	 <td><span id="baltext<?php echo $i;?>"><?php echo $balance = $obdtl+$getcalculated-$enjoyed;?></span> <input type="hidden" value="<?php echo $balance;?>" name="balance[]" id="bal<?php echo $i;?>"></td>
	 
	 <!--<td> <input type="text" value="<?php echo $balance;?>" name="encashed[]" class="textclass " id="encash<?php //echo $i;?>"onfocus="rateCal(<?php //echo $i;?>);" onkeyup="rateCal(<?php //echo $i;?>);"></td>-->
	 
	 <td> <input type="text" value="<?php $encash = 0; echo $encash;?>" name="encashed[]" class="textclass " id="encash<?php echo $i;?>"onfocus="rateCal(<?php echo $i;?>);" onkeyup="rateCal(<?php echo $i;?>);"></td>

	 <td><?php echo $rate;?>
	 <input type="hidden" value="<?php echo $rate;?>" name="rate[]" id="rate<?php echo $i;?>">
	 </td>
	 
	 <td><span id="amounttxt<?php echo $i;?>"><?php echo round($rate*$encash,0);?></span> <input type="hidden" value="<?php echo round($rate*$encash,0);?>" name="amount[]"  id="amountinp<?php echo $i;?>"></td>
 </tr>
	 <?php }}
	 else
	 {
	




	
if($chkbankdtl2!=null){	 
	 ?>
	 <tr style="background:#ffebeb">
	 <td><?php echo $i; ?> <input type="checkbox" value="<?php echo $emp['emp_id'];?>" name="chkbox[]" class="selectchk"  ></td>
	 <td><?php echo $emp['first_name']." ".$emp['middle_name']." ".$emp['last_name'].' - '.$emp['emp_id'];?> <input type="hidden" value="<?php echo $emp['emp_id'];?>" name="empid[]"></td>
	  <td><?php echo date("d-m-y",strtotime($emp['joindate'])); ?></td>
	 <td><?php echo "0";?> <input type="hidden" name="preday[]" value="0"></td>
	 <td>  <input type="text" value="<?php echo $chkbankdtl['ob'];?>" name="obday[]" class="textclass"  onfocus="calbala(<?php echo $i;?>);" onkeyup="calbala(<?php echo $i;?>);" id="ob<?php echo $i;?>"> </td>
	 <td><?php $earned = 0; echo $earned; ?> <input type="hidden" value="<?php echo $earned;?>" name="earned[]" id="calcul<?php echo $i;?>"></td>
	 <td><?php echo $chkbankdtl['enjoyed'];?> <input type="hidden" value="<?php echo $chkbankdtl['enjoyed'];?>" name="enjoyed[]" id="enjoy<?php echo $i;?>"></td>
	 <td><span id="baltext<?php echo $i;?>"><?php echo $chkbankdtl['balanced'];?><span> <input type="hidden" value="<?php echo $chkbankdtl['balanced'];?>" name="balance[]" id="bal<?php echo $i;?>"> </td>
	 <td> <input type="text" value="0" name="encashed[]" class="textclass " id="encash<?php echo $i;?>"></td>
	 <td><input type="text" value="0" name="rate[]" class="textclass " id="rate<?php echo $i;?>" onfocus="rateCal(<?php echo $i;?>);" ></td>
	 <td><span id="amounttxt<?php echo $i;?>"><?php echo $chkbankdtl['amount'];?></span> <input type="hidden" value="0" name="amount[]"  id="amountinp<?php echo $i;?>"></td>
	 <td>  
	 
	 <a href="javascrip:void()" onclick="delrow(<?php echo  $chkbankdtl2['leave_details_id'];?>)">
                                <img src="Payroll/images/delete-icon.png"/></a>
</td>
 </tr>
<?php } else {?>
 <tr >
	 <td><?php echo $i; ?> <input type="checkbox" value="<?php echo $emp['emp_id'];?>" name="chkbox[]" class="selectchk"  ></td>
	 <td><?php echo $emp['first_name']." ".$emp['middle_name']." ".$emp['last_name'].' - '.$emp['emp_id'];?> <input type="hidden" value="<?php echo $emp['emp_id'];?>" name="empid[]"></td>
	  <td><?php echo date("d-m-y",strtotime($emp['joindate'])); ?></td>
	 <td><?php echo $present;?> <input type="hidden" name="preday[]" value="0"></td>
	 
	 <td><?php $obdtl =0;
			/*if ($leave_type == 6 && $clintid ==11){$obdtl =5;}
			if ($leave_type == 5 && $clintid ==11){$obdtl =4;}*/
			?> 
			<input type="text" value="<?php echo $obdtl;?>" name="obday[]" class="textclass" onfocus="calbala(<?php echo $i;?>);" onkeyup="calbala(<?php echo $i;?>);" id="ob<?php echo $i;?>"></td>
	 
	 <td><?php //echo $getcalculated; 
	 $getcalculated= 0;
	  echo $getcalculated;?> <input type="hidden" value="0" name="earned[]" id="calcul<?php echo $i;?>"></td>
	 
	 <td><?php   $enjoyed = $obdtlday['sumt']+$obdtlday21['sumt']; echo round($enjoyed,2); ?> <input type="hidden" value="<?php echo round($enjoyed,2);?>" name="enjoyed[]" id="enjoy<?php echo $i;?>"></td>
	 
	 <td><span id="baltext<?php echo $i;?>"><?php echo $balance = $obdtl+$getcalculated-$enjoyed;?></span> <input type="hidden" value="<?php echo $balance;?>" name="balance[]" id="bal<?php echo $i;?>"></td>
	 
	 <!--<td> <input type="text" value="<?php echo $balance;?>" name="encashed[]" class="textclass " id="encash<?php //echo $i;?>"onfocus="rateCal(<?php //echo $i;?>);" onkeyup="rateCal(<?php //echo $i;?>);"></td>-->
	 
	 <td> <input type="text" value="<?php $encash = 0; echo $encash;?>" name="encashed[]" class="textclass " id="encash<?php echo $i;?>"onfocus="rateCal(<?php echo $i;?>);" onkeyup="rateCal(<?php echo $i;?>);"></td>
	 
	 <td><input type="text" value="<?php $rate =0;echo $rate;?>" name="rate[]" class="textclass " id="rate<?php echo $i;?>" ></td>
	 
	 <td><span id="amounttxt<?php echo $i;?>"><?php echo "0";?></span> <input type="hidden" value="<?php echo "0";?>" name="amount[]"  id="amountinp<?php echo $i;?>"></td>
 </tr>
	 <?php }		 
	























	
		 
	 }
	 	 
	 ?>
 <?php $i++; } 
 if($tcount==0){?>
<tr align="center">
	<td colspan="10" class="tdata errorclass">
		<span class="norec">No Record found</span>
	</td>
<tr>
 <?php }?>
 <tr>
 <td></td>
<td ><input type="submit" value="Submit" class="btnclass"></td>
<td colspan="8" class="successclass" id="success"></td>
</tr>
 </table>
 </form>
 <div id="test"></div>
