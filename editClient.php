<?php 
$title = 'Edit Client';
include('include/header.php');
date_default_timezone_set('Asia/Kolkata');
$date = date('ymdGis');
include_once 'LoaderManager.php';
$loaderManager = new LoaderManager();
$manageIdStatus = $loaderManager->manageIdStatus();
include_once 'ClientManager.php';
$clientManager = new ClientManager();
$result = $clientManager->listClients();
$clientIdType = $clientManager->getClientIdType();
if (isset($_GET['client_id'])) {
    $client_id = trim(stripslashes($_GET['client_id']));
    $clientDetails = $clientManager->getClientDetails($client_id);
    $total = $clientManager->getClientProjects($client_id);
}
else {
    header('Location:viewClients');
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Edit Client</h1>
        <?php include_once('include/notificationBell.php'); ?>
    </section>

    <!-- Main content -->
    <section class="content">
    <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    
                    <form role="form" id="createClientForm" method="POST" action="ClientController.php" enctype="multipart/form-data">
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
                                <p class="col-md-12"><label>Note: &nbsp;<span class="mandatory"> * </span></label> &nbsp;fields are mandatory.</p>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name <span class="mandatory">*</span></label>
                                        <input value="<?php echo $clientDetails['name']; ?>" class="form-control" id="name" placeholder="Enter Client Name" type="text" name="name" autocomplete="off" required autofocus>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email <span class="mandatory">*</span></label>
                                        <input value="<?php echo $clientDetails['email']; ?>" name="email" class="form-control remove-space check-dublicate" id="email" placeholder="Enter Client Email Address" type="email" autocomplete="off" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone_no">Phone No. <span class="mandatory">*</span></label>
                                        <input value="<?php echo $clientDetails['phone_no']; ?>" name="phone_no" class="form-control" id="phone_no" placeholder="Enter Client Phone Number" type="text" autocomplete="off" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="photo">Photo</label>
                                        <input type="file" data-allowed-file-extensions="png jpg jpeg" name="photo" class="dropify" data-default-file="<?php echo 'uploads/client_image/'.$clientDetails['photo'];?>" data-height="100" style="height: 100% !important;">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="auto_generated_id">Client Id <span class="mandatory">*</span></label>
                                        <?php if($manageIdStatus['client_id'] == 1) {?>
                                        <input name="client_id" value="<?php echo $clientDetails['client_id']; ?>" class="form-control" id="auto_generated_id" placeholder="Enter Client Id" type="text" autocomplete="off" readonly="" required>
                                        <?php } elseif($manageIdStatus['client_id'] == 2) {?>
                                        <input value="<?php echo $clientDetails['client_id']; ?> name="client_id" class="form-control" id="auto_generated_id" placeholder="Enter Client Id" type="text" autocomplete="off" required>
                                        <?php } else {?>
                                        <input name="client_id" class="form-control" id="auto_generated_id" placeholder="Choose type of client Id by clicking the link above" type="text" autocomplete="off" readonly="" required>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="currentAddress">Address <span class="mandatory">*</span></label>
                                        <input value="<?php echo $clientDetails['address']; ?>" name="address" class="form-control" id="currentAddress" placeholder="Enter Client Address" type="text" autocomplete="off" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="country">Country <span class="mandatory">*</span></label>
                                        <select name="country" class="bfh-countries form-control" data-country="<?php echo $clientDetails['country']; ?>" required>
                                        </select>
                                    </div>
                                    <div id="hide_div_state">
                                        <div class="form-group">
                                            <label for="name">State <span class="mandatory">*</span></label>
                                            <select id="state" class="form-control" name="state" required>   
                                                <?php for ($i=0; $i < $totalStates ; $i++) { ?>
                                                <option value="<?php echo $adminManager->state_name[$i]; ?>" <?php if ($clientDetails['state']== $i+1) { echo "selected"; } ?>><?php echo $adminManager->state_name[$i]; ?> (<?php echo $adminManager->state_gst_code[$i]; ?>)</option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">GSTIN </label>
                                            <input class="form-control" id="gstin" value="<?php echo $clientDetails['gstin']; ?>" placeholder="Enter Client GSTIN" type="text" name="gstin" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php 
                            if($total > 0) {
                                for ($i=0; $i < $total ; $i++) { ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="projectTitle">Project Title <span class="mandatory">*</span></label>
                                            <input value="<?php echo $clientManager->title[$i];?>" name="project_title[]" class="form-control project_title_input" id="projectTitle" placeholder="Enter Project Title" type="text" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="projectDescription">Project Description <span class="mandatory">*</span></label>
                                            <textarea class="form-control project_description_textarea" name="project_description[]" placeholder="Write about project..." rows="5" required><?php echo $clientManager->description[$i];?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="project_id[]" value="<?php echo $clientManager->project_id[$i];?>">
                                <?php } 
                            } else { ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="projectTitle">Project Title <span class="mandatory">*</span></label>
                                            <input name="project_title_clone[]" class="form-control project_title_input" id="projectTitle" placeholder="Enter Project Title" type="text" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="projectDescription">Project Description <span class="mandatory">*</span></label>
                                            <textarea class="form-control project_description_textarea" name="project_description_clone[]" placeholder="Write about project..." rows="5" required></textarea>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="row clone-div">
                                
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <input type="hidden" name="oldPhoto" value="<?php echo $clientDetails['photo'];?>">
                        <div class="box-footer">
                            <a id="add-more" class="btn btn-success">Add More Projects</a>
                            <?php if($manageIdStatus['client_id'] == 2) {?>
                                <a id="manageId" class="btn btn-primary pull-right">Update</a>
                            <?php } else {?>
                            <input type="submit" class="btn btn-primary pull-right" value="Update" name="editClientDetails">
                            <?php }?>
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
    //toggle div state and GST
     if($('#country').val() == 'India') {
        $('#hide_div_state').css('display','block');
     }
     $('#country').change( function() {
        if($(this).val() == 'India') {
            $('#hide_div_state').css('display','block');
         } else {
            $('#hide_div_state').css('display','none');
         }
     });
    // add more projects
    var div_id =1;
    $('#add-more').click(function() {
        $('.clone-div').append('<div data-id="'+div_id+'"><div class="col-md-12"><div class="form-group"><label for="projectTitle'+div_id+'">Project Title <span class="mandatory">*</span></label><input name="project_title_clone[]" class="form-control project_title_input" id="projectTitle'+div_id+'" placeholder="Enter Project Title" type="text" autocomplete="off" required></div></div><div class="col-md-12"><div class="form-group"><label for="projectDescription'+div_id+'">Project Description <span class="mandatory">*</span></label><textarea class="form-control project_description_textarea" id="projectDescription'+div_id+'" name="project_description_clone[]" placeholder="Write about project..." rows="5" required></textarea></div></div><div class="col-md-12"><a class="remove-clone-div btn btn-warning" onclick="removeCloneDiv('+div_id+');">Remove</a><br></div></div>');
        div_id++;
    });
    function removeCloneDiv(div_id) {
        $('[data-id=' + div_id + ']').remove();
    }
    // check dublicate entry for client Id
    $('#auto_generated_id').keyup( function() {
        var check_employee_id = $(this).val();
        $.ajax({
            url: "EmployeeController.php",
            type: "post",
            cache: false,
            data: {"check_employee_id": check_employee_id},
            success: function(result){
                if(result==1) {
                    $('#auto_generated_id').val('');
                    $('#auto_generated_id').html('');
                    swal("Oops!!", "Employee Id already exists. Please try another one.", "error");

                }
                
            }
        });
    });

    // fade error message div
    $( ".clear-error-msg" ).click(function() {
        $( ".error-message" ).fadeOut( "slow" );
    });
    // trim space
    $('.remove-space').each(function() {
        $(this).keyup(function() {
            var field = $(this);
            var str = $(this).val();
            $(this).val($.trim(str))

        });
    });
    // check dublicate entry
    $('.check-dublicate').each(function() {
        $(this).keyup(function() {
            var field = $(this);
            var str = $(this).val();
            $(this).val($.trim(str));
            var field_name = $(this).attr('name');
            var check_already_exist_client = $(this).val();
            var oldValue = '<?php echo $clientDetails['email'];?>';
            if(oldValue != check_already_exist_client) {
                $.ajax({
                    url: "ClientController.php",
                    type: "post",
                    cache: false,
                    data: {"check_already_exist_client": check_already_exist_client, "field_name": field_name},
                    success: function(result){
                        if(result==1) {
                            field.val('');
                            field.focus();
                            swal("oops", "Given "+field_name+" already exist.Please try another.", "error"); 

                        }
                        
                    }
                });
            }    

        });
    });
</script>
<?php
if(isset($_SESSION['employeeIdTypeSelected'])) {
?>
<script type="text/javascript">
   swal('Congrats', 'Employee Id Type Choosen Successfully.', 'success');
</script>

<?php   
unset($_SESSION['employeeIdTypeSelected']);
}
?>
</body>
</html>
