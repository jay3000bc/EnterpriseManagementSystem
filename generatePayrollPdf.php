<?php
//ini_set('display_errors', 1);
date_default_timezone_set('Asia/Kolkata');
$current_date = time();
include_once 'DBManager.php';
include_once 'EmployeeManager.php';
include_once 'PayrollManager.php';
$DBManager = new DBManager();
$employeeManager = new EmployeeManager();
$payrollManager = new PayrollManager();
if(isset($_GET['employee_id'])) {
	$employee_id = $_GET['employee_id'];
	$result = $employeeManager->getEmployeeDetailsByEmployeeId($employee_id);
	$resultPayroll = $payrollManager->getEmployeePayroll($employee_id);
} else if(isset($_GET['print_payroll'])) {
	$employee_id = $_GET['print_payroll'];
	$result = $employeeManager->getEmployeeDetailsByEmployeeId($employee_id);
	$resultPayroll = $payrollManager->getEmployeePayroll($employee_id);
} else {
	$resultPayroll = $payrollManager->getPreviewPayroll();
	$result = $employeeManager->getEmployeeDetailsByEmployeeId($resultPayroll['employee_id']);

}

setlocale(LC_MONETARY, 'en_IN');
include_once 'EvaluateDaysManager.php';
$evaluateDaysManager = new EvaluateDaysManager();
$month = date('m', strtotime("-1 month"));
$year = date('Y', strtotime("-1 month"));
$available_calender_days = $evaluateDaysManager->calculateAvailableCalenderDays($month, $year);
$resultgetCutOffStatus = $evaluateDaysManager->getCutOffStatus();

// Company Details
include_once 'AdminManager.php';
$adminManager = new AdminManager();
$companyInfo = $adminManager->getAdminDetails();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Generating Payroll</title>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/custom.css">
</head>
<body>
	<div class="container payroll-box">
		<div class="row">
			<div class="col-md-12">
				<?php if($companyInfo['company_logo'] != '') { ?>
                <img src="<?php echo 'uploads/company_profile_images/'.$companyInfo['company_logo'];?>" alt="logo">
                <?php } else { ?>
                <img src="uploads/company_profile_images/logo-black.png" alt="logo">
                <?php } ?><br>
			</div>
			<div class="col-md-12" >
				<h4 style="color:#0083A3 !important;font-weight:bold !important">Payslip for the Month of <?php echo date("F Y",strtotime("-1 month"));?><br> Financial year 
					<?php 
					if(date('m') > 03) {
					   $d = date('Y-m-d', strtotime('+1 years'));
					   echo   date('Y') .'-'.date('y', strtotime($d));
					} else {
					  $d = date('Y-m-d', strtotime('-1 years'));
					  echo   date('Y', strtotime($d)).'-'.date('y');
					} ?>
				</h4>
				<!--<br>-->
				<h4><label style="color:#0083A3 !important;font-weight:bold !important">Private &amp; Confidential</label></h4>
			</div>
			<div class="col-md-12">
				<!--<h4><label>Private &amp; Confidential</label></h4>-->
				<table class="table table-bordered" style="width: 100%;">
					<thead>
						<tr class="table-heading" style="background: #7cc576 !important;">
							<th colspan="2" class="text-center">Associate Information</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td colspan="2" style="color:#0083A3 !important;font-size:16px !important;font-weight:bold !important">Name of Employee: <?php echo $result['name'];?></td>
						</tr>
						<tr>
							<td style="width: 50%;">Associate Id: <?php echo str_pad($result['employee_id'], 4, '0', STR_PAD_LEFT);?></td>
							<td style="width: 50%;">Location: <?php echo $result['current_address'];?></td>
						</tr>
						<tr>
							<td>Designation: <?php echo $result['designation'];?></td>
							<td>PAN: <?php echo $result['pan'];?></td>
						</tr>
						<tr>
							<td>Gender: <?php echo $result['gender'];?></td>
							<td>Bank A/C: <?php echo $result['bank_account'];?></td>
						</tr>
						<tr>
							<td>Date of Joining: <?php echo $result['date_of_joining'];?></td>
							<td>IFSC: <?php echo $result['ifsc_code'];?></td>
						</tr>
						<tr>
							<td>Date of Birth: <?php echo $result['date_of_birth'];?></td>
							<td>Status: 
								<?php  
                                    if($resultPayroll['status'] == 1) echo 'Salary Credited'; else echo 'Salary not Credited';  ?>
                            </td>
						</tr>
						<tr>
							<td>PF Account:  <?php echo $result['pf_account'];?></td>
							<td>Available Calender Days: <?php echo $available_calender_days;?></td>
						</tr>
						<tr>
							<td>Policy No: <?php echo $result['policy_no'];?></td>
							<td><?php if($resultgetCutOffStatus['status']== 1) { ?> Paid Days: <?php echo $resultPayroll['paid_days_count']; } ?></td>
						</tr>
						<tr>
							<td>LIC Id: <?php echo $result['lic_id'];?></td>
							<td><?php if($resultgetCutOffStatus['status']== 1) { ?> Loss of pay days: <?php echo $resultPayroll['un_paid_days_count']; } ?></td>
						</tr>
					</tbody>
				</table>
				<table class="table table-bordered" style="width: 100%;">
					<thead>
						<tr class="table-heading" style="background: #7cc576 !important;">
							<th style="width: 50%;"><span class="amount-name">Earnings </span><span class="amount-value">Amount in Rs</span></th>
							<th style="width: 50%;"><span class="amount-name">Deductions </span><span class="amount-value">Amount in Rs</span></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><span class="amount-name">Basic </span><span class="amount-value"><?php echo $resultPayroll['basic']; //money_format('%!i', $resultPayroll['basic']);?></span></td>
							<td><span class="amount-name">Professional Tax</span><span class="amount-value"><?php echo $resultPayroll['professional_tax']; //money_format('%!i', $resultPayroll['professional_tax']);?></span></td>
						</tr>
						<tr>
							<td><span class="amount-name">House rent allowance </span><span class="amount-value"><?php echo $resultPayroll['house_rent_allowance']; //money_format('%!i', $resultPayroll['house_rent_allowance']);?></span></td>
							<td><span class="amount-name">Income Tax </span><span class="amount-value"><?php echo $resultPayroll['income_tax']; //money_format('%!i', $resultPayroll['income_tax']);?></span></td>
						</tr>
						<tr>
							<td><span class="amount-name">Conveyance allowance </span><span class="amount-value"><?php  echo $resultPayroll['conveyance_allowance']; //money_format('%!i', $resultPayroll['conveyance_allowance']);?></span></td>
							<td><span class="amount-name">Provident Fund  </span><span class="amount-value"><?php echo $resultPayroll['provident_fund'] //money_format('%!i', $resultPayroll['provident_fund']);?></span></td>
						</tr>
						<tr>
							<td><span class="amount-name">Special Allowance </span><span class="amount-value"><?php  echo $resultPayroll['special_allowance']; //money_format('%!i', $resultPayroll['special_allowance']);?></span>
							</td>
							<td>
								<?php if($resultPayroll['health_insurance'] != 0) {?>
								<span class="amount-name">Health Insurance </span><span class="amount-value"><?php  echo $resultPayroll['health_insurance']; //money_format('%!i', $resultPayroll['health_insurance']);?></span>
								<?php } ?>
							</td>
						</tr>
						<tr>
							<td><span class="amount-name">Bonus </span><span class="amount-value"><?php  echo $resultPayroll['bonus']; //money_format('%!i', $resultPayroll['bonus']);?></span>
							</td>
							<td>
								<?php if($resultPayroll['un_paid_days'] != 0) {?>
								<span class="amount-name">Un-paid days </span><span class="amount-value"><?php  echo $resultPayroll['un_paid_days'] //money_format('%!i', $resultPayroll['un_paid_days']);?></span>
								<?php } ?>
							</td>
						</tr>
						<tr>
							<td><span class="amount-name">Food Allowance</span><span class="amount-value"><?php  echo $resultPayroll['food_allowance']; //money_format('%!i', $resultPayroll['food_allowance']);?></span>
							</td>
							<td>
								<?php if($resultPayroll['misc'] != 0) {?>
								<span class="amount-name">Misc </span><span class="amount-value"><?php  echo $resultPayroll['misc']; //money_format('%!i', $resultPayroll['misc']);?></span>
								<?php } ?>
							</td>
						</tr>
						<tr>
							<td></td>
							<td><span class="amount-name">Gross Deduction:</span><span class="amount-value"><?php  echo $resultPayroll['gross_deductions'] //money_format('%!i', $resultPayroll['gross_deductions']);?></span></td>
						</tr>
						<tr>
							<td><span class="amount-name">Gross Earning:</span><span class="amount-value"><?php  echo  $resultPayroll['gross_earnings']; //money_format('%!i', $resultPayroll['gross_earnings']);?></span></td>
							<td><span class="amount-name">Net Earning:</span><span class="amount-value"><?php echo $resultPayroll['net_pay'];   ?></span></td>
							<!--<td><span class="amount-name" style="text-align: right; width: 100%;">Net pay</span></td>-->
							<!--<td><span class="amount-name" style="text-align: left"><?php //echo  $resultPayroll['net_pay']; ?></span></td>-->
						</tr>
					</tbody>
				</table>
				<p style="text-align: right; margin-top: 30px;">This is computer generated paysilip and does not required a signature.</p>
			</div>
		</div>
	</div>
	
</body>
</html>
<?php 
if(isset($_GET['print_payroll'])) {
?>	
<script type="text/javascript">
	window.print();
	window.location.assign('payroll');
</script>
<?php
	}
?>