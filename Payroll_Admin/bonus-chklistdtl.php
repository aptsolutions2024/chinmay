 <?php 
 ini_set('display_errors',1);
 ini_set('display_startup_errors',1);
 error_reporting(0);
 $chkno = $_REQUEST['checkn'];
 $checkdate = $_REQUEST['checkdt'];
  $checkdate = $_REQUEST['checkdt'];
 $invoiceno=$_REQUEST['invoiceno'];
 
 session_start();
// print_r($_SESSION);
 $doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

$month=$_SESSION['month'];
$clientid = $_SESSION['clintid'];
$resclt=$payrollAdmin->displayClient($clientid);
 $cmonth=$resclt['current_month'];
$type = "B";
 $empid1 = $_REQUEST['empid1'];

    $tab_emp='bonus';
$startday = $_SESSION['startbonusyear'];
$endday = $_SESSION['endbonusyear'];
if ($empid1 >0 )

{$emplist = $payrollAdmin->getBonusChequeEmployeeByEmpId($empid1,$startday,$endday);
}
else{
	$empid1= 0;
	
$emplist = $payrollAdmin->getBonusChequeEmployeeByClientId($clientid,$tab_emp,$startday,$endday);

}

 ?>
 
 
 <form method="post"  id="addchkdtl" action="/add-bonus-cheque-details">
			  <input type="hidden" value="" id="chkdate" name="chkdate">
			  <input type="hidden" value="" name="print1" id="print1">
			  <input type="hidden" value="<?php echo $cmonth;?>" id="cmonth" name="cmonth">
			  <div id="chkdtllst">

 
			
	<table width="100%" style="background-color:#fff" id="emplist">

	<tr>
	<th align="left" width="5%">Sr No</th>
	<th align="left" width="10%">Invoice No</th>
	<th align="left" width="5%">Emp Id</th>
	<th align="left" width="30%">Emp Name</th>
	<th align="left" width="10%">Amount</th>
	<th align="left" width="12%">Cheque No.</th>
	<th align="left" width="15%">Cheque Date</th>
	<th align="left" width="10%">Action</th>
	</tr>
	
	<?php $srno=1; $no=0;
	while($emp = mysql_fetch_array($emplist)){
		$chkDtl = $userObj->chkBonusDetails($emp['emp_id'],$startday,$endday,'B');
		$cnt = 0;
		$cnt = mysql_num_rows($chkDtl);	
		 $chk = mysql_fetch_array($chkDtl);
	?>
	<tr id="chkdtl<?php echo $srno;?>">
	<td><?php echo $srno; ?></td>
	
	<td><?php echo date("M, Y", strtotime($startday))." TO ". date("M, Y", strtotime($endday)); ?></td>
	
	<td><input name="emp_id[]" type="hidden" value="<?php echo $emp['emp_id'];?>"><?php echo $emp['emp_id'];?></td>
	
	<td><?php echo $emp['first_name']." ".$emp['middle_name']." ".$emp['last_name'];?></td>
	
	
	 <?php 
	 if($cnt>0){?>
	  <td><input name="amount[]" type="text" value="<?php echo $chk['amount'];?>" class="textclass " id="amt<?php echo $srno;?>"></td>
		
		<td><input name="check_no[]" type="text" value="<?php echo $chk['check_no'];?>" class="textclass " id="chk<?php echo $srno;?>" ></td>
		
		<td><input name="date[]" type="text" value="<?php echo date('d-m-Y',strtotime($chk['date']));?>" class="textclass " id="date<?php echo $srno;?>"></td>
		
		
		<td><input type="button" value="Delete" class="btnclass" onclick="deletesingle('<?php echo $chk['chk_detail_id'];?>','<?php echo $srno;?>')" id="delbtn<?php echo $srno;?>"><?php ?></td>
	
		
		
	 <?php }else {  ?>	
	  
		<td><input name="amount[]" type="text" value='<?php echo $emp['amount'];?>' class="textclass " id="amt<?php echo $srno;?>" readonly></td>
		
		<td><input name="check_no[]" type="text" value="<?php echo $chkno;?>" class="textclass " id="chk<?php echo $srno;?>"> </td>
		
		<td><input name="date[]" type="text" value="<?php echo $checkdate;?>" class="textclass " id="date<?php echo $srno;?>"></td>
	
	
	 <?php $chkno++;}
	//$existnum = $userObj->checkExistChequeDetails($emp['emp_id'],$sal_month,$type);
	?>
	</tr>
	<tr id="chkdtlsucc<?php echo $srno;?>" class="hidecontent">
	<td colspan="9" id="succdtl<?php echo $srno;?>" class="successclass"></td>
	</tr>
	<?php $srno++; $no++;} ?>
	<?php  ?>

	</table>
      </div>       
            <div class="clearFix">&nbsp;</div>
			<div>			
<div><input type="submit" value="Save" name="submit1" class="btnclass" > <input type="button" value="Print All" name="printbtn" class="btnclass"  onclick="printval()">	 <input type="submit" value="Export" name="exportbtn" class="btnclass" onclick = "export1();" >
</div>
            </form>
        </div>
		<script>

function printval(){
		var client = $("#client").val();
		   var billno=$("#invoiceno").val();
		   var type='B';
        window.location.href="/check-print-pre?client="+client+"&type="+type;
          
}



function add_cheque_details(){
	
	                alert("ADD");
                    
var empId = document.getElementsByName('emp_id[]');
/*var checkedvals = "";
for (var i=0, n=checkboxes.length;i<n;i++) 
{
if (checkboxes[i].checked) 
{
checkedvals += ","+checkboxes[i].value;
}
}
if (checkedvals) checkedvals = checkedvals.substring(1);*/



                    
                    //emp_id = $("#emp_id").val();
                    //chkdate  = $("#date").val();
                        $.post('/add-bonus-cheque-details',{		
		
		emp_id: empId
		//chkdate :chkdate
	},function(result){
			            alert(result);	
			            $("#test").text(result);
                        
                    });
	

                // Prevents default submission of the form after clicking on the submit button. 
                return false;   
            };


function deletesingle(id,sr){ alert(id);
	$.post('/delete-op-print-record',{		
		'id':id		
	},function(data){
	    	$("#succdtl"+sr).html(data);
	});
}

</script>
