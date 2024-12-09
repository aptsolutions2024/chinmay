<?php
session_start();
// print_r($_SESSION);
if(isset($_SESSION['log_id'])&&$_SESSION['log_id']==''){
    header("/index");
}

$doc_path=$_SERVER["DOCUMENT_ROOT"];
include ($doc_path.'/include_payroll_admin.php');

$user_id=$_SESSION['log_id'];
$comp_id=$_SESSION['comp_id'];
$result11=$payrollAdmin->showClient1($comp_id,$user_id);
//print_r($result11);
?>
<!DOCTYPE html>
<head>
  <meta charset="utf-8"/>
  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width"/>
  <title>Salary | Employee</title>
  <!-- Included CSS Files -->
  <link rel="stylesheet" href="../css/responsive.css">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
  <link rel="stylesheet" href="../css/style.css">
  <style>
  #hidedatewisedetails{
      display:none;
  }
  #datewisedetailsmsg{
    color: red;
    margin: 4% 17%;
    font-size: 28px;
  }
      .alert-danger{
        color:red;
        border: 1px solid;
        padding: 10px 15px;
        margin: 10px;
      }
      
      span.errormsgspan{
        padding-left: 4%;
      }
      
      
     .alert-success h1{
        padding: 20px;
        color: green;
        border: 1px solid;
        margin: 9px;
      }
  </style>
<script>
    function validation() {
        var errormsg ='';
        var file = document.getElementById('file').value;
       
       if(file ==""){
            // error ="Please Select the file";
            alert("Please Select the file");
            return false;
        }
         var val=document.getElementById('client').value;
            if(val==0){
                alert("Please Select the Client Name");
                document.getElementById("client").focus();
                  return false;
            }
    }
  function displaydata(){ 
            $(".successclass").hide();
            var val=document.getElementById('client').value;
            if(val==0){
                alert("Please Select the Client Name");
                document.getElementById("client").focus();
                  return false;
            }
            else {
                var base_url = window.location.origin;
                window.location.href = base_url+"/display-datewise-details?id="+val;
            //  $.post('/display-datewise-details',{
            //     'id':val,
            // },function(data){
            //   $("#displaydata").html(data);
            // });
            }
        }
          function displaydataWO(){ 
            var val=document.getElementById('client').value;
            if(val==0){
                alert("Please Select the Client Name");
                document.getElementById("client").focus();
                  return false;
            }
            else {
                var base_url = window.location.origin;
                window.location.href = base_url+"/display-datewise-details?id="+val+"&flag=YES";
            }
        }
        
         function displayExistRecords(){ 
            var val=document.getElementById('client').value;
            if(val==0){
                alert("Please Select the Client Name");
                document.getElementById("client").focus();
                  return false;
            }
            else {
                var base_url = window.location.origin;
                window.location.href = base_url+"/display-datewise-details?id="+val+"&flag=Existing";
            }
        }
        
    function updateCurrentMonthClient() {
       
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

       
    </script>

</head>
 <body>

<!--Header starts here-->
<?php include('header.php');?>
<!--Header end here-->
<div class="clearFix"></div>
<!--Menu starts here-->

<!--Slider part starts here-->

<div class="twelve mobicenter innerbg">
    <div class="row">
       
        <div class="clearFix"></div>

      <div class="twelve padd0" id="margin1"> <h3>Employee Import </h3></div>

        <div class="twelve padd0" id="margin1"> <h4>Step No.1</h4></div>
        <br/>
        <form method="post"  name="frm" action="/datewise_document_details_process"  enctype="multipart/form-data" onsubmit="return validation();">


        <div class="twelve" >

            <div class="two padd0 columns" >
                <span class="labelclass">Client :</span>
            </div>
           <div class="row" style="display: flex; align-items: center;">
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

  
           
         

        </div>
    
   
        <div class="clearFix"></div>
          <div class="twelve padd0" id="datewisedetailsmsg"></div>
        <span id="hidedatewisedetails">
        <div class="twelve padd0" id="margin1"> <h4>Step No.2</h4></div>
        <br/>

        <div class="twelve " >
              <div class="two padd0 columns" >
              
            </div>
              <div class="ten padd0 columns">
                    <input type="button" class="btnclass" onclick="displaydata();" value="Export Employee Data ( Blank Format )">
               
              
                    <input type="button" class="btnclass" onclick="displaydataWO();" value="Export Employee Data ( PP,WO Format )">
                
             
                     <input type="button" class="btnclass" onclick="displayExistRecords();" value="Export Employee Data ( Existing Records )">
                 </div>
                 <div id="displaydata"></div>
         </div>
           
        
        <div class="clearFix"></div>
         
      <div class="twelve padd0" id="margin1"> <h4>Step No.3</h4></div>
        <br/>
        <div class="twelve " >
            <div class="two  columns" >
              Upload CSV File :
            </div>
            <div class="four columns">

                <input type="file" name="file" id="file" class="textclass"><br/>
                <span class="errorclass hidecontent" id="errormsg"></span>
                  </div>
            <div class="one columns">
                <input type="submit" name="submit" id="submit" value="Upload" class="btnclass" >
            </div>

        </div>
        <div class="clearFix"></div>
        </span>
            </form>


<div id="errorMsg">
      <?php  if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg']!="") {?>
                                        <div class="alert-danger" role="alert">
                                            <?=$_SESSION['errorMsg'];
                                            $_SESSION['errorMsg']="";
                                            ?>
                                        </div>
      <?php } ?>   
      <?php if(isset($_SESSION['successMsg']) && $_SESSION['successMsg']!="") {?>
                                        <div class="alert-success" role="alert">
                                          <h1>  <?=$_SESSION['successMsg'];
                                          $_SESSION['successMsg']="";
                                          ?></h1>
                                        </div>
                                    <?php } ?>
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