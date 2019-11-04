-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2019 �?11 �?04 �?10:02
-- 服务器版本: 5.5.53
-- PHP 版本: 5.5.38

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `ctf`
--

-- --------------------------------------------------------

--
-- 表的结构 `ctf_admin`
--

CREATE TABLE IF NOT EXISTS `ctf_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` char(32) DEFAULT NULL,
  `nickname` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `cover` varchar(100) DEFAULT NULL,
  `limit` char(1) DEFAULT NULL COMMENT '9',
  `update_time` int(11) DEFAULT NULL,
  `update_ip` varchar(16) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL COMMENT '注册时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `ctf_admin`
--

INSERT INTO `ctf_admin` (`id`, `username`, `password`, `nickname`, `email`, `cover`, `limit`, `update_time`, `update_ip`, `create_time`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Aman', NULL, NULL, '9', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `ctf_click`
--

CREATE TABLE IF NOT EXISTS `ctf_click` (
  `uid` int(11) DEFAULT NULL,
  `gid` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ctf_guestbook`
--

CREATE TABLE IF NOT EXISTS `ctf_guestbook` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `reply` int(11) DEFAULT NULL,
  `ip` varchar(16) DEFAULT NULL,
  `who` char(1) DEFAULT '0' COMMENT '回复对象 0用户 1管理员',
  `type` varchar(255) DEFAULT NULL COMMENT '0 用户 1管理员',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `ctf_links`
--

CREATE TABLE IF NOT EXISTS `ctf_links` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `logo` varchar(100) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `order` int(5) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `checkurl` varchar(100) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `status` varchar(5) DEFAULT '1',
  `hide` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `ctf_links`
--

INSERT INTO `ctf_links` (`id`, `logo`, `title`, `order`, `url`, `checkurl`, `update_time`, `status`, `hide`) VALUES
(1, NULL, 'Aman''s blog', 0, 'http://194nb.com', 'http://194nb.com', 1570442545, '1', 0);

-- --------------------------------------------------------

--
-- 表的结构 `ctf_notice`
--

CREATE TABLE IF NOT EXISTS `ctf_notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` char(1) DEFAULT NULL COMMENT '0 ctf  1正常',
  `content` varchar(255) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `ctf_safelog`
--

CREATE TABLE IF NOT EXISTS `ctf_safelog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `usertype` enum('0','1','2') DEFAULT NULL,
  `url` varchar(150) DEFAULT NULL,
  `method` varchar(10) DEFAULT NULL,
  `agent` varchar(255) DEFAULT NULL,
  `cookie` varchar(150) DEFAULT NULL,
  `data` text,
  `info` varchar(50) DEFAULT NULL,
  `type` enum('0','1','2') DEFAULT '0' COMMENT '0轻度1中度2重度',
  `ip` varchar(16) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `status` enum('0','1') DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `ctf_soft`
--

CREATE TABLE IF NOT EXISTS `ctf_soft` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `des` varchar(255) DEFAULT NULL,
  `url` varchar(200) DEFAULT NULL,
  `pass` varchar(20) DEFAULT NULL,
  `author` varchar(25) DEFAULT NULL,
  `num` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `home` varchar(100) DEFAULT NULL,
  `size` varchar(10) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `ctf_solve_log`
--

CREATE TABLE IF NOT EXISTS `ctf_solve_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `coin` decimal(10,2) DEFAULT '0.00',
  `first` char(1) DEFAULT '0' COMMENT '1是',
  `first_coin` decimal(10,2) DEFAULT '0.00',
  `create_time` int(11) DEFAULT NULL,
  `end_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='解题记录' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `ctf_subject`
--

CREATE TABLE IF NOT EXISTS `ctf_subject` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `value` int(11) DEFAULT NULL COMMENT 'jinfen',
  `type_id` int(11) DEFAULT NULL,
  `author` varchar(25) DEFAULT NULL,
  `first` int(11) DEFAULT NULL,
  `flag` varchar(40) DEFAULT NULL,
  `hint` varchar(255) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `coin` decimal(10,2) DEFAULT '0.00',
  `first_coin` decimal(10,2) DEFAULT '0.00',
  `create_time` int(11) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `urltitle` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `ctf_sys`
--

CREATE TABLE IF NOT EXISTS `ctf_sys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `webtitle` varchar(100) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `keyword` varchar(255) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `icp` varchar(255) DEFAULT NULL,
  `declare` text COMMENT '声明',
  `foot` text COMMENT 'js',
  `status` char(1) DEFAULT NULL,
  `theme` int(5) DEFAULT NULL,
  `remember` char(1) DEFAULT NULL,
  `baidumapak` varchar(50) DEFAULT NULL,
  `email` char(1) DEFAULT NULL,
  `email_username` varchar(30) DEFAULT NULL,
  `email_password` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `ctf_syslog`
--

CREATE TABLE IF NOT EXISTS `ctf_syslog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usertype` enum('0','1','2') DEFAULT '0' COMMENT '0游客1用户2管理员',
  `uid` int(11) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL COMMENT '例如登录 禁用 启用',
  `url` varchar(255) DEFAULT NULL,
  `method` varchar(5) DEFAULT NULL,
  `data` varchar(255) DEFAULT NULL,
  `result` enum('0','1') DEFAULT '0' COMMENT '0失败1成功',
  `agent` varchar(200) DEFAULT NULL,
  `cookie` varchar(100) DEFAULT NULL,
  `ip` varchar(16) DEFAULT NULL,
  `create_time` varchar(255) DEFAULT NULL,
  `info` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `ctf_tools`
--

CREATE TABLE IF NOT EXISTS `ctf_tools` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `img` varchar(100) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `des` varchar(50) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `footurl` varchar(100) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `ctf_type`
--

CREATE TABLE IF NOT EXISTS `ctf_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `type` char(1) DEFAULT NULL,
  `order` int(5) DEFAULT '0',
  `create_time` int(11) DEFAULT NULL,
  `color` char(7) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `ctf_user`
--

CREATE TABLE IF NOT EXISTS `ctf_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` char(32) DEFAULT NULL,
  `nickname` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `cover` varchar(100) DEFAULT NULL,
  `sign` varchar(255) DEFAULT NULL,
  `team_id` int(11) DEFAULT NULL,
  `coin` decimal(10,2) DEFAULT '0.00' COMMENT '金币',
  `update_time` int(11) DEFAULT NULL,
  `update_ip` varchar(16) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL COMMENT '注册时间',
  `status` enum('-1','0','1') DEFAULT '0' COMMENT '-1禁用 0未激活 1可用',
  `delete_time` int(11) DEFAULT NULL,
  `token` varchar(50) DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
