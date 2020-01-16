
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


测试表
testuser
ID,数据添加时间,姓名,年龄,手机号,座机号,邮箱,简介,用户类型,头像(25*25)
id,post_date,name,age,cell,phone,email,intro,user_type,headimg

user_type = 0:普通用户|1:普通管理员|2:超级管理员

导航菜单表
menu
id,数据添加时间,栏目名称,父级id,权限,最终操作人id,首次添加人id,最后修改时间(首次添加为0),层级,平台,模块,动作
id,post_date,name,parent_id,authority,user__id___last_do,user__id___first_do,last_update,level,plat,module,act

导航菜单表
menu
栏目名称,父级id,首次添加人id,最后修改时间(首次添加为0),层级,平台,模块,动作
name,parent_id,user__id,last_update,level,plat,module,act

level = 0:大栏目级|1:小栏目级|2:选项卡级




