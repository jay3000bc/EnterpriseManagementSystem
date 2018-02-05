<?php
include('settings/config.php');
session_start();
date_default_timezone_set('Asia/Kolkata');
$microtime = microtime(true);
include_once 'AdminManager.php';
$adminManager = new AdminManager();
$companyInfo = $adminManager->getAdminDetails();
include_once 'DBManager.php';
$DBManager = new DBManager();
include_once 'ForgotPasswordManager.php';
$forgotPasswordManager = new ForgotPasswordManager();
// forgotPassword 
if(isset($_POST['forgotPassword'])) {
    $email = mysqli_real_escape_string($DBManager->conn, $_POST['email']);
    $accountDetails = $forgotPasswordManager->getAccountDetails($email);
    $name = $accountDetails['name'];
    if($accountDetails!= '' ) {
        //Generate a random string.
        $token = openssl_random_pseudo_bytes(16);
        //Convert the binary data into hexadecimal representation.
        $token = bin2hex($token);
        //save in db
        $savetoken = $forgotPasswordManager->saveToken($email, $token);
        if($savetoken) {
            // get browser info 
            $browserInfo = $forgotPasswordManager->getBrowser();
            $browserName = $browserInfo['name'];
            $operatingSystem =  $browserInfo['platform'];

            // include mail format 
            include('emails/forgotPasswordEmailMessage.php');
            // send mail
            if(mail($email, $resetPasswordSubject, $message, $from)) {
                //echo "Mail Sent";
            } else {
                $_SESSION['loginErrorMsg'] = 'Sorry, Email cannot be sent now.Please try again later';
                header('Location:index');
            }
            // end
            $_SESSION['successMsgSentPasswordResetEmail'] = 'success';
            header('Location:index');
        } else {
            $_SESSION['loginErrorMsg'] = 'Sorry, something went wrong please try again.';
            header('Location:forgotpassword');
        }    
    } else {
        $_SESSION['loginErrorMsg'] = 'Sorry, Your email is not registered with us.';
        header('Location:index');
    }
}
// save reset password

if(isset($_POST['saveResetPassword'])) {
    $email = mysqli_real_escape_string($DBManager->conn, $_POST['email']);
    $password = mysqli_real_escape_string($DBManager->conn, $_POST['newPassword']);
    $confirmPassword = mysqli_real_escape_string($DBManager->conn, $_POST['confirmPassword']);
    if($password != '' and $confirmPassword != '') {
        if($password == $confirmPassword) {
            $encryptpassword = md5($password);
            $result = $forgotPasswordManager->saveResetPassword($email, $encryptpassword);
            $_SESSION['loginErrorMsg'] = 'Congrats, Your password have been reset successfully.';
            header('Location:index');
        } else {
            $_SESSION['loginErrorMsg'] = 'Sorry, Your password new password and confirm password doesnot matches.';
            header('Location:index');
        }
    } else {
        $_SESSION['loginErrorMsg'] = 'Sorry, Password fields cannot be empty.';
        header('Location:index');
    }
    
}
