<?php
namespace tools\controller;
use \core\controller;

class ExpcatController extends Controller {

    private $_datas = [];
    private $_url = [];
    private $_navTab;

    public function __construct(){

        parent::__construct();

        $this->_navTab = 'tools_expcat';
        
        $this->_url = [
            'index' => L(PLAT, MOD, 'index'),
            'adh' => L(PLAT, MOD, 'adh'),
            'edith' => L(PLAT, MOD, 'edith'),
            'del' => L(PLAT, MOD, 'del')
        ];
    }

    public function index(){ 

        #查询列表页数据
        $sql = 'select id, name, level, child_nums from expcat where pid=0 and level=1';
        $expcats = M()->getRows($sql);

        $first = [];
        foreach( $expcats as $cat_key=>$cat ){
            $first['p_names'][$cat_key] = $cat['name'];
            $first['p_ids'][$cat_key] = $cat['id'];
            $first['p_levels'][$cat_key] = $cat['level'];
            $first['p_child_nums'][$cat_key] = $cat['child_nums'];
        }

        //分配模板变量&渲染模板
        $this->assign([
            'first'=>$first,    
            'url'=>$this->_url
        ]);
        $this->display('Expcat/index.tpl');
    }

    //列表页ajax获得子分类
    public function getChild(){ 

        //查询数据
        $sql = 'select id, name, level, child_nums from expcat where pid=' . $_POST['p_id'];
        //$sql = 'select id, name, level from expcat where pid=100';
        $rows = M()->getRows($sql);

        $child = [];

        if( !empty($rows) ){
            foreach( $rows as $row_key=>$row ){ 
                $child['child_names'][$row_key] = $row['name'];
                $child['child_ids'][$row_key] = $row['id'];
                $child['child_levels'][$row_key] = $row['level'];
                $child['child_child_nums'][$row_key] = $row['child_nums'];
            }
        }

        echo json_encode($child); 
        exit;
    }

    public function adh(){ 

        $pchild_num = $_POST['pchild_num'];

        $datas = [
            'name' => $_POST['name'],
            'pid' => $_POST['pid'],
            'post_date' => time(),
            'level' => $_POST['plevel']+1
        ];

        if ( $insertId=M()->setData('expcat', $datas) ){ 

            $pdatas = ['child_nums'=>'child_nums+1'];
            if( $pchild_num==0 ){
                $pdatas['child_ids'] = $insertId;
            }else{
                $pdatas['child_ids'] = "concat(child_ids, '," . $insertId . "')";
            }

            if($datas['pid']==0 || (in_array($datas['level'], [2, 3]) && M()->setData('expcat', $pdatas, 2, ['id'=>$datas['pid']], ['child_nums', 'child_ids']))){
                $re = AJAXre();
                $re->navTabId = $this->_navTab.'_index';
                $re->message = '添加成功！';
            }else{
                $re = AJAXre(1);
            }
        }else{ 
            $re = AJAXre(1);
        }

        echo json_encode($re);
        exit;
    }


    public function edith(){ 
        
        $name = $_POST['name'];
        $ori_name = $_POST['ori_name'];

        $datas = [];
        if( $name!=$ori_name ) $datas['name'] = $_POST['name'];

        if(empty($datas)){
            $re = AJAXre(1);
            echo json_encode($re);
            exit;
        }

        $condition = [];
        $condition['id'] = $_POST['id'];

        if ( M()->setData('expcat', $datas, 2, $condition) ){ 
            $re = AJAXre();
            $re->navTabId = $this->_navTab.'_index';
            $re->message = '修改EXP分类成功！';
        }else{ 
            $re = AJAXre(1);
        }

        echo json_encode($re);
        exit;
    }

    public function catLookup(){ 

        #获得所有的分类数据
        $sql = 'select id, name, pid, level from expcat where 1';
        $cats = M()->getRows($sql);

        $tree_out = [];
        $this->recursiveCat($tree_out, $cats);
        
        $this->assign([
            'cats'=>$tree_out
        ]);

        $this->display('Expcat/catLookup.tpl');
    }

    private function recursiveCat(&$tree_in, $cats, $parent_id=0, $space=0){ 
        
        foreach( $cats as $cats_val1 ){ 
            
            if( $cats_val1['pid']==$parent_id ){
                
                $cats_val1['space'] = $space;
                $tree_in[] = $cats_val1;

                $next_space = $space+1;
                $this->recursiveCat($tree_in, $cats, $cats_val1['id'], $next_space);
            }
        }
    }
}      
