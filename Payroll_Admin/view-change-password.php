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
     

</script>

<!-- The Modal -->
<div id="id01" class="modal">
  <!--<span onclick="document.getElementById('id01').style.display='none'"  class="close" title="Close Modal">&times;</span>-->

    <!-- Modal Content -->
    <form class="modal-content animate" action="/change-password-process" onsubmit="return" method="post">
     <!--   <div class="imgcontainer">
            <img src="img_avatar2.png" alt="Avatar" class="avatar">
        </div>-->
<div style="margin-left: 30px;">
    <div style='background:darkcyan;-ms-transform: rotate(270deg);-webkit-transform: rotate(270deg);
    transform: rotate(270deg);border-radius: 0 0 10px 10px;position: fixed;margin-left:-111px;width: 202px;margin-top: 83px;'>
        <div style="padding: 5px 15px;font-size: 22px;color: #fff;">
            Change Password
        </div>
    </div>
    <div class="container">
        <div style="color: red;margin-bottom: 10px;"><?=$errors[$_SESSION['error_code']];?>
         <?php if (isset($_SESSION['message'])): ?>
                <div style="color: green; margin-bottom: 10px;">
                    <?= $_SESSION['message']; ?>
                </div>
                <?php unset($_SESSION['message']); ?>
            <?php elseif (isset($_SESSION['error'])): ?>
                <div style="color: red; margin-bottom: 10px;">
                    <?= $_SESSION['error']; ?>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

        </div>
            <label><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="username" id="ur" class="textclass">

            <label><b>Old Password</b></label>
            <input type="password" placeholder="Enter Old Password" name="old_password" id="old_pass" class="textclass">
  
   <label><b>New Password</b></label>
            <input type="password" placeholder="Enter New Password" name="new_password" id="new_pass" class="textclass">

          <!--            <input type="checkbox" checked="checked"> Remember me-->
        </div>

        <div class="container" style="background-color:#f1f1f1">

            <button class="cancelbtn" type="submit">Change Password</button>
                 <span id="errormsg" class="errorclass hidecontent loginvalidation"></span>
                 <a href="/payroll"><button class="cancelbtn" type="button">Login</button></a>
               
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