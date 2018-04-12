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
foreach ($currencies as $key => $currency) {
	if($key == $invoiceDetails['currency_type']) {
		if($key == 'rupee') {
			$currency_type = '<i class="fa fa-inr" aria-hidden="true"></i>';
		} else {
			$currency_type = $currency;
		}
		
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Preview Invoice</title>
	<!-- Font Awesome -->
  	<link rel="stylesheet" href="plugins/font-awesome/css/font-awesome.min.css">
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
			<table class="table table-bordered" style="width: 100%;">
				<thead>
					<tr>
						<th colspan="2">Tax Invoice</th>
					</tr>
					<tr>
						<th class="text-center" style="width: 50%;">Invoice Details</th>
						<th class="text-center" style="width: 50%;">Bill to Party</th>
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
							if (!is_numeric($invoiceDetails['state'])) { echo $invoiceDetails['state']; 
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
						<th class="text-center">SL NO.</th>
						<th class="text-center">Services Description</th>
						<th class="text-center">HSN/ SAC Code</th>
						<th class="text-center">Qnty.</th>
						<th class="text-center">Price</th>
						<th class="text-center">SGST <br>( % )</th>
						<th class="text-center">CGST <br>( % )</th>
						<th class="text-center">IGST <br>( % )</th>
						<th class="text-center">Amount <br><?php echo '( '.$currency_type.' )'; ?> </th>
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
						<td class="text-center"><?php echo $i+1; ?></td>
						<td class="text-center"><?php echo $invoiceManager->desc_of_service[$i]; ?></td>
						<td class="text-center"><?php echo $invoiceManager->sac_code[$i]; ?></td>
						<td class="text-center"><?php echo $invoiceManager->quantity[$i]; ?></td>
						<td class="text-center"><?php echo $invoiceManager->price[$i]; ?></td>
						<td class="text-center"><?php echo $invoiceManager->sgst[$i]; ?></td>
						<td class="text-center"><?php echo $invoiceManager->cgst[$i]; ?></td>
						<td class="text-center"><?php echo $invoiceManager->igst[$i]; ?></td>
						<td class="text-center"><?php echo sprintf('%0.2f', $amount); ?></td>
					</tr>
					<?php } ?>
					<tr>
						<td colspan="8">Total</td>
						<td class="text-center"><?php  echo sprintf('%0.2f', $netAmount); ?>
								
							</td>
					</tr>
					<tr>
						<td colspan="4">Total invoice amount in words</td>
						<td colspan="4">Total amount before Tax</td>
						<td class="text-center" colspan="1"><?php echo sprintf('%0.2f', $totalAmountBeforeTax); ?></td>
					</tr>
					<tr>
						<td colspan="4" rowspan="3"><?php echo ucwords(no_to_words($netAmount)); if($netAmount != 0) echo 'only'; ?></td>
					</tr>
					<tr>
						<td colspan="4">Total Tax Amount <?php echo '( '.$totalTax.'% )'; ?></td>
						<td class="text-center" colspan="1"><?php $totalTaxAmount = $netAmount - $totalAmountBeforeTax; echo sprintf('%0.2f', $totalTaxAmount); ?></td>
					</tr>
					<tr>
						<td colspan="4">Total Amount after Tax</td>
						<td class="text-center" colspan="1"><?php echo sprintf('%0.2f', $netAmount); ?></td>
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
