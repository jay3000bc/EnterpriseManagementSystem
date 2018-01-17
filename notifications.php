<?php 
date_default_timezone_set('Asia/Kolkata');
include('settings/config.php');
include('include/header.php');
include_once 'EmployeeManager.php';
$employeeManager = new EmployeeManager();
$totalProfileUpdateRequest = $employeeManager->getProfileUpdateRequest();
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Notifications</h1>
        <?php include_once('include/notificationBell.php'); ?>
    </section>

    <!-- Main content -->
    <section class="content">
    <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h4>You have <?php echo $totalProfileUpdateRequest;?> notifications.</h4>
                      
                    </div>
                    <div class="box-body">
                        <div class="row">  
                            <div class="col-md-12">
                                <ul class="list-group">
                                    <?php for ($i=0; $i < $totalProfileUpdateRequest ; $i++) { 
                                        $employeeDetails = $employeeManager->getEmployeeDetailsByEmployeeId($employeeManager->request_profile_employee_id[$i]);
                                        $resultRequestProfileDetails = $employeeManager->getRequestProfileEmployeeDetails($employeeManager->request_profile_employee_id[$i]);
                                    ?>
                                    <li class="list-group-item">
                                    <a href="editEmployee.php?request_id=<?php echo $employeeDetails['employee_id'];?>">
                                    <i class="fa fa-user text-aqua"></i> &nbsp;<?php echo $employeeDetails['name']. ' has requested for Profile Update on '. date('d-m-Y', strtotime($resultRequestProfileDetails['created_at'])). ' at '. date('h:i:s A', strtotime($resultRequestProfileDetails['created_at'])); ?>
                                    </a>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- /.box -->
                </div>
            </div>
        </div>
        <!-- /.row -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include('include/footer.php');?>
</body>
</html>