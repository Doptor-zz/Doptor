-- phpMyAdmin SQL Dump
-- version 4.0.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 31, 2014 at 08:42 PM
-- Server version: 5.5.35-cll
-- PHP Version: 5.3.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tngbdcom_mjtest`
--

-- --------------------------------------------------------

--
-- Table structure for table `built_forms`
--

CREATE TABLE IF NOT EXISTS `built_forms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hash` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `category` int(10) unsigned NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `show_captcha` tinyint(1) NOT NULL DEFAULT '0',
  `data` text COLLATE utf8_unicode_ci NOT NULL,
  `rendered` text COLLATE utf8_unicode_ci NOT NULL,
  `redirect_to` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `extra_code` text COLLATE utf8_unicode_ci,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `built_forms_category_index` (`category`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `built_forms`
--

INSERT INTO `built_forms` (`id`, `name`, `category`, `description`, `show_captcha`, `data`, `rendered`, `redirect_to`, `extra_code`, `created_at`, `updated_at`) VALUES
(8, 'Client Data', 1, '', 0, '[{"title":"Form Name","fields":{"name":{"label":"Form Name","type":"input","value":"Client Data","name":"name"}}},{"title":"Text Input","fields":{"id":{"label":"ID / Name","type":"input","value":"client32nn","name":"id"},"label":{"label":"Label Text","type":"input","value":"Client Name","name":"label"},"placeholder":{"label":"Placeholder","type":"input","value":"","name":"placeholder"},"helptext":{"label":"Help Text","type":"input","value":"","name":"helptext"},"required":{"label":"Required","type":"checkbox","value":false,"name":"required"},"inputsize":{"label":"Input Size","type":"select","value":[{"value":"input-mini","selected":false,"label":"Mini"},{"value":"input-small","selected":false,"label":"Small"},{"value":"input-medium","selected":false,"label":"Medium"},{"value":"input-large","selected":false,"label":"Large"},{"value":"input-xlarge","selected":true,"label":"Xlarge"},{"value":"input-xxlarge","selected":false,"label":"Xxlarge"}],"name":"inputsize"}}},{"title":"Text Area","fields":{"id":{"label":"ID / Name","type":"input","value":"clientaddress9mm","name":"id"},"label":{"label":"Label Text","type":"input","value":"Address","name":"label"},"textarea":{"label":"Starting Text","type":"textarea","value":"","name":"textarea"}}},{"title":"Text Input","fields":{"id":{"label":"ID / Name","type":"input","value":"phone8089","name":"id"},"label":{"label":"Label Text","type":"input","value":"Phone","name":"label"},"placeholder":{"label":"Placeholder","type":"input","value":"","name":"placeholder"},"helptext":{"label":"Help Text","type":"input","value":"","name":"helptext"},"required":{"label":"Required","type":"checkbox","value":false,"name":"required"},"inputsize":{"label":"Input Size","type":"select","value":[{"value":"input-mini","selected":false,"label":"Mini"},{"value":"input-small","selected":false,"label":"Small"},{"value":"input-medium","selected":false,"label":"Medium"},{"value":"input-large","selected":false,"label":"Large"},{"value":"input-xlarge","selected":true,"label":"Xlarge"},{"value":"input-xxlarge","selected":false,"label":"Xxlarge"}],"name":"inputsize"}}},{"title":"Text Input","fields":{"id":{"label":"ID / Name","type":"input","value":"email232","name":"id"},"label":{"label":"Label Text","type":"input","value":"Email ","name":"label"},"placeholder":{"label":"Placeholder","type":"input","value":"","name":"placeholder"},"helptext":{"label":"Help Text","type":"input","value":"","name":"helptext"},"required":{"label":"Required","type":"checkbox","value":false,"name":"required"},"inputsize":{"label":"Input Size","type":"select","value":[{"value":"input-mini","selected":false,"label":"Mini"},{"value":"input-small","selected":false,"label":"Small"},{"value":"input-medium","selected":false,"label":"Medium"},{"value":"input-large","selected":false,"label":"Large"},{"value":"input-xlarge","selected":true,"label":"Xlarge"},{"value":"input-xxlarge","selected":false,"label":"Xxlarge"}],"name":"inputsize"}}},{"title":"Text Input","fields":{"id":{"label":"ID / Name","type":"input","value":"website9808","name":"id"},"label":{"label":"Label Text","type":"input","value":"Website","name":"label"},"placeholder":{"label":"Placeholder","type":"input","value":"","name":"placeholder"},"helptext":{"label":"Help Text","type":"input","value":"","name":"helptext"},"required":{"label":"Required","type":"checkbox","value":false,"name":"required"},"inputsize":{"label":"Input Size","type":"select","value":[{"value":"input-mini","selected":false,"label":"Mini"},{"value":"input-small","selected":false,"label":"Small"},{"value":"input-medium","selected":false,"label":"Medium"},{"value":"input-large","selected":false,"label":"Large"},{"value":"input-xlarge","selected":true,"label":"Xlarge"},{"value":"input-xxlarge","selected":false,"label":"Xxlarge"}],"name":"inputsize"}}},{"title":"Select Basic","fields":{"id":{"label":"ID / Name","type":"input","value":"country009ms","name":"id"},"label":{"label":"Label Text","type":"input","value":"Country","name":"label"},"options":{"label":"Options","type":"textarea-split","value":["Bangladesh","Malaysia","Singapore","USA","Canada","Australia","UK","Japan"],"name":"options"},"inputsize":{"label":"Input Size","type":"select","value":[{"value":"input-mini","selected":false,"label":"Mini"},{"value":"input-small","selected":false,"label":"Small"},{"value":"input-medium","selected":false,"label":"Medium"},{"value":"input-large","selected":false,"label":"Large"},{"value":"input-xlarge","selected":true,"label":"Xlarge"},{"value":"input-xxlarge","selected":false,"label":"Xxlarge"}],"name":"inputsize"}}},{"title":"Multiple Radios","fields":{"name":{"label":"Group Name","type":"input","value":"status98nm","name":"name"},"label":{"label":"Label Text","type":"input","value":"Status","name":"label"},"required":{"label":"Required","type":"checkbox","value":false,"name":"required"},"radios":{"label":"Radios","type":"textarea-split","value":["Active","Inactive"],"name":"radios"}}},{"title":"Single Button","fields":{"id":{"label":"ID / Name","type":"input","value":"singlebutton44d","name":"id"},"label":{"label":"Label Text","type":"input","value":"","name":"label"},"buttonlabel":{"label":"Button Label","type":"input","value":"Submit","name":"buttonlabel"},"buttontype":{"label":"Button Type","type":"select","value":[{"value":"btn-default","selected":false,"label":"Default"},{"value":"btn-primary","selected":true,"label":"Primary"},{"value":"btn-info","selected":false,"label":"Info"},{"value":"btn-success","selected":false,"label":"Success"},{"value":"btn-warning","selected":false,"label":"Warning"},{"value":"btn-danger","selected":false,"label":"Danger"},{"value":"btn-inverse","selected":false,"label":"Inverse"}],"name":"buttontype"}}}]', '<form class="form-horizontal">\n<fieldset>\n\n<!-- Form Name -->\n<legend>Client Data</legend>\n\n<!-- Text input-->\n<div class="control-group">\n  <label class="control-label" for="client32nn">Client Name</label>\n  <div class="controls">\n    <input id="client32nn" name="client32nn" type="text" placeholder="" class="input-xlarge">\n    \n  </div>\n</div>\n\n<!-- Textarea -->\n<div class="control-group">\n  <label class="control-label" for="clientaddress9mm">Address</label>\n  <div class="controls">                     \n    <textarea id="clientaddress9mm" name="clientaddress9mm"></textarea>\n  </div>\n</div>\n\n<!-- Text input-->\n<div class="control-group">\n  <label class="control-label" for="phone8089">Phone</label>\n  <div class="controls">\n    <input id="phone8089" name="phone8089" type="text" placeholder="" class="input-xlarge">\n    \n  </div>\n</div>\n\n<!-- Text input-->\n<div class="control-group">\n  <label class="control-label" for="email232">Email </label>\n  <div class="controls">\n    <input id="email232" name="email232" type="text" placeholder="" class="input-xlarge">\n    \n  </div>\n</div>\n\n<!-- Text input-->\n<div class="control-group">\n  <label class="control-label" for="website9808">Website</label>\n  <div class="controls">\n    <input id="website9808" name="website9808" type="text" placeholder="" class="input-xlarge">\n    \n  </div>\n</div>\n\n<!-- Select Basic -->\n<div class="control-group">\n  <label class="control-label" for="country009ms">Country</label>\n  <div class="controls">\n    <select id="country009ms" name="country009ms" class="input-xlarge">\n      <option>Bangladesh</option>\n      <option>Malaysia</option>\n      <option>Singapore</option>\n      <option>USA</option>\n      <option>Canada</option>\n      <option>Australia</option>\n      <option>UK</option>\n      <option>Japan</option>\n    </select>\n  </div>\n</div>\n\n<!-- Multiple Radios -->\n<div class="control-group">\n  <label class="control-label" for="status98nm">Status</label>\n  <div class="controls">\n    <label class="radio" for="status98nm-0">\n      <input type="radio" name="status98nm" id="status98nm-0" value="Active" checked="checked">\n      Active\n    </label>\n    <label class="radio" for="status98nm-1">\n      <input type="radio" name="status98nm" id="status98nm-1" value="Inactive">\n      Inactive\n    </label>\n  </div>\n</div>\n\n<!-- Button -->\n<div class="control-group">\n  <label class="control-label" for="singlebutton44d"></label>\n  <div class="controls">\n    <button id="singlebutton44d" name="singlebutton44d" class="btn btn-primary">Submit</button>\n  </div>\n</div>\n\n</fieldset>\n</form>\n', 'list', '', '2014-03-27 23:33:25', '2014-03-27 23:33:25');

-- --------------------------------------------------------

--
-- Table structure for table `built_modules`
--

CREATE TABLE IF NOT EXISTS `built_modules` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hash` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `version` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `author` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `form_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `target` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `table_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_author` boolean COLLATE utf8_unicode_ci DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `built_modules`
--

INSERT INTO `built_modules` (`id`, `name`, `version`, `author`, `website`, `description`, `form_id`, `target`, `file`, `table_name`, `created_at`, `updated_at`) VALUES
(3, 'Test Module', '1', 'Andrew', 'http://www.doptor.org', '', '8', 'admin', '/home/tngbdcom/public_html/cms/app/storage/temp/test_module.zip', 'testing_form', '2014-03-22 00:35:16', '2014-03-22 00:35:16');

-- --------------------------------------------------------
--
-- Table structure for table `built_reports`
--

CREATE TABLE IF NOT EXISTS `built_reports` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `author` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `version` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modules` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `show_calendars` boolean COLLATE utf8_unicode_ci DEFAULT 1,
  `created_by` int(10) unsigned NOT NULL,
  `updated_by` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `built_reports_created_by_index` (`created_by`),
  KEY `built_reports_updated_by_index` (`updated_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
-- --------------------------------------------------------
--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `alias` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'post',
  `language_id` int(10) unsigned NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `status` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'published',
  `created_by` int(10) unsigned NOT NULL,
  `updated_by` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `categories_language_id_index` (`language_id`),
  KEY `categories_created_by_index` (`created_by`),
  KEY `categories_updated_by_index` (`updated_by`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `alias`, `type`, `language_id`, `description`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(2, 'First Category', 'first-category', 'post', 1, 'Lorem Ipsum', 'published', 1, NULL, '2014-03-29 16:00:00', '2014-03-29 16:00:00'),
(3, 'Another Category', 'another-category', 'page', 1, 'Lorem Ipsum', 'published', 1, NULL, '2014-03-29 16:00:00', '2014-03-29 16:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `contact_categories`
--

CREATE TABLE IF NOT EXISTS `contact_categories` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `alias` varchar(255) collate utf8_unicode_ci NOT NULL,
  `description` text collate utf8_unicode_ci,
  `status` varchar(20) collate utf8_unicode_ci NOT NULL default 'published',
  `created_by` int(10) unsigned NOT NULL,
  `updated_by` int(10) unsigned default NULL,
  `created_at` timestamp NOT NULL default '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `contact_categories_created_by_index` (`created_by`),
  KEY `contact_categories_updated_by_index` (`updated_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `contact_categories`
--

INSERT INTO `contact_categories` (`id`, `name`, `alias`, `description`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Test', 'test', '', 'published', 13, 7, '2014-07-24 05:13:45', '2014-07-25 20:14:47');

-- --------------------------------------------------------

--
-- Table structure for table `contact_details`
--

CREATE TABLE IF NOT EXISTS `contact_details` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `alias` varchar(255) collate utf8_unicode_ci NOT NULL,
  `image` varchar(255) collate utf8_unicode_ci default NULL,
  `email` varchar(255) collate utf8_unicode_ci default NULL,
  `address` varchar(255) collate utf8_unicode_ci default NULL,
  `city` varchar(255) collate utf8_unicode_ci default NULL,
  `state` varchar(255) collate utf8_unicode_ci default NULL,
  `zip_code` varchar(255) collate utf8_unicode_ci default NULL,
  `country` varchar(255) collate utf8_unicode_ci default NULL,
  `telephone` varchar(255) collate utf8_unicode_ci default NULL,
  `mobile` varchar(255) collate utf8_unicode_ci default NULL,
  `fax` varchar(255) collate utf8_unicode_ci default NULL,
  `website` varchar(255) collate utf8_unicode_ci default NULL,
  `location` text collate utf8_unicode_ci,
  `display_options` text collate utf8_unicode_ci,
  `category_id` int(10) unsigned default NULL,
  `created_at` timestamp NOT NULL default '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `contact_details`
--

INSERT INTO `contact_details` (`id`, `name`, `alias`, `image`, `email`, `address`, `city`, `state`, `zip_code`, `country`, `telephone`, `mobile`, `fax`, `website`, `location`, `display_options`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'Doptor HQ', 'doptor-hq', '', 'info@doptor.org', 'Silicon Valley', 'Silicon Valley', 'Silicon Valley', '12345678', 'USA', '+0000000000000', '+0000000000000', '+0000000000000', 'www.doptor.org', '{"latitude":"37.383116401049264","longitude":"-122.06344642910767"}', '{"name":1,"image":1,"email":1,"address":1,"city":1,"state":1,"zip_code":1,"country":1,"telephone":1,"mobile":1,"fax":1,"website":1,"location":1}', 1, '2014-07-24 05:18:23', '2014-07-25 20:28:44');

-- --------------------------------------------------------

--
-- Table structure for table `contact_emails`
--

CREATE TABLE IF NOT EXISTS `contact_emails` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `email` varchar(255) collate utf8_unicode_ci NOT NULL,
  `subject` varchar(255) collate utf8_unicode_ci default NULL,
  `message` text collate utf8_unicode_ci NOT NULL,
  `contact_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL default '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `category_post`
--

CREATE TABLE IF NOT EXISTS `category_post` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned NOT NULL,
  `post_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_post_category_id_index` (`category_id`),
  KEY `category_post_post_id_index` (`post_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `category_post`
--

INSERT INTO `category_post` (`id`, `category_id`, `post_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 7),
(7, 1, 8),
(8, 3, 13);

-- --------------------------------------------------------

--
-- Table structure for table `form_categories`
--

CREATE TABLE IF NOT EXISTS `form_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `form_categories`
--

INSERT INTO `form_categories` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'test', 'test', '2014-03-20 21:10:03', '2014-03-20 21:10:03');

-- --------------------------------------------------------

--
-- Table structure for table `form_entries`
--

CREATE TABLE IF NOT EXISTS `form_entries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(10) unsigned NOT NULL,
  `fields` text COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `groups_name_unique` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `group_menu`
--

CREATE TABLE IF NOT EXISTS `group_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(10) unsigned NOT NULL,
  `menu_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `group_menu_group_id_index` (`group_id`),
  KEY `group_menu_menu_id_index` (`menu_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `group_menu`
--

INSERT INTO `group_menu` (`id`, `group_id`, `menu_id`) VALUES
(2, 2, 11),
(3, 1, 11),
(4, 1, 33),
(5, 2, 33),
(6, 1, 37),
(7, 1, 38);

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE IF NOT EXISTS `languages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `created_at`, `updated_at`) VALUES
(2, 'English', '2014-03-29 16:00:00', '2014-03-29 16:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `media_entries`
--

CREATE TABLE IF NOT EXISTS `media_entries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `caption` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `thumbnail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `album_id` int(10) unsigned DEFAULT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `updated_by` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `media_entries_created_by_index` (`created_by`),
  KEY `media_entries_updated_by_index` (`updated_by`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `media_entries`
--

INSERT INTO `media_entries` (`id`, `caption`, `image`, `thumbnail`, `album_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, '', 'time line11_ihA2koJj.jpg', 'time line11_ihA2koJj.jpg', 0, 1, 0, '2014-03-20 20:14:09', '2014-03-20 20:14:09'),
(3, '', 'Doptor Logo_UdhdA20E.png', 'Doptor Logo_UdhdA20E.png', 0, 3, 0, '2014-03-22 21:47:53', '2014-03-22 21:47:53'),
(8, NULL, 'doptor/Doptor Logo Black_M6Cxwm5B.png', 'doptor/thumbs/Doptor Logo Black_M6Cxwm5B.png', NULL, 14, NULL, '2014-03-31 04:22:29', '2014-03-31 04:22:29');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE IF NOT EXISTS `menus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `alias` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link_manual` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category` int(10) unsigned NULL,
  `position` int(10) unsigned NOT NULL,
  `display_text` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `same_window` tinyint(1) NOT NULL DEFAULT '1',
  `show_image` tinyint(1) NOT NULL DEFAULT '1',
  `is_wrapper` tinyint(1) NOT NULL DEFAULT '0',
  `wrapper_width` int(10) unsigned DEFAULT NULL,
  `wrapper_height` int(10) unsigned DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'published',
  `parent` int(10) unsigned NOT NULL,
  `order` int(11) NOT NULL DEFAULT '0',
  `target` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `language_id` int(10) unsigned NOT NULL,
  `publish_start` datetime DEFAULT NULL,
  `publish_end` datetime DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_keywords` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `menus_position_index` (`position`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=39 ;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `title`, `alias`, `link`, `icon`, `link_manual`, `position`, `display_text`, `same_window`, `show_image`, `is_wrapper`, `status`, `parent`, `order`, `target`, `language_id`, `publish_start`, `publish_end`, `meta_title`, `meta_description`, `meta_keywords`, `created_at`, `updated_at`) VALUES
(4, 'Home', 'public-top-menu-home', '/', '', '', 1, 'Welcome to Doptor CMS.', 1, 1, 0, 'published', 0, 1, 'public', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '2014-03-22 03:11:17', '2014-03-27 02:36:31'),
(5, 'About Us', 'public-top-menu-about-us', 'pages/about-us', '', '#', 1, '', 1, 0, 0, 'published', 0, 3, 'public', 0, NULL, NULL, '', '', '', '2014-03-22 03:11:55', '2014-03-31 04:30:19'),
(6, 'Backend', 'public-small-menu-right-backend', 'manual', '', 'backend', 4, '', 0, 1, 0, 'published', 0, 1, 'public', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '2014-03-22 03:20:05', '2014-03-22 03:20:05'),
(7, 'Admin', 'public-small-menu-right-admin', 'manual', '', 'admin', 4, '', 0, 1, 0, 'published', 0, 2, 'public', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '2014-03-22 03:20:37', '2014-03-22 03:20:37'),
(8, 'About Us', 'public-bottom-menu-about-us', 'pages/about-us', '', '', 2, '', 1, 1, 0, 'published', 0, 0, 'public', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '2014-03-22 03:21:12', '2014-03-22 03:21:12'),
(9, 'Demo', 'public-small-menu-left-demo', 'pages/demo', '', '#', 3, '', 0, 0, 0, 'published', 0, 1, 'public', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '2014-03-22 03:22:01', '2014-03-27 10:00:05'),
(10, 'Download', 'public-small-menu-left-download', 'pages/under-construction', '', '', 3, '', 0, 0, 0, 'published', 0, 2, 'public', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '2014-03-22 03:22:25', '2014-03-25 18:01:04'),
(13, 'Contact Us', 'public-top-menu-contact-us', 'link_type/modules/form23', '', '', 1, '', 1, 1, 0, 'unpublished', 0, 8, 'public', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '2014-03-22 21:35:43', '2014-03-26 07:20:22'),
(14, 'Main', 'public-top-menu-main', 'manual', '', '#', 1, '', 1, 1, 0, 'published', 0, 2, 'public', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '2014-03-22 22:06:11', '2014-03-22 22:13:58'),
(15, 'Sub-1', 'public-top-menu-sub-1', 'manual', '', '#', 1, '', 1, 1, 0, 'published', 14, 0, 'public', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '2014-03-22 22:06:57', '2014-03-22 22:06:57'),
(16, 'Sub-2', 'public-top-menu-sub-2', 'manual', '', '#', 1, '', 1, 1, 0, 'published', 14, 0, 'public', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '2014-03-22 22:07:57', '2014-03-22 22:09:26'),
(17, 'Sub-3', 'public-top-menu-sub-3', 'manual', '', '#', 1, '', 1, 1, 0, 'published', 14, 0, 'public', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '2014-03-22 22:08:31', '2014-03-22 22:10:12'),
(18, 'Sub-Sub-1', 'public-top-menu-sub-sub-1', 'manual', '', '#', 1, '', 1, 1, 0, 'published', 15, 0, 'public', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '2014-03-22 22:11:29', '2014-03-22 22:11:29'),
(19, 'Sub-Sub-2', 'public-top-menu-sub-sub-2', 'manual', '', '#', 1, '', 1, 1, 0, 'published', 15, 0, 'public', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '2014-03-22 22:12:24', '2014-03-22 22:12:24'),
(20, 'Sub-Sub-Sub-1', 'public-top-menu-sub-sub-sub-1', 'manual', '', '#', 1, '', 1, 1, 0, 'published', 18, 0, 'public', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '2014-03-22 22:13:15', '2014-03-22 22:13:15'),
(32, 'Help', 'public-top-menu-help', 'pages/help', NULL, '', 1, '', 1, 0, 0, 'published', 0, 10, 'public', 0, NULL, NULL, NULL, '', '', '2014-03-27 21:50:17', '2014-03-31 04:29:11');

-- --------------------------------------------------------

--
-- Table structure for table `menu_positions`
--

CREATE TABLE IF NOT EXISTS `menu_positions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `alias` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `menu_positions`
--

INSERT INTO `menu_positions` (`id`, `name`, `alias`, `created_at`, `updated_at`) VALUES
(1, 'Public Top Menu', 'public-top-menu', '2014-09-07 18:15:00', '2014-09-07 18:15:00'),
(2, 'Public Bottom Menu', 'public-bottom-menu', '2014-09-07 18:15:00', '2014-09-07 18:15:00'),
(3, 'Public Small Menu Left', 'public-small-menu-left', '2014-09-07 18:15:00', '2014-09-07 18:15:00'),
(4, 'Public Small Menu Right', 'public-small-menu-right', '2014-09-07 18:15:00', '2014-09-07 18:15:00'),
(5, 'Admin Top Menu', 'admin-top-menu', '2014-09-07 18:15:00', '2014-09-07 18:15:00'),
(6, 'Admin Main Menu', 'admin-main-menu', '2014-09-07 18:15:00', '2014-09-07 18:15:00');

-- --------------------------------------------------------

--
-- Table structure for table `menu_categories`
--

CREATE TABLE IF NOT EXISTS `menu_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `alias` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `position` int(10) UNSIGNED NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

INSERT INTO `menu_categories` (`id`, `name`, `alias`, `position`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Onepage Top', 'onepage-top', 1, '', '2014-10-01 17:23:19', '2014-10-01 17:23:19'),
(2, 'Onepage Bottom', 'onepage-bottom', 2, '', '2014-10-01 17:23:28', '2014-10-01 17:23:28'),
(3, 'Multiplepage Top', 'multiplepage-top', 1, '', '2014-10-01 17:23:40', '2014-10-01 17:23:40'),
(4, 'Multiplepage Bottom', 'multiplepage-bottom', 2, '', '2014-10-01 17:23:50', '2014-10-01 17:23:50');
-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2012_12_06_225921_migration_cartalyst_sentry_install_users', 1),
('2012_12_06_225929_migration_cartalyst_sentry_install_groups', 1),
('2012_12_06_225945_migration_cartalyst_sentry_install_users_groups_pivot', 1),
('2012_12_06_225988_migration_cartalyst_sentry_install_throttle', 1),
('2013_12_05_152937_create_form_categories_table', 1),
('2013_12_14_150939_create_built_forms_table', 1),
('2013_12_16_085835_create_menucategories_table', 1),
('2013_12_16_142732_create_menus_table', 1),
('2013_12_26_144014_create_modules_table', 1),
('2014_02_02_104111_pivot_group_menu_table', 1),
('2014_02_04_061701_create_built_modules_table', 1),
('2014_02_14_030526_create_settings_table', 1),
('2014_02_19_175006_create_slideshow_table', 1),
('2014_01_26_155006_create_languages_table', 2),
('2014_01_26_175006_create_posts_table', 2),
('2014_01_28_153951_create_categories_table', 2),
('2014_01_29_063050_pivot_category_post_table', 2),
('2014_03_10_020526_create_media_entries_table', 3),
('2014_03_12_074541_create_themes_table', 4),
('2014_10_14_294335_create_contact_details_table', 5),
('2014_10_14_437293_create_contact_emails_table', 5),
('2014_10_21_153951_create_contact_categories_table', 5),
('2014_07_28_142845_create_report_generators_table', 6),
('2014_07_28_142827_create_built_reports_table', 7),
('2014_08_21_221904_create_filled_forms_table', 8),
('2014_08_21_221904_create_form_entries_table', 9),
('2014_09_07_223749_create_menu_positions_table', 10),
('2014_09_08_214527_add_position_to_menus_table', 10),
('2014_09_13_200037_add_security_fields_to_users_table', 11);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hash` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `alias` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `table` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `author` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `target` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `links` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `name`, `alias`, `table`, `version`, `author`, `website`, `description`, `target`, `enabled`, `created_at`, `updated_at`) VALUES
(10, 'Add Customer', 'add_customer', 'add_customer', '0.1', 'Doptor', 'http://www.tngbd.com', '', 'admin|backend', 1, '2014-03-24 07:25:44', '2014-03-24 07:25:44');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permalink` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('published','unpublished','drafted','archived') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'published',
  `target` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `publish_start` datetime DEFAULT NULL,
  `publish_end` datetime DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_keywords` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` enum('page','post') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'post',
  `hits` int(11) NOT NULL DEFAULT '0',
  `extras` text COLLATE utf8_unicode_ci,
  `created_by` int(10) unsigned NOT NULL,
  `updated_by` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `posts_created_by_index` (`created_by`),
  KEY `posts_updated_by_index` (`updated_by`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `permalink`, `image`, `content`, `status`, `target`, `featured`, `publish_start`, `publish_end`, `meta_title`, `meta_description`, `meta_keywords`, `type`, `hits`, `created_by`, `updated_by`, `created_at`, `updated_at`, `extras`) VALUES
(1, 'Contact Us', 'contact', NULL, 'Our contact address goes here', 'published', 'public', 0, NULL, NULL, NULL, NULL, NULL, 'page', 0, 1, NULL, '2014-03-29 16:00:00', '2014-03-29 16:00:00', '{"contact_page":true,"contact_coords":"40.7142700, -74.0059700"}'),
(9, 'Welcome', 'welcome', NULL, '<p>The CMS public section can now be viewed at <a href="#">Public</a></p>\n\n<p>The CMS admin can now be viewed at <a href="admin">Admin</a></p>\n\n<p>The CMS backend can now be viewed at <a href="backend">Backend</a></p>', 'published', 'public', 0, NULL, NULL, NULL, NULL, NULL, 'page', 0, 1, NULL, '2014-03-29 16:00:00', '2014-03-29 16:00:00', NULL),
(10, 'About Us', 'about-us', NULL, '<p>Doptor is an Integrated and well-designed Content Management System (CMS) provides an end user with the tools to build and maintain a sustainable web presence. For a serious company, having a maintainable website is extremely important and the effectiveness of such a site depends on the ease of use and power of the backend CMS. There are many available CMS out there but they are too generalized to fit the needs of many companies.</p>\r\n\r\n<p>Introducing the new CMS platform for businesses, which caters to their exact need without sacrificing the power and quality of a standard platform. Through this CMS, websites can be built that aims to serve as a learning and knowledge-sharing platform for the company and act as communication tool to disseminate information to the internal and external stakeholders. The website will be a tool for sharing public information and build rapport with the external stakeholders. It will be the main channel for the company to publish and share information on activities, lessons learnt from the project interventions, good practices and relevant research. In addition to having a CMS, a business needs other tools for regular operations as well. These other suites of applications run in the different departments of the company but together they ensure the moving forward of the company. In order to assist a company with all these needs, the CMS platform will include additional business modules, for example Invoicing, Bills, Accounting, Payroll, etc.</p>\r\n\r\n<p>This CMS compliable with IOS and android, other mobile devices and with all browser.</p>\r\n\r\n<p>- Doptor are provide a free opensource CMS.&nbsp;<br />\r\n- Build your website and any kind of application using doptor.<br />\r\n- Both online and offline.</p>\r\n\r\n<p>3 type of interface- 1). Backend, 2). Admin, 3). Public</p>\r\n\r\n<p>- Backend : You can manage full system.<br />\r\n- Admin : Your officer / clark can do the operation such as accounting, payroll, inventory etc.<br />\r\n- Public : &nbsp;Public website.</p>\r\n', 'published', 'public', 0, NULL, NULL, NULL, '', '', 'page', 1, 1, NULL, '2014-03-29 16:00:00', '2014-03-31 04:30:26', NULL),
(11, 'First Post', 'first-post', NULL, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi odio mauris, auctor ut varius non, tempus nec nisi. Quisque at tellus risus. Aliquam erat volutpat. Proin et dolor magna. Sed vel metus justo. Mauris eu metus massa. Duis viverra ultricies nisl, ut pharetra eros hendrerit non.</p>\n<p>Phasellus laoreet libero non eros rhoncus sed iaculis ante molestie. Etiam arcu purus, dictum a tincidunt id, ornare sed orci. Curabitur ornare ornare nulla quis tincidunt. Morbi nisi elit, mattis nec bibendum vel, facilisis eu ipsum. Phasellus non dolor erat, in placerat lacus. Aliquam pulvinar, est eu commodo vulputate, neque elit molestie lorem, sed vestibulum felis erat et risus. Nulla non velit odio.</p>\n<p>Curabitur ornare ornare nulla quis tincidunt. Morbi nisi elit, mattis nec bibendum vel, facilisis eu ipsum. Phasellus non dolor erat, in placerat lacus. Aliquam pulvinar, est eu commodo vulputate, neque elit molestie lorem, sed vestibulum felis erat et risus. Nulla non velit odio.</p>', 'published', 'public', 0, NULL, NULL, NULL, NULL, NULL, 'post', 0, 1, NULL, '2014-03-29 16:00:00', '2014-03-29 16:00:00', NULL),
(12, 'Second Post', 'second-post', NULL, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi odio mauris, auctor ut varius non, tempus nec nisi. Quisque at tellus risus. Aliquam erat volutpat. Proin et dolor magna. Sed vel metus justo. Mauris eu metus massa. Duis viverra ultricies nisl, ut pharetra eros hendrerit non.</p>\n<p>Phasellus laoreet libero non eros rhoncus sed iaculis ante molestie. Etiam arcu purus, dictum a tincidunt id, ornare sed orci. Curabitur ornare ornare nulla quis tincidunt. Morbi nisi elit, mattis nec bibendum vel, facilisis eu ipsum. Phasellus non dolor erat, in placerat lacus. Aliquam pulvinar, est eu commodo vulputate, neque elit molestie lorem, sed vestibulum felis erat et risus. Nulla non velit odio.</p>\n<p>Curabitur ornare ornare nulla quis tincidunt. Morbi nisi elit, mattis nec bibendum vel, facilisis eu ipsum. Phasellus non dolor erat, in placerat lacus. Aliquam pulvinar, est eu commodo vulputate, neque elit molestie lorem, sed vestibulum felis erat et risus. Nulla non velit odio.</p>', 'published', 'public', 0, NULL, NULL, NULL, NULL, NULL, 'post', 0, 1, NULL, '2014-03-29 16:00:00', '2014-03-29 16:00:00', NULL),
(13, 'Help', 'help', NULL, '<p>How to create accounting module :&nbsp;<br />\r\n4 steps for create any kind of module such as accounting, payroll, inventory etc. (we are keepon increase controller for form builder). Now 5%-10% programming (coding) required. Coming soon 0% coding.<br />\r\n&nbsp;<br />\r\nStep -1 : Create one or two form (Builder--&gt;Form Builder), all field name must be unique.&nbsp;<br />\r\nStep -2 : Create a module (Builder --&gt; Module Builder) and select which form you are using.&nbsp;<br />\r\nStep -3 : Install Module. go to Extension --&gt; module --&gt; Install<br />\r\nStep -4 : Create Menu (Menu manager) must assign module.<br />\r\n&nbsp;<br />\r\nThanks<br />\r\nAnd Enjoy.</p>\r\n\r\n<p>&nbsp;</p>\r\n', 'published', 'public', 0, NULL, NULL, NULL, '', '', 'page', 0, 1, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `report_generators`
--

CREATE TABLE IF NOT EXISTS `report_generators` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `modules` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `author` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `show_calendars` boolean COLLATE utf8_unicode_ci DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=28 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `description`, `value`, `created_at`, `updated_at`) VALUES
(1, 'website_name', '', 'Doptor CMS', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'footer_text', '', 'Powered by : Doptor v1.2, Copyright @ 2011-2014', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'public_offline', '', 'no', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'public_offline_end', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'admin_offline', '', 'no', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'admin_offline_end', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 'backend_offline', '', 'no', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 'backend_offline_end', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 'offline_message', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 'email_host', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 'email_port', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 'email_encryption', '', 'false', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 'email_username', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 'email_password', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 'mysqldump_path', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, 'backend_theme', '', '3', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(17, 'admin_theme', '', '2', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(18, 'public_theme', '', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(19, 'website_logo', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(20, 'facebook_link', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(21, 'twitter_link', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(22, 'gplus_link', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(23, 'company_name', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(24, 'company_address', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(25, 'company_contact', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26, 'disabled_ips', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(27, 'auto_logout_time', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `slideshow`
--

CREATE TABLE IF NOT EXISTS `slideshow` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `caption` text COLLATE utf8_unicode_ci,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'published',
  `publish_start` datetime DEFAULT NULL,
  `publish_end` datetime DEFAULT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `updated_by` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `slideshow_created_by_index` (`created_by`),
  KEY `slideshow_updated_by_index` (`updated_by`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `slideshow`
--

INSERT INTO `slideshow` (`id`, `caption`, `image`, `status`, `publish_start`, `publish_end`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(5, '<p>doptor</p>\n', 'doptor profile 11.png', 'published', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, '2014-03-26 07:17:28', '2014-03-26 07:17:28'),
(2, '<p>www.doptor.org</p>\n', 'doptor profile.png', 'published', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, '2014-03-22 03:27:07', '2014-03-22 20:59:35'),
(4, '<p>DOPTOR</p>\n', 'doptor_banner.png', 'published', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, '2014-03-26 07:15:52', '2014-03-26 07:15:52');

-- --------------------------------------------------------

--
-- Table structure for table `themes`
--

CREATE TABLE IF NOT EXISTS `themes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `author` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `screenshot` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `directory` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `target` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `themes_created_by_index` (`created_by`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `themes`
--

INSERT INTO `themes` (`id`, `name`, `version`, `author`, `description`, `screenshot`, `directory`, `target`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Default Public Theme', '1.0', '', 'Default Public Theme', '', 'default', 'public', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Default Admin Theme', '1.0', '', 'Default Admin Theme', '', 'default', 'admin', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Default Backend Theme', '1.0', '', 'Default Backend Theme', '', 'default', 'backend', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `throttle`
--

CREATE TABLE IF NOT EXISTS `throttle` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `attempts` int(11) NOT NULL DEFAULT '0',
  `suspended` tinyint(1) NOT NULL DEFAULT '0',
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `last_attempt_at` timestamp NULL DEFAULT NULL,
  `suspended_at` timestamp NULL DEFAULT NULL,
  `banned_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `throttle_user_id_index` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `security_question` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `security_answer` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `auto_logout_time` int(10) unsigned DEFAULT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `activated` tinyint(1) NOT NULL DEFAULT '0',
  `activation_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `activated_at` timestamp NULL DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `last_pw_changed` timestamp NULL DEFAULT NULL,
  `persist_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reset_password_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  KEY `users_activation_code_index` (`activation_code`),
  KEY `users_reset_password_code_index` (`reset_password_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE IF NOT EXISTS `users_groups` (
  `user_id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
