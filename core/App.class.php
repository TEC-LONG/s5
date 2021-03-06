<?php

namespace core;
use \Route;

class App{

    private static $_objs=array();

    public static function single($className, $params, $type='single'){//$type='single'表示走单例；$type='no_single'表示不走单例

        if( empty(self::$_objs[$className]) ){
            if( empty($params) ):
                self::$_objs[$className] = new $className;
            else:
                if( $className==='\Upload\File' ){
                    self::$_objs[$className] = new $className($params[0], $params[1]);
                }else{
                    self::$_objs[$className] = new $className($params);
                }
            endif;
        }

        if( $type=='no_single' ){
        
            $tmp_obj = self::$_objs[$className];
            unset(self::$_objs[$className]);
            return $tmp_obj;

        }elseif ( $type=='single' ) {
            
            return self::$_objs[$className];
        }
    }

    public static function autoload($className){ 

        //$className = basename($className);//得到了除去命名空间的纯类名，Linux下不认“\”做目录分隔符，basename无效
        $t_className = explode('\\', $className);
        $arrNums = count($t_className);
        $className = $t_className[$arrNums-1];

        if( substr($className, -10)=='Controller' ){//如果包含了Controller关键字，则表示是一个控制器类文件
            //           mvc/app/admin/controller/
            //include APP_ADMIN_CONTROLLER_PATH . $className . '.class.php';
            //         mvc/app/     admin[/home]               /controller/xxxController.class.php
            include APP_PATH . $GLOBALS['plat'] . '/controller/' . $className . '.class.php';
        }elseif( substr($className, -7)=='Service' ){

            include APP_PATH . $GLOBALS['plat'] . '/service/' . $className . '.class.php';
        }elseif( $className=='Model'||$className=='NiceModel' ){//父类模型和NiceModel父类模型要比普通模型先判断
            
            //       mvc/core/    Model|NiceModel   .class.php
            include CORE_PATH . $className . '.class.php';

        }elseif( substr($className, -5)=='Model' ) {//如果包含了Model关键字，则表示是一个模型类文件
            
            //         mvc/app/model/     xxxxModel      .class.php
            include APP_MODEL_PATH . $className . '.class.php';
        }elseif( substr($className, -4)=='Tool' ) {//如果包含了Tool关键字，则表示是一个工具类文件
            include PLUGINS_PATH . $className . '.class.php';
        }
    }

    public static function run(){ 
        //接收一个名为a的GET参数保存到$action变量中
        $GLOBALS['action'] = $action = Route::$method;//动作参数
        //接收一个名为m的GET参数保存到$module变量中
        $GLOBALS['module'] = $module = Route::$controller;//模块参数
        //接收一个名为p的GET参数保存到$plat变量中
        $GLOBALS['plat'] = $plat = Route::$plat;//平台参数
        
        define('PLAT', $plat);
        define('MOD', $module);
        define('ACT', $action);

        $className = $module.'Controller';
        $obj = M($className);

        $obj->$action();
    }
}

