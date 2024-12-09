<?php

$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$result1 = $payrollAdmin->showClient1($comp_id,$user_id);
$result = $payrollAdmin->displayClientGroup();
$_SESSION['month']='current';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Salary | HR Head Home</title>
    <link rel="stylesheet" href="/Payroll/css/responsive.css">
    <link rel="stylesheet" href="/Payroll/css/style.css">
    <script>
        

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
 function diplayform(val){


     if(val=='1'){
         $.post('/emp-attendance-page', {
         }, function (data) {
             $('#dispfrm').html(data);
             $('.btntableft').removeClass('activeBtn');
             $('.btntableft').addClass('tabbutton');
             $('#'+val).addClass('activeBtn');
             $('#'+val).removeClass('tabbutton');
         });
     }
     else if(val=='2'){
         $.post('/report-adv_employee', {
         }, function (data) {
             $('.btntableft').removeClass('activeBtn');
             $('.btntableft').addClass('tabbutton');
             $('#dispfrm').html(data);
             $('#'+val).addClass('activeBtn');
             $('#'+val).removeClass('tabbutton');
         });
     }
	 
     else if(val=='3'){
         $.post('/report-society-letter', {
         }, function (data) {
             $('.btntableft').removeClass('activeBtn');
             $('.btntableft').addClass('tabbutton');
             $('#dispfrm').html(data);
             $('#'+val).addClass('activeBtn');
             $('#'+val).removeClass('tabbutton');
         });
     } else if(val=='4'){
         $.post('/report-email-payslip11', {
         }, function (data) {
             $('.btntableft').removeClass('activeBtn');
             $('.btntableft').addClass('tabbutton');
             $('#dispfrm').html(data);
             $('#'+val).addClass('activeBtn');
             $('#'+val).removeClass('tabbutton');
         });
     }

 }
 
        function updateCurrentMonth() {
    var select = document.getElementById('client'); // Change 'clientid' to 'client'
    var selectedOption = select.options[select.selectedIndex];
    var currentMonth = selectedOption.getAttribute('data-current-month');
    document.getElementById('current-month').textContent = currentMonth || '--select--'; // Fallback to '--select--' if no month is found
}


function clientGroupReset(){
    $('#clientGroup').val('');
    
}
function clientReset(){
    $('#client').val('');
}
    </script>
</head>
<body>
    <!-- Header starts here -->
    <?php include('header.php'); ?>
    <!-- Header end here -->

    
<?php //include('menu.php'); ?>
    <div class="clearFix"></div>
<!--Slider part starts here-->

<div class="twelve mobicenter innerbg">
    <div class="row">
        <div class="twelve" id="margin1"> <h3>Advances Reports</h3></div>

        <div class="clearFix"></div>

        <div class="twelve" id="margin1">
		<div class="boxborder" id="addAdvance">
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
            <select class="textclass" name="client" id="client" onchange="updateCurrentMonth(); $('#linkshow').hide(); clientGroupReset()
           " style="width: 100%;">
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
            <select class="textclass" name="clientGroup" id="clientGroup"  onchange="$('#linkshow').hide(); clientReset()">
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
        <div id="linkshow" class="hidecontent">


        <div class="clearFix"></div>
        <div class="twelve" id="margin1">
            <div class="two   tab columns">
            <ul style="list-style: none;background-color: #f7f7f7;">
                <li> <span class="btntableft tabbutton" onclick="diplayform(1);" id="1">Emp Attendance</span></li>
               <!-- <li> <span class="btntableft tabbutton" onclick="diplayform(2);" id="2">For an employee</span></li>-->
               <!--<li> <span class="btntableft tabbutton" onclick="diplayform(3);" id="3">Bank/Soc.Letter</span></li>-->
               


            </ul>

            </div>
            <div class="ten  columns" style=" ">
           <div style="padding: 5px;border:1px solid #8c8c8c;border-radius:10px;" id="dispfrm"></div>
                </div>
            </div>


            <div class="clearFix"></div>

            <br/>


        </div>






 </div>














    </div>


    </div>

</div>

<!--Slider part ends here-->
<div class="clearFix"></div>

    <div class="footer">
        <p>&copy; 2024 Your Company | <a href="/privacy-policy">Privacy Policy</a> | <a href="/contact-us">Contact Us</a></p>
    </div>

    <!-- JavaScript for AJAX Submission -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
<script>
// $(document).ready(function() {
//     $('#payslip-form').on('submit', function(e) {
//         e.preventDefault(); // Prevent default form submission

//         var frdt = $('#from-date').val(); // Append '-01' for the first day of the month
//         var todt = $('#to-date').val(); // Same for the to-date

//         var empid = '<?= $emp_login_id ?>'; // Make sure this is correct
//         console.log("From date: " + frdt);
//         console.log("To date: " + todt);
//         console.log("Employee ID: " + empid);

//         if (empid === '' || empid === null) {
//             alert("Employee ID is missing");
//             return;
//         }

//         // Debug form data before sending
//         console.log("Sending From Date: " + frdt);
//         console.log("Sending To Date: " + todt);
        
//         // Validate date inputs
//         if (!frdt || !todt) {
//             alert('Please select both From Date and To Date');
//             return;
//         }

//       $.ajax({
//     url: '/emp-attendance',
//     method: 'POST',
//     data: {
//         frdt: frdt,
//         todt: todt,
//         empid: empid
//     },
//     success: function(response) {
//         console.log(response); // Log the response to see what’s coming back

//         // Optionally handle any returned data from the server here
//         // window.location.href = '/emp-attendance';
//     },
//     error: function(xhr, status, error) {
//         console.error('An error occurred: ' + error);
//         alert('There was an error processing your request.');
//     }
// });

//     });
// });

</script>

</body>
</html>
