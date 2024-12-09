<?php
session_start();
//print_r($_SESSION); 
if(isset($_SESSION['log_id'])&&$_SESSION['log_id']==''){
    header("location:../index.php");
}
             if($_SESSION['startbonusyear']=='' || $_SESSION['endbonusyear']=='')
                        {
                            
                             //  echo "<div style='text-align: center;font-size: 23px;color: #ff0000;margin-top: 15px;'>Invalid Bonus Year</div>";
                                header( "refresh:3;url=/user-home" );
                        }
                        ini_set('display_errors',1);
ini_set('display_startup_errors',1);
//ini_set('max_execution_time',900);
//set_time_limit(900);
error_reporting(0);


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
  <title>Bonus |Lock</title>
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

<?php // include('menu.php');?>

<!--Menu ends here-->
<div class="clearFix"></div>
<!--Slider part starts here-->

<div class="twelve mobicenter innerbg">
    <div class="row">
        <div class="twelve" id="margin1"> <h3>Bonus</h3></div>
         <?php 
                   if($_SESSION['startbonusyear']=='' || $_SESSION['endbonusyear']=='')
                        {
                               echo "<div style='text-align: left;font-size: 32px;color: #ff0000;margin-top: 15px;'>Invalid Bonus Year</div>";
                                header( "refresh:3;url=/user-home" );
                        }

        ?>     
        <div class="clearFix"></div>

        <div class="twelve" id="margin1">
            <div class="boxborder" id="adddepartment">
		<div class="seven padd0 columns"  >
		
		
		<div class="two padd0 columns"  >
                <span class="labelclass">Client :</span>
            </div>
		
	
		
		
					
            <div class="nine padd0 columns"  >
                <select class="textclass" name="client" id="client" onchange="updateCurrentMonth();">
                    <option value="">--Select--</option>
                     <?php  foreach($result1 as $row1){        ?>
                    
                        <option value="<?php echo $row1['mast_client_id']; ?>" data-current-month="<?php echo date('F Y', strtotime($row1['current_month'])); ?>">
            <?php echo $row1['client_name']; ?> - <?php echo date('F Y', strtotime($row1['current_month'])); ?>
          </option>
                    <?php }    ?>

                </select>
               <span style="color:#7d1a15;">
        Month: <span id="current-month">--select--</span>
    </span>
            </div>
            
			<div class="one padd0 columns"  ></div>
		</div>
		
		   
			<div class="one padd0 columns" align="center">
			    
			    
                <input type="button" onclick="updatelock();" class="btnclass" value="Lock the Data">


             </div>
			<div class="clearFix">&nbsp;</div>
			<div class="twelve padd0 columns hidecontent"  id="sucmessage">

                
            </div>
            
          
       
		
        <div class="clearFix"></div>
		<div id="display"></div>
		 </div>
		  </div>
    </div>   
    </div>

</div>

<!--Slider part ends here-->
<div class="clearFix"></div>
<div id="test"></div>
<!--footer start -->
<?php include('footer.php');?>


<!--footer end -->
<script>
function updatelock(){
	var client = $("#client").val();
	
	if(client ==""){
		$("#nerror").show();
		$("#nerror").text("Please select client");
		return false;
	}else{
		$("#nerror").hide();
		$("#tyerror").hide();
		$("#wagerror").hide();
		$("#bonerror").hide();
		$("#exgerror").hide();	
	
   
	$.post('/updatebonuslock',{
			'client':client
	        },function(data){ 
			$("#test").text(data);
			$('#sucmessage').show();
			$('#sucmessage').html('<div class="success31">&nbsp; &nbsp; Record Successfully Updated !</div>');
			$('#display').hide();			
             
            });
}
}





</script>

</body>

</html>