<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');
$result11=$payrollAdmin->showClientNoGroup($comp_id,$user_id);
?>
    <div class="two padd0 columns" >
        <span class="labelclass">Client :</span>
    </div>
    <div class="four columns">
        <select id="client" name="client" class="textclass" onchange="updateCurrentMonthClient();">
          <option value="0">--select--</option>
          <?php foreach($result11 as $row1) { ?>
              <option value="<?php echo $row1['mast_client_id']; ?>" data-current-month="<?php echo date('F Y', strtotime($row1['current_month'])); ?>" data-datewise-details="<?=$row1['daywise_details'];?>">
                  <?php echo $row1['client_name']; ?> - <?php echo date('F Y', strtotime($row1['current_month'])); ?>
              </option>
          <?php } ?>
        </select>
   </div>
  <div class="three columns">
               <span style="color:#7d1a15; margin-left: 10px; text-align:center;">Month: <span id="current-month-client"> </span></span>
  </div>