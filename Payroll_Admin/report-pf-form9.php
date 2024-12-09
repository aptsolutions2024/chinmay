<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

$comp_id=$_SESSION['comp_id'];

?>

<div class="twelve mobicenter">
    <div class="row">
        <div class="twelve"><h3>PF - Form9</h3></div>
        <div class="clearFix"></div>
        <form id="form" action="/r-report-pf-form9-page" method="post">
        <div class="twelve" id="margin1">
            
			
      		  <div class="three padd0 columns"> Starting PF No :	</div>
				<div class="two padd0 columns"><input type="text" name="start_pfno" id="start_pfno" class="textclass">
				 <span class="errorclass hidecontent" id="checkdateerror1"></span>
				</div>
				<div class="five padd0 columns"></div>
				 <div class="one  padd0 columns">  </div>
			  <div class="clearFix">&nbsp;</div>
			  <div class="three padd0 columns"> Ending PF No :	</div>
				<div class="two padd0 columns"><input type="text" name="end_pfno" id="end_pfno" class="textclass">
				 <span class="errorclass hidecontent" id="checknerror1"></span>
				</div>
				<div class="five padd0 columns"></div>
				 <div class="one  padd0 columns">  </div>
			  <div class="clearFix"></div>

           
            </div>

           
             <div class="one padd0 columns" id="margin1">
            </div>
            <div class="three padd0 columns" id="margin1">

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
<br/>
<!--Slider part ends here-->
<div class="clearFix"></div>