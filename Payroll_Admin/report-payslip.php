<?php

$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

$comp_id=$_SESSION['comp_id'];

?>





<script>



    function changeemp(val){

        if(val!='all'){
            $('#showemp').show();
        }
        else
        {
            $('#showemp').hide();
        }
    }
    function showTabdata(id,name){

        $.post('/display-employee', {
            'id': id
        }, function (data) {
            $('#searching').hide();
            $('#displaydata').html(data);
            $('#name').val(name);
            $('#displaydata').show();
            document.getElementById('empid').value=id;

        });

    }
    function serachemp(val){
        $.post('/display-employee1', {
            'name': val
        }, function (data) {
            $('#searching').html(data);
            $('#searching').show();
        });
    }
</script>





<!--<div class="twelve mobicenter innerbg">-->
<div class="twelve mobicenter">
    <div class="row">
        <div class="twelve"><h3>Payslip</h3></div>
        <div class="clearFix"></div>
        <form id="form" action="/r-report-payslip-page" method="post">
        <div class="twelve" id="margin1">
            <div class="one  columns">
                <span class="labelclass1">Employee :</span>
            </div>
            <div class="two padd0 columns" style="margin-top:6px;">
                <input type="radio" name="emp" value="all" onclick="changeemp(this.value);" checked>All
                <input type="radio" name="emp" value="random" onclick="changeemp(this.value);" >Random
            </div>
            <div class="five padd0 columns">
                <div id="showemp" class="hidecontent">
                    <input type="text" name="name" id="name" onkeyup="serachemp(this.value);" autocomplete="off" placeholder="Enter the Employee Name" class="textclass" >
                    <div id="searching" style="z-index:10000;position: absolute;width: 100%;border: 1px solid rgba(151, 151, 151, 0.97);display: none;background-color: #FFFFFF;">

                    </div>
                    <input type="hidden" name="empid" id="empid" value=""> <br/> <br/>
                </div>
            </div>
           <div class="one padd0 columns"></div>
            <div class="clearFix" ></div> 
            <div class="three  columns" style= "display:none;">
                <span class="labelclass1">Include Zero Salary Employees :</span>
            </div>
            <div class="two padd0 columns" style= "display:none;" >
                <input type="radio" name="zerosal" value="yes" onclick="changeemp(this.value);" >Yes
                <input type="radio" name="zerosal" value="no" onclick="changeemp(this.value);" checked >No
            </div>
			<div class="seven padd0 columns" style= "display:none;"></div>
			<div class="clearFix" style= "display:none;"></div>
			<div class="three  columns"style= "display:none;" >
                <span class="labelclass1">No of Payslip for page :</span>
            </div>
            <div class="three padd0 columns"style= "display:none;" >
                <input type="radio" name="noofpay" value="1" > 1
                <input type="radio" name="noofpay" value="2" checked> 2
				<input type="radio" name="noofpay" value="3" > 3
            </div>

		<div class="nine padd0 columns" id="margin1">
                &nbsp;
            </div>
       


            <div class="clearFix"></div>

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

            </form>
        </div>





</div>

