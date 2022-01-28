<?php
session_start();
date_default_timezone_set('Asia/Kolkata');
$microtime = microtime(true);
include_once 'DBManager.php';
$DBManager = new DBManager();
include_once 'AdminManager.php';
include_once 'LoaderManager.php';
if (isset($_POST["loginForm"])) {
    $adminLoginForm = new AdminManager();
    $username = mysqli_real_escape_string($DBManager->conn, $_POST['username']);
    $password = mysqli_real_escape_string($DBManager->conn, $_POST['password']);
    $encryptpassword = md5($password);
    if($username == 'admin') {
        $loaderManager = new LoaderManager();
        $checkSettingComplete = $loaderManager->checkSettingComplete();
        if($checkSettingComplete['status'] == 1 ) {
            $result = $adminLoginForm->loginRequest($username, $encryptpassword);
        } else {
            $_SESSION['completeSetting'] = 'Please complete setting before you login.';
            header('location:setup');
        }
        
    }
    else {
        include_once 'EmployeeManager.php';
        $employeeLoginForm = new EmployeeManager();   
        $result = $employeeLoginForm->loginRequest($username, $encryptpassword);
    }
}
if (isset($_POST["changePasswordForm"])) {
    $changePasswordForm = new AdminManager();
    $currentPassword = mysqli_real_escape_string($DBManager->conn, $_POST['currentPassword']);
    $newPassword = mysqli_real_escape_string($DBManager->conn, $_POST['newPassword']);
    $encryptCurrentPassword = md5($currentPassword);
    $encryptNewPassword = md5($newPassword);
 	$result = $changePasswordForm->ChangePassword($encryptCurrentPassword, $encryptNewPassword);
}
// update company and admin profile
if(isset($_POST['updateCompanyProfile'])) {
    $company_name = mysqli_real_escape_string($DBManager->conn, $_POST['company_name']);
    $company_address = mysqli_real_escape_string($DBManager->conn, $_POST['company_address']);
    $state = mysqli_real_escape_string($DBManager->conn, $_POST['state']);
    $contact_number = mysqli_real_escape_string($DBManager->conn, $_POST['contact_number']);
    $email = mysqli_real_escape_string($DBManager->conn, $_POST['email']);
    $crn = mysqli_real_escape_string($DBManager->conn, $_POST['crn']);
    $gstin = mysqli_real_escape_string($DBManager->conn, $_POST['gstin']);
    $pan = mysqli_real_escape_string($DBManager->conn, $_POST['pan']);
    $oldPhoto = mysqli_real_escape_string($DBManager->conn, $_POST['oldPhoto']);
    $oldLogo = mysqli_real_escape_string($DBManager->conn, $_POST['oldLogo']);
    $oldSignature = mysqli_real_escape_string($DBManager->conn, $_POST['oldSignature']);
    // Admin Image upload
    if($_FILES["photo"]['name'][0] != '') {
        $target_dir = "uploads/company_profile_images/";
        $target_file = $target_dir .$microtime. basename($_FILES["photo"]["name"]);
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        $imageFileType = strtolower($imageFileType);
        $check = getimagesize($_FILES["photo"]["tmp_name"]);
        // Check if image file is a actual image or fake image
        if ($check == false) {
            $_SESSION['photoErrorMsg'] = "File is not an image.";
            header('Location:companyProfile');
        }
        // Check if file already exists
        elseif (file_exists($target_file)) {
            //echo "string"; die();
            $_SESSION['photoErrorMsg'] = "Sorry, image file already exists.";
            header('Location:companyProfile');
            exit();
        } 
         // Check file size
        elseif ($_FILES["photo"]["size"] > 5242880) {
            $_SESSION['photoErrorMsg'] = "Sorry, image file is too large. Maximum file size must be less than 5MB.";
            header('Location:companyProfile');
            exit();
        }
        // Allow certain file formats
        elseif ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            $_SESSION['photoErrorMsg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            header('Location:companyProfile');
            exit();
        }
        else {
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                $photo = $microtime.basename($_FILES["photo"]["name"]);
                //die();
            } else {
                $_SESSION['photoErrorMsg'] = "Sorry, there was an error uploading your file.";
                header('Location:companyProfile');
                exit();

            }
        }
    }
    else {
        $photo = $oldPhoto;
    }

    // company logo upload
    if($_FILES["company_logo"]['name'][0] != '') {
        $target_dir = "uploads/company_profile_images/";
        $target_file = $target_dir .$microtime. basename($_FILES["company_logo"]["name"]);
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        $imageFileType = strtolower($imageFileType);
        $check = getimagesize($_FILES["company_logo"]["tmp_name"]);
        // Check if image file is a actual image or fake image
        if ($check == false) {
            $_SESSION['companyLogoErrorMsg'] = "File is not an image.";
            header('Location:companyProfile');
        }
        // Check if file already exists
        elseif (file_exists($target_file)) {
            //echo "string"; die();
            $_SESSION['companyLogoErrorMsg'] = "Sorry, image file already exists.";
            header('Location:companyProfile');
            exit();
        } 
         // Check file size
        elseif ($_FILES["company_logo"]["size"] > 5242880) {
            $_SESSION['companyLogoErrorMsg'] = "Sorry, image file is too large. Maximum file size must be less than 5MB.";
            header('Location:companyProfile');
            exit();
        }
        // Allow certain file formats
        elseif ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            $_SESSION['companyLogoErrorMsg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            header('Location:companyProfile');
            exit();
        }
        else {
            if (move_uploaded_file($_FILES["company_logo"]["tmp_name"], $target_file)) {
                $company_logo = $microtime.basename($_FILES["company_logo"]["name"]);
                //die();
            } else {
                $_SESSION['companyLogoErrorMsg'] = "Sorry, there was an error uploading your file.";
                header('Location:companyProfile');
                exit();

            }
        }
    }
    else {
        $company_logo = $oldLogo;
    }
    // end
    // company admin signature
    if($_FILES["signature"]['name'][0] != '') {
        $target_dir = "uploads/company_profile_images/";
        $target_file = $target_dir .$microtime. basename($_FILES["signature"]["name"]);
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        $imageFileType = strtolower($imageFileType);
        $check = getimagesize($_FILES["signature"]["tmp_name"]);
        // Check if image file is a actual image or fake image
        if ($check == false) {
            $_SESSION['companyLogoErrorMsg'] = "File is not an image.";
            header('Location:companyProfile');
        }
        // Check if file already exists
        elseif (file_exists($target_file)) {
            //echo "string"; die();
            $_SESSION['companyLogoErrorMsg'] = "Sorry, image file already exists.";
            header('Location:companyProfile');
            exit();
        } 
         // Check file size
        elseif ($_FILES["signature"]["size"] > 5242880) {
            $_SESSION['companyLogoErrorMsg'] = "Sorry, image file is too large. Maximum file size must be less than 5MB.";
            header('Location:companyProfile');
            exit();
        }
        // Allow certain file formats
        elseif ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            $_SESSION['companyLogoErrorMsg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            header('Location:companyProfile');
            exit();
        }
        else {
            if (move_uploaded_file($_FILES["signature"]["tmp_name"], $target_file)) {
                $signature = $microtime.basename($_FILES["signature"]["name"]);
                //die();
            } else {
                $_SESSION['companyLogoErrorMsg'] = "Sorry, there was an error uploading your file.";
                header('Location:companyProfile');
                exit();

            }
        }
    }
    else {
        $signature = $oldSignature;
    }

    // end
    $adminManager = new AdminManager();
    $result = $adminManager->updateCompanyProfile($company_name, $company_address, $state, $contact_number, $email, $crn, $gstin, $pan, $photo, $company_logo, $signature);
    // update sac code

    if(isset($_POST['sac'])) {
        foreach ($_POST['sac'] as $key => $value) {
            
            $sac = mysqli_real_escape_string($DBManager->conn, $_POST['sac'][$key]);
            $sac_id = mysqli_real_escape_string($DBManager->conn, $_POST['sac_id'][$key]);
            $result1 = $adminManager->updateSacCode($sac_id, $sac);
        }
    }
    // save clone SAC    
    if(isset($_POST['sac_clone'])) {
        foreach ($_POST['sac_clone'] as $key => $value) {
            $sac = mysqli_real_escape_string($DBManager->conn, $_POST['sac_clone'][$key]);
             $result2 = $adminManager->saveSacCode($sac);
        }
    }
    // update bank details 
    if(isset($_POST['bank_name'])) {
        foreach ($_POST['bank_name'] as $key => $value) {
            $bank_id = mysqli_real_escape_string($DBManager->conn, $_POST['bank_id'][$key]);
            $bank_name = mysqli_real_escape_string($DBManager->conn, $_POST['bank_name'][$key]);
            $bank_account_no = mysqli_real_escape_string($DBManager->conn, $_POST['bank_account_no'][$key]);
            $ifsc = mysqli_real_escape_string($DBManager->conn, $_POST['ifsc'][$key]);
            $result3 = $adminManager->updateBankDetails($bank_id, $bank_name, $bank_account_no, $ifsc);
        }
    }    
    // save clone bank details
    if(isset($_POST['bank_name_clone'])) {
        foreach ($_POST['bank_name_clone'] as $key => $value) {
            $bank_name_clone = mysqli_real_escape_string($DBManager->conn, $_POST['bank_name_clone'][$key]);
            $bank_account_no_clone = mysqli_real_escape_string($DBManager->conn, $_POST['bank_account_no_clone'][$key]);
            $ifsc_clone = mysqli_real_escape_string($DBManager->conn, $_POST['ifsc_clone'][$key]);
            $result4 = $adminManager->saveBankDetails($bank_name_clone, $bank_account_no_clone, $ifsc_clone);
        }
    }

    if($result) {
        $_SESSION['updateCompanyProfileSuccess'] = 'success';
        header('Location:companyProfile');
    }
}
if (isset($_POST["updateTermsConditions"])) {
   if($_FILES["employee_terms_conditions"]['name'][0] != '') {
        $target_dir = "uploads/termsAndConditions_pdf/";
        $target_file = $target_dir . basename($_FILES["employee_terms_conditions"]["name"]);
        // Check if file already exists
        if (file_exists($target_file)) {
            unlink($target_file);
        } 
         // Check file size
        elseif ($_FILES["employee_terms_conditions"]["size"] > 5242880) {
            $_SESSION['photoErrorMsg'] = "Sorry, File is too large. Maximum file size must be less than 5MB.";
            header('Location:employeeTermsConditions');
            exit();
        }
        else {
            if (move_uploaded_file($_FILES["employee_terms_conditions"]["tmp_name"], $target_file)) {
                $employee_terms_conditions = basename($_FILES["employee_terms_conditions"]["name"]);
            } else {
                $_SESSION['pdfErrorMsg'] = "Sorry, there was an error uploading your file.";
                header('Location:employeeTermsConditions');
                exit();

            }
        }
    } 
    $adminManager = new AdminManager();
    $result = $adminManager->updateEmployeeTermsConditions($employee_terms_conditions);
    if($result) {
        $_SESSION['updateTermsConditionsSuccess'] = 'success';
        header('Location:employeeTermsConditions');
    }

}
// delete banks details
if (isset($_POST['delete_bank_id'])) {
    $adminManager = new AdminManager();
    $delete_bank_id = mysqli_real_escape_string($DBManager->conn, $_POST['delete_bank_id']);
    echo $result = $adminManager->deleteBankDetails($delete_bank_id);
}
// delete sac details
if (isset($_POST['delete_sac_id'])) {
    $adminManager = new AdminManager();
    $delete_sac_id = mysqli_real_escape_string($DBManager->conn, $_POST['delete_sac_id']);
    echo $result = $adminManager->deleteSacDetails($delete_sac_id);
}
// check sac code dublicate
if(isset($_POST['sac_code_value'])) {
    $adminManager = new AdminManager();
    $sac_code_value = mysqli_real_escape_string($DBManager->conn, $_POST['sac_code_value']);
    echo $result = $adminManager->chechSACDublicate($sac_code_value);
}

// forgotPassword 
if(isset($_POST['forgotPassword'])) {
    $adminManager = new AdminManager();
    $email = mysqli_real_escape_string($DBManager->conn, $_POST['email']);
    $accountDetails = $adminManager->getAccountDetails($email);
}

// change theme color
if(isset($_POST['skinColor'])) {
    //echo $_POST['skinColor'];
    $adminManager = new AdminManager();
    $skinColor = mysqli_real_escape_string($DBManager->conn, $_POST['skinColor']);
    $colorChangeResult = $adminManager->updateThemeColor($skinColor);
}