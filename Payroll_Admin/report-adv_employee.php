 <?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

$comp_id=$_SESSION['comp_id'];


?>

<!--<div class="twelve mobicenter innerbg">-->
<div class="twelve mobicenter">
    <div class="row">
        <div class="twelve"><h3>Advance List </h3></div>
        <div class="clearFix"></div>
        <form id="form" action="/r-report-adv-employee-page" method="post" onsubmit ="return validation()">
        <div class="twelve" id="margin1">
            <div class="two  padd0 columns">
                <span class="labelclass1">Employee :</span>
            </div>
           
            <div class="four padd0 columns">
			<input type="hidden" value="" name="eid" id="eid" >
			<input type="text" onkeyup="serachemp(this.value);  " class="textclass" placeholder="Full Name" id="name" autocomplete="off" name="name">
            <div id="searching" style="z-index:10000;position: absolute;width: 97%;border: 1px solid rgba(151, 151, 151, 0.97);display: none;background-color: #FFFFFF;">
        </div>
		<div id="errinm" class="errorclass hidecontent"></div>
            </div>
			
            <div class="clearFix"></div>



        <div class="twelve" id="margin1">
		<div class="two padd0 columns">
	     <span class="labelclass1">Date :</span>
            </div>
           
			
     	<div class="four  columns " id = "advdate1">
		              </div>
			

</div>
            <div class="clearFix"></div>
             <div class="two padd0 columns" id="margin1">
            </div>
            <div class="three padd0 columns" id="margin1">

                <input type="submit" name="submit" id="submit" value="Print" class="btnclass">
            </div>
            <div class="eight padd0 columns" id="margin1">
                &nbsp;
            </div>
            <div class="clearFix"></div>

            </form>






        <div class="clearFix"></div>






        </div>





</div>


<br/>
<!--Slider part ends here-->
<div class="clearFix"></div>
<script>
 function serachemp(val){
        $.post('/display-employee3', {
            'name': val
        }, function (data) {
            $('#searching').html(data);
            $('#searching').show();
			
	    });
    }
	
 function advdates(val){
	 
        $.post('/show_adv_dates', {
            'emp_id': val
        }, function (data) {
            $('#advdate1').html(data);
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
	   document.getElementById('eid').value=id;
		var empid = document.getElementById('eid').value;
	    advdates(empid);		
    	
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



