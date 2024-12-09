<?php
session_start();

$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

$comp_id = $_SESSION['comp_id'];
$user_id = $_SESSION['log_id'];

// Define $id here. For example, if you're getting $id from a query parameter:
$id = isset($_POST['id']) ? $_POST['id'] : null;
if ($id !== null) {
    // Fetch the data
    $result1 = $payrollAdmin->showGroupClient1($id);

    // Check if any results were returned
    if (empty($result1)) {
        echo "No results found.";
        exit;
    }
} else {
    echo "ID is not set.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Client Group</title>
    <!-- Include any required CSS/JS here -->
</head>
<body>
    <div class="boxborder">
        <form id="form">
            <div class="twelve" id="margin1">
                <div class="clearFix"></div>
                <div class="two padd0 columns">
                    <span class="labelclass">Name :</span>
                </div>
                <div class="four padd0 columns">
                    <input type="hidden" id="editid" name="editid" value="<?php echo htmlspecialchars($result1['id']); ?>">
                    <input type="text" name="editgroup_name" id="editgroup_name" placeholder="Group Name" class="textclass" value="<?php echo htmlspecialchars($result1['group_name']); ?>">
                    <span class="errorclass hidecontent" id="cnerror"></span>
                </div>
                <div class="clearFix"></div>
                <div class="two columns" id="margin1">
                    <span class="labelclass">ESI CODE :</span>
                </div>
                <div class="four padd0 columns" id="margin1">
                    <input type="text" name="editesicode" id="editesicode" placeholder="ESI Code" class="textclass" value="<?php echo htmlspecialchars($result1['esicode']); ?>">
                    <span class="errorclass hidecontent" id="esierror"></span>
                </div>
                <div class="clearFix"></div>
                <div class="two padd0 columns" id="margin1">
                    <span class="labelclass">PF CODE :</span>
                </div>
                <div class="four padd0 columns" id="margin1">
                    <input type="text" name="editpfcode" id="editpfcode" placeholder="PF Code" class="textclass" value="<?php echo htmlspecialchars($result1['pfcode']); ?>">
                    <span class="errorclass hidecontent" id="pferror"></span>
                </div>
                
                 <div class="clearFix"></div>
                  <!-- Added by saksi on 28-10-24 -->
                <div class="two padd0 columns" id="margin1">
                    <span class="labelclass">LWF number :</span>
                </div>
                <div class="four padd0 columns" id="margin1">
                    <input type="text" name="editlwf_no" id="editlwf_no" placeholder="LWF number" class="textclass" value="<?php echo htmlspecialchars($result1['lwf_no']); ?>">
                    <span class="errorclass hidecontent" id="pferror"></span>
                </div>
                
                
                <div class="two columns"></div>
                <br/>
                <br/>
                <div class="four padd0 columns" id="margin1">
                    <input type="button" name="submit" id="submit" value="update" class="btnclass" onclick="update();">
                </div>
                <div class="seven padd0 columns" id="margin1">&nbsp;</div>
                <div class="twelve padd0 columns successclass hidecontent" id="success"></div>
                
                <div class="clearFix"></div>
            </form>
        </div>
        
    </body>
</html>
