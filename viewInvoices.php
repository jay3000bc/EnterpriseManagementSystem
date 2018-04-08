<?php 
$title = 'View Invoices';
include('include/header.php');
include_once 'DBManager.php';
include_once 'InvoiceManager.php';
$DBManager = new DBManager();
if(isset($_POST['invoice_type'])) {
    include_once 'InvoiceManager.php';
    $invoiceManager = new InvoiceManager();
    if($_POST['invoice_type'] == 0) {
        $invoiceManager = new InvoiceManager();
        $result = $invoiceManager->listInvoices();
    } else {
        $invoiceManager = new InvoiceManager();
        $result = $invoiceManager->listReceivedInvoices();
    } 
} else {
    $invoiceManager = new InvoiceManager();
    $result = $invoiceManager->listInvoices(); 
}


?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>View Invoices</h1>
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
                                <form id="filtetInvoice" method="POST" action="viewInvoices">
                                    <div class="form-group">
                                        <label for="invoice_type">Invoice Type </label>
                                        <select id="invoice_type" name="invoice_type" class="form-control">
                                            <option value="">Select Invoice Type</option>
                                            <?php if(isset($_POST['invoice_type'] )) {?>
                                            <option value="0" <?php if($_POST['invoice_type'] == 0) echo 'selected';?>>Created Invoice</option>
                                            <option value="1" <?php if($_POST['invoice_type'] == 1) echo 'selected';?>>Received Invoice</option>
                                            <?php }  else { ?>
                                            <option value="0" selected>Created Invoice</option>
                                            <option value="1" >Received Invoice</option>
                                            <?php } ?>
                                        </select>
                                    </div>    
                                </form>
                            </div>
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
                                <h4>
                                    <?php if(isset($_POST['invoice_type']) and ($_POST['invoice_type'] ==1 )) { ?>
                                        <b>Showing "Received invoices"</b>
                                    <?php } elseif(isset($_POST['invoice_type']) and ($_POST['invoice_type'] == 0 )) { ?>
                                    <b>Showing "Created invoices"</b>
                                    <?php } else {  ?>
                                    <b>Showing "Created invoices"</b>
                                    <?php } ?> 
                                </h4>
                                <hr>
                            </div>    
                            <div class="col-md-12">
                                <table id="display_employee_table" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <?php if(isset($_POST['invoice_type']) and ($_POST['invoice_type'] ==1 )) { ?>
                                            <th>#</th>
                                            <th>Invoice Id</th>
                                            <th>Seller Name</th>
                                            <th>Created At</th>
                                            <th>Amount</th>
                                            <th>Invoice pdf</th>
                                            <th>Status</th>
                                            <?php } else { ?>
                                            <th>#</th>
                                            <th>Invoice Id</th>
                                            <th>Client Name</th>
                                            <th>Created At</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        for($i=0; $i< $result; $i++) {
                                         ?>   
                                        <tr>
                                            <td><?php echo $i+1;?></td>
                                            <td><?php echo $invoiceManager->invoice_id[$i];?></td>
                                            <td><?php echo $invoiceManager->client_name[$i];?></td>
                                            <td><?php echo $invoiceManager->invoice_date[$i];?></td>
                                            <?php 
                                            foreach ($currencies as $key => $currency) {
                                                if($key == $invoiceManager->currency_type[$i]) {
                                                    $currency_type = $currency;
                                                } 
                                            } ?>
                                            <td><?php echo $currency_type.' '. sprintf('%0.2f', $invoiceManager->invoice_amount[$i]);?></td>
                                            <td>
                                                <select class="form-control status" name="status">
                                                    <option <?php if($invoiceManager->status[$i] == 0) echo 'selected';?> value="0">Unpaid</option>
                                                    <option <?php if($invoiceManager->status[$i] == 1) echo 'selected';?> value="1">Paid</option>
                                                </select>
                                                <input type="hidden" name="id" value="<?php echo $invoiceManager->invoice_id[$i];?>">
                                            </td>
                                            <td>
                                                <?php 
                                                if(isset($_POST['invoice_type']) and ($_POST['invoice_type'] ==1)) { ?>
                                                <a target="_blank" href="uploads/invoices/receivedInvoice/<?php echo $invoiceManager->upload_invoice[$i];?>"><u>View</u></a>
                                                <?php } else { ?>
                                                <a target="_blank" href="uploads/invoices/createdInvoice/<?php echo $invoiceManager->invoice_id[$i];?>.pdf"><u>View</u></a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php
                                        }
                                        ?>
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
<?php include('include/footer.php');
if(isset($_POST['invoice_type'])) { ?>
<script type="text/javascript">

    // change sataus
    $('.status').change(function() {
        var select_box = $(this);
        var status = $(this).val();
        var invoice_id = $(this).next('input').val();
        var invoice_type = '<?php echo $_POST['invoice_type'];?>';
        $.ajax({
            url: "InvoiceController.php",
            type: "post",
            cache: false,
            data: { "invoice_id": invoice_id, "status": status, "invoice_type": invoice_type },
            success: function(result) {
                if (result=='success') {
                    if(status == 0) {
                        
                    }
                    else if(status == 1) {
                        
                    }
                    else {
                        
                    }
                }
                else {
                    swal("Something Went Wrong!!!");
                }
            }
        });
    });

</script>
<?php 
} else { ?>
    <script type="text/javascript">

    // change sataus
    $('.status').change(function() {
        var select_box = $(this);
        var status = $(this).val();
        var invoice_id = $(this).next('input').val();
        var invoice_type = 0;
        $.ajax({
            url: "InvoiceController.php",
            type: "post",
            cache: false,
            data: { "invoice_id": invoice_id, "status": status, "invoice_type": invoice_type },
            success: function(result) {
                if (result=='success') {
                    if(status == 0) {
                        
                    }
                    else if(status == 1) {
                        
                    }
                    else {
                        
                    }
                }
                else {
                    swal("Something Went Wrong!!!");
                }
            }
        });
    });

</script>
<?php
} 
?>

<script>
    //Date picker
    var start = moment().subtract(29, 'days').format('DD/MM/YYYY');
    var end = moment().format('DD/MM/YYYY');
    //alert(end);
    $('#min').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy',
        endDate :end 
    });
    $('#max').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy',
        endDate :end 
    });




</script>
<script type="text/javascript">
$(document).ready(function(){
    var table = $('#display_employee_table');
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
            var iStartDateCol = 3;
            var iEndDateCol = 3;
     
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
    var table = $('#display_employee_table').DataTable();
    table.draw();

    $('#min, #max').change(function () {
            table.draw();
        
    });
    $('#invoice_type').change(function() {
        $('#filtetInvoice').submit();
    });
});
</script>
</body>
</html>