<?php
namespace store\controller;
use \core\controller;

class CategoryController extends Controller {

    private $_datas = [];
    private $_init = [];
    private $_navTab;
    private $_requ;

    public function __construct(){

        parent::__construct();

        $this->_navTab = 'store_category';
        handler_init_special_fields($this->_init);

        //扔进模板
        $this->_datas = $this->_init;

        $this->_requ = M('RequestTool');

        $this->_datas['navTab'] = $this->_navTab;
        $this->_datas['url'] = [
            'index' => L(PLAT, MOD, 'index'),
            'adh' => L(PLAT, MOD, 'adh'),
            'updh' => L(PLAT, MOD, 'updh'),
            'del' => L(PLAT, MOD, 'del')
        ];
    }

    public function index(){ 

        #查询列表页数据
        $rows = M()->table('tl_goods_category')->select('*')
        ->where([['parent_id', 0], ['level', 1]])
        ->get();

        $this->_datas['first'] = [];
        foreach( $rows as $k=>$row ){
            $this->_datas['first']['p_names'][$k] = $row['name'];
            $this->_datas['first']['p_ids'][$k] = $row['id'];
            $this->_datas['first']['p_levels'][$k] = $row['level'];
        }

        //分配模板变量&渲染模板
        $this->assign($this->_datas);
        $this->display('goods_category/index.tpl');
    }

    //列表页ajax获得子分类
    public function getChild(){ 

        $request = $this->_requ->all();

        //查询数据
        $rows = M()->table('tl_goods_category')->select('id,name,level')->where([['parent_id', $request['p_id']]])->get();

        $child = [];

        if( !empty($rows) ){
            foreach( $rows as $row_key=>$row ){ 
                $child['child_names'][$row_key] = $row['name'];
                $child['child_ids'][$row_key] = $row['id'];
                $child['child_levels'][$row_key] = $row['level'];
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
            'level' => $request['plevel']+1
        ];

        if ( M()->table('tl_goods_category')->insert($datas)->exec() ){ 
            JSON()->navtab($this->_navTab.'_index')->exec();
        }else{ 
            JSON()->stat(300)->msg('操作失败')->exec();
        }
    }

    public function updh(){ 

        $request = $this->_requ->all();
        
        $datas = [];
        if( $request['name']!==$request['ori_name'] ) $datas['name'] = $request['name'];

        if(empty($datas)){
            JSON()->stat(300)->msg('尚未修改任何数据！')->exec();
        }

        if ( M()->table('tl_goods_category')->fields(array_keys($datas))->update($datas)->where(['id', $request['id']])->exec() ){ 
            JSON()->navtab($this->_navTab.'_index')->exec();
        }else{ 
            JSON()->stat(300)->msg('操作失败')->exec();
        }
    }
}      
