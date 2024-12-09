<?php
$page=basename($_SERVER['PHP_SELF']);

$ltype =$_SESSION['log_type'];

?>
<!--Menu starts here-->

<div class="twelve nav" >

<div class="row" >

    <div  class="contenttext" id='cssmenus' >

        <ul>
		<?php if($ltype !=3){?>

            <li  <?php if($page=='index.php'){ ?>class='active'<?php } ?>><a href='/home'><span>Home</span></a></li>
              
            <li class='has-sub <?php 	if($page=='add-mast-client.php' || $page=='edit-mast-client.php'){ ?>active<?php } ?>'  ><a href="javascript:void()"><span>master's</span></a>
               <ul>
                <li <?php if($page=='add-mast-client.php' || $page=='edit-mast-client.php'){ ?>class='active'<?php } ?>><a <?php if($page=='add-mast-department.php' || $page=='edit-mast-department.php'){ ?>class='noborder'<?php } ?> href='/add-mast-client'><span>Client</span></a></li>
                <li <?php if($page=='add-client-group.php' || $page=='edit-client-group.php'){ ?>class='active'<?php } ?>><a <?php if($page=='add-client-group.php' || $page=='edit-client-group.php'){ ?>class='noborder'<?php } ?> href='/add-client-group'><span>Client Group</span></a></li>
                <!--<li <?php if($page=='add-mast-client.php' || $page=='edit-mast-client.php'){ ?>class='active'<?php } ?>><a <?php if($page=='add-mast-parent.php' || $page=='edit-mast-parent.php'){ ?>class='noborder'<?php } ?> href='/add-mast-parent'><span>Parent</span></a></li>-->
                <li <?php if($page=='add-mast-parent.php' || $page=='edit-mast-parent.php'){ ?>class='active'<?php } ?>><a <?php if($page=='add-mast-qualification.php' || $page=='edit-mast-qualification.php'){ ?>class='noborder'<?php } ?> href='/add-mast-department'><span>Department</span></a></li>
                <li <?php if($page=='add-mast-qualification.php' || $page=='edit-mast-qualification.php'){ ?>class='active'<?php } ?>><a <?php if($page=='add-mast-designation.php' || $page=='edit-mast-designation.php'){ ?>class='noborder'<?php } ?> href='/add-mast-qualification'><span>Qualification</span></a></li>
                <li <?php if($page=='add-mast-designation.php' || $page=='edit-mast-designation.php'){ ?>class='active'<?php } ?>><a <?php if($page=='add-mast-location.php' || $page=='edit-mast-location.php'){ ?>class='noborder'<?php } ?> href='/add-mast-designation'><span>Designation</span></a></li>
                                <li <?php if($page=='add-mast-category.php' || $page=='edit-mast-category.php'){ ?>class='active'<?php } ?>><a <?php if($page=='add-mast-location.php' || $page=='edit-mast-location.php'){ ?>class='noborder'<?php } ?> href='/add-mast-category'><span>Category</span></a></li>

                <!--<li <?php if($page=='add-mast-location.php' || $page=='edit-mast-location.php'){ ?>class='active'<?php } ?>><a  <?php if($page=='add-mast-location.php' || $page=='edit-mast-location.php'){ ?>class='noborder'<?php } ?> href='/add-mast-location'><span>Location</span></a></li>-->
		        <li <?php if($page=='add-mast-bank.php' || $page=='edit-mast-bank.php'){ ?>class='active'<?php } ?>><a  <?php if($page=='add-mast-bank.php' || $page=='edit-mast-bank.php'){ ?>class='noborder'<?php } ?> href='/add-mast-bank'><span>Bank</span></a></li>
		        </ul>
            </li>
            <li class='has-sub <?php if($page=='add-employee-new.php' || $page=='edit-employee.php' || $page=='edit-all-employee.php' ||$page=='letters.php'){ ?>active<?php } ?>'><a href="javascript:void()"><span>Employee</span></a>
                <ul>
                       <li <?php if($page=='add-employee-new.php'){ ?>class='active'<?php } ?>><a <?php if($page=='edit-employee.php'){ ?>class='noborder'<?php } ?> href='/add-employee-new'><span>Add Employee</span></a></li>
                    <!--<li <?php if($page=='add-employee.php'){ ?>class='active'<?php } ?>><a <?php if($page=='edit-employee.php'){ ?>class='noborder'<?php } ?> href='/add-employee'><span>Add Employee</span></a></li>-->
                    <li <?php if($page=='edit-employee.php'){ ?>class='active'<?php } ?>><a <?php if($page=='edit-all-employee.php'){ ?>class='noborder'<?php } ?> href='/edit-employee'><span>Edit Employee</span></a></li>
                    <li <?php if($page=='edit-all-employee.php'){ ?>class='active'<?php } ?>><a href='/edit-all-employee' <?php if($page=='export-emp.php'){ ?>class='noborder'<?php } ?>><span>Edit All Employee</span></a></li>
                    <li class="has-sub">
                        <a href="javascript:void()">Export</a>
                        <ul>
                            <li <?php if($page=='export-emp.php'){ ?>class='active'<?php } ?>><a href='/export-emp-page'><span>Master Employee</span></a></li>
                            <li <?php if($page=='export-emp-income-page.php'){ ?>class='active'<?php } ?>><a href='/export-emp-income-page'><span>Income</span></a></li>
                            <li <?php if($page=='export-emp-deduct-page.php'){ ?>class='active'<?php } ?>><a href='/export-emp-deduct-page'><span>Deduct</span></a></li>
                            <li <?php if($page=='export-leave.php'){ ?>class='active'<?php } ?>><a href='/export-leave'><span>Leave</span></a></li>
                            <li <?php if($page=='export-advance.php'){ ?>class='active'<?php } ?>><a href='/export-advance' class="noborder" ><span>Advance</span></a></li>
							<li <?php if($page=='export-active-employee.php'){ ?>class='active'<?php } ?>><a href='/export-active-employee' class="noborder" ><span>Active Employee</span></a></li>
                        </ul>
                    </li>
                    <li class="has-sub">
                        <a href="javascript:void()" class="noborder">Import</a>
                        <ul>
                            <li <?php if($page=='import-emp.php'){ ?>class='active'<?php } ?>><a  <?php if($page=='import-income.php'){ ?>class='noborder'<?php } ?> href='/import-emp'><span>Master Employee</span></a></li>
                            <li <?php if($page=='import-income.php'){ ?>class='active'<?php } ?>><a  <?php if($page=='import-deduct.php'){ ?>class='noborder'<?php } ?> href='/import-income'><span>Income</span></a></li>
                            <li <?php if($page=='import-deduct.php'){ ?>class='active'<?php } ?>><a href='/import-deduct' class="noborder"><span>Deduct</span></a></li>
                        </ul>
                   </li>
                   		<li <?php if($page=='letters.php'){ ?>class='active'<?php } ?>><a href='/letters' <?php if($page=='letters.php'){ ?>class='noborder'<?php } ?> ><span>Letters</span></a></li>
        <li <?php if($page=='idCard.php'){ ?>class='active'<?php } ?>><a href='/idCard' <?php if($page=='idCard.php'){ ?>class='noborder'<?php } ?> ><span>Identity Card</span></a></li>
        
                </ul>
            </li>
		
            <li class="has-sub"><a href="javascript:void()"><span>Activities</span></a>
                <ul>
                    <li  <?php if($page=='datewise-details.php'){ ?>class='active'<?php } ?>><a  <?php if($page=='datewise-details.php'){ ?>class='noborder'<?php } ?> href='/datewise-details'><span>Datewise details</span></a></li>
                    <li  <?php if($page=='tran-day.php'){ ?>class='active'<?php } ?>><a  <?php if($page=='tran-calculation.php'){ ?>class='noborder'<?php } ?> href='/tran-day'><span>Input Days</span></a></li>
                    <li <?php if($page=='tran-calculation.php'){ ?>class='active'<?php } ?>><a href='/tran-calculation' <?php if($page=='import-transactions.php'){ ?>class='noborder'<?php } ?>  ><span>Calculation</span></a></li>
                    <!--                    <li><a href='export.php'><span>Export</span></a></li>-->
                    <li <?php if($page=='import-transactions.php'){ ?>class='active'<?php } ?>><a href='/import-transactions'  <?php if($page=='tran-leave.php'){ ?>class='noborder'<?php } ?> ><span>Import & Export </span></a></li>
					<!--li <?php if($page=='arrears.php'){ ?>class='active'<?php } ?>><a href='/arrears'  <?php if($page=='arrears.php'){ ?>class='noborder'<?php } ?> ><span>Arrears </span></a></li-->
	               <li <?php if($page=='show-salmonth.php'){ ?>class='active'<?php } ?>><a href='/show-salmonth'  <?php if($page=='show-salmonth.php'){ ?>class='noborder'<?php } ?> ><span>Emp. Available Monthts </span></a></li>
					
                </ul>
            </li>
			<?php }
		if($ltype ==3){ if($_SESSION['comp_id']==2) {$_SESSION['log_id']=3;}else {$_SESSION['log_id']=2;}}?>

			
            <li >
            <li class='has-sub <?php if($page=='report-salary.php' || $page=='report-bank.php'){ ?>active<?php } ?>'><a href='javascript:void(0);' ><span>Reports</span></a>
                <ul>
                    <li <?php if($page=='report-salary.php'){ ?>class='active'<?php } ?>><a <?php if($page=='report-bank.php'){ ?>class='noborder'<?php } ?> href='/report-salary'  <?php if($page=='report-bank.php'){ ?>class='noborder'<?php } ?>><span>Salary</span></a></li>
                    <!--li <?php if($page=='report-bank.php'  ){ ?>class='active'<?php } ?>><a <?php if($page=='report-pf.php'){ ?>class='noborder'<?php } ?> href='/report-bank'><span>Bank</span></a></li-->
                    <li <?php if($page=='report-pf.php'    ){ ?>class='active'<?php } ?>><a <?php if($page=='report-esi.php'){ ?>class='noborder'<?php } ?> href='/report-pf'><span>P.F</span></a></li>
                    <li <?php if($page=='report-esi.php'   ){ ?>class='active'<?php } ?>><a <?php if($page=='report-profession-tax.php'){ ?>class='noborder'<?php } ?> href='/report-esi'><span>E.S.I</span></a></li>
                    <li <?php if($page=='report-profession-tax.php'){ ?>class='active'<?php } ?>><a <?php if($page=='report-lws.php'){ ?>class='noborder'<?php } ?> href='/report-profession-tax'><span>Profession Tax</span></a></li>
                    <li <?php if($page=='report-lws.php'   ){ ?>class='active'<?php } ?>><a <?php if($page=='report-leave.php'){ ?>class='noborder'<?php } ?> href='/report-lws'><span>L.W.F.</span></a></li>
                   <li <?php if($page=='report-advances.php'){ ?>class='active'<?php } ?>> <a <?php if($page=='report-advances.php'){ ?>class='noborder'<?php } ?>  href='/report-advances' ><span>Advances</span></a></li>
                    <!--<li <?php if($page=='report-gst-bill.php'){ ?>class='active'<?php } ?>><a href='/report-gst-bill'  <?php if($page=='report-gst-bill.php'){ ?>class='noborder'<?php } ?>><span>GST BILL </span></a></li>-->
                    <!--<li <?php if($page=='report-mis.php'){ ?>class='active'<?php } ?>><a href='/report-mis' <?php if($page=='report-mis.php'){ ?>class='noborder'<?php } ?>><span>MISC. Reports</span></a></li>-->
					
                  
                  	<!--li <?php if($page=='report-gst-bill.php'){ ?>class='active'<?php } ?>><a href='/report-gst-bill'  <?php if($page=='report-gst-bill.php'){ ?>class='noborder'<?php } ?>><span>GST BILL </span></a></li>
					
					
					<li <?php if($page=='emerson-bill.php'){ ?>class='active'<?php } ?>><a href='/emerson-bill'  class='noborder'><span>Emerson Bill </span></a></li-->
                  <!--<li <?php if($page=='employee-attendance.php'){ ?>class='active'<?php } ?>><a href='/employee-attendance'  <?php if($page=='employee-attendance.php'){ ?>class='noborder'<?php } ?>><span>Attendance </span></a></li>-->
                  
                </ul>
            </li>

			
		<?php if($ltype !=3){?>
			
			<li class="has-sub">  <a href="javascript:void()"><span>Leave</span></a>
			<ul>
				<li <?php if($page=='leave-encashment.php'){ ?>class='active'<?php } ?>><a href="/leave-encashment" class=<?php if($page=='leave-encashment.php'){ ?>class='noborder'<?php } ?>><span>Encashment</span></a></li>
				<!--<li <?php if($page=='leave-reports.php'){ ?>class='active'<?php } ?>><a href="/leave-reports" class='noborder'><span>Bank Reports</span></a></li>-->
				<li <?php if($page=='leave-detail_reports.php'){ ?>class='active'<?php } ?>><a href="/leave-detail_reports" class='noborder'><span>Reports</span></a></li>
				<!--<li <?php if($page=='leave-encashment-export-page.php'){ ?>class='active'<?php } ?>><a href="/leave-encashment-export-page" class=<?php if($page=='leave-encashment-export-page.php'){ ?>class='noborder'<?php } ?>><span>Export To Excel</span></a></li>-->
				
			</ul>
			</li>

			
			            <!--li class='has-sub'><a href='javascript:void(0);' ><span>Income  Tax</span></a>
                <ul>
                    <li <?php if($page=='add-financial-year.php'){ ?>class='active'<?php } ?>><a href='/add-financial-year'><span>financial year</span></a></li>
                    <li <?php if($page=='edit-intax-employee.php'){ ?>class='active'<?php } ?>><a <?php if($page=='income-calculation.php'){ ?>class='noborder'<?php } ?> href='/edit-intax-employee'  <?php if($page=='report-bank.php'){ ?>class='noborder'<?php } ?>><span>Enter /Edit Details</span></a></li>
                    <li  <?php if($page=='income-calculation.php'){ ?>class='active'<?php } ?>><a href='/income-calculation' <?php if($page=='add-comp-details.php'){ ?>class='noborder'<?php } ?>><span>Calculation</span></a></li>
                    <li <?php if($page=='add-comp-details.php'){ ?>class='active'<?php } ?>><a href='/add-comp-details' <?php if($page=='add-it-deposit-details.php'){ ?>class='noborder'<?php } ?> ><span>Company Details</span></a></li>
                    <li <?php if($page=='add-it-deposit-details.php'){ ?>class='active'<?php } ?>><a href='/add-it-deposit-details' <?php if($page=='report-form16.php'){ ?>class='noborder'<?php } ?> ><span>IT Deposit Details</span></a></li>
                    <li <?php if($page=='report-form16.php'){ ?>class='active'<?php } ?>><a href='/report-form16'  class="noborder"><span>Form 16 </span></a></li>

                </ul>
            </li-->

			<li class='has-sub'><a href='javascript:void(0);' ><span>Bonus</span></a>
			<ul>
			<li <?php if($page=='select_current_bonus_year.php'){ ?>class='active'<?php } ?>><a href='/select_current_bonus_year'><span>Select Year</span></a></li>
				<li <?php if($page=='bonus.php'){ ?>class='active'<?php } ?>><a href='/bonus'><span>Bonus Calculation</span></a></li>
				
                <li <?php if($page=='statememt-bonus-calculation.php'){ ?>class='active'<?php } ?>><a href='/statememt-bonus-calculation'  ><span>Export Bonus</span></a></li>
				<li <?php if($page=='bonus-statement.php'){ ?>class='active'<?php } ?>><a href='/bonus-statement'  ><span>Statement</span></a></li>
				<li <?php if($page=='bonus-reports.php'){ ?>class='active'<?php } ?>><a href='/bonus-reports'  class="noborder"><span>Bank Reports</span></a></li>
				<li <?php if($page=='bonus-lock.php'){ ?>class='active'<?php } ?>><a href='/bonus-lock'  class="noborder"><span>Lock the Data</span></a></li>
			</ul>
			</li>			
			
			
			
<!--<li class='has-sub'><a href='javascript:void(0);' ><span>Other Payment</span></a>
			<ul>
			<li <?php if($page=='add-mast-other-payement.php'){ ?>class='active'<?php } ?>><a href='/add-mast-other-payement'><span>Other Payement</span></a></li>
				<li <?php if($page=='other-payment-details.php'){ ?>class='active'<?php } ?>><a href='/other-payment-details'><span>Other Payement Details</span></a></li>
				
                <li <?php if($page=='report-op-gst-bill.php'){ ?>class='active'<?php } ?>><a href='/report-op-gst-bill'  ><span>Bill & List</span></a></li>
				<li <?php if($page=='bonus-reports.php'){ ?>class='active'<?php } ?>><a href='/op-bank-reports'  class="noborder"><span>Bank Reports</span></a></li>
			</ul>
			</li>-->			
            <li class='has-sub'><a href='javascript:void(0);' ><span>Misc.</span></a>
                <ul>
                    <li <?php if($page=='tran_monthly_closing.php'){ ?>class='active'<?php } ?>><a href='/tran_monthly_closing'  class='noborder' ><span>Misc. Activities</span></a></li>
                    <li <?php if($page=='db_backup_view.php'){ ?>class='active'<?php } ?>><a href='/db_backup_view'  class='noborder' ><span>Database Backup</span></a></li>
                </ul>
            </li>
			
			
		<?php }?>
        </ul>

    </div>

</div>

</div>

<!--Menu ends here-->