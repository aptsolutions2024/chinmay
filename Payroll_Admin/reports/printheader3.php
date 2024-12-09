<!--Header starts here-->
<div style="clear: both;"></div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	
<style>
	.date {
	    float: right;
	    padding-right: 0px !important;
	    font-size: 12px !important;
	}
	.compDetails {
	    float: left;
	    padding-left: 0px !important;
	    font-size: 12px !important;
	}
    header, .header_bg {
        background-color: #fff !important;
        padding: 0;
        background: linear-gradient(#fff, #fff) !important;
    }
	.head11 {
        font-size: 12px;
        color: #000;
        font-family: arial;
    }
	.head12 {
        margin-left: 12px;
        margin-top: 0px;
        font-size: 14px;
        color: #000;
        font-family: arial;
    }
	.head13 {
        font-size: 12px;
        color: #000;
        font-family: arial;
    }
	.margin_right_10 {
        margin-right: 10px;
    }
	@media print {
	    .btnprnt { display: none; }
	    header, .header_bg {
	        background-color: #fff !important;
	        background: linear-gradient(#fff, #fff) !important;
	    }
		.head11, .head12, .head13 {
            color: #000 !important;
        }
	}
</style>

<header class="twelve header_bg">
    <div class="  container justify-content-center text-center">
        <div class="twelve columns">
            <div class="heade head12">
                <!-- Company Name -->
                <p style="font-size: 16px;">
                    <?php
                    $co_id = $_SESSION['comp_id'];
                    $clientId = $_SESSION['clintid'];
                    $rowcomp = $payrollAdmin->displayCompany($co_id);

                    $clientGrp = $_SESSION['clientGrp'];
                    if ($clientGrp != '') {
                        $rowclient = $payrollAdmin->displayClientGroupById($clientGrp);
                    } else {
                        $rowclient = $payrollAdmin->displayClient($clientId);
                    }
                    // echo $rowcomp['comp_name'];
                    ?>
                </p>

                <!-- Client Name -->
                <p style="font-size: 16px;">
                    <b><?php echo $_SESSION['client_name']; ?></b>
                </p>

                <!-- Report Title -->
                <p style="font-size: 16px;">
                    <b><?php echo $_SESSION['reporttitle']; ?></b><br>
                </p>
            </div>
        </div>
    </div>
</header>
<!--Header end here-->
