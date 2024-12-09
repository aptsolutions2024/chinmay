<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];

$result1 = $payrollAdmin->showClient1($comp_id,$user_id);
$_SESSION['month']='current';
$otherPaymentTypes = $payrollAdmin->showOtherPayment($comp_id);


?>
<!DOCTYPE html>
<head>
  <meta charset="utf-8"/>
  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width"/>
  <title>Other Payment | Encashment</title>
  <!-- Included CSS Files -->
  <link rel="stylesheet" href="Payroll/css/responsive.css">
  <link rel="stylesheet" href="Payroll/css/style.css">
    
    <link rel="stylesheet" href="Payroll/css/jquery-ui.css">


		<script>
		    function updateCurrentMonth() {
    var select = document.getElementById('client'); // Change 'clientid' to 'client'
    var selectedOption = select.options[select.selectedIndex];
    var currentMonth = selectedOption.getAttribute('data-current-month');
    document.getElementById('current-month').textContent = currentMonth || '--select--'; // Fallback to '--select--' if no month is found
}
		</script>
 <body>
<!--Header starts here-->
<?php include('header.php');?>
<!--Header end here-->
<div class="clearFix"></div>
<!--Menu starts here-->


<!--Menu ends here-->
<div class="clearFix"></div>
<!--Slider part starts here-->

<div class="twelve mobicenter innerbg">
    <div class="row">
        <div class="twelve" id="margin1"> <h3>Other Payment</h3></div>

        <div class="clearFix"></div>

        <div class="twelve" id="margin1">
             <div class="boxborder" id="addOtherPayment">
            <div class="four padd0 columns"  >
			<div class="five   columns"  >
                <span class="labelclass1">Client :</span>
            </div>
			<div class="seven padd0 columns" >
                <select class="textclass" name="client" id="client" onchange="updateCurrentMonth();" >
                    <option value="">--Select--</option>
                    <?php foreach($result1 as $row1) {?>
                        <option value="<?php echo $row1['mast_client_id']; ?>" data-current-month="<?php echo date('F Y', strtotime($row1['current_month'])); ?>">
            <?php echo $row1['client_name']; ?> - <?php echo date('F Y', strtotime($row1['current_month'])); ?>
          </option>   <?php } ?>

                </select>
                <div class="fseven padd0 columns" id="margin1">
        <h5 style="color:#7d1a15;">Month : <span id="current-month">--select--</span></h5>
      </div>
            <span class="errorclass hidecontent" id="clinterror"></span>
			</div>
			
			<div class="one padd0 columns" ></div>
            </div>
            <div class="six padd0 columns"  >
				<div class="three  columns " style="display:none;" >
					
					<input type="radio" name="emp" value="all" onclick="changeemp(this.value);" checked id="all">All
                <input type="radio" name="emp" value="random" onclick="changeemp(this.value);" id="Random">Random
				</div>
				<div class="nine padd0  columns"  >
					 <div id="showemp" class="hidecontent">
                    <input type="text" name="name" id="name" onkeyup="serachemp(this.value);" autocomplete="off" placeholder="Enter the Employee Name" class="textclass" >
                    <div id="searching" style="z-index:10000;position: absolute;width: 100%;border: 1px solid rgba(151, 151, 151, 0.97);display: none;background-color: #FFFFFF;">

                    </div>
                    <input type="hidden" name="empid" id="empid" value="">
					</div>
				</div>
				<div class="one padd0  columns"  >
				</div>
			</div>
			<div class="clearFix">&nbsp;</div>
			<div class="four padd0 columns">
					<div class="five  columns " >
                        <span class="labelclass1">Other Payment Type </span>
                    </div>
					<div class="seven columns" >
                      <select name="otherpaymenttype" class="textclass" id="optype" >
					  
						<option value=""> -- select type --</option>
						<?php foreach($otherPaymentTypes as $ltyp) {?>
						<option value="<?php echo $ltyp['op_id'];?>"> <?php echo $ltyp['op_name'];?></option>
						<?php }?>
					  </select>
					  <span class="errorclass hidecontent" id="optypeerror"></span>
                    </div>
					
			</div>
			<span id="dates">
           <div class="four padd0 columns"  >
                
                    <div class="five  columns pdl10p"  id = "prv_to" >
                        <span> Bill No</span>
                    </div>
                    <div class="seven columns" >
                        <input type="text" name="billno" id="billno" class="textclass" value="">
                        <span class="errorclass hidecontent" id="billnoerror"></span>
                    </div>
            </div>
			<div class="four padd0 columns"  >
                
                    <div class="five  columns pdl10p"  id = "prv_to" >
                        <span> Date</span>
                    </div>
                    <div class="seven columns" >
                        <input type="text" name="billdate" id="billdate" class="textclass" value="">
                        <span class="errorclass hidecontent" id="billdateerror"></span>
                    </div>
            </div>
			 
			</span>
			<div class="clearFix"></div>
			
			
			
			
			 <div class="eight padd0 columns"  >
				<!--<div class="three  columns pdl10p" id = "prv_to" >
                        <span>One levae Per Present Days</span>
                </div>

				<div class="seven  columns "  >
					<input type="radio" name="presentday" value="12.00" onclick="changeperday(this.value);" checked id="12">Shop Act(12.00)
                <input type="radio" name="presentday" value="20" onclick="changeperday(this.value);" id="20">Factory  Act(20)
				</div>-->
				
				
			  <div class="five padd0 columns">
					<div class="six  columns " >
                        
                    </div>
					<div class="six columns" >
                     <button  class="btnclass" onclick="showList1();">Show</button>
                    </div>
					
			</div>
			  
			  
				<div class="clearFix">&nbsp;</div>
			
			<div style="display:none;">
			<div class="five pdl10p columns"  >
              
			  <div class="four  columns pdl10p"  id = "prv_to" >
                        <span> New Bill no</span>
                    </div>
                  
					<div class="eight columns" >
                        <input type="text" name="newbillno" id="newbillno" class="textclass" value="">
                        <span class="errorclass hidecontent" id="newbillnoerror"></span>
                    </div>

			</div>
			<div class="four padd0 columns"  >
                
                    <div class="four  columns pdl10p"  id = "prv_to" >
                        <span> New Date</span>
                    </div>
                    <div class="eight columns" >
                        <input type="text" name="newbilldate" id="newbilldate" class="textclass" value="">
                        <span class="errorclass hidecontent" id="newbilldateerror"></span>
                    </div>
            </div>
			
			  <div class="three  columns pdl10p"  id = "prv_to" >
							  <div class="six  columns "><span  floatval:right;>
							  
			  <button  class="btnclass" onclick="savenewbillno();">Save</button></span>
			  </div>

			</div>
			
			</div>
			
			
			
					<div class="clearFix">&nbsp;</div>
			
			  
		<!--	 <div class="four padd0 columns"  >
			 <div class="five   columns pdl10p" id = "prv_to" >
                        <span>One levae Per Present Days</span>
                    </div>
                    <div class="seven  columns" >
                        <input type="text" name="presentday" id="presentday" class="textclass" >
                        <span class="errorclass hidecontent" id="presentdayerror"></span>
                    </div>
			</div>
			
			<div class="clearFix"></div>
			
			  <div class="padd0 row" align="right">
			  <div class="twelve  columns ">
			  <button  class="btnclass" onclick="showList1();">Show</button>
			  </div>-->
				  
				  
			 </div>
			
			<div class="clearFix"></div>
			
      
		<div class="clearFix">&nbsp;</div>
		<div id="showlist" class="hidecontent">
		
		<div class="clearFix">&nbsp;</div>
		<div class="rows" >
		 <h3>Display Employee</h3>
		 </div>
		 <hr>
		 <div id="displaydetails"></div>
		</div>
       <div class="clearFix">&nbsp;</div>
     


        <div class="clearFix"></div>
		<div id="contenlist234"></div>
            <div class="clearFix"></div>

            <br/>

  </div>
    </div>
        </div>

    </div>

    </div>

</div>

<!--Slider part ends here-->
<div class="clearFix"></div>

<!--footer start -->
<?php include('footer.php');?>
<script type="text/javascript" src="Payroll/js/jquery.min.js"></script>
    <script type="text/javascript" src="Payroll/js/jquery-ui.js"></script>

<!--footer end -->
    <script>
        $( function() {
            $("#billdate").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat:'dd-mm-yy'
            });
            
			 $("#newbilldate").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat:'dd-mm-yy'
            });
           
        } );</script>
		<script>
     function changeemp(val){
		 var client = $("#client").val();
		 if(val=='random'){            
			
			//$("#printManual").hide();
			if(client==""){
				$("#clinterror").show();
				$("#clinterror").text("Please Select Client");
				$("#all").prop("checked", true);
				return false;
			}else{
				$("#clinterror").hide();
			}	
			$("#showemp").show();
			//$("#manualchequeprint").hide();
			$("#subbtn").show();			
        }		
        else if(val=='all')
        {$("#showemp").hide();	
			//$("#manualchequeprint").hide(); 
			$("#subbtn").show();
			//$("#printManual").hide();
			$("#empid").val('');
        }
    }
	function serachemp(val){
		var clientid = $("#client").val();
		
        $.post('/display-employee2', {
            'name': val,
			'clientid':clientid
        }, function (data) {
            $('#searching').html(data);
            $('#searching').show();			
        });
    }
	function showTabdata(id,name){

        $.post('/display-employee', {
            'id': id
        }, function (data) {
            $('#searching').hide();
            $('#displaydata').html(data);
            $('#name').val(name);
            $('#displaydata').show();
            document.getElementById('empid').value=id;			
			//getEmp(id);
        });
    }
	function clearError(){
		 $("#clinterror").text('');
		//$('input:radio[name=emp]:checked').val();
		 $("#optypeerror").text('');
		 $("#frdterror").text('');
		 $("#todterror").text('');
		 $("#calculationfrmerror").text('');
		 $("#payment_date").text('');
		 
		 $("#calculationtoerror").text('');
		 $("#presentdayerror").text('');
		 $("#carfrfrmerror").text('');
		 $("#carfrtoerror").text('');
	}
	function showList1(){
	    
		clearError();
		 var client=$("#client").val();
		  var optype=$("#optype").val();
		   var billno=$("#billno").val();
		    var billdate=$("#billdate").val();
	     $("#client").removeClass('bordererror');
	     $("#optype").removeClass('bordererror');
	     $("#billno").removeClass('bordererror');
	     $("#billdate").removeClass('bordererror');
		 
		// alert(empid1);
		 if(client ==""){
			 $("#client").focus();
        	   error ="Please select Client";
        	   $("#client").val('');
        	   $("#client").addClass('bordererror');
        	   $("#client").attr("placeholder", error);
        	   return false;
		 }else if(optype ==""){
			 $("#optype").focus();
        	   error ="Please select leave type";
        	   $("#optype").val('');
        	   $("#optype").addClass('bordererror');
        	   $("#optype").attr("placeholder", error);
        	   return false;
		 }else if(billno ==""){
			 $("#billno").focus();
        	   error ="Please select bill no.";
        	   $("#billno").val('');
        	   $("#billno").addClass('bordererror');
        	   $("#billno").attr("placeholder", error);
        	   return false;
		 }else if(billdate ==""){
			 $("#billdate").focus();
        	   error ="Please enter bill date";
        	   $("#billdate").val('');
        	   $("#billdate").addClass('bordererror');
        	   $("#billdate").attr("placeholder", error);
        	   return false;
		 }/*else if(calculationfrm ==""){
			 $("#calculationfrmerror").show();
			 $("#calculationfrmerror").text("Please select Calculation from date");
		 }else if(calculationto ==""){
			 $("#calculationtoerror").show();
			 $("#calculationtoerror").text("Please select Calculation To date");
		 }else if(presentday ==""){
			 $("#presentdayerror").show();
			 $("#presentdayerror").text("Please enter calculation day");
		 }*/else{
			  $('#displaydetails').html('<div style="height: 200px;width:400px;padding-top:100px;" align="center"> <img src="../images/loading.gif" /></div>');
			
			 $.post('/other-payment-details-process', {
			 'client': client,			
			 'optype':optype,
			 'billno':billno,
			 'billdate':billdate
	 
		}, function (data) {	
			$("#showlist").show();		
		   $("#displaydetails").html(data);	
		   //showList1();
		 });
    }
		
		
	}	
		
		
		
		
		
		
		function savenewbillno(){

		clearError();
		 var client = $("#client").val();
		 
		 var optype = $("#optype").val();
		 var billno = $("#billno").val();
		 var billdate = $("#billdate").val();
		 var newbillno = $("#newbillno").val();
		 var newbilldate = $("#newbilldate").val();
		 
		 
		 //alert(empid1);
		 if(client ==""){
			 $("#clinterror").show();
			 $("#clinterror").text("Please select Client");
		 }else if(billno ==""){
			 $("#billnoerror").show();
			 $("#billnoerror").text("Please select bill no.");
		 }else if(billdate ==""){
			 $("#billdateerror").show();
			 $("#billdateerror").text("Please enter bill date");
		 }else if(newbillno ==""){
			 $("#newbillnoerror").show();
			 $("#newbillnoerror").text("Please enter new bill no.");
		 }else if(newbilldate ==""){
			 $("#newbilldateerror").show();
			 $("#newbilldateerror").text("Please new enter bill date");
		 }else{
		     
			 $.post('/save_newbillno-process', {
			 'client': client,			
			 'optype':optype,
			 'billno':billno,
			 'billdate':billdate,
			 'newbillno':newbillno,
			 'newbilldate':newbilldate
	 
	 
		}, function (data) {	
		  
$("#showlist").show();
$("#displaydetails").html(data);	
		   		  
	 });
    }
		
		}
		
		/*.done(function( data ) {
			$("#showlist").show();		
			$("#displaydetails").html(data);	
	  });*/
	
	 function checkAll(val){
		 if(document.getElementById('allcheck').checked){	
			/*if ($(this).hasAttribute('disabled')) {
                return false;
            }*/			
			 $(".selectchk" ).prop( "checked", true );
		 }else{
			 $(".selectchk" ).prop( "checked", false );
		 }		
	 }
</script>
</body>

</html>