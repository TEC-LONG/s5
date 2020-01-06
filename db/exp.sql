
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









