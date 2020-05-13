<?php
namespace admin\service;
use \model\UserModel;
use \Validator;

class ArticleCateService {


    public function getCate($pid=0, $prefix='p'){
    
        ///初始化参数
        $result = [];

        ///查询满足条件的数据
        $rows = M('ArticleCategoryModel')
        ->select('id, name, level, child_nums')
        ->where([
            ['pid', $pid]
        ])->get();

        if(!empty($rows)){

            ///数据处理
            foreach( $rows as $k=>$row){
            
                $result[$prefix . '_names'][$k]      = $row['name'];
                $result[$prefix . 'ids'][$k]         = $row['id'];
                $result[$prefix . 'levels'][$k]      = $row['level'];
                $result[$prefix . 'child_nums'][$k]  = $row['child_nums'];
            }
        }

        return $result;
    }

    public function checkPostRequest($request){
    
        ///需检查的搜索字段
        $fields = [
            'id'        => 'int$|min&:1',
            'pid'       => 'int$|min&:0',
            'plevel'    => 'int$|min&:0'
        ];

        ///字段对应的提示信息
        $msg = [
            'id.int'        => '非法的操作【i】',
            'id.min'        => 'id值异常',
            'pid.int'       => '非法的操作【p】',
            'pid.min'       => 'pid值异常',
            'plevel.int'    => '非法的操作【l】',
            'plevel.min'    => 'plevel值异常'
        ];

        ///校验
        $obj = Validator::make($request, $fields, $msg);
        #有错误信息则返回给页面
        // if( !empty($obj->err) ) JSON()->stat(300)->msg($obj->getErrMsg())->exec();
    }

    public function insert($request, $headimg){

        ///初始化参数
        $pchild_num = $request['pchild_num'];
        $arti_cate_model = M('ArticleCategoryModel');

        ///新增当前分类
        #组装数组
        $data = [
            'name'      => $request['name'],
            'pid'       => $request['pid'],
            'post_date' => time(),
            'level'     => $request['plevel']+1
        ];

        #执行新增并获取新记录的id值
        if( $arti_cate_model->insert($data)->exec() ){
            $last_insert_id = $arti_cate_model->last_insert_id();
        }

        if( isset($last_insert_id) ){///上级分类相关数据更新
            
            $pdata = [
                'child_nums'    => '@child_nums+1'   #子分类数量
            ];
            $pdata['child_ids'] = $pchild_num==0 ? $last_insert_id : "@concat(child_ids, ',".$last_insert_id."')";   #子分类id值集合

            # pid=0则当前分类为顶级分类，再无上级分类
            $is_success = $data['pid']==0;
            # level>1则表示有上级分类，则更新上级分类
            $is_success = $is_success || (in_array($data['level'], [2, 3]) && $arti_cate_model->update($pdata)->where(['id', $data['pid']])->exec());
            if( $is_success ){
                return true;
            }
        }
        JSON()->stat(300)->msg('新增分类失败！')->exec();
    }

    public function update($request){
        
        ///初始化参数
        $name = $request['name'];
        $ori_name = $request['ori_name'];

        ///
        $data = [];
        if( $name!=$ori_name ) $data['name'] = $name;

        if(empty($data)) JSON()->stat(300)->msg('当前分类名称并没有被修改，请先修改')->exec();

        $re = M('ArticleCategoryModel')->update($data)->where(['id', $request['id']])->exec();

        if(!$re) JSON()->stat(300)->msg('操作失败')->exec();
        return true;
    }

    public function recursiveCat(&$tree_in, $cats, $parent_id=0, $space=0){ 
        
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
