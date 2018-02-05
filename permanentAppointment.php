<?php
$title = 'Permanent Appointment';
date_default_timezone_set('Asia/Kolkata');
$current_date = time(); 
include('include/header.php');
include_once 'EmployeeManager.php';
$employeeManager = new EmployeeManager();
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Permanent Appointment Letter</h1>
        <?php include_once('include/notificationBell.php'); ?>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <form role="form" id="" method="POST" action="AppointmentController.php">
                    <!-- <div class="box-header with-border">
                        <h3 class="box-title">.</h3>
                    </div> -->
                    <div class="box-body">
                        <div class="row">
                            <?php 
                                if(isset($_SESSION['permanent_error'])) {
                            ?>
                                <div class="col-md-12">
                                    <p class="alert alert-danger"><?php echo $_SESSION['permanent_error'];?></p>
                                </div>
                            <?php
                                unset($_SESSION['permanent_error']);  
                                }
                            ?>
                            <p class="col-md-12"><label>Note: &nbsp;<span class="mandatory"> * </span></label> &nbsp;fields are mandatory.</p>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Employee Name <span class="mandatory">*</span></label>
                                    <input class="form-control" id="name" placeholder="Enter Name" type="text" name="name" autocomplete="off" required autofocus>
                                    <ul class="suggesstion"></ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Employee Id</label>
                                    <input class="form-control" id="employee_id" type="text" name="employee_id" autocomplete="off" readonly="" required>
                                </div>
                            </div>
                            <div class="col-md-6 change-default-letter" style="display: none; margin-top: 10px;">
                                <div class="from-group">
                                    <p style="color:#0000FF;margin-bottom: 0;">[ You can now edit this default letter with your own words &amp; sentences. ]</p>
                                </div>
                            </div>
                            <div class="col-md-6 change-default-letter" style="display: none;">
                                <div class="from-group text-right">
                                    <div class="radio">
                                        <label style="margin-right: 20px;">
                                            <input name="logo" id="add_logo" value="addlogo" checked="" type="radio">
                                             Add Logo
                                        </label>
                                        <label>
                                            <input name="logo" id="remove_logo" value="removelogo" type="radio">
                                            Remove Logo
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="appointment_text" style="display: none;">
                                        <div id="company_logo" style="text-align: center">
                                             <?php 
                                             if($companyInfo['company_logo'] != '') { ?>
                                             <img src="<?php echo 'uploads/company_profile_images/'.$companyInfo['company_logo'];?>" alt="logo">
                                             <?php } else { ?>
                                             <img src="images/logo.png" alt="logo">
                                             <?php } ?> 
                                        </div><br>
                                        <h3 style="text-align: center; text-decoration: underline;">Letter of Appointment</h3><br>
                                        <p>Dear <span class="employee_name">xxxx</span>,<br>Welcome to <b>Tomato Inc.</b></p>
                                        <p>I am pleased to offer you employment in the position of “Junior Programmer” with
                                        <b>Tomato Inc.</b>. I am eager to have you as part of our team. I foresee your potential skills as
                                        a valuable contribution to our company and clients. Your appointment as “Junior
                                        Programmer” will commence on <?php echo date("d/m/Y",$current_date);?>.</p>

                                        <p>As “Junior Programmer”, you will be entitled to a monthly starting remuneration of Rs 18,000/- (Rupees Eighteen Thousands only), which indicates cost to company. Regular performance review will be conducted to assess your performance and suitability.</p>

                                        <p>You shall receive your payment on or before the 7th day of every month. Leave and other
                                        company policies are available in our EMS. A hard copy of company policies is also
                                        provided to you. These policies are reviewed and posted in our EMS from time to time by
                                        the management of <b>Tomato Inc.</b> for your benefit. You shall abide by the terms and
                                        conditions of the standing orders and the rules of the company as in force from time to
                                        time.</p>

                                        <p>Your signing this appointment letter confirms your acceptance of the terms and conditions and that you would be joining <b>Tomato Inc.</b> on the given date.</p>

                                        <p>I am looking forward to working with you.</p><br>
                                        <br>
                                        <p style="width: 50%; float: left;"><b>Appointment Accepted by:</b><br><br>
                                        <br><br>
                                        <b>Mr. <span class="employee_name">xxxx</span></b></p>
                                        <p style="text-align: right; width: 50%; float: right;"><b>Sincerely</b><br><br><br><br><b>Jay J. Das</b>,<br><b>Managing Director,</b> <b>Tomato Inc.</b> <br><b>Date:<?php echo date("d/m/Y",$current_date);?></b></p><br>
                                    </div>
                                    <textarea style="text-align: justify;text-justify: inter-word;display: none;" id="appointment_details" class="textarea_prob_appoint form-control" rows="5" name="appointment_details" placeholder="Place some text here">
                                        
                                    </textarea>
                                </div>
                            </div>
                            <div class="col-md-12 change-default-letter" style="display: none;">
                                <div class="form-group">
                                    <a class="btn btn-info preview-btn pull-left">Preview</a>
                                    <input type="submit" class="btn btn-sm btn-success pull-right" name="savePermanentAppointment" value="Generate Pdf">
                                    <input style="margin: 0 10px;" type="submit" class="btn btn-sm btn-warning pull-right" name="savePermanentAppointment" value="Print">
                                </div>
                            </div>
                        </div>
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
<?php include('include/footer.php');
?>
<script type="text/javascript">
    $( "#name" ).autocomplete({
        autoFocus: true,
        delay: 100,
        source: 'namelist.php',
        minLength:2,
        select: function(event,ui){
        var code = ui.item.id;
        var value = ui.item.value;
            if(code != '') {
                getIdFunction(code, value);
            }
        },
        // optional
        html: true, 
        // optional (if other layers overlap the autocomplete list)
        open: function(event, ui) {
        $(".ui-autocomplete").css("z-index", 1000);
        }
    });
    // check in input is empty 
    $('#name').keyup( function(event) {
        var input_value = $(this).val();
        if (input_value == "") {
            $('#employee_id').val('');
            $('.mce-tinymce').remove();
            $('textarea').html('');
            $('textarea').css('display','none');
            $('.change-default-letter').css('display','none');
                
        }
        if(event.keyCode == 13) {
          if($("#employee_id").val().length==0) {
              event.preventDefault();
              return false;
              alert('aa');
          }
        }
    });
    function getIdFunction(argument1, argument2) {
        $('#employee_id').val(argument1);

        // check appointment exist or not
        $.ajax({
            url: "AppointmentController.php",
            type: "post",
            cache: false,
            data: {"permanent_employee_id": argument1},
            success: function(result1) {
                //alert(result1);
                if(result1 == 0) {
                    $('.appointment_text').css('display','block');
                    $('.employee_name').html(argument2);
                    $('textarea').css('display','block');
                    $('textarea').html($('.appointment_text').html());
                    $('.appointment_text').css('display','none');
                    $('.change-default-letter').css('display','block');
                    appointmentDetails();
                }
                else {
                    swal('Alert','Permanenet appointment letter already generated.','warning');
                    $('textarea').css('display','block');
                    $('textarea').html(result1);
                    $('.change-default-letter').css('display','block');
                    appointmentDetails();
                }
            }
        });
    }
    // initialize editor
    function appointmentDetails(){
        tinymce.init({
            selector: "textarea",
            menubar: false,
            min_height: 200,
            content_style: "div {padding: 50px}",         
            plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste jbimages"
            ],          
        toolbar: "undo redo | bold italic underline | styleselect formatselect fontselect fontsizeselect |bullist numlist outdent indent | alignleft aligncenter alignright alignjustify | link image",   
        //relative_urls: false  
        // without images_upload_url set, Upload tab won't show up
            images_upload_url: 'tinymceUploadImage.php',

            //images_upload_base_path: '/uploads/letterLogo/',
            images_upload_credentials: true     
        });
    }
   //tinymce.init({ selector:'textarea' });
   // preview modal 
   $('.preview-btn').click(function() {
        $('.modal-body').html(tinyMCE.activeEditor.getContent());
        $('#myModal').modal('show');

        //$('#myModal').modal('hide');
   });
   // toggle company logo
   
   $('#add_logo').click(function() {
        //alert('hello');
        var frame = $("iframe").contents();
        frame.find("#company_logo").css('display','block');
   });
   $('#remove_logo').click(function() {
        var frame = $("iframe").contents();
        frame.find("#company_logo").css('display','none');
   });

   // print document 
    function printMe() {
        document.getElementById('appointment_details_ifr').contentWindow.print();
    }
</script>
<?php 
    if(isset($_SESSION['permanent_success'])) {
?>
<script type="text/javascript">
    swal('Congrats', 'Permanent Appointment Generated Successfully.', 'success');
</script>
<?php
    unset($_SESSION['permanent_success']);  
    }
?>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
     <!--  <button type="button" class="close" data-dismiss="modal">&times;</button> -->
      <div class="modal-body"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
</body>
</html>