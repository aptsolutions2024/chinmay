<?php 
session_start();
$doc_path=$_SERVER["DOCUMENT_ROOT"];
include $doc_path.'/lib/class/error.php';
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
.password-strength-status{
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

<script>
function validation()
{
    	$("#userDiv").html('');
       /*
        var empemail=$("#empemail").val();
        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        $("#empemail").removeClass('bordererror');
        if (empemail == "") {
            error = "Please enter emailid.";
            $("#empemail").focus();
            $("#empemail").addClass('bordererror');
            $("#empemail").attr("placeholder",error);
            return false;
        }else if (!filter.test(empemail) && empemail != "") {
            $("#empemail").val('');
            error = "Username as a your email.  example@gmail.com";
            $("#empemail").focus();
            $("#empemail").addClass('bordererror');
            $("#empemail").attr("placeholder",error);
            return false;
        }*/
        var passcode=$("#passcode").val();
        var mobile_no=$("#mobile_no").val();
        $("#passcode").removeClass('bordererror');
        $("#mobile_no").removeClass('bordererror');
        
        if (passcode == "") {
            error = "Please enter employee passcode";
            $("#passcode").focus();
            $("#passcode").addClass('bordererror');
            $("#passcode").attr("placeholder",error);
            return false;
        }else if (mobile_no == "") {
            error = "Please Enter Mobile no.";
            $("#mobile_no").focus();
            $("#mobile_no").addClass('bordererror');
            $("#mobile_no").attr("placeholder",error);
            return false;
        }
		else if (mobile_no.length != 10) {
            error = "Invalid number must be ten digits";
            // $("#mobile_no").val('');
            $("#mobile_no").focus();
            $("#mobile_no").addClass('bordererror');
            $("#mobile_no").attr("placeholder",error);
            return false;
        }else{
            //alert("IN else....");
            $.post('/create-employee-process',{
            'passcode': passcode,           
            'mobile_no': mobile_no           
            }, function(data){
                //alert(data);
    		//console.log(data);
    		$("#userDiv").html(data);
            });
            
        }
        
}
function checkPasswordStrength() {
	var number = /([0-9])/;
	var alphabets = /([a-zA-Z])/;
	var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
	var password = $('#upass').val().trim();
	if (password.length < 6) {
		$('#password-strength-status').removeClass();
		$('#password-strength-status').addClass('weak-password');
		$('#password-strength-status').html("Weak (should be atleast 6 characters.)");
		return false;
	} else {
		if (password.match(number) && password.match(alphabets) && password.match(special_characters)) {
			$('#password-strength-status').removeClass();
			$('#password-strength-status').addClass('strong-password');
			$('#password-strength-status').html("Strong");
		}
		else {
			$('#password-strength-status').removeClass();
			$('#password-strength-status').addClass('medium-password');
			$('#password-strength-status').html("Medium (should include alphabets, numbers and special characters.)");
		}
	}
	
}
function updatePasswwordofEmp(){
      var passcode=$("#passcode").val();
       var mobile_no=$("#mobile_no").val();
    //   var username=$("#uname").val();
       var password=$("#upass").val();
       var emp_id=$("#emp_id").val();
        $("#passcode").removeClass('bordererror');
        $("#mobile_no").removeClass('bordererror');
        // $("#uname").removeClass('bordererror');
        $("#upass").removeClass('bordererror');
        
        if (passcode == "") {
            error = "Please enter employee passcode";
            $("#passcode").focus();
            $("#passcode").addClass('bordererror');
            $("#passcode").attr("placeholder",error);
            return false;
        }else if (mobile_no == "") {
            error = "Please Enter Mobile no.";
            $("#mobile_no").focus();
            $("#mobile_no").addClass('bordererror');
            $("#mobile_no").attr("placeholder",error);
            return false;
        }
		else if (mobile_no.length != 10) {
            error = "Invalid number must be ten digits";
            //$("#mobile_no").val('');
            $("#mobile_no").focus();
            $("#mobile_no").addClass('bordererror');
            $("#mobile_no").attr("placeholder",error);
            return false;
        }else if (password == "") {
            error = "Please enter the password";
            $("#upass").focus();
            $("#upass").addClass('bordererror');
            $("#upass").attr("placeholder",error);
            return false;
        }else if (password.length < 6) {
    		$('#password-strength-status').removeClass();
    		$('#password-strength-status').addClass('weak-password');
    		$('#password-strength-status').html("Weak (should be atleast 6 characters.)");
    		return false;
	   }else {
          $.post('/employee-password-update',{     
            'password': password, 
            'emp_id':emp_id,
            }, function(data){
    		//console.log(data);
    		$("#userDiv").html(data);
            });
        } 
}

function createAccountofEmp(){
    
       var passcode=$("#passcode").val();
       var mobile_no=$("#mobile_no").val();
       var username=$("#uname").val();
       var password=$("#upass").val();
       var emp_id=$("#emp_id").val();
        $("#passcode").removeClass('bordererror');
        $("#mobile_no").removeClass('bordererror');
        $("#uname").removeClass('bordererror');
        $("#upass").removeClass('bordererror');
        
        if (passcode == "") {
            error = "Please enter employee passcode";
            $("#passcode").focus();
            $("#passcode").addClass('bordererror');
            $("#passcode").attr("placeholder",error);
            return false;
        }else if (mobile_no == "") {
            error = "Please Enter Mobile no.";
            $("#mobile_no").focus();
            $("#mobile_no").addClass('bordererror');
            $("#mobile_no").attr("placeholder",error);
            return false;
        }
		else if (mobile_no.length != 10) {
            error = "Invalid number must be ten digits";
            //$("#mobile_no").val('');
            $("#mobile_no").focus();
            $("#mobile_no").addClass('bordererror');
            $("#mobile_no").attr("placeholder",error);
            return false;
        }
	     else if (username == "") {
            error = "Invalid username.";
            $("#uname").focus();
            $("#uname").addClass('bordererror');
            $("#uname").attr("placeholder",error);
            return false;
        }else if (password == "") {
            error = "Please enter the password";
            $("#upass").focus();
            $("#upass").addClass('bordererror');
            $("#upass").attr("placeholder",error);
            return false;
        }else if (password.length < 6) {
    		$('#password-strength-status').removeClass();
    		$('#password-strength-status').addClass('weak-password');
    		$('#password-strength-status').html("Weak (should be atleast 6 characters.)");
    		return false;
	   }else {
          $.post('/create-new-employee-login',{
            'username': username,           
            'password': password, 
            'emp_id':emp_id,
            }, function(data){
                //alert(data);
    		//console.log(data);
    		$("#userDiv").html(data);
            });
        } 
}
function checkusername(){
         var username=$("#uname").val();
        $("#uname").removeClass('bordererror');
        $.get('/check-employee-username',{
            'username': username,           
        }, function(data){
           // alert(data);
			if(data.trim(data)=="Username already exist."){
    			$("#userDiv").val(data);
    			error = "Username already exists.";
    			$("#uname").val('');
    			$("#uname").addClass('bordererror');
    			$("#uname").attr("placeholder", error);
                  return false;
            }else{
               return true;
            }
        });

    }

</script>
<div class="twelve mobicenter innerbg">
    <div class="row">
        <div class="twelve padd0" id="margin1" style="text-align:center;"> <h3>Create Employee</h3>
        
        </div>
        <div class="clearFix"></div>
        <div class="twelve padd0" id="margin1">
           
            	<form action="#" method="post" name="fee" enctype="multipart/form-data">
                      <input type="hidden" name="hdnerr" id="hdnerr" value="">
			          <div class="three respopadd0 columns paddl0" id="margin1"></div>
                      <div class="six respopadd0 columns paddl0 paddr0" style="border: 1px solid #7596bf;">
				            <div class="fscol">Set / Create Password</div>
							<br>

                    <div class="twelve midbodyadm columns  margb10" >
                            <div class="four columns paddl0 labaltext padd0">
                                Employee Mobile No. :
                            </div>
                            <div class="eight respopadd0 columns padd0">
                              <input type="text" name="mobile_no" id="mobile_no" placeholder="Employee Mobile No." class="textclass" oninput="return validation();" maxlength="20">
                            </div> 
                        </div>
                        <div class="clearFix"></div>
       	                <div class="twelve midbodyadm columns  margb10" >
                            <div class="four columns paddl0 labaltext padd0">
                                Employee Passcode :
                            </div>
                            <div class="eight respopadd0 columns padd0">
                              <input type="text" name="passcode" id="passcode" placeholder="Employee Passcode" class="textclass" onfocusout="return validation();" maxlength="20">
                            </div> 
                        </div> 
                        <div class="clearFix"></div>
                      
                        <div id="userDiv"></div>
							<div class="twelve midbodyadm columns margb10">
                        </div>
                    </div>
                    
                    </form>
</div>
                     	<div class="twelve midbodyadm columns margb10 "  style="text-align:center;">
                             
    							    <!--<input type="button" class="submitbtn" value="Submit" >-->
    							    <a href="http://hrnews.co.in/payroll"><input type="button" class="submitbtn" value="Back"></a>
                                
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


