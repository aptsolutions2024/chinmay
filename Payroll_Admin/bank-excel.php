<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');
$comp_id=$_SESSION['comp_id'];

?>

  <link rel="stylesheet" href="../css/responsive.css">
  <link rel="stylesheet" href="../css/style.css">
<!-- Included CSS Files -->



<script>

    $('#cal').val($('#client').val());

 </script>





<!--<div class="twelve mobicenter innerbg">-->
<div class="twelve mobicenter">
    <div class="row">
        <div class="twelve"><h3>Bank Excel File</h3></div>
        <form id="form" action="/bank-excel-export" method="post">
            <input type="hidden" name="cal" id="cal" value="all">
        <div class="twelve" >             

       <!--div class="three padd0 columns" id="margin1">
			 No of Employees per page
            </div>
			<div class="four padd0 columns" id="margin1">
			 <input type="text" name="noofper" class="textclass">
            </div-->
            
           <div class="clearFix"></div>
           

             <div class="one padd0 columns" id="margin1">
			
            </div>
           <div class="three padd0 columns" id="margin1">
    <input type="submit" name="submit_format1" id="submit" value="Format 1" class="btnclass">
</div>
<div class="three padd0 columns" id="margin1">
    <input type="submit" name="submit_format2" id="submit1" value="Format 2" class="btnclass">
</div>

            <div class="eight padd0 columns" id="margin1">
                &nbsp;
            </div>
            <div class="clearFix"></div>

            </form>
            
        <br />
        <br />
        </div>





</div>

