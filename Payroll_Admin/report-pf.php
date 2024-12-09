<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');


$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$result1 = $payrollAdmin->showClient1($comp_id,$user_id);
$result = $payrollAdmin->displayClientGroup();


$_SESSION['month']='current';

?>
<!DOCTYPE html>
<head>
  <meta charset="utf-8"/>
  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width"/>
  <title>Salary | Reports</title>
  <!-- Included CSS Files -->
  
<link rel="stylesheet" href="Payroll/css/jquery-ui.css">
<script type="text/javascript" src="Payroll/js/jquery.min.js"></script>
    <script type="text/javascript" src="Payroll/js/jquery-ui.js"></script>  

<style>
    .pfmaing {
    
    box-sizing: border-box;
}



</style>
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
        <div class="twelve" id="margin1"> <h3>P.F Reports List</h3></div>

        <div class="clearFix"></div>

        <div class="twelve" id="margin1">
    <div class="boxborder">
  <div class="pfmaing">
      <!--**********************-->
    <!-- Client: and Month: row -->
    <div class="row">
     
    <!-- Container for both rows -->
    <div class="row">
        <!-- Month: Current/Previous Row -->
        <div style="display: flex; align-items: center;">
               <div class="two columns">
                <span class="labelclass1" style="margin-right: 10px;">Month:</span>
     
               </div>  
               <div class="three columns">
                    <div style="display: flex; align-items: center; margin-right: 20px;">
                
                <label style="margin-right: 10px;">
                    <input type="radio" name="month" value="current" onclick="showdates();" checked> Current
                </label>
                <label style="margin-right: 10px;">
                    <input type="radio" name="month" value="previous" onclick="showdates();"> Previous
                </label>
                </div>
            </div>
            <div class="six columns">
               
            <!-- From Date Row (Initially hidden) -->
            <div id="showPrevious" class="hidecontent" style="display: none; flex: 1; align-items: center;">
                <div class ="two columns">
                    <span class="labelclass1">From:</span>
                </div>
                <div class ="three columns">
                    <input type="month" name="frdt" id="frdt" class="textclass">
                    <span class="errorclass hidecontent" id="fderror"></span>
                </div>
                <!--<div class ="two columns">
                    <span class="labelclass1">To:</span>
                </div>
                <div class ="three columns">
                    <input type="text" name="todt" id="todt" class="textclass">
                    <span class="errorclass hidecontent" id="fderror"></span>
                </div>-->


            </div>
            </div>
        </div>
    </div>


   <!-- Client Dropdown -->
        <div class="two columns">
            <span class="labelclass1">Client:</span>
        </div>
        <div class="three columns">
            <select class="textclass" name="client" id="client" onchange="updateCurrentMonth(); $('#linkshow').hide();
           resetClientGroup()" style="width: 100%;">
                <option value="">--Select--</option>
                <?php foreach($result1 as $row1) { ?>
                <option value="<?php echo $row1['mast_client_id']; ?>" data-current-month="<?php echo date('F Y', strtotime($row1['current_month'])); ?>">
                    <?php echo $row1['client_name']; ?> - <?php echo date('F Y', strtotime($row1['current_month'])); ?>
                </option>
                <?php } ?>
            </select>
            <span class="errorclass hidecontent" id="nerror" style="display: block; margin-top: 5px;"></span>
        </div>
        <!-- Month Display -->
        <div class="three columns" style="text-align: left;">
            <span style="color:#7d1a15; margin-left: 10px;">
                Month: <span id="current-month"></span>
            </span>
        </div>
    </div>

       
 
    <!-- Client Group row -->
    <div class="row">
        <div class="two columns">
            <span class="labelclass1">Client Group:</span>
        </div>
        <div class="three columns">
            <select class="textclass" name="clientGroup" id="clientGroup"  onchange="$('#linkshow').hide(); resetClient()">
                <option value="">--Select--</option>
                <?php foreach($result as $row2) { ?>
                <option value="<?php echo $row2['id']; ?>">
                    <?php echo $row2['group_name']; ?>
                </option>
                <?php } ?>
            </select>
        </div>
    <div class="one columns">
        <div style="justify-content: center; margin-bottom: 10px;">
    <button class="btnclass" onclick="saveclint();">Show</button>
    
  
</div>

    </div>
</div>
     <!--***********************-->

        
        
        
<div class="clearFix"></div>
        <div id="linkshow" class="hidecontent" style="margin-top: 00px;">
            <div class="row">
                <div class="two tab columns">
                    <ul style="list-style: none; background-color: #f7f7f7;">
                        <li><span class="btntableft tabbutton" onclick="diplayform(1);" id="1">Statement</span></li>
                        <li><span class="btntableft tabbutton" onclick="diplayform(2);" id="2">Summary</span></li>
                        <li><span class="btntableft tabbutton" onclick="diplayform(3);" id="3">UAN E.C.R.</span></li>
                        <!--<li><span class="btntableft tabbutton" onclick="diplayform(4);" id="4">Salary Summary</span></li>-->
                        <li><span class="btntableft tabbutton" onclick="diplayform(5);" id="5">Newly Joined Emp.</span></li>
                        <li><span class="btntableft tabbutton" onclick="diplayform(6);" id="6">Left Emp.</span></li>
                        <li><span class="btntableft tabbutton" onclick="diplayform(8);" id="8">Code Wise Summary</span></li>
                    </ul>
                </div>
                <div class="ten columns">
                    <div style="padding: 5px; border: 1px solid #8c8c8c; border-radius: 5px; min-height: 310px;" id="dispfrm"></div>
                </div>
            </div>
        </div>

        <div class="clearFix"></div>
    </div>
</div>


            

            <br/>
        </div>
    </div>
    </div>
</div>
<!--Slider part ends here-->
<div class="clearFix"></div>

<!--footer start -->
<?php include('footer.php');?>
<script>
// Function to reset clientGroup when a new client is selected
function resetClientGroup() {
    $('#clientGroup').val('');  
}

// Function to reset client when a new clientGroup is selected
function resetClient() {
    $('#client').val('');  
}
</script>
<link rel="stylesheet" href="Payroll/css/jquery-ui.css">
<script type="text/javascript" src="Payroll/js/jquery.min.js"></script>
    <script type="text/javascript" src="Payroll/js/jquery-ui.js"></script>
 <script>
   
    //  $( function() {
    //             $("#frdt").datepicker({
    //                 changeMonth: true,
    //                 changeYear: true,
    //                 dateFormat:'dd-mm-yy'
    //             });
    //             $("#todt").datepicker({
    //                 changeMonth: true,
    //                 changeYear: true,
    //                 dateFormat:'dd-mm-yy'
    //             });
    //         } );
        function saveclint(){
            $('#derror').html('');

            $('#nerror').html('');
            var val= document.getElementById('client').value;
            var cgrp= document.getElementById('clientGroup').value;
            if (val>0 && cgrp>0)
               {
                   alert ("Please select either Client or Client Group at a time !!");
                   $('#linkshow').hide();
           
                   return;
               }
            
            var frdt=0;
            //var todt=0;
            var Count=0;
            var months = document.getElementsByName('month');
            var month_value;
            for(var i = 0; i < months.length; i++){
                if(months[i].checked){
                    month_value = months[i].value;
                }
            }

            if(month_value=='current'){
                $('#showPrevious').hide();
            }
            if(val=='' && cgrp== ''){
                Count=0;
                $('#nerror').html("Please select the Client or Client Group");
                $('#nerror').show();
                document.getElementById("client").focus();
                $('#linkshow').hide();
            }
            else if(month_value=='previous'){
              //  $('#showPrevious').show();
                frdt = document.getElementById('frdt').value;
        //        todt = document.getElementById('todt').value;
alert("From Date: " + frdt);
                /*   var frdt1 = new Date(frdt);
                 var todt1 = new Date(todt);
                 */
                if(frdt==''){
                    $('#fderror').html("Please enter date");
                    $('#fderror').show();
                    $('#tderror').hide();
                    $('#linkshow').hide();
                }
                // else if(todt==''){
                //     $('#tderror').html("Please enter date");
                //     $('#tderror').show();
                //     $('#fderror').hide();
                //     $('#linkshow').hide();
                // }
                else{

                    Count=1;
                }

            }else{
                Count=1;
            }


            if(Count!=0){
                $('#nerror').html('');
                $('#nerror').hide();
                $.post('/store_session', {
                    'clientid': val,
                    'frdt':frdt,
                    'clientGrp':cgrp,
                    'month_value': month_value
                }, function (data) {
                    $('#linkshow').show();
                });
                diplayform(1);
            }

        }
        
        function showdates()
        {
 
            var month_value;
            var months = document.getElementsByName('month');
            $('#fderror').hide();
           for(var i = 0; i < months.length; i++){
                if(months[i].checked){
                    month_value = months[i].value;
                }
            }

            if(month_value=='current'){
                $('#showPrevious').hide();
            }
            else
            {
              $('#showPrevious').show();
            } 
        }

        function saveclint1(){

            var val= document.getElementById('client').value;

            var Count=0;
            var months = document.getElementsByName('month');
            var month_value;
            for(var i = 0; i < months.length; i++){
                if(months[i].checked){
                    month_value = months[i].value;
                }
            }
            if(val==''){
                Count=0;
                $('#nerror').html("Please select the Client");
                $('#nerror').show();
                document.getElementById("client").focus();
                $('#linkshow').hide();
            }
            else if(month_value=='previous'){
                $('#showPrevious').show();
                var frdt = document.getElementById('frdt').value;
                var todt = document.getElementById('frdt').value;

// Alert boxes to check the dates
        alert("From Date: " + frdt);
        alert("To Date: " + todt);
                if(frdt==''){
                    $('#fderror').html("Please enter From date");
                    $('#fderror').show();
                    $('#tderror').hide();
                    $('#linkshow').hide();
                }
                else if(todt==''){
                    $('#tderror').html("Please enter To date");
                    $('#tderror').show();
                    $('#fderror').hide();
                    $('#linkshow').hide();
                }
                else{
                    Count=1;
                }

            }else{
                Count=1;
            }


            if(Count!=0){
                $('#nerror').html('');
                $('#nerror').hide();
                $.post('/store_session', {
                    'clientid': val,
                    'frdt':frdt,
                    'todt':todt,
                    'month_value': month_value
                }, function (data) {
                    $('#linkshow').show();
                    $('#fderror').html('');
                    $('#tderror').html('');
                    $('#nerror').html('');
                });
                diplayform(1);
            }

        }

        function diplayform(val){
			
			
            if(val=='1'){
                $.post('/report-pf-statement', {
                }, function (data) {
                    $('#dispfrm').html(data);
                    $('.btntableft').removeClass('activeBtn');
                    $('.btntableft').addClass('tabbutton');
                    $('#'+val).addClass('activeBtn');
                    $('#'+val).removeClass('tabbutton');
                });
            }
            else if(val=='2'){
                $.post('/report-pf-statement-summary', {
                }, function(data) {
                    $('#dispfrm').html(data);
                    $('.btntableft').removeClass('activeBtn');
                    $('.btntableft').addClass('tabbutton');
                    $('#'+val).addClass('activeBtn');
                    $('#'+val).removeClass('tabbutton');
                });
            }
            else if(val=='3'){
                $.post('/report-pf_uan_ecr', {
                }, function(data) {
				    $('#dispfrm').html(data);
                    $('.btntableft').removeClass('activeBtn');
                    $('.btntableft').addClass('tabbutton');
                    $('#'+val).addClass('activeBtn');
                    $('#'+val).removeClass('tabbutton');
                });
            }
			else if(val=='4'){
                $.post('/report-pf_salary-summery', {
                }, function(data) {
				    $('#dispfrm').html(data);
                    $('.btntableft').removeClass('activeBtn');
                    $('.btntableft').addClass('tabbutton');
                    $('#'+val).addClass('activeBtn');
                    $('#'+val).removeClass('tabbutton');
                });
            }


			else if(val=='5'){
                $.post('/report-pf-newlyjoined', {
                }, function(data) {
				    $('#dispfrm').html(data);
                    $('.btntableft').removeClass('activeBtn');
                    $('.btntableft').addClass('tabbutton');
                    $('#'+val).addClass('activeBtn');
                    $('#'+val).removeClass('tabbutton');
                });
            }
			else if(val=='6'){
                $.post('report-pf-left', {
                }, function(data) {
				    $('#dispfrm').html(data);
                    $('.btntableft').removeClass('activeBtn');
                    $('.btntableft').addClass('tabbutton');
                    $('#'+val).addClass('activeBtn');
                    $('#'+val).removeClass('tabbutton');
                });
            }
			else if(val=='7'){
                $.post('/report-pf-form9', {
                }, function(data) {
				    $('#dispfrm').html(data);
                    $('.btntableft').removeClass('activeBtn');
                    $('.btntableft').addClass('tabbutton');
                    $('#'+val).addClass('activeBtn');
                    $('#'+val).removeClass('tabbutton');
                });
            }
           else if(val=='8'){ 
		          var client= document.getElementById('client').value;
		    
                $.post('/report-pf-code-summary', {
				
                }, function(data) {
				    $('#dispfrm').html(data);
                    $('.btntableft').removeClass('activeBtn');
                    $('.btntableft').addClass('tabbutton');
                    $('#'+val).addClass('activeBtn');
                    $('#'+val).removeClass('tabbutton');
                });
            }

			}
    </script>

<!--footer end -->

</body>

</html>
            