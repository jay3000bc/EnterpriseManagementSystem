<?php
// header
//$fromEMS = 'adminems@enterhelix.com';
$from  = 'MIME-Version: 1.0' . "\r\n";
$from .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$from .= 'From: '.$fromEMS."\r\n".
'Reply-To: '.$fromEMS."\r\n" .
'X-Mailer: PHP/' . phpversion();
// end header
$message = '<html><body>';
$message .= '<p class="alert alert-info text-center">'.$companyInfo['company_name'].' </p>';
$message .= '<p>Hi '.$name.',</p>';

$message .= '<p>You recently requested to reset your password for your '.$companyInfo['company_name'].' account. Use the link below to reset it. This password reset is only valid for the next 24 hours</p>';
$message .='<a class="btn btn-success" href="'.$absoluteUrl.'resetPassword.php?token='.$token.'">Reset your password</a>';
$message .= '<p>For security, this request was received from a '.$operatingSystem.' device using '.$browserName.'. If you did not request a password reset, please ignore this email or <a href="www.enterhelix.com/support">Contact Support</a> if you have questions.</p>';
$message .= '<p>Thanks<br>'.$companyInfo['company_name'].'</p>';
$message .= '</body></html>';
?>
