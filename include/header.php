<?php
include('settings/config.php');
session_start();
date_default_timezone_set('Asia/Kolkata');
$current_date = time();
$current_link = $absoluteUrl.basename($_SERVER['PHP_SELF'],".php");
if(isset($_SESSION['username'])) {
    include_once 'AdminManager.php';
    $adminManager = new AdminManager();
    $companyInfo = $adminManager->getAdminDetails();
    $totalStates = $adminManager->getStates();

    // get employee profile update notification detalis
    include_once 'EmployeeManager.php';
    $employeeManager = new EmployeeManager();
    $totalProfileUpdateRequest = $employeeManager->getProfileUpdateRequest();
}
else {
   header('Location:index');
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin | <?php echo $title;?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="plugins/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
  <!--  dropify -->
  <link href="plugins/dropify/css/dropify.min.css" rel="stylesheet" />
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  <link rel="stylesheet" type="text/css" href="css/custom.css">
  <!-- sweet alert -->
  <link rel="stylesheet" href="plugins/sweetalert/sweetalert.css">
  <!-- jquery auto complete -->
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <!-- bootstrap-form-helper -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap-formhelpers.min.css">
  <!-- password strength -->
  <link rel="stylesheet" type="text/css" href="css/passwordStrength.css">
  <!-- jQuery 2.2.3 -->
  <script src="js/jquery-2.2.3.min.js"></script>
  <!-- jQuery ui 2.2.3 -->
  <script src="js/jquery-ui.min.js"></script>
  

</head>
<body class="hold-transition sidebar-mini <?php if(isset($_COOKIE['skinColor'])) echo $_COOKIE['skinColor']; else echo 'skin-blue';?>">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="adminHome" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b>LB</span>
      <!-- logo for regular state and mobile devices -->
      <?php if($companyInfo['company_logo'] != '') { ?>
      <img style="width: 60%;" src="<?php echo 'uploads/company_profile_images/'.$companyInfo['company_logo'];?>" alt="company-logo">
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
              <span class="hidden-xs">Welcome Admin, Today: <?php echo(date("d/m/y",$current_date)); 
                  if( $companyInfo['last_logged_in'] !='') {
                  ?><br>
                  You Last Logged in at <?php echo(date("h:i A",$companyInfo['last_logged_in'])).' on '; echo(date("d/m/Y",$companyInfo['last_logged_in']));?>
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
          <?php if(isset($companyInfo['photo'])) { ?>
          <img src="<?php echo 'uploads/company_profile_images/'.$companyInfo['photo'];?>" class="img-circle" alt="User Image">
           <?php }
            else { ?>
            <img src="uploads/avatar5.png" class="img-circle" alt="User Image">
          <?php  } ?>
        </div>
        <div class="pull-left info">
          <p>Admin</p>
          <a href="#"><i class="fa fa-circle text-success" style="color: #7BC60E;"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <li class="treeview <?php if($current_link == $absoluteUrl.'adminHome') echo 'active'; ?>">
          <a href="adminHome">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <li class="treeview <?php if($current_link == $absoluteUrl.'createEmployee' || $current_link == $absoluteUrl.'viewEmployees' || $current_link == $absoluteUrl.'viewEmployeeDetails' || $current_link == $absoluteUrl.'editEmployee' || $current_link == $absoluteUrl.'payroll' || $current_link == $absoluteUrl.'probationerAppointment' || $current_link == $absoluteUrl.'employeeTermsConditions' || $current_link == $absoluteUrl.'permanentAppointment' || $current_link == $absoluteUrl.'experienceCertificate' || $current_link == $absoluteUrl.'searchPayroll') echo 'active'; ?>">
          <a href="#">
            <i class="fa fa-user" aria-hidden="true"></i>
            <span>Employees</span>
          </a>

          <ul class="treeview-menu">
            <li class="<?php if($current_link == $absoluteUrl.'createEmployee') echo 'active'; ?>"><a href="createEmployee"><i class="fa fa-circle"></i>Create Employee</a></li>
            <li class="<?php if($current_link == $absoluteUrl.'viewEmployees') echo 'active'; ?>"><a href="viewEmployees"><i class="fa fa-circle"></i>View Employees</a></li>
             <li class="<?php if($current_link == $absoluteUrl.'probationerAppointment') echo 'active'; ?>"><a href="probationerAppointment"><div class="menu-round-icon"><i class="fa fa-circle"></i><br><i class="fa fa-circle" style="opacity:0;"></i></div><div class="modified-submenu">Probationer <br>Appointment Letter</div></a></li>

             <li class="<?php if($current_link == $absoluteUrl.'permanentAppointment') echo 'active'; ?>"><a href="permanentAppointment"><div class="menu-round-icon"><i class="fa fa-circle"></i><br><i class="fa fa-circle" style="opacity:0;"></i></div><div class="modified-submenu">Permanent <br>Appointment Letter</div></a></li>
             <li class="<?php if($current_link == $absoluteUrl.'experienceCertificate') echo 'active'; ?>"><a href="experienceCertificate"><i class="fa fa-circle"></i>Experience Certificate</a></li>
            

            <li  class="<?php if($current_link == $absoluteUrl.'employeeTermsConditions') echo 'active'; ?>"><a href="employeeTermsConditions"><div class="menu-round-icon"><i class="fa fa-circle"></i><br><i class="fa fa-circle" style="opacity:0;"></i></div><div class="modified-submenu">Employee <br>Terms &amp; Conditions</div></a></li>

            <li  class="<?php if($current_link == $absoluteUrl.'payroll') echo 'active'; ?>"><a href="payroll"><i class="fa fa-circle"></i>Payroll</a></li>
            <li  class="<?php if($current_link == $absoluteUrl.'searchPayroll') echo 'active'; ?>"><a href="searchPayroll"><i class="fa fa-circle"></i>Search Payroll</a></li>
          </ul>
        </li>
        <li class="treeview <?php if($current_link == $absoluteUrl.'createClient' || $current_link == $absoluteUrl.'viewClients' || $current_link == $absoluteUrl.'viewClientProjects.php' || $current_link == $absoluteUrl.'viewClientDetails' || $current_link == $absoluteUrl.'editClient' || $current_link == $absoluteUrl.'viewProjects' || $current_link == $absoluteUrl.'viewSingleProjectDetails' ) echo 'active'; ?>">
          <a href="#">
            <i class="fa fa-users" aria-hidden="true"></i>
            <span>Clients</span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if($current_link == $absoluteUrl.'createClient') echo 'active'; ?>"><a href="createClient"><i class="fa fa-circle"></i>Create Clients</a></li>
            <li class="<?php if($current_link == $absoluteUrl.'viewClients' || $current_link == $absoluteUrl.'viewClientProjects.php' || $current_link == $absoluteUrl.'viewClientDetails' || $current_link == $absoluteUrl.'editClient') echo 'active'; ?>"><a href="viewClients"><i class="fa fa-circle"></i>View Clients</a></li>
            <li class="<?php if($current_link == $absoluteUrl.'viewProjects' || $current_link == $absoluteUrl.'viewSingleProjectDetails') echo 'active'; ?>"><a href="viewProjects"><i class="fa fa-circle"></i>View Projects</a></li>
          </ul>
        </li>
        <li class="treeview <?php if($current_link == $absoluteUrl.'createInvoice' || $current_link == $absoluteUrl.'viewInvoices' || $current_link == $absoluteUrl.'receiveInvoice') echo 'active'; ?>">
          <a href="#">
            <i class="fa fa-file-text" aria-hidden="true"></i>
            <span>Invoice</span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if($current_link == $absoluteUrl.'createInvoice') echo 'active'; ?>"><a href="createInvoice"><i class="fa fa-circle"></i>Create Invoice</a></li>
            <li class="<?php if($current_link == $absoluteUrl.'receiveInvoice') echo 'active'; ?>"><a href="receiveInvoice"><i class="fa fa-circle"></i>Receive Invoice</a></li>
            <li class="<?php if($current_link == $absoluteUrl.'viewInvoices') echo 'active'; ?>"><a href="viewInvoices"><i class="fa fa-circle"></i>View Invoices</a></li>
          </ul>  
        </li>
        <li class="treeview <?php if($current_link == $absoluteUrl.'currentGST' || $current_link == $absoluteUrl.'searchGST' || $current_link == $absoluteUrl.'viewGST') echo 'active'; ?>">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>GST</span>
          </a>  
          <ul class="treeview-menu">
              <li class="<?php if($current_link == $absoluteUrl.'currentGST') echo 'active'; ?>"><a href="currentGST"><i class="fa fa-circle"></i>Current GST</a></li>
              <li class="<?php if($current_link == $absoluteUrl.'searchGST') echo 'active'; ?>"><a href="searchGST"><i class="fa fa-circle"></i>Search GST</a></li>
          </ul>
        </li>
        <li class="treeview <?php if($current_link == $absoluteUrl.'companyProfile' || $current_link == $absoluteUrl.'changePasswordForm' || $current_link == $absoluteUrl.'employeeLeaveHoliday' || $current_link == $absoluteUrl.'employeeLeaveHoliday' || $current_link == $absoluteUrl.'notifications' ) echo 'active'; ?>">
          <a href="#">
            <i class="fa fa-cog" aria-hidden="true"></i>
            <span>Settings</span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if($current_link == $absoluteUrl.'companyProfile') echo 'active'; ?>"><a href="companyProfile"><i class="fa fa-circle"></i>Company Profile</a></li>
            <li class="<?php if($current_link == $absoluteUrl.'changePasswordForm') echo 'active'; ?>"><a href="changePasswordForm"><i class="fa fa-circle"></i>Change Password</a></li>
            <li class="<?php if($current_link == $absoluteUrl.'employeeLeaveHoliday') echo 'active'; ?>"><a href="employeeLeaveHoliday"><i class="fa fa-circle"></i>Employee leave/ holiday</a></li>
            <li class="<?php if($current_link == $absoluteUrl.'notifications') echo 'active'; ?>"><a href="notifications"><i class="fa fa-circle"></i>Notifications</a></li>
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