<?php
namespace tools\controller;
use \core\controller;

class ChifanController extends Controller {

    ##标准预定义属性
    private $_datas = [];
    private $_url = [];
    private $_navTab;

    ##非标准预定义属性
    private $_type = [0=>'午餐晚餐', 1=>'早餐', 2=>'通用'];
    private $_food_type = [0=>'主食', 1=>'配菜', 2=>'营养补充', 3=>'主菜', 4=>'饮品', 5=>'汤'];


    public function __construct(){

        parent::__construct();

        $this->_navTab = 'chifan';
        
        switch ( ACT ){
            case 'index':
                $this->_url = [
                    'ad' => ['url'=>L(PLAT, MOD, 'ad'), 'rel'=>$this->_navTab.'_ad'],
                    'upd' => ['url'=>L(PLAT, MOD, 'upd'), 'rel'=>$this->_navTab.'_upd'],
                    'del' => L(PLAT, MOD, 'del')
                ];
            break;
            case 'ad':
                $this->_url = [
                    'adh' => L(PLAT, MOD, 'adh')
                ];
            break;
            case 'upd':
                $this->_url = [
                    'updh' => L(PLAT, MOD, 'updh')
                ];
            break;
        }
    }

    public function index(){ 

        //查询数据
        $sql = 'select * from chifan where 1';

        if( $cais = M()->getRows($sql) ){
            foreach( $cais as $cais_key=>&$cai ){ 
                if( !empty($cai['expnew_ids']) ){
                    $cai['expnew_titles'] = explode('|', $cai['expnew_titles']);
                    $cai['expnew_ids'] = explode('|', $cai['expnew_ids']);
                }
                $cai['has_descr'] = !empty($cai['descr']) ? '是' : '否';
            }
        }

        //分配模板变量&渲染模板
        $this->assign([
            'food_type'=>$this->_food_type,
            'cais'=>$cais,
            'type'=>$this->_type,
            'url'=>$this->_url
        ]);
        $this->display('Chifan/index.tpl');
    }

    public function ad(){ 

        $this->assign([
            'food_type'=>$this->_food_type,
            'type'=>$this->_type,
            'url'=>$this->_url
        ]);

        $this->display('Chifan/ad.tpl');
    }

    public function adh(){ 
        //接收数据
        $datas = [
            'type' => $_POST['type'],
            'food_type' => $_POST['food_type'],
            'cai' => $_POST['cai'],
            'descr' => $_POST['descr']
        ];

        //执行新增
        if( M()->setData('chifan', $datas) ){
            $re = AJAXre();
            $re->navTabId = $this->_navTab.'_ad';
            $re->message = '添加成功！';
        }else{
            $re = AJAXre(1);
        }

        #返回结果
        echo json_encode($re); 
        exit;
    }

    public function upd(){ 
        
        //接收参数
        $id = $_GET['id'];

        //查询数据
        $sql = 'select * from chifan where id=' . $id;
        $cai = M()->getRow($sql);

        $this->assign([
            'food_type'=>$this->_food_type,
            'url'=>$this->_url,
            'type'=>$this->_type,
            'cai'=>$cai
        ]);

        $this->display('Chifan/upd.tpl');
    }

    public function updh(){ 
        //接收数据
        //接收参数
        $con = ['id'=>$_GET['id']];

        $datas = [
            'type' => $_POST['type'],
            'food_type' => $_POST['food_type'],
            'cai' => $_POST['cai'],
            'descr' => $_POST['descr']
        ];

        //执行新增
        if( M()->setData('chifan', $datas, 2, $con) ){
            $re = AJAXre();
            $re->navTabId = $this->_navTab.'_upd';
            $re->message = '更新成功！';
        }else{
            $re = AJAXre(1);
        }

        #返回结果
        echo json_encode($re); 
        exit;
    }

    

    
}      
