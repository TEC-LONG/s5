<?php
namespace tools\controller;
use \core\controller;

class UserController extends Controller {

    ##标准预定义属性
    protected $_datas = [];
    private $_init = [];
    private $_extra = [];
    private $_navTab;

    public function __construct(){

        parent::__construct();

        $this->_navTab = 'tools_user';

        //非标准预定义属性赋值与转换
        $this->_init['level'] = '0:普通用户|1:管理员';
        $this->_init['status'] = '0:正常|1:禁用';
        $this->_init['ori'] = '0:注册|1:后台添加';
        $this->_init['is_online'] = '0:未知|1:在线|2:离线';
        handler_init_special_fields($this->_init);

        //扔进模板
        $this->_datas = $this->_init;

        $this->_datas['url'] = [
            'index' => ['url'=>L('/tools/user/index'), 'rel'=>$this->_navTab.'_index'],
            'ad'    => ['url'=>L('/tools/user/ad'), 'rel'=>$this->_navTab.'_ad'],
            'adh'   => ['url'=>L('/tools/user/adh')],
            'upd'   => ['url'=>L('/tools/user/upd'), 'rel'=>$this->_navTab.'_upd'],
            'updh'  => ['url'=>L('/tools/user/updh')],
            'del'   => ['url'=>L('/tools/user/del')],
            'group' => ['url'=>L('/tools/user/group'), 'rel'=>$this->_navTab.'_group'],
            'gAdUpd'=> ['url'=>L('/tools/user/gedit'), 'rel'=>$this->_navTab.'_edit'],
            'gPost' => ['url'=>L('/tools/user/gpost')]
        ];

        $this->_datas['mustShow'] = [
            'id'        => ['ch'=>'ID', 'width'=>30], 
            'acc'       => ['ch'=>'账号', 'width'=>120], 
            'nickname'  => ['ch'=>'用户昵称', 'width'=>120],
            'cell'      => ['ch'=>'手机号', 'width'=>100], 
            'email'     => ['ch'=>'邮箱', 'width'=>160], 
            'level'     => ['ch'=>'用户级别', 'width'=>60],
            'status'    => ['ch'=>'状态', 'width'=>100],
            'ori'       => ['ch'=>'新增来源', 'width'=>120]
        ];

        $this->_extra['form-elems'] = [
            'acc'       => ['ch'=>'账号', 'rule'=>'required||regex@:^[\w_]{6,20}$'],
            'pwd'       => ['ch'=>'密码', 'rule'=>'required||regex@:^[\w_]{6,15}$'],//6~15个英文字母或数字或下划线组合
            'nickname'  => ['ch'=>'昵称', 'rule'=>'required']
        ];

        $this->_datas['navTab'] = $this->_navTab;
    }

    public function index(){ 

        //接收数据
        $request = REQUEST()->all();

        //查询条件(融合搜索条件)
        $con_arr = [['is_del', 0], ['level', 1]];

        #需要搜索的字段
        $form_elems = [
            ['acc', 'like'],
            ['nickname', 'like']
        ];

        $con = $this->_condition_string($request, $form_elems, $con_arr);//将条件数组数据转换为条件字符串

        //将搜索的原始数据扔进模板
        $this->_datas['search'] = $this->_get_ori_search_datas($request, $form_elems);

        //分页参数
        $this->_datas['page'] = $page = $this->_page('user', $con, $request);

        //查询数据
        $this->_datas['rows'] = M('UserModel')->select('*')->where($con)
                ->limit($page['limitM'] . ',' . $page['numPerPage'])
                ->get();

        //分配模板变量&渲染模板
        $this->assign($this->_datas);
        $this->display('user/index.tpl');
    }

    public function ad(){ 

        ///用户组数据
        $user_group = M('UserGroupModel')->getAll();

        $this->assign($this->_datas);

        $this->display('user/ad.tpl');
    }

    public function adh(){ 
        //接收数据
        $request = REQUEST()->all();

        //检查数据
        //check($request,  $this->_extra['form-elems'])

        //构建新增数据
        $insert = [
            'acc' => $request['acc'],
            'pwd' => M('UserModel')->make_pwd($request['pwd']),
            'nickname' => $request['nickname'],
            'cell' => $request['cell'],
            'email' => $request['email'],
            'salt' => M('UserModel')->make_salt(),
            'level' => 1,
            'ori' => 1,
            'post_date' => time()
        ];

        $re = M('UserModel')->insert($insert)->exec();

        //执行新增
        if( $re ){
            JSON()->navtab($this->_navTab.'_ad')->exec();
        }else{
            JSON()->stat(300)->msg('操作失败')->exec();
        }
    }

    public function upd(){ 
        
        //接收数据
        $request = REQUEST()->all();

        //检查数据
        //check($request,  $this->_extra['form-elems'])

        //查询数据
        $this->_datas['row'] = M('UserModel')->select('*')->where(['id', $request['id']])->find();

        //分配模板变量&渲染模板
        $this->assign($this->_datas);
        $this->display('user/upd.tpl');
    }

    public function updh(){ 

        //接收数据
        $request = REQUEST()->all();

        //检查数据
        // $this->_extra['form-elems']['id'] = ['ch'=>'菜品ID', 'rule'=>'required'];
        //check($request,  $this->_extra['form-elems'])

        //取出修改了的数据
        #查询已有数据
        $row = M('UserModel')->select('*')->where(['id', $request['id']])->find();
        $request['pwd'] = $request['pwd']=='' ? $row['pwd'] : M('UserModel')->make_pwd($request['pwd'], $row['salt']);
        $update_data = F()->compare($request, $row, ['acc', 'pwd', 'nickname', 'cell', 'email']);

        if( empty($update_data) ){
            JSON()->stat(300)->msg('您还没有修改任何数据！请先修改数据。')->exec();
        }

        $re = M('UserModel')
        ->fields(array_keys($update_data))
        ->update($update_data)
        ->where(['id', '=', $request['id']])
        ->exec();

        if( $re ){
            JSON()->navtab($this->_navTab.'_upd')->msg('修改用户成功！')->exec();
        }else{
            JSON()->stat(300)->msg('操作失败')->exec();
        }
    }

    public function del(){
    
        //接收数据
        $request = REQUEST()->all();

        //检查数据
        // $this->_extra['form-elems']['id'] = ['ch'=>'菜品ID', 'rule'=>'required'];
        //check($request,  $this->_extra['form-elems'])

        //执行删除操作  将需要删除的数据 is_del字段设置为1
        $re = M('UserModel')->fields('is_del')->update([1])->where(['id', '=', $request['id']])->exec();

        if( $re ){
            JSON()->navtab($this->_navTab.'_index')->msg('删除成功！')->exec();
        }else{
            JSON()->stat(300)->msg('操作失败')->exec();
        }
    }

    public function groupList(){
    
        ///接收数据
        $request = REQUEST()->all();
        $this->_datas['search'] = $request;

        ///需要搜索的字段
        $search_form = [
            // ['s_mem_acc', 'like'],
            // ['s_mem_pwd', 'like']
        ];
        $condition = F()->S2C($request, $search_form);
        if(empty($condition)) $condition=1;

        ///构建查询对象
        $obj = M()->table('user_group')->select('*')->where($condition)->orderby('sort desc');

        #分页参数
        $nowPage = isset($request['pageNum']) ? intval($request['pageNum']) : (isset($_COOKIE['pageNum']) ? intval($_COOKIE['pageNum']) : 1);
        $this->_datas['page'] = $page = $obj->pagination($nowPage)->pagination;
        $page['numPerPageList'] = [20, 30, 40, 60, 80, 100, 120, 160, 200];

        #查询数据
        $this->_datas['rows'] = $obj->limit($page['limitM'] . ',' . $page['numPerPage'])->get();
        
        ///表头信息
        $this->_datas['thead'] = [
            ['ch'=>'ID', 'width'=>30],
            ['ch'=>'组名', 'width'=>160],
            ['ch'=>'排序', 'width'=>120],
        ];

        ///分配模板变量&渲染模板
        $this->assign($this->_datas);
        $this->display('user/group.tpl');
    }

    

    
}      
