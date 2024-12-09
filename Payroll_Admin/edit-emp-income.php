<?php

$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

if(isset($_REQUEST['id'])&&$_REQUEST['id']!='') {
    $id = $_REQUEST['id'];
    $_SESSION['tempcid'] = $id;
}
else{
    $id = $_SESSION['tempcid'];
}

$result1=$payrollAdmin->displayClient($id);
$comp_id=$_SESSION['comp_id'];
$resultIncome = $payrollAdmin->showIncomehead($comp_id);
$rowsincome=$payrollAdmin->showEployeeincomeall($id);
?>
<form id="form2">
    <div class="twelve padd0 columns successclass hidecontent" id="success21" style="margin-bottom:15px;">


    </div>

    <div class="clearFix"></div>

    <div id="insertIncome">

        <div class="two columns">
            <span class="labelclass">Income :</span>
        </div>
        <div class="four columns">
            <select id="incomeid1" name="incomeid1" class="textclass">
                <option value="0">--select-</option>
                <?php
                foreach($resultIncome as $rowin){
               
                    ?>

                    <option value="<?php echo $rowin['mast_income_heads_id'];?>"  <?php if($rowin['mast_income_heads_id']==$rowsincome['head_id']){ echo "selected" ;} ?> ><?php echo $rowin['income_heads_name'];?></option>
                <?php }

                ?>
            </select>
            <span class="errorclass hidecontent" id="incoerror1"></span>
        </div>

        <input type="hidden" name="emp_income_id1" id="emp_income_id1" value="<?php echo $rowsincome['emp_income_id']; ?>">
        <div class="two columns">
            <span class="labelclass">Calculation Type :</span>
        </div>
        <div class="four  columns">
		   <?php
                        $rescalin=$payrollAdmin->showCalType('caltype_income');
                        ?>
                        <select  name="caltype1" id="caltype1" class="textclass">
                            <option value="0">--select-</option>
                            <?php
                            foreach($rescalin as $rowcalin){
                            ?>
                                <option value="<?php echo $rowcalin['id']; ?>" <?php if($rowsincome['calc_type']== $rowcalin['id']){ echo "selected" ;} ?>><?php echo $rowcalin['name']; ?></option>

                            <?php } ?>

                        </select>
						
						
           
            <span class="errorclass hidecontent" id="calterror1"></span>
        </div>
        <div class="clearFix"></div>
        <div class="two columns">
            <span class="labelclass">STD Amount :</span>
        </div>
        <div class="four  columns">
            <input type="text" name="stdamt1" id="stdamt1" placeholder="STD Amount" class="textclass" value="<?php echo $rowsincome['std_amt']; ?>">
            <span class="errorclass hidecontent" id="stderror1"></span>
        </div>
        <div class="two columns">
            <span class="labelclass">Remark :</span>
        </div>
        <div class="four  columns">
            <input type="text" name="inremark1" id="inremark1" placeholder="Remark" class="textclass" value="<?php echo $rowsincome['remark']; ?>">
            <span class="errorclass hidecontent" id="inrerror1"></span>
        </div>
        <div class="clearFix"></div>




        <div class="ten padd0 columns">
            &nbsp;&nbsp;
        </div>
        <div class="two columns text-right">
            <input type="button" name="submit" id="submit2" value="Update" class="btnclass" onclick="updateIncome();">
        </div>

        <div class="clearFix"></div>

</form>