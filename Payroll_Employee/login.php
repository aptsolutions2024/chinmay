<?php 
session_start();

// Clear previous session data related to login, if any
unset($_SESSION['log_id'], $_SESSION['clientid'], $_SESSION['log_type'], $_SESSION['fname'], $_SESSION['comp_id'], $_SESSION['emp_login_id']);
unset($_SESSION['month']); // Clear specific fields that should not be set before login


include 'lib/class/error.php'; // Ensure this file exists and defines $errors
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width"/>
    <title>Salary | Home</title>
    <!-- Included CSS Files -->
    <link rel="stylesheet" href="Payroll/css/responsive.css">
    <link rel="stylesheet" href="Payroll/css/style.css">
    <style>
        html, body {
    height: 100%;
    margin: 0;
    background-color:#f6fde8;
    
}

#footer {
    position: relative;
    bottom: 0;
    width: 100%;
    background-color: #5f9ea0; /* Adjust the background color as needed */
}

.coptyright_bg {
    padding: 20px; /* Add padding to give space within the footer */
}

body {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

#footer {
    margin-top: auto;
}

    </style>
</head>
<body>

<!--Header starts here-->
<header class="twelve header_bg">
    <div class="row">
        <div class="twelve padd0 columns">
            <div class="eight padd0 columns text-left" id="container1">
                <br>
                <!-- Logo Section -->
                <h3 class="Color2"> Dev. By &nbsp;&nbsp; APT Solutions </h3>
                <br><br>
            </div>
            <div class="four columns text-right text-center" id="container3"></div>
        </div>
    </div>
</header>
<!--Header end here-->

<div class="clearFix"></div>

<!-- Main Content -->
<div align="center" style="background-color: #f6fde8;position: relative;height:539px;background-size: cover; background-position: 50% 50%;"></div>
<div class="clearFix"></div>

<!-- Footer start -->
<footer class="twelve coptyright_bg" id="footer">
    <div class="row">
        <div class="twelve columns">
            <div class="four columns text-left mobicenter" id="container1"></div>
            <div class="four columns text-center" id="container2">
                <div class="copyright">All rights reserved, Copyright © 2023 Salary Module</div>
            </div>
            <div class="four columns text-left footer-text mobicenter" id="container3"></div>
        </div>
    </div>
</footer>

<!-- JavaScript -->
<script src='Payroll/js/jquery.min.js'></script>
<script src='Payroll/js/script.js'></script>

<script>
    function displayLoginWindow(){
        document.getElementById('id01').style.display='block';
    }

    function validation() {
        var error = '';
        var usernamea = document.getElementById('ur').value;
        var password = document.getElementById('pwd').value;

        if(usernamea === "") {
            error = "Please Enter Username";
            $(".loginvalidation").text(error).show();
            return false;
        } else if(password === "") {
            error = "Please Enter Password";
            $(".loginvalidation").text(error).show();
            return false;
        }
        return true; // Validation passed
    }

    $(document).ready(function(){
        displayLoginWindow();
    });
</script>

<!-- Login Modal -->
<div id="id01" class="modal" style="display:none; margin-top:50px">
    <form class="modal-content animate" action="/emp-login-process" onsubmit="return validation();" method="post">
        <h1 style="margin-left: 30px;">Employee Login</h1>
        <div style="margin-left: 30px;">
            <div style='background:darkcyan; -ms-transform: rotate(270deg); -webkit-transform: rotate(270deg); transform: rotate(270deg); border-radius: 0 0 10px 10px; position: fixed; margin-left:-111px; width: 202px; margin-top: 83px;'>
                <div style="padding: 5px 15px; font-size: 22px; color: #fff;">LOGIN</div>
            </div>
            <div class="container">
                <div style="color: red; margin-bottom: 10px;"><?=$errors[$_SESSION['error_code']] ?? '';?><?php unset($_SESSION['error_code']);?></div>
                <label><b>Username</b></label>
                <input type="text" placeholder="Enter Username" name="username" id="ur" class="textclass">
                <label><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="password" id="pwd" class="textclass">
            </div>
            <div class="container" style="background-color:#f1f1f1">
                <button class="cancelbtn" type="submit">Login</button>
                <!--<a href="/create-payroll-employee"><button class="cancelbtn" type="button">Register</button></a>-->
                <a href="/emp-view-change-password"><button class="cancelbtn" type="button">Change Password</button></a>
                <span id="errormsg" class="errorclass hidecontent loginvalidation"></span>
            </div>
        </div>
    </form>
</div>
</body>
</html>
