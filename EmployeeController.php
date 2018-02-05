<?php
session_start();
include_once 'DBManager.php';
$DBManager = new DBManager();
include_once 'EmployeeManager.php';
include_once 'Validate.php';
if (isset($_POST["saveEmployeeDetails"])) {
    $employeeManager = new EmployeeManager();
    foreach( $_POST as $key => $value )
    {
        $key = 'session_'.$key;
        $_SESSION[$key] = $value;
    }
    $employee_id = mysqli_real_escape_string($DBManager->conn, $_POST['employee_id']);
    $email = mysqli_real_escape_string($DBManager->conn, $_POST['email']);
    $check_email_unique_result = $employeeManager->checkUnique($email, 'email');
    if($check_email_unique_result > 0 ) {
        $_SESSION['ErrorMsg'] = "Email already exist. Please try another.";
        header('Location:createEmployee');
        die();
    }
    $phone_no = mysqli_real_escape_string($DBManager->conn, $_POST['phone_no']);
    $check_phone_unique_result = $employeeManager->checkUnique($phone_no, 'phone_no');
    if($check_phone_unique_result > 0 ) {
        $_SESSION['ErrorMsg'] = "Phone number already exist. Please try another.";
        header('Location:createEmployee');
        die();
    }
    $name = mysqli_real_escape_string($DBManager->conn, $_POST['name']);
    $page_name = mysqli_real_escape_string($DBManager->conn, $_POST['page_name']);
    $designation = mysqli_real_escape_string($DBManager->conn, $_POST['designation']);
    $password = mysqli_real_escape_string($DBManager->conn, $_POST['password']);
    $encryptpassword = md5($password);
    /*image upload*/
    if($_FILES["photo"]['name'][0] != '') {
        $target_dir = "uploads/employee/images/";
        $target_file = $target_dir . basename($_FILES["photo"]["name"]);
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        $check = getimagesize($_FILES["photo"]["tmp_name"]);
        // Check if image file is a actual image or fake image
        if ($check == false) {
            $_SESSION['ErrorMsg'] = "File is not an image.";
            header('Location:createEmployee');
        }
        // Check if file already exists
        elseif (file_exists($target_file)) {
            //echo "string"; die();
            $_SESSION['ErrorMsg'] = "Sorry, image file already exists.";
            header('Location:createEmployee');
            exit();
        } 
         // Check file size
        elseif ($_FILES["photo"]["size"] > 5242880) {
            $_SESSION['ErrorMsg'] = "Sorry, image file is too large. Maximum file size must be less than 5MB.";
            header('Location:createEmployee');
            exit();
        }
        // Allow certain file formats
        elseif ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            $_SESSION['ErrorMsg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            header('Location:createEmployee');
            exit();
        }
        else {
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                $photo = basename($_FILES["photo"]["name"]);
                $_SESSION['session_photo_name'] = $photo;
                //die();
            } else {
                $_SESSION['ErrorMsg'] = "Sorry, there was an error uploading your file.";
                header('Location:createEmployee');
                exit();

            }
        }
    }
    else {
        $photo = 'defaultuser.png';
    } 
    $current_address = mysqli_real_escape_string($DBManager->conn, $_POST['current_address']);
    $permanent_address = mysqli_real_escape_string($DBManager->conn, $_POST['permanent_address']);
    $father_name = mysqli_real_escape_string($DBManager->conn, $_POST['father_name']);
    $gender = mysqli_real_escape_string($DBManager->conn, $_POST['gender']);
    $date_of_joining = mysqli_real_escape_string($DBManager->conn, $_POST['date_of_joining']);
    $date_of_birth = mysqli_real_escape_string($DBManager->conn, $_POST['date_of_birth']);
    $pf_account = mysqli_real_escape_string($DBManager->conn, $_POST['pf_account']);
    $policy_no = mysqli_real_escape_string($DBManager->conn, $_POST['policy_no']);
    $lic_id = mysqli_real_escape_string($DBManager->conn, $_POST['lic_id']);
    $pan = mysqli_real_escape_string($DBManager->conn, $_POST['pan']);
    $check_pan_unique_result = $employeeManager->checkUnique($pan, 'pan');
    if($check_pan_unique_result > 0 ) {
        $_SESSION['ErrorMsg'] = "PAN already exist..";
        header('Location:createEmployee');
        die();
    }
    $passport_no = mysqli_real_escape_string($DBManager->conn, $_POST['passport_no']);
    $driving_license_no = mysqli_real_escape_string($DBManager->conn, $_POST['driving_license_no']);
    $bank_account = mysqli_real_escape_string($DBManager->conn, $_POST['bank_account']);
    $check_bank_account_unique_result = $employeeManager->checkUnique($bank_account, 'bank_account');
    if($check_bank_account_unique_result > 0 ) {
        $_SESSION['ErrorMsg'] = "Bank Account already exist.";
        header('Location:createEmployee');
        die();
    }
    $ifsc_code = mysqli_real_escape_string($DBManager->conn, $_POST['ifsc_code']);

    $result = $employeeManager->CreateEmployee($employee_id, $name, $designation, $email, $phone_no, $encryptpassword, $photo, $current_address, $permanent_address, $father_name, $gender, $date_of_joining, $date_of_birth, $pf_account, $policy_no, $lic_id, $pan, $passport_no, $driving_license_no, $bank_account, $ifsc_code);
    if($result) {
        $_SESSION['successMsg'] = "employeeAdded";
        foreach( $_POST as $key => $value )
        {
            $key = 'session_'.$key;
            unset($_SESSION[$key]);
            
        } 
        unset($_SESSION['session_photo_name']);
        header('Location:viewEmployees');
    }
    else {
        $_SESSION['ErrorMsg'] = "Enable to Create Employee";
         header('Location:createEmployee');
    }
}
// update employee profile  details   
if(isset($_POST['saveEditEmployeeDetails'])) {

    $id = mysqli_real_escape_string($DBManager->conn, $_POST['id']);
    $employeeManager = new EmployeeManager();
    
    $employee_id = mysqli_real_escape_string($DBManager->conn, $_POST['employee_id']);
    $email = mysqli_real_escape_string($DBManager->conn, $_POST['email']);
    $getExistEmail = $employeeManager->editCheckUnique($id, 'email');
    
    if($getExistEmail['email'] != $email ) {
        $check_email_unique_result = $employeeManager->checkUnique($email, 'email');
        if($check_email_unique_result > 0 ) {
            $_SESSION['ErrorMsg'] = "Email already exist. Please try another.";
            header('Location:editEmployee?id='.$id);
            die();
        }
    }
    $phone_no = mysqli_real_escape_string($DBManager->conn, $_POST['phone_no']);
    
    $getExistPhone = $employeeManager->editCheckUnique($id, 'phone_no');
    if($getExistPhone['phone_no'] != $phone_no ) {
        $check_phone_unique_result = $employeeManager->checkUnique($phone_no, 'phone_no');
        if($check_phone_unique_result > 0 ) {
            $_SESSION['ErrorMsg'] = "Phone number already exist. Please try another.";
            header('Location:editEmployee?id='.$id);
            die();
        }
    }
    $name = mysqli_real_escape_string($DBManager->conn, $_POST['name']);
    $page_name = mysqli_real_escape_string($DBManager->conn, $_POST['page_name']);
    $designation = mysqli_real_escape_string($DBManager->conn, $_POST['designation']);
    if(isset($_POST['password'])) {
        $password = mysqli_real_escape_string($DBManager->conn, $_POST['password']);
        $encryptpassword = md5($password);
    } else {
        $encryptpassword = '';
    }    
    $oldPhoto = mysqli_real_escape_string($DBManager->conn, $_POST['oldPhoto']);
    /*image upload*/
    if($_FILES["photo"]['name'][0] != '') {
        //echo "string";die();
        $target_dir = "uploads/employee/images/";
        $target_file = $target_dir . basename($_FILES["photo"]["name"]);
        //echo $target_file; die();
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        $check = getimagesize($_FILES["photo"]["tmp_name"]);
        // Check if image file is a actual image or fake image
        if ($check == false) {
            $_SESSION['ErrorMsg'] = "File is not an image.";
            header('Location:editEmployee?id='.$id);
        }
        // Check if file already exists
        elseif (file_exists($target_file)) {
            //echo "string"; die();
            $_SESSION['ErrorMsg'] = "Sorry, image file already exists.";
            header('Location:editEmployee?id='.$id);
            exit();
        } 
         // Check file size
        elseif ($_FILES["photo"]["size"] > 5242880) {
            $_SESSION['ErrorMsg'] = "Sorry, image file is too large. Maximum file size must be less than 5MB.";
            header('Location:editEmployee?id='.$id);
            exit();
        }
        // Allow certain file formats
        elseif ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            $_SESSION['ErrorMsg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            header('Location:editEmployee?id='.$id);
            exit();
        }
        else {
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                unlink( 'uploads/employee/images/'.$oldPhoto );
                $photo = basename($_FILES["photo"]["name"]);
                //die();
            } else {
                $_SESSION['ErrorMsg'] = "Sorry, there was an error uploading your file.";
                header('Location:editEmployee?id='.$id);
                exit();

            }
        }
    }
    else {
        $photo = $oldPhoto;
    } 
    $current_address = mysqli_real_escape_string($DBManager->conn, $_POST['current_address']);
    $permanent_address = mysqli_real_escape_string($DBManager->conn, $_POST['permanent_address']);
    $father_name = mysqli_real_escape_string($DBManager->conn, $_POST['father_name']);
    $gender = mysqli_real_escape_string($DBManager->conn, $_POST['gender']);
    $date_of_joining = mysqli_real_escape_string($DBManager->conn, $_POST['date_of_joining']);
    $date_of_birth = mysqli_real_escape_string($DBManager->conn, $_POST['date_of_birth']);
    $pf_account = mysqli_real_escape_string($DBManager->conn, $_POST['pf_account']);
    $policy_no = mysqli_real_escape_string($DBManager->conn, $_POST['policy_no']);
    $lic_id = mysqli_real_escape_string($DBManager->conn, $_POST['lic_id']);
    $pan = mysqli_real_escape_string($DBManager->conn, $_POST['pan']);

    $getExistPAN = $employeeManager->editCheckUnique($id, 'pan');
    if($getExistPAN['pan'] != $pan ) {
        $check_pan_unique_result = $employeeManager->checkUnique($pan, 'pan');
        if($check_pan_unique_result > 0 ) {
            $_SESSION['ErrorMsg'] = "PAN already exist..";
            header('Location:editEmployee?id='.$id);
            die();
        }
    }    
    $passport_no = mysqli_real_escape_string($DBManager->conn, $_POST['passport_no']);
    $driving_license_no = mysqli_real_escape_string($DBManager->conn, $_POST['driving_license_no']);
    $bank_account = mysqli_real_escape_string($DBManager->conn, $_POST['bank_account']);

    $getExistAC = $employeeManager->editCheckUnique($id, 'bank_account');
    if($getExistAC['bank_account'] != $bank_account ) {
        $check_bank_account_unique_result = $employeeManager->checkUnique($bank_account, 'bank_account');
        if($check_bank_account_unique_result > 0 ) {
            $_SESSION['ErrorMsg'] = "Bank Account already exist.";
            header('Location:editEmployee?id='.$id);
            die();
        }
    }
    $ifsc_code = mysqli_real_escape_string($DBManager->conn, $_POST['ifsc_code']);



    $result = $employeeManager->editEmployee($id, $employee_id, $name, $designation, $email, $phone_no, $encryptpassword, $photo, $current_address, $permanent_address, $father_name, $gender, $date_of_joining, $date_of_birth, $pf_account, $policy_no, $lic_id, $pan, $passport_no, $driving_license_no, $bank_account, $ifsc_code);
    if($result) {
        if(isset($_POST['profile_update_request'])) {
            $resultProfileRequestUpdate = $employeeManager->deleteProfileUpdateRequest($_POST['profile_update_request']);
        }
        $_SESSION['successMsg'] = "employeeEdited";
        header('Location:viewEmployees');
    }
    else {
        $_SESSION['ErrorMsg'] = "Enable to Edit Employee";
        header('Location:editEmployee?id='.$id);
        die();
    }
}

if(isset($_POST['check_employee_id'])) {
    //$con = new DBManager();
    $check_employee_id = mysqli_real_escape_string($DBManager->conn, $_POST['check_employee_id']);
    $employeeManager = new EmployeeManager();
    echo $result = $employeeManager->checkEmployeeIdExists($check_employee_id);

}
if(isset($_POST['deleteEmployee'])) {
    $deleteEmployee = mysqli_real_escape_string($DBManager->conn, $_POST['deleteEmployee']);
    $employeeManager = new EmployeeManager();
    echo $result = $employeeManager->deleteEmployee($deleteEmployee);
}
if(isset($_POST['db_id'])) {
    $db_id = mysqli_real_escape_string($DBManager->conn, $_POST['db_id']);
    $employeeManager = new EmployeeManager();
    echo $result = $employeeManager->deletePhoto($db_id);
}
if(isset($_POST['manageEmployeeIdForm'])) {
    $type = mysqli_real_escape_string($DBManager->conn, $_POST['type']);
    $employeeManager = new EmployeeManager();
    $totalEmployee = $employeeManager->listEmployees();
    $result = $employeeManager->manageEmployeeId($type, $totalEmployee);
    if($result) {
        $_SESSION['employeeIdTypeSelected'] = "employeeIdTypeSelected";
        header('Location:createEmployee');
    }
    else {
        header('Location:manageEmployeeId.php');
    }
}
if(isset($_POST['find_employee_name_list'])) {
    $searchKey = mysqli_real_escape_string($DBManager->conn, $_POST['find_employee_name_list']); 
    $employeeManager = new EmployeeManager();
    $listEmployeeName = $employeeManager->listEmployeesName($searchKey);
    echo json_encode($listEmployeeName);
}
if(isset($_POST['status']) and isset($_POST['id'])) {
    $id = mysqli_real_escape_string($DBManager->conn, $_POST['id']);
    $status = mysqli_real_escape_string($DBManager->conn, $_POST['status']);  
    $employeeManager = new EmployeeManager();
    echo $result = $employeeManager->changeEmployeeStatus($id, $status);
}
// employee login 
if (isset($_POST["loginForm"])) {
    $employeeLoginForm = new EmployeeManager();
    $email = mysqli_real_escape_string($DBManager->conn, $_POST['email']);
    $password = mysqli_real_escape_string($DBManager->conn, $_POST['password']);
    $encryptpassword = md5($password);
    $result = $employeeLoginForm->loginRequest($email, $encryptpassword);
}

// check_already_exist_value
if(isset($_POST['check_already_exist_value'])) {
    $employeeManager = new EmployeeManager();
    $value = mysqli_real_escape_string($DBManager->conn, $_POST['check_already_exist_value']);
    $field_name = mysqli_real_escape_string($DBManager->conn, $_POST['field_name']);
    echo $result = $employeeManager->check_already_exist_value($value, $field_name);
}