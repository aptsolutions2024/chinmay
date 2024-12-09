<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');
$comp_id=$_SESSION['comp_id'];
$resultIncome = $payrollAdmin->showIncomehead($comp_id);


$user_id=$_SESSION['log_id'];
$result11=$payrollAdmin->showClient1($comp_id,$user_id);
$rescalin=$payrollAdmin->showCalType("caltype_income");
?>
<!DOCTYPE html>
<head>
  <meta charset="utf-8"/>
  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width"/>
    <title>Salary | Import Income</title>

    <script>

function clearer()
{
    $("#errormsg1").text('');
    $("#errormsg2").text('');
    $("#errormsg3").text('');
}
        function validation() {
            clearer();
            var error ='';
        var file=$("#file").val();
       $("#file").removeClass('bordererror');
       var incomeid=$("#incomeid").val();
       $("#incomeid").removeClass('bordererror');
       var caltype=$("#caltype").val();
       $("#caltype").removeClass('bordererror');
            if(incomeid=="0"){
               $("#incomeid").focus();
	   error ="Please Select the Income";
	   $("#incomeid").val('');
	   $("#incomeid").addClass('bordererror');
	   $("#incomeid").attr("placeholder", error);
                return false;
            } else if(caltype=="0"){
                $("#caltype").focus();
        	   error ="Please Select the Calculation Typee";
        	   $("#caltype").val('');
        	   $("#caltype").addClass('bordererror');
        	   $("#caltype").attr("placeholder", error);
                        return false;
                    } else if(file ==""){
                $("#file").focus();
        	   error ="Please Select the file";
        	   $("#file").val('');
        	   $("#file").addClass('bordererror');
        	   $("#file").attr("placeholder", error);
                return false;
            }
        }
        function expton(val){
            if(val!='0'){
                $('#expid').show();
                var a = document.getElementById('linkId'); //or grab it by tagname etc
                a.href = "/export-emp-income?cid="+val;
            }else{
                $('#expid').hide();

            }
        }
        
        function updateCurrentMonth() {
          var select = document.getElementById('clientid');
          var selectedOption = select.options[select.selectedIndex];
          var currentMonth = selectedOption.getAttribute('data-current-month');
          document.getElementById('current-month').textContent = currentMonth;
        }
    </script>

</head>
 <body>

<!--Header starts here-->
<?php include('header.php');?>
<!--Header end here-->
<div class="clearFix"></div>
<!--Menu starts here-->



<!--Menu ends here-->
<div class="clearFix"></div>
<!--Slider part starts here-->

<div class="twelve mobicenter innerbg">
    <div class="row">
        <div class="twelve padd0" id="margin1"> <h3>Employee Income Import</h3></div>
        <div class="clearFix"></div>

<div class="boxborder" style="min-height: 100px;">

        <div class="twelve padd0" id="margin1"> <h4>Step No.1</h4></div>

        <div class="twelve" >

            <div class="two padd0 columns"  id="margin1">
                <span class="labelclass">Client :</span>
            </div>
          <div class="four padd0 columns" id="margin1" style="display: inline-block; vertical-align: middle;">
    <select id="clientid" name="clientid" class="textclass" onclick="expton(this.value); updateCurrentMonth();">
        <option value="0">--select--</option>
        <?php foreach($result11 as $row1) { ?>
            <option value="<?php echo $row1['mast_client_id']; ?>" data-current-month="<?php echo date('F Y', strtotime($row1['current_month'])); ?>">
                <?php echo $row1['client_name']; ?> - <?php echo date('F Y', strtotime($row1['current_month'])); ?>
            </option>
        <?php } ?>
    </select>
    <h5 style="color:#7d1a15;">Month: <span id="current-month">--select--</span></h5>
</div>

            <div class="six columns" id="margin1" align="center" >
                <div class=" hidecontent " id="expid">
                    <a id="linkId" class="switch" href="">Export to Data Employee Income and Format </a>
                </div>
            </div>

            <div class="clearFix"></div>


        </div>
        
        <div class="clearFix"></div>
        <br/>

        <div class="twelve padd0" id="margin1"> <h4>Step No.2</h4></div>
        <br/>
        <form name="frm" action="/import-emp-income-process" method="post"  enctype="multipart/form-data" onsubmit="return validation();">


        <div class="twelve" >
            <div class="two padd0 columns">
                Income :
            </div>
            <div class="four columns">
                <select id="incomeid" name="incomeid" class="textclass" >
                    <option value="0">--select-</option>
                    <?php
                    foreach($resultIncome as $rowin)
                    {
                        ?>

                        <option value="<?php echo $rowin['mast_income_heads_id'];?>"><?php echo $rowin['income_heads_name'];?></option>
                    <?php }

                    ?>
                </select>
                <span class="errorclass hidecontent" id="errormsg1"></span>
                  </div>
            <div class="two columns">
                <span class="labelclass">Calculation Type :</span>
            </div>
            <div class="four  columns">
                <select  name="caltype" id="caltype" class="textclass">
                    <option value="0">--select-</option>
                   <?php
                   foreach($rescalin as $rowcalin) {?>
                        <option value="<?php echo $rowcalin['id']; ?>"><?php echo $rowcalin['name']; ?></option>

                    <?php } ?>
                </select>
                <span class="errorclass hidecontent" id="errormsg2"></span>
            </div>

            <div class="clearFix"></div>
            <div class="two padd0 columns">
                Upload CSV File
            </div>
            <div class="four  columns">
                <input type="file" name="file" id="file" class="textclass">
                <span class="errorclass hidecontent" id="errormsg3"></span>
            </div>
        </div>
            <div class="clearFix"></div>
            <div class="twelve" >
                <div class="two columns">
                   &nbsp;
                </div>
                <div class="four  columns">
                    <input type="submit" name="submit" id="submit" value="Upload" class="btnclass" >
                </div>
                <div class="six columns">


                </div>
            </div>

        </form>
        <div class="clearFix"></div>




    </div>

</div>
</div>

<!--Slider part ends here-->
<div class="clearFix"></div>

<!--footer start -->
<?php include('footer.php');?>


<!--footer end -->

</body>

</html>