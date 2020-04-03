<?php

namespace admin\controller;
use \core\Controller;//引入空间类文件

class CatController extends Controller{

    private $_fields;

    public function __construct(){ 
        parent::__construct();

        $this->_fields['level'] = array(1=>'1级节点', '2级节点', '3级节点');
        $this->_fields['is_have_child'] = array('无', '有');
    }
    #列表
    public function catIndex(){ 
        //查询数据
        $sql = 'select id, name from bg_cat where parent_id=0';
        $rows = M()->getRows($sql);

        $p = array();
        foreach( $rows as $row_key=>$row ){ 
            $p['p_names'][$row_key] = $row['name'];
            $p['p_ids'][$row_key] = $row['id'];
        }

        $this->assign('p', $p);
        $this->display('cat/catIndex.tpl');
    }

    #列表页ajax
    public function getChild(){ 
        //过滤参数
        T($_POST);

        //判断是否为空
        if( !$_POST['p_id'] ) echo json_encode(array(0=>'no_p_id'));

        //查询数据
        $sql = 'select id, name from bg_cat where parent_id=' . $_POST['p_id'];
        $rows = M()->getRows($sql);

        $s = array();
        foreach( $rows as $row_key=>$row ){ 
            $s['s_names'][$row_key] = $row['name'];
            $s['s_ids'][$row_key] = $row['id'];
        }

        echo json_encode($s); 
    }
    #添加
    public function catAdh(){ 

        //检查是否为空
        //TE($_POST, 'p=admin&m=cat&a=catIndex', array(100, 'parent_id'));

        //过滤参数
        T($_POST);

        //分类数据
        $_POST['post_date'] = time();

        //执行新增操作
        if( $id = M()->setData('bg_cat', $_POST) ){
            $re = array();
            $re['id'] = $id;
            echo json_encode($re); 
            exit;
        }
    }

    #编辑
    public function catUpdh(){ 
        
        //过滤参数
        T($_POST);

        //排除数组元素
        $arr = AP($_POST, array('id'));

        //执行更新操作
        if( M()->setData('bg_cat', $arr, 2, array('id'=>$_POST['id'])) ){
            $re = array();
            $re['type'] = 'yes';
            echo json_encode($re); 
            exit;
        }
    }
}

