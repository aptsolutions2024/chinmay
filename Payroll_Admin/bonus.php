<?php
session_start();
if (isset($_SESSION['log_id']) && $_SESSION['log_id'] == '') {
    header("location:../index.php");
}

if ($_SESSION['startbonusyear'] == '' || $_SESSION['endbonusyear'] == '') {
    echo "<h1>Invalid Bonus Year</h1>";
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

$comp_id = $_SESSION['comp_id'];
$user_id = $_SESSION['log_id'];

$result1 = $payrollAdmin->showClient1($comp_id, $user_id);
$result2 = $payrollAdmin->getBonusType();
$_SESSION['month'] = 'current';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width"/>
    <title>Bonus Calculation</title>
    <link rel="stylesheet" href="../css/responsive.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/jquery-ui.css">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/jquery-ui.js"></script>
</head>
<body>
<!-- Header starts here -->
<?php include('header.php'); ?>
<!-- Header end here -->

<div class="twelve mobicenter innerbg container">
    <div class="twelve" id="margin1">
        <h3>Bonus</h3>
    </div>
    <div class="boxborder container" style="padding: 20px;">
        <div class="clearFix"></div>

        <div class="four padd0 columns">
            <div class="three padd0 columns">
                <span class="labelclass">Client:</span>
            </div>
            <div class="eight padd0 columns">
                <select class="textclass" name="client" id="client">
                    <option value="">--Select--</option>
                    <?php foreach ($result1 as $row1) { ?>
                        <option value="<?php echo $row1['mast_client_id']; ?>"><?php echo $row1['client_name']; ?></option>
                    <?php } ?>
                </select>
                <span class="errorclass hidecontent" id="nerror"></span>
            </div>
        </div>

        <div class="four padd0 columns">
            <div class="three padd0 columns">
                <span class="labelclass">Type:</span>
            </div>
            <div class="eight padd0 columns">
                <select name="type" class="textclass" id="type" onchange="displaywages(this.value)">
                    <option value="">--- Select Type ---</option>
                    <?php foreach ($result2 as $row) { ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                    <?php } ?>
                </select>
                <span class="errorclass hidecontent" id="tyerror"></span>
            </div>
        </div>

        <div class="clearFix">&nbsp;</div>
        <span id="wamt" class="hidecontent">
            <div class="four padd0 columns hidecontent" id="wamtsec">
                <div class="three padd0 columns">Wages:</div>
                <div class="eight padd0 columns">
                    <input type="text" name="amount" class="textclass" value="7000" id="amount">
                    <span class="errorclass hidecontent" id="wagerror"></span>
                </div>
            </div>
            <div class="four padd0 columns">
                <div class="three padd0 columns">Bonus Rate:</div>
                <div class="eight padd0 columns">
                    <input type="text" name="bonus_rate" class="textclass" value="8.33" style="width: 90%;" id="bonusrate"> &nbsp; %
                    <span class="errorclass hidecontent" id="bonerror"></span>
                </div>
            </div>
            <div class="four padd0 columns">
                <div class="three padd0 columns">Exgratia:</div>
                <div class="eight padd0 columns">
                    <input type="text" name="exgratia" class="textclass" value="0" id="exgratia" style="width: 90%;"> &nbsp; %
                    <span class="errorclass hidecontent" id="exgerror"></span>
                </div>
            </div>
            <div class="clearFix">&nbsp;</div>
        </span>

        <div class="one padd0 columns">
            <span class="labelclass">Client Type</span>
        </div>
        <div class="two columns">
            <input type="radio" name="comptype" value="org" checked> As per Existing Record<br>
            <input type="radio" name="comptype" value="new"> As per New Client
        </div>

        <div class="clearFix">&nbsp;</div>
        <div class="one padd0 columns" align="center">
            <input type="button" onclick="calulation();" class="btnclass" value="Calculate">
        </div>

        <div class="clearFix">&nbsp;</div>
        <div class="twelve padd0 columns hidecontent" id="sucmessage"></div>
        <div class="clearFix"></div>
        <div id="display"></div>
    </div>
</div>

<!-- Footer start -->
<?php include('footer.php'); ?>
<!-- Footer end -->

<script>
function calulation() {
    var client = $("#client").val();
    var type = $("#type").val();
    var amount = $("#amount").val();
    var bonusrate = $("#bonusrate").val();
    var comptype1 = document.getElementsByName('comptype');
    var comptype;

    for (var i = 0; i < comptype1.length; i++) {
        if (comptype1[i].checked) {
            comptype = comptype1[i].value;
            break;
        }
    }

    var exgratia = $("#exgratia").val();
    var sessionstartdate = '<?php if (isset($_SESSION['startbonusyear'])) { echo $_SESSION['startbonusyear']; } ?>';
    var sessionenddate = '<?php if (isset($_SESSION['endbonusyear'])) { echo $_SESSION['endbonusyear']; } ?>';

    if (sessionstartdate == "" || sessionenddate == "") {
        $("#display").html('<div class="error31">Please select bonus Year</div>');
        return false;
    }
    if (client == "") {
        $("#nerror").show().text("Please select client");
        return false;
    } else if (type == "") {
        $("#tyerror").show().text("Please select Type");
        return false;
    } else if (amount == "") {
        $("#wagerror").show().text("Please enter wages");
        return false;
    } else if (bonusrate == "") {
        $("#bonerror").show().text("Please enter bonus rate");
        return false;
    } else if (exgratia == "") {
        $("#exgerror").show().text("Please enter exgratia rate");
        return false;
    } else {
        $("#nerror, #tyerror, #wagerror, #bonerror, #exgerror").hide();

        $('#display').html('<div style="height: 80px; width: 80px; padding-left: 30px;padding-top: 20px;" align="left"><img src="../Payroll/images/loading.gif" /></div>');

        $.post('/calculation-bonus', {
            'client': client,
            'type': type,
            'exgratia': exgratia,
            'bonusrate': bonusrate,
            'amount': amount,
            'comptype': comptype
        }, function (data) {
          // debugger;
            // alert(data);
            $("#display").html(data);
            //$('#display').hide();
        });
    }
}

function displaywages(val) {
    $("#wamt").show();
    if (val == '2' || val == '3') {
        $("#wamtsec").show();
    } else {
        $("#wamtsec").hide();
    }
}

function updatelock() {
    var client = $("#client").val();

    if (client == "") {
        $("#nerror").show().text("Please select client");
        return false;
    } else {
        $("#nerror, #tyerror, #wagerror, #bonerror, #exgerror").hide();

        $.post('/updatebonuslock', {
            'client': client
        }, function (data) {
            $("#display").html(data);
            $('#sucmessage').show().html('<div class="success31">&nbsp; &nbsp; Record Successfully Updated!</div>');
           // $('#display').hide();
        });
    }
}
</script>
</body>
</html>
