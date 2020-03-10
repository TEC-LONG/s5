<?php
namespace tools\controller;
use \core\controller;

class MemAccPwdController extends Controller {

    ##标准预定义属性
    protected $_datas = [];
    private $_init = [];
    private $_extra = [];
    private $_navTab;

    public function __construct(){

        parent::__construct();

        $this->_navTab = 'tools_memAccPwd';
        $this->_datas['navTab'] = $this->_navTab;

        $this->_datas['url'] = [
            'index' => ['url'=>L(PLAT, MOD, 'index'), 'rel'=>$this->_navTab.'_index'],
            'adupd' => ['url'=>L(PLAT, MOD, 'adupd'), 'rel'=>$this->_navTab.'_adupd'],
            'post' => ['url'=>L(PLAT, MOD, 'post')],
            'accIndex' => ['url'=>L(PLAT, MOD, 'accIndex'), 'rel'=>$this->_navTab.'_accIndex'],
            'accAdUpd' => ['url'=>L(PLAT, MOD, 'accAdUpd'), 'rel'=>$this->_navTab.'_accAdUpd'],
            'accPost' => ['url'=>L(PLAT, MOD, 'accPost')],
            'pwdIndex' => ['url'=>L(PLAT, MOD, 'pwdIndex'), 'rel'=>$this->_navTab.'_pwdIndex'],
            'pwdAdUpd' => ['url'=>L(PLAT, MOD, 'pwdAdUpd'), 'rel'=>$this->_navTab.'_pwdAdUpd'],
            'pwdPost' => ['url'=>L(PLAT, MOD, 'pwdPost')],
            'del' => ['url'=>L(PLAT, MOD, 'del')]
        ];
    }

    public function accIndex(){
        ///接收数据
        $request = REQUEST()->all();
        $this->_datas['accIndexType'] = isset($request['type']) ? $request['type'] : '';

        ///将搜索的原始数据扔进模板
        #需要搜索的字段
        // $form_elems = [];
        // $this->_datas['search'] = $this->_get_ori_search_datas($request, $form_elems);

        ///构建查询对象
        $obj = M()->table('mem_acc')->select('*')->where(1);

        #分页参数
        $this->_data['page'] = $page = $this->_paginate($request, $obj);

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

            $this->_data['id'] = $request['id'];
            $this->_data['row'] = M()->table('mem_acc')->select('*')->where(['id', $request['id']])->find();
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

        ///数据是否重复，重复了没必要增和改
        $duplicate = $obj->select('id')->where(['mem_acc', $request['mem_acc']])->limit(1)->find();
        if(!empty($duplicate)) JSON()->stat(300)->msg('"账号数据"已经存在。')->exec();

        if( isset($request['id']) ){///编辑
            #查询已有数据
            $ori = M()->table('mem_acc')->select('*')->where(['id', $request['id']])->find();

            #新老数据对比，构建编辑数据
            $update = F()->compare($request, $ori, ['mem_acc']);

            if( empty($update) ) JSON()->stat(300)->msg('您还没有修改任何数据！请先修改数据。')->exec();
            $re = $obj->fields(array_keys($update))->update($update)->where(['id', $request['id']])->exec();

        }else{///新增
            $insert = [
                'mem_acc' => $request['mem_acc'],
                'post_date' => time()
            ];

            $re = $obj->insert($insert)->exec();
        }
        
        ///返回结果
        if( $re ){
            JSON()->navtab($this->_navTab.'_accPost')->exec();
        }else{
            JSON()->stat(300)->msg('操作失败')->exec();
        }
    }

    public function pwdIndex(){
        ///接收数据
        $request = REQUEST()->all();
        $this->_datas['pwdIndexType'] = isset($request['type']) ? $request['type'] : '';

        ///将搜索的原始数据扔进模板
        #需要搜索的字段
        // $form_elems = [];
        // $this->_datas['search'] = $this->_get_ori_search_datas($request, $form_elems);

        ///构建查询对象
        $obj = M()->table('mem_pwd')->select('*')->where(1);

        #分页参数
        $this->_data['page'] = $page = $this->_paginate($request, $obj);

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

            $this->_data['id'] = $request['id'];
            $this->_data['row'] = M()->table('mem_pwd')->select('*')->where(['id', $request['id']])->find();
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

        ///数据是否重复，重复了没必要增和改
        $duplicate = $obj->select('id')->where(['mem_pwd', $request['mem_pwd']])->limit(1)->find();
        if(!empty($duplicate)) JSON()->stat(300)->msg('"密码数据"已经存在。')->exec();

        if( isset($request['id']) ){///编辑
            #查询已有数据
            $ori = M()->table('mem_pwd')->select('*')->where(['id', $request['id']])->find();

            #新老数据对比，构建编辑数据
            $update = F()->compare($request, $ori, ['mem_pwd']);

            if( empty($update) ) JSON()->stat(300)->msg('您还没有修改任何数据！请先修改数据。')->exec();
            $re = $obj->fields(array_keys($update))->update($update)->where(['id', $request['id']])->exec();

        }else{///新增
            $insert = [
                'mem_pwd' => $request['mem_pwd'],
                'post_date' => time()
            ];

            $re = $obj->insert($insert)->exec();
        }
        
        ///返回结果
        if( $re ){
            JSON()->navtab($this->_navTab.'_pwdPost')->exec();
        }else{
            JSON()->stat(300)->msg('操作失败')->exec();
        }
    }

    public function index(){ 
        ///接收数据
        $request = REQUEST()->all();

        ///将搜索的原始数据扔进模板
        #需要搜索的字段
        // $form_elems = [];
        // $this->_datas['search'] = $this->_get_ori_search_datas($request, $form_elems);

        ///构建查询对象
        $obj = M()->table('mem_acc__mem_pwd as map')->select('map.*, ma.mem_acc, mp.mem_pwd')->where(1)
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
            ['ch'=>'acc映射', 'width'=>120],
            ['ch'=>'pwd映射', 'width'=>120]
        ];

        ///分配模板变量&渲染模板
        $this->assign($this->_datas);
        $this->display('memAccPwd/index.tpl');
    }

    public function adupd(){ 
         ///接收数据
        $request = REQUEST()->all();

        ///编辑部分
        if( isset($request['id']) ){

            $this->_data['id'] = $request['id'];
            $this->_data['row'] = M()->table('mem_acc__mem_pwd as map')->select('map.*, ma.mem_acc, mp.mem_pwd')->where(['id', $request['id']])
            ->leftjoin('mem_acc as ma', 'ma.id=map.mem_acc__id')
            ->leftjoin('mem_pwd as mp', 'mp.id=map.mem_pwd__id')
            ->find();
        }

        ///分配模板变量&渲染模板
        $this->assign($this->_datas);   
        $this->display('memAccPwd/adUpd.tpl');
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
            'level' => 1,
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
