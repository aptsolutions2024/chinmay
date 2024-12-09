<?php
$page=basename($_SERVER['PHP_SELF']);

$ltype =$_SESSION['log_type'];

?>
<!--Menu starts here-->

<div class="twelve nav" >

<div class="row" >

    <div  class="contenttext" id='cssmenus' >

        <ul>
		

            <li  <?php if($page=='index.php'){ ?>class='active'<?php } ?>><a href='/home'><span>Home</span></a></li>
              
            
		
            <li class="has-sub"><a href="javascript:void()"><span>Salary</span></a>
                <ul>
                    <li  <?php if($page=='tran-day.php'){ ?>class='active'<?php } ?>><a  <?php if($page=='tran-calculation.php'){ ?>class='noborder'<?php } ?> href='/tran-day'><span>Input Days</span></a></li>
                    <li <?php if($page=='tran-calculation.php'){ ?>class='active'<?php } ?>><a href='/tran-calculation' <?php if($page=='import-transactions.php'){ ?>class='noborder'<?php } ?>  ><span>Calculation</span></a></li>
                    <!--                    <li><a href='export.php'><span>Export</span></a></li>-->
                    <li <?php if($page=='import-transactions.php'){ ?>class='active'<?php } ?>><a href='/import-transactions'  <?php if($page=='tran-leave.php'){ ?>class='noborder'<?php } ?> ><span>Import & Export </span></a></li>
					<li <?php if($page=='arrears.php'){ ?>class='active'<?php } ?>><a href='/arrears'  <?php if($page=='arrears.php'){ ?>class='noborder'<?php } ?> ><span>Arrears </span></a></li>
					
                </ul>
            </li>
			
			
        </ul>

    </div>

</div>

</div>

<!--Menu ends here-->