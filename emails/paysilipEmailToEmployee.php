<?php
// mail header
$paysilipHeaders  = 'MIME-Version: 1.0' . "\r\n";
$paysilipHeaders .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

$paysilipHeaders .= 'From: '.$fromEMS."\r\n".'Reply-To: '.$fromEMS."\r\n" .'X-Mailer: PHP/' . phpversion();
// end header
$lastMonth = date("F Y",strtotime("-1 month"));
$pdf_link = $absoluteUrl.$target_file;
$paysilipMessage = '<html><body>';

$paysilipMessage .= '<p>Dear '.$name.',</p>';

$paysilipMessage .= '<p>Salary for the month of '.$lastMonth.' has been credited (will be credited) to your Bank A/c # ' .$bankAccount.'</p>';
$paysilipMessage .='<p>Click the link below for the Payslip.</p>';
$paysilipMessage .= '<a href="'.$pdf_link.'">View Paysilip</a>';
$paysilipMessage .= '<p>Thanks<br>'.$companyInfo['company_name'].'</p>';
$paysilipMessage .= '</body></html>';
?>