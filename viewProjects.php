<?php 
$title = 'View Projects';
include('include/header.php');
include_once 'ClientManager.php';
$clientManager = new ClientManager();
$result = $clientManager->listAllProjects();
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>View Projects</h1>
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
                        <table id="display_client_table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Project Title</th>
                                <th>Client Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            for($i=0; $i< $result; $i++) {
                             ?>   
                            <tr>
                                <td><?php echo $i+1;?></td>
                                <td><?php echo substr(strip_tags($clientManager->title[$i]),0,20); echo strlen(strip_tags($clientManager->title[$i])) > 20 ? "..." : ""?></td>
                                <td><?php echo $clientManager->name[$i];?></td>
                                <td><?php echo $clientManager->created_at[$i];?></td>
                                <td id="ended_at_value<?php echo $clientManager->project_id[$i]; ?>"><?php if($clientManager->ended_at[$i]) echo $clientManager->ended_at[$i]; else echo 'On Going'?></td>
                                <td>
                                    <a title="View" href="viewSingleProjectDetails?project_id=<?php echo $clientManager->project_id[$i]; ?>" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>

                                    <?php 
                                    if($clientManager->status[$i] == 1) { ?>
                                    <input type="hidden" name="client_id" value="<?php echo $clientManager->client_id[$i]; ?>">
                                    <a style="width:125px;" data-id="<?php echo $clientManager->status[$i]; ?>" class="complete-btn btn btn-sm btn-success">COMPLETED
                                    </a>
                                    <input type="hidden" name="delete_client_id" value="<?php echo $clientManager->project_id[$i]; ?>">
                                    <?php } else { ?>
                                    <input type="hidden" name="client_id" value="<?php echo $clientManager->client_id[$i]; ?>">
                                    <a style="width:125px;" data-id="<?php echo $clientManager->status[$i]; ?>" class="complete-btn btn btn-sm btn-warning">MARK AS COMPLETE
                                    </a>
                                    <input type="hidden" name="delete_client_id" value="<?php echo $clientManager->project_id[$i]; ?>">
                                    <?php  } ?>
                                    <a title="Delete" class="delete-btn btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a>
                                    <input type="hidden" name="delete_client_id" value="<?php echo $clientManager->project_id[$i]; ?>">
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                         </tbody>
                    </table>
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

if(isset($_SESSION['successMsg'])) {
    if($_SESSION['successMsg'] == 'clientAdded') {
?>
    <script type="text/javascript">
        swal('Congrats','Client Created Successfully', 'success');

    </script>
<?php
    }
    if($_SESSION['successMsg'] == 'clientEdited') {
?>
    <script type="text/javascript">
        swal('Congrats','Client Edited Successfully', 'success');

    </script>
<?php
    }
unset($_SESSION['successMsg']);  
}
?>
<script type="text/javascript">
// delete Client
$('.delete-btn').click(function() {
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
                    input_element.parent().parent().remove();
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
                        $('#ended_at_value'+id).html('On Going');
                    }
                    else {
                        button.html('COMPLETED');
                        button.data('id', 1);
                        button.removeClass('btn-warning');
                        button.addClass('btn-success');
                        button.addClass("disable_a_href");
                        button.removeClass('complete-btn');
                        $('#ended_at_value'+id).html($.datepicker.formatDate('dd/mm/yy', new Date()));
                    }
                }
                else {
                    swal("Something Went Wrong!!!");
                }
            }
        });
});
</script>
<script type="text/javascript">
    $(document).ready(function(){
        var table = $('#display_client_table');
        table.DataTable({
            responsive: true,
             initComplete: function () {
                this.api().columns([7]).every( function () {
                    var column = this;
                    var select = $('<select class="select_status"><option value="">All</option></select>')
                        .appendTo( $(column.footer()).empty() )
                        .on( 'change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );
     
                            column
                                .search( val ? '^'+val+'$' : '', true, false )
                                .draw();
                        } );
     
                    column.data().unique().sort().each( function ( d, j ) {
                        var val = $('<div/>').html(d).text();
                        select.append( '<option value="'+val+'">'+val+'</option>' )
                    } );
                } );
            },
            
            "lengthMenu": [
                [10, 20, 50, 100, -1],
                [10, 20, 50, 100, "All"] // change per page values here
            ]
            
        });
        
    });
</script>
</body>
</html>