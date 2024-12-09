<?php
$doc_path=$_SERVER["DOCUMENT_ROOT"];
include ($doc_path.'/include_payroll_admin.php');
// print_r($_SESSION);
$payrollAdmin = new payrollAdmin();

if($_SESSION['log_type']==2)
{
    
}else
{
    echo "<script>window.location.href='/payroll-logout';</script>";exit();
}


$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$result1=$payrollAdmin->showClient1($comp_id,$user_id);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width"/>
  <title>Salary | Edit All Employee</title>
  <link rel="stylesheet" href="../css/responsive.css">
  <link rel="stylesheet" href="../css/style.css">
  <script type="text/javascript" src="../js/jquery.min.js"></script>
  <script>
    function showTabdata(id) {
      $.post('/display-all-employee', {'id': id}, function(data) {
        $('#displaydata').html(data);
      });
    }

    function updateCurrentMonth() {
      var select = document.getElementById('clientid');
      var selectedOption = select.options[select.selectedIndex];
      var currentMonth = selectedOption.getAttribute('data-current-month');
      document.getElementById('current-month').textContent = currentMonth;
    }

    function saveCmonth(id) {
      $.post('/display-current-month', {'id': id}, function(data) {
        $('#displaydata').html(data);
      });
    }

    // Optionally, call updateCurrentMonth on page load if a default option is selected
    document.addEventListener('DOMContentLoaded', function() {
      updateCurrentMonth();
    });
  </script>
</head>
<body>

<?php include('header.php'); ?>
<div class="clearFix"></div>

<div class="twelve mobicenter innerbg">
  <div class="row">
    <div class="boxborder" id="margin1">
      <div class="two columns" id="margin1">
        <span class="labelclass">Client :</span>
      </div>
      <div class="four columns" id="margin1">
        <select id="clientid" name="clientid" class="textclass" onchange="showTabdata(this.value); updateCurrentMonth();">
          <option>--select--</option>
          <?php
          foreach($result1 as $row1) {
          ?>
          <option value="<?php echo $row1['mast_client_id']; ?>" data-current-month="<?php echo date('F Y', strtotime($row1['current_month'])); ?>">
            <?php echo $row1['client_name']; ?> - <?php echo date('F Y', strtotime($row1['current_month'])); ?>
          </option>
          <?php } ?>
        </select>
      </div>
      <div class="four columns" id="margin1">
        <h5 style="color:#7d1a15;">Month : <span id="current-month">--select--</span></h5>
      </div>
      <div class="clearFix"></div>
      <div id="displaydata"></div>
    </div>
  </div>
  <br/>
</div>

<div class="clearFix"></div>

<?php include('footer.php'); ?>
</body>
</html>
