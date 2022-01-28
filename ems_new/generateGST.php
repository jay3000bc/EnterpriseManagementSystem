<?php
include('settings/config.php');
date_default_timezone_set('Asia/Kolkata');
include_once 'GSTManager.php';
$GSTManager = new GSTManager();
if(isset($_GET['period'])) {
	$period = $_GET['period'];
} elseif(isset($_GET['period_print'])) {
	$period = $_GET['period_print'];
} else {
    $period = date("Y-m",strtotime("-1 month"));
}

$resultSale = $GSTManager->getSaleDetailsbyPeriod($period);
$resultPurchase = $GSTManager->getPurchaseDetailsbyPeriod($period);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Generating GST</title>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/custom.css">
    <!-- Font Awesome -->
    
    <link rel="stylesheet" href="plugins/font-awesome/css/font-awesome.min.css">
</head>
<body>
	<div class="container-fluid gst_box">
		<div class="row">
			<div class="col-md-12">
                <?php if($resultSale != '') { ?>
				<h4><b>SALE DETAILS</b></h4>
				<table id="display_gst_table" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>SL No.</th>
                            <th>Customer Name</th>
                            <th>GSTIN</th>
                            <th>Bill No.</th>
                            <th>Bill Date</th>
                            <th>Bill Paid Date</th>
                            <th>Item</th>
                            <th>GST Rate</th>
                            <th>HSN/ SAC Code</th>
                            <th>Amount Without Tax</th>
                            <th>CGST Amt.</th>
                            <th>SGST Amt.</th>
                            <th>IGST Amt.</th>
                            <th>Total Invoice Amt.</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        for($i=0; $i< $resultSale; $i++) {
                         ?>   
                        <tr>
                            <td><?php echo $i+1;?></td>
                            <td><?php echo $GSTManager->client_name[$i];?></td>
                            <td><?php echo $GSTManager->gstin[$i];?></td>
                            <td><?php echo $GSTManager->invoice_id[$i];?></td>
                            <td><?php echo $GSTManager->invoice_date[$i];?></td>
                            <td><?php echo date("d/m/Y", strtotime($GSTManager->invoice_paid_date[$i]));?></td>
                            <td><?php echo $GSTManager->desc_of_service[$i];?></td>
                            <td></td>
                            <td><?php echo $GSTManager->sac_code[$i];?></td>
                            <?php 
                            foreach ($currencies as $key => $currency) {
                                if($key == $GSTManager->currency_type[$i]) {
                                    if($key == 'rupee') {
                                        $currency_type = '<i class="fa fa-inr" aria-hidden="true"></i>';
                                    } else {
                                        $currency_type = $currency;
                                    }
                                } 
                            } ?>
                            <td>
                            <?php 
                            $totalAmountBeforeTax = 0;
                            $totalTax = $GSTManager->sgst[$i] + $GSTManager->cgst[$i] + $GSTManager->igst[$i];
                            $individualTaxAmount = $GSTManager->quantity[$i] * $GSTManager->price[$i] * .01 * $totalTax;
                            $totalAmountBeforeTax = $totalAmountBeforeTax + $GSTManager->quantity[$i] * $GSTManager->price[$i];

                            $cgstAmt = $GSTManager->quantity[$i] * $GSTManager->price[$i] * .01 * $GSTManager->cgst[$i];
                            $sgstAmt = $GSTManager->quantity[$i] * $GSTManager->price[$i] * .01 * $GSTManager->sgst[$i];
                            $igstAmt = $GSTManager->quantity[$i] * $GSTManager->price[$i] * .01 * $GSTManager->igst[$i];
                            echo $currency_type.' '.sprintf('%0.2f', $totalAmountBeforeTax);?></td>
                            <td><?php echo $currency_type.' '.sprintf('%0.2f', $cgstAmt);?></td>
                            <td><?php echo $currency_type.' '.sprintf('%0.2f', $sgstAmt);?></td>
                            <td><?php echo $currency_type.' '.sprintf('%0.2f', $igstAmt);?></td>
                            <td><?php  $total_amount = $GSTManager->quantity[$i] * $GSTManager->price[$i] + $cgstAmt + $sgstAmt + $igstAmt;
                            echo $currency_type.' '.sprintf('%0.2f', $total_amount);
                                ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                     </tbody>
                </table><br>
                <?php } ?>
                    <?php if($resultPurchase != '') { ?>
                <h4><b>PURCHASE DETAILS</b></h4>
                <table id="display_gst_purchase_table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>SL No.</th>
                            <th>Supplier Name</th>
                            <th>GSTIN</th>
                            <th>Bill No.</th>
                            <th>Bill Date</th>
                            <th>Bill Paid Date</th>
                            <th>Item</th>
                            <th>GST Rate</th>
                            <th>HSN/ SAC Code</th>
                            <th>Amount Without Tax</th>
                            <th>CGST Amt.</th>
                            <th>SGST Amt.</th>
                            <th>IGST Amt.</th>
                            <th>Total Invoice Amt.</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        for($i=0; $i< $resultPurchase; $i++) {
                         ?>   
                        <tr>
                            <td><?php echo $i+1;?></td>
                            <td><?php echo $GSTManager->receive_client_name[$i];?></td>
                            <td><?php echo $GSTManager->receive_gstin[$i];?></td>
                            <td><?php echo $GSTManager->receive_invoice_id[$i];?></td>
                            <td><?php echo $GSTManager->receive_invoice_date[$i];?></td>
                            <td><?php echo date("d/m/Y", strtotime($GSTManager->receive_invoice_paid_date[$i]));?></td>
                            <td><?php echo $GSTManager->receive_desc_of_service[$i];?></td>
                            <td></td>
                            <td><?php echo $GSTManager->receive_sac_code[$i];?></td>
                            <?php 
                            foreach ($currencies as $key => $currency) {
                                if($key == $GSTManager->receive_currency_type[$i]) {
                                    if($key == 'rupee') {
                                        $currency_type = '<i class="fa fa-inr" aria-hidden="true"></i>';
                                    } else {
                                        $currency_type = $currency;
                                    }
                                } 
                            } ?>
                            <td>
                            <?php 
                            $totalAmountBeforeTax = 0;
                            $totalTax = $GSTManager->receive_sgst[$i] + $GSTManager->receive_cgst[$i] + $GSTManager->receive_igst[$i];
                            $individualTaxAmount = $GSTManager->receive_quantity[$i] * $GSTManager->receive_price[$i] * .01 * $totalTax;
                            $totalAmountBeforeTax = $totalAmountBeforeTax + $GSTManager->receive_quantity[$i] * $GSTManager->receive_price[$i];

                            $cgstAmt = $GSTManager->receive_quantity[$i] * $GSTManager->receive_price[$i] * .01 * $GSTManager->receive_cgst[$i];
                            $sgstAmt = $GSTManager->receive_quantity[$i] * $GSTManager->receive_price[$i] * .01 * $GSTManager->receive_sgst[$i];
                            $igstAmt = $GSTManager->receive_quantity[$i] * $GSTManager->receive_price[$i] * .01 * $GSTManager->receive_igst[$i];
                            echo $currency_type.' '.sprintf('%0.2f', $totalAmountBeforeTax);?></td>
                            <td><?php echo $currency_type.' '.sprintf('%0.2f', $cgstAmt);?></td>
                            <td><?php echo $currency_type.' '.sprintf('%0.2f', $sgstAmt);?></td>
                            <td><?php echo $currency_type.' '.sprintf('%0.2f', $igstAmt);?></td>
                            <td><?php $total_amount = $GSTManager->receive_quantity[$i] * $GSTManager->receive_price[$i] + $cgstAmt + $sgstAmt + $igstAmt;
                                echo $currency_type.' '.sprintf('%0.2f', $total_amount);?></td>
                        </tr>
                        <?php
                        }
                        ?>
                     </tbody>
                </table>
                <?php } ?>
			</div>
		</div>
	</div>
	
</body>
</html>
<?php 
if(isset($_GET['period_print'])) {
?>	
<script type="text/javascript">
	window.print();
	window.location.assign('viewGST?period=<?php echo $period;?>');
</script>
<?php
	}
?>