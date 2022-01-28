<?php
date_default_timezone_set('Asia/Kolkata');
include_once 'DBManager.php';
class GSTManager { 
    // getSaleDetails of last month
	public function getSaleDetails() {
		$db = new DBManager();
		
        $year = date("Y",strtotime("-1 month"));
        $month = date("m",strtotime("-1 month"));

        $sql = "SELECT * from ems_invoices, ems_invoice_amount where MONTH(ems_invoices.created_at) = $month AND YEAR(ems_invoices.created_at) = $year and ems_invoices.invoice_id = ems_invoice_amount.invoice_id order by ems_invoices.id desc";

        $data = $db->getAllRecords($sql);
        $total = $db->getNumRow($sql);
        while ($row = $db->getNextRow()) {
            $this->invoice_id[] = $row['invoice_id'];
            $this->client_name[] = $row['name'];
            $this->gstin[] = $row['gstin'];
            $this->invoice_date[] = $row['invoice_date'];
            $this->invoice_paid_date[] = $row['invoice_paid_date'];
            $this->desc_of_service[] = $row['desc_of_service'];
            $this->sac_code[] = $row['sac_code'];
            $this->quantity[] = $row['quantity'];
            $this->price[] = $row['price'];
            $this->sgst[] = $row['sgst'];
            $this->cgst[] = $row['cgst'];
            $this->igst[] = $row['igst'];
            $this->currency_type[] = $row['currency_type'];
            $this->invoice_amount[] = $row['net_amount'];
            $this->status[] = $row['status'];
        }
        
        return $total;
	}
    // getPurchaseDetails of last month
	public function getPurchaseDetails() {
		$db = new DBManager();

		$year = date("Y",strtotime("-1 month"));
        $month = date("m",strtotime("-1 month"));
        $sql = "SELECT * from ems_receive_invoice, ems_invoice_receive_amount where MONTH(ems_receive_invoice.created_at) = $month AND YEAR(ems_receive_invoice.created_at) = $year and ems_receive_invoice.invoice_id = ems_invoice_receive_amount.invoice_id order by ems_receive_invoice.id desc";

        $data = $db->getAllRecords($sql);
        $total = $db->getNumRow($sql);
        while ($row = $db->getNextRow()) {
            $this->receive_invoice_id[] = $row['invoice_id'];
            $this->receive_client_name[] = $row['name'];
            $this->receive_gstin[] = $row['gstin'];
            $this->receive_invoice_date[] = $row['invoice_date'];
            $this->receive_invoice_paid_date[] = $row['invoice_paid_date'];
            $this->receive_desc_of_service[] = $row['desc_of_service'];
            $this->receive_sac_code[] = $row['sac_code'];
            $this->receive_quantity[] = $row['quantity'];
            $this->receive_price[] = $row['price'];
            $this->receive_sgst[] = $row['sgst'];
            $this->receive_cgst[] = $row['cgst'];
            $this->receive_igst[] = $row['igst'];
            $this->receive_currency_type[] = $row['currency_type'];
            $this->receive_invoice_amount[] = $row['invoice_amount'];
        }
        return $total;
	}

	// get all created invoice group by Month 

	public function getCreatedInvoicebyMonth() {
		$db = new DBManager();
        $sql = "SELECT ems_invoices.invoice_id as invoice_id, ems_invoices.created_at as created_at from ems_invoices, ems_invoice_amount where ems_invoices.invoice_id = ems_invoice_amount.invoice_id GROUP BY DATE_FORMAT(ems_invoices.created_at, '%Y%m') order by ems_invoices.id desc";

        $data = $db->getAllRecords($sql);
        $totalSale = $db->getNumRow($sql);
        while ($row = $db->getNextRow()) {
            $this->created_invoice_id[] = $row['invoice_id'];
            $this->created_invoice_date_monthly[] = $row['created_at'];
        }
        return $totalSale;
    }

    // get all received invoice which are paid group by Month

    public function getReceivedInvoicebyMonth() {
        $db = new DBManager();
        
        $sql = "SELECT ems_receive_invoice.invoice_id as invoice_id, ems_receive_invoice.created_at as created_at  from ems_receive_invoice, ems_invoice_receive_amount where ems_receive_invoice.invoice_id = ems_invoice_receive_amount.invoice_id GROUP BY DATE_FORMAT(ems_receive_invoice.created_at, 'Y%m%') order by ems_receive_invoice.id desc";

        $data = $db->getAllRecords($sql);
        $totalPurchase = $db->getNumRow($sql);
        while ($row = $db->getNextRow()) {
            $this->receive_invoice_id[] = $row['invoice_id'];
            $this->receive_invoice_date_monthly[] = $row['created_at'];
        }
        return $totalPurchase;
        
    }

    // get sell and purchase details by period/month

    public function getSaleDetailsbyPeriod($period) {
        $db = new DBManager();
        $year = date("Y",strtotime($period));
        $month = date("m",strtotime($period));
        $sql = "SELECT * from ems_invoices, ems_invoice_amount where MONTH(ems_invoices.created_at) = $month AND YEAR(ems_invoices.created_at) = $year and ems_invoices.invoice_id = ems_invoice_amount.invoice_id order by ems_invoices.id desc";
        $data = $db->getAllRecords($sql);
        $total = $db->getNumRow($sql);
        while ($row = $db->getNextRow()) {
            $this->invoice_id[] = $row['invoice_id'];
            $this->client_name[] = $row['name'];
            $this->gstin[] = $row['gstin'];
            $this->invoice_date[] = $row['invoice_date'];
            $this->invoice_paid_date[] = $row['invoice_paid_date'];
            $this->desc_of_service[] = $row['desc_of_service'];
            $this->sac_code[] = $row['sac_code'];
            $this->quantity[] = $row['quantity'];
            $this->price[] = $row['price'];
            $this->sgst[] = $row['sgst'];
            $this->cgst[] = $row['cgst'];
            $this->igst[] = $row['igst'];
            $this->currency_type[] = $row['currency_type'];
            $this->invoice_amount[] = $row['net_amount'];
            $this->status[] = $row['status'];
        }
        return $total;
    }

    public function getPurchaseDetailsbyPeriod($period) {
        $db = new DBManager();
        $year = date("Y",strtotime($period));
        $month = date("m",strtotime($period));
        $sql = "SELECT * from ems_receive_invoice, ems_invoice_receive_amount where MONTH(ems_receive_invoice.created_at) = $month AND YEAR(ems_receive_invoice.created_at) = $year and ems_receive_invoice.invoice_id = ems_invoice_receive_amount.invoice_id order by ems_receive_invoice.id desc";

        $data = $db->getAllRecords($sql);
        $total = $db->getNumRow($sql);
        while ($row = $db->getNextRow()) {
            $this->receive_invoice_id[] = $row['invoice_id'];
            $this->receive_client_name[] = $row['name'];
            $this->receive_gstin[] = $row['gstin'];
            $this->receive_invoice_date[] = $row['invoice_date'];
            $this->receive_invoice_paid_date[] = $row['invoice_paid_date'];
            $this->receive_desc_of_service[] = $row['desc_of_service'];
            $this->receive_sac_code[] = $row['sac_code'];
            $this->receive_quantity[] = $row['quantity'];
            $this->receive_price[] = $row['price'];
            $this->receive_sgst[] = $row['sgst'];
            $this->receive_cgst[] = $row['cgst'];
            $this->receive_igst[] = $row['igst'];
            $this->receive_currency_type[] = $row['currency_type'];
            $this->receive_invoice_amount[] = $row['invoice_amount'];
        }
        return $total;
    }

    // save generate GST information
    public function generateGST($period, $status) {
        $db = new DBManager();
        $sql = "INSERT into ems_gst_period (period, status) values ('$period', $status)";
        $result = $db->execute($sql);
        return $result;
    }
    // get all period status
    public function getAllGSTPeriod() {
        $db = new DBManager();
        $sql = "SELECT * from ems_gst_period";
        $data = $db->getAllRecords($sql);
        $total = $db->getNumRow($sql);
        while ($row = $db->getNextRow()) {
            $this->period[] = $row['period'];
            $this->status[] = $row['status'];
        }
        return $total;
    }
}
