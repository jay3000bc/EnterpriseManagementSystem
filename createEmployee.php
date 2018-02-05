<?php 
$title = 'Create Employee';
include('include/header.php');
date_default_timezone_set('Asia/Kolkata');
$date = date('ymdGis');
include_once 'LoaderManager.php';
$loaderManager = new LoaderManager();
$manageIdStatus = $loaderManager->manageIdStatus();
include_once 'EmployeeManager.php';
$employeeManager = new EmployeeManager();
$result = $employeeManager->listEmployees();
if($manageIdStatus['employee_id'] ==1) {
    $auto_generated_id = $employeeManager->getAutoIncrimentIDEmployee();
    $employeeIdDetails = $employeeManager->getEmployeeIdDetails(); 
    $auto_id = $employeeIdDetails['prefix'].str_pad($auto_generated_id['AUTO_INCREMENT'], $employeeIdDetails['digits'], '0', STR_PAD_LEFT); 
}

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Create Employee</h1>
        <?php include_once('include/notificationBell.php'); ?>
    </section>

    <!-- Main content -->
    <section class="content">
    <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    
                    <form role="form" id="createEmployeeForm" method="POST" action="EmployeeController.php" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <?php 
                                    if(isset($_SESSION['ErrorMsg'])) {
                                ?>
                                    <div class="col-md-12 error-message">
                                        <p class="alert alert-danger"><?php echo $_SESSION['ErrorMsg'];?><span style="color:#fff;" class="clear-error-msg close">&times;</span></p>
                                    </div>
                                <?php
                                    unset($_SESSION['ErrorMsg']);  
                                    }
                                ?>
                                <p class="col-md-12"><label>Note: &nbsp;<span class="mandatory"> * </span></label> &nbsp;fields are mandatory.</p>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name <span class="mandatory">*</span></label>
                                        <input class="form-control" id="name" placeholder="Enter Name" type="text" name="name" value="<?php if(isset($_SESSION['session_name'])) echo htmlspecialchars($_SESSION['session_name']); unset($_SESSION['session_name']);?>" autocomplete="off" required autofocus>
                                    </div>
                                    <div class="form-group">
                                        <label for="designation">Designation <span class="mandatory">*</span></label>
                                        <select  name="designation" class="form-control" required>
                                            <option value="">Select</option>
                                            <?php foreach ($arrayDesignations as $key => $designation) { ?>
                                                <option <?php if(isset($_SESSION['session_designation']) && ($_SESSION['session_designation']== $designation)) echo 'selected'; unset($_SESSION['session_designation']); ?> value="<?php echo $designation;?>"><?php echo $designation;?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email <span class="mandatory">*</span></label>
                                        <input name="email" value="<?php if(isset($_SESSION['session_email'])) echo htmlspecialchars($_SESSION['session_email']); unset($_SESSION['session_email']); ?>" class="form-control remove-space check-dublicate" id="email" placeholder="Enter Employee Email Address" type="email" autocomplete="off" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone_no">Phone No. <span class="mandatory">*</span></label>
                                        <input name="phone_no" value="<?php if(isset($_SESSION['session_phone_no'])) echo htmlspecialchars($_SESSION['session_phone_no']); unset($_SESSION['session_phone_no']); ?>" class="form-control remove-space" id="phone_no" placeholder="Enter Employee Phone Number" type="text" autocomplete="off" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password <span class="mandatory">*</span></label>
                                       <input class="form-control" id="password" name="password" data-toggle="popover" title="Password Strength" data-content="Enter Password..." value="<?php if(isset($_SESSION['session_password'])) echo htmlspecialchars($_SESSION['session_password']); unset($_SESSION['session_password']); ?>" placeholder="Enter Password" type="password" autocomplete="off" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="confirmPassword">Confirm Password <span class="mandatory">*</span></label>
                                        <input name="confirm_password" value="<?php if(isset($_SESSION['session_confirm_password'])) echo htmlspecialchars($_SESSION['session_confirm_password']); unset($_SESSION['session_confirm_password']); ?>" class="form-control" id="confirmPassword" placeholder="Confirm Password" type="password" autocomplete="off" required>
                                    </div>
                                    
                                    
                                    <div class="from-group">
                                        <div class="radio" style="margin-top: 31px; margin-bottom: 32px;">
                                            <label style="margin-right: 40px;">
                                                <?php if(isset($_SESSION['session_gender']) && ($_SESSION['session_gender']== 'Male')) { unset($_SESSION['session_gender']); ?>
                                                <input  name="gender" checked="" id="optionsRadios1" value="Male" type="radio">
                                                <?php } else {  ?>
                                                <input  name="gender" checked="" id="optionsRadios1" value="Male" type="radio">
                                                 <?php } ?>   
                                                 Male
                                            </label>
                                            <label>
                                                <input name="gender" <?php if(isset($_SESSION['session_gender']) && ($_SESSION['session_gender']== 'Female')) { echo 'checked'; unset($_SESSION['session_gender']); } ?> id="optionsRadios2" value="Female" type="radio">
                                                Female
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="pfAccount">PF Account</label>
                                        <input name="pf_account" value="<?php if(isset($_SESSION['session_pf_account'])) echo htmlspecialchars($_SESSION['session_pf_account']); unset($_SESSION['session_pf_account']); ?>" class="form-control" id="pfAccount" placeholder="Enter PF Account" type="text" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="lic_id">LIC ID</label>
                                        <input name="lic_id" value="<?php if(isset($_SESSION['session_lic_id'])) echo htmlspecialchars($_SESSION['session_lic_id']); unset($_SESSION['session_lic_id']); ?>" class="form-control" id="lic_id" placeholder="Enter LIC Id" type="text" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="ploicyNumber">Policy Number</label>
                                        <input name="policy_no" value="<?php if(isset($_SESSION['session_policy_no'])) echo htmlspecialchars($_SESSION['session_policy_no']); unset($_SESSION['session_policy_no']); ?>" class="form-control" id="ploicyNumber" placeholder="Enter Policy Number" type="text" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="bankAccount">Bank Account <span class="mandatory">*</span></label>
                                        <input name="bank_account" value="<?php if(isset($_SESSION['session_bank_account'])) echo htmlspecialchars($_SESSION['session_bank_account']); unset($_SESSION['session_bank_account']); ?>" class="form-control remove-space" id="bankAccount" placeholder="Enter Passport No." type="text" autocomplete="off" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="ifscCode">IFSC Code <span class="mandatory">*</span></label>
                                        <input name="ifsc_code" value="<?php if(isset($_SESSION['session_ifsc_code'])) echo htmlspecialchars($_SESSION['session_ifsc_code']); unset($_SESSION['session_ifsc_code']); ?>" class="form-control remove-space" id="ifscCode" placeholder="Enter Passport No." type="text" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="auto_generated_id">Employee Id <span class="mandatory">*</span></label>
                                        <!-- <div class="input-group date"> -->
                                            <?php if($manageIdStatus['employee_id'] == 1) {?>
                                            <input name="employee_id" value="<?php echo $auto_id;?>" class="form-control" id="auto_generated_id" type="text" autocomplete="off" readonly="" required>
                                            <?php } elseif($manageIdStatus['employee_id'] == 2) {?>
                                            <input name="employee_id" value="<?php if(isset($_SESSION['session_employee_id'])) echo htmlspecialchars($_SESSION['session_employee_id']); unset($_SESSION['session_employee_id']); ?>" class="form-control" id="auto_generated_id" placeholder="Enter Employee Id" type="text" autocomplete="off" required>
                                            <?php } else {?>
                                            <input name="employee_id" value="<?php if(isset($_SESSION['session_employee_id'])) echo htmlspecialchars($_SESSION['session_employee_id']); unset($_SESSION['session_employee_id']); ?>" class="form-control" id="auto_generated_id" placeholder="Choose type of Employee Id by clicking the link above" type="text" autocomplete="off" readonly="" required>
                                            <?php } ?>
                                            <!-- <div class="input-group-addon">
                                            <span id="edit_employee_id" style="cursor: pointer;">Edit ID</span>
                                          </div> -->
                                       <!--  </div>     -->
                                    </div>
                                    
                                    
                                    <div class="form-group">
                                        <label for="currentAddress">Current Address <span class="mandatory">*</span></label>
                                        <input name="current_address" value="<?php if(isset($_SESSION['session_current_address'])) echo htmlspecialchars($_SESSION['session_current_address']); unset($_SESSION['session_current_address']); ?>" class="form-control" id="currentAddress" placeholder="Enter Employee Address" type="text" autocomplete="off" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="permanentAddress">Permanent Address <span class="mandatory">*</span></label>
                                        <input name="permanent_address" value="<?php if(isset($_SESSION['session_permanent_address'])) echo htmlspecialchars($_SESSION['session_permanent_address']); unset($_SESSION['session_permanent_address']); ?>" class="form-control" id="permanentAddress" placeholder="Enter Employee Permament Address" type="text" autocomplete="off" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="fatherName">Father Name <span class="mandatory">*</span></label>
                                        <input name="father_name" value="<?php if(isset($_SESSION['session_father_name'])) echo htmlspecialchars($_SESSION['session_father_name']); unset($_SESSION['session_father_name']); ?>" class="form-control" id="fatherName" placeholder="Father Name" type="text" autocomplete="off" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Date of Joining <span class="mandatory">*</span></label>
                                        <div class="input-group date">
                                          <div class="input-group-addon calender-icon">
                                            <i class="fa fa-calendar"></i>
                                          </div>
                                          <input name="date_of_joining" value="<?php if(isset($_SESSION['session_date_of_joining'])) echo htmlspecialchars($_SESSION['session_date_of_joining']); unset($_SESSION['session_date_of_joining']); ?>" class="form-control pull-right" id="datepicker_date_of_joining" type="text">
                                        </div>
                                    </div> 
                                    <div class="form-group">
                                        <label>Date of Birth <span class="mandatory">*</span></label>
                                        <div class="input-group date">
                                            <div class="input-group-addon calender-icon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input name="date_of_birth" value="<?php if(isset($_SESSION['session_date_of_birth'])) echo htmlspecialchars($_SESSION['session_date_of_birth']); unset($_SESSION['session_date_of_birth']); ?>" class="form-control pull-right" id="datepicker_date_of_birth" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="pan">PAN <span class="mandatory">*</span></label>
                                        <input name="pan" value="<?php if(isset($_SESSION['session_pan'])) echo htmlspecialchars($_SESSION['session_pan']); unset($_SESSION['session_pan']); ?>" class="form-control remove-space" id="pan" placeholder="Enter PAN" type="text" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="drivingLicense">Driving License</label>
                                        <input name="driving_license_no" value="<?php if(isset($_SESSION['session_driving_license_no'])) echo htmlspecialchars($_SESSION['session_driving_license_no']); unset($_SESSION['session_driving_license_no']); ?>" class="form-control remove-space" id="drivingLicense" placeholder="Enter Passport No." type="text" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="passportNo">Passport No</label>
                                        <input name="passport_no" value="<?php if(isset($_SESSION['session_passport_no'])) echo htmlspecialchars($_SESSION['session_passport_no']); unset($_SESSION['session_passport_no']); ?>" class="form-control remove-space" id="passportNo" placeholder="Enter Passport No." type="text" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="photo">Photo</label>
                                        <input type="file" data-allowed-file-extensions="png jpg jpeg" data-default-file="<?php if(isset($_SESSION['session_photo_name'])) { echo 'uploads/'.$_SESSION['session_photo_name']; unset($_SESSION['session_photo_name']); } else { echo 'uploads/defaultuser.png'; } ?>" name="photo" class="dropify" data-height="100" style="height: 100% !important;">
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <?php if($manageIdStatus['employee_id'] == 0) {?>
                        <div class="box-footer text-center">
                            <a id="manageId" class="btn btn-primary">Submit</a>
                        </div>
                        <?php } else {?>
                        <div class="box-footer text-center">
                            <button class="btn btn-danger pull-left reset" type="reset">Reset</button>
                            <input type="submit" id="saveEmployeeDetails" class="btn btn-success pull-right" value="Submit" name="saveEmployeeDetails" >
                        </div>
                        <?php }?>
                    </form>
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
<script type="text/javascript">
    // clear form data
     $('.reset').click(function() {
        location.reload();
     });
    // end
    $('.remove-space').each(function() {
        $(this).keyup(function() {
            var field = $(this);
            var str = $(this).val();
            $(this).val($.trim(str));
        });
    });
    // check dublicate entry
    $('.check-dublicate').each(function() {
        $(this).keyup(function() {
            var field = $(this);
            var str = $(this).val();
            $(this).val($.trim(str));
            var field_name = $(this).attr('name');
            var check_already_exist_value = $(this).val();
            $.ajax({
                url: "EmployeeController.php",
                type: "post",
                cache: false,
                data: {"check_already_exist_value": check_already_exist_value, "field_name": field_name},
                success: function(result) {
                    if(result==1) {
                        field.val('');
                        field.focus();
                        swal("oops", "Given "+field_name+" already exist.Please try another.", "error");
                    }
                    
                }
            });

        });
    });
    // check dublicate enrty for employee Id
    $('#auto_generated_id').keyup( function() {
        var check_employee_id = $(this).val();
        $.ajax({
            url: "EmployeeController.php",
            type: "post",
            cache: false,
            data: {"check_employee_id": check_employee_id},
            success: function(result){
                if(result==1) {
                    $('#auto_generated_id').val('');
                    $('#auto_generated_id').html('');
                    swal("Oops!!", "Employee Id already exists. Please try another one.", "error");

                }
                
            }
        });
    });

    // fade error message div
    $( ".clear-error-msg" ).click(function() {
        $( ".error-message" ).fadeOut( "slow" );
    });

    // show date picker on click on icon
    $('.calender-icon').click(function() {
        $(this).next('input').focus();
    });
</script>
<?php
if(isset($_SESSION['employeeIdTypeSelected'])) {
?>
<script type="text/javascript">
   swal('Congrats', 'Employee Id Type Choosen Successfully.', 'success');
</script>

<?php   
unset($_SESSION['employeeIdTypeSelected']);
}
?>
</body>
</html>