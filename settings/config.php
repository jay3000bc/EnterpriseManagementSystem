<?php

	/* database credientails */
		$host = 'localhost'; /* mysql server name default is localhost */
		$databaseName = 'alegra6_mukesh'; /* Database to be used */
		$databaseUser = 'alegra6_mukesh'; /* Database username */
		$databasePassword = 'muk797'; /* Database  password */
	/* end */

	// Path of target folder  where you will install EMS 

	$absoluteUrl = 'http://alegralabs.com/mukesh/EMS-v1.2/';

	// EMS email address for all out going emails

	$fromEMS = 'adminems@alegralabs.com';

	// working hours a day for the employees default is 8, you can change it according to your company

	$WorkingHoursPerDay = 8;

	// Email sent to Employee for payslip boolean value, default is true

	$sendEmailToEmployee = true;

	//Subject of email, sent to employee for salary credit form EMS system

	$payslipSubject = "Salary Credited";

	// list of currencies used in EMS

	$currencies = array("rupee"=>"&#8377;", "dollar"=>"&#36;", "pound"=>"&#163;", "euro"=>"&#8364;");

	//invoice type selectbox options
	
	$invoiceTypes = array("National Invoice", "Export Invoice");

	
	// Email sent to Client for Invoice details boolean value, default is true

	$sendEmailToClient = true;

	//Subject of email, sent to client for Invoice details form EMS system

	$invoiceSubject = "Invoice Details";

	//subject of email sent from EMS for change Password 

	$resetPasswordSubject = 'Reset Password Request';

	// List of designation in the company for employee

	$arrayDesignations = array('Junior Programmer', 'Associate Programme', 'Senior Programmer', 'Team Leader', 'Project Manager');

	//  footer format text with tags

	$footerMessage = '<strong>Copyright &copy; 2017-2018.</strong> All rights reserved.';

	// Salary pay currency type

	$salaryPayCurrency = '&#8377;';

	
?>