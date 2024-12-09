<?php 
echo "222222";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

error_reporting(E_ALL); // Disable all error reporting
session_start();
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

$clintid=$_SESSION['clientid'];
$group=$payrollAdmin->displayClientGroup($_SESSION['$clientGrp']);

$_SESSION['reporttitle']=$reporttitle;
$empid=$row['emp_id'];
$monthtit =  date('F Y',strtotime($row['sal_month']));
$reporttitle="PAYSLIP FOR THE MONTH ".strtoupper($monthtit);
$_SESSION['reporttitle'] = $reporttitle;

$emprows=$payrollAdmin->showtranhiEployeedetails($empid,$row['sal_month']);
$net_salary = $emprows['netsalary']; // This should already be calculated in your previous logic
$net_salary_word = strtolower(convertNumberToWords($net_salary)); 
$net_salary_words = ucfirst($net_salary_word);
$resclt=$payrollAdmin->displayClient($emprows['client_id']);
$_SESSION['client_name']=$resclt['client_name'];

$emprows1=$payrollAdmin->showEployeedetails($empid);
$desrows=$payrollAdmin->displayDesignation($emprows['desg_id']);
$deptrows=$payrollAdmin->displayDepartment($emprows['dept_id']);
$bankrows=$payrollAdmin->displayBank($emprows['bank_id']);
$tempc=$tcount%$per;
return;
$pdf=new PDF_HTML_Table();
$pdf->AddPage();
$pdf->SetFont('Arial','',8);
?>

    <div  <?php
	//&& $tempc!=1
    if($no1==$noofpay )
	{
	    
        echo 'class="page-bk"';
		$no1 = 1;
        }
	else{
		$no1++;
		}
   
echo $no1."@@@@@@@@@@@@2";
				?>  >
<?php 
function convertNumberToWords($number) {
    $numberInWords = new NumberFormatter("en", NumberFormatter::SPELLOUT);
    return ucfirst($numberInWords->format($number));
}


if($noofpay =="2" && $no1==1){echo "<div ><br><br><br><br><br><br><br><br><br><br><br><br><br></div>";}?>
<div class="header_bg row body">

<?php 	{	include("printheader2.php");
			$pdf->Cell(180,10,$_SESSION['client_name'],0,1,'C');
			$pdf->Cell(180,10,$_SESSION['reporttitle'],0,1,'C');
	}?>

</div>

<div style="height:3px"></div>
<?php
	
?>
   <div class="row" style="padding: 0 10px;">

            <table border="1" width="100%" style="margin-bottom:8px" >

                <tr>
                    <td height="10px" width="1%">Emp Id :</td><td height="10px" width="30%" colspan="2"><b><?php echo $row["emp_id"];?> <?php if($emprows1['ticket_no']!=""){ echo "(".$emprows1['ticket_no'].")";}?></b> </td>
                    <td height="10px" width="19%">Emp.Name :</td><td height="10px" width="38%"  colspan="3"><b><?php echo $emprows1["first_name"]." ".$emprows1["middle_name"]." ".$emprows1["last_name"]; ?></b></td>
					<?php
					//$pdf->Cell(200,50,'  ',0,1);
					$pdf->Cell(20,5,'Emp Id :',1,0);
					 $pdf->Cell(15,5,$row["emp_id"],'TB',0,'R');
					 if($emprows1['ticket_no']!=""){ $pdf->Cell(45,5, "(".$emprows1['ticket_no'].")",'TBR',0,'L');}
					 else {$pdf->Cell(45,5, " ",'TBR',0,'L');}
					$pdf->Cell(40,5,'Emp.Name :',1,0);
					 $pdf->Cell(60,5,$emprows1["first_name"]." ".$emprows1["middle_name"]." ".$emprows1["last_name"],1,1,'L');
					 
					 ?>
					
               </tr>
                <tr>
                    
                    <!-- commented by shraddha on 07-10-2024 if($resclt['pfcode']!=""){$cpfccode = $resclt['pfcode']." / ";}else{$cpfccode ="";}; -->
                    <td height="5px" width="15%">PF No.:</td><td height="5px" width="35%" colspan="2"><?php  echo $cpfccode.$emprows1["pfno"] ; //if ($emprows1["joindate"]!='0000-00-00'){echo date("d-m-Y", strtotime($emprows1["joindate"]));} ?></td>
                    <td height="5px" width="15%">Designation :</td><td height="5px" width="35%" colspan="3"><?php if( $desrows['mast_desg_name']!="N.A."){ 
					
						$desg1= $desrows['mast_desg_name'];
				
					
					
					echo $desg1;
					} ?>	

                    </td>
					<?php
					$pdf->Cell(20,5,'PF No.:',1,0);
					 $pdf->Cell(60,5,$cpfccode.$emprows1["pfno"],'TB',0,'L');
					$pdf->Cell(40,5,'Designation :',1,0);
					if( $desrows['mast_desg_name']!="N.A."){ $pdf->Cell(60,5,$desg1,1,1,'L');}
					else{$pdf->Cell(60,5,' ',1,1,'L');}
				
					
					?>

                </tr>
                <tr>
                    <td height="5px" width="16%">UAN :</td>
                    <td height="5px" width="34%" colspan="2"> <?php  echo $emprows1["uan"] ?></td>
				    <td height="5px" width="15%">Department :</td>
                    <td height="5px" width="35%"  colspan="3"> 
					<?php $dept1= "";
						if( $deptrows['mast_dept_name']!="N.A."){ 
						
						$dept1= $deptrows['mast_dept_name'];
						
						
						} 
						
						echo $dept1;
					 $pdf->Cell(20,5,'UAN :',1,0);
					 $pdf->Cell(60,5,$emprows1["uan"],'TB',0,'L');
					 $pdf->Cell(40,5,'Department :',1,0);
					 $pdf->Cell(60,5,$dept1,1,1,'L');	
						
						
						
						
						?>	
</td>
	
                </tr>




                <tr>
                    <td>ESI NO :</td>
                    <td colspan="2"> <?php echo $emprows['esino']; ?></td>
					<td height="5px" width="15%">Bank A/c No :</td>
                    <td height="5px" width="35%"  colspan="3"> <?php echo $emprows["bankacno"]; 
					
					 $pdf->Cell(20,5,'ESI No :',1,0);
					 $pdf->Cell(60,5,$emprows1["esino"],'TB',0,'L');
					 $pdf->Cell(40,5,'Bank A/c No :',1,0);
					 $pdf->Cell(60,5,$emprows["bankacno"],1,1,'L');	
					
					
					
					
					?></td>
				
					
					
	</tr>
		<tr>			
                    <td >Bank Name
                    </td>
					<td colspan="2"><?php $str1='';echo $bankrows['bank_name'];?></td>
				    <td height="5px" width="15%">Branch :</td>
                    <td height="5px" width="35%"  colspan="3"> <?php echo $bankrows['ifsc_code'].'-'.$bankrows['branch']; 
					
					
					 $pdf->Cell(20,5,'Bank Name :',1,0);
					 $pdf->Cell(60,5,$bankrows['bank_name'],'TB',0,'L');
					 $pdf->Cell(40,5,'Branch :',1,0);
					 $pdf->Cell(60,5,$bankrows['branch'],1,1,'L');	
					 $pdf->Cell(200,5,'  ',0,1);
					
					
					
					?>	</td>
					
                </tr>



            </table>
       <table>
    <tr>
        <td height="5px" width="15%">&nbsp;</td>
        <td height="5px" width="7%">&nbsp; </td>
        <td height="5px" width="14%">&nbsp;</td>
        <td height="5px" width="14%" align= 'right'><b>STD PAY</b></td>
        <td height="5px" width="17%" align= 'right'><b>EARNINGS</b></td>
        <td height="5px" width="16%"> &nbsp;</td>
        <td height="5px" width="16%"align= 'right' ><b>DEDUCTIONS</b></td>
    </tr>


   <tr>
 <?php
    $pdf->Cell(20,5,'',1,0);
	$pdf->Cell(15,5,'',1,0);
	$pdf->Cell(25,5,'',1,0);
	$pdf->Cell(20,5,'STD PAY',1,0);
	$pdf->Cell(40,5,'EARNINGS',1,0,'R');
	$pdf->Cell(30,5,'',1,0);
	$pdf->Cell(30,5,'DEDUCTIONS',1,1,'R');
	$i = 0;
	while ($i<=10)
	{
		$arr_inc_name[$i] = "";
		$pdf_arr_inc_name[$i] ="";
		$pdf_arr_ded_name[$i] ="";
		$arr_inc_std[$i] = "";
		$arr_inc_amt[$i] = "";
		$arr_ded_name[$i] = "";
		$arr_ded_amt[$i] = "";
		$arr_days_name[$i] = "";
		$arr_days_value[$i] = "";
		$i++;                   
	}
    $tran_day_emp_id = $row['emp_id'];
    $row1= $payrollAdmin->getEmpTranIncome($comp_id,$tran_day_emp_id,$row['sal_month']);
    $i = 1;
    $gr_sal = 0;
  
    foreach($row1 as $row_inc ){
        if($row_inc['amount'] > 0){
				$arr_inc_name[$i] = "&nbsp;<b>".$row_inc['income_heads_name']."</b>";
			    $pdf_arr_inc_name[$i] = "&nbsp;".$row_inc['short_name'];
    			$arr_inc_std[$i] = $row_inc['std_amt'];
        		$arr_inc_amt[$i] = $row_inc['amount'];
    			$gr_sal = $gr_sal +$row_inc['std_amt'];
        	    $i++;
        }
        else
        {
            
        }

    }
    $arr_inc_name[$i]='&nbsp;<b>GROSS SALARY</b>';
    $pdf_arr_inc_name[$i] = "&nbsp;GROSS SALARY";
    $arr_inc_std[$i] = number_format ( $gr_sal ,2,".",",");
    $arr_inc_amt[$i]=$emprows['gross_salary'];

    //deductions
    $j=1;
     	$row1= $payrollAdmin->getEmpTranDeduct($comp_id,$tran_day_emp_id,$row['sal_month']);
        foreach($row1 as $row_ded){
    
        if($row_ded['amount'] > 0){
    		$arr_ded_name[$j] = "&nbsp;<b>".$row_ded['deduct_heads_name']."</b>";
    		 $pdf_arr_ded_name[$j] = "&nbsp;".$row_ded['deduct_heads_name'];
    		$arr_ded_amt[$j] = $row_ded['amount'];
            $j++;
        }
        else{
    		
            $arr_ded_amt[$j]  = ' ';
        }
    
    }
    
    //advances
    	$row1= $payrollAdmin->getEmpTranAdvance($comp_id,$tran_day_emp_id,$row['sal_month']);
        foreach($row1 as $row_ded){
            $arr_ded_name[$j] = "&nbsp;<b>".$row_ded['advance_type_name']."</b>";
            if($row_ded['amount'] > 0){
                $arr_ded_amt[$j] = $row_ded['amount'];
            }else{
                $arr_ded_amt[$j]  = ' ';
            }
    	   $j++;
    }
    
    $arr_ded_name[$j] = "&nbsp;<b>".'TOTAL DEDUCT.</b>';
     $pdf_arr_ded_name[$j] = "&nbsp;TOTAL DEDUCT";
    $arr_ded_amt[$j] = $emprows['tot_deduct'];
      
    //Days Details
    
    
    
    $row1= $payrollAdmin->getEmpTranDays($tran_day_emp_id,$row['sal_month']);
    $k = 1;
    foreach($row1 as $row_days){
               if($row_days['present'] > 0) {
                   $arr_days_name[$k] = "&nbsp;<b>"."Present Days</b>";
                   $arr_days_value[$k] = $row_days['present'];
                   $k++;
               }
               if($row_days['absent'] > 0) {
                   $arr_days_name[$k] = "&nbsp;<b>"."Absent Days.</b>";
                   $arr_days_value[$k] = $row_days['absent'];
                   $k++;
               }
               if($row_days['weeklyoff'] > 0) {
                   $arr_days_name[$k] = "&nbsp;<b>"."Weekly Off.</b>";
                   $arr_days_value[$k] = $row_days['weeklyoff'];
                   $k++;
               }
               if($row_days['pl'] > 0) {
                   $arr_days_name[$k] = "&nbsp;<b>"."Paid Leave.</b>";
                   $arr_days_value[$k] = $row_days['pl'];
                   $k++;
               }
               if($row_days['sl'] > 0) {
                   $arr_days_name[$k] = "&nbsp;<b>"."Sick Leave.</b>";
                   $arr_days_value[$k] = $row_days['sl'];
                   $k++;
               }
               if ($row_days['cl'] > 0) {
                   $arr_days_name[$k] = "&nbsp;<b>"."Casual Leave.</b>";
                   $arr_days_value[$k] = $row_days['cl'];
                   $k++;
               }
               if($row_days['otherleave'] > 0) {
                   $arr_days_name[$k] = "&nbsp;<b>"."Other Leave.</b>";
                   $arr_days_value[$k] = $row_days['otherleave'];
                   $k++;
               }
               if($row_days['paidholiday'] > 0) {
                   $arr_days_name[$k] = "&nbsp;<b>"."Paid Holiday.</b>";
                   $arr_days_value[$k] = $row_days['paidholiday'];
                   $k++;
               }
			   
               if($row_days['additional'] > 0) {
					$arr_days_name[$k] = "&nbsp;<b>"."Additional Days.</b>";
                   $arr_days_value[$k] = $row_days['additional'];
                   $k++;
               }
               if($row_days['othours'] > 0 &&  $clientid != 5 &&  $clientid != 7 ) {
                   $arr_days_name[$k] = "&nbsp;<b>"."Ot Hours";
                   $arr_days_value[$k] = $row_days['othours'];
                   $k++;
               }
              if($row_days['nightshifts'] > 0) {
                   $arr_days_name[$k] = "&nbsp;<b>"."Night Shifts.</b>";
                   $arr_days_value[$k] = $row_days['nightshifts'];
                   $k++;
               }
                   $arr_days_name[$k] = "&nbsp;<b>"."Payable Days.</b>";
                   $arr_days_value[$k] = $emprows['payabledays'];

       }


	   
	   //$K - DAYS SUBSCRIPT $i - income subscript $j - deduction subscript
		if($i>=$j)
        {$maxrows = $i;}
        else
        {$maxrows = $j;}

		if ($maxrows>=$k)
        {}
        else
        {$maxrows = $k;}
//	    echo "  ** i= ".$i. "  **** j= ".$j."  ** k = ".$k."  Max= ". $maxrows. "  *********** ";

		for($l=1;$maxrows>=$l;$l++){
         echo "<tr>";
            if ($l <= $k)
			{
				echo "<td>".$arr_days_name[$l]."</td>
				<td  align='right'>".number_format( $arr_days_value[$l],2,".",",")."</td>";
                $pdf->Cell(20,5,substr($arr_days_name[$l],6),1,0,'L');
				$pdf->Cell(15,5,number_format($arr_days_value[$l],2,".",","),1,0,'R');
				}
            else
            {
				echo "<td> </td>	<td> </td>";
				$pdf->Cell(20,5,' ',1,0,'L');
				$pdf->Cell(15,5,' ',1,0,'L');
			}

            if ($l < $i)
			{
				//checking array subscript
				echo "<td>".$arr_inc_name[$l]."</td>
				<td align='right'>  ". number_format($arr_inc_std[$l],2,".",",")."</td>
				<td align='right'>".number_format( $arr_inc_amt[$l],2,".",",")."</td>";

                //$pdf->SetFont('Arial','B',8);
                $pdf->Cell(25,5,substr($pdf_arr_inc_name[$l],6),1,0,'L');
				$pdf->Cell(20,5,number_format($arr_inc_std[$l],2,".",","),1,0,'R');
				$pdf->Cell(40,5,number_format( $arr_inc_amt[$l],2,".",","),1,0,'R');
			}
			elseif ($l==$maxrows )
			{
				echo "<td>".$arr_inc_name[$i]."</td>
				<td align='right'>  ". $arr_inc_std[$i]."</td>
				<td align='right'>".number_format( $arr_inc_amt[$i],2,".",",")."</td>";

                $pdf->Cell(25,5,substr($pdf_arr_inc_name[$i],6),1,0,'L');
				$pdf->Cell(20,5, $arr_inc_std[$i],1,0,'R');
				$pdf->Cell(40,5,number_format( $arr_inc_amt[$i],2,".",","),1,0,'R');
			}
			else 
            {
               echo "<td></td>
				<td></td>
				<td></td>";

				$pdf->Cell(25,5,' ',1,0,'L');
				$pdf->Cell(20,5,' ',1,0,'L');
				$pdf->Cell(40,5,' ',1,0,'L');
				}

            if ($l < $j){         //checking array subscript
               echo "<td>".$arr_ded_name[$l]."</td>
				<td align='right' >".number_format( $arr_ded_amt[$l],2,".",",")."</td>";

                $pdf->Cell(30,5,substr( $pdf_arr_ded_name[$l],6),1,0,'L');
				$pdf->Cell(30,5,number_format( $arr_ded_amt[$l],2,".",","),1,1,'R');
				}
            elseif ($l== $maxrows){
               echo "<td >".substr($arr_ded_name[$j],6)."</td>
				<td align='right' >".number_format( $arr_ded_amt[$j],2,".",",")."</td>";

                $pdf->Cell(30,5,substr($pdf_arr_ded_name[$j],6),1,0,'L');
				$pdf->Cell(30,5,number_format( $arr_ded_amt[$j],2,".",","),1,1,'R');
				}
			else
            {
               echo "<td ></td>	<td ></td>";

                $pdf->Cell(30,5,' ',1,0,'L');
				$pdf->Cell(30,5,' ',1,1,'L');
			}

           echo "</tr>";
            
        }






   echo "
       <tr>
           <td class='thheading'>";
		   /* if ($reimbursement > 0)
			 {echo "REIMBURSEMENT";}
		
		    echo "</td> <td class='thheading'>";
			if ($reimbursement > 0)
			 {echo $reimbursement;} 
		    */
		   echo '</td>
           <td></td>
           <td></td>
           <td></td>
           <td></td>
           <td class="thheading">NET SALARY Rs.</td>
           <td align="right" class="thheading">'.number_format($emprows['netsalary'],2,".",",").'
           </td>
	   </tr>
	   <tr>
	   
           <td colspan="7" class="thheading">Net Salary in Words :  Rs. ' . $net_salary_words . ' Only/-
    </td>
	   </tr>
	  
	 
	</table>
	<p>This is a computer generated report hence does not require any signature.</h3>
    </div>
	<br/><br/>
	</div>';
	
		  /*  if ($reimbursement > 0)
			 {	$pdf->Cell(20,5,'REIMBURSEMENT',1,0);
			 $pdf->Cell(15,5,number_format($reimbursement,2,'.',','),1,0);}
			else{ */
				$pdf->Cell(20,5,' ',1,0);
				$pdf->Cell(15,5,' ',1,0);
			//} 	
			$pdf->Cell(25,5,'',1,0);
			$pdf->Cell(20,5,' ',1,0);
			$pdf->Cell(40,5,' ',1,0);
			$pdf->Cell(30,5,'NET SALARY Rs.',1,0);
			$pdf->Cell(30,5,number_format($emprows['netsalary'],2,".",","),1,1,'R');
			
			$pdf->Cell(0,10,'This is a computer generated report hence does not require any signature.',0,1,'L');
	
	$temp=$clintid.'_'.$emprows1["first_name"]."-".$emprows1["middle_name"]."-".$emprows1["last_name"].'_'.$monthtit;
    $name=$doc_path.'/pdffiles/payslip/'.$temp.'.pdf';
    $pdf->Output($name,'F');
				 /* Code for creating DOC files
				 $docfilename='../docfiles/payslip/'.$temp.'.doc';
				 $myfile = fopen($docfilename, "w") or die("Unable to open file!");


				 fclose($myfile);*/
				 fwrite($myfile, "<br><img src='../images/JSM-logo.jpg'> <br>$compname<br>$pdfHtml<br><br>");
					$pdfHtml='';
   echo  $count++;
?>