-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 08, 2016 at 06:10 AM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tenposs_dev`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE IF NOT EXISTS `addresses` (
  `id` int(10) unsigned NOT NULL,
  `latitude` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `longitude` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tel` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `store_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_contacts`
--

CREATE TABLE IF NOT EXISTS `admin_contacts` (
`id` int(10) unsigned NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `apps`
--

CREATE TABLE IF NOT EXISTS `apps` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `created_time` timestamp NULL DEFAULT NULL,
  `status` smallint(6) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `app_settings`
--

CREATE TABLE IF NOT EXISTS `app_settings` (
`id` int(10) unsigned NOT NULL,
  `store_id` int(10) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title_color` varchar(9) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `font_size` smallint(6) NOT NULL,
  `font_family` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `header_color` varchar(9) COLLATE utf8_unicode_ci DEFAULT NULL,
  `menu_icon_color` varchar(9) COLLATE utf8_unicode_ci DEFAULT NULL,
  `menu_background_color` varchar(9) COLLATE utf8_unicode_ci DEFAULT NULL,
  `menu_font_color` varchar(9) COLLATE utf8_unicode_ci DEFAULT NULL,
  `menu_font_size` smallint(6) DEFAULT NULL,
  `menu_font_family` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `template_id` int(10) unsigned NOT NULL,
  `top_main_image_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `app_stores`
--

CREATE TABLE IF NOT EXISTS `app_stores` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `store_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `app_users`
--

CREATE TABLE IF NOT EXISTS `app_users` (
  `id` int(10) unsigned NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `social_type` smallint(6) NOT NULL,
  `social_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `app_id` int(10) unsigned NOT NULL,
  `temporary_hash` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `android_push_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `apple_push_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `role` smallint(5) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `components`
--

CREATE TABLE IF NOT EXISTS `components` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE IF NOT EXISTS `coupons` (
  `id` int(10) unsigned NOT NULL,
  `type` smallint(6) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` smallint(6) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `store_id` int(10) unsigned DEFAULT NULL,
  `image_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `limit` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
`id` int(10) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `coupon_id` int(10) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE IF NOT EXISTS `menus` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `store_id` int(10) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2016_07_27_154926_create_user_sessions_table', 1),
('2016_07_27_155521_create_addresses_table', 1),
('2016_07_30_114006_create_admin_contacts_table', 1),
('2016_07_30_114232_create_app_settings_table', 1),
('2016_07_31_035304_create_app_users_table', 1),
('2016_07_31_040520_create_apps_table', 1),
('2016_07_31_041511_create_components_table', 1),
('2016_07_31_041806_create_coupons_table', 1),
('2016_07_31_073024_create_items_table', 1),
('2016_07_31_073526_create_menus_table', 1),
('2016_07_31_080147_create_news_table', 1),
('2016_07_31_080516_create_photo_categories_table', 1),
('2016_07_31_080746_create_photos_table', 1),
('2016_07_31_081013_create_rel_app_settings_components_table', 1),
('2016_07_31_081611_create_rel_app_settings_sidemenus_components_table', 1),
('2016_07_31_082419_create_rel_apps_stores_components_table', 1),
('2016_07_31_083634_create_rel_items_table', 1),
('2016_07_31_084230_create_rel_menus_items_table', 1),
('2016_07_31_084825_create_reserves_table', 1),
('2016_07_31_085104_create_sidemenus_table', 1),
('2016_07_31_085255_create_app_stores_table', 1),
('2016_07_31_085255_create_stores_table', 1),
('2016_07_31_085405_create_templates_table', 1),
('2016_07_31_085451_create_user_messages_table', 1),
('2016_07_31_090022_create_user_profiles_table', 1),
('2016_07_31_090710_create_user_pushs_table', 1),
('2016_08_05_150203_create_top_main_images_table', 1),
('2016_08_6_091622_add_foreignkey_to_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
`id` int(10) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `date` date DEFAULT NULL,
  `store_id` int(10) unsigned DEFAULT NULL,
  `image_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE IF NOT EXISTS `photos` (
  `id` int(10) unsigned NOT NULL,
  `image_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `photo_category_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `photo_categories`
--

CREATE TABLE IF NOT EXISTS `photo_categories` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `store_id` int(10) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rel_apps_stores`
--

CREATE TABLE IF NOT EXISTS `rel_apps_stores` (
  `app_id` int(10) unsigned NOT NULL,
  `store_id` int(10) unsigned NOT NULL,
  `app_icon_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `store_icon_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `version` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `push_notification_dev_file` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `push_notification_pro_file` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `splash_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rel_app_settings_components`
--

CREATE TABLE IF NOT EXISTS `rel_app_settings_components` (
  `app_setting_id` int(10) unsigned NOT NULL DEFAULT '0',
  `component_id` int(10) unsigned NOT NULL DEFAULT '0',
  `order` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rel_app_settings_sidemenus`
--

CREATE TABLE IF NOT EXISTS `rel_app_settings_sidemenus` (
  `app_setting_id` int(10) unsigned NOT NULL DEFAULT '0',
  `sidemenu_id` int(10) unsigned NOT NULL DEFAULT '0',
  `order` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rel_items`
--

CREATE TABLE IF NOT EXISTS `rel_items` (
  `item_id` int(10) unsigned NOT NULL DEFAULT '0',
  `related_id` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rel_menus_items`
--

CREATE TABLE IF NOT EXISTS `rel_menus_items` (
  `menu_id` int(10) unsigned NOT NULL DEFAULT '0',
  `item_id` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reserves`
--

CREATE TABLE IF NOT EXISTS `reserves` (
`id` int(10) unsigned NOT NULL,
  `reserve_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `store_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sidemenus`
--

CREATE TABLE IF NOT EXISTS `sidemenus` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE IF NOT EXISTS `stores` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Stores 56467', '2016-08-05 09:03:02', '2016-08-05 09:03:02', '0000-00-00 00:00:00'),
(2, 'Stores 26998', '2016-08-05 09:03:02', '2016-08-05 09:03:02', '0000-00-00 00:00:00'),
(3, 'Stores 79219', '2016-08-05 09:03:02', '2016-08-05 09:03:02', '0000-00-00 00:00:00'),
(4, 'Stores 12359', '2016-08-05 09:03:02', '2016-08-05 09:03:02', '0000-00-00 00:00:00'),
(5, 'Stores 18662', '2016-08-05 09:03:02', '2016-08-05 09:03:02', '0000-00-00 00:00:00'),
(6, 'Stores 62499', '2016-08-05 09:03:02', '2016-08-05 09:03:02', '0000-00-00 00:00:00'),
(7, 'Stores 88621', '2016-08-05 09:03:02', '2016-08-05 09:03:02', '0000-00-00 00:00:00'),
(8, 'Stores 54992', '2016-08-05 09:03:02', '2016-08-05 09:03:02', '0000-00-00 00:00:00'),
(9, 'Stores 71805', '2016-08-05 09:03:02', '2016-08-05 09:03:02', '0000-00-00 00:00:00'),
(10, 'Stores 39041', '2016-08-05 09:03:02', '2016-08-05 09:03:02', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `store_top_main_images`
--

CREATE TABLE IF NOT EXISTS `store_top_main_images` (
`id` int(10) unsigned NOT NULL,
  `image_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `store_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `templates`
--

CREATE TABLE IF NOT EXISTS `templates` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `fullname` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sex` int(10) unsigned NOT NULL,
  `birthday` date NOT NULL,
  `locale` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(10) unsigned NOT NULL DEFAULT '0',
  `temporary_hash` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `company` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tel` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=51 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `fullname`, `sex`, `birthday`, `locale`, `status`, `temporary_hash`, `remember_token`, `created_at`, `updated_at`, `deleted_at`, `company`, `address`, `tel`) VALUES
(1, 'Clifton Rice Sr.', 'zemlak.rosamond@example.org', '$2y$10$ep9KOPmDytcxbD5PU.aWG.VOKN7LBQ72BouFZQH14sPceYKPUpxPC', 'Dolores Harris', 1, '1989-06-10', 'ar_KW', 1, '6364d3f0f495b6ab9dcf8d3b5c6e0b01', '', '2016-08-05 09:03:00', '2016-08-05 09:03:00', NULL, 'Gerhold, Wiza and Spinka', '16011 Laurianne Mountains Suite 837\nNorth Dallas, MD 83040', '1-523-752-8468'),
(2, 'Lilliana Wehner', 'nmacejkovic@example.com', '$2y$10$oN/gE.DU5Vcg1QOaC.Ww5.0gwFfJ4f8EpT4lfv2c/6meHivWjTRpC', 'Ahmad Stehr PhD', 1, '1997-04-19', 'nr_ZA', 0, '6364d3f0f495b6ab9dcf8d3b5c6e0b01', '', '2016-08-05 09:03:00', '2016-08-05 09:03:00', NULL, 'Lesch LLC', '99923 Ruecker Estate\nWest Jackelinehaven, GA 25426', '775.829.9907 x52925'),
(3, 'Esta Kerluke', 'cordelia89@example.net', '$2y$10$ad8gGkGbfECkusI7CfPtZugYPm92pGOiLhUcSg.Dh/QaSQMNqK0vS', 'Myrtie Beahan Jr.', 0, '1965-08-08', 'en_NA', 1, '6364d3f0f495b6ab9dcf8d3b5c6e0b01', '', '2016-08-05 09:03:00', '2016-08-05 09:03:00', NULL, 'Kunze, Lowe and Larkin', '53725 Feil Ferry\nWest Bertrandview, NC 49561-4627', '1-665-869-5875 x4548'),
(4, 'Mercedes Kuvalis', 'germaine.jacobson@example.com', '$2y$10$KchdfbecLyv.r/fUbcfiR.LUbJu1mkgM1ipCOJNbQxHMgPW8Oh7M6', 'Astrid Jacobi Sr.', 1, '1985-01-27', 'uz_AF', 0, '6364d3f0f495b6ab9dcf8d3b5c6e0b01', '', '2016-08-05 09:03:00', '2016-08-05 09:03:00', NULL, 'Weimann-Breitenberg', '855 Lynch Burgs Apt. 694\nVeldafort, IN 91800-7402', '413-220-5364'),
(5, 'Sherwood Gorczany I', 'ernestine23@example.net', '$2y$10$EC2v.KQYxrTWsSe5WEVb9ORPzUSGXRru3iaRZCnGjq1JwONGeomrK', 'Isadore Hermann', 0, '1975-10-06', 'wal_E', 4, '6364d3f0f495b6ab9dcf8d3b5c6e0b01', '', '2016-08-05 09:03:00', '2016-08-05 09:03:00', NULL, 'Medhurst, Ullrich and Mayert', '9825 Wolf Island\nSpencershire, ID 40232-9182', '1-356-394-4121 x1848'),
(6, 'Wilburn Batz', 'apaucek@example.net', '$2y$10$zKcspvKKnj4nMTuyxpMBNuOF6/OIA97vZJ9PLRoH8t1SAmHoD24S2', 'Dee Witting', 1, '1997-02-15', 'kam_K', 3, '6364d3f0f495b6ab9dcf8d3b5c6e0b01', '', '2016-08-05 09:03:00', '2016-08-05 09:03:00', NULL, 'Walker-Schulist', '73422 Stark Creek Suite 225\nOmafurt, UT 12476-1173', '859-970-7979 x123'),
(7, 'Prof. Myron Paucek', 'johann70@example.com', '$2y$10$Ldtdz.CPrYMOBRdbXyt2T.qOgh9sudeXypjA9Z1U68Kh5ETQz/GfO', 'Prof. Tyrel Morar MD', 0, '1979-11-05', 'es_CL', 0, '6364d3f0f495b6ab9dcf8d3b5c6e0b01', '', '2016-08-05 09:03:01', '2016-08-05 09:03:01', NULL, 'Hintz, Parker and Considine', '349 Dale Falls\nQueeniemouth, AK 33670', '497-598-5859'),
(8, 'Aniyah Baumbach', 'bruen.mae@example.org', '$2y$10$NW.GC.znhmw8ogF/R4cDlOLZ/yMjatAVJO6FT0xxMsmqkUxnMczfG', 'Prof. Cleora Ryan Jr.', 1, '1957-07-21', 'bn_IN', 1, '6364d3f0f495b6ab9dcf8d3b5c6e0b01', '', '2016-08-05 09:03:01', '2016-08-05 09:03:01', NULL, 'McClure PLC', '6299 Balistreri Haven Suite 053\nLake Margaretthaven, MO 57614', '601.595.9123'),
(9, 'Deja Boyer DDS', 'mdamore@example.com', '$2y$10$yB0sCUZF08HkSKsoTL/IneiYAZkgDAvEpY6Pq9AOOuO.9WviXRz9G', 'Madalyn Konopelski II', 1, '1971-10-18', 'en_BW', 4, '6364d3f0f495b6ab9dcf8d3b5c6e0b01', '', '2016-08-05 09:03:01', '2016-08-05 09:03:01', NULL, 'Jenkins LLC', '500 Larkin Crossroad Suite 385\nMayerport, WA 02420-0859', '(661) 297-5401 x4468'),
(10, 'Jeramie Bechtelar Sr', 'ludwig77@example.net', '$2y$10$tooiYdZhctzHJsu7JfeNae7MfJ9aVpaLpgH5DWJvRbM6Kj167a.gq', 'Darren Predovic', 0, '1984-06-14', 'kok_I', 1, '6364d3f0f495b6ab9dcf8d3b5c6e0b01', '', '2016-08-05 09:03:01', '2016-08-05 09:03:01', NULL, 'Batz, Kuhic and Kuvalis', '716 Hackett Corners Apt. 243\nEast Jewellside, UT 67158-5836', '1-273-518-3176 x9575'),
(11, 'Guido Hegmann', 'leanna.kreiger@example.com', '$2y$10$ec1nkmimxUtr9XXFuaEI1e91puO3GWH5bvPXHC.2/uLLV/5PwRMGi', 'Mrs. Jazmyn Hermiston I', 1, '1961-03-03', 'ga_IE', 4, '6364d3f0f495b6ab9dcf8d3b5c6e0b01', '', '2016-08-05 09:03:01', '2016-08-05 09:03:01', NULL, 'Stokes-Romaguera', '9621 Hamill Walk Apt. 568\nWest Paul, VA 96711', '257.921.8311'),
(12, 'Mr. Cicero Blanda', 'hudson.kub@example.net', '$2y$10$gm8kOrEytcXoUtpwuVPuOO7mEIja5roVvXr9nJ/NFZ71r2lUYozGa', 'Alayna Sporer DDS', 1, '1968-01-05', 'haw_U', 3, '6364d3f0f495b6ab9dcf8d3b5c6e0b01', '', '2016-08-05 09:03:01', '2016-08-05 09:03:01', NULL, 'Cummerata, Ullrich and Rosenbaum', '59224 O''Reilly Gateway\nFerminshire, NJ 50485-8801', '1-828-970-7441 x3277'),
(13, 'Mrs. Krystina Wucker', 'jeffry.lehner@example.org', '$2y$10$ZR4WLwbf52DzvQJHvMg/TOnhB8Kw7QjbGX5RIjzhG9WiikeuNBbm2', 'Jan Champlin', 0, '1992-04-16', 'ii_CN', 1, '6364d3f0f495b6ab9dcf8d3b5c6e0b01', '', '2016-08-05 09:03:01', '2016-08-05 09:03:01', NULL, 'Parisian Group', '498 Bennett Viaduct Suite 812\nMullerstad, WI 72641', '442.917.5416'),
(14, 'Richie Rosenbaum', 'marcia87@example.com', '$2y$10$inhWBzmpdL4EHc2xaJ1vsOJQ9B9TY06Wr9HL4xm0dbE9P9o5.ix2S', 'Lee Lockman', 1, '1989-03-17', 'ar_DZ', 3, '6364d3f0f495b6ab9dcf8d3b5c6e0b01', '', '2016-08-05 09:03:01', '2016-08-05 09:03:01', NULL, 'Block Inc', '30287 Melyssa Knoll\nSouth Alysa, UT 98165-3274', '1-475-397-2474 x7588'),
(15, 'Name Renner', 'gbailey@example.com', '$2y$10$gUv0S0bHI2j2tNLPW17/QuWUjC0z.pC.VPvgBsnHOXSvVlZllubGu', 'Bonnie Orn', 0, '1984-01-26', 'es_PY', 0, '6364d3f0f495b6ab9dcf8d3b5c6e0b01', '', '2016-08-05 09:03:01', '2016-08-05 09:03:01', NULL, 'Hirthe-Deckow', '6426 Walter Route Suite 771\nMaybelleshire, MT 63882', '(549) 809-4725'),
(16, 'Ana Schamberger', 'eudora12@example.com', '$2y$10$ByrOWWRdHazQb1jPc351UOxUaE/5XB.gVv1jR7MCgZczfdxjSnbL.', 'Daren Casper', 0, '1976-12-09', 'lo_LA', 0, '6364d3f0f495b6ab9dcf8d3b5c6e0b01', '', '2016-08-05 09:03:01', '2016-08-05 09:03:01', NULL, 'Brekke, Roberts and Konopelski', '63682 Conn Port Suite 907\nDorothyhaven, MN 10526', '+1 (386) 751-4184'),
(17, 'Amiya Cartwright', 'quinn05@example.net', '$2y$10$dtU7BQyBMSDT5oAjkvoLvOBR3VdU.uw6vtnr5hJPNPdBBhx8q7CcG', 'Antonia Pouros', 0, '1995-09-24', 'ar_OM', 4, '6364d3f0f495b6ab9dcf8d3b5c6e0b01', '', '2016-08-05 09:03:01', '2016-08-05 09:03:01', NULL, 'Abshire-Hermann', '836 Malachi Drive Suite 430\nNorth Cade, AK 75729', '(304) 769-0217'),
(18, 'Dr. Cathrine Willms', 'wiza.rebekah@example.org', '$2y$10$r0WAiuN9T4DFhIn1kLScVe6BV7kKstWci7V9Rff43.lnOH7DVVsHG', 'Creola Ferry', 1, '1971-07-01', 'om_KE', 3, '6364d3f0f495b6ab9dcf8d3b5c6e0b01', '', '2016-08-05 09:03:01', '2016-08-05 09:03:01', NULL, 'DuBuque Inc', '76540 Price Walk Suite 145\nNorth Eldonberg, HI 03018', '478.350.8489'),
(19, 'Jovani Reilly', 'eve.simonis@example.net', '$2y$10$PxwOXZ3H6NPSuaXehbhAiOqfAOASEu3Am1uev2gqiP4iSuxNYZ7d6', 'Dixie Hartmann', 1, '1981-06-05', 'trv_T', 3, '6364d3f0f495b6ab9dcf8d3b5c6e0b01', '', '2016-08-05 09:03:01', '2016-08-05 09:03:01', NULL, 'O''Reilly-Nicolas', '36882 Nikolaus Harbor Suite 084\nPort Brendamouth, HI 22105-3066', '367-446-4876 x9010'),
(20, 'Jaida Gorczany', 'adrian.kassulke@example.net', '$2y$10$HFRD0eVHt1Cz6FtSpLBBjesTvPxplgDZlm0gMs1bDHziWIcbtay3a', 'Antwon Paucek', 1, '1995-03-31', 'ti_ET', 4, '6364d3f0f495b6ab9dcf8d3b5c6e0b01', '', '2016-08-05 09:03:01', '2016-08-05 09:03:01', NULL, 'Labadie LLC', '4184 Treutel Pike Apt. 294\nLuettgenville, VA 93505-7590', '+1-883-639-1063'),
(21, 'Era Morar', 'cecelia94@example.org', '$2y$10$tSc4//WUOd01eq8VB6YXDufO8H/7EPOUhKc6DHJNRra6xBbLvEaku', 'Dr. Geoffrey Dibbert', 0, '1957-12-29', 'nn_NO', 3, '6364d3f0f495b6ab9dcf8d3b5c6e0b01', '', '2016-08-05 09:03:01', '2016-08-05 09:03:01', NULL, 'Breitenberg, Bayer and Aufderhar', '90539 Camren Crossing Apt. 822\nAmyaburgh, MN 24699-3932', '(838) 425-3528 x0132'),
(22, 'Verner Braun', 'colleen.sauer@example.org', '$2y$10$PI27Y7m5K/6pTaWcqo1WiOp0Ql6Ia7IhnVV8GsOGQ7zfxmSOKp1yS', 'Catalina Stamm', 0, '1990-02-21', 'en_IN', 1, '6364d3f0f495b6ab9dcf8d3b5c6e0b01', '', '2016-08-05 09:03:01', '2016-08-05 09:03:01', NULL, 'Kutch, Swaniawski and Buckridge', '58462 Boehm Summit\nWest Mellie, MI 15004', '+1-426-365-8813'),
(23, 'Larry Nitzsche', 'stanford34@example.org', '$2y$10$jkjoS.PIa1eC8P9KrggNfOnjPCPMWcHeDjGbCCjxMhadMJB2f15C6', 'Prof. Adalberto Weber IV', 0, '1980-10-20', 'id_ID', 3, '6364d3f0f495b6ab9dcf8d3b5c6e0b01', '', '2016-08-05 09:03:01', '2016-08-05 09:03:01', NULL, 'Crooks, Robel and Ankunding', '614 Ana Loop Suite 069\nSouth Vida, SC 26269-0685', '674-447-7686'),
(24, 'Ben Stehr II', 'plindgren@example.org', '$2y$10$dEKx8wG.5ZzaSotcsjzqkOANNaEgYn/bsub9/BQf6/WZulZ2f70o6', 'Dallin Boyer II', 1, '1979-08-27', 'de_LU', 0, '6364d3f0f495b6ab9dcf8d3b5c6e0b01', '', '2016-08-05 09:03:01', '2016-08-05 09:03:01', NULL, 'Cummings Ltd', '62202 Cassin Highway Suite 037\nHanefort, SC 38685', '+1-283-639-3389'),
(25, 'Mckayla McDermott', 'laurel44@example.com', '$2y$10$HX81ts6GtUqRELz8Db7FNuhkQluCq.c.u/PHH.QEN02vN7TFvp9vq', 'Mr. Tyrese Parisian III', 0, '1988-09-29', 'or_IN', 3, '6364d3f0f495b6ab9dcf8d3b5c6e0b01', '', '2016-08-05 09:03:01', '2016-08-05 09:03:01', NULL, 'Buckridge-Volkman', '54277 Bergnaum Plaza Suite 700\nElroyburgh, AK 99478-9313', '(885) 716-7967'),
(26, 'Lula Walker', 'earlene.nolan@example.com', '$2y$10$EhH0HUjigjcQ5ibGj05DR.0RRUk8YvDB7YwOLpA9Gr7w8LVjiI8zC', 'Emanuel Gusikowski', 1, '1979-04-09', 'haw_U', 3, '6364d3f0f495b6ab9dcf8d3b5c6e0b01', '', '2016-08-05 09:03:01', '2016-08-05 09:03:01', NULL, 'Robel-Macejkovic', '9573 Aylin Viaduct\nCharitystad, AZ 07921', '245.338.4731'),
(27, 'Arlie Cremin', 'fisher.marta@example.com', '$2y$10$ulVZHbJQMwRWs0d11wKWhudGGtQ.KrQSfdwKUMZY4OnDn6y4Qa4yC', 'Edison Sanford IV', 1, '1980-12-11', 'ar_SD', 4, '6364d3f0f495b6ab9dcf8d3b5c6e0b01', '', '2016-08-05 09:03:01', '2016-08-05 09:03:01', NULL, 'Reichert, Fahey and Dickens', '24378 Koelpin Prairie\nEast Marcelle, CA 27795-5227', '581.631.8230'),
(28, 'Prof. Warren Mann', 'beer.evans@example.com', '$2y$10$SGj9qTfk5MNUof4KWO194uoYhX6ff231AV3Cs.RfQQNH5I1D1SUy2', 'Jacynthe Labadie', 1, '1987-08-20', 'fil_P', 1, '6364d3f0f495b6ab9dcf8d3b5c6e0b01', '', '2016-08-05 09:03:01', '2016-08-05 09:03:01', NULL, 'Schoen Group', '112 Gerhold Ridges\nNorth Prudence, TX 16241', '1-674-251-5887'),
(29, 'Lewis Christiansen', 'kohler.adriel@example.org', '$2y$10$v8U7iOWPG7Fn8AcxwvUnXerWdBo2/080qradsFvUdQGs/vALMksg2', 'Carolanne Williamson', 1, '1993-12-12', 'pl_PL', 3, '6364d3f0f495b6ab9dcf8d3b5c6e0b01', '', '2016-08-05 09:03:01', '2016-08-05 09:03:01', NULL, 'Doyle-Wisozk', '936 Geraldine Spurs\nEast Reyna, CO 98802-8598', '1-597-540-1380 x4497'),
(30, 'Paris Balistreri', 'doyle.earl@example.org', '$2y$10$Es/9NjMBL1f1DcYbC7F1AOnOONszDBhSiq95VJNQOT01Cbi/U5AuC', 'Dr. Monserrat Bosco II', 1, '1967-08-15', 'kcg_N', 1, '6364d3f0f495b6ab9dcf8d3b5c6e0b01', '', '2016-08-05 09:03:01', '2016-08-05 09:03:01', NULL, 'Leannon-Mraz', '876 Hermann Bypass\nNorth Roxanne, ME 94370', '549-701-9534'),
(31, 'Dax Jast V', 'xbins@example.org', '$2y$10$K5LzzYoxs3Ub8O0cWYUPEefqbL4yzULIE4A/9SohPuokVtz4N7A2.', 'Dr. Quinton Osinski', 0, '1958-01-17', 'ar_AE', 4, '6364d3f0f495b6ab9dcf8d3b5c6e0b01', '', '2016-08-05 09:03:01', '2016-08-05 09:03:01', NULL, 'Lubowitz PLC', '1158 Lowe Trail\nQuigleyhaven, MA 65534', '354-252-6796 x832'),
(32, 'Dr. Brett Ryan', 'fwilliamson@example.net', '$2y$10$2.S8EZFP9wHBs9eZ7kK5gOv/SCK1ATTHrH2JwwYs0Pe6wHjRXndDq', 'Prof. Ova Ortiz', 0, '1957-06-11', 'kn_IN', 4, '6364d3f0f495b6ab9dcf8d3b5c6e0b01', '', '2016-08-05 09:03:01', '2016-08-05 09:03:01', NULL, 'Bechtelar, Runolfsdottir and Wilkinson', '7763 Kerluke Locks Apt. 466\nDickiborough, AL 73556-7057', '(518) 639-5218 x9658'),
(33, 'Marley Sawayn', 'klesch@example.net', '$2y$10$U3QcUElw.X2VuQVb1iABauyQoikPH7/VX4UX4V6Gj8wiz7Bvs6Wpe', 'Aylin Schuppe', 1, '1964-02-11', 'as_IN', 1, '6364d3f0f495b6ab9dcf8d3b5c6e0b01', '', '2016-08-05 09:03:01', '2016-08-05 09:03:01', NULL, 'Sporer-Reynolds', '7175 Yessenia Haven Apt. 107\nSouth Andrew, SD 46092-8911', '+1-542-276-6416'),
(34, 'Aiden Rau', 'upton.lolita@example.com', '$2y$10$rkyFhlGi1yeFOfj42O.ob.tWhq7F.EhCeKX4CXTXYF9lLsZiunm8K', 'Sidney Kunde Jr.', 1, '1978-12-22', 'om_ET', 3, '6364d3f0f495b6ab9dcf8d3b5c6e0b01', '', '2016-08-05 09:03:01', '2016-08-05 09:03:01', NULL, 'Bosco, Hills and Considine', '7432 Anya Plaza\nRohanville, MS 22376-5623', '401-243-6570'),
(35, 'Delia Turner', 'oconnell.ernesto@example.net', '$2y$10$IrWqOeQh7v2eieTx1EX0I.UGvpBVKgaWCjC4UfG2/J8Lelahby2me', 'Gerson Conroy', 0, '1988-03-24', 'ms_BN', 4, '6364d3f0f495b6ab9dcf8d3b5c6e0b01', '', '2016-08-05 09:03:01', '2016-08-05 09:03:01', NULL, 'Bailey LLC', '467 Verna Stream Apt. 797\nWest Melisa, AZ 51914-6339', '630-571-0050 x5749'),
(36, 'Miss Nina Doyle Sr.', 'qboyer@example.com', '$2y$10$O5zky5cBrZqJx6hvRR2naO3HIFzKUrTYDFJOOAqmuNf0bAZXBhIJu', 'Leonard Flatley', 0, '1990-08-24', 'ts_ZA', 0, '6364d3f0f495b6ab9dcf8d3b5c6e0b01', '', '2016-08-05 09:03:01', '2016-08-05 09:03:01', NULL, 'Schoen, Kautzer and Heaney', '740 Roberts Viaduct Suite 281\nReingertown, RI 95353', '1-809-522-5739 x780'),
(37, 'Cortez Bechtelar', 'nhansen@example.com', '$2y$10$Ztw71dsW0I8IX04frI38a.4xJ/Eow6Y0F6jbYbar0vBRTKNRsID52', 'Troy Schinner', 1, '1978-12-24', 'byn_E', 4, '6364d3f0f495b6ab9dcf8d3b5c6e0b01', '', '2016-08-05 09:03:01', '2016-08-05 09:03:01', NULL, 'Hessel-Franecki', '619 Eichmann Ridge Apt. 454\nNorth Lourdes, VT 44749', '1-836-620-6610 x4475'),
(38, 'Prof. Hobart Altenwe', 'auer.name@example.org', '$2y$10$pzc8pkcApIYHhZEhiFEDJuXgJC2XQI465LIsBT6S8aTzMjxDWKKH.', 'Ada Waters', 1, '1975-02-13', 'aa_ET', 3, '6364d3f0f495b6ab9dcf8d3b5c6e0b01', '', '2016-08-05 09:03:01', '2016-08-05 09:03:01', NULL, 'Gorczany Inc', '9601 Buckridge Stravenue\nSunnyside, NV 87709-5490', '+17577167929'),
(39, 'Kane Kemmer', 'zullrich@example.com', '$2y$10$/.8VROmr8JYMZ3rwhp6eV.DcIjWyNK4qg2buhYh/Nh9oWHfrN61K.', 'Theron Schumm', 0, '1973-01-03', 'en_BW', 0, '6364d3f0f495b6ab9dcf8d3b5c6e0b01', '', '2016-08-05 09:03:01', '2016-08-05 09:03:01', NULL, 'Hermann Inc', '92208 Jalon Skyway Suite 798\nBoganmouth, VT 73023-4714', '(613) 816-7579'),
(40, 'Prof. Lesley Trantow', 'dion.dicki@example.org', '$2y$10$MWQpqpxAD2bwyQt1wAIsTegcjxOdWwzVVyRz3kGugoMpsh4Gsv/IS', 'Elenor Wunsch', 1, '1979-01-14', 'tr_TR', 0, '6364d3f0f495b6ab9dcf8d3b5c6e0b01', '', '2016-08-05 09:03:01', '2016-08-05 09:03:01', NULL, 'Corkery-Stark', '789 Taryn Ferry Suite 597\nIsadorefort, ND 37260', '920-383-4288 x30224'),
(41, 'Dr. Joey Friesen', 'marielle11@example.com', '$2y$10$uYrrQU4sCLj1vMYfXS8JkOD8.6ukgs9N/Ki2f.khH4u5YURI2UHAS', 'Ms. Kaya Gaylord', 1, '1983-01-04', 'ne_IN', 1, '6364d3f0f495b6ab9dcf8d3b5c6e0b01', '', '2016-08-05 09:03:01', '2016-08-05 09:03:01', NULL, 'Prosacco, Bailey and Stiedemann', '3527 Roma River\nPort Samara, LA 27107-1385', '1-561-702-6113 x1758'),
(42, 'Margarette Ernser DD', 'greg30@example.com', '$2y$10$qcz6np6wPBrKpCNkIyad3uRcnMQNhNjX8j0DfO6dcZ9MQxAyBTE3e', 'Mckenna Streich', 0, '1969-09-29', 'fur_I', 0, '6364d3f0f495b6ab9dcf8d3b5c6e0b01', '', '2016-08-05 09:03:02', '2016-08-05 09:03:02', NULL, 'Pouros Group', '398 Myrtice Isle\nLake Louveniashire, SD 57364', '331-781-4239 x364'),
(43, 'Michel Wisozk', 'jaskolski.duane@example.com', '$2y$10$T509yOGpeJ6JJ5kdqyFabeoxqKHwLuk9ipH1oGZNPxob0PemyZQv2', 'Mr. Jensen Harvey', 0, '1983-12-06', 'uz_UZ', 4, '6364d3f0f495b6ab9dcf8d3b5c6e0b01', '', '2016-08-05 09:03:02', '2016-08-05 09:03:02', NULL, 'Johnston Ltd', '495 Brakus Cape Apt. 534\nPort Luis, FL 98377', '929.856.4859 x47676'),
(44, 'Sincere Gleichner', 'beier.marlen@example.com', '$2y$10$0A5tGgx3NOj7oSDOsk83rOv9YUV3I9jBzqzNLSJRbFQsdX3p4Ghwi', 'Dr. Erling Feil', 1, '1969-03-10', 'ku_IR', 1, '6364d3f0f495b6ab9dcf8d3b5c6e0b01', '', '2016-08-05 09:03:02', '2016-08-05 09:03:02', NULL, 'Wilderman and Sons', '94615 Moore Tunnel Apt. 616\nWest Robbie, SD 65412', '(791) 473-7958 x4531'),
(45, 'Jessica Reichel', 'wava.wuckert@example.org', '$2y$10$1.uWthxIbyHAGkgkwnuZY.vQH1tXyUBJSxFgqPIk16JXjl0nyqo7S', 'Richie Fritsch', 0, '1958-10-23', 'sid_E', 3, '6364d3f0f495b6ab9dcf8d3b5c6e0b01', '', '2016-08-05 09:03:02', '2016-08-05 09:03:02', NULL, 'Buckridge-Ortiz', '15152 Sheila Courts\nProsaccobury, FL 92220-9762', '+1-373-378-0813'),
(46, 'Cecelia Schmitt', 'noble11@example.com', '$2y$10$o/EcQPWFWirnNWDlu1zxDePq9CBw2RBQnoncCHERVCe.I/I/oifzS', 'Brittany Zemlak', 1, '1972-06-05', 'syr_S', 3, '6364d3f0f495b6ab9dcf8d3b5c6e0b01', '', '2016-08-05 09:03:02', '2016-08-05 09:03:02', NULL, 'Lang, Hahn and Nicolas', '20965 Ankunding Roads\nNorth Milanbury, AK 07355', '745.332.1373 x01958'),
(47, 'Angeline Bruen', 'fkeeling@example.net', '$2y$10$RmxhbRmYcEjb0og0kwUO5OLoTbO9Fdqez5SO9qNxIYIfrVQ.BbsBe', 'London Hilll', 1, '1965-05-19', 'zh_MO', 1, '6364d3f0f495b6ab9dcf8d3b5c6e0b01', '', '2016-08-05 09:03:02', '2016-08-05 09:03:02', NULL, 'Mayer-Lubowitz', '20046 Norval Parkway Apt. 548\nNew Domenicamouth, WV 20001-3708', '828.752.3214 x12559'),
(48, 'Pasquale Watsica', 'abrown@example.net', '$2y$10$9QCYnS.Zi84zEox5jsEkIOV1SagyOiEFNDtxlgP4sXRptC2xhftAe', 'Nicola Purdy', 0, '1970-06-15', 'kfo_C', 3, '6364d3f0f495b6ab9dcf8d3b5c6e0b01', '', '2016-08-05 09:03:02', '2016-08-05 09:03:02', NULL, 'Huel-Hickle', '497 Paxton Knoll\nEmmymouth, IA 25914', '(909) 894-8200 x2922'),
(49, 'Prof. Terry Hammes', 'madalyn73@example.net', '$2y$10$D7hd8Cms8ACNNyGBEz7/ZeHRiEKw84sMnAZt0m.A6l4.HLh1HrIbq', 'Eleanora McGlynn', 1, '1990-10-23', 'ku_SY', 1, '6364d3f0f495b6ab9dcf8d3b5c6e0b01', '', '2016-08-05 09:03:02', '2016-08-05 09:03:02', NULL, 'Bechtelar Group', '34649 Ullrich Gardens\nJuanashire, RI 83272', '828.507.0411 x44861'),
(50, 'Lysanne Pfannerstill', 'christ.boyle@example.com', '$2y$10$VKGWf0CqpY5osbb38uOKp.dYaxbdY3hmjLZqozm/7y.DJl5aRDWVW', 'Frankie Schuster', 0, '1993-06-13', 'zh_CN', 0, '6364d3f0f495b6ab9dcf8d3b5c6e0b01', '', '2016-08-05 09:03:02', '2016-08-05 09:03:02', NULL, 'Simonis, Borer and Lindgren', '5712 Buckridge Brooks Suite 607\nWest Kianastad, DC 43096-9576', '1-339-976-6498 x7167');

-- --------------------------------------------------------

--
-- Table structure for table `user_messages`
--

CREATE TABLE IF NOT EXISTS `user_messages` (
  `id` int(10) unsigned NOT NULL,
  `from_user_id` int(10) unsigned DEFAULT NULL,
  `to_user_id` int(10) unsigned DEFAULT NULL,
  `message` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE IF NOT EXISTS `user_profiles` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` smallint(6) DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `facebook_status` smallint(6) NOT NULL DEFAULT '0',
  `twitter_status` smallint(6) NOT NULL DEFAULT '0',
  `instagram_status` smallint(6) NOT NULL DEFAULT '0',
  `facebook_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `twitter_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `instagram_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `app_user_id` int(10) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_pushs`
--

CREATE TABLE IF NOT EXISTS `user_pushs` (
  `id` int(10) unsigned NOT NULL,
  `ranking` smallint(6) NOT NULL DEFAULT '1',
  `news` smallint(6) NOT NULL DEFAULT '1',
  `coupon` smallint(6) NOT NULL DEFAULT '1',
  `chat` smallint(6) NOT NULL DEFAULT '1',
  `app_user_id` int(10) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_sessions`
--

CREATE TABLE IF NOT EXISTS `user_sessions` (
  `id` int(10) unsigned NOT NULL,
  `app_user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` smallint(6) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
 ADD PRIMARY KEY (`id`), ADD KEY `addresses_store_id_index` (`store_id`);

--
-- Indexes for table `admin_contacts`
--
ALTER TABLE `admin_contacts`
 ADD PRIMARY KEY (`id`), ADD KEY `admin_contacts_email_index` (`email`);

--
-- Indexes for table `apps`
--
ALTER TABLE `apps`
 ADD PRIMARY KEY (`id`), ADD KEY `apps_user_id_index` (`user_id`);

--
-- Indexes for table `app_settings`
--
ALTER TABLE `app_settings`
 ADD PRIMARY KEY (`id`), ADD KEY `app_settings_store_id_index` (`store_id`), ADD KEY `app_settings_template_id_index` (`template_id`);

--
-- Indexes for table `app_stores`
--
ALTER TABLE `app_stores`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_users`
--
ALTER TABLE `app_users`
 ADD PRIMARY KEY (`id`), ADD KEY `app_users_app_id_index` (`app_id`);

--
-- Indexes for table `components`
--
ALTER TABLE `components`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
 ADD PRIMARY KEY (`id`), ADD KEY `coupons_store_id_index` (`store_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
 ADD PRIMARY KEY (`id`), ADD KEY `items_coupon_id_index` (`coupon_id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
 ADD PRIMARY KEY (`id`), ADD KEY `menus_store_id_index` (`store_id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
 ADD PRIMARY KEY (`id`), ADD KEY `news_store_id_index` (`store_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
 ADD KEY `password_resets_email_index` (`email`), ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `photos`
--
ALTER TABLE `photos`
 ADD PRIMARY KEY (`id`), ADD KEY `photos_photo_category_id_index` (`photo_category_id`);

--
-- Indexes for table `photo_categories`
--
ALTER TABLE `photo_categories`
 ADD PRIMARY KEY (`id`), ADD KEY `photo_categories_store_id_index` (`store_id`);

--
-- Indexes for table `rel_apps_stores`
--
ALTER TABLE `rel_apps_stores`
 ADD PRIMARY KEY (`app_id`,`store_id`), ADD KEY `rel_apps_stores_store_id_foreign` (`store_id`);

--
-- Indexes for table `rel_app_settings_components`
--
ALTER TABLE `rel_app_settings_components`
 ADD PRIMARY KEY (`app_setting_id`,`component_id`), ADD KEY `rel_app_settings_components_component_id_foreign` (`component_id`);

--
-- Indexes for table `rel_app_settings_sidemenus`
--
ALTER TABLE `rel_app_settings_sidemenus`
 ADD PRIMARY KEY (`app_setting_id`,`sidemenu_id`), ADD KEY `rel_app_settings_sidemenus_sidemenu_id_foreign` (`sidemenu_id`);

--
-- Indexes for table `rel_items`
--
ALTER TABLE `rel_items`
 ADD PRIMARY KEY (`item_id`,`related_id`), ADD KEY `rel_items_related_id_foreign` (`related_id`);

--
-- Indexes for table `rel_menus_items`
--
ALTER TABLE `rel_menus_items`
 ADD PRIMARY KEY (`menu_id`,`item_id`), ADD KEY `rel_menus_items_item_id_foreign` (`item_id`);

--
-- Indexes for table `reserves`
--
ALTER TABLE `reserves`
 ADD PRIMARY KEY (`id`), ADD KEY `reserves_store_id_index` (`store_id`);

--
-- Indexes for table `sidemenus`
--
ALTER TABLE `sidemenus`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_top_main_images`
--
ALTER TABLE `store_top_main_images`
 ADD PRIMARY KEY (`id`), ADD KEY `store_top_main_images_store_id_index` (`store_id`);

--
-- Indexes for table `templates`
--
ALTER TABLE `templates`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `users_email_unique` (`email`), ADD KEY `users_tel_index` (`tel`);

--
-- Indexes for table `user_messages`
--
ALTER TABLE `user_messages`
 ADD PRIMARY KEY (`id`), ADD KEY `user_messages_from_user_id_index` (`from_user_id`), ADD KEY `user_messages_to_user_id_index` (`to_user_id`);

--
-- Indexes for table `user_profiles`
--
ALTER TABLE `user_profiles`
 ADD PRIMARY KEY (`id`), ADD KEY `user_profiles_app_user_id_index` (`app_user_id`);

--
-- Indexes for table `user_pushs`
--
ALTER TABLE `user_pushs`
 ADD PRIMARY KEY (`id`), ADD KEY `user_pushs_app_user_id_index` (`app_user_id`);

--
-- Indexes for table `user_sessions`
--
ALTER TABLE `user_sessions`
 ADD PRIMARY KEY (`id`,`app_user_id`), ADD KEY `user_sessions_app_user_id_foreign` (`app_user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_contacts`
--
ALTER TABLE `admin_contacts`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `apps`
--
ALTER TABLE `apps`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `app_settings`
--
ALTER TABLE `app_settings`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `app_stores`
--
ALTER TABLE `app_stores`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `reserves`
--
ALTER TABLE `reserves`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sidemenus`
--
ALTER TABLE `sidemenus`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `store_top_main_images`
--
ALTER TABLE `store_top_main_images`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `templates`
--
ALTER TABLE `templates`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=51;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
ADD CONSTRAINT `addresses_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`);

--
-- Constraints for table `apps`
--
ALTER TABLE `apps`
ADD CONSTRAINT `apps_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `app_settings`
--
ALTER TABLE `app_settings`
ADD CONSTRAINT `app_settings_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`),
ADD CONSTRAINT `app_settings_template_id_foreign` FOREIGN KEY (`template_id`) REFERENCES `templates` (`id`);

--
-- Constraints for table `app_users`
--
ALTER TABLE `app_users`
ADD CONSTRAINT `app_users_app_id_foreign` FOREIGN KEY (`app_id`) REFERENCES `apps` (`id`);

--
-- Constraints for table `coupons`
--
ALTER TABLE `coupons`
ADD CONSTRAINT `coupons_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`);

--
-- Constraints for table `items`
--
ALTER TABLE `items`
ADD CONSTRAINT `items_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`);

--
-- Constraints for table `menus`
--
ALTER TABLE `menus`
ADD CONSTRAINT `menus_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`);

--
-- Constraints for table `news`
--
ALTER TABLE `news`
ADD CONSTRAINT `news_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`);

--
-- Constraints for table `photos`
--
ALTER TABLE `photos`
ADD CONSTRAINT `photos_photo_category_id_foreign` FOREIGN KEY (`photo_category_id`) REFERENCES `photo_categories` (`id`);

--
-- Constraints for table `photo_categories`
--
ALTER TABLE `photo_categories`
ADD CONSTRAINT `photo_categories_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`);

--
-- Constraints for table `rel_apps_stores`
--
ALTER TABLE `rel_apps_stores`
ADD CONSTRAINT `rel_apps_stores_app_id_foreign` FOREIGN KEY (`app_id`) REFERENCES `apps` (`id`),
ADD CONSTRAINT `rel_apps_stores_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`);

--
-- Constraints for table `rel_app_settings_components`
--
ALTER TABLE `rel_app_settings_components`
ADD CONSTRAINT `rel_app_settings_components_app_setting_id_foreign` FOREIGN KEY (`app_setting_id`) REFERENCES `app_settings` (`id`),
ADD CONSTRAINT `rel_app_settings_components_component_id_foreign` FOREIGN KEY (`component_id`) REFERENCES `components` (`id`);

--
-- Constraints for table `rel_app_settings_sidemenus`
--
ALTER TABLE `rel_app_settings_sidemenus`
ADD CONSTRAINT `rel_app_settings_sidemenus_app_setting_id_foreign` FOREIGN KEY (`app_setting_id`) REFERENCES `app_settings` (`id`),
ADD CONSTRAINT `rel_app_settings_sidemenus_sidemenu_id_foreign` FOREIGN KEY (`sidemenu_id`) REFERENCES `sidemenus` (`id`);

--
-- Constraints for table `rel_items`
--
ALTER TABLE `rel_items`
ADD CONSTRAINT `rel_items_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
ADD CONSTRAINT `rel_items_related_id_foreign` FOREIGN KEY (`related_id`) REFERENCES `items` (`id`);

--
-- Constraints for table `rel_menus_items`
--
ALTER TABLE `rel_menus_items`
ADD CONSTRAINT `rel_menus_items_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
ADD CONSTRAINT `rel_menus_items_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`);

--
-- Constraints for table `reserves`
--
ALTER TABLE `reserves`
ADD CONSTRAINT `reserves_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`);

--
-- Constraints for table `store_top_main_images`
--
ALTER TABLE `store_top_main_images`
ADD CONSTRAINT `store_top_main_images_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`);

--
-- Constraints for table `user_messages`
--
ALTER TABLE `user_messages`
ADD CONSTRAINT `user_messages_from_user_id_foreign` FOREIGN KEY (`from_user_id`) REFERENCES `app_users` (`id`),
ADD CONSTRAINT `user_messages_to_user_id_foreign` FOREIGN KEY (`to_user_id`) REFERENCES `app_users` (`id`);

--
-- Constraints for table `user_profiles`
--
ALTER TABLE `user_profiles`
ADD CONSTRAINT `user_profiles_app_user_id_foreign` FOREIGN KEY (`app_user_id`) REFERENCES `app_users` (`id`);

--
-- Constraints for table `user_pushs`
--
ALTER TABLE `user_pushs`
ADD CONSTRAINT `user_pushs_app_user_id_foreign` FOREIGN KEY (`app_user_id`) REFERENCES `app_users` (`id`);

--
-- Constraints for table `user_sessions`
--
ALTER TABLE `user_sessions`
ADD CONSTRAINT `user_sessions_app_user_id_foreign` FOREIGN KEY (`app_user_id`) REFERENCES `app_users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
