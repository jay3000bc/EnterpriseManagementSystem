<?php
session_start();
include_once 'AdminManager.php';
$adminManager = new AdminManager();
$companyInfo = $adminManager->getAdminDetails();
if(isset($_SESSION['username'])) {
    header('Location:adminHome');
}
if($companyInfo['theme_color'] == 'skin-blue') { 
    $theme_color = 'blue-skin forgot-password-link'; 
} 
if($companyInfo['theme_color'] == 'skin-yellow') { 
    $theme_color = 'yellow-skin forgot-password-link'; 
}
if($companyInfo['theme_color'] == 'skin-purple') { 
    $theme_color = 'purple-skin forgot-password-link'; 
} 
if($companyInfo['theme_color'] == 'skin-green') { 
    $theme_color = 'green-skin forgot-password-link'; 
} 
if($companyInfo['theme_color'] == 'skin-black') { 
    $theme_color = 'black-skin'; 
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>EMS | Forgot Password</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

    <!-- FONTAWESOME-->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

    <!-- CUSTOM CSS -->
    
    <link rel="stylesheet" type="text/css" href="css/custom.css">
   
    <!-- jQuery 2.2.3 -->
    <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
  </head>
<body>
    <div class="container">
        <div class="row">
            <div class="centered-aligned">
                <div class="col-md-6 col-md-offset-3 text-center">
                    <?php if(isset($_SESSION['loginErrorMsg'])) { ?>
                    <p class="alert alert-danger"><?php  echo $_SESSION['loginErrorMsg'];?></p>
                    <?php } ?>
                    <form id="forgotPassword" class="login-form <?php echo $theme_color;?>" method="POST" action="ForgotPasswordController.php">
                        <div class="header-image">
                            <?php if($companyInfo['company_logo'] != '') { ?>
                            <img src="<?php echo 'uploads/company_profile_images/'.$companyInfo['company_logo'];?>" alt="logo">
                            <?php } else { ?>
                            <img src="uploads/company_profile_images/logo-black.png" alt="logo">
                            <?php } ?>
                        </div>
                        <h4>Forgot Password</h4>
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" placeholder="Enter your email" required autofocus>
                        </div>
                        <div class="form-group">
                            <input class="btn btn-success btn-block" type="submit" value="Send Password Reset Link" name="forgotPassword">
                         </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="js/custom.js" type="text/javascript"></script>
</body>
</html>
<?php
unset($_SESSION['loginErrorMsg']);  
?>