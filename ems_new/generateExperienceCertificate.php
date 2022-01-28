<?php
date_default_timezone_set('Asia/Kolkata');
$current_date = time();
include_once 'DBManager.php';
include_once 'AppointmentManager.php';
$DBManager = new DBManager();
$appointmentManager = new AppointmentManager();
if(isset($_GET['employee_id'])) {
	$employee_id = $_GET['employee_id'];
} elseif(isset($_GET['print_experience'])) {
	$employee_id = $_GET['print_experience'];
} else {
	header('Location:experienceCertificate');
}
$result = $appointmentManager->getExperienceCertificate($employee_id);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Generating Experience Certificate</title>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/custom.css">
</head>
<body>
	<div class="container appointment-box">
		<div class="row">
			<div class="col-md-12">
				<?php echo $result['experience_details'];?>
			</div>
		</div>
	</div>
</body>
</html>
<?php 
if(isset($_GET['print_experience'])) {
?>	
<script type="text/javascript">
	window.print();
	window.location.assign('experienceCertificate');
</script>
<?php
	}
?>