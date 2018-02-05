<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Asia/Kolkata');
$current_date = time();
$microtime = microtime(true);
session_start();
include_once 'DBManager.php';
$DBManager = new DBManager();
include_once 'ClientManager.php';
$clientManager = new ClientManager();
//include_once 'validate.php';
// save Client id type
if(isset($_POST['manageClientIdForm'])) {
    $type = mysqli_real_escape_string($DBManager->conn, $_POST['type']);
    $result = $clientManager->manageClientId($type);
    if($result) {
        $_SESSION['ClientIdTypeSelected'] = "ClientIdTypeSelected";
        header('Location:createClient');
        die();
    }
    else {
        header('Location:manageClientId.php');
        die();
    }
}

if(isset($_POST['saveClientDetails'])) {
    foreach( $_POST as $key => $value )
    {
        $key = 'session_client_'.$key;
        $_SESSION[$key] = $value;
    }
    $client_id = mysqli_real_escape_string($DBManager->conn, $_POST['client_id']);
    $name = mysqli_real_escape_string($DBManager->conn, $_POST['name']);
    $country = mysqli_real_escape_string($DBManager->conn, $_POST['country']);
    $email = mysqli_real_escape_string($DBManager->conn, $_POST['email']);
    $phone_no = mysqli_real_escape_string($DBManager->conn, $_POST['phone_no']);
    $address = mysqli_real_escape_string($DBManager->conn, $_POST['address']);
    $state = '';
    $gstin= '';
    if(isset($_POST['state'])) {
        $state = mysqli_real_escape_string($DBManager->conn, $_POST['state']);
        $gstin = mysqli_real_escape_string($DBManager->conn, $_POST['gstin']);
    }
    $created_at = date("d/m/Y",$current_date);
    // echo $_FILES["photo"]['name'];
    // die();
    /*image upload*/
    if($_FILES["photo"]['name'] != '') {
        //echo "string";die();
        $target_dir = "uploads/client_image/";
        $target_file = $target_dir . $microtime . basename($_FILES["photo"]["name"]);
        //echo $target_file; die();
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        $check = getimagesize($_FILES["photo"]["tmp_name"]);
        // Check if image file is a actual image or fake image
        if ($check == false) {
            $_SESSION['ErrorMsg'] = "File is not an image.";
            header('Location:createClient');
        }
        // Check if file already exists
        elseif (file_exists($target_file)) {
            //echo "string"; die();
            unlink($target_file);
        } 
         // Check file size
        elseif ($_FILES["photo"]["size"] > 5242880) {
            $_SESSION['ErrorMsg'] = "Sorry, image file is too large. Maximum file size must be less than 5kb.";
            header('Location:createClient');
            exit();
        }
        // Allow certain file formats
        elseif ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            $_SESSION['ErrorMsg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            header('Location:createClient');
            exit();
        }
        else {
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                $photo = $microtime . basename($_FILES["photo"]["name"]);
                $_SESSION['session_client_photo_name'] = $photo;
                //die();
            } else {
                $_SESSION['ErrorMsg'] = "Sorry, there was an error uploading your file.";
                header('Location:createClient');
                exit();

            }
        }
    }
    else {
        $photo = 'defaultuser.png';
    }

    $result1 = $clientManager->saveClientDetails($client_id, $name, $country, $state, $gstin, $email, $phone_no,  $address, $photo, $created_at );
    $_SESSION['session_no_of_project'] = count($_POST['project_title']);
    foreach ($_POST['project_title'] as $key => $value) {
        $session_key = 'session_client_project_title_'.$key;
        $_SESSION[$session_key] = mysqli_real_escape_string($DBManager->conn, $_POST['project_title'][$key]);
        $session_key = 'session_client_project_desc_'.$key;
        $_SESSION[$session_key] = mysqli_real_escape_string($DBManager->conn, $_POST['project_description'][$key]);
            $project_title = mysqli_real_escape_string($DBManager->conn, $_POST['project_title'][$key]);
            $project_description = mysqli_real_escape_string($DBManager->conn, $_POST['project_description'][$key]);
       $result2 = $clientManager->saveClientProjects($client_id, $project_title, $project_description, $created_at );

    }

    if($result1 && $result2) {
        $_SESSION['successMsg'] = "clientAdded";
        foreach( $_POST as $key => $value )
        {
                $key = 'session_client_'.$key;
                unset($_SESSION[$key]); 
        }
        unset($_SESSION['session_client_photo_name']);
        unset($_SESSION['session_no_of_project']);
        header('Location:viewClients');
        die();
    }
    else {
        $_SESSION['ErrorMsg'] = "Opps Something went Wrong.";
        header('Location:createClient');
        die();
    }
    
}
// Edit Client Details
if(isset($_POST['editClientDetails'])) {
    $client_id = mysqli_real_escape_string($DBManager->conn, $_POST['client_id']);
    $name = mysqli_real_escape_string($DBManager->conn, $_POST['name']);
    $country = mysqli_real_escape_string($DBManager->conn, $_POST['country']);
    $email = mysqli_real_escape_string($DBManager->conn, $_POST['email']);
    $phone_no = mysqli_real_escape_string($DBManager->conn, $_POST['phone_no']);
    $address = mysqli_real_escape_string($DBManager->conn, $_POST['address']);
    $state = '';
    $gstin= '';
    if(isset($_POST['state'])) {
        $state = mysqli_real_escape_string($DBManager->conn, $_POST['state']);
        $gstin = mysqli_real_escape_string($DBManager->conn, $_POST['gstin']);
    }
    $oldPhoto = mysqli_real_escape_string($DBManager->conn, $_POST['oldPhoto']);
    /*image upload*/
    if($_FILES["photo"]['name'][0] != '') {
        //echo "string";die();
        $target_dir = "uploads/client_image/";
        $target_file = $target_dir . basename($_FILES["photo"]["name"]);
        //echo $target_file; die();
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        $check = getimagesize($_FILES["photo"]["tmp_name"]);
        // Check if image file is a actual image or fake image
        if ($check == false) {
            $_SESSION['ErrorMsg'] = "File is not an image.";
            header('Location:editClient?client_id='.$client_id);
        }
        // Check if file already exists
        elseif (file_exists($target_file)) {
            //echo "string"; die();
            unlink($target_file);
        } 
         // Check file size
        elseif ($_FILES["photo"]["size"] > 5242880) {
            $_SESSION['ErrorMsg'] = "Sorry, image file is too large. Maximum file size must be less than 5kb.";
            header('Location:editClient?client_id='.$client_id);
            exit();
        }
        // Allow certain file formats
        elseif ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            $_SESSION['ErrorMsg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            header('Location:editClient?client_id='.$client_id);
            exit();
        }
        else {
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                $photo = basename($_FILES["photo"]["name"]);
                //die();
            } else {
                $_SESSION['ErrorMsg'] = "Sorry, there was an error uploading your file.";
                header('Location:editClient?client_id='.$client_id);
                exit();

            }
        }
    }
    else {
        $photo = $oldPhoto;
    }
    $result1 = $clientManager->editClientDetails($client_id, $name, $country, $state, $gstin, $email, $phone_no,  $address, $photo);
    if(isset($_POST['project_title'])) {
        foreach ($_POST['project_title'] as $key => $value) {
           $project_title = mysqli_real_escape_string($DBManager->conn, $_POST['project_title'][$key]);
           $project_description = mysqli_real_escape_string($DBManager->conn, $_POST['project_description'][$key]);
           $project_id = mysqli_real_escape_string($DBManager->conn, $_POST['project_id'][$key]);
           $result2 = $clientManager->editClientProjects($client_id, $project_title, $project_description, $project_id);

        }
    }
    $created_at = date("d/m/Y",$current_date);
    if(isset($_POST['project_title_clone'])) {
        foreach ($_POST['project_title_clone'] as $key => $value) {
           $project_title = mysqli_real_escape_string($DBManager->conn, $_POST['project_title_clone'][$key]);
           $project_description = mysqli_real_escape_string($DBManager->conn, $_POST['project_description_clone'][$key]);
           $result3 = $clientManager->saveClientProjects($client_id, $project_title, $project_description, $created_at );

        }
    }    
    if($result1) {

        $_SESSION['successMsg'] = "clientEdited";
        header('Location:viewClients');
    }
    else {
        $_SESSION['ErrorMsg'] = "Opps Something went Wrong.";
        header('Location:editClient?client_id='.$client_id);
    }
}
// change project status
if(isset($_POST['project_status'])) {
    $id = mysqli_real_escape_string($DBManager->conn, $_POST['id']);
    $project_status = mysqli_real_escape_string($DBManager->conn, $_POST['project_status']);
    $client_id = mysqli_real_escape_string($DBManager->conn, $_POST['client_id']);
    $ended_at = date("d/m/Y",$current_date);
    echo $result = $clientManager->changeProjectStatus($id, $project_status, $ended_at, $client_id);
    die();
}
// delete project
if(isset($_POST['project_id'])) {
    $project_id = mysqli_real_escape_string($DBManager->conn, $_POST['project_id']);
    echo $result = $clientManager->deleteProject($project_id);
    die();
}
// delete client
if(isset($_POST['client_id'])) {
    $client_id = mysqli_real_escape_string($DBManager->conn, $_POST['client_id']);
    //$result = $clientManager->deleteProject($project_id);
    echo $result = $clientManager->deleteClient($client_id);
    die();
}
// check_already_exist_client
if(isset($_POST['check_already_exist_client'])) {
    $clientManager = new ClientManager();
    $field_value = mysqli_real_escape_string($DBManager->conn, $_POST['check_already_exist_client']);
    $field_name = mysqli_real_escape_string($DBManager->conn, $_POST['field_name']);
    echo $result = $clientManager->check_already_exist_client($field_value, $field_name);
}