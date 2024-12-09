<?php
$doc_path=$_SERVER["DOCUMENT_ROOT"];
include ($doc_path.'/include_payroll_admin.php');

$comp_id=$_SESSION['comp_id'];

error_reporting(0);



?>
<!DOCTYPE html>

<head>

  <meta charset="utf-8"/>



  <!-- Set the viewport width to device width for mobile -->

  <meta name="viewport" content="width=device-width"/>



  <title>Salary | Bank</title>

  
<script>



    function deleterow(id){
        if(confirm('Are you You Sure want to delete this Field?')) {
            $.post('/delete-mast-bank-process', {
                'bid': id
            }, function (data) {
                $('#success').hide();
                $('#editsuccess').hide();
                $("#success1").html('Recourd Delete Successfully');
                $("#success1").show();
                $("#dispaly").load(document.URL + ' #dispaly');
            });
        }
    }
    function clear() {
        $('#berror').html("");
        $('#ad1error').html("");
        $('#ad2error').html("");
        $('#cterror').html("");
        $('#pnerror').html("");
        $('#ifscerror').html("");

    }
  function saveBank() {
      clear();
      var action='Insert';
      $('#success').hide();
        $('#editsuccess').hide();
var name=$("#bname").val();
$("#bname").removeClass('bordererror');
var add=$("#add").val();
$("#add").removeClass('bordererror');
var branch=$("#branch").val();
$("#branch").removeClass('bordererror');
var ifsccode=$("#ifsccode").val();
$("#ifsccode").removeClass('bordererror');
var city=$("#city").val();
$("#city").removeClass('bordererror');
var pincode=$("#pincode").val();
$("#pincode").removeClass('bordererror');
	   if(name ==""){
	   $("#bname").focus();
	   error ="Please Enter the Bank Name";
	   $("#bname").val('');
	   $("#bname").addClass('bordererror');
	   $("#bname").attr("placeholder", error);
	   return false;
	}else if(add ==""){
	   $("#add").focus();
	   error ="Please Enter the address 1";
	   $("#add").val('');
	   $("#add").addClass('bordererror');
	   $("#add").attr("placeholder", error);
	   return false;
	}
	else if(branch ==""){
	   $("#branch").focus();
	   error ="Please Enter the address 2";
	   $("#branch").val('');
	   $("#branch").addClass('bordererror');
	   $("#branch").attr("placeholder", error);
	   return false;
	}
	else if(branch ==""){
	   $("#branch").focus();
	   error ="Please Enter the branch";
	   $("#branch").val('');
	   $("#branch").addClass('bordererror');
	   $("#branch").attr("placeholder", error);
	   return false;
	}else if(ifsccode ==""){
	   $("#ifsccode").focus();
	   error ="Please Enter the IFSC Code";
	   $("#ifsccode").val('');
	   $("#ifsccode").addClass('bordererror');
	   $("#ifsccode").attr("placeholder", error);
	   return false;
	}else if(city ==""){
	   $("#city").focus();
	   error ="Please Enter the City Name";
	   $("#city").val('');
	   $("#city").addClass('bordererror');
	   $("#city").attr("placeholder", error);
	   return false;
	}else if(pincode ==""){
	   $("#pincode").focus();
	   error ="Please Enter the PIN Code";
	   $("#pincode").val('');
	   $("#pincode").addClass('bordererror');
	   $("#pincode").attr("placeholder", error);
	   return false;
	}
      else {

              $.post('/add-mast-bank-process',{
                  'name':name,
                  'add':add,
                  'branch':branch,
                  'pincode':pincode,
                  'city':city,
                  'ifsccode':ifsccode,
                  'action':action

              },function(data){

                  $('#error').hide();
                  $("#success").html('Record Insert Successfully<br/><br/>');
                  $("#success").html(data);
                  $("#success").show();
                  $("#form").trigger('reset');
                  $("#dispaly").load(document.URL +  ' #dispaly');


              });

      }

  }
  
  function updateBank() {
      clear();
      var action='Update';
       $('#success').hide();
        $('#editsuccess').hide();
var name=$("#editbname").val();
var bid=$("#bid").val();
$("#editbname").removeClass('bordererror');
var add=$("#editadd").val();
$("#editadd").removeClass('bordererror');
var branch=$("#editbranch").val();
$("#editbranch").removeClass('bordererror');
var ifsccode=$("#editifsccode").val();
$("#editifsccode").removeClass('bordererror');
var city=$("#editcity").val();
$("#editcity").removeClass('bordererror');
var pincode=$("#editpincode").val();
$("#editpincode").removeClass('bordererror');
	   if(name ==""){
	   $("#editbname").focus();
	   error ="Please Enter the Bank Nam";
	   $("#editbname").val('');
	   $("#editbname").addClass('bordererror');
	   $("#editbname").attr("placeholder", error);
	   return false;
	}else if(add ==""){
	   $("#editadd").focus();
	   error ="Please Enter the address 1";
	   $("#editadd").val('');
	   $("#editadd").addClass('bordererror');
	   $("#editadd").attr("placeholder", error);
	   return false;
	}
	else if(branch ==""){
	   $("#editbranch").focus();
	   error ="Please Enter the address 2";
	   $("#editbranch").val('');
	   $("#editbranch").addClass('bordererror');
	   $("#editbranch").attr("placeholder", error);
	   return false;
	}
	else if(branch ==""){
	   $("#editbranch").focus();
	   error ="Please Enter the branch";
	   $("#editbranch").val('');
	   $("#editbranch").addClass('bordererror');
	   $("#editbranch").attr("placeholder", error);
	   return false;
	}else if(ifsccode ==""){
	   $("#editifsccode").focus();
	   error ="Please Enter the IFSC Code";
	   $("#editifsccode").val('');
	   $("#editifsccode").addClass('bordererror');
	   $("#editifsccode").attr("placeholder", error);
	   return false;
	}else if(city ==""){
	   $("#editcity").focus();
	   error ="Please Enter the City Name";
	   $("#editcity").val('');
	   $("#editcity").addClass('bordererror');
	   $("#editcity").attr("placeholder", error);
	   return false;
	}else if(pincode ==""){
	   $("#editpincode").focus();
	   error ="Please Enter the PIN Code";
	   $("#editpincode").val('');
	   $("#editpincode").addClass('bordererror');
	   $("#editpincode").attr("placeholder", error);
	   return false;
	}
	  else {
              $.post('/add-mast-bank-process',{
                 'bid':bid,
                  'name':name,
                  'add':add,
                  'branch':branch,
                  'pincode':pincode,
                  'city':city,
                  'ifsccode':ifsccode,
                  'action':action
              },function(data){
				 //alert(data);
                  $('#error').hide();
                  $("#editsuccess").html(data);
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
        <div class="twelve" id="margin1"><h3>Add Bank</h3></div>



        <div class="clearFix"></div>
        <div class="boxborder" id="addBank">
        <form id="form">
        <div class="twelve" id="margin1">
            

            <div class="clearFix"></div>
            <div class="one padd0 columns">
            <span class="labelclass">Name :</span>
            </div>
            <div class="four padd0 columns">
                <input type="text" name="bname" id="bname" placeholder="Bank Name" class="textclass">
                <span class="errorclass hidecontent" id="berror"></span>
            </div>
            <div class="two padd0 columns">

            </div>
            <div class="one padd0 columns">
                <span class="labelclass">Address :</span>
            </div>
            <div class="four padd0 columns">
                <textarea class="textclass" id="add" name="add"  placeholder="Address"></textarea>
                <span class="errorclass hidecontent" id="ad1error"></span>
            </div>
            <div class="clearFix"></div>

            <div class="one padd0 columns" id="margin1">
                <span class="labelclass">Branch :</span>
            </div>
            <div class="four padd0 columns" id="margin1">
                <input type="text" class="textclass"  id="branch" name="branch" placeholder="Branch ">
                <span class="errorclass hidecontent" id="brerror"></span>
            </div>
            <div class="two padd0 columns">

            </div>
            <div class="one padd0 columns" id="margin1">
                <span class="labelclass"> IFSC CODE :</span>
            </div>
            <div class="four padd0 columns" id="margin1">
                <input type="text" name="ifsccode" id="ifsccode" placeholder="IFSC Code" class="textclass">
                <span class="errorclass hidecontent" id="ifscerror"></span>
            </div>
            <div class="clearFix"></div>

            <div class="one padd0 columns" id="margin1">
                <span class="labelclass"> City :</span>
            </div>
            <div class="four padd0 columns" id="margin1">
                <input type="text" name="city" id="city" placeholder="City" class="textclass">
                <span class="errorclass hidecontent" id="cterror"></span>
            </div>
            <div class="two padd0 columns">

            </div>
            <div class="one padd0 columns" id="margin1">
                <span class="labelclass">PIN Code :</span>
            </div>
            <div class="four padd0 columns" id="margin1">
                <input type="text" name="pincode" id="pincode" placeholder="PIN Code" class="textclass">
                <span class="errorclass hidecontent" id="pnerror"></span>
            </div>
            <div class="clearFix"></div>


             <div class="one padd0 columns" id="margin1">
            </div>
            <div class="three padd0 columns" id="margin1">
                <input type="button" name="submit" id="submit" value="Save" class="btnclass" onclick="saveBank();">
            </div>
            <div class="eight padd0 columns" id="margin1">
                &nbsp;
            </div>
            <div class="twelve padd0 columns successclass hidecontent" id="success">


            </div>
            <div class="clearFix"></div>

            </form>
        </div>  </div>
         <div  id="editBank">  </div>
        <div class="twelve" id="margin1">
            <h3>Display Bank</h3>
        </div>
         <hr>
    <span class="successclass hidecontent" id="success"></span>
        <div class="twelve" id="margin1" style="background-color: #fff;" >
       <div id="dispaly">
           
            <table id="example" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th align="left" width="5%">Sr.No</th>
                        <th align="left" width="25%">Name</th>

                        <th align="left" width="10%">Branch</th>
                        <th align="left" width="20%">Address</th>

                        <th align="left" width="10%">City</th>
                        <th align="left" width="10%">IFSC Code</th>
                        <th align="left" width="10%">PIN Code</th>

                        <th align="center" width="10%">Action</th>

                    </tr>
                </thead>
                <?php
                
                $result = $payrollAdmin->showBank($comp_id);
                $total_results = sizeof($result);

                $count=1;
                foreach($result as $row){

                ?>

                    <tr>
                        <td align="center"><?php echo $count;?></td>
                        <td class="tdata"><?=$row['bank_name'];?></td>
                        <td class="tdata"><?=$row['branch'];?></td>
                        <td class="tdata"><?=$row['add1'];?></td>
                        <td class="tdata"><?=$row['city'];?></td>
                        <td class="tdata"><?=$row['ifsc_code'];?></td>
                        <td class="tdata"><?=$row['pin_code'];?></td>
                        <td class="tdata" align="center">  <a onclick="editBankFun('<?=$row['mast_bank_id'];?>');" >
                    <img src="Payroll/images/edit-icon.png" /></a>
                    <!--<a href="javascrip:void()" onclick="deleterow(<?=$row['mast_bank_id'];?>)">
                                <img src="Payroll/images/delete-icon.png" /></a>-->
                    
                    </td>
                    

                    </tr>
                <?php
                    $count++;
                } ?>
                
            </table>
               
           </DIV>







</div>


</div>
<br/>
 </div>
<!--Slider part ends here-->
<div class="clearFix"></div>

<!--footer start -->
<?php include('footer.php');?>


<!--footer end -->
<script>
  function editBankFun(id) {
       $.post('/edit-mast-bank', {
                'bid': id
            }, function (data) {
				$("#addBank").hide();
				$("#editBank").html(data);
				$("#editBank").show();
                	$("#editbname").focus();
                	
            });

    }
</script>
</body>

</html>