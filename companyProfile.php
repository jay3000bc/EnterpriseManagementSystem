<?php 
$title = 'Company Profile';
include('include/header.php');
include('settings/indian_bankname_list.php');
$sacResults = $adminManager->getSac();
$bankDetails= $adminManager->getBankDetails();
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Company Profile</h1>
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
                        <?php 
                            if(isset($_SESSION['companyLogoErrorMsg'])) {
                        ?>
                            <div class="col-md-12">
                                <p class="alert alert-danger"><?php echo $_SESSION['companyLogoErrorMsg'];?></p>
                            </div>
                        <?php
                            unset($_SESSION['companyLogoErrorMsg']);  
                            }
                        ?>
                        <?php if(isset($_SESSION['changePasswordErrorMsg'])) { ?>
                            <p class="alert alert-danger"><?php  echo $_SESSION['changePasswordErrorMsg'];?></p>
                            <?php 
                            unset($_SESSION['changePasswordErrorMsg']);
                        } ?>

                        <form role="form" id="companyProfileForm" method="POST" action="AdminController.php" enctype="multipart/form-data">
                            <p><label>Note: &nbsp;<span class="mandatory"> * </span></label> &nbsp;fields are mandatory.</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="company_name">Company Name <span class="mandatory">*</span></label>
                                        <input class="form-control" id="company_name" placeholder="Enter Company Name" type="text" value="<?php echo $companyInfo['company_name'];?>" name="company_name" autocomplete="off" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="company_address">Company Address <span class="mandatory">*</span></label>
                                        <textarea class="form-control" placeholder="Enter Company Address" name="company_address" id="company_address" rows="3"><?php echo $companyInfo['company_address'];?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="state">State <span class="mandatory">*</span></label>
                                        <select id="state" class="form-control" name="state" required>   <option value="">Select State</option>
                                            <?php for ($i=0; $i < $totalStates ; $i++) { ?>
                                            <option value="<?php echo $adminManager->state_id[$i]; ?>" <?php if ($companyInfo['state'] == $i+1) { echo "selected"; } ?>><?php echo $adminManager->state_name[$i]; ?> (<?php echo $adminManager->state_gst_code[$i]; ?>)</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="contact_number">Contact No. <span class="mandatory">*</span></label>
                                        <input class="form-control" id="contact_number" placeholder="Enter Contact Number" value="<?php echo $companyInfo['contact_number'];?>" type="text" name="contact_number" autocomplete="off" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email <span class="mandatory">*</span></label>
                                        <input class="form-control" id="email" value="<?php echo $companyInfo['email'];?>" placeholder="Enter Email" type="email" name="email" autocomplete="off" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">CRN </label>
                                        <input class="form-control" id="crn" value="<?php echo $companyInfo['crn'];?>" placeholder="Enter Company Registration Number" type="crn" name="crn" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">GSTIN <span class="mandatory">*</span></label>
                                        <input class="form-control" id="gstin" value="<?php echo $companyInfo['gstin'];?>" placeholder="Enter GSTIN" type="gstin" name="gstin" autocomplete="off" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">PAN <span class="mandatory">*</span></label>
                                        <input class="form-control" id="pan" value="<?php echo $companyInfo['pan'];?>" placeholder="Enter PAN" type="pan" name="pan" autocomplete="off" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="photo">Admin Photo </label> <span style="color:#0000FF">[ Please upload an image of only JPG, GIF, PNG format and maximum size of 500 kb. ]</span>
                                        <input type="file" data-allowed-file-extensions="png jpg jpeg" name="photo" data-default-file="<?php echo 'uploads/company_profile_images/'.$companyInfo['photo'];?>" class="dropify" data-height="100" style="height: 100% !important;">
                                    </div>
                                    <div class="form-group">
                                        <label for="company_logo">Comapny Logo </label> <span style="color:#0000FF">[ Please upload an image of only JPG, GIF, PNG format and maximum size of 500 kb. For better resolution use 200 x 40 px image. ]</span>
                                        <input type="file" data-allowed-file-extensions="png jpg jpeg" name="company_logo" data-default-file="<?php echo 'uploads/company_profile_images/'.$companyInfo['company_logo'];?>" class="dropify" data-height="100" style="height: 100% !important;">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <hr style="border-color:#000;">
                                </div>
                                <div class="col-md-12">
                                    <h4>Following details will be required for invoicing.</h4>
                                </div><br><br>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="signature">Signature </label> <span style="color:#0000FF">[ Upload your scanned signature, if your invoice requires your signature. ]</span>
                                        <input type="file" data-allowed-file-extensions="png jpg jpeg" name="signature" data-default-file="<?php echo 'uploads/company_profile_images/'.$companyInfo['signature'];?>" class="dropify" data-height="100" style="height: 100% !important;">
                                    </div>
                                </div> 
                                <div class="col-md-6"></div>   
                            </div>
                            <?php if($sacResults == '') { ?>
                            <div class="row">
                                <div class="col-md-6">    
                                    <div class="form-group">
                                        <label for="sac">SAC (Service accounting code) <span class="mandatory">*</span></label>
                                        <p style="color: #0000FF; float:right;"><a style="color:#0000FF;" href="https://cleartax.in/s/sac-codes-gst-rates-for-services" target="_blank">Find SAC Code</a></p>
                                        <input class="form-control" id="sac_id" type="hidden" name="sac_id[]">
                                         <input class="form-control"  id="sac_code" placeholder="Enter SAC code" type="text" name="sac_clone[]" autocomplete="off" required><br>
                                        
                                    </div>
                                </div>
                                <div class="col-md-6">
                                </div>
                            </div>    
                            <?php } ?>
                            <?php for ($i=0; $i < $sacResults ; $i++) { ?>
                            <div class="row" data-delete_sac_div="<?php echo $adminManager->sac_id[$i]; ?>">    
                                <div class="col-md-6">    
                                    <div class="form-group">
                                        <label for="sac">SAC (Service accounting code) <span class="mandatory">*</span></label>
                                        <input class="form-control" id="sac_id" value="<?php echo $adminManager->sac_id[$i]; ?>" type="hidden" name="sac_id[]">
                                         <input class="form-control" onkeyup="checkSAC('<?php echo 'sac_code'.$i;?>')"  id="sac_code<?php echo $i;?>" value="<?php echo $adminManager->sac[$i]; ?>" placeholder="Enter SAC code" type="text" name="sac[]" autocomplete="off" required><br>
                                        
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label style="opacity: 0;">Detete SAC</label><br>
                                        <a data-delete_sac_id="<?php echo $adminManager->sac_id[$i]; ?>" class="btn btn-warning delete_sac_details">Remove</a>
                                        <input type="hidden" value="<?php echo $adminManager->sac_id[$i]; ?>">
                                    </div>
                                </div>
                            </div>    
                            <?php } ?>    
                            <div class="row clone_sac_code_div">
                                    
                            </div>
                            <div class="row">    
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <a id="add-more" class="btn btn-success">Add More SAC code</a>
                                    </div>
                                </div>
                            </div>
                            <?php if($bankDetails == '') { ?>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="bank_name">Bank Name <span class="mandatory">*</span></label>
                                        <select id="bank_name" class="form-control" name="bank_name_clone[]">
                                            <?php foreach ($indian_bankname_list as $key => $value) { ?>
                                            <option vlaue="<?php echo $value ?>"><?php echo $value ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">   
                                    <div class="form-group">
                                        <label for="bank_account_no">Bank A/C No. <span class="mandatory">*</span></label>
                                        <input class="form-control" id="bank_account_no" placeholder="Enter Bank Account No" type="text" name="bank_account_no_clone[]" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="ifsc">IFSC code <span class="mandatory">*</span></label>
                                        <input class="form-control" id="ifsc" placeholder="Enter IFSC code" type="text" name="ifsc_clone[]" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-md-3"></div>
                            </div>
                            <?php } ?>
                            <?php for ($i=0; $i < $bankDetails ; $i++) { 
                                //echo $adminManager->bank_name[$i];
                                //die();
                                ?>

                            <div class="row" data-delete_bank="<?php echo $adminManager->bank_id[$i]; ?>">    
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="bank_name">Bank Name <span class="mandatory">*</span></label>
                                        <select id="bank_name" class="form-control" name="bank_name[]">
                                            <?php foreach ($indian_bankname_list as $key => $value) { ?>
                                            <option <?php if($adminManager->bank_name[$i] == $value) echo "Selected" ?> vlaue="<?php echo $value ?>"><?php echo $value ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">   
                                    <div class="form-group">
                                        <label for="bank_account_no">Bank A/C No. <span class="mandatory">*</span></label>
                                        <input class="form-control" id="bank_account_no" value="<?php echo $adminManager->bank_account_no[$i]; ?>" placeholder="Enter Bank Account No" type="text" name="bank_account_no[]" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="ifsc">IFSC code <span class="mandatory">*</span></label>
                                        <input class="form-control" id="ifsc" value="<?php echo $adminManager->ifsc[$i]; ?>" placeholder="Enter IFSC code" type="text" name="ifsc[]" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label style="opacity: 0;">Delete Bank</label><br>
                                        <a data-delete_bank_id="<?php echo $adminManager->bank_id[$i]; ?>" class="btn btn-warning delete_bank_details">Remove</a>
                                        <input type="hidden" name="bank_id[]" value="<?php echo $adminManager->bank_id[$i]; ?>">
                                    </div>
                                </div>
                            </div>
                            
                            <?php } ?>  
                            <div class="row bank_clone_div">
                                
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <a id="add-more-bank" class="btn btn-success">Add More Bank</a>
                                </div>
                            </div>
                            <input type="hidden" name="oldPhoto" value="<?php echo $companyInfo['photo'];?>">
                            <input type="hidden" name="oldLogo" value="<?php echo $companyInfo['company_logo'];?>">
                            <input type="hidden" name="oldSignature" value="<?php echo $companyInfo['signature'];?>">
                            <div class="form-group text-center">
                                <input type="submit" class="btn btn-primary" value="Update" name="updateCompanyProfile" >
                            </div>
                        </form>
                        
                        <!-- /.box-body -->
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
// profile update success message
if(isset($_SESSION['updateCompanyProfileSuccess'])) {
?>
<script type="text/javascript">
  swal('Congrats', 'Company Profile has been update successfully.', 'success');
</script>

<?php   
unset($_SESSION['updateCompanyProfileSuccess']);
}
?>
<script type="text/javascript">
    // delete bank details
    $('.delete_bank_details').click(function() {
        var delete_bank_id = $(this).data("delete_bank_id");
        swal({
          title: "Are you sure?",
          text: "Your will not be able to recover the Bank Details!",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Yes, delete it!",
          closeOnConfirm: false
        },
        function(){
            $.ajax({
                url: "AdminController.php",
                type: "post",
                cache: false,
                data: {"delete_bank_id": delete_bank_id},
                success: function(result) {
                    if (result==1) {
                        $('[data-delete_bank=' + delete_bank_id + ']').remove();
                        swal("Deleted!", "Bank details has been deleted successfully.", "success"); 
                    }
                    else {
                        swal("Oops","Something Went Wrong!!!", "error");
                    }
                }
            });
        });
    });

    // delete sac code
    $('.delete_sac_details').click(function() {
        var delete_sac_id = $(this).data("delete_sac_id");
        swal({
          title: "Are you sure?",
          text: "Your will not be able to recover the SAC code!",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Yes, delete it!",
          closeOnConfirm: false
        },
        function(){
            $.ajax({
                url: "AdminController.php",
                type: "post",
                cache: false,
                data: {"delete_sac_id": delete_sac_id},
                success: function(result) {
                    if (result==1) {
                        $('[data-delete_sac_div=' + delete_sac_id + ']').remove();
                        swal("Deleted!", "SAC code has been deleted successfully.", "success"); 
                    }
                    else {
                        swal("Oops","Something Went Wrong!!!", "error");
                    }
                }
            });
        });
    });

    // Add more SAC codes

    var div_id =1;
    $('#add-more').click(function() {
        $('.clone_sac_code_div').append('<div class="col-md-6" data-id="'+div_id+'"><div class="form-group"><input name="sac_clone[]" class="form-control sac_code '+div_id+'" id="sac'+div_id+'" onkeyup="checkSACClone('+div_id+')" placeholder="Enter SAC code" type="text" autocomplete="off" required></div><div class="form-group"><a class="remove-clone-div btn btn-warning" onclick="removeCloneDiv('+div_id+');">Remove</a><br></div></div>');
        div_id++;
    });
    function removeCloneDiv(div_id) {
        $('[data-id=' + div_id + ']').remove();
        div_id--;
    }

    // check sac code value dublicate entry

    function checkSAC(arg) {
        var sac_code_value = $('#'+arg).val();
        $.ajax({
            url: "AdminController.php",
            type: "post",
            cache: false,
            data: {"sac_code_value": sac_code_value},
            success: function(result) {
                if (result == 1) {
                    $('#'+arg).val('');
                    swal("Oops", "SAC code already exist.", "error"); 
                }
            }
        });
    }
    // check sac code clone value dublicate enrty
    function checkSACClone(arg) {
        var sac_code_value = $('.'+arg).val();
        $.ajax({
            url: "AdminController.php",
            type: "post",
            cache: false,
            data: {"sac_code_value": sac_code_value},
            success: function(result) {
                if (result == 1) {
                    $('.'+arg).val('');
                    swal("Oops", "SAC code already exist.", "error"); 
                }
            }
        });
    }

    // Add more bank details
    var div_bank_id =1;
    $('#add-more-bank').click(function() {
        $('.bank_clone_div').append('<div data-id="'+div_bank_id+'"><div class="col-md-3"><div class="form-group"><label for="bank_name'+div_bank_id+'">Bank Name <span class="mandatory">*</span></label><select id="bank_name'+div_bank_id+'" class="form-control" name="bank_name_clone[]"><?php foreach ($indian_bankname_list as $key => $value) { ?><option vlaue="<?php echo $value ?>"><?php echo $value ?></option><?php } ?></select></div></div><div class="col-md-3"><div class="form-group"><label for="bank_account_no'+div_bank_id+'">Bank A/C No. <span class="mandatory">*</span></label><input class="form-control" id="bank_account_no'+div_bank_id+'" placeholder="Enter Bank Account No" type="bank_account_no" name="bank_account_no_clone[]" autocomplete="off" required></div></div><div class="col-md-3"><div class="form-group"><label for="ifsc'+div_bank_id+'">IFSC code <span class="mandatory">*</span></label><input class="form-control" id="ifsc'+div_bank_id+'" placeholder="Enter IFSC code" type="ifsc" name="ifsc_clone[]" autocomplete="off" required></div></div><div class="col-md-3"><div class="form-group"><label style="opacity:0;">delete</label><br><a class="remove-clone-div btn btn-warning" onclick="removeCloneDivBank('+div_bank_id+');">Remove</a></div></div></div>');
        div_bank_id++;
    });
    function removeCloneDivBank(div_bank_id) {
        $('[data-id=' + div_bank_id + ']').remove();
        div_bank_id--;
    }
    function removeOldDivBank(delete_bank_id) {
        $('[data-delete_bank=' + delete_bank_id + ']').remove();
    }
</script>
</body>
</html>