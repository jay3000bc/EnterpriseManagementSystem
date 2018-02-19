<?php
$resultSale = $GSTManager->getSaleDetailsbyPeriod($period);
$resultPurchase = $GSTManager->getPurchaseDetailsbyPeriod($period);
$output = '';
$output .= '<table>';
if($resultSale != '') { 
$output .= '<tr><th>SALE DETAILS</th></tr>';
$output .= '<tr>  
                <th>SL No.</th>
                <th>Customer Name</th>
                <th>GSTIN</th>
                <th>Bill No.</th>
                <th>Bill Date</th>
                <th>Item</th>
                <th>GST Rate</th>
                <th>HSN/ SAC Code</th>
                <th>Amount Without Tax</th>
                <th>CGST Amt.</th>
                <th>SGST Amt.</th>
                <th>IGST Amt.</th>
                <th>Net Amt.</th>
            </tr>';
            $count =1;
            for($i=0; $i< $resultSale; $i++) {
                foreach ($currencies as $key => $currency) {
                    if($key == $GSTManager->currency_type[$i]) {
                        $currency_type = $currency;
                        if($key == 'rupee') {
                            $currency_type = 'Rs.';
                        } else {
                            $currency_type = $currency;
                        }
                    } 
                }
                $totalAmountBeforeTax = 0;
                $totalTax = $GSTManager->sgst[$i] + $GSTManager->cgst[$i] + $GSTManager->igst[$i];
                $individualTaxAmount = $GSTManager->quantity[$i] * $GSTManager->price[$i] * .01 * $totalTax;
                $totalAmountBeforeTax = $totalAmountBeforeTax + $GSTManager->quantity[$i] * $GSTManager->price[$i];

                $cgstAmt = $GSTManager->quantity[$i] * $GSTManager->price[$i] * .01 * $GSTManager->cgst[$i];
                $sgstAmt = $GSTManager->quantity[$i] * $GSTManager->price[$i] * .01 * $GSTManager->sgst[$i];
                $igstAmt = $GSTManager->quantity[$i] * $GSTManager->price[$i] * .01 * $GSTManager->igst[$i];
                $total_amount = $GSTManager->quantity[$i] * $GSTManager->price[$i] + $cgstAmt + $sgstAmt + $igstAmt;
                $gstRate = 'Not Available';
                $output .= '
                <tr>  
                    <td>'.$count.'</td>  
                    <td>'.$GSTManager->client_name[$i].'</td>  
                    <td>'.$GSTManager->gstin[$i].'</td>  
                    <td>'.$GSTManager->invoice_id[$i].'</td>  
                    <td>'.$GSTManager->invoice_date[$i].'</td>
                    <td>'.$GSTManager->desc_of_service[$i].'</td>
                    <td>'.$gstRate.'</td>
                    <td>'.$GSTManager->sac_code[$i].'</td>
                    <td>'.$currency_type.' '.sprintf('%0.2f', $totalAmountBeforeTax).'</td>
                    <td>'.$currency_type.' '.sprintf('%0.2f', $cgstAmt).'</td>
                    <td>'.$currency_type.' '.sprintf('%0.2f', $sgstAmt).'</td>
                    <td>'.$currency_type.' '.sprintf('%0.2f', $igstAmt).'</td>
                    <td>'.$currency_type.' '.sprintf('%0.2f', $total_amount).'</td>
                </tr>
                ';
                $count++;
            }
}
if($resultPurchase != '') {
$output .= '<tr></tr><tr></tr><tr><th>PURCHASE DETAILS</th></tr>';
$output .= '<tr>  
                <th>SL No.</th>
                <th>Supplier Name</th>
                <th>GSTIN</th>
                <th>Bill No.</th>
                <th>Bill Date</th>
                <th>Item</th>
                <th>GST Rate</th>
                <th>HSN/ SAC Code</th>
                <th>Amount Without Tax</th>
                <th>CGST Amt.</th>
                <th>SGST Amt.</th>
                <th>IGST Amt.</th>
                <th>Net Amt.</th>
            </tr>';
            $count= 1;
            for($i=0; $i< $resultPurchase; $i++) {
                foreach ($currencies as $key => $currency) {
                    if($key == $GSTManager->currency_type[$i]) {
                        if($key == 'rupee') {
                            $currency_type = 'Rs.';
                        } else {
                            $currency_type = $currency;
                        }
                    } 
                }
                $totalAmountBeforeTax = 0;
                $totalTax = $GSTManager->receive_sgst[$i] + $GSTManager->receive_cgst[$i] + $GSTManager->receive_igst[$i];
                $individualTaxAmount = $GSTManager->receive_quantity[$i] * $GSTManager->receive_price[$i] * .01 * $totalTax;
                $totalAmountBeforeTax = $totalAmountBeforeTax + $GSTManager->receive_quantity[$i] * $GSTManager->receive_price[$i];

                $cgstAmt = $GSTManager->receive_quantity[$i] * $GSTManager->receive_price[$i] * .01 * $GSTManager->receive_cgst[$i];
                $sgstAmt = $GSTManager->receive_quantity[$i] * $GSTManager->receive_price[$i] * .01 * $GSTManager->receive_sgst[$i];
                $igstAmt = $GSTManager->receive_quantity[$i] * $GSTManager->receive_price[$i] * .01 * $GSTManager->receive_igst[$i];
                $total_amount = $GSTManager->receive_quantity[$i] * $GSTManager->receive_price[$i] + $cgstAmt + $sgstAmt + $igstAmt;
                $output .= '
                <tr>  
                    <td>'.$count.'</td>  
                    <td>'.$GSTManager->receive_client_name[$i].'</td>  
                    <td>'.$GSTManager->receive_gstin[$i].'</td>  
                    <td>'.$GSTManager->receive_invoice_id[$i].'</td>  
                    <td>'.$GSTManager->receive_invoice_date[$i].'</td>
                    <td>'.$GSTManager->receive_desc_of_service[$i].'</td>
                    <td>'.$gstRate.'</td>
                    <td>'.$GSTManager->receive_sac_code[$i].'</td>
                    <td>'.$currency_type.' '.sprintf('%0.2f', $totalAmountBeforeTax).'</td>
                    <td>'.$currency_type.' '.sprintf('%0.2f', $cgstAmt).'</td>
                    <td>'.$currency_type.' '.sprintf('%0.2f', $sgstAmt).'</td>
                    <td>'.$currency_type.' '.sprintf('%0.2f', $igstAmt).'</td>
                    <td>'.$currency_type.' '.sprintf('%0.2f', $total_amount).'</td>
                </tr>
               ';
               $count++;
            }
}
                
$output .= '</table>'; 
require_once('vendor/autoload.php');
$htmlPhpExcel = new \Ticketpark\HtmlPhpExcel\HtmlPhpExcel($output);
$htmlPhpExcel->process()->save('uploads/GST/'.$period.'.xlsx');           
?>