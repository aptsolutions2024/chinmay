<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

if(isset($_REQUEST['id'])&&$_REQUEST['id']!='') {
    $did = $_REQUEST['id'];
    $_SESSION['tempdid'] = $did;
}
else{
    $did = $_SESSION['tempdid'];
}

$comp_id=$_SESSION['comp_id'];

$result1=$payrollAdmin->displayOtherPayment($did);



?>
 
 <div class="boxborder">
        <form id="form">
        <div class="twelve" id="margin1">
            <div class="twelve padd0 columns successclass hidecontent" id="editsuccess">


            </div>

            <div class="clearFix"></div>
            <input type="hidden" name="did" id="did" value="<?php echo $_REQUEST['id'];?>">
            <div class="one padd0 columns">
            <span class="labelclass">Name :</span>
            </div>
            <div class="four padd0 columns">
                <input type="text" name="dname" id="editdname" placeholder="Other Payment Name" class="textclass" value="<?php echo $result1['op_name'];?>">
                <span class="errorclass hidecontent" id="dnerror"></span>
            </div>
            <div class="two padd0 columns">

            </div>
            <div class="one padd0 columns">

            </div>
            <div class="four padd0 columns">

            </div>
            <div class="clearFix"></div>



             <div class="one padd0 columns" id="margin1">
            </div>
            <div class="three padd0 columns" id="margin1">
                <input type="button" name="submit" id="submit" value="Update" class="btnclass" onclick="updateOtherPayment();">
            </div>
            <div class="eight padd0 columns" id="margin1">
                &nbsp;
            </div>
            <div class="clearFix"></div>
<br>
 <span class="successclass hidecontent" id="editsuccess"></span>
            </form>
        </div>
        