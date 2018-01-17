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
		$pdf=exec('/usr/local/bin/wkhtmltopdf --page-size A4 --print-media-type --include-in-outline  http://www.enterhelix.com/mukesh/ems/generateGST.php?period='.$period.' ../ems/uploads/GST/'.$period.'.pdf 2>&1');
		//generate xl file
        include_once 'generateGSTXL.php';
        
        //end
		if($_POST["generateGST"] == 'Print') {
			header('location:generateGST.php?period_print='.$period);
		} else {
			header('location:viewGST.php?period='.$period);
		}
		
	}
	else {
		$_SESSION['GSTMessage'] = 'fail';
		header('viewGST.php?period='.$period);
	}
}