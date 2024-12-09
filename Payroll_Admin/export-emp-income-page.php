<?php
session_start();

if(isset($_SESSION['log_id'])&&$_SESSION['log_id']==''){
    header("/home");
}
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(0);
$doc_path=$_SERVER["DOCUMENT_ROOT"];
include ($doc_path.'/include_payroll_admin.php');
//$userObj=new user();
$user_id=$_SESSION['log_id'];
$comp_id=$_SESSION['comp_id'];
$result11=$payrollAdmin->showClient1($comp_id,$user_id);


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

<script>
    function updateCurrentMonth() {
      var select = document.getElementById('clientid');
      var selectedOption = select.options[select.selectedIndex];
      var currentMonth = selectedOption.getAttribute('data-current-month');
      document.getElementById('current-month').textContent = currentMonth;
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
        <div class="twelve padd0" id="margin1"> <h3>Employee Income Export </h3></div>
        <div class="clearFix"></div>
        <br/>
        <form method="post"  name="frm" action="/export_income" method="post"  enctype="multipart/form-data" onsubmit="return validation();" >
           <input type="hidden" name="cal" id="cal" value="all">

        <div class="twelve" >
            <div class="one   columns">
                <span class="labelclass1">Employee :</span>
            </div>
            <div class="two  columns">
                <input type="radio" name="emp" value="0" onclick="changeemp(this.value);" checked>All
                <input type="radio" name="emp" value="1" onclick="changeemp(this.value);" >Client wise
            </div>
            <div class="nine columns">
                <span id="clientshow" class="hide">
                <span class="labelclass">Client :</span>
                <select id="clientid" name="clientid" class="six textclass" onchange="checkout(this.value); updateCurrentMonth();">
                    <option value="0">--select--</option>
                    <?php
                   // while($row1=$result11->fetch_assoc()){
                   foreach($result11 as $row1){                       ?>
                        <option value="<?php echo $row1['mast_client_id']; ?>" data-current-month="<?php echo date('F Y', strtotime($row1['current_month'])); ?>">
            <?php echo $row1['client_name']; ?> - <?php echo date('F Y', strtotime($row1['current_month'])); ?>
          </option>
          <?php }

                    ?>
                </select>&nbsp;&nbsp;&nbsp;
                 <span style="color:#7d1a15;"> Month : <span id="current-month">--select--</span></span>

                 </span>
            </div>
        </div>

        <div class="clearFix"></div>

        <div class="two  columns" id="margin1">
            <span class="labelclass1">Include Left Employees :</span>
        </div>
        <div class="two  columns" id="margin1">
            <input type="radio" name="left" value="yes" >Yes
            <input type="radio" name="left" value="no" checked>No
        </div>

        <div class="eight padd0 columns" id="margin1">
            &nbsp;
        </div>



        <div class="clearFix"></div>

        <div class="two  columns" id="margin1">
            <input type="submit" name="submit" id="submit" value="Export" class="btnclass" >
        </div>
        <div class="two  columns" id="margin1">

        </div>

        <div class="eight padd0 columns" id="margin1">
            &nbsp;
        </div>



        <div class="clearFix"></div>


        <span class="errorclass hidecontent" id="error"></span>



        </form>


    </div>


</div>

<!--Slider part ends here-->
<div class="clearFix"></div>

<!--footer start -->
<?php include('footer.php');?>
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui.js"></script>
<script>
    function checkout(val){
        $('#cal').val(val);
    }
    function changeemp(temp){
        if(temp==0){
            $('#clientshow').hide();
            $('#cal').val('all');
        }
        else{
            $('#cal').val(0);
            $('#clientshow').show();
        }

    }
    function validation(){
        $('#error').html("");
        $('#error').hide();
        var cal=$('#cal').val();
         if(cal=='0'){
             $('#error').html("Please select the Client");
             $('#error').show();
             document.getElementById("clientid").focus();
             return false;
         }
    }
</script>

<!--footer end -->

</body>

</html>