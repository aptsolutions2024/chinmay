 <?php 
 //error_reporting(0);
 $chkno = $_REQUEST['checkn'];
 $checkdate = $_REQUEST['checkdt'];
 session_start();
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

$month=$_SESSION['month'];
$clientid = $_SESSION['clintid'];
$resclt=$payrollAdmin ->displayClient($clientid);
 $cmonth=$resclt['current_month'];
$type = "S";
 $empid1 = $_REQUEST['empid1'];

 if($month=='current'){
    $monthtit =  date('F Y',strtotime($cmonth));
    $tab_emp='tran_employee';
     $sal_month=$cmonth;
 }
else{
    $monthtit =  date('F Y',strtotime($_SESSION['frdt']));    
    $tab_emp='hist_employee';
	
	$sql = "SELECT LAST_DAY('".$frdt."') AS last_day";
	$row= mysql_query($sql);
	$res = mysql_fetch_assoc($row);
	$sal_month = $res['last_day'];
	
 }
if ($empid1 >0 )

{$emplist = $userObj->getChequeEmployeeByEmpId($empid1,$tab_emp,$sal_month,$type);
}
else{
	$empid1= 0;
$emplist = $userObj->getChequeEmployeeByClientId($clientid,$tab_emp,$sal_month);
}
 ?>
 <form method="post" action="add-cheque-details.php" id="addchkdtl" >
			  <input type="hidden" value="" id="chkdate" name="chkdate">
			  <input type="hidden" value="" name="print1" id="print1">
			  <input type="hidden" value="<?php echo $cmonth;?>" id="cmonth" name="cmonth">
			  <div id="chkdtllst">
			  
			
	<table width="100%" style="background-color:#fff" id="emplist">

	<tr>
	<th align="left" width="5%">Sr No</th>
	<th align="left" width="10%">Salary Month</th>
	<th align="left" width="5%">Emp Id</th>
	<th align="left" width="30%">Emp Name</th>
	<th align="left" width="10%">Amount</th>
	<th align="left" width="12%">Cheque No.</th>
	<th align="left" width="15%">Cheque Date</th>
	<th align="left" width="10%">Action</th>
	</tr>
	
	<?php $srno=1; $no=0;
	while($emp = mysql_fetch_array($emplist)){
		$chkDtl = $userObj->chkDetails($emp['emp_id'],$cmonth,$type);
		//print_r($chkDtl);
		$cnt = 0;
		$cnt = mysql_num_rows($chkDtl);	
		$chk = mysql_fetch_array($chkDtl);
		
	?>
	<tr id="chkdtl<?php echo $srno;?>">
	<td><?php echo $srno; ?></td>
	
	<td><?php echo date("M, Y", strtotime($cmonth));; ?></td>
	
	<td><input name="emp_id[]" type="hidden" value="<?php echo $emp['emp_id'];?>"><?php echo $emp['emp_id'];?></td>
	
	<td><?php echo $emp['first_name']." ".$emp['middle_name']." ".$emp['last_name'];?></td>
	
	
	 <?php 
	 if($cnt>0){?>
	  <td><input name="amount[]" type="text" value="<?php echo $chk['amount'];?>" class="textclass " id="amt<?php echo $srno;?>"></td>
		
		<td><input name="check_no[]" type="text" value="<?php echo $chk['check_no'];?>" class="textclass " id="chk<?php echo $srno;?>" ></td>
		
		<td><input name="date[]" type="text" value="<?php echo date('d-m-Y',strtotime($chk['date']));?>" class="textclass " id="date<?php echo $srno;?>"></td>
		
		
	 <?php }else {  ?>	
	  
		<td><input name="amount[]" type="text" value='<?php echo $emp['netsalary'];?>' class="textclass " id="amt<?php echo $srno;?>" readonly></td>
		
		<td><input name="check_no[]" type="text" value="<?php echo $chkno;?>" class="textclass " id="chk<?php echo $srno;?>"> </td>
		
		<td><input name="date[]" type="text" value="<?php echo $checkdate;?>" class="textclass " id="date<?php echo $srno;?>"></td>
	
	
	 <?php $chkno++;}
	$existnum = $userObj->checkExistChequeDetails($emp['emp_id'],$sal_month,$type);
	?>
	<td><?php if($existnum != 0){?><input type="button" value="Delete" class="btnclass" onclick="deletesingle('<?php echo $chk['chk_detail_id'];?>','<?php echo $srno;?>')" id="delbtn<?php echo $srno;?>"><?php }?></td>
	<!--<td><input type="button" value="Edit" class="btnclass" onclick="editsingle('<?php echo $chk['chk_detail_id'];?>','<?php echo $srno;?>')"></td>-->
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
<div><input type="submit" value="Save" name="submit" class="btnclass" id="addcheque" > 
	 <input type="submit" value="Print All" name="printbtn" class="btnclass"  onclick="printval()">
	 <input type="submit" value="Export" name="exportbtn" class="btnclass" onclick = "export1();" >
</div>
            </form>
        </div>
		<script>
		$(document).ready(function() {
    $('#addchkdtl').on('submit',function(){
	
	var chkdt = $("#checkdate").val(); 
	var print1 = $("#print1").val();
	
	if(chkdt ==""){ 
		$("#checkdateerror1").show();
		$("#checkdateerror1").text("Please Select Date");
		
	}
	;
	
	if(parseInt(print1) == 1){	
		var client = $("#client").val();
		var employee = $("input[name='emp']:checked"). val();
		var empid = $("#empid").val();		
		window.location.href="check-print-pre.php?client="+client+"&empid1="+empid+"&checkdate="+chkdt+"&empid="+empid;
		
	}	else if(parseInt(print1) == 2){	
		var client = $("#client").val();
		alert(client);
		var employee = $("input[name='emp']:checked"). val();
		var empid = $("#empid").val();	
			var type = 'B';
		window.location.href="export_chequelist.php?client="+client+"&empid1="+empid+"&checkdate="+chkdt+"&empid="+empid+"&type="+type;
		
	}
	
	
	else{
		$("#chkdate").val(chkdt);
        var form = $(this);
        $.ajax({
            type:'post',
            url:'add-cheque-details.php',
            dataType: "text",
            data: form.serialize(),
            success: function(result){
			alert(result);	
			$("#test").text(result);
            }
        });
	}

        // Prevents default submission of the form after clicking on the submit button. 
        return false;   
    });
});

function print_cheque(client,emp_id) {

	$.post('check-print-pre.php',{
		
		'client':client,
		'empid1':emp_id,
		'type':'S'
		
	},function(data){
		
		alert(data);
	});
}
function deletesingle(id,sr){ alert(id);
	$.post('delete-print-record.php',{		
		'id':id		
	},function(data){		
		if(data.trim()==1){
			$("#chkdtlsucc"+sr).show();
			$("#succdtl"+sr).html("Record Successfully deleted");
			$("#chk"+sr).val("");
			$("#date"+sr).val("");	
			$("#delbtn"+sr).hide();	
			$("#chkdtl"+sr).css("color","#f00");
			
		}
	});
}

		</script>