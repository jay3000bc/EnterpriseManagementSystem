<?php 
$term = trim(strip_tags($_GET['term'])); 
include_once 'InvoiceManager.php';
$invoiceManager = new InvoiceManager();
$result = $invoiceManager->listDescOfServices($term);
echo json_encode($result);
?>