<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

if($_SESSION['log_type']==2)
{
    
}else
{
    echo "<script>window.location.href='/payroll-logout';</script>";exit();
}
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$result1 = $payrollAdmin->showClient1($comp_id,$user_id);
?>
<!DOCTYPE html>
<head>
  <meta charset="utf-8"/>
  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width"/>
  <title>Salary | Transactions </title>
  <!-- Included CSS Files -->
 
    <link rel="stylesheet" href="Payroll/css/responsive.css">
<script type="text/javascript" src="Payroll/js/jquery.min.js"></script>
<script type="text/javascript" src="Payroll/css/style.css"></script>

    <script>
     function updateCurrentMonth() {
    var select = document.getElementById('client'); // Change 'clientid' to 'client'
    var selectedOption = select.options[select.selectedIndex];
    var currentMonth = selectedOption.getAttribute('data-current-month');
    var datewisedetails=selectedOption.getAttribute('data-datewise-details'); 
    if(datewisedetails=='Y'){
         $("#hidedatewisedetails").hide();
         $("#datewisedetailsmsg").html("Day Details Can Be Imported Only Through Menu->Datewise Details");
    }else if(datewisedetails=='N'){
         $("#hidedatewisedetails").show();
         $("#datewisedetailsmsg").html("");
        
       //  alert("Datewise details not available for this client");
    }
    document.getElementById('current-month').textContent = currentMonth || '--select--'; // Fallback to '--select--' if no month is found
}
        function clientno(val){
            var clientid= document.getElementById('client').value;
            if (clientid=="")
            {
                alert ("Please Select Client.");

            }
            else {
                $.post('/sessionclientno', {
                    'clientid': clientid
                }, function (data) {

                  //  alert(data);

                });
            }
        }

       function validation() {
            var errormsg ='';
            var file = document.getElementById('file').value;
            var file=$("#file").val();
	       $("#file").removeClass('bordererror');
            if(file ==""){
               $("#file").focus();
        	   error ="Please Select the file";
        	   $("#file").val('');
        	   $("#file").addClass('bordererror');
        	   $("#file").attr("placeholder", error);
        	   return false;
            }
        }
		function emptranexport(){
			var clientid= document.getElementById('client').value;
			if (clientid=="")
				{
				    alert ("Please Select Client.");
					return;
				}
				$.post('/export-emp-transactions',{
                    'clientid':clientid
                },function(data){
                    alert(data);
                    $("#a").html(data);
                });
		}
		
		
		function trandaysexport(){
			var clientid= document.getElementById('client').value;
			if (clientid==""){   
				alert ("Please Select Client.");
				return;
			}
		}
    </script>
    <style>
     #hidedatewisedetails{
      display:none;
  }
   #datewisedetailsmsg{
        color: red;
        margin: 4% 17%;
        font-size: 28px;
      }
    </style>
</head>
<body>

<!--Header starts here-->
<?php include('header.php');?>
<!--Header end here-->
<div class="clearFix"></div>
<!--Slider part starts here-->

<div class="twelve mobicenter innerbg">
    <div class="row">
        <div class="twelve padd0" id="margin1"> <h3>Days Details Export And Import</h3></div>
        <div class="clearFix"></div>
        <br/>
        <div class="boxborder">
        <form name="frm" action="/import-transactions-process" method="post"  enctype="multipart/form-data" onsubmit="return validation();">
        <div class="twelve " >
            <div class="one padd0 columns"  >
                <span class="labelclass">Client :</span>
            </div>
            <div class="four padd0 columns"  >
                <select class="textclass" name="client" id="client" onchange="clientno(this.value); updateCurrentMonth();">
                    <option value=''>--Select--</option>
                    <?php foreach($result1 as $row1){?>
                        <option value="<?php echo $row1['mast_client_id']; ?>" data-current-month="<?php echo date('F Y', strtotime($row1['current_month'])); ?>" data-datewise-details="<?=$row1['daywise_details'];?>">
            <?php echo $row1['client_name']; ?> - <?php echo date('F Y', strtotime($row1['current_month'])); ?>
          </option>
                        
                         <?php } ?>
                </select>
                
             
            </div>
            <span style="color:#7d1a15; margin-left: 10px;">
        Month: <span id="current-month">--select--</span>
    </span>
</div>
 <div class="twelve padd0" id="datewisedetailsmsg"></div>
<span id="hidedatewisedetails">
 <div class="twelve columns" >
            <div class="seven padd0 columns">
                <!--                <a class="switch" href="../transactions.csv" download>Transactions Export to Blank CSV File </a><br/>-->
                <!--<a class="switch" href="export-emp-transactions.php">Export Data / Blank Excel Format for importing days details </a>-->
                <a class="switch"  href="/export-emp-transactions">1. Generate Blank file from Employee Master </a>
				
            </div>
            <div class="five columns">
<div id='a'></div>

            </div>

        </div>
       
	<!-- Commented by Shraddha on 07-10-2024 -->		
<!--<div class="twelve columns" >
            <div class="seven padd0 columns">
               
                <a class="switch" href="/export-trandays-transactions">2. Export Entered Days details from Transaction File. </a>
				
            </div>
            <div class="five columns">
<div id='a'></div>

            </div>

        </div>-->
 

<div  class = "twelve columns">
		    <div class="two padd0 columns"  >
             2. Import from CSV File :
            </div>
            <div class="three padd0 columns">
                <input type="file" name="file" id="file" class="textclass">
                <br/>
                <span class="errorclass hidecontent" id="errormsg"></span>
            </div>
        </div>
            <div class="clearFix"></div>
            <div class="twelve " id="margin1">


                <input type="submit" name="submit" id="submit" value="Import" class="btnclass" >

            </div>
            </span>
            <div class="clearFix"></div>

        </form>
        </div>
        <div class="clearFix"></div>

        <br/>
 
   <div class="clearFix"></div>
</div>


</div>

<!--Slider part ends here-->
<div class="clearFix"></div>

<!--footer start -->
<?php include('footer.php');?>


<!--footer end -->

</body>

</html>