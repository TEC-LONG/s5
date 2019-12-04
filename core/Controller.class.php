<?php

namespace core;

class Controller extends \Smarty{

    //protected $smarty;

    public function __construct(){ 

        parent::__construct();//执行一次Smarty类的构造方法

        //指定模板文件存放的目录（如果是后台则目录应是blog/app/admin/view；如果是前台则目录应是blog/app/home/view）
        $path = APP_PATH . $GLOBALS['plat'] . '/';
        //$this->left_delimiter = '{#';
        //$this->right_delimiter = '#}';

        $this->setTemplateDir($path . 'view');
        $this->setCompileDir($path . 'view_c');

        //调用方法检查是否已经登陆
        //$this->checkIsLogin();
    }

    protected function checkIsLogin(){ 
        //http://www.blog.com/index.php?p=home&m=index&a=showIndex
        @session_start();
        //检查之前是否已经登陆过
        //如果没有$_SESSION['user']数据，则说明之前没有登陆成功或者根本没有登陆过
        if( !isset($_SESSION['admin'])&&$GLOBALS['plat']=='admin'&&$GLOBALS['module']!='Login' ){
            
            //if( isset($_COOKIE['is_login']) ){//没有SESSION登陆信息，但是存在7天免登录信息，则重新找回之前点击7天免登录的用户信息
                //根据记录的COOKIE信息找回用户所有的信息
                //$userModel = M('\\model\\UserModel');
                //$acc = T($_COOKIE['is_login']);
                //$sql = "select * from bl_user where account='{$acc}'";
                //$user = $userModel->getRow($sql);
                //将找回的用户信息重新存储进SESSION名为user的元素中
                //$_SESSION['user'] = $user;

            //}else{//即不存在SESSION登陆信息，也没有之前记录的7天免登录信息，则重新登陆
                $this->jump('请先登陆！', 'p=admin&m=login&a=showLogin');
            //}
        }
    }

    /**
     * 方法名: jump
     * 方法作用: 跳转页面
     * 参数
     * $msg    string    跳转前的提示信息
     * $urlP    string    跳转目标链接后的路由参数与传递的GET数据参数
     * $time    int    提示信息展示的时间
     */
    public function jump($msg='操作成功！', $urlP='p=admin&m=user&a=showIndex', $time=2){ 
        echo $msg; 
        $url = C('URL') . '/index.php?' . $urlP;
        header("Refresh:{$time}; url={$url}");
        exit;
    }

    

}