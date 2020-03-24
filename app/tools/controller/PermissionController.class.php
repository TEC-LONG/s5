<?php
namespace tools\controller;
use \core\controller;
use \model\PermissionModel;
use \model\MenuPermissionModel;

class PermissionController extends Controller {

    ##标准预定义属性
    protected $_datas = [];
    private $_navTab;

    public function __construct(){

        parent::__construct();

        $this->_navTab = 'tools_permission';


        $this->_datas['url'] = [
            'index' => ['url'=>L('/tools/permission/index'), 'rel'=>$this->_navTab.'_index'],
            'pAdUpd'=> ['url'=>L('/tools/permission/pedit'), 'rel'=>$this->_navTab.'_pedit'],
            'pPost' => ['url'=>L('/tools/permission/ppost')],
            'del'   => ['url'=>L('/tools/permission/del')],
            'mpindex'   => ['url'=>L('/tools/permission/mpindex'), 'rel'=>$this->_navTab.'_mpindex'],
            'mpAdUpd'   => ['url'=>L('/tools/permission/mpedit'), 'rel'=>$this->_navTab.'_mpAdUpd'],
            'mpPost'   => ['url'=>L('/tools/permission/mppost')],
            'menuLookup'   => ['url'=>L('/tools/menu/index')]
        ];

        $this->_datas['navTab'] = $this->_navTab;

        ///数据表值对字段
        $this->_datas['flag'] = PermissionModel::C_FLAG;
        $this->_datas['request'] = MenuPermissionModel::C_REQUEST;
    }

    public function index(){
    
        ///接收数据
        $request = REQUEST()->all();
        $this->_datas['search'] = $request;

        ///需要搜索的字段
        $search_form = [
            ['s_name', 'like'],
            ['s_flag', 'like']
        ];
        $condition = F()->S2C($request, $search_form);
        if(empty($condition)) $condition=1;

        ///构建查询对象
        $obj = M()->table('permission')->select('*')->where($condition);

        #分页参数
        $nowPage = isset($request['pageNum']) ? intval($request['pageNum']) : (isset($_COOKIE['pageNum']) ? intval($_COOKIE['pageNum']) : 1);
        $this->_datas['page'] = $page = $obj->pagination($nowPage)->pagination;
        $page['numPerPageList'] = [20, 30, 40, 60, 80, 100, 120, 160, 200];

        #查询数据
        $this->_datas['rows'] = $obj->limit($page['limitM'] . ',' . $page['numPerPage'])->get();

        ///表头信息
        $this->_datas['thead'] = [
            ['ch'=>'权限名称', 'width'=>160],
            ['ch'=>'权限标识', 'width'=>120],
            ['ch'=>'ID', 'width'=>30]
        ];

        ///分配模板变量&渲染模板
        $this->assign($this->_datas);
        $this->display('permission/index.tpl');
    }

    public function pAdUpd(){
    
        ///接收数据
        $request = REQUEST()->all();

        ///编辑部分
        if( isset($request['id']) ){
            $this->_datas['row'] = M()->table('permission')->select('*')->where(['id', $request['id']])->find();
        }

        ///分配模板变量&渲染模板
        $this->assign($this->_datas);   
        $this->display('permission/edit.tpl');
    }

    public function pPost(){
        ///接收数据
        $request = REQUEST()->all();

        ///检查数据
        //check($request,  $this->_extra['form-elems'])

        ///模型对象
        $obj = M()->table('permission');

        if( isset($request['id']) ){///编辑
            #查询已有数据
            $ori = $obj->select('*')->where(['id', $request['id']])->find();

            #新老数据对比，构建编辑数据
            $update = F()->compare($request, $ori, ['name', 'flag']);

            if( empty($update) ) JSON()->stat(300)->msg('您还没有修改任何数据！请先修改数据。')->exec();
            $re = $obj->fields(array_keys($update))->update($update)->where(['id', $request['id']])->exec();

        }else{///新增

            #数据是否重复，重复了没必要新增
            $duplicate = $obj->select('id')->where(['name', $request['name']])->limit(1)->find();
            if(!empty($duplicate)) JSON()->stat(300)->msg('权限"'.$request['name'].'"已经存在！无需重复添加。')->exec();

            $insert = [
                'name' => $request['name'],
                'flag' => $request['flag'],
                'post_date' => time()
            ];

            $re = $obj->insert($insert)->exec();
        }
        
        ///返回结果
        if( $re ){
            JSON()->navtab($this->_navTab.'_index')->exec();
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

        if( $request['tb']=='permission' ){
            $navtab = $this->_navTab.'_index';
            $re = M()->table('permission')->where(['id', '=', $request['id']])->delete();
        }elseif( $request['tb']=='mpermission' ){
            $navtab = $this->_navTab.'_index';
            $re = M()->table('menu_permission')->where(['id', '=', $request['id']])->delete();
        }else{
            // $navtab = $this->_navTab.'_index';
            // //执行删除操作  将需要删除的数据 is_del字段设置为1
            // $re = M('UserModel')->fields('is_del')->update([1])->where(['id', '=', $request['id']])->exec();
        }
        
        if( $re ){
            JSON()->navtab($navtab)->msg('删除成功！')->exec();
        }else{
            JSON()->stat(300)->msg('操作失败')->exec();
        }
    }

    public function menuPermissionIndex(){
    
        ///接收数据
        $request = REQUEST()->all();
        $this->_datas['search'] = $request;

        ///需要搜索的字段
        $search_form = [
            ['s_route', 'like', 'mp.'],
            ['s_request', 'like', 'mp.'],
            ['s_display_name', 'like', 'mp.']
        ];
        $condition = [];
        $condition = F()->S2C($request, $search_form);
        if(!empty($request['s_menu_name'])) $condition[]=['m.name', 'like', $request['s_menu_name']];
        if(empty($condition)) $condition=1;
        

        ///构建查询对象
        $obj = M()->table('menu_permission as mp')->select('mp.*, m.name as menu_name, p.name, p.flag')
        ->leftjoin('menu as m', 'mp.menu__id=m.id')
        ->leftjoin('permission as p', 'mp.permission__id=p.id')->where($condition);

        #分页参数
        $nowPage = isset($request['pageNum']) ? intval($request['pageNum']) : (isset($_COOKIE['pageNum']) ? intval($_COOKIE['pageNum']) : 1);
        $this->_datas['page'] = $page = $obj->pagination($nowPage)->pagination;
        $page['numPerPageList'] = [20, 30, 40, 60, 80, 100, 120, 160, 200];

        #查询数据
        $this->_datas['rows'] = $obj->limit($page['limitM'] . ',' . $page['numPerPage'])->get();

        // var_dump(M()->dbug());
        // exit;
        

        ///表头信息
        $this->_datas['thead'] = [
            ['ch'=>'页面名称', 'width'=>160],
            ['ch'=>'路由', 'width'=>120],
            ['ch'=>'请求方式', 'width'=>120],
            ['ch'=>'navtab', 'width'=>120],
            ['ch'=>'权限名称', 'width'=>120],
            ['ch'=>'权限标识', 'width'=>120],
            ['ch'=>'所属menu', 'width'=>120],
            ['ch'=>'ID', 'width'=>30]
        ];

        ///分配模板变量&渲染模板
        $this->assign($this->_datas);
        $this->display('permission/mpIndex.tpl');
    }

    public function menuPermissionEdit(){
    
        ///接收数据
        $request = REQUEST()->all();

        ///编辑部分
        if( isset($request['id']) ){
            $this->_datas['row'] = M()->table('menu_permission as mp')->select('mp.*, m.name, p.name as pname')
            ->leftjoin('menu as m', 'mp.menu__id=m.id')
            ->leftjoin('permission as p', 'p.id=mp.permission__id')->where(['mp.id', $request['id']])->find();
        }

        ///分配模板变量&渲染模板
        $this->assign($this->_datas);
        $this->display('permission/mpEdit.tpl');
    }

    public function menuPermissionPost(){
        ///接收数据
        $request = REQUEST()->all();

        ///检查数据
        //check($request,  $this->_extra['form-elems'])

        ///模型对象
        $obj = M()->table('menu_permission');

        if( isset($request['id']) ){///编辑
            #查询已有数据
            $ori = $obj->select('*')->where(['id', $request['id']])->find();

            #新老数据对比，构建编辑数据
            $update = F()->compare($request, $ori, ['display_name', 'permission__id', 'route', 'menu__id', 'request', 'navtab']);
            if( empty($update) ) JSON()->stat(300)->msg('您还没有修改任何数据！请先修改数据。')->exec();
            
            $update['update_time'] = time();
            $re = $obj->fields(array_keys($update))->update($update)->where(['id', $request['id']])->exec();

        }else{///新增

            #数据是否重复，重复了没必要新增
            $duplicate = $obj->select('id')->where([
                ['display_name', $request['display_name']],
                ['permission__id', $request['permission__id']],
                ['menu__id', $request['menu__id']]
            ])->limit(1)->find();
            if(!empty($duplicate)) JSON()->stat(300)->msg('权限菜单已经存在！无需重复添加。')->exec();

            $insert = [
                'permission__id' => $request['permission__id'],
                'route' => $request['route'],
                'display_name' => $request['display_name'],
                'menu__id' => $request['menu__id'],
                'request' => $request['request'],
                'navtab' => $request['navtab'],
                'post_date' => time()
            ];

            $re = $obj->insert($insert)->exec();
        }
        
        ///返回结果
        if( $re ){
            JSON()->navtab($this->_navTab.'_mpindex')->exec();
        }else{
            JSON()->stat(300)->msg('操作失败')->exec();
        }
    }
}      
