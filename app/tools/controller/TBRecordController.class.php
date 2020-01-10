<?php
namespace tools\controller;
use \core\controller;

class TBRecordController extends Controller {

    private $_datas=[];
    private $_extra=[];
    private $_model;
    private $_navTab;
    private $_requ;

    public function __construct(){
    
        parent::__construct();

        $this->_navTab = 'TBRecord';
        $this->_requ = M('RequestTool');

        $this->_datas['belong_db'] = ['exp', 'test'];
        $this->_datas['navTab'] = $this->_navTab;
        $this->_datas['url'] = [
            'index' => L(PLAT, MOD, 'index'),
            'robot' => L(PLAT, MOD, 'robot'),
            'ad' => L(PLAT, MOD, 'ad'),
            'adh' => L(PLAT, MOD, 'adh'),
            'upd' => L(PLAT, MOD, 'upd'),
            'del' => L(PLAT, MOD, 'del')
        ];

        switch (ACT) {
            case 'index':
                $this->_datas['has_special_field'] = [0=>'否', '是'];
                $this->_datas['has_relate_field'] = [0=>'否', '是'];

                $this->_datas['pagination'] = [
                    'numsPerPage'=>40,
                    'now_page'=>1,
                    'defaultShowPageRows'=>[20, 40, 70]
                ];

                $this->_datas['mustShow'] = [
                    'id' => ['ch'=>'ID', 'width'=>80], 
                    'ch_name' => ['ch'=>'表中文名', 'width'=>100], 
                    'en_name' => ['ch'=>'表英文名', 'width'=>100], 
                    'has_special_field' => ['ch'=>'是否有特殊字段', 'width'=>50], 
                    'has_relate_field' => ['ch'=>'是否有关联字段', 'width'=>50], 
                    'belong_db' => ['ch'=>'所属库名称', 'width'=>100],
                    'post_date' => ['ch'=>'创建时间', 'width'=>120]
                ];

                $this->_model = M();
            break;
            case 'ad':
                
            break;
            case 'upd':
                $this->_datas['url'] = [
                    'updh' => L(PLAT, MOD, 'updh')
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
            // case 'robot':
            // case 'enum':
            //     $this->_datas['major_acts'] = ['列表页', '添加页', '编辑页', '模型'];
            //     $this->_datas['list_url_acts'] = ['index', 'ad', 'upd', 'del'];
            //     $this->_datas['list_search_rule'] = ['like', 'mul'];
            // break;
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

    // public function robot(){
    //     //接收数据
    //     $request = $_REQUEST;

    //     //检查数据
    //     // var_dump($request);
    //     // exit;
    //     // var_dump(111);
    //     // exit;
        
    //     $this->assign($this->_datas);
    //     $this->display('TbStruct/robot.tpl');

    // }

    // public function enum(){
    
    //     //接收数据
    //     $request = $_REQUEST;

    //     if( $request['type']==1 ){
        
    //         $enumHtml = '<select class="combox" name="${param.inputName}">
    //                         <option value="0">否</option>
    //                         <option value="1">是</option>
    //                     </select>';
    //     }elseif( $request['type']==2 ) {
            
    //         $enumHtml = '<select class="combox" name="${param.inputName}">';

    //         foreach( $this->_datas['list_search_rule'] as $k=>$v){
                
    //             $enumHtml .= '<option value="'.$k.'">'.$v.'</option>';
    //         }
    //         $enumHtml .= '</select>';
                            
    //     }

    //     echo $enumHtml;
    // }

    public function del(){
        //接收数据
        $request = $_REQUEST;

        //检查数据
        // $this->_extra['form-elems']['id'] = ['ch'=>'菜品ID', 'rule'=>'required'];
        //check($request,  $this->_extra['form-elems'])

        //tb_special_field删除条件
        $con = ['tb_record__id'=>$request['id']];
        if( !M()->setData('tb_special_field', ['is_del'=>1], 2, $con) ){
            $re = AJAXre(1);
            echo json_encode($re);
            exit;
        }

        //tb_record构建删除条件
        $con = ['id'=>$request['id']];

        //将需要删除的数据 is_del字段设置为1
        if( M()->setData('tb_record', ['is_del'=>1], 2, $con) ){
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

    public function upd(){

        //接收数据
        $request = $_REQUEST;

        //检查数据
        //check($request,  $this->_extra['form-elems'])

        //查询数据 tb_record
        $sql = 'select * from tb_record where id=' . $request['id'];
        if(!$row = M()->getRow($sql)) exit('查不到数据！');

        //查询关联数据tb_special_field
        $sql = 'select id, ch_name as field_ch_name, en_name as field_en_name, ori_key_val, specification, field_type from tb_special_field where is_del=0 and tb_record__id='.$row['id'];
        $this->_datas['tb_special_field_rows'] = M()->getRows($sql);

        //特殊字段处理
        $this->_datas['row'] = $this->_special_fields($this->_extra['special_fields'], $row);

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
        $request = $_REQUEST;
        $has_update_data = 0;

        //检查数据
        // $this->_extra['form-elems']['id'] = ['ch'=>'表信息ID', 'rule'=>'required'];
        //check($request,  $this->_extra['form-elems'])

        // echo '<pre>';
        // var_dump($request);
        // echo '<pre>';
        // exit;
        
        //tb_record
        #获取被更新的数据
        $may_update_fields = ['belong_db', 'ch_name', 'en_name', 'comm', 'create_sql', 'ori_struct'];
        $tb_record_update = $this->_get_update_data($request, $may_update_fields);

        if( isset($tb_record_update['ori_struct']) ){
            //处理原始表结构
            $arr_struct = explode("\r\n", $request['ori_struct']);	//表结构第一次拆分形成的数组  array(表中文名, 表英文名, 表字段中文名, 表字段英文名);
            $arr_struct = array_map(function($ele){
                return trim($ele);
            }, $arr_struct);

            $tb_record_update['ch_fields'] = $arr_struct[2];
            $tb_record_update['en_fields'] = $arr_struct[3];
        }

        if( !empty($tb_record_update) )  $has_update_data=1;

        #执行更新
        if( !empty($tb_record_update)&&!M()->table('tb_record')->fields(array_keys($tb_record_update))->update($tb_record_update)->where(['id', $request['id']])->exec() ){
            $re = AJAXre(1);
            $re->message = 'tb_record更新失败，导致操作失败！';
            echo json_encode($re); 
            exit;
        }

        //tb_special_field
        #获取被更新的数据
        $may_update_fields = ['field_ch_name'=>'ch_name', 'field_en_name'=>'en_name', 'field_type', 'ori_key_val', 'specification'];
        $tb_special_field_update = $this->_get_update_data($request, $may_update_fields, 2);
        if( !empty($tb_special_field_update) )  $has_update_data=1;

        /*
        Array
        (
            [0] => Array
                (
                    [type_sql] => eeee
                    [condition] => Array
                        (
                            [id] => 1
                        )
                )
        )
        */

        foreach( $tb_special_field_update as $t_s_f_u_val){
        
            $condition = $t_s_f_u_val['condition'];//更新条件
            $update = $t_s_f_u_val;//更新数据
            
            unset($update['condition']);

            if( !M()->setData('tb_special_field', $update, 2, $condition) ){//任何一条失败，则中断
                $re = AJAXre(1);
                $re->message = 'tb_special_field中的数据更新失败，导致操作失败！';
                echo json_encode($re); 
                exit;
            }
        }

        #获取要新增的数据
        $may_add_fields = ['field_ch_name'=>'ch_name', 'field_en_name'=>'en_name', 'field_type', 'ori_key_val', 'specification'];
        $tb_special_field_add = $this->_get_update_data($request, $may_add_fields, 3);
        if( !empty($tb_special_field_add) )  $has_update_data=1;

        $values = [];
        $sql = 'insert into tb_special_field ';
        /*
array(2) {
  [3]=>
  array(6) {
    ["ch_name"]=>
    string(2) "aa"
    ["en_name"]=>
    string(2) "aa"
    ["type_sql"]=>
    string(2) "aa"
    ["field_type"]=>
    string(1) "0"
    ["key_val"]=>
    string(0) ""
    ["specification"]=>
    string(0) ""
  }
  [4]=>
  array(6) {
    ["ch_name"]=>
    string(2) "bb"
    ["en_name"]=>
    string(0) ""
    ["type_sql"]=>
    string(2) "bb"
    ["field_type"]=>
    string(1) "0"
    ["key_val"]=>
    string(0) ""
    ["specification"]=>
    string(0) ""
  }
}
        */
        foreach( $tb_special_field_add as $t_s_f_a_val){
        
            $t_s_f_a_val['tb_record__id'] = $request['id'];//加上tb_record__id

            if(empty($add_fields)){
                $add_fields = array_keys($t_s_f_a_val);
                $sql .= '(' . implode(',', $add_fields) . ') values ';
            }
            
            $tmp = array_values($t_s_f_a_val);
            $tmp = array_map(function ($elem){
                return '"' . str_replace('"', '\'', $elem) . '"';
            }, $tmp);
            $values[] = '(' . implode(',', $tmp) . ')';
        }

        $sql .= implode(',', $values);
        
        // var_dump($tb_special_field_add);
        // exit;

        if( !empty($tb_special_field_add)&&!M()->setData1($sql) ){//不成功，则就此中断
            $re = AJAXre(1);
            $re->message = 'tb_special_field的数据新增失败，导致操作失败！';
            echo json_encode($re); 
            exit;
        }

        #获取要删除的数据
        $tb_special_field_del = $this->_get_update_data($request, [], 4);
        if( !empty($tb_special_field_del) )  $has_update_data=1;
        if( !empty($tb_special_field_del) )  $sql='delete from tb_special_field where id in ('.implode(',', $tb_special_field_del).')';

        if( !empty($tb_special_field_del)&&!M()->setData1($sql) ){//不成功，则就此中断
            $re = AJAXre(1);
            $re->message = 'tb_special_field的数据删除失败，导致操作失败！';
            echo json_encode($re); 
            exit;
        }

        //调整tb_record状态字段has_special_field,has_relate_field
        
        if( $has_update_data ){
            
            #查询本条数据
            $sql = 'select has_special_field,has_relate_field from tb_record where id='.$request['id'];
            $tb_record_row = M()->getRow($sql);

            #是否有特殊字段
            $special_field_num_arr = M()->GN('tb_special_field', ['tb_record__id'=>$request['id']]);
            if($special_field_num_arr['num']>0&&$tb_record_row['has_special_field']==0){//tb_special_field存在特殊字段且tb_record状态字段has_special_field值又为0，则改变has_special_field字段的值为1

                M()->setData('tb_record', ['has_special_field'=>1], 2, ['id'=>$request['id']]);//不成功要记录日志
            }

            #是否有关联字段
            if($special_field_num_arr['num']>0){//存在特殊字段才可能存在关联字段

                $sql = 'select en_name from tb_special_field where tb_record__id='.$request['id'];
                $tb_special_field_rows = M()->getRows($sql);

                foreach( $tb_special_field_rows as $val){
                
                    if( strpos($val['en_name'], '__') ){
                        M()->setData('tb_record', ['has_relate_field'=>1], 2, ['id'=>$request['id']]);//不成功要记录日志
                        break;
                    }
                }
            }
        }

        //返回结果
        if( $has_update_data ){
            $re = AJAXre();
            $re->navTabId = $this->_navTab.'_upd'.$request['id'];
        }else{
            $re = AJAXre(1);
            $re->msg = '没有任何数据被修改，请先修改数据，再提交！';
        }

        echo json_encode($re); 
        exit;
        

        /*
UPDATE categories SET
    display_order = CASE id
        WHEN 1 THEN 3
        WHEN 2 THEN 4
        WHEN 3 THEN 5
    END,
    title = CASE id
        WHEN 1 THEN 'New Title 1'
        WHEN 2 THEN 'New Title 2'
        WHEN 3 THEN 'New Title 3'
    END
WHERE id IN (1,2,3)
        */

        // print_r($tb_special_field_update);
        // echo "\n";
        
        // exit;

        /*$update_datas = [];
        foreach( $tb_special_field_update as $t_s_f_u_key=>$t_s_f_u_val){
        
            foreach( $t_s_f_u_val as $field=>$val){
            
                if( $field=='condition' )   continue;
                
                $update_datas[$field][$t_s_f_u_key]['val'] = $val;
                $update_datas[$field][$t_s_f_u_key]['id'] = $t_s_f_u_val['condition']['id'];
            }
        }

        // print_r($update_datas);
        // exit;

        $sql = "UPDATE tb_special_field SET\n";
        $tmp = [];
        $ids = [];
        $counter = 0;
        foreach ($update_datas as $field => $vals) {
            
            $tmp[$counter] = $field . " = CASE id\n";
            foreach( $vals as $val){
            
                $tmp[$counter] .= "WHEN " . $val['id'] . " THEN '" . $val['val'] . "'\n";
                if(!in_array($val['id'], $ids)) $ids[]=$val['id'];
            }
            $tmp[$counter] .= "END";
            $counter++;
        }

        $sql .= implode(",\n", $tmp) . ' WHERE id IN (' . implode(',', $ids) . ')';

        var_dump($sql);
        exit;
        
        #更新tb_special_field
        if( !M()->setData1($sql) ){
            $re = AJAXre(1);
            echo json_encode($re); 
            exit;
        }

        var_dump('aaa');
        exit;*/
        
        

        



        //执行更新
        // if( M()->setData('chifan', $datas, 2, ['id'=>$request['id']]) ){
        //     $re = AJAXre();
        //     $re->navTabId = $this->_navTab.'_upd';
        //     $re->message = '更新菜品成功！';
        // }else{
        //     $re = AJAXre(1);
        // }
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

        $request = $_POST;

        //分页数据
		$this->_datas['pagination']['now_page'] = $now_page = isset($request['pageNum']) ? $request['pageNum'] : $this->_datas['pagination']['now_page'];
        $this->_datas['pagination']['numPerPage'] = isset($request['numPerPage']) ? $request['numPerPage'] : $this->_datas['pagination']['numsPerPage'];
		$show_nums_from = ($now_page-1) * $this->_datas['pagination']['numsPerPage'];

        $this->_datas['pagination']['total_rows'] = $total_rows = M()->GN('tb_record');
		$this->_datas['pagination']['total_num_pagination'] = (int)round(ceil($total_rows/$this->_datas['pagination']['numsPerPage']));
        $limit = $show_nums_from . ',' . $this->_datas['pagination']['numsPerPage'];

        
        $sql = 'select id, post_date, belong_db, ch_name, en_name, has_special_field, has_relate_field from tb_record where is_del=0 order by post_date desc limit ' . $limit;
        $this->_datas['rows'] = M()->getRows($sql);

        //分页html
        $this->_datas['pagehtml'] = $this->_pageHtml($this->_datas['pagination']);

        //列表内容
        // $this->_datas['tbhtml'] = $this->_tbhtml($this->_datas['mustShow'], $this->_datas['rows']);
        
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
        $request = $_REQUEST;

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
            'comm' => $request['comm'],
            'belong_db' => $request['belong_db'],
            'post_date' => time()
        ];

        //是否有关联字段
        $arr_field = explode(',', $arr_struct[3]);
        foreach ($arr_field as  $field) {

            if( strpos(trim($field), '__') ){//有关联字段

                $data['has_special_field'] = 1;
                break;
            }
        }

        #执行新增
        if( !$id=M()->setData('tb_record', $data) ){//不成功，则就此中断
            $re = AJAXre(1);
        }else{

            //是否有关联字段
            $arr_field = explode(',', $arr_struct[3]);
            $arr_field_ch_name = explode(',', $arr_struct[2]);
            $tmp_relate_fields = [];
            $tmp_counter = 0;
            foreach ($arr_field as  $k=>$field) {

                if( strpos(trim($field), '__') ){//关联字段

                    $tmp_relate_fields[$tmp_counter]['ch_name'] = $arr_field_ch_name[$k];
                    $tmp_relate_fields[$tmp_counter]['en_name'] = $field;
                    $tmp_relate_fields[$tmp_counter]['field_type'] = 1;
                    $tmp_relate_fields[$tmp_counter]['tb_record__id'] = $id;
                    $tmp_relate_fields[$tmp_counter]['post_date'] = time();

                    $tmp_arr_relate_field = explode('__', trim($field));
                    $tmp_relate_fields[$tmp_counter]['relate_tb_name'] = $tmp_arr_relate_field[0];
                    $tmp_relate_fields[$tmp_counter]['relate_field_name'] = $tmp_arr_relate_field[1];
                    
                    if(!isset($data['has_special_field'])) $data['has_special_field'] = 1;
                }
            }

            if(!empty($tmp_relate_fields)){

                $tmp_fields = implode(',', array_keys($tmp_relate_fields[0]));
                $re = M()->table('tb_special_field')
                ->fields($tmp_fields)
                ->insert($tmp_relate_fields)
                ->exec();

                if(!$re){
                    $re = AJAXre(1);
                    echo json_encode($re); 
                    exit;
                }
            }

            //成功
            $re = AJAXre();
            $re->navTabId = $this->_datas['navTab'].'_add';
            $re->message = '添加成功！';
        }

        #返回结果
        echo json_encode($re); 
        exit;

        /*if( !$tb_record__id = M()->setData('tb_record', $data) ){//不成功，则就此中断
            $re = AJAXre(1);
            echo json_encode($re); 
            exit;
        }
        
        //特殊字段 tb_special_field
        if(!empty($request['special_fields'])){
            
            $sql = 'insert into tb_special_field (tb_record__id, en_name, serialize, field_type, relate_tb_name, relate_field_name, post_date) values ';
            $arr_special_fields = explode("\r\n", $request['special_fields']);
            
            $arr_row_sql = [];
            foreach ($arr_special_fields as $field) {
                
                $arr_field = explode('=', trim($field));//['belong_pro', '{0:"exp"}']
                $arr_field[1] = json_decode(trim($arr_field[1]), true);//["0"=>"否", "1"=>"是"]
                $row_sql = "(%d, '%s', '%s', %d, '%s', '%s', %d)";

                $arr_row_sql[] = sprintf($row_sql, $tb_record__id, trim($arr_field[0]), serialize($arr_field[1]), 0, '', '', time());
            }


            $sql .= implode(',', $arr_row_sql);

            if(  !M()->setData1($sql) ){//不成功，则就此中断
                $re = AJAXre(1);
                echo json_encode($re); 
                exit;
            }
            
            //更新
            $updates = ['has_special_field'=>1];
            if( !M()->setData('tb_record', $updates, 2, ['id'=>$tb_record__id]) ){
                
                $re = AJAXre(1);
                echo json_encode($re); 
                exit;
            }
        }

        //关联字段
        $arr_relate_field = explode(',', $arr_struct[3]);
        $arr_row_sql = [];
        foreach ($arr_relate_field as  $field) {

            if( strpos(trim($field), '__') ){//关联字段
                
                $arr_relate = explode('__', trim($field));
                //需要先查询tb_special_field是否已经存在这个关联字段的信息
                $sql1 = 'select en_name, serialize from tb_special_field where en_name="' . trim($field) . '"';
                $this_relate_field = M()->getRow($sql1);

                if( empty($this_relate_field) ){//当前只是判断 如果表里没有数据才增加， 没有检查有但是数据不一样的情况，需要完善
                    $has_relate_field = 1;
                    $arr_row_sql[] = sprintf($row_sql, $tb_record__id, trim($arr_field[0]), serialize($arr_field[1]), 1, $arr_relate_field[0], $arr_relate_field[1], time());
                }
            }
        }

        //更新
        if( !empty($arr_row_sql) ){
            $updates = ['has_relate_field'=> 1];
            if( !M()->setData('tb_record', $updates, 2, ['id'=>$tb_record__id]) ){
                
                $re = AJAXre(1);
                echo json_encode($re); 
                exit;
            }
        }
        
        //成功
        $re = AJAXre();
        $re->navTabId = $this->_datas['navTab'].'_add';
        $re->message = '添加成功！';
        #返回结果
        echo json_encode($re); 
        exit;*/
    }
}      
