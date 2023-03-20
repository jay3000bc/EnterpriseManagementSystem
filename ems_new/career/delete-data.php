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

$delete_id = sanitize($id);


$file = $db->query("SELECT * FROM recruit_application WHERE id = '$delete_id'");
$fileName = mysqli_fetch_assoc($file);

// $file_Name = $fileName['resume'];
// $fileRoot = $_SERVER['DOCUMENT_ROOT']."/career/resume_application/".$file_Name;
// unlink($fileRoot);

$deleted_data = "DELETE FROM recruit_application WHERE id = '$delete_id' ";
$delete_applicant = $db->query($deleted_data);

if ($delete_applicant) {
	$status = "success";
    $message = "Data Deleted";	
}else{
	$status = "fail";
    $message = "Please reload your page then try aain";
}

$obj = new stdClass();  // creation of object
$obj->status = $status;
$obj->message = $message;
echo json_encode($obj);
