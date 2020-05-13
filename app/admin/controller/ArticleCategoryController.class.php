<?php
namespace admin\controller;
use \core\controller;
use \model\ArticleCategoryModel;
use \Validator;

class ArticleCategoryController extends Controller {

    ##标准预定义属性
    public $_datas = [];

    public function __construct(){

        parent::__construct();

        $this->_datas['url'] = [
            'index' => $this->route('get',  '/admin/article/cate'),
            'post'  => $this->route('post', '/admin/article/cate/post'),
            // 'del'   => ['url'=>L('/admin/article/cate/del')]
        ];

        $this->_datas['level']  = ArticleCategoryModel::C_LEVEL;
        $this->_datas['navTab'] = $this->navtab;
    }

    /**
     * 首页展示
     */
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

    /**
     * 录入数据
     */
    public function post(){
    
        ///初始化参数
        $request                = REQUEST()->all();
        $article_cate_service   = M('ArticleCateService');

        ///检查数据
        $article_cate_service->checkPostRequest($request);

        ///录入数据,如失败，在服务中拦截
        if( isset($request['id']) ){#编辑
            $article_cate_service->update($request);
        }else{#新增
            $article_cate_service->insert($request);
        }

        JSON()->navtab($this->navtab)->msg('操作成功！')->exec();
    }

    public function catLookup(){
    
        ///获得所有的分类数据
        $cats = M('ArticleCategoryModel')->select('id, name, pid, level')->get();

        $tree = [];
        M('ArticleCateService')->recursiveCat($tree, $cats);

        ///渲染视图
        $this->_datas['cats'] = $tree;
        $this->display('articleCate/catLookup.tpl');
    }


    public function del1(){
    
        ///初始化参数
        $request = REQUEST()->all();

        ///检查数据
        $obj = Validator::make($request, ['id'=>'required'], ['id.required'=>'非法的操作']);
        #有错误信息则返回给页面
        if( !empty($obj->err) ) JSON()->stat(300)->msg($obj->getErrMsg())->exec();

        ///执行删除操作  将需要删除的数据 is_del字段设置为1
        $re = M('UserModel')->fields('is_del')->update([1])->where(['id', '=', $request['id']])->exec();
        
        if( $re ){
            JSON()->navtab($this->navtab)->msg('删除成功！')->exec();
        }else{
            JSON()->stat(300)->msg('操作失败')->exec();
        }
    }
}      
