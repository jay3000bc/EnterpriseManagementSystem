<?php 
$title = 'Clients';
include('include/header.php');
include_once 'ClientManager.php';
$clientManager = new ClientManager();
$result = $clientManager->listClients();
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>View Clients</h1>
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
                                <th>Client Id</th>
                                <th>Name</th>
                                <th>Projects</th>
                                <th>Country</th>
                                <th>Start Date</th>
                                <th>Action</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Client Id</th>
                                <th>Name</th>
                                <th>Projects</th>
                                <th>Country</th>
                                <th>Start Date</th>
                                <th>Action</th>
                                <th>Status</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            for($i=0; $i< $result; $i++) {
                             ?>   
                            <tr>
                                <td><?php echo $i+1;?></td>
                                <td><?php echo str_pad($clientManager->client_id[$i], 4, '0', STR_PAD_LEFT);?></td>
                                <td><?php echo $clientManager->name[$i];?></td>
                                <td><a title="View Projects" href="viewClientProjects.php?client_id=<?php echo $clientManager->client_id[$i]; ?>"><u>View Project(s)</u></a></td>
                                <td><?php echo $clientManager->country[$i];?></td>
                                <td><?php echo $clientManager->created_at[$i];?></td>
                                <td>
                                    <a title="View" href="viewClientDetails?client_id=<?php echo $clientManager->client_id[$i]; ?>" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>

                                    <a title="Edit" class="btn btn-sm btn-success" href="editClient?client_id=<?php echo $clientManager->client_id[$i]; ?>"><i class="fa fa-pencil"></i></a>
                                    <input type="hidden" name="name" value="<?php echo $clientManager->name[$i]; ?>">
                                    <a title="Delete" class="delete-btn btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a>
                                    <input type="hidden" name="delete_client_id" value="<?php echo $clientManager->client_id[$i]; ?>">
                                </td>
                                <?php 
                                    if($clientManager->status[$i] == 1) { ?>
                                <th style="color:#ff0000">Inactive</th>
                                <?php } else { ?>
                                <th style="color:#008000">Active</th>
                                <?php  } ?>
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
    var name = $(this).prev('input').val();
    var client_id = input_element.val();
    swal({
      title: "Are you sure?",
      text: "You want to delete the Client <b>"+name+"</b>. All projects associated with this client will also be deleted.",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      confirmButtonText: "Yes, delete it!",
      closeOnConfirm: false,
      html: true
    },
    function(){
        $.ajax({
            url: "ClientController.php",
            type: "post",
            cache: false,
            data: {"client_id": client_id},
            success: function(result) {
                if (result==1) {
                    input_element.parent().parent().remove();
                    swal("Deleted!", "Client and its corresponding projects has been deleted successfully.", "success"); 
                }
                else {
                    swal("Something Went Wrong!!!");
                }
            }
        });
    });
});

</script>

<!-- Datatable -->
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