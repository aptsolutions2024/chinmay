<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

$id=$_REQUEST['id'];
$view=$_REQUEST['view'];
?>
<div class="twelve">
        <?php


        $resad=$payrollAdmin->displayAdvances($id);
        $adcount=sizeof($resad);

                        ?>

        <table width="100%"  >
            <tr>
                <th align="left" width="5%">Sr.No</th>


                <th align="left" width="10%">Advance Type</th>
                <th align="left" width="30%">Advances Amount</th>
                <th align="left" width="25%">Advances Installment</th>
                <th align="left" width="20%">Date</th>

                <th align="center" width="10%">Action</th>

            </tr>

            <?php $count=1;
            if($adcount!=0) {
                echo '<pre>';
                print_r($resad);
                foreach($resad as $rowad) {
                
                    ?>
                    <tr>
                        <td class="tdata"><?php echo $count; ?></td>



                        <td class="tdata"><?php
                                           $adname=$payrollAdmin->displayAdvancetype($rowad['advance_type_id']);
                            echo $adname['advance_type_name'];
                            ?></td>
                        <td class="tdata"><?php echo $rowad['adv_amount']; ?></td>
                        <td class="tdata"><?php echo $rowad['adv_installment']; ?></td>
                        <td class="tdata"><?php if($rowad['date']!="") { echo date("d-m-Y", strtotime($rowad['date'])); }?></td>
                        <td class="tdata" align="center">
                            <?php if($view!='1'){?>
                            <a href="javascript:void(0)" onclick="editadrow(<?php echo $rowad['emp_advnacen_id']; ?>)">
                                <img src="Payroll/images/edit-icon.png"/></a>
                        <?php } ?>
                            <a href="javascript:void(0)" onclick="deleteadrow(<?php echo $rowad['emp_advnacen_id']; ?>)">
                                <img src="Payroll/images/delete-icon.png"/></a>
                        </td>

                    </tr>
                    <?php
                    $count++;
                }
            }
            else{
                ?>
            <tr align="center">
                <td colspan="6" class="tdata errorclass">
                    <span class="norec">No Record found</span>
                </td>
            <tr>
            <?php
            }
            ?>

        </table>
</div>
