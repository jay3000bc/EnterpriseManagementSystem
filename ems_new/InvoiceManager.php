<?php
include_once('settings/config.php');
include_once 'DBManager.php';
class InvoiceManager { 
    public function getInvoiceId() {
        $db = new DBManager();
        $sql = "SELECT * from ems_invoice_auto_id";
        $result = $db->getARecord($sql);
        return $result;
    }

    public function getCounter(){
        $db = new DBManager();
        $sql = "SELECT * from ems_setup WHERE id='1'";
        $result = $db->getARecord($sql);
        return $result;
    }

    public function updateCounter($update_counter){
        $db = new DBManager();
        $sql = "UPDATE ems_setup SET counter = '$update_counter' WHERE id='1' ";
        $result = $db->execute($sql);
    }

    public function updateCounter_Year($reset_counter,$reset_year){
        $db = new DBManager();
        $sql = "UPDATE ems_setup SET counter = '$reset_counter', year='$reset_year'  WHERE id='1' ";
        $result = $db->execute($sql);
    }



    // updateNatioanlId
    public function updateNatioanlId($current_national_id) {
        $db = new DBManager();
        $sql = "UPDATE ems_invoice_auto_id set current_india_based_id='$current_national_id'";
        $result = $db->execute($sql);
        return $result;
    }
    public function updateExportlId($current_export_id) {
        $db = new DBManager();
        $sql = "UPDATE ems_invoice_auto_id set current_export_id='$current_export_id'";
        $result = $db->execute($sql);
        return $result;
    }
    public function getAutoIncrimentIDInvoice() {
        $databaseName = $GLOBALS['databaseName'];
        $db = new DBManager();
        $sql = "SELECT `AUTO_INCREMENT`
            FROM  INFORMATION_SCHEMA.TABLES
            WHERE TABLE_SCHEMA = $databaseName
            AND   TABLE_NAME   = 'ems_invoices'";
        $data = $db->getARecord($sql);
        return $data;
 
    }
    public function saveInvoice($invoice_id, $invoice_type, $client_id, $client_name, $client_email, $client_address, $client_gstin, $client_state, $mode_of_invoice, $reverse_charge, $bank_account, $currency_type, $qty_hrs, $net_amount, $invoice_date, $invoice_date_new) {
        $db = new DBManager();
        $sql = "INSERT into ems_invoices(invoice_id, invoice_type, client_id, name, email, address, gstin, state, invoice_mode, reverse_charge, bank_id, currency_type, qty_hrs, net_amount, invoice_date, created_at) values ('$invoice_id', '$invoice_type', '$client_id', '$client_name', '$client_email', '$client_address', '$client_gstin', '$client_state' ,'$mode_of_invoice', '$reverse_charge', '$bank_account', '$currency_type', '$qty_hrs', '$net_amount' , '$invoice_date', '$invoice_date_new')";

        $result = $db->execute($sql);
        return $result;

    }
    public function saveInvoiceAmount($invoice_id, $desc_of_service, $sac_code, $quantity, $price, $cgst, $sgst, $igst) {
        $db = new DBManager();
        $sql = "INSERT into ems_invoice_amount(invoice_id, desc_of_service, sac_code, quantity, price, cgst, sgst, igst) values ('$invoice_id', '$desc_of_service', '$sac_code', '$quantity', '$price', '$cgst', '$sgst', '$igst')";
        //echo $sql;
        //die();
        $result = $db->execute($sql);
        return $result;

    }
    // update invoice table
    public function saveEditedInvoice($invoice_id, $invoice_type, $client_id, $name, $email, $address, $gstin, $state, $invoice_mode, $reverse_charge, $bank_id, $currency_type, $qty_hrs, $net_amount, $invoice_date, $invoice_date_new) {
        $db = new DBManager();
        if (is_numeric($invoice_id)) {
            $sql = "UPDATE ems_invoices set invoice_type='$invoice_type', client_id='$client_id', name='$name', email='$email', address='$address', gstin='$gstin', state='$state', invoice_mode='$invoice_mode', reverse_charge='$reverse_charge', bank_id='$bank_id', currency_type='$currency_type', qty_hrs='$qty_hrs', net_amount='$net_amount', invoice_date='$invoice_date', created_at ='$invoice_date_new' where invoice_id=$invoice_id";
        } else {
            $sql = "UPDATE ems_invoices set invoice_type='$invoice_type', client_id='$client_id', name='$name', email='$email', address='$address', gstin='$gstin', state='$state', invoice_mode='$invoice_mode', reverse_charge='$reverse_charge', bank_id='$bank_id', currency_type='$currency_type', qty_hrs='$qty_hrs', net_amount='$net_amount', invoice_date='$invoice_date', created_at='$invoice_date_new' where invoice_id='$invoice_id'";
        }
        $result = $db->execute($sql);
        return $result;

    }
    // end
    // update invoice service amount
    public function updateInvoiceAmount($service_id, $invoice_id, $desc_of_service, $sac_code, $quantity, $price, $cgst, $sgst, $igst) {
        $db = new DBManager();
        $sql = "UPDATE ems_invoice_amount set desc_of_service='$desc_of_service', sac_code='$sac_code', quantity='$quantity', price='$price', cgst='$cgst', sgst='$sgst', igst='$igst' where id=$service_id";
        $result = $db->execute($sql);
        return $result;

    }
    //deleteAllPreviewServices
    public function deleteAllPreviewServices() {
        $db = new DBManager();
        $sql = "DELETE from ems_invoice_amount_preview";
        $result = $db->execute($sql);
        return $result;
    }
    // preview Invoice
    public function previewInvoice($invoice_id, $client_id, $client_name, $client_address, $client_gstin, $client_state, $mode_of_invoice, $reverse_charge, $bank_account, $currency_type, $qty_hrs, $net_amount, $invoice_date) {
        $db = new DBManager();
        $sql = "DELETE from ems_invoices_preview";
        $result = $db->execute($sql);
        $sql = "INSERT into ems_invoices_preview(invoice_id, client_id, name, address, gstin, state, invoice_mode, reverse_charge, bank_id, currency_type, qty_hrs, net_amount, invoice_date) values ('$invoice_id', '$client_id', '$client_name', '$client_address', '$client_gstin', '$client_state' ,'$mode_of_invoice', '$reverse_charge', '$bank_account', '$currency_type', '$qty_hrs','$net_amount' , '$invoice_date')";
        $result = $db->execute($sql);
        return $result;

    }
    public function previewInvoiceAmount($invoice_id, $desc_of_service, $sac_code, $quantity, $price, $cgst, $sgst, $igst) {
        $db = new DBManager();
        $sql = "INSERT into ems_invoice_amount_preview(invoice_id, desc_of_service, sac_code, quantity, price, cgst, sgst, igst) values ('$invoice_id', '$desc_of_service', '$sac_code', '$quantity', '$price', '$cgst', '$sgst', '$igst')";
        //echo $sql;
        //die();
        $result = $db->execute($sql);
        return $result;

    }
    public function getPreviewInvoiceDetails() {
        $db = new DBManager();
        $sql = "SELECT * from ems_invoices_preview";
        $result = $db->getARecord($sql);
        return $result;
    }
    public function getPreviewServices($invoice_id) {
        $db = new DBManager();
        $sql = "SELECT * from ems_invoice_amount_preview where invoice_id = '$invoice_id'";
        $data = $db->getAllRecords($sql);
        $total = $db->getNumRow($sql);
        while ($row = $db->getNextRow()) {
            $this->desc_of_service[] = $row['desc_of_service'];
            $this->sac_code[] = $row['sac_code'];
            $this->quantity[] = $row['quantity'];
            $this->price[] = $row['price'];
            $this->sgst[] = $row['sgst'];
            $this->cgst[] = $row['cgst'];
            $this->igst[] = $row['igst'];
        }
        return $total;
    }
    //end

    public function getInvoiceDetails($invoice_id) {
        $db = new DBManager();
        $sql = "SELECT * from ems_invoices where invoice_id= '$invoice_id'";
        $result = $db->getARecord($sql);
        return $result;
    }

    public function getServices($invoice_id) {
        $db = new DBManager();
        $sql = "SELECT * from ems_invoice_amount where invoice_id = '$invoice_id'";
        $data = $db->getAllRecords($sql);
        $total = $db->getNumRow($sql);
        while ($row = $db->getNextRow()) {
            $this->service_id[] = $row['id'];
            $this->desc_of_service[] = $row['desc_of_service'];
            $this->sac_code[] = $row['sac_code'];
            $this->quantity[] = $row['quantity'];
            $this->price[] = $row['price'];
            $this->sgst[] = $row['sgst'];
            $this->cgst[] = $row['cgst'];
            $this->igst[] = $row['igst'];
        }
        return $total;
    }
     
    public function listInvoices()
    {
        $db = new DBManager();
        $sql = "SELECT * from ems_invoices order by id desc";
        $data = $db->getAllRecords($sql);
        $total = $db->getNumRow($sql);
        while ($row = $db->getNextRow()) {
            $this->invoice_id[] = $row['invoice_id'];
            $this->client_name[] = $row['name'];
            $this->invoice_date[] = $row['invoice_date'];
            $this->currency_type[] = $row['currency_type'];
            $this->invoice_amount[] = $row['net_amount'];
            $this->status[] = $row['status'];
            $this->credit_note[] = $row['credit_note'];
        }
        return $total;
    } 
    // list received  invoices 
    public function listReceivedInvoices()
    {
        $db = new DBManager();
        $sql = "SELECT * from ems_receive_invoice order by id desc";
        $data = $db->getAllRecords($sql);
        $total = $db->getNumRow($sql);
        while ($row = $db->getNextRow()) {
            $this->id[] = $row['id'];
            $this->invoice_id[] = $row['invoice_id'];
            $this->client_name[] = $row['name'];
            $this->invoice_date[] = $row['invoice_date'];
            $this->currency_type[] = $row['currency_type'];
            $this->invoice_amount[] = $row['invoice_amount'];
            $this->upload_invoice[] = $row['upload_invoice'];
            $this->status[] = $row['status'];
            $this->credit_note[] = $row['credit_note'];
        }
        return $total;
    }

    // fetch invoice by id

    public function fetchReceivedInvoicesById($id){

        $db = new DBManager();
        

        if (is_numeric($id)) {
            $sql = "SELECT * from ems_receive_invoice where id=$id";
        }
        else {
            $sql = "SELECT * from ems_receive_invoice where id='$id'";

        }
        //echo $sql;
        $receiveInvoice = $db->getARecord($sql);
        
        return $receiveInvoice;


    }

    public function fetchInvoiceReceiveAmount($invoice_id){

        $db = new DBManager();

        $sql = "SELECT * from ems_invoice_receive_amount where invoice_id ='$invoice_id'";

        $data = $db->getAllRecords($sql);
        $total = $db->getNumRow($sql);

        $arrayNameList =array();
        $arrayName = array();
        
        while ($row = $db->getNextRow()) {
            $this->id[] = $row['id'];
            //$this->invoice_id[] = $row['invoice_id'];
            $arrayName['id'] = $row['id'];
            $arrayName['desc_of_service'] = $row['desc_of_service'];
            $arrayName['sac_code'] = $row['sac_code'];
            $arrayName['quantity'] = $row['quantity'];
            $arrayName['price'] = $row['price'];
            $arrayName['sgst'] = $row['sgst'];
            $arrayName['cgst'] = $row['cgst'];
            $arrayName['igst'] = $row['igst'];

            array_push($arrayNameList, $arrayName);
        }

        return $arrayNameList;

    }

    // list of Description of Services

    public function listDescOfServices($searchKey) {
        $db = new DBManager();
        $sql = "SELECT DISTINCT desc_of_service from ems_invoice_amount where desc_of_service LIKE '$searchKey%'";
        $data = $db->getAllRecords($sql);
        $arrayNameList =array();
        $arrayName = array();
        while ($row = $db->getNextRow()) {
            $arrayName['value'] = $row['desc_of_service'];
            $arrayName['label'] = $row['desc_of_service'];
            array_push($arrayNameList, $arrayName); 
        }
        return $arrayNameList;
    }

    // receive invoice function
    public function saveReceiveInvoice($invoice_id, $name, $address, $email, $contact_no, $invoice_date, $currency_type, $invoice_amount, $gstin, $upload_invoice, $invoice_date_new ) {
        $db = new DBManager();
        $sql = "INSERT into ems_receive_invoice(invoice_id, name, address, email, contact_no, invoice_date, currency_type, invoice_amount, gstin, upload_invoice, created_at) values ('$invoice_id', '$name', '$address', '$email', '$contact_no', '$invoice_date', '$currency_type' ,'$invoice_amount', '$gstin', '$upload_invoice', '$invoice_date_new')";
        $result = $db->execute($sql);
        return $result;
    }
    public function saveReceiveInvoiceAmount($invoice_id, $desc_of_service, $sac_code, $quantity, $price, $cgst, $sgst, $igst) {
        $db = new DBManager();
        $sql = "INSERT into ems_invoice_receive_amount(invoice_id, desc_of_service, sac_code, quantity, price, cgst, sgst, igst) values ('$invoice_id', '$desc_of_service', '$sac_code', '$quantity', '$price', '$cgst', '$sgst', '$igst')";
        //echo $sql;
        //die();
        $result = $db->execute($sql);
        return $result;

    }

    // receive invoice update function

    public function saveReceiveInvoiceUpdate($receive_id,$invoice_id, $name, $address, $email, $contact_no, $invoice_date, $currency_type, $invoice_amount, $gstin, $upload_invoice, $invoice_date_new ) {
        $db = new DBManager();


        //$sql = "INSERT into ems_receive_invoice(invoice_id, name, address, email, contact_no, invoice_date, currency_type, invoice_amount, gstin, upload_invoice, created_at) '
        //values ('$invoice_id', '$name', '$address', '$email', '$contact_no', '$invoice_date', '$currency_type' ,'$invoice_amount', '$gstin', '$upload_invoice', '$invoice_date_new')";
       
       if( !empty($upload_invoice) ){

            $sql = "UPDATE ems_receive_invoice SET
                invoice_id = '$invoice_id',
                name = '$name',
                address = '$address',
                email = '$email',
                contact_no = '$contact_no',
                invoice_date = '$invoice_date',
                currency_type = '$currency_type',
                invoice_amount = '$invoice_amount',
                gstin = '$gstin',
                upload_invoice = '$upload_invoice',
                created_at = '$invoice_date_new'
                WHERE id = $receive_id";

       }
       else if(empty($upload_invoice)){

            $sql = "UPDATE ems_receive_invoice SET
            invoice_id = '$invoice_id',
            name = '$name',
            address = '$address',
            email = '$email',
            contact_no = '$contact_no',
            invoice_date = '$invoice_date',
            currency_type = '$currency_type',
            invoice_amount = '$invoice_amount',
            gstin = '$gstin',
            created_at = '$invoice_date_new'
            WHERE id = $receive_id";

       }

        $result = $db->execute($sql);
        return $result;
    }


    // receive invoice chek id is available or not function

    public function checkID($id){
        $db = new DBManager();
        $sql = "SELECT * FROM  ems_receive_invoice WHERE id=$id";
        $avail = $db->execute($sql);
        return $avail;
    }

    // receive invoice chek id is available or not function


    public function saveReceiveInvoiceAmountUpdate($invoice_receive_amount_id,$invoice_id, $desc_of_service, $sac_code, $quantity, $price, $cgst, $sgst, $igst) {
        $db = new DBManager();
        //$sql = "INSERT into ems_invoice_receive_amount(invoice_id, desc_of_service, sac_code, quantity, price, cgst, sgst, igst)
        // values ('$invoice_id', '$desc_of_service', '$sac_code', '$quantity', '$price', '$cgst', '$sgst', '$igst')";
        //echo $sql;
        //die();

       // $check = "SELECT * FROM ems_invoice_receive_amount WHERE id=$invoice_receive_amount_id";
       

        if(!empty($invoice_receive_amount_id)){

            $sql = "UPDATE ems_invoice_receive_amount SET 
            invoice_id = '$invoice_id',
            desc_of_service = '$desc_of_service',
            sac_code = '$sac_code',
            quantity = '$quantity',
            price = '$price',
            cgst = '$cgst',
            sgst = '$sgst',
            igst = '$igst'
            WHERE id = $invoice_receive_amount_id";

        }
        else {
            $sql = "INSERT into ems_invoice_receive_amount(invoice_id, desc_of_service, sac_code, quantity, price, cgst, sgst, igst) values ('$invoice_id', '$desc_of_service', '$sac_code', '$quantity', '$price', '$cgst', '$sgst', '$igst')";
        }

        $result = $db->execute($sql);
        return $result;

    

    }
    // receive invoice update function

    //delete receive amount row

    public function deleteReceiveAmountRow($id){

        $db = new DBManager();
        $sql = "DELETE from ems_invoice_receive_amount where id = '$id'";
        $result = $db->execute($sql);
        if($result){
            return 1;
        }
        


    }


    // list seller name 
    public function listSellerName($searchKey) {
        $db = new DBManager();
        $sql = "SELECT * from ems_receive_invoice where name LIKE '$searchKey%' and created_at = (SELECT MAX(created_at) from ems_receive_invoice where name LIKE '$searchKey%')";
        $result = $db->execute($sql);       
        $data = $db->getAllRecords($sql);
        $arrayNameList =array();
        $arrayName = array();
        while ($row = $db->getNextRow()) {
            $arrayName['id'] = $row['id'];
            $arrayName['value'] = $row['name'];
            $arrayName['label'] = $row['name'];
            $arrayName['address'] = $row['address'];
            $arrayName['email'] = $row['email'];
            $arrayName['contact_no'] = $row['contact_no'];
            $arrayName['gstin'] = $row['gstin'];
            array_push($arrayNameList, $arrayName); 
        }
        return $arrayNameList;
    }
    public function changeStatus($invoice_id, $status, $invoice_type) {
        $db = new DBManager();
        $currentDate = date("Y-m-d");
        if($invoice_type == 0) {
            if($status == 1) {
               $sql = "UPDATE ems_invoices set status='$status', invoice_paid_date = '$currentDate'  where invoice_id='$invoice_id'"; 
            } else {
                $sql = "UPDATE ems_invoices set status='$status', invoice_paid_date = NULL where invoice_id='$invoice_id'";
            }
        } else {
            if($status == 1) {
               $sql = "UPDATE ems_receive_invoice set status='$status', invoice_paid_date = '$currentDate'  where invoice_id='$invoice_id'"; 
            } else {
                $sql = "UPDATE ems_receive_invoice set status='$status', invoice_paid_date = NULL where invoice_id='$invoice_id'";
            }
        }
        
        
        $result = $db->execute($sql);
        return $result;
    }
    // list of Received Description of Services

    public function listDescOfReceivedServices($searchKey) {
        $db = new DBManager();
        $sql = "SELECT DISTINCT desc_of_service from ems_invoice_receive_amount where desc_of_service LIKE '$searchKey%'";
        $data = $db->getAllRecords($sql);
        $arrayNameList =array();
        $arrayName = array();
        while ($row = $db->getNextRow()) {
            $arrayName['value'] = $row['desc_of_service'];
            $arrayName['label'] = $row['desc_of_service'];
            array_push($arrayNameList, $arrayName); 
        }
        return $arrayNameList;
    }

    // list of Received Description of Services

    public function getSACReceivedInvoice($searchKey) {
        $db = new DBManager();
        $sql = "SELECT DISTINCT sac_code from ems_invoice_receive_amount where sac_code LIKE '$searchKey%'";
        $data = $db->getAllRecords($sql);
        $arrayNameList =array();
        $arrayName = array();
        while ($row = $db->getNextRow()) {
            $arrayName['value'] = $row['sac_code'];
            $arrayName['label'] = $row['sac_code'];
            array_push($arrayNameList, $arrayName); 
        }
        return $arrayNameList;
    }
    // check_already_exist_value
    public function check_already_exist_value($field_value, $field_name) {
        $db = new DBManager();
        $sql = "SELECT * from ems_receive_invoice where invoice_id = '$field_value'";
        $total = $db->getNumRow($sql);
        return $total;
    }

    // add credit note 

    public function saveCreditNote($invoice_id, $invoice_type, $credit_note) {
        $db = new DBManager();
        if($invoice_type == 0) {
            $sql = "UPDATE ems_invoices set credit_note='$credit_note' where invoice_id='$invoice_id'"; 
        } else {
            $sql = "UPDATE ems_receive_invoice set credit_note='$credit_note' where invoice_id='$invoice_id'";
        }
        
        $result = $db->execute($sql);
        return $result;
    }

    public function deleteOldService($invoice_id, $service_id, $net_amount_after_row_remove) {
        $db = new DBManager();
        $sql1 = "DELETE from ems_invoice_amount where id = $service_id";
        $sql2 = "UPDATE ems_invoices set net_amount=$net_amount_after_row_remove where invoice_id='$invoice_id'";
        $result1 = $db->execute($sql1); 
        $result2 = $db->execute($sql2);
        if($result1 && $result2) {
            return 'success';
        }
    }
}