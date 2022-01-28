<?php
$title = 'Client Details'; 
include('include/header.php');
if (isset($_GET['client_id'])) {
    include_once 'ClientManager.php';
    $client_id = trim(stripslashes($_GET['client_id']));
    $clientManager = new ClientManager();
    $result = $clientManager->getClientDetails($client_id);
}
else {
    header('Location:viewClients');
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Client Details</h1>
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
                            <div><label>Client Id: </label> <?php echo str_pad($result['client_id'], 4, '0', STR_PAD_LEFT);?></div>
                            <div><label>Name: </label> <?php echo $result['name'];?></div>
                            <div><label>Email: </label> <?php echo $result['email'];?></div>
                            <div><label>Phone No.: </label> <?php echo $result['phone_no'];?></div>
                            <div><label>Address: </label> <?php echo $result['address'];?></div>
                            <?php if( !is_numeric($result['state'])) { ?>
                            <div><label>State: </label> <?php echo $result['state'];?> </div>
                            <?php } ?>
                            <div><label>Country: </label> <?php echo $result['country'];?></div>
                            <div><label>Created At: </label> <?php echo $result['created_at'];?></div>
                        </div>
                        <div class="col-md-2">
                            <img width="100" height="100" src="uploads/client_image/<?php echo $result['photo']; ?>">
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