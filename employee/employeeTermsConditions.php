<?php include('../employee/include/header.php');
include_once '../AdminManager.php';
$adminManager = new AdminManager();
$result = $adminManager->getEmployeeTermsConditions();
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <h1>Employee Terms &amp; Conditions</h1>
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Employee</li>
        <li class="active"><a href="employeeTermsConditions.php">Employee Terms &amp; Conditions</a></li>
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
                        <?php if($result['file_name'] != '') {?>
                        <iframe src="<?php echo $relativeUrl;?>uploads/termsAndConditions_pdf/<?php echo $result['file_name'];?>" width="100%" height="500px"></iframe>
                        <?php } else { ?>
                        <p>It seems the Administrator has not provided any Terms &amp; Conditions.</p>
                        <?php } ?>
                    </div>    
                </div>
            </div>   
        </div>
     </section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include('../employee/include/footer.php');?>
</body>
</html>
