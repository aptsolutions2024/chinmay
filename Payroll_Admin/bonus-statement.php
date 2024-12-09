<?php
session_start();
//print_r($_SESSION);
if(isset($_SESSION['log_id'])&&$_SESSION['log_id']==''){
    header("location:../index.php");
}
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$result1 = $payrollAdmin->showClient1($comp_id,$user_id);
$result2 = $payrollAdmin->getBonusType();
$_SESSION['month']='current';
?>
<!DOCTYPE html>
<head>
  <meta charset="utf-8"/>
  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width"/>
  <title>Salary | Bonus Statements</title>
  <!-- Included CSS Files -->

  <link rel="stylesheet" href="../css/responsive.css">
  <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/jquery-ui.css">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/jquery-ui.js"></script>
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

<?php //include('menu.php');?>

<!--Menu ends here-->
<div class="clearFix"></div>
<!--Slider part starts here-->

<div class="twelve mobicenter innerbg">
    <div class="row">
        <div class="twelve" id="margin1"> <h3>Bonus Statement</h3></div>

        <div class="clearFix"></div>
        <div class="boxborder" id="adddepartment">
		<form method="post" action="/r-report-bonus-statement" onsubmit="return calulation()" onchange="updateCurrentMonth();">
        <div class="twelve" id="margin1">
		
			<div class="one padd0 columns"  >
                <span class="labelclass">Client :</span>
            </div>
            <div class="three padd0 columns"  >
                <select class="textclass" name="client" id="client" onchange="saveclint();" >
                    <option value="">--Select--</option>
                   <?php  foreach($result1 as $row1){        ?>
                    
                        <option value="<?php echo $row1['mast_client_id']; ?>" data-current-month="<?php echo date('F Y', strtotime($row1['current_month'])); ?>">
            <?php echo $row1['client_name']; ?> - <?php echo date('F Y', strtotime($row1['current_month'])); ?>
          </option>
          
                    <?php }    ?>

                </select>
                <span class="errorclass hidecontent" id="nerror"></span>
 <span style="color:#7d1a15; margin-left: 10px;">
        Month: <span id="current-month">--select--</span>
    </span>
            </div>
			
            <div class="five padd0 columns"  >
                <div class="four columns" align="center">

                <span class="labelclass">Lower range of Days :</span>
            </div>
            <div class="three columns">
			            <input type="text" name="days" id="days" value ="0" class="textclass"  onchange="saveclint();">
			</div>
            </div>
			
			<div class="two  columns"  align="center"><input type="submit" class="btnclass" value="Print"></div>
		
		
		 <div class="clearFix">&nbsp;</div>
		    <div class="twelve" id="margin1" style="display:none;">
            <div class="two padd0 columns">
                <span class="labelclass1">Employee :</span>
            </div>
           
            <div class="four padd0 columns" >
			<input type="hidden" value="" name="employee" id="eid">
			<input type="text" onkeyup="serachemp1(this.value);" class="textclass" placeholder="Full Name" id="name" autocomplete="off" name="name">
            <div id="searching" style="z-index:10000;position: absolute;width: 97%;border: 1px solid rgba(151, 151, 151, 0.97);display: none;background-color: #FFFFFF;">
        </div>
		<div id="errinm" class="errorclass hidecontent"></div>
            </div>

            <div class="four padd0 columns">
            </div>
			</div>
			 <div class="clearFix"></div>
		
           
			<div class="one padd0 columns" align="center">

                
            </div>
            
          
        </div>
        
		</form>
        <div class="clearFix"></div>
		<div id="display"></div>
        
    </div>     </div>   
    </div>

</div>

<!--Slider part ends here-->
<div class="clearFix"></div>
<div id="test"></div>
<!--footer start -->
<?php include('footer.php');?>


<!--footer end -->
<script>
     function saveclint(){
         $('#derror').html('');
         $('#nerror').html('');
         var val= document.getElementById('client').value;
         var frdt=0;
         var todt=0;
         var Count=0;
         
         if(val==''){
                   Count=0;
             $('#nerror').html("Please select the Client");
             $('#nerror').show();
             document.getElementById("client").focus();
             $('#linkshow').hide();
         }       
		 else{
             Count=1;
         }

  if(Count!=0){
            $('#nerror').html('');
            $('#nerror').hide();
            $.post('/store_session', {
                'val': val,
				'clientid': val
				//'month_value': month_value
            }, function (data) {
                $('#linkshow').show();
            });
               diplayform(1);
        }
     }
	function serachemp1(val){
        $.post('display-employee3', {
            'name': val
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
	   $("#eid").val(id);
	   document.getElementById('empid').value=id;
		//refreshconutIncome(id);
   });

}
function calulation(){
	var client = $("#client").val();
	var type = $("#type").val();
	var amount = $("#amount").val();
	var bonusrate = $("#bonusrate").val();
	var exgratia = $("#exgratia").val();
	var sessionstartdate = '<?php  if(isset($_SESSION['startbonusyear'])){echo $_SESSION['startbonusyear'];};?>';
	var sessionenddate = '<?php  if(isset($_SESSION['endbonusyear'])){echo $_SESSION['endbonusyear'];};?>';
	if(sessionstartdate =="" || sessionenddate==""){		
		$("#display").html('<div class="error31">Please select bonus Year</div>');
		return false;
	}
	if(client ==""){
		$("#nerror").show();
		$("#nerror").text("Please select client");
		return false;
	}else{
		$("#nerror").hide();	
	
}
}
function displaywages(val){
	$("#wamt").show();
	if(val =='2'){
		$("#wamtsec").show();
	}else{
		$("#wamtsec").hide();
	}
}
</script>

</body>

</html>