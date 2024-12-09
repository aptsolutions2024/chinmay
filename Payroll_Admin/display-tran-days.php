<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

if($_SESSION['log_type']==2 || $_SESSION['log_type']==3 )
{
    
}else
{
    echo "<script>window.location.href='/payroll-logout';</script>";exit();
}

  $id = $_REQUEST['id'];
  $lmt = $_REQUEST['lmt'];
 // $lmt = 100;



  $result = $payrollAdmin->displayemployeeClientlmt($id,$lmt);
  $resultee =$result;

  $result2 = $payrollAdmin->displayClient($id);
  $datewisedetailsInput="";
  $datewisedetailsInputClass="";
  if($result2['daywise_details']=='Y'){
      $datewisedetailsInput="readonly";
       $datewisedetailsInputClass="daysdetailsAvailable";
  }
 // echo "***********".$datewisedetailsInput;
  //print_r($result2);
  $count = sizeof($result);

    $headrow= $payrollAdmin->displayCompany($_SESSION['comp_id']);
    $head = $headrow['td_string'];
    //echo $head;
    echo $count.'$$$';
 	 ?>

<style>
.ht40{height:40px; border:1px solid #ccc; border-top:0; text-align:left; padding-left:5px}
#trandtl td{height:39px;}


td, .ht40 {
	height:40px !important;
    line-height: 28px !important;
    background: #fff !important;
    padding: 0px 10px !important;
    border: 1px solid #f3f3f3 !important;
    font-size: 14px !important;
}
.daysdetailsAvailable{
        background-color: blanchedalmond;
}
</style>
<div style="height: 20px;width: 100%">&nbsp;</div>

<div>
    <div style="min-height:30%; padding-bottom: 20px; overflow-y: scroll;">
	<div style="display:inline-block; width:300px; vertical-align: top;">
	<div style="padding: 5px!important;
    border: 1px solid #c4c4c4!important; background: #eee; height:50px">
	    
	<b>Employee Name</b>
	</div>
	<?php 
	if ($lmt=="0, 30"){$i=1;}
	if ($lmt=="30, 30"){$i=31;}
	if ($lmt=="60, 30"){$i=61;}
	if ($lmt=="90, 30"){$i=91;}
	if ($lmt=="120, 30"){$i=121;}
	if ($lmt=="150, 30"){$i=151;}
	$i=1;
	foreach($resultee as $row1) {
        $result1 = $payrollAdmin->showEployeedetails($row1['emp_id']);
		
		echo "<div class='ht40'>".$i." - ".$result1['first_name'].' '. $result1['middle_name'].' '.$result1['last_name'].'-'. $row1['emp_id']."</div>";$i++;
	}
		?>
	</div>
	<div style="display:inline-block; width:75%; overflow:auto" id="trandtl">
    <table width="1600px">
        <tr >
           
              <?php 
              //present,weeklyoff,  absent, pl,cl,sl , paidholiday,additional, othours, nightshifts,incometax,canteen,extra_inc1, extra_inc2,leave_encash,extra_ded1,extra_ded2, wagediff,Allow_arrears, Ot_arrears,invalid
					$pos = strpos($head, "fullpay");
					if ($pos === false) {
						echo "<th style='display:none;height:50px'>Full Pay</th>";
					} else {
						echo "<th>Full Pay</th>";
					}   
           
					$pos = strpos($head, "halfpay");
					if ($pos === false) {
						echo "<th style='display:none'>Half Pay</th>";
					} else {
						echo "<th>Half Pay</th>";
					}   


					$pos = strpos($head, "leavewop");
					if ($pos === false) {
						echo "<th style='display:none'>Leave WOP</th>";
					} else {
						echo "<th>Leave WOP</th>";
					}  
					
					$pos = strpos($head, "present");
				
					if ($pos === false) {
						echo "<th style='display:none'>Present Days</th>";
					} else {
						echo "<th>Present Days</th>";
					}   
					
//present,weeklyoff, absent, pl,cl,sl , paidholiday,additional, othours, nightshifts,incometax,canteen,extra_inc1, extra_inc2,leave_encash,extra_ded1,extra_ded2, wagediff,Allow_arrears, Ot_arrears,invalid				
					$pos = strpos($head, "weeklyoff");
					if ($pos === false) {
						echo "<th style='display:none'>WeeklyOff</th>";
					} else {
						echo "<th>Weekly Off</th>";
					}   
           
					$pos = strpos($head, "absent");
					if ($pos === false) {
						echo "<th style='display:none'>Abs. Days</th>";
					} else {
						echo "<th>Abs. Days</th>";
					}   


					$pos = strpos($head, "pl");
					if ($pos === false) {
						echo "<th style='display:none'>Earn Leave</th>";
					} else {
						echo "<th>Earn Leave</th>";
					}   


					$pos = strpos($head, "sl");
					if ($pos === false) {
						echo "<th style='display:none'>Sick Leave</th>";
					} else {
						echo "<th>Sick Leave</th>";
					}   
										
					$pos = strpos($head, "cl");
					if ($pos === false) {
						echo "<th style='display:none'>Casual Leave</th>";
					} else {
						echo "<th>Casual Leave</th>";
					}   
           
					$pos = strpos($head, "otherleave");
					if ($pos === false) {
						echo "<th style='display:none'>Oth. Leave</th>";
					} else {
						echo "<th>Oth. Leave</th>";
					}   


					$pos = strpos($head, "paidholiday");
					if ($pos === false) {
						echo "<th style='display:none'>Paid Holi.</th>";
					} else {
						echo "<th>Paid Holi.</th>";
					}   


					$pos = strpos($head, "additional");
					if ($pos === false) {
						echo "<th style='display:none'>Addl. Days</th>";
					} else {
						echo "<th>Addl. Days</th>";
					}   
 					
					$pos = strpos($head, "othours");
					if ($pos === false) {
						echo "<th style='display:none'>OT Hours</th>";
					} else {
						echo "<th>OT Hours</th>";
					}   
           
					$pos = strpos($head, "nightshifts");
					if ($pos === false) {
						echo "<th style='display:none'>Night Shift</th>";
					} else {
						echo "<th>Night Shift</th>";
					}   


					$pos = strpos($head, "extra_inc1");
					if ($pos === false) {
						echo "<th style='display:none'>Extra Inc1</th>";
					} else {
						echo "<th>Extra Inc1</th>";
					}   


					$pos = strpos($head, "extra_inc2");
					if ($pos === false) {
						echo "<th style='display:none'>Reimb.</th>";
					} else {
						echo "<th>Reimb.</th>";
					}   
					
				$pos = strpos($head, "leave_encash");
					if ($pos === false) {
						echo "<th style='display:none'>L-Encash</th>";
					} else {
						echo "<th>L-Encash</th>";
					}   
					
					$pos = strpos($head, "reward");
					if ($pos === false) {
						echo "<th style='display:none'>Reward</th>";
					} else {
						echo "<th>Reward</th>";
					}   

					$pos = strpos($head, "extra_ded1");
					if ($pos === false) {
						echo "<th style='display:none'>Extra Ded1</th>";
					} else {
						echo "<th>Extra Ded1</th>";
					}   


					$pos = strpos($head, "extra_ded2");
					if ($pos === false) {
						echo "<th style='display:none'>Extra Ded2</th>";
					} else {
						echo "<th>Extra Ded2</th>";
					}   
										
					$pos = strpos($head, "leftdate");
					if ($pos === false) {
						echo "<th style='display:none'>LeavingDate</th>";
					} else {
						echo "<th>LeavingDate</th>";
					}   
           
					$pos = strpos($head, "wagediff");
					if ($pos === false) {
						echo "<th style='display:none'>Wage Diff</th>";
					} else {
						echo "<th>Wage DIff</th>";
					}   


					$pos = strpos($head, "Allow_arrears");
					if ($pos === false) {
						echo "<th style='display:none'>Allow. Arr.</th>";
					} else {
						echo "<th>Allow. Arr.</th>";
					}   


					$pos = strpos($head, "Ot_arrears");
					if ($pos === false) {
						echo "<th style='display:none'>OT. Arr.</th>";
					} else {
						echo "<th>OT. Arr.</th>";
					} 
					
					$pos = strpos($head, "incometax");
					if ($pos === false) {
						echo "<th style='display:none'>Inc. Tax</th>";
					} else {
						echo "<th>Inc. Tax</th>";
					}
					$pos = strpos($head, "society");
					if ($pos === false) {
						echo "<th style='display:none'>Society</th>";
					} else {
						echo "<th>Society</th>";
					}
					$pos = strpos($head, "canteen");
					if ($pos === false) {
						echo "<th style='display:none'>Canteen</th>";
					} else {
						echo "<th>Canteen</th>";
					}	
					$pos = strpos($head, "remarks");
					if ($pos === false) {
						echo "<th style='display:none'>Remarks</th>";
					} else {
						echo "<th>Remarks</th>";
					}					
                    
					echo "<th> Invalid </th>";
					?>
					


 </tr>
    <?php
if($count>0) {
    $i=1;

    foreach($result as $row) {
        $result1 = $payrollAdmin->showEployeedetails($row['emp_id']);
        $result2 = $payrollAdmin->displayTranday($row['emp_id']);

        ?>
        <input type="hidden" id="emp_id<?php echo $i;?>" name="emp_id[]" value="<?php echo $row['emp_id']; ?>">

        <input type="hidden" id="tr_id<?php echo $i;?>" name="tr_id[]" value="<?php echo $result2['trd_id']; ?>">
        <tr>
            <!--<td width="10%"><?php

                //echo $i." - ".$result1['first_name'].' 00000000000000000'. $result1['middle_name'].' '.$result1['last_name'].'-'. $row['emp_id'];

            ?></td>-->
			
			
			<?php
					$pos = strpos($head, "fullpay");
					if ($pos === false) {
						echo "    <td style= 'display:none' >
								<input type='text' name='fp[]' id='fp".$i."'  class='textclass' value='". $result2['fullpay']."' title='Please enter the Full Pay'>
								</td>";
					} else {
						$tt = $result2['fullpay'];
						if($result2['fullpay'] =="0.00"){$tt = "";}
						echo "    <td class='ht40'>
								<input type='text' name='fp[]' id='fp".$i."'  class='textclass' value='". $tt."' title='Please enter the Full Pay'>
								</td>";
					}   

					$pos = strpos($head, "halfpay");
					if ($pos === false) {
						echo "    <td style= 'display:none'>
								<input type='text' name='hp[]' id='hp".$i."'  class='textclass' value='". $result2['halfpay']."' title='Please enter the Half Pay'>
								</td>";
					} else {
						$tt = $result2['halfpay'];
						if($result2['halfpay'] =="0.00"){$tt = "";}
						echo "    <td >
								<input type='text' name='hp[]' id='hp".$i."'  class='textclass' value='". $tt."' title='Please enter the Half Pay'>
								</td>";
					}   
			

					$pos = strpos($head, "leavewop");
					if ($pos === false) {
						echo "    <td style= 'display:none'>
								<input type='text' name='lw[]' id='lw".$i."'  class='textclass' value='". $result2['leavewop']."' title='Please enter the  Leave WOP'>
								</td>";
					} else {
						$tt = $result2['leavewop'];
						if($result2['leavewop'] =="0.00"){$tt = "";}
						echo "    <td >
								<input type='text' name='lw[]' id='lw".$i."'  class='textclass' value='". $tt."' title='Please enter the Leave WOP'>
								</td>";
					}   
					
					$pos = strpos($head, "present");
					if ($pos === false) {
						echo "    <td style= 'display:none'>
								<input type='text' name='pr[]' id='pr".$i."'  class='textclass $datewisedetailsInputClass' value='". $result2['present']."' title='Please enter the  Present Days'  $datewisedetailsInput  >
								</td>";
					} else {
						$tt = $result2['present'];
						if($result2['present'] =="0.00"){$tt = "";}
						echo "    <td class='ht40' >
								<input type='text' name='pr[]' id='pr".$i."'  class='textclass $datewisedetailsInputClass' value='". $tt."' title='Please enter the Present Days'  $datewisedetailsInput  >
								</td>";
					}   
					
					$pos = strpos($head, "weeklyoff");
					if ($pos === false) {
						echo "    <td style= 'display:none'>
								<input type='text' name='wo[]' id='wo".$i."'  class='textclass $datewisedetailsInputClass' value='". $result2['weeklyoff']."' title='Please enter the WeeklyOff'  $datewisedetailsInput  >
								</td>";
					} else {
						$tt = $result2['weeklyoff'];
						if($result2['weeklyoff'] =="0.00"){$tt = "";}
						echo "    <td >
								<input type='text' name='wo[]' id='wo".$i."'  class='textclass $datewisedetailsInputClass' value='". $tt."' title='Please enter the WeeklyOff'  $datewisedetailsInput  >
								</td>";
					}   
					
					$pos = strpos($head, "absent"); 
					if ($pos === false) { 
						echo "    <td style= 'display:none'>
								<input type='text' name='ab[]' id='ab".$i."'  class='textclass $datewisedetailsInputClass' value='".$result2['absent']."' title='Please enter the  Absent Days'  $datewisedetailsInput  >
								</td>";
					} else {
						
						$tt = $result2['absent'];
						if($result2['absent'] =="0.00"){$tt = "";}
						echo "    <td >
								<input type='text' name='ab[]' id='ab".$i."'  class='textclass $datewisedetailsInputClass' value='". $tt."' title='Please enter the Absent Days'  $datewisedetailsInput  >
								</td>";
					}   


					$pos = strpos($head, "pl");
					if ($pos === false) {
						echo "    <td style= 'display:none'>
								<input type='text' name='pl[]' id='pl".$i."'  class='textclass $datewisedetailsInputClass' value='". $result2['pl']."' title='Please enter the  Paid Leave'  $datewisedetailsInput  >
								</td>";
					} else {
						$tt = $result2['pl'];
						if($result2['pl'] =="0.00"){$tt = "";}
						echo "    <td >
								<input type='text' name='pl[]' id='pl".$i."'  class='textclass $datewisedetailsInputClass' value='". $tt."' title='Please enter the  Paid Leave'  $datewisedetailsInput  >
								</td>";
					}   
					
					
					$pos = strpos($head, "sl");
					if ($pos === false) {
						echo "    <td style= 'display:none'>
								<input type='text' name='sl[]' id='sl".$i."'  class='textclass $datewisedetailsInputClass' value='". $result2['sl']."' title='Please enter the  Sick Leave'  $datewisedetailsInput  >
								</td>";
					} else {
						$tt = $result2['sl'];
						if($result2['sl'] =="0.00"){$tt = "";}
						echo "    <td >
								<input type='text' name='sl[]' id='sl".$i."'  class='textclass $datewisedetailsInputClass' value='". $tt."' title='Please enter the  Sick Leave'  $datewisedetailsInput  >
								</td>";
					}   

					$pos = strpos($head, "cl");
					if ($pos === false) {
						echo "    <td style= 'display:none'>
								<input type='text' name='cl[]' id='cl".$i."'  class='textclass $datewisedetailsInputClass' value='". $result2['cl']."' title='Please enter the  Casual Leave'  $datewisedetailsInput  >
								</td>";
					} else {
						$tt = $result2['cl'];
						if($result2['cl'] =="0.00"){$tt = "";}
						echo "    <td >
								<input type='text' name='cl[]' id='cl".$i."'  class='textclass $datewisedetailsInputClass' value='". $tt."' title='Please enter the  Casual Leave'  $datewisedetailsInput  >
								</td>";
					}   

					$pos = strpos($head, "otherleave");
					if ($pos === false) {
						echo "    <td style= 'display:none'>
								<input type='text' name='ol[]' id='ol".$i."'  class='textclass ' value='". $result2['otherleave']."' title='Please enter the  Other Leave'>
								</td>";
					} else {
						$tt = $result2['otherleave'];
						if($result2['otherleave'] =="0.00"){$tt = "";}
						echo "    <td >
								<input type='text' name='ol[]' id='ol".$i."'  class='textclass' value='". $tt."' title='Please enter the  Other Leave'>
								</td>";
					}   

					$pos = strpos($head, "paidholiday");
					if ($pos === false) {
						echo "    <td style= 'display:none'>
								<input type='text' name='ph[]' id='ph".$i."'  class='textclass $datewisedetailsInputClass' value='". $result2['paidholiday']."' title='Please enter the Paid Holiday'  $datewisedetailsInput  >
								</td>";
					} else {
						$tt = $result2['paidholiday'];
						if($result2['paidholiday'] =="0.00"){$tt = "";}
						echo "    <td >
								<input type='text' name='ph[]' id='ph".$i."'  class='textclass $datewisedetailsInputClass' value='". $tt."' title='Please enter the Paid Holiday'  $datewisedetailsInput  >
								</td>";
					}   

					$pos = strpos($head, "additional");
					if ($pos === false) {
						echo "    <td style= 'display:none'>
								<input type='text' name='add[]' id='add".$i."'  class='textclass $datewisedetailsInputClass' value='". $result2['additional']."' title='Please enter the  Additional Days'  $datewisedetailsInput  >
								</td>";
					} else {
						$tt = $result2['additional'];
						if($result2['additional'] =="0.00"){$tt = "";}
						echo "    <td >
								<input type='text' name='add[]' id='add".$i."'  class='textclass $datewisedetailsInputClass' value='". $tt."' title='Please enter the Additional Days'  $datewisedetailsInput  >
								</td>";
					}   


					$pos = strpos($head, "othours");
					if ($pos === false) {
						echo "    <td style= 'display:none'>
								<input type='text' name='oh[]' id='oh".$i."'  class='textclass $datewisedetailsInputClass' value='". $result2['othours']."' title='Please enter the  Overtime Hours'  $datewisedetailsInput  >
								</td>";
					} else {
						$tt = $result2['othours'];
						if($result2['othours'] =="0.00"){$tt = "";}
						echo "    <td >
								<input type='text' name='oh[]' id='oh".$i."'  class='textclass $datewisedetailsInputClass' value='". $tt."' title='Please enter the Overtime Hours'  $datewisedetailsInput  >
								</td>";
					}   
										
					$pos = strpos($head, "nightshifts");
					if ($pos === false) {
						echo "    <td style= 'display:none'>
								<input type='text' name='ns[]' id='ns".$i."'  class='textclass' value='". $result2['nightshifts']."' title='Please enter the  Night Shifts'>
								</td>";
					} else {
						$tt = $result2['nightshifts'];
						if($result2['nightshifts'] =="0.00"){$tt = "";}
						echo "    <td >
								<input type='text' name='ns[]' id='ns".$i."'  class='textclass' value='". $tt."' title='Please enter the Night Shifts'>
								</td>";
					}   
					
					$pos = strpos($head, "extra_inc1");
					if ($pos === false) {
						echo "    <td style= 'display:none'>
								<input type='text' name='extra_inc1[]' id='extra_inc1".$i."'  class='textclass' value='". $result2['extra_inc1']."' title='Please enter the  Extra Income1'>
								</td>";
					} else {
						$tt = $result2['extra_inc1'];
						if($result2['extra_inc1'] =="0.00"){$tt = "";}
						echo "    <td >
								<input type='text' name='extra_inc1[]' id='extra_inc1".$i."'  class='textclass' value='". $tt."' title='Please enter the Extra Income1 '>
								</td>";
					}   
					$pos = strpos($head, "extra_inc2");
					if ($pos === false) {
						echo "    <td style= 'display:none'>
								<input type='text' name='extra_inc2[]' id='extra_inc2".$i."'  class='textclass' value='". $result2['extra_inc2']."' title='Please enter the   Extra Income2 '>
								</td>";
					} else {
						$tt = $result2['extra_inc2'];
						if($result2['extra_inc2'] =="0.00"){$tt = "";}
						echo "    <td >
								<input type='text' name='extra_inc2[]' id='extra_inc2".$i."'  class='textclass' value='". $tt."' title='Please enter the  Extra Income2 '>
								</td>";
					} 




					$pos = strpos($head, "leave_encash");
					if ($pos === false) {
						echo "    <td style= 'display:none'>
								<input type='text' name='leave_encash[]' id='leave_encash".$i."'  class='textclass' value='". $result2['leave_encash']."' title='Please enter the   Leave Encashment '>
								</td>";
					} else {
						$tt = $result2['leave_encash'];
						if($result2['leave_encash'] =="0.00"){$tt = "";}
						echo "    <td >
								<input type='text' name='leave_encash[]' id='leave_encash".$i."'  class='textclass' value='". $tt."' title='Please enter the  Leave Encashment '>
								</td>";
					} 




					$pos = strpos($head, "reward");
					if ($pos === false) {
						echo "    <td style= 'display:none'>
								<input type='text' name='reward[]' id='reward".$i."'  class='textclass' value='". $result2['reward']."' title='Please enter the   reward '>
								</td>";
					} else {
						$tt = $result2['reward'];
						if($result2['reward'] =="0.00"){$tt = "";}
						echo "    <td >
								<input type='text' name='reward[]' id='reward".$i."'  class='textclass' value='". $tt."' title='Please enter the  Extra Income2 '>
								</td>";
					} 




					
					$pos = strpos($head, "extra_ded1");
					if ($pos === false) {
						echo "    <td style= 'display:none'>
								<input type='text' name='extra_ded1[]' id='extra_ded1".$i."'  class='textclass' value='". $result2['extra_ded1']."' title='Please enter the  Extra Deduction1'>
								</td>";
					} else {
						$tt = $result2['extra_ded1'];
						if($result2['extra_ded1'] =="0.00"){$tt = "";}
						echo "    <td >
								<input type='text' name='extra_ded1[]' id='extra_ded1".$i."'  class='textclass' value='". $tt."' title='Please enter the Extra Deduction 1'>
								</td>";
					}   
					$pos = strpos($head, "extra_ded2");
					if ($pos === false) {
						echo "    <td style= 'display:none'>
								<input type='text' name='extra_ded2[]' id='extra_ded2".$i."'  class='textclass' value='". $result2['extra_ded2']."' title='Please enter the   Extra Deduction 2'>
								</td>";
					} else {
						$tt = $result2['extra_ded2'];
						if($result2['extra_ded2'] =="0.00"){$tt = "";}
						echo "    <td >
								<input type='text' name='extra_ded2[]' id='extra_ded2".$i."'  class='textclass' value='". $tt."' title='Please enter the  Extra Deduction 2'>
								</td>";
					}   
					$pos = strpos($head, "leftdate");
					if ($pos === false) {
						echo "    <td style= 'display:none'>
								<input type='text' name='leftdate[]' id='leftdate".$i."'  class='textclass' value='". $result2['leftdate']."' title='Please enter the  Left Date'>
								</td>";
					} else {
						$tt = $result2['leftdate'];
						if($result2['leftdate'] =="0.00"){$tt = "";}
						echo "    <td >
								<input type='text' name='leftdate[]' id='leftdate".$i."'  class='textclass' value='". $tt."' title='Please enter the Left Date'>
								</td>";
					}   


					$pos = strpos($head, "wagediff");
					if ($pos === false) {
						echo "    <td style= 'display:none'>
								<input type='text' name='wagediff[]' id='wagediff".$i."'  class='textclass' value='". $result2['wagediff']."' title='Please enter the  Basic+DA Diff'>
								</td>";
					} else {
						$tt = $result2['wagediff'];
						if($result2['wagediff'] =="0.00"){$tt = "";}
						echo "    <td >
								<input type='text' name='wagediff[]' id='wagediff".$i."'  class='textclass' value='". $tt."' title='Please enter the Basic+DA Diff'>
								</td>";
					}   
					
					$pos = strpos($head, "Allow_arrears");
					if ($pos === false) {
						echo "    <td style= 'display:none'>
								<input type='text' name='Allow_arrears[]' id='Allow_arrears".$i."'  class='textclass' value='". $result2['Allow_arrears']."' title='Please enter the  Allow_arrears'>
								</td>";
					} else {
						$tt = $result2['Allow_arrears'];
						if($result2['Allow_arrears'] =="0.00"){$tt = "";}
						echo "    <td >
								<input type='text' name='Allow_arrears[]' id='Allow_arrears".$i."'  class='textclass' value='". $tt."' title='Please enter the Allow_arrears'>
								</td>";
					}   

					$pos = strpos($head, "Ot_arrears");
					if ($pos === false) {
						echo "    <td style= 'display:none'>
								<input type='text' name='Ot_arrears[]' id='Ot_arrears".$i."'  class='textclass' value='". $result2['Ot_arrears']."' title='Please enter the  Ot_arrears'>
								</td>";
					} else {
						$tt = $result2['Ot_arrears'];
						if($result2['Ot_arrears'] =="0.00"){$tt = "";}
						echo "    <td >
								<input type='text' name='Ot_arrears[]' id='Ot_arrears".$i."'  class='textclass' value='". $tt."' title='Please enter the Ot_arrears'>
								</td>";
					}
					
					$pos = strpos($head, "incometax");
					if ($pos === false) {
						echo "    <td style= 'display:none'>
								<input type='text' name='incometax[]' id='incometax".$i."'  class='textclass' value='". $result2['incometax']."' title='Please enter the  income_tax'>
								</td>";
					} else {
						$tt = $result2['incometax'];
						if($result2['incometax'] =="0.00"){$tt = "";}
						echo "    <td >
								<input type='text' name='incometax[]' id='incometax".$i."'  class='textclass' value='". $tt."' title='Please enter the income tax'>
								</td>";
					}
					$pos = strpos($head, "society");
					if ($pos === false) {
						echo "    <td style= 'display:none'>
								<input type='text' name='society[]' id='society".$i."'  class='textclass' value='". $result2['society']."' title='Please enter the  society'>
								</td>";
					} else {
						$tt = $result2['society'];
						if($result2['society'] =="0.00"){$tt = "";}
						echo "    <td >
								<input type='text' name='society[]' id='society".$i."'  class='textclass' value='". $tt."' title='Please enter the society'>
								</td>";
					}
					$pos = strpos($head, "canteen");
					if ($pos === false) {
						echo "    <td style= 'display:none'>
								<input type='text' name='canteen[]' id='canteen".$i."'  class='textclass' value='". $result2['canteen']."' title='Please enter the  canteen'>
								</td>";
					} else {
						$tt = $result2['canteen'];
						if($result2['canteen'] =="0.00"){$tt = "";}
						echo "    <td >
								<input type='text' name='canteen[]' id='canteen".$i."'  class='textclass' value='". $tt."' title='Please enter the canteen'>
								</td>";
					}	
					$pos = strpos($head, "remarks");
					if ($pos === false) {
						echo "    <td style= 'display:none'>
								<input type='text' name='remarks[]' id='remarks".$i."'  class='textclass' value='". $result2['remarks']."' title='Please enter the  remarks'>
								</td>";
					} else {
						$tt = $result2['remarks'];
						if($result2['remarks'] =="0.00"){$tt = "";}
						echo "    <td >
								<input type='text' name='remarks[]' id='remarks".$i."'  class='textclass' value='". $tt."' title='Please enter the remarks'>
								</td>";
					}					
			
					
						echo "    <td >
								<input type='text' name='invalid[]' id='invalid".$i."'  class='textclass' value='". $result2['invalid']."' title='Please enter the Invalid Days'>
								</td>
								</tr>";

        $i++;
    }
}
else{
    ?>
    <tr class="bgColor3">
        <td colspan="21" class="errorclass" align="center">No Result Fond!</td>
    </tr>
    <?php
}
?>

</table>
</div>
</div>
<?php
if($count>0) { ?>
<div ><br/>
<input type="submit" value="Save" class="btnclass" >
</div>
<?php } ?>
    <br/>


<script src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>

<script type="text/javascript">
    $(document).ready(function(){

        $('.textclass').tooltip({
            track: true
        });
    });
</script>
<style type="text/css">

    .ui-tooltip {
        padding: 8px;
        position: absolute;
        z-index: 9999;
        max-width: 300px;
        -webkit-box-shadow: 0 0 5px #aaa;
        box-shadow: 0 0 5px #aaa;
        background-color: #fff;
        font-size:10pt;
        border-width: 2px;
    }




</style>