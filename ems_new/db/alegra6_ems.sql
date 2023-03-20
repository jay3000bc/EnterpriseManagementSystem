-- phpMyAdmin SQL Dump
-- version 4.9.11
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 20, 2023 at 03:13 AM
-- Server version: 10.2.44-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `alegra6_ems`
--
CREATE DATABASE IF NOT EXISTS `alegra6_ems` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `alegra6_ems`;

-- --------------------------------------------------------

--
-- Table structure for table `ems_admin`
--

CREATE TABLE `ems_admin` (
  `id` int(11) NOT NULL,
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
  `theme_color` varchar(50) NOT NULL DEFAULT 'skin-yellow',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ems_clients`
--

CREATE TABLE `ems_clients` (
  `id` int(5) NOT NULL,
  `client_id` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `country` varchar(50) NOT NULL,
  `state` varchar(100) DEFAULT NULL,
  `gstin` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_no` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `photo` varchar(50) NOT NULL,
  `created_at` varchar(50) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0-on going, 1-completed'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ems_client_auto_id`
--

CREATE TABLE `ems_client_auto_id` (
  `id` int(5) UNSIGNED ZEROFILL NOT NULL,
  `prefix` varchar(30) DEFAULT NULL,
  `digits` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ems_company_bank_details`
--

CREATE TABLE `ems_company_bank_details` (
  `id` int(11) NOT NULL,
  `bank_name` varchar(100) NOT NULL,
  `bank_account_no` varchar(100) NOT NULL,
  `ifsc` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ems_company_sac`
--

CREATE TABLE `ems_company_sac` (
  `id` int(11) NOT NULL,
  `sac` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ems_employees`
--

CREATE TABLE `ems_employees` (
  `id` int(4) UNSIGNED NOT NULL,
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
  `max_qualification` varchar(255) NOT NULL,
  `pf_account` text DEFAULT NULL,
  `policy_no` varchar(100) DEFAULT NULL,
  `lic_id` varchar(100) DEFAULT NULL,
  `pan` varchar(100) DEFAULT NULL,
  `passport_no` varchar(100) DEFAULT NULL,
  `driving_license_no` varchar(100) DEFAULT NULL,
  `bank_account` text NOT NULL,
  `ifsc_code` varchar(50) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1-Active, 0-Inactive',
  `last_logged_in` varchar(100) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ems_employee_auto_id`
--

CREATE TABLE `ems_employee_auto_id` (
  `id` int(4) UNSIGNED ZEROFILL NOT NULL,
  `prefix` varchar(100) DEFAULT NULL,
  `digits` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ems_employee_terms_conditions`
--

CREATE TABLE `ems_employee_terms_conditions` (
  `id` int(11) NOT NULL,
  `file_name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ems_experience_certificate`
--

CREATE TABLE `ems_experience_certificate` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(50) NOT NULL,
  `experience_details` text NOT NULL,
  `pdf_name` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ems_gst_period`
--

CREATE TABLE `ems_gst_period` (
  `id` int(11) NOT NULL,
  `period` varchar(50) NOT NULL,
  `status` int(11) NOT NULL COMMENT '0-Not generated, 1-generated',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ems_invoices`
--

CREATE TABLE `ems_invoices` (
  `id` int(5) UNSIGNED ZEROFILL NOT NULL,
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
  `qty_hrs` int(11) NOT NULL DEFAULT 0 COMMENT '0-Quantity, 1-Hourly',
  `net_amount` decimal(10,2) NOT NULL,
  `invoice_date` varchar(50) NOT NULL,
  `status` int(11) DEFAULT NULL COMMENT '0-Unpaid, 1-Paid',
  `invoice_paid_date` date DEFAULT NULL,
  `credit_note` text DEFAULT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ems_invoices_preview`
--

CREATE TABLE `ems_invoices_preview` (
  `id` int(6) UNSIGNED ZEROFILL NOT NULL,
  `invoice_id` varchar(255) NOT NULL,
  `client_id` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `gstin` varchar(100) NOT NULL,
  `state` varchar(255) DEFAULT NULL,
  `invoice_mode` int(2) NOT NULL COMMENT '0-online, 1-manual',
  `reverse_charge` int(2) NOT NULL COMMENT '0-No, 1-Yes',
  `bank_id` int(11) NOT NULL,
  `currency_type` varchar(50) NOT NULL,
  `qty_hrs` int(11) NOT NULL DEFAULT 0 COMMENT '0-Quantity, 1-Hourly',
  `net_amount` decimal(10,2) NOT NULL,
  `invoice_date` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ems_invoice_amount`
--

CREATE TABLE `ems_invoice_amount` (
  `id` int(11) NOT NULL,
  `invoice_id` varchar(100) NOT NULL,
  `desc_of_service` text NOT NULL,
  `sac_code` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `sgst` int(11) NOT NULL,
  `cgst` int(11) NOT NULL,
  `igst` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ems_invoice_amount_preview`
--

CREATE TABLE `ems_invoice_amount_preview` (
  `id` int(11) NOT NULL,
  `invoice_id` varchar(100) NOT NULL,
  `desc_of_service` text NOT NULL,
  `sac_code` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `sgst` int(11) NOT NULL,
  `cgst` int(11) NOT NULL,
  `igst` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ems_invoice_auto_id`
--

CREATE TABLE `ems_invoice_auto_id` (
  `id` int(5) UNSIGNED ZEROFILL NOT NULL,
  `digits` int(12) DEFAULT NULL,
  `export_invoice_prefix` varchar(30) DEFAULT NULL,
  `current_export_id` int(5) UNSIGNED ZEROFILL NOT NULL,
  `india_based_prefix` varchar(30) DEFAULT NULL,
  `current_india_based_id` int(5) UNSIGNED ZEROFILL NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ems_invoice_receive_amount`
--

CREATE TABLE `ems_invoice_receive_amount` (
  `id` int(11) NOT NULL,
  `invoice_id` varchar(100) NOT NULL,
  `desc_of_service` text NOT NULL,
  `sac_code` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `sgst` int(11) NOT NULL,
  `cgst` int(11) NOT NULL,
  `igst` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ems_loader`
--

CREATE TABLE `ems_loader` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `company_profile_update` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ems_manage_client_id`
--

CREATE TABLE `ems_manage_client_id` (
  `id` int(11) NOT NULL,
  `type` int(11) NOT NULL COMMENT '1-autoincrement, 2-manual, 0-none'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ems_manage_employee_id`
--

CREATE TABLE `ems_manage_employee_id` (
  `id` int(11) NOT NULL,
  `type` int(11) DEFAULT 0 COMMENT '1-autoincrement, 2-manual, 0-none'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ems_payroll`
--

CREATE TABLE `ems_payroll` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(50) NOT NULL,
  `basic` decimal(10,2) NOT NULL DEFAULT 0.00,
  `house_rent_allowance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `food_allowance` decimal(10,2) NOT NULL,
  `conveyance_allowance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `special_allowance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `bonus` decimal(10,2) NOT NULL DEFAULT 0.00,
  `overtime` int(10) NOT NULL DEFAULT 0,
  `overtimeAmount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `professional_tax` decimal(10,2) NOT NULL DEFAULT 0.00,
  `income_tax` decimal(10,2) NOT NULL DEFAULT 0.00,
  `provident_fund` decimal(10,2) NOT NULL DEFAULT 0.00,
  `health_insurance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `un_paid_days` decimal(10,2) NOT NULL DEFAULT 0.00,
  `misc` decimal(10,2) NOT NULL DEFAULT 0.00,
  `gross_earnings` decimal(10,2) NOT NULL DEFAULT 0.00,
  `gross_deductions` decimal(10,2) NOT NULL DEFAULT 0.00,
  `net_pay` decimal(10,2) NOT NULL DEFAULT 0.00,
  `pdf_name` varchar(100) NOT NULL,
  `paid_days_count` int(11) NOT NULL,
  `un_paid_days_count` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` varchar(50) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ems_pay_cut_off`
--

CREATE TABLE `ems_pay_cut_off` (
  `id` int(11) NOT NULL,
  `status` int(11) NOT NULL COMMENT '0-disabled, 1-enabled',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ems_permanent_appointment`
--

CREATE TABLE `ems_permanent_appointment` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(50) NOT NULL,
  `appointment_details` text NOT NULL,
  `pdf_name` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ems_preview_payroll`
--

CREATE TABLE `ems_preview_payroll` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(50) NOT NULL,
  `basic` decimal(10,2) NOT NULL DEFAULT 0.00,
  `house_rent_allowance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `food_allowance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `conveyance_allowance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `special_allowance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `bonus` decimal(10,2) NOT NULL DEFAULT 0.00,
  `overtime` int(10) NOT NULL DEFAULT 0,
  `overtimeAmount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `professional_tax` decimal(10,2) NOT NULL DEFAULT 0.00,
  `income_tax` decimal(10,2) NOT NULL DEFAULT 0.00,
  `provident_fund` decimal(10,2) NOT NULL DEFAULT 0.00,
  `health_insurance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `un_paid_days` decimal(10,2) NOT NULL DEFAULT 0.00,
  `misc` decimal(10,2) NOT NULL DEFAULT 0.00,
  `gross_earnings` decimal(10,2) NOT NULL DEFAULT 0.00,
  `gross_deductions` decimal(10,2) NOT NULL DEFAULT 0.00,
  `net_pay` decimal(10,2) NOT NULL DEFAULT 0.00,
  `pdf_name` varchar(100) NOT NULL,
  `paid_days_count` int(11) NOT NULL,
  `un_paid_days_count` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ems_probationer_appointment`
--

CREATE TABLE `ems_probationer_appointment` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(50) NOT NULL,
  `appointment_details` text NOT NULL,
  `pdf_name` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ems_profile_update_request`
--

CREATE TABLE `ems_profile_update_request` (
  `id` int(11) UNSIGNED NOT NULL,
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
  `max_qualification` varchar(255) NOT NULL,
  `pf_account` text DEFAULT NULL,
  `policy_no` varchar(100) DEFAULT NULL,
  `lic_id` varchar(100) DEFAULT NULL,
  `pan` varchar(100) DEFAULT NULL,
  `passport_no` varchar(100) DEFAULT NULL,
  `driving_license_no` varchar(100) DEFAULT NULL,
  `bank_account` text NOT NULL,
  `ifsc_code` varchar(50) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1-Active, 0-Inactive',
  `last_logged_in` varchar(100) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ems_projects`
--

CREATE TABLE `ems_projects` (
  `id` int(11) NOT NULL,
  `client_id` varchar(50) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `created_at` varchar(50) NOT NULL,
  `ended_at` varchar(50) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0-on going, 1-completed',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ems_receive_invoice`
--

CREATE TABLE `ems_receive_invoice` (
  `id` int(6) UNSIGNED ZEROFILL NOT NULL,
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
  `status` int(11) DEFAULT 0 COMMENT '0-Unpaid, 1-Paid',
  `invoice_paid_date` date DEFAULT NULL,
  `credit_note` text DEFAULT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ems_reset_password`
--

CREATE TABLE `ems_reset_password` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ems_setup`
--

CREATE TABLE `ems_setup` (
  `id` int(11) NOT NULL,
  `status` int(11) NOT NULL COMMENT '0-setting incoplete, 1- setting compete',
  `counter` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ems_states`
--

CREATE TABLE `ems_states` (
  `id` int(11) NOT NULL,
  `state_name` varchar(100) NOT NULL,
  `state_gst_code` int(2) UNSIGNED ZEROFILL NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ems_weekly_holidays`
--

CREATE TABLE `ems_weekly_holidays` (
  `id` int(11) NOT NULL,
  `day_name` varchar(30) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ems_admin`
--
ALTER TABLE `ems_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_clients`
--
ALTER TABLE `ems_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_client_auto_id`
--
ALTER TABLE `ems_client_auto_id`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_company_bank_details`
--
ALTER TABLE `ems_company_bank_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_company_sac`
--
ALTER TABLE `ems_company_sac`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_employees`
--
ALTER TABLE `ems_employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_employee_auto_id`
--
ALTER TABLE `ems_employee_auto_id`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_employee_terms_conditions`
--
ALTER TABLE `ems_employee_terms_conditions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_experience_certificate`
--
ALTER TABLE `ems_experience_certificate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_gst_period`
--
ALTER TABLE `ems_gst_period`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_invoices`
--
ALTER TABLE `ems_invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_invoices_preview`
--
ALTER TABLE `ems_invoices_preview`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_invoice_amount`
--
ALTER TABLE `ems_invoice_amount`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_invoice_amount_preview`
--
ALTER TABLE `ems_invoice_amount_preview`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_invoice_auto_id`
--
ALTER TABLE `ems_invoice_auto_id`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_invoice_receive_amount`
--
ALTER TABLE `ems_invoice_receive_amount`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_loader`
--
ALTER TABLE `ems_loader`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_manage_client_id`
--
ALTER TABLE `ems_manage_client_id`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_manage_employee_id`
--
ALTER TABLE `ems_manage_employee_id`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_payroll`
--
ALTER TABLE `ems_payroll`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_pay_cut_off`
--
ALTER TABLE `ems_pay_cut_off`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_permanent_appointment`
--
ALTER TABLE `ems_permanent_appointment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_preview_payroll`
--
ALTER TABLE `ems_preview_payroll`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_probationer_appointment`
--
ALTER TABLE `ems_probationer_appointment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_profile_update_request`
--
ALTER TABLE `ems_profile_update_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_projects`
--
ALTER TABLE `ems_projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_receive_invoice`
--
ALTER TABLE `ems_receive_invoice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_reset_password`
--
ALTER TABLE `ems_reset_password`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_setup`
--
ALTER TABLE `ems_setup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_states`
--
ALTER TABLE `ems_states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_weekly_holidays`
--
ALTER TABLE `ems_weekly_holidays`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ems_admin`
--
ALTER TABLE `ems_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ems_clients`
--
ALTER TABLE `ems_clients`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ems_client_auto_id`
--
ALTER TABLE `ems_client_auto_id`
  MODIFY `id` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ems_company_bank_details`
--
ALTER TABLE `ems_company_bank_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ems_company_sac`
--
ALTER TABLE `ems_company_sac`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ems_employees`
--
ALTER TABLE `ems_employees`
  MODIFY `id` int(4) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ems_employee_auto_id`
--
ALTER TABLE `ems_employee_auto_id`
  MODIFY `id` int(4) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ems_employee_terms_conditions`
--
ALTER TABLE `ems_employee_terms_conditions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ems_experience_certificate`
--
ALTER TABLE `ems_experience_certificate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ems_gst_period`
--
ALTER TABLE `ems_gst_period`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ems_invoices`
--
ALTER TABLE `ems_invoices`
  MODIFY `id` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ems_invoices_preview`
--
ALTER TABLE `ems_invoices_preview`
  MODIFY `id` int(6) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ems_invoice_amount`
--
ALTER TABLE `ems_invoice_amount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ems_invoice_amount_preview`
--
ALTER TABLE `ems_invoice_amount_preview`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ems_invoice_auto_id`
--
ALTER TABLE `ems_invoice_auto_id`
  MODIFY `id` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ems_invoice_receive_amount`
--
ALTER TABLE `ems_invoice_receive_amount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ems_loader`
--
ALTER TABLE `ems_loader`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ems_manage_client_id`
--
ALTER TABLE `ems_manage_client_id`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ems_manage_employee_id`
--
ALTER TABLE `ems_manage_employee_id`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ems_payroll`
--
ALTER TABLE `ems_payroll`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ems_pay_cut_off`
--
ALTER TABLE `ems_pay_cut_off`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ems_permanent_appointment`
--
ALTER TABLE `ems_permanent_appointment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ems_preview_payroll`
--
ALTER TABLE `ems_preview_payroll`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ems_probationer_appointment`
--
ALTER TABLE `ems_probationer_appointment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ems_profile_update_request`
--
ALTER TABLE `ems_profile_update_request`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ems_projects`
--
ALTER TABLE `ems_projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ems_receive_invoice`
--
ALTER TABLE `ems_receive_invoice`
  MODIFY `id` int(6) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ems_reset_password`
--
ALTER TABLE `ems_reset_password`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ems_setup`
--
ALTER TABLE `ems_setup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ems_states`
--
ALTER TABLE `ems_states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ems_weekly_holidays`
--
ALTER TABLE `ems_weekly_holidays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
