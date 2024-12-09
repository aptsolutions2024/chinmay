<?php
session_start();
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

$comp_id = $_SESSION['comp_id'];
$user_id = $_SESSION['log_id'];
$result = $payrollAdmin->showClient1($comp_id, $user_id);
$total_results = sizeof($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width"/>
    <title>Salary | Client</title>
    <!-- Included CSS Files -->
    <link rel="stylesheet" href="Payroll/css/responsive.css">
    <link rel="stylesheet" href="Payroll/css/style.css">
    <link rel="stylesheet" href="Payroll/css/jquery-ui.css">
    <script src="Payroll/js/jquery.min.js"></script>
    <script src="Payroll/js/jquery-ui.js"></script>
    <style>
    .icon-spacing {
        margin-right: 10px;
    }
</style>
    <script>
        $(function() {
            $("#cm").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'dd-mm-yy'
            });
        });
function editGroupClient(id) {
    console.log("Editing ID: ", id);
   
       $.post('/edit-group-client', {
            'id': id
            }, function (data) {
				$("#addclient").hide();
				$("#editclient").html(data);
				$("#editclient").show();
                
            });

    }
        function deleterow(id) {
            if (confirm('Are you sure you want to delete this field?')) {
                $.get('/delete-mast-client-process', { 'cid': id }, function(data) {
                    $('#success').hide();
                    $('#error').hide();
                    $("#success1").html('Record deleted successfully');
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

        function clearErrors() {
            $('#cnerror, #esierror, #pferror').html('');
            $('#group_name, #esicode, #pfcode,#lwf_no').removeClass('bordererror');
        }

        function save() {
    clearErrors();
    $('#success1').hide();

    var group_name = $("#group_name").val();
    var esicode = $("#esicode").val();
    var pfcode = $("#pfcode").val();
    var lwf_no=$('#lwf_no').val();

    if (group_name === "") {
        $("#group_name").focus().addClass('bordererror').attr("placeholder", "Please enter the client name");
        return false;
    }

    if (esicode === "") {
        $("#esicode").focus().addClass('bordererror').attr("placeholder", "Please enter the ESI code");
        return false;
    }

    if (pfcode === "") {
        $("#pfcode").focus().addClass('bordererror').attr("placeholder", "Please enter the PF code");
        return false;
    }
    if (lwf_no === "") {
        $("#lwf_no").focus().addClass('bordererror').attr("placeholder", "Please enter the LWF Number");
        return false;
    }

    $.post('/add-client-group-process11', {
        'group_name': group_name,
        'esicode': esicode,
        'pfcode': pfcode,
        'lwf_no': lwf_no
    }, function(data) {
        console.log(data);
        $('#error').hide();
        $("#success").html('Record Inserted Successfully').show();
        $("#form").trigger('reset');
        $("#dispaly").load(document.URL + ' #dispaly');
    });
}

    </script>
    <style>
        .highlight {
            background-color: #333;
            cursor: pointer;
        }
    </style>
</head>
<body>

<!--Header starts here-->
<?php include('header.php'); ?>
<!--Header end here-->

<div class="clearFix"></div>

<div class="twelve mobicenter innerbg">
    <div class="row">
        <div class="twelve" id="margin1"><h3>Client Group</h3></div>
        <div class="clearFix"></div>
        <div class="boxborder" id="addclient">
            <form id="form">
                <div class="twelve" id="margin1">
                    
                    <div class="clearFix"></div>
                    <div class="two padd0 columns">
                        <span class="labelclass">Name :</span>
                    </div>
                    <div class="four padd0 columns">
                        <input type="text" name="group_name" id="group_name" placeholder="Group Name" class="textclass">
                        <span class="errorclass hidecontent" id="cnerror"></span>
                    </div>
                    <br>
                    <div class="clearFix"></div>
                    <div class="two padd0 columns" id="margin1">
                        <span class="labelclass">ESI CODE :</span>
                    </div>
                    <div class="four padd0 columns" id="margin1">
                        <input type="text" name="esicode" id="esicode" placeholder="ESI Code" class="textclass">
                        <span class="errorclass hidecontent" id="esierror"></span>
                    </div>
                    <div class="clearFix"></div>
                    <div class="two padd0 columns" id="margin1">
                        <span class="labelclass">PF CODE :</span>
                    </div>
                    <div class="four padd0 columns" id="margin1">
                        <input type="text" name="pfcode" id="pfcode" placeholder="PF Code" class="textclass">
                        <span class="errorclass hidecontent" id="pferror"></span>
                    </div>
                    <div class="clearFix"></div>
                     <!-- Added by saksi on 28-10-24 -->
                    <div class="two padd0 columns" id="margin1">
                        <span class="labelclass">LWF No. :</span>
                    </div>
                    <div class="four padd0 columns" id="margin1">
                        <input type="text" name="lwf_no" id="lwf_no" placeholder="LWF Number" class="textclass">
                        <span class="errorclass hidecontent" id="lwferror"></span>
                    </div>
                    <div class="two columns"></div>
                    <br/>
                    <br/>
                    <div class="four padd0 columns" id="margin1">
                        <input type="button" name="submit" id="submit" value="Save" class="btnclass" onclick="save();">
                    </div>
                    
                    <div class="seven padd0 columns" id="margin1">&nbsp;</div>
                    <div class="twelve padd0 columns successclass hidecontent" id="success"></div>
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
        <div class="twelve" id="margin1" style="background-color: #fff;">
            <div id="dispaly">
                <table width="100%" id="example" class="display">
                    <thead>
                        <tr>
                            <th align="left" width="5%">Sr.No</th>
                            <th align="left" width="20%">Group Name</th>
                            <th align="left" width="20%">PF Code</th>
                            <th align="left" width="20%">ESI Code</th>
                            <th align="left" width="20%">LWF Number</th>
                            <th align="center" width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php
    $count = 1;
    $result = $payrollAdmin->displayClientGroup(); // Fetch all client groups

    foreach ($result as $row) {
        ?>
        <tr id="row_<?= $row['id']; ?>">
            <td class="tdata"><?php echo $count; ?></td>
            <td class="tdata"><?= htmlspecialchars($row['group_name']); ?></td>
            <td class="tdata"><?= htmlspecialchars($row['pfcode']); ?></td>
            <td class="tdata"><?= htmlspecialchars($row['esicode']); ?></td>
            <td class="tdata"><?= htmlspecialchars($row['lwf_no']); ?></td>
            
             <td class="tdata" align="center"> 
					<a onclick="editGroupClient('<?=$row['id'];?>');" class="icon-spacing">
                       <img src="Payroll/images/edit-icon.png" />
                    </a>
        <!--            <a href="javascript:void(0);" onclick="deleteGroupClient('<?=$row['id'];?>');">-->
        <!--    <img src="Payroll/images/delete-icon.png" alt="Delete" />-->
        <!--</a>-->
                            <!--a href="javascrip:void()" onclick="deleterow(<?=$row['id'];?>)">
                                <img src="Payroll/images/delete-icon.png" /></a--></td>
            
						
                            
                               
        </tr>
        <?php
        $count++;
    }
    if (count($result) == 0) {
        ?>
        <tr align="center">
            <td colspan="5" class="tdata errorclass">
                <span class="norec">No record found</span>
            </td>
        </tr>
    <?php } ?>
</tbody>

                </table>
            </div>
        </div>
    </div>
    <br/>
    <div class="clearFix"></div>
    <!--footer start -->
    <?php include('footer.php'); ?>
    <!--footer end -->
    <script>
    
   function deleteGroupClient(id) {
    if (confirm("Are you sure you want to permanently delete this record?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "delete-group-client", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = xhr.responseText.trim(); 
                console.log("Response from server:", response); 
                if (response === '1') {
                    document.getElementById('row_' + id).style.display = 'none';
                } else {
                    alert('Failed to delete the record. Server response: ' + response);
                }
            }
        };
        xhr.send("id=" + encodeURIComponent(id)); 
    }
}




        function editMasClient(id) {
            $.post('/edit-mast-client', { 'cid': id }, function(data) {
                $("#addclient").hide();
                $("#editclient").html(data);
                $("#editclient").show();
            });
        }

      function update() {
    $('#success1').hide();
    var group_name = $("#editgroup_name").val();
    var esicode = $("#editesicode").val();
    var pfcode = $("#editpfcode").val();
    var lwf_no=$('#editlwf_no').val();
    var editid = $("#editid").val(); 
// alert(editid);
    // Validation checks
    if (group_name === "") {
        $("#group_name").focus().addClass('bordererror').attr("placeholder", "Please enter the client name");
        return false;
    }

    if (esicode === "") {
        $("#esicode").focus().addClass('bordererror').attr("placeholder", "Please enter the ESI code");
        return false;
    }

    if (pfcode === "") {
        $("#pfcode").focus().addClass('bordererror').attr("placeholder", "Please enter the PF code");
        return false;
    }
    if (lwf_no === "") {
        $("#lwf_no").focus().addClass('bordererror').attr("placeholder", "Please enter the LWF number");
        return false;
    }

    // AJAX request to update the client group
    $.ajax({
        url: '/update-group-client-process', // Ensure this path is correct
        type: 'POST',
        data: {
            'group_name': group_name,
            'esicode': esicode,
            'pfcode': pfcode,
            'editid': editid,
            'lwf_no':lwf_no
        },
        dataType: 'json',
        success: function(response) {
            console.log(response);
            if (response.success) {
                $("#error").hide();
                $("#success1").html('Record updated successfully').show();
            } else {
                $("#error").html('Update failed: ' + response.message).show();
            }

            // Reload specific parts of the page if needed
            $("#editclient").load(document.URL + ' #editclient');
            $("#addclient").show();
            $("#editclient").hide();
            $("#dispaly").load(document.URL + ' #dispaly');
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error:', textStatus, errorThrown);
            $("#error").html('An error occurred. Please try again.').show();
        }
    });
}





        function cancel() {
            $("#addclient").show();
            $("#editclient").hide();
        }
    </script>
    
</body>
</html>
