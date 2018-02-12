<?php
session_start();
include('../settings/config.php');
$current_link = $absoluteUrl.'employee/'.basename($_SERVER['PHP_SELF'],".php");
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
   header('Location:../index');
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Employee | <?php echo $title;?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../plugins/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="../plugins/datepicker/datepicker3.css">
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
  <script src="../js/jquery-2.2.3.min.js"></script>
</head>
<body class="hold-transition sidebar-mini <?php echo $companyInfo['theme_color']; ?>">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="home" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b>LB</span>
      <!-- logo for regular state and mobile devices -->
      <?php if($companyInfo['company_logo'] != '') { ?>
      <img style="<?php echo $dasboardLogoSize;?>" src="<?php echo '../uploads/company_profile_images/'.$companyInfo['company_logo'];?>" alt="company-logo">
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
        <li class="treeview <?php if($current_link == $absoluteUrl.'employee/home') echo 'active'; ?>">
          <a href="home">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <li class="treeview <?php if($current_link == $absoluteUrl.'employee/payroll' || $current_link == $absoluteUrl.'employee/probationerAppointment' || $current_link == $absoluteUrl.'employee/employeeTermsConditions' || $current_link == $absoluteUrl.'employee/permanentAppointment' ) echo 'active'; ?>">
          <a href="#">
            <i class="fa fa-user" aria-hidden="true"></i>
            <span>Employees</span>
          </a>

          <ul class="treeview-menu">
             <li class="<?php if($current_link == $absoluteUrl.'employee/probationerAppointment') echo 'active'; ?>"><a href="probationerAppointment"><div class="menu-round-icon"><i class="fa fa-circle"></i><br><i class="fa fa-circle" style="opacity:0;"></i></div><div class="modified-submenu">Probationer <br>Appointment Letter</div></a></li>

             <li class="<?php if($current_link == $absoluteUrl.'employee/permanentAppointment') echo 'active'; ?>"><a href="permanentAppointment"><div class="menu-round-icon"><i class="fa fa-circle"></i><br><i class="fa fa-circle" style="opacity:0;"></i></div><div class="modified-submenu">Permanent <br>Appointment Letter</div></a></li>
            

            <li  class="<?php if($current_link == $absoluteUrl.'employee/employeeTermsConditions') echo 'active'; ?>"><a href="employeeTermsConditions"><div class="menu-round-icon"><i class="fa fa-circle"></i><br><i class="fa fa-circle" style="opacity:0;"></i></div><div class="modified-submenu">Employee <br>Terms &amp; Conditions</div></a></li>
            <li  class="<?php if($current_link == $absoluteUrl.'employee/payroll') echo 'active'; ?>"><a href="payroll"><i class="fa fa-circle"></i>Payroll</a></li>
          </ul>
        </li>
        <li class="treeview <?php if($current_link == $absoluteUrl.'employee/profile' || $current_link == $absoluteUrl.'employee/changePasswordForm' || $current_link == $absoluteUrl.'employee/editProfile') echo 'active'; ?>">
          <a href="#">
            <i class="fa fa-cog" aria-hidden="true"></i>
            <span>Settings</span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if($current_link == $absoluteUrl.'employee/profile') echo 'active'; ?>"><a href="profile"><i class="fa fa-circle"></i>Profile</a></li>
            <li class="<?php if($current_link == $absoluteUrl.'employee/editProfile') echo 'active'; ?>"><a href="editProfile"><i class="fa fa-circle"></i>Edit Profile</a></li>
            <li class="<?php if($current_link == $absoluteUrl.'employee/changePasswordForm') echo 'active'; ?>"><a href="changePasswordForm"><i class="fa fa-circle"></i>Change Password</a></li>
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