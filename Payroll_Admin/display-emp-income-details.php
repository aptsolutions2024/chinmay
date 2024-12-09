<?php
$doc_path = $_SERVER["DOCUMENT_ROOT"];
include($doc_path . '/include_payroll_admin.php');

if ($_SESSION['log_type'] != 2) {
    echo "<script>window.location.href='/payroll-logout';</script>";
    exit();
}

$id = $_REQUEST['id'];
$view = $_REQUEST['view'];
?>
<div class="twelve">
    <?php
    $resei = $payrollAdmin->displayEmpincome($id);
    $eicount = sizeof($resei);
    ?>

    <table width="100%">
        <tr>
            <th align="left" width="5%">Sr.No</th>
            <th align="left" width="20%">Income Heads</th>
            <th align="left" width="25%">Calculation Type</th>
            <th align="left" width="20%">STD Amount</th>
            <th align="left" width="20%">Remark</th>
            <th align="center" width="10%">Action</th>
        </tr>

        <?php
        $count = 1;
        if ($eicount != 0) {
            // First, create an array to hold income heads
            $incomeHeads = [];
            foreach ($resei as $rowei) {
                $rs1 = $payrollAdmin->displayIncomehead($rowei['head_id']);
                $incomeHeads[] = [
                    'emp_income_id' => $rowei['emp_income_id'],
                    'income_heads_name' => $rs1['income_heads_name'],
                    'calc_type' => $payrollAdmin->getIncomeCalculationTypeByid($rowei['calc_type']),
                    'std_amt' => $rowei['std_amt'],
                    'remark' => $rowei['remark']
                ];
            }

            // Sort the income heads in ascending order by name
            usort($incomeHeads, function($a, $b) {
                return strcmp($a['income_heads_name'], $b['income_heads_name']); // Change here for ascending order
            });

            // Display the sorted data
            foreach ($incomeHeads as $row) {
                ?>
                <tr>
                    <td class="tdata"><?php echo $count; ?></td>
                    <td class="tdata"><?php echo $row['income_heads_name']; ?></td>
                    <td class="tdata"><?php echo $row['calc_type']; ?></td>
                    <td class="tdata"><?php echo $row['std_amt']; ?></td>
                    <td class="tdata"><?php echo $row['remark']; ?></td>
                    <td class="tdata" align="center">
                        <?php if ($view != '1') { ?>
                            <a href="javascript:void(0)" onclick="editeirow(<?php echo $row['emp_income_id']; ?>)">
                                <img src="Payroll/images/edit-icon.png"/></a>
                        <?php } ?>
                        <a href="javascript:void(0)" onclick="deleteeirow(<?php echo $row['emp_income_id']; ?>)">
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
