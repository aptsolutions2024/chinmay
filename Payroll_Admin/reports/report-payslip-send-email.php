<?php
session_start();
ini_Set('display_errors',1);
ini_Set('display_startup_errors',1);
error_reporting(0);
$month=$_SESSION['month'];
$clintid=$_SESSION['clintid'];
$emp=$_REQUEST['emp'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];


//require('../send-email/PHPMailer/PHPMailerAutoload.php');
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

$payrollAdmin = new payrollAdmin();
$resclt=$payrollAdmin->displayClient($clintid);
$cmonth=$resclt['current_month'];
if($month=='current'){
    $monthtit =  date('F Y',strtotime($cmonth));
    $tab_days='tran_days';
    $tab_emp='tran_employee';
    $tab_empinc='tran_income';
    $tab_empded='tran_deduct';
    $frdt=$cmonth;
    $todt=$cmonth;
}
else{
    $tab_days='hist_days';
    $tab_emp='hist_employee';
    $tab_empinc='hist_income';
    $tab_empded='hist_deduct';

    $frdt=date("Y-m-d", strtotime($_SESSION['frdt']));
    $todt=date("Y-m-t", strtotime($_SESSION['frdt']));
	$monthtit =  date('F Y',strtotime($_SESSION['frdt']));
	
}

//echo $clientid.'#FromDate'.$frdt.'#ToDate'.$todt;
//$sql = "SELECT * FROM $tab_days WHERE comp_id ='".$comp_id."' AND user_id='".$user_id."' ";
$sql = "SELECT * FROM tran_days WHERE client_id ='".$clintid."' AND sal_month >= '$frdt' AND sal_month <= '$todt' ";
        if($emp!='all'){
            $empid=$_REQUEST['empid'];
            $sql .= " AND emp_id=".$empid;
        }

        $sql .=" union 
        SELECT * FROM hist_days WHERE client_id ='".$clintid."' AND sal_month >= '$frdt' AND sal_month <= '$todt'
         ";
         
if($emp!='all'){
    $empid=$_REQUEST['empid'];
    $sql .= " AND emp_id=".$empid;
}
$res = $payrollAdmin->executeQuery($sql);
$tcount= count($res);
if($clintid==5){
    $comp_aprv = 'V.D.S';
}else{
    $comp_aprv = 'C.H.S';
}
?>

<!DOCTYPE html>

<html lang="en-US">
<head>

    <meta charset="utf-8"/>


    <title> &nbsp;</title>

    <!-- Included CSS Files -->
    <link rel="stylesheet" href="../css/responsive.css">
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>
<?php
        //$count=1;
        //$per=2;
        $failed_msg = '';
    $success_msg = '';
        foreach($res as $row){
            $monthtit =  date('F Y',strtotime($row['sal_month']));
            
            $empid=$row['emp_id'];
            $emprows1=$payrollAdmin->showEployeedetails($empid);
            
            
            $temp=$clintid.'_'.$emprows1["first_name"]."-".$emprows1["middle_name"]."-".$emprows1["last_name"].'_'.$monthtit;
            $name=$doc_path.'/pdffiles/payslip/'.$temp.'.pdf';
            
            $empmail=$emprows1["email"];
            require_once($doc_path."/send-email/PHPMailer/class.phpmailer.php");
            
            $mail = new PHPMailer();
            // $mail-> isSMTP();
            $filename=$temp.'.pdf';
          // echo '1';
            if(!file_exists($name)){
               $failed_msg .= "File not found for ".$temp."<br>";
               continue;
            }
            $uploadfile=$name;
            $mail->SMTPDebug = 3;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'tls';
            $mail->Host = 'smtp.gmail.com';     
            $mail->Port = '587';
            $mail->IsHTML(true);
            
           if ($clintid == 5) {
    $mail->Username = 'vdshetty@aptsolutions.in'; // SMTP username
    $mail->Password = 'y*AZ4%QHjN%R';             // SMTP password
    $mail->setFrom('vdshetty@aptsolutions.in', 'Payslip'); // From address
} else {
    $mail->Username = 'chinmaya@aptsolutions.in'; // Default SMTP username
    $mail->Password = 'chinmay@2024';             // Default SMTP password
    $mail->setFrom('chinmaya@aptsolutions.in', 'Payslip'); // From address
}
 
            //$empmail= 'shraddharhatole14997@gmail.com';
            $mail->addAddress($empmail);   // Add a recipient
            //$mail->AddCC("katkaraparna@gmail.com");
            $bodyContent = '<h1>'.$comp_aprv.' PAYSLIP FOR THE MONTH '.$monthtit.'</h1>';
            $mail->Subject = $comp_aprv.' PAYSLIP FOR THE MONTH '.$monthtit;
            $mail->Body    = $bodyContent;     
            $mail->addAttachment($uploadfile, $filename);
            
            if($mail->send()){
                $success_msg .= "Mail has been sent to ".$temp."<br>";
            
            }else{
                $failed_msg .= "Mail could not be sent !!! Mailer Error: " . $mail->ErrorInfo."<br>";
            }
            $mail->SmtpClose();
            clearstatcache();
            
    }
    echo "<br>";
    echo "<label style='color:red;font-size: 18px;'>".$failed_msg."</label>";
    echo "<br>****************<br>";
    echo "<label style='color:green;font-size: 16px;'>".$success_msg."</label>";
exit;
?>
                <!-- content end -->

</body>
</html>