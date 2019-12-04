<?php

//引入路径常量定义文件
include './config/pathD.php';

//引入初始化操作文件
include CONFIG_PATH . 'init.php';

//调用启动方法，让程序运行起来
\core\App::run();