<footer class="main-footer">
	<?php echo $footerMessage;?>
</footer>
</div>
<!-- /.wrapper -->
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="../bootstrap/js/bootstrap.min.js"></script>

<!-- daterangepicker -->
<script src="../plugins/moment/min/moment.min.js"></script>
<!-- datepicker -->
<script src="../plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- sweet alert -->
<script type="text/javascript" src="../plugins/sweetalert/sweetalert.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/app.min.js"></script>
<!-- jquery validation -->
<script src="../js/passwordStrength.js" type="text/javascript"></script>
<script src="../js/jquery.validate.js" type="text/javascript"></script>
<script src="../js/formValidate.js" type="text/javascript"></script>
<!--  dropify -->
<script src="../plugins/dropify/js/dropify.min.js" charset="utf-8"></script>
<!-- jQuery cookie plugin -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
<!-- end -->
<script type="text/javascript">
    // initialize dropify
	$('.dropify').dropify();
	//Date picker
    $('#datepicker_date_of_joining').datepicker({
      autoclose: true
    });
    $('#datepicker_date_of_birth').datepicker({
      autoclose: true
    });
    /*edit_employee_id*/
    $('#edit_employee_id').click(function() {
        $('#auto_generated_id').removeAttr('readonly').val('');
    });
</script>
<!-- DataTables -->
<script src="../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../plugins/datatables/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
     var table = $('#display_users_table');
    	table.DataTable({
        "lengthMenu": [
            [5, 10, 20, 50, 100, -1],
            [5, 10, 20, 50, 100, "All"] // change per page values here
        ]
    });
</script>
<script type="text/javascript">
  $(document).ready(function (){
    $("#changeSkin").change(function () {
        var skinColor = $(this).val();
        $("body").removeClass().addClass("hold-transition "+skinColor+" sidebar-mini");
        $.cookie('skinColor', skinColor);
    });
  });
</script>
<?php if(isset($_COOKIE['skinColor'])) { ?>
<script type="text/javascript">
      var cookieSkinColor = '<?php echo $_COOKIE['skinColor']; ?>';
     $("#changeSkin").val(cookieSkinColor);
</script>
<?php } ?>