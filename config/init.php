<?php


//引入全局配置文件
include CONFIG_PATH . 'conf.php';

//引入公共函数文件
include CORE_PATH . 'Func.php';

//引入配置常量文件
include CONFIG_PATH . 'define.conf.php';

include CORE_PATH . 'Route.class.php';
include CORE_PATH . 'Validator.class.php';

Route::prepare();

if( Route::$plat=='tools' ){
    include TOOLS_CONF_PATH . 'AutoTb.conf.php';
}elseif( Route::$plat=='admin' ){
    //引入模板配置文件
    // include CONFIG_PATH . 'template_conf.php';
}

//引入核心应用类文件
include CORE_PATH . 'App.class.php';
spl_autoload_register('\\core\\App::autoload');//注册自动加载静态成员方法

//引入composer自动加载文件
include VENDOR_PATH . 'autoload.php';

//引入SMARTY核心类文件
include SMARTY_DIR . 'Smarty.class.php';//       mvc/plugins/smarty/Smarty.class.php

//引入父类控制器文件
include CORE_PATH . 'Controller.class.php';
if (C('dweb.debug')) {
    
    ini_set('error_reporting', E_ALL & ~E_WARNING & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
    ini_set('display_errors', 1);
}
