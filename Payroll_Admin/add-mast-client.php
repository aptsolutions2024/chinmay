<?php
session_start();
$doc_path=$_SERVER["DOCUMENT_ROOT"];
include ($doc_path.'/include_payroll_admin.php');

$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$result1 = $payrollAdmin->showClientGroup();

$result = $payrollAdmin->showClient1($comp_id,$user_id);
$total_results = sizeof($result);


?>
<!DOCTYPE html>

<head>

  <meta charset="utf-8"/>



  <!-- Set the viewport width to device width for mobile -->

  <meta name="viewport" content="width=device-width"/>



  <title>Salary | Client</title>

  <!-- Included CSS Files -->

  <link rel="stylesheet" href="Payroll/css/responsive.css">

  <link rel="stylesheet" href="Payroll/css/style.css">
  <link rel="stylesheet" href="Payroll/css/jquery-ui.css">
    <script type="text/javascript" src="Payroll/js/jquery.min.js"></script>
    <script type="text/javascript" src="Payroll/js/jquery-ui.js"></script>


    <script>
        $( function() {
            $("#cm").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat:'dd-mm-yy'
            });
        } );



    function deleterow(id) {
        if(confirm('Are you You Sure want to delete this Field?')) {
            $.get('/delete-mast-client-process', {
                'cid': id
            }, function (data) {
                $('#success').hide();
                $('#error').hide();
                $("#success1").html('Recourd Delete Successfully');
                $("#success1").show();
                $("#dispaly").load(document.URL + ' #dispaly');
            });
        }

    }
    function clear() {
        $('#cnerror').html("");
        $('#ad1error').html("");
        $('#pererror').html("");
        $('#esierror').html("");
        $('#pferror').html("");
        $('#tanerror').html("");
        $('#panerror').html("");
        $('#gsterror').html("");
    }
  function save() {
    clear();
    $('#success1').hide();
    var name = $("#cname").val();
    var add1 = $("#add1").val();
    var esicode = $("#esicode").val();
    var pfcode = $("#pfcode").val();
    var tanno = $("#tanno").val();
    var panno1 = $("#panno").val();
    var gstno = $("#gstno").val();
    var lwf_no=$('#lwf_no').val();
    var cm = $("#cm").val();
    var parent = $("#parent").val();
    var sc = $("#sc").val();
    var email = $("#email").val();
    var parent_comp = $("#parent_comp").val();
    var daywise_details = $('input[name="daywise_details"]:checked').val(); 

    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    
    // Clear error classes and placeholders
    $("#cname, #add1, #esicode, #pfcode, #tanno, #panno, #gstno,#lwf_no, #cm, #email, #parent").removeClass('bordererror');
    
    if (name == "") {
        $("#cname").focus().val('').addClass('bordererror').attr("placeholder", "Please Enter the Client Name");
        return false;
    } else if (add1 == "") {
        $("#add1").focus().val('').addClass('bordererror').attr("placeholder", "Please Enter the address 1");
        return false;
    } else if (parent == "") {
        $("#parent").focus().val('').addClass('bordererror').attr("placeholder", "Please select parent");
        return false;
    } else if (!daywise_details) {
        // Check if daywise details is selected
        alert("Please select Day Wise Details");
        return false;
    } else if (esicode == "") {
        $("#esicode").focus().val('').addClass('bordererror').attr("placeholder", "Please Enter the ESI Code");
        return false;
    } else if (pfcode == "") {
        $("#pfcode").focus().val('').addClass('bordererror').attr("placeholder", "Please Enter the PF Code");
        return false;
    } else if (tanno == "") {
        $("#tanno").focus().val('').addClass('bordererror').attr("placeholder", "Please Enter the TAN No");
        return false;
    } else if (panno1 == "") {
        $("#panno").focus().val('').addClass('bordererror').attr("placeholder", "Please Enter the PAN No");
        return false;
    } else if (gstno == "") {
        $("#gstno").focus().val('').addClass('bordererror').attr("placeholder", "Please Enter the GST No");
        return false;
    } else if (cm == "") {
        $("#cm").focus().val('').addClass('bordererror').attr("placeholder", "Please Select Current Month");
        return false;
    } else if (!filter.test(email) && email != "") {
        $("#email").focus().val('').addClass('bordererror').attr("placeholder", "Please enter valid email");
        return false;
    }
    else if (lwf_no == "") {
        $("#lwf_no").focus().val('').addClass('bordererror').attr("placeholder", "Please Enter the LWF No");
        return false;
    } 
    else {
        $.get('/add-mast-client-process', {
            'name': name,
            'add1': add1,
            'esicode': esicode,
            'pfcode': pfcode,
            'tanno': tanno,
            'panno': panno1,
            'gstno': gstno,
            'cm': cm,
            'sc': sc,
            'email': email,
            'parent': parent,
            'parent_comp': parent_comp,
            'lwf_no':lwf_no,
            'daywise_details': daywise_details // Corrected data being passed
        }, function (data) {
            alert(data);
            $('#error').hide();
            $("#success").html(data).show();
            $("#form").trigger('reset');
            location.reload();
        });
    }
}




    </script>
    
    
    <style>
    .highlight {
    background-color:#333;
    cursor:pointer;
    }
    .errorclass {
    color: red;
    font-size: 0.9em;
}

.hidecontent {
    display: none;
}

    </style>
    <script>
document.getElementById('cm').addEventListener('change', function() {
    var cmValue = this.value;
    var errorElement = document.getElementById('cmerror');
    var regex = /^\d{4}-(0[1-9]|1[0-2])$/; // YYYY-MM format
    
    if (!regex.test(cmValue)) {
        errorElement.textContent = "Please enter the date in YYYY-MM format.";
        errorElement.classList.remove('hidecontent');
    } else {
        errorElement.textContent = "";
        errorElement.classList.add('hidecontent');
    }
});
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
	
        <div class="twelve" id="margin1"><h3>Client</h3></div>



        <div class="clearFix"></div>
		<div class="boxborder" id="addclient">
        <form id="form">
        <div class="twelve" id="margin1">
            

            <div class="clearFix"></div>
            <div class="one padd0 columns">
            <span class="labelclass">Name :</span>
            </div>
            <div class="four padd0 columns">
                <input type="text" name="cname" id="cname" placeholder="Client Name" class="textclass">
                <span class="errorclass hidecontent" id="cnerror"></span>
            </div>
            <div class="two columns">

            </div>
            <div class="one columns">
                <span class="labelclass">Address:</span>
            </div>
            <div class="four padd0 columns">
                <textarea class="textclass" id="add1" name="add1"  placeholder="Address"></textarea>
                <span class="errorclass hidecontent" id="ad1error"></span>
            </div>
            <div class="clearFix"></div>

<!--------------Start Parent Yes/No------------------------>
<!--------------End Parent Yes/No------------------------>
    <div class="parent">
            <div class="one padd0 columns" id="margin1">
                <span class="labelclass">Client Group :</span>
            </div>
            <div class="four padd0 columns" id="margin1">
                <select id="parent" name="parent" class="textclass">
                    <option value="">- Not Applicable -</option>
                    <?php
                    foreach($result1 as $row1){         ?>
                        <option value="<?php echo $row1['id'];?>"><?php echo $row1['group_name'];?></option>
                    <?php }

                    ?>
                </select>
                <span class="errorclass hidecontent" id="pererror"></span>
            </div>
            <div class="two columns">

            </div>
        </div>
              <div class="one columns" id="margin1">
                <span class="labelclass">  ESI CODE :</span>
            </div>
            <div class="four padd0 columns" id="margin1">
                <input type="text" name="esicode" id="esicode" placeholder="ESI Code" class="textclass">
                <span class="errorclass hidecontent" id="esierror"></span>
            </div>
               
               <div class="clearFix"></div>


          
            <div class="clearFix"></div>

            <div class="one padd0 columns" id="margin1">
                <span class="labelclass"> PFCODE :</span>
            </div>
            <div class="four padd0 columns" id="margin1">
                <input type="text" name="pfcode" id="pfcode" placeholder="PF Code" class="textclass">
                <span class="errorclass hidecontent" id="pferror"></span>
            </div>
            <div class="two columns">

            </div>
            <div class="one columns" id="margin1">
                <span class="labelclass">TAN No :</span>
            </div>
            <div class="four padd0 columns" id="margin1">
                <input type="text" name="tanno" id="tanno" placeholder="TAN No" class="textclass">
                <span class="errorclass hidecontent" id="tanerror"></span>
            </div>
            <div class="clearFix"></div>

            <div class="one padd0 columns" id="margin1">
                <span class="labelclass">PAN No :</span>
            </div>
            <div class="four padd0 columns" id="margin1">
    <input type="text" name="panno" id="panno" placeholder="PAN No" class="textclass" maxlength="10">
    <span class="errorclass hidecontent" id="panerror"></span>
</div>

            <div class="two columns">

            </div>
            <div class="one columns" id="margin1">
                <span class="labelclass"> GST No :</span>
            </div>
            <div class="four padd0 columns" id="margin1">
                <input type="text" name="gstno" id="gstno" placeholder="GST No" class="textclass" maxlength="15">
                <span class="errorclass hidecontent" id="gsterror"></span>
            </div>

            <div class="clearFix"></div>

            <div class="one padd0 columns" id="margin1">
    <span class="labelclass">Month :</span>
</div>
<div class="four padd0 columns" id="margin1">
    <input type="month" name="cm" id="cm" class="textclass">
    <span class="errorclass hidecontent" id="cmerror"></span>
</div>
            <div class="two columns">

            </div>
            <div class="one columns" id="margin1">
                <span class="labelclass">Email Id:</span>
            </div>
            <div class="four padd0 columns" id="margin1">
                <input type="text" name="email" id="email" placeholder="Enter the Email Id" class="textclass">
            </div>

            <div class="clearFix"></div>
            <div class="one padd0 columns" id="margin1">
                <span class="labelclass">Charges:</span>
            </div>
            <div class="four padd0 columns" id="margin1">
                <input type="text" name="sc" id="sc" placeholder="Services Charges" class="textclass">

            </div>
            <div class="two padd0 columns" id="margin1" style="margin-left: 213px;">
                <span class="labelclass" style="margin-right: 10px;">Day Wise Details:</span>
     
               </div>
            <div class="two padd0 columns" id="margin1">
                    <div style="display: flex; align-items: center; margin-right: 20px;">
                
                <label style="margin-right: 10px;">
                    <input type="radio" name="daywise_details" id="daywise_details" value="Y" > Yes
                </label>
                <label style="margin-right: 10px;">
                    <input type="radio" name="daywise_details" id="daywise_details" value="N" > No
                </label>
                </div>
            </div>

            <div class="clearFix"></div>

            <div class="one padd0 columns" id="margin1">
                <span class="labelclass"> LWF Number :</span>
            </div>
            <div class="four padd0 columns" id="margin1">
                <input type="text" name="lwf_no" id="lwf_no" placeholder="LWF number" class="textclass">
                <span class="errorclass hidecontent" id="lwferror"></span>
            </div>


            <div class="two padd0 columns" id="margin1">

            </div>
            <div class="five padd0 columns" id="margin1">

            </div>

            <div class="clearFix"></div>

             <div class="one padd0 columns" id="margin1">
            </div>
            <div class="four padd0 columns" id="margin1">
                <input type="button" name="submit" id="submit" value="Save" class="btnclass" onclick="save();">
            </div><div class="twelve padd0 columns successclass hidecontent" id="success">
</div>
            <div class="seven padd0 columns" id="margin1">
                &nbsp;
            </div>
            <div class="clearFix"></div>

            </form>
        </div>
        </div>
		<div id="editclient"></div>
        <div class="twelve" id="margin1">
            <h3>Display Client</h3>
        </div>
         <hr>
    <span class="successclass hidecontent" id="success1"></span>
        <div class="twelve" id="margin1" style="background-color: #fff;" >

            <div id="dispaly">
            <table width="100%" id="example" class="display" >
                 <thead>
                    <tr>
                        <th align="left" width="5%">Sr.No</th>
                        <th align="left" width="20%">Name</th>
                        <th align="left" width="20%">Client Group</th>
                        <th align="left" width="20%">Address</th>
                        <th align="left" width="20%">ESI Code</th>
                        <th align="left" width="20%">PAN No</th>
                        <th align="left" width="20%">Date Wise Details</th>
                        <th align="left" width="20%">LWF No.</th>



                        <th align="center" width="10%">Action</th>

                    </tr>
 </thead>
                <?php
                $count=1;
               
                foreach($result as $row){
                   
                    //$parentNm=$payrollAdmin->displayClient($row['group_id']);
                        $parentNm=$payrollAdmin->showGroupClient1($row['group_id']);
                   
                ?>

                    <tr id="reload('<?=$row['mast_client_id'];?>');">
                        <td class="tdata"><?php echo $count;?></td>
                        <td class="tdata"><?=$row['client_name'];?></td>
                         <td class="tdata"><?php if(!empty($parentNm)){  echo $parentNm['group_name']; };?></td>
                        <td class="tdata"><?=$row['client_add1'];?></td>
                          <td class="tdata"><?=$row['esicode'];?></td>
                        <td class="tdata"><?=$row['panno'];?></td>
                        <td class="tdata"><?=$row['daywise_details'];?></td>
                        <td class="tdata"><?=$row['lwf_no'];?></td>
                        <td class="tdata" align="center"> 
						<a  onclick="editMasClient('<?=$row['mast_client_id'];?>');">
                                <img src="Payroll/images/edit-icon.png" /></a>
                            <!--a href="javascrip:void()" onclick="deleterow(<?=$row['mast_client_id'];?>)">
                                <img src="Payroll/images/delete-icon.png" /></a--></td>

                    </tr>
                <?php
                    $count++;
                } ?>
                <?php if($total_results == 0){?>
                <tr align="center">
                    <td colspan="7" class="tdata errorclass">
                        <span class="norec">No Record found</span>
                    </td>
                <tr>
                    <?php }?>
            </table>
               
            </div>







</div>


</div>
<br/>
<!--Slider part ends here-->
<div class="clearFix"></div>

<!--footer start -->
<?php include('footer.php');?>

<script>
    function editMasClient(id) {
       $.post('/edit-mast-client', {
                'cid': id
            }, function (data) {
				$("#addclient").hide();
				$("#editclient").html(data);
				$("#editclient").show();
                	$("#editcname").focus();
            });

    }
    function update() {
      $('#success1').hide();
        var name=$("#editcname").val();
        var add1=$("#editadd1").val();
        var esicode=$("#editesicode").val();
        var pfcode=$("#editpfcode").val();
        var tanno=$("#edittanno").val();
        var panno1=$("#editpanno").val();
        var gstno=$("#editgstno").val();
        var lwf_no =$("#editlwf_no").val();
        var cid=$("#cid").val();
      var cm=$("#editcm").val();
      var parent=$("#editparent").val();
      var sc=$("#editsc").val();
      var email=$("#editemail").val();
      var parent_comp=$("#editparent_comp").val();
      var daywise_details = $('input[name="daywise_details"]:checked').val(); 
      
      
     // var rule = /^[a-zA-Z]*$/;
$("#editcname").removeClass('bordererror');
$("#editadd1").removeClass('bordererror');
$("#editesicode").removeClass('bordererror');
$("#editpfcode").removeClass('bordererror');
$("#edittanno").removeClass('bordererror');
$("#editpanno").removeClass('bordererror');
$("#editgstno").removeClass('bordererror');
$("#cid").removeClass('bordererror');
$("#editcm").removeClass('bordererror');
$("#editparent").removeClass('bordererror');
$("#editsc").removeClass('bordererror');
$("#editemail").removeClass('bordererror');
$("#editlwf_no").removeClass('bordererror');
    if(name ==""){
   $("#editcname").focus();
   error ="Please Enter the Client Name";
   $("#editcname").val('');
   $("#editcname").addClass('bordererror');
   $("#editcname").attr("placeholder", error);
   return false;
}
  else if(add1 ==""){
   $("#editadd1").focus();
   error ="Please Enter the address 1";
   $("#editadd1").val('');
   $("#editadd1").addClass('bordererror');
   $("#editadd1").attr("placeholder", error);
   return false;
} else if(esicode ==""){
   $("#editesicode").focus();
   error ="Please Enter the ESI Code";
   $("#editesicode").val('');
   $("#editesicode").addClass('bordererror');
   $("#editesicode").attr("placeholder", error);
   return false;
}
 else if(pfcode ==""){
   $("#edittanno").focus();
   error ="Please Enter the TAN No";
   $("#edittanno").val('');
   $("#edittanno").addClass('bordererror');
   $("#edittanno").attr("placeholder", error);
   return false;
}
 else if(panno1 ==""){
   $("#editpanno").focus();
   error ="Please Enter the PAN No";
   $("#editpanno").val('');
   $("#editpanno").addClass('bordererror');
   $("#editpanno").attr("placeholder", error);
   return false;
}
 else if(gstno ==""){
   $("#editgstno").focus();
   error ="Please Enter the GST No";
   $("#editgstno").val('');
   $("#editgstno").addClass('bordererror');
   $("#editgstno").attr("placeholder", error);
   return false;
}
else if(lwf_no ==""){
   $("#editlwf_no").focus();
   error ="Please Enter the LWF No";
   $("#editlwf_no").val('');
   $("#editlwf_no").addClass('bordererror');
   $("#editlwf_no").attr("placeholder", error);
   return false;
}
 else if(cm ==""){
   $("#editcm").focus();
   error ="Please Select Current Month";
   $("#editcm").val('');
   $("#editcm").addClass('bordererror');
   $("#editcm").attr("placeholder", error);
   return false;
}
else if (!daywise_details) {
        // Check if daywise details is selected
        alert("Please select Day Wise Details");
        return false;
    }
else {

              $.post('/edit-mast-client-process',{
                  'name':name,
                  'cid':cid,
                  'add1':add1,
                  'esicode':esicode,
                  'pfcode':pfcode,
                  'tanno':tanno,
                  'panno':panno1,
                  'gstno':gstno,
                  'lwf_no':lwf_no,
                  'cm':cm,
                  'sc':sc,
                  'email':email,
                  'parent':parent,
                  'parent_comp':parent_comp,
                  'daywise_details': daywise_details 

              },function(data){ 
                  //alert(data);
                  $('#error').hide();
                  $("#editsuccess").html(data);
                  $("#editsuccess").show();
                  $("#dispaly").load(document.URL +  ' #dispaly');
              });

      }
  

  }
  
 /* function showparent(value){
      if(value=='N'){
         $('.parent').show();
      }else{
         $('.parent').hide(); 
      }
  }*/
</script>
<!--footer end -->

</body>

</html>