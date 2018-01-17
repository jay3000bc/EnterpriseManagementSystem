<?php 
include('include/header.php');
if (isset($_GET['project_id'])) {
    include_once 'ClientManager.php';
    $project_id = trim(stripslashes($_GET['project_id']));
    $clientManager = new ClientManager();
    $projectDetails = $clientManager->getAProjectDetails($project_id);
    $clientDetails = $clientManager->getClientDetails($projectDetails['client_id']);
}
else {
    header('Location:viewClients.php');
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>View Project Details</h1>
        <?php include_once('include/notificationBell.php'); ?>
    </section>

    <!-- Main content -->
    <section class="content">
    <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <?php if($projectDetails != '' ) { ?>
                    <div class="box-header with-border">
                      <h3 class="box-title"><label>Client Name: </label> <?php echo $clientDetails['name'];?></h3>
                    </div>
                    <div class="box-body">
                        <div id="<?php echo $projectDetails['id'];?>" class="panel box box-solid box-primary">
                                <div class="box-header with-border">
                                    <h4 class="box-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse" aria-expanded="false" class="collapsed">
                                        <?php echo $projectDetails['title'];?>
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse" class="panel-collapse collapse in" aria-expanded="false">
                                    <div class="box-body">
                                        <?php echo $projectDetails['description'];?>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Start Date: </label> <?php echo $projectDetails['created_at'];?><br>
                                            <?php if($projectDetails['status'] == 1) { ?>
                                            <label>End Date: </label> <span class="ended_at_value<?php echo $projectDetails['id'];?>"><?php echo $projectDetails['ended_at'];?></span>
                                             <?php } else { ?>
                                            <label>End Date: </label> <span class="ended_at_value<?php echo $projectDetails['id']; ?>">On Going</span>
                                            <?php } ?>
                                        </div>
                                        <div class="col-md-6">
                                            <a data-delete_id="<?php echo $projectDetails['id'];?>" style="margin-left: 10px;" title="Delete" class="delete-btn btn btn-md btn-danger pull-right">DELETE</a>
                                            <input type="hidden" name="delete_client_id" value="<?php echo $projectDetails['id'];?>">
                                            <?php 
                                            if($projectDetails['status'] == 1) { ?>
                                            <input type="hidden" name="delete_client_id" value="<?php echo $projectDetails['client_id'];?>">
                                            <a data-id="<?php echo $projectDetails['status'];?>" class="complete-btn btn btn-md btn-success pull-right">COMPLETED
                                            </a>
                                            <input type="hidden" name="delete_client_id" value="<?php echo $projectDetails['id'];?>">
                                            <?php } else { ?>
                                            <input type="hidden" name="delete_client_id" value="<?php echo $projectDetails['client_id'];?>">
                                            <a data-id="<?php echo $projectDetails['status'];?>" class="complete-btn btn btn-md btn-warning pull-right">MARK AS COMPLETE
                                            </a>
                                            <input type="hidden" name="delete_client_id" value="<?php echo $projectDetails['id'];?>">
                                            <?php  } ?>
                                        </div>
                                    </div>
                                </div>
                            </div><br>
                        
                    </div>
                    <?php } else { ?>
                    <div class="box-header with-border">
                      <h3 class="box-title">No projects available.</h3>
                    </div>
                    <?php } ?>
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
// delete Client
$('.delete-btn').click(function() {
    var delete_project_div = $(this).data("delete_id");
    var input_element = $(this).next('input');
    var project_id = input_element.val();
    swal({
      title: "Are you sure?",
      text: "Your will not be able to recover the Project Details !!!",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      confirmButtonText: "Yes, delete it!",
      closeOnConfirm: false
    },
    function(){
        $.ajax({
            url: "ClientController.php",
            type: "post",
            cache: false,
            data: {"project_id": project_id},
            success: function(result) {
                if (result==1) {
                    $('#'+delete_project_div).remove();
                    $('.box-body').append('<h3 class="box-title">No projects available.</h3>');
                    swal("Deleted!", "Project has been deleted successfully.", "success"); 
                }
                else {
                    swal("Something Went Wrong!!!");
                }
            }
        });
    });
});

//active or deactive Client

$('.complete-btn').click(function() {
    var button = $(this);
    //alert(button.html());
    var project_status = $(this).data("id");
    var id = $(this).next('input').val();
    var client_id = $(this).prev('input').val();
    $.ajax({
            url: "ClientController.php",
            type: "post",
            cache: false,
            data: {"id": id, "project_status": project_status, "client_id": client_id},
            success: function(result) {
                if (result=='success') {
                    if(project_status == 1) {
                        button.html('MARK AS COMPLETE');
                        button.data('id', 0);
                        button.removeClass('btn-success');
                        button.addClass('btn-warning');
                        $('.ended_at_value'+id).html('On Going');
                    }
                    else {
                        button.html('COMPLETED');
                        button.data('id', 1);
                        button.removeClass('btn-warning');
                        button.addClass('btn-success');
                        button.addClass("disable_a_href");
                        button.removeClass('complete-btn');
                        $('.ended_at_value'+id).html($.datepicker.formatDate('dd/mm/yy', new Date()));
                    }
                }
                else {
                    swal("Something Went Wrong!!!");
                }
            }
        });
});
</script>
</body>
</html>
