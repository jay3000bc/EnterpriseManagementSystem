<?php include('include/header.php');
date_default_timezone_set('Asia/Kolkata');
include_once 'AdminManager.php';
$adminManager = new AdminManager();
$result = $adminManager->getEmployeeTermsConditions();
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Employee Terms &amp; Conditions</h1>
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
                        <?php if($result['file_name'] != '') {?>
                        <iframe src="<?php echo $relativeUrl;?>uploads/termsAndConditions_pdf/<?php echo $result['file_name'];?>" width="100%" height="500px"></iframe>
                        <?php } else { ?>
                        <iframe src="<?php echo $relativeUrl;?>uploads/termsAndConditions_pdf/EMPLOYEES-AGREMENT-ALEGRALABS.pdf" width="100%" height="500px"></iframe>
                        <?php } ?>
                        <div class="form-group">
                            <br>
                            <a class="btn btn-primary update-btn pull-left">Upload Terms &amp; Conditions</a>
                            <p class="pull-right">
                                <label>Updated at:</label>
                                <?php $date=$result['created_at']; 
                                $timestamp = strtotime($date);
                                echo date("d-m-Y H:i:s", $timestamp);?></p>
                        </div>
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
?>
<script type="text/javascript">
    $('.update-btn').click(function() {
        $('#myModal').modal('show');
    });
</script>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Upload Employee Terms &amp; Conditions</h4>
            </div>
            <div class="modal-body">
                <form role="form" id="" method="POST" action="AdminController.php" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="file" class="dropify" name="employee_terms_conditions">
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-success btn" name="updateTermsConditions" value="Save">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
if(isset($_SESSION['updateTermsConditionsSuccess'])) {
?>
<script type="text/javascript">
  swal('Congrats', 'Employee Terms and Conditions has been update successfully.', 'success');
</script>

<?php   
unset($_SESSION['updateTermsConditionsSuccess']);
}
?>
</body>
</html> 