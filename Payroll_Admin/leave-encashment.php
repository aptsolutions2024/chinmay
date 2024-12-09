<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');
//error_reporting(E_ALL);
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];

$result1 = $payrollAdmin->showClient1($comp_id,$user_id);
$_SESSION['month']='current';
$leavetypes = $payrollAdmin->showLeavetype($comp_id);


?>
<!DOCTYPE html>
<head>
  <meta charset="utf-8"/>
  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width"/>
  <title>Leave | Encashment</title>
 
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
        <div class="twelve" id="margin1"> <h3>Encashment</h3></div>

        <div class="clearFix"></div>

        <div class="twelve" id="margin1">
            <div class="boxborder" id="addLeave">
            <div class="six padd0 columns"  >
			<div class="three   columns"  >
                <span class="labelclass1">Client :</span>
            </div>
			<div class="eight padd0  columns" >
                <select class="textclass" name="client" id="client" onchange="updateCurrentMonth();">
                    <option value="">--Select--</option>
                    <?php foreach($result1 as $row1) {?>
                        <option value="<?php echo $row1['mast_client_id']; ?>" data-current-month="<?php echo date('F Y', strtotime($row1['current_month'])); ?>">
            <?php echo $row1['client_name']; ?> - <?php echo date('F Y', strtotime($row1['current_month'])); ?>
          </option>
          <?php } ?>

                </select>
                
                <span class="errorclass hidecontent" id="clinterror"></span>
                <span style="color:#7d1a15; margin-left: 10px;">
        Month: <span id="current-month">--select--</span>
    </span>
			</div>
			<div class="one padd0 columns" ></div>
            </div>
            <div class="six padd0 columns"  >
                <div class="three padd0 columns"  align="center">
                    <span class="labelclass">Record Range :</span>
                </div>
                <div class="four padd0 columns">
                    <select class="textclass" name="lmt" id="lmt" onchange="displaydata();">
                      <option value="0, 30">0 to 30</option>
                        <option value="30, 30">31 to 60</option>
                        <option value="60, 30">61 to 90</option>
                        <option value="90, 30">91 to 120</option>
                        <option value="120, 30">121 to 150</option>
                        <option value="150, 30">151 to 180</option>
                        <option value="180, 30">181 to 210</option>
                        <option value="210, 30">211 to 240</option>
                        <option value="240, 30">241 to 270</option>
                        <option value="270, 30">271 to 300</option>
                        


                    </select>
                    <span class="errorclass hidecontent" id="lmterror"></span>
                </div>
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
			<div class="six padd0 columns">
					<div class="three  columns " >
                        <span class="labelclass1">Leave Type </span>
                    </div>
					<div class="seven columns" >
                      <select name="leavetype" class="textclass" id="leavetype" onchange="changeField()">
					  
						<option value=""> -- select type --</option>
						  
						<option value="<?php echo '6';?>"> <?php echo "EARN LEAVE";?></option>
						 
					  </select>
					  <span class="errorclass hidecontent" id="leavetypeerror"></span>
                    </div>
					
			</div>
			<span id="dates">
           <div class="four padd0 columns"  >
                
                    <div class="five  columns " >
                        <span class="labelclass1"> &nbsp; Payment Date</span>
                    </div>
                    <div class="seven columns">
                        <input type="text" name="payment_date" id="payment_date" class="textclass" value="01-01-2022">
                        <span class="errorclass hidecontent" id="frdterror"></span>
                    </div> 
            </div>
			 <div class="six padd0 columns"  >
			 <div class="three  columns pdl10p" id = "prv_to" style= "display:none;" >
                        <span> To Date</span>
                    </div>
                    <div class="seven columns"  style= "display:none;" >
                        <input type="text" name="todt1" id="todt1" class="textclass" value="31-12-2022" >
                        <span class="errorclass hidecontent" id="todterror"></span>
                    </div>
					
			</div>
			</span>
			<div class="clearFix"></div>
			
			<div class="six padd0 columns"  >
			 <div class="three  columns "  id = "prv_to" >
                        <span> Calculation From </span>
                    </div>
                    <div class="seven columns" >
                        <input type="text" name="frdt" id="frdt" class="textclass" value="01-01-2022">
                        <span class="errorclass hidecontent" id="calculationfrmerror"></span>
                    </div>
					
			</div>
			<div class="four padd0 columns"  >
			 <div class="five  columns pdl10p"  id = "prv_to" >
                        <span> Calculation To</span>
                    </div>
                    <div class="seven columns" >
                        <input type="text" name="todt" id="todt" class="textclass" value="31-12-2022">
                        <span class="errorclass hidecontent" id="calculationtoerror"></span>
                    </div>
					
			</div>
			
			
			
			
			
					<div class="clearFix">&nbsp;</div>
			
			 <div class="eight padd0 columns"  >
				<div class="three  columns pdl10p" id = "prv_to" >
                        <span>One levae Per Present Days</span>
                </div>

				<div class="seven  columns "  >
					<input type="radio" name="presentday" value="12.00" onclick="changeperday(this.value);" checked id="12">Shop Act(12.00)
                <input type="radio" name="presentday" value="20" onclick="changeperday(this.value);" id="20">Factory  Act(20)
				</div>
				
							  <div class="eight  columns "><span  floatval:right;>
							  
			  <button  class="btnclass" onclick="showList1();">Show</button>
			  </span>
			  </div>

			
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
      </div>
 </div>

        <div class="clearFix"></div>
		<div id="contenlist234"></div>
            <div class="clearFix"></div>

            <br/>


        </div>

    </div>

    </div>

</div>

<!--Slider part ends here-->
<div class="clearFix"></div>

<!--footer start -->
<?php include('footer.php');?>


<!--footer end -->
    <script>
        $(document).ready(function() {
            $("#payment_date").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat:'dd-mm-yy'
            });
            $("#frdt").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat:'dd-mm-yy'
            });
            $("#todt").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat:'dd-mm-yy'
            });
			 $("#calculationfrm").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat:'dd-mm-yy'
            });
			 $("#calculationto").datepicker({
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
		 $("#leavetypeerror").text('');
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
		 var client = $("#client").val();
		 var lmt=$("#lmt").val();
		 var emp = $('input:radio[name=emp]:checked').val();
		 var empid = $("#empid").val();
		 var leavetype = $("#leavetype").val();
		 var frdt = $("#frdt").val();
		 var todt = $("#todt").val();
		 var payment_date = $("#payment_date").val();
		 
		 var calculationfrm = $("#calculationfrm").val();
		 var calculationto = $("#calculationto").val();
		 var presentday = $('input:radio[name=presentday]:checked').val();
		 
		 $("#client").removeClass('bordererror');
		 $("#leavetype").removeClass('bordererror');
		 $("#frdt").removeClass('bordererror');
		 $("#todt").removeClass('bordererror');
		 $("#payment_date").removeClass('bordererror');
		
		// alert(empid1);
		 if(client ==""){
			$("#client").focus();
               error ="Please select Client";
               $("#client").val('');
               $("#client").addClass('bordererror');
               $("#client").attr("placeholder", error);
               return false;
		 }else if(leavetype ==""){
			 $("#leavetype").focus();
               error ="Please select leave type";
               $("#leavetype").val('');
               $("#leavetype").addClass('bordererror');
               $("#leavetype").attr("placeholder", error);
               return false;
		 }else if(frdt ==""){
			 $("#frdt").focus();
               error ="Please select from date";
               $("#frdt").val('');
               $("#frdt").addClass('bordererror');
               $("#frdt").attr("placeholder", error);
               return false;
		 }else if(todt ==""){
			$("#todt").focus();
               error ="Please select To date";
               $("#todt").val('');
               $("#todt").addClass('bordererror');
               $("#todt").attr("placeholder", error);
               return false;
		 }else{
			  $('#displaydetails').html('<div style="height: 200px;width:400px;padding-top:100px;" align="center"> <img src="../Payroll/images/loading.gif" /></div>');
			
			 $.post('/leave-encashment-details', {
			 'client': client,
			  'lmt':lmt,
			 'emp':emp,
             'empid':empid,
			 'leavetype':leavetype,
			 'frdt':frdt,
			 'todt':todt,
			 'payment_date':payment_date,
			 'calculationfrm':calculationfrm,
			 'calculationto':calculationto,
			 'presentday':presentday
	 
		}, function (data) {
		    //alert(data);
			$("#showlist").show();		
		   $("#displaydetails").html(data);	
		   
		});
		 }	 
		/* */
		
	 }


	function exportexcel(){
		clearError();
		 var client = $("#client").val();
		 var lmt=$("#lmt").val();
		 var emp = $('input:radio[name=emp]:checked').val();
		 var empid = $("#empid").val();
		 var leavetype = $("#leavetype").val();
		 var frdt = $("#frdt").val();
		 var todt = $("#todt").val();
		 var payment_date = $("#payment_date").val();
		 
		 var calculationfrm = $("#calculationfrm").val();
		 var calculationto = $("#calculationto").val();
		 var presentday = $('input:radio[name=presentday]:checked').val();
		 
		 $("#client").removeClass('bordererror');
		 $("#leavetype").removeClass('bordererror');
		 $("#frdt").removeClass('bordererror');
		 $("#todt").removeClass('bordererror');
		 $("#payment_date").removeClass('bordererror');
		
		 //alert(empid1);
		 if(client ==""){
			$("#client").focus();
               error ="Please select Client";
               $("#client").val('');
               $("#client").addClass('bordererror');
               $("#client").attr("placeholder", error);
               return false;
		 }else if(leavetype ==""){
			 $("#leavetype").focus();
               error ="Please select leave type";
               $("#leavetype").val('');
               $("#leavetype").addClass('bordererror');
               $("#leavetype").attr("placeholder", error);
               return false;
		 }else if(frdt ==""){
			 $("#frdt").focus();
               error ="Please select from date";
               $("#frdt").val('');
               $("#frdt").addClass('bordererror');
               $("#frdt").attr("placeholder", error);
               return false;
		 }else if(todt ==""){
			$("#todt").focus();
               error ="Please select To date";
               $("#todt").val('');
               $("#todt").addClass('bordererror');
               $("#todt").attr("placeholder", error);
               return false;
		 }else{
			alert("222");
			 $.post('/leave1-encashment-export', {
			 'client': client,
			  'lmt':lmt,
			 'emp':emp,
             'empid':empid,
			 'leavetype':leavetype,
			 'frdt':frdt,
			 'todt':todt,
			 'payment_date':payment_date,
			 'calculationfrm':calculationfrm,
			 'calculationto':calculationto,
			 'presentday':presentday
	 
		}, function (data) {
		});
	
		
	 }

}
	 /*function changeField(){ 
	 var client = $("#client").val();
	 var leavetype = $("#leavetype").val();	 
		 $.post('/get-lattest-opening-date', {
			 'client': client,
			 'leavetype':leavetype	 
		}, function (data) {	
			//$("#showlist").show();		
		   //$("#displaydetails").html(data);		  
		   
		});
	 }*/
	 function rateCal(id){
	     //debugger;
		 var enc = $("#encash"+id).val();
		 var rate = $("#rate"+id).val();
		 var amount =0;
		 
		if(enc=="" || rate==""){
			amount=0;
		}else{
			var amount = parseFloat(enc) * parseFloat(rate);
		}		 
		 
		 var amounttxt = $("#amounttxt"+id).text(Number(amount).toFixed(0));
		  var amountinp = $("#amountinp"+id).val(Number(amount).toFixed(0));
		 
		 
	 }
	 function checkAll(val){
		 if(document.getElementById('allcheck').checked){			
			 $(".selectchk" ).prop( "checked", true );
		 }else{
			 $(".selectchk" ).prop( "checked", false );
		 }		
	 }
</script>
</body>

</html>