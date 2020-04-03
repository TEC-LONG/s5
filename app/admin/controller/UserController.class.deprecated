<?php

namespace admin\controller;
use \core\Controller;//引入空间类文件

class UserController extends Controller{

    private $_fields;

    public function __construct(){ 
        parent::__construct();

        $this->_fields['level'] = array('普通用户', '管理员');
        $this->_fields['status'] = array('正常', '禁用');
        $this->_fields['ori'] = array('注册', '后台添加');
        $this->_fields['is_online'] = array('未知', '在线', '离线');
    }

    #列表
    public function userIndex(){ 
        //查询数据
        $sql = "select id, acc, nickname, cell, email, level, status, ori, post_date from bg_user where 1 limit 0, 20";
        $rows = M()->getRows($sql);

        $this->assign('rows', $rows);
        $this->assign('fields', $this->_fields);

        $this->display('user/userIndex.tpl');
    }

    #添加
    public function userAdd(){ 
        $this->display('user/userAdd.tpl');
    }

    public function userAddh(){ 
        
        //检查是否为空
        TE($_POST, 'p=admin&m=user&a=userAdd', array(100, 'level', 'status'));

        //过滤参数
        T($_POST);

        //检查不能重复的字段数据
        $fieldsVals = array('acc'=>$_POST['acc']);
        $accNum = M()->GN('bg_user', $fieldsVals);
        if( $accNum )  $this->jump('账号已存在，请重新填写账号！', 'p=admin&m=user&a=userAdd');


        //上传头像图片
        if( $fname=M('FuploadTool', array($_FILES['img']))->up() ){
            $_POST['img'] = $fname;
        }
        
        //补全表数据
        $_POST['post_date'] = time();
        $_POST['ori'] = 1;
        $_POST['salt'] = randStr();//随机6个字符

        $_POST['pwd'] = md5( md5( $_POST['pwd'] ).$_POST['salt'] );

        //执行新增操作
        if( M()->setData('bg_user', $_POST) ){
            $this->jump('新增用户成功！', 'p=admin&m=user&a=userIndex', 1);
        }
    }

    #更新
    public function userUpd(){ 

        //检查是否为空
        TE($_GET, 'p=admin&m=user&a=userIndex', array('id'));

        //过滤参数
        T($_GET['id']);

        //查询回显数据
        $sql = 'select * from bg_user where id=' . $_GET['id'];
        $row = M()->getRow($sql);

        $this->assign('row', $row);

        $this->display('user/userUpd.tpl');
    }

    public function userUpdh(){ 

        //检查是否为空（除了单选和多选，$_POST参数为空的表示不要修改）
        TE($_GET, 'p=admin&m=user&a=userIndex', array('id'));

        //过滤参数
        T($_GET['id']);
        T($_POST);

        //构建需要更新的数据
        $targets = array('level', 'status');//所有的单选和多选name值
        $datas = array();
        foreach( $_POST as $k=>$v ){ 
            if( $v!==''&&!in_array($k, $targets)&&substr($k, -2)!='_o' )://检查普通表单域数据是否有更新
                $datas[$k] = $v;
            elseif( in_array($k, $targets) )://检查单选和多选数据是否有更新
                if( $_POST[$k]!=$_POST[$k.'_o'] ){
                    $datas[$k] = $v;
                }
            endif;
        }

        //处理密码
        if( isset($datas['pwd']) ){
            $sql = 'select salt from bg_user where id=' . $_GET['id'];
            $row = M()->getRow($sql); 

            $datas['pwd'] = md5( md5($datas['pwd']).$row['salt'] );
        }

        //检查头像是否有更新
        if( !empty( $_FILES['img']['name'] ) ){
            
            //上传新的头像
            if( $fname=M('FuploadTool', array($_FILES['img']))->up() ):
                $datas['img'] = $fname;
                //删除旧的头像
                @unlink(PUBLIC_PATH . 'admin/upload/' . $_POST['img_o']);
            endif;
        }

        //执行更新操作
        if( !empty($datas) ){
            if( M()->setData('bg_user', $datas, 2, array('id'=>$_GET['id'])) ):
                $this->jump('编辑成功！', 'p=admin&m=user&a=userUpd&id='.$_GET['id'], 1);
            endif;
        }else{
            $this->jump('没有任何数据被修改，请先修改数据！', 'p=admin&m=user&a=userUpd&id='.$_GET['id'], 1);
        }
    }

    #删除
    public function userDel(){ 
        //检查是否为空
        TE($_GET, 'p=admin&m=user&a=userIndex', array('id'));

        //过滤参数
        T($_GET['id']);

        //删除条件
        $con = array('id'=>$_GET['id']);

        //删除操作
        if( M()->setData('bg_user', $con, 3) ){
            $this->jump('删除用户成功！', 'p=admin&m=user&a=userIndex', 1);
        }
    }

    #改变用户状态
    public function userStatus(){ 
        //检查是否为空
        TE($_GET, 'p=admin&m=user&a=userIndex', array('id'));

        //过滤参数
        T($_GET);

        //构建数据
        $datas = array('status'=>$_GET['status']);

        //构建更新条件
        $condition = array('id'=>$_GET['id']);

        //修改数据
        if( M()->setData('bg_user', $datas, 2, $condition) ){
            if( $_GET['status']==0 ):
                $this->jump('解除锁定成功！', 'p=admin&m=user&a=userIndex', 1);
            elseif( $_GET['status']==1 ):
                $this->jump('锁定成功！', 'p=admin&m=user&a=userIndex', 1);
            endif;
        }
    }
}

