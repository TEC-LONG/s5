<?php
namespace tools\controller;
use \core\controller;
use \plugins\RequestTool;

class RobotController extends Controller {

    private $_datas=[];
    private $_navTab;
    private $_requ;

    //记录处理过程中需要的数据
    private $save_key_val = [];//处理后的值对信息
    private $handler_save_url = [];//处理后的列表页跳转链接相关信息

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
                $this->_datas['plats'] = ['tools', 'admin', 'home'];
                $this->_datas['major_acts'] = ['列表页', '添加页', '编辑页', '模型', '删除功能', '列表导出功能'];//这个数组内元素的顺序不要随意改动，因后面的功能很多都基于现有元素的下表来进行判断操作的
                $this->_datas['list_url_acts'] = ['index'=>'列表页', 'ad'=>'添加页', 'upd'=>'编辑页', 'del'=>'删除功能', 'export'=>'列表导出功能'];//总的url
                $this->_datas['list_url_acts_default'] = ['index'=>'列表页', 'ad'=>'添加页', 'upd'=>'编辑页', 'del'=>'删除功能'];//列表页默认需要生成的url

                $this->_datas['list_search_rule'] = ['like', 'mul'];
                $this->_datas['list_search_form_type'] = ['text-normal'=>'text-normal', 'text-numb'=>'text-numb', 'text-phone'=>'text-phone', 'text-pwd'=>'text-pwd', 'text-email'=>'text-email', 'select'=>'select', 'radio'=>'radio', 'checkbox'=>'checkbox'];
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
        #控制器构造方法初始化部分
        $controller_construct = $this->controller_construct($request);
        // echo $controller_construct;
        // exit;

        #列表页部分
        $controller_index = '';
        $templ_index = '';
        if( in_array('0', $request['major_acts']) ){
            $controller_index = $this->controller_index($request);
            $templ_index = $this->templ_index($request);//列表页html模板

            // echo $templ_index;
            // exit;
        }

        #添加页部分
        $templ_ad = '';
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
        $controller_templ = str_replace('{{$plat}}', $request['plat'], $ori_controller_templ);
        $controller_templ = str_replace('{{$controller_name}}', ucfirst($request['controller_name']), $controller_templ);
        $controller_templ = str_replace('{{$controller_construct}}', $controller_construct, $controller_templ);
        $controller_templ = str_replace('{{$controller_index}}', $controller_index, $controller_templ);
        
        // var_dump($controller_templ);
        // exit;

        // 生成文件
        if(!empty($templ_index)||!empty($templ_ad)){//生成模板目录

            $templ_dir = DOWNLOAD_PATH . strtolower($request['controller_name']);
            if( !is_dir($templ_dir) ){
                @mkdir($templ_dir);
                chmod($templ_dir, 0777);
            }
        }

        if(!empty($controller_templ)){

            #文件名
            $controller_file_name = DOWNLOAD_PATH . $request['controller_name'] . 'Controller.class.php';
            file_put_contents($controller_file_name, $controller_templ);
        }

        if( !empty($templ_index) ){

            $templ_index_name = $templ_dir . '/index.tpl';
            file_put_contents($templ_index_name, $templ_index);
        }
    }

    protected function search_td($form_name, $form_type, $save_key_val){

        $td_html = '';
        $tmp_save_key_val_keys = array_keys($save_key_val);

        switch($form_type){
        case 'text-normal':
            $td_html .= '<input type="text" name="'.$form_name.'" value="{if isset($search.'.$form_name.')}{$search.'.$form_name.'}{/if}" />';
        break;
        case 'text-email':
            $td_html .= '<input type="text" name="'.$form_name.'" class="email" alt="请输入您的电子邮件"/>';
        break;
        case 'text-phone':
            $td_html .= '<input type="text" name="'.$form_name.'" class="phone" alt="请输入您的电话"/>';
        break;
        case 'text-numb':
            $td_html .= '<input type="text" name="'.$form_name.'" class="number" alt="请输入数字"/>';
        break;
        case 'select':
            if( in_array($form_name, $tmp_save_key_val_keys) ){
                $td_html .= '<select class="combox" name="'.$form_name.'">' . PHP_EOL;
                foreach( $save_key_val[$form_name] as $k=>$v){
                    $td_html .= '<option value="'.$k.'" {if isset($search.'.$form_name.')&&$search.'.$form_name.'=="'.$k.'"}selected{/if}>'.$v.'</option>' . PHP_EOL;
                }
                $td_html .= '</select>' . PHP_EOL;
            }
            /*
            <select class="combox" name="xxx">
                <option value="1">test1</option>
                <option value="2" {if $search.xxx=="2"}selected{/if}>test2</option>
            </select>
            */
        break;
        case 'radio':
            if( in_array($form_name, $tmp_save_key_val_keys) ){
                $td_html .= '<select class="combox" name="'.$form_name.'">' . PHP_EOL;
                foreach( $save_key_val[$form_name] as $k=>$v){
                    $td_html .= '<option value="'.$k.'" {if $search.'.$form_name.'=="'.$k.'"}selected{/if}>'.$v.'</option>' . PHP_EOL;
                }
                $td_html .= '</select>' . PHP_EOL;
            }
            /*
            <select class="combox" name="xxx">
                <option value="1">test1</option>
                <option value="2" {if $search.xxx=="2"}selected{/if}>test2</option>
            </select>
            */
        break;
        case 'checkbox':
            if( in_array($form_name, $tmp_save_key_val_keys) ){
                foreach( $save_key_val[$form_name] as $k=>$v){
                    $td_html .= '<input type="checkbox" name="'.$form_name.'[]" value="'.$k.'" {if in_array("'.$k.'", $search.'.$form_name.')}checked{/if} />'.$v.'&nbsp;&nbsp;&nbsp;&nbsp;' . PHP_EOL;
                }
            }
            /*
            <input type="checkbox" name="xxx[]" value="1" {if in_array("1", $search.xxx)}checked{/if} />'.test1.'&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="checkbox" name="xxx[]" value="2" {if in_array("2", $search.xxx)}checked{/if} />'.test2.'&nbsp;&nbsp;&nbsp;&nbsp;
            */
        break;
        }

        return $td_html;
    }

    protected function handler_get_jump_url($ch_name){
    
        /*
        $this->handler_save_url:
        array(4) {
            [0]=>
            array(4) {
                ["ch_name"]=>
                string(9) "列表页"
                ["descr_name"]=>
                string(0) ""
                ["index"]=>
                string(7) "'index'"
                ["navtab"]=>
                string(10) "User_index"
            }
            [1]=>
            array(4) {
                ["ch_name"]=>
                string(9) "添加页"
                ["descr_name"]=>
                string(0) "添加用户"
                ["index"]=>
                string(4) "'ad'"
                ["navtab"]=>
                string(7) "User_ad"
            }
        }
        */
        $templ_form_action = ['url'=>'', 'descr_name'=>'', 'navtab'=>''];
        foreach( $this->handler_save_url as $v){
            
            if( $v['ch_name']===$ch_name ){
            
                $templ_form_action['url'] = '{$url.'.$v['index'].'.url}';
                $templ_form_action['descr_name'] = empty($v['descr_name'])?$v['ch_name']:$v['descr_name'];
                $templ_form_action['navtab'] = $v['navtab'];
                break;
                /*E
                最终得到：
                $templ_form_action = ['url'=>'{$url.ad.url}', 'descr_name'=>'添加用户', 'navtab'=>'User_ad'];
                */
            }
        }

        return $templ_form_action;
    }

    /**
     * 
     */
    protected function templ_index($request){
        // var_dump($this->handler_save_url);
        // var_dump($request);
        // exit;

        //搜索区域内容
        $search_html = '';
        #检查是否有搜索的内容
        if( isset($request['list_search_name'])&&$request['list_search_name'][0]!=='' ){ //存在且第一个元素不为空字符串，才说明真的有搜索部分

            $templ_form_action = $this->handler_get_jump_url('列表页');

            $templ_search_td = '';
            foreach( $request['list_search_ch_title'] as $k=>$ch_title){
            
                $templ_search_td .= '<td>'.$ch_title.'：';
                $templ_search_td .= $this->search_td($request['list_search_form_name'][$k], $request['list_search_form_type'][$k], $this->save_key_val);
                $templ_search_td .= '</td>';
            }

            $search_html = '
<div class="pageHeader">
    <form onsubmit="return navTabSearch(this);" action="'.$templ_form_action['url'].'" method="post" onreset="$(this).find(\'select.combox\').comboxReset()">
    <div class="searchBar">
        <table class="searchContent">
            <tr>
                '.$templ_search_td.'
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
                        <td>适用场景：
                            <input type="checkbox" name="types[]" value="1" {if in_array("1", $search.types)}checked{/if} />test1&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="checkbox" name="types[]" value="2" {if in_array("2", $search.types)}checked{/if} />test2&nbsp;&nbsp;&nbsp;&nbsp;
                        </td>
                        <td>食物类型：
                            <input type="checkbox" name="food_types[]" value="1" {if in_array("1", $search.food_types)}checked{/if} />类型1&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="checkbox" name="food_types[]" value="2" {if in_array("2", $search.food_types)}checked{/if} />类型2&nbsp;&nbsp;&nbsp;&nbsp;
                        </td>
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
        #按钮部分
        $btn_html = '';
        
        $tmp_li = '';
        if( in_array('1', $request['major_acts']) ){//勾选了 "添加页"

            $templ_form_action = $this->handler_get_jump_url('添加页');
            $tmp_li .= '<li><a class="add" href="'.$templ_form_action['url'].'" target="navTab" rel="'.$templ_form_action['navtab'].'"><span>'.$templ_form_action['descr_name'].'</span></a></li>' . PHP_EOL;
        }

        if( in_array('4', $request['major_acts']) ){//勾选了 "删除功能"

            $templ_form_action = $this->handler_get_jump_url('删除功能');
            $tmp_li .= '<li><a class="delete" href="'.$templ_form_action['url'].'&id={ldelim}sid_{$navTab}}" target="ajaxTodo" title="确定要删除吗?"><span>删除</span></a></li>' . PHP_EOL;
        }

        if( in_array('2', $request['major_acts']) ){//勾选了 "编辑页"

            $templ_form_action = $this->handler_get_jump_url('编辑页');
            $tmp_li .= '<li><a class="edit" href="'.$templ_form_action['url'].'&id={ldelim}sid_{$navTab}}" target="navTab"  rel="'.$templ_form_action['navtab'].'"><span>'.$templ_form_action['descr_name'].'</span></a></li>' . PHP_EOL;
        }

        if( in_array('5', $request['major_acts']) ){//勾选了 "列表导出功能"

            $templ_form_action = $this->handler_get_jump_url('列表导出功能');
            $tmp_li .= '<li class="line">line</li>' . PHP_EOL;
            $tmp_li .= '<li><a class="icon" href="'.$templ_form_action['url'].'" target="dwzExport" targetType="navTab" title="实要导出这些记录吗?"><span>导出EXCEL</span></a></li>' . PHP_EOL;
        }

        if( !empty($tmp_li) ){

            $btn_html = '
            <div class="panelBar">
                <ul class="toolBar">
                    '.$tmp_li.'
                </ul>
            </div>
            ';
        }
        /*E
        最终得到：
        <div class="panelBar">
            <ul class="toolBar">
                <li><a class="add" href="{$url.ad.url}" target="navTab" rel="{$url.ad.rel}"><span>添加菜品</span></a></li>
                <li><a class="delete" href="{$url.del}&id={ldelim}sid_{$navTab}}" target="ajaxTodo" title="确定要删除吗?"><span>删除</span></a></li>
                <li><a class="edit" href="{$url.upd.url}&id={ldelim}sid_{$navTab}}" target="navTab"  rel="{$url.upd.rel}"><span>修改菜品</span></a></li>
                <li class="line">line</li>
                <li><a class="icon" href="demo/common/dwz-team.xls" target="dwzExport" targetType="navTab" title="实要导出这些记录吗?"><span>导出EXCEL</span></a></li>
            </ul>
        </div>
        */

        #内容部分
        $main_list_html = '';

        if( !empty($request['list_must_show_ch'])&&!empty($request['list_must_show_en']) ){

            $tmp_thead = '
            <thead>
                <tr>
                    <th width="30"><input type="checkbox" group="ids" class="checkboxCtrl"></th>
                    <th width="30">序号</th>
            ';
            /*
            $request['list_must_show_ch']：
            array(3) {
                [0]=>
                string(9) "post_date"
                [1]=>
                string(6) "账号"
                [2]=>
                string(12) "用户昵称"
            }
            */
            foreach( $request['list_must_show_ch'] as $k=>$v){
            
                $tmp_thead .= '<th width="'.$request['list_must_show_width'][$k].'">'.$v.'</th>' . PHP_EOL;
            }

            $tmp_thead .= '
                </tr>
            </thead>
            ';

            $tmp_tbody = '
            <tbody>
            {foreach $rows as $rows_key=>$row}
            <tr target="sid_{$navtab}" rel="{$row.id}">
                <td><input name="ids_{$navtab}[]" value="{$row.id}" type="checkbox"></td>
                <td>{$rows_key+1}</td>
            ';

            foreach( $request['list_must_show_en'] as $k=>$v){
            
                $tmp_tbody .= '
                <td>{$row.'.$v.'}</td>
                ';
            }
            $tmp_tbody .= '
            </tr>
            {/foreach}
            </tbody>
            ';

            $main_list_html = '
            <table class="table" width="100%" layoutH="138">
                '.$tmp_thead.'
                '.$tmp_tbody.'
            </table>
            ';
        }

        /*E
        最终得到：
        <table class="table" width="100%" layoutH="138">
            <thead>
                <tr>
                    <th width="30"><input type="checkbox" group="ids" class="checkboxCtrl"></th>
                    <th width="30">序号</th>
                    {foreach $mustShow as $col}
                    <th {if !empty($col.width)}width="{$col.width}"{/if}>{$col.ch}</th>
                    {/foreach}
                </tr>
            </thead>
            <tbody>
                {$tbhtml}
            </tbody>
        </table>
        */

        //分页区域内容
        $pagination_search_html = '';
        foreach( $request['list_search_ch_title'] as $k=>$ch_title){
            
            $pagination_search_html .= '
            <input type="hidden" name="'.$request['list_search_form_name'][$k].'" value="{$search.'.$request['list_search_form_name'][$k].'}" />
            ';
        }

        $templ_form_action = $this->handler_get_jump_url('列表页');

        $pagination_html = '
        <form id="pagerForm" method="post" action="'.$templ_form_action['url'].'">
            <input type="hidden" name="pageNum" value="1" />
            <input type="hidden" name="numPerPage" value="{$page.numPerPage}" />
            '.$pagination_search_html.'
        </form>
        <div class="panelBar">
            <div class="pages">
                <span>显示</span>
                <select class="combox" name="numPerPage" {literal}onchange="navTabPageBreak({numPerPage:this.value})"{/literal}>
                    <option value="{$page.numPerPage}">{$page.numPerPage}</option>
                    {foreach $page.numPerPageList as $thisNumPerPage}
                        {if $thisNumPerPage!=$page.numPerPage}
                    <option value="{$thisNumPerPage}">{$thisNumPerPage}</option>
                        {/if}
                    {/foreach}
                </select>
                <span>条，总共{$page.totalNum}条记录，合计{$page.totalPageNum}页</span>
            </div>
            <div class="pagination" targetType="navTab" totalCount="{$page.totalNum}" numPerPage="{$page.numPerPage}" pageNumShown="6" currentPage="{$page.pageNum}"></div>
        </div>
        ';
        //pageNumShown表示显示多少个页码


        /*E
        最终得到：
        <form id="pagerForm" method="post" action="{$url.index}">
            <input type="hidden" name="pageNum" value="1" />
            <input type="hidden" name="numPerPage" value="{$page.numPerPage}" />
            <input type="hidden" name="cai" value="{$search.cai}" />
            {foreach $search.types as $val}
            <input type="hidden" name="types[]" value="{$val}"/>
            {/foreach}
            {foreach $search.food_types as $val}
            <input type="hidden" name="food_types[]" value="{$val}"/>
            {/foreach}
        </form>
        <div class="panelBar">
            <div class="pages">
                <span>显示</span>
                <select class="combox" name="numPerPage" {literal}onchange="navTabPageBreak({numPerPage:this.value})"{/literal}>
                    <option value="{$page.numPerPage}">{$page.numPerPage}</option>
                    {foreach $page.numPerPageList as $thisNumPerPage}
                        {if $thisNumPerPage!=$page.numPerPage}
                    <option value="{$thisNumPerPage}">{$thisNumPerPage}</option>
                        {/if}
                    {/foreach}
                </select>
                <span>条，总共{$page.totalNum}条记录，合计{$page.totalPageNum}页</span>
            </div>
            <div class="pagination" targetType="navTab" totalCount="{$page.totalNum}" numPerPage="{$page.numPerPage}" pageNumShown="10" currentPage="{$page.pageNum}"></div>
        </div>
        */

        $index_html = $search_html . '<div class="pageContent">' . PHP_EOL . $btn_html . $main_list_html . $pagination_html . PHP_EOL . '</div>';
        return $index_html;
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
    
            //分配模板变量&渲染模板
            $this->assign($this->_datas);
            $this->display(\''.$display_template.'\');
        }
        ';

        return $templ;
    }

    protected function handler_ori_key_val($key_val_en_name, $key_val_ori_key_val){
    
        /*B
        原有数据：
        $key_val_en_name:
        array(2) {
            [0]=>
            string(5) "level"
            [1]=>
            string(6) "status"
        }
        $key_val_ori_key_val:
        array(2) {
            [0]=>
            string(26) "0:普通用户|1:管理员"
            [1]=>
            string(17) "0:正常|1:禁用"
        }
        */

        foreach( $key_val_en_name as $k=>$name){
        
            if(!empty($name)){

                $tmp_arr1 = explode('|', $key_val_ori_key_val[$k]);
                $tmp_arr1 = array_map(function($elem){
                    return trim($elem);
                }, $tmp_arr1);

                #                          0:普通用户
                foreach( $tmp_arr1 as $k1=>$v1){

                    $tmp_arr2 = explode(':', $v1);
                    $tmp_arr2 = array_map(function($elem){
                        return trim($elem);
                    }, $tmp_arr2);

                    if( is_numeric($tmp_arr2[0]) ) $tmp_arr2[0] = intval($tmp_arr2[0]);//如果是数字类型，则转换为整型
                    #                  'level'     0             '普通用户'
                    $this->save_key_val[$name][$tmp_arr2[0]] = $tmp_arr2[1];
                }
            }
        }

        /*E
        最终形成：
        $this->save_key_val = [
            'level' => [0=>'普通用户', 1=>'管理员'],
            'status' => [0=>'正常', 1=>'禁用']
        ];
        */
    }

    /**
     * method:构建控制器构造方法
     */
    protected function controller_construct($request){

        //navtab
        $navtab = '
            $this->_navTab = \''.$request['navtab'].'\';
        ';
        /*E
        最终形成：
        $this->_navTab = 'chifan';
        */

        //$this->_init
        /*B
        原有数据：
        $request['robot_key_val_en_name']:
        array(2) {
            [0]=>
            string(5) "level"
            [1]=>
            string(6) "status"
        }
        $request['robot_key_val_ori_key_val']:
        array(2) {
            [0]=>
            string(26) "0:普通用户|1:管理员"
            [1]=>
            string(17) "0:正常|1:禁用"
        }
        */
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
        #处理并记录key_val数据，供之后处理过程使用
        $this->handler_ori_key_val($request['robot_key_val_en_name'], $request['robot_key_val_ori_key_val']);
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

                #额外记录下链接相关信息，供之后的处理功能使用
                $this->handler_save_url[$k]['ch_name'] = $request['list_url_name'][$k];
                $this->handler_save_url[$k]['descr_name'] = $request['list_url_descr_name'][$k];
                $this->handler_save_url[$k]['index'] = $request['list_url_act'][$k];

                if( !empty($request['list_url_navtab'][$k]) ){//跳转链接项若是填写了navtab则需要额外包含navtab
                    
                    if( $request['list_url_navtab'][$k]==='default' ){//default则给默认

                        $init_index_url[] = $tmp_act.' => [\'url\'=>L('.$tmp_plat.', '.$tmp_mod.', '.$tmp_act.'), \'rel\'=>\''.$request['navtab'].'_'.$request['list_url_act'][$k].'\']';

                        $this->handler_save_url[$k]['navtab'] = $request['navtab'].'_'.$request['list_url_act'][$k];
                    }else {//非default则直接使用

                        $init_index_url[] = $tmp_act.' => [\'url\'=>L('.$tmp_plat.', '.$tmp_mod.', '.$tmp_act.'), \'rel\'=>\''.$request['list_url_navtab'][$k].'\']';

                        $this->handler_save_url[$k]['navtab'] = $request['list_url_navtab'][$k];
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
        }elseif ( $request['type']==4 ) {
            
            $enumHtml = T_createSelectHtml($this->_datas['list_search_form_type'], $request['name'].'[]', 2);
        }elseif ( $request['type']==5 ) {
            
            $enumHtml = T_createSelectHtml($this->_datas['list_url_acts'], $request['name'].'[]', 1);
        }

        echo $enumHtml;
    }

}      
