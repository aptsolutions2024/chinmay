<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

$comp_id=$_SESSION['comp_id'];
$client=$_REQUEST['client'];
$period = $payrollAdmin->getdates($client);
?>
<!DOCTYPE html>

<head>
  <meta charset="utf-8"/>
      <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width"/>
  <title>Leave | Bank</title>
  <!-- Included CSS Files -->
  <link rel="stylesheet" href="Payroll/css/jquery-ui.css">
<script type="text/javascript" src="Payroll/js/jquery.min.js"></script>
    <script type="text/javascript" src="Payroll/js/jquery-ui.js"></script>
<script>
// $( function() {
//             $("#frdt1").datepicker({
//                 changeMonth: true,
//                 changeYear: true,
//                 dateFormat:'yy-mm-dd'
//             });
//             $("#todt1").datepicker({
//                 changeMonth: true,
//                 changeYear: true,
//                 dateFormat:'yy-mm-dd'
//             });
//         } );
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
        <div class="twelve"><h3>Leave Details Report</h3></div>
        <div class="clearFix"></div>
        <form name="form" id="form" action="/r-report-leave-details" method="post" onsubmit="return validation()">
            <input type="hidden" name="clintid" value="<?php echo $client; ?>">
        <div class="twelve" id="margin1">
	      <div class="eight padd0 columns">
			<div class="four  padd0 columns">
				<div class="four  columns pdl10p">From Date</div>
				<div class="eight padd0 columns"><input type="date" name="from_date" class="textclass" id="frdt1"><span class="errorclass hidecontent" id="to_dateerror"></span></div>
            </div>
            <div class="four  padd0 columns" >
				<div class="four  columns pdl10p">To Date</div>
				<div class="eight padd0 columns"><input type="date" name="to_date" class="textclass" id="todt1"><span class="errorclass hidecontent" id="to_dateerror"></span></div>
            </div>
            <div class="clearFix"></div>
			
            <div class="three padd0 columns"><br>
                <input type="submit" name="submit" id="submit" value="Print" class="btnclass">
            </div>
            </div>
            <div class="four padd0 columns" id="margin1">
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