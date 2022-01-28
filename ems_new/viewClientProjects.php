<?php 
$title = 'Projects';
include('include/header.php');
if (isset($_GET['client_id'])) {
    include_once 'ClientManager.php';
    $client_id = trim(stripslashes($_GET['client_id']));
    $clientManager = new ClientManager();
    $total = $clientManager->getClientProjects($client_id);
    $clientDetails = $clientManager->getClientDetails($client_id);
}
else {
    header('Location:viewClients');
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
                    <div class="box-header with-border">
                      <h3 class="box-title"><label>Client Name: </label> <?php echo $clientDetails['name'];?></h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <?php if($total > 0) { ?>
                        <div class="box-group" id="accordion">
                        <p>Note: Click on project title to view description.</p>
                        <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                        <?php for ($i=0; $i < $total ; $i++) { ?>
                            <div id="<?php echo $i;?>" class="panel box box-solid box-primary">
                                <div class="box-header with-border">
                                    <h4 class="box-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $i;?>" aria-expanded="false" class="collapsed">
                                        <?php echo $clientManager->title[$i];?>
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse<?php echo $i;?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                    <div class="box-body">
                                    <?php echo $clientManager->description[$i];?>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Start Date: </label> <?php echo $clientManager->created_at[$i];?><br>
                                            <?php if($clientManager->status[$i] == 1) { ?>
                                            <label>End Date: </label> <span class="ended_at_value<?php echo $clientManager->project_id[$i]; ?>"><?php echo $clientManager->ended_at[$i];?></span>
                                            <?php } else { ?>
                                            <label>End Date: </label> <span class="ended_at_value<?php echo $clientManager->project_id[$i]; ?>">On Going</span>
                                            <?php } ?>
                                        </div>
                                        <div class="col-md-6">
                                            <a data-delete_id="<?php echo $i;?>" style="margin-left: 10px;" title="Delete" class="delete-btn btn btn-md btn-danger pull-right">DELETE</a>
                                            <input type="hidden" name="delete_client_id" value="<?php echo $clientManager->project_id[$i]; ?>">
                                            <?php 
                                            if($clientManager->status[$i] == 1) { ?>
                                            <a data-id="<?php echo $clientManager->status[$i]; ?>" class="complete-btn btn btn-md btn-success pull-right">COMPLETED
                                            </a>
                                            <input type="hidden" name="delete_client_id" value="<?php echo $clientManager->project_id[$i]; ?>">
                                            <?php } else { ?>
                                            <a data-id="<?php echo $clientManager->status[$i]; ?>" class="complete-btn btn btn-md btn-warning pull-right">MARK AS COMPLETE
                                            </a>
                                            <input type="hidden" name="delete_client_id" value="<?php echo $clientManager->project_id[$i]; ?>">
                                            <?php  } ?>
                                        </div>
                                    </div>
                                </div>
                            </div><br>
                            <?php } ?>
                        </div>
                        <?php } else { ?>
                        <p>No projects available.</p>
                        <?php } ?> 
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
<?php include('include/footer.php'); ?>

<script type="text/javascript">
// delete Client
$('.delete-btn').click(function() {
    var delete_project_div = $(this).data("delete_id");
    var input_element = $(this).next('input');
    var delete_project_by_project_id = input_element.val();
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
            data: {"delete_project_by_project_id": delete_project_by_project_id},
            success: function(result) {
                if (result==1) {
                    $('#'+delete_project_div).remove();
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
    var client_id = "<?php echo $clientDetails['client_id'];?>";
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