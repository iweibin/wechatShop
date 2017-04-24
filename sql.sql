-- --------------------------------------------------------

-- 用户信息表

CREATE TABLE IF NOT EXISTS `wx_user` (
  `user_id` mediumint(8) NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `openid` varchar(40) NOT NULL COMMENT 'openid',
  `nickname` varchar(200) NULL COMMENT '用户昵称',
  `sex` int(1) NULL COMMENT '性别',
  `avatar` varchar(200) NOT NULL  COMMENT '头像',
  `province` varchar(50) NULL COMMENT '省份',
  `city` varchar(50) NULL COMMENT '城市',
  `country` varchar(50) NULL COMMENT '国家',
  `telephone` varchar(13) NULL COMMENT '用户电话',
  `address_id` mediumint(8) NULL COMMENT '默认收货地址',
  `last_login` varchar(10) NULL COMMENT '最后登录时间',
  PRIMARY KEY (`user_id`)
) 
ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT = '用户信息表';

--管理员信息表

CREATE TABLE IF NOT EXISTS `wx_admin` (
  `uid` mediumint(8) NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `username` varchar(20) NOT NULL COMMENT '用户名',
  `password` varchar(40) NOT NULL COMMENT '用户密码',
  `nickname` varchar(200) NULL COMMENT '用户昵称',
  `avatar` varchar(200) NULL  COMMENT '头像',
  `email` varchar(20) NULL COMMENT '电子邮箱',
  `telephone` varchar(13) NULL COMMENT '用户电话',
  `user_key` varchar(8) NOT NULL COMMENT 'userKey',
  `level` int(1) NOT NULL DEFAULT '6' COMMENT '用户级别',
  `last_login` varchar(10) NULL COMMENT '最后登录时间',
  PRIMARY KEY (`uid`)
) 
ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT = '管理员信息表';

-- --------------------------------------------------------
-- 商品信息表

CREATE TABLE IF NOT EXISTS `wx_goods` (
  `gid` int(10) NOT NULL AUTO_INCREMENT COMMENT '商品编号',
  `gname` varchar(20) NOT NULL COMMENT '商品名称',
  `gtype_id` int(10) NOT NULL COMMENT '商品类型的编号',
  `gimg_id` int(10) NOT NULL COMMENT '商品主页滚动图片编号',
  `gdec_s` varchar(100) NOT NULL COMMENT '商品主页描述（短）',
  `gdec_l` text COMMENT '商品主页描述（长）',
  `gpri` int(10) NOT NULL COMMENT '商品价格',
  `gnum` int(10) NOT NULL COMMENT '商品数量',
  `gclass_id` int(10) NOT NULL COMMENT '商品购买时分类模块的编号',
  PRIMARY KEY (`gid`)
) 
ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品信息表';





-- 大师信息表

CREATE TABLE IF NOT EXISTS `wx_master` (
  `master_id` int(4) unsigned NOT NULL AUTO_INCREMENT COMMENT '大师id',
  `master_name` varchar(200) NOT NULL COMMENT '大师名字',
  `master_skill` varchar(200) NOT NULL COMMENT '技艺名称',
  `master_summary` mediumtext NOT NULL COMMENT '简介',
  `master_picture` varchar(100) NOT NULL COMMENT '头像',
  PRIMARY KEY (`master_id`)
) 
ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT = '大师信息表';

-- --------------------------------------------------------

-- 大师作品信息表

CREATE TABLE IF NOT EXISTS `wx_works` (
  `works_id` int(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '作品 id',
  `master_id` int(4) unsigned NOT NULL COMMENT '所属大师 id',
  `works_name` varchar(200) NOT NULL COMMENT '作品名称',
  `works_summary` mediumtext NULL COMMENT '作品简介',
  `works_status` varchar (1) NOT NULL COMMENT '作品状态：0下架 1缺货 2在售',
  `works_prize` double NOT NULL COMMENT '作品价格',
  `works_num` int(4) NOT NULL COMMENT '作品数量',
  PRIMARY KEY (`works_id`)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT = '大师作品信息表';

-- --------------------------------------------------------

-- 大师作品图片表

CREATE TABLE IF NOT EXISTS `wx_works_pic` (
  `pic_id` int(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `works_id` int(8) unsigned NOT NULL COMMENT '所属作品id',
  `pic_path` varchar(100) NOT NULL COMMENT '图片路径',
  PRIMARY KEY (`pic_id`)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '大师作品图片表';

-- --------------------------------------------------------

-- 地址信息表

CREATE TABLE IF NOT EXISTS `wx_address` (
  `add_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `user_id` int(8) unsigned NOT NULL COMMENT '所属用户ID',
  `add_default` varchar(1) NOT NULL COMMENT '是否默认地址：0不是，1是',
  `add_province` varchar(40) NOT NULL COMMENT '省',
  `add_city` varchar(40) NOT NULL COMMENT '市',
  `add_area` varchar(40) NOT NULL COMMENT '区',
  `add_street` varchar(40) NOT NULL COMMENT '街道',
  `add_detail` varchar(100) NOT NULL COMMENT '详细地址',
  `add_name` varchar(40) NOT NULL COMMENT '收件人名字',
  `add_telephone` varchar(13) NOT NULL COMMENT '收件人电话',
  PRIMARY KEY (`add_id`)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT ='地址信息表';

-- --------------------------------------------------------

-- 订单表

CREATE TABLE IF NOT EXISTS `wx_order` (
  `order_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `order_status` varchar(1) NOT NULL COMMENT '订单状态：0待付款，1待发货，2待收货，3退换货',
  `user_id` int(8) unsigned NOT NULL COMMENT '所属用户ID',
  `shopping_order_id` int(10) NOT NULL COMMENT '对应购物车商品编号',
  `order_time` varchar(20) NOT NULL COMMENT '下单时间',
  PRIMARY KEY (`order_id`)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT = '订单表';



-- --------------------------------------------------------

-- 商品选择分类表

CREATE TABLE IF NOT EXISTS `wx_goods_class` (
  `gclass_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '商品选择分类编号',
  `gclass_name` varchar(40) NOT NULL COMMENT '商品选择分类名称',
  `value` varchar(100) NOT NULL COMMENT '商品选择分类值',
  PRIMARY KEY (`gclass_id`)
) 
ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品选择分类表';

-- --------------------------------------------------------

-- 购物车表

CREATE TABLE IF NOT EXISTS `wx_shopping_cart` (
  `shopping_order_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '订单编号',
  `gid` int(10) UNSIGNED NOT NULL COMMENT '商品编号',
  `bnum` int(10) UNSIGNED NOT NULL COMMENT '购买数量',
  `status` int(10) UNSIGNED NOT NULL DEFAULT '1' COMMENT '商品状态',
  `user_id` int(10) UNSIGNED NOT NULL COMMENT '用户编号',
  PRIMARY KEY (`shopping_order_id`)
) 
ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='购物车表';

-- --------------------------------------------------------

-- 商品类型表

CREATE TABLE IF NOT EXISTS `wx_goods_class` (
  `gtype_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '商品类型的编号',
  `gtype_name` varchar(40) NOT NULL COMMENT '商品类型名称',
  PRIMARY KEY (`gtype_id`)
) 
ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品类型表';

-- --------------------------------------------------------

-- 商品图片表

CREATE TABLE IF NOT EXISTS `wx_gimg` (
  `gimg_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品图片编号',
  `gimg_url` varchar(100) NOT NULL COMMENT '商品图片url',
  PRIMARY KEY (`gimg_id`)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '商品图片表';

-- --------------------------------------------------------