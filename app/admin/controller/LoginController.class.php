<?php

namespace admin\controller;
use \core\Controller;//引入空间类文件

class LoginController extends Controller{

    public function showLogin(){ 
        
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
        //检查是否为空
        TE($_POST, 'p=admin&m=login&a=showLogin');

        //过滤参数
        T($_POST);

        //检查验证码
        @session_start();
        if( $_SESSION['checkcode']!==$_POST['checkcode'] ) $this->jump('验证码不正确！', 'p=admin&m=login&a=showLogin');

        //检查账号密码
        $sql = 'select * from bg_user where acc="' . $_POST['acc'] . '" and level=1 and status<>1 limit 1';
        $row = M()->getRow($sql);

        if( !empty($row)&&$row['pwd']===md5(md5($_POST['pwd']).$row['salt']) ){//账号密码正确，登陆成功
            $_SESSION['admin'] = $row;

            //如果勾选了七天免登录

            //跳转后台首页
            $this->jump('登陆成功', 'p=admin&m=user&a=userIndex');

        }else{//账号或密码不正确，登陆失败
            $this->jump('账号或密码错误！', 'p=admin&m=login&a=showLogin');
        }
    }

    public function logout(){ 
        
        @session_start();
        unset($_SESSION['admin']);

        $this->jump('', 'p=admin&m=login&a=showLogin', 0);
    }
}

