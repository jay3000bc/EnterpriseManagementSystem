<?php
// header
$from  = 'MIME-Version: 1.0' . "\r\n";
$from .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$from .= 'From: '.$fromEMS."\r\n".
'Reply-To: '.$fromEMS."\r\n" .
'X-Mailer: PHP/' . phpversion();
// end header
$message = '<html><body>';
$message .= '<p>Dear '.$client_name.',</p>';
$message .= '<p>Please find your attachment invoice # '.$invoice_id.'.</p>';
$message .= '<p>Invoice Date: '.$invoice_date.'.</p>';
$message .='<a href="'.$invoicelink.'">Invoice</a>';
$message .= '<p>Thanks<br>'.$companyInfo['company_name'].'</p>';
$message .= '</body></html>';
?>
