<?php
session_start();

if(isset($_SESSION['log_id'])&&$_SESSION['log_id']==''){
    header("location:../index.php");
}

include("../lib/class/admin.php");
$adminObj=new admin();
include_once('../paginate.php');

$doc_path = $_SERVER["DOCUMENT_ROOT"];

$user_id=$_SESSION['log_id'];
$comp_id='1';
$result11=$adminObj->showClient1($comp_id,$user_id);
?>
<!DOCTYPE html>
<head>
  <meta charset="utf-8"/>
  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width"/>
  <title>Salary | Employee</title>

<script>
    function validation() {
        var errormsg ='';
        var file=$("#file").val();
       if(file ==""){
            $("#file").focus();
	   error ="Please Select the file";
	   $("#file").val('');
	   $("#file").addClass('bordererror');
	   $("#file").attr("placeholder", error);
            return false;
        }
    }
    function updateCurrentMonth() {
      var select = document.getElementById('clientid');
      var selectedOption = select.options[select.selectedIndex];
      var currentMonth = selectedOption.getAttribute('data-current-month');
      document.getElementById('current-month').textContent = currentMonth;
    }
    </script>
    <link rel="stylesheet" href="../Payroll/css/responsive.css">
    <link rel="stylesheet" href="../Payroll/css/style.css">
</head>

 <body>

<!--Header starts here-->
<?php include('header.php');?>
<!--Header end here-->
<div class="clearFix"></div>
<!--Menu starts here-->

<?php include('menu.php');?>

<!--Menu ends here-->
<div class="clearFix"></div>
<!--Slider part starts here-->
<div class="twelve mobicenter innerbg">
    <div class="row">
        <div class="twelve padd0" id="margin1"> <h3>Employee Salary Import </h3></div>
        <div class="clearFix"></div>
         <div class="boxborder" style="min-height: 100px;">
        
       
        <form name="frm" action="./import_salary_imc_process.php" method="post"  enctype="multipart/form-data" onsubmit="return validation();">
        <div class="twelve" >
              <div class="one padd0 columns" >
                <span class="labelclass">Client :</span>
            </div>
            <div class="four  columns">
                <select id="clientid" name="clientid" class="textclass" onchange="updateCurrentMonth();">
                    <option value="0">--select--</option>
                    <?php
                    foreach($result11 as $row1)
                    {
                        ?>

                       <option value="<?php echo $row1['mast_client_id']; ?>" data-current-month="<?php echo date('F Y', strtotime($row1['current_month'])); ?>">
            <?php echo $row1['client_name']; ?> - <?php echo date('F Y', strtotime($row1['current_month'])); ?>
          </option>
          <?php }

                    ?>
                </select>
                <span style="color:#7d1a15;"> Month : <span id="current-month">--select--</span></span>

            </div>
            <div class="two  columns" align="center">
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
        </form>
        <div class="clearFix"></div>
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