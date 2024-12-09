<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');
//$result11=$payrollAdmin->showClient1($comp_id,$user_id);
$result11=$payrollAdmin->showClientNoGroup($comp_id,$user_id);
//print_r($result11);
$result = $payrollAdmin->displayClientGroup();
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];




?>
<!DOCTYPE html>
<head>
  <meta charset="utf-8"/>
  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width"/>
  <title>Salary | Monthly Closing</title>
<style>
    .showclientlist{
        display:none;
    }
    .resuccofmonthlyclose{
        color:green;
        border:1px solid red;
        padding:2%;
    }
    .resfailofmonthlyclose{
        color:red;border:1px solid red;
          padding:2%;
    }
</style>
  <script>
 function updateCurrentMonthClient() {
         $("#display").html("");
    $(".hideonclintchange").hide();
    var select = document.getElementById('client');
    var selectedOption = select.options[select.selectedIndex];
    var currentMonth = selectedOption.getAttribute('data-current-month');
    var datewisedetails=selectedOption.getAttribute('data-datewise-details'); 
  
    if(datewisedetails=='Y'){
         $("#hidedatewisedetails").show();
         $("#datewisedetailsmsg").html("");
    }else if(datewisedetails=='N'){
         $("#hidedatewisedetails").hide();
         $("#datewisedetailsmsg").html("Datewise details not available for this client");
       //  alert("Datewise details not available for this client");
    }
    document.getElementById('current-month-client').textContent = currentMonth ? currentMonth : '--select--';
}
function showClients(){
     $(".hideonclintchange").hide();
     $("#display").html("");
    var select = document.getElementById('clientGroup');
    var selectedOption = select.options[select.selectedIndex];
    var cgvlue = selectedOption.getAttribute('value');
   
     if(cgvlue=='1'){
         
         $(".showclientlist").show();
          var clientGroup = $('#clientGroup').val();
          $.post('/get-clientlist-of-group',{
              'clientGroup':clientGroup,
          },function(data){
              $(".showclientlist").html(data);

          });
    }else{
         $(".showclientlist").hide();
    }
}

      function closing(){
             $('#loaderDiv').show();
           //  return false;
        //  $('#display').html('<div style="height: 200px;width:400px;padding-top:100px;" align="center"> <img src="../images/loading.gif" /></div>');
          var clientGroup = $('#clientGroup').val();
          var clientid = $('#client').val();
          $.post('/monthly_closing',{
              'clientGroup':clientGroup,
              'clientid':clientid
          },function(data){
                  $('#loaderDiv').hide();
              $("#display").html(data);

          });
      }
	  
	  
	  
      function update_advances(){
         $('#display').html('<div style="height: 200px;width:400px;padding-top:100px;" align="center"> <img src="../images/loading.gif" /></div>');
          var clientid = '1';
          $.post('/update_advances',{
              'clientid':clientid
          },function(data){
 
              $("#display").html(data);
             // showClients();

          });
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
    <div class="row" >
         <div class="boxborder" id="chackPassword" style="height: 120px;margin-top: 3%;" >
       
            <div class="one padd0 columns">
            <span class="labelclass">Password :</span>
            </div>
            <div class="four padd0 columns">
                <input type="password" name="password" id="password" placeholder="Enter password" class="textclass">
                <span class="errorclass hidecontent" id="cnerror"></span>
            </div>
             <div class="clearFix"></div>
             <div class="one padd0 columns"></div>
            <div class="four padd0 columns" id="margin1">
             <button class="btnclass" onclick="checkPassword()"> Submit</button>
          </div>
          </div>
            
       <div id="monthlyClosing" style="display:none;">
        <div class="twelve padd0" id="margin1"> <h3>Monthly Closing</h3></div>
        
        <div class="clearFix"></div>
        <div class="boxborder" id="addOtherPayment">
          <div class="twelve padd0" id="margin1">
            <div class="two columns">
            <span class="labelclass1">Client Group:</span>
        </div>
        <div class="three columns">
            <select class="textclass" name="clientGroup" id="clientGroup"  onchange="showClients()">
                <option value="">--Select--</option>
                <?php foreach($result as $row2) { ?>
                <option value="<?php echo $row2['id']; ?>">
                    <?php echo $row2['group_name']; ?>
                </option>
                <?php } ?>
            </select>
        </div>
            <div class="six columns"  id="">
               <!-- <span class="labelclass">Client :</span> -->
            </div>
            </div>
                  <div class="clearFix"></div>
                     <!--<div class="boxborder" id="addOtherPayment">-->
        <div class="twelve padd00 showclientlist" id="margin1" >
         
             <div class="two padd0 columns" >
                <span class="labelclass">Client :</span>
            </div>
    
             <div class="four columns">
                        <select id="client" name="client" class="textclass" onchange="updateCurrentMonthClient();">
                          <option value="0">--select--</option>
                          <?php foreach($result11 as $row1) { ?>
                              <option value="<?php echo $row1['mast_client_id']; ?>" data-current-month="<?php echo date('F Y', strtotime($row1['current_month'])); ?>" data-datewise-details="<?=$row1['daywise_details'];?>">
                                  <?php echo $row1['client_name']; ?> - <?php echo date('F Y', strtotime($row1['current_month'])); ?>
                              </option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="three columns">
                                   <span style="color:#7d1a15; margin-left: 10px; text-align:center;">Month: <span id="current-month-client"> </span></span>
                      </div>
             </div>
            <!--</div>-->
            <div class="clearFix"></div>
            <div class="twelve padd00" id="margin1" style="text-align:center;">
            
                <button class="btnclass" onclick="closing()">
                    Monthly Closing
                </button>
                <br>    <br>
                 <div  id="loaderDiv" style="display:none;">
        		    <div style="height: 200px;width:400px;margin: 0 auto;"> <img src="<?=$global_base_url;?>/Payroll/images/loading.gif" /></div>
        		  </div>
           

            </div>
            </div>
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

<script>
    function checkPassword()
    {
        var password= $("#password").val();
        if(password ==""){
           $("#password").focus();
           error ="Please enter password";
           $("#password").val('');
           $("#password").addClass('bordererror');
           $("#password").attr("placeholder", error);
           return false;
        }else if(password=='chinmaypw')
        {
          $("#monthlyClosing").show();
          $("#chackPassword").hide();
        }else
        {
            alert("Your password does not match. Please try again.");
            $("#password").val('');
        }
    }
</script>

<!--footer end -->

</body>

</html>