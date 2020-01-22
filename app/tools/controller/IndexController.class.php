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

        $menu1 = M()->table('menu')->select('id,name,parent_id,level')->where([['is_del', 0],['level', 1]])->get();
        $menu2 = M()->table('menu')->select('id,name,parent_id,level')->where([['is_del', 0],['level', 2]])->get();
        $menu3 = M()->table('menu')->select('id,name,parent_id,level,plat,module,act,navtab')->where([['is_del', 0],['level', 3]])->get();

        $loginOutUrl = 'xxxx';

        $this->assign(array(
            'menu1'=>$menu1,
            'menu2'=>$menu2,
            'menu3'=>$menu3,
            'loginOutUrl'=>$loginOutUrl
        ));

	    $this->display('Index/index.tpl');
    }

    private function menus(){ 

        #获得所有的分类数据
        $menus = M()->table('menu')->select('id,name,parent_id,level')->where(['is_del', 0])->get();

        $tree_out = [];
        $this->recursiveMenu($tree_out, $menus);

        return $tree_out;
        
    }

    private function recursiveMenu(&$tree_in, $menus, $parent_id=0, $space=0){ 
        
        foreach( $menus as $cats_val1 ){ 
            
            if( $cats_val1['parent_id']==$parent_id ){
                
                $cats_val1['space'] = $space;
                $tree_in[] = $cats_val1;

                $next_space = $space+1;
                $this->recursiveMenu($tree_in, $menus, $cats_val1['id'], $next_space);
            }
        }
    }

    public function selfmain() {
    
        $this->display('Index/main.tpl');
    }
}
