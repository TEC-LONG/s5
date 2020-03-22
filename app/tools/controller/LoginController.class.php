<?php

namespace tools\controller;
use \core\Controller;//引入空间类文件

class LoginController extends Controller{

    public function index(){ 
        
        $this->display('login/index.tpl');
    }

    public function showCheckcodeImg(){ 
        
        $checkcodeTool = M('CheckcodeTool', array('width'=>85, 'height'=>36, 'fontsize'=>20, 'fontspace'=>15, 'left'=>15, 'bottom'=>10));

        //将验证码字符记录到SESSION
        @session_start();
        $_SESSION['checkcode'] = $checkcodeTool->_string;

        //输出图像
        header("content-type: image/gif");
		echo $checkcodeTool->getGIF();
    }

    public function checklogin(){ 

        $request = REQUEST()->all();
        // @session_start();
        // var_dump($_SESSION);
        // F()->var_dump($request);

        //检查验证码
        @session_start();
        if( $_SESSION['checkcode']!==$request['checkcode'] ) J('验证码不正确！', '/tools/login/index');

        //检查账号密码
        $row = M('UserModel')->select('*')->where([
            ['acc', $request['acc']],
            ['level', 1],
            ['status', '<>', 1]
        ])->limit(1)->find();

        // if(empty($row)) $this->jump('账号错误！', 'p=tools&m=login&a=index');
        if(empty($row)) J('账号错误！', '/tools/login/index');

        if( $row['pwd']===M('UserModel')->make_pwd($request['pwd'], $row['salt']) ){//账号密码正确，登陆成功
            $_SESSION['admin'] = $row;

            //如果勾选了七天免登录

            //跳转后台首页
            // $this->jump('登陆成功', 'p=tools&m=index&a=index');
            J('登陆成功', '/tools/index', 0);

        }else{//账号或密码不正确，登陆失败
            // $this->jump('密码错误！', 'p=tools&m=login&a=index');
            J('密码错误！', '/tools/login/index');
        }
    }

    public function logout(){ 
        
        @session_start();
        unset($_SESSION['admin']);

        // $this->jump('', 'p=tools&m=login&a=index', 0);
        J('', '/tools/login/index', 0);
    }
}

