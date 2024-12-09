<?php
session_start();

if(isset($_REQUEST['cid'])&&$_REQUEST['cid']!='') {
    $cid = $_REQUEST['cid'];
    $_SESSION['tempcid'] = $cid;
}
else{
    $cid = $_SESSION['tempcid'];
}

$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

$result1=$payrollAdmin->displayClient($cid);

$result = $payrollAdmin->showClient1($comp_id,$user_id);
$total_results = sizeof($result);


//print_r($_REQUEST);exit;
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];

// $result11 = $payrollAdmin->showClient1($comp_id,$user_id);
$result11 = $payrollAdmin->showClientGroup();
//echo "<pre>";print_r($result1);echo "</pre>";

?>
</head>
 <body>
     <div class="boxborder">
<form id="form">
                <input type="hidden" id="cid" name="cid" value="<?php echo $result1['mast_client_id'];?>">
        <div class="clearFix"></div>


        
            <div class="one padd0 columns">
            <span class="labelclass">Name :</span>
            </div>
            <div class="four padd0 columns">
                <input type="text" name="cname" id="editcname" placeholder="Client Name" class="textclass" value="<?php echo $result1['client_name'];?>">
            </div>
                    <div class="two columns">

                    </div>

                    <div class="one columns">
                        <span class="labelclass">Address 1 :</span>
                    </div>
                    <div class="four padd0 columns" >
                        <textarea class="textclass" id="editadd1" name="editadd1"  placeholder="Address 1"><?php echo $result1['client_add1'];?></textarea>
                    </div>
           
            <div class="clearFix"></div>
            <!--------------Start Parent Yes/No------------------------>
           
              
                <div class="one padd0 columns">
                        <span class="labelclass">Group ID :</span>
                </div>
                <div class="four padd0 columns" >
                    <select id="editparent" name="parent" class="textclass">
                       
                        <?php foreach($result11 as $row1){            ?>
                            <option value="<?php echo $row1['id'];?>" <?php if($result1['group_id']==$row1['id']){ echo "selected"; }?>><?php echo $row1['group_name'];?></option>
                        <?php }                        ?>
                    </select>
                    </div>
                <div class="two columns">

                </div>
               
        
           
            <div class="one columns" id="margin1">
                    <span class="labelclass">  ESI CODE :</span>
            </div>
            <div class="four padd0 columns" id="margin1">
                    <input type="text" name="esicode" id="editesicode" placeholder="ESI Code" class="textclass" value="<?php echo $result1['esicode'];?>">
            </div>
         
               <div class="clearFix"></div>

          
     
           <div class="twelve" id="margin1">
                    <div class="one padd0 columns">
                        <span class="labelclass"> PFCODE :</span>
                    </div>
                    <div class="four padd0 columns">
                        <input type="text" name="pfcode" id="editpfcode" placeholder="PF Code" class="textclass" value="<?php echo $result1['pfcode'];?>">
                    </div>
               <div class="two columns">

               </div>

                    <div class="one  columns">
                        <span class="labelclass">TAN No :</span>
                    </div>
                    <div class="four padd0 columns">
                        <input type="text" name="tanno" id="edittanno" placeholder="TAN No" class="textclass" value="<?php echo $result1['tanno'];?>">
                    </div>                                          &nbsp;
            </div>
            <div class="clearFix"></div>
                <div class="twelve" >
                    <div class="one padd0 columns">
                        <span class="labelclass">PAN No :</span>
                    </div>
                    <div class="four  padd0 columns">
                        <input type="text" name="panno" id="editpanno" placeholder="PAN No" class="textclass" value="<?php echo $result1['panno'];?>">
                    </div>
                    <div class="two columns">

                    </div>

                    <div class="one columns">
                        <span class="labelclass"> GST No :</span>
                    </div>
                    <div class="four padd0 columns">
                        <input type="text" name="gstno" id="editgstno" placeholder="GST No" class="textclass" value="<?php echo $result1['gstno'];?>">
                    </div>
                </div>
            <div class="clearFix"></div>


                    <div class="one padd0 columns" id="margin1">
                        <span class="labelclass">Month :</span>
                    </div>
                    <div class="four padd0 columns" id="margin1">
                        <input type="text" name="cm" id="editcm" placeholder="Current Month" class="textclass"  value="<?php echo $result1['current_month'];?>">
                        <span class="editerrorclass hidecontent" id="editcmediterror"></span>
                    </div>
                    <div class="two columns">

                    </div>
                    <div class="one  columns" id="margin1">
                        <span class="labelclass">Email Id:</span>
                    </div>
                    <div class="four padd0 columns" id="margin1">
                        <input type="text" name="email" id="editemail" placeholder="Enter the Email Id" class="textclass"  value="<?php echo $result1['email'];?>">
                    </div>

                    <div class="clearFix"></div>
                    <div class="one padd0 columns" id="margin1">
                        <span class="labelclass">Charges :</span>
                    </div>
                    <div class="four padd0 columns" id="margin1">
                        <input type="text" name="sc" id="editsc" placeholder="Services Charges" class="textclass"  value="<?php echo $result1['ser_charges'];?>">

                    </div>
                    
     <div class="two padd0 columns" id="margin1" style="margin-left: 213px;">
    <span class="labelclass" style="margin-right: 10px;">Day Wise Details:</span>
</div>
<div class="two padd0 columns" id="margin1">
    <div style="display: flex; align-items: center; margin-right: 20px;">
        <!-- Set 'checked' based on the value in $result1['daywise_details'] -->
        <label style="margin-right: 10px;">
            <input type="radio" name="daywise_details" value="Y" <?php echo ($result1['daywise_details'] == 'Y') ? 'checked' : ''; ?> > Yes
        </label>
        <label style="margin-right: 10px;">
            <input type="radio" name="daywise_details" value="N" <?php echo ($result1['daywise_details'] == 'N') ? 'checked' : ''; ?> > No
        </label>
    </div>
</div>

          <div class="clearFix"></div>

           <!-- Added by saksi on 28-10-24 -->
     
           <div class="twelve" id="margin1">
                    <div class="one padd0 columns">
                        <span class="labelclass"> LWF Number :</span>
                    </div>
                    <div class="four padd0 columns">
                        <input type="text" name="lwf_no" id="editlwf_no" placeholder="lwf number" class="textclass" value="<?php echo $result1['lwf_no'];?>">
                    </div>
               <div class="two columns">

               </div>
            </div>                
                    <div class="two columns">

                    </div>
                    <div class="one padd0 columns" id="margin1">

                    </div>
                    <div class="four padd0 columns" id="margin1">

                    </div>

                    <div class="clearFix"></div>



                    <div class="one padd0 columns" id="margin1">
            </div>
            <div class="three padd0 columns" id="margin1">
                <input type="button" name="submit" id="submit" value="Update" class="btnclass" onclick="update();">
            </div>
            <div class="eight padd0 columns" id="margin1">
                &nbsp;
            </div>
            <div class="clearFix"></div>

            <div class="four padd0 columns" id="margin1">
                <span class="editerrorclass hidecontent" id="editerror"></span>
                <span class="successclass hidecontent" id="editsuccess"></span>
            </div>
            <div class="eight padd0 columns" id="margin1">
                &nbsp;
            </div>
            </form></div>
        