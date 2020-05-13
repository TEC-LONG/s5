<?php
namespace tools\controller;
use \core\controller;

class MemAccPwdController extends Controller {

    ##标准预定义属性
    protected $_datas = [];
    protected $_navTab;

    public function __construct(){

        parent::__construct();

        $this->_navTab = 'tools_memAccPwd';
        $this->_datas['navTab'] = $this->_navTab;

        $this->_datas['url'] = [
            'index' => ['url'=>L('/tools/accPwd/index'), 'rel'=>$this->_navTab.'_index'],
            'adUpd' => ['url'=>L('/tools/accPwd/edit'), 'rel'=>$this->_navTab.'_adUpd'],
            'post' => ['url'=>L('/tools/accPwd/post')],
            'accIndex' => ['url'=>L('/tools/accPwd/accIndex'), 'rel'=>$this->_navTab.'_accIndex'],
            'accAdUpd' => ['url'=>L('/tools/accPwd/accAdUpd'), 'rel'=>$this->_navTab.'_accAdUpd'],
            'accPost' => ['url'=>L('/tools/accPwd/accPost')],
            'pwdIndex' => ['url'=>L('/tools/accPwd/pwdIndex'), 'rel'=>$this->_navTab.'_pwdIndex'],
            'pwdAdUpd' => ['url'=>L('/tools/accPwd/pwdAdUpd'), 'rel'=>$this->_navTab.'_pwdAdUpd'],
            'pwdPost' => ['url'=>L('/tools/accPwd/pwdPost')],
            'belongsToIndex' => ['url'=>L('/tools/accPwd/belongsToIndex'), 'rel'=>$this->_navTab.'_belongsToIndex'],
            'belongsToAdUpd' => ['url'=>L('/tools/accPwd/belongsToAdUpd'), 'rel'=>$this->_navTab.'_belongsToAdUpd'],
            'belongsToPost' => ['url'=>L('/tools/accPwd/belongsToPost')],
            'del' => ['url'=>L('/tools/accPwd/del')]
        ];
    }

    public function accIndex(){
        ///接收数据
        $request = REQUEST()->all();
        $this->_datas['search'] = $request;
        $this->_datas['accIndexType'] = isset($request['type']) ? $request['type'] : '';

        ///需要搜索的字段
        $search_form = [
            ['s_mem_acc', 'like']
        ];
        $condition = F()->S2C($request, $search_form);
        if(empty($condition)) $condition=1;

        ///构建查询对象
        $obj = M()->table('mem_acc')->select('*')->where($condition);

        #分页参数
        $this->_datas['page'] = $page = $this->_paginate($request, $obj);

        #查询数据
        $this->_datas['rows'] = $obj->limit($page['limitM'] . ',' . $page['numPerPage'])->get();

        ///表头信息
        $this->_datas['thead'] = [
            ['ch'=>'ID', 'width'=>30],
            ['ch'=>'acc数据', 'width'=>120]
        ];

        ///分配模板变量&渲染模板
        $this->assign($this->_datas);
        $this->display('memAccPwd/accIndex.tpl');
    }

    public function accAdUpd(){
        ///接收数据
        $request = REQUEST()->all();

        ///编辑部分
        if( isset($request['id']) ){

            $this->_datas['id'] = $request['id'];
            $this->_datas['row'] = M()->table('mem_acc')->select('*')->where(['id', $request['id']])->find();
        }

        ///分配模板变量&渲染模板
        $this->assign($this->_datas);   
        $this->display('memAccPwd/accAdUpd.tpl');
    }

    public function accPost(){
        ///接收数据
        $request = REQUEST()->all();

        ///检查数据
        //check($request,  $this->_extra['form-elems'])

        ///模型对象
        $obj = M()->table('mem_acc');

        if( isset($request['id']) ){///编辑
            #查询已有数据
            $ori = $obj->select('*')->where(['id', $request['id']])->find();

            #新老数据对比，构建编辑数据
            $update = F()->compare($request, $ori, ['mem_acc']);

            if( empty($update) ) JSON()->stat(300)->msg('您还没有修改任何数据！请先修改数据。')->exec();
            $re = $obj->update($update)->where(['id', $request['id']])->exec();

        }else{///新增

            #数据是否重复，重复了没必要新增
            $duplicate = $obj->select('id')->where(['mem_acc', $request['mem_acc']])->limit(1)->find();
            if(!empty($duplicate)) JSON()->stat(300)->msg('"账号数据"已经存在。')->exec();

            $insert = [
                'mem_acc' => $request['mem_acc'],
                'post_date' => time()
            ];

            $re = $obj->insert($insert)->exec();
        }
        
        ///返回结果
        if( $re ){
            JSON()->navtab($this->_navTab.'_accIndex')->exec();
        }else{
            JSON()->stat(300)->msg('操作失败')->exec();
        }
    }

    public function pwdIndex(){
        ///接收数据
        $request = REQUEST()->all();
        $this->_datas['search'] = $request;
        $this->_datas['pwdIndexType'] = isset($request['type']) ? $request['type'] : '';

        ///需要搜索的字段
        $search_form = [
            ['s_mem_pwd', 'like']
        ];
        $condition = F()->S2C($request, $search_form);
        if(empty($condition)) $condition=1;

        ///构建查询对象
        $obj = M()->table('mem_pwd')->select('*')->where($condition);

        #分页参数
        $this->_datas['page'] = $page = $this->_paginate($request, $obj);

        #查询数据
        $this->_datas['rows'] = $obj->limit($page['limitM'] . ',' . $page['numPerPage'])->get();
        
        ///表头信息
        $this->_datas['thead'] = [
            ['ch'=>'ID', 'width'=>30],
            ['ch'=>'pwd数据', 'width'=>120]
        ];

        ///分配模板变量&渲染模板
        $this->assign($this->_datas);
        $this->display('memAccPwd/pwdIndex.tpl');
    }

    public function pwdAdUpd(){
        ///接收数据
        $request = REQUEST()->all();

        ///编辑部分
        if( isset($request['id']) ){

            $this->_datas['id'] = $request['id'];
            $this->_datas['row'] = M()->table('mem_pwd')->select('*')->where(['id', $request['id']])->find();
        }

        ///分配模板变量&渲染模板
        $this->assign($this->_datas);
        $this->display('memAccPwd/pwdAdUpd.tpl');
    }

    public function pwdPost(){
        ///接收数据
        $request = REQUEST()->all();

        ///检查数据
        //check($request,  $this->_extra['form-elems'])

        ///模型对象
        $obj = M()->table('mem_pwd');

        if( isset($request['id']) ){///编辑
            #查询已有数据
            $ori =$obj->select('*')->where(['id', $request['id']])->find();

            #新老数据对比，构建编辑数据
            $update = F()->compare($request, $ori, ['mem_pwd']);

            if( empty($update) ) JSON()->stat(300)->msg('您还没有修改任何数据！请先修改数据。')->exec();
            $re = $obj->update($update)->where(['id', $request['id']])->exec();

        }else{///新增

            #数据是否重复，重复了没必要新增
            $duplicate = $obj->select('id')->where(['mem_pwd', $request['mem_pwd']])->limit(1)->find();
            if(!empty($duplicate)) JSON()->stat(300)->msg('"密码数据"已经存在。')->exec();

            $insert = [
                'mem_pwd' => $request['mem_pwd'],
                'post_date' => time()
            ];

            $re = $obj->insert($insert)->exec();
        }
        
        ///返回结果
        if( $re ){
            JSON()->navtab($this->_navTab.'_pwdIndex')->exec();
        }else{
            JSON()->stat(300)->msg('操作失败')->exec();
        }
    }

    public function belongsToIndex(){
        ///接收数据
        $request = REQUEST()->all();
        $this->_datas['search'] = $request;
        $this->_datas['belongsToIndexType'] = isset($request['type']) ? $request['type'] : '';

        ///需要搜索的字段
        $search_form = [
            ['s_belongs_to', 'like']
        ];
        $condition = F()->S2C($request, $search_form);
        if(empty($condition)) $condition=1;

        ///构建查询对象
        $obj = M()->table('mem_belongs_to')->select('*')->where($condition);

        #分页参数
        $this->_datas['page'] = $page = $this->_paginate($request, $obj);

        #查询数据
        $this->_datas['rows'] = $obj->limit($page['limitM'] . ',' . $page['numPerPage'])->get();
        
        ///表头信息
        $this->_datas['thead'] = [
            ['ch'=>'ID', 'width'=>30],
            ['ch'=>'归属方', 'width'=>120]
        ];

        ///分配模板变量&渲染模板
        $this->assign($this->_datas);
        $this->display('memAccPwd/belongsToIndex.tpl');
    }

    public function belongsToAdUpd(){
        ///接收数据
        $request = REQUEST()->all();

        ///编辑部分
        if( isset($request['id']) ){

            $this->_datas['id'] = $request['id'];
            $this->_datas['row'] = M()->table('mem_belongs_to')->select('*')->where(['id', $request['id']])->find();
        }

        ///分配模板变量&渲染模板
        $this->assign($this->_datas);   
        $this->display('memAccPwd/belongsToAdUpd.tpl');
    }

    public function belongsToPost(){
        ///接收数据
        $request = REQUEST()->all();

        ///检查数据
        //check($request,  $this->_extra['form-elems'])

        ///模型对象
        $obj = M()->table('mem_belongs_to');

        if( isset($request['id']) ){///编辑
            #查询已有数据
            $ori =$obj->select('*')->where(['id', $request['id']])->find();

            #新老数据对比，构建编辑数据
            $update = F()->compare($request, $ori, ['belongs_to']);

            if( empty($update) ) JSON()->stat(300)->msg('您还没有修改任何数据！请先修改数据。')->exec();
            $re = $obj->update($update)->where(['id', $request['id']])->exec();

        }else{///新增

            #数据是否重复，重复了没必要新增
            $duplicate = $obj->select('id')->where(['belongs_to', $request['belongs_to']])->limit(1)->find();
            if(!empty($duplicate)) JSON()->stat(300)->msg('"密码数据"已经存在。')->exec();

            $insert = [
                'belongs_to' => $request['belongs_to'],
                'post_date' => time()
            ];

            $re = $obj->insert($insert)->exec();
        }
        
        ///返回结果
        if( $re ){
            JSON()->navtab($this->_navTab.'_pwdIndex')->exec();
        }else{
            JSON()->stat(300)->msg('操作失败')->exec();
        }
    }

    public function index(){ 
        ///接收数据
        $request = REQUEST()->all();
        $this->_datas['search'] = $request;

        ///需要搜索的字段
        $search_form = [
            ['s_mem_acc', 'like'],
            ['s_mem_pwd', 'like']
        ];
        $condition = F()->S2C($request, $search_form);
        if(empty($condition)) $condition=1;

        ///构建查询对象
        $obj = M()->table('mem_acc__mem_pwd as map')->select('map.*, mbt.belongs_to as bt, ma.mem_acc, mp.mem_pwd')->where($condition)
        ->leftjoin('mem_belongs_to as mbt', 'mbt.id=map.mem_belongs_to__id')
        ->leftjoin('mem_acc as ma', 'ma.id=map.mem_acc__id')
        ->leftjoin('mem_pwd as mp', 'mp.id=map.mem_pwd__id');

        #分页参数
        $nowPage = isset($request['pageNum']) ? intval($request['pageNum']) : (isset($_COOKIE['pageNum']) ? intval($_COOKIE['pageNum']) : 1);
        $this->_datas['page'] = $page = $obj->pagination($nowPage)->pagination;
        $page['numPerPageList'] = [20, 30, 40, 60, 80, 100, 120, 160, 200];

        #查询数据
        $this->_datas['rows'] = $obj->limit($page['limitM'] . ',' . $page['numPerPage'])->get();
        
        ///表头信息
        $this->_datas['thead'] = [
            ['ch'=>'ID', 'width'=>30],
            ['ch'=>'归属方', 'width'=>160],
            ['ch'=>'acc映射', 'width'=>120],
            ['ch'=>'pwd映射', 'width'=>120],
            ['ch'=>'标签', 'width'=>220]
        ];

        ///分配模板变量&渲染模板
        $this->assign($this->_datas);
        $this->display('memAccPwd/index.tpl');
    }

    public function adUpd(){ 
        ///接收数据
        $request = REQUEST()->all();

        ///编辑部分
        if( isset($request['id']) ){

            $this->_datas['id'] = $request['id'];
            $this->_datas['row'] = M()->table('mem_acc__mem_pwd as map')->select('map.*, ma.mem_acc, mp.mem_pwd')->where(['map.id', $request['id']])
            ->leftjoin('mem_acc as ma', 'ma.id=map.mem_acc__id')
            ->leftjoin('mem_pwd as mp', 'mp.id=map.mem_pwd__id')
            ->find();
        }

        ///分配模板变量&渲染模板
        $this->assign($this->_datas);   
        $this->display('memAccPwd/adUpd.tpl');
    }

    public function post(){
        ///接收数据
        $request = REQUEST()->all();

        ///检查数据
        //check($request,  $this->_extra['form-elems'])

        ///模型对象
        $obj = M()->table('mem_acc__mem_pwd');

        if( isset($request['id']) ){///编辑
            #查询已有数据
            $ori = $obj->select('*')->where(['id', $request['id']])->find();

            #新老数据对比，构建编辑数据
            $request['mem_acc__id'] = $request['accLookup_mem_acc__id'];
            $request['mem_pwd__id'] = $request['pwdLookup_mem_pwd__id'];
            $update = F()->compare($request, $ori, ['mem_acc__id', 'mem_pwd__id', 'belongs_to', 'comm', 'tags']);

            if( empty($update) ) JSON()->stat(300)->msg('您还没有修改任何数据！请先修改数据。')->exec();
            $re = $obj->update($update)->where(['id', $request['id']])->exec();

        }else{///新增

            #数据是否重复，重复了没必要新增
            $duplicate = $obj->select('id')->where([
                ['mem_acc__id', $request['accLookup_mem_acc__id']],
                ['mem_pwd__id', $request['accLookup_mem_pwd__id']],
                ['belongs_to', $request['belongs_to']]
            ])->limit(1)->find();
            if(!empty($duplicate)) JSON()->stat(300)->msg('数据已经存在。')->exec();

            $insert = [
                'mem_acc__id' => !empty($request['accLookup_mem_acc__id']) ? $request['accLookup_mem_acc__id'] : 0,
                'mem_pwd__id' => !empty($request['pwdLookup_mem_pwd__id']) ? $request['pwdLookup_mem_pwd__id'] : 0,
                'mem_belongs_to__id' => !empty($request['belongsToLookup_belongs_to__id']) ? $request['belongsToLookup_belongs_to__id'] : 0,
                'comm' => $request['comm'],
                'tags' => $request['tags'],
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

        //执行删除操作  将需要删除的数据 is_del字段设置为1
        $re = M('UserModel')->fields('is_del')->update([1])->where(['id', '=', $request['id']])->exec();

        if( $re ){
            JSON()->navtab($this->_navTab.'_index')->msg('删除成功！')->exec();
        }else{
            JSON()->stat(300)->msg('操作失败')->exec();
        }
    }
}      
