<?php
namespace tools\controller;
use \core\controller;
use \plugins\RequestTool;

class RobotController extends Controller {

    private $_datas=[];
    private $_navTab;
    private $_requ;

    public function __construct(){
    
        parent::__construct();

        $this->_navTab = 'Robot';
        $this->_requ = M('RequestTool');

        $this->_datas['navTab'] = $this->_navTab;
        $this->_datas['url'] = [
            'index' => L(PLAT, MOD, 'index'),
            'adh' => L(PLAT, MOD, 'adh')
        ];

        switch (ACT) {
            case 'index':
            case 'enum':
                $this->_datas['major_acts'] = ['列表页', '添加页', '编辑页', '模型'];
                $this->_datas['list_url_acts'] = ['index', 'ad', 'upd', 'del'];
                $this->_datas['list_search_rule'] = ['like', 'mul'];
            break;
        }
    }

    public function adh(){
        //接收数据
        $request =$this->_requ->all('l');
        var_dump($request);
        exit;
        

        //控制器公共初始化部分
        #文件名
        $controller_file_name = $request['controller_name'] . 'Controller.class.php';

        #控制器构造方法初始化部分
        $controller_construct = $this->controller_construct($request);
        echo $controller_construct;

        exit;
        
    }

    /**
     * method:构建控制器构造方法
     */
    protected function controller_construct($request){

        //navtab
        $navtab = '
            $this->_navTab = \''.$request['navtab'].'\';
        ';
        /*
        最终形成：
        $this->_navTab = 'chifan';
        */

        //$this->_init
        $init = '';
        foreach( $request['names'] as $k=>$name){
        
            $init .= '
            $this->_init[\''.$name.'\'] = \''.$request['key_vals'][$k].'\';
            ';
        }
        if(!empty($init)){
            $init .= '
            $this->JD($this->_init);
            ';
        }
        /*
        最终形成：
        $this->_init['field_type'] = '0:普通字段|1:关联字段';
        $this->_init['has_relate_field'] = '0:否|1:是';
        $this->JD($this->_init);
        */

        //init_index
        $init_index = '';
        if( in_array('0', $request['major_acts']) ){//0表示列表页
        
            #初始化从列表页跳转的各页面链接
            $init_index_url = [];
            foreach( $request['list_url_plat'] as $k=>$plat){

                $tmp_plat = ($plat==='PLAT') ? $plat : '\''.$plat.'\'';//不等于PLAT则需要加上引号
                $tmp_mod = ($request['list_url_mod'][$k]==='MOD') ? $request['list_url_mod'][$k] : '\''.$request['list_url_mod'][$k].'\'';//不等于MOD则需要加上引号
                $tmp_act = '\''.$request['list_url_act'][$k].'\'';

                if( !empty($request['list_url_navtab'][$k]) ){//跳转链接项若是填写了navtab则需要额外包含navtab
                    
                    if( $request['list_url_navtab'][$k]==='default' ){//default则给默认
                        $init_index_url[] = $tmp_act.' => [\'url\'=>L('.$tmp_plat.', '.$tmp_mod.', '.$tmp_act.'), \'rel\'=>$this->_navTab.\'_'.$request['list_url_act'][$k].'\']';
                    }else {//非default则直接使用
                        $init_index_url[] = $tmp_act.' => [\'url\'=>L('.$tmp_plat.', '.$tmp_mod.', '.$tmp_act.'), \'rel\'=>\''.$request['list_url_navtab'][$k].'\']';
                    }
                    
                }else{
                    $init_index_url[] = $tmp_act.' => [\'url\'=>L('.$tmp_plat.', '.$tmp_mod.', '.$tmp_act.')]';
                }
            }
            
            $str_init_index_url = '';
            if( !empty($init_index_url) ){

                $str_init_index_url = '
                    $this->_datas[\'url\'] = [
                        '.implode(','.PHP_EOL, $init_index_url).'
                    ];
                ';
            }
            /*
            最终形成：
            $this->_datas['url'] = [
                'index' => ['url'=>L('Admin', 'User', 'index')],
                'ad' => ['url'=>L(PLAT, MOD, 'ad'), 'rel'=>$this->_navTab.'_ad'],
                'upd' => ['url'=>L(PLAT, MOD, 'upd'), 'rel'=>$this->_navTab.'_upd'],
                'del' => ['url'=>L(PLAT, MOD, 'del')]
            ];
            */
            

            #初始化mustShow
            $init_index_mustShow = [];
            foreach( $request['list_must_show_ch'] as $k=>$v){
                
                $tmp_is_set = ($request['list_must_show_is_set'][$k]=='1') ? ",'is_set'=>1" : "";
                $init_index_mustShow[] = "'".$request['list_must_show_en'][$k]."'=>['ch'=>'".$v."', 'width'=>".$request['list_must_show_width'][$k].$tmp_is_set."]";
            }

            $str_init_index_mustShow = '';
            if( !empty($init_index_mustShow) ){

                $str_init_index_mustShow = "
                    $this->_datas['mustShow'] = [
                        ".implode(','.PHP_EOL, $init_index_mustShow)."
                    ];
                ";
            }
            /*
            最终形成：
            $this->_datas['mustShow'] = [
                'id' => ['ch'=>'ID', 'width'=>30], 
                'cai' => ['ch'=>'菜品', 'width'=>60], 
                'byeffect' => ['ch'=>'副作用', 'width'=>150]
            ];
            */
            
            if( !empty($str_init_index_url)||!empty($str_init_index_mustShow) ){
                $init_index .= '
                if(ACT==\'index\'){
                    '.$str_init_index_url.'
                    '.$str_init_index_mustShow.'
                }
                ';
            }
            /*
            最终形成：
            if(ACT=='index'){
                $this->_datas['url'] = [
                    'index' => L(PLAT, MOD, 'index'),
                    'ad' => ['url'=>L(PLAT, MOD, 'ad'), 'rel'=>$this->_navTab.'_ad'],
                    'upd' => ['url'=>L(PLAT, MOD, 'upd'), 'rel'=>$this->_navTab.'_upd'],
                    'del' => L(PLAT, MOD, 'del')
                ];
                $this->_datas['mustShow'] = [
                    'id' => ['ch'=>'ID', 'width'=>30], 
                    'cai' => ['ch'=>'菜品', 'width'=>60], 
                    'byeffect' => ['ch'=>'副作用', 'width'=>150]
                ];
            }
            */
        }

        //init_ad
        $init_ad = '';
        if( in_array('1', $request['major_acts']) ){//1表示添加页
        

        }


        //init_adh_and_updh
        $init_adh_and_updh = '';

        //init_upd
        $init_upd = '';
        if( in_array('2', $request['major_acts']) ){//2表示编辑页
        
        }


        //构造方法模板合成
        $templ = '
        public function __construct(){

            parent::__construct();
    
            '.$navtab.'
    
            '.$init.'
            
            '.$init_index.'
            '.$init_ad.'
            '.$init_adh_and_updh.'
            '.$init_upd.'
    
            $this->_datas[\'navTab\'] = $this->_navTab;
        }
        ';

        return $templ;
    }

    public function test(){
        //接收数据
        $request = M('RequestTool')->all('n');
        var_dump($request);

        echo '<hr/>';
        
        $request = M('RequestTool')->vars($request, 'htmlspecialchars_decode');
        var_dump($request);
    }

    public function index(){
        //接收数据
        // $request = $_REQUEST;

        //检查数据
        $this->assign($this->_datas);
        $this->display('Robot/index.tpl');

    }

    public function enum(){
    
        //接收数据
        $request = M('RequestTool')->all();

        if( $request['type']==1 ){
        
            $enumHtml = '<select class="combox" name="'.$request['name'].'[]">
                            <option value="0">否</option>
                            <option value="1">是</option>
                        </select>';
        }elseif( $request['type']==2 ) {
            
            $enumHtml = '<select class="combox" name="'.$request['name'].'[]">';

            foreach( $this->_datas['list_search_rule'] as $k=>$v){
                
                $enumHtml .= '<option value="'.$k.'">'.$v.'</option>';
            }
            $enumHtml .= '</select>';
                            
        }

        echo $enumHtml;
    }

}      
