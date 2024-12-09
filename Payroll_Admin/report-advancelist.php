<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

$comp_id=$_SESSION['comp_id'];
$resadv = $payrollAdmin->showAdvancetype($comp_id);

?>



  <!-- Included CSS Files -->
  <link rel="stylesheet" href="../css/responsive.css">
  <link rel="stylesheet" href="../css/style.css">



<!--<div class="twelve mobicenter innerbg">-->
<div class="twelve mobicenter">
    <div class="row">
        <div class="twelve"><h3>Advances List</h3></div>
        <div class="clearFix"></div>
        <form id="form" action="/r-report-advlist-page" method="post">
        <div class="twelve" id="margin1">
            <!--<div class="two padd0 columns">-->
            <!--    <span class="labelclass1">Client Group :</span>-->
            <!--</div>-->
            <!--<div class="two padd0 columns">-->
            <!--    <input type="radio" name="emp" value="Parent" onclick="changeemp(this.value);" checked>Yes-->
            <!--    <input type="radio" name="emp" value="Client" onclick="changeemp(this.value);" >No-->
            <!--</div>-->

          
			<div class="two columns">
                        <span class="labelclass">Advance Type :</span>
                    </div>
                    <div class="three  columns">
                        <select name="advtype" id="advtype" class="textclass">
                            <option value= '0'>--ALL---</option>
                            <?php foreach($resadv as $rowadv){?>
                                <option value="<?php echo $rowadv['mast_advance_type_id']; ?>"><?php echo $rowadv['advance_type_name']; ?></option>
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





