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
              
            
            <li class='has-sub <?php if($page=='report-salary.php' || $page=='report-bank.php'){ ?>active<?php } ?>'><a href='javascript:void(0);' ><span>Reports</span></a>
                <ul>
                    <li <?php if($page=='report-salary.php'){ ?>class='active'<?php } ?>><a <?php if($page=='report-bank.php'){ ?>class='noborder'<?php } ?> href='/report-salary'  <?php if($page=='report-bank.php'){ ?>class='noborder'<?php } ?>><span>Salary</span></a></li>
                    <li <?php if($page=='report-bank.php'  ){ ?>class='active'<?php } ?>><a <?php if($page=='report-pf.php'){ ?>class='noborder'<?php } ?> href='/report-bank'><span>Bank</span></a></li>
                    <li <?php if($page=='report-pf.php'    ){ ?>class='active'<?php } ?>><a <?php if($page=='report-esi.php'){ ?>class='noborder'<?php } ?> href='/report-pf'><span>P.F</span></a></li>
                    <li <?php if($page=='report-esi.php'   ){ ?>class='active'<?php } ?>><a <?php if($page=='report-profession-tax.php'){ ?>class='noborder'<?php } ?> href='/report-esi'><span>E.S.I</span></a></li>
                    <li <?php if($page=='report-profession-tax.php'){ ?>class='active'<?php } ?>><a <?php if($page=='report-lws.php'){ ?>class='noborder'<?php } ?> href='/report-profession-tax'><span>Profession Tax</span></a></li>
                    <li <?php if($page=='report-lws.php'   ){ ?>class='active'<?php } ?>><a <?php if($page=='report-leave.php'){ ?>class='noborder'<?php } ?> href='/report-lws'><span>L.W.F.</span></a></li>
                    <li <?php if($page=='report-advances.php'){ ?>class='active'<?php } ?>> <a <?php if($page=='report-advances.php'){ ?>class='noborder'<?php } ?>  href='/report-advances' ><span>Advances</span></a></li>
                    <li <?php if($page=='report-mis.php'){ ?>class='active'<?php } ?>><a href='/report-mis' <?php if($page=='report-mis.php'){ ?>class='noborder'<?php } ?>><span>MISC. Reports</span></a></li>
					
					
					<li <?php if($page=='report-gst-bill.php'){ ?>class='active'<?php } ?>><a href='/report-gst-bill'  <?php if($page=='report-gst-bill.php'){ ?>class='noborder'<?php } ?>><span>GST BILL </span></a></li>
					<li <?php if($page=='emerson-bill.php'){ ?>class='active'<?php } ?>><a href='/emerson-bill'  class='noborder'><span>Emerson Bill </span></a></li>
                </ul>
            </li>

        </ul>

    </div>

</div>

</div>

<!--Menu ends here-->