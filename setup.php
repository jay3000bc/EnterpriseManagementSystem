<?php
session_start();
include_once('settings/config.php');
include_once 'DBManager.php';
$DBManager = new DBManager();
if(!isset($DBManager->mysqlConnectError)) {
	$current_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

	// check if given reletive folder given in config is currect or not 
	if($current_link == $absoluteUrl.'setup') {
        // create all database tables
        $file = 'db/ems.sql';

        if($allSQLFileContent = file_get_contents($file)) {
            $DBManager = new DBManager();
            $var_array = explode(';',$allSQLFileContent);
            foreach($var_array as $value) {
                $sql = $value.';';
                if($sql != '' and $sql != ';') {
                    $result = $DBManager->execute($sql);
                }    
            }
        }
        //end
        if($result) {
            $DBManager = new DBManager();
            include_once 'LoaderManager.php';
            $loaderManager = new LoaderManager();
            $manageIdStatus = $loaderManager->manageIdStatus();
            $result = $loaderManager->checkSettingComplete();
        } else {
            header('location:index');
        }
        
		if($result['status'] == 0) {
			
		} else {
			header('location:index');
		}
	} elseif($current_link == $absoluteUrl.'setup?step=1') {
        $DBManager = new DBManager();
        include_once 'LoaderManager.php';
        $loaderManager = new LoaderManager();
        $manageIdStatus = $loaderManager->manageIdStatus();
        if($manageIdStatus['employee_id'] == 0 && $manageIdStatus['client_id'] == 0 && $manageIdStatus['invoice_id'] == 0) {
            $step = 1;
        } else {
            header('location:setup?step=2');
        }
	} elseif($current_link == $absoluteUrl.'setup?step=2') {
        $DBManager = new DBManager();
        include_once 'LoaderManager.php';
        $loaderManager = new LoaderManager();
        $manageIdStatus = $loaderManager->manageIdStatus();
        if(($manageIdStatus['employee_id'] == 1 || $manageIdStatus['employee_id'] == 2) && $manageIdStatus['client_id'] == 0 && $manageIdStatus['invoice_id'] == 0) {
            $step = 2;
        } else {
            header('location:setup?step=3');
        }
	} elseif($current_link == $absoluteUrl.'setup?step=3') {
        $DBManager = new DBManager();
        include_once 'LoaderManager.php';
        $loaderManager = new LoaderManager();
        $manageIdStatus = $loaderManager->manageIdStatus();
        if(($manageIdStatus['employee_id'] == 1 || $manageIdStatus['employee_id'] == 2) && ($manageIdStatus['client_id'] == 1 || $manageIdStatus['client_id'] == 2) && $manageIdStatus['invoice_id'] == 0) {
            $step = 3;
        } else {
            $_SESSION['setupSuccess'] = 'success';
            //header('location:index');
        }
		
	}  else {
		$error = 'relativeUrlNotCorrect';
	}
} else {

    $error = "Database does not exists";
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>EMS | Setup</title>
	<!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- sweet alert -->
    <link rel="stylesheet" href="plugins/sweetalert/sweetalert.css">
    <!-- FONTAWESOME-->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <!-- CUSTOM CSS -->
    <link rel="stylesheet" type="text/css" href="css/custom.css">
</head>
<?php if(isset($result) && $result['status'] == 0) { ?>
<body onload="myFunction()" style="margin:0;">
    <div id="loader"></div>
	<div class="container" style="display:none;" id="myDiv">
<?php } else { ?> 
<body>
    <div class="container">
<?php } ?>       
		<div class="row div-centered">
			<div class="col-md-12">
				<div class="jumbotron">
					<div>
						<?php if(isset($result) && $result['status'] == 0) { ?>
						<h3>Welcome To EMS</h3>
						<p>All tables have been installed succcesfully.</p>
						<a href="setup?step=1" class="btn btn-primary">Continue</a>
						<?php } elseif(isset($step) && $step == 1) { ?>
						<h3>Manage employees</h3>
						<p class="alert alert-warning border-color-red">The Employee Module, supports creation of employees, payrolls and leave/ holidays.<br>If you don't know what to enter, please visit our <a href="www.alegralabs.com/support" target="_blank"><u>support</u></a> page.</p>
						<div class="row">
                            <div class="col-md-7">
                                <div style="color:#ff0000">Note: You will save it once. You cannot undo any changes later.</div>
                                <form role="form" id="manageInvoiceId" method="POST" action="LoaderController.php">
                                    <div class="from-group">
                                        <div class="radio" style="margin-top: 31px; margin-bottom: 32px;">
                                            <label style="margin-right: 40px;">
                                                <input name="type" id="autoIncrement" value="1" <?php if($manageIdStatus['employee_id']== 1) echo "checked";?> type="radio">
                                                 Auto Increment <span style="color: #0000ff">[ Maximum no. of digits is 12 ]</span>
                                            </label><br>
                                            <label>
                                                <input name="type" id="manual" value="2" <?php if($manageIdStatus['employee_id']== 2) echo "checked";?> type="radio">
                                                Manual <span style="color: #0000ff">[ Maximum no. of characters is 255 ]</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="autoIncrementSelected" style="display: none;">
                                        <div class="form-group">
                                            <label>How many digits would you like to show in your Employee Id. Default is 6 digits.</label>
                                            <p><small>For example, If you enter 6, your Client Id. will be padded with zeros, like 000001, 000023, etc.</small></p>
                                            <input class="form-control" id="invoice_digits" placeholder="6" type="text" name="invoice_digits" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label>Would you like to provide starting number. No value or default will start from 1.</label>
                                            <input placeholder="Example: 100" id="starting_no" class="form-control" type="text" name="starting_no" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label>Would you like some prefixes for Employee Id. Default no prefixes.</label>
                                            <input placeholder="Example: TOM-" class="form-control" type="text" id="export_invoice_prefix" name="export_invoice_prefix" autocomplete="off">
                                        </div>
                                        
                                        <div class="form-group">
                                            <ul style="border: 1px solid #0000ff; margin-top: 10px; padding:20px 30px;">
                                                <li>Your first Employee Id will start with the number 
                                                    <input style="width: 30%; border: none;background: none;" type="text" name="e1" class="export_invoice_id" value="000001" disabled>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                         <?php if($manageIdStatus['employee_id'] > 0) { ?>
                                        <input type="submit" class="btn btn-success" value="Continue" name="manageEmployeeId" disabled>
                                        <?php } else { ?>
                                        <input type="submit" class="btn btn-success" id="submit-btn" value="Continue" name="manageEmployeeId" disabled>
                                        <?php } ?>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-5"></div>
                        </div>
						<?php } elseif(isset($step) && $step == 2) { ?>
						<h3>Manage Client Id</h3>
                        <p class="alert alert-warning border-color-red">The Client Module, supports creation of clients and projects.<br>If you don't know what to enter, please visit our <a href="www.alegralabs.com/support" target="_blank"><u>support</u></a> page.</p>
                        <div class="row">
                            <div class="col-md-7">
                                <p style="color:#ff0000">Note: You will save it once. You cannot undo any changes later.</p>
                                <form role="form" id="manageInvoiceId" method="POST" action="LoaderController.php">
                                    <div class="from-group">
                                        <div class="radio" style="margin-top: 31px; margin-bottom: 32px;">
                                            <label style="margin-right: 40px;">
                                                <input name="type" id="autoIncrement" value="1" <?php if($manageIdStatus['client_id']== 1) echo "checked";?> type="radio">
                                                 Auto Increment <span style="color: #0000ff">[ Maximum no. of digits is 12 ]</span>
                                            </label><br>
                                            <label>
                                                <input name="type" id="manual" value="2" <?php if($manageIdStatus['client_id']== 2) echo "checked";?> type="radio">
                                                Manual <span style="color: #0000ff">[ Maximum no. of characters is 255 ]</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="autoIncrementSelected" style="display: none;">
                                        <div class="form-group">
                                        <label>How many digits would you like to show in your Client Id. Default is 6 digits.</label>
                                        <p><small>For example, If you enter 6, your Client Id will be padded with zeros, like 000001, 000023, etc.</small></p>
                                        <input class="form-control" id="invoice_digits" placeholder="6" type="text" name="invoice_digits" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label>Would you like to provide starting number. No value or default will start from 1.</label>
                                        <input placeholder="Example: 100" id="starting_no" class="form-control" type="text" name="starting_no" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label>Would you like some prefixes for Client Id. Default no prefixes.</label>
                                        <input placeholder="Example: TOMC-" class="form-control" type="text" id="export_invoice_prefix" name="export_invoice_prefix" autocomplete="off">
                                    </div>
                                    
                                    <div class="form-group">
                                        <ul style="border: 1px solid #0000ff; margin-top: 10px; padding:20px 30px;">
                                            <li>Your first Client Id will start with the number 
                                                <input style="width: 30%; border: none;background: none;" type="text" name="e1" class="export_invoice_id" value="000001" disabled>
                                            </li>
                                        </ul>
                                    </div>
                                    </div>
                                    <div class="form-group">
                                         <?php if($manageIdStatus['client_id'] > 0) { ?>
                                        <input type="submit" class="btn btn-success" value="Continue" name="manageClientId" disabled>
                                        <?php } else { ?>
                                        <input type="submit" class="btn btn-success" id="submit-btn" value="Continue" name="manageClientId" disabled>
                                        <?php } ?>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-5"></div>
                        </div>
						<?php } elseif(isset($step) && $step == 3) { ?>
						<h3>Manage Invoice Id</h3>
                        <p class="alert alert-warning border-color-red">The Invoice Module, supports creation of  Client Invoices and  Seller Invoices.<br>If you don't know what to enter, please visit our <a href="www.alegralabs.com/support" target="_blank"><u>support</u></a> page.</p>
                        <div class="row">
                            <div class="col-md-8">
                                <p style="color:#ff0000">Note: You will save it once. You cannot undo any changes later.</p>
                                <form role="form" id="manageInvoiceId" method="POST" action="LoaderController.php">
                                <div class="from-group">
                                    <div class="radio" style="margin-top: 31px; margin-bottom: 32px;">
                                        <label style="margin-right: 40px;">
                                            <input name="type" id="autoIncrement" value="1" <?php if($manageIdStatus['invoice_id']== 1) echo "checked";?> type="radio">
                                             Auto Increment <span style="color: #0000ff">[ Maximum no. of digits is 12 ]</span>
                                        </label><br>
                                        <label>
                                            <input name="type" id="manual" value="2" <?php if($manageIdStatus['invoice_id']== 2) echo "checked";?> type="radio">
                                            Manual <span style="color: #0000ff">[ Maximum no. of characters is 255 ]</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="autoIncrementSelected" style="display: none;">
                                    <div class="form-group">
                                    <label>How many digits would you like to show in your invoice no. Default is 6 digits.</label>
                                    <p><small>For example, If you enter 6, your invoice number no. will be padded with zeros, like 000001, 000023, etc.</small></p>
                                    <input class="form-control" id="invoice_digits" placeholder="6" type="text" name="invoice_digits" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label>Would you like to provide starting number. No value or default will start from 1.</label>
                                    <input placeholder="Example: 100" id="starting_no" class="form-control" type="text" name="starting_no" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label>Would you like some prefixes for India based invoice. Default no prefixes.</label>
                                    <input id="india_based_invoice_prefix" placeholder="Example: N-" class="form-control" type="text" name="india_based_prefix" autocomplete="off">
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                      <input type="checkbox" class="form-check-input" id="checkboxExport">
                                        &nbsp;Do you export products and/ or services
                                    </label>
                                  </div>
                                <div class="form-group exportPrefixEnable" style="display: none;">
                                    <label>Would you like some prefixes for export invoice. Default no prefixes.</label>
                                    <input placeholder="Example: E-" class="form-control" type="text" id="export_invoice_prefix" name="export_invoice_prefix" autocomplete="off">
                                </div>
                                
                                
                                <div class="form-group">
                                    <ul style="border: 1px solid #0000ff; margin-top: 10px; padding:20px 30px;">

                                        <li style="list-style: none;">Your first India based invoice will start with the invoice number
                                            <input style="width: 30%; border: none; background: none;" type="text" name="e2" class="india_based_invoice_id" value="000001" disabled>
                                        </li>
                                        <li class="exportPrefixEnableInfo" style="display: none;">Your first export invoice will start with the invoice number 
                                            <input style="width: 30%; border: none;background: none;" type="text" name="e1" class="export_invoice_id" value="000001" disabled>
                                        </li>
                                    </ul>
                                </div>
                                </div>
                                <div class="form-group">
                                     <?php if($manageIdStatus['invoice_id'] > 0) { ?>
                                    <input type="submit" class="btn btn-success" value="Continue" name="manageInvoiceId" disabled>
                                    <?php } else { ?>
                                    <input id="submit-btn" type="submit" class="btn btn-success" value="Continue" name="manageInvoiceId" disabled>
                                    <?php } ?>
                                </div>
                                </form>
                            </div>
                            <div class="col-md-5"></div>
                        </div>
						<?php } elseif(isset($error) && $error == 'relativeUrlNotCorrect') { ?>
						<p class="alert alert-danger errorMsg">Sorry, you have not set absolute path or it may be incorrect, please confirm it by going to EMS -> Setting -> config file. If the problem continues please visit our <a href="www.alegralabs.com/support" target="_blank"><u>support</u></a> page.</p>
						<?php } elseif(isset($error) && $error == "Database does not exists") { ?>
						<p class="alert alert-danger errorMsg">Sorry, You have not created any database for EMS yet. Please create a database for your EMS and run the setup page again. Also check that you have entered your credientials in config file correctly. If the problem continues please visit our <a href="www.alegralabs.com/support" target="_blank"><u>support</u></a> page.  </p>
						<?php } elseif(isset($success)) { ?>
                        <p class="alert alert-danger"><?php echo $success;?></p>
                        <?php } elseif(isset($error)) { ?>
                        <p class="alert alert-danger errorMsg"><?php echo $error;?></p>
                        <?php } else {} ?>
					</div>	
				</div>
			</div>
		</div>
	</div>
    <!-- js -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"
                  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
                  crossorigin="anonymous"></script>
    <!-- sweet alert -->
    <script type="text/javascript" src="plugins/sweetalert/sweetalert.min.js"></script>
    <!-- Manage Employee -->
    <!-- If seleted auto indrement then show div -->
    <script type="text/javascript">
        $('#autoIncrement').click(function() {
            $('.autoIncrementSelected').css('display','block');
            $('#submit-btn').removeAttr('disabled');
        });
        $('#manual').click(function() {
            $('.autoIncrementSelected').css('display','none');
            $('#submit-btn').removeAttr('disabled');
        });
        // select digits
        function pad (str, max) {
          str = str.toString();
          return str.length < max ? pad("0" + str, max) : str;
        }

        // starting number
        var selectDigits = 6
        var startingNumber = 1; 
        var export_invoice_id = $('.export_invoice_id').val();
        var india_based_invoice_id = $('.india_based_invoice_id').val();
        var export_invoice_prefix = '';
        var india_based_invoice_prefix = '';
        function cacl_export_invoice_id(selectDigits, startingNumber, export_invoice_prefix) {
            export_invoice_id = export_invoice_prefix+pad(startingNumber, selectDigits);
            return export_invoice_id;
        }

        function cacl_india_based_invoice_id(selectDigits, startingNumber, india_based_invoice_prefix) {
            india_based_invoice_id = india_based_invoice_prefix+pad(startingNumber, selectDigits);
            return india_based_invoice_id;
        }
        $('#invoice_digits').keyup(function() {
            if($(this).val().length > 0) {
                selectDigits = $(this).val();
                export_invoice_id = cacl_export_invoice_id(selectDigits, startingNumber, export_invoice_prefix);
                $('.export_invoice_id').val(export_invoice_id);
                india_based_invoice_id = cacl_export_invoice_id(selectDigits, startingNumber, india_based_invoice_prefix);
                $('.india_based_invoice_id').val(india_based_invoice_id);
            }
            else {
                selectDigits = 6;
                export_invoice_id = cacl_export_invoice_id(selectDigits, startingNumber, export_invoice_prefix);
                $('.export_invoice_id').val(export_invoice_id);
                india_based_invoice_id = cacl_export_invoice_id(selectDigits, startingNumber, india_based_invoice_prefix);
                $('.india_based_invoice_id').val(india_based_invoice_id);
            }
        });
        $('#starting_no').keyup(function() {
            if($(this).val().length > 0) {
                startingNumber = $(this).val();
                export_invoice_id = cacl_export_invoice_id(selectDigits, startingNumber, export_invoice_prefix);
                $('.export_invoice_id').val(export_invoice_id);
                india_based_invoice_id = cacl_export_invoice_id(selectDigits, startingNumber, india_based_invoice_prefix);
                $('.india_based_invoice_id').val(india_based_invoice_id);
            }
            else {
                startingNumber = 1;
                export_invoice_id = cacl_export_invoice_id(selectDigits, startingNumber, export_invoice_prefix);
                $('.export_invoice_id').val(export_invoice_id);
                india_based_invoice_id = cacl_export_invoice_id(selectDigits, startingNumber, india_based_invoice_prefix);
                $('.india_based_invoice_id').val(india_based_invoice_id);
            }

        });

        
        $('#export_invoice_prefix').keyup(function() {
            if($(this).val().length > 0) {
                export_invoice_prefix = $(this).val();
                //$('.export_invoice_id').val(export_invoice_prefix+export_invoice_id);
                export_invoice_id = cacl_export_invoice_id(selectDigits, startingNumber, export_invoice_prefix);
                $('.export_invoice_id').val(export_invoice_id);
            }
            else {
                export_invoice_prefix = '';
                export_invoice_id = cacl_export_invoice_id(selectDigits, startingNumber, export_invoice_prefix);
                $('.export_invoice_id').val(export_invoice_id);
                //$('.export_invoice_id').val(export_invoice_id);

            }
        });
        
        $('#india_based_invoice_prefix').keyup(function() {
            if($(this).val().length > 0) {
                india_based_invoice_prefix = $(this).val();
                india_based_invoice_id = cacl_export_invoice_id(selectDigits, startingNumber, india_based_invoice_prefix);
                $('.india_based_invoice_id').val(india_based_invoice_id);
            }
            else {
                india_based_invoice_prefix = '';
                india_based_invoice_id = cacl_export_invoice_id(selectDigits, startingNumber, india_based_invoice_prefix);
                $('.india_based_invoice_id').val(india_based_invoice_id);
            }
        });

    </script>
    <script type="text/javascript">
        // check box for enable export invoices
        $('#checkboxExport').change(function() {
            if(this.checked) {
                $('.exportPrefixEnable').css('display', 'block');
                $('.exportPrefixEnableInfo').css('display', 'block');
            }
            else {
                $('.exportPrefixEnable').css('display', 'none');
                $('.exportPrefixEnableInfo').css('display', 'none');

            }
        });
        // if setting is incomplete alert
        <?php if(isset($_SESSION['completeSetting'])) { ?>
            swal('Oops!!!', 'Please complete initial setting before you login.','warning');
        <?php unset($_SESSION['completeSetting']); } ?>   
    </script>
    <!-- loader -->
    <script>
        var myVar;

        function myFunction() {
            myVar = setTimeout(showPage, 3000);
        }

        function showPage() {
          document.getElementById("loader").style.display = "none";
          document.getElementById("myDiv").style.display = "block";
        }
    </script>
</body>
</html>

 