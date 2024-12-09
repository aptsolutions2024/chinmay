<?php
error_reporting(0);
 $client=$_REQUEST['client'];
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

?>

<head>

  <meta charset="utf-8"/>


</head>
 <body>

<!--Header starts here-->
<?php //include('header.php');?>
<!--Header end here-->
<div class="clearFix"></div>
<!--Menu starts here-->

<?php //include('menu.php');?>

<!--Menu ends here-->
<div class="clearFix"></div>
<!--Slider part starts here-->

<div class="twelve mobicenter " >
    <div class="row">
        <div class="twelve" id="margin1"><h3>Form 20</h3></div>

        <div class="clearFix"></div>
        <form id="form" action="/r-report-form20-page" method="post" onsubmit="return form20validation()">
        <div class="two columns"  id="margin1">
            <span class="labelclass">Employee :</span>
        </div>
        <div class="seven columns" id="margin1">
            <input type="hidden" name="empid" id="empid" value="">
			<input type="hidden" name="client" id="client" value="<?php echo $client;?>">
			
            <input type="text" name="name" onkeyup="serachemp(this.value);" class="textclass" placeholder="Full Name" id="name" autocomplete="off">
            <div id="searching" style="z-index:10000;position: absolute;width: 97%;border: 1px solid rgba(151, 151, 151, 0.97);display: none;background-color: #FFFFFF;">
			
        </div>
		<div id="frm2onameerror" class="errorclass"></div>
        </div>

            <div class="two columns"  >

            </div>
			<div class="clearFix"></div>
			<div class="two columns" >
            <span class="labelclass">From Date :</span>
        </div>
			<div class="four columns" >
            <input type="text" name="frmd2" id="frmd2" class="textclass" value = "<?php //echo date('d-m-Y',strtotime($cmonth));?>" >
                        <span class="errorclass hidecontent" id="frmd2error"></span>
        </div>

            <div class="five columns"  >  </div>
        <div class="clearFix"></div>
		<div class="two columns"  >
            <span class="labelclass">To Date :</span>
        </div>
			<div class="four columns" >
            <input type="text" name="tod2" id="tod2" class="textclass" value = "<?php //echo date('d-m-Y',strtotime($cmonth));?>" >
                        <span class="errorclass hidecontent" id="tod2error"></span>
        </div>

            <div class="five columns"  id="margin1">  </div>
        <div class="clearFix"></div>
		
		
		<!--<div class="two  columns pdl10p" id="prv_to">
				<span>One leave Per Present Days</span>
		</div>

		<div class="eight  columns ">
			<input type="radio" name="presentday" value="12" onclick="changeperday(this.value);" checked="" id="12">Shopo Act(12)
		<input type="radio" name="presentday" value="20" onclick="changeperday(this.value);" id="20">Factory  Act(20)
		</div>
				
				-->
		
        <div class="one padd0 columns" id="margin1">
        </div>
		<div class="clearFix"></div>
        <div class="two padd0 columns" id="margin1">

            <input type="submit" name="submit" id="submit" value="Print" class="btnclass">
        </div>
        <div class="eight padd0 columns" id="margin1">
            &nbsp;
        </div>
        <div class="clearFix"></div>

</form>
    </div>


</div>
<div class="clearFix"></div>

<!--Slider part ends here-->

<!--footer start -->
<?php //include('footer.php');?>

<script>


function showTabdata(id,name){

       $.post('/display-employee1', {
           'id': id
       }, function (data) {
           $('#searching').hide();
           $('#name').val(name);
            document.getElementById('empid').value=id;
       });
    } 

    function serachemp(val){
			var client = <?php echo $client;?>
			//alert(client);
        $.post('/display-employee2', {
            'name': val,
			'clientid':client
        }, function (data) {
            $('#searching').html(data);
            $('#searching').show();
        });
    }
	 $( function() {
		 $("#tod2").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat:'dd-mm-yy'
            });
            $("#frmd2").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat:'dd-mm-yy'
            });
            
    } );
	function form20validation(){
		$("#frm2onameerror").html("");
		$("#tod2error").html("");
		$("#frmd2error").html("");
		
		var tod2 = $("#tod2").val();
		var frmd2 = $("#frmd2").val();
		var name = $("#name").val();
		if(name ==""){ alert("fdf");
			$("#frm2onameerror").html("Please enter name");
			return false;
		}
		
		if(frmd2 ==""){
			$("#frmd2error").html("Please enter From Date");			
			$("#frmd2error").show();
			return false;
		}
		if(tod2 ==""){ alert("hi");
			$("#tod2error").html("Please enter To Date");
			$("#tod2error").show();
			return false;
		}
		
	}
  </script>
<!--footer end -->

</body>

</html>