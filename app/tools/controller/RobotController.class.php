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
            'index' => L('/tools/robot/index'),
            'adh' => L('/tools/robot/adh'),
            'tbLookup' => L('/tools/tbRecord/tbLookup'),
            'kvLookup' => L('/tools/tbRecord/kvLookup')
        ];

        switch (ACT) {
            case 'index':
            case 'enum':
            case 'adh':
                $this->_datas['plats'] = ['tools', 'admin', 'home'];
                $this->_datas['major_acts'] = ['列表页', '添加页', '编辑页', '模型', '删除功能', '列表导出功能'];//这个数组内元素的顺序不要随意改动，因后面的功能很多都基于现有元素的下表来进行判断操作的
                $this->_datas['list_url_acts'] = ['index'=>'列表页', 'ad'=>'添加页', 'upd'=>'编辑页', 'del'=>'删除功能', 'export'=>'列表导出功能', 'adh'=>'添加处理程序'];//总的url
                $this->_datas['list_url_acts_default'] = ['index'=>'列表页', 'ad'=>'添加页', 'upd'=>'编辑页', 'del'=>'删除功能'];//列表页默认需要生成的url
                $this->_datas['ad_url_acts_default'] = ['adh'=>'添加处理程序'];//添加页默认需要生成的url

                $this->_datas['list_search_rule'] = ['like', 'equal', 'mul'];
                $this->_datas['list_search_form_type'] = ['text-normal'=>'text-normal', 'text-numb'=>'text-numb', 'text-phone'=>'text-phone', 'text-pwd'=>'text-pwd', 'text-email'=>'text-email', 'select'=>'select', 'radio'=>'radio', 'checkbox'=>'checkbox'];

                // $this->_datas['field_list_form_type'] = ['text-normal', 'text-numb', 'text-phone', 'text-pwd', 'text-email', 'select', 'radio', 'checkbox', 'file', 'txt-area'];
                $this->_datas['ad_or_upd_form_type'] = ['text-normal', 'text-numb', 'text-phone', 'text-pwd', 'text-email', 'date', 'date-time', 'select', 'checkbox', 'textarea', 'textarea-editor', 'file', 'file-mul'];
            break;
        }
    }

    public function adh(){
        //接收数据
        $request = $this->_requ->all('l');
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
        $controller_ad = '';
        $controller_adh = '';
        $templ_ad = '';
        if( in_array('1', $request['major_acts']) ){
            $controller_ad = $this->controller_ad($request);
            // $controller_adh = $this->controller_adh($request);
            $templ_ad = $this->templ_ad($request);
        }

        #编辑页部分
        $controller_upd = '';
        $controller_updh = '';
        $templ_upd = '';
        if( in_array('2', $request['major_acts']) ){
            // $controller_upd = $this->controller_upd($request);
            // $controller_updh = $this->controller_updh($request);
            // $templ_upd = $this->templ_upd($request);
        }

        #编辑页部分
        $controller_del = '';
        if( in_array('4', $request['major_acts']) ){

        }

        #形成控制器文件
        $ori_controller_templ = file_get_contents(PUBLIC_PATH . 'tools/moban/xx.controller.ban');
        $controller_templ = str_replace('{{$plat}}', $request['plat'], $ori_controller_templ);
        $controller_templ = str_replace('{{$controller_name}}', ucfirst($request['controller_name']), $controller_templ);
        $controller_templ = str_replace('{{$controller_construct}}', $controller_construct, $controller_templ);
        $controller_templ = str_replace('{{$controller_index}}', $controller_index, $controller_templ);
        $controller_templ = str_replace('{{$ad}}', $controller_ad, $controller_templ);
        $controller_templ = str_replace('{{$adh}}', $controller_adh, $controller_templ);
        $controller_templ = str_replace('{{$upd}}', $controller_upd, $controller_templ);
        $controller_templ = str_replace('{{$updh}}', $controller_updh, $controller_templ);
        $controller_templ = str_replace('{{$del}}', $controller_del, $controller_templ);
        
        // var_dump($controller_templ);
        // exit;

        // 生成文件
        if(!empty($templ_index)||!empty($templ_ad)||!empty($templ_upd)){//生成模板目录

            // $templ_dir = DOWNLOAD_PATH . strtolower($request['controller_name']);
            $templ_dir = TOOLS_VIEW_PATH . strtolower($request['controller_name']);
            if( !is_dir($templ_dir) ){
                @mkdir($templ_dir);
                chmod($templ_dir, 0777);
            }
        }

        if(!empty($controller_templ)){

            #文件名
            // $controller_file_name = DOWNLOAD_PATH . $request['controller_name'] . 'Controller.class.php';
            $controller_file_name = TOOLS_CONTROLLER_PATH . $request['controller_name'] . 'Controller.class.php';
            file_put_contents($controller_file_name, $controller_templ);
        }

        if( !empty($templ_index) ){
            $templ_index_url_info = $this->handler_get_jump_url('列表页');
            $templ_index_name = $templ_dir . '/'.$templ_index_url_info['index'].'.tpl';
            file_put_contents($templ_index_name, $templ_index);
        }

        if( !empty($templ_ad) ){
            $templ_index_url_info = $this->handler_get_jump_url('添加页');
            $templ_ad_name = $templ_dir . '/'.$templ_index_url_info['index'].'.tpl';
            file_put_contents($templ_ad_name, $templ_ad);
        }
    }

    protected function templ_ad($request){


        $templ_ad_html = '';
        if( isset($request['ad_form_elem_name'])&&!empty($request['ad_form_elem_name']) ){

            $tmp_html = '';
            foreach ($request['ad_form_elem_name'] as $k => $elem_name) {
                
                switch ($request['ad_form_elem_form_type'][$k]) {
                    case 'text-normal':
                        $tmp_html .= '
<p>
    <label>'.$request['ad_form_elem_ch_title'][$k].'：</label>
    <input name="'.$request['ad_form_elem_form_name'][$k].'" type="text" />
</p>
                        ';
                    break;
                    case 'text-numb':
                        $tmp_html .= '
<p>
    <label>'.$request['ad_form_elem_ch_title'][$k].'：</label>
    <input name="'.$request['ad_form_elem_form_name'][$k].'" type="text" class="digits" />
</p>
                        ';
                    break;
                    case 'text-phone':
                        $tmp_html .= '
<p>
    <label>'.$request['ad_form_elem_ch_title'][$k].'：</label>
    <input name="'.$request['ad_form_elem_form_name'][$k].'" type="text" class="phone" />
</p>
                        ';
                    break;
                    case 'text-pwd':
                        $tmp_html .= '
<p>
    <label>'.$request['ad_form_elem_ch_title'][$k].'：</label>
    <input name="'.$request['ad_form_elem_form_name'][$k].'" type="text" class="alphanumeric" minlength="6" maxlength="20" />
</p>
                        ';
                    break;
                    case 'text-email':
                        $tmp_html .= '
<p>
    <label>'.$request['ad_form_elem_ch_title'][$k].'：</label>
    <input name="'.$request['ad_form_elem_form_name'][$k].'" type="text" class="email" />
</p>
                        ';
                    break;
                    case 'date':
                        $tmp_html .= '
<p>
    <label>'.$request['ad_form_elem_ch_title'][$k].'：</label>
    <input type="text" name="'.$request['ad_form_elem_form_name'][$k].'" class="date" readonly="true"/>
    <a class="inputDateButton" href="javascript:;">选择</a>
    <span class="info">格式：yyyy-MM-dd</span>
</p>
                        ';
                    break;
                    case 'date-time':
                        $tmp_html .= '
<p>
    <label>'.$request['ad_form_elem_ch_title'][$k].'：</label>
    <input type="text" name="'.$request['ad_form_elem_form_name'][$k].'" class="date" dateFmt="yyyy-MM-dd HH:mm" readonly="true"/>
    <a class="inputDateButton" href="javascript:;">选择</a>
    <span class="info">格式：yyyy-MM-dd HH:mm</span>
</p>
                        ';
                    break;
                    case 'select':
                        $tmp_html .= '
<p>
    <label>'.$request['ad_form_elem_ch_title'][$k].'：</label>
    {T_createSelectHtml($'.$request['ad_form_elem_form_name'][$k].', "'.$request['ad_form_elem_form_name'][$k].'", 2)}
</p>
                        ';
                    break;
                    case 'checkbox':
                        $tmp_html .= '
<div class="divider"></div>
<p class="nowrap">
    <label>'.$request['ad_form_elem_ch_title'][$k].'：</label>
    {foreach $types as $key=>$val}
    <input type="checkbox" name="'.$request['ad_form_elem_form_name'][$k].'[]" value="{$key}" />{$val}&nbsp;&nbsp;&nbsp;&nbsp;
    {/foreach}
</p>
<div class="divider"></div>
                        ';
                    break;
                    case 'textarea':
                        $tmp_html .= '
<div class="divider"></div>
<p class="nowrap">
    <label>'.$request['ad_form_elem_ch_title'][$k].'：</label>
    <textarea name="'.$request['ad_form_elem_form_name'][$k].'" cols="80" rows="2"></textarea>
</p>
<div class="divider"></div>
                        ';
                    break;
                    case 'textarea-editor':
                        $tmp_html .= '

                        ';
                    break;
                    case 'file':
                        $tmp_html .= '
<div class="divider"></div>
<p class="nowrap">
    <label>上传单个文件：</label>

    <div class="upload-wrap">
        <input type="file" name="pic[]" accept="image/*" class="valid" style="left: 0px;">
        <div class="thumbnail">
            <img src="themes/default/images/wx.png" style="max-width: 80px; max-height: 80px">
            <a class="del-icon" href="demo/common/ajaxDone.html"></a>
        </div>
    </div>
</p>
<div class="divider"></div>
                        ';
                    break;
                    case 'file-mul':
                        $tmp_html .= '
<div class="divider"></div>
<p class="nowrap">
    <label>上传多个文件：</label>
    <ul id="upload-preview" class="upload-preview"></ul>
    <div class="upload-wrap" rel="#upload-preview">
        <input type="file" name="file2" accept="image/*" multiple="multiple">
    </div>
</p>
<div class="divider"></div>
                        ';
                    break;
                }
            }
        
            $templ_ad_html = '
<div class="pageContent">
	<form method="post" action="{$url.adh}" class="pageForm required-validate" onsubmit="return validateCallback(this, navTabAjaxDone);">
        <div class="pageFormContent" layoutH="56">
            '.$tmp_html.'
		</div>
		<div class="formBar">
			<ul>
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit">保存</button></div></div></li>
				<li>
					<div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div>
				</li>
			</ul>
		</div>
	</form>
</div>
        ';
        }

        return $templ_ad_html;
    }

    protected function controller_ad($request){
    
        $templ_ad_url_info = $this->handler_get_jump_url('添加页');
        $display_template = strtolower($request['controller_name']) . '/'.$templ_ad_url_info['index'].'.tpl';

        $templ = '
        public function '.$templ_ad_url_info['index'].'(){ 

            $this->assign($this->_datas);

            $this->display(\''.$display_template.'\');
        }
        ';

        return $templ;

        /*E
        最终形成：
        public function ad(){ 

            $this->assign($this->_datas);

            $this->display('Chifan/ad.tpl');
        }
        */
    }

    protected function search_td($form_name, $form_type, $save_key_val, $ch_title=''){

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
                $td_html .= '<option value="">'.$ch_title.'</option>' . PHP_EOL;
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
                $td_html .= '<option value="">'.$ch_title.'</option>' . PHP_EOL;
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
                $templ_form_action['index'] = $v['index'];
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
            
                if( $request['list_search_form_type'][$k]=='select'||$request['list_search_form_type'][$k]=='radio' ){
                    $templ_search_td .= '<td>';
                }else{
                    $templ_search_td .= '<td>'.$ch_title.'：';
                }
                $templ_search_td .= $this->search_td($request['list_search_form_name'][$k], $request['list_search_form_type'][$k], $this->save_key_val, $ch_title);
                $templ_search_td .= '</td>';
                
            }

            $search_html = '
<div class="pageHeader">
    <form onsubmit="return navTabSearch(this);" action="'.$templ_form_action['url'].'" method="get" onreset="$(this).find(\'select.combox\').comboxReset()">
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
            <form onsubmit="return navTabSearch(this);" action="{$url.index}" method="get" onreset="$(this).find('select.combox').comboxReset()">
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
                <li><a class="edit" href="{$url.upd.url}?id={ldelim}sid_{$navTab}}" target="navTab"  rel="{$url.upd.rel}"><span>修改菜品</span></a></li>
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
        <form id="pagerForm" method="get" action="'.$templ_form_action['url'].'">
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
        <form id="pagerForm" method="get" action="{$url.index}">
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
        $templ_index_url_info = $this->handler_get_jump_url('列表页');
        $display_template = strtolower($request['controller_name']) . '/'.$templ_index_url_info['index'].'.tpl';
        /*E
        最终形成：User/index.tpl
        */
    
        #列表页方法模板合成
        $templ = '
        public function '.$templ_index_url_info['index'].'(){ 

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
            handler_init_special_fields($this->_init);
            //扔进模板
            $this->_datas = $this->_init;
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

                $str_init_index_mustShow = '
                    $this->_datas[\'mustShow\'] = [
                        '.implode(','.PHP_EOL, $init_index_mustShow).'
                    ];
                ';
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
        #将前面功能使用后记录下的，但本次功能却不需要用到的数据清空，避免前面产生的数据对本次功能产生影响
        // $this->handler_save_url = [];

        $init_ad = '';
        if( in_array('1', $request['major_acts']) ){//1表示添加页
        
            #添加页所需要的链接
            $str_init_ad_url = $this->get_construct_url_html($request['ad_url_plat'], $request['ad_url_mod'], $request['ad_url_act'], $request['ad_url_name'], $request['ad_url_descr_name'], $request['ad_url_navtab'], $request['navtab']);

            if( !empty($str_init_ad_url) ){
                $init_ad .= '
                if(ACT==\'ad\'){
                    '.$str_init_ad_url.'
                }
                ';
            }
        }
        /*E
        最终形成：
        if(ACT=='ad'){
            $this->_datas['url'] = [
                'adh' => L(PLAT, MOD, 'adh')
            ];
        }
        */

        //init_adh
        $init_adh = '';
        if( in_array('1', $request['major_acts']) ){//1表示添加页
        
            $tmp_elem = [];
            foreach( $request['ad_form_elem_name'] as $k=>$v){
            
                $tmp_elem[$k] = "'" . $v . "'=>['ch'=>'".$request['ad_form_elem_ch_title'][$k]."'";
                #rule
                if( !empty($request['ad_form_elem_rule'][$k]) ){

                    $tmp_elem[$k] .= ", 'rule'=>'".$request['ad_form_elem_rule'][$k]."'";
                }
                #rule msg
                $tmp_arr_rule_msg = [];
                // required:xxx必须填写！||mul-int|>|<:xx值必须在0到9之间
                if( !empty($request['ad_form_elem_rule_msg'][$k]) ){
                
                    ##是否有||
                    $tmp_is_multi_rule = 0;
                    if(strpos($request['ad_form_elem_rule_msg'][$k], '||')){
                        $tmp_is_multi_rule = 1;
                    }

                    if( $tmp_is_multi_rule ){//多规则
                    
                        // ['required:xxx必须填写！', 'mul-int|>|<:xx值必须在0到9之间']
                        $tmp_arr = explode('||', $request['ad_form_elem_rule_msg'][$k]);

                        foreach( $tmp_arr as $k1=>$v1){
                            
                            $tmp_arr_msg = explode(':', $v1);
                            $tmp_arr_rule_msg[] = "'".$tmp_arr_msg[0]."'=>'".$tmp_arr_msg[1]."'";//最终得到：//'required'=> 'xxx必须填写！'
                        }
                        

                    }else{//单规则
                        $tmp_arr_msg = explode(':', $request['ad_form_elem_rule_msg'][$k]);
                        $tmp_arr_rule_msg[] = "'".$tmp_arr_msg[0]."'=>'".$tmp_arr_msg[1]."'";//最终得到：//'required'=> 'xxx必须填写！'
                    }
                }

                if( !empty($tmp_arr_rule_msg) ){

                    $tmp_elem[$k] .= ", 'msg'=>[" . implode(','.PHP_EOL, $tmp_arr_rule_msg) . "]" . PHP_EOL;
                }

                $tmp_elem[$k] .= "]";
            }

            if(!empty($tmp_elem)){

                $init_adh .= '
                if(ACT==\'adh\'){
                    $this->_extra[\'form-elems\'] = [
                    '.implode(','.PHP_EOL, $tmp_elem).'
                    ];
                }
                ';
            }
        }

        /*E
        最终形成：
        if(ACT=='adh'){
            $this->_extra['form-elems'] = [
                'cai' => ['ch'=>'菜品', 'rule'=>'required'], 
                'food_types' => ['ch'=>'食物类型', 'rule'=>'required||mul-int|>:0|<:9', 'msg'=>[
                    'required'=> 'xxx必须填写！',
                    'mul-int'=> 'xxx所有值必须为数字！',
                    // 'mul-int|>'=> 'xxx所有的值都不能小于0！',//单纯只有min规则时
                    // 'mul-int|<'=> 'xxx所有的值都不能大于9！',//单纯只有max规则时
                    'mul-int|>|<'=> 'xxx所有的值都需要在0~9之间！',//min和max同时存在时
                ]], 
                'types' => ['ch'=>'适用场景', 'rule'=>'required||int|>=:0'],
                'taste' => ['ch'=>'口味'], 
                'mouthfeel' => ['ch'=>'口感']
            ];
        }


        单独规则：required  email  cell  phone
        主：int  mul-int  regex
        副：>:0  >=:0  <:10  <=:10  =:6  @:正则规则

        互斥项：int与mul-int互斥

        使用方法：
        1) 多重规则使用"||"连接，主副规则使用"|"连接，如： required||int|>:0|<=:10||regex|@:\d
        2) 单独规则与主规则除了regex外，均可独立使用，regex必须配合副规则同时使用；


        //rule:  required  int  int:min0:max10   int:min0  int:max10   int:regex@xxx  mul-int  mul-int:min0:max10  mul-int:max10  mul-int:min0  mul-mixd   mul-mixd:regex@xxx   regex@xxx
        rule:  required  int  int|min:0  int|max:10  int|min:0|max:10  mul-int  mul-int|min:0  mul-int|max:10  mul-int|min:0|max:10  maxlength:10  regex@xxxx   
        */

        //init_upd
        $init_upd = '';
        if( in_array('2', $request['major_acts']) ){//2表示编辑页
        
        }

        //init_updh
        $init_updh = '';
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
            '.$init_adh.'
            '.$init_upd.'
            '.$init_updh.'
    
            $this->_datas[\'navTab\'] = $this->_navTab;
        }
        ';

        return $templ;
    }

    public function robot_get_notice(){


        $request =$this->_requ->all();

        if( $request['type']==1 ){//字段数据过滤规则
        
            echo '
<textarea style="width:95%;height:200px">
单独规则：required  email  cell  phone
主：int  mul-int  regex
副：>:0  >=:0  <:10  <=:10  =:6  @:正则规则

互斥项：int与mul-int互斥

使用方法：
1) 多重规则使用"||"连接，主副规则使用"|"连接，如： required||int|>:0|<=:10||regex|@:\d
2) 单独规则与主规则除了regex外，均可独立使用，regex必须配合副规则同时使用；

最终形成：
$this->_extra"form-elems"] = [
    "cai" => ["ch"=>"菜品", "rule"=>"required"], 
    "food_types" => ["ch"=>"食物类型", "rule"=>"required||mul-int|>:0|<:9", "msg"=>[
        "required"=> "xxx必须填写！",
        "mul-int"=> "xxx所有值必须为数字！",
        // "mul-int|>"=> "xxx所有的值都不能小于0！",//单纯只有min规则时
        // "mul-int|<"=> "xxx所有的值都不能大于9！",//单纯只有max规则时
        "mul-int|>|<"=> "xxx所有的值都需要在0~9之间！",//min和max同时存在时
    ]], 
    "types" => ["ch"=>"适用场景", "rule"=>"required||int|>=:0"],
    "taste" => ["ch"=>"口味"], 
    "mouthfeel" => ["ch"=>"口感"]
];
</textarea>
            ';
        }elseif( $request['type']==2 ) {
            echo '
<textarea style="width:95%;height:200px">
提示信息格式：主规则|副规则:提示信息||主规则|副规则:提示信息
如：required:xxx必须填写||int|>:xxx不能小于n!
</textarea>          
            ';
        }


    }

    protected function get_construct_url_html($url_plat, $url_mod, $url_act, $url_name, $url_descr_name, $url_navtab, $navtab_main){
    
        $init_ad_url = [];
        foreach( $url_plat as $k=>$plat){

            $tmp_plat = ($plat==='PLAT') ? $plat : '\''.$plat.'\'';//不等于PLAT则需要加上引号
            $tmp_mod = ($url_mod[$k]==='MOD') ? $url_mod[$k] : '\''.$url_mod[$k].'\'';//不等于MOD则需要加上引号
            $tmp_act = '\''.$url_act[$k].'\'';
            
            #额外记录下链接相关信息，供之后的处理功能使用
            $tmp_handler_save_url_key = count($this->handler_save_url)+1;
            $this->handler_save_url[$tmp_handler_save_url_key]['ch_name'] = $url_name[$k];
            $this->handler_save_url[$tmp_handler_save_url_key]['descr_name'] = $url_descr_name[$k];
            $this->handler_save_url[$tmp_handler_save_url_key]['index'] = $url_act[$k];

            if( !empty($url_navtab[$k]) ){//跳转链接项若是填写了navtab则需要额外包含navtab
                
                if( $url_navtab[$k]==='default' ){//default则给默认

                    $init_ad_url[] = $tmp_act.' => [\'url\'=>L('.$tmp_plat.', '.$tmp_mod.', '.$tmp_act.'), \'rel\'=>\''.$navtab_main.'_'.$url_act[$k].'\']';

                    $this->handler_save_url[$tmp_handler_save_url_key]['navtab'] = $navtab_main.'_'.$url_act[$k];
                }else {//非default则直接使用

                    $init_ad_url[] = $tmp_act.' => [\'url\'=>L('.$tmp_plat.', '.$tmp_mod.', '.$tmp_act.'), \'rel\'=>\''.$url_navtab[$k].'\']';

                    $this->handler_save_url[$tmp_handler_save_url_key]['navtab'] = $url_navtab[$k];
                }
                
            }else{
                $init_ad_url[] = $tmp_act.' => [\'url\'=>L('.$tmp_plat.', '.$tmp_mod.', '.$tmp_act.')]';
            }
        }
            
        $str_init_url = '';
        if( !empty($init_ad_url) ){

            $str_init_url = '
                $this->_datas[\'url\'] = [
                    '.implode(','.PHP_EOL, $init_ad_url).'
                ];
            ';
        }

        return $str_init_url;
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
            
            // $enumHtml = T_createSelectHtml($this->_datas['field_list_form_type'], $request['name'].'[]', 2);
        }elseif ( $request['type']==4 ) {
            
            $enumHtml = T_createSelectHtml($this->_datas['list_search_form_type'], $request['name'].'[]', 2);
        }elseif ( $request['type']==5 ) {
            
            $enumHtml = T_createSelectHtml($this->_datas['list_url_acts'], $request['name'].'[]', 1);
        }elseif ($request['type']==6) {
            
            $enumHtml = T_createSelectHtml($this->_datas['ad_or_upd_form_type'], $request['name'], 1);
        }

        echo $enumHtml;
    }

}      
