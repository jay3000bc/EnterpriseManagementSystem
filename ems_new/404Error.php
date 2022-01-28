<?php
include('settings/config.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>404 Error</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.6 -->
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="plugins/font-awesome/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="plugins/Ionicons/css/ionicons.min.css">
	<!-- custom css -->
	<link rel="stylesheet" type="text/css" href="css/custom.css">
</head>
<body>
	<div class="container">
	    <div class="row">
	        <div class="col-md-6 col-md-offset-3">
	            <div class="centered-middle">
	            	<div class="error-template panel panel-primary panel-sm">
		                <h1>
		                    Oops!</h1>
		                <h2>
		                    404 Not Found</h2>
		                <div class="error-details">
		                    Sorry, an error has occured, Requested page not found!
		                </div>
		                <div class="error-actions">
		                    <a href="<?php echo $absoluteUrl;?>" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-home"></span>
		                        Take Me Home </a><a href="<?php echo $absoluteUrl.'support';?>" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-envelope"></span> Contact Support </a>
		                </div>
		            </div>
	            </div>
	        </div>
	    </div>
	</div>
</body>
</html>