<?php
//ini_set('display_errors', 1);
date_default_timezone_set('Asia/Kolkata');
$current_date = time();
include_once 'DBManager.php';
include_once 'AppointmentManager.php';
$DBManager = new DBManager();
$appointmentManager = new AppointmentManager();
$employee_id = $_GET['employee_id'];
$result = $appointmentManager->getProbationAppointment($employee_id);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Generating ProbationAppointment</title>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/custom.css">
</head>
<body>
	<div class="container appointment-box">
		<div class="row">
			<div class="col-md-12">
				<?php echo $result['appointment_details'];?>
			</div>
		</div>
	</div>
	
</body>
</html>

