<?php

$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

if($_SESSION['log_type']==2 || $_SESSION['log_type']==3 )
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
  <style>  #datewisedetailsmsg{
       color: red;
    font-size: 20px;
    text-align: center;
  }</style>
    <script type="text/javascript" src="../Payroll/js/jquery.min.js"></script>
  <script>
   function updateCurrentMonth() {
        var select = document.getElementById('client'); // Change 'clientid' to 'client'
        var selectedOption = select.options[select.selectedIndex];
        var currentMonth = selectedOption.getAttribute('data-current-month');
        $("#cm").val(currentMonth);
          var datewisedetails=selectedOption.getAttribute('data-datewise-details'); 
      
        if(datewisedetails=='Y'){
                $("#datewisedetailsmsg").html("Day Details Can Be Changed Only Through Menu->Datewise Details");
        }else if(datewisedetails=='N'){
           $("#datewisedetailsmsg").html();
        }
        document.getElementById('current-month').textContent = currentMonth || '--select--'; // Fallback to '--select--' if no month is found
    }
    function clstr(){
          $('#clerror').html("");
          $('#lmterror').html("");
    }
    function displaydata(){ //alert("hello");
            $(".successclass").hide();
            clstr();
            var val=$("#client").val();
            $("#client").removeClass('bordererror');
             var lmt=$("#lmt").val();
             $("#lmt").removeClass('bordererror');
            if(val=='0'){
                $("#client").focus();
               error ="Please Select the Client Name";
        	   $("#client").val('');
        	   $("#client").addClass('bordererror');
        	   $("#client").attr("placeholder", error);
            }else if(lmt=='0'){
                $("#lmterror").focus();
                error ="Please Select the Limit";
        	   $("#lmterror").val('');
        	   $("#lmterror").addClass('bordererror');
        	   $("#lmterror").attr("placeholder", error);
            } else {
                 $.post('/display-tran-days',{
                    'id':val,
                    'lmt':lmt
                },function(data){
                    var result = data.split('$$$');
                    if(result[0]>0){
                        $('#SetForAllDiv').css('display','block');
                         $("#presentDays").val('');
                         $("#weeklyOff").val('');
                         $("#paidHoliday").val('');
                    }else{
                         $("#presentDays").val('');
                         $("#weeklyOff").val('');
                         $("#paidHoliday").val('');
                         $('#SetForAllDiv').css('display','none');
                    }
                    $("#display").html(result[1]);
                    $("#display").show();
                    
                });
                monthdisplay(val);
            }
        }

      function monthdisplay(val){
          $.post('/display-monthval',{
              'id':val
          },function(data){
              $("#sm").html(data);
              $("#sm").show();
          });
      }
      //added by Shraddha on 07-10-2024
    function SetAmt(){
       var prArr = document.getElementsByName('pr[]');
       var woArr = document.getElementsByName('wo[]');
       var phArr = document.getElementsByName('ph[]');
       
       var presentDays = $("#presentDays").val();
       var weeklyOff = $("#weeklyOff").val();
       var paidHoliday = $("#paidHoliday").val();
       for ( var i = 0; i < prArr.length; i++ ){
            {
                prArr[i].value= Number(presentDays).toFixed(2);
                woArr[i].value= Number(weeklyOff).toFixed(2);
                phArr[i].value= Number(paidHoliday).toFixed(2);
            }
        }
    }
    function clearAmt(){
        $("#presentDays").val('');
        $("#weeklyOff").val('');
        $("#paidHoliday").val('');
         var prArr = document.getElementsByName('pr[]');
        var woArr = document.getElementsByName('wo[]');
       var phArr = document.getElementsByName('ph[]');
       for ( var i = 0; i < prArr.length; i++ ){
            {
                prArr[i].value= '';
                woArr[i].value= '';
                phArr[i].value= '';
            }
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

<form id="form" action="/tran-day-process" method="post">
<div class="twelve mobicenter innerbg">
    <div class="row">
        <div class="twelve padd0" id="margin1"> <h3>Transactions Days</h3></div>
        <div class="clearFix"></div>
                <?php
                if(isset($_REQUEST['msg']) && $_REQUEST['msg']=='update'){
                    ?>
                <div class="twelve padd0 columns successclass">
                    <br />Transactions Updated successfully!<br />
                </div>
                <?php
                }
                ?>
                <div class="clearFix"></div>
            <div class="twelve" id="margin1">
                <div class="boxborder" style="min-height: 100px;">
                <div class="one padd0 columns"  >
                    <span class="labelclass">Client :</span>
                </div>
                <div class="four padd0 columns"  >
                    <input type="hidden" id="cm" name="cm" >
                    <select class="textclass" name="client" id="client" onchange="displaydata();updateCurrentMonth();">
                        <option value="0">--Select--</option>
                        <?php foreach ($result1 as $row1){?>
                            <option value="<?php echo $row1['mast_client_id']; ?>" data-current-month="<?php echo date('F Y', strtotime($row1['current_month'])); ?>" data-datewise-details="<?=$row1['daywise_details'];?>">
                            <?php echo $row1['client_name']; ?> - <?php echo date('F Y', strtotime($row1['current_month'])); ?>
                          </option>
                          <?php } ?>
                    </select>
                    <br>
                    <span style="color:#7d1a15; margin-left: 10px;">
                        Month: <span id="current-month">--select--</span>
                    </span>
                    <span class="errorclass hidecontent" id="clerror"></span>
                </div>
                <div class="two padd0 columns"  align="center" style="display:block;">
                    <span class="labelclass">Record Range :</span>
                </div>
                <div class="two padd0 columns"style="display :block">
                    <select class="textclass" name="lmt" id="lmt" onchange="displaydata();">
                        <option value="0, 30">0 to 30</option>
                        <option value="30, 30">31 to 60</option>
                        <option value="60, 30">61 to 90</option>
                        <option value="90, 30">91 to 120</option>
                        <option value="120, 30">121 to 150</option>
                        <option value="150, 30">151 to 180</option>
                        <option value="180, 30">181 to 210</option>
                        <option value="210, 30">211 to 240</option>
                        <option value="240, 30">241 to 270</option>
                        <option value="270, 30">271 to 300</option>
                        <option value="300, 30">301 to 330</option>
                        <option value="330, 30">331 to 360</option>
                    </select>
                    <span class="errorclass hidecontent" id="lmterror"></span>
                </div>
                <div class="three padd0 columns">
                    <!--<span class="labelclass">Month :</span> <span class="labelclass" id="sm">&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </span>&nbsp;-->
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                    <input type="button" onclick="displaydata();" class="btnclass" value="Show" >
                </div>
                <div class="clearFix"></div>
                <div class="twelve padd0" id="datewisedetailsmsg"></div>
                <div class="clearFix"></div>
                <!-- added by Shraddha on 07-10-2024 -->
                <div class="row" id="SetForAllDiv" style="display:none;margin-left:120px;margin-top:10px">
                    <div class="two columns">
                        <label>Present Days</label>
                        <input type="text" name="presentDays" id="presentDays" placeholder="0" class="textclass" value="">
                    </div>
                     <div class="two columns">
                         <label>Weekly Off</label>
                        <input type="text" name="weeklyOff" id="weeklyOff" placeholder="0" class="textclass" value="">
                    </div>
                     <div class="two columns">
                         <label>Paid Holiday</label>
                        <input type="text" name="paidHoliday" id="paidHoliday" placeholder="0" class="textclass" value="">
                    </div>
                
                    <div class="columns" style="margin-top:20px;">
                        <input type="button" value="Set Std Amt" class="btnclass" onclick="SetAmt();">
                    </div>
                    <div class="columns" style="margin-top:20px;">
                        <input type="button" value="Clear" class="btnclass" onclick="clearAmt();">
                    </div>
                </div>
                <div class="twelve" id="display" align="center">
                </div>
         </div>
         </div>
    </div>
	</div>
</form>
</div>
<!--Slider part ends here-->
<div class="clearFix"></div>

<!--footer start -->
<?php include('footer.php');?>

<!--<script src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>-->

<!--footer end -->

</body>

</html>