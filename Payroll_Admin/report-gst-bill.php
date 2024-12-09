<?php
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
  <title>Salary | Reports</title>
  
        
<script>
function updateCurrentMonth() {
    var select = document.getElementById('client'); // Change 'clientid' to 'client'
    var selectedOption = select.options[select.selectedIndex];
    var currentMonth = selectedOption.getAttribute('data-current-month');
    document.getElementById('current-month').textContent = currentMonth || '--select--'; // Fallback to '--select--' if no month is found
}

            $( function() {
                $("#frdt").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat:'dd-mm-yy'
                });
				                
            } );
            function saveclint(){
                $('#derror').html('');
                $('#nerror').html('');
                var val= document.getElementById('client').value;
                var frdt=0;
                var todt=0;
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
                if(val==''){
                    Count=0;
                    $('#nerror').html("Please select the Client");
                    $('#nerror').show();
                    document.getElementById("client").focus();
                    $('#linkshow').hide();
                }
                else if(month_value=='previous'){
                    $('#showPrevious').show();
                    frdt = document.getElementById('frdt').value;
                    if(frdt==''){
                        $('#fderror').html("Please enter date");
                        $('#fderror').show();
                        $('#tderror').hide();
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
                        'month_value': month_value
                    }, function (data) {
                        $('#linkshow').show();
                    });
                    diplayform(1);
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
                    if(frdt==''){
                        $('#fderror').html("Please enter date");
                        $('#fderror').show();
                        $('#tderror').hide();
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
                $.post('/report-gst-statement', {
                }, function (data) {
                    $('#dispfrm').html(data);
                    $('.btntableft').removeClass('activeBtn');
                    $('.btntableft').addClass('tabbutton');
                    $('#'+val).addClass('activeBtn');
                    $('#'+val).removeClass('tabbutton');
                });
            }
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
        <div class="twelve" id="margin1"> <h3>GST Bill Reports</h3></div>
        <div class="clearFix"></div>
        <div class="twelve" id="margin1">
            <div class="boxborder" id="addAdvance">
            <div class="one padd0 columns"  >
                <span class="labelclass1">Client :</span>
            </div>
            <div class="three padd0 columns"  >
                <select class="textclass" name="client" id="client" onchange="saveclint(); updateCurrentMonth();">
                    <option value="">--Select--</option>
                    <?php foreach($result1 as $row1) {?>
                       <option value="<?php echo $row1['mast_client_id']; ?>" data-current-month="<?php echo date('F Y', strtotime($row1['current_month'])); ?>">
            <?php echo $row1['client_name']; ?> - <?php echo date('F Y', strtotime($row1['current_month'])); ?>
          </option>
          <?php } ?>
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
            
            
            
            
            <div class="one columns" align="center">
                <span class="labelclass1">Month :</span>
            </div>
            <div class="two columns">
                <input type="radio" name="month" value="current" onclick="saveclint();" checked>  Current
                <input type="radio" name="month" value="previous" onclick="saveclint();">  Previous
            </div>
            <div class="five columns">
                <div id="showPrevious" class="hidecontent">
                    <div class="one paddt0 columns" align="center">
                        <span class="labelclass1">Form</span>
                    </div>
                    <div class="four paddt0 columns">
                        <input type="text" name="frdt" id="frdt" class="textclass">
                        <span class="errorclass hidecontent" id="fderror"></span>
                    </div>
                    
                    <div class="one paddt0 columns">
                        <button  class="btnclass" onclick="saveclint1();">Show</button>
                    </div>

                </div>
            </div>
      
        <div class="clearFix"></div>
        <div id="linkshow" class="hidecontent">
        <div class="clearFix"></div>
        <div class="twelve" id="margin1">
            <div class="two tab columns">
            <ul style="list-style: none;background-color: #f7f7f7;">
                <li> <span class="btntableft tabbutton" onclick="diplayform(1);" id="1">GST BILL</span></li>
                <li> <span class="btntableft tabbutton" onclick="diplayform(2);" id="2">xxxxxxxx</span></li>
                <li> <span class="btntableft tabbutton" onclick="diplayform(3);" id="3">xxxxxxxx</span></li>
                <li> <span class="btntableft tabbutton" onclick="diplayform(4);" id="4">xxxxxxxx</span></li>

            </ul>
            </div>
            <div class="ten  columns">
           <div style="padding: 5px;border:1px solid #8c8c8c;border-radius:5px;min-height:310px;" id="dispfrm"></div>
                </div>
            </div>
            <div class="clearFix"></div>
            <br/>
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