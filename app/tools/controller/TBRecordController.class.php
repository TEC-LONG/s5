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

        $this->_navTab = 'tools_TBRecord';
        $this->_requ = M('RequestTool');

        $this->_datas['belong_db'] = ['exp', 'test', 'blog', 'store'];
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

        //检查数据
        //check($request,  $this->_extra['form-elems'])

        //查询数据 tb_record
        $this->_datas['row'] = M()->table('tb_record')->select('*')->where(['id', $request['id']])->find();

        // //查询关联数据tb_special_field
        // $sql = 'select id, ch_name as field_ch_name, en_name as field_en_name, ori_key_val, specification, field_type from tb_special_field where is_del=0 and tb_record__id='.$row['id'];
        // $this->_datas['tb_special_field_rows'] = M()->getRows($sql);

        // //特殊字段处理
        // $this->_datas['row'] = $this->_special_fields($this->_extra['special_fields'], $row);

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
        if( M()->table('tb_record')->fields(array_keys($upd_data))->update($upd_data)->where(['id', $request['id']])->exec() ){
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
}      
