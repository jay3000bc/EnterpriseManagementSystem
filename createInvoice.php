<?php
$title = 'Create Invoice';
setlocale(LC_MONETARY, 'en_IN'); 
include('include/header.php');
$sacResults = $adminManager->getSac();
include_once 'LoaderManager.php';
$loaderManager = new LoaderManager();
$manageIdStatus = $loaderManager->manageIdStatus();
include_once 'ClientManager.php';
$clientManager = new ClientManager();
include_once 'InvoiceManager.php';
$invoiceManager = new InvoiceManager();
$generate_export_invoice_id = '';
$generate_india__based_invoice_id = '';
if($manageIdStatus['invoice_id'] ==1) {
    $invoiceId = $invoiceManager->getInvoiceId();
    $export_auto_generated_id = str_pad(($invoiceId['current_export_id'] + $invoiceId['id']), $invoiceId['digits'], '0', STR_PAD_LEFT);
    $generate_export_invoice_id = $invoiceId['export_invoice_prefix'].$export_auto_generated_id;

    $national_auto_generated_id = str_pad(($invoiceId['current_india_based_id'] + $invoiceId['id']), $invoiceId['digits'], '0', STR_PAD_LEFT);
    $generate_india__based_invoice_id = $invoiceId['india_based_prefix'].$national_auto_generated_id;
}
$bankDetails= $adminManager->getBankDetails();
?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Create Invoice</h1>
      <?php include_once('include/notificationBell.php'); ?>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-body">
                        <form role="form" id="invoiceForm" method="POST" action="InvoiceController.php">
                            <input type="hidden" name="current_export_id" value="<?php echo $invoiceId['current_export_id']+1;?>">
                            <input type="hidden" name="current_national_id" value="<?php echo $invoiceId['current_india_based_id']+1;?>">
                            <div class="form-content">
                                <div class="row">
                                    <?php 
                                    if(isset($_SESSION['ErrorMsgInvoice'])) {
                                ?>
                                    <div class="col-md-12 error-message">
                                        <p class="alert alert-danger"><?php echo $_SESSION['ErrorMsgInvoice'];?><span style="color:#fff;" class="clear-error-msg close">&times;</span></p>
                                    </div>
                                <?php
                                    unset($_SESSION['ErrorMsgInvoice']);  
                                    }
                                ?>
                                <p class="col-md-12"><label>Note: &nbsp;<span class="mandatory"> * </span></label> &nbsp;fields are mandatory.</p>
                                <div class="col-md-6" style="border-right: 2px solid #a1a1a1;">
                                    <h4><b>Bill to party</b></h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="invoice_type">Invoice Type <span class="mandatory">*</span></label>
                                                <?php if($manageIdStatus['invoice_id'] == 1) {  
                                                    if($invoiceId['export_invoice_prefix'] != '')  { ?>
                                                <select id="invoice_type" name="invoice_type" class="form-control" required>
                                                    <option value="">Select Invoice Type<?php foreach ($invoiceTypes as $key => $invoiceType) { ?>
                                                    <option <?php if(isset($_SESSION['session_create_invoice_type']) && $_SESSION['session_create_invoice_type'] == $key) echo 'selected'; unset($_SESSION['session_create_invoice_type']); ?> value="<?php echo $key ?>"><?php echo $invoiceType ?></option>
                                                    <?php } ?>
                                                </select>
                                                <?php } else { ?>
                                                <input value="<?php if(isset($_SESSION['session_create_invoice_invoice_type'])) echo htmlspecialchars($_SESSION['session_create_invoice_invoice_type']); unset($_SESSION['session_create_invoice_invoice_type']); ?>" type="text" name="invoice_type" class="form-control" value="National Invoice" readonly>

                                                <?php } 
                                                        } else { ?>
                                                <select id="invoice_type" name="invoice_type" class="form-control" disabled>
                                                    <?php foreach ($invoiceTypes as $key => $invoiceType) { ?>
                                                    <option value="<?php echo $key ?>"><?php echo $invoiceType ?></option>
                                                    <?php } ?>
                                                </select>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">    
                                            <div class="form-group">
                                                <label for="client_name">Currency Type <span class="mandatory">*</span></label>
                                                <select id="currency_type" name="currency_type" class="form-control" required>
                                                    <?php foreach ($currencies as $key => $currency) { ?>
                                                    <option <?php if(isset($_SESSION['session_create_currency_type']) && $_SESSION['session_create_currency_type'] == $key) echo 'selected'; unset($_SESSION['session_create_currency_type']); ?> value="<?php echo $key ?>"><?php echo $currency ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>    
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="client_name">Client Name <span class="mandatory">*</span></label>
                                        <input id="client_name" placeholder="Enter Client Name" type="text" value="<?php if(isset($_SESSION['session_create_invoice_client_name'])) echo htmlspecialchars($_SESSION['session_create_invoice_client_name']); unset($_SESSION['session_create_invoice_client_name']); ?>" name="client_name" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="client_email">Client Email <span class="mandatory">*</span></label>
                                        <input id="client_email" placeholder="Enter Client Name" type="text" value="<?php if(isset($_SESSION['session_create_invoice_client_email'])) echo htmlspecialchars($_SESSION['session_create_invoice_client_email']); unset($_SESSION['session_create_invoice_client_email']); ?>" name="client_email" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="client_address">Client Address <span class="mandatory">*</span></label>
                                        <textarea id="client_address" name="client_address" class="form-control" placeholder="Address of Client" rows="4"><?php if(isset($_SESSION['session_create_invoice_client_address'])) echo htmlspecialchars($_SESSION['session_create_invoice_client_address']); unset($_SESSION['session_create_invoice_client_address']); ?></textarea>
                                    </div>
                                    <div id="hide_div_state">
                                        <div class="form-group">
                                            <label for="client_gstin">Client GST <span class="mandatory">*</span></label>
                                            <input id="client_gstin" placeholder="Enter Client GSTIN" type="text" value="<?php if(isset($_SESSION['session_create_invoice_client_gstin'])) echo htmlspecialchars($_SESSION['session_create_invoice_client_gstin']); unset($_SESSION['session_create_invoice_client_gstin']); ?>" name="client_gstin" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="foreign_state">Client State <span class="mandatory">*</span></label>
                                        <select id="state" class="form-control" name="client_state" required>   
                                                <option value="">Select Client State</option>
                                                <?php for ($i=0; $i < $totalStates ; $i++) { ?>
                                                <option <?php if(isset($_SESSION['session_create_invoice_client_state']) && $_SESSION['session_create_invoice_client_state'] == $adminManager->state_id[$i]) echo 'selected'; unset($_SESSION['session_create_invoice_client_state']); ?> value="<?php echo $adminManager->state_id[$i]; ?>"><?php echo $adminManager->state_name[$i]; ?> (<?php echo $adminManager->state_gst_code[$i]; ?>)</option>
                                                <?php } ?>
                                            </select>
                                        <input type="text" name="client_state" id="foreign_state" class="form-control" placeholder="Enter Client State" style="display: none;" disabled required>
                                    </div>
                                    <div class="form-group">
                                        <label for="mode_of_invoice">Mode of Invoice <span class="mandatory">*</span></label>
                                        <select id="mode_of_invoice" name="mode_of_invoice" class="form-control">
                                            <option value="">Select Mode of Invoice</option>
                                            <option <?php if(isset($_SESSION['session_create_invoice_mode_of_invoice']) && $_SESSION['session_create_invoice_mode_of_invoice'] == 0) echo 'selected'; unset($_SESSION['session_create_invoice_mode_of_invoice']); ?> value="0">Online</option>
                                            <option <?php if(isset($_SESSION['session_create_invoice_mode_of_invoice']) && $_SESSION['session_create_invoice_mode_of_invoice'] == 1) echo 'selected'; unset($_SESSION['session_create_invoice_mode_of_invoice']); ?>  value="1">Manual</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h4><b>Invoice Details</b></h4>
                                    <div class="form-group">
                                        <label for="invoice_no">Invoice No. <span class="mandatory">*</span></label>
                                        <?php if($manageIdStatus['invoice_id'] ==1) { ?>

                                            <?php if($invoiceId['export_invoice_prefix'] != '')  { ?>
                                        <input palceholder="Invoice No." id="invoice_no" type="text" name="invoice_no" class="form-control" readonly> 
                                        <?php } else { ?>
                                        <input palceholder="Invoice No." id="invoice_no" type="text" name="invoice_no" class="form-control" value="<?php echo $generate_india__based_invoice_id; ?>" readonly>
                                        <?php } ?>
                                        <?php } elseif($manageIdStatus['invoice_id'] ==2) { ?>
                                        <input palceholder="Invoice No." id="invoice_no" type="text" name="invoice_no" class="form-control"><?php } else { ?>
                                        <input palceholder="Please Select Invoice No. type from link above" type="text" name="invoice_no" class="form-control" readonly> 
                                        <?php } ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="invoice_date">Invoice Date <span class="mandatory">*</span></label>
                                        <input id="invoice_date" type="text" name="invoice_date" value="<?php echo date("d/m/Y", $current_date);?>" class="form-control" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="reverse_charge">Reverse Charge <span class="mandatory">*</span></label>
                                        <select id="reverse_charge" name="reverse_charge" class="form-control">
                                            <option <?php if(isset($_SESSION['session_create_invoice_reverse_charge']) && $_SESSION['session_create_invoice_reverse_charge'] == 0) echo 'selected'; unset($_SESSION['session_create_invoice_reverse_charge']); ?> value="0">No</option>
                                            <option <?php if(isset($_SESSION['session_create_invoice_reverse_charge']) && $_SESSION['session_create_invoice_reverse_charge'] == 1) echo 'selected'; unset($_SESSION['session_create_invoice_reverse_charge']); ?> value="1">Yes</option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="admin_gstin">GSTIN <span class="mandatory">*</span></label>
                                        <input id="admin_gstin" name="admin_gstin" class="form-control" value="<?php echo $companyInfo['gstin'];?>">
                                     </div>   
                                    <div class="form-group">
                                        <label for="admin_state">State <span class="mandatory">*</span></label>
                                        <select id="admin_state" class="form-control" name="admin_state" required>   
                                            <option value="">Select State</option>
                                            <?php for ($i=0; $i < $totalStates ; $i++) { ?>
                                            <?php if(isset($_SESSION['session_create_invoice_admin_state'])) { ?>
                                            <option <?php if(isset($_SESSION['session_create_invoice_admin_state']) && $_SESSION['session_create_invoice_admin_state'] == $i+1) echo 'selected'; unset($_SESSION['session_create_invoice_admin_state']); ?> value="<?php echo $adminManager->state_id[$i]; ?>"><?php echo $adminManager->state_name[$i]; ?> (<?php echo $adminManager->state_gst_code[$i]; ?>)</option>
                                            <?php } else { ?>
                                            <option value="<?php echo $adminManager->state_id[$i]; ?>" <?php if ($companyInfo['state'] == $i+1) { echo "selected"; } ?>><?php echo $adminManager->state_name[$i]; ?> (<?php echo $adminManager->state_gst_code[$i]; ?>)</option>
                                            <?php   } 
                                                } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="admin_bank_account">Bank A/C No. </label>
                                        <select id="admin_bank_account" class="form-control" name="admin_bank_account" required>   
                                            <option value="">Select Bank A/C No.</option>
                                            <?php for ($i=0; $i < $bankDetails ; $i++) { ?>
                                            <option <?php if(isset($_SESSION['session_create_invoice_admin_bank_account']) && $_SESSION['session_create_invoice_admin_bank_account'] == $adminManager->bank_id[$i]) echo 'selected'; unset($_SESSION['session_create_invoice_admin_bank_account']); ?> value="<?php echo $adminManager->bank_id[$i]; ?>"><?php echo $adminManager->bank_account_no[$i]; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div style="border-bottom: 2px solid #a1a1a1;"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group radio">
                                        <label class="radio-inline">
                                            <input id="qty_based_service" type="radio" name="qty_hrs" value="0" checked>Quantity based Services
                                        </label>
                                        <label class="radio-inline">
                                            <input id="hrs_based_service" type="radio" name="qty_hrs" value="1">Hourly based Services
                                        </label>
                                    </div>
                                </div>    
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="desc_of_service">Description of Service</label>
                                        <input id="desc_of_service" type="text" name="desc_of_service[]" class="form-control desc_of_service" placeholder="Write about description of service" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="sac_code">SAC/ HSN <span class="mandatory">*</span></label>
                                        <p style="color: #0000FF; float:right; margin-bottom: 0;"><a style="color:#0000FF;" href="https://cleartax.in/s/sac-codes-gst-rates-for-services" target="_blank">Find SAC Code</a></p>
                                        <select id="sac_code" name="sac_code[]" class="form-control" required>
                                            <option value="">Select SAC</option>
                                            <?php for ($i=0; $i < $sacResults ; $i++) { ?>
                                            <option value="<?php echo $adminManager->sac[$i]; ?>"><?php echo $adminManager->sac[$i]; ?></option>
                                            <?php } ?> 
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="quantity"><span class="qty_hrs">Qnty.</span></label>
                                        <input pattern="[0-9]"  onkeyup="keyupFunctionQuantity(0)" id="quantity0" type="text" name="quantity[]" class="form-control quantity" placeholder="Qnty." autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="price"><span class="price_hr">Price</span> (<span class="currency_type_selected">&#8377;</span>) </label>
                                        <input  onkeyup="keyupFunctionPrice(0)" id="price0" type="text" name="price[]"  class="form-control price" placeholder="Price" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="cgst">CGST (%)</label>
                                        <input  onkeyup="keyupFunctionCGST(0)" id="cgst0" type="text" name="cgst[]" class="form-control cgst gst-validate" placeholder="CGST(%)" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="sgst">SGST (%)</label>
                                        <input  onkeyup="keyupFunctionSGST(0)" id="sgst0" type="text" name="sgst[]" class="form-control sgst gst-validate" placeholder="SGST(%)" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="igst">IGST (%)</label>
                                        <input  onkeyup="keyupFunctionIGST(0)" id="igst0" type="text" name="igst[]" class="form-control igst gst-validate" placeholder="IGST(%)" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="clone_desc_of_service">
                                
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <a id="add-more-service" class="btn btn-success">Add More</a>
                                </div>
                                <div class="col-md-6">
                                    <label>Total amount: <span class="currency_type_selected">&#8377;</span> <span id="total_amount">0.00</span></label>
                                </div>
                                <div class="col-md-12">
                                    <br>
                                    <div style="border-bottom: 2px solid #a1a1a1;"></div>
                                    <br>
                                </div>
                            </div>   
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <?php if($manageIdStatus['invoice_id'] !=0)  { ?>
                                        <input class="btn btn-info preview-btn pull-left" value="Preview" type="text" name="previewInvoice">
                                        <input type="submit" class="btn btn-success pull-right generate-pdf-btn" name="saveInvoice" value="Generate Pdf">
                                        <input style="margin: 0 10px;" class="btn btn-warning pull-right generate-pdf-btn"  value="Print" type="submit" name="saveInvoice">
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="adminEmail" value="<?php echo $companyInfo['email'];?>">
                            <input id="client_id" type="hidden" name="client_id">
                            <input type="hidden" id="net_amount" value="0" name="net_amount">
                            <input type="hidden" id="total0" value="0">
                        </form> 
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
if(isset($_SESSION['errorMsg'])) {
?>
<script type="text/javascript">
    swal('Oops','Something Went Wrong', 'warning');
</script>

<?php   
unset($_SESSION['errorMsg']);
}
?>
<script type="text/javascript">
    // calculate total amount
    var total = 0;
    var quantity = 0;
    var price = 0;
    var cgst = 0;
    var sgst = 0;
    var igst = 0;
    var calNetAmount = 0;
    function keyupFunctionQuantity(arg) {
        if($('#quantity'+arg).val().length > 0) {
                quantity = $('#quantity'+arg).val();
                price = $('#price'+arg).val();
                cgst = $('#cgst'+arg).val();
                sgst = $('#sgst'+arg).val();
                igst = $('#igst'+arg).val();
                total = totalAmount(quantity, price, cgst, sgst, igst);
                $('#total'+arg).val(total);
                calNetAmount = 0;
                $('input.desc_of_service').each(function(i) {
                    calNetAmount = parseFloat(calNetAmount) + parseFloat($('#total'+i).val());
                    $('#total_amount').html(ReplaceNumberWithCommas(calNetAmount));
                    $('#net_amount').val(calNetAmount);
                });
        }
        else {
            quantity = 0;
            price = $('#price'+arg).val();
            cgst = $('#cgst'+arg).val();
            sgst = $('#sgst'+arg).val();
            igst = $('#igst'+arg).val();
            total = totalAmount(quantity, price, cgst, sgst, igst);
            $('#total'+arg).val(total);
            calNetAmount = 0;
            $('input.desc_of_service').each(function(i) {
                calNetAmount = parseFloat(calNetAmount) + parseFloat($('#total'+i).val());
                $('#total_amount').html(ReplaceNumberWithCommas(calNetAmount));
                $('#net_amount').val(calNetAmount);
            });
        }
    }
    function keyupFunctionPrice(arg) {
        if($('#price'+arg).val().length > 0) {
            quantity = $('#quantity'+arg).val();
            price = $('#price'+arg).val();
            cgst = $('#cgst'+arg).val();
            sgst = $('#sgst'+arg).val();
            igst = $('#igst'+arg).val();
            total = totalAmount(quantity, price, cgst, sgst, igst);
            $('#total'+arg).val(total);
            calNetAmount = 0;
            $('input.desc_of_service').each(function(i) {
                calNetAmount = parseFloat(calNetAmount) + parseFloat($('#total'+i).val());
                $('#total_amount').html(ReplaceNumberWithCommas(calNetAmount));
                $('#net_amount').val(calNetAmount);
            });
        }
        else {
            price = 0;
            quantity = $('#quantity'+arg).val();
            cgst = $('#cgst'+arg).val();
            sgst = $('#sgst'+arg).val();
            igst = $('#igst'+arg).val();
            total = totalAmount(quantity, price, cgst, sgst, igst);
            $('#total'+arg).val(total);
            calNetAmount = 0;
            $('input.desc_of_service').each(function(i) {
                calNetAmount = parseFloat(calNetAmount) + parseFloat($('#total'+i).val());
                $('#total_amount').html(ReplaceNumberWithCommas(calNetAmount));
                $('#net_amount').val(calNetAmount);
            });
        }
    }
    function keyupFunctionCGST(arg) {
        if($('#cgst'+arg).val().length > 0) {
            cgst = $('#cgst'+arg).val();
            if(FilterPercent(cgst) == 1) {
                $('#cgst'+arg).val('');
            } else {
                quantity = $('#quantity'+arg).val();
                price = $('#price'+arg).val();
                cgst = $('#cgst'+arg).val();
                sgst = $('#sgst'+arg).val();
                igst = $('#igst'+arg).val();
                total = totalAmount(quantity, price, cgst, sgst, igst);
                $('#total'+arg).val(total);
                calNetAmount = 0;
                $('input.desc_of_service').each(function(i) {
                    calNetAmount = parseFloat(calNetAmount) + parseFloat($('#total'+i).val());
                    $('#total_amount').html(ReplaceNumberWithCommas(calNetAmount));
                    $('#net_amount').val(calNetAmount);
                });
            }
        }
        else {
            quantity = $('#quantity'+arg).val();
            price = $('#price'+arg).val();
            cgst = $('#cgst'+arg).val();
            sgst = $('#sgst'+arg).val();
            igst = $('#igst'+arg).val();
            total = totalAmount(quantity, price, cgst, sgst, igst);
            $('#total'+arg).val(total);
            calNetAmount = 0;
            $('input.desc_of_service').each(function(i) {
                calNetAmount = parseFloat(calNetAmount) + parseFloat($('#total'+i).val());
                $('#total_amount').html(ReplaceNumberWithCommas(calNetAmount));
                $('#net_amount').val(calNetAmount);
            });
        }
    }
    function keyupFunctionSGST(arg) {
        if($('#sgst'+arg).val().length > 0) {
            sgst = $('#sgst'+arg).val();
            if(FilterPercent(sgst) == 1) {
                $('#sgst'+arg).val('');
            } else {
                quantity = $('#quantity'+arg).val();
                price = $('#price'+arg).val();
                cgst = $('#cgst'+arg).val();
                sgst = $('#sgst'+arg).val();
                igst = $('#igst'+arg).val();
                total = totalAmount(quantity, price, cgst, sgst, igst);
                $('#total'+arg).val(total);
                calNetAmount = 0;
                $('input.desc_of_service').each(function(i) {
                    calNetAmount = parseFloat(calNetAmount) + parseFloat($('#total'+i).val());
                    $('#total_amount').html(ReplaceNumberWithCommas(calNetAmount));
                    $('#net_amount').val(calNetAmount);
                });
            }
        }
        else {
            quantity = $('#quantity'+arg).val();
            price = $('#price'+arg).val();
            cgst = $('#cgst'+arg).val();
            sgst = $('#sgst'+arg).val();
            igst = $('#igst'+arg).val();
            total = totalAmount(quantity, price, cgst, sgst, igst);
            $('#total'+arg).val(total);
            calNetAmount = 0;
            $('input.desc_of_service').each(function(i) {
                calNetAmount = parseFloat(calNetAmount) + parseFloat($('#total'+i).val());
                $('#total_amount').html(ReplaceNumberWithCommas(calNetAmount));
                $('#net_amount').val(calNetAmount);
            });
        }
    }
    function keyupFunctionIGST(arg) {
        if($('#igst'+arg).val().length > 0) {
            igst = $('#igst'+arg).val();
            if(FilterPercent(igst) == 1) {
                $('#igst'+arg).val('');
            } else {
                quantity = $('#quantity'+arg).val();
                price = $('#price'+arg).val();
                cgst = $('#cgst'+arg).val();
                sgst = $('#sgst'+arg).val();
                igst = $('#igst'+arg).val();
                total = totalAmount(quantity, price, cgst, sgst, igst);
                $('#total'+arg).val(total);
                calNetAmount = 0;
                $('input.desc_of_service').each(function(i) {
                    calNetAmount = parseFloat(calNetAmount) + parseFloat($('#total'+i).val());
                    $('#total_amount').html(ReplaceNumberWithCommas(calNetAmount));
                    $('#net_amount').val(calNetAmount);
                });
            }
        }
        else {
            quantity = $('#quantity'+arg).val();
            price = $('#price'+arg).val();
            cgst = $('#cgst'+arg).val();
            sgst = $('#sgst'+arg).val();
            igst = $('#igst'+arg).val();
            total = totalAmount(quantity, price, cgst, sgst, igst);
            $('#total'+arg).val(total);
            calNetAmount = 0;
            $('input.desc_of_service').each(function(i) {
                calNetAmount = parseFloat(calNetAmount) + parseFloat($('#total'+i).val());
                $('#total_amount').html(ReplaceNumberWithCommas(calNetAmount));
                $('#net_amount').val(calNetAmount);
            });
        }
    }
    function totalAmount(quantity, price, cgst, sgst, igst) {
        total = quantity * price;
        cgst = total * cgst * 0.01;
        sgst = total * sgst * 0.01;
        igst = total * igst * 0.01;
        total = total + cgst + sgst + igst;
        return total;
    } 

    function FilterPercent(value) {
        if(value.includes("%")){
            alert("Please enter number - will be calculated as % (Percentage");
            return 1;
        } else {
            return 2;
        }
    }
     
     // format given number 
    function ReplaceNumberWithCommas(givenNumber) {
        //Seperates the components of the number
        var components = givenNumber.toString().split(".");
        //Comma-fies the first part
        components [0] = components [0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        if(components [1] == undefined) {
            components [1] = '0' + '0';
            return components.join(".");
        }
        else if(components [1].length == 1) {
            components [1] = components [1] + '0';
            return components.join(".");
        }
        else if(components [1].length > 2) {
            givenNumber=givenNumber.replace(/\,/g,'');
            givenNumber = parseFloat(givenNumber).toFixed(2);
            var components_new = givenNumber.toString().split(".");
            components_new [0] = components_new [0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            return components_new.join(".");
        }
        else {
            return components.join(".");
        }
    }
    // Add more Services 
    var div_id =1;
    var qty_hrs = 'Qty.';
    var price_type = 'Price'; 
    $('#add-more-service').click(function() {
        if ($('#qty_based_service').is(':checked')) {
            qty_hrs = 'Qty.';
            price_type = 'Price'; 
        } else {
            qty_hrs = 'Hrs.';
            price_type = 'Price/hr'; 
        }
        quantity = 0;
        price = 0;
        cgst = 0;
        sgst = 0;
        igst = 0;
        $('.clone_desc_of_service').append('<div data-id="'+div_id+'" class="row"><input type="hidden" id="total'+div_id+'" value="0"><div class="col-md-4"><div class="form-group"><input id="desc_of_service'+div_id+'" type="text" name="desc_of_service[]" class="form-control desc_of_service" placeholder="Write about description of service" autocomplete="off"></div></div><div class="col-md-2"><div class="form-group"><select id="sac_code'+div_id+'" name="sac_code[]" class="form-control" required><option value="">Select SAC</option><?php for ($i=0; $i < $sacResults ; $i++) { ?><option value="<?php echo $adminManager->sac[$i]; ?>"><?php echo $adminManager->sac[$i]; ?></option><?php } ?></select></div></div><div class="col-md-1"><div class="form-group"><input autocomplete="off" id="quantity'+div_id+'" type="text" name="quantity[]" class="form-control quantity" placeholder="'+qty_hrs+'" onkeyup="keyupFunctionQuantity('+div_id+')"></div></div><div class="col-md-2"><div class="form-group"><input autocomplete="off" id="price'+div_id+'" type="text" name="price[]" class="form-control price" placeholder="'+price_type+'" onkeyup="keyupFunctionPrice('+div_id+')"></div></div><div class="col-md-1"><div class="form-group"><input autocomplete="off" onkeyup="keyupFunctionCGST('+div_id+')" id="cgst'+div_id+'" type="text" name="cgst[]" class="form-control cgst" placeholder="CGST(%)"></div></div><div class="col-md-1"><div class="form-group"><input autocomplete="off" onkeyup="keyupFunctionSGST('+div_id+')" id="sgst'+div_id+'" type="text" name="sgst[]" class="form-control sgst" placeholder="SGST(%)"></div></div><div class="col-md-1"><div class="form-group"><input autocomplete="off" onkeyup="keyupFunctionIGST('+div_id+')" id="igst'+div_id+'" type="text" name="igst[]" class="form-control igst" placeholder="IGST(%)"></div></div><div class="col-md-12"><div class="form-group"><a class="remove-clone-div btn btn-warning" onclick="removeCloneDiv('+div_id+');">Remove</a><br></div></div></div>');
       div_id++;
    });
    // remove clone div
    function removeCloneDiv(div_id) {
        calNetAmount = parseFloat(calNetAmount)-parseFloat($('#total'+div_id).val());
        $('#total_amount').html(ReplaceNumberWithCommas(calNetAmount));
        $('#net_amount').val(calNetAmount);
        $('[data-id=' + div_id + ']').remove();
        div_id--;
    }
    // end

    // populate invoice id based on invoice type
    
    $('#invoice_type').change(function(){
        if($(this).val() == 1) {
            $('#invoice_no').val('<?php echo $generate_export_invoice_id;?>');
            $('#state').attr('disabled');
            $('#state').css('display','none');
            $('#client_gstin').attr('disabled', 'disabled');
            $('#hide_div_state').css('display','none');
            $('#foreign_state').css('display','block');
            $('#foreign_state').removeAttr('disabled');
        } else {
            $('#invoice_no').val('<?php echo $generate_india__based_invoice_id;?>');
            $('#state').removeAttr('disabled');
            $('#client_gstin').removeAttr('disabled');
            $('#hide_div_state').css('display','block');
            $('#foreign_state').css('display','none');
            $('#foreign_state').attr('disabled');
        }
        $('#invoice_no').removeClass('error');
        $('#invoice_no').next('label').remove();
    });
    // select currency type
    $('#currency_type').change(function(){
        $('.currency_type_selected').html($( "#currency_type option:selected" ).text());
        
    });

    // client name list
    $( "#client_name" ).autocomplete({
        autoFocus: true,
        delay: 100,
        source: 'clientNameList.php',
        minLength:2,
        select: function(event,ui){
        var id = ui.item.id;
        var client_id = ui.item.client_id;
        var value = ui.item.value;
        var client_gstin = ui.item.gstin;
        var state = ui.item.state;
        var address = ui.item.address;
        var email = ui.item.email;
            if(id != '') {
                $('#client_id').val(client_id);
                $('#client_gstin').val(client_gstin);
                $('#state').val(state);
                $('#client_address').val(address);
                $('#client_email').val(email);
                $('#client_gstin').removeClass('error');
                $('#client_gstin').next('label').remove();
                $('#state').removeClass('error');
                $('#state').next('label').remove();
                $('#client_address').removeClass('error');
                $('#client_address').next('label').remove();
                $('#client_email').removeClass('error');
                $('#client_email').next('label').remove();
                $('#foreign_state').val(state);
            }
        },
        // optional
        html: true, 
        // optional (if other layers overlap the autocomplete list)
        open: function(event, ui) {
        $(".ui-autocomplete").css("z-index", 1000);
        }
    });
    // check in input is empty 
    $('#client_name').keyup( function() {
        var input_value = $(this).val();
        if (input_value == "") {
            $('#client_id').val('');
            $('#client_gstin').val('');
            $('#state').val('');
            $('#client_address').val('');
            $('#client_email').val('');
        }
    });

    // auto polulate decsription of services
    var options = {
        autoFocus: true,
        delay: 100,
        source: 'descriptionOfServicesList.php',
        minLength: 2
    };
    var selector = 'input.desc_of_service';
    $(document).on('keydown.autocomplete', selector, function() {
        $(this).autocomplete(options);
    });
    // end

   
</script>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg" id="printableArea">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<script type="text/javascript">
    // preview modal 
   $('.preview-btn').click(function() {
        var btn_text = $(this).val();
        var form = $("#invoiceForm");
        $('.generate-pdf-btn').attr('disabled','disabled');
        $.ajax({
            type:"POST",
            url:form.attr("action"),
            data:form.serialize(),
            success: function(response) {
               if(response == 'success') {
                     $('.generate-pdf-btn').removeAttr('disabled','disabled');
                    if(btn_text == 'Preview') {
                        $(".modal-body").load('previewInvoice.php');
                        $('#myModal').modal('show');
                    }
               } 
            }
        });
    });
   // service type
   $('#qty_based_service').click(function() {
        $('.qty_hrs').html('Qty.');
        $('.quantity').attr('placeholder', 'Qty.');
        $('.price_hr').html('Price');
        $('.price').attr('placeholder', 'price');
   });
   $('#hrs_based_service').click(function() {
        $('.qty_hrs').html('Hrs.');
        $('.quantity').attr('placeholder', 'Hrs.');
        $('.price_hr').html('Price/Hr');
        $('.price').attr('placeholder', 'Price/hr.');
   });
</script>
</body>
</html>
