<?php 
session_start();
date_default_timezone_set('Asia/Kolkata');
$current_date = time();
include_once 'DBManager.php';
$DBManager = new DBManager();
include_once 'EvaluateDaysManager.php';
$evaluateDaysManager = new EvaluateDaysManager();

if (isset($_POST["weekly_day_selected"]) || isset($_POST["status"])) {
  
	if (isset($_POST["status"])) {
    	$status = mysqli_real_escape_string($DBManager->conn, $_POST['status']);
    	$result1 = $evaluateDaysManager->savePayCutoffStatus($status);
    }	
   
    if (isset($_POST["weekly_day_selected"])) {
    	$result = $evaluateDaysManager->getWeeklyDaySelected();
	  	if($result > 0) {
	  		$deleteResult = $evaluateDaysManager->deleteWeeklyDaySelected();
	  	}
	    foreach ($_POST["weekly_day_selected"] as $key => $value) {
	    	$result2 = $evaluateDaysManager->saveWeeklyDaySelected($value);
	    }
	}    
	if($result1 || $result2) {
		echo "success";
	}
	else {
		echo "fail";
	}
}	
?> 