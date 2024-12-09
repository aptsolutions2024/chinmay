<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');
if($_SESSION['log_type']==2)
{
    
}else

{
    echo "<script>window.location.href='/payroll-logout';</script>";exit();
}

$id=$_REQUEST['id'];
$_SESSION['empid'] = $id;
$employer_sign_image = 'http://chinmay.aptsolutions.in/emp_imgs/employer_sign_img.png';
$clientName = $payrollAdmin->DisplayClientName($id);
$profilePhoto = $payrollAdmin->profilePhoto($id);

$imagePath = $profilePhoto 
    ? 'http://chinmay.aptsolutions.in/' . $profilePhoto 
    : 'http://chinmay.aptsolutions.in/' . "/emp_imgs/dummy-profile.jpg";

$imagePath = str_replace('\\', '/', $imagePath); // Convert backslashes to forward slashes (if applicable).
$imagePath = htmlspecialchars($imagePath); // Escape the output to prevent XSS.
$extension = end(explode(".", $imagePath));
//echo $extension;
 $rowsemp=$payrollAdmin->showEployeedetails($id);
 $birthDate = htmlspecialchars($rowsemp['bdate']);
if ($birthDate) {
    // Calculate the age
    $birthDateTime = new DateTime($birthDate);
    $currentDate = new DateTime(); // Current date
    $age = $currentDate->diff($birthDateTime)->y; // Calculate the age in years
    // echo "Age: " . $age;joindate
} else {
    echo "Birthdate not available";
}
$firstname = htmlspecialchars($rowsemp['first_name']);
$middlename = htmlspecialchars($rowsemp['middle_name']);
$lastname = htmlspecialchars($rowsemp['last_name']);

$middle_initial = substr($middlename, 0, 1);

?>

  <link rel="stylesheet" href="Payroll/css/style.css">
    <script type="text/javascript" src="Payroll/js/jquery.min.js"></script>
<link rel="stylesheet" href="Payroll/css/jquery-ui.css">
<script type="text/javascript" src="Payroll/js/jquery-ui.js"></script>



<style>
    .identity-card {
    width: 61%;
    border: 1px solid #000;
    padding: 20px;
    font-family: Arial, sans-serif;
    margin: 0 auto;
    background-color: #f8f8f8;
}

.form-title {
    text-align: center;
    font-weight: bold;
    text-transform: uppercase;
}

.form-rule {
    text-align: center;
    font-size: 0.9em;
    margin-bottom: 20px;
}

.form-row {
    display: flex;
    margin: 10px 0;
    align-items: center;
}

.form-row label {
    width: -3%;
    font-weight: bold;
}

.photo-box {
    width: 152px;
    height: 152px;
    border: 1px solid #000;
    float: right;
    margin: -140px 20px 20px 0;
}

.signature-label {
    text-align: right;
    font-weight: bold;
    /*margin-top: 40px;*/
    display: block;
}

.button-row {
    text-align: right;
    margin-top: 20px;
}
.tabcontent {
    display: none; /* Hide all tab content by default */
}

.tabcontent.active {
    display: block; /* Show active tab content */
}

/*.btnclass {*/
/*    background-color: #4CAF50;*/
/*    color: white;*/
/*    border: none;*/
/*    padding: 10px 20px;*/
/*    cursor: pointer;*/
/*}*/

.btnclass:hover {
    background-color: #45a049;
}

</style>

<!--Menu ends here-->
<div class="clearFix"></div>
<!--Slider part starts here-->

<div class="twelve mobicenter innerbg">
    <div class="row">



        <div class="twelve" id="margin1">
    <div class="tab">
        <button id="t1" class="active tablinks" onclick="openTab(event, 'tab1')">IDentity Card</button>
    </div>

    <!-- Ensure the active class is added to make this tab content visible by default -->
    <div id="tab1" class="tabcontent active">
        <div class="identity-card" id="identityCard">
            <h2 class="form-title">IDENTITY CARD</h2>
            <p class="form-rule">FORM X (See Rule 57(1))</p>
            <form>
                <div class="form-row">
                    <label>Name of the Establishment:&nbsp;&nbsp;</label>
                    <span><?php echo htmlspecialchars($clientName); ?></span>
                </div>
                <div class="form-row">
                    <label>Name of the Employee:&nbsp;&nbsp;</label>
                    <span><?php echo "{$firstname} {$middle_initial}. {$lastname}"; ?></span>
                </div>
                <div class="form-row">
                    <label>Age:&nbsp;&nbsp;</label>
                    <span><?php echo $age."&nbsp;"; ?></span>
                    <label>Sex:&nbsp;&nbsp;</label>
                    <span><?php echo htmlspecialchars($rowsemp['gender']) ."&nbsp;"."&nbsp;"?></span>
                </div>
                <div class="form-row">
                    <label>Date of entry in service:&nbsp;&nbsp;</label>
                    <span>
                        <?php
                        $joindate = $rowsemp['joindate'];
                        echo htmlspecialchars(date('d-m-Y', strtotime($joindate)));
                        ?>
                    </span>
                </div>
                <div class="form-row">
                    <label>Designation / Nature of work:&nbsp;&nbsp;&nbsp;&nbsp;</label>
                    <span><?php echo htmlspecialchars($rowsemp['department']); ?></span>
                </div>
                <div class="form-row">
                    <label>Department:&nbsp;&nbsp;</label>
                    <span><?php echo htmlspecialchars($rowsemp['department']); ?></span>
                </div>
                <div class="photo-box">
                    <?php if(strtolower($extension)=='pdf'){ ?>
                        <embed src="<?php echo htmlspecialchars($imagePath); ?>" type="application/pdf"   style="max-width: 150px; height: auto;">
                    <?php }else{ ?>
                        <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="Employee Photo" style="max-width: 150px; height: auto;">
                    <?php } ?>
                </div>
                 <div class="form-row">
                    <img src="<?php echo htmlspecialchars($employer_sign_image); ?>" alt="Employer Image" style="width:180px;height:60px;">
                </div>
                <div class="form-row">
                    <label class="signature-label">Employer</label>
                </div>
                <div class="button-row">
                    <input type="button" name="print" value="Print" class="btnclass" onclick="printIdentityCard()">
                </div>
            </form>
        </div>
        <div class="twelve padd0 columns successclass hidecontent" id="success1" style="margin-bottom: 15px;"></div>
        <div class="clearFix"></div>
    </div>
</div>



    </div>
   

<br/>

<div class="clearFix"></div>
<script>
function printIdentityCard() {
    const identityCard = document.getElementById('identityCard').outerHTML;

    const printWindow = window.open('', '_blank', 'width=800,height=600');
    printWindow.document.open();
    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Identity Card</title>
            <style>
                /* Include your styles here */
                .identity-card {
                    width: 61%;
                    border: 1px solid #000;
                    padding: 20px;
                    font-family: Arial, sans-serif;
                    margin: 0 auto;
                    background-color: #f8f8f8;
                }
                .form-title {
                    text-align: center;
                    font-weight: bold;
                    text-transform: uppercase;
                }
                .form-rule {
                    text-align: center;
                    font-size: 0.9em;
                    margin-bottom: 20px;
                }
                .form-row {
                    display: flex;
                    margin: 10px 0;
                    align-items: center;
                }
                .form-row label {
                    width: -3%;
                    font-weight: bold;
                }
                .photo-box {
                    width: 152px;
                    height: 152px;
                    float: right;
                    margin: -140px 20px 20px 0;
                }
                .signature-label {
                    text-align: right;
                    font-weight: bold;
                   /                    display: block;
                }
                .button-row {
                    text-align: right;
                    margin-top: 20px;
                }

                /* Hide the print button during printing */
                @media print {
                    .button-row {
                        display: none;
                    }
                }
            </style>
        </head>
        <body onload="window.print(); window.close();">
            ${identityCard}
        </body>
        </html>
    `);
    printWindow.document.close();
}
</script>



<!--Slider part ends here-->
