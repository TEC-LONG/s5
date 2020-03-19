<?php

class Route{

    public static $plat;
    public static $controller;
    public static $method;

    private static $_routes = [
        'get' => [],
        'post' => []
    ];
    private static $_maps = [
        'get' => [],
        'post' => []
    ];

    public static function get($route, $map){
    
        self::routeAd($route, $map, 'get');
    }

    public static function post($route, $map){
    
        self::routeAd($route, $map, 'post');
    }

    private static function routeAd($route, $map, $type){
        
        if( $type=='get' ){#add get
        
            $key = count(self::$_routes['get']);
            self::$_maps['get'][$key] = $map;
            self::$_routes['get'][$key] = '/' . self::$plat . '/' . $route;
        }else {#add post
            $key = count(self::$_routes['post']);
            self::$_maps['post'][$key] = $map;
            self::$_routes['post'][$key] = '/' . self::$plat . '/' . $route;
        }
    }

    public static function prepare(){

        $URI = $_SERVER['REQUEST_URI'];

        if(empty($URI)||$URI==='/') $URI='/'.C('dweb.p').'/'.C('dweb.m').'/'.C('dweb.a');
        if(strpos($URI, '?')){

            preg_match('/^(.*)\?/', $URI, $preg_arr);
            $URI = $preg_arr[1];
        }
        $URI_arr = explode('/', substr($URI, 1));
        self::$plat = $URI_arr[0];

        ///确定routes文件
        $routes_path = APP_PATH . strtolower($URI_arr[0]) . DIRECTORY_SEPARATOR . 'routes.php';
        $has_routes = file_exists($routes_path);

        if(!$has_routes) exit('跳转404，记录日志！没有routes文件');
        include $routes_path;

        ///当前请求的方式
        $request_method = strtolower($_SERVER['REQUEST_METHOD']);
        if(!in_array($request_method, ['get', 'post'])) exit('跳转404，记录日志！请求方式非法');
        
        ///匹配routes规则，确定指向哪个控制器下的哪个方法
        $routes_gather = self::$_routes[$request_method];
        // var_dump($_GET);
        // var_dump($URI);
        // var_dump($request_method);
        // echo '<pre>';
        // var_dump($routes_gather);
        // echo '<pre>';
        if(!in_array($URI, $routes_gather)) exit('跳转404，记录日志！匹配不到routes对应的规则');

        $routes_key = array_search($URI, $routes_gather);#routes的key与map的key一致
        $map = self::$_maps[$request_method][$routes_key];

        #得到控制器名和方法
        $map_str = explode('@', $map);
        self::$controller = ucfirst($map_str[0]);
        self::$method = $map_str[1];
    }
}

