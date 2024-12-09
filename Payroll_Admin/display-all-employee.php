<?php
$doc_path=$_SERVER["DOCUMENT_ROOT"];
include ($doc_path.'/include_payroll_admin.php');
error_reporting(0);
$payrollAdmin = new payrollAdmin();

if($_SESSION['log_type']==2)
{
    
}else
{
    echo "<script>window.location.href='/payroll-logout';</script>";exit();
}


include($doc_path."/lib/class/advance.php");
$advance =new advance();
$id=$_REQUEST['id'];
$rowsemp=$payrollAdmin->showEployeedetails($id);
$rowsincome=$payrollAdmin->showEployeeincome($id);
$rowsdeduct=$payrollAdmin->showEployeededuct($id);
$rowsleave=$payrollAdmin->showEployeeleave($id);
$rowsadnavcen=$payrollAdmin->showEployeeadnavcen($id);
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$result1 = $payrollAdmin->showClient1($comp_id,$user_id);
$result2 = $payrollAdmin->showDesignation($comp_id);
$result3 = $payrollAdmin->showDepartment($comp_id);
$result4 = $payrollAdmin->showQualification($comp_id);
$result5 = $payrollAdmin->showBank($comp_id);

$result6 = $payrollAdmin->showLocation($comp_id);
$result7= $payrollAdmin->showPayscalecode($comp_id);
$resultIncome = $payrollAdmin->showIncomehead($comp_id);
$resultdest = $payrollAdmin->showDeductionhead($comp_id);
$advancetype = $advance->getAdvanceType($comp_id);


?>


<script>
    $( document ).ready(function() {

    $('#tab1').show();
	
	$( "#date1" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat:'dd-mm-yy'
        });
		
		$( ".advdate" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat:'dd-mm-yy'
        });
    });

    function displayDataDeduct(){
        var destid=document.getElementById('destid').value;
        var clientid=document.getElementById('clientid').value;
        if(destid=='0'){
            alert('Select The Deduction');
        }
        else{
            $.post('/display-emp-deduct-data',{
                'destid':destid,
                'clientid':clientid
            },function(data){
                $('#showdeductdata').html(data);
            });

        }
    }
    function displayDataIncome(){
        var incomeid=document.getElementById('incomeid').value;
        var clientid=document.getElementById('clientid').value;
        if(incomeid=='0'){
            alert('Select The Income');
        } else{
            $.post('/display-emp-income-data',{
                'incomeid':incomeid,
                'clientid':clientid
            },function(data){

                $('#showincomedata').html(data);
            });

        }
    }

    function displayData(lmfrom,lmto){
        var cid=document.getElementById('clientid').value;
        var checkboxes = document.getElementsByName('check[]');
        var vals = "";
        var j=0;
        var fielda ="";
        var fieldb ="";
        var fieldc ="";
        var fieldd ="";
        for (var i=0, n=checkboxes.length;i<n;i++)
        {
            if (checkboxes[i].checked)
            {
                vals += ","+checkboxes[i].value;

                if(j==0){
                    fielda=checkboxes[i].value;
                }else if(j==1){
                    fieldb=checkboxes[i].value;
                }else if(j==2){
                    fieldc=checkboxes[i].value;
                }else if(j==3){
                    fieldd=checkboxes[i].value;
                }
                j++;
            }
        }

       if(j==4){
            $.post('/display-emp-data',{
                'cid':cid,
                'fielda':fielda,
                'fieldb':fieldb,
                'fieldc':fieldc,
                'fieldd':fieldd,
                'limitfrom':lmfrom,
                'limitto':lmto
            },function(data){

                $('#showdata').html(data);
            });

        }else{

            alert("Minimum field Checked");
        }


    }
function displayAdvance(){
        var advid=document.getElementById('advid').value;
        var clientid=document.getElementById('clientid').value;
		 var date1=document.getElementById('date1').value;
        if(advid=='0'){
            alert('Select The Advance');
			return false;
        }
		
            $.post('/display-emp-advance-data',{
                'advid':advid,
                'clientid':clientid,
				'advdate':date1
            },function(data){
                $('#showadvancedata').html(data);
            });

        
    }
    function openTab(evt, tabName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";
    }

      function SetAmt(incded){
       var texta = document.getElementsByName('textaincome[]');
     if (incded =='inc')
       {
               var emp_ic_id = document.getElementsByName('emp_ic_id[]');
               var setval = $("#setvali").val();

        	for ( var i = 0; i < emp_ic_id.length; i++ ){
        
                       {texta[i].value= setval;}
                }
           
           
       }
        
        
    }
    
    function updateIncome() {
    var formData = {
        emp_ic_id: $("input[name='emp_ic_id[]']").map(function() { return this.value; }).get(),
        textaincome: $("input[name='textaincome[]']").map(function() { return this.value; }).get(),
        caltype: $("select[name='caltype[]']").map(function() { return this.value; }).get(),
        // Add more fields as necessary
    };

    // Validate if each employee has a selected Calculation Type
    var allCalTypesSelected = true;
    formData.caltype.forEach(function(value, index) {
        if (value === '0') {
            allCalTypesSelected = false;
            alert('Please select a Calculation Type for employee #' + (index + 1));
            return false; // Break the loop if validation fails
        }
    });

    // If not all Calculation Types are selected, prevent form submission
    if (!allCalTypesSelected) {
        return; // Prevent the AJAX request if validation fails
    }

    console.log(formData); // Log the form data to ensure it's correct

    $.ajax({
        type: "POST",
        url: "/update-all-emp-income-process",
        data: formData,
        success: function(response) {
            response = JSON.parse(response);
            console.log(response); // Log the response to verify its contents
            if (response.status === 'success') {
               // refreshIncome(response.emp_ic_id);
               
                alert('Income updated successfully!');
                displayDataIncome();
            } else {
                alert(response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error(error);
            alert('Error updating income.');
        }
    });
}

function refreshIncome(id) {
    
    $.post('/display-emp-income-data', { id: id }, function(data) {
        // alert('Income updated successfully!');
     $('#showincomedata').html(data);
        });
}

function updateDeduct() {
   var clientidnew=$("#clientid").val();
    var formData = {
        emp_de_id: $("input[name='emp_de_id[]']").map(function() { return this.value; }).get(),
        texta: $("input[name='textdeducta[]']").map(function() { return this.value; }).get(),
        textc: $("input[name='textdeductc[]']").map(function() { return this.value; }).get(),
        caltype: $("select[name='dedcaltype[]']").map(function() { return this.value; }).get(),
        clientid: clientidnew,
    };
    
 //alert($("#clientid").val());
    // Validate if each employee has a selected Calculation Type
    var allCalTypesSelected = true;
    formData.caltype.forEach(function(value, index) {
        if (value === '0') {
            allCalTypesSelected = false;
            alert('Please select a Calculation Type for employee #' + (index + 1));
            return false; // Break the loop if validation fails
        }
    });

    // If not all Calculation Types are selected, prevent form submission
    if (!allCalTypesSelected) {
        return; // Prevent the AJAX request if validation fails
    }

    //console.log(formData); // Log the form data to ensure it's correct

    // Perform the AJAX request
    $.ajax({
        type: "POST",
        url: "/update-all-emp-deduct-process",
        data: formData,
        success: function(response) {
            response = JSON.parse(response);
            
            console.log(response); // Log the response to verify its contents
           // alert(response);
            if (response.status === 'success') {
                //refreshDeduct(response.emp_de_id); // Refresh data without reloading the page
                alert('Deduction updated successfully!');
                displayDataDeduct();
                
            } else {
                alert("parsing error ");
                alert(response.message); // Show the error message if update failed
            }
        },
        error: function(xhr, status, error) {
            console.error(error);
            alert('Error updating deduction.');
        }
    });
}

function refreshDeduct(id) {
     var clientidnew=$("#clientid").val();
    $.post('/display-emp-deduct-data', { destid: id,clientid:clientidnew  }, function(data) {
        //  alert('Deduction data refreshed successfully!');
        $('#showdeductdata').html(data); // Refresh the data without page reload
       
    });
}

// Bind form submission to prevent default and trigger the updateDeduct function
$('#empfr').submit(function(event) {
    event.preventDefault(); // Prevent the form from refreshing the page
    updateDeduct(); // Call the update function on form submit
});

    </script>



<!--Menu ends here-->
<div class="clearFix"></div>
<!--Slider part starts here-->

<div class="twelve mobicenter innerbg">
    <div class="row">



        <div class="twelve" id="margin1">
            <div class="tab">
                <button id="t1" class="tablinks active" onclick="openTab(event, 'tab1')">View Employee</button>
                <button id="t2" class="tablinks" onclick="openTab(event, 'tab2')" >Employee Income</button>
                <button id="t3" class="tablinks" onclick="openTab(event, 'tab3')">Employee Deduct</button>
				<button id="t4" class="tablinks" onclick="openTab(event, 'tab4')">Advance</button>
				<button id="t5" class="tablinks" onclick="openTab(event, 'tab5')">Other Fields</button>

            </div>

            <div id="tab1" class="tabcontent ">
                <form action="/update-all-emp-process" method="post" name="inempfr">
                <h3>View Employee  <h6 style="color:red;"> (Please select any 4 columns at a time)</h6></h3>
                <div style="min-height:200px;max-height:200px; padding-left: 10px; border: 1px solid gray; padding-bottom: 20px; overflow-y: scroll;">
                    <div class="studentreport" >


                        <?php

                        $result = $payrollAdmin->selectempstrdet();

                        if (count($result) > 0) {
                            foreach ($result  as $row) {

                                if ($row['Field'] != 'emp_id' && $row['Field'] != 'db_update' && $row['Field'] != 'db_adddate') {
                                    ?>
                                    <div class="three padd0 columns">
                                        <input type="checkbox" id="grno" name="check[]"
                                               value="<?php echo $row['Field']; ?>" class="boxcheck valign "> <span
                                                class="test-upper"><?php echo $row['Field']; ?></span>
                                    </div>

                                <?php }
                            }
                        }
                      ?>


                    </div>
                </div>
                <div>
                      <input type="button" onclick="displayData(0,190);" value="show[1-190]" class="btnclass" id="margin1">
                        <input type="button" onclick="displayData(190,400);" value="show[191-380]" class="btnclass" id="margin1">
                 </div>

                <div id="showdata" style="height: 100%;background: #fff;">

                </div>


                </form>
            </div>
        </div>

            <div id="tab2" class="tabcontent">
                <h3>Income</h3>
                <div>
                    <form id="incomeForm" onsubmit="updateIncome(); return false;">
                    <div id="margin1">
                        <div class="two columns">
                            <span class="labelclass">Income :</span>
                        </div>
                        <div class="four columns">
                            <select id="incomeid" name="incomeid" class="textclass">
                                <option value="0">--select-</option>
                                <?php foreach ($resultIncome as $rowin) { ?>
                                    <option value="<?php echo $rowin['mast_income_heads_id']; ?>"><?php echo $rowin['income_heads_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="two columns">
                            <input type="button" onclick="displayDataIncome();" value="show" class="btnclass">
                        </div>
                        <div class="two columns">
                            <input type="text" name="setvali" id="setvali" placeholder="0" class="textclass" value="">
                        </div>
                        <div class="two columns">
                            <input type="button" value="Set Std Amt" class="btnclass" onclick="SetAmt('inc');">
                        </div>
                        <div class="clearFix"></div>
                        <div id="showincomedata"></div>
                    </div>
                </form>
     
      </div>
</div>


            <div id="tab3" class="tabcontent">
                <h3>Deduct</h3>
                <div>
                       <form id="empfr" name="empfr">
    <div id="margin1">
        <div class="two columns">
            <span class="labelclass">Deduction :</span>
        </div>
        <div class="four columns">
            <select id="destid" name="destid" class="textclass">
                <option value="0">--select--</option>
                <?php foreach ($resultdest as $rowde) { ?>
                    <option value="<?php echo $rowde['mast_deduct_heads_id']; ?>">
                        <?php echo $rowde['deduct_heads_name']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="two columns">
            <input type="button" onclick="displayDataDeduct();" value="Show" class="btnclass">
        </div>
        
        <div class="four columns"></div>
        <div class="clearFix"></div>

        <div id="showdeductdata">
            <!-- This is where deduction data will be displayed dynamically via JS -->
        </div>
    </div>
</form>
    </div>
            </div>
			<!---- tab 4----->
			<div id="tab4" class="tabcontent">
                <h3>Advance</h3>
                <div>


                        
                            <div id="margin4">
                                <div class="two columns">
                                    <span class="labelclass">Advance :</span>
                                </div>
                                <div class="four  columns">
                                    <select id="advid" name="advid" class="textclass">
                                        <option value="0">--select-</option>
                                        <?php
										foreach($advancetype as $advance){
                                            ?>

                                            <option value="<?php echo $advance['mast_advance_type_id'];?>" ><?php echo $advance['advance_type_name'];?></option>
                                        <?php }

                                        ?>
                                    </select>
                                </div>

								<div class="four  columns"><input type="date" name="date1" id="date1" placeholder="Date" class="textclass">

                                </div>
                                <div class="two columns">

                                    <input type="button" onclick="displayAdvance();" value="show" class="btnclass" >

                                </div>
                                
                                <div class="clearFix"></div>


                                <div id="showadvancedata">

                                </div>
                            </div>
                       
                </div>
            </div>
			<!----- tab 4 end -----> 

<!---- tab 5----->
			<div id="tab5" class="tabcontent">
                <h3>Other Fields</h3>
                <div>


                        <form action="/display-emp-other-data-process"  method="post" name="empfr">
                            <div id="margin4">
                            <div class="two columns">
                                    <span class="labelclass">Advance :</span>
                                </div>
                                <div class="four  columns">
                                    <select id="otherid" name="otherid"  class="textclass">
                                        <option value="0">--select-</option>
                                        <?php $getallid = array(
                                			array('desg_id','mast_desg','Designation','mast_desg_id','mast_desg_name'),
                                			array('dept_id','mast_dept','Department','mast_dept_id','mast_dept_name'),
                                			array('qualif_id','mast_qualif','Qalification','mast_qualif_id','mast_qualif_name'),
                                			array('bank_id','mast_bank','Bank','mast_bank_id','bank_name|add1'),
                                			array('loc_id','mast_location','Location','mast_location_id','mast_location_name'),
                                			array('paycode_id','mast_paycode','PayScale','mast_paycode_id','mast_paycode_name'));
                                		foreach($getallid as $rowin){
                                           ?>

                                           <option value="<?php echo $rowin[0]."#".$rowin[1]."#".$rowin[3]."#".$rowin[4];?>"><?php echo $rowin[2];?></option>
                                       <?php }

                                       ?>
                                   </select>
                                </div>

								
                                <div class="two columns">

                                    <input type="button" onclick="displayOtherData();" value="show" class="btnclass" >

                                </div>
                                
                                <div class="clearFix"></div>


                                <div id="showotherdata">

                                </div>
                            </div>
                            </form>
                       
                </div>
            </div>
			<!----- tab 5 end -----> 





        </div>


    </div>
<br/>

<div class="clearFix"></div>

<script>
    function displayOtherData(){
		var otherid=$("#otherid").val();
		$("#otherid").removeClass('bordererror');
		if(otherid=='0'){
            alert('Select The Other Fields');
			return false;
        }else{
		 $.post('/display-other-fields-data',{
                'clientid':'<?=$id;?>',
                'otherid':otherid
            },function(data){
               // alert(data);
                $('#showotherdata').html(data);
            });
		}
	}
</script>

<!--Slider part ends here-->
