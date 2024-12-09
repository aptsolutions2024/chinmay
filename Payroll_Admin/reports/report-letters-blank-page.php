<?php
include ('../../include_payroll_admin.php');

$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];

$comapnydtl = $payrollAdmin->showCompdetailsById($comp_id);

?>

<!DOCTYPE html>

<html lang="en-US">
<head>

    <meta charset="utf-8"/>
    <title> &nbsp;</title>

    <style>

        .thheading{
            text-transform: uppercase;
            font-weight: bold;
            background-color: #fff;
        }
        .heading{
            margin: 10px 20px;
        }
        .btnprnt{
            margin: 10px 20px;
        }
        .page-bk {
            position: relative;
            /*display: block;*/
            page-break-after: auto;
            z-index: 0;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        table, td, th {
            padding: 5px!important;
			border:0 !important;
            /*border: 1px dotted black!important;*/
            font-size:22px !important;
            font-family: Arial;

        }
		.flr{float:right}
		#appletter{appletter}
		.tjust{text-align:justify}
		.tbtit1{font-weight:900}
		.tbtit2{font-weight:500}
		table.paydtl,.paydtl td{border:1px solid black !important}
		.bggray{
			background:#ccc;
		}
		#format2 table,#format2 td,#format2 th {
            padding: 5px!important;
			border:0 !important;
            /*border: 1px dotted black!important;*/
            font-size:13px !important;
            font-family: Arial;

        }
		footer {page-break-after: auto;}
		.tjust{text-align:justify}
        @media print
        { footer {page-break-after: auto;}
            .btnprnt{display:none}
            .header_bg{
                background-color:#7D1A15;
                border-radius:0px;
            }
            .heade{
                color: #fff!important;
            }
            #header, #footer {
                display:none!important;
            }
            #footer {
                display:none!important;
            }
            .body { padding: 10px; }
            body{
                margin-left: 50px;
            }
			
        }

        @media all {
            #watermark {
                display: none;

                float: right;
            }

            .pagebreak {
                display: none;
            }

            #header, #footer {

                display:none!important;

            }
            #footer {
                display:none!important;
            }
			
			footer {page-break-after: always;}
        }
    </style>
</head>
<body>
<div class="btnprnt">
    <button class="submitbtn" onclick="myFunction()">Print</button>
    <button class="submitbtn"  onclick="history.go(-1);" >Cancel</button>
</div>
<!-- content starts -->

<div>
<div class="header_bg">
<?php
//include('printheader.php');
?>
</div>
    <div class="row body" >
	
	<div class="page-bk">
    <table width="100%" id="appletter">
	<thead>
	<tr>
	
	<td align="right"   style="text-align:left">
	<div style="width:45%; float:right">
<?php echo $comapnydtl['comp_name'];?><br>
	1117/5A, Off Ganeshkhind Road,<br>Pune 411 016<br>Tel. :25660360 / 25652095 Fax:25656144<br>e-mail:shaconpvt@gmail.com
	</div>
	</td></tr></thead>
    
	
	
	
</table></div>

 </div>
    </div>
<!-- content end -->

<script>
    function myFunction() {
        window.print();
    }
	
</script>


</body>
</html>