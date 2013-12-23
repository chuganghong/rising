-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2013 年 10 月 29 日 02:03
-- 服务器版本: 5.6.12-log
-- PHP 版本: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `king`
--
CREATE DATABASE IF NOT EXISTS `rising` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `rising`;

-- --------------------------------------------------------

--
-- 表的结构 `sd_admin_action`
--

CREATE TABLE IF NOT EXISTS `sd_admin_action` (
  `action_id` tinyint(3) NOT NULL AUTO_INCREMENT,
  `parent_id` tinyint(3) NOT NULL DEFAULT '0',
  `action_code` varchar(50) NOT NULL,
  PRIMARY KEY (`action_id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=78 ;

--
-- 转存表中的数据 `sd_admin_action`
--

INSERT INTO `sd_admin_action` (`action_id`, `parent_id`, `action_code`) VALUES
(5, 0, 'priv'),
(6, 0, 'db'),
(31, 5, 'admin_manage'),
(32, 5, 'admin_pass'),
(33, 5, 'admin_drop'),
(34, 5, 'logs_manage'),
(35, 5, 'logs_drop'),
(36, 5, 'role_manage'),
(37, 6, 'db_backup'),
(38, 6, 'db_restore'),
(39, 6, 'db_optimize'),
(40, 6, 'sql_query'),
(77, 76, 'flash_manage'),
(76, 0, 'ads'),
(72, 68, 'Case_drop'),
(71, 68, 'Case_manage'),
(70, 68, 'Case_cat_drop'),
(69, 68, 'Case_cat_manage'),
(68, 0, 'Case');

-- --------------------------------------------------------

--
-- 表的结构 `sd_admin_log`
--

CREATE TABLE IF NOT EXISTS `sd_admin_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `log_time` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `log_info` varchar(255) NOT NULL DEFAULT '',
  `ip_address` varchar(15) NOT NULL DEFAULT '',
  PRIMARY KEY (`log_id`),
  KEY `log_time` (`log_time`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `sd_admin_user`
--

CREATE TABLE IF NOT EXISTS `sd_admin_user` (
  `user_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(60) NOT NULL,
  `true_name` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(32) NOT NULL,
  `add_time` int(11) NOT NULL DEFAULT '0',
  `last_login` int(11) NOT NULL DEFAULT '0',
  `last_ip` varchar(15) NOT NULL,
  `role_id` smallint(6) DEFAULT NULL,
  `agency_id` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY `user_name` (`user_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `sd_admin_user`
--

INSERT INTO `sd_admin_user` (`user_id`, `user_name`, `true_name`, `email`, `password`, `add_time`, `last_login`, `last_ip`, `role_id`, `agency_id`) VALUES
(1, 'admin', 'wing', 'benang@163.com', 'e10adc3949ba59abbe56e057f20f883e', 1284434890, 1373593786, '127.0.0.1', 1, 0),
(2, 'king', 'king', 'hdx_232855512@qq.com', '5583413443164b56500def9a533c7c70', 1284434890, 1379390709, '127.0.0.1', 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `sd_case`
--

CREATE TABLE IF NOT EXISTS `sd_case` (
  `case_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cat_id` smallint(6) NOT NULL DEFAULT '0',
  `title` varchar(200) DEFAULT NULL,
  `sort_order` tinyint(4) NOT NULL DEFAULT '0',
  `keyword` varchar(100) DEFAULT NULL,
  `content` mediumtext,
  `title_en` varchar(200) NOT NULL,
  `keyword_en` varchar(100) NOT NULL,
  `content_en` mediumtext NOT NULL,
  `title_tw` varchar(200) NOT NULL,
  `keyword_tw` varchar(100) NOT NULL,
  `content_tw` mediumtext NOT NULL,
  `g_pic` varchar(50) NOT NULL,
  `addtime` int(11) NOT NULL DEFAULT '0',
  `author` varchar(20) DEFAULT NULL,
  `click` int(11) NOT NULL DEFAULT '0',
  `updatetime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`case_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `sd_case_cat`
--

CREATE TABLE IF NOT EXISTS `sd_case_cat` (
  `cat_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `typeid` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1为图片2为新闻3为自定4自定义页面',
  `stype` varchar(200) NOT NULL,
  `cat_name` varchar(90) NOT NULL,
  `action_name` varchar(50) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `cat_desc` varchar(255) NOT NULL,
  `cat_name_en` varchar(90) NOT NULL,
  `keywords_en` varchar(255) NOT NULL,
  `cat_desc_en` varchar(255) NOT NULL,
  `cat_name_tw` varchar(90) NOT NULL,
  `keywords_tw` varchar(255) NOT NULL,
  `cat_desc_tw` varchar(255) NOT NULL,
  `parent_id` smallint(6) NOT NULL DEFAULT '0',
  `sort_order` tinyint(4) NOT NULL,
  `show_in_nav` tinyint(4) NOT NULL DEFAULT '0',
  `tid` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0为链接管理，1为栏目管理',
  PRIMARY KEY (`cat_id`),
  KEY `cat_name` (`cat_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

-- --------------------------------------------------------

--
-- 表的结构 `sd_contact_us`
--

CREATE TABLE IF NOT EXISTS `sd_contact_us` (
  `u_Id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `u_Name` varchar(20) NOT NULL,
  `u_Email` varchar(20) NOT NULL,
  `u_Message` text NOT NULL,
  `u_Tel` varchar(20) NOT NULL,
  `u_Addtime` int(11) NOT NULL,
  PRIMARY KEY (`u_Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `sd_flash_play`
--

CREATE TABLE IF NOT EXISTS `sd_flash_play` (
  `flash_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `cat_id` smallint(6) NOT NULL,
  `img_type` tinyint(2) NOT NULL DEFAULT '0',
  `img_src` varchar(50) NOT NULL,
  `img_link` varchar(50) NOT NULL,
  `img_title` varchar(20) NOT NULL,
  `img_alt` varchar(20) NOT NULL,
  `img_sort` smallint(6) NOT NULL DEFAULT '0',
  `img_title_en` varchar(20) NOT NULL,
  `img_alt_en` varchar(20) NOT NULL,
  `img_title_tw` varchar(20) NOT NULL,
  `img_alt_tw` varchar(20) NOT NULL,
  PRIMARY KEY (`flash_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `sd_role`
--

CREATE TABLE IF NOT EXISTS `sd_role` (
  `role_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(60) NOT NULL DEFAULT '',
  `action_list` text NOT NULL,
  `role_describe` text,
  PRIMARY KEY (`role_id`),
  KEY `user_name` (`role_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `sd_role`
--

INSERT INTO `sd_role` (`role_id`, `role_name`, `action_list`, `role_describe`) VALUES
(1, '超级管理员', 'all', '超级管理员');

-- --------------------------------------------------------

--
-- 表的结构 `sd_sys_config`
--

CREATE TABLE IF NOT EXISTS `sd_sys_config` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `config_name` varchar(20) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `config_name` (`config_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- 转存表中的数据 `sd_sys_config`
--

INSERT INTO `sd_sys_config` (`id`, `config_name`, `value`) VALUES
(1, 'badkey', '法轮功|胡锦涛|五四运动|当局|该国'),
(2, 'smtp_host', 'smtp.qq.com'),
(3, 'smtp_port', '25'),
(4, 'smtp_user', '1073712069@qq.com'),
(5, 'smtp_pass', '178554120'),
(6, 'smtp_mail', '1073712069@qq.com'),
(7, 'mail_service', '1'),
(8, 'show_shop_record', '9'),
(9, 'show_shop_refresh', '10'),
(10, 'integral_ratio', '1'),
(11, 'integral_deduct', '1'),
(12, 'visit_stats', 'on'),
(13, 'description', 'description'),
(14, 'keywords', 'keywords'),
(15, 'upload_allowext', '*.zip|*.rar|*.exe|*.pdf|*.bfx');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
