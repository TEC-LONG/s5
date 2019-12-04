-- phpMyAdmin SQL Dump
-- version 4.0.10.20
-- https://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2017-11-30 23:28:04
-- 服务器版本: 5.5.24
-- PHP 版本: 5.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `bg`
--

-- --------------------------------------------------------

--
-- 表的结构 `bg_cat`
--

CREATE TABLE IF NOT EXISTS `bg_cat` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_date` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '分类名称',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类id',
  `article_nums` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '直属文章数量',
  `level` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '节点层级',
  `is_have_child` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否有子节点',
  `child_nums` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '直属子节点总个数',
  PRIMARY KEY (`id`),
  KEY `post_date` (`post_date`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- 转存表中的数据 `bg_cat`
--

INSERT INTO `bg_cat` (`id`, `post_date`, `name`, `parent_id`, `article_nums`, `level`, `is_have_child`, `child_nums`) VALUES
(1, 0, '教育', 0, 0, 1, 0, 0),
(2, 0, '科技', 0, 0, 1, 0, 0),
(3, 0, '生活', 0, 0, 1, 0, 0),
(4, 0, '教材', 1, 0, 2, 0, 0),
(5, 0, '外语', 1, 0, 2, 0, 0),
(6, 0, '文学', 2, 0, 2, 0, 0),
(7, 0, '传记', 2, 0, 2, 0, 0),
(8, 0, '青春文学', 3, 0, 2, 0, 0),
(9, 0, '动漫', 3, 0, 2, 0, 0),
(10, 0, '研究生/本科', 4, 0, 3, 0, 0),
(11, 0, '高职高专', 4, 0, 3, 0, 0),
(12, 0, '英语综合教程', 5, 0, 3, 0, 0),
(13, 0, '英语专项训练', 5, 0, 3, 0, 0),
(14, 0, '文集', 6, 0, 3, 0, 0),
(15, 0, '纪实文学', 6, 0, 3, 0, 0),
(16, 0, '财经人物', 7, 0, 3, 0, 0),
(17, 0, '历代帝王', 7, 0, 3, 0, 0),
(18, 0, '校园', 8, 0, 3, 0, 0),
(19, 0, '爱情/情感', 8, 0, 3, 0, 0),
(20, 0, '大陆漫画', 9, 0, 3, 0, 0),
(21, 0, '港台漫画', 9, 0, 3, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `bg_user`
--

CREATE TABLE IF NOT EXISTS `bg_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_date` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `acc` varchar(30) NOT NULL DEFAULT '' COMMENT '帐号',
  `pwd` char(32) NOT NULL DEFAULT '' COMMENT '密码',
  `nickname` varchar(30) NOT NULL DEFAULT '' COMMENT '用户昵称',
  `cell` varchar(20) NOT NULL DEFAULT '' COMMENT '手机号',
  `email` varchar(100) NOT NULL DEFAULT '' COMMENT '邮箱',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '用户级别',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  `img` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `ori` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '来源',
  `upd_date` int(4) unsigned NOT NULL DEFAULT '0' COMMENT '最后更新时间',
  `is_online` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否在线',
  `salt` char(6) NOT NULL DEFAULT '' COMMENT '干扰字符',
  PRIMARY KEY (`id`),
  KEY `post_date` (`post_date`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `bg_user`
--

INSERT INTO `bg_user` (`id`, `post_date`, `acc`, `pwd`, `nickname`, `cell`, `email`, `level`, `status`, `img`, `ori`, `upd_date`, `is_online`, `salt`) VALUES
(3, 1510669377, 'lisi', '12d4dfda374039f3d8907ea86b06e71e', 'xiaols', '18588999999', 'a@admin.com', 1, 0, 'bg_5a0fb1b64bb2a2017111812061468.jpg', 1, 0, 0, '84M6ec'),
(4, 1510987197, 'zhangsan', 'e6ff3c0920c521f5e19faa7be74cafcc', 'xiaozs', '18588999999', 'a@admin.com', 1, 0, 'bg_5a0fd5bda492520171118143957100.png', 1, 0, 0, 'p8UYUz');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
