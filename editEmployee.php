<?php 
$title = 'Edit Employee';
include('include/header.php');
include_once 'EmployeeManager.php';
date_default_timezone_set('Asia/Kolkata');
$date = date('ymdGis');
include_once 'LoaderManager.php';
$loaderManager = new LoaderManager();
$manageIdStatus = $loaderManager->manageIdStatus();
if (isset($_GET['employee_id'])) {
    $employee_id = trim(stripslashes($_GET['employee_id']));
    $employeeManager = new EmployeeManager();
    $result = $employeeManager->getEmployeeDetailsByEmployeeId($employee_id);
} 
if (isset($_GET['request_id'])) {
    $employee_id = trim(stripslashes($_GET['request_id']));
    //echo $employee_id;
    $employeeManager = new EmployeeManager();
    $result = $employeeManager->getEmployeeDetailsByEmployeeId($employee_id);
    
    $resultRequestProfileDetails = $employeeManager->getRequestProfileEmployeeDetails($employee_id);
}  
                    
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Edit Employee</h1>
        <?php include_once('include/notificationBell.php'); ?>
    </section>

    <!-- Main content -->
    <section class="content">
    <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <?php if (isset($_GET['employee_id'])) { ?>
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
                                        <input class="form-control" id="name" value="<?php echo $result['name'];?>" placeholder="Enter Name" type="text" name="name" autocomplete="off" required autofocus>
                                        <?php  if(isset($_SESSION['inputFieldName'])) { 
                                        if($_SESSION['inputFieldName'] == 'name') {
                                        ?> <p><?php echo $_SESSION['inputFieldNameError'];?></p>
                                        <?php
                                        } }?>
                                    </div>
                                    <div class="form-group">
                                        <label for="designation">Designation <span class="mandatory">*</span></label>

                                        <select  name="designation" class="form-control" required>
                                            <option <?php if($result['designation']== '') echo "Selected";?> value="">Select</option>
                                            <?php foreach ($arrayDesignations as $key => $designation) { ?>
                                                <option <?php if($result['designation']== $designation) echo "Selected";?> value="<?php echo $designation;?>"><?php echo $designation;?></option>
                                            <?php } ?>
                                        </select>
                                        <?php 
                                            if(isset($_SESSION['inputFieldName'])) {
                                            if($_SESSION['inputFieldName'] == 'designation') {
                                        ?> <p><?php echo $_SESSION['inputFieldNameError'];?></p>
                                        <?php
                                        } }?>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email <span class="mandatory">*</span></label>
                                        <input name="email" value="<?php echo $result['email'];?>" class="form-control remove-space check-dublicate" id="email" placeholder="Enter Employee Email Address" type="email" autocomplete="off" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone_no">Phone No. <span class="mandatory">*</span></label>
                                        <input value="<?php echo $result['phone_no'];?>" name="phone_no" class="form-control remove-space" id="phone_no" placeholder="Enter Employee Phone Number" type="text" autocomplete="off" required>
                                    </div>
                                    <!-- <div class="form-group">
                                        <label for="password">Password <span class="mandatory">*</span></label>
                                        <input class="form-control" id="password" name="password" placeholder="Enter Password" type="password" autocomplete="off" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="confirmPassword">Confirm Password <span class="mandatory">*</span></label>
                                        <input name="confirm_password" class="form-control" id="confirmPassword" placeholder="Confirm Password" type="password" autocomplete="off" required>
                                    </div> -->
                                    
                                    
                                    <div class="from-group">
                                        <div class="radio" style="margin-top: 31px; margin-bottom: 32px;">
                                            <label style="margin-right: 40px;">
                                                <input <?php if($result['gender']=='Male') echo "checked";?> name="gender" id="optionsRadios1" value="Male" type="radio">
                                                 Male
                                            </label>
                                            <label>
                                                <input <?php if($result['gender']=='Female') echo "checked";?> name="gender" id="optionsRadios2" value="Female" type="radio">
                                                Female
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="pfAccount">PF Account</label>
                                        <input name="pf_account" value="<?php echo $result['pf_account'];?>" class="form-control" id="pfAccount" placeholder="Enter PF Account" type="text" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="lic_id">LIC ID</label>
                                        <input name="lic_id" value="<?php echo $result['lic_id'];?>" class="form-control" id="lic_id" placeholder="Enter LIC Id" type="text" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="ploicyNumber">Policy Number</label>
                                        <input value="<?php echo $result['policy_no'];?>" name="policy_no" class="form-control" id="ploicyNumber" placeholder="Enter Policy Number" type="text" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="bankAccount">Bank Account <span class="mandatory">*</span></label>
                                        <input value="<?php echo $result['bank_account'];?>" name="bank_account" class="form-control" id="bankAccount" placeholder="Enter Bank Account No." type="text" autocomplete="off" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="ifscCode">IFSC Code <span class="mandatory">*</span></label>
                                        <input value="<?php echo $result['ifsc_code'];?>" name="ifsc_code" class="form-control" id="ifscCode" placeholder="Enter IFSC Code." type="text" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="auto_generated_id">Employee Id <span class="mandatory">*</span></label>
                                        <!-- <div class="input-group date"> -->
                                            <?php if($manageIdStatus['employee_id'] == 1) { ?>
                                            <input value="<?php echo $result['employee_id'];?>" name="employee_id" class="form-control" id="auto_generated_id" placeholder="Enter Employee Id" type="text" autocomplete="off" readonly="" required>
                                            <?php } if ($manageIdStatus['employee_id'] == 2) { ?>
                                            <input value="<?php echo $result['employee_id'];?>" name="employee_id" class="form-control" id="auto_generated_id" placeholder="Enter Employee Id" type="text" autocomplete="off" required>
                                            <?php } ?>
                                            <!-- <div class="input-group-addon">
                                            <span id="edit_employee_id" style="cursor: pointer;">Edit ID</span>
                                          </div>
                                        </div>     -->
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="currentAddress">Current Adreess <span class="mandatory">*</span></label>
                                        <input value="<?php echo $result['current_address'];?>" name="current_address" class="form-control" id="currentAddress" placeholder="Enter Employee Address" type="text" autocomplete="off" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="permanentAddress">Permanent Adreess <span class="mandatory">*</span></label>
                                        <input value="<?php echo $result['permanent_address'];?>" name="permanent_address" class="form-control" id="permanentAddress" placeholder="Enter Employee Permament Address" type="text" autocomplete="off" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="fatherName">Father Name <span class="mandatory">*</span></label>
                                        <input value="<?php echo $result['father_name'];?>" name="father_name" class="form-control" id="fatherName" placeholder="Father Name" type="text" autocomplete="off" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Date of Joining <span class="mandatory">*</span></label>
                                        <div class="input-group date">
                                          <div class="input-group-addon calender-icon">
                                            <i class="fa fa-calendar"></i>
                                          </div>
                                          <input value="<?php echo $result['date_of_joining'];?>" name="date_of_joining" class="form-control pull-right" id="datepicker_date_of_joining" type="text">
                                        </div>
                                    </div> 
                                    <div class="form-group">
                                        <label>Date of Birth <span class="mandatory">*</span></label>
                                        <div class="input-group date">
                                            <div class="input-group-addon calender-icon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input value="<?php echo $result['date_of_birth'];?>" name="date_of_birth" class="form-control pull-right" id="datepicker_date_of_birth" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="pan">PAN <span class="mandatory">*</span></label>
                                        <input value="<?php echo $result['pan'];?>" name="pan" class="form-control" id="pan" placeholder="Enter PAN" type="text" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="drivingLicense">Driving License</label>
                                        <input value="<?php echo $result['driving_license_no'];?>" name="driving_license_no" class="form-control" id="drivingLicense" placeholder="Enter Driving License No." type="text" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="passportNo">Passport No</label>
                                        <input value="<?php echo $result['passport_no'];?>" name="passport_no" class="form-control" id="passportNo" placeholder="Enter Passport No." type="text" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="photo">Photo</label>
                                        <span style="color:#0000FF">[ Please upload a passport size photo of only JPG, GIF, PNG format and maximum size of 500 kb. For better resolution use 160 x 160 px image. ]</span>
                                        <input type="file" name="photo" class="dropify" data-height="100" data-allowed-file-extensions="png jpg jpeg" data-default-file="<?php echo 'uploads/employee/images/'.$result['photo'];?>" style="height: 100% !important;">
                                        <input type="hidden" name="oldPhoto" value="<?php echo $result['photo'];?>">
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <div class="box-footer text-center">
                            <input type="hidden" name="id" value="<?php echo $result['id'];?>">
                            <input type="submit" class="btn btn-primary" value="Save Changes" name="saveEditEmployeeDetails" >
                        </div>
                    </form>
                    <?php } 
                     if (isset($_GET['request_id'])) {
                     ?>
                      <form role="form" id="createEmployeeForm" method="POST" action="EmployeeController.php" enctype="multipart/form-data">
                        <input type="hidden" name="page_name" value="<?php echo $_SERVER['PHP_SELF'];?>">
                        <input type="hidden" name="profile_update_request" value="<?php echo $_GET['request_id'];?>">
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
                                        <?php if($resultRequestProfileDetails['name'] !='') { ?>
                                        <input class="form-control input-high-light" id="name" value="<?php echo $resultRequestProfileDetails['name'];?>" placeholder="Enter Name" type="text" name="name" autocomplete="off" required autofocus>
                                        <?php } else { ?>
                                         <input class="form-control" id="name" value="<?php echo $result['name'];?>" placeholder="Enter Name" type="text" name="name" autocomplete="off" required autofocus>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="designation">Designation <span class="mandatory">*</span></label>
                                        <?php if($resultRequestProfileDetails['designation'] !='') { ?>
                                        <select  name="designation" class="form-control input-high-light" required>
                                            <option <?php if($resultRequestProfileDetails['designation']== '') echo "Selected";?> value="">Select</option>
                                            <?php foreach ($arrayDesignations as $key => $designation) { ?>
                                                <option <?php if($resultRequestProfileDetails['designation']== $designation) echo "Selected";?> value="<?php echo $designation;?>"><?php echo $designation;?></option>
                                            <?php } ?>
                                        </select>
                                        <?php } else { ?>
                                        <select  name="designation" class="form-control" required>
                                            <option <?php if($result['designation']== '') echo "Selected";?> value="">Select</option>
                                            <?php foreach ($arrayDesignations as $key => $designation) { ?>
                                                <option <?php if($result['designation']== $designation) echo "Selected";?> value="<?php echo $designation;?>"><?php echo $designation;?></option>
                                            <?php } ?>
                                        </select>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email <span class="mandatory">*</span></label>
                                        <?php if($resultRequestProfileDetails['email'] !='') { ?>
                                        <input name="email" value="<?php echo $resultRequestProfileDetails['email'];?>" class="form-control remove-space check-dublicate" id="email" placeholder="Enter Employee Email Address input-high-light" type="email" autocomplete="off" required>
                                        <?php } else { ?>
                                        <input name="email" value="<?php echo $result['email'];?>" class="form-control" id="email" placeholder="Enter Employee Email Address" type="email" autocomplete="off" required>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone_no">Phone No. <span class="mandatory">*</span></label>
                                        <?php if($resultRequestProfileDetails['phone_no'] !='') { ?>
                                        <input value="<?php echo $resultRequestProfileDetails['phone_no'];?>" name="phone_no" class="form-control input-high-light" id="phone_no" placeholder="Enter Employee Phone Number" type="text" autocomplete="off" required>
                                        <?php } else { ?>
                                        <input value="<?php echo $result['phone_no'];?>" name="phone_no" class="form-control" id="phone_no" placeholder="Enter Employee Phone Number" type="text" autocomplete="off" required>
                                        <?php } ?>
                                    </div>
                                    
                                    <div class="from-group">
                                        <div class="radio" style="margin-top: 31px; margin-bottom: 32px;">
                                            <?php if($resultRequestProfileDetails['gender'] !='') { ?>
                                            <label style="margin-right: 40px;">
                                                <input <?php if($resultRequestProfileDetails['gender']=='Male') echo "checked";?> name="gender" id="optionsRadios1" value="Male" type="radio">
                                                 Male
                                            </label>
                                            <label>
                                                <input class="input-high-light" <?php if($resultRequestProfileDetails['gender']=='Female') echo "checked";?> name="gender" id="optionsRadios2" value="Female" type="radio">
                                                Female
                                            </label>
                                            <?php } else { ?>
                                            <label style="margin-right: 40px;">
                                                <input class="input-high-light" <?php if($result['gender']=='Male') echo "checked";?> name="gender" id="optionsRadios1" value="Male" type="radio">
                                                 Male
                                            </label>
                                            <label>
                                                <input <?php if($result['gender']=='Female') echo "checked";?> name="gender" id="optionsRadios2" value="Female" type="radio">
                                                Female
                                            </label>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="pfAccount">PF Account</label>
                                        <?php if($resultRequestProfileDetails['pf_account'] !='') { ?>
                                        <input name="pf_account" value="<?php echo $resultRequestProfileDetails['pf_account'];?>" class="form-control input-high-light" id="pfAccount" placeholder="Enter PF Account" type="text" autocomplete="off">
                                        <?php } else { ?>
                                        <input name="pf_account" value="<?php echo $result['pf_account'];?>" class="form-control" id="pfAccount" placeholder="Enter PF Account" type="text" autocomplete="off">
                                        <?php } ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="lic_id">LIC ID</label>
                                        <?php if($resultRequestProfileDetails['lic_id'] !='') { ?>
                                        <input name="lic_id" value="<?php echo $resultRequestProfileDetails['lic_id'];?>" class="form-control input-high-light" id="lic_id" placeholder="Enter LIC Id" type="text" autocomplete="off">
                                        <?php } else { ?>
                                        <input name="lic_id" value="<?php echo $result['lic_id'];?>" class="form-control" id="lic_id" placeholder="Enter LIC Id" type="text" autocomplete="off">
                                        <?php } ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="ploicyNumber">Policy Number</label>
                                        <?php if($resultRequestProfileDetails['policy_no'] !='') { ?>
                                        <input value="<?php echo $resultRequestProfileDetails['policy_no'];?>" name="policy_no" class="form-control input-high-light" id="ploicyNumber" placeholder="Enter Policy Number" type="text" autocomplete="off">
                                        <?php } else { ?>
                                        <input value="<?php echo $result['policy_no'];?>" name="policy_no" class="form-control" id="ploicyNumber" placeholder="Enter Policy Number" type="text" autocomplete="off">
                                        <?php } ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="bankAccount">Bank Account <span class="mandatory">*</span></label>
                                        <?php if($resultRequestProfileDetails['bank_account'] !='') { ?>
                                        <input value="<?php echo $resultRequestProfileDetails['bank_account'];?>" name="bank_account" class="form-control input-high-light" id="bankAccount" placeholder="Enter Bank Account No." type="text" autocomplete="off" required>
                                        <?php } else { ?>
                                        <input value="<?php echo $result['bank_account'];?>" name="bank_account" class="form-control" id="bankAccount" placeholder="Enter Bank Account No." type="text" autocomplete="off" required>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="ifscCode">IFSC Code <span class="mandatory">*</span></label>
                                        <?php if($resultRequestProfileDetails['ifsc_code'] !='') { ?>
                                        <input value="<?php echo $resultRequestProfileDetails['ifsc_code'];?>" name="ifsc_code" class="form-control input-high-light" id="ifscCode" placeholder="Enter IFSC Code." type="text" autocomplete="off" required>
                                        <?php } else { ?>
                                        <input value="<?php echo $result['ifsc_code'];?>" name="ifsc_code" class="form-control" id="ifscCode" placeholder="Enter IFSC Code." type="text" autocomplete="off" required>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="auto_generated_id">Employee Id <span class="mandatory">*</span></label>
                                        <!-- <div class="input-group date"> -->
                                            <?php if($manageIdStatus['employee_id'] == 1) { ?>
                                            <input value="<?php echo $result['employee_id'];?>" name="employee_id" class="form-control" id="auto_generated_id" placeholder="Enter Employee Id" type="text" autocomplete="off" readonly="" required>
                                            <?php } if ($manageIdStatus['employee_id'] == 2) { ?>
                                            <input value="<?php echo $result['employee_id'];?>" name="employee_id" class="form-control" id="auto_generated_id" placeholder="Enter Employee Id" type="text" autocomplete="off" required>
                                            <?php } ?>
                                            <!-- <div class="input-group-addon">
                                            <span id="edit_employee_id" style="cursor: pointer;">Edit ID</span>
                                          </div>
                                        </div>     -->
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="currentAddress">Current Adreess <span class="mandatory">*</span></label>
                                        <?php if($resultRequestProfileDetails['current_address'] !='') { ?>
                                        <input value="<?php echo $resultRequestProfileDetails['current_address'];?>" name="current_address" class="form-control input-high-light" id="currentAddress" placeholder="Enter Employee Address" type="text" autocomplete="off" required>
                                        <?php } else { ?>
                                        <input value="<?php echo $result['current_address'];?>" name="current_address" class="form-control" id="currentAddress" placeholder="Enter Employee Address" type="text" autocomplete="off" required>
                                        <?php } ?>

                                    </div>
                                    <div class="form-group">
                                        <label for="permanentAddress">Permanent Adreess <span class="mandatory">*</span></label>
                                        <?php if($resultRequestProfileDetails['permanent_address'] !='') { ?>
                                        <input value="<?php echo $resultRequestProfileDetails['permanent_address'];?>" name="permanent_address" class="form-control input-high-light" id="permanentAddress" placeholder="Enter Employee Permament Address" type="text" autocomplete="off" required>
                                        <?php } else { ?>
                                        <input value="<?php echo $result['permanent_address'];?>" name="permanent_address" class="form-control" id="permanentAddress" placeholder="Enter Employee Permament Address" type="text" autocomplete="off" required>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="fatherName">Father Name <span class="mandatory">*</span></label>
                                        <?php if($resultRequestProfileDetails['father_name'] !='') { ?>
                                        <input value="<?php echo $resultRequestProfileDetails['father_name'];?>" name="father_name" class="form-control input-high-light" id="fatherName" placeholder="Father Name" type="text" autocomplete="off" required>
                                        <?php } else { ?>
                                        <input value="<?php echo $result['father_name'];?>" name="father_name" class="form-control" id="fatherName" placeholder="Father Name" type="text" autocomplete="off" required>
                                        <?php } ?>

                                    </div>
                                    <div class="form-group">
                                        <label>Date of Joining <span class="mandatory">*</span></label>
                                        <div class="input-group date">
                                          <div class="input-group-addon calender-icon">
                                            <i class="fa fa-calendar"></i>
                                          </div>
                                          <?php if($resultRequestProfileDetails['date_of_joining'] !='') { ?>
                                          <input value="<?php echo $resultRequestProfileDetails['date_of_joining'];?>" name="date_of_joining" class="form-control pull-right input-high-light" id="datepicker_date_of_joining" type="text">
                                          <?php } else { ?>
                                          <input value="<?php echo $result['date_of_joining'];?>" name="date_of_joining" class="form-control pull-right" id="datepicker_date_of_joining" type="text">
                                          <?php } ?>
                                        </div>
                                    </div> 
                                    <div class="form-group">
                                        <label>Date of Birth <span class="mandatory">*</span></label>
                                        <div class="input-group date">
                                            <div class="input-group-addon calender-icon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <?php if($resultRequestProfileDetails['date_of_birth'] !='') { ?>
                                            <input value="<?php echo $resultRequestProfileDetails['date_of_birth'];?>" name="date_of_birth" class="form-control pull-right input-high-light" id="datepicker_date_of_birth" type="text">
                                            <?php } else { ?>
                                            <input value="<?php echo $result['date_of_birth'];?>" name="date_of_birth" class="form-control pull-right" id="datepicker_date_of_birth" type="text">
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="pan">PAN <span class="mandatory">*</span></label>
                                        <?php if($resultRequestProfileDetails['pan'] !='') { ?>
                                        <input value="<?php echo $resultRequestProfileDetails['pan'];?>" name="pan" class="form-control input-high-light" id="pan" placeholder="Enter PAN" type="text" autocomplete="off">
                                        <?php } else { ?>
                                        <input value="<?php echo $result['pan'];?>" name="pan" class="form-control" id="pan" placeholder="Enter PAN" type="text" autocomplete="off">
                                        <?php } ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="drivingLicense">Driving License</label>
                                        <?php if($resultRequestProfileDetails['driving_license_no'] !='') { ?>
                                        <input value="<?php echo $resultRequestProfileDetails['driving_license_no'];?>" name="driving_license_no" class="form-control input-high-light" id="drivingLicense" placeholder="Enter Driving License No." type="text" autocomplete="off">
                                        <?php } else { ?>
                                        <input value="<?php echo $result['driving_license_no'];?>" name="driving_license_no" class="form-control" id="drivingLicense" placeholder="Enter Driving License No." type="text" autocomplete="off">
                                        <?php } ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="passportNo">Passport No</label>
                                        <?php if($resultRequestProfileDetails['passport_no'] !='') { ?>
                                        <input value="<?php echo $resultRequestProfileDetails['passport_no'];?>" name="passport_no" class="form-control input-high-light" id="passportNo" placeholder="Enter Passport No." type="text" autocomplete="off">
                                        <?php } else { ?>
                                        <input value="<?php echo $result['passport_no'];?>" name="passport_no" class="form-control" id="passportNo" placeholder="Enter Passport No." type="text" autocomplete="off">
                                        <?php } ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="photo">Photo</label>
                                        <span style="color:#0000FF">[ Please upload a passport size photo of only JPG, GIF, PNG format and maximum size of 500 kb. For better resolution use 160 x 160 px image. ]</span>
                                        <?php if($resultRequestProfileDetails['photo'] !='') { ?>
                                        <style type="text/css">
                                            .dropify-wrapper {
                                                border:1px solid #FF0000 !important;
                                            }
                                        </style>
                                        <input type="file" name="photo" class="dropify input-high-light" data-height="100" data-allowed-file-extensions="png jpg jpeg" data-default-file="<?php echo 'uploads/employee/images/'.$resultRequestProfileDetails['photo'];?>" style="height: 100% !important; border-color: #FF0000;">
                                        <input type="hidden" name="oldPhoto" value="<?php echo $resultRequestProfileDetails['photo'];?>">
                                        <?php } else { ?>
                                        <input type="file" name="photo" class="dropify" data-height="100" data-allowed-file-extensions="png jpg jpeg" data-default-file="<?php echo 'uploads/employee/images/'.$result['photo'];?>" style="height: 100% !important;">
                                        <input type="hidden" name="oldPhoto" value="<?php echo $result['photo'];?>">
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <div class="box-footer text-center">
                            <input type="hidden" name="id" value="<?php echo $result['id'];?>">
                            <input type="submit" class="btn btn-primary" value="Save Changes" name="saveEditEmployeeDetails" >
                        </div>
                    </form>
                     <?php } ?>
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
    var db_employee_id = '<?php echo $result['employee_id'];?>';
    $('#auto_generated_id').keyup( function() {
        var check_employee_id = $(this).val();
        if(db_employee_id != check_employee_id) {

            $.ajax({
                url: "EmployeeController.php",
                type: "post",
                cache: false,
                data: {"check_employee_id": check_employee_id},
                success: function(result){
                    if(result==1) {
                        $('#auto_generated_id').val('');
                        $('#auto_generated_id').html(''); 
                        swal("Oops", "Employee Id already exists. Please try another one.", "error");        
                    }
                    
                    
                }
            });
        }
    });
    // $('.dropify-clear').click( function() {
    //     var db_id = '<?php //echo $result['id'];?>';
    //     $.ajax({
    //         url: "EmployeeController.php",
    //         type: "post",
    //         cache: false,
    //         data: {"db_id": db_id},
    //         success: function(result){
    //             if(result==1) {
    //             alert("ok");        
    //             }
    //          }
    //     });
    // });

    // fade error message div
    $( ".clear-error-msg" ).click(function() {
        $( ".error-message" ).fadeOut( "slow" );
    });

    // show date picker on click on icon
    $('.calender-icon').click(function() {
        $(this).next('input').focus();
    });
    // trimspace
    $('.remove-space').each(function() {
        $(this).keyup(function() {
            var field = $(this);
            var str = $(this).val();
            $(this).val($.trim(str));
        });
    });
    //check dublicate
    $('.check-dublicate').each(function() {
        $(this).keyup(function() {
            var field = $(this);
            var str = $(this).val();
            $(this).val($.trim(str));
            var oldValue = '<?php echo $result['email'];?>';
            var field_name = $(this).attr('name');
            var check_already_exist_value = $(this).val();
            if(oldValue != check_already_exist_value) { 
                $.ajax({
                    url: "EmployeeController.php",
                    type: "post",
                    cache: false,
                    data: {"check_already_exist_value": check_already_exist_value, "field_name": field_name},
                    success: function(result){
                        if(result==1) {
                            field.val('');
                            swal("oops", "Given "+field_name+" already exist.Please try another.", "error"); 
                            field.focus();
                        }
                        
                    }
                });
            }    

        });
    });
</script>
</body>
</html>