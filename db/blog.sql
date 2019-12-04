#表前缀：bg

#用户表
#bg_user
#id,账号,密码,用户昵称,手机号,邮箱,用户级别,状态,头像,来源,注册时间,最后更新时间,是否在线,干扰字符
#id,acc,pwd,nickname,cell,email,level,status,img,ori,post_date,upd_date,is_online,salt

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


#分类表
#bg_cat
#id,分类名称,上级分类id,直属文章数量,节点层级,是否有子节点,直属子节点总个数,添加时间
#id,name,parent_id,article_nums,level,is_have_child,child_nums,post_date

#level = {'1':1级节点; 2:2级节点; 3:3级节点}
#is_have_child = {'0':无; 1:有}

CREATE TABLE `bg_cat` ( `id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ) ENGINE=INNODB DEFAULT CHARSET=utf8;
ALTER TABLE `bg_cat` ADD `post_date` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0'; ALTER TABLE `bg_cat` ADD INDEX ( `post_date` );
ALTER TABLE `bg_cat` ADD `name` VARCHAR( 30 ) NOT NULL DEFAULT ''  COMMENT '分类名称';
ALTER TABLE `bg_cat` ADD `parent_id` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '上级分类id';
ALTER TABLE `bg_cat` ADD `article_nums` MEDIUMINT UNSIGNED NOT NULL DEFAULT '0' COMMENT '直属文章数量';
ALTER TABLE `bg_cat` ADD `level` TINYINT UNSIGNED NOT NULL DEFAULT '1' COMMENT '节点层级';
ALTER TABLE `bg_cat` ADD `is_have_child` TINYINT UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否有子节点';
ALTER TABLE `bg_cat` ADD `child_nums` SMALLINT UNSIGNED NOT NULL DEFAULT '0' COMMENT '直属子节点总个数';

insert into bg_cat set name='教材', parent_id=1, level=2;
insert into bg_cat set name='外语', parent_id=1, level=2;
insert into bg_cat set name='文学', parent_id=2, level=2;
insert into bg_cat set name='传记', parent_id=2, level=2;
insert into bg_cat set name='青春文学', parent_id=3, level=2;
insert into bg_cat set name='动漫', parent_id=3, level=2;

insert into bg_cat set name='研究生/本科', parent_id=4, level=3;
insert into bg_cat set name='高职高专', parent_id=4, level=3;
insert into bg_cat set name='英语综合教程', parent_id=5, level=3;
insert into bg_cat set name='英语专项训练', parent_id=5, level=3;
insert into bg_cat set name='文集', parent_id=6, level=3;
insert into bg_cat set name='纪实文学', parent_id=6, level=3;
insert into bg_cat set name='财经人物', parent_id=7, level=3;
insert into bg_cat set name='历代帝王', parent_id=7, level=3;
insert into bg_cat set name='校园', parent_id=8, level=3;
insert into bg_cat set name='爱情/情感', parent_id=8, level=3;
insert into bg_cat set name='大陆漫画', parent_id=9, level=3;
insert into bg_cat set name='港台漫画', parent_id=9, level=3;


#文章表
#bg_article
#id,上级文章id,排序,标题,简介,正文,所属分类id,所属分类名,类型,文章作者,添加者id,添加者昵称,状态,添加时间,最后修改时间
#id,p_id,sort,title,intro,content,cat__id,cat__name,type,auth,user__id,user__nickname,status,post_date,upd_date

#status = {0:草稿; 1:发布; 2:隐藏}
#type = {0:教程}

CREATE TABLE `bg_article` ( `id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
ALTER TABLE `bg_article` ADD `post_date` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0'; ALTER TABLE `bg_article` ADD INDEX ( `post_date` );
ALTER TABLE `bg_article` ADD `p_id` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '0' COMMENT '上级文章id';
ALTER TABLE `bg_article` ADD `sort` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '50' COMMENT '排序';
ALTER TABLE `bg_article` ADD `title` VARCHAR( 100 ) NOT NULL DEFAULT ''  COMMENT '标题';
ALTER TABLE `bg_article` ADD `intro` VARCHAR( 255 ) NOT NULL DEFAULT ''  COMMENT '简介';
ALTER TABLE `bg_article` ADD `content` TEXT NOT NULL COMMENT '正文';
ALTER TABLE `bg_article` ADD `cat__id` INT( 4 ) UNSIGNED NOT NULL DEFAULT '0' COMMENT '所属分类id';
ALTER TABLE `bg_article` ADD `cat__name` VARCHAR( 30 ) NOT NULL DEFAULT ''  COMMENT '所属分类名';
ALTER TABLE `bg_article` ADD `type` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '0' COMMENT '类型';
ALTER TABLE `bg_article` ADD `auth` VARCHAR( 30 ) NOT NULL DEFAULT ''  COMMENT '文章作者';
ALTER TABLE `bg_article` ADD `user__id` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0'  COMMENT '添加者id';
ALTER TABLE `bg_article` ADD `user__nickname` VARCHAR( 30 ) NOT NULL DEFAULT ''  COMMENT '添加者昵称';
ALTER TABLE `bg_article` ADD `status` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '1' COMMENT '状态';
ALTER TABLE `bg_article` ADD `upd_date` INT( 4 ) UNSIGNED NOT NULL DEFAULT '0' COMMENT '最后修改时间';



#标签表
#bg_tag
#id,名称,描述,添加时间,添加者id,添加者账号,排序
#id,name,des,post_date,user__id,user__acc,sort

CREATE TABLE `bg_tag` ( `id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
ALTER TABLE `bg_tag` ADD `post_date` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0'; ALTER TABLE `bg_tag` ADD INDEX ( `post_date` );
ALTER TABLE `bg_tag` ADD `name` VARCHAR( 30 ) NOT NULL DEFAULT ''  COMMENT '名称';
ALTER TABLE `bg_tag` ADD `des` VARCHAR( 255 ) NOT NULL DEFAULT ''  COMMENT '描述';
ALTER TABLE `bg_tag` ADD `user__id` INT( 4 ) UNSIGNED NOT NULL DEFAULT '0' COMMENT '添加者id';
ALTER TABLE `bg_tag` ADD `user__acc` VARCHAR( 30 ) NOT NULL DEFAULT ''  COMMENT '添加者账号';
ALTER TABLE `bg_tag` ADD `sort` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序';



#文章标签表
#bg_article_tag
#id,标签表id,标签名称,文章表id,文章标题,添加时间,添加者id,添加者账号,排序
#id,tag__id,tag__name,article__id,article_title,post_date,user__id,user__acc,sort

CREATE TABLE `bg_article_tag` ( `id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
ALTER TABLE `bg_article_tag` ADD `post_date` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0'; ALTER TABLE `bg_article_tag` ADD INDEX ( `post_date` );
ALTER TABLE `bg_article_tag` ADD `tag__id` INT( 4 ) UNSIGNED NOT NULL DEFAULT '0' COMMENT '标签表id';
ALTER TABLE `bg_article_tag` ADD `tag__name` VARCHAR( 30 ) NOT NULL DEFAULT ''  COMMENT '标签名称';
ALTER TABLE `bg_article_tag` ADD `article__id` INT( 4 ) UNSIGNED NOT NULL DEFAULT '0' COMMENT '文章表id';
ALTER TABLE `bg_article_tag` ADD `article_title` VARCHAR( 100 ) NOT NULL DEFAULT ''  COMMENT '文章标题';
ALTER TABLE `bg_article_tag` ADD `user__id` INT( 4 ) UNSIGNED NOT NULL DEFAULT '0' COMMENT '添加者id';
ALTER TABLE `bg_article_tag` ADD `user__acc` VARCHAR( 30 ) NOT NULL DEFAULT ''  COMMENT '添加者账号';
ALTER TABLE `bg_article_tag` ADD `sort` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序';




A：我到底做了什么事情才让你这么不尊重我，
如果你是我朋友，
那么，伤害你女儿的那些杂碎，
肯定会受到惩罚，
像你这样诚实的人，你的敌人就是我的敌人，
那么，他们就会怕你，

B：您。。当我的朋友？
A：（点头）（极慢）
B：(kiss A's hand) godfather
A：今后，也许我会需要你的帮助，
也许不会，今天我们既然是朋友了，
那就请你收下这份公道
B：thank u godfather
