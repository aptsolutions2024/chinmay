<?php
$doc_path=$_SERVER["DOCUMENT_ROOT"];
include ($doc_path.'/include_payroll_admin.php');

$comp_id=$_SESSION['comp_id'];

$result = $payrollAdmin->showOtherPayment($comp_id);
$total_results = sizeof($result);

?>
<!DOCTYPE html>

<head>
  <meta charset="utf-8"/>
      <!-- Set the viewport width to device width for mobile -->

  <meta name="viewport" content="width=device-width"/>



  <title>Salary | Other Payment</title>

  <!-- Included CSS Files -->

  <link rel="stylesheet" href="../css/responsive.css">

  <link rel="stylesheet" href="../css/style.css">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
<script>



    function deleterow(id) {
        if(confirm('Are you You Sure want to delete this Field?')) {
            $.post('/delete-mast-other-payment-process', {
                'did': id
            }, function (data) {
                $('#success').hide();
                $('#error').hide();
//            $("#success1").html('Recourd Delete Successfully');
                $("#success1").html(data);
                $("#success1").show();
                $("#dispaly").load(document.URL + ' #dispaly');
            });
        }
    }
    function clear() {
        $('#dnerror').html("");
   }
  function saveOtherPayment() {
      clear();
      $('#success1').hide();
        var name=$("#dname").val();
        var action='Insert';
	   $("#dname").removeClass('bordererror');
     
        if(name ==""){
	   $("#dname").focus();
	   error ="Please Enter the Other Payment Name";
	   $("#dname").val('');
	   $("#dname").addClass('bordererror');
	   $("#dname").attr("placeholder", error);
	   return false;
	}  else {

              $.post('/add-mast-other-payment-process',{
                  'name':name,
                  'action':action
              },function(data){
                  $('#error').hide();
                 $("#success").html('Record Insert Successfully<br/><br/>');
                  $("#success").show();
                  $("#form").trigger('reset');
                  $("#dispaly").load(document.URL +  ' #dispaly');
              });

      }

  }
  
  function updateOtherPayment() {
      clear();
      $('#success1').hide();
       var name=$("#editdname").val();
       var action='Update';
       var did=$("#did").val();
	   $("#editdname").removeClass('bordererror');
	   if(name ==""){
	   $("#editdname").focus();
	   error ="Please Enter the Department Name";
	   $("#editdname").val('');
	   $("#editdname").addClass('bordererror');
	   $("#editdname").attr("placeholder", error);
	   return false;
	}  else {
		$.post('/add-mast-other-payment-process',{
                  'name':name,
                  'did':did,
                  'action':action
              },function(data){
				 // alert(data);
                  $('#success').hide();
                 $("#editsuccess").html('Record Updated Successfully<br/><br/>');
                  $("#editsuccess").show();
                $("#dispaly").load(document.URL +  ' #dispaly');
              });

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
        <div class="twelve" id="margin1"><h3>Add Other Payment</h3></div>



        <div class="clearFix"></div>
        <div class="boxborder" id="addPayment">
        <form id="form">
        <div class="twelve" id="margin1">
            <div class="twelve padd0 columns successclass hidecontent" id="success">


            </div>

            <div class="clearFix"></div>
            <div class="one padd0 columns">
            <span class="labelclass">Name :</span>
            </div>
            <div class="four padd0 columns">
                <input type="text" name="dname" id="dname" placeholder="Add Other Payment" class="textclass">
                <span class="errorclass hidecontent" id="dnerror"></span>
            </div>
            <div class="two padd0 columns">

            </div>
            <div class="one padd0 columns">

            </div>
            <div class="four padd0 columns">

            </div>
            <div class="clearFix"></div>



             <div class="one padd0 columns" id="margin1">
            </div>
            <div class="three padd0 columns" id="margin1">
                <input type="button" name="submit" id="submit" value="Save" class="btnclass" onclick="saveOtherPayment();">
            </div>
            <div class="eight padd0 columns" id="margin1">
                &nbsp;
            </div>
            <div class="clearFix"></div>

            </form>
             </div>
		
        </div>
        <div id="editPayments"></div>
        <div class="twelve" id="margin1">
            <h3>Display Other Payment</h3>
        </div>
         <hr>
    <span class="successclass hidecontent" id="success1"></span>
        <div class="twelve" id="margin1" style="background-color: #fff;" >

            <div id="dispaly">
            <table id="example" class="display" style="width:100%">
                 <thead>
                    <tr>
                        <th align="left" width="10%">Sr.No</th>
                        <th align="left" width="80%">Name</th>


                        <th align="center" width="10%">Action</th>

                    </tr>
                 </thead>
               
                <?php
                $count=1;
                foreach($result as $row){

                ?>

                    <tr>
                        <td class="tdata"><?php echo $count;?></td>
                        <td class="tdata"><?=$row['op_name'];?></td>

                        <td class="tdata" align="center">  <a onclick="editPaymentFun('<?=$row['op_id'];?>');">
                                <img src="Payroll/images/edit-icon.png" /></a>
                            <!--<a href="javascrip:void()" onclick="deleterow('<?=$row['op_id'];?>')">
                                <img src="Payroll/images/delete-icon.png" /></a>-->
                                </td>

                    </tr>
                <?php
                    $count++;
                } ?>
                
                
            </table>
                
            </div>







</div>

</div>
</div>
<br/>
<!--Slider part ends here-->
<div class="clearFix"></div>

<!--footer start -->
<?php include('footer.php');?>


<!--footer end -->
<script>
  function editPaymentFun(id) {
       $.post('/edit-mast-other-payment', {
                'id': id
            }, function (data) {
               //alert(data);
				$("#addPayment").hide();
				$("#editPayments").html(data);
				$("#editPayments").show();
                
            });

    }
</script>
</body>

</html>