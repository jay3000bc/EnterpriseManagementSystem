<?php

$title = 'Receive Invoice';
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
$bankDetails= $adminManager->getBankDetails();

if (isset($_GET['id'])) {
    $id = trim(stripslashes($_GET['id']));

    $invoiceManager = new InvoiceManager();
    $result = $invoiceManager->fetchReceivedInvoicesById($id);

    $invoice_receive_amount = $invoiceManager->fetchInvoiceReceiveAmount($result['invoice_id']);

} 





?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Receive Invoice [ Purchase of product(s) or Service(s) ]</h1>
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
                        <form role="form" id="receiveInvoiceForm" method="POST" action="InvoiceController.php"
                            enctype="multipart/form-data">
                            <input type="hidden" name="receive_id" value="<?php echo $result['id']; ?>" >
                            <div class="form-content">
                                <div class="row">
                                    <?php 
                                    if(isset($_SESSION['ErrorMsg'])) {
                                ?>
                                    <div class="col-md-12 error-message">
                                        <p class="alert alert-danger"><?php echo $_SESSION['ErrorMsg'];?><span
                                                style="color:#fff;" class="clear-error-msg close">&times;</span></p>
                                    </div>
                                    <?php
                                    unset($_SESSION['ErrorMsg']);  
                                    }
                                ?>
                                    <p class="col-md-12"><label>Note: &nbsp;<span class="mandatory"> * </span></label>
                                        &nbsp;fields are mandatory.</p>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="invoice_no">Invoice No. <span
                                                            class="mandatory">*</span></label>
                                                    <input value="<?php echo $result['invoice_id'] ?>"
                                                        palceholder="Invoice No." id="invoice_no" type="text"
                                                        name="invoice_no"
                                                        class="form-control remove-space check-dublicate"
                                                        autocomplete="off" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="client_name">Currency Type <span
                                                            class="mandatory">*</span></label>
                                                    <select id="currency_type" name="currency_type" class="form-control"
                                                        required>
                                                        <?php foreach ($currencies as $key => $currency) { ?>
                                                        <option
                                                            <?php if( $result['currency_type']  == $key)  echo 'selected';  ?>
                                                            value="<?php echo $key ?>"><?php echo $currency;  ?>
                                                        </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="invoice_date">Invoice Date <span
                                                    class="mandatory">*</span></label>

                                            <input
                                                value="<?php echo date("d-m-Y", strtotime( $result['created_at'] )); ?>"
                                                id="invoice_date" placeholder="Enter Invoice Date" type="text"
                                                name="invoice_date" class="form-control" data-date-format="dd/mm/yy" required />

                                            <!--<input id="invoice_date" placeholder="Enter Invoice Date" type="text" value="<?php //echo $result['created_at'];?>" name="invoice_date" class="form-control"> -->

                                        </div>
                                        <div class="form-group">
                                            <label for="client_name">Seller Name <span
                                                    class="mandatory">*</span></label>
                                            <input value="<?php echo $result['name'] ?>" id="client_name"
                                                placeholder="Enter Seller Name" type="text" name="client_name"
                                                class="form-control" autocomplete="off" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="client_address">Seller Address <span
                                                    class="mandatory">*</span></label>
                    
                                            <textarea  required="required" id="client_address" name="client_address" class="form-control" 
                                                placeholder="Address of Client" rows="4">
                                                <?php if(isset($_SESSION['session_receive_invoice_client_address'])) 
                                                    echo htmlspecialchars($_SESSION['session_receive_invoice_client_address']); 
                                                    unset($_SESSION['session_receive_invoice_client_address']);
                                                    echo $result['address'];
                                                ?>
                                            </textarea>
                                        

                                        </div>


                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="client_email">Seller Email <span
                                                    class="mandatory">*</span></label>
                                            <input value="<?php echo $result['email'] ?>" id="client_email"
                                                placeholder="Enter Seller Email" type="text" name="client_email"
                                                class="form-control remove-space" autocomplete="off"  required>
                                        </div>
                                        <div class="form-group">
                                            <label for="client_contact_no">Seller Contact No. <span
                                                    class="mandatory">*</span></label>
                                            <input value="<?php echo $result['contact_no']; ?>" id="client_contact_no"
                                                placeholder="Enter Seller Contact No." type="text"
                                                name="client_contact_no" class="form-control remove-space"
                                                autocomplete="off"  required>
                                        </div>
                                        <div id="hide_div_state">
                                            <div class="form-group">
                                                <label for="client_gstin">Seller GST <span
                                                        class="mandatory">*</span></label>
                                                <input value="<?php echo $result['gstin']; ?>" id="client_gstin"
                                                    placeholder="Enter Seller GSTIN" type="text" name="client_gstin"
                                                    class="form-control remove-space" autocomplete="off"  required>
                                            </div>
                                        </div>
                                        
                                        <!--If invoice uploaded -->
                                        <?php if( !empty($result['upload_invoice']) ) {?>
                                        <div class="form-group">
                                            <label for="upload_invoice">Uploaded invoice </label> <br>
                                            <a href="uploads/invoices/receivedInvoice/<?php echo $result['upload_invoice']; ?>" target="_blank">View Invoice</a>
                                            <input type="hidden" name="previous_uploaded_invoice" value="<?php echo $result['upload_invoice']; ?>">
                                        </div>
                                        <?php } ?>
                                        
                                        <div class="form-group">
                                            <label for="upload_invoice">Updated Uploaded invoice </label>
                                            <?php if(isset($_SESSION['session_receive_invoice_upload'])) { ?>
                                            <input type="file"
                                                data-allowed-file-extensions="png jpg jpeg pdf xps doc docx"
                                                data-default-file="<?php echo 'uploads/'.$_SESSION['session_receive_invoice_upload']; unset($_SESSION['session_receive_invoice_upload']); ?>"
                                                name="upload_invoice" class="dropify" data-height="100"
                                                style="height: 100% !important;">
                                            <input type="hidden" name="previousUploadfile"
                                                value="<?php echo $_SESSION['session_receive_invoice_upload']; ?>">
                                            <?php } else { ?>
                                            <input type="file"
                                                data-allowed-file-extensions="png jpg jpeg pdf xps doc docx"
                                                name="upload_invoice" class="dropify" data-height="100"
                                                style="height: 100% !important;">
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>

                                <hr>


                                <?php
                                $c =-1; 
                                $all_total = 0;
                                for($i=0;$i< sizeof($invoice_receive_amount); $i++){ 
                                $c= $c+1;
                                
                                $total_amount = $invoice_receive_amount[$i]['quantity'] * $invoice_receive_amount[$i]['price'];

                                $row_total = ( $total_amount ) +
                                             ( $total_amount * ($invoice_receive_amount[$i]['sgst']/100) ) +
                                             ( $total_amount * ($invoice_receive_amount[$i]['cgst']/100) ) +
                                             ( $total_amount * ($invoice_receive_amount[$i]['igst']/100) ) ;

                                $all_total = $all_total + $row_total ;

                                ?>


                                <div data-id="<?php echo $c; ?>" class="row">
                                    <input type="hidden" id="invoice_receive_amount<?php echo $c; ?>" name="invoice_receive_amount_id[]" value="<?php echo $invoice_receive_amount[$i]['id']; ?>">
                                    <input type="hidden" id="total<?php echo $c; ?>" value="<?php echo $row_total; ?>">
                                    
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="desc_of_service<?php echo $c; ?>">Description of Service</label>
                                            <input id="desc_of_service<?php echo $c; ?>" type="text"
                                                name="desc_of_service[]" class="form-control desc_of_service"
                                                placeholder="Write about description of service" autocomplete="off"
                                                value="<?php echo $invoice_receive_amount[$i]['desc_of_service'] ; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="sac_code<?php echo $c; ?>">SAC <span
                                                    class="mandatory">*</span></label>
                                            <input id="sac_code<?php echo $c; ?>" placeholder="Enter SAC" type="text"
                                                name="sac_code[]" class="form-control sac_code" required="required"
                                                value="<?php echo $invoice_receive_amount[$i]['sac_code'] ; ?>" >
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="quantity<?php echo $c; ?>">Qnty. </label>
                                            <input autocomplete="off" id="quantity<?php echo $c; ?>" type="text"
                                                name="quantity[]" class="form-control quantity" placeholder="Qnty."
                                                onkeyup="keyupFunctionQuantity(<?php echo $c; ?>)"
                                                value="<?php echo $invoice_receive_amount[$i]['quantity'] ; ?>" required="required">
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group"><label for="price<?php echo $c ?>">Price </label>
                                            <input autocomplete="off" id="price<?php echo $c; ?>" type="text"
                                                name="price[]" class="form-control price" placeholder="Price"
                                                onkeyup="keyupFunctionPrice(<?php echo $c; ?>)"
                                                value="<?php echo $invoice_receive_amount[$i]['price'] ; ?>" required="required">
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="cgst<?php echo $c; ?>">CGST (%)</label>
                                            <input autocomplete="off" onkeyup="keyupFunctionCGST(<?php echo $c; ?>)"
                                                id="cgst<?php echo $c; ?>" type="text" name="cgst[]"
                                                class="form-control cgst" placeholder="CGST(%)"
                                                value="<?php echo $invoice_receive_amount[$i]['cgst'] ; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="sgst<?php echo $c; ?>">SGST (%) </label>
                                            <input autocomplete="off" onkeyup="keyupFunctionSGST(<?php echo $c; ?>)"
                                                id="sgst<?php echo $c; ?>" type="text" name="sgst[]"
                                                class="form-control sgst" placeholder="SGST(%)"
                                                value="<?php echo $invoice_receive_amount[$i]['sgst'] ; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="igst<?php echo $c; ?>">IGST (%)</label>
                                            <input autocomplete="off" onkeyup="keyupFunctionIGST(<?php echo $c; ?>)"
                                                id="igst<?php echo $c; ?>" type="text" name="igst[]"
                                                class="form-control igst" placeholder="IGST(%)"
                                                value="<?php echo $invoice_receive_amount[$i]['igst'] ; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <?php if($c!=0){ ?>
                                            <a class="remove-clone-div btn btn-warning"
                                                onclick="removeCloneDiv(<?php echo $c; ?>);">Remove</a>
                                            <?php }  ?>
                                            <br>
                                        </div>
                                    </div>

                                </div>
                        
                                <?php } ?>
                                <input type="hidden" id="divId" value="<?php echo $c; ?>">
                            </div>

                            <div class="clone_desc_of_service">

                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <a id="add-more-service" class="btn btn-success">Add More</a>
                                </div>
                                <div class="col-md-6">
                                    <label>Total amount: <span class="currency_type_selected">&#8377;</span> <span
                                            id="total_amount"><?php echo $all_total ;?></span></label>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input style="padding: 6px 50px;" class="btn btn-info" value="Update"
                                            type="submit" name="updateReceiveInvoice">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="net_amount" value="<?php echo $all_total ;?>" name="invoice_amount">
                            <!--<input type="hidden" id="total0" value="0">-->
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
if(isset($_SESSION['successMsg'])) {
?>
<script type="text/javascript">
    swal('Congrats', 'Recevied Invoice created Updated', 'success');
</script>

<?php   
unset($_SESSION['successMsg']);
}
if(isset($_SESSION['errorMsg'])) {
?>
<script type="text/javascript">
    swal('Oops', 'Something Went Wrong', 'warning');
</script>

<?php   
unset($_SESSION['errorMsg']);
}
?>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" id="printableArea">

        <!-- Modal content-->
        <div class="modal-content">
            <!--  <button type="button" class="close" data-dismiss="modal">&times;</button> -->
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <!-- <button class="btn btn-default" onclick="printDiv('printableArea')"><i class="fa fa-print" aria-hidden="true" style="font-size: 17px;"> Print</i></button> -->
            </div>
        </div>

    </div>
</div>
<script type="text/javascript">
    // fade error message div
    $(".clear-error-msg").click(function () {
        $(".error-message").fadeOut("slow");
    });
    // calculate total amount
    var total = 0;
    var quantity = 0;
    var price = 0;
    var cgst = 0;
    var sgst = 0;
    var igst = 0;
    var calNetAmount = 0;
  //  var calNetAmount = parseFloat( $('#net_amount').val() );

    function keyupFunctionQuantity(arg) {
        
        if ($('#quantity' + arg).val().length > 0) {
            quantity = $('#quantity' + arg).val();
            price = $('#price' + arg).val();
            cgst = $('#cgst' + arg).val();
            sgst = $('#sgst' + arg).val();
            igst = $('#igst' + arg).val();
            //console.log(quantity);
            total = totalAmount(quantity, price, cgst, sgst, igst);
            $('#total' + arg).val(total);
           // console.log(total);
            calNetAmount = 0;
            $('input.desc_of_service').each(function (i) {
                console.log("i",i);
                calNetAmount = parseFloat(calNetAmount) + parseFloat($('#total' + i).val());
                console.log(calNetAmount);
               // $('#total_amount').html(ReplaceNumberWithCommas(calNetAmount));
                $('#total_amount').html(calNetAmount.toFixed(2));
               // console.log("Total Amount",calNetAmount);
                $('#net_amount').val(calNetAmount);
            });
        } else {
            quantity = 0;
            price = $('#price' + arg).val();
            cgst = $('#cgst' + arg).val();
            sgst = $('#sgst' + arg).val();
            igst = $('#igst' + arg).val();
            total = totalAmount(quantity, price, cgst, sgst, igst);
            $('#total' + arg).val(total);
            calNetAmount = 0;
            $('input.desc_of_service').each(function (i) {
                calNetAmount = parseFloat(calNetAmount) + parseFloat($('#total' + i).val());
               // $('#total_amount').html(ReplaceNumberWithCommas(calNetAmount));
                $('#total_amount').html(calNetAmount.toFixed(2));
                $('#net_amount').val(calNetAmount);
            });
        }
    }

    function keyupFunctionPrice(arg) {

        //console.log( $('#price' + arg).val().length );

        if ( $('#price' + arg).val().length > 0) {
         
           // console.log( $('#quantity' + arg).val() );
            quantity =  parseInt($('#quantity' + arg).val()) ;
            price =  parseFloat($('#price' + arg).val()) ;
            //console.log(price);
            console.log(quantity);
            cgst =  $('#cgst' + arg).val() ;
            sgst =  $('#sgst' + arg).val() ;
            igst =  $('#igst' + arg).val() ;
            total = totalAmount(quantity, price, cgst, sgst, igst);
            $('#total' + arg).val(parseFloat(total));
            calNetAmount = 0;
            $('input.desc_of_service').each(function (i) {
                calNetAmount = parseFloat(calNetAmount) + parseFloat($('#total' + i).val());
                console.log("arg",arg);
                console.log("i",i);
                console.log("Total", parseFloat($('#total' + i).val()));
                console.log("All Total",calNetAmount);
                //$('#total_amount').html(ReplaceNumberWithCommas(calNetAmount));
                $('#total_amount').html(calNetAmount.toFixed(2));
                $('#net_amount').val(calNetAmount);
            });
        } else {
            price = 0;
            quantity = $('#quantity' + arg).val();
            cgst = $('#cgst' + arg).val();
            sgst = $('#sgst' + arg).val();
            igst = $('#igst' + arg).val();
            total = totalAmount(quantity, price, cgst, sgst, igst);
            $('#total' + arg).val(total);
            calNetAmount = 0;
            $('input.desc_of_service').each(function (i) {
                calNetAmount = parseFloat(calNetAmount) + parseFloat($('#total' + i).val());
               // $('#total_amount').html(ReplaceNumberWithCommas(calNetAmount));
                $('#total_amount').html(calNetAmount.toFixed(2));
                $('#net_amount').val(calNetAmount);
            });
        }
    }

    function keyupFunctionCGST(arg) {
        if ($('#cgst' + arg).val().length > 0) {
            cgst = $('#cgst' + arg).val();
            if (FilterPercent(cgst) == 1) {
                $('#cgst' + arg).val('');
            } else {
                quantity = $('#quantity' + arg).val();
                price = $('#price' + arg).val();
                cgst = $('#cgst' + arg).val();
                sgst = $('#sgst' + arg).val();
                igst = $('#igst' + arg).val();
                total = totalAmount(quantity, price, cgst, sgst, igst);
                $('#total' + arg).val(total);
                calNetAmount = 0;
                $('input.desc_of_service').each(function (i) {
                    calNetAmount = parseFloat(calNetAmount) + parseFloat($('#total' + i).val());
                    //$('#total_amount').html(ReplaceNumberWithCommas(calNetAmount));
                    $('#total_amount').html(calNetAmount.toFixed(2));
                    $('#net_amount').val(calNetAmount);
                });
            }
        } else {
            quantity = $('#quantity' + arg).val();
            price = $('#price' + arg).val();
            cgst = $('#cgst' + arg).val();
            sgst = $('#sgst' + arg).val();
            igst = $('#igst' + arg).val();
            total = totalAmount(quantity, price, cgst, sgst, igst);
            $('#total' + arg).val(total);
            calNetAmount = 0;
            $('input.desc_of_service').each(function (i) {
                calNetAmount = parseFloat(calNetAmount) + parseFloat($('#total' + i).val());
               // $('#total_amount').html(ReplaceNumberWithCommas(calNetAmount));
                $('#total_amount').html(calNetAmount.toFixed(2));
                $('#net_amount').val(calNetAmount);
            });
        }
    }

    function keyupFunctionSGST(arg) {
        if ($('#sgst' + arg).val().length > 0) {
            sgst = $('#sgst' + arg).val();
            if (FilterPercent(sgst) == 1) {
                $('#sgst' + arg).val('');
            } else {
                quantity = $('#quantity' + arg).val();
                price = $('#price' + arg).val();
                cgst = $('#cgst' + arg).val();
                sgst = $('#sgst' + arg).val();
                igst = $('#igst' + arg).val();
                total = totalAmount(quantity, price, cgst, sgst, igst);
                $('#total' + arg).val(total);
                calNetAmount = 0;
                $('input.desc_of_service').each(function (i) {
                    calNetAmount = parseFloat(calNetAmount) + parseFloat($('#total' + i).val());
                   // $('#total_amount').html(ReplaceNumberWithCommas(calNetAmount));
                    $('#total_amount').html(calNetAmount.toFixed(2));
                    $('#net_amount').val(calNetAmount);
                });
            }
        } else {
            quantity = $('#quantity' + arg).val();
            price = $('#price' + arg).val();
            cgst = $('#cgst' + arg).val();
            sgst = $('#sgst' + arg).val();
            igst = $('#igst' + arg).val();
            total = totalAmount(quantity, price, cgst, sgst, igst);
            $('#total' + arg).val(total);
            calNetAmount = 0;
            $('input.desc_of_service').each(function (i) {
                calNetAmount = parseFloat(calNetAmount) + parseFloat($('#total' + i).val());
                //$('#total_amount').html(ReplaceNumberWithCommas(calNetAmount));
                $('#total_amount').html(calNetAmount.toFixed(2));
                $('#net_amount').val(calNetAmount);
            });
        }
    }

    function keyupFunctionIGST(arg) {
        if ($('#igst' + arg).val().length > 0) {
            igst = $('#igst' + arg).val();
            if (FilterPercent(igst) == 1) {
                $('#igst' + arg).val('');
            } else {
                quantity = $('#quantity' + arg).val();
                price = $('#price' + arg).val();
                cgst = $('#cgst' + arg).val();
                sgst = $('#sgst' + arg).val();
                igst = $('#igst' + arg).val();
                total = totalAmount(quantity, price, cgst, sgst, igst);
                $('#total' + arg).val(total);
                calNetAmount = 0;
                $('input.desc_of_service').each(function (i) {
                    calNetAmount = parseFloat(calNetAmount) + parseFloat($('#total' + i).val());
                  //  $('#total_amount').html(ReplaceNumberWithCommas(calNetAmount));
                  $('#total_amount').html(calNetAmount.toFixed(2));
                    $('#net_amount').val(calNetAmount);
                });
            }
        } else {
            quantity = $('#quantity' + arg).val();
            price = $('#price' + arg).val();
            cgst = $('#cgst' + arg).val();
            sgst = $('#sgst' + arg).val();
            igst = $('#igst' + arg).val();
            total = totalAmount(quantity, price, cgst, sgst, igst);
            $('#total' + arg).val(total);
            calNetAmount = 0;
            $('input.desc_of_service').each(function (i) {
                calNetAmount = parseFloat(calNetAmount) + parseFloat($('#total' + i).val());
               // $('#total_amount').html(ReplaceNumberWithCommas(calNetAmount));
               $('#total_amount').html(calNetAmount.toFixed(2));
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
        if (value.includes("%")) {
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
        components[0] = components[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        if (components[1] == undefined) {
            components[1] = '0' + '0';
            return components.join(".");
        } else if (components[1].length == 1) {
            components[1] = components[1] + '0';
            return components.join(".");
        } else if (components[1].length > 2) {
            givenNumber = givenNumber.replace(/\,/g, '');
            givenNumber = parseFloat(givenNumber).toFixed(2);
            var components_new = givenNumber.toString().split(".");
            components_new[0] = components_new[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            return components_new.join(".");
        } else {
            return components.join(".");
        }
    }
    // Add more Services 
      //var div_id =1;
    
    
    $('#add-more-service').click(function () {
        // clone_total["ashish"+div_id] = 0;
        // alert(clone_total;
        var div_id = parseInt($('#divId').val())+1 ;
        quantity = 0;
        price = 0;
        cgst = 0;
        sgst = 0;
        igst = 0;
        $('.clone_desc_of_service').append('<div data-id="' + div_id +
            '" class="row"><input type="text" id="total' + div_id +
            '" value="0"><div class="col-md-5"><div class="form-group"><label for="desc_of_service' +
            div_id + '">Description of Service</label><input id="desc_of_service' + div_id +
            '" type="text"  name="desc_of_service[]" class="form-control desc_of_service" placeholder="Write about description of service" autocomplete="off" required="required"></div></div><div class="col-md-2"><div class="form-group"><label for="sac_code' +
            div_id + '">SAC <span class="mandatory">*</span></label><input id="sac_code' + div_id +
            '" placeholder="Enter SAC" type="text" name="sac_code[]" class="form-control sac_code" required="required"></div></div><div class="col-md-1"><div class="form-group"><label for="quantity' +
            div_id + '">Qnty. </label><input autocomplete="off" id="quantity' + div_id +
            '" type="text" name="quantity[]" class="form-control quantity" placeholder="Qnty." onkeyup="keyupFunctionQuantity(' +
            div_id + ')"></div></div><div class="col-md-1"><div class="form-group"><label for="price' +
            div_id + '">Price </label><input autocomplete="off" id="price' + div_id +
            '" type="text" name="price[]" class="form-control price" placeholder="Price" onkeyup="keyupFunctionPrice(' +
            div_id + ')"></div></div><div class="col-md-1"><div class="form-group"><label for="cgst' +
            div_id + '">CGST (%)</label><input autocomplete="off" onkeyup="keyupFunctionCGST(' + div_id +
            ')" id="cgst' + div_id +
            '" type="text" name="cgst[]" class="form-control cgst" placeholder="CGST(%)"></div></div><div class="col-md-1"><div class="form-group"><label for="sgst' +
            div_id + '">SGST (%) </label><input autocomplete="off" onkeyup="keyupFunctionSGST(' + div_id +
            ')" id="sgst' + div_id +
            '" type="text" name="sgst[]" class="form-control sgst" placeholder="SGST(%)"></div></div><div class="col-md-1"><div class="form-group"><label for="igst' +
            div_id + '">IGST (%)</label><input autocomplete="off" onkeyup="keyupFunctionIGST(' + div_id +
            ')" id="igst' + div_id +
            '" type="text" name="igst[]" class="form-control igst" placeholder="IGST(%)"></div></div><div class="col-md-12"><div class="form-group"><a class="remove-clone-div btn btn-warning" onclick="removeCloneDiv(' +
            div_id + ');">Remove</a><br></div></div></div>');
        //div_id++;
        $('#divId').val( parseInt($('#divId').val())+1 );
    });
    // remove clone div
    function removeCloneDiv(div_id) {

       // delete row from database
      
      // console.log( $('#invoice_receive_amount'+div_id).val() );
       
       if( $('#invoice_receive_amount'+div_id).val() !=undefined  ) {

        var id = parseInt( ($('#invoice_receive_amount'+div_id).val() ) );

      /*  swal({
          title: "Are you sure?",
          text: "Your will not be able to recover the Pyroll !",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Yes, delete it!",
          closeOnConfirm: false
        },*/
       // function(){
            $.ajax({
                url: "InvoiceController.php",
                type: "post",
                cache: false,
                data: {"deleteRow": id},
                success: function(result) {
                    console.log(result);
                    if (result==1) {

                       // payroll_id_input.parent().parent().remove();
                        swal("Deleted!", "Payroll has been deleted successfully.", "success"); 

                    }
                    else {
                        swal("Something Went Wrong!!!");
                    }
                }
            });
       // });


       }




       calNetAmount = parseFloat( $('#net_amount').val() ) - parseFloat($('#total' + div_id).val());
                        //console.log( calNetAmount );

                        //console.log( parseFloat( $('#total'+div_id).val() ) );

                    // var calNetAmount = parseFloat( $('#net_amount').val() ) ;
                    
                    //  calNetAmount = parseFloat( calNetAmount ) - parseFloat($('#total' + div_id).val());
                        calNetAmount = parseFloat( $('#net_amount').val() ) - parseFloat($('#total' + div_id).val());
                    // console.log(calNetAmount);
                       // $('#total_amount').html(ReplaceNumberWithCommas(calNetAmount));

                        $('#total_amount').html(calNetAmount.toFixed(2));
                        $('#net_amount').val(calNetAmount);
                        $('[data-id=' + div_id + ']').remove();
                        div_id--; 
                        $('#divId').val( $('#divId').val()-1 );

        //delete row from database

    }
    // end

    // date picker
    $('#invoice_date').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy'
    });
    // preview modal 
    $('.preview-btn').click(function () {
        var btn_text = $(this).val();
        var form = $("#invoiceForm");
        $('.generate-pdf-btn').attr('disabled', 'disabled');
        //$('#invoiceForm').submit();
        $.ajax({
            type: "POST",
            url: form.attr("action"),
            data: form.serialize(),
            success: function (response) {
                if (response == 'success') {
                    $('.generate-pdf-btn').removeAttr('disabled', 'disabled');
                    if (btn_text == 'Preview') {
                        $(".modal-body").load('previewInvoice.php');
                        $('#myModal').modal('show');
                    }
                }
            }
        });
    });

    // format amount value
    // format given number 
    function ReplaceNumberWithCommas(givenNumber) {
        //Seperates the components of the number
        var components = givenNumber.toString().split(".");
        //Comma-fies the first part
        components[0] = components[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        if (components[1] == undefined) {
            components[1] = '0' + '0';
            return components.join(".");
        } else if (components[1].length == 1) {
            components[1] = components[1] + '0';
            return components.join(".");
        } else if (components[1].length > 2) {
            givenNumber = givenNumber.replace(/\,/g, '');
            givenNumber = parseFloat(givenNumber).toFixed(2);
            var components_new = givenNumber.toString().split(".");
            components_new[0] = components_new[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            return components_new.join(".");
        } else {
            return components.join(".");
        }
    }


    // Seller name list
    $("#client_name").autocomplete({
        autoFocus: true,
        delay: 100,
        source: 'sellerNameList.php',
        minLength: 2,
        select: function (event, ui) {
            var id = ui.item.id;
            var value = ui.item.value;
            var client_gstin = ui.item.gstin;
            var email = ui.item.email;
            var contact_no = ui.item.contact_no;
            var address = ui.item.address;
            //alert(email);
            if (id != '') {
                $('#client_id').val(id);
                $('#client_gstin').val(client_gstin);
                $('#client_email').val(email);
                $('#client_address').val(address);
                $('#client_contact_no').val(contact_no);
                $('#client_email').removeClass('error');
                $('#client_email').next('label').remove();
                $('#client_gstin').removeClass('error');
                $('#client_gstin').next('label').remove();
                $('#state').removeClass('error');
                $('#state').next('label').remove();
                $('#client_address').removeClass('error');
                $('#client_address').next('label').remove();
                $('#client_contact_no').removeClass('error');
                $('#client_contact_no').next('label').remove();
            }
        },
        // optional
        html: true,
        // optional (if other layers overlap the autocomplete list)
        open: function (event, ui) {
            $(".ui-autocomplete").css("z-index", 1000);
        }
    });
    // check in input is empty 
    $('#client_name').keyup(function () {
        var input_value = $(this).val();
        if (input_value == "") {
            $('#client_email').val('');
            $('#client_gstin').val('');
            $('#client_contact_no').val('');
            $('#client_address').val('');
        }
    });
    // end
    // auto polulate decsription of services
    var options1 = {
        autoFocus: true,
        source: 'descriptionOfReceivedServicesList.php',
        minLength: 2
    };
    var selector = 'input.desc_of_service';
    $(document).on('keydown.autocomplete', selector, function () {
        $(this).autocomplete(options1);
        console.log("Desc", options1);
    });
    // end

    // auto polulate SAC in Received Invoice
    var options = {
        autoFocus: true,
        source: 'sacReceivedInvoiceList.php',
        minLength: 2
    };
    var selector = 'input.sac_code';
    $(document).on('keydown.autocomplete', selector, function () {
        $(this).autocomplete(options);
        console.log("SAC", options);

    });
    // end

    // select currency type
    $('#currency_type').change(function () {
        $('.currency_type_selected').html($("#currency_type option:selected").text());

    });

    // trim space
    $('.remove-space').each(function () {
        $(this).keyup(function () {
            var field = $(this);
            var str = $(this).val();
            $(this).val($.trim(str));
        });
    });
    // check dublicate entry
    $('.check-dublicate').each(function () {
        $(this).blur(function () {
            var field = $(this);
            var str = $(this).val();
            $(this).val($.trim(str));
            var field_name = $(this).attr('name');
            var check_already_exist_value = $(this).val();
            $.ajax({
                url: "InvoiceController.php",
                type: "post",
                cache: false,
                data: {
                    "check_already_exist_value": check_already_exist_value,
                    "field_name": field_name
                },
                success: function (result) {
                    if (result == 1) {
                        field.val('');
                        field.focus();
                        swal("oops", "Invoice No. already exist.Please try another.",
                            "error");
                    }

                }
            });

        });
    });


    var desc_c = 0;
    var sac_c = 0;

    var qty_c = 0;
    var qty_c1 = 0;
    
    var price_c =0;
    var price_c1 =0;

    $( "#receiveInvoiceForm" ).submit(function( event ) {


        
        
        $('input[name^="desc_of_service"]').each(function() {
            //alert($(this).val());
            if($(this).val() == ''){
                event.preventDefault();
                $(this).css("border", "1px solid red");
                if(desc_c==0){
                    $(this).after("<div class='validation' style='color:red;margin-bottom: 20px;'>Please Enter Service Description.</div>");
                    desc_c=1;
                }
                
            }
            else{
                $(this).next(".validation").remove();
                $(this).css("border", "1px solid #d2d6de");
            }
            
        });


        $('input[name^="sac_code"]').each(function() {
            if($(this).val() == ''){
                event.preventDefault();
                $(this).css("border", "1px solid red");
                if(sac_c==0){
                    $(this).after("<div class='validation' style='color:red;margin-bottom: 20px;'>Please Enter SAC</div>");
                    sac_c=1;
                }
                
            }
            else{
                $(this).next(".validation").remove();
                $(this).css("border", "1px solid #d2d6de");
            }
            
        });

        $('input[name^="quantity"]').each(function() {


            var check = /^[0-9]$/;
            check = check.test($(this).val());

            

            if($(this).val() == ''){

                event.preventDefault();
                $(this).css("border", "1px solid red");
                if(qty_c==0){
                    $(this).after("<div class='validation' style='color:red;margin-bottom: 20px;'>Please Enter Quantity</div>");
                    qty_c=1;
                }
               
                
            }
            else if( !check  ){
                $(this).next(".validation").remove();
                event.preventDefault();
                if(qty_c1==0){
                    
                    $(this).after("<div class='validation' style='color:red;margin-bottom: 20px;'>Quantity must be a number</div>");
                    qty_c1=1;
                }
                
                
            }
            else{
                $(this).next(".validation").remove();
                $(this).css("border", "1px solid #d2d6de");
            }
            
        });

        $('input[name^="price"]').each(function() {


            var check = /[+-]?([0-9]*[.])?[0-9]+/;
            
            check = check.test($(this).val());

            if($(this).val() == ''){
                event.preventDefault();
                $(this).css("border", "1px solid red");
                
                if(price_c==0){
                    $(this).after("<div class='validation' style='color:red;margin-bottom: 20px;'>Please Enter Price</div>");
                    price_c=1;
                }
                
            }
           else if( !check  ){
                event.preventDefault();
                $(this).css("border", "1px solid red");

                if(price_c1==0){
                    $(this).after("<div class='validation' style='color:red;margin-bottom: 20px;'>Price must be a number</div>");
                    price_c1=1;
                }
                
            }
            else{
                $(this).next(".validation").remove();
                $(this).css("border", "1px solid #d2d6de");
            }
            
        }); 

    }); 


   


</script>
</body>

</html>