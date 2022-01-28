<?php 
$title = 'Current GST';
include('settings/config.php');
include('include/header.php');
include_once 'GSTManager.php';
$GSTManager = new GSTManager();
$resultSale = $GSTManager->getSaleDetails();
$resultPurchase = $GSTManager->getPurchaseDetails();
$period = date("Y-m",strtotime("-1 month"));
$resultGSTPeriod = $GSTManager->getAllGSTPeriod();
?>
<style type="text/css">
    table {
        font-size: 14px;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>GST return for the month <?php echo date("M Y",strtotime("-1 month")); ?></h1>
      <?php include_once('include/notificationBell.php'); ?>
    </section>

    <!-- Main content -->
    <section class="content">
    <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                <?php if($resultSale != '' || $resultPurchase != '') { ?>
                    <?php if($resultSale != '') { ?>
                    <div class="box-header with-border">
                      <h3 class="box-title"><b>SALE DETAILS</b></h3>
                    </div>
                    <div class="box-body">
                        <div class="row">  
                            <div class="col-md-12">
                                <table id="display_gst_table" class="table table-bordered table-striped table-responsive">
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
                                            <td><?php
                                            if($GSTManager->invoice_paid_date[$i] != '') {
                                                echo date("d/m/Y", strtotime($GSTManager->invoice_paid_date[$i]));
                                                } else {
                                                    echo 'N/A';
                                            } ?>
                                             </td>
                                            
                                            <td><?php echo $GSTManager->desc_of_service[$i];?></td>
                                            <td></td>
                                            <td><?php echo $GSTManager->sac_code[$i];?></td>
                                            <?php 
                                            foreach ($currencies as $key => $currency) {
                                                if($key == $GSTManager->currency_type[$i]) {
                                                    $currency_type = $currency;
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
                                            <td><?php 
                                                    $total_amount = $GSTManager->quantity[$i] * $GSTManager->price[$i] + $cgstAmt + $sgstAmt + $igstAmt;
                                            echo $currency_type.' '.sprintf('%0.2f', $total_amount);?></td>
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                     </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.box -->
                    <hr>
                    <?php } ?>
                    <?php if($resultPurchase != '') { ?>
                    <div class="box-header with-border">
                      <h3 class="box-title"><b>PURCHASE DETAILS</b></h3>
                    </div>
                    <div class="box-body">
                        <div class="row">  
                            <div class="col-md-12">
                                <table id="display_gst_purchase_table" class="table table-bordered table-striped table-responsive">
                                    <thead>
                                        <tr>
                                            <th>SL No.</th>
                                            <th>Supplier Name</th>
                                            <th>GSTIN</th>
                                            <th>Bill No.</th>
                                            <th>Bill Date</th>
                                            <th>Bill Paid Date.</th>
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
                                            <td><?php 
                                            if($GSTManager->receive_invoice_paid_date[$i] != '') {
                                                echo date("d/m/Y", strtotime($GSTManager->receive_invoice_paid_date[$i]));
                                            } else {
                                                echo 'N/A';
                                            }
                                            ?></td>
                                            <td><?php echo $GSTManager->receive_desc_of_service[$i];?></td>
                                            <td></td>
                                            <td><?php echo $GSTManager->receive_sac_code[$i];?></td>
                                            <?php 
                                            foreach ($currencies as $key => $currency) {
                                                if($key == $GSTManager->receive_currency_type[$i]) {
                                                    $currency_type = $currency;
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
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php 
                         for ($j=0; $j < $resultGSTPeriod ; $j++) { 
                             if($GSTManager->period[$j] == $period) {
                                $status = 'Generated';
                             }
                         }
                    ?>
                    <form method="POST" action="GSTController.php">
                        <?php if(isset($status)) { ?>
                        <div class="box-footer with-border">
                            <a target="_blank" href="generateGST.php?period_print=<?php echo $period;?>" class="btn btn-warning">Print</a>
                            <a target="_blank" href="uploads/GST/<?php echo $period;?>.xlsx" class="btn btn-info">Download EXCEL</a>
                            <a target="_blank" href="uploads/GST/<?php echo $period;?>.pdf" class="btn btn-primary">Download PDF</a>
                        </div>
                        <?php } else { ?>
                        <div class="box-footer with-border">
                            <input type="hidden" name="period" value="<?php echo $period;?>">
                            <input type="submit" name="generateGST" value="Print" class="pull-left btn btn-md btn-info">
                            <input type="submit" name="generateGST" value="Generate GST" class="pull-right btn btn-md btn-success">
                        </div>
                        <?php } ?>
                    </form>
                    <!-- /.box -->
                 <?php } else { ?>
                 <div class="box-header with-border">
                      <h3 class="box-title">No Sell and Purchase data available for this month</h3>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
        <!-- /.row -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include('include/footer.php');?>
</body>
</html>

