<?php
namespace tools\controller;
use \core\controller;

class TestuserController extends Controller {

    ##标准预定义属性
    protected $_datas = [];
    private $_init=[];
    private $_extra=[];
    
    private $_m;
    private $_navTab;

    
        public function __construct(){

            parent::__construct();
    
            
            $this->_navTab = 'Testuser';
        
    
            
                $this->_init['user_type'] = '0:普通用户|1:普通管理员|2:超级管理员';
                
            $this->JD($this->_init);
            
            
            
                if(ACT=='index'){
                    
                    $this->_datas['url'] = [
                        'index' => ['url'=>L(PLAT, MOD, 'index'), 'rel'=>'Testuser_index'],
'ad' => ['url'=>L(PLAT, MOD, 'ad'), 'rel'=>'Testuser_ad'],
'upd' => ['url'=>L(PLAT, MOD, 'upd'), 'rel'=>'Testuser_upd'],
'del' => ['url'=>L(PLAT, MOD, 'del'), 'rel'=>'Testuser_del']
                    ];
                
                    
                    $this->_datas['mustShow'] = [
                        'name'=>['ch'=>'姓名', 'width'=>70],
'age'=>['ch'=>'年龄', 'width'=>70],
'cell'=>['ch'=>'手机号', 'width'=>70],
'phone'=>['ch'=>'座机号', 'width'=>70],
'email'=>['ch'=>'邮箱', 'width'=>70],
'user_type'=>['ch'=>'用户类型', 'width'=>70],
'headimg'=>['ch'=>'头像(25*25)', 'width'=>70]
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
                ['name', 'like'],
['age', 'like'],
['user_type', 'like']
            ];
            
            //将条件数组数据转换为条件字符串
            $con = $this->_condition_string($request, $form_elems, $con_arr);
    
            //将搜索的原始数据扔进模板
            $this->_datas['search'] = $this->_get_ori_search_datas($request, $form_elems);
    
            //分页参数
            $this->_datas['page'] = $page = $this->_page('testuser', $con, 3);
    
            //查询数据
            $rows = M()->table('testuser')
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
            $this->display('testuser/index.tpl');
        }
        

    

    

    

    

    
}      
