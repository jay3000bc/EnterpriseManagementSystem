<?php
include_once 'function_no_to_words.php';
include('settings/config.php');
date_default_timezone_set('Asia/Kolkata');
$current_date = time();
include_once 'AdminManager.php';
$adminManager = new AdminManager();
$companyInfo = $adminManager->getAdminDetails();
$totalStates = $adminManager->getStates();
include_once 'InvoiceManager.php';
$companyInfo = $adminManager->getAdminDetails();
include_once 'InvoiceManager.php';
$invoiceManager = new InvoiceManager();
$invoiceDetails = $invoiceManager->getPreviewInvoiceDetails();
$invoice_id = $invoiceDetails['invoice_id'];
$totalServices = $invoiceManager->getPreviewServices($invoice_id);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Preview Invoice</title>
</head>
<body>
	<div class="container invoice-box" id="previewInvoiceDetails">
	<div class="row">
		<div class="col-md-12 text-center">
		<?php if($companyInfo['company_logo'] != '') { ?>
			<img src="<?php echo 'uploads/company_profile_images/'.$companyInfo['company_logo'];?>" class="generate-payroll-logo">
		<?php } else { ?>
			<h3><?php echo $companyInfo['company_name']; ?></h3>
		<?php } ?>
		</div>
		<div class="col-md-6 col-md-offset-3 text-center invoice-company-address">
			<h4><?php echo $companyInfo['company_address']; ?></h4>
			<h4>Cell: <?php echo $companyInfo['contact_number']; ?></h4>
			<h4>GSTIN: <?php echo $companyInfo['gstin']; ?></h4>
		</div>
		<div class="col-md-12">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th colspan="2">Tax Invoice</th>
					</tr>
					<tr>
						<th class="text-center">Invoice Details</th>
						<th class="text-center">Bill to Party</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Invoice No.: <?php echo $invoiceDetails['invoice_id']; ?></td>
						<td>Name: <?php echo $invoiceDetails['name']; ?></td>
					</tr>
					<tr>
						<td>Invoice Date: <?php echo $invoiceDetails['invoice_date']; ?></td>
						<td>Address: <?php echo $invoiceDetails['address']; ?></td>
					</tr>
					<tr>
						<td>Reverse Charge: <?php if($invoiceDetails['reverse_charge'] == 0) echo 'No'; else echo 'Yes'; ?></td>
						<td>GSTIN: <?php if($invoiceDetails['gstin'] != '') echo $invoiceDetails['gstin']; else echo "NIL";?></td>
					</tr>
					<tr>
						<td>State: 
							<?php 
							for ($i=0; $i < $totalStates ; $i++) {
								if ($companyInfo['state'] == $i+1) {
									echo $adminManager->state_name[$i].',';
									echo '&nbsp;&nbsp;&nbsp;Code: '.$adminManager->state_gst_code[$i];
								} 
							} 
							?>
						</td>

						<td>State: <?php 
							if($invoiceDetails['state'] == 0) { echo $invoiceDetails['address']; 
							} else {
							for ($i=0; $i < $totalStates ; $i++) {
								if ($invoiceDetails['state'] == $i+1) {
						 		echo $adminManager->state_name[$i].',';
						 		echo '&nbsp;&nbsp;&nbsp;Code: '.$adminManager->state_gst_code[$i]; 
						 		} 
						 	}
						} ?>
							
						</td>
					</tr>
				</tbody>
			</table><hr>
			<table class="table table-bordered">
				<thead>
					
					<tr>
						<th>SL NO.</th>
						<th>Services Description</th>
						<th>SAC Code</th>
						<th>Qnty.</th>
						<th>Price</th>
						<th>SGST</th>
						<th>CGST</th>
						<th>IGST</th>
						<th>Amount</th>
					</tr>

				</thead>
				<tbody>
					<?php 
					$invoiceManager = new InvoiceManager();
					$totalServices = $invoiceManager->getPreviewServices($invoice_id);
					$totalAmountBeforeTax = 0;
					$netAmount = $invoiceDetails['net_amount'];

					for ($i=0; $i < $totalServices ; $i++)  {
						$totalTax = $invoiceManager->sgst[$i] + $invoiceManager->cgst[$i] + $invoiceManager->igst[$i];
						$individualTaxAmount = $invoiceManager->quantity[$i] * $invoiceManager->price[$i] * .01 * $totalTax;
						$amount = $invoiceManager->quantity[$i] * $invoiceManager->price[$i] + $individualTaxAmount;
						$totalAmountBeforeTax = $totalAmountBeforeTax + $invoiceManager->quantity[$i] * $invoiceManager->price[$i];
						?>
					<tr>
						<td><?php echo $i+1; ?></td>
						<td><?php echo $invoiceManager->desc_of_service[$i]; ?></td>
						<td><?php echo $invoiceManager->sac_code[$i]; ?></td>
						<td><?php echo $invoiceManager->quantity[$i]; ?></td>
						<td><?php echo $invoiceManager->price[$i]; ?></td>
						<td><?php echo $invoiceManager->sgst[$i]; ?></td>
						<td><?php echo $invoiceManager->cgst[$i]; ?></td>
						<td><?php echo $invoiceManager->igst[$i]; ?></td>
						<td><?php echo $amount; ?></td>
					</tr>
					<?php } ?>
					<tr>
						<td colspan="8">Total</td>
						<td><?php echo $netAmount; ?></td>
					</tr>
					<tr>
						<td colspan="3">Total invoice amount in words</td>
						<td colspan="3">Total amount before Tax</td>
						<td colspan="3"><?php echo $totalAmountBeforeTax; ?></td>
					</tr>
					<tr>
						<td colspan="3" rowspan="3"><?php echo ucwords(no_to_words($netAmount)); if($netAmount != 0) echo 'only'; ?></td>
					</tr>
					<tr>
						<td colspan="3">Total Tax Amount</td>
						<td colspan="3"><?php echo $netAmount - $totalAmountBeforeTax; ?></td>
					</tr>
					<tr>
						<td colspan="3">Total Amount after Tax</td>
						<td colspan="3"><?php echo $netAmount; ?></td>
					</tr>
				</tbody>
			</table><hr>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Bank Details</th>
						<th>Certified that the particulars given above are true and correct</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$abankDetails = $adminManager->getABankDetails($invoiceDetails['bank_id']); 
					?>
					<tr>
						<td>Bank Name: 
							<?php echo $abankDetails['bank_name']; 
							?></td>
						<td class="text-center">For Alegra Labs</td>
					</tr>
					<tr>
						<td>Bank A/C No.: 
							<?php echo $abankDetails['bank_account_no']; 
							?></td>
						<td rowspan="3" class="text-center">
							<?php 
							if($companyInfo['signature'] != '') { ?>
								<img style="width: 200px; padding-top: 15px;" src="<?php echo 'uploads/company_profile_images/'.$companyInfo['signature'];?>" alt="signature">
							<?php 	
							} else {
								echo 'This is a computer generated invoice and does not require a signature'; 
							} ?>	
						</td>
					</tr>
					<tr>
						<td>Bank IFSC: <?php echo $abankDetails['ifsc']; 
							?> </td>
					</tr>
					<tr>
						<td>PAN No.: <?php echo $companyInfo['pan']; ?></td>
					</tr>
					<tr>
						<td></td>
						<td class="text-center">Authorised Signatory</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
</body>
</html>
