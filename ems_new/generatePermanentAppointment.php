<?php
//ini_set('display_errors', 1);
date_default_timezone_set('Asia/Kolkata');
$current_date = time();
include_once 'DBManager.php';
include_once 'AppointmentManager.php';
$DBManager = new DBManager();
$appointmentManager = new AppointmentManager();
if(isset($_GET['employee_id'])) {
	$employee_id = $_GET['employee_id'];
} elseif(isset($_GET['print_appointment'])) {
	$employee_id = $_GET['print_appointment'];
} else {
	header('Location:permanentAppointment');
}
$result = $appointmentManager->getPermanentAppointment($employee_id);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Generating Permanent Appointment</title>
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
<?php 
if(isset($_GET['print_appointment'])) {
?>	
<script type="text/javascript">
	window.print();
	window.location.assign('permanentAppointment');
</script>
<?php
	}
?>