<?php$doc_path=$_SERVER["DOCUMENT_ROOT"];include ($doc_path.'/include_payroll_admin.php');$result = $payrollAdmin ->showCategory($comp_id);$total_results = sizeof($result);$comp_id=$_SESSION['comp_id'];?><!DOCTYPE html><head>  <meta charset="utf-8"/>  <!-- Set the viewport width to device width for mobile -->  <meta name="viewport" content="width=device-width"/>  <title>Salary | Category</title>  <!-- Included CSS Files -->  <script>    /*function deleterow(id){        if(confirm('Are you You Sure want to delete this Field?')) {            $.get('/delete-mast-designation-process', {                'id': id            }, function (data) {                $('#success').hide();                $('#error').hide();                $("#success1").html('Recourd Delete Successfully');                $("#success1").show();                $("#dispaly").load(document.URL + ' #dispaly');            });        }    }*/    function clear() {        $('#derror').html("");   }  function saveCategory() {      clear();      var action='Insert';      $('#success1').hide();       var name=$("#dname").val();	   $("#dname").removeClass('bordererror');	   if(name ==""){	   $("#dname").focus();	   error ="Please Enter the Category Name";	   $("#dname").val('');	   $("#dname").addClass('bordererror');	   $("#dname").attr("placeholder", error);	   return false;	} else {              $.post('/add-mast-category-process',{                  'name':name,                  'action':action              },function(data){                  $('#error').hide();                  $("#success").html('Record Insert Successfully<br/><br/>');                  $("#success").show();                  $("#form").trigger('reset');                  $("#dispaly").load(document.URL +  ' #dispaly');             });      }  }     function updateCategory() {      clear();      $('#success1').hide();      var action='Update';       var name=$("#editname").val();       var qid=$("#did").val();	   $("#editname").removeClass('bordererror');	   if(name ==""){	   $("#editname").focus();	   error ="Please Enter the Category Name";	   $("#editname").val('');	   $("#editname").addClass('bordererror');	   $("#editname").attr("placeholder", error);	   return false;	}	  else {              $.post('/add-mast-category-process',{                  'name':name,                  'id':qid,                  'action':action              },function(data){                  $('#error').hide();                  $("#editsuccess").html(data);                  $("#editsuccess").show();                  $("#dispaly").load(document.URL +  ' #dispaly');             });      }  }    </script></head> <body><!--Header starts here--><?php include('header.php');?><!--Header end here--><div class="clearFix"></div><!--Menu starts here--><!--Menu ends here--><div class="clearFix"></div><!--Slider part starts here--><div class="twelve mobicenter innerbg">    <div class="row">        <div class="twelve" id="margin1"><h3>Add Category</h3></div>        <div class="clearFix"></div>		<div class="boxborder" id="addDesig">        <form id="form">        <div class="twelve" id="margin1">                        <div class="clearFix"></div>            <div class="one padd0 columns">            <span class="labelclass">Name :</span>            </div>            <div class="four padd0 columns">                <input type="text" name="dname" id="dname" placeholder="Category Name" class="textclass">                <span class="errorclass hidecontent" id="derror"></span>            </div>            <div class="two padd0 columns">            </div>            <div class="one padd0 columns">            </div>            <div class="four padd0 columns">            </div>            <div class="clearFix"></div>             <div class="one padd0 columns" id="margin1">            </div>            <div class="three padd0 columns" id="margin1">                <input type="button" name="submit" id="submit" value="Save" class="btnclass" onclick="saveCategory();">            </div>            <div class="eight padd0 columns" id="margin1">                &nbsp;            </div>            <div class="twelve padd0 columns successclass hidecontent" id="success">            </div>            <div class="clearFix"></div>            </form>        </div>        </div>		<div id="editDesig"></div>        <div class="twelve" id="margin1">            <h3>Display Categorys</h3>        </div>         <hr>    <span class="successclass hidecontent" id="success1"></span>        <div class="twelve" id="margin1" style="background-color: #fff;" >            <div id="dispaly">            <table id="example" class="display" style="width:100%">                <thead>                    <tr>                        <th align="left" width="10%">Sr.No</th>                        <th align="left" width="80%">Name</th>                        <th align="center" width="10%">Action</th>                    </tr>                 </thead>               <?php                $count=1;                foreach($result as $row){                ?>                                 <tr>                        <td align="center"><?php echo $count;?></td>                        <td class="tdata"><?=$row['mast_category_name'];?></td>                    <td class="tdata" align="center">  <a onclick="editCategory('<?=$row['mast_category_id'];?>');" >                    <img src="Payroll/images/edit-icon.png" /></a>                    <!--<a href="javascrip:void()" onclick="deleterow(<?=$row['mast_category_id'];?>)">                    <img src="Payroll/images/delete-icon.png" /></a>-->                                        </td>                    </tr>                                    <?php                    $count++;                } ?>                           </table>                            </div></div></div></div><br/><!--Slider part ends here--><div class="clearFix"></div><!--footer start --><?php include('footer.php');?><!--footer end --><script>  function editCategory(id) {       $.post('/edit-mast-category', {                'id': id            }, function (data) {				$("#addDesig").hide();				$("#editDesig").html(data);				$("#editDesig").show();                            });    }</script></body></html>