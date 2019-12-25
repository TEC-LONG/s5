<?php
namespace tools\controller;
use \core\controller;

class TBRecordController extends Controller {

    private $_datas=[];
    private $_model;

    public function __construct(){
    
        parent::__construct();

        $this->_datas['belong_db'] = ['exp'];
        $this->_datas['navTab'] = 'TBRecord';
        $this->_datas['url'] = [
            'index' => L(PLAT, MOD, 'index'),
            'ad' => L(PLAT, MOD, 'ad'),
            'adh' => L(PLAT, MOD, 'adh'),
            'edit' => L(PLAT, MOD, 'edit'),
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
        }
    }

    private function _tbhtml($mustShow, $rows){

        $tbhtml = '';
        foreach ($rows as $rows_k => $row):
            
            foreach( $mustShow as $k=>$v ){
                        
                switch ($k) {
                    case 'belong_db':
                        #                  $this->_datas['belong_db'][0]
                        $tbhtml .= "<td>".$this->_datas['belong_db'][$row[$k]]."</td>";
                    break;
                    case 'has_special_field':
                        $tbhtml .= "<td>".$this->_datas['has_special_field'][$row[$k]]."</td>";
                    break;
                    case 'has_relate_field':
                        $tbhtml .= "<td>".$this->_datas['has_relate_field'][$row[$k]]."</td>";
                    break;
                    case 'post_date':
                        $tbhtml .= "<td>".date('Y-m-d H:i:s', $row[$k])."</td>";
                    break;
                    default:
                        $tbhtml .= "<td>".$row[$k]."</td>";
                    break;
                }
            }
        endforeach;

        return $tbhtml;
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
        $this->_datas['pagination']['numsPerPage'] = isset($request['numPerPage']) ? $request['numPerPage'] : $this->_datas['pagination']['numsPerPage'];
		$show_nums_from = ($now_page-1) * $this->_datas['pagination']['numsPerPage'];

        $this->_datas['pagination']['total_rows'] = $total_rows = M()->GN('tb_record');
		$this->_datas['pagination']['total_num_pagination'] = (int)round(ceil($total_rows/$this->_datas['pagination']['numsPerPage']));
        $limit = $show_nums_from . ',' . $this->_datas['pagination']['numsPerPage'];

        
        $sql = 'select id, post_date, belong_db, ch_name, en_name, has_special_field, has_relate_field from tb_record where 1 order by post_date desc limit ' . $limit;
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
        $has_relate_field = 0;

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
            'post_date' => time()
        ];

        #执行新增
        if( !$tb_record__id = M()->setData('tb_record', $data) ){//不成功，则就此中断
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
        exit;
    }
}      
