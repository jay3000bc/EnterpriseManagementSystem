<?php 
$title = 'Create Client';
include('include/header.php');
date_default_timezone_set('Asia/Kolkata');
$date = date('ymdGis');
include_once 'LoaderManager.php';
$loaderManager = new LoaderManager();
$manageIdStatus = $loaderManager->manageIdStatus();
include_once 'ClientManager.php';
$clientManager = new ClientManager();
$result = $clientManager->listClients();
if($manageIdStatus['employee_id'] ==1) {
    $auto_generated_id = $clientManager->getAutoIncrimentID();
    $clientIdDetails = $clientManager->getClientIdDetails();
    $auto_id = $clientIdDetails['prefix'].str_pad($auto_generated_id['AUTO_INCREMENT'], $clientIdDetails['digits'], '0', STR_PAD_LEFT);
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Create Client</h1>
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
                        <input type="hidden" name="page_name" value="<?php echo $_SERVER['PHP_SELF'];?>">
                        <div class="box-body">
                            <?php if($manageIdStatus['client_id'] == 0) {?>
                            <div class="row">
                                <div class="col-md-12">
                                    
                                <p style="font-size: 16px; background: yellow; border: 2px solid red; display: inline-block; padding: 5px; width:100%;">Before you start creating your clients, you will have to set the Client Id type. <br /> You can set the Client Id type by going to Settings > Manage Client Id, or by<a href="manageClientId.php"> Clicking Here</a></p>
                    
                                </div>
                            </div>
                            <?php } ?>
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
                                        <input value="<?php if(isset($_SESSION['session_client_name'])) echo htmlspecialchars($_SESSION['session_client_name']); unset($_SESSION['session_client_name']);?>" class="form-control" id="name" placeholder="Enter Client Name" type="text" name="name" autocomplete="off" required autofocus>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email <span class="mandatory">*</span></label>
                                        <input value="<?php if(isset($_SESSION['session_client_email'])) echo htmlspecialchars($_SESSION['session_client_email']); unset($_SESSION['session_client_email']);?>" name="email" class="form-control remove-space" id="email" placeholder="Enter Client Email Address" type="email" autocomplete="off" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone_no">Phone No. <span class="mandatory">*</span></label>
                                        <input value="<?php if(isset($_SESSION['session_client_phone_no'])) echo htmlspecialchars($_SESSION['session_client_phone_no']); unset($_SESSION['session_client_phone_no']);?>" name="phone_no" class="form-control" id="phone_no" placeholder="Enter Client Phone Number" type="text" autocomplete="off" required>
                                    </div>
                                    
                                    
                                    <div class="form-group">
                                        <label for="photo">Photo</label>
                                        <span style="color:#0000FF">[ Please upload a passport size photo of only JPG, GIF, PNG format and maximum size of 500 kb. For better resolution use 160 x 160 px image. ]</span>
                                        <input type="file" data-allowed-file-extensions="png jpg jpeg" data-default-file="<?php if(isset($_SESSION['session_client_photo_name'])) { echo 'uploads/'.$_SESSION['session_client_photo_name']; unset($_SESSION['session_client_photo_name']); } else { echo 'uploads/defaultuser.png'; } ?>" name="photo" class="dropify" data-height="100" style="height: 100% !important;">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="auto_generated_id">Client Id <span class="mandatory">*</span></label>
                                        <?php if($manageIdStatus['client_id'] == 1) {?>
                                        <input name="client_id" value="<?php echo $auto_id;?>" class="form-control" id="auto_generated_id" placeholder="Enter Client Id" type="text" autocomplete="off" readonly="" required>
                                        <?php } elseif($manageIdStatus['client_id'] == 2) {?>
                                        <input value="<?php if(isset($_SESSION['session_client_client_id'])) echo htmlspecialchars($_SESSION['session_client_client_id']); unset($_SESSION['session_client_client_id']);?>" name="client_id" class="form-control" id="auto_generated_id" placeholder="Enter Client Id" type="text" autocomplete="off" required>
                                        <?php } else {?>
                                        <input name="client_id" class="form-control" id="auto_generated_id" placeholder="Choose type of client Id by clicking the link above" type="text" autocomplete="off" readonly="" required>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="currentAddress">Address <span class="mandatory">*</span></label>
                                        <input value="<?php if(isset($_SESSION['session_client_client_address'])) echo htmlspecialchars($_SESSION['session_client_client_address']); unset($_SESSION['session_client_client_address']);?>" name="address" class="form-control" id="currentAddress" placeholder="Enter Client Address" type="text" autocomplete="off" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="country">Country <span class="mandatory">*</span></label>
                                        <select value="<?php if(isset($_SESSION['session_client_country'])) echo htmlspecialchars($_SESSION['session_client_country']); unset($_SESSION['session_client_country']);?>" id="country" name="country" class="bfh-countries form-control" data-country="India" required></select>
                                    </div>
                                    <div id="hide_div_state">
                                        <div class="form-group">
                                            <label for="name">State <span class="mandatory">*</span></label>
                                            <select id="state" class="form-control" name="state" required>   
                                                <option value="">Select State</option>
                                                <?php for ($i=0; $i < $totalStates ; $i++) { ?>
                                                <option value="<?php echo $adminManager->state_id[$i]; ?>" <?php if ($companyInfo['state'] == $i+1) { echo "selected"; } ?>><?php echo $adminManager->state_name[$i]; ?> (<?php echo $adminManager->state_gst_code[$i]; ?>)</option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">GSTIN </label>
                                            <input value="<?php if(isset($_SESSION['session_client_gstin'])) echo htmlspecialchars($_SESSION['session_client_gstin']); unset($_SESSION['session_client_gstin']);?>" class="form-control" id="gstin" placeholder="Enter Client GSTIN" type="text" name="gstin" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group" id="foreign_state_div" style="display: none;">
                                        <label for="name">State <span class="mandatory">*</span></label>
                                        <input value="<?php if(isset($_SESSION['session_state'])) echo htmlspecialchars($_SESSION['session_state']); unset($_SESSION['session_gstin']);?>" class="form-control" id="foreign_state" placeholder="Enter Client State" type="text" name="state" autocomplete="off" disabled>
                                    </div>
                                </div>
                            </div>
                            <?php
                            if(isset($_SESSION['session_no_of_project'])) {
                                for ($i=0; $i < $_SESSION['session_no_of_project'] ; $i++) { 
                                    $session_key_project_title = 'session_client_project_title_'.$i;
                                    $session_key_project_desc = 'session_client_project_desc_'.$i; ?> 
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="projectTitle">Project Title <span class="mandatory">*</span></label>
                                                <input value="<?php echo $_SESSION['session_key_project_title']?>" name="project_title[]" class="form-control project_title_input" id="projectTitle" placeholder="Enter Project Title" type="text" autocomplete="off" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="projectDescription">Project Description <span class="mandatory">*</span></label>
                                                <textarea class="form-control project_description_textarea" name="project_description[]" placeholder="Write about project..." rows="5" required><?php echo $_SESSION['session_key_project_desc']?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    
                            <?php    
                                unset($_SESSION['session_key_project_title']); 
                                unset($_SESSION['session_key_project_desc']);
                                    }
                                unset($_SESSION['session_no_of_project']);    
                            }

                                ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="projectTitle">Project Title <span class="mandatory">*</span></label>
                                        <input name="project_title[]" class="form-control project_title_input" id="projectTitle" placeholder="Enter Project Title" type="text" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="projectDescription">Project Description <span class="mandatory">*</span></label>
                                        <textarea class="form-control project_description_textarea" name="project_description[]" placeholder="Write about project..." rows="5" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row clone-div">
                                
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <div class="box-footer">
                            <a id="add-more" class="btn btn-success">Add More Projects</a>
                            <?php if($manageIdStatus['client_id'] == 0) {?>
                                <a id="manageId" class="btn btn-primary pull-right">Submit</a>
                            <?php } else {?>
                            <input type="submit" class="btn btn-primary pull-right" value="Submit" name="saveClientDetails">
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
        $('#foreign_state_div').css('display','none');
     }
     $('#country').change( function() {
        if($(this).val() == 'India') {
            $('#foreign_state_div').css('display','none');
            $('#foreign_state').attr('disabled', 'disabled');
            $('#state').removeAttr('disabled');
            $('#gstin').removeAttr('disabled');
            $('#hide_div_state').css('display','block');

         } else {
            $('#foreign_state_div').css('display','block');
            $('#foreign_state').removeAttr('disabled');
            $('#state').attr('disabled', 'disabled');
            $('#gstin').attr('disabled', 'disabled');
            $('#hide_div_state').css('display','none');
         }
     });
    // Add more projects 
    var div_id =1;
    $('#add-more').click(function() {
        $('.clone-div').append('<div data-id="'+div_id+'"><div class="col-md-12"><div class="form-group"><label for="projectTitle'+div_id+'">Project Title <span class="mandatory">*</span></label><input name="project_title[]" class="form-control project_title_input" id="projectTitle'+div_id+'" placeholder="Enter Project Title" type="text" autocomplete="off" required></div></div><div class="col-md-12"><div class="form-group"><label for="projectDescription'+div_id+'">Project Description <span class="mandatory">*</span></label><textarea class="form-control project_description_textarea" id="projectDescription'+div_id+'" name="project_description[]" placeholder="Write about project..." rows="5" required></textarea></div></div><div class="col-md-12"><a class="remove-clone-div btn btn-warning" onclick="removeCloneDiv('+div_id+');">Remove</a><br></div></div>');
        div_id++;
    });
    function removeCloneDiv(div_id) {
        $('[data-id=' + div_id + ']').remove();
    }
    // check dublicate entry for manual entry epmloyee Id 
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
    // trim space in form controls
    $('.remove-space').each(function() {
        $(this).keyup(function() {
            var field = $(this);
            var str = $(this).val();
            $(this).val($.trim(str))

        });
    });
    // check dublicate entry for email
    $('.check-dublicate').each(function() {
        $(this).keyup(function() {
            var field = $(this);
            var str = $(this).val();
            $(this).val($.trim(str));
            var field_name = $(this).attr('name');
            var check_already_exist_client = $(this).val();
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
