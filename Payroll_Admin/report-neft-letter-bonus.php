<?php
session_start();

if(isset($_SESSION['log_id'])&&$_SESSION['log_id']==''){
    header("location:../index.php");
}

$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

include_once('../paginate.php');
$comp_id=$_SESSION['comp_id'];

?>
<!DOCTYPE html>

<head>
  <meta charset="utf-8"/>
      <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width"/>
  <title>Salary | Summary</title>
  <!-- Included CSS Files -->
  <link rel="stylesheet" href="../css/responsive.css">
  <link rel="stylesheet" href="../css/style.css">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
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
	
</script>
</head>
 <body>

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
        <div class="twelve"><h3>Salary NEFT Letter</h3></div>
        <div class="clearFix"></div>
        <form id="form" action="/r-report-leave-neft-letter" method="post" >
        <div class="twelve" id="margin1">
            <div class="three padd0 columns">
                <span class="labelclass1">Parent :</span>
            </div>
            <div class="five padd10 columns">
				<input type="hidden" name="pay_type" value="B">

                <input type="radio" name="emp" value="Parent" onclick="changeemp(this.value);" >Yes
                <input type="radio" name="emp" value="Client" onclick="changeemp(this.value);" checked>No
            </div>
            <div class="two padd0 columns">
                <div  class="hidecontent">
                    <input type="text" name="name" id="name" onkeyup="serachemp(this.value);" autocomplete="off" placeholder="Enter the Employee Name" class="textclass" >
                    <div id="searching" style="z-index:10000;position: absolute;width: 100%;border: 1px solid rgba(151, 151, 151, 0.97);display: none;background-color: #FFFFFF;">

                    </div>
                    <input type="hidden" name="empid" id="empid" value="">
                </div>

            </div>
            <div class="four  padd0 columns">

            </div>
            <div class="clearFix"></div>


			
			
			
			
			 <div class="three padd0 columns"> Date :	</div>
				<div class="two padd0 columns"><input type="text" name="checkdate" id="checkdate" class="textclass">
				 <span class="errorclass hidecontent" id="checkdateerror1"></span>
				</div>
				<div class="five padd0 columns"></div>
				 <div class="one  padd0 columns">  </div>
				 
			  <div class="clearFix">&nbsp;</div>
			  </span>
			  <span id="checkno" >
			  <div class="three padd0 columns"> Cheque no :	</div>
				<div class="two padd0 columns"><input type="text" name="checkn" id="checkn" class="textclass" onkeyup="setcheckno(this.value)">
				 <span class="errorclass hidecontent" id="checknerror1"></span>
				</div>
				<div class="five padd0 columns"></div>
				 <div class="one  padd0 columns">  </div>
				 </span>
			  <div class="clearFix">&nbsp; </div>
			  <div class="three padd0 columns" ></div>
			 
				  <div class="clearFix">&nbsp; </div>
		
             	<div class="three padd0 columns">
                <span class="labelclass1">Sakal Consolidated :</span>
            </div>
        
                   <div class="four padd0 columns">
							

                <input type="radio" name="sakal_type" value="Yes"  >Yes
                <input type="radio" name="sakal_type" value="No" checked >No
            </div>
     	  <div class="clearFix">&nbsp; </div>
		
			
	   			
			

             <div class="one padd0 columns" id="margin1">
            </div>
            <div class="three padd0 columns" id="margin1">
<!--                <input type="button" name="submit" id="submit" value="Save" class="btnclass" onclick="reportpayslip();">-->
                <input type="submit" name="submit" id="submit" value="Print" class="btnclass">
            </div>
            <div class="eight padd0 columns" id="margin1">
                &nbsp;
            </div>
            <div class="clearFix"></div>

            </form>






        <div class="clearFix"></div>






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

</body>

</html>