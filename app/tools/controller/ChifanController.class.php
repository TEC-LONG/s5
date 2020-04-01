<?php
namespace tools\controller;
use \core\controller;
use \model\ChifanModel;
use \model\ImagesModel;

class ChifanController extends Controller {

    ##标准预定义属性
    protected $_datas = [];
    private $_extra=[];
    protected $_navTab;

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
        $nowPage = isset($request['pageNum']) ? intval($request['pageNum']) : 1;
        $this->_datas['page'] = $page = $obj->pagination($nowPage)->pagination;
        $page['numPerPageList'] = [20, 30, 40, 60, 80, 100, 120, 160, 200];

        #查询数据
        $this->_datas['rows'] = $obj->limit($page['limitM'] . ',' . $page['numPerPage'])->get();

        ///表头信息
        $this->_datas['thead'] = [
            ['ch'=>'菜品', 'width'=>80],
            ['ch'=>'适用时段', 'width'=>80],
            ['ch'=>'主类型', 'width'=>80],
            ['ch'=>'副类型', 'width'=>80],
            ['ch'=>'口味', 'width'=>80],
            ['ch'=>'口感', 'width'=>80],
            ['ch'=>'功效', 'width'=>80],
            ['ch'=>'副作用', 'width'=>160],
            ['ch'=>'ID', 'width'=>30]
        ];

        ///处理集合数据
        foreach( $this->_datas['rows'] as $k=>$v){
        
            // $this->_datas['rows'][$k]['types'] = explode(',', $v['types']);
            // $this->_datas['rows'][$k]['main_type'] = explode(',', $v['main_type']);
            // $this->_datas['rows'][$k]['second_type'] = explode(',', $v['second_type']);
            $need = ['types', 'main_type', 'second_type'];
            foreach( $need as $v1){
            
                $tmp_arr = explode(',', $v[$v1]);
                $tmp_arr1 = [];
                foreach( $tmp_arr as $v2){
                    $tmp_arr1[] = $this->_datas[$v1][$v2];
                }
                $this->_datas['rows'][$k][$v1] = implode(',', $tmp_arr1);
            }
        }

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
            $this->_datas['row']['types'] = explode(',', $this->_datas['row']['types']);
            $this->_datas['row']['main_type'] = explode(',', $this->_datas['row']['main_type']);
            $this->_datas['row']['second_type'] = explode(',', $this->_datas['row']['second_type']);
        }

        ///分配模板变量&渲染模板
        $this->assign($this->_datas);   
        $this->display('Chifan/adUpd.tpl');
    }

    public function post(){
        ///接收数据
        $request = REQUEST()->all();
        if(isset($request['types'])) $request['types']=implode(',', $request['types']);
        if(isset($request['main_type'])) $request['main_type']=implode(',', $request['main_type']);
        if(isset($request['second_type'])) $request['second_type']=implode(',', $request['second_type']);

        ///检查数据
        #check($request,  $this->_extra['form-elems'])

        ///模型对象
        $obj = M()->table('chifan');

        if( isset($request['id']) ){///编辑
            #查询已有数据
            $ori = $obj->select('*')->where(['id', $request['id']])->find();

            #新老数据对比，构建编辑数据
            $update = F()->compare($request, $ori, ['cai', 'types', 'main_type', 'second_type', 'descr', 'taste', 'mouthfeel', 'effects', 'effects_comm', 'byeffect']);
            if( empty($update) ) JSON()->stat(300)->msg('您还没有修改任何数据！请先修改数据。')->exec();

            $re = $obj->fields(array_keys($update))->update($update)->where(['id', $request['id']])->exec();
            $id = $request['id'];

        }else{///新增

            #数据是否重复，重复了没必要新增
            $duplicate = $obj->select('id')->where(['cai', $request['cai']])->limit(1)->find();
            if(!empty($duplicate)) JSON()->stat(300)->msg('菜品"'.$request['cai'].'"已经存在！无需重复添加。')->exec();

            $insert = [
                'cai' => $request['cai'],
                'types' => isset($request['types'])?$request['types']:'',
                'main_type' => isset($request['main_type'])?$request['main_type']:'',
                'second_type' => isset($request['second_type'])?$request['second_type']:'',
                'descr' => $request['descr'],
                'taste' => $request['taste'],
                'mouthfeel' => $request['mouthfeel'],
                'effects' => $request['effects'],
                'effects_comm' => $request['effects_comm'],
                'byeffect' => $request['byeffect'],
                'post_date' => time()
            ];

            $re = $obj->insert($insert)->exec();
            $id = M()->last_insert_id();
        }

        ///富文本图片入库处理
        M('EditorTool')->textarea('descr')->cookie('xhimages')->type('xheditor', ImagesModel::C_TYPE)->table('chifan')->id($id)->field('descr')->editorimg($request);
        M('EditorTool')->textarea('effects_comm')->cookie('xhimages')->type('xheditor', ImagesModel::C_TYPE)->table('chifan')->id($id)->field('effects_comm')->editorimg($request);
        
        ///返回结果
        if( $re ){
            JSON()->navtab($this->_navTab.'_AdUpd')->exec();
        }else{
            JSON()->stat(300)->msg('操作失败')->exec();
        }
    }

    public function del(){
    
        //接收数据
        $request = $_REQUEST;

        //检查数据
        // $this->_extra['form-elems']['id'] = ['ch'=>'菜品ID', 'rule'=>'required'];
        //check($request,  $this->_extra['form-elems'])

        M('EditorTool')->type('xheditor', ImagesModel::C_TYPE)->table('chifan')->id($request['id'])->field('descr')->clear();
        M('EditorTool')->type('xheditor', ImagesModel::C_TYPE)->table('chifan')->id($request['id'])->field('effects_comm')->clear();

        //执行删除操作
        $re = M()->table('chifan')->where(['id', '=', $request['id']])->delete();

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
