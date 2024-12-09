
<!--Header starts here-->
<div style="clear: both;"></div>
	<style>
        header,.header_bg{
            background-color:#fff !important;
			
            padding: 0;
			background: linear-gradient(#fff,#fff) !important;
        }
		.head11{font-size:12px;color: #000; font-family:arial;}
		.head12{margin-left:12px;margin-top:0px;font-size:14px;color: #000; font-family:arial;}
		.head13{font-size:12px;color: #000; font-family:arial;}
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
    <div class="row body" >
        <div class="twelve padd0 columns" >
            <div class="six padd0 columns mobicenter text-left " id="container1">
                <!-- Modify top header1 start here -->
                <div class="logo" >
				
                    <?php
                    $co_id=$_SESSION['comp_id'];
                    $rowcomp=$payrollAdmin->displayCompany($co_id);?>
                    <span class="heade head12" style="float:left">&nbsp;<?php echo $rowcomp['comp_name'];?> </span>
                    

                <!-- Modify top header1 ends here -->

            </div>
			</div>
            <div class="six padd0 columns text-right text-center" id="container3" >

                <!-- Modify top header3  Navigation start here -->


                <div class="mobicenter text-right margin_right_10"  >
                    <span class="heade head12"  style=""><?php echo "(".$_SESSION['clientid'].")"; //echo $_SESSION['client_name']; ?> <br/></span> </div>
                <!-- Modify top header3 Navigation start here -->
            </div>
			<div class="clearFix"></div>
			<div class="heade head12" align="center"> <?php echo $_SESSION['reporttitle']; ?></div></div>
        
        </div>
</header>
<!--Header end here-->