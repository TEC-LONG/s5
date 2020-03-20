<?php
namespace tools\controller;
use \core\controller;

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
            'del' => L('/tools/menu/del')
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
}      
