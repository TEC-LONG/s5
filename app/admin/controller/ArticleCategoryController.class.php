<?php
namespace admin\controller;
use \core\controller;
use \model\ArticleCategoryModel;
use \Validator;

class ArticleCategoryController extends Controller {

    ##标准预定义属性
    public $_datas = [];
    protected $_navTab;

    public function __construct(){

        parent::__construct();

        $this->_navTab = $navTab = 'admin_article_category';

        $this->_datas['url'] = [
            'index' => ['url'=>L('/admin/article/cate'),        'rel'=>$navTab.'_index'],
            'ad'    => ['url'=>L('/admin/article/cate/add'),    'rel'=>$navTab.'_add'],
            'upd'   => ['url'=>L('/admin/article/cate/upd'),    'rel'=>$navTab.'_upd'],
            'post'  => ['url'=>L('/admin/article/cate/post')],
            'del'   => ['url'=>L('/admin/article/cate/del')]
        ];

        $this->_datas['level']  = ArticleCategoryModel::C_LEVEL;
        $this->_datas['navTab'] = $navTab;
    }

    public function index(){

        ///初始化参数
        $article_cate_service = M('ArticleCateService');

        ///查询列表页数据
        $this->_datas['first'] = $article_cate_service->getCate();

        //分配模板变量&渲染模板
        $this->assign($this->_datas);
        $this->display('articleCate/index.tpl');
    }

    /**
     * 列表页ajax获得子分类
     */
    public function getChild(){ 

        ///初始化参数
        $article_cate_service = M('ArticleCateService');

        ///查询列表页数据
        $child = $article_cate_service->getCate($_POST['p_id'], 'child');

        ///返回数据
        JSON()->arr($child)->exec();
    }

    public function post(){
    
        ///初始化参数
        $request                = REQUEST()->all();
        $article_cate_service   = M('ArticleCateService');

        ///检查数据
        $article_cate_service->checkPostRequest($request);

        ///录入数据
        if( isset($request['id']) ){#编辑

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
        
        }else{#新增

            ##新增当前分类
            $article_cate_service->insert($request);
        }
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

    /**
     * 数据列表
     */
    public function index1(){ 

        ///初始化参数
        $request                = REQUEST()->all();
        $article_cate_service   = M('ArticleCateService');

        ///校验数据
        $article_cate_service->checkListRequest($request);
        
        ///获取列表数据
        $article_cate_service->getUserList($request, $this);

        ///额外的逻辑处理
        #表头信息
        $this->_datas['thead'] = [
            ['ch'=>'账号',      'width'=>120],
            ['ch'=>'用户昵称',  'width'=>120],
            ['ch'=>'手机号',    'width'=>100],
            ['ch'=>'邮箱',      'width'=>160],
            ['ch'=>'用户级别',  'width'=>60],
            ['ch'=>'状态',      'width'=>100],
            ['ch'=>'新增来源',  'width'=>120],
            ['ch'=>'ID',        'width'=>30]
        ];

        //分配模板变量&渲染模板
        $this->assign($this->_datas);
        $this->display('user/index.tpl');
    }

    /**
     * 添加/编辑页
     */
    public function showEdit(){
    
        ///初始化参数
        $request = REQUEST()->all();

        ///编辑页需查询回显数据
        if( isset($request['id']) ){
        
            #根据id查询
            $this->_datas['row'] = M()->table('user')->select('*')->where(['id', $request['id']])->find();
        }
        
        $this->assign($this->_datas);
        $this->display('user/edit.tpl');
    }

    /**
     * 录入数据
     */
    public function post1(){

        ///初始化参数
        $request        = REQUEST()->all();
        $user_service   = M('UserService');

        ///校验数据
        $user_service->checkPostRequest($request);

        ///文件上传
        $headimg = $user_service->upheadimg('img');

        ///录入数据
        if( isset($request['id']) ){#编辑
        
            $user_service->update($request, $headimg);

        }else{#新增

            $user_service->insert($request, $headimg);
        }

        ///返回失败结果
        JSON()->stat(300)->msg('操作失败')->exec();
    }

    public function del1(){
    
        ///初始化参数
        $request = REQUEST()->all();

        ///检查数据
        $obj = Validator::make($request, ['id'=>'required'], ['id.required'=>'非法的操作']);
        #有错误信息则返回给页面
        if( !empty($obj->err) ) JSON()->stat(300)->msg($obj->getErrMsg())->exec();

        $navtab = $this->_navTab.'_index';
        ///执行删除操作  将需要删除的数据 is_del字段设置为1
        $re = M('UserModel')->fields('is_del')->update([1])->where(['id', '=', $request['id']])->exec();
        
        if( $re ){
            JSON()->navtab($navtab)->msg('删除成功！')->exec();
        }else{
            JSON()->stat(300)->msg('操作失败')->exec();
        }
    }
}      
