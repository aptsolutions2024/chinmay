<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

$comp_id=$_SESSION['comp_id'];

$client=$_SESSION['clientid'];

?>

<div class="twelve mobicenter">
    <div class="row">
        <div class="twelve"><h3>Code Wise Summary</h3></div>
        <div class="clearFix"></div>
        <form id="form" action="/r-report-pf-code-summary?client=<?php echo $client ?>" method="post">
        <div class="twelve" id="margin1">
            <div style="display:none">
            <div class="two padd0 columns">
                <span class="labelclass1">Client Group :</span>
            </div>
            <div class="two padd0 columns">
                <input type="radio" name="emp" value="Parent" onclick="changeemp(this.value);" checked>Yes
                <input type="radio" name="emp" value="Client" onclick="changeemp(this.value);" >No
            </div>
            </div>
			<br>
      		
				<div class="five padd0 columns"></div>
				 <div class="one  padd0 columns">  </div>
			  <div class="clearFix">&nbsp;</div>
			 
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