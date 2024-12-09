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
  <title>Salary | UAN Mismatch</title>
  <link rel="stylesheet" href="../css/responsive.css">
  <link rel="stylesheet" href="../css/style.css">
  <script type="text/javascript" src="../js/jquery.min.js"></script>
  <script>
    function showUanData(id) {
      $.post('/display-uan-data', {'id': id}, function(data) {
        $('#displaydata').html(data);
      });
    }

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
        <select id="clientid" name="clientid" class="textclass" onchange="showUanData(this.value);">
          <option>--select--</option>
          <?php
          foreach($result1 as $row1) {
          ?>
          <option value="<?php echo $row1['mast_client_id']; ?>" ><?php echo $row1['client_name']; ?> - <?php echo date('F Y', strtotime($row1['current_month'])); ?></option>
          <?php } ?>
        </select>
      </div>
      <div class="four columns" id="margin1">
        <input type="file" id="file" name="file" class="textclass">
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
