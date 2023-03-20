<?php 
require_once 'database.php';

function sanitize($dirty){
    global $db;
    return trim(mysqli_real_escape_string($db, $dirty));
}

$status = $message = "";

$params = file_get_contents('php://input');
$json = json_decode($params);

$id = $json->deleteid;

$id = sanitize($id);


$candidateDetails = $db->query("SELECT * FROM recruit_application WHERE id = '$id'");

$candidateDetails = mysqli_fetch_assoc($candidateDetails);

	$status = "success";
    $message = "Data Deleted";	


// $obj = new stdClass();  // creation of object
// $obj->status = $candidateDetails['full_name'];
// $obj->message = $message;
echo json_encode($candidateDetails);
