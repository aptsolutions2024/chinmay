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

$_SESSION['month']='current';
?>
<!DOCTYPE html>
<head>
  <meta charset="utf-8"/>
  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width"/>
  <title>Salary | Letters</title>
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
}</script>
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
        <div class="twelve" id="margin1"> <h3>Bonus Export</h3></div>

        <div class="clearFix"></div>
        <div class="boxborder" id="adddepartment">
		<form method ="post" action="/export-bonus-calculation" onsubmit="return validation()" onchange="updateCurrentMonth();">
        <div class="twelve" id="margin1">
            <div class="one padd0 columns"  >
                <span class="labelclass">Client :</span>
            </div>
            <div class="three padd0 columns"  >
                <select class="textclass" name="client" id="client" >
                    <option value="">--Select--</option>
                    <?php  foreach($result1 as $row1){        ?>
                    
                        <option value="<?php echo $row1['mast_client_id']; ?>" data-current-month="<?php echo date('F Y', strtotime($row1['current_month'])); ?>">
            <?php echo $row1['client_name']; ?> - <?php echo date('F Y', strtotime($row1['current_month'])); ?>
          </option>
                    <?php }    ?>

                </select>
                <span class="errorclass hidecontent" id="nerror"></span>
            </div> 
            <div class="one columns" align="center"></div>
<div class="two columns" align="center">

                <span style="color:#7d1a15;">
        Month: <span id="current-month">--select--</span>
    </span>
            </div>
            
            <div class="one columns" align="center"></div>
            
			<div class="two padd0 columns" align="center">
                <input type="submit"  class="btnclass" value="Export">
            </div>  
			<div class="clearFix"></div>
			<div class="twelve padd0 columns" id="success1"></div>			
          
        </div>	
</form>		
        <div class="clearFix"></div>
		<div id="display"></div>
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
function validation(){
	var client = $("#client").val();
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
	$("#success1").html('<div class="success31">&nbsp; &nbsp; Report Exporting Successfully!</div>');
}
</script>
</body>

</html>