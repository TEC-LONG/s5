<?php
namespace tools\controller;
use \core\controller;
use \model\SmenuModel;

class MenuController extends Controller {

    private $_datas = [];
    private $_init = [];
    private $_navTab;
    private $_requ;

    public function __construct(){

        parent::__construct();

        $this->_navTab = 'tools_menu';
        $this->_init['level3_type'] = '0:内部跳转链接|1:外部跳转链接';
        handler_init_special_fields($this->_init);

        //扔进模板
        $this->_datas = $this->_init;

        $this->_requ = M('RequestTool');

        $this->_datas['navTab'] = $this->_navTab;
        $this->_datas['url'] = [
            'index' => L('/tools/menu/index'),
            'adh' => L('/tools/menu/adh'),
            'updh' => L('/tools/menu/updh'),
            'del' => L('/tools/menu/del'),
            'smenu' => ['url'=>L('/tools/smenu/index'), 'rel'=>$this->_navTab.'_smenu'],
            'smenuAdUpd' => ['url'=>L('/tools/smenu/edit'), 'rel'=>$this->_navTab.'_smenuAdUpd'],
            'smenuPost' => ['url'=>L('/tools/smenu/post')]
        ];
    }

    public function index(){ 

        #查询列表页数据
        $rows = M()->table('menu')->select('*')
        ->where([['parent_id', 0], ['level', 1], ['is_del', 0]])
        ->get();

        $this->_datas['first'] = [];
        foreach( $rows as $k=>$row ){
            $this->_datas['first']['p_names'][$k] = $row['name'];
            $this->_datas['first']['p_ids'][$k] = $row['id'];
            $this->_datas['first']['p_levels'][$k] = $row['level'];
        }
        //分配模板变量&渲染模板
        $this->assign($this->_datas);
        $this->display('Menu/index.tpl');
    }

    //列表页ajax获得子分类
    public function getChild(){ 

        $request = $this->_requ->all();

        //查询数据
        $rows = M()->table('menu')->select('id,name,level,plat,module,act,navtab,level3_type,level3_href,route')->where([['parent_id', $request['p_id']], ['is_del', 0]])->get();

        $child = [];

        if( !empty($rows) ){
            foreach( $rows as $row_key=>$row ){ 
                $child['child_names'][$row_key] = $row['name'];
                $child['child_ids'][$row_key] = $row['id'];
                $child['child_levels'][$row_key] = $row['level'];
                $child['plat'][$row_key] = $row['plat'];
                $child['module'][$row_key] = $row['module'];
                $child['act'][$row_key] = $row['act'];
                $child['navtab'][$row_key] = $row['navtab'];
                $child['level3_type'][$row_key] = $row['level3_type'];
                $child['level3_href'][$row_key] = $row['level3_href'];
                $child['route'][$row_key] = $row['route'];
            }
        }

        echo json_encode($child); 
        exit;
    }

    public function adh(){ 

        $request = $this->_requ->all();

        $datas = [
            'name' => $request['name'],
            'parent_id' => $request['pid'],
            'post_date' => time(),
            'plat' => $request['plat'],
            'module' => $request['module'],
            'act' => $request['act'],
            'navtab' => $request['navtab'],
            'level' => $request['plevel']+1,
            'level3_type'=>$request['level3_type'],
            'level3_href'=>$request['level3_href'],
            'route'=>$request['route']
        ];

        if ( M()->table('menu')->insert($datas)->exec() ){ 

            $re = AJAXre();
            $re->navTabId = $this->_navTab.'_index';
            $re->message = '添加成功！';
        }else{ 
            $re = AJAXre(1);
        }

        echo json_encode($re);
        exit;
    }


    public function updh(){ 

        $request = $this->_requ->all();
        
        $datas = [];
        if( $request['name']!==$request['ori_name'] ) $datas['name'] = $request['name'];
        if( $request['plat']!==$request['ori_plat'] ) $datas['plat'] = $request['plat'];
        if( $request['module']!==$request['ori_module'] ) $datas['module'] = $request['module'];
        if( $request['act']!==$request['ori_act'] ) $datas['act'] = $request['act'];
        if( $request['navtab']!==$request['ori_navtab'] ) $datas['navtab'] = $request['navtab'];
        if( $request['level3_type']!==$request['ori_level3_type'] ) $datas['level3_type'] = $request['level3_type'];
        if( $request['level3_href']!==$request['ori_level3_href'] ) $datas['level3_href'] = $request['level3_href'];
        if( $request['route']!==$request['ori_route'] ) $datas['route'] = $request['route'];

        if(empty($datas)){
            $re = AJAXre(1);
            echo json_encode($re);
            exit;
        }

        if ( M()->table('menu')->fields(array_keys($datas))->update($datas)->where(['id', $request['id']])->exec() ){ 
            $re = AJAXre();
            $re->navTabId = $this->_navTab.'_index';
            $re->message = '修改EXP分类成功！';
        }else{ 
            $re = AJAXre(1);
        }

        echo json_encode($re);
        exit;
    }

    public function del(){
    
        //接收数据
        $request = REQUEST()->all();

        //检查数据
        // $this->_extra['form-elems']['id'] = ['ch'=>'菜品ID', 'rule'=>'required'];
        //check($request,  $this->_extra['form-elems'])

        if( $request['tb']=='smenu' ){
            $navtab = $this->_navTab.'_smenu';
            $re = M()->table('smenu')->where(['id', '=', $request['id']])->delete();
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

    public function smenuList(){
    
        ///接收数据
        $request = REQUEST()->all();
        $this->_datas['search'] = $request;

        ///需要搜索的字段
        $search_form = [
            ['s_name', 'like']
        ];
        $condition = F()->S2C($request, $search_form);
        if(empty($condition)) $condition=1;

        ///构建查询对象
        $obj = M()->table('smenu')->select('*')->where($condition);

        #分页参数
        $nowPage = isset($request['pageNum']) ? intval($request['pageNum']) : (isset($_COOKIE['pageNum']) ? intval($_COOKIE['pageNum']) : 1);
        $this->_datas['page'] = $page = $obj->pagination($nowPage)->pagination;
        $page['numPerPageList'] = [20, 30, 40, 60, 80, 100, 120, 160, 200];

        #查询数据
        $this->_datas['rows'] = $obj->limit($page['limitM'] . ',' . $page['numPerPage'])->get();

        ///查询所有当前关联的上级子菜单
        $this->_datas['parent_names'] = [];
        $parent_id_arr = [];
        foreach( $this->_datas['rows'] as $k=>$v){
        
            if($v['parent_id']!=0) $parent_id_arr[]=$v['parent_id'];
        }
        if( !empty($parent_id_arr) ){
            $parent_names_arr = M('SmenuModel')->select('id, name')->where(['id', 'in', implode($parent_id_arr)])->get();
            foreach( $parent_names_arr as $k=>$v){
            
                $this->_datas['parent_names'][$v['id']] = $v['name'];
            }
        }

        ///请求方式
        $this->_datas['request_type'] = SmenuModel::C_REQUEST_TYPE;

        ///查询所有三级菜单
        $menu_arr = M('MenuModel')->select('id, name')->where(['level', 3])->get();
        $level3 = [];
        foreach( $menu_arr as $k=>$v){
        
            $level3[$v['id']] = $v['name'];
        }
        $this->_datas['level3'] = $level3;
        
        
        ///表头信息
        $this->_datas['thead'] = [
            ['ch'=>'组名', 'width'=>160],
            ['ch'=>'路由', 'width'=>120],
            ['ch'=>'请求方式', 'width'=>120],
            ['ch'=>'navtab', 'width'=>120],
            ['ch'=>'上级菜单', 'width'=>120],
            ['ch'=>'上级子菜单', 'width'=>120],
            ['ch'=>'外部跳转链接', 'width'=>120],
            ['ch'=>'ID', 'width'=>30]
        ];

        ///分配模板变量&渲染模板
        $this->assign($this->_datas);
        $this->display('menu/smenu.tpl');
    }
    
    public function smenuAdUpd(){
        
        ///接收数据
        $request = REQUEST()->all();
        
        ///查询所有三级菜单
        $this->_datas['level3'] = M('MenuModel')->select('id, name')->where(['level', 3])->get();

        ///请求方式
        $this->_datas['request_type'] = SmenuModel::C_REQUEST_TYPE;

        ///编辑部分
        if( isset($request['id']) ){
            $this->_datas['row'] = M()->table('smenu')->select('*')->where(['id', $request['id']])->find();
        }
        
        ///分配模板变量&渲染模板
        $this->assign($this->_datas);
        $this->display('menu/smenuEdit.tpl');
    }

    public function smenuPost(){
        ///接收数据
        $request = REQUEST()->all();

        ///检查数据
        //check($request,  $this->_extra['form-elems'])

        ///模型对象
        $obj = M()->table('smenu');

        if( isset($request['id']) ){///编辑
            #查询已有数据
            $ori = $obj->select('*')->where(['id', $request['id']])->find();

            #新老数据对比，构建编辑数据
            $update = F()->compare($request, $ori, ['name', 'route', 'request_type', 'navtab', 'menu__id', 'parent_id', 'link_href']);
            if( empty($update['link_href']) ){
                $update['link_type'] = array_search('内部跳转链接', SmenuModel::C_LINK_TYPE);
            }else{
                $update['link_type'] = array_search('外部跳转链接', SmenuModel::C_LINK_TYPE);
            }

            if( empty($update) ) JSON()->stat(300)->msg('您还没有修改任何数据！请先修改数据。')->exec();
            $re = $obj->fields(array_keys($update))->update($update)->where(['id', $request['id']])->exec();

        }else{///新增

            #数据是否重复，重复了没必要新增
            $duplicate = $obj->select('id')->where(['name', $request['name']])->limit(1)->find();
            if(!empty($duplicate)) JSON()->stat(300)->msg('子菜单"'.$request['name'].'"已经存在！无需重复添加。')->exec();

            $insert = [
                'name' => $request['name'],
                'route' => $request['route'],
                'request_type' => $request['request_type'],
                'navtab' => $request['navtab'],
                'menu__id' => $request['menu__id'],
                'parent_id' => $request['parent_id'],
                'link_href' => $request['link_href'],
                'link_type' => empty($request['link_type'])?array_search('内部跳转链接', SmenuModel::C_LINK_TYPE):array_search('外部跳转链接', SmenuModel::C_LINK_TYPE),
                'post_date' => time()
            ];

            $re = $obj->insert($insert)->exec();
        }
        
        ///返回结果
        if( $re ){
            JSON()->navtab($this->_navTab.'_smenu')->exec();
        }else{
            JSON()->stat(300)->msg('操作失败')->exec();
        }
    }
}      
