<?php
session_start();
include('../settings/config.php');
$current_link = $relativeUrl.'employee/'.basename($_SERVER['PHP_SELF']);
date_default_timezone_set('Asia/Kolkata');
$current_date = time();
if(isset($_SESSION['email'])) {
    include_once '../DBManager.php';
    $DBManager = new DBManager();
    $id = $_SESSION['id'];
    $employee_id = $_SESSION['employee_id'];
    include_once '../AdminManager.php';
    $adminManager = new AdminManager();
    $companyInfo = $adminManager->getAdminDetails();
    include_once '../EmployeeManager.php';
    $employeeManager = new EmployeeManager();
    $employeeInfo = $employeeManager->getEmployeeDetails($id);
}
else {
   header('Location:../index.php');
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Employee | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="../plugins/datepicker/datepicker3.css">
  <!-- Daterange picker -->
  <!--  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css"> -->
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <!--  dropify -->
  <link href="../plugins/dropify/css/dropify.min.css" rel="stylesheet" />
  <!-- DataTables -->
  <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
  <link rel="stylesheet" type="text/css" href="../css/custom.css">
  <!-- sweet alert -->
  <link rel="stylesheet" href="../plugins/sweetalert/sweetalert.css">
  <!-- password strength -->
  <link rel="stylesheet" type="text/css" href="../css/passwordStrength.css">
  <!-- jQuery 2.2.3 -->
  <script src="../plugins/jQuery/jquery-2.2.3.min.js"></script>
</head>
<body class="hold-transition sidebar-mini <?php if(isset($_COOKIE['skinColor'])) echo $_COOKIE['skinColor']; else echo 'skin-blue';?>">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="home.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b>LB</span>
      <!-- logo for regular state and mobile devices -->
      <?php if($companyInfo['company_logo'] != '') { ?>
      <img style="width: 60%;" src="<?php echo '../uploads/company_profile_images/'.$companyInfo['company_logo'];?>" alt="company-logo">
      <?php } elseif ($companyInfo['company_name'] != '') { ?> 
      <span class="logo-lg"><b><?php echo $companyInfo['company_name'];?></b></span>
      <?php } else { ?>
      <span class="logo-lg"><b>Tomato Inc.</b></span>
      <?php } ?>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
            <li class="user user-menu">
              <a href="#" class="text-right">
              <span class="hidden-xs">Welcome, <?php echo $employeeInfo['name'];?>, Today: <?php echo(date("d/m/y",$current_date)); 
                  if( $employeeInfo['last_logged_in'] !='') {
                  ?> <br>
                  You Last Logged in at <?php echo(date("h:i A",$employeeInfo['last_logged_in'])).' on '; echo(date("d/m/Y",$employeeInfo['last_logged_in']));?>
                 <?php } ?>   
              </span>
            </a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <?php if($employeeInfo['photo']) { ?>
          <img src="<?php echo '../uploads/employee/images/'.$employeeInfo['photo'];?>" class="img-circle" alt="User Image">
           <?php }
            else { ?>
            <img src="../uploads/employee/images/avatar5.png" class="img-circle" alt="User Image">
          <?php  } ?>
        </div>
        <div class="pull-left info">
          <p><?php echo $employeeInfo['name'] ?></p>
          <a href="#"><i class="fa fa-circle text-success" style="color: #7BC60E;"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <li class="treeview <?php if($current_link == $relativeUrl.'employee/home.php') echo 'active'; ?>">
          <a href="home.php">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <li class="treeview <?php if($current_link == $relativeUrl.'employee/payroll.php' || $current_link == $relativeUrl.'employee/probationerAppointment.php' || $current_link == $relativeUrl.'employee/employeeTermsConditions.php' || $current_link == $relativeUrl.'employee/permanentAppointment.php' ) echo 'active'; ?>">
          <a href="#">
            <i class="fa fa-user" aria-hidden="true"></i>
            <span>Employees</span>
          </a>

          <ul class="treeview-menu">
             <li class="<?php if($current_link == $relativeUrl.'employee/probationerAppointment.php') echo 'active'; ?>"><a href="probationerAppointment.php"><div class="menu-round-icon"><i class="fa fa-circle"></i><br><i class="fa fa-circle" style="opacity:0;"></i></div><div class="modified-submenu">Probationer <br>Appointment Letter</div></a></li>

             <li class="<?php if($current_link == $relativeUrl.'employee/permanentAppointment.php') echo 'active'; ?>"><a href="permanentAppointment.php"><div class="menu-round-icon"><i class="fa fa-circle"></i><br><i class="fa fa-circle" style="opacity:0;"></i></div><div class="modified-submenu">Permanent <br>Appointment Letter</div></a></li>
            

            <li  class="<?php if($current_link == $relativeUrl.'employee/employeeTermsConditions.php') echo 'active'; ?>"><a href="employeeTermsConditions.php"><div class="menu-round-icon"><i class="fa fa-circle"></i><br><i class="fa fa-circle" style="opacity:0;"></i></div><div class="modified-submenu">Employee <br>Terms &amp; Conditions</div></a></li>
            <li  class="<?php if($current_link == $relativeUrl.'employee/payroll.php') echo 'active'; ?>"><a href="payroll.php"><i class="fa fa-circle"></i>Payroll</a></li>
          </ul>
        </li>
        <li class="treeview <?php if($current_link == $relativeUrl.'employee/profile.php' || $current_link == $relativeUrl.'employee/changePasswordForm.php' || $current_link == $relativeUrl.'employee/editProfile.php') echo 'active'; ?>">
          <a href="#">
            <i class="fa fa-cog" aria-hidden="true"></i>
            <span>Settings</span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if($current_link == $relativeUrl.'employee/profile.php') echo 'active'; ?>"><a href="profile.php"><i class="fa fa-circle"></i>Profile</a></li>
            <li class="<?php if($current_link == $relativeUrl.'employee/editProfile.php') echo 'active'; ?>"><a href="editProfile.php"><i class="fa fa-circle"></i>Edit Profile</a></li>
            <li class="<?php if($current_link == $relativeUrl.'employee/changePasswordForm.php') echo 'active'; ?>"><a href="changePasswordForm.php"><i class="fa fa-circle"></i>Change Password</a></li>
          </ul>  
        </li>
        <li class="treeview">
          <a href="logout.php">
            <i class="fa fa-sign-out" aria-hidden="true"></i>
            <span>Log Out</span>
          </a>
        </li>
      </ul>
    </section>
  </aside>
 <!-- /.sidebar -->