<?php 
session_start();
include 'lib/class/error.php';
?>
<!DOCTYPE html>
<head>
  <meta charset="utf-8"/>

  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width"/>

  <title>Payroll</title>

  <!-- Included CSS Files -->
  
    <link rel="stylesheet" href="/Payroll/css/responsive.css">
    <link rel="stylesheet" href="Payroll/css/style.css">
	<link rel="stylesheet" href="/Payroll/css/main.css">
    <link rel="stylesheet" href="/Payroll/css/jquery-ui.css">
	
	<script src="/Payroll/js/modernizr.foundation.js"></script>
    <script src="/Payroll/js/jquery-1.11.2.min.js"></script>
    <script src="/Payroll/js/jquery-ui.js"></script>
    <script src="/Payroll/js/script.js"></script>
	<script src="/Payroll/js/gen_validatorv4.js" type="text/javascript"></script>
	<style>
	    .fscol{
            font-size: 30px;
            color: #ffffff;
            background: darkcyan;
            text-align: center;
            padding:10px;
	    }
	    .error_class{
	        padding: 8px;
            background-color: #fccac1;
            border: 1px dotted #eb5439;
            color: #000;
                text-align: center;
	    }
	    .success_class{
	     padding: 10px;
         color: blueviolet;
             text-align: center;
	    }
	    .weak-password {
    background-color: #FBE1E1;
}
.medium-password {
    background-color: #fd0;
}
.strong-password {
    background-color: #D5F9D5;
}
#password-strength-status{
        text-align: center;
    padding: 6px 0px;
}
	</style>
</head>
<body>
<header class="twelve header_bg">
    <div class="row">

        <div class="twelve padd0 columns" >

            <div class="eight padd0 columns text-left " id="container1"><br>

                     <h3 class="Color2"> Dev. By &nbsp &nbsp APT Solutions </h3> <br>  <br>

            </div>

            <div class="four columns text-right text-center" id="container3">

            </div>
   </div>
</header>

<!--Header end here-->
<div class="clearFix"></div>
<div class="twelve mobicenter innerbg">
    <div class="row">
        <div class="twelve padd0" id="margin1" style="text-align:center;"> <h3>Change Password</h3>
        
        </div>
        <div class="clearFix"></div>
        <div class="twelve padd0" id="margin1">
           
            	<form action="/changepassword" method="post" name="fee" enctype="multipart/form-data">
    <input type="hidden" name="hdnerr" id="hdnerr" value="">
    <div class="three respopadd0 columns paddl0" id="margin1"></div>
    <div class="six respopadd0 columns paddl0 paddr0" style="border: 1px solid #7596bf;">
        <div class="fscol">Change Password</div>
        <br>
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
        <div class="twelve midbodyadm columns margb10">
            <div class="four columns paddl0 labaltext padd0">Username :</div>
            <div class="eight respopadd0 columns padd0">
                <input type="text" name="uname" id="uname" placeholder="Enter Username" class="textclass" onfocusout="checkUnamepass();" maxlength="20">
            </div>
        </div>
        <div class="clearFix"></div>

        <div class="twelve midbodyadm columns margb10">
            <div class="four columns paddl0 labaltext padd0">Enter Old Password :</div>
            <div class="eight respopadd0 columns padd0">
                <input type="password" name="oldpass" id="oldpass" placeholder="Enter Old Password" class="textclass" maxlength="20">
            </div>
            <div class="clearFix"></div>
            
        </div>

        <div class="twelve midbodyadm columns margb10">
            <div class="four columns paddl0 labaltext padd0">Enter New Password :</div>
            <div class="eight respopadd0 columns padd0">
                <input type="password" name="newpass" id="newpass" placeholder="Enter New Password" class="textclass" maxlength="20">
            </div>
            <div class="clearFix"></div>
        </div>
        <div class="clearFix"></div>

        <div class="twelve midbodyadm columns margb10" style="text-align:center;">
            <input type="submit" class="submitbtn" value="Submit">
        </div>
    </div>
</form>

</div>
                     	<div class="twelve midbodyadm columns margb10 "  style="text-align:center;">
                             
    							    <!--<input type="button" class="submitbtn" value="Submit" >-->
    							    <a href="/employee"><input type="button" class="submitbtn" value="Back"></a>
                                
                            </div>
</div>

</div>

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
</body>
</html>

