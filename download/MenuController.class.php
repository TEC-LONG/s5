<?php
namespace tools\controller;
use \core\controller;

class MenuController extends Controller {

    ##标准预定义属性
    protected $_datas = [];
    private $_init=[];
    private $_extra=[];
    
    private $_m;
    private $_navTab;

    
        public function __construct(){

            parent::__construct();
    
            
            $this->_navTab = 'Menu';
        
    
            
                $this->_init['level'] = '0:大栏目级|1:小栏目级|2:选项卡级';
                
            handler_init_special_fields($this->_init);
            
            
            
                if(ACT=='index'){
                    
                    $this->_datas['url'] = [
                        'index' => ['url'=>L(PLAT, MOD, 'index'), 'rel'=>'Menu_index'],
'ad' => ['url'=>L(PLAT, MOD, 'ad'), 'rel'=>'Menu_ad'],
'upd' => ['url'=>L(PLAT, MOD, 'upd'), 'rel'=>'Menu_upd'],
'del' => ['url'=>L(PLAT, MOD, 'del'), 'rel'=>'Menu_del']
                    ];
                
                    
                    $this->_datas['mustShow'] = [
                        'post_date'=>['ch'=>'添加数据时间', 'width'=>70],
'name'=>['ch'=>'栏目名称', 'width'=>70],
'id'=>['ch'=>'ID', 'width'=>70],
'level'=>['ch'=>'层级', 'width'=>70]
                    ];
                
                }
                
            
            
            
    
            $this->_datas['navTab'] = $this->_navTab;
        }
        

    
        public function index(){ 

            $request = $_REQUEST;
    
            //初始条件
            $con_arr = ['is_del'=>'0'];

            //查询字段
            $form_elems = [
                ['post_date', 'like'],
                ['name', 'like'],
                ['level', 'like']
            ];
            
            //将条件数组数据转换为条件字符串
            $con = $this->_condition_string($request, $form_elems, $con_arr);
    
            //将搜索的原始数据扔进模板
            $this->_datas['search'] = $this->_get_ori_search_datas($request, $form_elems);
    
            //分页参数
            $this->_datas['page'] = $page = $this->_page('menu', $con, $request);
    
            //查询数据
            $rows = M()->table('menu')
                    ->select('*')
                    ->where($con)
                    ->limit($page['limitM'] . ',' . $page['numPerPage'])
                    ->get();
    
            /*if( $rows ){
                foreach( $rows as &$row ){ 
                    if( !empty($row['expnew_ids']) ){
                        $row['expnew_titles'] = explode('|', $row['expnew_titles']);
                        $row['expnew_ids'] = explode('|', $row['expnew_ids']);
                    }
                    $row['has_descr'] = !empty($row['descr']) ? '是' : '否';
                }
            }*/
            $this->_datas['rows'] = $rows;//扔到模板中
    
            //分配模板变量&渲染模板
            $this->assign($this->_datas);
            $this->display('menu/index.tpl');
        }
        

    

    

    

    

    
}      
