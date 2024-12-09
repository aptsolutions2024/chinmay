<?php
session_start();

if(isset($_SESSION['log_id'])&&$_SESSION['log_id']==''){
echo "<script>window.location.href='/home';</script>";exit();
}
include ('../../include_payroll_admin.php');

$comp_id=$_SESSION['comp_id'];
$client=$_REQUEST['client'];
//$period = $payrollAdmin->getdates($client);
//print_r($period);
?>



<!DOCTYPE html>

<head>
  <meta charset="utf-8"/>
      <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width"/>
  <title>Leave | Statement</title>
  <!-- Included CSS Files -->
  <link rel="stylesheet" href="../css/responsive.css">
  <link rel="stylesheet" href="../css/style.css">
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
        <div class="twelve"><h3>Leave Statement</h3></div>
        <div class="clearFix"></div>
        <form name="form" id="form" action="/r-report-leave-statement?client=<?php echo $client ?>" method="post" onsubmit="return validation()">
        <div class="twelve" id="margin1">
	
<div class="four padd0 columns"  >
			 <div class="five  columns "  id = "prv_to" >
                        <span> Period From </span>
                    </div>
                    <div class="seven columns" >
                        <input type="text" name="frdt1" id="frdt" class="textclass" value="01-01-2017">
                        <span class="errorclass hidecontent" id="calculationfrmerror"></span>
                    </div>
					
			</div>
			<div class="four padd0 columns"  >
			 <div class="five  columns pdl10p"  id = "prv_to" >
                        <span> Period To</span>
                    </div>
                    <div class="seven columns" >
                        <input type="text" name="todt1" id="todt" class="textclass" value="31-12-2017">
                        <span class="errorclass hidecontent" id="calculationtoerror"></span>
                    </div>
					
			</div>
		

            </div>
			  <div class="clearFix"></div>
			  
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