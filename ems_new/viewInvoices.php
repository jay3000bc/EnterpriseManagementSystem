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
                                            <th>Status</th>
                                            <th>Invoice pdf</th>
                                            <th>Credit Note</th>
                                            <?php } else { ?>
                                            <th>#</th>
                                            <th>Invoice Id</th>
                                            <th>Client Name</th>
                                            <th>Created At</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                            <th>Credit Note</th>
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
                                                if(isset($_POST['invoice_type']) and ($_POST['invoice_type'] ==1)) { 
                                                    if(($invoiceManager->upload_invoice[$i]) != '') {
                                                    ?>
                                                <a title="View" target="_blank" class="btn btn-sm btn-primary" href="uploads/invoices/receivedInvoice/<?php echo $invoiceManager->upload_invoice[$i];?>"><i class="fa fa-eye"></i></a>
                                                <?php } else {
                                                    echo 'N/A';
                                                    }
                                                } else { ?>
                                                <a title="View" target="_blank" class="btn btn-sm btn-primary" href="uploads/invoices/createdInvoice/<?php echo $invoiceManager->invoice_id[$i];?>.pdf"><i class="fa fa-eye"></i></a>
                                                <a title="Edit" href="editCreatedInvoice?invoice_id=<?php echo $invoiceManager->invoice_id[$i];?>" class="btn btn-sm btn-success"><i class="fa fa-pencil"></i></a>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php
                                                $creditNoteButton = '';
                                                if($invoiceManager->status[$i]== 1) { 
                                                        $creditNoteButton = 'display:none;';
                                                    } 
                                                if(isset($_POST['invoice_type']) and ($_POST['invoice_type'] ==1)) {
                                                     ?>

                                                    <a style="<?php echo $creditNoteButton;?>" id="creditNote<?php echo $invoiceManager->invoice_id[$i];?>" href="#creditNoteAddModal" data-toggle="modal" data-id="<?php echo $invoiceManager->invoice_id[$i];?>"
                                                data-type="1"
                                                data-creditnote="<?php echo $invoiceManager->credit_note[$i];?>"
                                                  class="btn btn-sm btn-primary creditNoteAddModal">Credit Note</a>
                                                <?php } else {
                                                    
                                                 ?>
                                                <a style="<?php echo $creditNoteButton;?>" id="creditNote<?php echo $invoiceManager->invoice_id[$i];?>" href="#creditNoteAddModal" data-toggle="modal" data-id="<?php echo $invoiceManager->invoice_id[$i];?>"
                                                data-type="0"
                                                data-creditnote="<?php echo $invoiceManager->credit_note[$i];?>"
                                                  class="btn btn-sm btn-primary creditNoteAddModal">Credit Note</a>
                                                
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

                        $('#creditNote'+invoice_id).css('display','inline-block');
                    }
                    else if(status == 1) {
                        $('#creditNote'+invoice_id).css('display','none');
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
                        $('#creditNote'+invoice_id).css('display','inline-block');
                    }
                    else if(status == 1) {
                        $('#creditNote'+invoice_id).css('display','none');
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
if(isset($_SESSION['successMsg'])) {
?>
<script type="text/javascript">
    swal('Congrats','Invoice generated successfully', 'success');
</script>

<?php   
unset($_SESSION['successMsg']);
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
<!-- credit Note Modal -->
<script type="text/javascript">
    var current_object
    $('.creditNoteAddModal').click( function() {
        current_object = $(this); 
        var invoice_id = $(this).attr('data-id');
        var add_note_invoice_type = $(this).attr('data-type');
        var credit_note_text = $(this).attr('data-creditnote');
        $("#created_invoice_id").val(invoice_id);
        $("#add_note_invoice_type").val(add_note_invoice_type);
        $("#credit_note").val(credit_note_text);

    });
</script>
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="creditNoteAddModal" aria-hidden="true" id="creditNoteAddModal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-content">
                <form id="add_credit_note_form" method="POST" name="requestacallform">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Add Credit Note</h4>
                    </div>
                    <div class="modal-body">
                    
                        <input type="hidden" name="invoice_id" id="created_invoice_id">
                        <input type="hidden" name="invoice_type" id="add_note_invoice_type">
                        <div class="form-group">                     
                            <textarea class="form-control" id="credit_note" type="text" name="credit_note"  placeholder="Write Credit Note" required></textarea>
                            <label class="error errorMessage"></label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-primary saveCreditNote">Save</a>
                  </div>
              </form>          
            </div>
        </div>
    </div>
</div>
<script>
    $('.credit_note').keyup(function() {
        if((this).val() != '') {
            $('.errorMessage').html('');
        } else {
            $('.errorMessage').html('Please write credit note.');
        }
        
    })
    $('.saveCreditNote').click( function() {
        var add_credit_note_id = $('#created_invoice_id').val();
        var credit_note_save_invoice_type = $('#add_note_invoice_type').val(); 
        var credit_note = $('#credit_note').val();
        if(credit_note != '') {
            $('.errorMessage').html('');
            $.ajax({
                url: "InvoiceController.php",
                type: "post",
                cache: false,
                data: {"add_credit_note_id": add_credit_note_id, "credit_note": credit_note, "credit_note_save_invoice_type": credit_note_save_invoice_type },
                success: function(result) {
                    if (result) {
                        swal('Congrats', 'Credit Note added successfully', 'success');
                        $('#creditNoteAddModal').modal('hide');
                        current_object.attr('data-creditnote', credit_note);
                        current_object = '';
                    }
                    else {
                        swal("Something Went Wrong!!!");
                    }
                }
            });
        } else {
            $('.errorMessage').html('Please write credit note.');
        }
    })
</script>
</body>
</html>