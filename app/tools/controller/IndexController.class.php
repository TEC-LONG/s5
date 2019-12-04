<?php
namespace tools\controller;
use \core\Controller;

class IndexController extends Controller {

    //protected function _init() {
    
        ////$this->t_modelMenu = D('menu');
        ////实例化auth类

    //}

    //protected function _checkLogin() {
        
        //C('DB_PREFIX', 'shop_');
        //$modelMember = D('member');
        //if ( !$modelMember->checkLoginExpire() ){ 
            //$_loginUrl = C('URL').C('FS').C('FApps').C('FS').'Login'.C('FS').'index';
            //$this->error('请登陆！', $_loginUrl);
        //}
        //C('DB_PREFIX', 'adm_');
    //}

    public function index(){

        $menu = array( C('tools.menu.menu1'), C('tools.menu.menu2'), C('tools.menu.menu3'), C('tools.menu.menu4') );
        $loginOutUrl = 'xxxx';

        $this->assign(array(
            'menu'=>$menu,
            'loginOutUrl'=>$loginOutUrl
        ));

	    $this->display('Index/index.tpl');
    }

    public function selfmain() {
    
        $this->display('Index/selfmain.tpl');
    }
}
