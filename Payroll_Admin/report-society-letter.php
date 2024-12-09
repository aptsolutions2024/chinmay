 <?php
 session_start();
 error_reporting(E_ALL);
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');
$comp_id=$_SESSION['comp_id'];
$resbnk=$payrollAdmin->showBank($comp_id);

?>




<!--<div class="twelve mobicenter innerbg">-->
<div class="twelve mobicenter">
    <div class="row">
        <div class="twelve"><h3>Society /Bank Letter</h3></div>
        <div class="clearFix"></div>
        <form id="form" action="/r-report-society-letter" method="post">
        <div class="twelve" id="margin1">
            <!--<div class="one padd0 columns">
                <span class="labelclass1">Parent :</span>
            </div>
            <div class="two padd0 columns">
                <input type="radio" name="emp" value="Parent" onclick="changeemp(this.value);" checked>Yes
                <input type="radio" name="emp" value="Client" onclick="changeemp(this.value);" >No
            </div>

          -->
			<div class="two columns">
                        <span class="labelclass">Bank /Society :</span>
                    </div>
                    <div class="three  columns">
                        <select name="bankid" id="bankid" class="textclass">
                            <option value= '0'>--ALL---</option>
                            <?php foreach($resbnk as $rowadv) {?>
                                <option value="<?php echo $rowadv['mast_bank_id']; ?>"><?php echo $rowadv['bank_name'].' '.$rowadv['branch']; ?></option>
                            <?php } ?>
                        </select>
                    </div>



<!--            <div class="five padd0 columns">
  </div> -->

            <div class="four padd0 columns">


            </div>
            <div class="clearFix"></div>




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





