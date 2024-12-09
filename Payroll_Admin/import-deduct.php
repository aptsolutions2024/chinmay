<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

$comp_id=$_SESSION['comp_id'];
$resultdest = $payrollAdmin->showDeductionhead($comp_id);
//$resultIncome = $payrollAdmin->showIncomehead($comp_id);


$user_id=$_SESSION['log_id'];
$result11=$payrollAdmin->showClient1($comp_id,$user_id);
$rescalde=$payrollAdmin->showCalType("caltype_deduct");
?>
<!DOCTYPE html>
<head>
  <meta charset="utf-8"/>
  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width"/>
    <title>Salary | Import Deduct</title>

    <script>
    function updateCurrentMonth() {
      var select = document.getElementById('clientid');
      var selectedOption = select.options[select.selectedIndex];
      var currentMonth = selectedOption.getAttribute('data-current-month');
      document.getElementById('current-month').textContent = currentMonth;
    }
        function clearer()
        {
            $("#errormsg1").text('');
            $("#errormsg2").text('');
            $("#errormsg3").text('');
        }
        function validation() {
            clearer();
            var error ='';

            var file = document.getElementById('file').value;
            var deductid = document.getElementById('deductid').value;
            var decaltype = document.getElementById('decaltype').value;
            
               var file=$("#file").val();
               $("#file").removeClass('bordererror');
               var deductid=$("#deductid").val();
               $("#deductid").removeClass('bordererror');
               var decaltype=$("#decaltype").val();
               $("#decaltype").removeClass('bordererror');
            
            if(deductid=="0"){
                $("#deductid").focus();
	   error ="Please Select the Deduct";
	   $("#deductid").val('');
	   $("#deductid").addClass('bordererror');
	   $("#deductid").attr("placeholder", error);
                return false;
            } else if(decaltype=="0"){
                $("#decaltype").focus();
	   error ="Please Select the Calculation Type";
	   $("#decaltype").val('');
	   $("#decaltype").addClass('bordererror');
	   $("#decaltype").attr("placeholder", error);
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
                a.href = "/export-emp-deduct?cid="+val;
            }else{
                $('#expid').hide();

            }
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
        <div class="twelve padd0" id="margin1"> <h3>Employee Deduct Import </h3></div>
        <div class="clearFix"></div>
<div class="boxborder" style="min-height: 100px;">

        <div class="twelve padd0" id="margin1"> <h4>Step No.1</h4></div>
        <br/>



        <div class="twelve" >

            <div class="two padd0 columns"  id="margin1">
                <span class="labelclass">Client :</span>
            </div>
            <div class="four padd0 columns" id="margin1">
                <select id="clientid" name="clientid" class="textclass" onclick="expton(this.value);updateCurrentMonth();">
                    <option value="0">--select--</option>
                    <?php
                    foreach($result11 as $row1)
                    {
                        ?>

                       <option value="<?php echo $row1['mast_client_id']; ?>" data-current-month="<?php echo date('F Y', strtotime($row1['current_month'])); ?>">
            <?php echo $row1['client_name']; ?> - <?php echo date('F Y', strtotime($row1['current_month'])); ?>
          </option>
          <?php }

                    ?>
                </select>
           <span style="color:#7d1a15;"> Month : <span id="current-month">--select--</span></span>

            </div>
            <div class="six columns" id="margin1" align="center" >
                <div class=" hidecontent " id="expid">
                    <a id="linkId" class="switch" href="">Export to Data Employee Deduct and Format </a>
                </div>
            </div>

            <div class="clearFix"></div>


        </div>
        <div class="clearFix"></div>





        <div class="twelve padd0" id="margin1"> <h4>Step No.2</h4></div>
        <br/>


        <form name="frm" action="/import-emp-deduct-process" method="post"  enctype="multipart/form-data" onsubmit="return validation();">


        <div class="twelve" >
            <div class="two padd0 columns">
                Deduct :
            </div>
            <div class="three columns">
                <select id="deductid" name="deductid" class="textclass">
                    <option value="0">--select-</option>
                    <?php
                    foreach($resultdest as $rowde)
                    {
                        ?>

                        <option value="<?php echo $rowde['mast_deduct_heads_id'];?>" ><?php echo $rowde['deduct_heads_name'];?></option>
                    <?php }

                    ?>
                </select>
                <span class="errorclass hidecontent" id="errormsg1"></span>
                  </div>
            <div class="two columns">
              &nbsp;
            </div>
            <div class="two columns">
                <span class="labelclass">Calculation Type :</span>
            </div>
            <div class="three columns">
                <select name="decaltype" id="decaltype" class="textclass">
                    <option value="0">--select-</option>
                <?php
                foreach($rescalde as $rowcalde)
                {?>
                        <option value="<?php echo $rowcalde['id']; ?>"><?php echo $rowcalde['name']; ?></option>

                    <?php } ?>
                </select>

                <span class="errorclass hidecontent" id="errormsg2"></span>
            </div>

            <div class="clearFix"></div>
            <div class="two padd0 columns">
                Upload CSV File
            </div>
            <div class="three columns">
                <input type="file" name="file" id="file" class="textclass">
                <span class="errorclass hidecontent" id="errormsg3"></span>
            </div>
            <div class="two columns">
                &nbsp;
            </div>
            <div class="five columns">
                &nbsp;
            </div>
            <div class="clearFix"></div>
        </div>
            <div class="clearFix"></div>
            <div class="twelve" >
                <div class="two columns">
        &nbsp;
                </div>
                <div class="four  columns">
                    <input type="submit" name="submit" id="submit" value="Upload" class="btnclass" >
                </div>
                <div class="four columns">


                </div>
                <div class="one columns">

                </div>
                <div class="three columns">

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