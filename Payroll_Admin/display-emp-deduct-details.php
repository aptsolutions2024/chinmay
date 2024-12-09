<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

$id = $_REQUEST['id'];
$view = $_REQUEST['view'];
?>
<div class="twelve" style="background-color: #fff;">
    <?php
    $resde = $payrollAdmin->displayDedincome($id);
    $decount = sizeof($resde);
    ?>

    <table width="100%">
        <tr>
            <th align="left" width="5%">Sr.No</th>
            <th align="left" width="20%">Deduction Heads</th>
            <th align="left" width="25%">Calculation Type</th>
            <th align="left" width="20%">STD Amount</th>
            <th align="left" width="20%">Remark</th>
            <th align="center" width="10%">Action</th>
        </tr>

        <?php
        $count = 1;
        if ($decount != 0) {
            // Create an array to hold deduction heads
            $deductionHeads = [];
            foreach ($resde as $rowde) {
                $rs1 = $payrollAdmin->displayDeductionhead($rowde['head_id']);
                $deductionHeads[] = [
                    'emp_deduct_id' => $rowde['emp_deduct_id'],
                    'deduct_heads_name' => $rs1['deduct_heads_name'],
                    'calc_type' => $rowde['calc_type'],
                    'std_amt' => $rowde['std_amt'],
                    'remark' => $rowde['remark']
                ];
            }

            // Sort the deduction heads in ascending order by name
            usort($deductionHeads, function($a, $b) {
                return strcmp($a['deduct_heads_name'], $b['deduct_heads_name']); // Ascending order
            });

            // Display the sorted data
            foreach ($deductionHeads as $row) {
                ?>
                <tr>
                    <td class="tdata"><?php echo $count; ?></td>
                    <td class="tdata"><?php echo $row['deduct_heads_name']; ?></td>
                    <td class="tdata"><?php
                        // Display calculation type based on the value
                        switch ($row['calc_type']) {
                            case '1':
                                echo "Month's Days - Weeklyoff(26/27)";
                                break;
                            case '2':
                                echo "Month's Days - (30/31)";
                                break;
                            case '3':
                                echo "Consolidated";
                                break;
                            case '4':
                                echo "Hourly Basis";
                                break;
                            case '5':
                                echo "Daily Basis";
                                break;
                            case '6':
                                echo "Quarterly";
                                break;
                            case '7':
                                echo "As per Govt. Rules";
                                break;
                            default:
                                echo '-';
                        }
                        ?></td>
                    <td class="tdata"><?php echo $row['std_amt']; ?></td>
                    <td class="tdata"><?php echo $row['remark']; ?></td>
                    <td class="tdata" align="center">
                        <?php if ($view != '1') { ?>
                            <a href="javascript:void(0)" onclick="editderow(<?php echo $row['emp_deduct_id']; ?>)">
                                <img src="Payroll/images/edit-icon.png"/></a>
                        <?php } ?>
                        <a href="javascript:void(0)" onclick="deletederow(<?php echo $row['emp_deduct_id']; ?>)">
                            <img src="Payroll/images/delete-icon.png"/></a>
                    </td>
                </tr>
                <?php
                $count++;
            }
        } else {
            ?>
            <tr align="center">
                <td colspan="6" class="tdata errorclass">
                    <span class="norec">No Record found</span>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>
