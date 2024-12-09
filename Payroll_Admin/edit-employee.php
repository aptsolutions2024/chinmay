<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

if($_SESSION['log_type']==2)
{
    
}else
{
    echo "<script>window.location.href='/payroll-logout';</script>";exit();
}

?>
<!DOCTYPE html>

<head>

  <meta charset="utf-8"/>



  <!-- Set the viewport width to device width for mobile -->

  <meta name="viewport" content="width=device-width"/>

  <title>Salary | Edit Employee</title>

  <!-- Included CSS Files -->

  <link rel="stylesheet" href="Payroll/css/responsive.css">

  <link rel="stylesheet" href="Payroll/css/style.css">
  <script type="text/javascript" src="Payroll/js/jquery.min.js"></script>

</head>
 <body>

<!--Header starts here-->
<?php include('header.php');?>
<!--Header end here-->
<div class="clearFix"></div>
<!--Menu starts here-->



<!--Menu ends here-->
<div class="clearFix"></div>
<!--Slider part starts here-->

<div class="twelve mobicenter innerbg" >
    <div class="row">
        <br>
        <h4>Edit Employee</h4>
<div class="boxborder" id="margin1">
        <div class="two columns"  id="margin1">
            <span class="labelclass">Employee :</span>
        </div>
        <div class="six columns" id="margin1">
            <input type="text" onkeyup="serachemp(this.value);" class="textclass" placeholder="Full Name" id="name" autocomplete="off" autofill="off">
            <div id="searching" style="z-index:10000;position: absolute;width: 97%;border: 1px solid rgba(151, 151, 151, 0.97);display: none;background-color: #FFFFFF;">



        </div>
        </div>

        <div class="four  columns"  id="margin1">
         <a href="/edit-employee"><input type="button" name="Clear" id="Clear" value="Clear" class="btnclass"></a>
            <input type="hidden" name="empid" id="empid" value="">
           </div>
        
      
        <div class="clearFix"></div>

<div id="displaydata">
  </div>
</div>


    </div>
	</div>
<br/>

</div>
<div class="clearFix"></div>

<!--Slider part ends here-->

<!--footer start -->
<?php include('footer.php');?>

<script>
  function showTabdata(id,name){
      $("#tab1").css("display", "block");
  //alert(name);
       $.get('/display-employee', {
           'id': id
       }, function (data) {
           $('#searching').hide();
           $('#name').val(name);
           $('#displaydata').show();
           $('#displaydata').html(data);
           $('#empid').val(id);
           
       });

    }
 
function openTab(evt, tabName) {

    // Declare all variables
    var i, tabcontent, tablinks;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
}



    function serachemp(val){
        $.get('/display-employee-edit', {
            'name': val
        }, function (data) {
            $('#searching').html(data);
            $('#searching').show();
        });
    }
    
    
  </script>
<!--footer end -->

</body>

</html>