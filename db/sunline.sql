-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 04, 2025 at 06:33 AM
-- Server version: 8.0.42-0ubuntu0.20.04.1
-- PHP Version: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sunline`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE `activity` (
  `id` int UNSIGNED NOT NULL,
  `intake_id` int UNSIGNED DEFAULT NULL,
  `activity_type_id` int UNSIGNED DEFAULT NULL,
  `client_id` int UNSIGNED DEFAULT NULL,
  `user_id` int UNSIGNED DEFAULT NULL,
  `module` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `details` text COLLATE utf8mb4_unicode_ci,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `activity_types`
--

CREATE TABLE `activity_types` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_types`
--

INSERT INTO `activity_types` (`id`, `title`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Add Referral Firm to Case', '2025-08-12 08:55:50', '2025-08-12 08:55:50', NULL),
(2, 'Add Referral Firm to Lead', '2025-08-12 08:55:50', '2025-08-12 08:55:50', NULL),
(3, 'Added a Note', '2025-08-12 08:55:50', '2025-08-12 08:55:50', NULL),
(4, 'Added Key Date', '2025-08-12 08:55:50', '2025-08-12 08:55:50', NULL),
(5, 'Additional Contact removed', '2025-08-12 08:55:50', '2025-08-12 08:55:50', NULL),
(6, 'Additional Contacts added', '2025-08-12 08:55:50', '2025-08-12 08:55:50', NULL),
(7, 'Appointment Cancelled', '2025-08-12 08:55:50', '2025-08-12 08:55:50', NULL),
(8, 'Appointment Created', '2025-08-12 08:55:50', '2025-08-12 08:55:50', NULL),
(9, 'Appointment Deleted', '2025-08-12 08:55:50', '2025-08-12 08:55:50', NULL),
(10, 'Appointment Reminder Email', '2025-08-12 08:55:50', '2025-08-12 08:55:50', NULL),
(11, 'Appointment Reminder Text Message', '2025-08-12 08:55:50', '2025-08-12 08:55:50', NULL),
(12, 'Appointment Rescheduled', '2025-08-12 08:55:50', '2025-08-12 08:55:50', NULL),
(13, 'Appointment Updated', '2025-08-12 08:55:50', '2025-08-12 08:55:50', NULL),
(14, 'Assigned A Task', '2025-08-12 08:55:50', '2025-08-12 08:55:50', NULL),
(15, 'Call - Abandoned Call', '2025-08-12 08:55:50', '2025-08-12 08:55:50', NULL),
(16, 'Call - Call Outcome Status Changed', '2025-08-12 08:55:50', '2025-08-12 08:55:50', NULL),
(17, 'Call - Declined Inbound Call', '2025-08-12 08:55:50', '2025-08-12 08:55:50', NULL),
(18, 'Call - Inbound', '2025-08-12 08:55:50', '2025-08-12 08:55:50', NULL),
(19, 'Call - Missed Outbound Call', '2025-08-12 08:55:50', '2025-08-12 08:55:50', NULL),
(20, 'Call - Missed Queue Call', '2025-08-12 08:55:50', '2025-08-12 08:55:50', NULL),
(21, 'Call - Outbound', '2025-08-12 08:55:50', '2025-08-12 08:55:50', NULL),
(22, 'Call - Outbound Call Generated', '2025-08-12 08:55:50', '2025-08-12 08:55:50', NULL),
(23, 'Call - Recycled Outbound Call', '2025-08-12 08:55:50', '2025-08-12 08:55:50', NULL),
(24, 'Call - Taken Over', '2025-08-12 08:55:50', '2025-08-12 08:55:50', NULL),
(25, 'Call - Transfer Inbound', '2025-08-12 08:55:50', '2025-08-12 08:55:50', NULL),
(26, 'Call - Transfer Outbound', '2025-08-12 08:55:50', '2025-08-12 08:55:50', NULL),
(27, 'Canceled Payment Plan', '2025-08-12 08:55:50', '2025-08-12 08:55:50', NULL),
(28, 'Cancelled Appointment', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(29, 'Case Change', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(30, 'Case Role Added', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(31, 'Case Role Changed', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(32, 'Case Role Contact Changed', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(33, 'Case Role Contact Issue Resolved', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(34, 'Changed Contact', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(35, 'Changed Lead Status', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(36, 'ClientProfile - Lead Converted', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(37, 'ClientProfile - Sync Notes', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(38, 'Clio - Lead Converted', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(39, 'Completed a Task', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(40, 'Completed Payment Plan', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(41, 'Converted Lead', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(42, 'Copied Lead', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(43, 'CosmoLex - Lead Converted', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(44, 'Created a New Lead', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(45, 'Created a new user', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(46, 'Created Payment Plan', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(47, 'Crocodile - Lead Converted', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(48, 'Delete a Lead', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(49, 'Deleted a Note of', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(50, 'Deleted a Task of', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(51, 'Document Added To Print Queue', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(52, 'Document created', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(53, 'Document Deleted', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(54, 'Document Template', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(55, 'Draft Invoice Created', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(56, 'E-Sign Contract Cancelled', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(57, 'E-Sign Contract Sent', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(58, 'E-Sign Contract Signed Now', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(59, 'Edited Key Date', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(60, 'Edited Note', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(61, 'Edited Payment Plan', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(62, 'Email Campaign Status', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(63, 'Email Entry', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(64, 'Email Opt-In/Opt-Out', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(65, 'Email Sent Or Replied', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(66, 'Email Status', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(67, 'Erased Key Date', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(68, 'FileVine Send Case', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(69, 'Imported a New Lead', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(70, 'Installment Payment', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(71, 'Intake Form', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(72, 'Integration', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(73, 'Invoice Deleted', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(74, 'Invoice Disapproved', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(75, 'Invoice Item Added', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(76, 'Invoice Item Removed', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(77, 'Invoice Item Updated', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(78, 'Invoice Payment', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(79, 'Invoice Saved', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(80, 'Invoice Sent', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(81, 'LawPay Account Changed', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(82, 'Lead Checking Quesionnaire', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(83, 'Lead Closure', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(84, 'Lead Name Changed', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(85, 'Lead Source Changed', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(86, 'Lien', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(87, 'MerchantPaymentAPI', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(88, 'Merged Lead', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(89, 'Multimedia Message Reply', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(90, 'Needles - Sync Notes', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(91, 'Needles Email Campaign', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(92, 'Payment Transaction', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(93, 'Phone Opt-In/Opt-Out', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(94, 'Prevail - Lead Converted', '2025-08-12 08:55:51', '2025-08-12 08:55:51', NULL),
(95, 'Remove Referral Firm from Case', '2025-08-12 08:55:52', '2025-08-12 08:55:52', NULL),
(96, 'Remove Referral Firm from Lead', '2025-08-12 08:55:52', '2025-08-12 08:55:52', NULL),
(97, 'Restore Lead', '2025-08-12 08:55:52', '2025-08-12 08:55:52', NULL),
(98, 'Sent to Referral Firm', '2025-08-12 08:55:52', '2025-08-12 08:55:52', NULL),
(99, 'SettlementPayee', '2025-08-12 08:55:52', '2025-08-12 08:55:52', NULL),
(100, 'Shipping Label', '2025-08-12 08:55:52', '2025-08-12 08:55:52', NULL),
(101, 'SmartAdvocateXML - Lead Converted', '2025-08-12 08:55:52', '2025-08-12 08:55:52', NULL),
(102, 'SMS Opt-In/Opt-Out', '2025-08-12 08:55:52', '2025-08-12 08:55:52', NULL),
(103, 'Special Damage', '2025-08-12 08:55:52', '2025-08-12 08:55:52', NULL),
(104, 'Telmetrics Call Log', '2025-08-12 08:55:52', '2025-08-12 08:55:52', NULL),
(105, 'Text Message Campaign Status', '2025-08-12 08:55:52', '2025-08-12 08:55:52', NULL),
(106, 'Text Message Failure', '2025-08-12 08:55:52', '2025-08-12 08:55:52', NULL),
(107, 'Text Message for Task assigned', '2025-08-12 08:55:52', '2025-08-12 08:55:52', NULL),
(108, 'Text Message reply from user', '2025-08-12 08:55:52', '2025-08-12 08:55:52', NULL),
(109, 'Text Message Status', '2025-08-12 08:55:52', '2025-08-12 08:55:52', NULL),
(110, 'Time Entry added', '2025-08-12 08:55:52', '2025-08-12 08:55:52', NULL),
(111, 'Time Entry changed', '2025-08-12 08:55:52', '2025-08-12 08:55:52', NULL),
(112, 'Time Entry removed', '2025-08-12 08:55:52', '2025-08-12 08:55:52', NULL),
(113, 'TimeSolv - Lead Converted', '2025-08-12 08:55:52', '2025-08-12 08:55:52', NULL),
(114, 'Transferred Lead From', '2025-08-12 08:55:52', '2025-08-12 08:55:52', NULL),
(115, 'TrialWorks - Lead Converted', '2025-08-12 08:55:52', '2025-08-12 08:55:52', NULL),
(116, 'Update Referral Firm on Case', '2025-08-12 08:55:52', '2025-08-12 08:55:52', NULL),
(117, 'Update Referral Firm on Lead', '2025-08-12 08:55:52', '2025-08-12 08:55:52', NULL),
(118, 'Updated Document Content', '2025-08-12 08:55:52', '2025-08-12 08:55:52', NULL),
(119, 'Updated Lead via import process (Fill)', '2025-08-12 08:55:52', '2025-08-12 08:55:52', NULL),
(120, 'Updated Lead via import process (Update)', '2025-08-12 08:55:52', '2025-08-12 08:55:52', NULL),
(121, 'Uploaded Document', '2025-08-12 08:55:52', '2025-08-12 08:55:52', NULL),
(122, 'Vonage Call Log', '2025-08-12 08:55:52', '2025-08-12 08:55:52', NULL),
(123, 'Webhook Failed Internally', '2025-08-12 08:55:52', '2025-08-12 08:55:52', NULL),
(124, 'Webhook Failed Response', '2025-08-12 08:55:52', '2025-08-12 08:55:52', NULL),
(125, 'Webhook Success Response', '2025-08-12 08:55:52', '2025-08-12 08:55:52', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `api_logs`
--

CREATE TABLE `api_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `webhook_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'POST',
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `request_body` json DEFAULT NULL,
  `response_body` json DEFAULT NULL,
  `status_code` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Design', '1', NULL, NULL),
(2, 'Technical', '1', NULL, NULL),
(3, 'Compliance', '1', NULL, NULL),
(4, 'Installation', '1', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contact_follow_ups`
--

CREATE TABLE `contact_follow_ups` (
  `id` int NOT NULL,
  `lead_id` bigint UNSIGNED NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_completed` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_follow_ups`
--

INSERT INTO `contact_follow_ups` (`id`, `lead_id`, `type`, `date`, `notes`, `is_completed`, `created_at`, `updated_at`) VALUES
(7, 2, 'meeting', '2025-09-01 23:39:00', 'Manage qualified leads and track proposal engagement', '0', '2025-09-01 12:35:21', '2025-09-01 12:35:21'),
(8, 1, 'email', '2025-09-02 23:36:00', 'Manage qualified leads and track proposal engagement', '1', '2025-09-01 12:36:25', '2025-09-01 12:41:46');

-- --------------------------------------------------------

--
-- Table structure for table `emails`
--

CREATE TABLE `emails` (
  `id` bigint UNSIGNED NOT NULL,
  `template_id` bigint UNSIGNED DEFAULT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `recipient_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lead_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `emails`
--

INSERT INTO `emails` (`id`, `template_id`, `category`, `subject`, `body`, `recipient_email`, `type`, `lead_id`, `created_at`, `updated_at`) VALUES
(1, 4, NULL, 'test1', '<p>Hi {{name}},Welcome to our platform! We&rsquo;re glad to have you onboard.1</p>', 'mkbhardwa961@gmail.com', NULL, 5, '2025-08-21 15:02:39', '2025-08-21 15:02:39'),
(2, 4, NULL, 'test1', '<p>Hi {{name}},Welcome to our platform! We&rsquo;re glad to have you onboard.1</p>', 'rahul@yopmail.com', 'lead', 5, '2025-08-21 15:04:26', '2025-08-21 15:04:26'),
(3, 4, NULL, 'test1', '<p>Hi {{name}},Welcome to our platform! We&rsquo;re glad to have you onboard.1</p>', 'rahul@yopmail.com', 'lead', 4, '2025-08-21 15:07:49', '2025-08-21 15:07:49'),
(4, 4, NULL, 'test1', '<p>Hi {{name}},Welcome to our platform! We&rsquo;re glad to have you onboard.1</p>', 'rahul@yopmail.com', 'lead', 4, '2025-08-21 15:08:19', '2025-08-21 15:08:19'),
(5, 4, NULL, 'test1', '<p>Hi Shivam chauhan,Welcome to our platform! We&rsquo;re glad to have you onboard.1</p>', 'rahul@yopmail.com', 'lead', 4, '2025-08-21 15:13:36', '2025-08-21 15:13:36'),
(6, 4, NULL, 'test1', '<p><strong style=\"color:green\">Hi</strong> Test test,<em>Welcome to our platform! We&rsquo;re glad to have you <s>onboard</s>.1</em></p>', 'rahul@yopmail.com', 'lead', 1, '2025-08-22 03:11:08', '2025-08-22 03:11:08'),
(7, 4, NULL, 'test1', '<p><strong style=\"color:green\">Hi</strong> Test test,<em>Welcome to our platform! We&rsquo;re glad to have you <s>onboard</s>.1</em></p>', 'rahul@yopmail.com', 'lead', 1, '2025-08-22 03:11:24', '2025-08-22 03:11:24'),
(8, 5, NULL, 'Welcome email template', '<p><strong>Dear Soni Chauhan,</strong></p>\r\n\r\n<p><strong>I hope you&#39;re well! I wanted to reach out one more time regarding your solar proposal.</strong></p>\r\n\r\n<p><strong>The solar industry is moving fast, and I&#39;d hate for you to miss out on the current incentives available. Here&#39;s what&#39;s time-sensitive:</strong></p>\r\n\r\n<p><strong>🔥 Current government rebates expire soon<br />\r\n💰 Interest rates for solar financing are at historic lows<br />\r\n⚡ Electricity prices continue to rise</strong></p>\r\n\r\n<p><strong>Your custom proposal shows potential savings of $15,000 over the next 10 years. That&#39;s money that could stay in your pocket instead of going to the electricity company.</strong></p>\r\n\r\n<p><strong>I&#39;m available this week for a quick call to discuss any concerns and help you move forward with confidence.</strong></p>\r\n\r\n<p><strong>What questions can I answer for you?</strong></p>\r\n\r\n<p><strong>Best regards,<br />\r\nJohn Smith<br />\r\nSunline Energy</strong></p>', 'soni@yopmail.com', 'lead', 6, '2025-08-26 02:34:16', '2025-08-26 02:34:16'),
(9, 4, NULL, 'test1', '<p><strong style=\"color:green\">Hi</strong> Bhupendra Singh,<em>Welcome to our platform! We&rsquo;re glad to have you <s>onboard</s>.1</em></p>', 'shivam@yopmail.com', 'lead', 5, '2025-08-31 09:15:35', '2025-08-31 09:15:35'),
(10, 5, NULL, 'Welcome email template', '<p><strong>Dear Soni Chauhan,</strong></p>\r\n\r\n<p><strong>I hope you&#39;re well! I wanted to reach out one more time regarding your solar proposal.</strong></p>\r\n\r\n<p><strong>The solar industry is moving fast, and I&#39;d hate for you to miss out on the current incentives available. Here&#39;s what&#39;s time-sensitive:</strong></p>\r\n\r\n<p><strong>🔥 Current government rebates expire soon<br />\r\n💰 Interest rates for solar financing are at historic lows<br />\r\n⚡ Electricity prices continue to rise</strong></p>\r\n\r\n<p><strong>Your custom proposal shows potential savings of $15,000 over the next 10 years. That&#39;s money that could stay in your pocket instead of going to the electricity company.</strong></p>\r\n\r\n<p><strong>I&#39;m available this week for a quick call to discuss any concerns and help you move forward with confidence.</strong></p>\r\n\r\n<p><strong>What questions can I answer for you?</strong></p>\r\n\r\n<p><strong>Best regards,<br />\r\nJohn Smith<br />\r\nSunline Energy</strong></p>', 'soni@yopmail.com', 'lead', 6, '2025-09-01 12:58:53', '2025-09-01 12:58:53'),
(11, 4, NULL, 'test1', '<p><strong>Hi</strong> Soni Chauhan,<em>Welcome to our platform! We&rsquo;re glad to have you <s>onboard</s>.1</em></p>', 'soni@yopmail.com', 'lead', 6, '2025-09-01 13:03:26', '2025-09-01 13:03:26'),
(12, 5, NULL, 'Welcome email template custom', '<p><strong>Dear Soni Chauhan,</strong></p>\r\n\r\n<p><strong>I hope you&#39;re well! I wanted to reach out one more time regarding your solar proposal.</strong></p>\r\n\r\n<p><strong>The solar industry is moving fast, and I&#39;d hate for you to miss out on the current incentives available. Here&#39;s what&#39;s time-sensitive:</strong></p>\r\n\r\n<p><strong>🔥 Current government rebates expire soon<br />\r\n💰 Interest rates for solar financing are at historic lows<br />\r\n⚡ Electricity prices continue to rise</strong></p>\r\n\r\n<p><strong>Your custom proposal shows potential savings of $15,000 over the next 10 years. That&#39;s money that could stay in your pocket instead of going to the electricity company.</strong></p>\r\n\r\n<p><strong>I&#39;m available this week for a quick call to discuss any concerns and help you move forward with confidence.</strong></p>\r\n\r\n<p><strong>What questions can I answer for you?</strong></p>\r\n\r\n<p><strong>Best regards,<br />\r\nJohn Smith<br />\r\nSunline Energy</strong></p>', 'soni@yopmail.com', 'lead', 6, '2025-09-01 13:04:56', '2025-09-01 13:04:56'),
(13, 5, NULL, 'Welcome email template', '<p><strong>Dear Soni Chauhan,</strong></p>\r\n\r\n<p><strong>I hope you&#39;re well! I wanted to reach out one more time regarding your solar proposal.</strong></p>\r\n\r\n<p><strong>The solar industry is moving fast, and I&#39;d hate for you to miss out on the current incentives available. Here&#39;s what&#39;s time-sensitive:</strong></p>\r\n\r\n<p><strong>🔥 Current government rebates expire soon<br />\r\n💰 Interest rates for solar financing are at historic lows<br />\r\n⚡ Electricity prices continue to rise</strong></p>\r\n\r\n<p><strong>Your custom proposal shows potential savings of $15,000 over the next 10 years. That&#39;s money that could stay in your pocket instead of going to the electricity company.</strong></p>\r\n\r\n<p><strong>I&#39;m available this week for a quick call to discuss any concerns and help you move forward with confidence.</strong></p>\r\n\r\n<p><strong>What questions can I answer for you?</strong></p>\r\n\r\n<p><strong>Best regards,<br />\r\nJohn Smith<br />\r\nSunline Energy</strong></p>', 'soni@yopmail.com', 'lead', 6, '2025-09-01 13:06:27', '2025-09-01 13:06:27'),
(14, 5, NULL, 'Welcome email template', '<p><strong>Dear Soni Chauhan,</strong></p>\r\n\r\n<p><strong>I hope you&#39;re well! I wanted to reach out one more time regarding your solar proposal.</strong></p>\r\n\r\n<p><strong>The solar industry is moving fast, and I&#39;d hate for you to miss out on the current incentives available. Here&#39;s what&#39;s time-sensitive:</strong></p>\r\n\r\n<p><strong>🔥 Current government rebates expire soon<br />\r\n💰 Interest rates for solar financing are at historic lows<br />\r\n⚡ Electricity prices continue to rise</strong></p>\r\n\r\n<p><strong>Your custom proposal shows potential savings of $15,000 over the next 10 years. That&#39;s money that could stay in your pocket instead of going to the electricity company.</strong></p>\r\n\r\n<p><strong>I&#39;m available this week for a quick call to discuss any concerns and help you move forward with confidence.</strong></p>\r\n\r\n<p><strong>What questions can I answer for you?</strong></p>\r\n\r\n<p><strong>Best regards,<br />\r\nJohn Smith<br />\r\nSunline Energy</strong></p>', 'soni@yopmail.com', 'lead', 6, '2025-09-01 13:07:12', '2025-09-01 13:07:12'),
(15, 5, NULL, 'Welcome email template', '<p><strong>Dear Soni Chauhan,</strong></p>\r\n\r\n<p><strong>I hope you&#39;re well! I wanted to reach out one more time regarding your solar proposal.</strong></p>\r\n\r\n<p><strong>The solar industry is moving fast, and I&#39;d hate for you to miss out on the current incentives available. Here&#39;s what&#39;s time-sensitive:</strong></p>\r\n\r\n<p><strong>🔥 Current government rebates expire soon<br />\r\n💰 Interest rates for solar financing are at historic lows<br />\r\n⚡ Electricity prices continue to rise</strong></p>\r\n\r\n<p><strong>Your custom proposal shows potential savings of $15,000 over the next 10 years. That&#39;s money that could stay in your pocket instead of going to the electricity company.</strong></p>\r\n\r\n<p><strong>I&#39;m available this week for a quick call to discuss any concerns and help you move forward with confidence.</strong></p>\r\n\r\n<p><strong>What questions can I answer for you?</strong></p>\r\n\r\n<p><strong>Best regards,<br />\r\nJohn Smith<br />\r\nSunline Energy</strong></p>', 'soni@yopmail.com', 'lead', 6, '2025-09-01 13:07:43', '2025-09-01 13:07:43');

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

CREATE TABLE `email_templates` (
  `id` bigint UNSIGNED NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `lead_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_templates`
--

INSERT INTO `email_templates` (`id`, `category`, `subject`, `body`, `status`, `lead_status`, `created_at`, `updated_at`) VALUES
(4, 'Follow-up', 'test1', '<p><strong>Hi</strong> {name},<em>Welcome to our platform! We&rsquo;re glad to have you <s>onboard</s>.1</em></p>', 'Active', NULL, '2025-08-20 06:06:32', '2025-08-21 15:28:55'),
(8, 'Welcome', 'Welcome email template 1', '<p>Welcome email template 1&nbsp;{address}</p>', 'Active', '1st Attempt', '2025-09-03 02:59:02', '2025-09-03 04:31:35');

-- --------------------------------------------------------

--
-- Table structure for table `fris`
--

CREATE TABLE `fris` (
  `id` bigint UNSIGNED NOT NULL,
  `lead_id` int DEFAULT NULL,
  `project` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `priority` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `assigned_to` bigint UNSIGNED DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fris`
--

INSERT INTO `fris` (`id`, `lead_id`, `project`, `client`, `status`, `category`, `priority`, `due_date`, `assigned_to`, `subject`, `description`, `created_by`, `created_at`, `updated_at`) VALUES
(6, NULL, 'Project 1', 'Client 1', 'Under Review', 'Compliance', 'High', '2025-08-18', 2, 'TEST', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock,', 1, '2025-08-18 04:46:07', '2025-08-25 05:27:49'),
(7, NULL, 'Project 2', 'Client 2', 'In Progress', 'Design', 'High', '2025-08-20', 2, 'TEST ok', 'ffffffffffffffffffffffff ok', 1, '2025-08-18 04:55:14', '2025-08-25 05:27:39'),
(8, 4, NULL, NULL, 'Open', 'Design', 'Medium', '2025-08-31', 3, 'Welcome email template 1', 'zxczxc', 1, '2025-08-30 14:33:28', '2025-08-30 14:49:12');

-- --------------------------------------------------------

--
-- Table structure for table `fri_images`
--

CREATE TABLE `fri_images` (
  `id` bigint UNSIGNED NOT NULL,
  `fri_id` bigint UNSIGNED NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Afrikaans', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(2, 'Albanian', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(3, 'Arabic', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(4, 'Azerbaijani', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(5, 'Basque', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(6, 'Belarusian', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(7, 'Bengali', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(8, 'Bulgarian', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(9, 'Catalan', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(10, 'Chinese (Hong Kong)', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(11, 'Chinese (Simplified)', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(12, 'Chinese (Traditional)', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(13, 'Croatian', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(14, 'Czech', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(15, 'Danish', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(16, 'Dutch', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(17, 'English', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(18, 'Esperanto', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(19, 'Estonian', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(20, 'Filipino', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(21, 'Finnish', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(22, 'French', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(23, 'Galician', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(24, 'Georgian', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(25, 'German', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(26, 'Greek', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(27, 'Gujarati', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(28, 'Haitian Creole', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(29, 'Hebrew', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(30, 'Hindi', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(31, 'Hungarain', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(32, 'Icelandic', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(33, 'Indonesian', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(34, 'Irish', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(35, 'Italian', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(36, 'Japanese', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(37, 'Kannada', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(38, 'Korean', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(39, 'Laothian', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(40, 'Latin', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(41, 'Latvian', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(42, 'Lithuanian', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(43, 'Macedonian', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(44, 'Malay', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(45, 'Malayalam', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(46, 'Maltese', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(47, 'Marathi', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(48, 'Mongolian', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(49, 'Norwegian', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(50, 'Persian', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(51, 'Polish', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(52, 'Portuguese', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(53, 'Romanian', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(54, 'Russian', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(55, 'Serbian', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(56, 'Slovak', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(57, 'Slovenian', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(58, 'Spanish', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(59, 'Swahili', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(60, 'Swedish', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(61, 'Tamil', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(62, 'Telugu', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(63, 'Thai', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(64, 'Turkish', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(65, 'Ukrainian', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(66, 'Urdu', '2025-08-12 08:55:44', '2025-08-12 08:55:44', NULL),
(67, 'Vietnamese', '2025-08-12 08:55:45', '2025-08-12 08:55:45', NULL),
(68, 'Welsh', '2025-08-12 08:55:45', '2025-08-12 08:55:45', NULL),
(69, 'Yiddish', '2025-08-12 08:55:45', '2025-08-12 08:55:45', NULL),
(70, 'Zulu', '2025-08-12 08:55:45', '2025-08-12 08:55:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `leads`
--

CREATE TABLE `leads` (
  `id` bigint UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assign_rep` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lead_source` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `roof_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `elogible_for_rebate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'New',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leads`
--

INSERT INTO `leads` (`id`, `first_name`, `last_name`, `email`, `phone`, `address`, `assign_rep`, `lead_source`, `roof_type`, `elogible_for_rebate`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Test', 'test', 'rahul@yopmail.com', '06395897674', 'sadsa', '2', '1', 'pitched', 'No', 'New', '2025-08-14 07:15:45', '2025-08-14 07:15:45'),
(2, 'Rahul', 'Kumar', 'mkbhardwa961@gmail.com', '09758463790', 'Address1', '2', '1', 'pitched', 'Yes', 'New', '2025-08-14 09:01:02', '2025-08-14 09:01:02'),
(3, 'bvhvbv', 'hkjhkj', 'mkbhardwa961@gmail.com', '06395897674', 'Vill-Nawada, rtert', '2', '1', NULL, 'Yes', 'New', '2025-08-14 09:02:13', '2025-08-14 09:02:13'),
(4, 'Shivam', 'chauhan', 'shivam@yopmail.com', '06395897674', '1818 phase 5 mohali', '2', '1', 'pitched', 'Yes', '1st Attempt', '2025-08-16 08:52:29', '2025-08-22 03:27:55'),
(5, 'Bhupendra', 'Singh', 'mkbhardwa961@gmail.com', '08527327806', 'Goverdhanpur', '2', '1', 'hipped', 'No', 'Qualified', '2025-08-16 09:04:56', '2025-08-31 02:19:15'),
(6, 'Soni', 'Chauhan', 'soni@yopmail.com', '989989898989', '188 Phase 5 mohali', '2', '1', 'pitched', 'Yes', 'Qualified', '2025-08-25 02:01:07', '2025-08-31 01:50:16');

-- --------------------------------------------------------

--
-- Table structure for table `lead_contacts`
--

CREATE TABLE `lead_contacts` (
  `id` bigint UNSIGNED NOT NULL,
  `lead_id` bigint UNSIGNED NOT NULL,
  `property` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phase` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `switchboard` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bill_size` decimal(10,2) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lead_contacts`
--

INSERT INTO `lead_contacts` (`id`, `lead_id`, `property`, `phase`, `switchboard`, `bill_size`, `price`, `status`, `created_at`) VALUES
(1, 6, 'fdsf', 'dfs', 'dsfsdf', '34.00', '3432432.00', 'pending', '2025-08-31 01:50:16'),
(2, 5, '5-Story', 'Single Phase', 'New', '45.00', '399.00', 'pending', '2025-08-31 02:19:15');

-- --------------------------------------------------------

--
-- Table structure for table `lead_follow_ups`
--

CREATE TABLE `lead_follow_ups` (
  `id` bigint UNSIGNED NOT NULL,
  `lead_id` bigint UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `is_completed` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lead_follow_ups`
--

INSERT INTO `lead_follow_ups` (`id`, `lead_id`, `type`, `date`, `notes`, `is_completed`, `created_at`, `updated_at`) VALUES
(1, 5, 'call', '2025-08-18 10:30:00', 'TESTING', '0', '2025-08-17 23:35:29', '2025-08-17 23:35:29'),
(2, 5, 'meeting', '2025-08-21 10:50:00', 'Test notes', '1', '2025-08-17 23:45:10', '2025-08-19 02:53:16'),
(3, 4, 'meeting', '2025-08-15 14:51:00', '14 lead followups', '0', '2025-08-17 23:52:00', '2025-08-17 23:52:00'),
(4, 3, 'email', '2025-08-21 10:59:00', '#3 follow ups', '1', '2025-08-17 23:56:40', '2025-08-19 02:53:21'),
(5, 5, 'call', '2025-08-12 11:03:00', 'Net  das d  a d  a d as d  as dd  asdf d  as d  asf', '0', '2025-08-18 00:01:00', '2025-08-18 00:01:00'),
(6, 4, 'meeting', '2025-08-23 13:00:00', 'Tsts followup please update here', '1', '2025-08-19 02:55:15', '2025-08-19 02:58:13'),
(7, 6, 'meeting', '2025-08-31 01:50:00', 'test today', '1', '2025-08-30 14:50:40', '2025-08-30 14:50:51');

-- --------------------------------------------------------

--
-- Table structure for table `lead_sources`
--

CREATE TABLE `lead_sources` (
  `id` bigint UNSIGNED NOT NULL,
  `source` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lead_sources`
--

INSERT INTO `lead_sources` (`id`, `source`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Sunline', '1', NULL, '2025-08-13 08:14:33'),
(5, 'Airtel', '1', '2025-08-13 08:03:16', '2025-08-13 08:03:16');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_resets_table', 1),
(2, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(3, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(4, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(5, '2016_06_01_000004_create_oauth_clients_table', 1),
(6, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(7, '2019_09_13_000000_create_permissions_table', 1),
(8, '2019_09_13_000001_create_roles_table', 1),
(9, '2019_09_13_000002_create_users_table', 1),
(10, '2019_09_13_000007_create_permission_role_pivot_table', 1),
(11, '2019_09_13_000008_create_role_user_pivot_table', 1),
(12, '2025_03_31_150646_create_contact_marital_status_table', 1),
(13, '2025_03_31_150646_create_contact_prefixes_table', 1),
(14, '2025_03_31_150646_create_contact_types_table', 1),
(15, '2025_03_31_150646_create_languages_table', 1),
(16, '2025_03_31_150647_create_contacts_table', 1),
(17, '2025_03_31_150648_create_activity_types_table', 1),
(18, '2025_03_31_150648_create_case_roles_table', 1),
(19, '2025_03_31_150648_create_case_types_table', 1),
(20, '2025_03_31_150648_create_lead_call_outcomes_table', 1),
(21, '2025_03_31_150648_create_lead_status_table', 1),
(22, '2025_03_31_150650_create_intakes_table', 1),
(23, '2025_03_31_150747_create_lead_key_date_types_table', 1),
(24, '2025_04_01_140619_create_intake_values', 1),
(25, '2025_04_15_164735_create_intake_contacts_table', 1),
(26, '2025_04_16_164840_create_lead_key_dates_table', 1),
(27, '2025_04_17_153914_create_lead_case_roles_table', 1),
(28, '2025_04_18_125715_create_address_types_table', 1),
(29, '2025_04_18_140848_create_activity_table', 1),
(30, '2025_04_18_140957_create_address_table', 1),
(31, '2025_04_18_143026_create_contact_address_table', 1),
(32, '2025_04_21_130948_create_form_question_answers_table', 1),
(33, '2025_04_22_194438_create_notes_category_table', 1),
(34, '2025_04_22_194439_create_lead_notes_table', 1),
(35, '2025_04_23_194438_create_task_types_table', 1),
(36, '2025_04_23_194438_create_tasks_category_table', 1),
(37, '2025_04_23_194439_create_lead_tasks_table', 1),
(38, '2025_04_28_133816_create_firm_types_table', 1),
(39, '2025_04_28_142328_create_firm_referral_status_table', 1),
(40, '2025_04_28_142411_create_firm_override_types_table', 1),
(41, '2025_04_28_142415_create_firm_table', 1),
(42, '2025_04_28_142442_create_lead_firms_table', 1),
(43, '2025_04_29_152733_create_cost_types_table', 1),
(44, '2025_04_29_152819_create_expense_category_table', 1),
(45, '2025_04_29_152924_create_document_category_table', 1),
(46, '2025_04_29_152930_create_document_folder_table', 1),
(47, '2025_04_29_152942_create_document_path_table', 1),
(48, '2025_04_29_153015_create_lead_expenses_table', 1),
(49, '2025_04_29_153128_create_e_sign_documents_table', 1),
(50, '2025_04_29_153148_create_e_sign_document_status_table', 1),
(51, '2025_05_02_132142_create_documents_table', 1),
(52, '2025_05_02_134163_create_document_print_queues_table', 1),
(53, '2025_05_22_171131_create_event_status_types_table', 1),
(54, '2025_05_22_171132_create_event_type_colors_table', 1),
(55, '2025_05_22_171132_create_event_types_table', 1),
(56, '2025_05_22_171132_create_lead_events_table', 1),
(57, '2025_06_05_080730_add_all_day_to_lead_events_table', 1),
(58, '2025_06_05_220650_create_appointment_settings_table', 1),
(59, '2025_06_10_070553_create_event_type_rules_table', 1),
(60, '2025_06_11_171804_create_email_status_table', 1),
(61, '2025_06_11_171815_create_texts_status_table', 1),
(62, '2025_06_11_171825_create_campaign_types_table', 1),
(63, '2025_06_11_171920_create_lead_communication_emails_table', 1),
(64, '2025_06_11_171920_create_lead_communication_texts_table', 1),
(65, '2025_06_16_164055_create_calendar_share_users_table', 1),
(66, '2025_06_17_070317_create_jobs_table', 1),
(67, '2025_08_07_191001_create_tags_table', 1),
(68, '2025_08_07_191002_create_email_campaigns_table', 1),
(69, '2025_08_13_123835_create_leas_sources_table', 2),
(70, '2025_08_14_122229_create_leads_table', 3),
(72, '2025_08_16_093340_create_lead_follo_ups_table', 4),
(73, '2025_08_18_061338_create_fris_table', 5),
(74, '2025_08_18_063302_status', 6),
(75, '2025_08_20_065414_create_email_templates_table', 7),
(76, '2025_08_21_201518_create_emails_table', 8),
(78, '2025_08_22_124555_create_tasks_table', 9),
(79, '2025_08_26_082630_create_tickets_table', 10),
(80, '2025_09_03_102200_create_api_logs_table', 11),
(81, '2025_09_03_181246_create_webhooks_table', 12);

-- --------------------------------------------------------

--
-- Table structure for table `notes_category`
--

CREATE TABLE `notes_category` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notes_category`
--

INSERT INTO `notes_category` (`id`, `title`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Accounting', '2025-08-12 08:55:46', '2025-08-12 08:55:46', NULL),
(2, 'Administrative', '2025-08-12 08:55:46', '2025-08-12 08:55:46', NULL),
(3, 'Alternate Contact', '2025-08-12 08:55:46', '2025-08-12 08:55:46', NULL),
(4, 'Appeal', '2025-08-12 08:55:46', '2025-08-12 08:55:46', NULL),
(5, 'Arbitration', '2025-08-12 08:55:46', '2025-08-12 08:55:46', NULL),
(6, 'Bankruptcy', '2025-08-12 08:55:46', '2025-08-12 08:55:46', NULL),
(7, 'Campaign', '2025-08-12 08:55:46', '2025-08-12 08:55:46', NULL),
(8, 'Client Communication', '2025-08-12 08:55:46', '2025-08-12 08:55:46', NULL),
(9, 'Data Support', '2025-08-12 08:55:46', '2025-08-12 08:55:46', NULL),
(10, 'Discovery', '2025-08-12 08:55:46', '2025-08-12 08:55:46', NULL),
(11, 'Documents', '2025-08-12 08:55:46', '2025-08-12 08:55:46', NULL),
(12, 'Expert', '2025-08-12 08:55:46', '2025-08-12 08:55:46', NULL),
(13, 'Follow Up', '2025-08-12 08:55:46', '2025-08-12 08:55:46', NULL),
(14, 'Insurance', '2025-08-12 08:55:46', '2025-08-12 08:55:46', NULL),
(15, 'Intake', '2025-08-12 08:55:46', '2025-08-12 08:55:46', NULL),
(16, 'Judge', '2025-08-12 08:55:46', '2025-08-12 08:55:46', NULL),
(17, 'Mediation', '2025-08-12 08:55:46', '2025-08-12 08:55:46', NULL),
(18, 'Medical', '2025-08-12 08:55:46', '2025-08-12 08:55:46', NULL),
(19, 'PFS', '2025-08-12 08:55:46', '2025-08-12 08:55:46', NULL),
(20, 'PID', '2025-08-12 08:55:46', '2025-08-12 08:55:46', NULL),
(21, 'Pretrial', '2025-08-12 08:55:46', '2025-08-12 08:55:46', NULL),
(22, 'Probate', '2025-08-12 08:55:46', '2025-08-12 08:55:46', NULL),
(23, 'Ranking', '2025-08-12 08:55:46', '2025-08-12 08:55:46', NULL),
(24, 'Referred', '2025-08-12 08:55:46', '2025-08-12 08:55:46', NULL),
(25, 'Settlements', '2025-08-12 08:55:46', '2025-08-12 08:55:46', NULL),
(26, 'SOL', '2025-08-12 08:55:46', '2025-08-12 08:55:46', NULL),
(27, 'Treatment', '2025-08-12 08:55:46', '2025-08-12 08:55:46', NULL),
(28, 'Trial', '2025-08-12 08:55:46', '2025-08-12 08:55:46', NULL),
(29, 'Voice Memo', '2025-08-12 08:55:46', '2025-08-12 08:55:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `client_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
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
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `client_id` bigint UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `id` bigint UNSIGNED NOT NULL,
  `client_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `title`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'user_management_access', '2019-09-13 13:51:30', '2019-09-13 13:51:30', NULL),
(2, 'permission_create', '2019-09-13 13:51:30', '2019-09-13 13:51:30', NULL),
(3, 'permission_edit', '2019-09-13 13:51:30', '2019-09-13 13:51:30', NULL),
(4, 'permission_show', '2019-09-13 13:51:30', '2019-09-13 13:51:30', NULL),
(5, 'permission_delete', '2019-09-13 13:51:30', '2019-09-13 13:51:30', NULL),
(6, 'permission_access', '2019-09-13 13:51:30', '2019-09-13 13:51:30', NULL),
(7, 'role_create', '2019-09-13 13:51:30', '2019-09-13 13:51:30', NULL),
(8, 'role_edit', '2019-09-13 13:51:30', '2019-09-13 13:51:30', NULL),
(9, 'role_show', '2019-09-13 13:51:30', '2019-09-13 13:51:30', NULL),
(10, 'role_delete', '2019-09-13 13:51:30', '2019-09-13 13:51:30', NULL),
(11, 'role_access', '2019-09-13 13:51:30', '2019-09-13 13:51:30', NULL),
(12, 'user_create', '2019-09-13 13:51:30', '2019-09-13 13:51:30', NULL),
(13, 'user_edit', '2019-09-13 13:51:30', '2019-09-13 13:51:30', NULL),
(14, 'user_show', '2019-09-13 13:51:30', '2019-09-13 13:51:30', NULL),
(15, 'user_delete', '2019-09-13 13:51:30', '2019-09-13 13:51:30', NULL),
(16, 'user_access', '2019-09-13 13:51:30', '2019-09-13 13:51:30', NULL),
(77, 'abc', '2025-08-13 01:47:38', '2025-08-13 01:49:35', '2025-08-13 01:49:35'),
(78, 'dfdsf', '2025-08-13 01:49:41', '2025-08-13 01:49:46', '2025-08-13 01:49:46'),
(79, 'lead_access', '2025-08-13 03:16:43', '2025-08-13 03:16:43', NULL),
(80, 'leadSource_access', '2025-08-13 07:48:14', '2025-08-13 07:48:14', NULL),
(81, 'leadSource_add', '2025-08-13 07:48:22', '2025-08-13 07:48:22', NULL),
(82, 'leadSource_edit', '2025-08-13 07:48:28', '2025-08-13 07:48:28', NULL),
(83, 'leadSource_delete', '2025-08-13 07:48:37', '2025-08-13 07:48:37', NULL),
(84, 'webhook_access', '2025-09-03 12:54:25', '2025-09-03 12:54:25', NULL),
(85, 'create_webhook', '2025-09-03 12:54:44', '2025-09-03 12:54:44', NULL),
(86, 'edit_webhook', '2025-09-03 12:54:53', '2025-09-03 12:54:53', NULL),
(87, 'delete_webhook', '2025-09-03 12:55:03', '2025-09-03 12:55:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `role_id` int UNSIGNED NOT NULL,
  `permission_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`role_id`, `permission_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(1, 14),
(1, 15),
(1, 16),
(1, 79),
(4, 1),
(4, 2),
(4, 3),
(4, 4),
(4, 5),
(4, 6),
(4, 7),
(4, 8),
(4, 9),
(4, 10),
(4, 11),
(4, 12),
(4, 13),
(4, 14),
(4, 15),
(4, 16),
(4, 79),
(1, 80),
(1, 81),
(1, 82),
(1, 83),
(1, 84),
(1, 85),
(1, 86),
(1, 87);

-- --------------------------------------------------------

--
-- Table structure for table `priorities`
--

CREATE TABLE `priorities` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `priorities`
--

INSERT INTO `priorities` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Low', '1', NULL, NULL),
(2, 'Medium', '1', NULL, NULL),
(3, 'High', '1', NULL, NULL),
(4, 'Critical', '1', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rfi_replies`
--

CREATE TABLE `rfi_replies` (
  `ticket_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `reply` text NOT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'ticket',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `title`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', '2019-09-13 13:45:46', '2019-09-13 13:45:46', NULL),
(4, 'User', '2025-08-13 05:27:58', '2025-08-13 05:27:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `user_id` int UNSIGNED NOT NULL,
  `role_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`user_id`, `role_id`) VALUES
(1, 1),
(2, 4),
(3, 4),
(9, 4),
(10, 4),
(11, 4);

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE `statuses` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`id`, `name`, `color`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Open', 'info', '1', NULL, NULL),
(2, 'In Progress', 'warning', '1', NULL, NULL),
(3, 'Under Review', 'review', '1', NULL, NULL),
(4, 'Closed', 'success', '1', NULL, NULL),
(5, 'Cancelled', NULL, '1', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Optional color hex or class for tag display',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` bigint UNSIGNED NOT NULL,
  `lead` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `assigned_to` int UNSIGNED DEFAULT NULL,
  `due_date` datetime DEFAULT NULL,
  `priority` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `task_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `lead`, `description`, `status`, `assigned_to`, `due_date`, `priority`, `task_type`, `created_at`, `updated_at`) VALUES
(4, '1', 'New lead #00n ffdbjfldf', 'Completed', 3, '2025-08-25 15:55:00', 'High', 'Meeting', '2025-08-25 02:54:31', '2025-08-25 04:55:55'),
(7, '4', 'Got it 👍\r\nYour code is almost correct, but you should use Carbon::today() instead of now() for comparing dates, because now() includes the time as well, which may cause mismatches.', 'Completed', 2, '2025-08-25 13:32:00', 'Low', 'Follow-up', '2025-08-25 05:01:04', '2025-08-26 02:33:02');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `urgency_label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assign_to` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('responded','open','closed') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'open',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `user_id`, `subject`, `category`, `urgency_label`, `assign_to`, `description`, `status`, `created_at`, `updated_at`) VALUES
(4, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam cursus nisl loborti', 'Technical Issue', 'Low', '3', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam cursus nisl lobortis quam tempor, sed convallis mauris tempor. Aliquam erat volutpat. Nulla ac tortor interdum, bibendum enim id, facilisis dui. Donec et metus diam. Duis et nulla varius, cursus turpis nec, scelerisque dolor. Praesent enim quam, pretium vitae mollis ut, eleifend a sem. In nec velit felis. Praesent convallis tortor ac scelerisque fermentum.', 'responded', '2025-08-26 14:19:13', '2025-08-28 03:06:27'),
(5, 1, 'Welcome email template 1 555 yyyyyyyy', 'Scheduling', 'High', '3', 'Welcome email template 1 yyyyyyyyyyy', 'open', '2025-08-26 14:20:46', '2025-08-28 03:06:14'),
(6, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam cursus nisl loborti', 'Product Question', 'High', '3', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam cursus nisl loborti  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam cursus nisl loborti  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam cursus nisl loborti', 'open', '2025-08-27 03:11:57', '2025-08-27 03:11:57');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_replies`
--

CREATE TABLE `ticket_replies` (
  `id` bigint UNSIGNED NOT NULL,
  `ticket_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `reply` text NOT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'ticket',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ticket_replies`
--

INSERT INTO `ticket_replies` (`id`, `ticket_id`, `user_id`, `reply`, `attachment`, `type`, `created_at`) VALUES
(24, 7, 1, 'tetes', NULL, 'ticket', '2025-08-30 14:00:03'),
(25, 7, 1, 'hello fri', NULL, 'rfi', '2025-08-30 14:01:48'),
(26, 7, 1, 'dgsdg', 'uploads/ticket_replies/1756582649_moneda.gif', 'rfi', '2025-08-30 14:07:29'),
(27, 6, 1, 'Hello tk', NULL, 'ticket', '2025-08-30 14:10:21'),
(28, 7, 1, 'dfsdf', NULL, 'rfi', '2025-08-30 14:10:52');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` datetime DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `last_name`, `phone`, `address`, `link`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Sunline Energy', NULL, NULL, NULL, NULL, 'admin@admin.com', NULL, '$2y$10$XWNsIBYqIoNbO4SFIFTHgecufz5N9vI9MIzs1CxrM6aOBow/hh48W', NULL, '2019-09-13 13:51:30', '2025-09-03 02:37:02', NULL),
(2, 'User', NULL, NULL, NULL, NULL, 'user@ymail.com', NULL, '$2y$10$tGIymDNcV8Ecrqm3a4FRPuikK89O7iom1NsdpOY47mNgYFqZ8K1UW', NULL, '2025-08-12 23:16:07', '2025-08-12 23:16:07', NULL),
(3, 'Soni', NULL, NULL, NULL, NULL, 'newuser@yopmail.com', NULL, '$2y$10$.o.le18AO6.z/Qu0HiRoTeDzz5j.BT.m/Q4EQcLXWnqsjFaRQLo1S', NULL, '2025-08-13 00:23:52', '2025-08-25 04:00:50', NULL),
(8, 'Kapil', NULL, NULL, NULL, NULL, 'admin@admin.com', NULL, '$2y$10$MxX6kKznF.tZ8.bQRxTdPOt8qicV2QQC/5K9bPq9W/bYq2OgYijoW', NULL, '2025-09-03 02:19:57', '2025-09-03 02:22:24', '2025-09-03 02:22:24'),
(9, 'Kapil', NULL, NULL, NULL, NULL, 'admin@admin.com', NULL, '$2y$10$4hOt3WERfEyDlkNxOskpXeULR4qRUONGeqDnDZ4ALwZtFvViqWyIC', NULL, '2025-09-03 02:22:13', '2025-09-03 02:22:22', '2025-09-03 02:22:22'),
(10, 'kapil', NULL, NULL, NULL, NULL, 'kap@yopmail.com', NULL, '$2y$10$mSjRnsyitOJfcHf8YXhYKOntorpMc9MNHPk8CDbPwHaruqV30FUBm', NULL, '2025-09-03 02:23:08', '2025-09-03 02:23:08', NULL),
(11, 'Sonu Chauhan', NULL, '072538247594', '1626 phase 5 mohali', 'kap123332', 'sonu@yopmail.com', NULL, '$2y$10$VZDiC7P6aHBWAefLJrqr.OTDF9cbG9QHqr9LDUtbhwvjj7xdjGPgW', NULL, '2025-09-03 02:29:11', '2025-09-04 00:56:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `webhooks`
--

CREATE TABLE `webhooks` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'POST',
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bearer_token` text COLLATE utf8mb4_unicode_ci,
  `body` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `webhooks`
--

INSERT INTO `webhooks` (`id`, `name`, `method`, `url`, `bearer_token`, `body`, `status`, `created_at`, `updated_at`) VALUES
(6, 'Dummy', 'POST', 'https://httpbin.org/post', NULL, '{\r\n    \"first_name\": \"first_name\",\r\n    \"last_name\": \"last_name\",\r\n    \"email\": \"email\",\r\n    \"phone\": \"phone\",\r\n    \"address\": \"address\"\r\n}', 'Active', '2025-09-03 14:50:56', '2025-09-03 15:53:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_intake_id_foreign` (`intake_id`),
  ADD KEY `activity_activity_type_id_foreign` (`activity_type_id`),
  ADD KEY `activity_client_id_foreign` (`client_id`),
  ADD KEY `activity_user_id_foreign` (`user_id`),
  ADD KEY `activity_module_index` (`module`);

--
-- Indexes for table `activity_types`
--
ALTER TABLE `activity_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `api_logs`
--
ALTER TABLE `api_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category_name_unique` (`name`);

--
-- Indexes for table `contact_follow_ups`
--
ALTER TABLE `contact_follow_ups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tick2_ibfk_1_2_r` (`lead_id`);

--
-- Indexes for table `emails`
--
ALTER TABLE `emails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_templates`
--
ALTER TABLE `email_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fris`
--
ALTER TABLE `fris`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fri_images`
--
ALTER TABLE `fri_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fri_images_fri_id_foreign` (`fri_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leads`
--
ALTER TABLE `leads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lead_contacts`
--
ALTER TABLE `lead_contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lead_contacts_lead_id_foreign` (`lead_id`);

--
-- Indexes for table `lead_follow_ups`
--
ALTER TABLE `lead_follow_ups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tick_ibfk_1_2_r` (`lead_id`);

--
-- Indexes for table `lead_sources`
--
ALTER TABLE `lead_sources`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notes_category`
--
ALTER TABLE `notes_category`
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
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD KEY `role_id_fk_334959` (`role_id`),
  ADD KEY `permission_id_fk_334959` (`permission_id`);

--
-- Indexes for table `priorities`
--
ALTER TABLE `priorities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `priority_name_unique` (`name`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD KEY `user_id_fk_334968` (`user_id`),
  ADD KEY `role_id_fk_334968` (`role_id`);

--
-- Indexes for table `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `status_name_unique` (`name`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tags_name_unique` (`name`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assigned_to` (`assigned_to`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_taskfhdfh` (`user_id`);

--
-- Indexes for table `ticket_replies`
--
ALTER TABLE `ticket_replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user__fk` (`ticket_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `webhooks`
--
ALTER TABLE `webhooks`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `activity_types`
--
ALTER TABLE `activity_types`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT for table `api_logs`
--
ALTER TABLE `api_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contact_follow_ups`
--
ALTER TABLE `contact_follow_ups`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `emails`
--
ALTER TABLE `emails`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `email_templates`
--
ALTER TABLE `email_templates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `fris`
--
ALTER TABLE `fris`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `fri_images`
--
ALTER TABLE `fri_images`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `leads`
--
ALTER TABLE `leads`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `lead_contacts`
--
ALTER TABLE `lead_contacts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `lead_follow_ups`
--
ALTER TABLE `lead_follow_ups`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `lead_sources`
--
ALTER TABLE `lead_sources`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `notes_category`
--
ALTER TABLE `notes_category`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `priorities`
--
ALTER TABLE `priorities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ticket_replies`
--
ALTER TABLE `ticket_replies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `webhooks`
--
ALTER TABLE `webhooks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity`
--
ALTER TABLE `activity`
  ADD CONSTRAINT `activity_activity_type_id_foreign` FOREIGN KEY (`activity_type_id`) REFERENCES `activity_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `activity_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `contacts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `activity_intake_id_foreign` FOREIGN KEY (`intake_id`) REFERENCES `intakes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `activity_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `contact_follow_ups`
--
ALTER TABLE `contact_follow_ups`
  ADD CONSTRAINT `tick2_ibfk_1_2_r` FOREIGN KEY (`lead_id`) REFERENCES `lead_contacts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `fri_images`
--
ALTER TABLE `fri_images`
  ADD CONSTRAINT `fri_images_fri_id_foreign` FOREIGN KEY (`fri_id`) REFERENCES `fris` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lead_contacts`
--
ALTER TABLE `lead_contacts`
  ADD CONSTRAINT `lead_contacts_lead_id_foreign` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lead_follow_ups`
--
ALTER TABLE `lead_follow_ups`
  ADD CONSTRAINT `tick_ibfk_1_2_r` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_id_fk_334959` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_id_fk_334959` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_id_fk_334968` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_id_fk_334968` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `fk_task` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `fk_taskfhdfh` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
