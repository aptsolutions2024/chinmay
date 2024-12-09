<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

$comp_id=$_SESSION['comp_id'];
$client=$_REQUEST['client'];

$period = $payrollAdmin->getdates($client);
$period1 = $payrollAdmin->getdates($client);
?>



<!DOCTYPE html>

<head>
  <meta charset="utf-8"/>
      <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width"/>
  <title>Leave | Bank</title>
  <!-- Included CSS Files -->

<script>
$( function() {
            $("#frdt1").datepicker({
				'client':client,
                changeMonth: true,
                changeYear: true,
                dateFormat:'dd-mm-yy'
            });
            $("#todt1").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat:'dd-mm-yy'
            });
        } );
    function changeemp(val){

        if(val!='all'){
            $('#showemp').show();
        }
        else
        {
            $('#showemp').hide();
        }
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

        });

    }
    function serachemp(val){
        $.post('/display-employee1', {
            'name': val
        }, function (data) {
            $('#searching').html(data);
            $('#searching').show();
        });
    }
	function validation(){
	
		var frm = $("#frdt1").val();
		var todt1 = $("#todt1").val();
		
		if(document.getElementById("frdt1").value=="")
		{
			     document.getElementById("frdt1").innerHTML="Please enter date";
                 //alert("Please enter payment date");
		         document.form.frdt1.focus();
		return false;	
        }
		return true;
	}
	
	
	
</script>
</head>
 <body>

<!--Header starts here-->
<?php //include('header.php');?>
<!--Header end here-->
<div class="clearFix"></div>
<!--Menu starts here-->

<?php //include('menu.php');?>

<!--Menu ends here-->
<div class="clearFix"></div>
<!--Slider part starts here-->

<!--<div class="twelve mobicenter innerbg">-->
<div class="twelve mobicenter">
    <div class="row">
        <div class="twelve"><h3>Leave Details Export</h3></div>
        <div class="clearFix"></div>
        <form name="form" id="form" action="/report-leave-details-export" method="post" onsubmit="return validation()">
        <div class="twelve" id="margin1">
		<!-- <div class="three padd0 columns">
            <div class="four padd0 columns">
                <span class="labelclass1">Parent :</span>
            </div>
            <div class="eight padd0 columns">
				<input type="hidden" name="pay_type" value="L">
                <input type="radio" name="emp" value="Parent" onclick="changeemp(this.value);" >Yes
                <input type="radio" name="emp" value="Client" onclick="changeemp(this.value);" checked>No
            </div>
			</div>
         <div class="six padd0 columns"><input type="" name="frdt1" class="textclass" id="frdt1" placeholder="dd-mm-yyyy"> <span class="errorclass hidecontent" id="from_dateerror"></span></div>-->
			
			
			   <div class="four padd0 columns">
	
			<input type="hidden" name="pay_type" value="L">
     			<input type="hidden" name="client" value="<?php echo $client;?>">
     	<div class="five  columns pdl10p">Date from </div>
			<div class="six columns" >
		   <select name="frdt1" class="textclass" id="frdt1" >
		   <option value="">-- Select Date --</option>
		   <?php foreach($period as $type) {?>
		   <option value="<?php echo $type['payment_date'];?>"><?php echo date('d-m-Y',strtotime($type['payment_date']));?></option>
		   <?php }?>
		   </select>
	
			
			

            </div>
			
			  <div class="clearFix"></div>
			
            <div class="twelve  padd0 columns"  >
				<div class="five  columns pdl10p">To Date</div>
			<div class="six columns" >
		   <select name="todt1" class="textclass" id="todt1" >
		   <option value="">-- Select Date --</option>
		   <?php foreach($period1 as $type) {?>
		   <option value="<?php echo $type['payment_date'];?>"><?php echo date('d-m-Y',strtotime($type['payment_date']));?></option>
		   <?php }?>
		   </select>
	
            </div>
            <div class="clearFix"></div>
			
            <div class="three padd0 columns"><br>
<!--                <input type="button" name="submit" id="submit" value="Save" class="btnclass" onclick="reportpayslip();">-->
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

</div>
</div>
<br/>
<!--Slider part ends here-->
<div class="clearFix"></div>

<!--footer start -->

<?php //include('footer.php');?>

<!--footer end -->

</body>

</html>