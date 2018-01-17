<?php 
include('include/header.php');
include_once 'EmployeeManager.php';?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>View Employees</h1>
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
                        <a href="createEmployee.php" class="btn btn-primary pull-right"><i class="fa fa-plus" aria-hidden="true"></i> &nbsp;Create New Employee</a>
                    </div>
                    <div class="box-body">
                        <table id="display_employee_table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Employee Id</th>
                                <th>Name</th>
                                <th>Designation</th>
                                <th>Date of Joining</th>
                                <th>Current Address</th>
                                <th>Action</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Employee Id</th>
                                <th>Name</th>
                                <th>Designation</th>
                                <th>Date of Joining</th>
                                <th>Current Address</th>
                                <th>Action</th>
                                <th>Status</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            $employeeManager = new EmployeeManager();
                            $result = $employeeManager->listEmployees();
                            for($i=0; $i< $result; $i++) {
                             ?>   
                            <tr>
                                <td><?php echo $i+1;?></td>
                                <td><?php echo str_pad($employeeManager->employee_id[$i], 4, '0', STR_PAD_LEFT);?></td>
                                <td><?php echo $employeeManager->name[$i];?></td>
                                <td><?php echo $employeeManager->designation[$i];?></td>
                                <td><?php echo $employeeManager->date_of_joining[$i];?></td>
                                <td><?php echo $employeeManager->current_address[$i];?></td>
                                <td>
                                    <a title="View" href="viewEmployeeDetails.php?employee_id=<?php echo $employeeManager->employee_id[$i]; ?>" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>
                                    <a title="Edit" class="btn btn-sm btn-success" href="editEmployee.php?employee_id=<?php echo $employeeManager->employee_id[$i]; ?>"><i class="fa fa-pencil"></i></a>
                                    <a title="Delete" class="delete-btn btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a>
                                    <input type="hidden" name="delete_employee_id" value="<?php echo $employeeManager->employee_id[$i]; ?>">
                                </td>
                                <?php 
                                    if($employeeManager->status[$i] == 1) { ?>
                                <td data-id="<?php echo $employeeManager->status[$i]; ?>" class="active-btn btn btn-sm btn-success" style="width:58px;border-radius: 3px; padding: 5px 10px;">Active
                                 </td>
                                 <input type="hidden" name="delete_employee_id" value="<?php echo $employeeManager->id[$i]; ?>">
                                <?php } else { ?>
                                <td data-id="<?php echo $employeeManager->status[$i]; ?>" class="active-btn btn btn-sm btn-warning" style="width:58px;border-radius: 3px;padding: 5px 10px;">Inactive
                                 </td>
                                 <input type="hidden" name="delete_employee_id" value="<?php echo $employeeManager->id[$i]; ?>">
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
    if($_SESSION['successMsg'] == 'employeeAdded') {
?>
    <script type="text/javascript">
        swal('Congrats','Employee Created Successfully', 'success');

    </script>
<?php
    }
    if($_SESSION['successMsg'] == 'employeeEdited') {
?>
    <script type="text/javascript">
        swal('Congrats','Employee Edited Successfully', 'success');

    </script>
<?php
    }
unset($_SESSION['successMsg']);  
}
?>
<script type="text/javascript">
// delete employee
$('.delete-btn').click(function() {
    var employee_id_input = $(this).next('input');
    var deleteEmployee = employee_id_input.val();
    swal({
      title: "Are you sure?",
      text: "Your will not be able to recover the Employee!",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      confirmButtonText: "Yes, delete it!",
      closeOnConfirm: false
    },
    function(){
        $.ajax({
            url: "EmployeeController.php",
            type: "post",
            cache: false,
            data: {"deleteEmployee": deleteEmployee},
            success: function(result) {
                if (result==1) {
                    employee_id_input.parent().parent().remove();
                    swal("Deleted!", "Employee has been deleted successfully.", "success"); 
                }
                else {
                    swal("Something Went Wrong!!!");
                }
            }
        });
    });
});

//active or deactive employee

$('.active-btn').click(function() {
    var button = $(this);
    //alert(button.html());
    var status = $(this).data("id");
    var id = $(this).next('input').val();
    $.ajax({
            url: "EmployeeController.php",
            type: "post",
            cache: false,
            data: {"id": id, "status": status},
            success: function(result) {
                if (result=='success') {
                    if(status == 1) {
                        button.html('Inactive');
                        button.data('id', 0);
                        button.removeClass('btn-success');
                        button.addClass('btn-warning');
                    }
                    else {
                        button.html('Active');
                        button.data('id', 1);
                        button.removeClass('btn-warning');
                        button.addClass('btn-success');
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
        var table = $('#display_employee_table');
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