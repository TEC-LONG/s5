<?php
namespace tools\controller;
use \core\controller;

class TBRecordController extends Controller {

    private $_datas=[];
    private $_extra=[];
    private $_model;
    protected $_navTab;
    private $_requ;

    public function __construct(){
    
        parent::__construct();

        $this->_navTab = 'tools_TBRecord';
        $this->_requ = M('RequestTool');

        $this->_datas['belong_db'] = ['exp', 'test', 'blog', 'store'];
        $this->_datas['navTab'] = $this->_navTab;
        $this->_datas['url'] = [
            'index' => L('/tools/tbRecord/index'),
            'ad' => L('/tools/tbRecord/ad'),
            'adh' => L('/tools/tbRecord/adh'),
            'upd' => L('/tools/tbRecord/upd'),
            'del' => L('/tools/tbRecord/del')
        ];

        switch (ACT) {
            case 'index':
                $this->_datas['mustShow'] = [
                    'id' => ['ch'=>'ID', 'width'=>80], 
                    'ch_name' => ['ch'=>'表中文名', 'width'=>100], 
                    'en_name' => ['ch'=>'表英文名', 'width'=>100], 
                    'belong_db' => ['ch'=>'所属库名称', 'width'=>100],
                    'post_date' => ['ch'=>'创建时间', 'width'=>120]
                ];

                $this->_model = M();
            break;
            case 'ad':
                
            break;
            case 'upd':
                $this->_datas['url'] = [
                    'updh' => L('/tools/tbRecord/updh')
                ];
                $this->_extra['form-elems'] = [
                    'id' => ['ch'=>'表信息ID', 'rule'=>'required']
                ];
                //arr:|  以"|"将字符串炸开成数组，不指定默认以","炸开
                $this->_extra['special_fields'] = [
                    'ch_fields' => 'arr',
                    'en_fields' => 'arr'
                ];
                //tb_special_field表值对字段数据
                $this->_datas['field_type'] = ['普通字段', '关联字段'];
            break;
        }
    }

    public function tbLookup(){
        //获得所有tb_record数据
        $ori_rows = M()->table('tb_record')->select('en_name,ch_name,belong_db,ch_fields,en_fields')->where(['is_del', 0])->get();

        $rows = [];
        foreach( $this->_datas['belong_db'] as $k=>$v){
            
            foreach( $ori_rows as $k1=>$v1){
                
                if( $k==$v1['belong_db'] ){
                    $rows[$v][$k1] = $v1;
                }
            }
        }
        $this->assign([
            'rows'=>$rows
        ]);

        $this->display('TbStruct/tbLookup.tpl');
    }

    public function kvLookup(){
        //接收数据
        $request =$this->_requ->all();

        if( isset($request['id']) ){
            //查询表下的普通特殊字段
            $tb_normal_special_fields = M()->table('tb_special_field')->select('ori_key_val, en_name')
            ->where([
                ['is_del', 0],
                ['tb_record__id', $request['id']],
                ['field_type', 0]
            ])
            ->get('index');

            if(empty($tb_normal_special_fields))
                echo json_encode([['none', 'none']]);
            else
                echo json_encode($tb_normal_special_fields);
            exit;
        }
        
        //获得当前数据库下的所有表，初始状态下就是第一个数据库下的所有表
        if(isset($request['belong_db'])){

            $belong_db = $request['belong_db'];
        }else{
            $belong_db_keys = array_keys($this->_datas['belong_db']);
            $belong_db = $belong_db_keys[0];
        }

        $this->_datas['first_database_tbs'] = M()->table('tb_record')->select('id, en_name')
        ->where([
            ['is_del', '0'],
            ['belong_db', $belong_db]
        ])
        ->get('index');

        if( isset($request['belong_db']) ){
            
            echo json_encode($this->_datas['first_database_tbs']);
            exit;
        }
        
        //查询第一个数据表下的所有普通特殊字段
        $this->_datas['first_tb_normal_special_fields'] = [];
        if( !empty($this->_datas['first_database_tbs']) ){
        
            $this->_datas['first_tb_normal_special_fields'] = M()->table('tb_special_field')->select('en_name, ori_key_val')
            ->where([
                ['is_del', 0],
                ['tb_record__id', $this->_datas['first_database_tbs'][0][0]],
                ['field_type', 0]
            ])
            ->get();
        }

        $this->_datas['url']['combox_tb'] = L(PLAT, MOD, 'kvLookup');

        $this->assign($this->_datas);
        $this->display('TbStruct/kvLookup.tpl');
    }

    public function del(){
        //接收数据
        $request = REQUEST()->all();

        //检查数据
        // $this->_extra['form-elems']['id'] = ['ch'=>'菜品ID', 'rule'=>'required'];
        //check($request,  $this->_extra['form-elems'])

        //tb_record构建删除条件
        $con = ['id'=>$request['id']];

        //将需要删除的数据 is_del字段设置为1
        if( M()->table('tb_record')->where(['id', $request['id']])->delete() ){
            JSON()->navtab($this->_navTab.'_index')->exec();
        }else{
            JSON()->stat(300)->msg('操作失败！')->exec();
        }
    }

    public function upd(){

        //接收数据
        $request = REQUEST()->all('n');

        //查询数据 tb_record
        $this->_datas['row'] = M()->table('tb_record')->select('*')->where(['id', $request['id']])->find();

        //分配模板变量&渲染模板
        $this->assign($this->_datas);
        $this->display('TbStruct/upd.tpl');
    }

    protected function _get_update_data($request, $may_update_fields=[], $type=1){

        $re_datas = [];
        if( $type==1 ){//$request[$field] = 'xx';

            //    $may_update_fields=['belong_db', 'ch_name', 'en_name', 'comm']
            foreach( $may_update_fields as $elem_name=>$field){
            
                if(!isset($request[$field])) $field=$elem_name;

                if( $request[$field]!==$request['old_'.$field] ){//新的不等于老的
                    $re_datas[$field] = $request[$field];
                }
            }
        }elseif ($type==2) {//$request[$field] = [0=>[...], 1=>[...],...]  只取需要更新的数据

            foreach( $request['ids'] as $ids_k=>$id){

                if($id==0) continue;//没有id，说明本条数据不是要更新的，而是要新增的
                if($request['field_ch_name'][$ids_k]==='') continue;//没有中文字段名，则表示该数据是要被删除的数据

                //$may_update_fields = ['field_ch_name'=>'ch_name', 'field_en_name'=>'en_name', 'type_sql', 'field_type', 'key_val', 'specification']
                foreach( $may_update_fields as $elem_name=>$field ){
                
                    $save_field = $field;
                    //        $request['ch_name']    $field='field_ch_name'
                    if(isset($request[$elem_name])) $field = $elem_name;

                    if( $request[$field][$ids_k]!==$request['old_'.$field][$ids_k] ){//新的不等于老的

                        $re_datas[$ids_k][$save_field] = $request[$field][$ids_k];
                        $re_datas[$ids_k]['condition'] = ['id'=>$id];//重复操作也没关系
                    }
                }
            }
        }elseif ($type==3) {//只取需要新增的数据

            foreach( $request['field_ch_name'] as $k=>$ch_name){

                if($request['ids'][$k]!=0||$ch_name==='') continue;//有id，说明本条数据不是要新增的

                //$may_update_fields = ['field_ch_name'=>'ch_name', 'field_en_name'=>'en_name', 'type_sql', 'field_type', 'key_val', 'specification']
                foreach( $may_update_fields as $elem_name=>$field ){
                
                    $save_field = $field;
                    //        $request['ch_name']    $field='field_ch_name'
                    if(isset($request[$elem_name])) $field = $elem_name;

                    $re_datas[$k][$save_field] = $request[$field][$k];
                }
            }
        }elseif ($type==4) {//只取需要被删除数据的id
            foreach( $request['ids'] as $ids_k=>$id){

                if($id==0) continue;//没有id，说明本条数据不是要更新的，而是要新增的
                if($request['field_ch_name'][$ids_k]!=='') continue;//没有中文字段名，则表示该数据是要被删除的数据

                $re_datas[] = $id;
            }
        }

        return $re_datas;
    }

    public function updh(){
        //接收数据
        $request = REQUEST()->all('l');

        //检查数据
        // $this->_extra['form-elems']['id'] = ['ch'=>'表信息ID', 'rule'=>'required'];
        //check($request,  $this->_extra['form-elems'])

        //tb_record
        #获取原数据
        $ori_row = M()->table('tb_record')->select('ori_struct, create_sql, special_field, comm, belong_db')->where(['id', $request['id']])->find();

        $upd_data = [];
        foreach ($ori_row as $k => $v) {
            
            if( $v!=$request[$k] ){
                $upd_data[$k] = $request[$k];
            }
        }

        if( isset($upd_data['ori_struct']) ){
            //处理原始表结构
            $arr_struct = explode("\r\n", $upd_data['ori_struct']);	//表结构第一次拆分形成的数组  array(表中文名, 表英文名, 表字段中文名, 表字段英文名);
            $arr_struct = array_map(function($ele){
                return trim($ele);
            }, $arr_struct);

            $upd_data['ch_name'] = $arr_struct[0];
            $upd_data['en_name'] = $arr_struct[1];
            $upd_data['ch_fields'] = $arr_struct[2];
            $upd_data['en_fields'] = $arr_struct[3];
        }

        if(empty($upd_data)) JSON()->stat(300)->msg('没有修改任何数据！')->exec();

        #执行更新
        if( M()->table('tb_record')->update($upd_data)->where(['id', $request['id']])->exec() ){
            JSON()->navtab($this->_navTab.'_upd')->exec();
        }else{
            JSON()->stat(300)->msg('操作失败！')->exec();
        }
    }

    private function _pageHtml($pagination){

        $pagehtml = '';
        foreach( $pagination['defaultShowPageRows'] as $v ){ 
			
            $pagehtml .= '<option value="'.$v.'" ';

            if ( $pagination['numsPerPage']==$v ) $pagehtml .= 'selected="selected"';

            $pagehtml .= ">".$v."</option>";
        }
        return $pagehtml;
    }
    public function index(){ 

        $request = REQUEST()->all();

        //查询条件(融合搜索条件)
        $con_arr = ['is_del', 0];

        #需要搜索的字段
        $form_elems = [
            ['ch_name', 'like'],
            ['en_name', 'like'],
            ['en_fields', 'like'],
            ['belong_db', 'equal']
        ];

        $con = $this->_condition_string($request, $form_elems, $con_arr);//将条件数组数据转换为条件字符串

        //将搜索的原始数据扔进模板
        $this->_datas['search'] = $this->_get_ori_search_datas($request, $form_elems);

        //分页参数
        $this->_datas['page'] = $page = $this->_page('tb_record', $con, $request);

        $this->_datas['rows'] = M()->table('tb_record')->select('id, post_date, belong_db, ch_name, en_name')
        ->where($con)->orderby('post_date desc')->limit($page['limitM'].','.$page['numPerPage'])->get();

        $this->assign($this->_datas);
        $this->display('TbStruct/list.tpl');
    }

    public function ad(){

        $request = $_POST;

        $this->assign($this->_datas);
        $this->display('TbStruct/ad.tpl');
    }

    public function adh(){
    
        //接收参数
        $request = REQUEST()->all('l');

        //处理原始表结构
        $arr_struct = explode("\r\n", $request['ori_struct']);	//表结构第一次拆分形成的数组  array(表中文名, 表英文名, 表字段中文名, 表字段英文名);
        foreach ($arr_struct as  &$struct) {
            $struct = trim($struct);
        }

        //tb_record
        $data = [
            'ch_name' => $arr_struct[0],
            'en_name' => $arr_struct[1],
            'ch_fields' => $arr_struct[2],
            'en_fields' => $arr_struct[3],
            'ori_struct' => $request['ori_struct'],
            'create_sql' => $request['create_sql'],
            'special_field' => $request['special_field'],
            'comm' => $request['comm'],
            'belong_db' => $request['belong_db'],
            'post_date' => time()
        ];

        #执行新增
        if( M()->setData('tb_record', $data) ){//不成功，则就此中断
            JSON()->navtab($this->_navTab.'_add')->exec();
        }else{
            JSON()->stat(300)->msg('操作失败！')->exec();
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

    /**
     * @method  _page
     * 方法作用: 构建分页参数
     * 
     * @param    $tb            string      [需要统计总的记录条数的表其表名]
     * @param    $condition     string      [统计总记录条数的条件，直接传递给模型，故条件的格式与模型where方法所需的条件格式保持统一]
     * @param    $request       array       [表单传值的集合，包含了分页所需的表单参数]
     * @param    $num_per_page  int         [每页显示的数据条数，默认为31条]
     * 
     * @return  array           [包含分页各项数据的数组]
     */
    protected function _page($tb, $condition, $request, $num_per_page=31){
        #分页参数
        $page = [];
        $page['numPerPageList'] = [20, 30, 40, 60, 80, 100, 120, 160, 200];
        $page['pageNum'] = $pageNum = isset($request['pageNum']) ? intval($request['pageNum']) : (isset($_COOKIE[$this->navtab.'pageNum']) ? intval($_COOKIE[$this->navtab.'pageNum']) : 1);
        setcookie($this->navtab.'pageNum', $pageNum);
        $page['numPerPage'] = $numPerPage = isset($request['numPerPage']) ? intval($request['numPerPage']) : $num_per_page;
        $tmp_arr_totalNum = M()->table($tb)->select('count(*) as num')->where($condition)->find();
        $page['totalNum'] = $totalNum = $tmp_arr_totalNum['num'];
        $page['totalPageNum'] = intval(ceil(($totalNum/$numPerPage)));
        $page['limitM'] = ($pageNum-1)*$numPerPage;

        return $page;
    } 
}      
