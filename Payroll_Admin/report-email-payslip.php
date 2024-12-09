<?php
session_start();

if(isset($_SESSION['log_id'])&&$_SESSION['log_id']==''){
    echo "<script>window.location.href='/home';</script>";exit();
}

include("../lib/connection/db-config.php");

$comp_id=$_SESSION['comp_id'];

?>
<!DOCTYPE html>

<head>
  <meta charset="utf-8"/>
      <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width"/>
  <title>Salary | Payslip</title>
  <!-- Included CSS Files -->
 
   <link rel="stylesheet" href="Payroll/css/jquery-ui.css">
<script type="text/javascript" src="Payroll/js/jquery.min.js"></script>
    <script type="text/javascript" src="Payroll/js/jquery-ui.js"></script>
</head>
 <body>
<div id="overlay"></div>
<!--Header starts here-->
<?php //include('header.php');?>
<!--Header end here-->
<div class="clearFix"></div>
<!--Menu starts here-->

<?php //include('menu.php');?>

<!--Menu ends here-->
<div class="clearFix"></div>
<!--Slider part starts here-->

<!--<div class="twelve mobicenter innerbg">-->
<div class="twelve mobicenter">
    <div class="row">
        <div class="twelve"><h3>Send Email Payslip</h3></div>
        <div class="clearFix"></div>
        <form id="form" action="/r-report-payslip-send-email" method="post">
        <div class="twelve" id="margin1">
            <div class="one padd0 columns">
                <span class="labelclass1">Employee :</span>
            </div>
            <div class="two padd0 columns">
                <input type="radio" id="empall" name="emp" value="all" onclick="changeemp(this.value);" checked>All
                <input type="radio" id="empone" name="emp" value="random" onclick="changeemp(this.value);" >Random
            </div>
            <div class="six padd0 columns">
                <div id="showemp" class="hidecontent">
                    <input type="text" name="name" id="name" onkeyup="serachemp(this.value);" autocomplete="off" placeholder="Enter the Employee Name" class="textclass" >
                    <div id="searching" style="z-index:10000;position: absolute;width: 100%;border: 1px solid rgba(151, 151, 151, 0.97);display: none;background-color: #FFFFFF;">

                    </div>
                    <input type="hidden" name="empid" id="empid" value="">
                </div>

            </div>
            <div class="three padd0 columns">

            </div>
            <div class="clearFix"></div>



             <div class="one padd0 columns" id="margin1">
            </div>
            <div class="three padd0 columns" id="margin1">

                <input type="button" name="submit" id="submit" value="Send Mail" class="btnclass" onclick="Sendmail();">
            </div>
            <div class="eight padd0 columns" id="margin1">
                &nbsp;
            </div>
            <div class="clearFix"></div>

            <div id="showout"></div>

            </form>
        </div>





</div>

</div>
</div>
<br/>
<!--Slider part ends here-->
<div class="clearFix"></div>

<!--footer start -->
<?php //include('footer.php');?>


<!--footer end -->
<script>
    function changeemp(val){

        if(val!='all'){
            $('#showemp').show();
        }
        else
        {
            $('#showemp').hide();
        }
    }
    function showTabdata(id,name){

        $.post('/display-employee', {
            'id': id
        }, function (data) {
            $('#searching').hide();
            $('#displaydata').html(data);
            $('#name').val(name);
            $('#displaydata').show();
            document.getElementById('empid').value=id;

        });

    }
    function serachemp(val){
        $.post('/display-employee1', {
            'name': val
        }, function (data) {
            $('#searching').html(data);
            $('#searching').show();
        });
    }

    function Sendmail() {
        $('#showout').html('<div style="height:70px;width:70px;padding-left:30px;padding-top:20px;" align="center"> <img src="../Payroll/images/loading.gif" /></div>');
        var emp='';
        var empid='0';
       if(document.getElementById('empall').checked) {
            emp=document.getElementById('empall').value;
        }
        else if(document.getElementById('empone').checked) {
            emp=document.getElementById('empone').value;
            empid=document.getElementById('empid').value;
        }
        $.get('/r-report-payslip-send-email', {
            'emp': emp,
            'empid':empid
        },function(data) {

            $('#showout').html(data);
            $('#showout').show();
        });
    }

    function full_loading(id){
        if(id){
            $('#showout').css('background', 'url("../images/loading.gif") no-repeat center ');
        }


    }
</script>
</body>

</html>