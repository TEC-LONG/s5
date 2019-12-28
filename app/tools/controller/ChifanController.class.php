<?php
namespace tools\controller;
use \core\controller;

class ChifanController extends Controller {

    ##标准预定义属性
    protected $_datas = [];
    private $_init=[];
    private $_extra=[];
    private $_model;
    private $_navTab;

    public function __construct(){

        parent::__construct();

        $this->_navTab = 'chifan';

        //非标准预定义属性赋值与转换
        $this->_init['types'] = '{"0":"早餐", "1":"午餐", "2":"晚餐", "3":"睡前", "4":"休闲"}';
        $this->_init['food_types'] = '{"0":"粥", "1":"粉", "2":"面", "3":"饭", "4":"点心", "5":"汤", "6":"大菜", "7":"下饭菜", "8":"小菜", "9":"配菜"}';
        $this->_init['taste'] = '{"0":"酸", "1":"甜", "2":"苦", "3":"辣", "4":"咸", "5":"香", "6":"鲜", "7":"无味", "8":"辛辣"}';
        $this->_init['mouthfeel'] = '{"0":"软", "1":"硬", "2":"糯", "3":"脆", "4":"Q弹", "5":"丝滑", "6":"入口即化", "7":"嫩"}';
        $this->_init['effects'] = '{"0":"温补", "1":"清热", "2":"解毒", "3":"去湿", "4":"安神", "5":"镇痛"}';
        $this->JD($this->_init);

        //扔进模板
        $this->_datas = $this->_init;
        
        //不同页面的个性化需求
        switch ( ACT ){
            case 'index':
                $this->_datas['url'] = [
                    'ad' => ['url'=>L(PLAT, MOD, 'ad'), 'rel'=>$this->_navTab.'_ad'],
                    'upd' => ['url'=>L(PLAT, MOD, 'upd'), 'rel'=>$this->_navTab.'_upd'],
                    'del' => L(PLAT, MOD, 'del')
                ];
                $this->_datas['mustShow'] = [
                    'id' => ['ch'=>'ID', 'width'=>30], 
                    'cai' => ['ch'=>'菜品', 'width'=>60], 
                    'food_types' => ['ch'=>'食物类型', 'width'=>60, 'is_set'=>1], //is_set表示是否为集合型数据字段，即格式类似"1,2,4,5"这样的多项字符串
                    'types' => ['ch'=>'适用场景', 'width'=>100, 'is_set'=>1], 
                    'taste' => ['ch'=>'口味', 'width'=>60, 'is_set'=>1], 
                    'mouthfeel' => ['ch'=>'口感', 'width'=>60, 'is_set'=>1],
                    'effects' => ['ch'=>'功效', 'width'=>100, 'is_set'=>1],
                    'byeffect' => ['ch'=>'副作用', 'width'=>150]
                ];

                $this->_model = M();
            break;
            case 'ad':
                $this->_datas['url'] = [
                    'adh' => L(PLAT, MOD, 'adh')
                ];
            break;
            case 'adh':
            case 'updh':
                //rule:  required  int  int:min0:max10   int:min0  int:max10   int:regex(xx)  mul-int  mul-int:min0:max10  mul-int:max10  mul-int:min0  mul-mixd   mul-mixd:regex(xx)
                $this->_extra['form-elems'] = [
                    'cai' => ['ch'=>'菜品', 'rule'=>'required'], 
                    'food_types' => ['ch'=>'食物类型', 'rule'=>'required|mul-int:min0:max9', 'msg'=>[
                        'required'=> 'xxx必须填写！',
                        'mul-int'=> 'xxx所有值必须为数字！',
                        // 'mul-int-min'=> 'xxx所有的值都不能小于0！',//单纯只有min规则时
                        // 'mul-int-max'=> 'xxx所有的值都不能大于9！',//单纯只有max规则时
                        'mul-int-min-max'=> 'xxx所有的值都需要在0~9之间！',//min和max同时存在时
                    ]], 
                    'types' => ['ch'=>'适用场景', 'rule'=>'required|mul'],
                    'taste' => ['ch'=>'口味', 'rule'=>'mul'], 
                    'mouthfeel' => ['ch'=>'口感', 'rule'=>'mul'],
                    'effects' => ['ch'=>'功效', 'rule'=>'mul'],
                    'effects_comm' => ['ch'=>'功效描述'],
                    'descr' => ['ch'=>'描述'],
                    'byeffect' => ['ch'=>'副作用']
                ];
            break;
            case 'upd':
                $this->_datas['url'] = [
                    'updh' => L(PLAT, MOD, 'updh')
                ];
                $this->_extra['form-elems'] = [
                    'id' => ['ch'=>'菜品ID', 'rule'=>'required']
                ];
                //arr:|  以"|"将字符串炸开成数组，不指定默认以","炸开
                $this->_extra['special_fields'] = [
                    'types' => 'arr',
                    'food_types' => 'arr',
                    'taste' => 'arr',
                    'mouthfeel' => 'arr',
                    'effects' => 'arr'
                ];
            break;
        }

        $this->_datas['navTab'] = $this->_navTab;
    }

    public function index(){ 

        //查询数据
        $sql = 'select * from chifan where 1 order by id desc';

        if( $cais = M()->getRows($sql) ){
            foreach( $cais as &$cai ){ 
                if( !empty($cai['expnew_ids']) ){
                    $cai['expnew_titles'] = explode('|', $cai['expnew_titles']);
                    $cai['expnew_ids'] = explode('|', $cai['expnew_ids']);
                }
                $cai['has_descr'] = !empty($cai['descr']) ? '是' : '否';
            }
            $this->_datas['cais'] = $cais;//扔到模板中
        }

        //列表html 扔到模板中
        $this->_datas['tbhtml'] = $this->_tbhtml($this->_datas['mustShow'], $cais, $this->_navTab, $this->_init);

        //分配模板变量&渲染模板
        $this->assign($this->_datas);
        $this->display('Chifan/index.tpl');
    }

    public function ad(){ 

        $this->assign($this->_datas);

        $this->display('Chifan/ad.tpl');
    }

    public function adh(){ 
        //接收数据
        $request = $_REQUEST;

        //检查数据
        //check($request,  $this->_extra['form-elems'])

        //构建新增数据
        $datas = [
            'cai' => $request['cai'],
            'descr' => $request['descr'],
            'types' => implode(',', $request['types']),
            'food_types' => implode(',', $request['food_types']),
            'taste' => implode(',', $request['taste']),
            'mouthfeel' => implode(',', $request['mouthfeel']),
            'effects' => implode(',', $request['effects']),
            'effects_comm' => $request['effects_comm'],
            'byeffect' => $request['byeffect'],
            'post_date' => time()
        ];

        //执行新增
        if( M()->setData('chifan', $datas) ){
            $re = AJAXre();
            $re->navTabId = $this->_navTab.'_ad';
            $re->message = '菜品添加成功！';
        }else{
            $re = AJAXre(1);
        }

        #返回结果
        echo json_encode($re); 
        exit;
    }

    public function upd(){ 
        
        //接收数据
        $request = $_REQUEST;

        //检查数据
        //check($request,  $this->_extra['form-elems'])

        //查询数据
        $sql = 'select * from chifan where id=' . $request['id'];
        $row = M()->getRow($sql);

        //特殊字段处理
        $this->_datas['row'] = $this->_special_fields($this->_extra['special_fields'], $row);

        //分配模板变量&渲染模板
        $this->assign($this->_datas);
        $this->display('Chifan/upd.tpl');
    }

    public function updh(){ 

        //接收数据
        $request = $_REQUEST;

        //检查数据
        // $this->_extra['form-elems']['id'] = ['ch'=>'菜品ID', 'rule'=>'required'];
        //check($request,  $this->_extra['form-elems'])

        //构建更新的数据
        #需要确认是否被修改了，修改了的才更新
        $datas = [
            'cai' => $request['cai'],
            'descr' => $request['descr'],
            'types' => empty($request['types']) ? '' : implode(',', $request['types']),
            'food_types' => empty($request['food_types']) ? '' : implode(',', $request['food_types']),
            'taste' => empty($request['taste']) ? '' : implode(',', $request['taste']),
            'mouthfeel' => empty($request['mouthfeel']) ? '' : implode(',', $request['mouthfeel']),
            'effects' => empty($request['effects']) ? '' : implode(',', $request['effects']),
            'effects_comm' => $request['effects_comm'],
            'byeffect' => $request['byeffect']
        ];

        //执行更新
        if( M()->setData('chifan', $datas, 2, ['id'=>$request['id']]) ){
            $re = AJAXre();
            $re->navTabId = $this->_navTab.'_upd';
            $re->message = '更新菜品成功！';
        }else{
            $re = AJAXre(1);
        }

        #返回结果
        echo json_encode($re); 
        exit;
    }

    

    
}      
