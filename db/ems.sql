--
-- Database: `ems`
--

-- --------------------------------------------------------


--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `ems_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `company_address` text NOT NULL,
  `state` int(11) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `crn` varchar(100) NOT NULL,
  `gstin` varchar(100) NOT NULL,
  `pan` varchar(50) NOT NULL,
  `company_logo` varchar(100) NOT NULL,
  `signature` varchar(100) NOT NULL,
  `last_logged_in` varchar(100) NOT NULL,
  `ip` varchar(100) NOT NULL,
  `theme_color` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

DELETE FROM `ems_admin`;
INSERT INTO `ems_admin` (`id`, `username`, `photo`, `password`, `company_name`, `company_address`, `state`, `contact_number`, `email`, `crn`, `gstin`, `pan`, `company_logo`, `signature`, `last_logged_in`, `ip`, `theme_color`,`created_at`) VALUES
(1, 'admin', 'defaultuser.png', '4297f44b13955235245b2497399d7a93', 'Tomato Inc.', 'Delhi', 11, '9508123456', 'admin@tomatoinc.com', '', 'GSTIN123', 'PAN123', 'logo-black.png', '', '1515495317', '110.234.66.65', 'skin-yellow', '2018-01-09 10:55:17');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE IF NOT EXISTS `ems_clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `country` varchar(50) NOT NULL,
  `state` int(5) NOT NULL,
  `gstin` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_no` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `photo` varchar(50) NOT NULL,
  `created_at` varchar(50) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0-on going, 1-completed',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `client_auto_id`
--

CREATE TABLE IF NOT EXISTS `ems_client_auto_id` (
  `id` int(6) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `prefix` varchar(30) DEFAULT NULL,
  `digits` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `company_bank_details`
--

CREATE TABLE IF NOT EXISTS `ems_company_bank_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bank_name` varchar(100) NOT NULL,
  `bank_account_no` varchar(100) NOT NULL,
  `ifsc` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `company_sac`
--

CREATE TABLE IF NOT EXISTS `ems_company_sac` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sac` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE IF NOT EXISTS `ems_employees` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `employee_auto_id`
--

CREATE TABLE IF NOT EXISTS `ems_employee_auto_id` (
  `id` int(6) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `prefix` varchar(30) DEFAULT NULL,
  `digits` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

DELETE FROM `ems_employee_auto_id`;
INSERT INTO `ems_employee_auto_id` (`id`, `prefix`) VALUES
(000100, 'TOM-');

-- --------------------------------------------------------

--
-- Table structure for table `employee_terms_conditions`
--

CREATE TABLE IF NOT EXISTS `ems_employee_terms_conditions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `employee_terms_conditions`
--
DELETE FROM `ems_employee_terms_conditions`;
INSERT INTO `ems_employee_terms_conditions` (`id`, `file_name`, `created_at`) VALUES
(1, 'EMPLOYEES-AGREMENT-TOMATO.pdf', '2017-12-01 18:26:52');

-- --------------------------------------------------------

--
-- Table structure for table `experience_certificate`
--

CREATE TABLE IF NOT EXISTS `ems_experience_certificate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` varchar(50) NOT NULL,
  `experience_details` text NOT NULL,
  `pdf_name` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gst_period`
--

CREATE TABLE IF NOT EXISTS `ems_gst_period` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `period` varchar(50) NOT NULL,
  `status` int(11) NOT NULL COMMENT '0-Not generated, 1-generated',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ems_invoices`
--

CREATE TABLE IF NOT EXISTS `ems_invoices` (
  `id` int(6) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `invoice_id` varchar(255) NOT NULL,
  `client_id` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `gstin` varchar(100) NOT NULL,
  `state` int(11) NOT NULL,
  `invoice_mode` int(2) NOT NULL COMMENT '0-online, 1-manual',
  `reverse_charge` int(2) NOT NULL COMMENT '0-No, 1-Yes',
  `bank_id` int(11) NOT NULL,
  `currency_type` varchar(50) NOT NULL,
  `net_amount` int(11) NOT NULL,
  `invoice_date` varchar(50) NOT NULL,
  `status` int(11) DEFAULT NULL COMMENT '0-Unpaid, 1-Paid, 2-Partially Paid',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ems_invoices_preview`
--

CREATE TABLE IF NOT EXISTS `ems_invoices_preview` (
  `id` int(6) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `invoice_id` varchar(255) NOT NULL,
  `client_id` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `gstin` varchar(100) NOT NULL,
  `state` int(11) NOT NULL,
  `invoice_mode` int(2) NOT NULL COMMENT '0-online, 1-manual',
  `reverse_charge` int(2) NOT NULL COMMENT '0-No, 1-Yes',
  `bank_id` int(11) NOT NULL,
  `currency_type` varchar(50) NOT NULL,
  `net_amount` decimal(10,2) NOT NULL,
  `invoice_date` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ems_invoice_amount`
--

CREATE TABLE IF NOT EXISTS `ems_invoice_amount` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` varchar(100) NOT NULL,
  `desc_of_service` text NOT NULL,
  `sac_code` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `sgst` int(11) NOT NULL,
  `cgst` int(11) NOT NULL,
  `igst` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ems_invoice_amount_preview`
--

CREATE TABLE IF NOT EXISTS `ems_invoice_amount_preview` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` varchar(100) NOT NULL,
  `desc_of_service` text NOT NULL,
  `sac_code` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `sgst` int(11) NOT NULL,
  `cgst` int(11) NOT NULL,
  `igst` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ems_invoice_auto_id`
--

CREATE TABLE IF NOT EXISTS `ems_invoice_auto_id` (
  `id` int(6) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `digits` int(12) DEFAULT NULL,
  `export_invoice_prefix` varchar(30) DEFAULT NULL,
  `current_export_id` int(6) unsigned zerofill NOT NULL,
  `india_based_prefix` varchar(30) DEFAULT NULL,
  `current_india_based_id` int(6) unsigned zerofill NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=101 ;

--
-- Dumping data for table `invoice_auto_id`
--
DELETE FROM `ems_invoice_auto_id`;
INSERT INTO `ems_invoice_auto_id` (`id`, `digits`, `export_invoice_prefix`, `current_export_id`, `india_based_prefix`, `current_india_based_id`) VALUES
(000100, 6, 'E-', 000001, 'TOM-', 000001);

-- --------------------------------------------------------

--
-- Table structure for table `ems_invoice_receive_amount`
--

CREATE TABLE IF NOT EXISTS `ems_invoice_receive_amount` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` varchar(100) NOT NULL,
  `desc_of_service` text NOT NULL,
  `sac_code` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `sgst` int(11) NOT NULL,
  `cgst` int(11) NOT NULL,
  `igst` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `loader`
--

CREATE TABLE IF NOT EXISTS `ems_loader` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `company_profile_update` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `loader`
--
DELETE FROM `ems_loader`;
INSERT INTO `ems_loader` (`id`, `employee_id`, `client_id`, `invoice_id`, `company_profile_update`, `created_at`) VALUES
(1, 0, 0, 0, 0, '2017-12-13 06:58:04');

-- --------------------------------------------------------

--
-- Table structure for table `manage_client_id`
--

CREATE TABLE IF NOT EXISTS `ems_manage_client_id` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL COMMENT '1-autoincrement, 2-manual, 0-none',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `manage_client_id`
--
DELETE FROM `ems_manage_client_id`;
INSERT INTO `ems_manage_client_id` (`id`, `type`) VALUES
(1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ems_manage_employee_id`
--

CREATE TABLE IF NOT EXISTS `ems_manage_employee_id` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) DEFAULT '0' COMMENT '1-autoincrement, 2-manual, 0-none',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `manage_employee_id`
--
DELETE FROM `ems_manage_employee_id`;
INSERT INTO `ems_manage_employee_id` (`id`, `type`) VALUES
(1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ems_payroll`
--

CREATE TABLE IF NOT EXISTS `ems_payroll` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` varchar(50) NOT NULL,
  `basic` decimal(10,2) NOT NULL DEFAULT '0.00',
  `house_rent_allowance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `conveyance_allowance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `special_allowance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `bonus` decimal(10,2) NOT NULL DEFAULT '0.00',
  `overtime` int(10) NOT NULL DEFAULT '0',
  `overtimeAmount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `professional_tax` decimal(10,2) NOT NULL DEFAULT '0.00',
  `income_tax` decimal(10,2) NOT NULL DEFAULT '0.00',
  `provident_fund` decimal(10,2) NOT NULL DEFAULT '0.00',
  `health_insurance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `un_paid_days` decimal(10,2) NOT NULL DEFAULT '0.00',
  `misc` decimal(10,2) NOT NULL DEFAULT '0.00',
  `gross_earnings` decimal(10,2) NOT NULL DEFAULT '0.00',
  `gross_deductions` decimal(10,2) NOT NULL DEFAULT '0.00',
  `net_pay` decimal(10,2) NOT NULL DEFAULT '0.00',
  `pdf_name` varchar(100) NOT NULL,
  `paid_days_count` int(11) NOT NULL,
  `un_paid_days_count` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` varchar(50) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pay_cut_off`
--

CREATE TABLE IF NOT EXISTS `ems_pay_cut_off` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` int(11) NOT NULL COMMENT '0-disabled, 1-enabled',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `pay_cut_off`
--
DELETE FROM `ems_pay_cut_off`;
INSERT INTO `ems_pay_cut_off` (`id`, `status`, `created_at`) VALUES
(1, 0, '2017-12-12 08:32:25');

-- --------------------------------------------------------

--
-- Table structure for table `permanent_appointment`
--

CREATE TABLE IF NOT EXISTS `ems_permanent_appointment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` varchar(50) NOT NULL,
  `appointment_details` text NOT NULL,
  `pdf_name` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ems_preview_payroll`
--

CREATE TABLE IF NOT EXISTS `ems_preview_payroll` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` varchar(50) NOT NULL,
  `basic` decimal(10,2) NOT NULL DEFAULT '0.00',
  `house_rent_allowance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `conveyance_allowance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `special_allowance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `bonus` decimal(10,2) NOT NULL DEFAULT '0.00',
  `overtime` int(10) NOT NULL DEFAULT '0',
  `overtimeAmount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `professional_tax` decimal(10,2) NOT NULL DEFAULT '0.00',
  `income_tax` decimal(10,2) NOT NULL DEFAULT '0.00',
  `provident_fund` decimal(10,2) NOT NULL DEFAULT '0.00',
  `health_insurance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `un_paid_days` decimal(10,2) NOT NULL DEFAULT '0.00',
  `misc` decimal(10,2) NOT NULL DEFAULT '0.00',
  `gross_earnings` decimal(10,2) NOT NULL DEFAULT '0.00',
  `gross_deductions` decimal(10,2) NOT NULL DEFAULT '0.00',
  `net_pay` decimal(10,2) NOT NULL DEFAULT '0.00',
  `pdf_name` varchar(100) NOT NULL,
  `paid_days_count` int(11) NOT NULL,
  `un_paid_days_count` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ems_probationer_appointment`
--

CREATE TABLE IF NOT EXISTS `ems_probationer_appointment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` varchar(50) NOT NULL,
  `appointment_details` text NOT NULL,
  `pdf_name` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ems_profile_update_request`
--

CREATE TABLE IF NOT EXISTS `ems_profile_update_request` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ems_projects`
--

CREATE TABLE IF NOT EXISTS `ems_projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` varchar(50) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `created_at` varchar(50) NOT NULL,
  `ended_at` varchar(50) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0-on going, 1-completed',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

-- --------------------------------------------------------

--
-- Table structure for table `ems_receive_invoice`
--

CREATE TABLE IF NOT EXISTS `ems_receive_invoice` (
  `id` int(6) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `invoice_id` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact_no` varchar(50) NOT NULL,
  `invoice_date` varchar(100) NOT NULL,
  `currency_type` varchar(50) NOT NULL,
  `invoice_amount` decimal(10,2) NOT NULL,
  `gstin` varchar(100) NOT NULL,
  `upload_invoice` varchar(100) NOT NULL,
  `status` int(11) DEFAULT NULL COMMENT '0-Unpaid, 1-Paid, 2-Partially Paid',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ems_reset_password`
--

CREATE TABLE IF NOT EXISTS `ems_reset_password` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `ems_states`
--

CREATE TABLE IF NOT EXISTS `ems_states` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `state_name` varchar(100) NOT NULL,
  `state_gst_code` int(2) unsigned zerofill NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

--
-- Dumping data for table `states`
--
DELETE FROM `ems_states`;
INSERT INTO `ems_states` (`id`, `state_name`, `state_gst_code`, `created_at`) VALUES
(1, 'Andaman and Nicobar Islands', 35, '2017-12-14 11:04:08'),
(2, 'Andhra Pradesh', 28, '2017-12-14 11:04:08'),
(3, 'Andhra Pradesh (New)', 37, '2017-12-14 11:04:08'),
(4, 'Arunachal Pradesh', 12, '2017-12-14 11:04:08'),
(5, 'Assam', 18, '2017-12-14 11:04:08'),
(6, 'Bihar', 10, '2017-12-14 11:04:08'),
(7, 'Chandigarh', 04, '2017-12-14 11:04:08'),
(8, 'Chattisgarh', 22, '2017-12-14 11:04:08'),
(9, 'Dadra and Nagar Haveli', 26, '2017-12-14 11:04:08'),
(10, 'Daman and Diu', 25, '2017-12-14 11:04:08'),
(11, 'Delhi', 07, '2017-12-14 11:04:08'),
(12, 'Goa', 30, '2017-12-14 11:04:08'),
(13, 'Gujarat', 24, '2017-12-14 11:04:08'),
(14, 'Haryana', 06, '2017-12-14 11:04:08'),
(15, 'Himachal Pradesh', 02, '2017-12-14 11:04:08'),
(16, 'Jammu and Kashmir', 01, '2017-12-14 11:04:08'),
(17, 'Jharkhand', 20, '2017-12-14 11:04:08'),
(18, 'Karnataka', 29, '2017-12-14 11:04:08'),
(19, 'Kerala', 32, '2017-12-14 11:04:08'),
(20, 'Lakshadweep Islands', 31, '2017-12-14 11:04:08'),
(21, 'Madhya Pradesh', 23, '2017-12-14 11:04:08'),
(22, 'Maharashtra', 27, '2017-12-14 11:04:08'),
(23, 'Manipur', 14, '2017-12-14 11:04:08'),
(24, 'Meghalaya', 17, '2017-12-14 11:04:08'),
(25, 'Mizoram', 15, '2017-12-14 11:04:08'),
(26, 'Nagaland', 13, '2017-12-14 11:04:08'),
(27, 'Odisha', 21, '2017-12-14 11:04:08'),
(28, 'Pondicherry', 34, '2017-12-14 11:04:08'),
(29, 'Punjab', 03, '2017-12-14 11:04:08'),
(30, 'Rajasthan', 08, '2017-12-14 11:04:08'),
(31, 'Sikkim', 11, '2017-12-14 11:04:08'),
(32, 'Tamil Nadu', 33, '2017-12-14 11:04:08'),
(33, 'Telangana', 36, '2017-12-14 11:04:08'),
(34, 'Tripura', 16, '2017-12-14 11:04:08'),
(35, 'Uttar Pradesh', 09, '2017-12-14 11:04:08'),
(36, 'Uttarakhand', 05, '2017-12-14 11:04:08'),
(37, 'West Bengal', 19, '2017-12-14 11:04:08');

-- --------------------------------------------------------

--
-- Table structure for table `ems_weekly_holidays`
--

CREATE TABLE IF NOT EXISTS `ems_weekly_holidays` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `day_name` varchar(30) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

DELETE FROM `ems_weekly_holidays`;
INSERT INTO `ems_weekly_holidays` (`id`, `day_name`, `created_at`) VALUES
(1, 'Sun', '2017-12-13 05:54:30'),
(2, 'Sat', '2017-12-13 05:54:30');

-- --------------------------------------------------------

--
-- Table structure for table `ems_setup`
--

CREATE TABLE IF NOT EXISTS `ems_setup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` int(11) NOT NULL COMMENT '0-setting incoplete, 1- setting compete',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `ems_setup`
--
DELETE FROM `ems_setup`;
INSERT INTO `ems_setup` (`id`, `status`, `created_at`) VALUES
(1, 0, '2018-01-13 11:49:32');

ALTER TABLE `ems_receive_invoice` CHANGE `status` `status` INT(11) NULL DEFAULT '0' COMMENT '0-Unpaid, 1-Paid, 2-Partially Paid';