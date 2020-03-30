<?php
namespace tools\controller;
use \core\controller;
use \model\ChifanModel;

class ChifanController extends Controller {

    ##标准预定义属性
    protected $_datas = [];
    private $_extra=[];
    private $_navTab;

    public function __construct(){

        parent::__construct();

        $this->_navTab = 'tools_chifan';
        $this->_datas['navTab'] = $this->_navTab;

        ///数据表值对字段
        $this->_datas['types'] = ChifanModel::C_TYPES;
        $this->_datas['main_type'] = ChifanModel::C_MAIN_TYPE;
        $this->_datas['second_type'] = ChifanModel::C_SECOND_TYPE;

        $this->_datas['url'] = [
            'index' => ['url'=>L('/tools/chifan/list'), 'rel'=>$this->_navTab.'_index'],
            'edit' => ['url'=>L('/tools/chifan/edit'), 'rel'=>$this->_navTab.'_AdUpd'],
            'post' => ['url'=>L('/tools/chifan/post')],
            'del' => ['url'=>L('/tools/chifan/del')],
            'editorImgUp' => ['url'=>L('/tools/editorbd/imgUp')]
        ];

        
        //不同页面的个性化需求
        switch ( ACT ){
            case 'index':
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

            break;
            case 'updh':
                //rule:  required  int  int:min0:max10   int:min0  int:max10   int:regex@xxx  mul-int  mul-int:min0:max10  mul-int:max10  mul-int:min0  mul-mixd   mul-mixd:regex@xxx   regex@xxx
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

        
    }

    public function index(){ 

        ///接收数据
        $request = REQUEST()->all();
        $this->_datas['search'] = $request;

        ///需要搜索的字段
        $search_form = [
            // ['s_name', 'like'],
            // ['s_flag', 'like']
        ];
        $condition = F()->S2C($request, $search_form);
        if(empty($condition)) $condition=1;

        ///构建查询对象
        $obj = M()->table('chifan')->select('*')->where($condition);

        #分页参数
        $nowPage = isset($request['pageNum']) ? intval($request['pageNum']) : (isset($_COOKIE['pageNum']) ? intval($_COOKIE['pageNum']) : 1);
        $this->_datas['page'] = $page = $obj->pagination($nowPage)->pagination;
        $page['numPerPageList'] = [20, 30, 40, 60, 80, 100, 120, 160, 200];

        #查询数据
        $this->_datas['rows'] = $obj->limit($page['limitM'] . ',' . $page['numPerPage'])->get();

        ///表头信息
        $this->_datas['thead'] = [
            ['ch'=>'菜品', 'width'=>160],
            ['ch'=>'适用时段', 'width'=>120],
            ['ch'=>'主类型', 'width'=>120],
            ['ch'=>'副类型', 'width'=>120],
            ['ch'=>'口味', 'width'=>120],
            ['ch'=>'口感', 'width'=>120],
            ['ch'=>'功效', 'width'=>120],
            ['ch'=>'副作用', 'width'=>120],
            ['ch'=>'ID', 'width'=>30]
        ];

        ///分配模板变量&渲染模板
        $this->assign($this->_datas);
        $this->display('Chifan/index.tpl');
    }

    public function adUpd(){ 
        ///接收数据
        $request = REQUEST()->all();

        ///编辑部分
        if( isset($request['id']) ){
            $this->_datas['row'] = M()->table('chifan')->select('*')->where(['id', $request['id']])->find();
        }

        ///分配模板变量&渲染模板
        $this->assign($this->_datas);   
        $this->display('Chifan/adUpd.tpl');
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
        $insert = [
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

        $re = M()->table('chifan')->insert($insert)->exec();

        //执行新增
        if( $re ){
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
        $row = M()->table('chifan')->select('*')->where(['id', $request['id']])->find();

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

        $re = M()->table('chifan')
        ->fields(array_keys($datas))
        ->update($datas)
        ->where(['id', '=', $request['id']])
        ->exec();

        //执行更新
        if( $re ){
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

    public function del(){
    
        //接收数据
        $request = $_REQUEST;

        //检查数据
        // $this->_extra['form-elems']['id'] = ['ch'=>'菜品ID', 'rule'=>'required'];
        //check($request,  $this->_extra['form-elems'])

        //执行删除操作
        $re = M()->table('chifan')->fields('is_del')->update([1])->where(['id', '=', $request['id']])->exec();

        //将需要删除的数据 is_del字段设置为1
        if( $re ){
            $re = AJAXre();
            $re->navTabId = $this->_navTab.'_index';
            $re->message = '删除成功！';
        }else{
            $re = AJAXre(1);
        }

        //返回删除结果
        echo json_encode($re);
        exit;
    }

    

    
}      
