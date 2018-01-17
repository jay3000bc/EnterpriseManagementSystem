<?php include('../employee/include/header.php');
include_once '../PayrollManager.php';
$payrollManager = new PayrollManager();
$allPayrolls = $payrollManager->getAllEmployeePayroll($employee_id);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Payroll</h1>
            <ol class="breadcrumb">
                <li><a href="home.php"><i class="fa fa-dashboard"></i> Home</a></li>
                <li> Employees</li>
                <li class="active"><a href="payroll.php"> Payroll</a></li>
            </ol>
    </section>

<!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
            <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-body">
                        <?php if($allPayrolls !='') { ?>
                        <table id="display_payroll_table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Month &amp; Year </th>
                                    <th>Amount</th>
                                    <th>Payroll</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    for($i=0; $i< $allPayrolls; $i++) {
                                 ?>
                                <tr>
                                    <td><?php echo $i+1; ?></td>
                                    <td><?php $created_at = $payrollManager->created_at[$i]; echo date('F Y', strtotime("-1 months", strtotime($created_at)));
                                    ?></td>
                                    <td><?php echo $salaryPayCurrency.' '.$payrollManager->net_pay[$i]; ?></td>
                                    <td><a target="_blank" class="btn btn-sm btn-primary" href="<?php echo $relativeUrl;?>uploads/payroll_pdf/<?php echo $payrollManager->pdf_name[$i];?>">View</a></td>
                                    <td>
                                        <?php  
                                            if($payrollManager->status[$i] ==1) { ?>
                                                Salary Credited
                                        <?php } else { ?>
                                                Salary not Credited
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <?php } else { ?>
                        <p>It seems the Administrator has not provided any Payroll</p>
                        <?php } ?>
                    </div>    
                </div>
            </div>   
        </div>
     </section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include('../employee/include/footer.php'); ?>
<script type="text/javascript">
    $(document).ready(function(){
        var table = $('#display_payroll_table');
        table.DataTable({
            responsive: true,
            
            "lengthMenu": [
                [10, 20, 50, 100, -1],
                [10, 20, 50, 100, "All"] // change per page values here
            ]
            
        });
        
    });
</script>
</body>
</html>