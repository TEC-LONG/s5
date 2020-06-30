<?php

namespace core;
use Route;

class Controller extends \Smarty{

    //protected $smarty;
    protected $manager;
    protected $navtab;

    public function __construct(){ 

        parent::__construct();//执行一次Smarty类的构造方法

        //指定模板文件存放的目录（如果是后台则目录应是blog/app/admin/view；如果是前台则目录应是blog/app/home/view）
        $path = APP_PATH . $GLOBALS['plat'] . '/';
        //$this->left_delimiter = '{#';
        //$this->right_delimiter = '#}';

        $this->setTemplateDir($path . 'view');
        $this->setCompileDir($path . 'view_c');

        //调用方法检查是否已经登陆
        $this->checkIsLogin();

        ///初始化数据
        $this->navtab = Route::$navtab;
    }

    protected function checkIsLogin(){ 
        //http://www.blog.com/index.php?p=home&m=index&a=showIndex
        @session_start();
        //检查之前是否已经登陆过
        //如果没有$_SESSION['user']数据，则说明之前没有登陆成功或者根本没有登陆过
        $LoginControler = PLAT=='tools'&& MOD=='Login';//表示登录模块，即LoginController中的所有方法
        $LoginControler = $LoginControler || PLAT=='blog';
        if( !isset($_SESSION['admin'])&&!$LoginControler ){//没有登录信息，又不是登录模块中的某个页面，则需要重新登录
            
            //if( isset($_COOKIE['is_login']) ){//没有SESSION登陆信息，但是存在7天免登录信息，则重新找回之前点击7天免登录的用户信息
                //根据记录的COOKIE信息找回用户所有的信息
                //$userModel = M('\\model\\UserModel');
                //$acc = T($_COOKIE['is_login']);
                //$sql = "select * from bl_user where account='{$acc}'";
                //$user = $userModel->getRow($sql);
                //将找回的用户信息重新存储进SESSION名为user的元素中
                //$_SESSION['user'] = $user;

            //}else{//即不存在SESSION登陆信息，也没有之前记录的7天免登录信息，则重新登陆
                J('请先登陆！', '/tools/login/index');
            //}
        }

        ///唤起登录的用户数据
        $this->manager = $_SESSION['admin'];
    }

    /**
     * @method  _pagination
     * 方法作用: 构建分页参数
     * 
     * @param    $request           array       [控制器负责接收数据的$request]
     * @param    $obj               object      [查询数据的模型对象]
     * @param    $numPerPageList    array       [每页展示数据条数列表]
     * 
     * @return    array    [包含分页各项数据的数组]
     */
    public function _paginate($request, $obj, $numPerPageList=[20, 30, 40, 60, 80, 100, 120, 160, 200]){

        $nowPage = isset($request['pageNum']) ? intval($request['pageNum']) : (isset($_COOKIE[$this->navtab.'pageNum']) ? intval($_COOKIE[$this->navtab.'pageNum']) : 1);

        $page = $obj->pagination($nowPage)->pagination;
        $page['numPerPageList'] = $numPerPageList;

        return $page;
    } 

    /**
     * @method  route
     * 方法作用: 构建跳转链接信息
     * 
     * @param    $type      array       [路由类型，取值范围："get"、"post"、"request"]
     * @param    $route     string      [路由全名，如："/admin/article"]
     * 
     * @return    array    [如return ['url'=>'https://xx.xx.xx/a/b', 'rel'=>'链接页面对应的navtab值'];]
     */
    ///                       get     /admin/user/index
    protected function route($type, $route){

        return [
            'url'=>L($route),
            'rel'=>Route::getElem($type, $route, 'navtab')
        ];
    }

}