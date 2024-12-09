<?php
include ('../../include_payroll_admin.php');

$start_pfno = $_REQUEST['start_pfno'];
$end_pfno = $_REQUEST['end_pfno'];
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];

	
?>

<!DOCTYPE html>

<html lang="en-US">
<head>

    <meta charset="utf-8"/>


    <title> &nbsp;</title>

    <style>
        .thheading{
            text-transform: uppercase;
            font-weight: bold;
            background-color: #fff;
            font-size:8px !important;
        }
        .heading{
            margin: 20px 30px;
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

        }

        table, td, th {
            padding: 5px!important;
            border: 1px dotted black!important;
            font-size:12px !important;
            font-family: monospace;
			
        }
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
		
		@page {
   
				margin: 15mm 16mm 27mm 16mm;
			}

    </style>
</head>
<body>
<div class="btnprnt">
    <button class="submitbtn" onclick="myFunction()">Print</button>
    <button class="submitbtn"  onclick="history.go(-1);" >Cancel</button>
</div>
<div class="clear" style="clear:both;"></div>
<div class="page-bk">
  <div class="row page">

      <div class="twelve" align="center">
      <h6> THE EMPLOYEES' PROVIDENT FUND SCHEME  </h6>
	  <h4>                        Form No.9  (Revised)  </h4>
	  
	 <br><br><br> 
      </div>
<table width="100%" style= "border:0">
	
	<tr>
       <th class="thheading" WIDTH = "3%">SR NO (1) </th>
		<th class="thheading" WIDTH = "7%" >PF AC NO (2)</th>
		<th class="thheading" WIDTH = "20 %">NAME OF THE EMP.</th>
        <th class="thheading" >MIDDLE NAME<BR>FATHER / HASBAND</th>
		
       <th class="thheading" WIDTH = "10%">AGE </th>
		<th class="thheading" WIDTH = "3%"> SEX </th>
		<th class="thheading" WIDTH = "10%" > DATE OF ELIG. FOR MEMBERSHIP</th>
        <th class="thheading" WIDTH = "5%" >TOTAL PERIOD OF PREV.SERVICE</th>

       <th class="thheading"  WIDTH = "10%"> DATE OF JOINING F.P.F. </th>
		<th class="thheading"  WIDTH = "5%">FOLIO NO OF LEGER CARD</th>
		<th class="thheading" WIDTH = "3%" >INI. OF H.C.</th>
        <th class="thheading"  WIDTH = "10%" >DATE & REASON OF LEAVING SERVICE</th>

        <th class="thheading" WIDTH='20%'>REMARKS & INIT. ON SETTLEMENT D.C.H.C.A.O. EPF. FPF DLI.</th>
		</tr>
<tr>


<!-- header starts -->


<!-- header end -->

<!-- content starts -->

<?php
$res=$payrollAdmin->getform9($start_pfno,$end_pfno,$comp_id);
$tot_std_amt = 0;
$tot_amount = 0;
$tot_employer_contri_1 = 0;
$tot_employer_contri_2 = 0;
$srno= 0;
$cnt= 0;
$page=1;
foreach($res as $row)
	{ $srno++;$cnt++;
    if (($cnt>6 && $page==1  ) || ($cnt>6 && $page>1  ))
	{  $page++;
		if ($srno >0){echo "</div>";$cnt=0;}
		?> </table><div class='page-bk' >
<table width='100%' style= 'border:0'>
	
	
	<tr>
       <th class="thheading" WIDTH = "3%">SR NO (1) </th>
		<th class="thheading" WIDTH = "7%" >PF AC NO (2)</th>
		<th class="thheading" WIDTH = "20 %">NAME OF THE EMP.</th>
        <th class="thheading" >MIDDLE NAME<BR>FATHER / HASBAND</th>
		
       <th class="thheading" WIDTH = "10%">AGE </th>
		<th class="thheading" WIDTH = "3%"> SEX </th>
		<th class="thheading" WIDTH = "10%" > DATE OF ELIG. FOR MEMBERSHIP</th>
        <th class="thheading" WIDTH = "5%" >TOTAL PERIOD OF PREV.SERVICE</th>

       <th class="thheading"  WIDTH = "10%"> DATE OF JOINING F.P.F. </th>
		<th class="thheading"  WIDTH = "5%">FOLIO NO OF LEGER CARD</th>
		<th class="thheading" WIDTH = "3%" >INI. OF H.C.</th>
        <th class="thheading"  WIDTH = "10%" >DATE & REASON OF LEAVING SERVICE</th>

        <th class="thheading" WIDTH='20%'>REMARKS & INIT. ON SETTLEMENT D.C.H.C.A.O. EPF. FPF DLI.</th>
		</tr>
<tr> 
	<?php 	

	}



	echo "<tr>
	        <td >" . $srno."</td>
			<td >".$row['pfno']."</td>
			<td >".$row['first_name']." ".$row['last_name']."</td>
			<td >".$row['middle_name']."</td>
			<td >".date('d-m-Y', strtotime($row['bdate']))."</td>
			<td >".$row['gender']."</td>
			<td >".date('d-m-Y', strtotime($row['joindate']))."</td>
			<td></td>
			<td >".date('d-m-Y', strtotime($row['joindate']))."</td>

			<td></td>
			<td></td>
			<td >";
			if (date('d-m-Y', strtotime($row['leftdate']))>date('d-m-Y', strtotime('2000-01-01')) ){
				echo date('d-m-Y', strtotime($row['leftdate']));}
			echo "</td>
			<td ><BR><BR><BR><BR><BR></td>
			</tr>";
			
    }


?>


</table>
<div>
SIGNATURE OF EMPLOYER
<br>  (WITH OFFICIAL SEAL)
	
</div>
<!--     <div  <?php
    if($tcount>$count && $tempc!=1){
                echo 'class="page-bk"';
                } ?>  >
<div class="header_bg"><?php //include("printheader1.php"); ?>


</div>

<br /> -->

<!-- content end -->

<script>
    function myFunction() {
        window.print();
    }
</script>


</body>
</html>