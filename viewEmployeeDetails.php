<?php 
include('include/header.php');
include_once 'EmployeeManager.php';?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Employee Details</h1>
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
                       <div class="col-md-4">
                            <?php
                            if (isset($_GET['employee_id'])) {
                                $employee_id = trim(stripslashes($_GET['employee_id']));
                                $employeeManager = new EmployeeManager();
                                $result = $employeeManager->getEmployeeDetailsByEmployeeId($employee_id);
                                //echo $result['name'];
                            ?>
                            <div><label>Employee Id: </label> <?php echo str_pad($result['employee_id'], 4, '0', STR_PAD_LEFT);?></div>
                            <div><label>Name: </label> <?php echo $result['name'];?></div>
                             <div><label>Father Name: </label> <?php echo $result['father_name'];?></div>
                            <div><label>Gender: </label> <?php echo $result['gender'];?></div>
                            <div><label>Designation: </label> <?php echo $result['designation'];?></div>
                            <div><label>Email: </label> <?php echo $result['email'];?></div>
                            <div><label>Phone No.: </label> <?php echo $result['phone_no'];?></div>
                            <div><label>Current Address: </label> <?php echo $result['current_address'];?></div>
                            <div><label>Permanent Address: </label> <?php echo $result['permanent_address'];?></div>
                           
                            <div><label>Date of Joining: </label> <?php echo $result['date_of_joining'];?></div>
                            <div><label>Date of Birth: </label> <?php echo $result['date_of_birth'];?></div>
                            <div><label>PF Account: </label> <?php echo $result['pf_account'];?></div>
                            <div><label>Policy No: </label> <?php echo $result['policy_no'];?></div>
                            <div><label>LIC Id: </label> <?php echo $result['lic_id'];?></div>
                            <div><label>PAN: </label> <?php echo $result['pan'];?></div>
                            <div><label>Passport No: </label> <?php echo $result['passport_no'];?></div>
                            <div><label>Driving License No: </label> <?php echo $result['driving_license_no'];?></div>
                            <div><label>Bank Account: </label> <?php echo $result['bank_account'];?></div>
                            <div><label>IFSC Code: </label> <?php echo $result['ifsc_code'];?></div>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="col-md-2">
                            <img style="width: 50%;" src="uploads/employee/images/<?php echo $result['photo']; ?>">
                        </div>
                        <div class="col-md-6"></div>
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
if($_SESSION['successMsg'] == 'employeeAdded') {
?>
<script type="text/javascript">
    alert('Employee Created Successfully');

</script>

<?php 
unset($_SESSION['successMsg']);  
}
?>
</body>
</html>