<?php
session_start();
include_once('settings/config.php');
date_default_timezone_set('Asia/Kolkata');
$current_date = time();
include_once 'DBManager.php';
$DBManager = new DBManager();
include_once 'AppointmentManager.php';
$appointmentManager = new AppointmentManager();
if (isset($_POST["saveProbationerAppointment"])) {
  
    $employee_id = mysqli_real_escape_string($DBManager->conn, $_POST['employee_id']);
    $appointment_details = mysqli_real_escape_string($DBManager->conn, $_POST['appointment_details']);
    
	$pdf_name = 'PROB'.$employee_id.'.pdf';
	$target_dir = "uploads/appointment_pdf/probationer/";
	$target_file = $target_dir . $pdf_name;

	if (file_exists($target_file)) {
		unlink($target_file);
	}
	$total = $appointmentManager->checkProbationAppointmentExists($employee_id);
	if(is_array($total)) {
		$result = $appointmentManager->updateProbationerAppointment($employee_id, $appointment_details);
	}
	else {
		$result = $appointmentManager->saveProbationerAppointment($employee_id, $appointment_details, $pdf_name);
	}
		
	if($result) {
		$generatePdfUrl = $absoluteUrl.'generatePrabationerAppointment.php?employee_id='.$employee_id;

		$pdf=exec('/usr/local/bin/wkhtmltopdf --page-size A4 --print-media-type --include-in-outline '.$generatePdfUrl.' '.$target_file.' 2>&1');
		if( !$pdf ) {
			$_SESSION['probationer_error'] = 'Failed to generate appointment pdf. Its seems you have not installed WKHTMLTOPDF on server or on local machine also enable exec function of php if it is in disbaled list.';
			header('location:probationerAppointment');
		}
		$_SESSION['probationer_success'] = 'success';
		if($_POST["saveProbationerAppointment"] == 'Print') {
			header('Location:generatePrabationerAppointment.php?print_appointment='.$employee_id);
		} else {
			header("Location: probationerAppointment");
		}
		
	}
}
if (isset($_POST["savePermanentAppointment"])) {
  
    $employee_id = mysqli_real_escape_string($DBManager->conn, $_POST['employee_id']);
    $appointment_details = mysqli_real_escape_string($DBManager->conn, $_POST['appointment_details']);

	$pdf_name = 'PERMA'.$employee_id.'.pdf';
	$target_dir = "uploads/appointment_pdf/permanent/";
	$target_file = $target_dir . $pdf_name;

	if (file_exists($target_file)) {
		unlink($target_file);
	}
	$total = $appointmentManager->checkPermanentAppointmentExists($employee_id);
	if(is_array($total)) {
		$result = $appointmentManager->updatePermanentAppointment($employee_id, $appointment_details);
	}
	else {
		$result = $appointmentManager->savePermanentAppointment($employee_id, $appointment_details, $pdf_name);
	}
	if($result) {
		$generatePdfUrl = $absoluteUrl.'generatePermanentAppointment?employee_id='.$employee_id;
		$pdf=exec('/usr/local/bin/wkhtmltopdf --page-size A4 --print-media-type --include-in-outline '.$generatePdfUrl.' '.$target_file.' 2>&1');
		if(!$pdf) {
			$_SESSION['permanent_error'] = 'Failed to generate appointment pdf. Its seems you have not installed WKHTMLTOPDF on server or on local machine also enable exec function of php if it is in disbaled list.';
			header('location:permanentAppointment');
			die();
		}
		$_SESSION['permanent_success'] = 'success';
		if($_POST["savePermanentAppointment"] == 'Print') {
			header('Location:generatePermanentAppointment.php?print_appointment='.$employee_id);
		} else {
			header("Location: permanentAppointment");
		}
	}
	
}
if (isset($_POST["probationer_employee_id"])) {
	$probationer_employee_id = mysqli_real_escape_string($DBManager->conn, $_POST['probationer_employee_id']);
	// echo $probationer_employee_id;
	// die();
	$total = $appointmentManager->checkProbationAppointmentExists($probationer_employee_id);
	if($total == 0) {
		echo $total;
	} else {
		foreach ($total as $key => $value) {
			echo $value;
		}
	}
}
if (isset($_POST["permanent_employee_id"])) {
	$permanent_employee_id = mysqli_real_escape_string($DBManager->conn, $_POST['permanent_employee_id']);
	// echo $permanent_employee_id;
	// die();
	$total = $appointmentManager->checkPermanentAppointmentExists($permanent_employee_id);
	if($total == 0) {
		echo $total;
	} else {
		foreach ($total as $key => $value) {
			echo $value;
		}
	}
}
if (isset($_POST["saveExperienceCertificate"])) {
  
    $employee_id = mysqli_real_escape_string($DBManager->conn, $_POST['employee_id']);
    $experience_details = mysqli_real_escape_string($DBManager->conn, $_POST['experience_details']);

	$pdf_name = 'EXPCERT'.$employee_id.'.pdf';
	$target_dir = "uploads/experience_certificate_pdf/";
	$target_file = $target_dir . $pdf_name;

	if (file_exists($target_file)) {
		unlink($target_file);
	}
	$total = $appointmentManager->checkExperienceCertificateExists($employee_id);
	if(is_array($total)) {
		$result = $appointmentManager->updateExperienceCertificate($employee_id, $experience_details);
	}
	else {
		$result = $appointmentManager->saveExperienceCertificate($employee_id, $experience_details, $pdf_name);
	}
	if($result) {
		$generatePdfUrl = $absoluteUrl.'generateExperienceCertificate?employee_id='.$employee_id;
		$pdf=exec('/usr/local/bin/wkhtmltopdf --page-size A4 --print-media-type --include-in-outline '.$generatePdfUrl.' '.$target_file.' 2>&1');
		if(!$pdf) {
			$_SESSION['experience_certificate_error'] = 'Failed to generate Experience Certificate pdf. Its seems you have not installed WKHTMLTOPDF on server or on local machine also enable exec function of php if it is in disbaled list.';
			header('location:experienceCertificate');
			die();
		}
		$_SESSION['experience_certificate_success'] = 'success';
		if($_POST["saveExperienceCertificate"] == 'Print') {
			header('Location:generateExperienceCertificate.php?print_experience='.$employee_id);
		} else {
			header("Location: experienceCertificate");
		}
	}
	
}
if (isset($_POST["experience_employee_id"])) {
	$experience_employee_id = mysqli_real_escape_string($DBManager->conn, $_POST['experience_employee_id']);
	// echo $permanent_employee_id;
	// die();
	$total = $appointmentManager->checkExperienceCertificateExists($experience_employee_id);
	if($total == 0) {
		echo $total;
	} else {
		foreach ($total as $key => $value) {
			echo $value;
		}
	}
}