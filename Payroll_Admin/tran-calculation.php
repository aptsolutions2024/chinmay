<?php

$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');


if($_SESSION['log_type']==2)
{
    
}else
{
    echo "<script>window.location.href='/payroll-logout';</script>";exit();
}
$result1 = $payrollAdmin->showClient1($comp_id,$user_id);



?>
<!DOCTYPE html>

<head>
  <meta charset="utf-8"/>
  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width"/>
  <title>Salary | Transactions Days</title>
  <!-- Included CSS Files -->
  <link rel="stylesheet" href="../Payroll/css/responsive.css">

  <link rel="stylesheet" href="../Payroll/css/style.css">
    <script type="text/javascript" src="../Payroll/js/jquery.min.js"></script>
  <script>
        function updateCurrentMonth() {
             $('#errorClient').html('');
            $('#errorClient').css('color','black');
            var select = document.getElementById('clientid'); // Correctly referencing 'clientid'
            var selectedOption = select.options[select.selectedIndex];
            var currentMonth = selectedOption.getAttribute('data-current-month');
            
            document.getElementById('current-month').textContent = currentMonth || '--select--';
        }
        function calsal(){
            var clientid= document.getElementById('clientid').value;
            if(clientid!='0'){
                $('#display').html('<div style="height: 200px;padding-top:100px;" align="center"> <img src="../Payroll/images/loading1.gif" /></div>');
		        var wagediff=0;
		        var otdiff =0;
		        var allowdiff =0;
                  $.post('/sal-calc',{
                      'clientid':clientid,
        			  'wagediff':wagediff,
        			  'otdiff':otdiff,
        			  'allowdiff':allowdiff,
        			  
                  },function(data){
                      $("#display").html(data);
                  });
            }else{
                $('#errorClient').html('Please select Client');
                $('#errorClient').css('color','red');
            }
        }
  </script>

 <body>

<!--Header starts here-->
<?php include('header.php');?>
<!--Header end here-->
<div class="clearFix"></div>
<div class="clearFix"></div>
<!--Slider part starts here-->

<div class="twelve mobicenter innerbg">
    <div class="row">
        <div class="twelve padd0" id="margin1"> <h3>Transactions Calculation</h3></div>
        <div class="clearFix"></div>
        <div class="twelve padd0" id="margin1">
            <div class="boxborder">
            <div class="one padd0 columns"  id="margin1">
                <span class="labelclass">Client :</span>
            </div>
           <div class="four padd0 columns" id="margin1">
                <select id="clientid" name="clientid" class="textclass" onchange="updateCurrentMonth();">
                    <option value="0">--select--</option>
                    <?php foreach($result1 as $row1) { ?>
                        <option value="<?php echo $row1['mast_client_id']; ?>" data-current-month="<?php echo date('F Y', strtotime($row1['current_month'])); ?>">
                            <?php echo $row1['client_name']; ?> - <?php echo date('F Y', strtotime($row1['current_month'])); ?>
                        </option>
                    <?php } ?>
                </select>
                <span id="errorClient" ></span>
                <span style="color:#7d1a15; margin-left: 10px;">
                    Month: <span id="current-month">--select--</span>
                </span>
            </div>
            <div class="four  padd0 columns" id="margin1" align="center">
                
                <button class="btnclass" onclick="calsal()">
                    Calculation

                </button>
            </div>
            <div class="clearFix">&nbsp;</div>
			<!-- <div class="five  padd0 columns" id="margin1" align="center">-->

			
			
			
		<div class="twelve padd0" id="margin1" style = "dispaly:none;">
            <!--div class="one padd0 columns"  >
                <span class="labelclass1 pdl10p"> Wage Diff:</span>
				</div>
				<div class="one padd0 columns">
				<span ><input type="text" value="" name="wagediff" class="textclass" id="wagediff"><div id="errinv" class="errorclass hidecontent"></div></span>
				</div>
            </div>
			 
			<div class="four padd0 columns">
				<div class="four padd0 columns">
                <span class="labelclass1 pdl10p"> Ot Diff:</span>
				</div>
				<div class="two padd0 columns">
				<span ><input type="text" name="Otdiff" id="otdiff" class="textclass"><div id="errinvdt"class="errorclass hidecontent"></div></span>
				</div>
            </div>
			<div class="clearFix">&nbsp;</div>
			
			<div class="twelve padd0" id="margin1">
            <div class="one padd0 columns"  >
                <span class="labelclass1 pdl10p"> 
					Allow Diff :</span>
				</div>
				<div class="one padd0 columns">
				<input type="text" name="allowdiff" id="allowdiff" class="textclass" ><div id="errinvdt"class="errorclass hidecontent"></div>
				</div>
            </div>
			<!--			<div class="four padd0 columns">
				<div class="four padd0 columns">
                <span class="labelclass1 pdl10p">  For Month :</span>
				</div>
				<div class="eight padd0 columns">
				<input type="text" name="saldate" id="saldate" class="textclass" value="4.75"><div id="errinvdt"class="errorclass hidecontent"></div>
				</div>
            </div>-->
			
			
            
			
			<!--</div> -->





      


                <div class="clearFix"></div>








    <div class="twelve" id="display">

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


<!--footer end -->

</body>

</html>