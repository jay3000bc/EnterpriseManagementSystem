<?php
include_once('settings/config.php');
$invoice_id = 1;
$generatePdfUrl = $absoluteUrl."generateInvoice.php?invoice_id=".$invoice_id;
$pdf=exec('/usr/local/bin/wkhtmltopdf --page-size A4 --print-media-type --include-in-outline  "'.$generatePdfUrl.'" uploads/invoices/createdInvoice/'.$invoice_id.'.pdf 2>&1');
if($pdf) {
	echo "success";
}
else {
	echo "Fail";
}
?>