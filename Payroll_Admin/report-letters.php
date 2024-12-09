<?php
$doc_path=$_SERVER["DOCUMENT_ROOT"];
include ($doc_path.'/include_payroll_admin.php');

 $comp_id=$_SESSION['comp_id'];


if(isset($_REQUEST['val'])){
	$type = $_REQUEST['val'];
}else{
	$type =1;
}

?>


<!--<div class="twelve mobicenter innerbg">-->
<div class="twelve mobicenter">
    <div class="row">
        <div class="twelve"><h3><?php if($type==1){echo "Appointment";}else if($type==2){echo "Experience Certificate";}else if($type==3){echo "Resignation Acceptance";}?></h3></div>
        <div class="clearFix"></div>
		<?php if($type==1){?>
        <form id="form" action="/r-report-letters-appoinment-page" method="post">
        <div class="twelve" id="margin1">
            <div class="two padd0 columns">
                <span class="labelclass1">Employee :</span>
            </div>
            <div class="two padd0 columns">
                <input type="radio" name="emp" value="0" checked onclick="getEmployee(this.value);">New
                <input type="radio" name="emp" value="1" onclick="getEmployee(this.value);" >Random
            </div>

            <div class="four padd0 columns" id="employeediv">
			<input type="hidden" value="" name="employee" id="eid">
			<input type="text" onkeyup="serachemp(this.value);" class="textclass" placeholder="Full Name" id="name" autocomplete="off" name="name">
            <div id="searching" style="z-index:10000;position: absolute;width: 97%;border: 1px solid rgba(151, 151, 151, 0.97);display: none;background-color: #FFFFFF;">
        </div>
		<div id="errinm" class="errorclass hidecontent"></div>
            </div>

            <div class="four padd0 columns">
            </div>
			</div>
			 <div class="clearFix"></div>
			<div class="twelve" id="margin1">
			<div class="two padd0 columns">
                <span class="labelclass1">Lettter Type :</span>
            </div>
            <div class="seven padd0 columns">
    <!--            <input type="radio" name="type" value="1" checked>Type 1-->
    <!--            <input type="radio" name="type" value="2" >Type 2-->
				<!--<input type="radio" name="type" value="3" >Type 3-->
				
			<input type="radio" name="typeapp" value="1" >Format 1
			    <input type="radio" name="typeapp" value="2" >Format 2
            </div>
            <div class="three padd0 columns">            </div>
            
            <div class="clearFix"></div>

             <div class="one padd0 columns" id="margin1">
            </div>
            <div class="three padd0 columns" id="margin1">

                <input type="submit" name="submit" id="submit" value="Print" class="btnclass">
            </div>
            <div class="eight padd0 columns" id="margin1">
                &nbsp;
            </div>
            <div class="clearFix"></div>
			</div>
            </form>
		<?php }else if($type==2){?>
		<form id="form" action="/r-report-letters-experience-page" method="post" onsubmit="return expval()">
        <div class="twelve" id="margin1">
            <div class="two padd0 columns">
                <span class="labelclass1">Employee :</span>
            </div>
            <!--<div class="two padd0 columns">
                <input type="radio" name="emp" value="0" onclick="getEmployeeForExperience(this.value);" checked>New
                <input type="radio" name="emp" value="1" onclick="getEmployeeForExperience(this.value);" >Random
            </div>-->

            <div class="four padd0 columns" >
			<input type="hidden" value="" name="employee" id="eid">
			<input type="text" onkeyup="serachemp1(this.value);" class="textclass" placeholder="Full Name" id="name" autocomplete="off" name="name">
            <div id="searching" style="z-index:10000;position: absolute;width: 97%;border: 1px solid rgba(151, 151, 151, 0.97);display: none;background-color: #FFFFFF;">
        </div>
		<div id="errinm" class="errorclass hidecontent"></div>
            </div>

            <div class="four padd0 columns">
            </div>
			</div>
			 <div class="clearFix"></div>
			<div class="twelve" id="margin1">
			<div class="two padd0 columns">
                <span class="labelclass1">Lettter Type :</span>
            </div>
            <div class="two padd0 columns">
                <input type="radio" name="type" value="1" checked>Type 1
                <input type="radio" name="type" value="2" >Type 2
            </div>
            <div class="four padd0 columns"><div>			
			</div>
            </div>
            <div class="four padd0 columns">
            </div>
			
			
            <div class="clearFix"></div>

             <div class="one padd0 columns" id="margin1">
            </div>
            <div class="three padd0 columns" id="margin1">

                <input type="submit" name="submit" id="submit" value="Print" class="btnclass">
            </div>
            <div class="eight padd0 columns" id="margin1">
                &nbsp;
            </div>
            <div class="clearFix"></div>
			<div id="erexpre" style="color:red"></div>
</div>
            </form>
			
			<?php }else if($type==3){?>
		<form id="form" action="/r-report-letters-resigation-acceptance-page" method="post" onsubmit="return expval()">
        <div class="twelve" id="margin1">
            <div class="two padd0 columns">
                <span class="labelclass1">Employee :</span>
            </div>
           
            <div class="four padd0 columns" >
			<input type="hidden" value="" name="employee" id="eid">
			<input type="text" onkeyup="serachemp1(this.value);" class="textclass" placeholder="Full Name" id="name" autocomplete="off" name="name">
            <div id="searching" style="z-index:10000;position: absolute;width: 97%;border: 1px solid rgba(151, 151, 151, 0.97);display: none;background-color: #FFFFFF;">
        </div>
		<div id="errinm" class="errorclass hidecontent"></div>
            </div>

            <div class="four padd0 columns">
            </div>
			</div>
			 <div class="clearFix"></div>
			 <div class="one padd0 columns" id="margin1">
            </div>
            <div class="three padd0 columns" id="margin1">

                <input type="submit" name="submit" id="submit" value="Print" class="btnclass">
            </div>
            <div class="eight padd0 columns" id="margin1">
                &nbsp;
            </div>
            <div class="clearFix"></div>
			<div id="erexpre" style="color:red"></div>
            </form>
			<?php } else if($type==4){?>
        <form id="form" action="/r-report-letters-blank-appoinment-page" method="post">        
			 
			<div class="twelve" id="margin1">
			<div class="two padd0 columns">
                <span class="labelclass1">Lettter Type :</span>
            </div>
            <div class="three padd0 columns">
                <input type="radio" name="type" value="1" checked>Type 1
                <input type="radio" name="type" value="2" >Type 2
				<input type="radio" name="type" value="3" >Type 3
            </div>

            <div class="four padd0 columns"><div>		
			
			</div>
            </div>
            <div class="four padd0 columns">
            </div>		
			
            <div class="clearFix"></div>
   <div class="one padd0 columns" id="margin1">
            </div>
			  <div class="clearFix"></div>
			<div class="two padd0 columns">
                <span class="labelclass1">Print Comp.Details :</span>
            </div>
            <div class="three padd0 columns">
                <input type="radio" name="compdet" value="1" checked>Yes
                <input type="radio" name="compdet" value="0" >No
            </div>

			 <div class="clearFix"></div>
			
             <div class="one padd0 columns" id="margin1">
            </div>
            <div class="three padd0 columns" id="margin1">

                <input type="submit" name="submit" id="submit" value="Print" class="btnclass">
            </div>
            <div class="eight padd0 columns" id="margin1">
                &nbsp;
            </div>
            <div class="clearFix"></div>
			</div>
            </form>
			<?php } else if($type==5){?>
        <form id="form" action="/r-report-letters-blank-page" method="post">        
			

             <div class="one padd0 columns" id="margin1">
            </div>
            <div class="three padd0 columns" id="margin1">

                <input type="submit" name="submit" id="submit" value="Print" class="btnclass">
            </div>
            <div class="eight padd0 columns" id="margin1">
                &nbsp;
            </div>
            <div class="clearFix"></div>
			</div>
            </form>
		<?php }?>
        <div class="clearFix"></div>
        </div>
</div>
<br/>
<!--Slider part ends here-->
<div class="clearFix"></div>
<script >
 function getEmployee(val){ 
if(val == '0'){
	$("#employeediv").hide();
	} else {
		$("#employeediv").show();
	  /* $.get('display-appoint-employee.php', {
         }, function (data) {
			 $("#employeediv").html(data);
             
         });*/
	}
  }
  function getEmployeeForExperience(val){ 
	  if(val == '0'){
	$("#employeedivexp").hide();
	} else {
		$("#employeedivexp").show();
	  $.post('/get-employee-byid-experience', {
         }, function (data) {
			 $("#employeedivexp").html(data);
             
         });
  }
  }
  function getEmployeeForResign(val){ 
	  if(val == '0'){
	$("#employeedivexp1").hide();
	} else {
		$("#employeedivexp1").show();
	  $.post('/display-employee3', {
         }, function (data) {
			 $("#employeedivexp1").html(data);
             
         });
  }
  }
function expval(){
	var empval = $("#employee").val();
	
	if(empval =="-- select --"){
	$("#erexpre").text("Please select Employee");
	return false;
	}
}
  </script>
  <script>
   $( document ).ready(function() {
    getEmployeeForExperience(1);
	getEmployeeForResign(1);
	getEmployee(0);
});


function serachemp(val){
        $.post('/display-appoint-employee', {
            'name': val
        }, function (data) {
            $('#searching').html(data);
            $('#searching').show();
        });
    }
	function serachemp1(val){
        $.post('/display-employee3', {
            'name': val
        }, function (data) {
            $('#searching').html(data);
            $('#searching').show();
        });
    }
function showTabdata(id,name){

   $.post('/display-employee', {
	   'id': id
   }, function (data) {
	   $('#searching').hide();
	   $('#displaydata').html(data);
	   $('#name').val(name);
	   $('#displaydata').show();
	   $("#eid").val(id);
	   document.getElementById('empid').value=id;
		//refreshconutIncome(id);
   });

}
function validation(){
	var nm = $("#name").val();
	
	if(nm ==""){
		$("#errinm").show();
		$("#errinm").text("Please select Employee ");
		return false;
	}else{
		$("#errinm").hide();
	}
}
  </script>