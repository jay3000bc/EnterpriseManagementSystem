<?php

	/* database credientails */
		$host = 'localhost'; /* mysql server name default is localhost */
		$databaseName = ''; /* Database to be used */
		$databaseUser = ''; /* Database username */
		$databasePassword = ''; /* Database  password */
	/* end */

	// Path of target folder  where you will install EMS. (say) if your site is http://www.example.com
	// and you install EMS inside a folder called "ems". Than $absoluteUrl will be http://www.example.com/ems 

	$absoluteUrl = 'https://www.alegralabs.com/ems/';

	// EMS email address for all out going emails

	$fromEMS = 'admin@alegralabs.com';

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


	//Subject of email, sent to client for Invoice details form EMS system

	$invoiceSubject = "Invoice Details";

	//subject of email sent from EMS for change Password 

	$resetPasswordSubject = 'Reset Password Request';

	// List of designation in the company for employee

	$arrayDesignations = array('Managing Director','Chief Operating Officer', 'Financial Analyst','Associate Director','HR-Manager','Project Manager','Team Leader','Senior Programmer','Associate Programmer','System Administrator','Junior Programmer','Accountant','Peon','Driver');

	//  footer format text with tags

	$footerMessage = '<strong>Copyright &copy; &lt;ALEGRA LABS /&gt;<sup>TM</sup> 2017-2018.</strong> All rights reserved.';

	// Salary pay currency type

	$salaryPayCurrency = '&#8377;';

	// Set dashboard logo size

	$dasboardLogoSize = 'width:80%;';

?>