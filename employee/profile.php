<?php include('../employee/include/header.php');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Profile</h1>
        <ol class="breadcrumb">
            <li><a href="home.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li> Settings</li>
            <li class="active"><a href="profile.php"> Profile</a></li>
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
                       <div class="col-md-4">
                            <div><label>Employee Id: </label> <?php echo str_pad($employeeInfo['employee_id'], 4, '0', STR_PAD_LEFT);?></div>
                            <div><label>Name: </label> <?php echo $employeeInfo['name'];?></div>
                             <div><label>Father Name: </label> <?php echo $employeeInfo['father_name'];?></div>
                            <div><label>Gender: </label> <?php echo $employeeInfo['gender'];?></div>
                            <div><label>Designation: </label> <?php echo $employeeInfo['designation'];?></div>
                            <div><label>Email: </label> <?php echo $employeeInfo['email'];?></div>
                            <div><label>Phone No.: </label> <?php echo $employeeInfo['phone_no'];?></div>
                            <div><label>Current Address: </label> <?php echo $employeeInfo['current_address'];?></div>
                            <div><label>Permanent Address: </label> <?php echo $employeeInfo['permanent_address'];?></div>
                           
                            <div><label>Date of Joining: </label> <?php echo $employeeInfo['date_of_joining'];?></div>
                            <div><label>Date of Birth: </label> <?php echo $employeeInfo['date_of_birth'];?></div>
                            <div><label>PF Account: </label> <?php echo $employeeInfo['pf_account'];?></div>
                            <div><label>Policy No: </label> <?php echo $employeeInfo['policy_no'];?></div>
                            <div><label>LIC Id: </label> <?php echo $employeeInfo['lic_id'];?></div>
                            <div><label>PAN: </label> <?php echo $employeeInfo['pan'];?></div>
                            <div><label>Passport No: </label> <?php echo $employeeInfo['passport_no'];?></div>
                            <div><label>Driving License No: </label> <?php echo $employeeInfo['driving_license_no'];?></div>
                            <div><label>Bank Account: </label> <?php echo $employeeInfo['bank_account'];?></div>
                            <div><label>IFSC Code: </label> <?php echo $employeeInfo['ifsc_code'];?></div>
                        </div>
                        <div class="col-md-2">
                            <img style="width: 50%;" src="../uploads/employee/images/<?php echo $employeeInfo['photo']; ?>">
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
<?php include('../employee/include/footer.php'); ?>
</body>
</html>
