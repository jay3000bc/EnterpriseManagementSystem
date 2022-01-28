<?php 
$title = 'Permanent Appointment';
include('../employee/include/header.php');
include_once '../AppointmentManager.php';
$appointmentManager = new AppointmentManager();
$result = $appointmentManager->getPermanentAppointment($employee_id);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Permanent Appointment Letter
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Employee</li>
        <li class="active"><a href="permanentAppointment">Permanent Appointment Letter</a></li>
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
                        <?php if($result !='') {?>
                        <p>This is your Permanent Appointment Letter.<br>
                        Now you can download or print the same.</p>
                        <iframe src="<?php echo $absoluteUrl;?>uploads/appointment_pdf/permanent/<?php echo $result['pdf_name'];?>" width="100%" height="500px"></iframe>
                        <?php } else { ?>
                        <p>It seems the Administrator has not provided any Permanent Appointment Letter</p>
                        <?php } ?>
                    </div>    
                </div>
            </div>   
        </div>
     </section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include('../employee/include/footer.php'); ?>
</body>
</html>
