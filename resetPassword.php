<?php
session_start();
date_default_timezone_set('Asia/Kolkata');
$currentTime =  date("h:i:s");
include_once 'AdminManager.php';
$adminManager = new AdminManager();
$companyInfo = $adminManager->getAdminDetails();
include_once 'ForgotPasswordManager.php';
$forgotPasswordManager = new ForgotPasswordManager();

if(isset($_SESSION['username'])) {
    header('Location:adminHome');
}
elseif(isset($_GET['token'])) {
    $resultResetPassword = $forgotPasswordManager->getResetPasswordDetails($_GET['token']);
    if(count($resultResetPassword) > 0) {
    //     $dbTimeStamp = $resultResetPassword['created_at'];
    //     $dbTime = date("h:i:s", strtotime($dbTimeStamp)); 
    //     $currentTime = time(); 
    //     $timeDiff = $currentTime-$dbTime;
    //     echo substr('00'.($timeDiff / 3600 % 24),-2)
    // .':'. substr('00'.($timeDiff / 60 % 60),-2)
    // .':'. substr('00'.($timeDiff % 60),-2);
    //     //$time = $currentTime-$dbTime;
    //     //echo $time; 
    //     die();
        
    } else {
       $_SESSION['loginErrorMsg'] = 'Invalid url'; 
       header('Location:index');
    }
} else {
    header('Location:index');
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>EMS | Reset Password</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/passwordStrength.css">
    <!-- FONTAWESOME-->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
     <!-- sweet alert -->
   <link rel="stylesheet" href="plugins/sweetalert/sweetalert.css">
    <!-- CUSTOM CSS -->
    
    <link rel="stylesheet" type="text/css" href="css/custom.css">
   
    <!-- jQuery 2.2.3 -->
    <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
  </head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3 header-image">
                <?php if($companyInfo['company_logo'] != '') { ?>
                <img src="<?php echo 'uploads/company_profile_images/'.$companyInfo['company_logo'];?>" alt="logo">
                <?php } else { ?>
                <img src="images/logo.png" alt="logo">
                <?php } ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-md-offset-3 text-center">
                <?php if(isset($_SESSION['loginErrorMsg'])) { ?>
                <p class="alert alert-danger"><?php  echo $_SESSION['loginErrorMsg'];?></p>
                <?php } ?>
                <form id="changePasswordForm" class="login-form" method="POST" action="ForgotPasswordController.php">
                    <h4>Reset Password</h4>
                    <div class="form-group">
                        <input data-toggle="popover" title="Password Strength" data-content="Enter Password..." class="form-control" id="password" name="newPassword" id="password" type="password" class="form-control" name="newPassword" placeholder="Enter new password" required autofocus>
                    </div>
                    <div class="form-group">
                        <input id="confirmPassword" type="password" class="form-control" name="confirmPassword" placeholder="Re-enter new password" required>
                    </div>
                    <input type="hidden" name="email" value="<?php echo $resultResetPassword['email'];?>">
                    <div class="form-group">
                        <input class="btn btn-success btn-block" type="submit" value="Submit" name="saveResetPassword">
                     </div>
                </form>
            </div>
        </div>
    </div>

<!-- jquery validation -->
<script src="js/jquery.validate.js" type="text/javascript"></script>
<!-- jquery form validation -->
<script src="js/formValidate.js" type="text/javascript"></script>
<script src="js/passwordStrength.js" type="text/javascript"></script>
</body>
</html>
<?php
if(isset($_SESSION['successMsg'])) { ?>
<script type="text/javascript">
    swal('Congrats','Your password reset link has been sent to your email. Please check your email to reset your password.', 'success');
</script>
<?php
unset($_SESSION['successMsg']);   
}
unset($_SESSION['loginErrorMsg']);  
?>