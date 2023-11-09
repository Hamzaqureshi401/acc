-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 04, 2023 at 11:26 AM
-- Server version: 10.5.19-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u932256864_acc`
--

-- --------------------------------------------------------

--
-- Table structure for table `addons`
--

CREATE TABLE `addons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `price` double(20,2) NOT NULL,
  `type` int(11) NOT NULL DEFAULT 1,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lead_id` bigint(20) UNSIGNED NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `quotation_no` bigint(20) DEFAULT NULL,
  `type` varchar(191) NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_status` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `lead_id`, `start_time`, `end_time`, `start_date`, `end_date`, `quotation_no`, `type`, `created_by`, `customer_status`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, '13:40:00', '17:40:00', '2023-11-05', NULL, 212840, 'Quote', 1, 1, 0, '2023-11-03 21:40:38', '2023-11-03 21:42:32');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `phone` varchar(191) NOT NULL,
  `email` varchar(191) DEFAULT NULL,
  `postcode` longtext DEFAULT NULL,
  `address` longtext DEFAULT NULL,
  `city` longtext DEFAULT NULL,
  `customer_note` longtext DEFAULT NULL,
  `situation_image` varchar(191) DEFAULT NULL,
  `lead_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `phone`, `email`, `postcode`, `address`, `city`, `customer_note`, `situation_image`, `lead_id`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Testing', '03009080007', 'testing@gmai.com', NULL, 'Main street no.1', NULL, NULL, NULL, 1, 1, '2023-11-03 21:42:32', '2023-11-03 21:42:32');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_number` varchar(191) NOT NULL,
  `date` date NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `address` varchar(191) NOT NULL,
  `type` varchar(191) NOT NULL,
  `sales_tax` double(20,2) DEFAULT NULL,
  `discount` double(20,2) DEFAULT NULL,
  `sub_total` double(20,2) DEFAULT NULL,
  `discount_amount` double(20,2) DEFAULT NULL,
  `tax_amount` double(20,2) DEFAULT NULL,
  `total_amount` double(20,2) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `customer_note` longtext DEFAULT NULL,
  `maintenance_date` date DEFAULT NULL,
  `first_invoice` int(11) DEFAULT NULL,
  `first_due_date` date DEFAULT NULL,
  `first_invoice_amount` int(11) DEFAULT NULL,
  `first_invoice_paid` int(11) DEFAULT NULL,
  `second_invoice` int(11) DEFAULT NULL,
  `second_due_date` date DEFAULT NULL,
  `second_invoice_amount` int(11) DEFAULT NULL,
  `second_invoice_paid` int(11) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `invoice_number`, `date`, `customer_id`, `address`, `type`, `sales_tax`, `discount`, `sub_total`, `discount_amount`, `tax_amount`, `total_amount`, `description`, `customer_note`, `maintenance_date`, `first_invoice`, `first_due_date`, `first_invoice_amount`, `first_invoice_paid`, `second_invoice`, `second_due_date`, `second_invoice_amount`, `second_invoice_paid`, `created_by`, `created_at`, `updated_at`) VALUES
(1, '214404', '2023-11-03', 1, ',Main street no.1,', 'Standard', NULL, NULL, 5000.00, 0.00, 0.00, 5000.00, NULL, NULL, '2023-11-04', 10, '2023-11-10', 500, 500, 90, '2023-11-30', 4500, NULL, 1, '2023-11-03 21:44:04', '2023-11-03 21:51:19');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_details`
--

CREATE TABLE `invoice_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(191) DEFAULT NULL,
  `price` double(20,2) DEFAULT NULL,
  `tax` double(20,2) DEFAULT NULL,
  `total` double(20,2) DEFAULT NULL,
  `quantity` double(15,2) DEFAULT NULL,
  `unit` varchar(191) DEFAULT NULL,
  `description` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice_details`
--

INSERT INTO `invoice_details` (`id`, `invoice_id`, `product_id`, `product_name`, `price`, `tax`, `total`, `quantity`, `unit`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Daikin Perfera R32 WiFi 2.0kw', 2200.00, 0.00, 4400.00, 2.00, 'Pcs', 'dfadsfasd', '2023-11-03 21:44:04', '2023-11-03 21:44:04'),
(2, 1, 2, 'AC Fitting Service', 300.00, 0.00, 600.00, 2.00, 'per ac', 'The complete Ac fitting', '2023-11-03 21:44:04', '2023-11-03 21:44:04');

-- --------------------------------------------------------

--
-- Table structure for table `leads`
--

CREATE TABLE `leads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `phone` varchar(191) NOT NULL,
  `email` varchar(191) DEFAULT NULL,
  `address` longtext DEFAULT NULL,
  `source` varchar(191) NOT NULL,
  `type` varchar(191) NOT NULL,
  `postcode` varchar(191) DEFAULT NULL,
  `city` varchar(191) DEFAULT NULL,
  `product_name` varchar(191) DEFAULT NULL,
  `additional_field` varchar(191) DEFAULT NULL,
  `message` varchar(191) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `appointment_status` int(11) NOT NULL DEFAULT 0,
  `quotation_status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leads`
--

INSERT INTO `leads` (`id`, `name`, `phone`, `email`, `address`, `source`, `type`, `postcode`, `city`, `product_name`, `additional_field`, `message`, `status`, `appointment_status`, `quotation_status`, `created_at`, `updated_at`) VALUES
(1, 'Testing', '03009080007', 'testing@gmai.com', 'Main street no.1', 'Contact page', 'WP Form', NULL, NULL, NULL, NULL, NULL, 0, 1, 1, '2023-11-03 21:21:40', '2023-11-03 21:40:38'),
(2, 'Mr usama', '03000233223', 'testing@gmail', 'Main street no. 1', 'System', 'System', '3000', 'Lahore', NULL, NULL, NULL, 0, 0, 0, '2023-11-03 21:32:42', '2023-11-03 21:32:42');

-- --------------------------------------------------------

--
-- Table structure for table `mailsettings`
--

CREATE TABLE `mailsettings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mail_transport` varchar(191) NOT NULL,
  `mail_host` varchar(191) NOT NULL,
  `mail_port` varchar(191) NOT NULL,
  `mail_username` varchar(191) NOT NULL,
  `mail_password` varchar(191) NOT NULL,
  `mail_encryption` varchar(191) NOT NULL,
  `mail_from` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mailsettings`
--

INSERT INTO `mailsettings` (`id`, `mail_transport`, `mail_host`, `mail_port`, `mail_username`, `mail_password`, `mail_encryption`, `mail_from`, `created_at`, `updated_at`) VALUES
(1, 'smtp', 'sandbox.smtp.mailtrap.io', '2525', 'c9b9e7731309e8', '********1819', 'tls', 'appemailtest12@gmail.com', '2023-11-02 22:40:55', '2023-11-02 22:40:55');

-- --------------------------------------------------------

--
-- Table structure for table `master_settings`
--

CREATE TABLE `master_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `master_title` text NOT NULL,
  `master_value` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_settings`
--

INSERT INTO `master_settings` (`id`, `master_title`, `master_value`, `created_at`, `updated_at`) VALUES
(1, 'store_name', 'Van Leeuwen Airconditioning', NULL, NULL),
(2, 'store_phone', '123456', NULL, NULL),
(3, 'store_email', 'email@email.com', NULL, NULL),
(4, 'tax_percentage', '0', NULL, NULL),
(5, 'currency_symbol', '€', NULL, NULL),
(6, 'address', '', NULL, NULL),
(7, 'logo', '/uploads/logo/1699046450.png', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(4, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(5, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(6, '2016_06_01_000004_create_oauth_clients_table', 1),
(7, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(8, '2019_08_19_000000_create_failed_jobs_table', 1),
(9, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(10, '2023_01_03_110853_create_product_categories_table', 1),
(11, '2023_01_03_110853_create_suppliers_table', 1),
(12, '2023_01_03_112634_create_products_table', 1),
(13, '2023_01_03_121155_create_addons_table', 1),
(14, '2023_01_03_130000_create_tables_table', 1),
(15, '2023_01_03_135206_create_customers_table', 1),
(16, '2023_01_04_045410_create_orders_table', 1),
(17, '2023_01_04_045419_create_order_details_table', 1),
(18, '2023_01_04_045426_create_order_detail_addons_table', 1),
(19, '2023_01_04_103009_create_order_payments_table', 1),
(20, '2023_01_05_113536_create_master_settings_table', 1),
(21, '2023_01_06_102531_create_translations_table', 1),
(22, '2023_01_07_083933_create_permissions_table', 1),
(23, '2023_01_07_084129_create_model_permissions_table', 1),
(24, '2023_09_07_040508_create_mailsettings_table', 1),
(25, '2023_09_13_123227_create_leads_table', 1),
(26, '2023_09_18_111043_create_stocks_table', 1),
(27, '2023_09_26_102808_create_appointments_table', 1),
(28, '2023_10_08_105744_create_quotations_table', 1),
(29, '2023_10_08_110414_create_quotation_details_table', 1),
(30, '2023_10_09_021845_create_invoices_table', 1),
(31, '2023_10_09_021901_create_invoice_details_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_permissions`
--

CREATE TABLE `model_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `permission_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_permissions`
--

INSERT INTO `model_permissions` (`id`, `user_id`, `permission_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2023-11-02 22:40:55', '2023-11-02 22:40:55'),
(2, 1, 2, '2023-11-02 22:40:55', '2023-11-02 22:40:55'),
(3, 1, 3, '2023-11-02 22:40:55', '2023-11-02 22:40:55'),
(4, 1, 4, '2023-11-02 22:40:55', '2023-11-02 22:40:55'),
(5, 1, 5, '2023-11-02 22:40:55', '2023-11-02 22:40:55'),
(6, 1, 6, '2023-11-02 22:40:55', '2023-11-02 22:40:55'),
(7, 1, 7, '2023-11-02 22:40:55', '2023-11-02 22:40:55'),
(8, 1, 8, '2023-11-02 22:40:55', '2023-11-02 22:40:55'),
(9, 1, 9, '2023-11-02 22:40:55', '2023-11-02 22:40:55'),
(10, 1, 10, '2023-11-02 22:40:55', '2023-11-02 22:40:55'),
(11, 1, 11, '2023-11-02 22:40:55', '2023-11-02 22:40:55'),
(12, 1, 12, '2023-11-02 22:40:55', '2023-11-02 22:40:55'),
(13, 1, 13, '2023-11-02 22:40:55', '2023-11-02 22:40:55'),
(14, 1, 14, '2023-11-02 22:40:55', '2023-11-02 22:40:55'),
(15, 1, 15, '2023-11-02 22:40:55', '2023-11-02 22:40:55'),
(16, 1, 16, '2023-11-02 22:40:55', '2023-11-02 22:40:55'),
(17, 1, 17, '2023-11-02 22:40:56', '2023-11-02 22:40:56'),
(18, 1, 18, '2023-11-02 22:40:56', '2023-11-02 22:40:56'),
(19, 1, 19, '2023-11-02 22:40:56', '2023-11-02 22:40:56'),
(20, 1, 20, '2023-11-02 22:40:56', '2023-11-02 22:40:56'),
(21, 1, 21, '2023-11-02 22:40:56', '2023-11-02 22:40:56'),
(22, 1, 22, '2023-11-02 22:40:56', '2023-11-02 22:40:56'),
(23, 1, 23, '2023-11-02 22:40:56', '2023-11-02 22:40:56'),
(24, 1, 24, '2023-11-02 22:40:56', '2023-11-02 22:40:56'),
(25, 1, 25, '2023-11-02 22:40:56', '2023-11-02 22:40:56'),
(26, 1, 26, '2023-11-02 22:40:56', '2023-11-02 22:40:56'),
(27, 1, 27, '2023-11-02 22:40:56', '2023-11-02 22:40:56'),
(28, 1, 28, '2023-11-02 22:40:56', '2023-11-02 22:40:56'),
(29, 1, 29, '2023-11-02 22:40:56', '2023-11-02 22:40:56'),
(30, 1, 30, '2023-11-02 22:40:56', '2023-11-02 22:40:56'),
(31, 1, 31, '2023-11-02 22:40:56', '2023-11-02 22:40:56'),
(32, 1, 32, '2023-11-02 22:40:56', '2023-11-02 22:40:56'),
(33, 1, 33, '2023-11-02 22:40:56', '2023-11-02 22:40:56'),
(34, 1, 34, '2023-11-02 22:40:56', '2023-11-02 22:40:56'),
(35, 1, 35, '2023-11-02 22:40:56', '2023-11-02 22:40:56'),
(36, 1, 36, '2023-11-02 22:40:56', '2023-11-02 22:40:56'),
(37, 1, 37, '2023-11-02 22:40:56', '2023-11-02 22:40:56'),
(38, 1, 38, '2023-11-02 22:40:56', '2023-11-02 22:40:56'),
(39, 1, 39, '2023-11-02 22:40:56', '2023-11-02 22:40:56'),
(40, 1, 40, '2023-11-02 22:40:56', '2023-11-02 22:40:56'),
(41, 1, 41, '2023-11-02 22:40:56', '2023-11-02 22:40:56'),
(42, 1, 42, '2023-11-02 22:40:56', '2023-11-02 22:40:56'),
(43, 1, 43, '2023-11-02 22:40:56', '2023-11-02 22:40:56'),
(44, 1, 44, '2023-11-02 22:40:56', '2023-11-02 22:40:56'),
(45, 1, 45, '2023-11-02 22:40:56', '2023-11-02 22:40:56'),
(46, 1, 46, '2023-11-02 22:40:56', '2023-11-02 22:40:56'),
(47, 1, 47, '2023-11-02 22:40:56', '2023-11-02 22:40:56'),
(48, 1, 48, '2023-11-02 22:40:56', '2023-11-02 22:40:56'),
(49, 1, 49, '2023-11-02 22:40:56', '2023-11-02 22:40:56'),
(50, 1, 50, '2023-11-02 22:40:56', '2023-11-02 22:40:56'),
(51, 1, 51, '2023-11-02 22:40:56', '2023-11-02 22:40:56'),
(52, 1, 52, '2023-11-02 22:40:56', '2023-11-02 22:40:56'),
(53, 1, 53, '2023-11-02 22:40:56', '2023-11-02 22:40:56'),
(54, 1, 54, '2023-11-02 22:40:56', '2023-11-02 22:40:56');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `secret` varchar(100) DEFAULT NULL,
  `provider` varchar(191) DEFAULT NULL,
  `redirect` text NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) NOT NULL,
  `access_token_id` varchar(100) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` datetime DEFAULT NULL,
  `order_number` varchar(191) NOT NULL,
  `customer_name` varchar(191) DEFAULT NULL,
  `customer_phone` varchar(191) DEFAULT NULL,
  `table_no` varchar(191) DEFAULT NULL,
  `service_charge` double(20,2) DEFAULT NULL,
  `discount` double(20,2) DEFAULT NULL,
  `subtotal` double(20,2) DEFAULT NULL,
  `tax_percentage` double(15,2) DEFAULT NULL,
  `tax_amount` double(15,2) DEFAULT NULL,
  `total` double(20,2) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `order_type` int(11) DEFAULT NULL,
  `notes` longtext DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `table_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(191) DEFAULT NULL,
  `rate` double(20,2) DEFAULT NULL,
  `total` double(20,2) DEFAULT NULL,
  `quantity` double(15,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_detail_addons`
--

CREATE TABLE `order_detail_addons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_detail_id` bigint(20) UNSIGNED NOT NULL,
  `addon_id` bigint(20) UNSIGNED DEFAULT NULL,
  `addon_name` varchar(191) DEFAULT NULL,
  `addon_price` double(20,2) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_payments`
--

CREATE TABLE `order_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_name` varchar(191) DEFAULT NULL,
  `customer_phone` varchar(191) DEFAULT NULL,
  `amount` double(15,2) NOT NULL,
  `type` int(11) NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(191) NOT NULL,
  `name` varchar(191) NOT NULL,
  `category` varchar(191) NOT NULL,
  `step` varchar(191) NOT NULL,
  `list` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `slug`, `name`, `category`, `step`, `list`, `created_at`, `updated_at`) VALUES
(1, 'products_list', 'View', 'products', '1', 1, NULL, NULL),
(2, 'add_product', 'Create', 'products', '2', 1, NULL, NULL),
(3, 'edit_product', 'Edit', 'products', '3', 1, NULL, NULL),
(4, 'delete_product', 'Delete', 'products', '1', 1, NULL, NULL),
(5, 'categories_list', 'View', 'Category', '1', 2, NULL, NULL),
(6, 'add_category', 'Create', 'Category', '2', 2, NULL, NULL),
(7, 'edit_category', 'Edit', 'Category', '3', 2, NULL, NULL),
(8, 'delete_category', 'Delete', 'Category', '4', 2, NULL, NULL),
(9, 'suppliers_list', 'View', 'Supplier', '1', 3, NULL, NULL),
(10, 'add_supplier', 'Create', 'Supplier', '2', 3, NULL, NULL),
(11, 'edit_supplier', 'Edit', 'Supplier', '3', 3, NULL, NULL),
(12, 'delete_supplier', 'Delete', 'Supplier', '4', 3, NULL, NULL),
(13, 'add_lead', 'Create', 'Leads', '1', 4, NULL, NULL),
(14, 'edit_lead', 'Edit', 'Leads', '2', 4, NULL, NULL),
(15, 'delete_lead', 'Delete', 'Leads', '3', 4, NULL, NULL),
(16, 'leads_list', 'View', 'Leads', '4', 4, NULL, NULL),
(17, 'contactleads_list', 'View', 'Leads', '5', 4, NULL, NULL),
(18, 'quoteleads_list', 'View', 'Leads', '6', 4, NULL, NULL),
(19, 'productleads_list', 'View', 'Leads', '7', 4, NULL, NULL),
(20, 'customers_list', 'View', 'customers', '1', 5, NULL, NULL),
(21, 'add_customer', 'Create', 'customers', '2', 5, NULL, NULL),
(22, 'edit_customer', 'Edit', 'customers', '3', 5, NULL, NULL),
(23, 'delete_customer', 'Delete', 'customers', '4', 5, NULL, NULL),
(24, 'add_appointment', 'Create', 'Appointment', '1', 6, NULL, NULL),
(25, 'edit_appointment', 'Edit', 'Appointment', '2', 6, NULL, NULL),
(26, 'delete_appointment', 'Delete', 'Appointment', '3', 6, NULL, NULL),
(27, 'appointment_list', 'View', 'Appointment', '4', 6, NULL, NULL),
(28, 'add_quotation', 'Create', 'Quotation', '1', 7, NULL, NULL),
(29, 'edit_quotation', 'Edit', 'Quotation', '2', 7, NULL, NULL),
(30, 'delete_quotation', 'Delete', 'Quotation', '3', 7, NULL, NULL),
(31, 'quotation_list', 'View', 'Quotation', '4', 7, NULL, NULL),
(32, 'add_invoice', 'Create', 'Invoice', '1', 8, NULL, NULL),
(33, 'edit_invoice', 'Edit', 'Invoice', '2', 8, NULL, NULL),
(34, 'delete_invoice', 'Delete', 'Invoice', '3', 8, NULL, NULL),
(35, 'invoice_list', 'View', 'Invoice', '4', 8, NULL, NULL),
(36, 'staffs_list', 'View', 'Staff', '1', 9, NULL, NULL),
(37, 'add_staff', 'Create', 'Staff', '2', 9, NULL, NULL),
(38, 'edit_staff', 'Edit', 'Staff', '3', 9, NULL, NULL),
(39, 'delete_staff', 'Delete', 'Staff', '4', 9, NULL, NULL),
(40, 'sales_report', 'Sales Report', 'Reports', '1', 10, NULL, NULL),
(41, 'day_wise_sales_report', 'Day Wise Sales Report', 'Reports', '2', 10, NULL, NULL),
(42, 'item_wise_sales_report', 'Item Wise Sales Report', 'Reports', '3', 10, NULL, NULL),
(43, 'customer_report', 'Customer Report', 'Reports', '4', 10, NULL, NULL),
(44, 'stock_report', 'Stock Report', 'Reports', '5', 10, NULL, NULL),
(45, 'low_stock_report', 'Low Stock Report', 'Reports', '6', 10, NULL, NULL),
(46, 'translations_list', 'View', 'Translation', '1', 11, NULL, NULL),
(47, 'add_translation', 'Create', 'Translation', '2', 11, NULL, NULL),
(48, 'edit_translation', 'Edit', 'Translation', '3', 11, NULL, NULL),
(49, 'delete_translation', 'Delete', 'Translation', '4', 11, NULL, NULL),
(50, 'account_settings', 'Account Settings', 'Settings', '1', 12, NULL, NULL),
(51, 'app_settings', 'App Settings', 'Settings', '2', 12, NULL, NULL),
(52, 'mail_settings', 'Mail Settings', 'Settings', '3', 12, NULL, NULL),
(53, 'invoices_list', 'View', 'Invoices', '1', 13, NULL, NULL),
(54, 'inventory_list', 'View', 'Invetory', '1', 14, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(191) NOT NULL,
  `name` varchar(191) NOT NULL,
  `unit` varchar(191) NOT NULL,
  `image` varchar(191) DEFAULT NULL,
  `price` double(20,2) DEFAULT NULL,
  `cost` double(20,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `quantity_alert` int(11) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `is_veg` int(11) DEFAULT NULL,
  `is_active` int(11) DEFAULT NULL,
  `loyalty_points` int(11) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `supplier_id`, `code`, `name`, `unit`, `image`, `price`, `cost`, `quantity`, `quantity_alert`, `description`, `is_veg`, `is_active`, `loyalty_points`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 4, 3, '0010', 'Daikin Perfera R32 WiFi 2.0kw', 'Pcs', '/uploads/products/1699046724.jpg', 2219.00, 2000.00, 8, 2, 'A+++\nFluisterstil (<19dB)\nOnecta app: op afstand bedienbaar\nSpraakbediening functie\n2-zonebewegingssensor\n3D-luchtstroom', 0, 1, 0, 1, '2023-11-03 21:25:24', '2023-11-03 21:44:04'),
(2, 1, 3, '00', 'AC Fitting Service', 'per ac', '/uploads/products/1699046831.png', 300.00, 200.00, 198, 10, NULL, 0, 1, 0, 1, '2023-11-03 21:27:11', '2023-11-03 21:44:04');

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `description` longtext DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`id`, `name`, `description`, `is_active`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'AC Service', 'ac service', 1, 1, '2023-11-03 21:18:51', '2023-11-03 21:18:51'),
(2, 'Ac Parts', 'AC Parts', 1, 1, '2023-11-03 21:19:02', '2023-11-03 21:19:02'),
(3, 'AC Outer ', '', 1, 1, '2023-11-03 21:19:12', '2023-11-03 21:19:12'),
(4, 'AC', '', 1, 1, '2023-11-03 21:19:20', '2023-11-03 21:19:20');

-- --------------------------------------------------------

--
-- Table structure for table `quotations`
--

CREATE TABLE `quotations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quotation_number` varchar(191) NOT NULL,
  `created_date` date NOT NULL,
  `expiry_date` date NOT NULL,
  `lead_id` bigint(20) UNSIGNED NOT NULL,
  `address` varchar(191) DEFAULT NULL,
  `stage` varchar(191) NOT NULL,
  `sales_tax` double(20,2) DEFAULT NULL,
  `discount` double(20,2) DEFAULT NULL,
  `sub_total` double(20,2) DEFAULT NULL,
  `discount_amount` double(20,2) DEFAULT NULL,
  `tax_amount` double(20,2) DEFAULT NULL,
  `total_amount` double(20,2) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `customer_note` longtext DEFAULT NULL,
  `invoice_status` int(11) NOT NULL DEFAULT 0,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quotations`
--

INSERT INTO `quotations` (`id`, `quotation_number`, `created_date`, `expiry_date`, `lead_id`, `address`, `stage`, `sales_tax`, `discount`, `sub_total`, `discount_amount`, `tax_amount`, `total_amount`, `description`, `customer_note`, `invoice_status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, '212840', '2023-11-04', '2023-11-04', 1, NULL, 'Accepted', NULL, NULL, 5000.00, 0.00, 0.00, 5000.00, NULL, NULL, 1, 1, '2023-11-03 21:28:40', '2023-11-03 21:44:04');

-- --------------------------------------------------------

--
-- Table structure for table `quotation_details`
--

CREATE TABLE `quotation_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quotation_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(191) DEFAULT NULL,
  `price` double(20,2) DEFAULT NULL,
  `tax` double(20,2) DEFAULT NULL,
  `total` double(20,2) DEFAULT NULL,
  `quantity` double(15,2) DEFAULT NULL,
  `unit` varchar(191) DEFAULT NULL,
  `description` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quotation_details`
--

INSERT INTO `quotation_details` (`id`, `quotation_id`, `product_id`, `product_name`, `price`, `tax`, `total`, `quantity`, `unit`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Daikin Perfera R32 WiFi 2.0kw', 2200.00, 0.00, 4400.00, 2.00, 'Pcs', 'dfadsfasd', '2023-11-03 21:28:40', '2023-11-03 21:28:40'),
(2, 1, 2, 'AC Fitting Service', 300.00, 0.00, 600.00, 2.00, 'per ac', 'The complete Ac fitting', '2023-11-03 21:28:40', '2023-11-03 21:28:40');

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`id`, `product_id`, `quantity`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 10, 1, '2023-11-03 21:25:24', '2023-11-03 21:25:24'),
(2, 2, 200, 1, '2023-11-03 21:27:11', '2023-11-03 21:27:11');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `business_name` longtext DEFAULT NULL,
  `phone_no` longtext DEFAULT NULL,
  `address` longtext DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `business_name`, `phone_no`, `address`, `is_active`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'LG', '', NULL, NULL, 1, 1, '2023-11-03 21:19:28', '2023-11-03 21:19:28'),
(2, 'Mistuibshi', '', NULL, NULL, 1, 1, '2023-11-03 21:22:50', '2023-11-03 21:22:50'),
(3, 'Daikin', '', NULL, NULL, 1, 1, '2023-11-03 21:23:04', '2023-11-03 21:23:04');

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `capacity` int(11) NOT NULL,
  `layout` varchar(191) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `translations`
--

CREATE TABLE `translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `data` longtext NOT NULL,
  `is_active` int(11) DEFAULT NULL,
  `default` int(11) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `user_type` int(11) NOT NULL DEFAULT 2,
  `phone` varchar(191) DEFAULT NULL,
  `avatar` varchar(191) DEFAULT NULL,
  `address` longtext DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `user_type`, `phone`, `avatar`, `address`, `is_active`, `created_by`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@admin.com', NULL, '$2y$10$F0.YZCLrqdvfmI0LcOoTqeiBTL.h2ejpTf1M71s6..0JsVlpzbVa6', 1, NULL, NULL, NULL, 1, NULL, NULL, '2023-11-02 22:40:55', '2023-11-02 22:40:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addons`
--
ALTER TABLE `addons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice_details`
--
ALTER TABLE `invoice_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leads`
--
ALTER TABLE `leads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mailsettings`
--
ALTER TABLE `mailsettings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_settings`
--
ALTER TABLE `master_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_permissions`
--
ALTER TABLE `model_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_detail_addons`
--
ALTER TABLE `order_detail_addons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_payments`
--
ALTER TABLE `order_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quotations`
--
ALTER TABLE `quotations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quotation_details`
--
ALTER TABLE `quotation_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `translations`
--
ALTER TABLE `translations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addons`
--
ALTER TABLE `addons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `invoice_details`
--
ALTER TABLE `invoice_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `leads`
--
ALTER TABLE `leads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mailsettings`
--
ALTER TABLE `mailsettings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `master_settings`
--
ALTER TABLE `master_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `model_permissions`
--
ALTER TABLE `model_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_detail_addons`
--
ALTER TABLE `order_detail_addons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_payments`
--
ALTER TABLE `order_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `quotations`
--
ALTER TABLE `quotations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `quotation_details`
--
ALTER TABLE `quotation_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `translations`
--
ALTER TABLE `translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
