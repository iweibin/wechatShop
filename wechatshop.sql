-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2017-04-27 17:06:59
-- 服务器版本： 10.1.13-MariaDB
-- PHP Version: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wechatshop`
--

-- --------------------------------------------------------

--
-- 表的结构 `address`
--

CREATE TABLE `address` (
  `add_id` mediumint(8) UNSIGNED NOT NULL COMMENT '主键',
  `user_id` int(8) UNSIGNED NOT NULL COMMENT '所属用户ID',
  `add_default` varchar(1) NOT NULL COMMENT '是否默认地址：0不是，1是',
  `add_province` varchar(40) NOT NULL COMMENT '省',
  `add_city` varchar(40) NOT NULL COMMENT '市',
  `add_area` varchar(40) NOT NULL COMMENT '区',
  `add_street` varchar(40) NOT NULL COMMENT '街道',
  `add_detail` varchar(100) NOT NULL COMMENT '详细地址',
  `add_name` varchar(40) NOT NULL COMMENT '收件人名字',
  `add_telephone` varchar(13) NOT NULL COMMENT '收件人电话'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='地址信息表';

-- --------------------------------------------------------

--
-- 表的结构 `goods`
--

CREATE TABLE `goods` (
  `gid` int(10) UNSIGNED NOT NULL COMMENT '商品编号',
  `gname` varchar(20) NOT NULL COMMENT '商品名称',
  `gtype_id` int(10) UNSIGNED NOT NULL COMMENT '商品类型的编号',
  `gimg_id` int(10) UNSIGNED NOT NULL COMMENT '商品主图片',
  `gdec_s` varchar(100) NOT NULL COMMENT '商品主页描述（短）',
  `gdec_l` text COMMENT '商品主页描述（长）',
  `gpri` varchar(100) NOT NULL COMMENT '商品价格',
  `gnum` int(10) UNSIGNED NOT NULL COMMENT '商品数量',
  `gchoice` int(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否精选（总精选2，次精选1，否0）',
  `gpreferential` int(1) DEFAULT '0' COMMENT '是否特惠',
  `gclass_id` int(10) UNSIGNED NOT NULL COMMENT '商品购买时分类模块的编号',
  `gsales` int(8) DEFAULT '0' COMMENT '产品销量',
  `gpic` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品信息表';

--
-- 转存表中的数据 `goods`
--

INSERT INTO `goods` (`gid`, `gname`, `gtype_id`, `gimg_id`, `gdec_s`, `gdec_l`, `gpri`, `gnum`, `gchoice`, `gpreferential`, `gclass_id`, `gsales`, `gpic`) VALUES
(1, 'pingguo', 1, 9, '', NULL, '10', 10, 2, 0, 0, 12001, '["pingguo1.png","pingguo2.png","pingguo3.png"]'),
(2, 'yezi', 1, 10, '', NULL, '12', 0, 2, 1, 0, 224, '["yezi.png"]'),
(3, 'xiangjiao', 2, 11, '', NULL, '23', 0, 2, 1, 0, 4524, '["xiangjiao.png"]'),
(4, 'juzi', 3, 12, '', NULL, '50', 0, 2, 0, 0, 12, '["juzi.png"]'),
(5, 'xigua', 2, 13, '', NULL, '99', 0, 2, 1, 0, 52, '["xigua.png"]');

-- --------------------------------------------------------

--
-- 表的结构 `goods_class`
--

CREATE TABLE `goods_class` (
  `gtype_id` int(10) UNSIGNED NOT NULL COMMENT '商品类型的编号',
  `gtype_name` varchar(40) NOT NULL COMMENT '商品类型名称'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品类型表';

--
-- 转存表中的数据 `goods_class`
--

INSERT INTO `goods_class` (`gtype_id`, `gtype_name`) VALUES
(1, 'wenchuang'),
(2, 'wenju'),
(3, 'dszp');

-- --------------------------------------------------------

--
-- 表的结构 `master`
--

CREATE TABLE `master` (
  `master_id` int(4) UNSIGNED NOT NULL COMMENT '大师id',
  `master_name` varchar(200) NOT NULL COMMENT '大师名字',
  `master_skill` varchar(200) NOT NULL COMMENT '技艺名称',
  `master_summary` mediumtext NOT NULL COMMENT '简介',
  `master_picture` varchar(100) NOT NULL COMMENT '头像'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='大师信息表';

-- --------------------------------------------------------

--
-- 表的结构 `order`
--

CREATE TABLE `order` (
  `order_id` mediumint(8) UNSIGNED NOT NULL COMMENT '主键ID',
  `order_status` varchar(1) NOT NULL COMMENT '订单状态：0待付款，1待发货，2待收货，3退换货',
  `user_id` int(8) UNSIGNED NOT NULL COMMENT '所属用户ID',
  `shopping_order_id` int(10) UNSIGNED NOT NULL COMMENT '对应购物车商品编号',
  `order_time` varchar(20) NOT NULL COMMENT '下单时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单表';

-- --------------------------------------------------------

--
-- 表的结构 `shopping_cart`
--

CREATE TABLE `shopping_cart` (
  `shopping_order_id` int(10) UNSIGNED NOT NULL COMMENT '订单编号',
  `gid` int(10) UNSIGNED NOT NULL COMMENT '商品编号',
  `bnum` int(10) UNSIGNED NOT NULL COMMENT '购买数量',
  `status` int(10) UNSIGNED NOT NULL DEFAULT '1' COMMENT '商品状态',
  `user_id` int(10) UNSIGNED NOT NULL COMMENT '用户编号'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='购物车表';

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `user_id` int(8) UNSIGNED NOT NULL COMMENT '用户id',
  `openid` varchar(40) NOT NULL COMMENT 'openid',
  `nickname` varchar(200) DEFAULT NULL COMMENT '用户昵称',
  `wechat` varchar(40) NOT NULL COMMENT '用户微信号',
  `sex` varchar(1) DEFAULT NULL COMMENT '性别',
  `user_picture` varchar(100) NOT NULL COMMENT '头像',
  `telephone` varchar(13) DEFAULT NULL COMMENT '用户电话',
  `address_id` mediumint(8) UNSIGNED DEFAULT NULL COMMENT '默认收货地址'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户信息表';

-- --------------------------------------------------------

--
-- 表的结构 `works`
--

CREATE TABLE `works` (
  `works_id` int(8) UNSIGNED NOT NULL COMMENT '作品 id',
  `master_id` int(4) UNSIGNED NOT NULL COMMENT '所属大师 id',
  `works_name` varchar(200) NOT NULL COMMENT '作品名称',
  `works_summary` mediumtext COMMENT '作品简介',
  `works_status` varchar(1) NOT NULL COMMENT '作品状态：0下架 1缺货 2在售',
  `works_prize` double NOT NULL COMMENT '作品价格',
  `works_num` int(4) NOT NULL COMMENT '作品数量'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='大师作品信息表';

-- --------------------------------------------------------

--
-- 表的结构 `works_pic`
--

CREATE TABLE `works_pic` (
  `pic_id` int(8) UNSIGNED NOT NULL COMMENT '主键ID',
  `works_id` int(8) UNSIGNED NOT NULL COMMENT '所属作品id',
  `pic_path` varchar(100) NOT NULL COMMENT '图片路径'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='大师作品图片表';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`add_id`);

--
-- Indexes for table `goods`
--
ALTER TABLE `goods`
  ADD PRIMARY KEY (`gid`);

--
-- Indexes for table `goods_class`
--
ALTER TABLE `goods_class`
  ADD PRIMARY KEY (`gtype_id`);

--
-- Indexes for table `master`
--
ALTER TABLE `master`
  ADD PRIMARY KEY (`master_id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD PRIMARY KEY (`shopping_order_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `works`
--
ALTER TABLE `works`
  ADD PRIMARY KEY (`works_id`);

--
-- Indexes for table `works_pic`
--
ALTER TABLE `works_pic`
  ADD PRIMARY KEY (`pic_id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `address`
--
ALTER TABLE `address`
  MODIFY `add_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键';
--
-- 使用表AUTO_INCREMENT `goods`
--
ALTER TABLE `goods`
  MODIFY `gid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '商品编号', AUTO_INCREMENT=6;
--
-- 使用表AUTO_INCREMENT `goods_class`
--
ALTER TABLE `goods_class`
  MODIFY `gtype_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '商品类型的编号', AUTO_INCREMENT=4;
--
-- 使用表AUTO_INCREMENT `master`
--
ALTER TABLE `master`
  MODIFY `master_id` int(4) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '大师id';
--
-- 使用表AUTO_INCREMENT `order`
--
ALTER TABLE `order`
  MODIFY `order_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键ID';
--
-- 使用表AUTO_INCREMENT `shopping_cart`
--
ALTER TABLE `shopping_cart`
  MODIFY `shopping_order_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '订单编号';
--
-- 使用表AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '用户id';
--
-- 使用表AUTO_INCREMENT `works`
--
ALTER TABLE `works`
  MODIFY `works_id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '作品 id';
--
-- 使用表AUTO_INCREMENT `works_pic`
--
ALTER TABLE `works_pic`
  MODIFY `pic_id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键ID';
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
