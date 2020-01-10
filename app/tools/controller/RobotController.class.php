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
            'adh' => L(PLAT, MOD, 'adh'),
            'tbLookup' => L(PLAT, 'TBRecord', 'tbLookup'),
            'kvLookup' => L(PLAT, 'TBRecord', 'kvLookup')
        ];

        switch (ACT) {
            case 'index':
            case 'enum':
            case 'adh':
                $this->_datas['major_acts'] = ['列表页', '添加页', '编辑页', '模型'];
                $this->_datas['list_url_acts'] = ['index', 'ad', 'upd', 'del'];
                $this->_datas['list_search_rule'] = ['like', 'mul'];
                $this->_datas['field_list_form_type'] = ['text-normal', 'text-numb', 'text-phone', 'text-pwd', 'text-email', 'select', 'radio', 'checkbox', 'file', 'txt-area'];
            break;
        }
    }

    public function adh(){
        //接收数据
        $request =$this->_requ->all('l');
        // var_dump($request);
        // exit;

        //形成控制器
        #文件名
        $controller_file_name = $request['controller_name'] . 'Controller.class.php';

        #控制器构造方法初始化部分
        $controller_construct = $this->controller_construct($request);
        // echo $controller_construct;
        // exit;

        #列表页部分
        $controller_index = '';
        if( in_array('0', $request['major_acts']) ){
            $controller_index = $this->controller_index($request);
            $templ_index = $this->templ_index($request);

            // echo $controller_index;
            // exit;
        }

        #添加页部分
        if( in_array('1', $request['major_acts']) ){
            // $controller_add = $this->controller_add($request);
            // $controller_adh = $this->controller_adh($request);
            // $templ_add = $this->templ_add($request);
        }

        #编辑页部分
        if( in_array('2', $request['major_acts']) ){
            // $controller_upd = $this->controller_upd($request);
            // $controller_updh = $this->controller_updh($request);
            // $templ_upd = $this->templ_upd($request);
        }

        #形成控制器文件
        $ori_controller_templ = file_get_contents(PUBLIC_PATH . 'tools/moban/xx.controller.ban');
        $controller_templ = str_replace('{{$controller_construct}}', $controller_construct, $ori_controller_templ);
        $controller_templ = str_replace('{{$controller_index}}', $controller_index, $controller_templ);
        
        var_dump($controller_templ);
        exit;
    }

    /**
     * 
     */
    protected function templ_index($request){

        var_dump($request);
        exit;
    
        //搜索区域内容
        $search_html = '';
        #检查是否有搜索的内容
        if( isset($request['list_search_name'])&&$request['list_search_name'][0]!=='' ){ //存在且第一个元素不为空字符串，才说明真的有搜索部分

            $templ_form_action = '';

            $search_html = '
<div class="pageHeader">
    <form onsubmit="return navTabSearch(this);" action="{'.$templ_form_action.'}" method="post" onreset="$(this).find(\'select.combox\').comboxReset()">
    <div class="searchBar">
        <table class="searchContent">
            <tr>
                <td>
                    菜品：<input type="text" name="cai" value="{$search.cai}" />中文标题，表单name值，表单类型，若果是select之类的还需要值对信息；优先解决：添加tr样式跟随
                </td>
                <td>
                    适用场景：
                    {foreach $types as $key=>$val}
                    <input type="checkbox" name="types[]" value="{$key}" {if in_array($key, $search.types)}checked{/if} />{$val}&nbsp;&nbsp;&nbsp;&nbsp;
                    {/foreach}
                </td>
                <td>
                    食物类型：
                    {foreach $food_types as $key=>$val}
                    <input type="checkbox" name="food_types[]" value="{$key}" {if in_array($key, $search.food_types)}checked{/if} />{$val}&nbsp;&nbsp;&nbsp;&nbsp;
                    {/foreach}
                </td>
                {* <td>
                    口味：
                    {foreach $taste as $key=>$val}
                    <input type="checkbox" name="taste[]" value="{$key}" />{$val}&nbsp;&nbsp;&nbsp;&nbsp;
                    {/foreach}
                </td>
                <td>
                    口感：
                    {foreach $mouthfeel as $key=>$val}
                    <input type="checkbox" name="mouthfeel[]" value="{$key}" />{$val}&nbsp;&nbsp;&nbsp;&nbsp;
                    {/foreach}
                </td>
                <td>
                    功效：
                    {foreach $effects as $key=>$val}
                    <input type="checkbox" name="effects[]" value="{$key}" />{$val}&nbsp;&nbsp;&nbsp;&nbsp;
                    {/foreach}
                </td>
                <td class="dateRange">
                    建档日期:
                    <input name="startDate" class="date readonly" readonly="readonly" type="text" value="">
                    <span class="limit">-</span>
                    <input name="endDate" class="date readonly" readonly="readonly" type="text" value="">
                </td> *}
            </tr>
        </table>
        <div class="subBar">
            <ul>
                <li><div class="button"><div class="buttonContent"><button type="reset">重置</button></div></div></li>
                <li><div class="buttonActive"><div class="buttonContent"><button type="submit">检索</button></div></div></li>
                <li><a class="button" href="demo_page6.html" target="dialog" mask="true" title="查询框"><span>高级检索</span></a></li>
            </ul>
        </div>
    </div>
    </form>
</div>
            ';
            
        }
        
        /*E
        最终得到：
        <div class="pageHeader">
            <form onsubmit="return navTabSearch(this);" action="{$url.index}" method="post" onreset="$(this).find('select.combox').comboxReset()">
            <div class="searchBar">
                <table class="searchContent">
                    <tr>
                        <td>
                            菜品：<input type="text" name="cai" value="{$search.cai}" />
                        </td>
                        <td>
                            适用场景：
                            {foreach $types as $key=>$val}
                            <input type="checkbox" name="types[]" value="{$key}" {if in_array($key, $search.types)}checked{/if} />{$val}&nbsp;&nbsp;&nbsp;&nbsp;
                            {/foreach}
                        </td>
                        <td>
                            食物类型：
                            {foreach $food_types as $key=>$val}
                            <input type="checkbox" name="food_types[]" value="{$key}" {if in_array($key, $search.food_types)}checked{/if} />{$val}&nbsp;&nbsp;&nbsp;&nbsp;
                            {/foreach}
                        </td>
                        {* <td>
                            口味：
                            {foreach $taste as $key=>$val}
                            <input type="checkbox" name="taste[]" value="{$key}" />{$val}&nbsp;&nbsp;&nbsp;&nbsp;
                            {/foreach}
                        </td>
                        <td>
                            口感：
                            {foreach $mouthfeel as $key=>$val}
                            <input type="checkbox" name="mouthfeel[]" value="{$key}" />{$val}&nbsp;&nbsp;&nbsp;&nbsp;
                            {/foreach}
                        </td>
                        <td>
                            功效：
                            {foreach $effects as $key=>$val}
                            <input type="checkbox" name="effects[]" value="{$key}" />{$val}&nbsp;&nbsp;&nbsp;&nbsp;
                            {/foreach}
                        </td>
                        <td class="dateRange">
                            建档日期:
                            <input name="startDate" class="date readonly" readonly="readonly" type="text" value="">
                            <span class="limit">-</span>
                            <input name="endDate" class="date readonly" readonly="readonly" type="text" value="">
                        </td> *}
                    </tr>
                </table>
                <div class="subBar">
                    <ul>
                        <li><div class="button"><div class="buttonContent"><button type="reset">重置</button></div></div></li>
                        <li><div class="buttonActive"><div class="buttonContent"><button type="submit">检索</button></div></div></li>
                        <li><a class="button" href="demo_page6.html" target="dialog" mask="true" title="查询框"><span>高级检索</span></a></li>
                    </ul>
                </div>
            </div>
            </form>
        </div>
        */


        //列表区域内容

        //分页区域内容

    }

    /**
     * 
     */
    protected function controller_index($request){
        
        #初始条件
        /*B
        如：$request['list_search_init'] = 'is_del:0|id:>:10|name:!=:zhangsan'
        */
        $list_search_init_arr = explode('|', $request['list_search_init']);
        $list_search_init = [];
        
        foreach( $list_search_init_arr as $field){

            if( !empty($field)&&strpos($field, ':') ){

                $field_arr = explode(':', $field);
                if( count($field_arr)==2 ){
                    
                    $list_search_init[] = "'" . $field_arr[0] . "'=>'" . $field_arr[1] . "'";
                }elseif (count($field_arr==3)) {
                    $list_search_init[] = "'" . $field_arr[0] . "'=>'" . $field_arr[1] . "\"" . $field_arr[2] . "\"'";
                }
            }
        }
        $list_search_init = implode(',', $list_search_init);
        /*E
        最终形成：
        'is_del'=>'=0','id'=>'>"10"','name'=>'!="zhangsan"'
        它将会用到模板中形成：
        $con_arr = ['is_del'=>'=0','id'=>'>"10"','name'=>'!="zhangsan"'];
        */

        #查询字段
        /*B
        如：
        $request['list_search_name']:
                                        array(3) {
                                            [0]=>
                                            string(3) "cai"
                                            [1]=>
                                            string(5) "types"
                                            [2]=>
                                            string(7) "effects"
                                        }
        $request['list_search_rule']：
                                        array(3) {
                                            [0]=>
                                            string(1) "0"
                                            [1]=>
                                            string(1) "1"
                                            [2]=>
                                            string(1) "1"
                                        }
        */
        $list_search = [];
        foreach( $request['list_search_name'] as $k=>$v){
            
            $tmp_rule_index = $request['list_search_rule'][$k];
            $list_search[] = "['".$v."', '".$this->_datas['list_search_rule'][$tmp_rule_index]."']";
        }
        $list_search = implode(','.PHP_EOL, $list_search);
        /*E
        最终形成：
        ['cai', 'like'],
        ['types', 'mul'],
        ['effects', 'mul']
        它将会用到模板中形成：
        $form_elems = [
            ['cai', 'like'],
            ['types', 'mul'],
            ['effects', 'mul']
        ];
        */

        #操作主表名称
        $major_table_name = $request['robot_tb_record_en_name'];
        /*E
        最终形成：tb_record
        */

        #查询字段
        $select = $request['list_fields'];
        /*E
        最终形成：id,name,age,user.id,user.name as uname
        */

        #渲染模板文件名
        $display_template = $request['list_tpl_name'];
        /*E
        最终形成：User/index.tpl
        */
    
        #列表页方法模板合成
        $templ = '
        public function index(){ 

            $request = $_REQUEST;
    
            //初始条件
            $con_arr = ['.$list_search_init.'];

            //查询字段
            $form_elems = [
                '.$list_search.'
            ];
            
            //将条件数组数据转换为条件字符串
            $con = $this->_condition_string($request, $form_elems, $con_arr);
    
            //将搜索的原始数据扔进模板
            $this->_datas[\'search\'] = $this->_get_ori_search_datas($request, $form_elems);
    
            //分页参数
            $this->_datas[\'page\'] = $page = $this->_page(\''.$major_table_name.'\', $con, 3);
    
            //查询数据
            $rows = M()->table(\''.$major_table_name.'\')
                    ->select(\''.$select.'\')
                    ->where($con)
                    ->limit($page[\'limitM\'] . \',\' . $page[\'numPerPage\'])
                    ->get();
    
            /*if( $rows ){
                foreach( $rows as &$row ){ 
                    if( !empty($row[\'expnew_ids\']) ){
                        $row[\'expnew_titles\'] = explode(\'|\', $row[\'expnew_titles\']);
                        $row[\'expnew_ids\'] = explode(\'|\', $row[\'expnew_ids\']);
                    }
                    $row[\'has_descr\'] = !empty($row[\'descr\']) ? \'是\' : \'否\';
                }
            }*/
            $this->_datas[\'rows\'] = $rows;//扔到模板中
    
            //列表html 扔到模板中
            $this->_datas[\'tbhtml\'] = $this->_tbhtml($this->_datas[\'mustShow\'], $cais, $this->_navTab, $this->_init);
    
            //分配模板变量&渲染模板
            $this->assign($this->_datas);
            $this->display(\''.$display_template.'\');
        }
        ';

        return $templ;
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
        foreach( $request['robot_key_val_en_name'] as $k=>$name){
        
            if(!empty($name)){
                $init .= '
                $this->_init[\''.$name.'\'] = \''.$request['robot_key_val_ori_key_val'][$k].'\';
                ';
            }
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
                if( !empty($v) ){
                    $tmp_is_set = ($request['list_must_show_is_set'][$k]=='1') ? ",'is_set'=>1" : "";
                    $init_index_mustShow[] = "'".$request['list_must_show_en'][$k]."'=>['ch'=>'".$v."', 'width'=>".$request['list_must_show_width'][$k].$tmp_is_set."]";
                }
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
                            
        }elseif ( $request['type']==3 ) {
            
            $enumHtml = T_createSelectHtml($this->_datas['field_list_form_type'], $request['name'].'[]', 2);
        }

        echo $enumHtml;
    }

}      
