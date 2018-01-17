<?php
include('../employee/include/header.php');
$microtime = microtime(true);
$result = $employeeManager->getEmployeeDetails($id);
$resultRequestProfileDetails = $employeeManager->getRequestProfileEmployeeDetails($employee_id);
if(isset($_POST['requestProfileChanges'])) {
    //echo $id;
    if($result['email'] != mysqli_real_escape_string($DBManager->conn, $_POST['email'])) {
        $email = mysqli_real_escape_string($DBManager->conn, $_POST['email']);
        $getExistEmail = $employeeManager->editCheckUnique($id, 'email');
        
        if($getExistEmail['email'] != $email ) {
            $check_email_unique_result = $employeeManager->checkUnique($email, 'email');
            if($check_email_unique_result > 0 ) {
                $_SESSION['ErrorMsg'] = "Email already exist. Please try another.";
                echo '<script type="text/javascript">
                   window.location = "editProfile.php"
              </script>';
                die();
            }
        }
    } else {
        $email = NULL;
    }
    if($result['phone_no'] != mysqli_real_escape_string($DBManager->conn, $_POST['phone_no'])) {
        $phone_no = mysqli_real_escape_string($DBManager->conn, $_POST['phone_no']);
    
        $getExistPhone = $employeeManager->editCheckUnique($id, 'phone_no');
        if($getExistPhone['phone_no'] != $phone_no ) {
            $check_phone_unique_result = $employeeManager->checkUnique($phone_no, 'phone_no');
            if($check_phone_unique_result > 0 ) {
                $_SESSION['ErrorMsg'] = "Phone number already exist. Please try another.";
                echo '<script type="text/javascript">
                   window.location = "editProfile.php"
              </script>';
                die();
            }
        }

    } else {
        $phone_no = NULL;
    }
    if($result['name'] != mysqli_real_escape_string($DBManager->conn, $_POST['name'])) {
        $name = mysqli_real_escape_string($DBManager->conn, $_POST['name']);
    } else {
        $name = NULL;
    }
    $designation = NULL;
    $password = NULL;
    $encryptpassword = NULL;

    $oldPhoto = mysqli_real_escape_string($DBManager->conn, $_POST['oldPhoto']);
    /*image upload*/
    if($_FILES["photo"]['name'][0] != '') {
        //echo "string";die();
        $target_dir = "../uploads/employee/images/";
        $target_file = $target_dir . $microtime . basename($_FILES["photo"]["name"]);
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        $check = getimagesize($_FILES["photo"]["tmp_name"]);
        // Check if image file is a actual image or fake image
        if ($check == false) {
            $_SESSION['ErrorMsg'] = "File is not an image.";
            echo '<script type="text/javascript">
               window.location = "editProfile.php"
            </script>';
        }
        // Check if file already exists
        elseif (file_exists($target_file)) {
            //echo "string"; die();
            $_SESSION['ErrorMsg'] = "Sorry, image file already exists.";
            echo '<script type="text/javascript">
               window.location = "editProfile.php"
            </script>';
            exit();
        } 
         // Check file size
        elseif ($_FILES["photo"]["size"] > 5242880) {
            $_SESSION['ErrorMsg'] = "Sorry, image file is too large. Maximum file size must be less than 5MB.";
            echo '<script type="text/javascript">
                window.location = "editProfile.php"
            </script>';
            exit();
        }
        // Allow certain file formats
        elseif ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            $_SESSION['ErrorMsg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            echo '<script type="text/javascript">
                window.location = "editProfile.php"
            </script>';
            exit();
        }
        else {
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                unlink( 'uploads/employee/profileRequest'.$oldPhoto );
                $photo = $microtime.basename($_FILES["photo"]["name"]);
                //die();
            } else {
                $_SESSION['ErrorMsg'] = "Sorry, there was an error uploading your file.";
                echo '<script type="text/javascript">
                   window.location = "editProfile.php"
                </script>';
                exit();

            }
        }
    }
    else {
        $photo = NULL;
    } 
    if($result['current_address'] != mysqli_real_escape_string($DBManager->conn, $_POST['current_address'])) {
        $current_address = mysqli_real_escape_string($DBManager->conn, $_POST['current_address']);
    } else {
        $current_address = NULL;
    }
    if($result['permanent_address'] != mysqli_real_escape_string($DBManager->conn, $_POST['permanent_address'])) {
        $permanent_address = mysqli_real_escape_string($DBManager->conn, $_POST['permanent_address']);
    } else {
        $permanent_address = NULL;
    }
    if($result['father_name'] != mysqli_real_escape_string($DBManager->conn, $_POST['father_name'])) {
        $father_name = mysqli_real_escape_string($DBManager->conn, $_POST['father_name']);
    } else {
        $father_name = NULL;
    }
    if($result['gender'] != mysqli_real_escape_string($DBManager->conn, $_POST['gender'])) {
        $gender = mysqli_real_escape_string($DBManager->conn, $_POST['gender']);
    } else {
        $gender  = NULL;
    }
    if($result['date_of_joining'] != mysqli_real_escape_string($DBManager->conn, $_POST['date_of_joining'])) {
        $date_of_joining = mysqli_real_escape_string($DBManager->conn, $_POST['date_of_joining']);
    } else {
        $date_of_joining = NULL;
    }
    if($result['date_of_birth'] != mysqli_real_escape_string($DBManager->conn, $_POST['date_of_birth'])) {
       $date_of_birth = mysqli_real_escape_string($DBManager->conn, $_POST['date_of_birth']); 
    } else {
        $date_of_birth = NULL;
    }
    if($result['pf_account'] != mysqli_real_escape_string($DBManager->conn, $_POST['pf_account'])) {
        $pf_account = mysqli_real_escape_string($DBManager->conn, $_POST['pf_account']);
    } else {
        $pf_account = NULL;
    }
    if($result['policy_no'] != mysqli_real_escape_string($DBManager->conn, $_POST['policy_no'])) {
        $policy_no = mysqli_real_escape_string($DBManager->conn, $_POST['policy_no']);
    } else {
        $policy_no = NULL;
    }
    if($result['lic_id'] != mysqli_real_escape_string($DBManager->conn, $_POST['lic_id'])) {
        $lic_id = mysqli_real_escape_string($DBManager->conn, $_POST['lic_id']);
    } else {
        $lic_id = NULL;
    }
    if($result['pan'] != mysqli_real_escape_string($DBManager->conn, $_POST['pan'])) {
        $pan = mysqli_real_escape_string($DBManager->conn, $_POST['pan']);
        $getExistPAN = $employeeManager->editCheckUnique($id, 'pan');
        if($getExistPAN['pan'] != $pan ) {
            $check_pan_unique_result = $employeeManager->checkUnique($pan, 'pan');
            if($check_pan_unique_result > 0 ) {
                $_SESSION['ErrorMsg'] = "PAN already exist..";
                echo '<script type="text/javascript">
                   window.location = "editProfile.php"
                </script>';
                die();
            }
        } 
    } else {
        $pan = NULL;
    }
    if($result['passport_no'] != mysqli_real_escape_string($DBManager->conn, $_POST['passport_no'])) {
        $passport_no = mysqli_real_escape_string($DBManager->conn, $_POST['passport_no']);
    } else {
        $passport_no = NULL;
    }
    if($result['driving_license_no'] != mysqli_real_escape_string($DBManager->conn, $_POST['driving_license_no'])) {
        $driving_license_no = mysqli_real_escape_string($DBManager->conn, $_POST['driving_license_no']);
    } else {
        $driving_license_no = NULL;
    }
    if($result['bank_account'] != mysqli_real_escape_string($DBManager->conn, $_POST['bank_account'])) {
        $bank_account = mysqli_real_escape_string($DBManager->conn, $_POST['bank_account']);
        $getExistAC = $employeeManager->editCheckUnique($id, 'bank_account');
        if($getExistAC['bank_account'] != $bank_account ) {
            $check_bank_account_unique_result = $employeeManager->checkUnique($bank_account, 'bank_account');
            if($check_bank_account_unique_result > 0 ) {
                $_SESSION['ErrorMsg'] = "Bank Account already exist.";
                echo '<script type="text/javascript">
                   window.location = "editProfile.php"
                </script>';
                die();
            }
        }
    } else {
        $bank_account = NULL;
    }
    if($result['ifsc_code'] != mysqli_real_escape_string($DBManager->conn, $_POST['ifsc_code'])) {
        $ifsc_code = mysqli_real_escape_string($DBManager->conn, $_POST['ifsc_code']); 
    } else {
        $ifsc_code = NULL;
    }
    $result = $employeeManager->editProfileRequset($employee_id, $name, $designation, $email, $phone_no, $encryptpassword, $photo, $current_address, $permanent_address, $father_name, $gender, $date_of_joining, $date_of_birth, $pf_account, $policy_no, $lic_id, $pan, $passport_no, $driving_license_no, $bank_account, $ifsc_code);
    if($result) {
        $_SESSION['successMsg'] = "successProfileRequest";
        echo '<script type="text/javascript">
           window.location = "home.php"
        </script>';
        die();
    }
    else {
        $_SESSION['ErrorMsg'] = "Sorry, Failed to send profile Request Update";
        echo '<script type="text/javascript">
           window.location = "editProfile.php"
        </script>';
        die();
    }
}   
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Edit Profile</h1>
        <ol class="breadcrumb">
            <li><a href="home.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li> Settings</li>
            <li class="active"><a href="editProfile.php"> Edit Profile</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <form role="form" id="createEmployeeForm" method="POST" action="editProfile.php" enctype="multipart/form-data">
                       <!--  <form role="form" id="createEmployeeForm" method="POST" action="../EmployeeController.php" enctype="multipart/form-data"> -->
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
                                <?php
                                 if(count($resultRequestProfileDetails) > 0) { ?>
                                     <div class="col-md-12 error-message">
                                        <p class="alert alert-warning">You have already sent profile update request to admin. <span style="color:#fff;" class="clear-error-msg close">&times;</span></p>
                                    </div>    
                                <?php } ?>
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
                                        <label for="email">Email <span class="mandatory">*</span></label>
                                        <input name="email" value="<?php echo $result['email'];?>" class="form-control remove-space check-dublicate" id="email" placeholder="Enter Employee Email Address" type="email" autocomplete="off" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="photo">Photo</label>
                                        <input type="file" name="photo" class="dropify" data-height="100" data-allowed-file-extensions="png jpg jpeg" data-default-file="<?php echo '../uploads/employee/images/'.$result['photo'];?>" style="height: 100% !important;">
                                        <input type="hidden" name="oldPhoto" value="<?php echo $result['photo'];?>">
                                    </div>
                                    
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
                                        <input value="<?php echo $result['bank_account'];?>" name="bank_account" class="form-control" id="bankAccount" placeholder="Enter Passport No." type="text" autocomplete="off" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="ifscCode">IFSC Code <span class="mandatory">*</span></label>
                                        <input value="<?php echo $result['ifsc_code'];?>" name="ifsc_code" class="form-control" id="ifscCode" placeholder="Enter Passport No." type="text" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone_no">Phone No. <span class="mandatory">*</span></label>
                                        <input value="<?php echo $result['phone_no'];?>" name="phone_no" class="form-control" id="phone_no" placeholder="Enter Employee Phone Number" type="text" autocomplete="off" required>
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
                                          <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                          </div>
                                          <input value="<?php echo $result['date_of_joining'];?>" name="date_of_joining" class="form-control pull-right" id="datepicker_date_of_joining" type="text">
                                        </div>
                                    </div> 
                                    <div class="form-group">
                                        <label>Date of Birth <span class="mandatory">*</span></label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
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
                                        <input value="<?php echo $result['driving_license_no'];?>" name="driving_license_no" class="form-control" id="drivingLicense" placeholder="Enter Passport No." type="text" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="passportNo">Passport No</label>
                                        <input value="<?php echo $result['passport_no'];?>" name="passport_no" class="form-control" id="passportNo" placeholder="Enter Passport No." type="text" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <div class="box-footer text-center">
                            <input type="hidden" name="id" value="<?php echo $result['id'];?>">
                            <?php if(count($resultRequestProfileDetails) > 0) {
                             ?>
                            <input type="text" class="btn btn-primary" value="Request Changes" name="requestProfileChanges" disabled>
                            <?php }  else { ?>
                            <input type="submit" class="btn btn-primary" value="Request Changes" name="requestProfileChanges">
                            <?php } ?>
                        </div>
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
    var db_employee_id = '<?php echo $result['employee_id'];?>';
    //alert(parseInt(db_employee_id));
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
                        //swal("Employee Id already exists. Please try another one."); 
                        swal("Oops", "Employee Id already exists. Please try another one.", "error");        
                    }
                    
                    
                }
            });
        }
    });
    $('.dropify-clear').click( function() {
        //alert('hello');
        var db_id = '<?php echo $result['id'];?>';
        $.ajax({
            url: "EmployeeController.php",
            type: "post",
            cache: false,
            data: {"db_id": db_id},
            success: function(result){
                if(result==1) {
                alert("ok");        
                }
             }
        });
    });

    // fade error message div
    $( ".clear-error-msg" ).click(function() {
        $( ".error-message" ).fadeOut( "slow" );
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
                    url: "../EmployeeController.php",
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