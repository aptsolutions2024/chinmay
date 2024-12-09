<!--Header starts here-->
<header class="twelve header_bg">
    <div class="row">
        <div class="twelve padd0 columns">
            <div class="Color2t">
                <?php
                error_reporting(E_ALL);
                $rowcomp = $payrollEmp->displayCompany($_SESSION['comp_id']);
             
                $client_name = $_SESSION['client_name'];
                $fname = $_SESSION['fname'];
                echo "<span class='Color2'>$rowcomp[comp_name], $client_name</span> | <span class='user-name'>$fname</span>";
                ?>
                <a class="btn logout-btn"  style="float: right;" href="/emp-payroll-logout">Logout</a>
            </div>
        </div>
    </div>
</header>

<style>
    /* General Styles */
    body {
        font-family: calibri;
    }
    
    .twelve.header_bg {
        padding: 10px;
        color: #ffffff;
    }

    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
        font-size: 16px; /* Base font size */
    }

    .company-name, .user-name {
        font-size: 14px; /* Base font size for company and user name */
        color: #ffffff;
    }

    .logout-btn {
        font-size: 14px;
        padding: 5px 10px;
        background-color: #007bff;
        color: #ffffff;
        text-decoration: none;
        border-radius: 4px;
    }

    /* Responsive Styles */
    @media (max-width: 768px) {
        /* On tablets and smaller screens */
        .header-content {
            flex-direction: column;
            text-align: center;
        }

        .company-name, .user-name {
            display: block;
            font-size: 12px; /* Smaller font size for smaller screens */
        }

        .logout-btn {
            margin-top: 10px;
            font-size: 12px;
            padding: 8px 16px;
        }
    }

    @media (max-width: 480px) {
        /* On mobile devices */
        .header-content {
            font-size: 14px; /* Further reduce base font size */
        }

        .company-name, .user-name {
            font-size: 12px; /* Smaller font for very small screens */
        }

        .logout-btn {
            font-size: 12px;
            padding: 5px 12px; /* Adjust button size */
        }
    }

    /* Optional: Custom style adjustments for DataTables and other page elements */
    .dataTables_filter, label {
        display: flex !important;
    }

    .dataTables_filter, table {
        padding: 0px !important;
    }
</style>

<!-- External Styles and Scripts -->
<link rel="stylesheet" href="Payroll/css/responsive.css">
<link rel="stylesheet" href="Payroll/css/style.css">
<script type="text/javascript" src="Payroll/js/jquery.min.js"></script>
<link href="Payroll/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="Payroll/css/buttons.dataTables.min.css" rel="stylesheet">

<!-- PHP for loading the menu -->
<?php
if ($_SESSION['log_type'] == 6) {
    include('menu.php');
}
?>
<!--Header end here-->
