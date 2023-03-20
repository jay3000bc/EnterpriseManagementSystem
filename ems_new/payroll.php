<?php 
$title = 'Payroll';
include('include/header.php');
date_default_timezone_set('Asia/Kolkata');
include_once 'EmployeeManager.php';
$employeeManager = new EmployeeManager();
include_once 'EvaluateDaysManager.php';
$evaluateDaysManager = new EvaluateDaysManager();
$month = date('m', strtotime("-1 month"));
$year = date('Y', strtotime("-1 month"));
$available_calender_days = $evaluateDaysManager->calculateAvailableCalenderDays($month, $year);
$resultgetCutOffStatus = $evaluateDaysManager->getCutOffStatus();
$resultWeeklyDaySelected = $evaluateDaysManager->getWeeklyDaySelected();
for ($i=0; $i < $resultWeeklyDaySelected ; $i++) { 
    $day_name = $evaluateDaysManager->day_name[$i];
    $count_days = $evaluateDaysManager->count_days($available_calender_days, $month , $year, $day_name);
    $count_days_array[] = $count_days;
    
}
$weekly_holidays = array_sum($count_days_array);
$working_days = $available_calender_days - $weekly_holidays;
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Payroll</h1>
        <?php include_once('include/notificationBell.php'); ?>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <form role="form" id="payrollForm" method="POST" action="PayrollController.php">
                    <!-- <div class="box-header with-border">
                        <h3 class="box-title">.</h3>
                    </div> -->
                        <div class="box-body">
                            <div class="row">
                                <?php 
                                    if(isset($_SESSION['payroll_error'])) {
                                ?>
                                    <div class="col-md-12 error-message">
                                        <p class="alert alert-danger"><?php echo $_SESSION['payroll_error'];?><span style="color:#fff;" class="clear-error-msg close">&times;</span></p>
                                    </div>
                                <?php
                                    unset($_SESSION['payroll_error']);  
                                    }
                                ?>
                                <p class="col-md-12"><label>Note: &nbsp;<span class="mandatory"> * </span></label> &nbsp;fields are mandatory.</p>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Employee Name <span class="mandatory">*</span></label>
                                        <input class="form-control" id="name" placeholder="Enter Name" value="<?php if(isset($_SESSION['session_payroll_name'])) echo htmlspecialchars($_SESSION['session_payroll_name']); unset($_SESSION['session_payroll_name']); ?>" type="text" name="name" autocomplete="off" required autofocus>
                                        <ul class="suggesstion"></ul>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Employee Id</label>
                                        <input class="form-control" value="<?php if(isset($_SESSION['session_payroll_employee_id'])) echo htmlspecialchars($_SESSION['session_payroll_employee_id']); ?>"  id="employee_id" type="text" name="employee_id" autocomplete="off" readonly="" required>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">    
                                <div class="col-md-12 text-center">
                                    <label>Note: Enter All Amounts In Rs [ Eg: 100.00 ]</label><hr>
                                </div>
                            </div>
                            <div class="row">    
                                <div class="col-md-6">
                                    <div class="form-group text-center">
                                        <label>Earnings</label>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Basic <span class="mandatory">*</span></label>
                                        <input class="form-control" id="basic" placeholder="Enter Basic Pay Amount" type="text" name="basic" value="<?php if(isset($_SESSION['session_payroll_basic'])) echo htmlspecialchars($_SESSION['session_payroll_basic']); ?>" autocomplete="off" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="food_allowance">Allowances and Reimbursement</label>
                                        <input class="form-control" id="food_allowance" placeholder="Enter Allowances and Reimbursement Amount" type="text" autocomplete="off" name="food_allowance" value="<?php if(isset($_SESSION['session_food_allowance'])) echo htmlspecialchars($_SESSION['session_payroll_food_allowance']); ?>">
                                    </div>

                                    <div class="form-group">
                                      <!--  <label for="overtime">Overtime </label>-->
                                        <input class="form-control" id="overtime" placeholder="Enter overtime in hours" type="hidden" autocomplete="off" name="overtime" value="<?php if(isset($_SESSION['session_payroll_overtime'])) echo htmlspecialchars($_SESSION['session_payroll_overtime']); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="house_rent_allowance">House Rent Allowance </label>
                                        <input class="form-control" id="house_rent_allowance" placeholder="Enter House Rent Allowance Amount" autocomplete="off" type="text" name="house_rent_allowance" value="<?php if(isset($_SESSION['session_payroll_house_rent_allowance'])) echo htmlspecialchars($_SESSION['session_payroll_house_rent_allowance']); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="conveyance_allowance">Conveyance Allowance </label>
                                        <input class="form-control" id="conveyance_allowance" placeholder="Enter Conveyance Allowance Amount" autocomplete="off" type="text" name="conveyance_allowance" value="<?php if(isset($_SESSION['session_payroll_conveyance_allowance'])) echo htmlspecialchars($_SESSION['session_payroll_conveyance_allowance']); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="special_allowance">Special Allowance </label>
                                        <input class="form-control" id="special_allowance" placeholder="Enter Special Allowance Amount" autocomplete="off" type="text" name="special_allowance" value="<?php if(isset($_SESSION['session_payroll_special_allowance'])) echo htmlspecialchars($_SESSION['session_payroll_special_allowance']); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="bonus">Bonus </label>
                                        <input class="form-control" id="bonus" autocomplete="off" placeholder="Enter Bonus Amount" type="text" name="bonus" value="<?php if(isset($_SESSION['session_payroll_bonus'])) echo htmlspecialchars($_SESSION['session_payroll_bonus']); ?>">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group text-center">
                                        <label>Deductions</label>
                                    </div>
                                    <div class="form-group">
                                        <label for="professional_tax">Professional Tax </label>
                                        <input class="form-control" id="professional_tax" placeholder="Enter Professional Tax Amount" type="text" autocomplete="off" name="professional_tax" value="<?php if(isset($_SESSION['session_payroll_professional_tax'])) echo htmlspecialchars($_SESSION['session_payroll_professional_tax']); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="income_tax">Income Tax </label>
                                        <input class="form-control" id="income_tax" placeholder="Enter Income Tax Amount" type="text" autocomplete="off" name="income_tax" value="<?php if(isset($_SESSION['session_payroll_income_tax'])) echo htmlspecialchars($_SESSION['session_payroll_income_tax']); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="provident_fund">Provident Fund </label>
                                        <input class="form-control" id="provident_fund" placeholder="Enter Provident Fund Amount" autocomplete="off" type="text" name="provident_fund" value="<?php if(isset($_SESSION['session_payroll_provident_fund'])) echo htmlspecialchars($_SESSION['session_payroll_provident_fund']); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="health_insurance">Health Insurance </label>
                                        <input class="form-control" id="health_insurance" placeholder="Enter Health Insurance Amount" autocomplete="off" type="text" name="health_insurance" value="<?php if(isset($_SESSION['session_payroll_health_insurance'])) echo htmlspecialchars($_SESSION['session_payroll_health_insurance']); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="un_paid_days_count">Un-paid days </label><p style="color: #0000FF; float:right;">[ AVAILABLE WORKING DAYS IN <?php echo strtoupper(date("M,  Y",strtotime("-1 month")));?>: <b><?php echo $working_days;?></b> ]</p>
                                        <?php if($resultgetCutOffStatus['status']== 1) { ?>
                                        <input class="form-control" id="un_paid_days_count" placeholder="Enter Un-paid days" type="text" autocomplete="off" name="un_paid_days_count" value="<?php if(isset($_SESSION['session_payroll_un_paid_days_count'])) echo htmlspecialchars($_SESSION['session_payroll_un_paid_days_count']); ?>">
                                        <?php } else { ?>
                                            <input class="form-control" id="un_paid_days_count" placeholder="Enter Un-paid days" type="text" autocomplete="off" name="un_paid_days_count" value="<?php if(isset($_SESSION['session_payroll_un_paid_days_count'])) echo htmlspecialchars($_SESSION['session_payroll_un_paid_days_count']); ?>" readonly>
                                        <?php } ?>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="misc">Misc </label>
                                        <input class="form-control" id="misc" autocomplete="off" placeholder="Enter Misc Amount" type="text" name="misc" value="<?php if(isset($_SESSION['session_payroll_misc'])) echo htmlspecialchars($_SESSION['session_payroll_misc']); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <hr>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="gross_earnings">Gross Earnings</label>
                                        <input class="form-control" id="gross_earnings" type="text" name="gross_earnings" readonly="" value="<?php if(isset($_SESSION['session_payroll_gross_earnings'])) echo htmlspecialchars($_SESSION['session_payroll_gross_earnings']); ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="gross_deductions">Gross Deductions</label>
                                        <input class="form-control" id="gross_deductions" type="text" readonly="" name="gross_deductions" value="<?php if(isset($_SESSION['session_payroll_gross_deductions'])) echo htmlspecialchars($_SESSION['session_payroll_gross_deductions']); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Net Pay:</label>
                                        <input type="text" name="net_pay" id="net_pay" class="form-control" readonly="" value="<?php if(isset($_SESSION['session_payroll_net_pay'])) echo htmlspecialchars($_SESSION['session_payroll_net_pay']); ?>">
                                    </div>    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status:</label>
                                        <select class="form-control" name="status" required>
                                            <option <?php if(isset($_SESSION['session_payroll_status']) && ($_SESSION['session_payroll_status']=='')) echo 'selected'; ?> value="">Select salary status</option>
                                            <option <?php if(isset($_SESSION['session_payroll_status']) && ($_SESSION['session_payroll_status']== 1)) echo 'selected'; ?> value="1">Salary credited</option>
                                            <option <?php if(isset($_SESSION['session_payroll_status']) && ($_SESSION['session_payroll_status']== 0)) echo 'selected'; ?> value="0">Salary not credited</option>
                                        </select>
                                    </div>    
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input class="btn btn-info preview-btn pull-left" value="Preview" type="text" name="previewPayroll">
                                        <input type="submit" class="pull-right btn btn-success generate-pdf-btn" name="savePayroll" value="Save & Confirm">
                                        <input style="margin: 0 10px;" class="btn btn-warning pull-right generate-pdf-btn"  value="Print" type="submit" name="savePayroll">
                                    </div>
                                </div>
                                <input value="<?php echo $available_calender_days;?>" type="hidden" name="paid_days_count">
                                <input style="opacity: 0; height: 0; width: 0; float: right" type="text" id="max_value" name="max_value" value="<?php echo $available_calender_days;?>">
                                <input type="hidden" name="overtimeAmount" id="overtimeAmount" value="<?php if(isset($_SESSION['session_payroll_overtimeAmount'])) echo htmlspecialchars($_SESSION['session_payroll_overtimeAmount']); ?>">
                                <input type="hidden" name="un_paid_days_amount" id="un_paid_days_amount" value="<?php if(isset($_SESSION['session_payroll_un_paid_days_amount'])) echo htmlspecialchars($_SESSION['session_payroll_un_paid_days_amount']); ?>">
                                <input type="hidden" name="email" id="email" value="<?php if(isset($_SESSION['session_payroll_email'])) echo htmlspecialchars($_SESSION['session_payroll_email']); ?>">
                                <input type="hidden" name="bankAccount" id="bankAccount" value="<?php if(isset($_SESSION['session_payroll_bankAccount'])) echo htmlspecialchars($_SESSION['session_payroll_bankAccount']); ?>">
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
<script type="text/javascript">
    var available_calender_days = '<?php echo $available_calender_days; ?>';
    var working_days = '<?php echo $working_days; ?>';
</script>
<?php include('include/footer.php');
?>
<!-- validate available calender days -->
<script type="text/javascript">
$('.project_title_input').blur(function() {
    $(this).rules("add", 
        {
        max: available_calender_days,
        messages: {
            required: "Please enter a value less than or equal to" +available_calender_days,
        }
    });
});
</script>

<!-- end -->

<script type="text/javascript">
    // employee name list
    $( "#name" ).autocomplete({
        autoFocus: true,
        delay: 100,
        source: 'namelist.php',
        minLength:2,
        select: function(event,ui){
        var id = ui.item.id;
        var value = ui.item.value;
        var email = ui.item.email;
        var bankAccount = ui.item.bank_account;
            if(id != '') {
                $('#employee_id').val(id);
                $('#email').val(email);
                $('#bankAccount').val(bankAccount);
                $('#employee_id').removeClass('error');
                $('#employee_id').next('label').remove();
                // check payroll already created or not
                var check_payroll_generated_id = $('#employee_id').val();
                $.ajax({
                    url: "PayrollController.php",
                    type: "post",
                    cache: false,
                    data: {"check_payroll_generated_id": check_payroll_generated_id},
                    success: function(result){
                        if(result >= 1) {
                            $('#employee_id').val('');
                            $("#name").val('');
                            var lastMonth ='<?php echo $lastMonth = date("F Y",strtotime("-1 month"));?>'
                            swal("Oops!!", "Paysilip for this employee for the month of "+ lastMonth + " has already been generated", "error");

                        }
                        
                    }
                });
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
        }
    });
    
    // payroll caculation
    var net_pay = 0;
    var basic = 0;
    var overtime = 0;
    var house_rent_allowance = 0;
    var food_allowance = 0;
    var conveyance_allowance = 0;
    var special_allowance = 0;
    var totalIncome = 0;
    var bonus = 0; 
    var professional_tax = 0;
    var income_tax = 0;
    var provident_fund = 0;
    var health_insurance = 0;
    var un_paid_days = 0;
    var misc = 0;
    var totalDeduction = 0;
    // format given number 
     function ReplaceNumberWithCommas(givenNumber) {
        //Seperates the components of the number
        var components = givenNumber.toString().split(".");
        //Comma-fies the first part
        components [0] = components [0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        if(components [1] == undefined) {
            components [1] = '0' + '0';
            return components.join(".");
        }
        else if(components [1].length == 1) {
            components [1] = components [1] + '0';
            return components.join(".");
        }
        else if(components [1].length > 2) {
            givenNumber=givenNumber.replace(/\,/g,'');
            givenNumber = parseFloat(givenNumber).toFixed(2);
            var components_new = givenNumber.toString().split(".");
            components_new [0] = components_new [0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            return components_new.join(".");
        }
        else {
            return components.join(".");
        }
    }

    // make payroll calculation

     $('#basic').blur(function() {
        basic = $('#basic').val();
        if(basic.length > 0) {
            $('#basic').val(ReplaceNumberWithCommas(basic));
            basic=basic.replace(/\,/g,'');
            basic = parseFloat(basic).toFixed(2);
            totalIncome = parseFloat(basic) + parseFloat(overtime) + parseFloat(house_rent_allowance) +parseFloat(food_allowance) + parseFloat(food_allowance) + parseFloat(conveyance_allowance) + parseFloat(special_allowance) + parseFloat(bonus);
            $('#gross_earnings').val(ReplaceNumberWithCommas(totalIncome));

            net_pay = parseFloat(totalIncome) - parseFloat(totalDeduction);
            $('#net_pay').val(ReplaceNumberWithCommas(net_pay));
            //alert(ReplaceNumberWithCommas(net_pay));
        }
        else {
            totalIncome = parseFloat(overtime) + parseFloat(house_rent_allowance) +parseFloat(food_allowance) + parseFloat(conveyance_allowance) + parseFloat(special_allowance) + parseFloat(bonus);
            $('#gross_earnings').val(ReplaceNumberWithCommas(totalIncome));
            net_pay = parseFloat(totalIncome) - parseFloat(totalDeduction);
            $('#net_pay').val(ReplaceNumberWithCommas(net_pay));
            basic = 0;
        } 
    });
    $('#overtime').keyup(function() {
        overtime = $('#overtime').val();
        if(overtime.length > 0) {
            if(!isNaN(overtime)) {
                var WorkingHoursPerDay = '<?php echo $WorkingHoursPerDay;?>';
                var totalWorkingHrs = available_calender_days * WorkingHoursPerDay;
                var maxOvertime = available_calender_days * 24 - WorkingHoursPerDay * working_days;
                if(overtime < maxOvertime) {
                    overtime = overtime * basic * 1.5 / totalWorkingHrs;
                    overtime = overtime.toFixed(2);
                    $('#overtimeAmount').val(overtime);
                    totalIncome = parseFloat(basic) + parseFloat(overtime) + parseFloat(house_rent_allowance) +parseFloat(food_allowance) + parseFloat(conveyance_allowance) + parseFloat(special_allowance) + parseFloat(bonus);
                    $('#gross_earnings').val(ReplaceNumberWithCommas(totalIncome));
                    net_pay = parseFloat(totalIncome) - parseFloat(totalDeduction);
                    $('#net_pay').val(ReplaceNumberWithCommas(net_pay));
                } else {
                    alert('Invalid overtime hours for a month.');
                }
            } else {
                alert('Please Enter digits only.');
            }
        }
        else {
            totalIncome = parseFloat(basic) + parseFloat(house_rent_allowance) +parseFloat(food_allowance) + parseFloat(conveyance_allowance) + parseFloat(special_allowance) + parseFloat(bonus);
            $('#gross_earnings').val(ReplaceNumberWithCommas(totalIncome));
            net_pay = parseFloat(totalIncome) - parseFloat(totalDeduction);
            $('#net_pay').val(ReplaceNumberWithCommas(net_pay));
            overtime = 0;
            $('#overtimeAmount').val(overtime);
        }
  
    });
    $('#house_rent_allowance').blur(function() {
        house_rent_allowance = $(this).val();
        if(house_rent_allowance.length > 0) {
            $('#house_rent_allowance').val(ReplaceNumberWithCommas(house_rent_allowance));
            house_rent_allowance=house_rent_allowance.replace(/\,/g,'');
            house_rent_allowance = parseFloat(house_rent_allowance).toFixed(2);
            totalIncome = parseFloat(basic) + parseFloat(overtime) + parseFloat(house_rent_allowance) + parseFloat(food_allowance) + parseFloat(conveyance_allowance) + parseFloat(special_allowance) + parseFloat(bonus);
            $('#gross_earnings').val(ReplaceNumberWithCommas(totalIncome));
            net_pay = parseFloat(totalIncome) - parseFloat(totalDeduction);
            $('#net_pay').val(ReplaceNumberWithCommas(net_pay));
        }
        else {
            totalIncome = parseFloat(basic) + parseFloat(overtime) + parseFloat(conveyance_allowance) + parseFloat(food_allowance) + parseFloat(special_allowance) + parseFloat(bonus);
            $('#gross_earnings').val(ReplaceNumberWithCommas(totalIncome));
            net_pay = parseFloat(totalIncome) - parseFloat(totalDeduction);
            $('#net_pay').val(ReplaceNumberWithCommas(net_pay));
            house_rent_allowance = 0;
        }   
    });

    $('#food_allowance').blur(function() {
        food_allowance = $(this).val();
        if(food_allowance.length > 0) {
            $('#food_allowance').val(ReplaceNumberWithCommas(food_allowance));
            food_allowance=food_allowance.replace(/\,/g,'');
            food_allowance = parseFloat(food_allowance).toFixed(2);
            totalIncome = parseFloat(basic) + parseFloat(overtime) + parseFloat(house_rent_allowance) + parseFloat(food_allowance) + parseFloat(conveyance_allowance) + parseFloat(special_allowance) + parseFloat(bonus);
            $('#gross_earnings').val(ReplaceNumberWithCommas(totalIncome));
            net_pay = parseFloat(totalIncome) - parseFloat(totalDeduction);
            $('#net_pay').val(ReplaceNumberWithCommas(net_pay));
        }
        else {
            totalIncome = parseFloat(basic) + parseFloat(overtime)  + parseFloat(house_rent_allowance) + parseFloat(conveyance_allowance) + parseFloat(special_allowance) + parseFloat(bonus);
            $('#gross_earnings').val(ReplaceNumberWithCommas(totalIncome));
            net_pay = parseFloat(totalIncome) - parseFloat(totalDeduction);
            $('#net_pay').val(ReplaceNumberWithCommas(net_pay));
            food_allowance = 0;
        }   
    });


    $('#conveyance_allowance').blur(function() {
        conveyance_allowance = $(this).val();
        if(conveyance_allowance.length > 0) {
            $('#conveyance_allowance').val(ReplaceNumberWithCommas(conveyance_allowance));
            conveyance_allowance = conveyance_allowance.replace(/\,/g,'');
            conveyance_allowance = parseFloat(conveyance_allowance).toFixed(2);

            totalIncome = parseFloat(basic) + parseFloat(overtime) + parseFloat(house_rent_allowance) +parseFloat(food_allowance) + parseFloat(conveyance_allowance) + parseFloat(special_allowance) + parseFloat(bonus);
            $('#gross_earnings').val(ReplaceNumberWithCommas(totalIncome));
            net_pay = parseFloat(totalIncome) - parseFloat(totalDeduction);
            $('#net_pay').val(ReplaceNumberWithCommas(net_pay));
        }
        else {
            totalIncome = parseFloat(basic) + parseFloat(overtime) + parseFloat(house_rent_allowance) +parseFloat(food_allowance) + parseFloat(special_allowance) + parseFloat(bonus);
            $('#gross_earnings').val(ReplaceNumberWithCommas(totalIncome));
            net_pay = parseFloat(totalIncome) - parseFloat(totalDeduction);
            $('#net_pay').val(ReplaceNumberWithCommas(net_pay));
            conveyance_allowance = 0;
        }
    });
    $('#special_allowance').blur(function() {
        special_allowance = $(this).val();
        if(special_allowance.length > 0) {
            $('#special_allowance').val(ReplaceNumberWithCommas(special_allowance));
            special_allowance = special_allowance.replace(/\,/g,'');
            special_allowance = parseFloat(special_allowance).toFixed(2);

            totalIncome = parseFloat(basic) + parseFloat(overtime) + parseFloat(house_rent_allowance) + parseFloat(food_allowance) + parseFloat(conveyance_allowance) + parseFloat(special_allowance) + parseFloat(bonus);
            $('#gross_earnings').val(ReplaceNumberWithCommas(totalIncome));
            net_pay = parseFloat(totalIncome) - parseFloat(totalDeduction);
            $('#net_pay').val(ReplaceNumberWithCommas(net_pay));
        }
        else {
            totalIncome = parseFloat(basic) + parseFloat(overtime) + parseFloat(house_rent_allowance) + parseFloat(food_allowance) + parseFloat(conveyance_allowance) + parseFloat(bonus);
            $('#gross_earnings').val(ReplaceNumberWithCommas(totalIncome));
            net_pay = parseFloat(totalIncome) - parseFloat(totalDeduction);
            $('#net_pay').val(ReplaceNumberWithCommas(net_pay));
            special_allowance = 0;
        }
    });
    $('#bonus').blur(function() {
        bonus = $(this).val();
        if(bonus.length > 0) {
            $('#bonus').val(ReplaceNumberWithCommas(bonus));
            bonus = bonus.replace(/\,/g,'');
            bonus = parseFloat(bonus).toFixed(2);

            totalIncome = parseFloat(basic) + parseFloat(overtime) + parseFloat(house_rent_allowance) + parseFloat(food_allowance) + parseFloat(conveyance_allowance) + parseFloat(special_allowance) + parseFloat(bonus);
            $('#gross_earnings').val(ReplaceNumberWithCommas(totalIncome));
            net_pay = parseFloat(totalIncome) - parseFloat(totalDeduction);
            $('#net_pay').val(ReplaceNumberWithCommas(net_pay));
        }
        else {
            totalIncome = parseFloat(basic) + parseFloat(overtime) + parseFloat(house_rent_allowance) + parseFloat(food_allowance) + parseFloat(conveyance_allowance) + parseFloat(special_allowance);
            $('#gross_earnings').val(ReplaceNumberWithCommas(totalIncome));
            net_pay = parseFloat(totalIncome) - parseFloat(totalDeduction);
            $('#net_pay').val(ReplaceNumberWithCommas(net_pay));
            bonus = 0;
        }
    });

    // gross deduction 
    $('#professional_tax').blur(function() {
        professional_tax = $('#professional_tax').val();
        if(professional_tax.length > 0) {
            $('#professional_tax').val(ReplaceNumberWithCommas(professional_tax));
            professional_tax = professional_tax.replace(/\,/g,'');
            professional_tax = parseFloat(professional_tax).toFixed(2);

            totalDeduction = parseFloat(professional_tax) + parseFloat(income_tax) + parseFloat(provident_fund) + parseFloat(health_insurance) + parseFloat(un_paid_days) + parseFloat(misc);
            $('#gross_deductions').val(ReplaceNumberWithCommas(totalDeduction));
            net_pay = parseFloat(totalIncome) - parseFloat(totalDeduction);
            $('#net_pay').val(ReplaceNumberWithCommas(net_pay));
        }
        else {
            totalDeduction = parseFloat(income_tax) + parseFloat(provident_fund) + parseFloat(health_insurance) + parseFloat(un_paid_days) + parseFloat(misc);
            $('#gross_deductions').val(ReplaceNumberWithCommas(totalDeduction));
            net_pay = parseFloat(totalIncome) - parseFloat(totalDeduction);
            $('#net_pay').val(ReplaceNumberWithCommas(net_pay));
            professional_tax = 0;
        }
    });
    $('#income_tax').blur(function() {
        income_tax = $('#income_tax').val();
        if(income_tax.length > 0) {
            $('#income_tax').val(ReplaceNumberWithCommas(income_tax));
            income_tax = income_tax.replace(/\,/g,'');
            income_tax = parseFloat(income_tax).toFixed(2);

            totalDeduction = parseFloat(professional_tax) + parseFloat(income_tax) + parseFloat(provident_fund) + parseFloat(health_insurance) + parseFloat(un_paid_days) + parseFloat(misc);
            $('#gross_deductions').val(ReplaceNumberWithCommas(totalDeduction));
            net_pay = parseFloat(totalIncome) - parseFloat(totalDeduction);
            $('#net_pay').val(ReplaceNumberWithCommas(net_pay));
        }
        else {
            totalDeduction = parseFloat(professional_tax) + parseFloat(provident_fund) + parseFloat(health_insurance) + parseFloat(un_paid_days) + parseFloat(misc);
            $('#gross_deductions').val(ReplaceNumberWithCommas(totalDeduction));
            net_pay = parseFloat(totalIncome) - parseFloat(totalDeduction);
            $('#net_pay').val(ReplaceNumberWithCommas(net_pay));
            income_tax = 0;
        }
    });
    $('#provident_fund').blur(function() {
        provident_fund = $('#provident_fund').val();
        if(provident_fund.length > 0) {
            $('#provident_fund').val(ReplaceNumberWithCommas(provident_fund));
            provident_fund = provident_fund.replace(/\,/g,'');
            provident_fund = parseFloat(provident_fund).toFixed(2);

            totalDeduction = parseFloat(professional_tax) + parseFloat(income_tax) + parseFloat(provident_fund) + parseFloat(health_insurance) + parseFloat(un_paid_days) + parseFloat(misc);
            $('#gross_deductions').val(ReplaceNumberWithCommas(totalDeduction));
            net_pay = parseFloat(totalIncome) - parseFloat(totalDeduction);
            $('#net_pay').val(ReplaceNumberWithCommas(net_pay));
        }
        else {
            totalDeduction = parseFloat(professional_tax) + parseFloat(income_tax) + parseFloat(health_insurance) + parseFloat(un_paid_days) + parseFloat(misc);
            $('#gross_deductions').val(ReplaceNumberWithCommas(totalDeduction));
            net_pay = parseFloat(totalIncome) - parseFloat(totalDeduction);
            $('#net_pay').val(ReplaceNumberWithCommas(net_pay));
            provident_fund = 0;
        }
    });
    $('#health_insurance').blur(function() {
        health_insurance = $('#health_insurance').val();
        if(health_insurance.length > 0) {
            $('#health_insurance').val(ReplaceNumberWithCommas(health_insurance));
            health_insurance = health_insurance.replace(/\,/g,'');
            health_insurance = parseFloat(health_insurance).toFixed(2);

            totalDeduction = parseFloat(professional_tax) + parseFloat(income_tax) + parseFloat(provident_fund) + parseFloat(health_insurance) + parseFloat(un_paid_days) + parseFloat(misc);
            $('#gross_deductions').val(ReplaceNumberWithCommas(totalDeduction));
            net_pay = parseFloat(totalIncome) - parseFloat(totalDeduction);
            $('#net_pay').val(ReplaceNumberWithCommas(net_pay));
        }
        else {
            totalDeduction = parseFloat(professional_tax) + parseFloat(income_tax) + parseFloat(provident_fund) + parseFloat(un_paid_days) + parseFloat(misc);
            $('#gross_deductions').val(ReplaceNumberWithCommas(totalDeduction));
            net_pay = parseFloat(totalIncome) - parseFloat(totalDeduction);
            $('#net_pay').val(ReplaceNumberWithCommas(net_pay));
            health_insurance = 0;
        }
    });
    var no_of_absent_days = 0;
    $('#un_paid_days_count').blur(function() {
        no_of_absent_days = $('#un_paid_days_count').val();
        if(no_of_absent_days.length > 0) {
           var loss_of_pay = (parseFloat(basic) * parseFloat(no_of_absent_days)/available_calender_days);
           loss_of_pay = loss_of_pay.toFixed(2);
           //alert(loss_of_pay);
           $('#un_paid_days_amount').val(loss_of_pay);
            totalDeduction = parseFloat(professional_tax) + parseFloat(income_tax) + parseFloat(provident_fund) + parseFloat(health_insurance) + parseFloat(loss_of_pay) + parseFloat(misc);
            $('#gross_deductions').val(ReplaceNumberWithCommas(totalDeduction));
            net_pay = parseFloat(totalIncome) - parseFloat(totalDeduction);
            $('#net_pay').val(ReplaceNumberWithCommas(net_pay));
            un_paid_days = loss_of_pay;
        }
        else {
            totalDeduction = parseFloat(professional_tax) + parseFloat(income_tax) + parseFloat(provident_fund) + parseFloat(health_insurance) + parseFloat(misc);
            $('#gross_deductions').val(ReplaceNumberWithCommas(totalDeduction));
            net_pay = parseFloat(totalIncome) - parseFloat(totalDeduction);
            $('#net_pay').val(ReplaceNumberWithCommas(net_pay));
            un_paid_days = 0;
            $('#un_paid_days_amount').val(un_paid_days);
        }
    });
    $('#misc').blur(function() {
        misc = $('#misc').val();
        if(misc.length > 0) {
            $('#misc').val(ReplaceNumberWithCommas(misc));
            misc = misc.replace(/\,/g,'');
            misc = parseFloat(misc).toFixed(2);

            totalDeduction = parseFloat(professional_tax) + parseFloat(income_tax) + parseFloat(provident_fund) + parseFloat(health_insurance) + parseFloat(un_paid_days) + parseFloat(misc);
            $('#gross_deductions').val(ReplaceNumberWithCommas(totalDeduction));
            net_pay = parseFloat(totalIncome) - parseFloat(totalDeduction);
            $('#net_pay').val(ReplaceNumberWithCommas(net_pay));
        }
        else {
            totalDeduction = parseFloat(professional_tax) + parseFloat(income_tax) + parseFloat(provident_fund) + parseFloat(health_insurance) + parseFloat(un_paid_days);
            $('#gross_deductions').val(ReplaceNumberWithCommas(totalDeduction));
            net_pay = parseFloat(totalIncome) - parseFloat(totalDeduction);
            $('#net_pay').val(ReplaceNumberWithCommas(net_pay));
            misc = 0;
        }
    });

    // fade error message div
    $( ".clear-error-msg" ).click(function() {
        $( ".error-message" ).fadeOut( "slow" );
    });

</script>

<?php 
    if(isset($_SESSION['payroll_success'])) {
?>
<script type="text/javascript">
    swal('Congrats', 'Payroll Generated Successfully.', 'success');
</script>
<?php
    unset($_SESSION['payroll_success']);  
    }
?>
<!-- preview Modal -->
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg" id="printableArea">

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
<!-- preview payroll -->
<script type="text/javascript">
    $('.preview-btn').click(function() {

        $("#payrollForm").valid();

        var btn_text = $(this).val();
        var form = $("#payrollForm");
        $('.generate-pdf-btn').attr('disabled','disabled');

        // console.log("Preview Btn Press",form);

        $.ajax({
            type:"POST",
            url:form.attr("action"),
            data:form.serialize(),
            success: function(response) {

            //    console.log("Preview Response",response);

               if(response == 'success') {
                     $('.generate-pdf-btn').removeAttr('disabled','disabled');
                    if(btn_text == 'Preview') {
                        $(".modal-body").load('generatePayrollPdf.php');
                        $('#myModal').modal('show');
                    }
               } 
            }
        });
        
    });

    // $('.generate-pdf-btn').click(function() {
    //     clickedBtn = $(this);
    //     $('.preview-btn').attr('disabled','disabled');
    //     clickedBtn.removeAttr('disabled','disabled');
    //     $("#payrollForm").submit();
    // });
</script>
</body>
</html>