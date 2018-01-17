<?php

	/* database creadientails web */
	// $host = 'localhost'; /* mysql server name default is localhost */
	// $databaseName = 'mukesh'; /* Database to be used */
	// $databaseUser = 'mukesh'; /* Database username */
	// $databasePassword = 'MKUghy49'; /* Database  password */
	/* end */
	/* database creadientails local */
	$host = 'localhost'; /* mysql server name default is localhost */
	$databaseName = 'ems'; /* Database to be used */
	$databaseUser = 'root'; /* Database username */
	$databasePassword = ''; /* Database  password */
	/* end */
	// EMS email address for all out going emails

	$fromEMS = 'adminems@enterhelix.com';

	// working hours a day for the employees

	$WorkingHoursPerDay = 8;

	//subject of email to employee for salary credit form EMS sysytem

	$payslipSubject = "Salary Credited";

	// list of currencies used in EMS

	$currencies = array("rupee"=>"&#8377;", "dollar"=>"&#36;", "pound"=>"&#163;", "euro"=>"&#8364;");

	//invoice type selectbox options
	
	$invoiceTypes = array("National Invoice", "Export Invoice");

	//subject of email sent to client form EMS system

	$invoiceSubject = "Invoice Details";

	//subject of email sent from EMS for change Password 

	$resetPasswordSubject = 'Reset Password Request';
	$arrayDesignations = array('Junior Programmer', 'Associate Programme', 'Senior Programmer', 'Team Leader', 'Project Manager');

	// footer format text with tags

	$footerMessage = '<strong>Copyright &copy; 2017-2018.</strong> All rights reserved.';

	$salaryPayCurrency = '&#8377;';

	// target folder name/path name where you will install EMS 
	//$relativeUrl = 'http://www.enterhelix.com/ems/';
	$relativeUrl = 'http://ems.localhost/';
?>