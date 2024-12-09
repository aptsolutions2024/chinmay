<?php 
session_start();
include 'lib/class/error.php';
?>
<!DOCTYPE html>
<head>

  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width"/>

  <title>Salary | Home</title>

  <!-- Included CSS Files -->

  <link rel="stylesheet" href="Payroll/css/responsive.css">

  <link rel="stylesheet" href="Payroll/css/style.css">
</head>
 <body>

<!--Header starts here-->

<header class="twelve header_bg">

    <div class="row">

        <div class="twelve padd0 columns" >

            <div class="eight padd0 columns text-left " id="container1">
<br>
<!--                <a href="index.php"><div class="logo" ><img src="../images/logo.png"></div></a>-->
 <h3 class="Color2"> Dev. By &nbsp &nbsp APT Solutions </h3> <br>
                <br>
                <!-- Modify top header1 ends here -->

            </div>


            <div class="four columns text-right text-center" id="container3">

            </div>




   </div>

</header>

<!--Header end here-->
<div class="clearFix"></div>

<div align="center" style="background-color: #f6fde8;position: relative;height:539px;background-size: cover;
    background-position: 50% 50%;">

 </div>

<div class="clearFix"></div>


<!--footer start -->

<footer class="twelve coptyright_bg"  id="footer">

        <div class="row">

            <div class="twelve columns">

            <div class="four columns text-left   mobicenter" id="container1">


            </div>

            <div class="four columns text-center" id="container2">

                <div class="copyright" >All right reserved, Copyright © 2023 Salary Module</div>

            </div>

            <div class="four columns text-left  footer-text mobicenter" id="container3">

            </div>

                </div>

        </div>



 </footer>

    <script src='Payroll/js/jquery.min.js'></script>

<script src='Payroll/js/script.js'></script>
<script type="text/javascript" src="Payroll/js/jquery.min.js"></script>
<script>
   function displayLoginWindow(){
            document.getElementById('id01').style.display='block';
        } 
    function validation() {
        
        
        
        var errormsg ='';

        var usernamea = document.getElementById('ur').value;


        var password = document.getElementById('pwd').value;

        if(usernamea ==""){

            error ="Please Enter Username";
            $(".loginvalidation").text(error);
            $(".loginvalidation").show();
            return false;
        }else if(password ==""){
            error ="Please Enter Password";
            $(".loginvalidation").text(error);
            $(".loginvalidation").show();
            return false;
        }
    }

</script>

<!-- The Modal -->
<div id="id01" class="modal">
  <!--<span onclick="document.getElementById('id01').style.display='none'"  class="close" title="Close Modal">&times;</span>-->

    <!-- Modal Content -->
    <form class="modal-content animate" action="/payroll-login-process" onsubmit="return validation();" method="post">
     <!--   <div class="imgcontainer">
            <img src="img_avatar2.png" alt="Avatar" class="avatar">
        </div>-->
<div style="margin-left: 30px;">
    <div style='background:darkcyan;-ms-transform: rotate(270deg);-webkit-transform: rotate(270deg);
    transform: rotate(270deg);border-radius: 0 0 10px 10px;position: fixed;margin-left:-111px;width: 202px;margin-top: 83px;'>
        <div style="padding: 5px 15px;font-size: 22px;color: #fff;">
            LOGIN
        </div>
    </div>
    <div class="container">
        <div style="color: red;margin-bottom: 10px;"><?=$errors[$_SESSION['error_code']];?>
        <?php unset($_SESSION['error_code']);?>
        </div>
            <label><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="username" id="ur" class="textclass">

            <label><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="password" id="pwd" class="textclass">

          <!--            <input type="checkbox" checked="checked"> Remember me-->
        </div>

        <div class="container" style="background-color:#f1f1f1">

            <button class="cancelbtn" type="submit">Login</button>
               <a href="/create-payroll-employee"><button class="cancelbtn" type="button">Register</button></a>
                 <a href="/view-change-password"><button class="cancelbtn" type="button">Change Password</button></a>
            <span id="errormsg" class="errorclass hidecontent loginvalidation"></span>
<!--            <button class="cancelbtn" onclick="login();">Login</button>-->
        </div>
		</div>
    </form>
</div>


<script>
    $(document).ready(function(){
    // Get the modal
    var modal = document.getElementById('id01');

    // When the user clicks anywhere outside of the modal, close it
  /*  window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }*/
    displayLoginWindow();
    });
 
</script>



<!--footer end -->

</body>

</html>