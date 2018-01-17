<?php 
include('include/header.php');
include_once 'EvaluateDaysManager.php';
$evaluateDaysManager = new EvaluateDaysManager();
$resultgetCutOffStatus = $evaluateDaysManager->getCutOffStatus();
$resultWeeklyDaySelected = $evaluateDaysManager->getWeeklyDaySelected();

for ($i=0; $i < $resultWeeklyDaySelected ; $i++) { 
    $day_name = $evaluateDaysManager->day_name[$i];
    if($day_name == 'Sun') {
        $value1 = 1;
    }
    if($day_name == 'Mon') {
        $value2 = 2;
    }
    if($day_name == 'Tue') {
        $value3 = 3;
    }
    if($day_name == 'Wed') {
        $value4 = 4;
    }
    if($day_name == 'Thu') {
        $value5 = 5;
    }
    if($day_name == 'Fri') {
        $value6 = 6;
    }
    if($day_name == 'Sat') {
        $value7 = 7;
    }
}
?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Employee Leave/ Holidays</h1>
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
                        <h3 class="box-title">Select Weekdays that are an holiday.</h3>
                    </div>
                    <div class="box-body">
                        <p>Click to select or deselect.</p>
                        <form role="form" id="manageHolidays" method="POST" action="EvaluateDaysController.php">
                            <div class="btn-group" data-toggle="buttons">
                                 <?php if(isset($value1)) { ?>
                                <label class="btn btn-md btn-background btn-sun active" onclick="toggleDays('SUNDAY')">
                                   <input type="checkbox" value="Sun" name="day" checked="checked" autocomplete="off">
                                    <span>SUNDAY</span>
                                </label>
                                <?php } else { ?> 
                                <label class="btn btn-md btn-background btn-sun" onclick="toggleDays('SUNDAY')">
                                   <input type="checkbox" value="Sun" name="day" autocomplete="off">
                                    <span>SUNDAY</span>
                                </label>
                                <?php } ?> 
                                <?php if(isset($value2)) { ?>
                                <label class="btn btn-md btn-background btn-mon active" onclick="toggleDays1('MONDAY')">
                                    <input type="checkbox" checked="checked" name="day" value="Mon" autocomplete="off"> MONDAY
                                </label>
                                <?php } else { ?>
                                    <label class="btn btn-md btn-background btn-mon" onclick="toggleDays1('MONDAY')">
                                    <input type="checkbox" name="day" value="Mon" autocomplete="off"> MONDAY
                                    </label>
                                <?php } ?> 
                                <?php if(isset($value3) ) { ?>
                                <label class="btn btn-md btn-background btn-tue active" onclick="toggleDays2('TUESDAY')">
                                    <input type="checkbox" name="day" checked="checked" value="Tue" autocomplete="off"> TUESDAY
                                </label>
                                <?php } else { ?>
                                <label class="btn btn-md btn-background btn-tue" onclick="toggleDays2('TUESDAY')">
                                    <input type="checkbox" name="day" value="Tue" autocomplete="off"> TUESDAY
                                </label>
                                <?php } ?>
                                <?php if(isset($value4)) { ?> 
                                <label class="btn btn-md btn-background btn-wed active" onclick="toggleDays3('WEDNESDAY')">
                                    <input type="checkbox" name="day" checked="checked" value="Wed" autocomplete="off"> WEDNESDAY
                                </label>
                                <?php } else { ?>
                                <label class="btn btn-md btn-background btn-wed" onclick="toggleDays3('WEDNESDAY')">
                                    <input type="checkbox" name="day" value="Wed" autocomplete="off"> WEDNESDAY
                                </label>
                                <?php } ?>
                                 <?php if(isset($value5)) { ?> 
                                <label class="btn btn-md btn-background btn-thu active" onclick="toggleDays4('THURSDAY')">
                                    <input type="checkbox" name="day" checked="checked" value="Thu" autocomplete="off"> THURSDAY
                                </label>
                                <?php } else { ?>
                                <label class="btn btn-md btn-background btn-thu" onclick="toggleDays4('THURSDAY')">
                                    <input type="checkbox" name="day" value="Thu" autocomplete="off"> THURSDAY
                                </label>
                                <?php } ?>
                                <?php if(isset($value6)) { ?> 
                                <label class="btn btn-md btn-background btn-fri active" onclick="toggleDays5('FRIDAY')">
                                    <input type="checkbox" name="day" checked="checked" value="Fri" autocomplete="off"> FRIDAY
                                </label>
                                <?php } else { ?>
                                <label class="btn btn-md btn-background btn-fri" onclick="toggleDays5('FRIDAY')">
                                    <input type="checkbox" name="day" value="Fri" autocomplete="off"> FRIDAY
                                </label>
                                <?php } ?>
                                <?php if(isset($value7)) { ?>
                                <label class="btn btn-md btn-background btn-sat active" onclick="toggleDays6('SATURDAY')">
                                    <input type="checkbox" name="day" checked value="Sat" autocomplete="off"> SATURDAY
                                </label>
                                <?php } else { ?>
                                <label class="btn btn-md btn-background btn-sat" onclick="toggleDays6('SATURDAY')">
                                    <input type="checkbox" name="day" value="Sat" autocomplete="off"> SATURDAY
                                </label>
                                <?php } ?>
                            </div><br><br>
                            <ul class="list-group selected-holidays-list" >
                                <label>Selected as weekly Holidays</label>
                                <?php if(isset($value1)) { ?>
                                <li style="border:none;" class="list-group-item SUNDAY">SUNDAY</li>
                                <?php } ?>
                                <?php if(isset($value2)) { ?>
                                <li style="border:none;" class="list-group-item MONDAY">MONDAY</li>
                                <?php } ?>
                                <?php if(isset($value3)) { ?>
                                <li style="border:none;" class="list-group-item TUESDAY">TUESDAY</li>
                                <?php } ?>
                                <?php if(isset($value4)) { ?>
                                <li style="border:none;" class="list-group-item WEDNESDAY">WEDNESDAY</li>
                                <?php } ?>
                                <?php if(isset($value5)) { ?>
                                <li style="border:none;" class="list-group-item THURSDAY">THURSDAY</li>
                                <?php } ?>
                                <?php if(isset($value6)) { ?>
                                <li style="border:none;" class="list-group-item FRIDAY">FRIDAY</li>
                                <?php } ?>
                                <?php if(isset($value7)) { ?>
                                <li style="border:none;" class="list-group-item SATURDAY">SATURDAY</li>
                                <?php } ?>
                            </ul>
                            <div class="form-group">
                                <label class="checkbox-inline">

                                    <?php if($resultgetCutOffStatus['status']== 0) { ?>
                                    <input id="status" type="checkbox" name="status" value="1"> 
                                    <?php } 
                                    if($resultgetCutOffStatus['status']== 1) { ?>
                                    <input id="status" type="checkbox" checked="ckecked" name="status" value="1"> <?php } ?>  Enable pay cut for absence
                                </label>
                            </div>
                            <p style="color: #ed1c24;">Note: Absense on each working days, will be deducted from basic bay. Formula[ Basic pay/ Number of calender days * Number of days absent ]</p>
                        </form> 
                    </div>
                    <div class="box-footer with-border text-center">
                        <button class="btn btn-primary">Save</button>
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
if(isset($_SESSION['changePasswordSuccessMsg'])) {
?>
<script type="text/javascript">
  alert('Password Changed Successfully');
</script>

<?php   
unset($_SESSION['changePasswordSuccessMsg']);
}
?> 
<?php if(isset($value1)) { ?>
<script type="text/javascript">
    var flip = 1;
    function toggleDays(arg) {
        $('.'+arg).toggle( flip++ % 2 === 0 );
    }
</script>
<?php }  else { ?>
<script type="text/javascript">
    var flip = 0;
    function toggleDays(arg) {
        var selectedValue = $(this ).find("span").html();
        if(flip == 1) {
            $('.selected-holidays-list').append('<li style="border:none;" class="list-group-item '+arg+'">'+arg+'</li>');
            flip++;
        }
        else {
            $('.'+arg).toggle( flip++ % 2 === 0 );
        }
    }
</script>
<?php } ?>
<?php if(isset($value2)) { ?>
<script type="text/javascript">
    var flip1 = 1;
    function toggleDays1(arg1) {
         $('.'+arg1).toggle( flip1++ % 2 === 0 );
    }
</script>
<?php }  else { ?>
<script type="text/javascript">
    var flip1 = 0;
    function toggleDays1(arg1) {
        //var selectedValue = $(this ).find("span").html();
        if(flip1 == 0) {
            $('.selected-holidays-list').append('<li style="border:none;" class="list-group-item '+arg1+'">'+arg1+'</li>');
            flip1++;
        }
        else {
            $('.'+arg1).toggle( flip1++ % 2 === 0 );
        }
    }
</script>
<?php } ?>

<?php if(isset($value3)) { ?>
<script type="text/javascript">
    var flip2 = 1;
    function toggleDays2(arg2) {
        $('.'+arg2).toggle( flip2++ % 2 === 0 );
    }
</script>
<?php }  else { ?>
<script type="text/javascript">
    var flip2 = 0;
    function toggleDays2(arg2) {
        //var selectedValue = $(this ).find("span").html();
        if(flip2 == 0) {
            $('.selected-holidays-list').append('<li style="border:none;" class="list-group-item '+arg2+'">'+arg2+'</li>');
            flip2++;
        }
        else {
            $('.'+arg2).toggle( flip2++ % 2 === 0 );
        }
    }
</script>
<?php } ?>

<?php if(isset($value4)) { ?>
<script type="text/javascript">
    var flip3 = 1;
    function toggleDays3(arg3) {
        $('.'+arg3).toggle( flip3++ % 2 === 0 );
    }
</script>
<?php }  else { ?>
<script type="text/javascript">
    var flip3 = 0;
    function toggleDays3(arg3) {
        //var selectedValue = $(this ).find("span").html();
        if(flip3 == 0) {
            $('.selected-holidays-list').append('<li style="border:none;" class="list-group-item '+arg3+'">'+arg3+'</li>');
            flip3++;
        }
        else {
            $('.'+arg3).toggle( flip3++ % 2 === 0 );
        }
    }
</script>
<?php } ?>

<?php if(isset($value5)) { ?>
<script type="text/javascript">
    var flip4 = 1;
    function toggleDays4(arg4) {
        $('.'+arg4).toggle( flip4++ % 2 === 0 );
    }
</script>
<?php }  else { ?>
<script type="text/javascript">
    var flip4 = 0;
    function toggleDays4(arg4) {
        //var selectedValue = $(this ).find("span").html();
        if(flip4 == 0) {
            $('.selected-holidays-list').append('<li style="border:none;" class="list-group-item '+arg4+'">'+arg4+'</li>');
            flip4++;
        }
        else {
            $('.'+arg4).toggle( flip4++ % 2 === 0 );
        }
    }
</script>
<?php } ?>

<?php if(isset($value6)) { ?>
<script type="text/javascript">
    var flip5 = 1;
    function toggleDays5(arg5) {
        $('.'+arg5).toggle( flip5++ % 2 === 0 );
    }
</script>
<?php }  else { ?>
<script type="text/javascript">
    var flip5 = 0;
    function toggleDays5(arg5) {
        //var selectedValue = $(this ).find("span").html();
        if(flip5 == 0) {
            $('.selected-holidays-list').append('<li style="border:none;" class="list-group-item '+arg5+'">'+arg5+'</li>');
            flip5++;
        }
        else {
            $('.'+arg5).toggle( flip5++ % 2 === 0 );
        }
    }
</script>
<?php } ?>

<?php if(isset($value7)) { ?>
<script type="text/javascript">
    var flip6 = 1;
    function toggleDays6(arg6) {
         $('.'+arg6).toggle( flip6++ % 2 === 0 );
    }
</script>    
<?php }  else { ?>
<script type="text/javascript">
    var flip6 = 0;
    function toggleDays6(arg6) {
        //var selectedValue = $(this ).find("span").html();
        if(flip6 == 0) {
            $('.selected-holidays-list').append('<li style="border:none;" class="list-group-item '+arg6+'">'+arg6+'</li>');
            flip6++;
        }
        else {
            $('.'+arg6).toggle( flip6++ % 2 === 0 );
        }
    }
</script> 
<?php } ?>
<script type="text/javascript">
var status = 0;
weekly_day_selected = [];
$('button').click(function() {
    weekly_day_selected.length = 0;
    if($("#status").is(':checked')) {
        status = 1;
        //alert('checked');
    }
    else {
        status = 0;
    }
    saveWeeklySeletedDays();
});
function saveWeeklySeletedDays() {
    $.each($("input[name='day']:checked"), function(){            
        weekly_day_selected.push($(this).val());
    });
    $.ajax({
       type: "POST",
       data: {"weekly_day_selected":weekly_day_selected, "status": status},
       url: "EvaluateDaysController.php",
       success: function(msg){
            swal('Congrats','Changes Saved Successfully', 'success');
        }
    });   
}
</script> 
</body>
</html>  