<?php
session_start();
include_once('settings/config.php');
include_once 'DBManager.php';
$DBManager = new DBManager();
if(isset($DBManager->mysqlConnectError)) { 
    $error = 'mysqlError';
} else {
    include_once 'LoaderManager.php';
    $loaderManager = new LoaderManager();
    $resultCheckTableExist = $loaderManager->checkTableExist();
    if(count($resultCheckTableExist) > 0 ) {
        include_once 'AdminManager.php';
        $adminManager = new AdminManager();
        $companyInfo = $adminManager->getAdminDetails();
        if(isset($_SESSION['username'])) 
        {
            header('Location:adminHome');
        }
    } else {
        $error = 'tablesDoesNotExist';
    }
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
    <title>EMS | Login</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

    <!-- FONTAWESOME-->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
     <!-- sweet alert -->
    <link rel="stylesheet" href="plugins/sweetalert/sweetalert.css">
    <!-- CUSTOM CSS -->
    
    <link rel="stylesheet" type="text/css" href="css/custom.css">
    <link rel="stylesheet" type="text/css" href="dist/css/skins/_all-skins.min.css">
    <!-- jQuery 2.2.3 -->
    <script src="js/jquery-2.2.3.min.js"></script>
  </head>
<body>
    <div class="container">
        <?php if(isset($error) && $error =='mysqlError') { ?>
            <div class="jumbotron div-centered">
                <h4>Welcome To EMS</h4>
                <p class="alert alert-danger">You have not configured your config file under setting folder. Please open the config file in any of your editor and give the necessary database credientials and full url where you want to install your EMS and then refresh the site.</p>
            </div>
        <?php } elseif(isset($error) && $error =='tablesDoesNotExist') { ?>
            <div class="jumbotron div-centered">
                <h3>Welcome To EMS</h3>
                <p class="alert alert-danger">You have not installed your tables yet. <a href="setup">Click here for table installation</a></p>
            </div>
        <?php } else { ?>
        <div class="row">
            <div class="centered-aligned">
                <div class="col-md-6 col-md-offset-3 text-center">
                <?php if(isset($_SESSION['loginErrorMsg'])) { ?>
                <p class="alert alert-danger error-message"><?php  echo $_SESSION['loginErrorMsg'];?><span style="color:#0000FF;" class="clear-error-msg close">&times;</span></p>
                <?php 
                unset($_SESSION['loginErrorMsg']);
                }
                ?>
                <form class="login-form <?php echo $theme_color;?>" method="POST" action="AdminController.php">
                    <div class="header-image">
                        <?php if($companyInfo['company_logo'] != '') { ?>
                        <img src="<?php echo 'uploads/company_profile_images/'.$companyInfo['company_logo'];?>" alt="logo">
                        <?php } else { ?>
                        <img src="uploads/company_profile_images/logo-black.png" alt="logo">
                        <?php } ?>
                    </div>
                    <h4>Sign In</h4>
                    <?php if(isset($_COOKIE['username']) && isset($_COOKIE['password'])) { ?>
                    <div class="form-group">
                        <input id="username" value="<?php echo $_COOKIE['username']; ?>" type="text" class="form-control" name="username" placeholder="Username" required autofocus>
                    </div>
                    <div class="form-group">
                        <input value="<?php echo $_COOKIE['password']; ?>" id="loginPassword" type="password" class="form-control" name="password" placeholder="Password" required>
                    </div>
                    <div class="form-group checkbox text-left">
                        <label class="">
                            <input type="checkbox" name="remember-me" id="rememberMe" checked> Remember Me
                        </label>
                    </div>
                    <?php } else {  ?>
                    <div class="form-group">
                        <input id="username" type="text" class="form-control" name="username" placeholder="Username" required autofocus>
                    </div>
                    <div class="form-group">
                        <input id="loginPassword" type="password" class="form-control" name="password" placeholder="Password" required>
                    </div>
                    <div class="form-group checkbox text-left">
                        <label class="">
                            <input type="checkbox" name="remember-me" id="rememberMe"> Remember Me
                        </label>
                    </div>
                    <?php } ?>
                    <div class="form-group text-left">
                        <a class="forgotPassword" href="forgotPassword">Forgot Password ?</a>
                    </div>
                    <div class="form-group">
                        <input class="btn btn-success pull-left" type="submit" value="Submit" name="loginForm">
                        <button class="btn btn-danger pull-right" type="reset">Reset</button>
                     </div>
                </form>
            </div>
            </div>
        </div>
        <?php } ?>
    </div>
    <!-- sweet alert -->
    <script type="text/javascript" src="plugins/sweetalert/sweetalert.min.js"></script>
    <?php
    if(isset($_SESSION['successMsgSentPasswordResetEmail'])) { ?>
    <script type="text/javascript">
        swal('Congrats','Your password reset link has been sent to your email. Please check your email to reset your password.', 'success');
    </script>
    <?php
    unset($_SESSION['successMsgSentPasswordResetEmail']);   
    }  
    ?>
    <!--  Setup success message -->
    <?php
    if(isset($_SESSION['setupSuccess'])) { ?>
    <script type="text/javascript">
        swal('Congrats','All your setup has been done succesfully. You can now login using Username as admin and Password as 123123 which is default, you can change it after logging.', 'success');
    </script>
    <?php
    unset($_SESSION['setupSuccess']);   
    }
    ?>
    <!-- End -->
    <!-- jQuery cookie plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <script type="text/javascript">
        // remember me
        $('#rememberMe').click(function(){
            if ($(this).prop('checked')) {
                var username = $('#username').val();
                var password = $('#loginPassword').val();
                
                if(username.length != 0 && password.length != 0) {
                    $.cookie('username', username);
                    $.cookie('password', password);
                    $('#rememberMe').attr('checked');
                } else {
                    swal('Warning','Please enter your username and password first.', 'warning');
                    $('#rememberMe').removeAttr('checked');
                }
            } else {
                $('#rememberMe').removeAttr('checked');
            }   
        });
    </script>
    <script src="js/custom.js" type="text/javascript"></script>
</body>
</html>