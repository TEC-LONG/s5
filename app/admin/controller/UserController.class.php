<?php
namespace admin\controller;
use \core\controller;
use \model\UserModel;

class UserController extends Controller {

    ##标准预定义属性
    public $_datas = [];
    protected $_navTab;

    public function __construct(){

        parent::__construct();

        $this->_navTab = $navTab = 'admin_user';

        $this->_datas['url'] = [
            'index' => ['url'=>L('/admin/user/index'), 'rel'=>$navTab.'_index'],
            'ad'    => ['url'=>L('/admin/user/add'), 'rel'=>$navTab.'_add'],
            'upd'   => ['url'=>L('/admin/user/upd'), 'rel'=>$navTab.'_upd'],
            'post'  => ['url'=>L('/admin/user/post')],
        ];

        $this->_datas['ori']    = UserModel::C_ORI;
        $this->_datas['status'] = UserModel::C_STATUS;
        $this->_datas['level']  = UserModel::C_LEVEL;
        $this->_datas['navTab'] = $navTab;
    }

    public function index(){ 

        ///接收数据
        $request = REQUEST()->all();
        #初始化参数
        $user_service = M('UserService');

        ///校验数据  service-check
        $user_service->checkListRequest($request);
        
        ///获取列表数据  service-list
        $user_service->getUserList($request, $this);

        ///额外的逻辑处理  service-logic
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

    public function showEdit(){
    
    }

    public function post(){
    
    }

    
}      
