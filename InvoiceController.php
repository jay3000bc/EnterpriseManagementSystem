<?php
session_start();
include_once('settings/config.php');
date_default_timezone_set('Asia/Kolkata');
$current_date = time();
$microtime = microtime(true);
include_once 'DBManager.php';
$DBManager = new DBManager();
include_once 'InvoiceManager.php';
$invoiceManager = new InvoiceManager();
include_once 'AdminManager.php';
$adminManager = new AdminManager();
$companyInfo = $adminManager->getAdminDetails();
// save Invoice of client
if (isset($_POST["saveInvoice"])) { 
	foreach( $_POST as $key => $value )
    {
        $key = 'session_create_invoice'.$key;
        $_SESSION[$key] = $value;
    }
	$client_email = mysqli_real_escape_string($DBManager->conn, $_POST['client_email']);
	$invoice_type = mysqli_real_escape_string($DBManager->conn, $_POST['invoice_type']);
	$currency_type = mysqli_real_escape_string($DBManager->conn, $_POST['currency_type']);
	$invoice_id = mysqli_real_escape_string($DBManager->conn, $_POST['invoice_no']);
	$client_id = mysqli_real_escape_string($DBManager->conn, $_POST['client_id']);
	$client_name = mysqli_real_escape_string($DBManager->conn, $_POST['client_name']);
	$client_address = mysqli_real_escape_string($DBManager->conn, $_POST['client_address']);
	$client_state = '';
	$client_gstin = '';
	if(isset($_POST['client_state']) && ($_POST['client_state'] != '')) {
		$client_state = mysqli_real_escape_string($DBManager->conn, $_POST['client_state']);
	}
	if(isset($_POST['client_gstin']) && ($_POST['client_gstin'] != '')) {
		$client_gstin = mysqli_real_escape_string($DBManager->conn, $_POST['client_gstin']);
	}
	
	$mode_of_invoice = mysqli_real_escape_string($DBManager->conn, $_POST['mode_of_invoice']);
	$invoice_date = mysqli_real_escape_string($DBManager->conn, $_POST['invoice_date']);

	$invoice_date_new = str_replace('/', '-', $_POST['invoice_date']);

	$invoice_date_new = date("Y-m-d", strtotime($invoice_date_new));
	$reverse_charge = mysqli_real_escape_string($DBManager->conn, $_POST['reverse_charge']);
	
	$admin_bank_account = mysqli_real_escape_string($DBManager->conn, $_POST['admin_bank_account']);
	$qty_hrs = mysqli_real_escape_string($DBManager->conn, $_POST['qty_hrs']);
	$net_amount = mysqli_real_escape_string($DBManager->conn, $_POST['net_amount']);

	foreach ($_POST['desc_of_service'] as $key => $value) {
		$desc_of_service = mysqli_real_escape_string($DBManager->conn, $_POST['desc_of_service'][$key]);
		$sac_code = mysqli_real_escape_string($DBManager->conn, $_POST['sac_code'][$key]);
		$quantity = mysqli_real_escape_string($DBManager->conn, $_POST['quantity'][$key]);
		$price = mysqli_real_escape_string($DBManager->conn, $_POST['price'][$key]);
		$cgst = mysqli_real_escape_string($DBManager->conn, $_POST['cgst'][$key]);
		$sgst = mysqli_real_escape_string($DBManager->conn, $_POST['sgst'][$key]);
		$igst = mysqli_real_escape_string($DBManager->conn, $_POST['igst'][$key]);
		if($cgst == '') {
			$cgst = 0;
		}
		if($sgst == '') {
			$sgst = 0;
		}
		if($igst == '') {
			$igst = 0;
		}
		$result1 = $invoiceManager->saveInvoiceAmount($invoice_id, $desc_of_service, $sac_code, $quantity, $price, $cgst, $sgst, $igst);
	}
	$result2 = $invoiceManager->saveInvoice($invoice_id, $invoice_type, $client_id, $client_name, $client_email, $client_address, $client_gstin, $client_state, $mode_of_invoice, $reverse_charge, $admin_bank_account, $currency_type, $qty_hrs, $net_amount, $invoice_date, $invoice_date_new);
	
	
	if($result2) {

		$reset_counter = mysqli_real_escape_string($DBManager->conn, $_POST['reset_counter']);
		$reset_year = mysqli_real_escape_string($DBManager->conn, $_POST['reset_year']);
	
		$update_counter = mysqli_real_escape_string($DBManager->conn, $_POST['update_counter']);
		
		// If Year is current year then update counter only.
		// If Year is not current year then update counter and year.
			if( ($reset_counter!=0) && ($reset_year!=0) ){
				$invoiceManager->updateCounter_Year($reset_counter, $reset_year);
			}
			else if( ($reset_counter==0) && ($reset_year==0)  ){
				$update_counter = $update_counter + 1;
				$invoiceManager->updateCounter($update_counter);
			}


		foreach( $_POST as $key => $value )
        {
            $key = 'session_create_invoice'.$key;
            unset($_SESSION[$key]); 
            
        }
		if($invoice_type == 0)  {
			$current_national_id = mysqli_real_escape_string($DBManager->conn, $_POST['current_national_id']);
			$updateAutoId = $invoiceManager->updateNatioanlId($current_national_id);
		} else {
			$current_export_id = mysqli_real_escape_string($DBManager->conn, $_POST['current_export_id']);
			$updateAutoId = $invoiceManager->updateExportlId($current_export_id);
		}
		// GENERATE PDF
		$generatePdfUrl = $absoluteUrl."generateInvoice.php?invoice_id=".$invoice_id;

		$pdf=exec('/usr/local/bin/wkhtmltopdf --page-size A4 --print-media-type --include-in-outline --encoding UTF-8 "'.$generatePdfUrl.'" uploads/invoices/createdInvoice/'.$invoice_id.'.pdf 2>&1');
		if(!$pdf) {
			$_SESSION['ErrorMsgInvoice'] = 'Failed to generate Invoice pdf. Its seems you have not installed WKHTMLTOPDF on server or on local machine also enable exec function of php if it is in disbaled list.';
			header('location:createInvoice');
		}
		// send invoice details to client
		//if($sendEmailToClient == true) {
		if($_POST['sendEmailToClient'] == 1) {
			$invoicelink = $absoluteUrl.'uploads/invoices/createdInvoice/'.$invoice_id.'.pdf';
			include_once 'emails/invoiceEmailToClient.php';

			mail($client_email, $invoiceSubject, $message, $from);

			if(isset($_POST['sendAdditionalEmails'])) {
				foreach ($_POST['sendAdditionalEmails'] as $key => $additionalEmail) {
					mail($additionalEmail, $invoiceSubject, $message, $from);
				}
			}
		}	
		// end
		if($_POST['saveInvoice'] == 'Print') {
			$_SESSION['successMsg'] = 'success';
			header('location:generateInvoice.php?print_invoice='.$invoice_id);
		} else {
			$_SESSION['successMsg'] = 'success';
			header('location:viewInvoices');
		}
		
	} else {
		$_SESSION['errorMsg'] = 'fail';
		header('location:createInvoice');
	}


		
}
// End
// update invoices of client
if (isset($_POST["saveEditedInvoice"])) { 
	$client_email = mysqli_real_escape_string($DBManager->conn, $_POST['client_email']);
	$invoice_type = mysqli_real_escape_string($DBManager->conn, $_POST['invoice_type']);
	$currency_type = mysqli_real_escape_string($DBManager->conn, $_POST['currency_type']);
	$invoice_id = mysqli_real_escape_string($DBManager->conn, $_POST['invoice_no']);
	$client_id = mysqli_real_escape_string($DBManager->conn, $_POST['client_id']);
	$client_name = mysqli_real_escape_string($DBManager->conn, $_POST['client_name']);
	$client_address = mysqli_real_escape_string($DBManager->conn, $_POST['client_address']);
	$client_state = '';
	$client_gstin = '';
	if(isset($_POST['client_state']) && ($_POST['client_state'] != '')) {
		$client_state = mysqli_real_escape_string($DBManager->conn, $_POST['client_state']);
		$client_gstin = mysqli_real_escape_string($DBManager->conn, $_POST['client_gstin']);
	}
	
	$mode_of_invoice = mysqli_real_escape_string($DBManager->conn, $_POST['mode_of_invoice']);
	$invoice_date = mysqli_real_escape_string($DBManager->conn, $_POST['invoice_date']);

	$invoice_date_new = str_replace('/', '-', $_POST['invoice_date']);

	$invoice_date_new = date("Y-m-d", strtotime($invoice_date_new));
	$reverse_charge = mysqli_real_escape_string($DBManager->conn, $_POST['reverse_charge']);
	
	$admin_bank_account = mysqli_real_escape_string($DBManager->conn, $_POST['admin_bank_account']);
	$qty_hrs = mysqli_real_escape_string($DBManager->conn, $_POST['qty_hrs']);
	
	$net_amount = mysqli_real_escape_string($DBManager->conn, $_POST['net_amount']);

	if(isset($_POST['desc_of_service_old'])) {

		foreach ($_POST['desc_of_service_old'] as $key_old => $value) {
			$service_id = mysqli_real_escape_string($DBManager->conn, $_POST['service_id_old'][$key_old]);
			$desc_of_service = mysqli_real_escape_string($DBManager->conn, $_POST['desc_of_service_old'][$key_old]);
			$sac_code = mysqli_real_escape_string($DBManager->conn, $_POST['sac_code_old'][$key_old]);
			$quantity = mysqli_real_escape_string($DBManager->conn, $_POST['quantity_old'][$key_old]);
			$price = mysqli_real_escape_string($DBManager->conn, $_POST['price_old'][$key_old]);
			$cgst = mysqli_real_escape_string($DBManager->conn, $_POST['cgst_old'][$key_old]);
			$sgst = mysqli_real_escape_string($DBManager->conn, $_POST['sgst_old'][$key_old]);
			$igst = mysqli_real_escape_string($DBManager->conn, $_POST['igst_old'][$key_old]);
			if($cgst == '') {
				$cgst = 0;
			}
			if($sgst == '') {
				$sgst = 0;
			}
			if($igst == '') {
				$igst = 0;
			}
			$result1 = $invoiceManager->updateInvoiceAmount($service_id, $invoice_id, $desc_of_service, $sac_code, $quantity, $price, $cgst, $sgst, $igst);
		}
	}
	if(isset($_POST['desc_of_service'])){
		foreach ($_POST['desc_of_service'] as $key_new => $value) {
			$desc_of_service = mysqli_real_escape_string($DBManager->conn, $_POST['desc_of_service'][$key_new]);
			$sac_code = mysqli_real_escape_string($DBManager->conn, $_POST['sac_code'][$key_new]);
			$quantity = mysqli_real_escape_string($DBManager->conn, $_POST['quantity'][$key_new]);
			$price = mysqli_real_escape_string($DBManager->conn, $_POST['price'][$key_new]);
			$cgst = mysqli_real_escape_string($DBManager->conn, $_POST['cgst'][$key_new]);
			$sgst = mysqli_real_escape_string($DBManager->conn, $_POST['sgst'][$key_new]);
			$igst = mysqli_real_escape_string($DBManager->conn, $_POST['igst'][$key_new]);
			if($cgst == '') {
				$cgst = 0;
			}
			if($sgst == '') {
				$sgst = 0;
			}
			if($igst == '') {
				$igst = 0;
			}
			$result1 = $invoiceManager->saveInvoiceAmount($invoice_id, $desc_of_service, $sac_code, $quantity, $price, $cgst, $sgst, $igst);
		}
	}
	$result2 = $invoiceManager->saveEditedInvoice($invoice_id, $invoice_type, $client_id, $client_name, $client_email, $client_address, $client_gstin, $client_state, $mode_of_invoice, $reverse_charge, $admin_bank_account, $currency_type, $qty_hrs, $net_amount, $invoice_date, $invoice_date_new);
	
	
	if($result2) {
		// GENERATE PDF
		$generatePdfUrl = $absoluteUrl."generateInvoice.php?invoice_id=".$invoice_id;

		$pdf=exec('/usr/local/bin/wkhtmltopdf --page-size A4 --print-media-type --include-in-outline --encoding UTF-8 "'.$generatePdfUrl.'" uploads/invoices/createdInvoice/'.$invoice_id.'.pdf 2>&1');
		if(!$pdf) {
			$_SESSION['ErrorMsgInvoice'] = 'Failed to generate Invoice pdf. Its seems you have not installed WKHTMLTOPDF on server or on local machine also enable exec function of php if it is in disbaled list.';
			header('location:createInvoice');
		}
		// send invoice details to client
		if($_POST['sendEmailToClient'] == 1) {
			$invoicelink = $absoluteUrl.'uploads/invoices/createdInvoice/'.$invoice_id.'.pdf';
			include_once 'emails/invoiceEmailToClient.php';

			//mail($client_email, $invoiceSubject, $message, $from);

			if(isset($_POST['sendAdditionalEmails'])) {
				foreach ($_POST['sendAdditionalEmails'] as $key => $additionalEmail) {
					mail($additionalEmail, $invoiceSubject, $message, $from);
					if(mail($additionalEmail, $invoiceSubject, $message, $from)) {
						
					} else {
						
					}
				}
			}

		}	
		// end
		if($_POST['saveEditedInvoice'] == 'Print') {
			$_SESSION['successMsg'] = 'success';
			header('location:generateInvoice.php?print_invoice='.$invoice_id);
		} else {
			$_SESSION['successMsg'] = 'success';
			header('location:viewInvoices');
		}
		
	} else {
		$_SESSION['errorMsg'] = 'fail';
		header('location:editCreatedInvoice');
	}
}
// End
// preview Invoice

if (isset($_POST["previewInvoice"])) { 
	$invoice_type = mysqli_real_escape_string($DBManager->conn, $_POST['invoice_type']);
	$currency_type = mysqli_real_escape_string($DBManager->conn, $_POST['currency_type']);
	$invoice_id = mysqli_real_escape_string($DBManager->conn, $_POST['invoice_no']);
	$client_id = mysqli_real_escape_string($DBManager->conn, $_POST['client_id']);
	$client_name = mysqli_real_escape_string($DBManager->conn, $_POST['client_name']);
	$client_address = mysqli_real_escape_string($DBManager->conn, $_POST['client_address']);
	$client_state = '';
	$client_gstin = '';
	if(isset($_POST['client_state']) && ($_POST['client_state'] != '')) {
		$client_state = mysqli_real_escape_string($DBManager->conn, $_POST['client_state']);
	}
	if(isset($_POST['client_gstin']) && ($_POST['client_gstin'] != '')) {
		$client_gstin = mysqli_real_escape_string($DBManager->conn, $_POST['client_gstin']);
	}
	$mode_of_invoice = mysqli_real_escape_string($DBManager->conn, $_POST['mode_of_invoice']);
	$invoice_date = mysqli_real_escape_string($DBManager->conn, $_POST['invoice_date']);
	$reverse_charge = mysqli_real_escape_string($DBManager->conn, $_POST['reverse_charge']);
	
	$admin_bank_account = mysqli_real_escape_string($DBManager->conn, $_POST['admin_bank_account']);
	$qty_hrs = mysqli_real_escape_string($DBManager->conn, $_POST['qty_hrs']);
	$net_amount = mysqli_real_escape_string($DBManager->conn, $_POST['net_amount']);
	$deleteAllPreviewServices = $invoiceManager->deleteAllPreviewServices();


	if(isset($_POST['desc_of_service_old'])) {

		foreach ($_POST['desc_of_service_old'] as $key_old => $value) {
			$service_id = mysqli_real_escape_string($DBManager->conn, $_POST['service_id_old'][$key_old]);
			$desc_of_service = mysqli_real_escape_string($DBManager->conn, $_POST['desc_of_service_old'][$key_old]);
			$sac_code = mysqli_real_escape_string($DBManager->conn, $_POST['sac_code_old'][$key_old]);
			$quantity = mysqli_real_escape_string($DBManager->conn, $_POST['quantity_old'][$key_old]);
			$price = mysqli_real_escape_string($DBManager->conn, $_POST['price_old'][$key_old]);
			$cgst = mysqli_real_escape_string($DBManager->conn, $_POST['cgst_old'][$key_old]);
			$sgst = mysqli_real_escape_string($DBManager->conn, $_POST['sgst_old'][$key_old]);
			$igst = mysqli_real_escape_string($DBManager->conn, $_POST['igst_old'][$key_old]);
			if($cgst == '') {
				$cgst = 0;
			}
			if($sgst == '') {
				$sgst = 0;
			}
			if($igst == '') {
				$igst = 0;
			}
			$result1 = $invoiceManager->previewInvoiceAmount($invoice_id, $desc_of_service, $sac_code, $quantity, $price, $cgst, $sgst, $igst);
		}
	}
	if(isset($_POST['desc_of_service'])){
		foreach ($_POST['desc_of_service'] as $key_new => $value) {
			$desc_of_service = mysqli_real_escape_string($DBManager->conn, $_POST['desc_of_service'][$key_new]);
			$sac_code = mysqli_real_escape_string($DBManager->conn, $_POST['sac_code'][$key_new]);
			$quantity = mysqli_real_escape_string($DBManager->conn, $_POST['quantity'][$key_new]);
			$price = mysqli_real_escape_string($DBManager->conn, $_POST['price'][$key_new]);
			$cgst = mysqli_real_escape_string($DBManager->conn, $_POST['cgst'][$key_new]);
			$sgst = mysqli_real_escape_string($DBManager->conn, $_POST['sgst'][$key_new]);
			$igst = mysqli_real_escape_string($DBManager->conn, $_POST['igst'][$key_new]);
			if($cgst == '') {
				$cgst = 0;
			}
			if($sgst == '') {
				$sgst = 0;
			}
			if($igst == '') {
				$igst = 0;
			}
			$result1 = $invoiceManager->previewInvoiceAmount($invoice_id, $desc_of_service, $sac_code, $quantity, $price, $cgst, $sgst, $igst);
		}
	}

	$result2 = $invoiceManager->previewInvoice($invoice_id, $client_id, $client_name, $client_address, $client_gstin, $client_state, $mode_of_invoice, $reverse_charge, $admin_bank_account, $currency_type, $qty_hrs, $net_amount, $invoice_date);
	
	
	if($result2) {
		$_SESSION['previewSuccess'] = 'previewSuccess';
		echo "success";
	} else {
		$_SESSION['errorMsg'] = 'fail';
		echo "fail";
	}
}

// receive Invoice

if (isset($_POST["saveReceiveInvoice"])) { 
	foreach( $_POST as $key => $value )
    {
        $key = 'session_receive_invoice'.$key;
        $_SESSION[$key] = $value;
    }
	$invoice_id = mysqli_real_escape_string($DBManager->conn, $_POST['invoice_no']);
	$client_name = mysqli_real_escape_string($DBManager->conn, $_POST['client_name']);
	$client_address = mysqli_real_escape_string($DBManager->conn, $_POST['client_address']);
	$client_email = mysqli_real_escape_string($DBManager->conn, $_POST['client_email']);
	$client_contact_no = mysqli_real_escape_string($DBManager->conn, $_POST['client_contact_no']);
	$client_gstin = mysqli_real_escape_string($DBManager->conn, $_POST['client_gstin']);
	$currency_type = mysqli_real_escape_string($DBManager->conn, $_POST['currency_type']);
	$invoice_date = mysqli_real_escape_string($DBManager->conn, $_POST['invoice_date']);
	$invoice_date_new = str_replace('/', '-', $_POST['invoice_date']);
	$invoice_date_new = date("Y-m-d", strtotime($invoice_date_new));
	$invoice_amount = mysqli_real_escape_string($DBManager->conn, $_POST['invoice_amount']);

	// upload invoice file
	if($_FILES["upload_invoice"]['name'][0] != '') {
        $target_dir = "uploads/invoices/receivedInvoice/";
        $target_file = $target_dir . $microtime. basename($_FILES["upload_invoice"]["name"]);
        //echo $target_file; die();
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        
        // Check if file already exists
        if (file_exists($target_file)) {
            //echo "string"; die();
            $_SESSION['ErrorMsg'] = "Sorry, file already exists.";
            header('Location:receiveInvoice');
            exit();
        } 
         // Check file size
        elseif ($_FILES["upload_invoice"]["size"] > 5242880) {
            $_SESSION['ErrorMsg'] = "Sorry, image file is too large. Maximum file size must be less than 5MB.";
            header('Location:receiveInvoice');
            exit();
        }
        // Allow certain file formats
        elseif ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "pdf" && $imageFileType != "xps" && $imageFileType != "doc" && $imageFileType != "docx" ) {
            $_SESSION['ErrorMsg'] = "Sorry, only JPG, JPEG, PNG, PDF, DOC and DOCX  files are allowed.";
            header('Location:receiveInvoice');
            exit();
        }
        else {
            if (move_uploaded_file($_FILES["upload_invoice"]["tmp_name"], $target_file)) {
                $upload_invoice = $microtime.basename($_FILES["upload_invoice"]["name"]);
                //die();
                $_SESSION['session_receive_invoice_upload'] = $upload_invoice;
            } else {
                $_SESSION['ErrorMsg'] = "Sorry, there was an error uploading your file.";
                header('Location:receiveInvoice');
                exit();

            }
        }
    }
    else {
        $upload_invoice = '';
        if(isset($_POST['previousUploadfile'])) {
        	$upload_invoice = $_POST['previousUploadfile'];
        }
    }
    foreach ($_POST['desc_of_service'] as $key => $value) {
		$desc_of_service = mysqli_real_escape_string($DBManager->conn, $_POST['desc_of_service'][$key]);
		$sac_code = mysqli_real_escape_string($DBManager->conn, $_POST['sac_code'][$key]);
		$quantity = mysqli_real_escape_string($DBManager->conn, $_POST['quantity'][$key]);
		$price = mysqli_real_escape_string($DBManager->conn, $_POST['price'][$key]);
		$cgst = mysqli_real_escape_string($DBManager->conn, $_POST['cgst'][$key]);
		$sgst = mysqli_real_escape_string($DBManager->conn, $_POST['sgst'][$key]);
		$igst = mysqli_real_escape_string($DBManager->conn, $_POST['igst'][$key]);
		if($cgst == '') {
			$cgst = 0;
		}
		if($sgst == '') {
			$sgst = 0;
		}
		if($igst == '') {
			$igst = 0;
		}
		$result1 = $invoiceManager->saveReceiveInvoiceAmount($invoice_id, $desc_of_service, $sac_code, $quantity, $price, $cgst, $sgst, $igst);
	}

	$result = $invoiceManager->saveReceiveInvoice($invoice_id, $client_name, $client_address, $client_email, $client_contact_no, $invoice_date, $currency_type, $invoice_amount, $client_gstin, $upload_invoice, $invoice_date_new );
	
	if($result) {
		foreach( $_POST as $key => $value )
        {
            $key = 'session_receive_invoice'.$key;
            unset($_SESSION[$key]); 
            unset($_SESSION['session_receive_invoice_upload']);
        }
		$_SESSION['successMsg'] = 'success';
		header('location:receiveInvoice');
	} else {
		$_SESSION['errorMsg'] = 'fail';
		header('location:receiveInvoice');
	}
}

// receive Invoice Update 

if (isset($_POST["updateReceiveInvoice"])) { 
	
	foreach( $_POST as $key => $value )
    {
        $key = 'session_receive_invoice'.$key;
        $_SESSION[$key] = $value;
    }

	$receive_id =  mysqli_real_escape_string($DBManager->conn, $_POST['receive_id']);
	$invoice_id = mysqli_real_escape_string($DBManager->conn, $_POST['invoice_no']);
	$client_name = mysqli_real_escape_string($DBManager->conn, $_POST['client_name']);
	$client_address = mysqli_real_escape_string($DBManager->conn, $_POST['client_address']);
	$client_email = mysqli_real_escape_string($DBManager->conn, $_POST['client_email']);
	$client_contact_no = mysqli_real_escape_string($DBManager->conn, $_POST['client_contact_no']);
	$client_gstin = mysqli_real_escape_string($DBManager->conn, $_POST['client_gstin']);
	$currency_type = mysqli_real_escape_string($DBManager->conn, $_POST['currency_type']);
	$invoice_date = mysqli_real_escape_string($DBManager->conn, $_POST['invoice_date']);
	$invoice_date_new = str_replace('/', '-', $_POST['invoice_date']);
	$invoice_date_new = date("Y-m-d", strtotime($invoice_date_new));
	$invoice_amount = mysqli_real_escape_string($DBManager->conn, $_POST['invoice_amount']);

	$previous_uploaded_invoice = mysqli_real_escape_string($DBManager->conn, $_POST['previous_uploaded_invoice']);

	
	// upload invoice file
	if($_FILES["upload_invoice"]['name'][0] != '') {
        $target_dir = "uploads/invoices/receivedInvoice/";
        $target_file = $target_dir . $microtime. basename($_FILES["upload_invoice"]["name"]);
        //echo $target_file; die();
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

		if(!empty($previous_uploaded_invoice)){
			unlink("uploads/invoices/receivedInvoice/".$previous_uploaded_invoice);
		}
        
        // Check if file already exists
        if (file_exists($target_file)) {
            //echo "string"; die();
            $_SESSION['ErrorMsg'] = "Sorry, file already exists.";
            header('Location:receiveInvoice');
            exit();
        } 
         // Check file size
        elseif ($_FILES["upload_invoice"]["size"] > 5242880) {
            $_SESSION['ErrorMsg'] = "Sorry, image file is too large. Maximum file size must be less than 5MB.";
            header('Location:receiveInvoice');
            exit();
        }
        // Allow certain file formats
        elseif ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "pdf" && $imageFileType != "xps" && $imageFileType != "doc" && $imageFileType != "docx" ) {
            $_SESSION['ErrorMsg'] = "Sorry, only JPG, JPEG, PNG, PDF, DOC and DOCX  files are allowed.";
            header('Location:receiveInvoice');
            exit();
        }
        else {
            if (move_uploaded_file($_FILES["upload_invoice"]["tmp_name"], $target_file)) {
                $upload_invoice = $microtime.basename($_FILES["upload_invoice"]["name"]);
                //die();
                $_SESSION['session_receive_invoice_upload'] = $upload_invoice;
            } else {
                $_SESSION['ErrorMsg'] = "Sorry, there was an error uploading your file.";
                header('Location:receiveInvoice');
                exit();

            }
        }
    }
   /* else {
        $upload_invoice = '';
        if(isset($_POST['previousUploadfile'])) {
        	$upload_invoice = $_POST['previousUploadfile'];
        }
    }*/
    foreach ($_POST['desc_of_service'] as $key => $value) {

		if(!empty($_POST['invoice_receive_amount_id'][$key])){
			$invoice_receive_amount_id = mysqli_real_escape_string($DBManager->conn, $_POST['invoice_receive_amount_id'][$key]); 
		}
		else {
			$invoice_receive_amount_id='';
		}

		$desc_of_service = mysqli_real_escape_string($DBManager->conn, $_POST['desc_of_service'][$key]);
		$sac_code = mysqli_real_escape_string($DBManager->conn, $_POST['sac_code'][$key]);
		$quantity = mysqli_real_escape_string($DBManager->conn, $_POST['quantity'][$key]);
		$price = mysqli_real_escape_string($DBManager->conn, $_POST['price'][$key]);
		$cgst = mysqli_real_escape_string($DBManager->conn, $_POST['cgst'][$key]);
		$sgst = mysqli_real_escape_string($DBManager->conn, $_POST['sgst'][$key]);
		$igst = mysqli_real_escape_string($DBManager->conn, $_POST['igst'][$key]);
		if($cgst == '') {
			$cgst = 0;
		}
		if($sgst == '') {
			$sgst = 0;
		}
		if($igst == '') {
			$igst = 0;
		}

		/*$check = $invoiceManager->checkID($invoice_receive_amount_id);
		if(!empty($check)){
			$result1 = $invoiceManager->saveReceiveInvoiceAmountUpdate($invoice_receive_amount_id,$invoice_id, $desc_of_service, $sac_code, $quantity, $price, $cgst, $sgst, $igst);
		}*/
		
		//$result1 = $invoiceManager->saveReceiveInvoiceAmount($invoice_id, $desc_of_service, $sac_code, $quantity, $price, $cgst, $sgst, $igst);
		$result1 = $invoiceManager->saveReceiveInvoiceAmountUpdate($invoice_receive_amount_id,$invoice_id, $desc_of_service, $sac_code, $quantity, $price, $cgst, $sgst, $igst);
	}

	$result = $invoiceManager->saveReceiveInvoiceUpdate($receive_id,$invoice_id, $client_name, $client_address, $client_email, $client_contact_no, $invoice_date, $currency_type, $invoice_amount, $client_gstin, $upload_invoice, $invoice_date_new );
	
	if($result) {
		foreach( $_POST as $key => $value )
        {
            $key = 'session_receive_invoice'.$key;
            unset($_SESSION[$key]); 
            unset($_SESSION['session_receive_invoice_upload']);
        }
		$_SESSION['successMsg'] = 'success';
		header('location:edit_receive_invoice?id='.$receive_id);
	} else {
		$_SESSION['errorMsg'] = 'fail';
		header('location:edit_receive_invoice?id='.$receive_id);
	}
}

// receive Invoice Update

// delete receive invoice amount


if( isset($_POST['deleteRow']) ){
	$id = mysqli_real_escape_string($DBManager->conn, $_POST['deleteRow']);
	echo $result = $invoiceManager->deleteReceiveAmountRow($id);
}

// delete receive invoice amount

if (isset($_POST["status"])) { 
	$invoice_id = mysqli_real_escape_string($DBManager->conn, $_POST['invoice_id']);
	$status = mysqli_real_escape_string($DBManager->conn, $_POST['status']);
	$invoice_type = mysqli_real_escape_string($DBManager->conn, $_POST['invoice_type']);
	$result = $invoiceManager->changeStatus($invoice_id, $status, $invoice_type);
	if($result) {
		echo "success";
	} else {
		echo "fail";
	}
}
// check_already_exist_value receive invoice id
if(isset($_POST['check_already_exist_value'])) {
    $invoiceManager = new InvoiceManager();
    $field_value = mysqli_real_escape_string($DBManager->conn, $_POST['check_already_exist_value']);
    $field_name = mysqli_real_escape_string($DBManager->conn, $_POST['field_name']);
    echo $result = $invoiceManager->check_already_exist_value($field_value, $field_name);
}

// add credit note 

if(isset($_POST['add_credit_note_id'])) {
	$invoiceManager = new InvoiceManager();
	$invoice_id = mysqli_real_escape_string($DBManager->conn, $_POST['add_credit_note_id']);
	$credit_note = mysqli_real_escape_string($DBManager->conn, $_POST['credit_note']);
	$invoice_type = mysqli_real_escape_string($DBManager->conn, $_POST['credit_note_save_invoice_type']);

	echo $result = $invoiceManager->saveCreditNote($invoice_id, $invoice_type, $credit_note);

}

// delete old services

if(isset($_POST['action']) && ($_POST["action"] == 'delete_old_services')) {
	$invoiceManager = new InvoiceManager();
	$invoice_id = mysqli_real_escape_string($DBManager->conn, $_POST['old_invoice_id']);
	$service_id = mysqli_real_escape_string($DBManager->conn, $_POST['old_service_id']);
	$net_amount_after_row_remove = mysqli_real_escape_string($DBManager->conn, $_POST['net_amount_after_row_remove']);
	echo $result = $invoiceManager->deleteOldService($invoice_id, $service_id, $net_amount_after_row_remove);

}