-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 18, 2017 at 03:29 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `imsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `division_masterfile`
--

CREATE TABLE IF NOT EXISTS `division_masterfile` (
  `div_code` varchar(9) NOT NULL,
  `div_name` varchar(50) NOT NULL,
  `user_add` varchar(20) DEFAULT NULL,
  `user_add_date` datetime NOT NULL,
  PRIMARY KEY (`div_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `division_masterfile`
--

INSERT INTO `division_masterfile` (`div_code`, `div_name`, `user_add`, `user_add_date`) VALUES
('000000101', 'Academic Departments', '', '2017-03-18 01:22:49'),
('000000102', 'Administration and Finance', '', '2017-03-18 01:22:49'),
('000000103', 'Services', '', '2017-03-18 01:22:49');

-- --------------------------------------------------------

--
-- Table structure for table `fund`
--

CREATE TABLE IF NOT EXISTS `fund` (
  `year` int(4) NOT NULL,
  `grant_code` varchar(10) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  PRIMARY KEY (`year`,`grant_code`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fund`
--

INSERT INTO `fund` (`year`, `grant_code`, `amount`) VALUES
(2017, 'GOSL', '2000000.00'),
(2017, 'UCSC funds', '1000000.00');

-- --------------------------------------------------------

--
-- Table structure for table `fund_detail`
--

CREATE TABLE IF NOT EXISTS `fund_detail` (
  `year` int(4) NOT NULL,
  `grant_code` varchar(10) NOT NULL,
  `itype_code` varchar(10) NOT NULL,
  `div_code` varchar(9) NOT NULL,
  `unit_code` varchar(9) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `user_add` varchar(30) NOT NULL,
  `user_add_date` datetime NOT NULL,
  `user_mod` varchar(30) NOT NULL,
  `user_mod_date` datetime NOT NULL,
  PRIMARY KEY (`year`,`grant_code`,`div_code`,`unit_code`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fund_detail`
--

INSERT INTO `fund_detail` (`year`, `grant_code`, `itype_code`, `div_code`, `unit_code`, `amount`, `user_add`, `user_add_date`, `user_mod`, `user_mod_date`) VALUES
(2017, 'GOSL', 'CON', '000000101', '000101001', '10000.00', 'admin', '2017-03-25 07:15:38', '', '0000-00-00 00:00:00'),
(2017, 'GOSL', 'CON', '000000101', '000101003', '100000.00', 'admin', '2017-03-25 07:11:26', '', '0000-00-00 00:00:00'),
(2017, 'GOSL', 'FA', '000000103', '000103006', '120000.00', 'admin', '2017-03-25 09:48:19', 'admin', '2017-03-25 18:45:38'),
(2017, 'UCSC funds', 'FA', '000000103', '000103006', '10000.00', 'admin', '2017-03-25 18:04:14', '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `grants`
--

CREATE TABLE IF NOT EXISTS `grants` (
  `grant_code` varchar(15) NOT NULL,
  `grant_name` varchar(100) NOT NULL,
  PRIMARY KEY (`grant_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grants`
--

INSERT INTO `grants` (`grant_code`, `grant_name`) VALUES
('GOSL', 'Govt. of Sri Lanka'),
('UCSC funds', 'UCSC funds');

-- --------------------------------------------------------

--
-- Table structure for table `grn_detail`
--

CREATE TABLE IF NOT EXISTS `grn_detail` (
  `grnd_number` varchar(11) NOT NULL,
  `grnd_mark` char(1) NOT NULL DEFAULT 'U',
  `grnd_transact_number` int(11) NOT NULL,
  `grnd_source` varchar(5) NOT NULL,
  `grnd_item_code` varchar(10) NOT NULL,
  `grnd_qty_recd` decimal(12,2) NOT NULL,
  `grnd_unit_price` decimal(12,2) DEFAULT NULL,
  `grnd_edit_price` decimal(12,2) DEFAULT NULL,
  `tax_per_unit` decimal(12,4) DEFAULT NULL,
  `edited_tax` decimal(12,2) NOT NULL,
  `tot_value` decimal(10,2) DEFAULT NULL,
  `grnd_stock_acct` varchar(6) DEFAULT NULL,
  `grnd_acct_yr` int(11) NOT NULL,
  `grnd_po_no` int(11) NOT NULL,
  `grnd_po_status` varchar(10) DEFAULT NULL,
  `grnd_po_acct_yr` int(11) DEFAULT NULL,
  `grnd_po_mark` char(1) NOT NULL,
  `grnd_order_qty` decimal(12,2) DEFAULT NULL,
  `grnd_already_received_qty` decimal(12,2) DEFAULT NULL,
  `batch_num` varchar(20) DEFAULT NULL,
  `invoice_num` varchar(50) DEFAULT NULL,
  `os_user` varchar(30) DEFAULT NULL,
  `machine_id` varchar(30) DEFAULT NULL,
  `user_add` varchar(30) DEFAULT NULL,
  `user_add_date` datetime DEFAULT NULL,
  `user_mod` varchar(30) DEFAULT NULL,
  `user_mod_date` datetime DEFAULT NULL,
  `purchase_type_flag` char(1) DEFAULT NULL,
  `job_doc_year` int(11) DEFAULT NULL,
  `job_doc_number` int(11) DEFAULT NULL,
  `job_tran_no` int(11) DEFAULT NULL,
  `additional_cost` decimal(18,2) DEFAULT NULL,
  `previous_cost` decimal(18,2) DEFAULT NULL,
  `com_code` varchar(6) DEFAULT NULL,
  `branch_code` varchar(6) DEFAULT NULL,
  `dep_code` varchar(9) DEFAULT NULL,
  `sec_code` varchar(9) DEFAULT NULL,
  `prog_code` varchar(9) DEFAULT NULL,
  PRIMARY KEY (`grnd_number`,`grnd_mark`,`grnd_item_code`,`grnd_acct_yr`),
  KEY `idx_grnd_batch_item` (`batch_num`,`grnd_item_code`),
  KEY `grnd_item_code` (`grnd_item_code`,`grnd_po_no`,`grnd_po_acct_yr`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `grn_master`
--

CREATE TABLE IF NOT EXISTS `grn_master` (
  `grnm_number` int(11) NOT NULL,
  `grnm_mark` char(1) NOT NULL DEFAULT 'U',
  `grnm_date` date NOT NULL,
  `grnm_supplier_code` varchar(10) NOT NULL,
  `grnm_supply_year` int(4) DEFAULT NULL,
  `grnm_narration` varchar(150) DEFAULT NULL,
  `grnm_shipment_num` int(11) DEFAULT NULL,
  `grnm_pur_inv_entered` varchar(1) DEFAULT NULL,
  `grnm_tp_no` varchar(20) DEFAULT NULL,
  `location_code` varchar(6) NOT NULL,
  `grnm_acct_yr` int(11) NOT NULL,
  `grnm_fob_value` decimal(12,2) NOT NULL,
  `grnm_foreign_total` decimal(12,2) NOT NULL,
  `grnm_lkr_total` decimal(12,2) NOT NULL,
  `grnm_bank_charg` decimal(12,2) NOT NULL,
  `grnm_grand_tot` decimal(12,2) DEFAULT NULL,
  `grnm_popay_amount` decimal(12,2) NOT NULL,
  `grnm_reference` char(15) DEFAULT NULL,
  `grnm_modifiable` char(1) NOT NULL,
  `grnm_cancelled` char(1) NOT NULL,
  `grnm_supp_foreign_local` char(1) NOT NULL,
  `grnm_project_code` varchar(6) DEFAULT NULL,
  `grnm_job_code` varchar(6) DEFAULT NULL,
  `os_user` varchar(30) DEFAULT NULL,
  `machine_id` varchar(30) DEFAULT NULL,
  `user_add` varchar(30) DEFAULT NULL,
  `user_add_date` datetime DEFAULT NULL,
  `user_mod` varchar(30) DEFAULT NULL,
  `user_mod_date` datetime DEFAULT NULL,
  `doct_source` varchar(5) DEFAULT NULL,
  `purchase_type_flag` varchar(15) DEFAULT NULL,
  `grnm_lc_no` varchar(20) NOT NULL,
  `grnm_exch_rate` decimal(11,8) NOT NULL,
  `grnm_fund_yr` int(11) NOT NULL,
  `grnm_grant_code` varchar(10) NOT NULL,
  `grnm_fund_code` varchar(8) NOT NULL,
  `grnm_fund_fac` varchar(9) NOT NULL,
  `grnm_fund_dept` varchar(9) NOT NULL,
  `grnm_fund_prog` varchar(9) NOT NULL,
  `grnm_value_more` decimal(12,2) NOT NULL,
  `grnm_value_less` decimal(12,2) NOT NULL,
  PRIMARY KEY (`grnm_number`,`grnm_mark`,`grnm_acct_yr`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `io_cancel`
--

CREATE TABLE IF NOT EXISTS `io_cancel` (
  `io_doct_num` int(11) NOT NULL,
  `io_acct_yr` int(11) NOT NULL,
  `io_date` datetime NOT NULL,
  `io_remarks` varchar(100) NOT NULL,
  `io_user_can` varchar(30) NOT NULL,
  PRIMARY KEY (`io_doct_num`,`io_acct_yr`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `issue_order_note_detail`
--

CREATE TABLE IF NOT EXISTS `issue_order_note_detail` (
  `ionh_doct_year` int(11) NOT NULL,
  `ionh_doct_no` int(11) NOT NULL,
  `ionh_doct_mark` char(1) NOT NULL DEFAULT 'U',
  `iond_transact_no` int(11) NOT NULL,
  `iond_item_code` varchar(10) NOT NULL,
  `iond_batch_no` varchar(20) NOT NULL,
  `iond_serial_no` varchar(50) DEFAULT NULL,
  `purchase_type_flag` char(1) DEFAULT NULL,
  `qty` decimal(18,2) NOT NULL,
  `qty_issued` decimal(12,2) NOT NULL DEFAULT '0.00',
  `unit_price` decimal(18,2) NOT NULL,
  `os_user` varchar(30) DEFAULT NULL,
  `machine_id` varchar(30) DEFAULT NULL,
  `user_add` varchar(30) DEFAULT NULL,
  `user_add_date` datetime DEFAULT NULL,
  `user_mod` varchar(30) DEFAULT NULL,
  `user_mod_date` datetime DEFAULT NULL,
  PRIMARY KEY (`ionh_doct_year`,`ionh_doct_no`,`ionh_doct_mark`,`iond_transact_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `issue_order_note_header`
--

CREATE TABLE IF NOT EXISTS `issue_order_note_header` (
  `ionh_doct_year` int(11) NOT NULL,
  `ionh_doct_no` int(11) NOT NULL,
  `ionh_doct_mark` char(1) NOT NULL DEFAULT 'U',
  `ionh_date` date DEFAULT NULL,
  `ionh_from_loc` varchar(6) DEFAULT NULL,
  `ionh_to_faculty` varchar(9) DEFAULT NULL,
  `ionh_to_department` varchar(9) DEFAULT NULL,
  `ionh_to_programme` varchar(9) DEFAULT NULL,
  `ionh_to_code` varchar(10) DEFAULT NULL,
  `ionh_narration` varchar(50) DEFAULT NULL,
  `ionh_cancel` char(1) DEFAULT NULL,
  `ionh_modifiable` char(1) DEFAULT NULL,
  `ionh_reference` varchar(50) DEFAULT NULL,
  `ionh_total_value` decimal(18,2) NOT NULL,
  `os_user` varchar(30) DEFAULT NULL,
  `machine_id` varchar(30) DEFAULT NULL,
  `user_add` varchar(30) DEFAULT NULL,
  `user_add_date` datetime DEFAULT NULL,
  `user_mod` varchar(30) DEFAULT NULL,
  `user_mod_date` datetime DEFAULT NULL,
  `doct_source` varchar(5) DEFAULT NULL,
  `com_code` varchar(6) DEFAULT NULL,
  `branch_code` varchar(6) DEFAULT NULL,
  PRIMARY KEY (`ionh_doct_year`,`ionh_doct_no`,`ionh_doct_mark`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `item_category`
--

CREATE TABLE IF NOT EXISTS `item_category` (
  `category_code` varchar(3) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `os_user` varchar(10) NOT NULL,
  `user_add_date` datetime NOT NULL DEFAULT '1900-01-01 01:01:01',
  PRIMARY KEY (`category_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_category`
--

INSERT INTO `item_category` (`category_code`, `category_name`, `os_user`, `user_add_date`) VALUES
('001', 'Printed Forms', 'admin', '2016-06-11 17:00:52'),
('002', 'Printed Books', 'admin', '2016-06-11 17:00:52'),
('003', 'Office Equipments', 'admin', '2016-06-11 17:00:52'),
('004', 'Furnitures', 'admin', '2016-06-11 17:00:52'),
('005', 'Computing Devices', 'admin', '2017-03-25 09:39:41');

-- --------------------------------------------------------

--
-- Table structure for table `item_detail`
--

CREATE TABLE IF NOT EXISTS `item_detail` (
  `id_doct_number` int(11) NOT NULL DEFAULT '0',
  `id_date` date DEFAULT NULL,
  `id_source` varchar(5) NOT NULL DEFAULT '',
  `id_transact_number` int(11) NOT NULL DEFAULT '0',
  `id_debit` decimal(12,2) DEFAULT NULL,
  `id_credit` decimal(12,2) DEFAULT NULL,
  `id_transact_narration` varchar(75) DEFAULT NULL,
  `id_item_code` varchar(10) DEFAULT NULL,
  `id_receipts_qty` decimal(12,2) NOT NULL DEFAULT '0.00',
  `id_issues_qty` decimal(12,2) NOT NULL DEFAULT '0.00',
  `id_location` varchar(6) DEFAULT NULL,
  `id_currency` varchar(5) DEFAULT NULL,
  `id_exch_rate` decimal(6,2) DEFAULT NULL,
  `id_foreign_debit` decimal(12,2) DEFAULT NULL,
  `id_foreign_credit` decimal(12,2) DEFAULT NULL,
  `id_post` varchar(1) DEFAULT NULL,
  `id_unit_cost_price` decimal(12,2) DEFAULT NULL,
  `batch_num` varchar(20) NOT NULL DEFAULT '',
  `id_on_hand` decimal(12,2) DEFAULT NULL,
  `id_avg_cost` decimal(12,2) DEFAULT NULL,
  `id_asset_value` decimal(12,2) DEFAULT NULL,
  `id_cancel` varchar(1) DEFAULT NULL,
  `id_model_code` varchar(25) DEFAULT NULL,
  `os_user` varchar(30) DEFAULT NULL,
  `user_add` varchar(30) DEFAULT NULL,
  `user_add_date` datetime DEFAULT NULL,
  `user_mod` varchar(30) DEFAULT NULL,
  `user_mod_date` datetime DEFAULT NULL,
  `purchase_type_flag` varchar(15) NOT NULL DEFAULT '',
  `div_code` varchar(9) DEFAULT NULL,
  `unit_code` varchar(9) DEFAULT NULL,
  PRIMARY KEY (`id_doct_number`,`id_source`,`batch_num`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `item_masterfile`
--

CREATE TABLE IF NOT EXISTS `item_masterfile` (
  `item_code` varchar(10) NOT NULL,
  `item_description` varchar(50) NOT NULL,
  `item_price` decimal(12,2) NOT NULL,
  `item_loc_code` varchar(6) NOT NULL,
  `item_cost` decimal(12,2) NOT NULL,
  `qty_in_hand` decimal(12,2) DEFAULT '0.00',
  `import_local` varchar(1) NOT NULL,
  `item_rol` int(3) DEFAULT NULL,
  `item_rol_qty` decimal(12,2) DEFAULT NULL,
  `item_cost_fc` decimal(12,2) NOT NULL,
  `item_uom` varchar(15) DEFAULT NULL,
  `item_costing_method` varchar(1) DEFAULT NULL,
  `product_category_code` varchar(3) DEFAULT NULL,
  `model_code` varchar(10) DEFAULT NULL,
  `item_serial_no_status` char(1) DEFAULT NULL,
  `item_type_code` varchar(10) DEFAULT NULL,
  `item_fa_code` varchar(3) NOT NULL,
  `product_sub_category_code` varchar(3) DEFAULT NULL,
  `user_add` varchar(30) DEFAULT NULL,
  `user_add_old` varchar(30) DEFAULT NULL,
  `user_add_date` datetime NOT NULL,
  `user_mod` varchar(30) DEFAULT NULL,
  `user_mod_date` datetime NOT NULL,
  PRIMARY KEY (`item_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_masterfile`
--

INSERT INTO `item_masterfile` (`item_code`, `item_description`, `item_price`, `item_loc_code`, `item_cost`, `qty_in_hand`, `import_local`, `item_rol`, `item_rol_qty`, `item_cost_fc`, `item_uom`, `item_costing_method`, `product_category_code`, `model_code`, `item_serial_no_status`, `item_type_code`, `item_fa_code`, `product_sub_category_code`, `user_add`, `user_add_old`, `user_add_date`, `user_mod`, `user_mod_date`) VALUES
('001001001 ', 'Letter Heads (General) Large', '1.00', '000001', '1.00', '55589.00', 'L', NULL, '50000.00', '1.00', 'Other', 'F', '001', NULL, NULL, 'FA', '', '001', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('001003001 ', 'Railway Ticket Application', '1.00', '000001', '1.00', '1240.00', 'L', NULL, '1500.00', '1.00', 'Other', 'F', '001', NULL, NULL, 'FA', '', '003', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('001003002 ', 'Railway Warrant Application - AB 70', '1.00', '000001', '1.00', '22.00', 'L', NULL, '50.00', '1.00', 'Other', 'F', '001', NULL, NULL, 'FA', '', '003', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('001005001 ', 'Certificate', '1.00', '000001', '1.00', '0.00', 'L', NULL, '1000.00', '1.00', 'Pkt', 'L', '001', NULL, NULL, 'CON', '', '005', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('002001001 ', 'Ledger', '0.00', '', '0.00', '0.00', 'L', 2, '10.00', '0.00', NULL, NULL, '002', NULL, NULL, 'FA', '', '', 'admin', NULL, '2017-03-21 03:42:39', NULL, '0000-00-00 00:00:00'),
('002002006 ', 'General Register', '1.00', '000001', '1.00', '0.00', 'L', NULL, '0.00', '1.00', 'Other', 'F', '002', NULL, NULL, 'FA', '', '002', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('002003001 ', 'UPF Loan Register', '1.00', '000001', '1.00', '8.00', 'L', NULL, '10.00', '1.00', 'Other', 'F', '002', NULL, NULL, 'CON', '', '003', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('002003002 ', 'Vote Ledger Book', '1.00', '000001', '1.00', '0.00', 'L', NULL, '100.00', '1.00', 'Other', 'F', '002', NULL, NULL, 'CON', '', '003', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('002003003 ', 'Deposite Ledger Book', '1.00', '000001', '1.00', '1.00', 'L', NULL, '10.00', '1.00', 'Other', 'F', '002', NULL, NULL, 'CON', '', '003', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('002003004 ', 'Mahapola Scholarship Paying Register', '1.00', '000001', '1.00', '4.00', 'L', NULL, '10.00', '1.00', 'Other', 'F', '002', NULL, NULL, 'CON', '', '003', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('002003005 ', 'Shroff Cheque & Cash Register', '1.00', '000001', '1.00', '16143.00', 'L', NULL, '10.00', '1.00', 'Other', 'F', '002', NULL, NULL, 'CON', '', '003', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('002003006 ', 'Cash Receipt Book - 219 (Invoice Book)', '1.00', '000001', '1.00', '25.00', 'L', NULL, '10.00', '1.00', 'Other', 'F', '002', NULL, NULL, 'CON', '', '003', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('002003007 ', 'Capital Cash Book', '1.00', '000001', '1.00', '100.00', 'L', NULL, '10.00', '1.00', 'Other', 'F', '002', NULL, NULL, 'CON', '', '003', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('002003008 ', 'Main Cash Book', '1.00', '000001', '1.00', '0.00', 'L', NULL, '10.00', '1.00', 'Other', 'F', '002', NULL, NULL, 'CON', '', '003', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('002003009 ', 'Cash Book,', '1.00', '000001', '1.00', '0.00', 'L', NULL, '0.00', '1.00', 'Other', 'F', '002', NULL, NULL, 'CON', '', '003', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('002003010 ', 'Exam Paying Register', '1.00', '000001', '1.00', '0.00', 'L', NULL, '0.00', '1.00', 'Other', 'F', '002', NULL, NULL, 'CON', '', '003', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('002005003 ', 'Pocket Note Books', '1.00', '000001', '1.00', '538.00', 'L', NULL, '10.00', '1.00', 'Other', 'F', '002', NULL, NULL, 'CON', '', '005', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('002006001 ', 'Good Receiving Note Book (Department)', '1.00', '000001', '1.00', '50.00', 'L', NULL, '10.00', '1.00', 'Other', 'F', '002', NULL, NULL, 'CON', '', '006', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('002006002 ', 'Stores Issue Order Note Book', '1.00', '000001', '1.00', '161.00', 'L', NULL, '10.00', '1.00', 'Other', 'F', '002', NULL, NULL, 'CON', '', '006', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('002006003 ', 'Stores Classification Books', '1.00', '000001', '1.00', '10.00', 'L', NULL, '10.00', '1.00', 'Other', 'F', '002', NULL, NULL, 'CON', '', '006', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('002006004 ', 'Inventry Books', '1.00', '000001', '1.00', '19.00', 'L', NULL, '10.00', '1.00', 'Other', 'F', '002', NULL, NULL, 'CON', '', '006', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('002006005 ', 'Goods Order Books - Works Department', '1.00', '000001', '1.00', '175.00', 'L', NULL, '10.00', '1.00', 'Other', 'F', '002', NULL, NULL, 'CON', '', '006', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('002006006 ', 'Stores Issue Order Note Book - Works', '1.00', '000001', '1.00', '0.00', 'L', NULL, '10.00', '1.00', 'Other', 'F', '002', NULL, NULL, 'CON', '', '006', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('002008001 ', 'Library Accession Register', '1.00', '000001', '1.00', '0.00', 'L', NULL, '10.00', '1.00', 'Other', 'F', '002', NULL, NULL, 'CON', '', '008', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('002008002 ', 'Degree Name Register', '1.00', '000001', '1.00', '0.00', 'L', NULL, '10.00', '1.00', 'Other', 'F', '002', NULL, NULL, 'CON', '', '008', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('002008003 ', 'Degree Name Register - 2nd Session', '1.00', '000001', '1.00', '0.00', 'L', NULL, '10.00', '1.00', 'Other', 'F', '002', NULL, NULL, 'CON', '', '008', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('002008004 ', 'Degree Name Register - 3rd Session', '1.00', '000001', '1.00', '0.00', 'L', NULL, '1.00', '1.00', 'Other', 'F', '002', NULL, NULL, 'CON', '', '008', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('002009002 ', 'Student Record Book', '1.00', '000001', '1.00', '0.00', 'L', NULL, '10.00', '1.00', 'Other', 'F', '002', NULL, NULL, 'CON', '', '009', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('002009003 ', 'Medical Record Books', '1.00', '000001', '1.00', '0.00', 'L', NULL, '10.00', '1.00', 'Other', 'F', '002', NULL, NULL, 'CON', '', '009', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('002009004 ', 'Training Record Book', '1.00', '000001', '1.00', '0.00', 'L', NULL, '10.00', '1.00', 'Other', 'F', '002', NULL, NULL, 'CON', '', '009', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('002009005 ', 'Internship Record Book', '1.00', '000001', '1.00', '0.00', 'L', NULL, '1.00', '1.00', 'Other', 'F', '002', NULL, NULL, 'CON', '', '009', 'uksj', NULL, '2015-04-27 17:39:02', NULL, '0000-00-00 00:00:00'),
('002009006 ', 'Third Year Finance Training Record Book', '1.00', '000001', '1.00', '0.00', 'L', NULL, '0.00', '1.00', 'Other', 'F', '002', NULL, NULL, 'CON', '', '009', 'uksl', NULL, '2015-08-31 10:37:48', 'admin', '2015-08-31 10:41:27'),
('003001001 ', 'Photocopiers', '1.00', '000003', '1.00', '0.00', 'L', NULL, '10.00', '1.00', 'Other', 'F', '003', NULL, NULL, 'CA', '06', '001', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('003001002 ', 'Digital Duplicating Machine', '1.00', '000003', '1.00', '0.00', 'L', NULL, '10.00', '1.00', 'Other', 'F', '003', NULL, NULL, 'CA', '06', '001', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('003001003 ', 'Binding Machine', '1.00', '000003', '1.00', '0.00', 'L', NULL, '10.00', '1.00', 'Other', 'F', '003', NULL, NULL, 'CA', '06', '001', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('003001004 ', 'Laminating Machine', '1.00', '000003', '1.00', '0.00', 'L', NULL, '10.00', '1.00', 'Other', 'F', '003', NULL, NULL, 'CA', '06', '001', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('003002001 ', 'Kettle Electric', '1.00', '000003', '1.00', '10.00', 'L', NULL, '10.00', '1.00', 'Other', 'F', '003', NULL, NULL, 'CA', '06', '002', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('003002002 ', 'Water Filter', '1.00', '000003', '1.00', '2.00', 'L', NULL, '10.00', '1.00', 'Other', 'F', '003', NULL, NULL, 'CA', '06', '002', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('003002003 ', 'Water Boiler', '1.00', '000003', '1.00', '7.00', 'L', NULL, '10.00', '1.00', 'Other', 'F', '003', NULL, NULL, 'CA', '06', '002', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('003002004 ', 'Refrigerator', '1.00', '000003', '1.00', '0.00', 'L', NULL, '10.00', '1.00', 'Other', 'F', '003', NULL, NULL, 'CA', '06', '002', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('003003001 ', 'Air Conditioner 9,000 BTU', '1.00', '000003', '1.00', '0.00', 'L', NULL, '10.00', '1.00', 'Other', 'F', '003', NULL, NULL, 'CA', '05', '003', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('003003002 ', 'Air Conditioner 12,000 BTU', '1.00', '000003', '1.00', '0.00', 'L', NULL, '10.00', '1.00', 'Other', 'F', '003', NULL, NULL, 'CA', '05', '003', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('003004001 ', 'Fire Extinguisher CO 2', '1.00', '000003', '1.00', '0.00', 'L', NULL, '10.00', '1.00', 'Other', 'F', '003', NULL, NULL, 'CA', '05', '004', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('003004002 ', 'Fire Extinguisher Water CO 2', '1.00', '000003', '1.00', '0.00', 'L', NULL, '10.00', '1.00', 'Other', 'F', '003', NULL, NULL, 'CA', '05', '004', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('003004003 ', 'Fire Extinguisher Foam', '1.00', '000003', '1.00', '0.00', 'L', NULL, '10.00', '1.00', 'Other', 'F', '003', NULL, NULL, 'CA', '05', '004', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('003010003 ', 'Telephone Roset Box', '1.00', '000003', '1.00', '0.00', 'L', NULL, '10.00', '1.00', 'Other', 'F', '003', NULL, NULL, 'RE_0607', '', '010', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('003010004 ', 'Telephone Hand Set Code', '1.00', '000003', '1.00', '50.00', 'L', NULL, '10.00', '1.00', 'Other', 'F', '003', NULL, NULL, 'RE_0607', '', '010', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('003010005 ', 'Telephone Roset Code', '1.00', '000003', '1.00', '0.00', 'L', NULL, '10.00', '1.00', 'Other', 'F', '003', NULL, NULL, 'RE_0607', '', '010', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('004001004 ', 'Conference Table (Wooden)', '1.00', '000003', '1.00', '0.00', 'L', NULL, '5.00', '1.00', 'Pkt', 'L', '004', NULL, NULL, 'CA', '02', '001', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('004003006 ', 'Fibre Glass Table', '1.00', '000003', '1.00', '0.00', 'L', NULL, '10.00', '1.00', 'Other', 'F', '004', NULL, NULL, 'CA', '02', '003', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('004004001 ', 'Arm Chairs (Wooden)', '1.00', '000003', '1.00', '0.00', 'L', NULL, '5.00', '1.00', 'Pkt', 'F', '004', NULL, NULL, 'CA', '02', '004', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('004004002 ', 'Varendah Chairs (Wooden)', '1.00', '000003', '1.00', '0.00', 'L', NULL, '5.00', '1.00', 'Pkt', 'L', '004', NULL, NULL, 'CA', '02', '004', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('004004004 ', 'Arm Chairs (Wooden Without )', '1.00', '000003', '1.00', '0.00', 'L', NULL, '5.00', '1.00', 'Pkt', 'L', '004', NULL, NULL, 'CA', '02', '004', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('004004005 ', 'Chairs for Conference Table (Wooden)', '1.00', '000003', '1.00', '0.00', 'L', NULL, '10.00', '1.00', 'Pkt', 'L', '004', NULL, NULL, 'CA', '02', '004', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('004004006 ', 'Lecture Hall Chairs', '1.00', '000003', '1.00', '1.00', 'L', NULL, '10.00', '1.00', 'Other', 'F', '004', NULL, NULL, 'CA', '02', '004', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('004004007 ', 'Clerical Chairs', '1.00', '000003', '1.00', '4.00', 'L', NULL, '10.00', '1.00', 'Other', 'F', '004', NULL, NULL, 'CA', '02', '004', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('004004008 ', 'Sofa', '1.00', '000003', '1.00', '0.00', 'L', NULL, '10.00', '1.00', 'Other', 'F', '004', NULL, NULL, 'CA', '02', '004', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('004004009 ', 'Chairs', '1.00', '000003', '1.00', '8.00', 'L', NULL, '10.00', '1.00', 'Other', 'F', '004', NULL, NULL, 'CA', '02', '004', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('004004010 ', 'Cushioned Chairs - Single Seater', '1.00', '000003', '1.00', '0.00', 'L', NULL, '10.00', '1.00', 'Other', 'F', '004', NULL, NULL, 'CA', '02', '004', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('004004011 ', 'Cushioned Chairs - Double Seater', '1.00', '000003', '1.00', '0.00', 'L', NULL, '10.00', '1.00', 'Other', 'F', '004', NULL, NULL, 'CA', '02', '004', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('004004012 ', 'Counter Chair', '1.00', '000003', '1.00', '0.00', 'L', NULL, '10.00', '1.00', 'Other', 'F', '004', NULL, NULL, 'CA', '02', '004', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('004004013 ', 'Podium Chair', '1.00', '000003', '1.00', '0.00', 'L', NULL, '10.00', '1.00', 'Other', 'F', '004', NULL, NULL, 'CA', '02', '004', 'admin_sup', 'admin_sup', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
('004004014 ', 'Lobby Chair', '1.00', '000003', '1.00', '0.00', 'L', NULL, '1.00', '1.00', 'Other', 'F', '004', NULL, NULL, 'CA', '', '004', 'uksj', NULL, '2014-08-19 08:55:44', NULL, '0000-00-00 00:00:00'),
('004004015 ', 'Desk and Chair Unit', '1.00', '000003', '1.00', '0.00', 'L', NULL, '1.00', '1.00', 'Other', 'F', '004', NULL, NULL, 'CA', '', '004', 'uksj', NULL, '2014-10-29 09:02:01', NULL, '0000-00-00 00:00:00'),
('004005001 ', 'Steel Dining Chair', '1.00', '000003', '1.00', '6.00', 'L', NULL, '1.00', '1.00', 'Other', 'F', '004', NULL, NULL, 'CA', '', '005', 'uksj', NULL, '2014-08-19 08:59:48', NULL, '0000-00-00 00:00:00'),
('005001001 ', 'HP 16"', '0.00', '', '0.00', '0.00', 'L', 5, '10.00', '0.00', NULL, NULL, '005', NULL, NULL, 'CON', '', '', 'admin', NULL, '2017-03-25 09:44:20', NULL, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `item_sub_category`
--

CREATE TABLE IF NOT EXISTS `item_sub_category` (
  `category_code` varchar(3) NOT NULL DEFAULT '',
  `product_sub_category_code` varchar(3) NOT NULL,
  `product_sub_category_des` varchar(100) NOT NULL,
  `user_add` varchar(30) DEFAULT NULL,
  `user_add_date` datetime NOT NULL,
  `user_mod` varchar(30) DEFAULT NULL,
  `user_mod_date` datetime DEFAULT NULL,
  PRIMARY KEY (`category_code`,`product_sub_category_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_sub_category`
--

INSERT INTO `item_sub_category` (`category_code`, `product_sub_category_code`, `product_sub_category_des`, `user_add`, `user_add_date`, `user_mod`, `user_mod_date`) VALUES
('001', '001', 'Letter Head', 'admin', '2017-03-23 15:13:27', NULL, NULL),
('001', '002', 'Vouchers', NULL, '2016-06-11 17:00:52', NULL, NULL),
('001', '003', 'Applications', NULL, '2016-06-11 17:00:52', NULL, NULL),
('001', '004', 'Identity Cards', NULL, '2016-06-11 17:00:52', NULL, NULL),
('001', '005', 'Certificates', NULL, '2016-06-11 17:00:52', NULL, NULL),
('001', '006', 'Printed Lables', NULL, '2016-06-11 17:00:52', NULL, NULL),
('001', '007', 'Printed Pads', NULL, '2016-06-11 17:00:52', NULL, NULL),
('001', '008', 'Printed Sheets', NULL, '2016-06-11 17:00:52', NULL, NULL),
('001', '009', 'Continue Sheets', NULL, '2016-06-11 17:00:52', NULL, NULL),
('001', '010', 'Printed Cards & Sheets Library', NULL, '2016-06-11 17:00:52', NULL, NULL),
('002', '001', 'Marks Entry Books', NULL, '2016-06-11 17:00:52', NULL, NULL),
('002', '002', 'Attendans Registers', NULL, '2016-06-11 17:00:52', NULL, NULL),
('002', '003', 'Printed Financial Books', NULL, '2016-06-11 17:00:52', NULL, NULL),
('002', '004', 'Hostal Registers & Books', NULL, '2016-06-11 17:00:52', NULL, NULL),
('002', '005', 'Security Printed Books', NULL, '2016-06-11 17:00:52', NULL, NULL),
('003', '001', 'Office Equipments', NULL, '2012-01-17 15:26:51', NULL, NULL),
('003', '002', 'House Hold Equipments', NULL, '2012-01-17 15:26:51', NULL, NULL),
('003', '003', 'Air Conditioners', NULL, '2012-01-17 15:26:51', NULL, NULL),
('003', '004', 'Fire Extinguishers', NULL, '2012-02-26 08:33:21', NULL, NULL),
('004', '001', 'Wooden Tables', NULL, '2016-06-11 17:00:52', NULL, NULL),
('004', '002', 'Steel Tables', NULL, '2016-06-11 17:00:52', NULL, NULL),
('004', '003', 'Fibre Glass Tables', NULL, '2012-01-14 08:37:36', NULL, NULL),
('004', '004', 'Wooden Chairs', NULL, '2016-06-11 17:00:52', NULL, NULL),
('004', '005', 'Steel Chairs', NULL, '2016-06-11 17:00:52', NULL, NULL),
('005', '001', 'Monitor', 'admin', '2017-03-25 09:39:41', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `item_type`
--

CREATE TABLE IF NOT EXISTS `item_type` (
  `item_type_code` varchar(10) NOT NULL,
  `item_type_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_type`
--

INSERT INTO `item_type` (`item_type_code`, `item_type_name`) VALUES
('FA', 'Fixed asset'),
('CON', 'Consumable');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE IF NOT EXISTS `location` (
  `location_code` varchar(6) NOT NULL,
  `location_name` varchar(50) NOT NULL,
  `loc_default` char(1) NOT NULL DEFAULT 'N',
  `store_type_code` varchar(6) DEFAULT NULL,
  `os_user` varchar(15) NOT NULL,
  `user_add_date` datetime NOT NULL,
  `mod_user` varchar(15) NOT NULL,
  `user_mod_date` datetime NOT NULL,
  PRIMARY KEY (`location_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_cancel`
--

CREATE TABLE IF NOT EXISTS `purchase_cancel` (
  `pic_num` int(11) NOT NULL,
  `pic_acct_yr` int(11) NOT NULL,
  `pic_date` datetime NOT NULL,
  `pic_remarks` char(100) NOT NULL,
  `pic_user_can` varchar(30) NOT NULL,
  PRIMARY KEY (`pic_num`,`pic_acct_yr`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `purch_ord_det`
--

CREATE TABLE IF NOT EXISTS `purch_ord_det` (
  `pod_po_no` int(11) NOT NULL,
  `pod_po_mark` char(1) NOT NULL DEFAULT 'U',
  `pod_trans_no` int(11) NOT NULL,
  `pod_item_code` char(10) NOT NULL,
  `pod_des` varchar(300) NOT NULL,
  `pod_qty` decimal(12,2) DEFAULT NULL,
  `pod_unit_price` decimal(12,2) DEFAULT NULL,
  `pod_warranty` int(2) DEFAULT NULL,
  `pod_acct_yr` int(11) NOT NULL,
  `pod_local_amount` decimal(12,2) DEFAULT NULL,
  `pod_nbt` decimal(12,2) NOT NULL DEFAULT '0.00',
  `pod_vat` decimal(12,2) NOT NULL DEFAULT '0.00',
  `pod_other` decimal(12,2) NOT NULL DEFAULT '0.00',
  `pod_amount` decimal(12,2) DEFAULT NULL,
  `pod_model_code` varchar(25) DEFAULT NULL,
  `pod_remarks` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`pod_po_no`,`pod_po_mark`,`pod_trans_no`,`pod_acct_yr`),
  KEY `idx_pod_no_yr_item` (`pod_po_no`,`pod_acct_yr`,`pod_item_code`),
  KEY `pod_po_no` (`pod_po_no`,`pod_item_code`,`pod_acct_yr`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `purch_ord_mas`
--

CREATE TABLE IF NOT EXISTS `purch_ord_mas` (
  `pom_po_no` int(11) NOT NULL,
  `pom_date` date DEFAULT NULL,
  `pom_sup_code` char(10) NOT NULL,
  `pom_sup_year` int(4) NOT NULL,
  `pom_remark` char(100) DEFAULT NULL,
  `pom_acct_yr` int(11) NOT NULL,
  `pom_uni_reference` varchar(30) DEFAULT NULL,
  `pom_reference` char(15) DEFAULT NULL,
  `pom_cancel` char(1) NOT NULL,
  `pom_grn_raised` char(1) DEFAULT 'N',
  `dep_code` varchar(9) DEFAULT NULL,
  `sec_code` varchar(9) DEFAULT NULL,
  `user_add` varchar(30) DEFAULT NULL,
  `user_add_date` datetime DEFAULT NULL,
  `user_mod` varchar(30) DEFAULT NULL,
  `user_mod_date` datetime DEFAULT NULL,
  `item_type_code` varchar(10) DEFAULT NULL,
  `item_val` decimal(12,2) NOT NULL,
  `fund_code` varchar(8) NOT NULL,
  `fund_amount` decimal(12,2) NOT NULL,
  `fund_fac` varchar(9) NOT NULL,
  `fund_dept` varchar(9) NOT NULL,
  `warranty_yr` int(2) DEFAULT NULL,
  `fund_avail` char(1) NOT NULL,
  `po_approved` char(1) NOT NULL,
  `user_approved` varchar(30) NOT NULL,
  `date_approved` datetime NOT NULL,
  `val_approved` decimal(12,2) NOT NULL,
  `pom_due_date` date DEFAULT NULL,
  PRIMARY KEY (`pom_po_no`,`pom_acct_yr`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE IF NOT EXISTS `supplier` (
  `supplier_code` varchar(5) NOT NULL,
  `supplier_name` varchar(100) NOT NULL,
  `sup_year` int(4) NOT NULL,
  `supplier_contact` varchar(25) DEFAULT NULL,
  `supplier_address1` varchar(300) NOT NULL,
  `supplier_address2` varchar(100) DEFAULT NULL,
  `supplier_address3` varchar(50) DEFAULT NULL,
  `supplier_phone` varchar(15) DEFAULT NULL,
  `supplier_fax` varchar(60) DEFAULT NULL,
  `supplier_vat_no` varchar(20) DEFAULT NULL,
  `supplier_email` varchar(30) DEFAULT NULL,
  `sup_foreign_local` varchar(1) DEFAULT NULL,
  `sup_address4` varchar(50) DEFAULT NULL,
  `supplier_phone2` varchar(60) DEFAULT NULL,
  `supplier_phone3` varchar(15) DEFAULT NULL,
  `supplier_phone4` varchar(15) DEFAULT NULL,
  `branch_code` varchar(15) DEFAULT NULL,
  `registered_status` varchar(3) DEFAULT 'RES',
  `effective_date_from` date DEFAULT '2016-01-01',
  `effective_date_to` date DEFAULT '2016-12-31',
  `sup_cat_code` int(10) NOT NULL,
  `sup_refno` varchar(11) DEFAULT NULL,
  `sup_user_add` varchar(30) DEFAULT NULL,
  `sup_add_date` datetime DEFAULT NULL,
  `sup_url` varchar(200) DEFAULT NULL,
  `sup_payment` int(5) NOT NULL,
  `sup_brno` varchar(25) DEFAULT NULL,
  `sup_ictrg` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`supplier_code`,`sup_cat_code`,`sup_year`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`supplier_code`, `supplier_name`, `sup_year`, `supplier_contact`, `supplier_address1`, `supplier_address2`, `supplier_address3`, `supplier_phone`, `supplier_fax`, `supplier_vat_no`, `supplier_email`, `sup_foreign_local`, `sup_address4`, `supplier_phone2`, `supplier_phone3`, `supplier_phone4`, `branch_code`, `registered_status`, `effective_date_from`, `effective_date_to`, `sup_cat_code`, `sup_refno`, `sup_user_add`, `sup_add_date`, `sup_url`, `sup_payment`, `sup_brno`, `sup_ictrg`) VALUES
('0001', 'Advanced Micro Technology (Pvt) Ltd', 2017, NULL, 'No:563/17, Sarasavi Mawatha, Nawala Road,', 'Rajagiriya.', 'Sri Lanka', '0112864225', '0112883735', '114255084-7000', 'amt@slt.lk', 'L', NULL, '0114400041', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 11, '00001', '', '2017-01-01 00:00:00', 'www.amtsl.com', 600, 'PV-10779', 'EM-0119'),
('0001', 'Advanced Micro Technology (Pvt) Ltd', 2017, NULL, 'No:563/17, Sarasavi Mawatha, Nawala Road,', 'Rajagiriya.', 'Sri Lanka', '0112864225', '0112883735', '114255084-7000', 'amt@slt.lk', 'L', NULL, '0114400041', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 12, '00001', '', '2017-01-01 00:00:00', 'www.amtsl.com', 600, 'PV-10779', 'EM-0119'),
('0001', 'Advanced Micro Technology (Pvt) Ltd', 2017, NULL, 'No:563/17, Sarasavi Mawatha, Nawala Road,', 'Rajagiriya.', 'Sri Lanka', '0112864225', '0112883735', '114255084-7000', 'amt@slt.lk', 'L', NULL, '0114400041', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 13, '00001', '', '2017-01-01 00:00:00', 'www.amtsl.com', 600, 'PV-10779', 'EM-0119'),
('0002', 'Lallans Sports Goods Manufacturers (Pvt) Ltd', 2017, NULL, 'Colombo Road, Malangama, Hidellana,', 'Ratnapura', 'Sri Lanka', '0452228613', '0452228755', '114218855 7000', 'lallansperera@hotmail.com', 'L', NULL, '0452228962', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 5, '00002', '', '2017-01-01 00:00:00', '', 400, 'PV 6112', ''),
('0003', 'GBS Systems', 2017, NULL, '449/95,Orangebill estate,Ihala Biyanwila,', 'Kadawatha 11850,', 'Sri Lanka', '0770645494', '0112923943', 'No', 'contactgbssystems@gmail.com', 'L', NULL, '+94770645494', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 9, '00003', '', '2017-01-01 00:00:00', 'No', 400, 'WP12688', 'Not Applicable'),
('0003', 'GBS Systems', 2017, NULL, '449/95,Orangebill estate,Ihala Biyanwila,', 'Kadawatha 11850,', 'Sri Lanka', '0770645494', '0112923943', 'No', 'contactgbssystems@gmail.com', 'L', NULL, '+94770645494', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 10, '00003', '', '2017-01-01 00:00:00', 'No', 400, 'WP12688', 'Not Applicable'),
('0003', 'GBS Systems', 2017, NULL, '449/95,Orangebill estate,Ihala Biyanwila,', 'Kadawatha 11850,', 'Sri Lanka', '0770645494', '0112923943', 'No', 'contactgbssystems@gmail.com', 'L', NULL, '+94770645494', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 11, '00003', '', '2017-01-01 00:00:00', 'No', 400, 'WP12688', 'Not Applicable'),
('0004', 'Genius Associates(PVT)Ltd', 2017, NULL, 'No 47 Jambugasmulla Road', 'Nugegoda', 'Sri Lanka', '0115522266', '0112823590', '114210935-7000', 'genius@sltnet.lk', 'L', NULL, '0115522266', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 12, '00004', '', '2017-01-01 00:00:00', 'www.geniuslanka.com', 400, 'PV17182', 'N/A'),
('0005', 'S.G.K Enterprise', 2017, NULL, '712/4 Mankada Road,', 'Kadawatha', 'Sri Lanka', '0715177310', '0112929403', '891021070-7000', 'shamith1991@gmail.com', 'L', NULL, '0112929403', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 1, '00005', '', '2017-01-01 00:00:00', 'http://sgkenterprises.meximas.com/', 1100, 'wp 6813', ''),
('0005', 'S.G.K Enterprise', 2017, NULL, '712/4 Mankada Road,', 'Kadawatha', 'Sri Lanka', '0715177310', '0112929403', '891021070-7000', 'shamith1991@gmail.com', 'L', NULL, '0112929403', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 3, '00005', '', '2017-01-01 00:00:00', 'http://sgkenterprises.meximas.com/', 1100, 'wp 6813', ''),
('0005', 'S.G.K Enterprise', 2017, NULL, '712/4 Mankada Road,', 'Kadawatha', 'Sri Lanka', '0715177310', '0112929403', '891021070-7000', 'shamith1991@gmail.com', 'L', NULL, '0112929403', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 4, '00005', '', '2017-01-01 00:00:00', 'http://sgkenterprises.meximas.com/', 1100, 'wp 6813', ''),
('0005', 'S.G.K Enterprise', 2017, NULL, '712/4 Mankada Road,', 'Kadawatha', 'Sri Lanka', '0715177310', '0112929403', '891021070-7000', 'shamith1991@gmail.com', 'L', NULL, '0112929403', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 8, '00005', '', '2017-01-01 00:00:00', 'http://sgkenterprises.meximas.com/', 1100, 'wp 6813', ''),
('0006', 'JOHN KEELLS OFFICE AUTOMATION PVT LTD.', 2017, NULL, 'NO. 90, UNION PLACE', 'COLOMBO 02.', 'Sri Lanka', '0112313000', '0112431745', '114096962.7000', 'jkoa@keells.com', 'L', NULL, '0112445760', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 6, '00006', '', '2017-01-01 00:00:00', 'www.keells.com', 700, 'PV127', '-'),
('0006', 'JOHN KEELLS OFFICE AUTOMATION PVT LTD.', 2017, NULL, 'NO. 90, UNION PLACE', 'COLOMBO 02.', 'Sri Lanka', '0112313000', '0112431745', '114096962.7000', 'jkoa@keells.com', 'L', NULL, '0112445760', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 11, '00006', '', '2017-01-01 00:00:00', 'www.keells.com', 700, 'PV127', '-'),
('0007', 'Jayantha Traders', 2017, NULL, 'No.627,Sirimavo Bandaranayake Mawatha', 'Colombo 14', 'Sri Lanka', '0112431334', '0112396441', '409034438-7000', 'jayanth2@sltnet.lk', 'L', NULL, '0112338733', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 1, '00007', '', '2017-01-01 00:00:00', '', 400, 'w/15591', ''),
('0007', 'Jayantha Traders', 2017, NULL, 'No.627,Sirimavo Bandaranayake Mawatha', 'Colombo 14', 'Sri Lanka', '0112431334', '0112396441', '409034438-7000', 'jayanth2@sltnet.lk', 'L', NULL, '0112338733', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 2, '00007', '', '2017-01-01 00:00:00', '', 400, 'w/15591', ''),
('0007', 'Jayantha Traders', 2017, NULL, 'No.627,Sirimavo Bandaranayake Mawatha', 'Colombo 14', 'Sri Lanka', '0112431334', '0112396441', '409034438-7000', 'jayanth2@sltnet.lk', 'L', NULL, '0112338733', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 7, '00007', '', '2017-01-01 00:00:00', '', 400, 'w/15591', ''),
('0008', 'Sumudu Enterprises', 2017, NULL, 'No. 197, Koralawella,', 'Moratuwa.', 'Sri Lanka', '0112657013', '0112659199', '409184065-7000', 'sumuduent@sltnet.lk', 'L', NULL, '', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 3, '00008', '', '2017-01-01 00:00:00', '', 400, 'W/H/1376', ''),
('0008', 'Sumudu Enterprises', 2017, NULL, 'No. 197, Koralawella,', 'Moratuwa.', 'Sri Lanka', '0112657013', '0112659199', '409184065-7000', 'sumuduent@sltnet.lk', 'L', NULL, '', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 5, '00008', '', '2017-01-01 00:00:00', '', 400, 'W/H/1376', ''),
('0009', 'Carlton Lanka Pvt Ltd', 2017, NULL, 'No.435/1/22, Maradana Road', 'Colombo -10', 'Sri Lanka', '0117632290', '0117632291', '174865485-2525', 'carltonlankalab@mail.com', 'L', NULL, '', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 9, '00009', '', '2017-01-01 00:00:00', 'www.carltonlanka.com', 400, 'PV86548', ''),
('0010', 'Tyre House Trading Pvt Ltd,No- 221/4/1 Sri Sangaraja Mawatha,Colombo-10', 2017, NULL, 'Sri Sangaraja Mawatha', 'Colombo-10', 'Sri Lanka', '0115445400', '0112441693', '114195383-7000', 'chami_nawa@yahoo.co.uk', 'L', NULL, '', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 7, '00010', '', '2017-01-01 00:00:00', '', 400, 'N(PVS)19538', ''),
('0011', 'ELECTRO CHEMICAL', 2017, NULL, 'NO:456, KANDY ROAD,', 'PELIYAGODA', 'Sri Lanka', '0114544393', '0112-914100', '761300989-7000', 'electrochemical@yuconlanka.com', 'L', NULL, '', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 7, '00011', '', '2017-01-01 00:00:00', '', 400, 'W/A 46222', 'N/A'),
('0012', 'Nova Biomedical Systems (Pvt) Ltd', 2017, NULL, 'NO. 205, Castle Street,', 'Colombo 08', 'Sri Lanka', '0112699974', '011- 2691490', '114485268-7000', 'novamedisys@gmail.com', 'L', NULL, '', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 9, '00012', '', '2017-01-01 00:00:00', '', 400, 'N(PVS)48526', '-'),
('0013', 'EWIS Peripherals(Pvt) Ltd', 2017, NULL, 'No. 142, Yathama Building, Galle Road', 'Colombo 03', 'Sri Lanka', '0117496000', '0112380580', '114240214  7000', 'peripherals@ewisl.net', 'L', NULL, 'Not Applicable', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 6, '00013', '', '2017-01-01 00:00:00', 'www.ewisl.net', 400, 'PV10130', 'Not Applicable'),
('0013', 'EWIS Peripherals(Pvt) Ltd', 2017, NULL, 'No. 142, Yathama Building, Galle Road', 'Colombo 03', 'Sri Lanka', '0117496000', '0112380580', '114240214  7000', 'peripherals@ewisl.net', 'L', NULL, 'Not Applicable', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 11, '00013', '', '2017-01-01 00:00:00', 'www.ewisl.net', 400, 'PV10130', 'Not Applicable'),
('0015', 'Techno Instruments (Pvt) ltd', 2017, NULL, '485, Havelock Road', 'Colombo 00600', 'Sri Lanka', '0112366896', '0112366899', '114406856-7000', 'techins_1@sltnet.lk', 'L', NULL, '0112366897', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 9, '00015', '', '2017-01-01 00:00:00', 'www.technoinstruments.com', 400, 'PV 4659', 'N/A'),
('0017', 'isiwari enterprises', 2017, NULL, 'no/506/01/01 kuruduwatta rd watabagaya Hirana, Panadura', 'Panadura', 'Sri Lanka', '0773320184', '0382245858', NULL, 'isiwari.sh@gmail.com', 'L', NULL, '', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 3, '00017', '', '2017-01-01 00:00:00', '', 400, 'BB6287', ''),
('0019', 'Neo Graphic Solutions (Pvt) Ltd', 2017, NULL, 'No;16A, Gamunu Mawatha,', 'Kiribathgoda', 'Sri Lanka', '0112909714', '0112909288', '114723070-7000', 'neoreshan@yahoo.com', 'L', NULL, '', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 2, '00019', '', '2017-01-01 00:00:00', '', 400, 'PV72307', ''),
('0021', 'OREL CORPORATION (PVT) LTD', 2017, NULL, 'BLOCK 12 & 13, TRACE EXPERT CITY, TRIPOLI MARKET, MARADANA ROAD,', 'COLOMBO 10', 'Sri Lanka', '0114791105', '0114792128 ', '114721255-7000', 'ranga@orelcorp.com', 'L', NULL, '0114792138', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 9, '00021', '', '2017-01-01 00:00:00', 'www.orelcorporation.com', 500, 'PV 72125', ''),
('0021', 'OREL CORPORATION (PVT) LTD', 2017, NULL, 'BLOCK 12 & 13, TRACE EXPERT CITY, TRIPOLI MARKET, MARADANA ROAD,', 'COLOMBO 10', 'Sri Lanka', '0114791105', '0114792128 ', '114721255-7000', 'ranga@orelcorp.com', 'L', NULL, '0114792138', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 12, '00021', '', '2017-01-01 00:00:00', 'www.orelcorporation.com', 500, 'PV 72125', ''),
('0022', 'Jinasena Innovation And Technology Institute (Pvt) Limited', 2017, NULL, '25A, Industrial Estate, Ekala', 'Ja Ela', 'Sri Lanka', '0112248681', '0112248615', '114124214 ? 7000', 'ashoka@tissajinasenagroup.com', 'L', NULL, '', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 9, '00022', '', '2017-01-01 00:00:00', 'www.tissajinasenagroup.com', 400, 'PV 7059', 'N.A'),
('0023', 'AV SYSTEMS (PRIVATE) LIMITED', 2017, NULL, '13A, ORUTHOTA', 'GAMPAHA', 'Sri Lanka', '0332233522', '033 2234081', '114744166-70000', 'info@avs.lk ', 'L', NULL, '', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 11, '00023', '', '2017-01-01 00:00:00', '', 400, 'P V 74416', 'NOT APPLICABLE'),
('0023', 'AV SYSTEMS (PRIVATE) LIMITED', 2017, NULL, '13A, ORUTHOTA', 'GAMPAHA', 'Sri Lanka', '0332233522', '033 2234081', '114744166-70000', 'info@avs.lk ', 'L', NULL, '', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 12, '00023', '', '2017-01-01 00:00:00', '', 400, 'P V 74416', 'NOT APPLICABLE'),
('0024', 'Accell technology holding pvt ltd', 2017, NULL, 'no 28 mews street colombo 02', 'colombo', 'Sri Lanka', '0112439311', '0112439322', '174058997-7000', 'sales@accelltecsl.com', 'L', NULL, '', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 13, '00024', '', '2017-01-01 00:00:00', '', 400, 'pv 105899', ''),
('0027', 'SEALINE TRADING COMPANY', 2017, NULL, '53, MALIBAN STREET', 'COLOMBO', 'Sri Lanka', '0112348559', '0114641897', 'NON-VAT', 'sealine@sltnet.lk', 'L', NULL, '', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 1, '00027', '', '2017-01-01 00:00:00', '', 400, 'W-666', 'N/A'),
('0029', 'VET WORLD (PVT) LIMITED', 2017, NULL, 'NO 15/A, EBENEZER PLACE', 'DEHIWALA', 'Sri Lanka', '0112717359', '0112716359', '114501832-7000', 'vetworld@sltnet.lk', 'L', NULL, '', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 9, '00029', '', '2017-01-01 00:00:00', '', 400, 'PV1113', ''),
('0029', 'VET WORLD (PVT) LIMITED', 2017, NULL, 'NO 15/A, EBENEZER PLACE', 'DEHIWALA', 'Sri Lanka', '0112717359', '0112716359', '114501832-7000', 'vetworld@sltnet.lk', 'L', NULL, '', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 10, '00029', '', '2017-01-01 00:00:00', '', 400, 'PV1113', ''),
('0030', 'Denme Medicals (Pvt) Ltd', 2017, NULL, '205, Castle Street', 'Colombo 08', 'Sri Lanka', '0112676999', '0112691490', '114649708-7000', 'denmemediclas@sltnet.lk ', 'L', NULL, '0112676996', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 9, '00030', '', '2017-01-01 00:00:00', 'www.denmemedicals.com ', 400, 'PV 64970', ''),
('0031', 'INTEGRATED COMMUNICATION SYSTEMS (PVT) LTD', 2017, NULL, '39 2/2, ALFRED PLACE, COLOMBO-03', 'COLOMBO', 'Sri Lanka', '0112500080', '0112-501259', '114132900-7000', 'fd@icslk.com', 'L', NULL, '', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 9, '00031', '', '2017-01-01 00:00:00', 'www.icslk.com', 400, 'PV 20900', 'NOT APPLICABLE'),
('0033', 'Emar Pharma (PVT) Ltd', 2017, NULL, 'No.23 Anderson Road, Kalubowila', 'Dehiwala', 'Sri Lanka', '0112810913', '0112768475', '114 039950 7000', 'info@emarpharma.com', 'L', NULL, '0112810914', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 9, '00033', '', '2017-01-01 00:00:00', '', 400, 'PV 17984', ''),
('0033', 'Emar Pharma (PVT) Ltd', 2017, NULL, 'No.23 Anderson Road, Kalubowila', 'Dehiwala', 'Sri Lanka', '0112810913', '0112768475', '114 039950 7000', 'info@emarpharma.com', 'L', NULL, '0112810914', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 10, '00033', '', '2017-01-01 00:00:00', '', 400, 'PV 17984', ''),
('0034', 'Energynet (Pvt) Limited', 2017, NULL, 'No 180/1, Deans Road, Colombo -10', 'Colombo', 'Sri Lanka', '0115334477', '0115349313', '114016810-7000', 'marketing1@energynetlk.com', 'L', NULL, '0114336677', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 6, '00034', '', '2017-01-01 00:00:00', '', 400, 'PV 6443', 'N/A'),
('0035', 'Islandwide Scientific (Pvt) Ltd.', 2017, NULL, '19A, Fairfield Graden', 'Colombo 8', 'Sri Lanka', '0112681147', '0112696663', '114346349 7000', 'islnwide@sltnet.lk', 'L', NULL, '', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 9, '00035', '', '2017-01-01 00:00:00', 'Under construction', 400, 'PV16161 of 01/10/200', 'N/A'),
('0036', 'MAT International (Pvt)Ltd', 2017, NULL, '45/A, Stork Place , Vipulasena Mawatha', 'Colombo-10', 'Sri Lanka', '0112697294', '0112697294', 'N/A', 'mat.perera@gmail.com', 'L', NULL, '0094773170955', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 1, '00036', '', '2017-01-01 00:00:00', 'www.mat-intl.com', 400, 'PV86666', 'N/A'),
('0036', 'MAT International (Pvt)Ltd', 2017, NULL, '45/A, Stork Place , Vipulasena Mawatha', 'Colombo-10', 'Sri Lanka', '0112697294', '0112697294', 'N/A', 'mat.perera@gmail.com', 'L', NULL, '0094773170955', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 11, '00036', '', '2017-01-01 00:00:00', 'www.mat-intl.com', 400, 'PV86666', 'N/A'),
('0037', 'Springfields (Pvt) limited', 2017, NULL, 'No 90, Sir chittampalam A Gardiner Mawatha', 'Colombo 02', 'Sri Lanka', '0115332151', '0115332152', '104058981-7000', 'info@springfields.lk', 'L', NULL, '', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 11, '00037', '', '2017-01-01 00:00:00', '', 400, 'PV 10569', '-'),
('0038', 'PURE TECH SOLUTIONS', 2017, NULL, 'No.236/15,Wijekumarathunga Mawatha', 'KIRULAPONA', 'Sri Lanka', '0114349693', '0112513040', NULL, 'pts@sltnet.lk', 'L', NULL, '0715817676', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 6, '00038', '', '2017-01-01 00:00:00', '', 400, 'WP10550', ''),
('0040', 'Terms Healthcare (Pvt) Ltd', 2017, NULL, '189, Dr. N. M. Perera Mawatha', 'Colombo -08', 'Sri Lanka', '0117641642', '0117641643', 'Not Applicable ', 'wasantha@termss.com', 'L', NULL, '', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 9, '00040', '', '2017-01-01 00:00:00', 'www.termss.com', 400, 'PV 92599 ', 'Not Applicable '),
('0041', 'Scientific Instruments (Pvt) Ltd', 2017, NULL, 'No 1/2 , Aberathna Mawatha , Boralesgamuwa', 'Boralesgamuwa', 'Sri Lanka', '0112545494', '0112545494', '114819344-7000', 'logistics@scientificinstrument', 'L', NULL, '0112518181', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 9, '00041', '', '2017-01-01 00:00:00', '', 400, 'PV 81934', 'N/A'),
('0042', 'CRAFT LANKA ENGINEERS (PVT) LTD', 2017, NULL, 'NO. 2A, SARASAVI UDYANAYA, NAWALA ROAD', 'NUGEGODA', 'Sri Lanka', '0114874420', '0112811334', '114117285 7000', 'cle@sltnet.lk', 'L', NULL, '', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 15, '00042', '', '2017-01-01 00:00:00', 'www.craftlankaeng.com', 400, 'PV 8792', 'EM - 0138 GRADE:EM-3'),
('0043', 'Photo Technica (Pvt) Ltd', 2017, NULL, '288, Galle Road', 'Colombo 3', 'Sri Lanka', '0117223332', '2577094', '114065250-7000', 'delanerolle@phototechnicasl.co', 'L', NULL, '', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 11, '00043', '', '2017-01-01 00:00:00', '', 400, 'PV1151', 'Not Applicable'),
('0046', 'TMI Solutions Private Limited', 2017, NULL, 'No: 20-1/1, Robert Gunawardena Mawatha, Kirulapone, Colombo - 06', 'kirulapone', 'Sri Lanka', '0114322000', '0115359217', 'VAT not registered ', 'info@tmisolutions.lk', 'L', NULL, '', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 9, '00046', '', '2017-01-01 00:00:00', 'www.tmisolutions.lk', 400, 'PV 71314', ''),
('0047', 'Jeiotech Lab Equipment Company', 2017, NULL, '78/2, Galawila Road, Malapalla, Kottawa,', 'Pannipitiya.', 'Sri Lanka', '0113183609', '0112854455', 'Not Applicable.', 'jeiotech@yahoo.com', 'L', NULL, '', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 9, '00047', '', '2017-01-01 00:00:00', '', 400, 'WC11372', 'Not Applicable.'),
('0048', 'Fakhri Trading Company', 2017, NULL, 'No: 252, Dam Street, Colombo -12.', 'Colombo', 'Sri Lanka', '0112320644', '0112470644', '662151050-7000', 'fakhritrading@gmail.com', 'L', NULL, '0112344741', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 1, '00048', '', '2017-01-01 00:00:00', '', 400, 'W 4335', 'N/A'),
('0051', 'Medico Ceylon', 2017, NULL, '16, Maya Mawatha, Pathiragoda,', 'Maharagama', 'Sri Lanka', '0112837419', '0112837343', NULL, 'medicoceylon@gmail.com', 'L', NULL, '', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 9, '00051', '', '2017-01-01 00:00:00', '', 400, 'WC 6767', ''),
('0054', 'Sun Super Enterprises', 2017, NULL, '262/A/2/2 ,Hokandara Road,', 'Thalawathugoda.', 'Sri Lanka', '0112796607', '0112796607', 'Not Applicable', 'sunsuperfurniture@gmail.com', 'L', NULL, '0772334284', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 3, '00054', '', '2017-01-01 00:00:00', '', 400, 'WC- 1734', '-'),
('0054', 'Sun Super Enterprises', 2017, NULL, '262/A/2/2 ,Hokandara Road,', 'Thalawathugoda.', 'Sri Lanka', '0112796607', '0112796607', 'Not Applicable', 'sunsuperfurniture@gmail.com', 'L', NULL, '0772334284', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 14, '00054', '', '2017-01-01 00:00:00', '', 400, 'WC- 1734', '-'),
('0056', 'Jeotech Lab Equipment Company', 2017, NULL, '78/2, Galawila Road, Malapalla, Kottawa,', 'Pannipitiya.', 'Sri Lanka', '0113183609', '0112854455', 'Not Applicable.', 'jeiotech@yahoo.com', 'L', NULL, '', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 9, '00056', '', '2017-01-01 00:00:00', '', 400, 'WC11372', 'Not Applicable.'),
('0058', 'Agaram Industries', 2017, NULL, 'No:73 Nelson Road Aminjikarai', 'Chennai', 'India', '9884429647', '91-044-23741529', '33691460047', 'bharathwaj@agaramindia.com', 'F', '600029', '91-044-23741413', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 9, '00058', '', '2017-01-01 00:00:00', 'www.agaramindia.com', 400, '1780', ''),
('0058', 'Agaram Industries', 2017, NULL, 'No:73 Nelson Road Aminjikarai', 'Chennai', 'India', '9884429647', '91-044-23741529', '33691460047', 'bharathwaj@agaramindia.com', 'F', '600029', '91-044-23741413', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 10, '00058', '', '2017-01-01 00:00:00', 'www.agaramindia.com', 400, '1780', ''),
('0061', 'INTER TRADE (PVT) LTD', 2017, NULL, 'No. 18,  5th LANE', 'RATMALANA', 'Sri Lanka', '0114519535', '0114513363', '114116980-7000', 'intertrade@sltnet.lk', 'L', NULL, '', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 3, '00061', '', '2017-01-01 00:00:00', '', 400, 'PV 8110', ''),
('0061', 'INTER TRADE (PVT) LTD', 2017, NULL, 'No. 18,  5th LANE', 'RATMALANA', 'Sri Lanka', '0114519535', '0114513363', '114116980-7000', 'intertrade@sltnet.lk', 'L', NULL, '', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 4, '00061', '', '2017-01-01 00:00:00', '', 400, 'PV 8110', ''),
('0061', 'INTER TRADE (PVT) LTD', 2017, NULL, 'No. 18,  5th LANE', 'RATMALANA', 'Sri Lanka', '0114519535', '0114513363', '114116980-7000', 'intertrade@sltnet.lk', 'L', NULL, '', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 5, '00061', '', '2017-01-01 00:00:00', '', 400, 'PV 8110', ''),
('0062', 'DSL Enterprises(PVT)LTD', 2017, NULL, 'No 147/7,Angulana Station Road, Moratuwa.', 'Moratuwa', 'Sri Lanka', '0114963069', '0112612584', '114681598-7000', 'mahesh@dsltrading.com', 'L', NULL, '', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 1, '00064', '', '2017-01-01 00:00:00', '', 400, 'PV 68159', ''),
('0068', 'IMS Holdings(PVT)Ltd.', 2017, NULL, 'No.620, Kotte Road', 'Rajagiriya', 'Sri Lanka', '0115554400', '0112888727', '114264938-7000', 'medical@imsholdings.com', 'L', NULL, '', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 9, '00068', '', '2017-01-01 00:00:00', 'www.imsholdings.com', 400, 'PV5235', 'N/A'),
('0073', 'Quolikem International (Pvt) Ltd', 2017, NULL, '136/4, High Level Road, Kirulapone,', 'Colombo 06.', 'Sri Lanka', '0115782722', '0112-798844', '114689890-7000', 'quolikem.sl@gmail.com', 'L', NULL, '0094777737772', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 9, '00073', '', '2017-01-01 00:00:00', '', 400, 'PV68989', 'N/A'),
('0074', 'Ogaki & Company', 2017, NULL, 'No.624/B1, Dewa Sumithrarama Mw., Eriyawetiya,', 'Kelaniya', 'Sri Lanka', '0092915935', '2986935', '663340395-2525', 'ogaki@sltnet.lk', 'L', NULL, '0777222345', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 9, '00074', '', '2017-01-01 00:00:00', 'www.ogaki.co', 400, 'WS9946', 'N/A'),
('0075', 'Softlogic Retail(Pvt)Ltd', 2017, NULL, '"Panasonic" Building,Level 3,NO.402,Galle Road', 'Colombo 03', '', '0112903254', '', '114689892-7000', '', '', NULL, '', NULL, NULL, NULL, 'RES', '2016-01-01', '2016-12-31', 4, '00075', '', '2017-03-25 09:51:03', NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `supplier_category`
--

CREATE TABLE IF NOT EXISTS `supplier_category` (
  `sup_cat_code` varchar(6) NOT NULL,
  `sup_cat_name` varchar(200) NOT NULL,
  `user_add` varchar(30) DEFAULT NULL,
  `user_add_date` datetime DEFAULT NULL,
  `user_mod` varchar(30) DEFAULT NULL,
  `user_mod_date` datetime DEFAULT NULL,
  `com_code` varchar(6) DEFAULT NULL,
  `country_code` varchar(6) DEFAULT NULL,
  `branch_code` varchar(6) DEFAULT NULL,
  `dep_code` varchar(6) DEFAULT NULL,
  `sec_code` varchar(6) DEFAULT NULL,
  `reference_code` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`sup_cat_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier_category`
--

INSERT INTO `supplier_category` (`sup_cat_code`, `sup_cat_name`, `user_add`, `user_add_date`, `user_mod`, `user_mod_date`, `com_code`, `country_code`, `branch_code`, `dep_code`, `sec_code`, `reference_code`) VALUES
('000001', 'Stationary', 'admin', '2011-11-25 09:07:37', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('000002', 'Computer Stationary and Consumables (CDs, Ribbon & Toners)', 'admin', '2011-11-25 09:10:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('000003', 'Photocopying Papers and Computer Papers', 'admin', '2011-11-25 09:14:25', 'admin', '2017-03-18 08:58:05', NULL, NULL, NULL, NULL, NULL, NULL),
('000004', 'Computers, Servers, Printers, UPS, Scanners & Network Accessories', 'admin', '2011-11-25 09:14:25', 'admin', '2017-03-18 08:58:05', NULL, NULL, NULL, NULL, NULL, NULL),
('000005', 'Office Furniture (Steel & Wooden) (Tables, Chairs, Filling Cabinets, Steel Cabinets, Lecture Room Furniture, Racks etc.)', 'admin', '2011-11-25 09:14:25', 'admin', '2017-03-18 08:58:05', NULL, NULL, NULL, NULL, NULL, NULL),
('000006', 'Electrical Items (Bulbs, Wires, Switches etc...)', 'admin', '2011-11-25 09:28:47', 'admin', '2017-03-18 08:58:05', NULL, NULL, NULL, NULL, NULL, NULL),
('000007', 'Janitorial Items', 'admin', '2011-11-25 09:28:47', 'admin', '2017-03-18 08:58:05', NULL, NULL, NULL, NULL, NULL, NULL),
('000008', 'Air Conditioners and Spare Parts', 'admin', '2011-11-25 09:28:47', 'admin', '2017-03-18 08:58:05', NULL, NULL, NULL, NULL, NULL, NULL),
('000009', 'Books, Periodicals and Other Publications', 'admin', '2011-11-25 09:28:47', 'admin', '2017-03-18 08:58:05', NULL, NULL, NULL, NULL, NULL, NULL),
('000010', 'Sanitaryware (Bidet Showers, Taps, Wash Basins, Commodes & Accessories)', 'admin', '2011-11-25 09:28:47', 'admin', '2017-03-18 08:58:05', NULL, NULL, NULL, NULL, NULL, NULL),
('000011', 'Building Repairs and Improvements (Civil Works)', 'admin', '2017-03-18 08:58:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('000012', 'Repairs and Maintenance of Power Lines and other Electrical Installations', 'admin', '2017-03-18 08:58:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('000013', 'Repairs to Vehicles (Vehicle Service, Auto Electrical and Auto AC Services)', 'admin', '2017-03-18 08:58:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('000014', 'Pest Control Service', 'admin', '2017-03-18 08:58:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('000015', 'Repairs and Servicing of Air-Conditioners', 'admin', '2017-03-18 08:58:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tiorder`
--

CREATE TABLE IF NOT EXISTS `tiorder` (
  `user` varchar(15) NOT NULL,
  `itemcode` varchar(10) NOT NULL,
  `batchno` varchar(20) NOT NULL,
  `itemdes` varchar(50) NOT NULL,
  `qty` decimal(12,2) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `iono` int(11) NOT NULL,
  `ioyear` int(11) NOT NULL,
  `loc` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tporder`
--

CREATE TABLE IF NOT EXISTS `tporder` (
  `user` varchar(15) NOT NULL,
  `itemcode` char(10) NOT NULL,
  `itemdes` varchar(50) DEFAULT NULL,
  `des` varchar(300) DEFAULT NULL,
  `qty` decimal(12,2) DEFAULT NULL,
  `uprice` decimal(12,2) DEFAULT NULL,
  `nbt` decimal(12,2) DEFAULT NULL,
  `vat` decimal(12,2) NOT NULL,
  `otax` decimal(12,2) NOT NULL,
  `warr` int(2) DEFAULT NULL,
  `val` decimal(12,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tporder`
--

INSERT INTO `tporder` (`user`, `itemcode`, `itemdes`, `des`, `qty`, `uprice`, `nbt`, `vat`, `otax`, `warr`, `val`) VALUES
('admin', '002003007', 'Capital Cash Book', '', '1.00', '100.00', '0.00', '0.00', '0.00', 0, '100.00');

-- --------------------------------------------------------

--
-- Table structure for table `unit_masterfile`
--

CREATE TABLE IF NOT EXISTS `unit_masterfile` (
  `unit_code` varchar(9) NOT NULL,
  `div_code` varchar(9) NOT NULL,
  `unit_name` varchar(50) NOT NULL,
  `user_add` varchar(20) DEFAULT NULL,
  `user_add_date` datetime DEFAULT NULL,
  PRIMARY KEY (`unit_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `unit_masterfile`
--

INSERT INTO `unit_masterfile` (`unit_code`, `div_code`, `unit_name`, `user_add`, `user_add_date`) VALUES
('000101001', '000000101', 'Department of Computation and Intelligent Systems', '', '2017-03-18 01:22:49'),
('000101002', '000000101', 'Department of Information Systems Engineering', '', '2017-03-18 01:22:49'),
('000101003', '000000101', 'Department of Communication and Media Technologies', '', '2017-03-18 01:22:49'),
('000102001', '000000102', 'Academic and Publications', '', '2017-03-18 01:22:49'),
('000102002', '000000102', 'Establishments and Administration', '', '2017-03-18 01:22:49'),
('000102003', '000000102', 'Examinations And Registration', '', '2017-03-18 01:22:49'),
('000102004', '000000102', 'Finance', '', '2017-03-18 01:22:49'),
('000103001', '000000103', 'Digital Forensic Centre (DFC)', '', '2017-03-18 01:22:49'),
('000103002', '000000103', 'Advanced Digital Media Technology Centre (ADMTC)', '', '2017-03-18 01:22:49'),
('000103003', '000000103', 'Professional Development Centre (PDC)', '', '2017-03-18 01:22:49'),
('000103004', '000000103', 'External Degrees Center (EDC)', '', '2017-03-18 01:22:49'),
('000103005', '000000103', 'Computing Services Centre (CSC)', '', '2017-03-18 01:22:49'),
('000103006', '000000103', 'E-Learning Centre (ELC)', '', '2017-03-25 09:39:41');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `username` varchar(12) NOT NULL,
  `password` varchar(10) NOT NULL,
  `group` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `group`, `email`) VALUES
('admin', 'ad', '1', ''),
('admin_sup', 'adsup', '2', 'sup@kln.ac.lk'),
('bsup', 'bsup', '1', 'b@cmb.ac.lk'),
('caa1', 'caa1', '2', 'caa1@ucsc.lk'),
('sar', 'sr@12', '1', 'sar@kln.ac.lk');

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

CREATE TABLE IF NOT EXISTS `user_groups` (
  `id` int(2) NOT NULL,
  `name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_groups`
--

INSERT INTO `user_groups` (`id`, `name`) VALUES
(1, 'Super user'),
(2, 'Administrator');

-- --------------------------------------------------------

--
-- Stand-in structure for view `vsuppobalance`
--
CREATE TABLE IF NOT EXISTS `vsuppobalance` (
`pod_po_no` int(11)
,`pod_acct_yr` int(11)
,`pom_sup_code` char(10)
,`pod_item_code` char(10)
,`pod_qty` decimal(12,2)
,`pod_unit_price` decimal(12,2)
,`pod_nbt` decimal(12,2)
,`pod_vat` decimal(12,2)
,`pod_other` decimal(12,2)
,`edit_price` decimal(12,2)
,`already_recd` decimal(34,2)
,`grn_status` varchar(10)
,`balance` decimal(35,2)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `vsuppodetails`
--
CREATE TABLE IF NOT EXISTS `vsuppodetails` (
`pod_po_no` int(11)
,`pod_acct_yr` int(11)
,`pom_sup_code` char(10)
,`pod_item_code` char(10)
,`pod_qty` decimal(12,2)
,`pod_unit_price` decimal(12,2)
,`pod_nbt` decimal(12,2)
,`pod_vat` decimal(12,2)
,`pod_other` decimal(12,2)
,`edit_price` decimal(12,2)
,`already_recd` decimal(34,2)
,`grn_status` varchar(10)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `vsuppohasbalance`
--
CREATE TABLE IF NOT EXISTS `vsuppohasbalance` (
`pod_po_no` int(11)
,`pod_acct_yr` int(11)
,`pom_sup_code` char(10)
,`pod_item_code` char(10)
,`pod_qty` decimal(12,2)
,`pod_unit_price` decimal(12,2)
,`pod_nbt` decimal(12,2)
,`pod_vat` decimal(12,2)
,`pod_other` decimal(12,2)
,`edit_price` decimal(12,2)
,`already_recd` decimal(34,2)
,`grn_status` varchar(10)
,`balance` decimal(35,2)
,`item_description` varchar(50)
);
-- --------------------------------------------------------

--
-- Structure for view `vsuppobalance`
--
DROP TABLE IF EXISTS `vsuppobalance`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vsuppobalance` AS select `vsuppodetails`.`pod_po_no` AS `pod_po_no`,`vsuppodetails`.`pod_acct_yr` AS `pod_acct_yr`,`vsuppodetails`.`pom_sup_code` AS `pom_sup_code`,`vsuppodetails`.`pod_item_code` AS `pod_item_code`,`vsuppodetails`.`pod_qty` AS `pod_qty`,`vsuppodetails`.`pod_unit_price` AS `pod_unit_price`,`vsuppodetails`.`pod_nbt` AS `pod_nbt`,`vsuppodetails`.`pod_vat` AS `pod_vat`,`vsuppodetails`.`pod_other` AS `pod_other`,`vsuppodetails`.`edit_price` AS `edit_price`,`vsuppodetails`.`already_recd` AS `already_recd`,`vsuppodetails`.`grn_status` AS `grn_status`,(`vsuppodetails`.`pod_qty` - `vsuppodetails`.`already_recd`) AS `balance` from `vsuppodetails`;

-- --------------------------------------------------------

--
-- Structure for view `vsuppodetails`
--
DROP TABLE IF EXISTS `vsuppodetails`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vsuppodetails` AS select `purch_ord_det`.`pod_po_no` AS `pod_po_no`,`purch_ord_det`.`pod_acct_yr` AS `pod_acct_yr`,`purch_ord_mas`.`pom_sup_code` AS `pom_sup_code`,`purch_ord_det`.`pod_item_code` AS `pod_item_code`,`purch_ord_det`.`pod_qty` AS `pod_qty`,`purch_ord_det`.`pod_unit_price` AS `pod_unit_price`,`purch_ord_det`.`pod_nbt` AS `pod_nbt`,`purch_ord_det`.`pod_vat` AS `pod_vat`,`purch_ord_det`.`pod_other` AS `pod_other`,ifnull(`grn_detail`.`grnd_edit_price`,`purch_ord_det`.`pod_unit_price`) AS `edit_price`,sum(ifnull(`grn_detail`.`grnd_qty_recd`,0)) AS `already_recd`,ifnull(`grn_detail`.`grnd_po_status`,_latin1'Normal') AS `grn_status` from ((`purch_ord_det` left join `grn_detail` on(((`purch_ord_det`.`pod_po_no` = `grn_detail`.`grnd_po_no`) and (`purch_ord_det`.`pod_acct_yr` = `grn_detail`.`grnd_po_acct_yr`) and (`purch_ord_det`.`pod_item_code` = `grn_detail`.`grnd_item_code`)))) join `purch_ord_mas` on(((`purch_ord_det`.`pod_po_no` = `purch_ord_mas`.`pom_po_no`) and (`purch_ord_det`.`pod_acct_yr` = `purch_ord_mas`.`pom_acct_yr`)))) group by `purch_ord_det`.`pod_po_no`,`purch_ord_det`.`pod_acct_yr`,`purch_ord_det`.`pod_item_code`;

-- --------------------------------------------------------

--
-- Structure for view `vsuppohasbalance`
--
DROP TABLE IF EXISTS `vsuppohasbalance`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vsuppohasbalance` AS select `vsuppobalance`.`pod_po_no` AS `pod_po_no`,`vsuppobalance`.`pod_acct_yr` AS `pod_acct_yr`,`vsuppobalance`.`pom_sup_code` AS `pom_sup_code`,`vsuppobalance`.`pod_item_code` AS `pod_item_code`,`vsuppobalance`.`pod_qty` AS `pod_qty`,`vsuppobalance`.`pod_unit_price` AS `pod_unit_price`,`vsuppobalance`.`pod_nbt` AS `pod_nbt`,`vsuppobalance`.`pod_vat` AS `pod_vat`,`vsuppobalance`.`pod_other` AS `pod_other`,`vsuppobalance`.`edit_price` AS `edit_price`,`vsuppobalance`.`already_recd` AS `already_recd`,`vsuppobalance`.`grn_status` AS `grn_status`,`vsuppobalance`.`balance` AS `balance`,`item_masterfile`.`item_description` AS `item_description` from (`vsuppobalance` join `item_masterfile`) where ((`item_masterfile`.`item_code` = `vsuppobalance`.`pod_item_code`) and (`vsuppobalance`.`balance` > 0));

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
