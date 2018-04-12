<?php
include_once 'DBManager.php';
class LoaderManager {
	public function checkTableExist() {
		$table_name = [];
		$db = new DBManager();
		$databaseName = $GLOBALS['databaseName'];
        $sql= "SELECT table_name FROM information_schema.tables WHERE table_schema = '$databaseName'";
        $data = $db->getAllRecords($sql);
        $total = $db->getNumRow($sql);
        while ($row = $db->getNextRow()) {
            $table_name[] = $row['table_name'];
        }
        return $table_name;
    }
	// sql to create invoice table
	public function createInvoiceTable($invoice_digits, $starting_no, $export_invoice_prefix, $india_based_prefix) {
		$db = new DBManager();
		$sql = "DROP TABLE IF EXISTS ems_invoice_auto_id";
		$result = $db->execute($sql);
		$sql= "create table ems_invoice_auto_id (
			id int($invoice_digits) unsigned zerofill not null auto_increment primary key,
			digits int(12),
			export_invoice_prefix varchar(30),
			current_export_id int($invoice_digits) unsigned zerofill not null,
			india_based_prefix varchar(30),
			current_india_based_id int($invoice_digits) unsigned zerofill not null

			) auto_increment=$starting_no";
		$result = $db->execute($sql);
		$sql1 = "insert into ems_invoice_auto_id (digits, export_invoice_prefix, current_export_id, india_based_prefix, current_india_based_id) Values ('$invoice_digits', '$export_invoice_prefix',0 ,'$india_based_prefix',0)";
		$result = $db->execute($sql1);
		$sql = "DROP TABLE IF EXISTS ems_invoices";
		$result = $db->execute($sql);
		$sql3 = "CREATE TABLE IF NOT EXISTS `ems_invoices` (
		  `id` int($invoice_digits) unsigned zerofill NOT NULL AUTO_INCREMENT,
		  `invoice_type` int(11) NOT NULL COMMENT '0-National, 1-Export',
		  `invoice_id` varchar(255) NOT NULL,
		  `client_id` varchar(255) NOT NULL,
		  `name` varchar(100) NOT NULL,
		  `email` varchar(100) NOT NULL,
		  `address` text NOT NULL,
		  `gstin` varchar(100) NOT NULL,
		  `state` varchar(255) DEFAULT NULL,
		  `invoice_mode` int(2) NOT NULL COMMENT '0-online, 1-manual',
		  `reverse_charge` int(2) NOT NULL COMMENT '0-No, 1-Yes',
		  `bank_id` int(11) NOT NULL,
		  `currency_type` varchar(50) NOT NULL,
		  `net_amount` int(11) NOT NULL,
		  `invoice_date` varchar(50) NOT NULL,
		  `status` int(11) DEFAULT NULL COMMENT '0-Unpaid, 1-Paid',
		  `invoice_paid_date` date DEFAULT NULL,
  		  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=$starting_no";
		$result = $db->execute($sql3);
		return $result;
	}
	// update loader table
	public function updateLoaderTable($field_id, $value) {
		$db = new DBManager();
		$sql = "UPDATE ems_loader set $field_id = '$value'";
		$result = $db->execute($sql);
        return $result;
	}
	public function manageIdStatus() {
		$db = new DBManager();
        $sql = "SELECT * from ems_loader";
        $result = $db->getARecord($sql);
        return $result;
	}

	// sql to create employee table
	public function createEmployeeTable($digits, $starting_no, $prefix) {
		$db = new DBManager();
		$sql = "DROP TABLE IF EXISTS ems_employee_auto_id";
		$result = $db->execute($sql);
		$sql= "create table ems_employee_auto_id (
			id int($digits) unsigned zerofill not null auto_increment primary key,
			prefix varchar(100),
			digits int(11)
			) auto_increment=$starting_no";
		$result = $db->execute($sql);
		$sql1 = "insert into ems_employee_auto_id (prefix, digits) Values ('$prefix', '$digits')";
		$result = $db->execute($sql1);
		$sql = "DROP TABLE IF EXISTS ems_employees";
		$result = $db->execute($sql);
		$sql3 = "CREATE TABLE IF NOT EXISTS `ems_employees` (
		  `id` int($digits) unsigned NOT NULL AUTO_INCREMENT,
		  `employee_id` varchar(50) NOT NULL,
		  `name` varchar(50) NOT NULL,
		  `designation` varchar(50) NOT NULL,
		  `email` varchar(100) NOT NULL,
		  `phone_no` varchar(50) NOT NULL,
		  `password` varchar(100) NOT NULL,
		  `photo` varchar(50) NOT NULL,
		  `current_address` text NOT NULL,
		  `permanent_address` text NOT NULL,
		  `father_name` varchar(50) NOT NULL,
		  `gender` varchar(10) NOT NULL,
		  `date_of_joining` varchar(50) NOT NULL,
		  `date_of_birth` varchar(50) NOT NULL,
		  `pf_account` text,
		  `policy_no` varchar(100) DEFAULT NULL,
		  `lic_id` varchar(100) DEFAULT NULL,
		  `pan` varchar(100) DEFAULT NULL,
		  `passport_no` varchar(100) DEFAULT NULL,
		  `driving_license_no` varchar(100) DEFAULT NULL,
		  `bank_account` text NOT NULL,
		  `ifsc_code` varchar(50) NOT NULL,
		  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1-Active, 0-Inactive',
		  `last_logged_in` varchar(100) NOT NULL,
		  `ip` varchar(50) NOT NULL,
		  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=$starting_no";
		$result = $db->execute($sql3);
		return $result;
	}


	// sql to create client table
	public function createClientTable($digits, $starting_no, $prefix) {
		$db = new DBManager();
		$sql = "DROP TABLE IF EXISTS ems_client_auto_id";
		$result = $db->execute($sql);
		$sql= "create table ems_client_auto_id (
			id int($digits) unsigned zerofill not null auto_increment primary key,
			prefix varchar(30),
			digits int(11)
			) auto_increment=$starting_no";
		$result = $db->execute($sql);
		$sql1 = "insert into ems_client_auto_id (prefix, digits) Values ('$prefix', '$digits')";
		$result = $db->execute($sql1);
		$sql = "DROP TABLE IF EXISTS ems_clients";
		$result = $db->execute($sql);
		$sql3 = "CREATE TABLE IF NOT EXISTS `ems_clients` (
		  `id` int($digits) NOT NULL AUTO_INCREMENT,
		  `client_id` varchar(50) NOT NULL,
		  `name` varchar(100) NOT NULL,
		  `country` varchar(50) NOT NULL,
		  `state` varchar(11) DEFAULT NULL,
		  `gstin` varchar(50) NOT NULL,
		  `email` varchar(100) NOT NULL,
		  `phone_no` varchar(50) NOT NULL,
		  `address` text NOT NULL,
		  `photo` varchar(50) NOT NULL,
		  `created_at` varchar(50) NOT NULL,
		  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0-on going, 1-completed',
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=$starting_no";
		$result = $db->execute($sql3);
		return $result;
	}
	// checking complete
	public function checkSettingComplete() {
		$db = new DBManager();
		$sql = "SELECT * from ems_setup where id = 1";
		$result = $db->getARecord($sql);
        return $result;
	}
	// updateSetupTable
	public function updateSetupTable() {
		$db = new DBManager();
		$sql = "UPDATE ems_setup set status = 1 where id = 1";
		$result = $db->execute($sql);
        return $result;
	}
}
