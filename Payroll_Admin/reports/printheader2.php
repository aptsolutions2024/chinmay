
<!--Header starts here-->
<div style="clear: both;"></div>
	<style>
        header,.header_bg{
            background-color:#fff !important;
			
            padding: 0;
			background: linear-gradient(#fff,#fff) !important;
        }
		.head11{font-size:15px !important;color: #000; font-family:arial;}
		.head12{margin-left:12px;margin-top:0px;font-size:15px !important;color: #000; font-family:arial;}
		.head13{font-size:15px !important;color: #000; font-family:arial;}
		.margin_right_10{margin-right:10px}
		
	@media print
{
    .btnprnt{display:none}
        header,.header_bg{
            background-color:#fff !important;
			background: linear-gradient(#fff,#fff) !important;
        }
		.head11,.head12,.head13{color:#000 !important}
}
	</style>

<header class="twelve header_bg">
    <div class="container" >
        <div class="twelve padd0 columns" >
            <div class="twelve padd0 columns mobicenter  " id="container1">
                <!-- Modify top header1 start here -->
                <div class="heade head12" >
				<center>
                    <?php
                    $co_id=$_SESSION['comp_id'];
                    $rowcomp=$payrollAdmin->displayCompany($co_id);?>
                    <?php echo "<b>".$_SESSION['client_name']."</b>";?> <br>
					<?php echo "<b>".$_SESSION['reporttitle']."</b>"; ?><br>
					<?php //echo "DEPLOYED AT - ".$_SESSION['client_name']; ?><br>
				</center>		

            </div>
		
			</div>
        
        </div></div>
</header>
<!--Header end here-->