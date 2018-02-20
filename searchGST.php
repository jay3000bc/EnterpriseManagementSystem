<?php 
$title = 'Search GST';
date_default_timezone_set('Asia/Kolkata');
include_once('settings/config.php');
include_once('include/header.php');
include_once 'GSTManager.php';
$GSTManager = new GSTManager();
$getCreatedInvoicebyMonth = $GSTManager->getCreatedInvoicebyMonth();
$getReceivedInvoicebyMonth = $GSTManager->getReceivedInvoicebyMonth();
$resultGSTPeriod = $GSTManager->getAllGSTPeriod();
?>
<style type="text/css">
    table {
        font-size: 14px;
    }
    .ui-datepicker-calendar {
        display: none;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Search GST</h1>
      <?php include_once('include/notificationBell.php'); ?>
    </section>

    <!-- Main content -->
    <section class="content">
    <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                      <div class="row">
                          <div class="col-md-3">
                              <div class="form-group">
                                  <label for="period">Search by Period :</label>
                                  <input value="ALL" name="period" id="period" class="form-control" />
                              </div>
                          </div>
                          <div class="col-md-9">
                            <div class="form-group">
                                <label for="period" style="opacity:0;">Reset</label><br>
                                <input value="Reset" class="reset-table btn btn-primary">
                            </div>  
                          </div>
                      </div>
                    </div>
                    <div class="box-body">
                        <div class="row">  
                            <div class="col-md-12">
                                <table id="display_gst_table" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>SL No.</th>
                                            <th>Period</th>
                                            <th>Status</th>
                                            <th>View</th>
                                            <th>Download Excel</th>
                                            <th>Download pdf</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if($getCreatedInvoicebyMonth > $getReceivedInvoicebyMonth)  {
                                            for($i=0; $i < $getCreatedInvoicebyMonth; $i++) {
                                         ?>   
                                        <tr>
                                            <td><?php echo $i+1;?></td>
                                            <td><?php $invoice_paid_date = $GSTManager->created_invoice_date_monthly[$i];
                                                $period = date('Y-m', strtotime($invoice_paid_date));
                                            echo date('M Y', strtotime($invoice_paid_date));?></td>
                                            <td>
                                            <?php 
                                            for($j=0; $j < $resultGSTPeriod; $j++) {

                                                if($GSTManager->period[$j] == $period) {
                                                    $generatedStatus = 'GENERATED';
                                                    
                                                }  
                                            } 
                                            if(isset($generatedStatus)) { ?>
                                            <span class="text-success">GENERATED</span>
                                            <?php } else  { ?>
                                            <span class="text-danger" style="color:#FF0000;">NOT GENERATED</span>
                                            <?php } ?>
                                            </td>
                                            <td><a href="viewGST?period=<?php echo $period; ?>">View</a></td>
                                            <?php 
                                            if($GSTManager->period[$i] == $period) { ?>
                                            <td><a target="_blank" href="uploads/GST/<?php echo $period;?>.xlsx">Download Excel</a></td>
                                            <td><a target="_blank" href="uploads/GST/<?php echo $period;?>.pdf">Download pdf</a></td>
                                            <?php } else { ?>
                                            <td><a class="current-page" href="uploads/GST/<?php echo $period;?>.xlsx">Download Excel</a></td>
                                            <td><a class="current-page" href="uploads/GST/<?php echo $period;?>.pdf">Download pdf</a></td>  
                                            <?php } ?>  
                                        </tr>
                                        <?php } 
                                        } else { 
                                        for($i=0; $i < $getReceivedInvoicebyMonth; $i++) {
                                         ?>   
                                        <tr>
                                            <td><?php echo $i+1;?></td>
                                            <td><?php $invoice_paid_date = $GSTManager->receive_invoice_date_monthly[$i];
                                                $period = date('Y-m', strtotime($invoice_paid_date));
                                            echo date('M Y', strtotime($invoice_paid_date));?></td>
                                            <td>
                                            <?php 
                                            for($j=0; $j < $resultGSTPeriod; $j++) {

                                                if($GSTManager->period[$j] == $period) {
                                                    $generatedStatus = 'GENERATED';
                                                    
                                                }  
                                            } 
                                            if(isset($generatedStatus)) {
                                            ?>

                                            <span class="text-success">GENERATED</span>
                                            <?php } else  { ?>
                                            <span class="text-danger" style="color:#FF0000;">NOT GENERATED</span>
                                            <?php } ?>
                                            </td>
                                            <td><a href="viewGST?period=<?php echo $period; ?>">View</a></td>
                                            <?php 
                                            if($GSTManager->period[$i] == $period) { ?>
                                            <td><a target="_blank" href="uploads/GST/<?php echo $period;?>.xlsx">Download Excel</a></td>
                                            <td><a target="_blank" href="uploads/GST/<?php echo $period;?>.pdf">Download pdf</a></td>
                                            <?php } else { ?>
                                            <td><a class="current-page" href="uploads/GST/<?php echo $period;?>.xlsx">Download Excel</a></td>
                                            <td><a class="current-page" href="uploads/GST/<?php echo $period;?>.pdf">Download pdf</a></td>  
                                            <?php } ?>  
                                        </tr>
                                        <?php } 
                                        } ?>
                                     </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.box -->
                </div>
            </div>
        </div>
        <!-- /.row -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include('include/footer.php');?>
<script type="text/javascript">
$(document).ready(function(){
    // month year picker
    var end = moment().subtract(1, 'month').format('MM/YYYY');
    //alert(end);
    $("#period").datepicker( {
        autoclose: true,
        format: "M yyyy",
        viewMode: "months", 
        minViewMode: "months",
        endDate :end 
    });
    // datatable
    var table = $('#display_gst_table');
    table.DataTable({
        responsive: true,
        
        "lengthMenu": [
            [10, 20, 50, 100, -1],
            [10, 20, 50, 100, "All"] // change per page values here
        ]
        
    });

    // custom search data table by colomn period
    var table = $('#display_gst_table').DataTable();
    $('#period').on('change', function () {
        var v =$(this).val();  // getting search input value
        table.columns(1).search(v).draw();
    });
    // if gst not generated
    $('a.current-page').click(function() {
        swal('Sorry','GST has not been generated yet', 'error');
        return false; 
    });
    //  reset-table
    $('.reset-table').click(function(){
        $('#period').val('ALL');
        table.search('').columns().search('').draw();
    });
});
</script>
</body>
</html>