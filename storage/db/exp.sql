
#vim快捷键表
#vimshortcut
#id,post_date,快捷键,快捷键说明,是否为多环境快捷键,多环境快捷键说明,主键,辅键
#id,post_date,shortcut,key_comment,is_multipart,key_multi_comment,first_key,second_key

#is_multipart = [0=>'否', 1=>'是'];

CREATE TABLE `vimshortcut` ( `id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ) ENGINE=INNODB DEFAULT CHARSET=utf8;
ALTER TABLE `vimshortcut` ADD `post_date` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0'; ALTER TABLE `` ADD INDEX ( `post_date` );
ALTER TABLE `vimshortcut` ADD `shortcut` VARCHAR( 100 )  NOT NULL DEFAULT '' COMMENT '快捷键';
ALTER TABLE `vimshortcut` ADD `key_comment` VARCHAR( 255 )  NOT NULL DEFAULT '' COMMENT '快捷键说明';
ALTER TABLE `vimshortcut` ADD `is_multipart` TINYINT( 1 )  UNSIGNED DEFAULT '0' COMMENT '是否为多环境快捷键';
ALTER TABLE `vimshortcut` ADD `key_multi_comment` VARCHAR( 255 )  NOT NULL DEFAULT '' COMMENT '多环境快捷键说明';
ALTER TABLE `vimshortcut` ADD `first_key` VARCHAR( 30 )  NOT NULL DEFAULT '' COMMENT '主键';
ALTER TABLE `vimshortcut` ADD `second_key` VARCHAR( 30 )  NOT NULL DEFAULT '' COMMENT '辅键';




用户表
user
id,post_date,账号,密码,用户昵称,手机号,邮箱,用户级别,状态,头像,来源,最后更新时间,是否在线,干扰字符,用户类型,是否删除
id,post_date,acc,pwd,nickname,cell,email,level,status,img,ori,upd_date,is_online,salt,user_type,is_del

user_type = 0:无|1:供应商

管理员权限表
admin_power
ID,post_date,user表id,menu表id,父menu的id,祖父menu的id,是否删除
id,post_date,user__id,menu__id,menu_level2_id,menu_level1_id,is_del


大事件
event
id,post_date,标题,备注内容,事件产生时间,事件结束时间,是否删除
id,post_date,title,descr,begin_time,end_time,is_del


商品表
tl_goods
id,post_date,商品名称,商品标准价格,商品编号,商品分类id,商品类型id,品牌id,供应商id,点击量,商品总数量,报警数量,商品描述,排序,商品销售状态,审核状态,是否删除
id,post_date,name,normal_price,sn,tl_goods_category__id,tl_goods_type__id,tl_goods_brand__id,tl_suppliers__id,click_num,total_num,warning_num,descr,sort_order,sale_type,check_type,is_del

sale_type = 0:下架|1:上架
check_type = 0:待审核|1:审核中|2:已审核-未通过|3:已审核-已通过

CREATE TABLE `tl_goods` ( `id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ) ENGINE=INNODB DEFAULT CHARSET=utf8;
ALTER TABLE `tl_goods` ADD `post_date` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0'; ALTER TABLE `tl_goods` ADD INDEX ( `post_date` );
ALTER TABLE `tl_goods` ADD `name` VARCHAR( 100 )  NOT NULL DEFAULT '' COMMENT '商品名称';
ALTER TABLE `tl_goods` ADD `normal_price` DECIMAL( 10,2 )  UNSIGNED DEFAULT '0.0000' COMMENT '商品标准价格';
ALTER TABLE `tl_goods` ADD `sn` VARCHAR( 255 )  NOT NULL DEFAULT '' COMMENT '商品编号';
ALTER TABLE `tl_goods` ADD `tl_goods_category__id` INT( 4 )  UNSIGNED DEFAULT '0' COMMENT '商品分类id';
ALTER TABLE `tl_goods` ADD `tl_goods_type__id` INT( 4 )  UNSIGNED DEFAULT '0' COMMENT '商品类型id';
ALTER TABLE `tl_goods` ADD `tl_goods_brand__id` INT( 4 )  UNSIGNED DEFAULT '0' COMMENT '品牌id';
ALTER TABLE `tl_goods` ADD `tl_suppliers__id` INT( 4 )  UNSIGNED DEFAULT '0' COMMENT '供应商id';
ALTER TABLE `tl_goods` ADD `click_num` MEDIUMINT( 3 )  UNSIGNED DEFAULT '0' COMMENT '点击量';
ALTER TABLE `tl_goods` ADD `total_num` MEDIUMINT( 3 )  UNSIGNED DEFAULT '0' COMMENT '商品总数量';
ALTER TABLE `tl_goods` ADD `unit` VARCHAR( 10 )  NOT NULL DEFAULT '' COMMENT '数量单位';
ALTER TABLE `tl_goods` ADD `warning_num` SMALLINT( 2 )  UNSIGNED DEFAULT '0' COMMENT '报警数量';
ALTER TABLE `tl_goods` ADD `descr` TEXT NOT NULL COMMENT '商品描述';
ALTER TABLE `tl_goods` ADD `sort_order` TINYINT( 1 )  UNSIGNED DEFAULT '0' COMMENT '排序';
ALTER TABLE `tl_goods` ADD `sale_type` TINYINT( 1 )  UNSIGNED DEFAULT '0' COMMENT '商品销售状态';
ALTER TABLE `tl_goods` ADD `check_type` TINYINT( 1 )  UNSIGNED DEFAULT '0' COMMENT '审核状态';
ALTER TABLE `tl_goods` ADD `is_del` TINYINT( 1 )  UNSIGNED DEFAULT '0' COMMENT '是否删除';


商品款式表
tl_goods_style
id,post_date,商品id,款式名称,本款商品价格,本款商品单位重量,本款商品数量
id,post_date,tl_goods__id,name,goods_price,weigt,num


商品价格梯度表
tl_goods_price
id,post_date,商品id,商品款式id,数量,折扣,是否删除
id,post_date,tl_goods__id,tl_goods_style__id,buy_num,discount


商品图片表
tl_goods_img
id,post_date,图片路径,限定宽度,限定高度,是否删除
id,post_date,img,width,height,is_del


商品-商品图片表
tl_goods__goods_img
id,post_date,商品id,商品图片id,图片类型
id,post_date,tl_goods__id,tl_goods_img__id,img_type

img_type = 0:商品主图|1:商品大图|2:商品缩略图


商品款式-商品图片表
tl_goods_style__goods_img
id,post_date,商品款式id,商品图片id,图片类型
id,post_date,tl_goods_style__id,tl_goods_img__id,img_type

img_type = 1:商品款式大图|2:商品款式缩略图

商品分类表
tl_goods_category
id,post_date,分类名称,父级id,层级
id,post_date,name,parent_id,level


商品类型
tl_goods_type
id,post_date,类型名称
id,post_date,name


属性表
tl_attr
id,post_date,属性名,所属商品类型id,input表单类型,选项值,排序
id,post_date,name,tl_goods_type__id,input_type,options,sort_order

input_type = 0:text|1:select|2:checkbox

商品-属性表
id,post_date,商品id,属性id,属性值
id,post_date,tl_goods__id,tl_attr__id,val

商品品牌表
tl_goods_brand
id,post_date,品牌名称,logo图片,品牌描述
id,post_date,name,logo_img,descr


供应商表
tl_suppliers
id,post_date,名称,详细描述
id,post_date,name,descr


订单表
tl_orders
id,post_date,订单号,用户id,总重量,总数量,快递费,总价(含快递费),支付状态,订单状态,物流状态,物流id,支付方式id,支付方式名称,支付时间,订单由商家确认时间,物流开始时间,邮编,收件地址国家,收件地址省,收件地址市,收件地址区或街道,收件详细地址,收件人真实姓名,收件人手机号
id,post_date,sn,tl_user__id,total_weight,total_num,express_price,total_price,pay_stat,order_stat,shipping_stat,tl_shipping__id,tl_pay__id,tl_pay__name,pay_time,confirm_time,shipping_time,post_code,country,province,city,district,address,consignee,cell

#特别说明：订单表之所以很多字段做冗余，是因为这些冗余字段的信息在订单形成后，不应该随着源信息的改变而改变。

pay_stat = 0:未支付|1:已支付
order_stat = 0:进行中|1:已完成|2:已取消
shipping_stat = 0:待发货|1:已发货|2:代签收|3:已签收


订单详情表
tl_orders_goods
id,post_date,订单id,商品id,商品名称,商品款式id,商品款式名称,商品款式缩略图,商品原价总和,商品购买价总和,商品重量总和,重量单位,购买数量,数量单位
id,post_date,tl_orders__id,tl_goods__id,tl_goods__name,tl_goods_style__id,tl_goods_style__name,goods_style_thumb,total_ori_price,total_buy_price,total_weight,weight_unit,buy_num,num_unit

#特别说明：商品信息随着时间的变化大概率可能会不断的变化，但是形成订单的商品其商品信息应该被固化在订单中，以便日后回溯。


地区表
tl_region









