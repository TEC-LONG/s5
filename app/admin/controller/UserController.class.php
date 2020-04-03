<?php
namespace admin\controller;
use \core\controller;
use \model\UserModel;

class UserController extends Controller {

    ##标准预定义属性
    protected $_datas = [];
    protected $_navTab;

    public function __construct(){

        parent::__construct();

        $this->_navTab = 'admin_user';

        $this->_datas['url'] = [
            'index' => ['url'=>L('/admin/user/index'), 'rel'=>$this->_navTab.'_index'],
            'ad'    => ['url'=>L('/admin/user/add'), 'rel'=>$this->_navTab.'_add'],
            'upd'    => ['url'=>L('/admin/user/upd'), 'rel'=>$this->_navTab.'_upd'],
            'post'   => ['url'=>L('/admin/user/post')],
        ];

        $this->_datas['navTab'] = $this->_navTab;

        $this->_datas['status'] = UserModel::C_STATUS;
        $this->_datas['ori'] = UserModel::C_ORI;
        $this->_datas['level'] = UserModel::C_LEVEL;
    }

    public function index(){ 

        //接收数据
        $request = REQUEST()->all();

        ///需要搜索的字段
        $search_form = [
            ['s_acc', 'like'],
            ['s_nickname', 'like']
        ];
        $condition = F()->S2C($request, $search_form);
        $conditon[] = ['is_del', 0];
        $condition[] = ['level', 0];

        ///构建查询对象
        $obj = M()->table('user')->select('*')->where($condition);

        #分页参数
        $this->_datas['page'] = $page = $this->_paginate($request, $obj);

        #查询数据
        $this->_datas['rows'] = $obj->limit($page['limitM'] . ',' . $page['numPerPage'])->get();

        ///表头信息
        $this->_datas['thead'] = [
            ['ch'=>'账号', 'width'=>120], 
            ['ch'=>'用户昵称', 'width'=>120],
            ['ch'=>'手机号', 'width'=>100], 
            ['ch'=>'邮箱', 'width'=>160], 
            ['ch'=>'用户级别', 'width'=>60],
            ['ch'=>'状态', 'width'=>100],
            ['ch'=>'新增来源', 'width'=>120],
            ['ch'=>'ID', 'width'=>30], 
        ];

        //分配模板变量&渲染模板
        $this->assign($this->_datas);
        $this->display('user/index.tpl');
    }

    
}      
