<?php
namespace store\controller;
use \core\controller;

class GoodsController extends Controller {

    ##标准预定义属性
    protected $_datas = [];
    private $_init = [];
    private $_extra = [];
    private $_navTab;

    public function __construct(){

        parent::__construct();

        $this->_navTab = 'store_goods';

        //非标准预定义属性赋值与转换
        $this->_init['sale_type'] = '0:下架|1:上架';
        $this->_init['check_type'] = '0:待审核|1:审核中|2:已审核-未通过|3:已审核-已通过';
        handler_init_special_fields($this->_init);

        //扔进模板
        $this->_datas = $this->_init;

        if( ACT==='index' ){
            $this->_datas['url'] = [
                'index' => ['url'=>L(PLAT, MOD, 'index'), 'rel'=>$this->_navTab.'_index'],
                'ad' => ['url'=>L(PLAT, MOD, 'ad'), 'rel'=>$this->_navTab.'_ad'],
                'upd' => ['url'=>L(PLAT, MOD, 'upd'), 'rel'=>$this->_navTab.'_upd'],
                'del' => ['url'=>L(PLAT, MOD, 'del')]
            ];
        }

        if( ACT==='ad' ){
            $this->_datas['url'] = [
                'adh' => ['url'=>L(PLAT, MOD, 'adh')]
            ];
        }

        if( ACT==='adh' ){
            // $this->_extra['form-elems'] = [
            //     'acc' => ['ch'=>'账号', 'rule'=>'required||regex@:^[\w_]{6,20}$'],
            //     'pwd' => ['ch'=>'密码', 'rule'=>'required||regex@:^[\w_]{6,15}$'],//6~15个英文字母或数字或下划线组合
            //     'nickname' => ['ch'=>'昵称', 'rule'=>'required']
            // ];
        }

        if( ACT==='upd' ){
            $this->_datas['url'] = [
                'updh' => ['url'=>L(PLAT, MOD, 'updh')]
            ];
        }

        if( ACT==='updh' ){
            // $this->_extra['form-elems'] = [
            //     'acc' => ['ch'=>'账号', 'rule'=>'required||regex@:^[\w_]{6,20}$'],
            //     'pwd' => ['ch'=>'密码', 'rule'=>'required||regex@:^[\w_]{6,15}$'],//6~15个英文字母或数字或下划线组合
            //     'nickname' => ['ch'=>'昵称', 'rule'=>'required']
            // ];
        }
        
        $this->_datas['navTab'] = $this->_navTab;
    }

    public function index(){ 

        //接收数据
        $request = REQUEST()->all();

        //查询条件(融合搜索条件)
        $con_arr = ['is_del', 0];

        #需要搜索的字段
        $form_elems = [
            // ['acc', 'like'],
            // ['nickname', 'like']
        ];

        $con = $this->_condition_string($request, $form_elems, $con_arr);//将条件数组数据转换为条件字符串

        //将搜索的原始数据扔进模板
        $this->_datas['search'] = $this->_get_ori_search_datas($request, $form_elems);

        //分页参数
        $this->_datas['page'] = $page = $this->_page('tl_goods', $con, $request);

        //查询数据
        $this->_datas['rows'] = M()->table('tl_goods')->select('*')->where($con)
                ->limit($page['limitM'] . ',' . $page['numPerPage'])
                ->get();

        //分配模板变量&渲染模板
        $this->assign($this->_datas);
        $this->display('goods/index.tpl');
    }

    public function ad(){ 

        $this->assign($this->_datas);

        $this->display('goods/ad.tpl');
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
            'level' => 0,
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

    

    
}      
