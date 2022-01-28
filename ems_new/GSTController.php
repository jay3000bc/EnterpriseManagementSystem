<?php
session_start();
date_default_timezone_set('Asia/Kolkata');
include_once('settings/config.php');
include_once 'DBManager.php';
$DBManager = new DBManager();
include_once 'GSTManager.php';
if (isset($_POST["generateGST"])) {
    $GSTManager = new GSTManager();
    $period = mysqli_real_escape_string($DBManager->conn, $_POST['period']);
    $status = 1;
    $result = $GSTManager->generateGST($period, $status);
    if($result) {
    	$_SESSION['GSTMessage'] = 'success';
    	// GENERATE PDF
		$generatePdfUrl = $absoluteUrl.'generateGST.php?period='.$period;
		$pdf=exec('/usr/local/bin/wkhtmltopdf --page-size A4 --print-media-type --include-in-outline --encoding UTF-8 '.$generatePdfUrl.' uploads/GST/'.$period.'.pdf 2>&1');
		if(!$pdf) {
			$_SESSION['ErrorMsgGST'] = 'Failed to generate Invoice pdf. Its seems you have not installed WKHTMLTOPDF on server or on local machine also enable exec function of php if it is in disbaled list.';
			header('viewGST?period='.$period);
		}
		//generate xl file
        include_once 'generateGSTXL.php';
        
        //end
		if($_POST["generateGST"] == 'Print') {
			header('location:generateGST.php?period_print='.$period);
		} else {
			header('location:viewGST?period='.$period);
		}
		
	}
	else {
		$_SESSION['GSTMessage'] = 'fail';
		header('viewGST?period='.$period);
	}
}