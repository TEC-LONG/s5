<?php
namespace admin\service;
use \model\UserModel;
use \Validator;

class ArticleCateService {

    public function checkListRequest($request){
    
        ///需检查的搜索字段    UTF8编码下：/[x{4e00}-x{9fa5}]+/
        $fields = [
            's_acc'         => 'regex$|@&:/^\w+$/',
            's_nickname'    => 'ch-utf8'
        ];

        ///字段排除检查值
        $excludes = [
            // 's_acc' => [''],
            // 's_nickname' => ['']
        ];

        ///字段对应的提示信息
        $msg = [
            's_acc.regex'   => '账号存在非法的字符（账号只能包含数字、字符和下划线）'
        ];

        $obj = Validator::make($request, $fields, $msg, $excludes);

        if( !empty($obj->err) ){
            echo '<pre>';
            var_dump($obj->err);
            exit;
        }
    }

    public function getUserList($request, $controller){
    
        ///需要搜索的字段
        $search_form = [
            ['s_acc', 'like'],
            ['s_nickname', 'like']
        ];
        $condition = F()->S2C($request, $search_form);
        $conditon[] = ['is_del', 0];
        $condition[] = ['level', 0];

        ///构建查询对象
        $obj = M()->table('user')->select('*')->where($condition);

        #分页参数
        $controller->_datas['page'] = $page = $controller->_paginate($request, $obj);

        #查询数据
        $controller->_datas['rows'] = $obj->limit($page['limitM'] . ',' . $page['numPerPage'])->get();
    }

    public function upheadimg($input){
    
        ///以年份和月份分别来创建保存editor图片的一级和二级目录
        $first_folder = date('Y');
        $first_folder_path = USER_IMG . $first_folder;

        if (!is_dir($first_folder_path)) {
            mkdir($first_folder_path);
            chmod($first_folder_path, 0757);
        }

        $second_folder = date('m');
        $path = $first_folder_path . '/' . $second_folder;

        if (!is_dir($path)) {
            mkdir($path, 0757);
            chmod($path, 0757);
        }

        #图片的命名规则：前缀_随机字符串年月日时分秒.随机字符串.jpg
        $imgName = uniqid('user_') . date('YmdHis') . '.' . F()->randStr(6);

        if ($file = F()->file($input, $path)->up('editormd_', $imgName)) {
            //$wholePath = '/home/xx/xx/s5/upload/userimg/2019/11/xx.jpg';
            $wholePath = $path . '/' . $first_folder . '/' . $second_folder . '/' . $file->getNameWithExtension();
            $img = F()->path2src($wholePath);//$img = 'upload/userimg/2019/11/xx.jpg';

            return $img;
        }

        return false;
    }

    public function update($request, $headimg){
    
        #查询已有数据
        $row = M('UserModel')->select('*')->where(['id', $request['id']])->find();
        $request['pwd'] = $request['pwd']=='' ? $row['pwd'] : M('UserModel')->make_pwd($request['pwd'], $row['salt']);##密码处理
        $request['img'] = empty($headimg) ? '' : $headimg;##头像处理
        $update_data = F()->compare($request, $row, ['acc', 'pwd', 'nickname', 'cell', 'email', 'img']);

        if( empty($update_data) ) JSON()->stat(300)->msg('您还没有修改任何数据！请先修改数据。')->exec();

        $re = M('UserModel')
        ->fields(array_keys($update_data))
        ->update($update_data)
        ->where(['id', '=', $request['id']])
        ->exec();

        if( $re ) JSON()->navtab($this->_navTab.'_upd')->msg('修改用户成功！')->exec();
    }

    public function insert($request, $headimg){
    
        //构建新增数据
        $insert = [
            'acc'       => $request['acc'],
            'pwd'       => M('UserModel')->make_pwd($request['pwd']),
            'nickname'  => $request['nickname'],
            'cell'      => $request['cell'],
            'email'     => $request['email'],
            'salt'      => M('UserModel')->make_salt(),
            'level'     => 0,
            'ori'       => 1,
            'img'       => empty($headimg) ? '' : $headimg,
            'post_date' => time()
        ];

        $re = M('UserModel')->insert($insert)->exec();

        //执行新增
        if( $re ) JSON()->navtab($this->_navTab.'_ad')->exec();
    }

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
    
}      
