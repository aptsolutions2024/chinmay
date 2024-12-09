<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');


$comp_id=$_SESSION['comp_id'];

$_SESSION['clientid'] = $_REQUEST['clientid'];
$clientid =$_REQUEST['clientid'];

$resclt=$payrollAdmin->displayClient($_REQUEST['clientid']);
$ser_charges=$resclt['ser_charges'];
?>



<!--<div class="twelve mobicenter innerbg">-->
<div class="twelve mobicenter">
    <div class="row">
        <div class="twelve"><h3>GST Statement</h3></div>
        <div class="clearFix"></div>
        <form id="form" action="/r-report-op-gst-statement-page" method="post" onsubmit="return validation()">
		<input type="hidden" value='<?php echo $clientid;?>' name="clientid" id="clientid">
        <div class="twelve" id="margin1">
            
            <div class="four padd0 columns">
				<div class="four padd0 columns">
                <span class="labelclass1 pdl10p"> Invoice No :</span>
				</div>
				<div class="eight padd0 columns">
				<span ><input type="text" value="" name="invoice" class="textclass" id="invoice"><div id="errinv" class="errorclass hidecontent"></div></span>
				</div>
            </div>
			 
			<div class="four padd0 columns">
				<div class="four padd0 columns">
                <span class="labelclass1 pdl10p"> Service Char:</span>
				</div>
				<div class="eight padd0 columns">
				<span ><input type="text" name="serchar" id="serchar" class="textclass" value = "<?=$ser_charges;?>"><div id="errinvdt"class="errorclass hidecontent"></div></span>
				</div>
            </div>
			<div class="clearFix">&nbsp;</div>
			<div class="four padd0 columns">
			<div class="four padd0 columns">
                <span class="labelclass1 pdl10p"> PF (%):</span>
				</div>
				<div class="eight padd0 columns">
				<input type="text" name="pf" id="pf" class="textclass" value="13.00"><div id="errinvdt"class="errorclass hidecontent"></div>
				</div>
            </div>
			<div class="four padd0 columns">
			<div class="four padd0 columns">
                <span class="labelclass1 pdl10p"> ESI (%):</span>
				</div>
				<div class="eight padd0 columns">
				<input type="text" name="esi" id="esi" class="textclass" value="3.25"><div id="errinvdt"class="errorclass hidecontent"></div>
				</div>
            </div>
			<div class="four padd0 columns">
			<div class="four padd0 columns">
                <span class="labelclass1 pdl10p"> GST (%):</span>
				</div>
				<div class="eight padd0 columns">
				<input type="text" name="gst" id="gst" class="textclass" value="18"><div id="errinvdt"class="errorclass hidecontent"></div>
				</div>
            </div>
			<div class="clearFix">&nbsp;</div>
			
			
            
           <!--
			<div class="one padd0 columns">
               
            </div>
			<div class="two padd0 columns">
                <span class="labelclass1">Date :</span>
            </div>
            <div class="two padd0 columns">
                <input type="text" name="frdt" id="frdt" class="textclass hasDatepicker">
            </div>-->
			
			
            <div class="clearFix"></div>
             <div class="one padd0 columns" id="margin1">
            </div>
            <div class="three padd0 columns" id="margin1">

                <input type="submit" name="submit" id="submit" value="Print" class="btnclass">
            </div>
            <div class="eight padd0 columns" id="margin1">
                &nbsp;
            </div>
            <div class="clearFix"></div>
            </form>
        <div class="clearFix"></div>
        </div>
</div>


<br/>
<!--Slider part ends here-->
<div class="clearFix"></div>
<script>
$( function() {                
				
	$("#invdate").datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat:'dd-mm-yy'
	});
	
} );
function validation(){
	var invoice = $("#invoice").val();
	var invdate = $("#invdate").val();
	if(invoice ==""){
		$("#errinv").show();
		$("#errinv").text("Please Enter Invoice No.");
		return false;
	}else{$("#errinv").hide();
	
	}
	if(invdate ==""){
		$("#errinvdt").show();
		$("#errinvdt").text("Please Enter Invoice Date.");
		return false;
	}else{
		$("#errinvdt").hide();
	}
}
</script>




