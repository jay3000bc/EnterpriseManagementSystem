<?php
$title = 'Change Password';
include('../employee/include/header.php');

// change password
if (isset($_POST["changePasswordForm"])) {
    include_once '../DBManager.php';
    $DBManager = new DBManager();
    include_once '../EmployeeManager.php';
    $employeeChangePasswordForm = new EmployeeManager();
    $id = mysqli_real_escape_string($DBManager->conn, $_POST['id']);
    $currentPassword = mysqli_real_escape_string($DBManager->conn, $_POST['currentPassword']);
    $newPassword = mysqli_real_escape_string($DBManager->conn, $_POST['newPassword']);
    $encryptCurrentPassword = md5($currentPassword);
    $encryptNewPassword = md5($newPassword);
    $result = $employeeChangePasswordForm->employeeChangePassword($id, $encryptCurrentPassword, $encryptNewPassword);
} 
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Change Password</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li>Settings</li>
            <li class="active"><a href="changePasswordForm">Change Password</a></li>
        </ol>
    </section>

<!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
            <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-body">
                        <?php if(isset($_SESSION['changePasswordErrorMsg'])) { ?>
                        <div class="col-md-12 error-message">
                            <p class="alert alert-danger"><?php  echo $_SESSION['changePasswordErrorMsg'];?><span style="color:#fff;" class="clear-error-msg close">&times;</span></p>
                        </div>
                        <?php 
                        unset($_SESSION['changePasswordErrorMsg']);
                        } ?>
                        <div class="col-md-3"></div>
                        <div class="col-md-6">  
                            <form role="form" id="changePasswordForm" method="POST" action="changePasswordForm">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                <div class="form-group">
                                    <label for="currentPassword">Current Password</label>
                                    <input class="form-control" id="currentPassword" placeholder="Current Password" type="password" name="currentPassword" autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">New Password</label>
                                    <input data-toggle="popover" title="Password Strength" data-content="Enter Password..." class="form-control" id="password" name="newPassword" placeholder="New Password" type="password" autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label for="confirmPassword">Confirm Password</label>
                                    <input class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password" type="password" autocomplete="off" required>
                                </div>
                                <div class="form-group text-center">
                                    <input type="submit" class="btn btn-primary" value="Update" name="changePasswordForm" >
                                </div>
                            </form>
                        </div>
                        <div class="col-md-3"></div>
                        <!-- /.box-body -->
                    </div>    
                </div>
            </div>   
        </div>
     </section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include('../employee/include/footer.php');
if(isset($_SESSION['changePasswordSuccessMsg'])) {
?>
<script type="text/javascript">
    var buttonDesign = 'btn';
    var buttonDesignColor = 'btn-primary';
    link = '../logout.php';
    swal({
        title: "Congrats<br><small>Your password has been update successfully.</small>",
        text: "Your password has been update successfully.",
        icon: "success",
        text: "<a class=" + buttonDesign + buttonDesignColor+" href="+ link +">Re-Login</a>",  
        html: true,
        showConfirmButton: false
        }); 
</script>
<?php   
unset($_SESSION['changePasswordSuccessMsg']);
}
if(isset($_SESSION['changePhotoSuccessMsg'])) {
?>
<script type="text/javascript">
  swal('Congrats', 'Your Photo has been updated successfully.', 'success');
</script>

<?php   
unset($_SESSION['changePhotoSuccessMsg']);
}
?>
</body>
</html>
