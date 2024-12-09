<?php
session_start();

if(isset($_SESSION['log_id'])&&$_SESSION['log_id']==''){
    header("location:../index.php");
}

$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
?>
<!DOCTYPE html>
<head>
  <meta charset="utf-8"/>
  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width"/>
  <title>Salary | Monthly Closing</title>
  <!-- Included CSS Files -->
  <link rel="stylesheet" href="../css/responsive.css">

  <link rel="stylesheet" href="../css/style.css">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
  <script>
     function processDBackup(){
         $('#loaderDiv').show();
           $('#processDBackup').prop('disabled', true);
           $.post('/db-backup',{
              'action':'download'
            },function(data){
           
              if(data){
                $("#display").html(data);
                $('#loaderDiv').hide();
              }
                 $('#processDBackup').prop('disabled', false);
          });
      }

  </script>

 <body>

<!--Header starts here-->
<?php include('header.php');?>
<!--Header end here-->
<div class="clearFix"></div>
<!--Menu starts here-->


<!--Menu ends here-->
<div class="clearFix"></div>
<!--Slider part starts here-->


            
            
<div class="twelve mobicenter innerbg">
    <div class="row" >
       
            
       <div id="monthlyClosing">
        <div class="twelve padd0" id="margin1"> <h3>Database Backup</h3></div>
        
        <div class="clearFix"></div>
        <div class="twelve padd0" id="margin1">
            <div class="boxborder" id="">
                
            <div class="one padd0 columns"  id="margin1">    </div>
            <div class="four padd0 columns" id="margin1">    </div>
	    	<div class="four padd0 columns" id="margin1">
                <button class="submitbtn" onclick="processDBackup()" id="processDBackup">
                    Create Backup
                </button>
                <div  id="loaderDiv" style="display:none;">
        		    <div style="height: 200px;width:400px;margin: 0 auto;"> <img src="../Payroll/images/loading.gif" /></div>
        		  </div>
            </div>
            
		   <div class="two  padd0 columns" id="margin1" align="center">
            </div>
            <div class="five  padd0 columns" id="margin1" align="center">

            </div>
            <div class="clearFix"></div>
            <div class="twelve" id="display" align="center">
            </div>

      </div>
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