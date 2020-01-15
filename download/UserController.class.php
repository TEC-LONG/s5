<?php
namespace {{$plat}}\controller;
use \core\controller;

class {{$controller_name}}Controller extends Controller {

    ##标准预定义属性
    protected $_datas = [];
    private $_init=[];
    private $_extra=[];
    
    private $_m;
    private $_navTab;

    
        public function __construct(){

            parent::__construct();
    
            
            $this->_navTab = 'User';
        
    
            
                $this->_init['level'] = '0:普通用户|1:管理员';
                
                $this->_init['status'] = '0:正常|1:禁用';
                
                $this->_init['ori'] = '0:注册|1:后台添加';
                
            $this->JD($this->_init);
            
            
            
                if(ACT=='index'){
                    
                    $this->_datas['url'] = [
                        'index' => ['url'=>L(PLAT, MOD, 'index'), 'rel'=>'User_index'],
'ad' => ['url'=>L(PLAT, MOD, 'ad'), 'rel'=>'User_ad'],
'upd' => ['url'=>L(PLAT, MOD, 'upd'), 'rel'=>'User_upd'],
'del' => ['url'=>L(PLAT, MOD, 'del'), 'rel'=>'User_del']
                    ];
                
                    
                    Array['mustShow'] = [
                        'acc'=>['ch'=>'账号', 'width'=>70],
'post_date'=>['ch'=>'post_date', 'width'=>70],
'id'=>['ch'=>'id', 'width'=>70],
'nickname'=>['ch'=>'用户昵称', 'width'=>70],
'cell'=>['ch'=>'手机号', 'width'=>70]
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
                ['acc', 'like'],
['nickname', 'like']
            ];
            
            //将条件数组数据转换为条件字符串
            $con = $this->_condition_string($request, $form_elems, $con_arr);
    
            //将搜索的原始数据扔进模板
            $this->_datas['search'] = $this->_get_ori_search_datas($request, $form_elems);
    
            //分页参数
            $this->_datas['page'] = $page = $this->_page('user', $con, 3);
    
            //查询数据
            $rows = M()->table('user')
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
            $this->display('User/index.tpl');
        }
        

    {{$ad}}

    {{$adh}}

    {{$upd}}

    {{$updh}}

    {{$del}}
}      
