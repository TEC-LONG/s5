<?php
namespace admin\controller;
use \core\controller;
use \model\UserModel;
use \Validator;

class UserController extends Controller {

    ##标准预定义属性
    public $_datas = [];
    protected $_navTab;

    public function __construct(){

        parent::__construct();

        $this->_navTab = $navTab = 'admin_user';

        $this->_datas['url'] = [
            'index' => ['url'=>L('/admin/user/index'),  'rel'=>$navTab.'_index'],
            'ad'    => ['url'=>L('/admin/user/add'),    'rel'=>$navTab.'_add'],
            'upd'   => ['url'=>L('/admin/user/upd'),    'rel'=>$navTab.'_upd'],
            'post'  => ['url'=>L('/admin/user/post')],
            'del'   => ['url'=>L('/admin/user/del')]
        ];

        $this->_datas['ori']    = UserModel::C_ORI;
        $this->_datas['status'] = UserModel::C_STATUS;
        $this->_datas['level']  = UserModel::C_LEVEL;
        $this->_datas['navTab'] = $navTab;
    }

    /**
     * 数据列表
     */
    public function index(){ 

        ///初始化参数
        $request        = REQUEST()->all();
        $user_service   = M('UserService');

        ///校验数据
        $user_service->checkListRequest($request);
        
        ///获取列表数据
        $user_service->getUserList($request, $this);

        ///额外的逻辑处理
        #表头信息
        $this->_datas['thead'] = [
            ['ch'=>'账号',      'width'=>120],
            ['ch'=>'用户昵称',  'width'=>120],
            ['ch'=>'手机号',    'width'=>100],
            ['ch'=>'邮箱',      'width'=>160],
            ['ch'=>'用户级别',  'width'=>60],
            ['ch'=>'状态',      'width'=>100],
            ['ch'=>'新增来源',  'width'=>120],
            ['ch'=>'ID',        'width'=>30]
        ];

        //分配模板变量&渲染模板
        $this->assign($this->_datas);
        $this->display('user/index.tpl');
    }

    /**
     * 添加/编辑页
     */
    public function showEdit(){
    
        ///初始化参数
        $request = REQUEST()->all();

        ///编辑页需查询回显数据
        if( isset($request['id']) ){
        
            #根据id查询
            $this->_datas['row'] = M()->table('user')->select('*')->where(['id', $request['id']])->find();
        }
        
        $this->assign($this->_datas);
        $this->display('user/edit.tpl');
    }

    /**
     * 录入数据
     */
    public function post(){

        ///初始化参数
        $request        = REQUEST()->all();
        $user_service   = M('UserService');

        ///校验数据
        $user_service->checkPostRequest($request);

        ///文件上传
        $headimg = $user_service->upheadimg('img');

        ///录入数据
        if( isset($request['id']) ){#编辑
        
            $navtab = $this->_navTab.'_upd';
            $re = $user_service->update($request, $headimg);

        }else{#新增

            $navtab = $this->_navTab.'_ad';
            $re = $user_service->insert($request, $headimg);
        }

        ///返回结果
        if( $re ){
            JSON()->navtab($navtab)->msg('操作成功！')->exec();
        }else{
            JSON()->stat(300)->msg('操作失败')->exec();
        }
    }

    public function del(){
    
        ///初始化参数
        $request = REQUEST()->all();

        ///检查数据
        $obj = Validator::make($request, ['id'=>'required'], ['id.required'=>'非法的操作']);
        #有错误信息则返回给页面
        if( !empty($obj->err) ) JSON()->stat(300)->msg($obj->getErrMsg())->exec();

        $navtab = $this->_navTab.'_index';
        ///执行删除操作  将需要删除的数据 is_del字段设置为1
        $re = M('UserModel')->fields('is_del')->update([1])->where(['id', '=', $request['id']])->exec();
        
        if( $re ){
            JSON()->navtab($navtab)->msg('删除成功！')->exec();
        }else{
            JSON()->stat(300)->msg('操作失败')->exec();
        }
    }
}      
