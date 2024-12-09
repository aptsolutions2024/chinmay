<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

if(isset($_REQUEST['bid'])&&$_REQUEST['bid']!='') {
    $bid = $_REQUEST['bid'];
    $_SESSION['tempdid'] = $bid;
}
else{
    $bid = $_SESSION['tempdid'];
}

$result1=$payrollAdmin->displayBank($bid);
$comp_id=$_SESSION['comp_id'];



?>
<div class="boxborder">
        <form id="form">
        <div class="twelve" id="margin1">
            
            <div class="clearFix"></div>
            <input type="hidden" name="bid" id="bid" value="<?php echo $_REQUEST['bid'];?>">
            <div class="one padd0 columns">
            <span class="labelclass">Name :</span>
            </div>
            <div class="four padd0 columns">
                <input type="text" name="bname" id="editbname" placeholder="Bank Name" class="textclass" value="<?php  echo $result1['bank_name']; ?>" >
                <span class="errorclass hidecontent" id="berror"></span>
            </div>
            <div class="two padd0 columns">

            </div>
            <div class="one padd0 columns">
                <span class="labelclass">Address :</span>
            </div>
            <div class="four padd0 columns">
                <textarea class="textclass" id="editadd" name="add"  placeholder="Address 1"><?php  echo $result1['add1']; ?></textarea>
                <span class="errorclass hidecontent" id="aderror"></span>
            </div>
            <div class="clearFix"></div>

            <div class="one padd0 columns" id="margin1">
                <span class="labelclass">Branch :</span>
            </div>
            <div class="four padd0 columns" id="margin1">
                <textarea class="textclass"  id="editbranch" name="branch" placeholder="Address 2"><?php  echo $result1['branch']; ?></textarea>
                <span class="errorclass hidecontent" id="brerror"></span>
            </div>
            <div class="two padd0 columns">

            </div>
            <div class="one padd0 columns" id="margin1">
                <span class="labelclass"> IFSC CODE :</span>
            </div>
            <div class="four padd0 columns" id="margin1">
                <input type="text" name="ifsccode" id="editifsccode" placeholder="IFSC Code" class="textclass"  value="<?php  echo $result1['ifsc_code']; ?>" >
                <span class="errorclass hidecontent" id="ifscerror"></span>
            </div>
            <div class="clearFix"></div>

            <div class="one padd0 columns" id="margin1">
                <span class="labelclass"> City :</span>
            </div>
            <div class="four padd0 columns" id="margin1">
                <input type="text" name="city" id="editcity" placeholder="City" class="textclass"  value="<?php  echo $result1['city']; ?>" >
                <span class="errorclass hidecontent" id="cterror"></span>
            </div>
            <div class="two padd0 columns">

            </div>
            <div class="one padd0 columns" id="margin1">
                <span class="labelclass">PIN Code :</span>
            </div>
            <div class="four padd0 columns" id="margin1">
                <input type="text" name="pincode" id="editpincode" placeholder="PIN Code" class="textclass"  value="<?php  echo $result1['pin_code']; ?>" >
                <span class="errorclass hidecontent" id="pnerror"></span>
            </div>
            <div class="clearFix"></div>


             <div class="one padd0 columns" id="margin1">
            </div>
            <div class="three padd0 columns" id="margin1">
                <input type="button" name="submit" id="submit" value="Update" class="btnclass" onclick="updateBank();">
            </div>
            <div class="eight padd0 columns" id="margin1">
                &nbsp;
            </div>
            <div class="twelve padd0 columns successclass hidecontent" id="editsuccess">


            </div>

            <div class="clearFix"></div>
<br>
<span class="successclass hidecontent" id="editsuccess"></span>
            </form>
        </div>
        