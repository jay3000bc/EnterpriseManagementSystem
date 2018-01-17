<?php 
$term = trim(strip_tags($_GET['term'])); 
//ini_set('display_errors', 1);
include_once 'ClientManager.php';
$clientManager = new ClientManager();
$result = $clientManager->listClientName($term);
echo json_encode($result);
?>