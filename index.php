<?php
session_start();
include_once('settings/config.php');
$mysql = mysql_connect($host, $databaseUser, $databasePassword);

if(mysql_select_db($databaseName, $mysql)) { 

} else {
    header('Location:setup.php');
}
include_once 'AdminManager.php';
$adminManager = new AdminManager();
$companyInfo = $adminManager->getAdminDetails();
if(isset($_SESSION['username'])) {
    header('Location:adminHome.php');
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
                <p class="alert alert-danger error-message"><?php  echo $_SESSION['loginErrorMsg'];?><span style="color:#0000FF;" class="clear-error-msg close">&times;</span></p>
                <?php } ?>
                <form class="login-form" method="POST" action="AdminController.php">
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
                        <a href="forgotPassword.php">Forgot Password ?</a>
                    </div>
                    <div class="form-group">
                        <input class="btn btn-success pull-left" type="submit" value="Submit" name="loginForm">
                        <button class="btn btn-danger pull-right" type="reset">Reset</button>
                     </div>
                </form>
            </div>
        </div>
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
    unset($_SESSION['loginErrorMsg']);  
    ?>
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