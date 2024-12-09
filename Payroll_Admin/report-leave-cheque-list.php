<?php
session_start();

if(isset($_SESSION['log_id'])&&$_SESSION['log_id']==''){
echo "<script>window.location.href='/home';</script>";exit();
}

include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
include_once('../paginate.php');
$comp_id=$_SESSION['comp_id'];
$clientid = $_SESSION['clintid'];
$period = $userObj->getdates($clientid);$tab_emp ="leave_details";

?>
<!DOCTYPE html>

<head>
  <meta charset="utf-8"/>
      <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width"/>
  <title>Leave | Cheque List</title>
  <!-- Included CSS Files -->
  <link rel="stylesheet" href="../css/responsive.css">
  <link rel="stylesheet" href="../css/style.css">

<script>
$( function() {
            $("#frdt1").datepicker({
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
	function clear(){
		$("#to_dateerror").hide();
		$("#from_dateerror").hide();
	}
	function validation(){
		clear();
		var frm = $("#frdt1").val();
		var todt1 = $("#todt1").val();
		
		 if(frm ==""){
			 $("#from_dateerror").show();
			 $("#from_dateerror").text("Please select from date");
			 return false;
		 }else if(todt1 ==""){
			 $("#to_dateerror").show();
			 $("#to_dateerror").text("Please select from date");
			 return false;
		 }
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
        <div class="twelve"><h3>Cheque List</h3></div>
        <div class="clearFix"></div>
        <form id="form" action="/r-report-cheque-list" method="post" onsubmit="return validation()">
        <div class="twelve" id="margin1">
		<div class="three padd0 columns">
            <div class="four padd0 columns">
                <span class="labelclass1">Parent :</span>
            </div>
            <div class="eight padd0 columns">
                <input type="radio" name="emp" value="all" onclick="changeemp(this.value);" >Yes
                <input type="radio" name="emp" value="random" onclick="changeemp(this.value);" checked >No
					<input type="hidden" name="pay_type" value="L">
            </div>
            
            
			</div>
            <div class="clearFix"></div>
           
               <div class="clearFix">&nbsp;</div>
			 <div class="four padd0 columns">
			<div class="four padd0 columns pdl10p">Payment Date</div>
			<div class="eight padd0 columns">
					   <select name="payment_date" id = "payment_date" class="textclass"  >
		   <option value="">-- Select Date --</option>
		   <?php while($type = mysql_fetch_assoc($period)){?>
		   <option value="<?php echo $type['payment_date'];?>"><?php echo date('d-m-Y',strtotime($type['payment_date']));?></option>
		   <?php }?>
		   </select>

           
           
             <div class="one padd0 columns" id="margin1">
            </div>
            <div class="three padd0 columns" id="margin1">
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