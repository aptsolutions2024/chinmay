<!--Header starts here-->
<div style="clear: both;"></div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<style>
	.date{
	    float: right;
	    padding-right: 0px !important;
	    font-size:12px !important;
	}
	.compDetails{
	    float:left;
	    padding-left: 0px !important;
	    font-size:12px !important;
	    
	}
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
    <div class="row container" >
        <div class="twelve padd0 columns" >
            <div class="twelve padd0 columns mobicenter  " id="container1">
                <!-- Modify top header1 start here -->
                <div class="heade head12 body" >
				<p style="font-size: 16px;text-align:center;">
                    <?php
                    $co_id=$_SESSION['comp_id'];
                    $clientId = $_SESSION['clintid'];
                    // print_r($_SESSION);
                    $rowcomp=$payrollAdmin->displayCompany($co_id);
                    
                    
                    // to print client / client group esi & pfcode
                    $clientGrp=$_SESSION['clientGrp'];
                    if ($clientGrp!=''){   
    $rowclient=$payrollAdmin->displayClientGroupById($clientGrp);
    
}else{
    $rowclient=$payrollAdmin->displayClient($clientId);
}

                    ?>
                    
                    
                  
                   </p>
                   
                   <p style="font-size: 16px; text-align:center;">
					 <b><?php echo $_SESSION['client_name']; ?>
					 </p>
					 
					 <p style="font-size: 16px;text-align:center;" >
					<?php echo $_SESSION['reporttitle']; ?></b><br>
					</p>
					
				
				
				
				
				 </div>
			<div class="clearFix"></div>
			</div>
        
        </div></div>
        	<div class="compDetails">
                    <span>ESI Code: <?php echo $rowclient['esicode'];?>&nbsp;&nbsp; <br>PF Code : <?php echo $rowclient['pfcode']?></span>
                </div>
</header>
<!--Header end here-->