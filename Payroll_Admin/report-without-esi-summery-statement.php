<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

$comp_id=$_SESSION['comp_id'];
$mon =$_REQUEST['mon'];
$frdt =$_REQUEST['frdt'];
// $tdt =$_REQUEST['todt'];
?>


<div class="twelve mobicenter">
    <div class="row">
        <div class="twelve"><h3>Without ESI Employee</h3></div>
        <div class="clearFix"></div>
        <form id="form" action="/r-report-without-esi-summery-statement-page" method="post">
        <div class="twelve" >
		<input type="hidden" value="<?php echo $mon;?>" name="mon">
		<input type="hidden" value="<?php echo $frdt;?>" name="frdt">
		<input type="hidden" value="<?php echo $tdt;?>" name="todt">
           
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