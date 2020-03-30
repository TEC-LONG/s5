<?php

//定义路径常量
//xxxx/xxxx/xx/mvc/config/define.php   => ROOT :      xxx/xxx/xx/mvc
define('ROOT', dirname(dirname(__FILE__)));//定义根目录常量

define('APP_PATH', ROOT . '/app/');//APP_PATH => xxx/mvc/app/
define('CORE_PATH', ROOT . '/core/');
define('PLUGINS_PATH', ROOT . '/plugins/');
define('CONFIG_PATH', ROOT . '/config/');
define('PUBLIC_PATH', ROOT . '/public/');
define('VENDOR_PATH', ROOT . '/vendor/');
define('DOWNLOAD_PATH', ROOT . '/download/');
define('UPLOAD_PATH', ROOT . '/upload/');
define('STORAGE_PATH', ROOT . '/storage/');

define('SMARTY_DIR', PLUGINS_PATH.'smarty/');//定义SMARTY目录常量
define('APP_MODEL_PATH', APP_PATH . 'model/');

## home
define('APP_HOME_PATH', APP_PATH . 'home/');
define('APP_HOME_VIEW_PATH', APP_HOME_PATH . 'view/');
define('APP_HOME_CONTROLLER_PATH', APP_HOME_PATH . 'controller/');

## admin
define('APP_ADMIN_PATH', APP_PATH . 'admin/');//APP_ADMIN_PATH =>  xx/mvc/app/admin/
define('APP_ADMIN_VIEW_PATH', APP_ADMIN_PATH . 'view/');//APP_ADMIN_VIEW_PATH  =>  xx/mvc/app/admin/view/
define('APP_ADMIN_CONTROLLER_PATH', APP_ADMIN_PATH . 'controller/');//APP_ADMIN_CONTROLLER_PATH  =>  xx/mvc/app/admin/controller/

## tools
define('TOOLS_PATH', APP_PATH . 'tools/');//  xx/mvc/app/tools/
define('TOOLS_VIEW_PATH', TOOLS_PATH . 'view/');//  xx/mvc/app/tools/view/
define('TOOLS_CONTROLLER_PATH', TOOLS_PATH . 'controller/');//  xx/mvc/app/tools/controller/
define('TOOLS_CONF_PATH', CONFIG_PATH . 'tools/');// xx/mvc/config/tools/

##log
define('STORAGE_LOG_PATH', STORAGE_PATH . 'log/');

##others
define('EDITOR_IMG', PUBLIC_PATH . 'tools/editorimg/' );
define('EDITORMD_IMG', UPLOAD_PATH . 'editormdimg/' );
define('EDITORBD_IMG', UPLOAD_PATH . 'editorbdimg/' );
