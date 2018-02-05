<?php 
$title = 'Change Password';
include('include/header.php');
include_once 'AdminManager.php';
$adminManager = new AdminManager();
$result = $adminManager->getAdminDetails();
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Change Password</h1>
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
                        <?php if(isset($_SESSION['changePasswordErrorMsg'])) { ?>
                        <p class="alert alert-danger"><?php  echo $_SESSION['changePasswordErrorMsg'];?></p>
                        <?php 
                        unset($_SESSION['changePasswordErrorMsg']);
                        } ?>
                        <div class="col-md-3"></div>
                        <div class="col-md-6">  
                            <form role="form" id="changePasswordForm" method="POST" action="AdminController.php">
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
            <!-- /.box -->
            </div>
        </div>
        <!-- /.row -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include('include/footer.php');
if(isset($_SESSION['changePasswordSuccessMsg'])) {
?>
<script type="text/javascript">
  swal('Congrats', 'Your Password has been update successfully.', 'success');
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