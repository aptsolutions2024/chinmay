<?php
session_start();

$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

$comp_id = $_SESSION['comp_id'];
$user_id = $_SESSION['log_id'];
$result1 = $payrollAdmin->showClient1($comp_id, $user_id);
$result = $payrollAdmin->displayClientGroup();

$client = $_POST['client'] ?? null;
$date = $_POST['date'] ?? null;
$yes_no = $_POST['yes_no'] ?? null;
$clientGroup = $_POST['clientGroup'] ?? null;
$id = isset($_POST['id']) ? $_POST['id'] : null;
// print_r($_POST);
if ($id !== null) {
    // echo "11111";
    $result11 = $payrollAdmin->showsalmonth1($id);

    if (empty($result11)) {
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
</head>
<body>
    
        <form id="form">
            <!-- Client Dropdown -->
            <div class="row">
                <div class="two columns">
                    <span class="labelclass1">Client:</span>
                </div>
                <div class="three columns">
                    <select class="textclass" disabled  name="editclient" id="editclient" onchange="updateCurrentMonth(); $('#linkshow').hide(); resetClientGroup();" style="width: 100%;">
    <option value="">--Select--</option>
    <?php foreach($result1 as $row1) { ?>
        <option value="<?php echo $row1['mast_client_id']; ?>" data-current-month="<?php echo date('F Y', strtotime($row1['current_month'])); ?>"
            <?php echo ($row1['mast_client_id'] == $result11['client_id']) ? 'selected' : ''; ?>>
            <?php echo $row1['client_name']; ?> - <?php echo date('F Y', strtotime($row1['current_month'])); ?>
        </option>
    <?php } ?>
</select>


                    <span class="errorclass hidecontent" id="nerror" style="display: block; margin-top: 5px;"></span>
                </div>
            </div>
            
            <!-- Client Group Dropdown -->
            <div class="row">
                <div class="two columns">
                    <span class="labelclass1">Client Group:</span>
                </div>
                <div class="three columns">
                    <select class="textclass" disabled  name="editclientGroup" id="editclientGroup" onchange="$('#linkshow').hide(); resetClient()">
                          <option value="">--Select--</option>
                        <?php foreach($result as $row2) { ?>
                            <option value="<?php echo $row2['id']; ?>"
                                <?php echo ($row2['id'] == $result11['group_id']) ? 'selected' : ''; ?>>
                                <?php echo $row2['group_name']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            
            <!-- Date Input -->
            <div class="row" style="margin-top: 10px;">
                <div class="two columns">
                    <span class="labelclass1">Date:</span>
                </div>
                <div class="three columns">
                    <input type="month"disabled  name="editdate" class="textclass" value="<?php echo date('Y-m', strtotime($result11['sal_month'])); ?>" required>
                </div>
            </div>
            
            <!-- Yes/No Radio Buttons -->
            <div class="row" style="margin-top: 10px;">
                <div class="two columns">
                    <span class="labelclass1">Yes or No:</span>
                </div>
                <div class="four columns" style="display: flex; gap: 10px;">
                    <label>
                        <input type="radio" name="edityes_no" value="Yes" <?php echo ($result11['flag'] == 'Y') ? 'checked' : ''; ?>> Yes
                    </label>
                    <label>
                        <input type="radio" name="edityes_no" value="No" <?php echo ($result11['flag'] == 'N') ? 'checked' : ''; ?>> No
                    </label>
                </div>
            </div>
            
            <!-- Submit Button -->
            <div class="row" style="margin-top: 20px;">
                <div class="six columns">
                   <input type="button" name="submit" id="submit" value="Update" class="btnclass" onclick="update(<?= $id; ?>);">
   </div>
            </div>
        </form>
    <script>
          function resetClient(){
          $('#editclient').val('');
      }
      function resetClientGroup(){
          $('#editclientGroup').val('');
      }
    </script>
</body>
</html>
