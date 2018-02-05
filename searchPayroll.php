<?php 
$title = 'Search Payroll';
include('include/header.php');
include_once 'PayrollManager.php';
$payrollManager = new PayrollManager();
$allPayrolls = $payrollManager->listPayroll();
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Search Payroll</h1>
      <?php include_once('include/notificationBell.php'); ?>
    </section>

    <!-- Main content -->
    <section class="content">
    <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <!-- <div class="box-header with-border">
                      <h3 class="box-title">Search Invoice</h3>
                    </div> -->
                    <div class="box-body">
                        <div class="row">
                           <div class="col-md-3">
                                <div class="form-group">
                                    <label for="invoice_start_date">Period From</label>
                                    <!-- <input class="form-control" type="text" name="daterange"/> -->
                                    <input placeholder="From" type="text" name="min" id="min" class="selectDate form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="invoice_start_date">Period To</label>
                                    <!-- <input class="form-control" type="text" name="daterange"/> -->
                                    <input placeholder="To" type="text" name="max" id="max" class="selectDate form-control">
                                </div>
                            </div>
                            
                        </div>
                        <div class="row">     
                            <div class="col-md-12">
                                <table id="display_payroll_table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Employee Id</th>
                                    <th>Employee Name</th>
                                    <th>Month &amp; Year </th>
                                    <th>Amount</th>
                                    <th>Payroll</th>
                                    <th>Status</th>
                                    <th>Created on</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    for($i=0; $i< $allPayrolls; $i++) {
                                 ?>
                                <tr>
                                    <td><?php echo $i+1; ?></td>
                                    <td><?php echo $payrollManager->employee_id[$i]; ; ?></td>
                                    <td><?php echo $payrollManager->name[$i]; ; ?></td>
                                    <td><?php $created_at = $payrollManager->created_at[$i]; echo date('F Y', strtotime("-1 months", strtotime($created_at)));
                                    ?></td>
                                    <td><?php echo $salaryPayCurrency.' '.$payrollManager->net_pay[$i]; ?></td>
                                    <td><a target="_blank" href="<?php echo $absoluteUrl.'uploads/payroll_pdf/'.$payrollManager->pdf_name[$i];?>"><u>View</u></a></td>
                                    <td>
                                        <?php  
                                            if($payrollManager->status[$i] ==1) { ?>
                                                Salary Credited
                                        <?php } else { ?>
                                                Salary not Credited
                                        <?php } ?>
                                    </td>
                                    <td><?php echo $payrollManager->created_at[$i]; ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                            </div>
                        </div>
                    </div>
            <!-- /.box -->
            </div>
        </div>
        <!-- /.row -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include('include/footer.php');?>
<!-- Date Range Picker -->
<script type="text/javascript">
    //Date picker
    var start = moment().subtract(29, 'days').format('YYYY/MM/DD');
    var end = moment().format('YYYY/MM/DD');
    //alert(end);
    $('#min').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        endDate :end 
    });
    $('#max').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        endDate :end 
    });

</script>
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

/* Custom filtering function which will search data in column four between two values */
$(document).ready(function () { 
    $.fn.dataTableExt.afnFiltering.push(
        function( oSettings, aData, iDataIndex ) {
            var iFini = document.getElementById('min').value;
            var iFfin = document.getElementById('max').value;
            var iStartDateCol = 7;
            var iEndDateCol = 7;
     
            iFini=iFini.substring(6,10) + iFini.substring(3,5)+ iFini.substring(0,2);
            iFfin=iFfin.substring(6,10) + iFfin.substring(3,5)+ iFfin.substring(0,2);
     
            var datofini=aData[iStartDateCol].substring(6,10) + aData[iStartDateCol].substring(3,5)+ aData[iStartDateCol].substring(0,2);
            var datoffin=aData[iEndDateCol].substring(6,10) + aData[iEndDateCol].substring(3,5)+ aData[iEndDateCol].substring(0,2);
     
            if ( iFini === "" && iFfin === "" )
            {
                return true;
            }
            else if ( iFini <= datofini && iFfin === "")
            {
                return true;
            }
            else if ( iFfin >= datoffin && iFini === "")
            {
                return true;
            }
            else if (iFini <= datofini && iFfin >= datoffin)
            {
                return true;
            }
            return false;
        }
    );
    var table = $('#display_payroll_table').DataTable();
    table.draw();

    $('#min, #max').change(function () {
            table.draw();
        
    });
});
</script>
</body>
</html>