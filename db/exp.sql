#表前缀：exp

#导航菜单表
#menu
#栏目名称,父级id,权限,最后操作人真实姓名,最终操作人id,首次添加人真实姓名,首次添加人id,最后修改时间(首次添加为0),层级,平台,模块,动作
#name,parent_id,authority,last_add_user,last_add_userid,first_add_user,first_add_userid,last_update,level,plat,module,act

#level = {'0':普通用户; 1:管理员}
#status = {'0':正常;1:禁用}
#ori = {'0':注册;1:后台添加}
#is_online={0:未知;1:在线;2:离线}

CREATE TABLE `bg_user` ( `id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ) ENGINE=INNODB DEFAULT CHARSET=utf8;
ALTER TABLE `bg_user` ADD `post_date` INT( 11 ) UNSIGNED NOT NULL DEFAULT '0' COMMENT '注册时间'; ALTER TABLE `bg_user` ADD INDEX ( `post_date` );
ALTER TABLE `bg_user` ADD `acc` VARCHAR( 30 ) NOT NULL DEFAULT ''  COMMENT '账号';
ALTER TABLE `bg_user` ADD `pwd` CHAR( 32 ) NOT NULL DEFAULT ''  COMMENT '密码';
ALTER TABLE `bg_user` ADD `nickname` VARCHAR( 30 ) NOT NULL DEFAULT ''  COMMENT '用户昵称';
ALTER TABLE `bg_user` ADD `cell` VARCHAR( 20 ) NOT NULL DEFAULT ''  COMMENT '手机号';
ALTER TABLE `bg_user` ADD `email` VARCHAR( 100 ) NOT NULL DEFAULT ''  COMMENT '邮箱';
ALTER TABLE `bg_user` ADD `level` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '0' COMMENT '用户级别';
ALTER TABLE `bg_user` ADD `status` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '0' COMMENT '状态';
ALTER TABLE `bg_user` ADD `img` VARCHAR( 255 ) NOT NULL DEFAULT ''  COMMENT '头像';
ALTER TABLE `bg_user` ADD `ori` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '0' COMMENT '来源';
ALTER TABLE `bg_user` ADD `upd_date` INT( 4 ) UNSIGNED NOT NULL DEFAULT '0' COMMENT '最后更新时间';
ALTER TABLE `bg_user` ADD `is_online` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否在线';
ALTER TABLE `bg_user` ADD `salt` char( 6 ) NOT NULL DEFAULT ''  COMMENT '干扰字符';


#导航菜单表
#menu
#id,栏目名称,父级id,权限,最后操作人真实姓名,最终操作人id,首次添加人真实姓名,首次添加人id,最后修改时间(首次添加为0),层级,平台,模块,动作
#id,name,parent_id,authority,last_add_user,last_add_userid,first_add_user,first_add_userid,last_update,level,plat,module,act

CREATE TABLE `menu` ( `id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ) ENGINE=myisam DEFAULT CHARSET=utf8;
ALTER TABLE `menu` ADD `post_date` INT( 11 ) UNSIGNED NOT NULL DEFAULT '0' COMMENT '注册时间'; ALTER TABLE `bg_user` ADD INDEX ( `post_date` );
ALTER TABLE `menu` ADD `name` VARCHAR( 30 ) NOT NULL DEFAULT ''  COMMENT '栏目名称';
ALTER TABLE `menu` ADD `parent_id` INT( 4 ) UNSIGNED NOT NULL DEFAULT '0' COMMENT '父级id';
ALTER TABLE `menu` ADD `last_add_user` VARCHAR( 30 ) NOT NULL DEFAULT ''  COMMENT '最后操作人真实姓名';
ALTER TABLE `menu` ADD `last_add_userid` INT( 4 ) UNSIGNED NOT NULL DEFAULT '0' COMMENT '最终操作人id';
ALTER TABLE `menu` ADD `first_add_user` VARCHAR( 30 ) NOT NULL DEFAULT ''  COMMENT '首次添加人真实姓名';
ALTER TABLE `menu` ADD `first_add_userid` INT( 4 ) UNSIGNED NOT NULL DEFAULT '0' COMMENT '首次添加人id';
ALTER TABLE `menu` ADD `last_update` INT( 4 ) UNSIGNED NOT NULL DEFAULT '0' COMMENT '最后修改时间(首次添加为0)';
ALTER TABLE `menu` ADD `level` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '0' COMMENT '层级';
ALTER TABLE `menu` ADD `plat` VARCHAR( 30 ) NOT NULL DEFAULT ''  COMMENT '平台';
ALTER TABLE `menu` ADD `module` VARCHAR( 30 ) NOT NULL DEFAULT ''  COMMENT '模块';
ALTER TABLE `menu` ADD `act` VARCHAR( 30 ) NOT NULL DEFAULT ''  COMMENT '动作';



#富文本图片表
#froala_edit_img
#id,路径,令牌,是否已使用
#id,img,token,has_use

CREATE TABLE `froala_edit_img` ( `id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ) ENGINE=INNODB DEFAULT CHARSET=utf8;
ALTER TABLE `froala_edit_img` ADD `post_date` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0'; ALTER TABLE `` ADD INDEX ( `post_date` );
ALTER TABLE `froala_edit_img` ADD `img` VARCHAR( 255 )  NOT NULL DEFAULT '' COMMENT '路径';
ALTER TABLE `froala_edit_img` ADD `token` VARCHAR( 255 )  NOT NULL DEFAULT '' COMMENT '令牌';
ALTER TABLE `froala_edit_img` ADD `has_use` TINYINT( 1 )  UNSIGNED DEFAULT '0' COMMENT '是否已使用';

#富文本editormd图片表
#editormd_img
#id,路径,令牌,是否已使用
#id,img,token,has_use

CREATE TABLE `editormd_img` ( `id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ) ENGINE=INNODB DEFAULT CHARSET=utf8;
ALTER TABLE `editormd_img` ADD `post_date` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0'; ALTER TABLE `` ADD INDEX ( `post_date` );
ALTER TABLE `editormd_img` ADD `img` VARCHAR( 255 )  NOT NULL DEFAULT '' COMMENT '路径';
ALTER TABLE `editormd_img` ADD `token` VARCHAR( 255 )  NOT NULL DEFAULT '' COMMENT '令牌';
ALTER TABLE `editormd_img` ADD `has_use` TINYINT( 1 )  UNSIGNED DEFAULT '0' COMMENT '是否已使用';


#exp分类表
#expcat
#id,分类名称,上级分类id,直属文章数量,节点层级,是否有子节点,直属子节点总个数,直属子节点id集合,添加时间
#id,name,pid,article_nums,level,is_have_child,child_nums,child_ids,post_date

#level = {1:1级节点; 2:2级节点; 3:3级节点}
#is_have_child = {0:无; 1:有}

CREATE TABLE `expcat` ( `id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
ALTER TABLE `expcat` ADD `post_date` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0'; ALTER TABLE `` ADD INDEX ( `post_date` );
ALTER TABLE `expcat` ADD `name` VARCHAR( 30 )  NOT NULL DEFAULT '' COMMENT '分类名称';
ALTER TABLE `expcat` ADD `pid` INT( 4 )  UNSIGNED DEFAULT '0' COMMENT '上级分类id';
ALTER TABLE `expcat` ADD `article_nums` INT( 4 )  UNSIGNED DEFAULT '0' COMMENT '直属文章数量';
ALTER TABLE `expcat` ADD `level` TINYINT( 1 )  UNSIGNED DEFAULT '1' COMMENT '节点层级';
ALTER TABLE `expcat` ADD `is_have_child` TINYINT( 1 )  UNSIGNED DEFAULT '0' COMMENT '是否有子节点';
ALTER TABLE `expcat` ADD `child_nums` SMALLINT( 2 )  UNSIGNED DEFAULT '0' COMMENT '直属子节点总个数';
ALTER TABLE `expcat` ADD `child_ids` VARCHAR( 255 )  NOT NULL DEFAULT '' COMMENT '直属子节点id集合';


update `expcat` set `child_nums`=child_nums+1,`child_ids`="concat(child_ids, ",15")" where `id`="1"

#exp文章表
#expnew
#id,post_date,标题,所属exp分类id,所属exp分类名称,内容,标签,所属exp分类id父级关系,所属exp分类名称父级关系,是否删除
#id,post_date,title,expcat__id,expcat__name,content,tags,crumbs_expcat_ids,crumbs_expcat_names,is_del

CREATE TABLE `expnew` ( `id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
ALTER TABLE `expnew` ADD `post_date` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0'; ALTER TABLE `` ADD INDEX ( `post_date` );
ALTER TABLE `expnew` ADD `title` VARCHAR( 50 )  NOT NULL DEFAULT '' COMMENT '标题';
ALTER TABLE `expnew` ADD `expcat__id` INT( 4 )  UNSIGNED DEFAULT '0' COMMENT '所属exp分类id';
ALTER TABLE `expnew` ADD `expcat__name` VARCHAR( 30 )  NOT NULL DEFAULT '' COMMENT '所属exp分类名称';
ALTER TABLE `expnew` ADD `content` TEXT NOT NULL COMMENT '内容';
ALTER TABLE `expnew` ADD `tags` VARCHAR( 255 )  NOT NULL DEFAULT '' COMMENT '标签';
ALTER TABLE `expnew` ADD `crumbs_expcat_ids` VARCHAR( 50 )  NOT NULL DEFAULT '' COMMENT '所属exp分类id父级关系';
ALTER TABLE `expnew` ADD `crumbs_expcat_names` VARCHAR( 255 )  NOT NULL DEFAULT '' COMMENT '所属exp分类名称父级关系';
ALTER TABLE `expnew` ADD `is_del` TINYINT( 1 )  UNSIGNED DEFAULT '0' COMMENT '是否删除';


#随机点餐表
#chifan
#id,post_date,菜品,描述,类型,食物类型,关联文章id集合,关联文章title集合
#id,post_date,cai,descr,type,food_type,expnew_ids,expnew_titles

#type = [0=>'午餐晚餐', 1=>'早餐'];
#food_type = [0=>'主食', 1=>'配菜', 2=>'营养补充', 3=>'主菜', 4=>'饮品'];

CREATE TABLE `chifan` ( `id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
ALTER TABLE `chifan` ADD `post_date` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0'; ALTER TABLE `` ADD INDEX ( `post_date` );
ALTER TABLE `chifan` ADD `cai` VARCHAR( 100 )  NOT NULL DEFAULT '' COMMENT '菜品';
ALTER TABLE `chifan` ADD `descr` TEXT NOT NULL COMMENT '描述';
ALTER TABLE `chifan` ADD `type` TINYINT( 1 )  UNSIGNED DEFAULT '0' COMMENT '类型';
ALTER TABLE `chifan` ADD `food_type` TINYINT( 1 )  UNSIGNED DEFAULT '0' COMMENT '食物类型';
ALTER TABLE `chifan` ADD `expnew_ids` VARCHAR( 255 )  NOT NULL DEFAULT '' COMMENT '关联文章id集合';
ALTER TABLE `chifan` ADD `expnew_titles` VARCHAR( 255 )  NOT NULL DEFAULT '' COMMENT '关联文章title集合';

#vim快捷键表
#vimshortcut
#id,post_date,快捷键,快捷键说明,是否为多环境快捷键,多环境快捷键说明,主键,辅键
#id,post_date,shortcut,key_comment,is_multipart,key_multi_comment,first_key,second_key

#is_multipart = [0=>'否', 1=>'是'];

CREATE TABLE `vimshortcut` ( `id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
ALTER TABLE `vimshortcut` ADD `post_date` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0'; ALTER TABLE `` ADD INDEX ( `post_date` );
ALTER TABLE `vimshortcut` ADD `shortcut` VARCHAR( 100 )  NOT NULL DEFAULT '' COMMENT '快捷键';
ALTER TABLE `vimshortcut` ADD `key_comment` VARCHAR( 255 )  NOT NULL DEFAULT '' COMMENT '快捷键说明';
ALTER TABLE `vimshortcut` ADD `is_multipart` TINYINT( 1 )  UNSIGNED DEFAULT '0' COMMENT '是否为多环境快捷键';
ALTER TABLE `vimshortcut` ADD `key_multi_comment` VARCHAR( 255 )  NOT NULL DEFAULT '' COMMENT '多环境快捷键说明';
ALTER TABLE `vimshortcut` ADD `first_key` VARCHAR( 30 )  NOT NULL DEFAULT '' COMMENT '主键';
ALTER TABLE `vimshortcut` ADD `second_key` VARCHAR( 30 )  NOT NULL DEFAULT '' COMMENT '辅键';


#工程信息记录表                                                                                                                   
#prorecord
#id,post_date,所属工程,标题,内容,是否删除
#id,post_date,belong_pro,title,content,is_del

belong_pro = [0=>'exp', 1=>'玖富', 2=>'综合']
is_del = [0=>'未删除', 1=>'已删除']

CREATE TABLE `prorecord` ( `id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
ALTER TABLE `prorecord` ADD `post_date` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0'; ALTER TABLE `` ADD INDEX ( `post_date` );
ALTER TABLE `prorecord` ADD `belong_pro` TINYINT( 1 )  UNSIGNED DEFAULT '0' COMMENT '所属工程';
ALTER TABLE `prorecord` ADD `title` VARCHAR( 100 )  NOT NULL DEFAULT '' COMMENT '标题';
ALTER TABLE `prorecord` ADD `content` TEXT NOT NULL COMMENT '内容';
ALTER TABLE `prorecord` ADD `is_del` TINYINT( 1 )  UNSIGNED DEFAULT '0' COMMENT '是否删除';


#表结构记录表                                                                                                                   
#tb_record
#id,post_date,所属库,表中文名,表英文名,中文字段集合,英文字段集合,原始建表草稿,建表语句,是否有特殊字段,备注信息
#id,post_date,belong_db,ch_name,en_name,ch_fields,en_fields,ori_struct,create_sql,has_special_field,comm

belong_db = {"0":"exp"}
has_special_field = {"0":"否", "1":"是"}

CREATE TABLE `tb_record` ( `id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ) ENGINE=INNODB DEFAULT CHARSET=utf8;
ALTER TABLE `tb_record` ADD `post_date` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0'; ALTER TABLE `tb_record` ADD INDEX ( `post_date` );
ALTER TABLE `tb_record` ADD `belong_db` TINYINT( 1 )  UNSIGNED DEFAULT '0' COMMENT '所属库';
ALTER TABLE `tb_record` ADD `ch_name` VARCHAR( 100 )  NOT NULL DEFAULT '' COMMENT '表中文名';
ALTER TABLE `tb_record` ADD `en_name` VARCHAR( 100 )  NOT NULL DEFAULT '' COMMENT '表英文名';
ALTER TABLE `tb_record` ADD `ch_fields` VARCHAR( 255 )  NOT NULL DEFAULT '' COMMENT '中文字段集合';
ALTER TABLE `tb_record` ADD `en_fields` VARCHAR( 255 )  NOT NULL DEFAULT '' COMMENT '英文字段集合';
ALTER TABLE `tb_record` ADD `ori_struct` TEXT COMMENT '原始建表草稿';
ALTER TABLE `tb_record` ADD `create_sql` TEXT COMMENT '建表语句';
ALTER TABLE `tb_record` ADD `has_special_field` TINYINT( 1 )  UNSIGNED DEFAULT '0' COMMENT '是否有特殊字段';
ALTER TABLE `tb_record` ADD `comm` VARCHAR( 255 )  NOT NULL DEFAULT '' COMMENT '备注信息';



#表特殊字段记录表                                                                                                                   
#tb_special_field
#id,post_date,所属表id,英文字段名,字段特别说明,字段序列化值对,字段类型
#id,post_date,tb_record__id,en_name,specification,serialize,field_type

field_type = {"0":'普通字段', "1":'关联字段'}

CREATE TABLE `tb_special_field` ( `id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ) ENGINE=INNODB DEFAULT CHARSET=utf8;
ALTER TABLE `tb_special_field` ADD `post_date` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0'; ALTER TABLE `tb_special_field` ADD INDEX ( `post_date` );
ALTER TABLE `tb_special_field` ADD `tb_record__id` INT( 4 )  UNSIGNED DEFAULT '0' COMMENT '所属表id';
ALTER TABLE `tb_special_field` ADD `en_name` VARCHAR( 100 )  NOT NULL DEFAULT '' COMMENT '英文字段名';
ALTER TABLE `tb_special_field` ADD `specification` VARCHAR( 100 )  NOT NULL DEFAULT '' COMMENT '字段特别说明';
ALTER TABLE `tb_special_field` ADD `serialize` VARCHAR( 100 )  NOT NULL DEFAULT '' COMMENT '字段序列化值对';
ALTER TABLE `tb_special_field` ADD `field_type` TINYINT( 1 )  UNSIGNED DEFAULT '0' COMMENT '字段类型';









