<?php
$title = 'Experience Certificate';
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
        <h1>Experience Certificate</h1>
         <?php include_once('include/notificationBell.php'); ?>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <form role="form" id="payrollForm" method="POST" action="AppointmentController.php">
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
                            </div><br>
                            <div class="col-md-6 change-default-letter" style="display: none; margin-top: 10px;">
                                <div class="from-group">
                                    <p style="color:#0000FF; margin-bottom: 0;">[ You can now edit this default letter with your own words &amp; sentences. ]</p>
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
                                        <div id="company_logo" style="text-align: center" >
                                             <?php if($companyInfo['company_logo'] != '') { ?>
                                             <img  src="<?php echo 'uploads/company_profile_images/'.$companyInfo['company_logo'];?>" alt="logo">
                                             <?php } else { ?>
                                             <img  src="images/logo.png" alt="logo">
                                             <?php } ?> 
                                        </div><br>
                                        <p><b>Date: <?php echo date("d/m/Y",$current_date);?></b></p>
                                        <h3 style="text-align: center; text-decoration: underline;">WORK EXPERIENCE CERTIFICATE</h3><br>

                                        <p>This is to inform whomsoever it may concern and certify that <b><span class="employee_name"></span></b> was a full-time employee as a Web Developer of <b>Tomato Inc.</b> from 01/08/2011 to xx/xx/xxxx as per the personnel files and company’s employment record.</p>

                                        <p>During his employment, we found <b><span class="employee_name"></span></b> to be professional, knowledgeable and result oriented with theoretical and practical understanding of work requirements. He has successfully completed many web and mobile applications</p>

                                        <p>He has a friendly, outgoing personality, very good sense of humour and works well as an individual or member of a team as required by the management</p>

                                        <p>Overall, <b><span class="employee_name"></span></b> performed his duties and responsibilities cheerfully with attention to detail at all times. With  his enthusiasm to work, learn and progress. I am certain that he would make a great employee to any enterprise.</p>

                                        <p>Please feel free to contact us if you have specific questions regarding his employment.</p>

                                        <p>On behalf of the company, I take this opportunity to wish <span class="employee_name"></span> all the very best in his future career endeavours.</p>
                                        <p><br></p>
                                        <p style="">
                                            <b>Jay J. Das</b>,<br><br><br><br><b>Managing Director,</b> <b>Tomato Inc.</b> <br><b>Date: <?php echo date("d/m/Y",$current_date);?></b></p><br>
                                    </div>
                                    <textarea style="text-align: justify;text-justify: inter-word;display: none;" id="appointment_details" class="textarea_prob_appoint form-control" rows="5" name="experience_details" placeholder="Place some text here">
                                        
                                    </textarea>
                                </div>
                            </div>
                            <div class="col-md-12 change-default-letter" style="display: none;">
                                <div class="form-group">
                                    <a class="btn btn-info preview-btn pull-left">Preview</a>
                                    
                                    <input type="submit" class="btn btn-sm btn-success pull-right" name="saveExperienceCertificate" value="Generate Pdf">
                                    <input style="margin: 0 10px;" type="submit" class="btn btn-sm btn-warning pull-right" name="saveExperienceCertificate" value="Print">
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
    $('#name').keyup( function() {
        var input_value = $(this).val();
        if (input_value == "") {
            $('#employee_id').val('');
            $('.mce-tinymce').remove();
            $('textarea').html('');
            $('textarea').css('display','none');
            $('.change-default-letter').css('display','none');
                
        }
     });  
    // if already generated document
    function getIdFunction(argument1, argument2) {
        $('#employee_id').val(argument1);
        // check appointment exist or not
        $.ajax({
            url: "AppointmentController.php",
            type: "post",
            cache: false,
            data: {"experience_employee_id": argument1},
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
                    swal('Alert','Experience Certificate already generated.','warning');
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
    if(isset($_SESSION['experience_certificate_success'])) {
?>
<script type="text/javascript">
    swal('Congrats', 'Experience Certificate Generated Successfully.', 'success');
</script>
<?php
    unset($_SESSION['experience_certificate_success']);  
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