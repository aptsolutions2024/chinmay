<?php
error_reporting(E_ALL); // Disable all error reporting
ini_set('display_errors', '0'); // Disable error display

session_start();
$flag ='';
if ($_SESSION['log_type'] == 2 )
{
   $doc_path = $_SERVER["DOCUMENT_ROOT"];
    include($doc_path . '/include_payroll_admin.php');

    if($_SESSION['log_type']==2)
    {
        // print_r($_SESSION);
        // echo "''''!!!!!!!";
        // echo "client group".$_SESSION['clientGrp'];
        $month=$_SESSION['month'];
        $clientid=$_SESSION['clientid'];
        $clientGrp=$_SESSION['clientGrp'];
        
        $emp=$_REQUEST['emp'];
        $comp_id=$_SESSION['comp_id'];
        $user_id=$_SESSION['log_id'];
        $zerosal = $_REQUEST['zerosal'];
        $noofpay = $_REQUEST['noofpay'];
        $empid=$_REQUEST['empid'];
        $per=$noofpay;
        
      
       if (isset($_SESSION['frdt'])) {
          // echo $_SESSION['frdt'];
              // Convert the 'YYYY-MM' value to the first day of the month
            $frdt = date('Y-m-t', strtotime($_SESSION['frdt']));  
            // Convert to the last day of the month
            $todt = date('Y-m-t', strtotime($_SESSION['frdt']));  
            // Month Title for display
            $monthtit = date('F Y', strtotime($frdt));
            // echo $frdt.$todt."^^^^^^^^^^^^^^^^";
            

    } else {
        echo "Session dates are not set properly.";
    }
    }
    else
    {
        echo "<script>window.location.href='/payroll-logout';</script>";exit();
    }

}


else if ($_SESSION['log_type'] == 5) {
    include('../../include_payroll_admin.php');
    $payrollAdmin = new payrollAdmin();
    
    if ($_SESSION['log_type'] == 5) { 
        $clientid = $_SESSION['clientid'];
        $comp_id = $_SESSION['comp_id'];
        $user_id = $_SESSION['log_id'];
        $empid = $_SESSION['emp_login_id'];

        // Format dates
       $frdt = date('Y-m-01', strtotime($_REQUEST['from_date']));
        $todt = date('Y-m-01', strtotime($_REQUEST['to_date']));
        $monthtit = date('F Y', strtotime($frdt));
// echo $frdt;
        // Check if the date exists
        $isDatePresent = $payrollAdmin->checkDateExistsInShowSalmonth($clientid, $frdt);

        if (!$isDatePresent) {
            echo json_encode(['flag' => 'date_not_present']);
            exit; // Stop script execution after sending the response
        } else {
            // Check the flag status
            $result = $payrollAdmin->getClientFlagStatus($clientid, $frdt);
            $flag = $result['flag'] ?? null;

            if ($flag === null) {
                echo json_encode(['flag' => 'please selecte another date']);
            } else {
                // echo json_encode(['flag' => $flag]);
            }
            
        }
    } else {
        echo "<script>window.location.href='/emp-payroll-logout';</script>";
        exit();
    }
}

include('../../fpdf/html_table.php');

$pdfHtml='';


$resclt=$payrollAdmin->displayClient($clientid);
// print_r($resclt);
$cmonth=date('Y-m-t',strtotime($resclt['current_month']));
if($month=='current'){
    $monthtit =  date('m Y',strtotime($cmonth));
    $frdt=$cmonth;
    $todt=$cmonth;

 }

if ($clientGrp!='' && $clientGrp != 1)
{
    // echo $clientGrp;
    // echo "frdt:".$frdt;
    
    
     
    $res=$payrollAdmin->getSalMonthDataGroup($comp_id,$user_id,$zerosal,$frdt,$todt,$clientGrp);
}
elseif($clientGrp == 1) {
        // echo "!!!!!!!1$$$$$$$$$$$$$$";
        $clientids = $payrollAdmin->displayclientbyComp($comp_id);
        // print_r($clientids);
        // $resclt = $payrollAdmin->displayClient($clientids['client_id']);
        $clientGrp=$clientids['client_id'];
        $clientid=$clientids['client_id'];
        $res=$payrollAdmin->getSalMonthDataGroups($comp_id,$user_id,$zerosal,$frdt,$todt,$clientGrp);
    }
else
{
    $res=$payrollAdmin->getSalMonthData($comp_id,$user_id,$zerosal,$empid,$emp,$clientid,$frdt,$todt);
}
//print_r($res);
$tcount= count($res);

    $reporttitle="PAYSLIP FOR THE MONTH ".strtoupper($monthtit);

$_SESSION['reporttitle']=$reporttitle;
?>

<!DOCTYPE html>

<html lang="en-US">
<head>

    <meta charset="utf-8"/>


    <title> &nbsp;</title>

    <!-- Included CSS Files -->
   <!-- <link rel="stylesheet" href="../css/responsive.css">
    <link rel="stylesheet" href="../css/style.css">-->
    <style>
	body{font-family:arial}
        .thheading{
            text-transform: uppercase;
            font-weight: bold;
            background-color: #fff;
        }
		.logo span.head11 {
			font-size: 17px !important;
		}
		
		span.head13 {
			font-size: 20px !important;
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
            page-break-after: always;
            z-index: 0;

        }
		


        table {
            border-collapse: collapse;
            width: 100%;
            font-weight:bold !important;

        }

        table, td, th {
            padding: 4px!important;
            border: 1px solid black!important;
            font-size:13px !important;
            font-family:arial;
			
        }
		@page {margin :27mm 16mm 22mm 16mm;}
        @media print
        {
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
            .body { margin: 0 30px 10px 10px; }
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

        }



    </style>
    <script>
    function myFunction() {
        window.print();
    }
</script>

</head>

<body>
<div class="btnprnt">
    <button class="submitbtn" onclick="myFunction()">Print</button>
    <button class="submitbtn" onclick="goBack()">Cancel</button>
</div>
<script>
    function goBack() {
        window.history.back();  // Go back to the previous page
    }
</script>
<!-- header starts -->


<!-- header end -->

<!-- content starts -->

<?php
$count=0;

$no1= 1;
function convert_digit_to_words($no)  
	{   
	//creating array  of word for each digitASDJK
	 $words = array('0'=> 'Zero' ,'1'=> 'one' ,'2'=> 'two' ,'3' => 'three','4' => 'four','5' => 'five','6' => 'six','7' => 'seven','8' => 'eight','9' => 'nine','10' => 'ten','11' => 'eleven','12' => 'twelve','13' => 'thirteen','14' => 'fourteen','15' => 'fifteen','16' => 'sixteen','17' => 'seventeen','18' => 'eighteen','19' => 'nineteen','20' => 'twenty','30' => 'thirty','40' => 'forty','50' => 'fifty','60' => 'sixty','70' => 'seventy','80' => 'eighty','90' => 'ninty','100' => 'hundred','1000' => 'thousand','100000' => 'lac','10000000' => 'crore');
	 
	 //for decimal number taking decimal part
	 
	$cash=(int)$no;  //take number wihout decimal
	$decpart = $no - $cash; //get decimal part of number
	
	$decpart=sprintf("%01.2f",$decpart); //take only two digit after decimal
	
	$decpart1=substr($decpart,2,1); //take first digit after decimal
	$decpart2=substr($decpart,3,1);   //take second digit after decimal  
	
	$decimalstr='';
	
	//if given no. is decimal than  preparing string for decimal digit's word
	
	if($decpart>0)
	{
	 $decimalstr.="point ".$numbers[$decpart1]." ".$numbers[$decpart2];
	}
	if($no == 0)
	        return ' ';
	    else {
	    $novalue='';
	    $highno=$no;
	    $remainno=0;
	    $value=100;
	    $value1=1000;       
	            while($no>=100)    {
	                if(($value <= $no) &&($no  < $value1))    {
	                $novalue=$words["$value"];
	                $highno = (int)($no/$value);
	                $remainno = $no % $value;
	                break;
	                }
	                $value= $value1;
	                $value1 = $value * 100;
	            }       
	          if(array_key_exists("$highno",$words))  //check if $high value is in $words array
	              return $words["$highno"]." ".$novalue." ".convert_digit_to_words($remainno).$decimalstr;  //recursion
	          else {
	             $unit=$highno%10;
	             $ten =(int)($highno/10)*10;
	             return $words["$ten"]." ".$words["$unit"]." ".$novalue." ".convert_digit_to_words($remainno
	             ).$decimalstr; //recursion
	           }
	    }
	}
if (empty($res)) {
    echo "No data found.";
} else {
    foreach ($res as $row) {
        //print_r($row);
        if($flag=='Y' || $flag==''){
            include "payslip.php";
        }else{
            echo 'Please choose another date to see payslip';
        }
    }
}?>
<!-- content end -->



</body>
</html>