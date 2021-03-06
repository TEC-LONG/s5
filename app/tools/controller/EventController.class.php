<?php
namespace tools\controller;
use \core\controller;

class EventController extends Controller {

    ##标准预定义属性
    protected $_datas = [];
    private $_init = [];
    private $_extra = [];
    protected $_navTab;

    public function __construct(){

        parent::__construct();

        $this->_navTab = 'tools_event';

        //扔进模板
        $this->_datas = $this->_init;

        $this->_datas['url'] = [
            'index' => ['url'=>L('/tools/event/index'), 'rel'=>$this->_navTab.'_index'],
            'ad' => ['url'=>L('/tools/event/ad'), 'rel'=>$this->_navTab.'_ad'],
            'adh' => ['url'=>L('/tools/event/adh')],
            'upd' => ['url'=>L('/tools/event/upd'), 'rel'=>$this->_navTab.'_upd'],
            'updh' => ['url'=>L('/tools/event/updh')],
            'del' => ['url'=>L('/tools/event/del')]
        ];

        $this->_datas['navTab'] = $this->_navTab;
    }

    public function index(){ 

        //接收数据
        $request = REQUEST()->all();
        #对时间数据进行补全
        if(isset($request['b_post_date'])&&!empty($request['b_post_date'])) $request['b_post_date'].=' 0:0:0';
        if(isset($request['e_post_date'])&&!empty($request['e_post_date'])) $request['e_post_date'].=' 23:59:59';
        if(isset($request['b_begin_time'])&&!empty($request['b_begin_time'])) $request['b_begin_time'].=' 0:0:0';
        if(isset($request['e_begin_time'])&&!empty($request['e_begin_time'])) $request['e_begin_time'].=' 23:59:59';
        if(isset($request['b_end_time'])&&!empty($request['b_end_time'])) $request['b_end_time'].=' 0:0:0';
        if(isset($request['e_end_time'])&&!empty($request['e_end_time'])) $request['e_end_time'].=' 23:59:59';

        // //查询条件(融合搜索条件)
        $con_arr = ['is_del', 0];

        // #需要搜索的字段
        $form_elems = [
            ['title', 'like'],
            ['post_date', 'time-in'],
            ['begin_time', 'time-in'],
            ['end_time', 'time-in']
        ];

        $con = $this->_condition_string($request, $form_elems, $con_arr);//将条件数组数据转换为条件字符串

        // //将搜索的原始数据扔进模板
        $this->_datas['search'] = $this->_get_ori_search_datas($request, $form_elems);

        //查询数据
        $this->_datas['rows'] = M()->table('event')->select('*')->where($con)->orderby('post_date desc')->get();

        //分配模板变量&渲染模板
        $this->assign($this->_datas);
        $this->display('event/index.tpl');
    }

    public function ad(){ 

        $this->assign($this->_datas);

        $this->display('event/ad.tpl');
    }

    public function adh(){ 
        //接收数据
        $request = REQUEST()->all();

        

        //检查数据
        $this->_extra['form-elems'] = [
            'title' => ['ch'=>'标题', 'rule'=>'required']
        ];
        //check($request,  $this->_extra['form-elems'])

        //构建新增数据
        $insert = [
            'title' => $request['title'],
            'begin_time' => !empty($request['begin_time']) ? strtotime($request['begin_time'].' 0:0:0') : 0,
            'end_time' => !empty($request['end_time']) ? strtotime($request['end_time'].' 23:59:59') : 0,
            'descr' => $request['descr'],
            'post_date' => time()
        ];

        $re = M()->table('event')->insert($insert)->exec();

        //执行新增
        if( $re ){
            JSON()->navtab($this->_navTab.'_index')->exec();
        }else{
            JSON()->stat(300)->msg('操作失败')->exec();
        }
    }

    public function upd(){ 
        
        //接收数据
        $request = REQUEST()->all();

        //检查数据
        $this->_extra['form-elems'] = [
            'id' => ['ch'=>'ID', 'rule'=>'required']
        ];
        //check($request,  $this->_extra['form-elems'])

        //查询数据
        $this->_datas['row'] = M()->table('event')->select('*')->where(['id', $request['id']])->find();

        //分配模板变量&渲染模板
        $this->assign($this->_datas);
        $this->display('event/upd.tpl');
    }

    public function updh(){ 

        //接收数据
        $request = REQUEST()->all();

        //检查数据
        $this->_extra['form-elems'] = [
            'id' => ['ch'=>'ID', 'rule'=>'required'],
            'title' => ['ch'=>'标题', 'rule'=>'required']
        ];
        // $this->_extra['form-elems']['id'] = ['ch'=>'菜品ID', 'rule'=>'required'];
        //check($request,  $this->_extra['form-elems'])

        //取出修改了的数据
        #查询已有数据
        $row = M()->table('event')->select('*')->where(['id', $request['id']])->find();
        $request['begin_time'] = empty($request['begin_time']) ? 0 : strtotime($request['begin_time'].' 0:0:0');
        $request['end_time'] = empty($request['end_time']) ? 0 : strtotime($request['end_time'].' 23:59:59');
        $update_data = F()->compare($request, $row, ['title', 'descr', 'begin_time', 'end_time']);

        if( empty($update_data) ){
            JSON()->stat(300)->msg('您还没有修改任何数据！请先修改数据。')->exec();
        }

        $re = M()->table('event')
        ->update($update_data)
        ->where(['id', '=', $request['id']])
        ->exec();

        if( $re ){
            JSON()->navtab($this->_navTab.'_index')->msg('操作成功！')->exec();
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
        $re = M()->table('event')->fields('is_del')->update([1])->where(['id', '=', $request['id']])->exec();

        if( $re ){
            JSON()->navtab($this->_navTab.'_index')->msg('删除成功！')->exec();
        }else{
            JSON()->stat(300)->msg('操作失败')->exec();
        }
    }




    /**
     * @method  _condition_string
     * 方法作用: 将符合要求的指定字段，处理为字符串类型的where条件
     * 
     * @param    $request       array    [表单传值的集合]
     * @param    $form_elems    array    [指定的条件字段及其规则，如：]
                $form_elems = [
                    ['acc',         'like'],
                    ['nickname',    'like']
                ];
     * @param    $con_arr       array    [默认的条件字段，如：$con_arr=['is_del', 0];]
     * 
     * @return    string    [字符串类型的条件语句]
     */
    protected function _condition_string($request, $form_elems, $con_arr){

        $con_search = $this->_condition($request, $form_elems);
        $con_default = $this->_condition($con_arr, [], 2);
        $con_arr = array_merge($con_default, $con_search);//将非查询的数据与查询的数据进行合并，形成完整的条件数组数据
        
        $con = [];
        /*
        $con_arr = [
            'name' => '="zhangsan"',
            'post_date' => [
                ['>=1234567'],
                ['<=7654321']
            ]
        ]
        */
        foreach( $con_arr as $field=>$val){
        
            if( is_array($val) ){
                $con[] = $field . $val[0];
                $con[] = $field . $val[1];
            }else{
                $con[] = $field . $val;
            }
        }

        $con = implode(' and ', $con);

        return $con;
    }
    /**
     * 方法名:_condition
     * 方法作用:处理条件初稿，得到可使用的条件数组集合
     * 参数：
     * $request
     * $form_elems
     * $type    处理方式，1=处理带限制规则的条件，当$type为1时，只需要传递第一个参数；2=处理不带限制规则的条件
     * return: array
     */
    protected function _condition($request, $form_elems=[], $type=1){
    
        $con = [];
        if( $type==1 ){

            foreach( $form_elems as $elem){

                if($elem[1]==='time-in'){
                    $has_begin = isset($request['b_'.$elem[0]])&&$request['b_'.$elem[0]]!=='';
                    $has_end = isset($request['e_'.$elem[0]])&&$request['e_'.$elem[0]]!=='';
                    if(!$has_begin&&!$has_end) continue;
                }else{
                    if(!isset($request[$elem[0]])||$request[$elem[0]]==='') continue;
                }
                
                if( isset($elem[1]) ){//y有特殊处理标记

                    if( $elem[1]==='mul' ){//数组
                        
                        $str_arr = [];
                        //        [1, 3, 4]
                        foreach( $request[$elem[0]] as $val){

                            $str_arr[] = $val;
                        }
                        //                             1|3|4
                        $con[$elem[0]] = ' REGEXP "' . implode('|', $str_arr) . '"';
                    }elseif( $elem[1]==='like' ){//模糊匹配

                        $con[$elem[0]] = ' like "%' . $request[$elem[0]] . '%"';
                    }elseif ( $elem[1]==='equal' ) {
                        
                        $con[$elem[0]] = '="' . $request[$elem[0]] . '"';
                    }elseif ( $elem[1]==='time-in' ) {
                        
                        $con[$elem[0]][0] = '>=' . strtotime($request['b_'.$elem[0]]);
                        $con[$elem[0]][1] = '<=' . strtotime($request['e_'.$elem[0]]);
                    }
                
                }else{//普通

                    //     'name'                     'name'
                    $con[$elem[0]] = '="' . $request[$elem[0]] . '"';
                }
            }
        }elseif ($type==2) {
            
            if( is_array($request[0]) ){
                    
                foreach( $request as $k=>$v){

                    if( count($v)==3 ){
                        $con[$v[0]] = $v[1] . '"' . $v[2] . '"';
                    }elseif( strpos($v[1], '=')!==false ){

                        // $con[$k][$v[0]] = $v[1];
                        $con[$v[0]] = $v[1];
                    }else{
                        // $con[$k][$v[0]] = '="' . $v[1] . '"';
                        $con[$v[0]] = '="' . $v[1] . '"';
                    }
                }
            }else{
                
                if( count($request)==3 ){

                    $con[$request[0]] = $request[1] . '"' . $request[2] . '"';
                }elseif( strpos($request[1], '=')!==false ){

                    $con[$request[0]] = $request[1];
                }else{
                    $con[$request[0]] = '="' . $request[1] . '"';
                }
            }
        }
        
        return $con;
    }

    protected function _get_ori_search_datas($request, $form_elems){
    
        $fields = [];
        foreach( $form_elems as $elem){
        
            if( isset($elem[1])&&$elem[1]==='time-in' ){

                $fields[] = 'b_'.$elem[0];
                $fields[] = 'e_'.$elem[0];
            }elseif( isset($elem[0]) ){

                $fields[] = $elem[0];
            }else{
                $fields[] = $elem;
            }
        }

        $ori_search_datas = [];
        foreach( $fields as $field){
            
            if( isset($request[$field]) ){

                $ori_search_datas[$field] = $request[$field];
            }
        }

        return $ori_search_datas;
    }

    
}      
