<div class="pageContent">
<form method="post" action="{$url.adh}" class="pageForm required-validate" onsubmit="return validateCallback(this, navTabAjaxDone);">
	<div class="pageFormContent" layoutH="57">
		<dl class="nowrap">
			<dt>控制器名称：</dt>
			<dd>
				<input type="text" maxlength="20" name="controller_name" value="" class="required" />
				<span class="info">如"UserController.class.php"的"User"即可</span>
			</dd>
		</dl>
		<dl class="nowrap">
			<dt>主navtab：</dt>
			<dd>
				<input type="text" maxlength="20" name="navtab" value="" class="required" />
				<span class="info">如"User_add"的"User"即可，一般与控制器名保持统一</span>
			</dd>
		</dl>

<script>
$('input[name="controller_name"]').keyup(function(){
	$('input[name="navtab"]').val($(this).val());
	$('input[name="list_tpl_name"]').val($(this).val()+'/index.tpl');//列表页模板文件名
});
</script>

		<dl class="nowrap">
			<dt>生成页面：</dt>
			<dd class="Robot_major_acts">
				{foreach $major_acts as $key=>$val}
				<input type="checkbox" name="major_acts[]" value="{$key}" />{$val}&nbsp;&nbsp;&nbsp;&nbsp;
				{/foreach}
			</dd>
		</dl>
		
		<dl class="nowrap">
			<dt><strong>表数据值对文案：</strong></dt>
			<dd>
				<!--<a class="button key_val_add" onclick="key_val_add_f()"><span>添加值对字段</span></a>-->
			</dd>
		</dl>

		<div class="divider"></div>

		<table class="list nowrap itemDetail" addButton="添加值对字段" width="100%">
			<thead>
				<tr>
					<th type="lookup" name="robot_key_val.en_name[]" lookupGroup="robot_key_val" lookupUrl="{$url.kvLookup}" size="12">字段名称</th>
					<th type="text" name="robot_key_val.ori_key_val[]" size="130">字段值对信息</th>
					<th type="del" width="60">操作</th>
				</tr>
			</thead>
			<tbody>
				<tr class="unitBox">
					<td>
						<input type="text" name="robot_key_val.en_name[]" size="12">
						<a class="btnLook" href="{$url.kvLookup}" lookupgroup="robot_key_val">查找带回</a>
					</td>
					<td><input type="text" name="robot_key_val.ori_key_val[]" size="130"></td>
					<td><a href="javascript:void(0)" class="btnDel ">删除</a></td>
				</tr>
			</tbody>
		</table>

		<div class="divider"></div>

		<dl class="nowrap">
			<dt><strong>操作字段：</strong></dt>
			<dd>
				<!--<a class="button key_val_add" onclick="key_val_add_f()"><span>添加值对字段</span></a>-->
			</dd>
		</dl>

		{* <table class="list nowrap field_list itemDetail" addButton="添加值对字段"width="100%"> *}
		<table class="list nowrap field_list" width="100%">
			<thead>
				<tr id="hder">
					<th type="text" name="field_list_ch_name[]" size="24">中文名</th>
					<th type="text" name="field_list_en_name[]" size="24">英文名</th>
					<th type="enum" name="field_list_is_mustShow[]" enumUrl="{L(PLAT, MOD, 'enum')}&type=1&name=field_list_is_mustShow" size="12">是否列表必显</th>
					<th type="enum" name="field_list_is_search[]" enumUrl="{L(PLAT, MOD, 'enum')}&type=1&name=field_list_is_search" size="12">是否为搜索条件</th>
					<th type="enum" name="field_list_is_add[]" enumUrl="{L(PLAT, MOD, 'enum')}&type=1&name=field_list_is_add" size="12">是否可添加</th>
					<th type="enum" name="field_list_is_upd[]" enumUrl="{L(PLAT, MOD, 'enum')}&type=1&name=field_list_is_upd" size="12">是否可编辑</th>
					<th type="enum" name="field_list_form_type[]" enumUrl="{L(PLAT, MOD, 'enum')}&type=3&name=field_list_form_type" size="12" type="text" name="field_list_form_type[]" size="12">表单类型</th>
					<th type="del" width="60">操作</th>
				</tr>
			</thead>
			<tbody>
				<tr class="unitBox">
					<td><input type="text" name="field_list_ch_name[]" size="24"></td>
					<td><input type="text" name="field_list_en_name[]" size="24"></td>
					<td>{T_createSelectHtml(['否', '是'], 'field_list_is_mustShow[]', 2)}</td>
					<td>{T_createSelectHtml(['否', '是'], 'field_list_is_search[]', 2)}</td>
					<td>{T_createSelectHtml(['否', '是'], 'field_list_is_add[]', 2)}</td>
					<td>{T_createSelectHtml(['否', '是'], 'field_list_is_upd[]', 2)}</td>
					<td>{T_createSelectHtml($field_list_form_type, 'field_list_form_type[]', 2)}</td>
					<td><a href="javascript:void(0)" class="btnDel ">删除</a></td>
				</tr>
			</tbody>
		</table>

		<div class="divider"></div>

		<div class="tabs" currentIndex="0" eventType="click">
			<div class="tabsHeader">
				<div class="tabsHeaderContent">
					<ul class="Robot_major_acts_tab">
						{foreach $major_acts as $major_acts_k=>$major_acts_val}
							<li class="{if $major_acts_k==0}selected{/if} Robot_major_acts_tab_{$major_acts_k}"><a href="javascript:void(0)"><span>{$major_acts_val}</span></a></li>
						{/foreach}
					</ul>
				</div>
			</div>
			<div class="tabsContent">
				{foreach $major_acts as $major_acts_k=>$major_acts_val}
				{if $major_acts_val==='列表页'}
				<div class="Robot_major_acts_info_{$major_acts_k}">
					<dl class="nowrap">
						<dt>操作主表：</dt>
						<dd>
							<a class="btnLook" href="{$url.tbLookup}" lookupGroup="robot_tb_record">查找带回</a>
							{* <input name="list_major_table" type="text" value=""/> *}
							<input name="robot_tb_record.en_name" type="text"/>
							<input name="robot_tb_record.ch_fields" type="hidden"/>
							<input name="robot_tb_record.en_fields" type="hidden"/>
							<span class="info">可以连带设置别名，如"User as u"</span>
						</dd>
					</dl>
					<dl class="nowrap">
						<dt>主表连带操作：</dt>
						<dd>
							<a class="button robot_field_list" href="javascript:;" onclick="robot_field_list()"><span>生成操作字段</span></a>
						</dd>
					</dl>
					<dl class="nowrap">
						<dt>是否连表：</dt>
						<dd>
							{T_createSelectHtml(['否', '是'], 'list_is_leftjoin', 2)}
						</dd>
					</dl>

					<dl class="nowrap">
						<dt><strong>连表信息：</strong></dt>
						<dd>
							<!-- <input type="text" maxlength="100" name="list_leftjoin_table" value="" style="width:75%" readonly />
							<span class="info"></span> -->
						</dd>
					</dl>

					<div class="divider"></div>

					<table class="list nowrap itemDetail" addButton="添加连接的表" width="100%">
						<thead>
							<tr>
								<th type="lookup" name="leftjoin_tb_name.en_name[]" lookupGroup="leftjoin_tb_name" lookupUrl="{$url.tbLookup}" size="24">表英文名(可以连带设置表别名,如“操作主表”)</th>
								<th type="text" name="leftjoin_condition[]" defaultVal="" size="100">连接条件</th>
								<th type="del" width="60">操作</th>
							</tr>
						</thead>
						<tbody>
							<tr class="unitBox">
								<td>
									<input type="text" name="leftjoin_tb_name.en_name[]" size="24">
									<a class="btnLook" href="{$url.tbLookup}" lookupgroup="leftjoin_tb_name">查找带回</a>
								</td>
								<td><input type="text" name="leftjoin_condition[]" size="100"></td>
								<td><a href="javascript:void(0)" class="btnDel ">删除</a></td>
							</tr>
						</tbody>
					</table>

					<div class="divider"></div>

					<dl class="nowrap">
						<dt>查询字段：</dt>
						<dd>
							<input type="text" name="list_fields" value="*" style="width:75%" />
							<span class="info">当有设置连表时，则必须指定字段所属的表</span>
						</dd>
					</dl>

					<dl class="nowrap">
						<dt>每页显示数据条数：</dt>
						<dd>
							<input type="text" name="list_num_perpage" value="30" style="width:75%" />
							<span class="info">不填写则表示列表页不构建分页</span>
						</dd>
					</dl>

					<dl class="nowrap">
						<dt>初始查询条件：</dt>
						<dd>
							<input type="text" maxlength="60" name="list_search_init" value="is_del:0" style="width:75%" />
							<span class="info">格式样例："is_del:0|id:>:10|name:!=:zhangsan"</span>
						</dd>
					</dl>

					<dl class="nowrap">
						<dt>模板文件名：</dt>
						<dd>
							<input type="text" name="list_tpl_name" value="index.tpl" style="width:75%" />
							<span class="info">1)需要指定目录名;2)默认使用"控制器名/index.tpl"名称</span>
						</dd>
					</dl>

					<div class="divider"></div>

					<table class="list nowrap itemDetail" addButton="初始化列表页所需的跳转链接" width="100%">
						<thead>
							<tr>
								<th type="text" name="list_url_plat[]" defaultVal="PLAT" size="12">平台参数</th>
								<th type="text" name="list_url_mod[]" defaultVal="MOD" size="12">模块参数</th>
								<th type="text" name="list_url_act[]" size="12">动作参数</th>
								<th type="text" name="list_url_navtab[]" size="12" defaultVal="default">本条链接对应的navtab</th>
								<th type="del" width="60">操作</th>
							</tr>
						</thead>
						<tbody>
							{for $i=0 to 3}
							<tr class="unitBox">
								<td><input type="text" name="list_url_plat[]" value="PLAT" size="12"></td>
								<td><input type="text" name="list_url_mod[]" value="MOD" size="12"></td>
								<td><input type="text" name="list_url_act[]" value="{$list_url_acts[$i]}" size="12"></td>
								<td><input type="text" name="list_url_navtab[]" value="default" size="12"></td>
								<td><a href="javascript:void(0)" class="btnDel ">删除</a></td>
							</tr>
							{/for}
						</tbody>
					</table>

					<div class="divider"></div>
					
					<table class="list nowrap itemDetail add_list_mustShow" addButton="新增必显字段" width="100%">
						<thead>
							<tr>
								<th type="text" name="list_must_show_ch[]" size="24">中文字段名</th>
								<th type="text" name="list_must_show_en[]" size="24">英文字段名</th>
								<th type="text" name="list_must_show_width[]" defaultVal="70" size="12">列显示宽度</th>
								<th type="enum" name="list_must_show_is_set[]" enumUrl="{L(PLAT, MOD, 'enum')}&type=1&name=list_must_show_is_set" size="12">是否为集合类型字段(如："1,2,4,7")</th>
								<th type="del" width="60">操作</th>
							</tr>
						</thead>
						<tbody>
							<tr class="unitBox">
								<td>
									<input type="text" name="list_must_show_ch[]" size="24">
								</td>
								<td><input type="text" name="list_must_show_en[]" size="24"></td>
								<td><input type="text" name="list_must_show_width[]" size="12" value="70"></td>
								<td>{T_createSelectHtml(['否', '是'], 'list_must_show_is_set[]', 2)}</td>
								<td><a href="javascript:void(0)" class="btnDel ">删除</a></td>
							</tr>
						</tbody>
					</table>

					<div class="divider"></div>

					<dl class="nowrap">
						<dt>列表页是否包含搜索：</dt>
						<dd>
							{T_createSelectHtml(['否', '是'], 'list_is_has_search', 2, 1)}
						</dd>
					</dl>

					<div class="divider"></div>

					<table class="list nowrap itemDetail add_list_search" addButton="添加搜索查询条件" width="100%">
						<thead>
							<tr>
								<th type="text" name="list_search_name[]" size="12">字段英文名</th>
								<th type="text" name="list_search_form_name[]" size="12">表单name值（通常与英文名相同）</th>
								<th type="enum" name="list_search_form_type[]" enumUrl="{L(PLAT, MOD, 'enum')}&type=4&name=list_search_form_type" size="12">表单类型</th>
								<th type="enum" name="list_search_rule[]" enumUrl="{L(PLAT, MOD, 'enum')}&type=2&name=list_search_rule" size="12">条件拼接规则</th>
								<th type="del" width="60">操作</th>
							</tr>
						</thead>
						<tbody>
							<tr class="unitBox">
								<td><input type="text" name="list_search_name[]" value="" size="12" maxlength="30"></td>
								<td><input type="text" name="list_search_form_name[]" value="" size="12" maxlength="30"></td>
								<td>{T_createSelectHtml($list_search_form_type, 'list_search_form_type[]', 2)}</td>
								<td>{T_createSelectHtml($list_search_rule, 'list_search_rule[]', 2)}</td>
								<td><a href="javascript:void(0)" class="btnDel ">删除</a></td>
							</tr>
						</tbody>
					</table>
				</div>
				{elseif $major_acts_val==='添加页'}
				<div class="Robot_major_acts_info_{$major_acts_k}">
					<dl class="nowrap">
						<dt>模板文件名：</dt>
						<dd>
							<input type="text" name="add_tpl_name" value="" style="width:75%" />
							<span class="info">不填写则表示使用默认的"控制器名/ad.tpl"名称</span>
						</dd>
					</dl>

					<div class="divider"></div>

					<table class="list nowrap itemDetail" addButton="初始化添加页所需的跳转链接" width="100%">
						<thead>
							<tr>
								<th type="text" name="add_url_plat[]" defaultVal="PLAT" size="12">平台参数</th>
								<th type="text" name="add_url_mod[]" defaultVal="MOD" size="12">模块参数</th>
								<th type="text" name="add_url_act[]" size="12">动作参数</th>
								<th type="text" name="add_url_navtab[]" size="12">本条链接对应的navtab</th>
								<th type="del" width="60">操作</th>
							</tr>
						</thead>
						<tbody>
							<tr class="unitBox">
								<td><input type="text" name="add_url_plat[]" value="PLAT" size="12"></td>
								<td><input type="text" name="add_url_mod[]" value="MOD" size="12"></td>
								<td><input type="text" name="add_url_act[]" value="adh" size="12"></td>
								<td><input type="text" name="add_url_navtab[]" value="" size="12"></td>
								<td><a href="javascript:void(0)" class="btnDel ">删除</a></td>
							</tr>
						</tbody>
					</table>

					<div class="divider"></div>

					{* <dl class="nowrap">
						<dt>列表页是否包含删除功能：</dt>
						<dd>
							{T_createSelectHtml(['否', '是'], 'list_is_has_delete', 2, 1)}
						</dd>
					</dl> *}

					<dl class="nowrap">
						<dt>删除方式：</dt>
						<dd>
							{T_createSelectHtml(['更新is_del字段', '直接删除数据'], 'delete_type', 2)}
						</dd>
					</dl>

					<dl class="nowrap">
						<dt>额外扩充的删除条件：</dt>
						<dd>
							<input type="text" name="delete_extra_condition" value="" style="width:75%" />
							<span class="info">表示在默认删除条件基础上扩充的删除条件</span>
						</dd>
					</dl>
				</div>
				{elseif $major_acts_val==='编辑页'}
				<div>

				</div>
				{elseif $major_acts_val==='模型'}
				<div>

				</div>
				{/if}
				{/foreach}
			</div>
			<div class="tabsFooter">
				<div class="tabsFooterContent"></div>
			</div>
		</div>

	</div>
	<div class="formBar">
		<ul>
			<li><div class="buttonActive"><div class="buttonContent"><button type="submit">保存</button></div></div></li>
			<li><div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div></li>
		</ul>
	</div>
</form>
</div>

<script>
//初始化
var Robot_init = function (){

	$('.Robot_major_acts').find('input').each(function(i){

		if(i==0){ //列表页 按钮选中；同时相关的tab要显示
			$($('.Robot_major_acts').find('input')[i]).prop("checked",true);
			$('.Robot_major_acts_tab_'+i).show();
			$('.Robot_major_acts_info_'+i).show();
		}else{ //其它按钮都不选中；同时相关的tab要隐藏
			$($('.Robot_major_acts').find('input')[i]).prop("checked",false);
			$('.Robot_major_acts_tab_'+i).hide();
			$('.Robot_major_acts_info_'+i).hide();
		}
	});
};

Robot_init();

var has_selected = true;//当前tab被关闭后，是否有tab没有关闭的；false表示所有都关了，true表示还有没关的
//生成页面 选项点击事件
$('.Robot_major_acts').find('input').click(function(){

	//console.log($(this).is(":checked"));
	//console.log($(this).val());

	var this_index = parseInt($(this).val());
	var this_tab = '.Robot_major_acts_tab_'+this_index;//比如：Robot_major_acts_tab_0表示第一个选项对应的tab 的class名
	var this_tab_info = '.Robot_major_acts_info_'+this_index;//比如：Robot_major_info_tab_0表示第一个选项对应的tab info 的class名

	if($(this).is(":checked")){

		$(this_tab).show();
		
		if(!has_selected){
			$(this_tab_info).show();
			$(this_tab).addClass('selected');
			has_selected = true;
		}
	}else{

		var this_is_selected = false;//当前这个按钮对应的tab是否是 当前显示的项
		if($(this_tab).hasClass('selected')){
			this_is_selected = true;
		}

		//当前这个 按钮 相关的tab和tab info隐藏
		$(this_tab).hide();
		$(this_tab_info).hide();

		if(this_is_selected){ //如果关闭的是当前显示的项，则需要将未关闭的项中的第一项打开

			has_selected = false;//当前tab被关闭后，是否有tab没有关闭的；false表示所有都关了，true表示还有没关的
			$('.Robot_major_acts').find('input').each(function(i){

				if($(this).is(":checked")){ //第一个还被选中的显示出来

					has_selected = true;
					$($('.Robot_major_acts_tab').find('li')[i]).addClass('selected');
					$($('.Robot_major_acts_tab').find('li')[i]).siblings().removeClass('selected');//已经有一个被选中了，其它的都取消选中
					$('.Robot_major_acts_info_'+i).show();
					return false;
				}
			});

			if(!has_selected){ //如果tab已经全部关闭了，则移除所有的selected
				$('.Robot_major_acts_tab').find('li').siblings().removeClass('selected');
			}
		}
	}
});

//生成操作字段列表
var robot_field_list = function (){

	$('.field_list').find('tbody').html('');

	var ch_fields = $('input[name="robot_tb_record.ch_fields"]').val().split(',');
	var en_fields = $('input[name="robot_tb_record.en_fields"]').val().split(',');

	var tr_html = '';
	for( var i in ch_fields ){
		tr_html += '<tr class="unitBox">';
		tr_html += '<td><input type="text" name="field_list_ch_name[]" size="24" value="'+ch_fields[i]+'"></td>';
		tr_html += '<td><input type="text" name="field_list_en_name[]" size="24" value="'+en_fields[i]+'"></td>';
		tr_html += '<td>{T_createSelectHtml(["否", "是"], "field_list_is_mustShow[]", 2)}</td>';
		tr_html += '<td>{T_createSelectHtml(["否", "是"], "field_list_is_search[]", 2)}</td>';
		tr_html += '<td>{T_createSelectHtml(["否", "是"], "field_list_is_add[]", 2)}</td>';
		tr_html += '<td>{T_createSelectHtml(["否", "是"], "field_list_is_upd[]", 2)}</td>';
		tr_html += '<td>{T_createSelectHtml($field_list_form_type, "field_list_form_type[]", 2)}</td>';
		tr_html += '<td><a href="javascript:void(0)" class="btnDel ">删除</a></td>';
		tr_html += '</tr>';
	}

	$('.field_list').find('tbody').append(tr_html);
	$('select[name="field_list_is_mustShow[]"]').bind('change', field_list_is_mustShow);
	$('select[name="field_list_is_search[]"]').bind('change', field_list_is_search);

	doChangeColorOfRow(".field_list tr:even:not(.hder)", ".field_list tr:odd:not(.hder)");
};

//设置搜索字段
var field_list_is_search = function(){

	//当前选中行的数据
	var en_name = $(this).parents('tr').find('input[name="field_list_en_name[]"]').val();

	//清掉没有内容的tr
	$('.add_list_search').find('tbody tr').each(function(i){

		var en = $(this).find('input[name="list_search_name[]"]').val();

		if(en===''){
			$(this).find('.btnDel').click();
		}
	});

	if( $(this).val()==='1' ){ //选择了“是”

		//查找是否已经存在一样的数据，如果存在则不再额外增加
		var is_has = false;
		$('.add_list_search').find('tbody tr').each(function(i){

			var en = $(this).find('input[name="list_search_name[]"]').val();
			if(en===en_name){
				is_has = true;
				return false;
			}
		});

		if(!is_has){ //不存在相同的，才增加一条

			//新增一条tr
			$('.add_list_search').prev().prev().find('button').click();

			//给新增的tr填充数据
			$('.add_list_search').find('tbody tr').last().find('input[name="list_search_name[]"]').val(en_name);
		}
		

	}else if( $(this).val()==='0' ){ //选择了“否”
		
		//删除与当前内容一致的行
		$('.add_list_search').find('tbody tr').each(function(i){

			var en = $(this).find('input[name="list_search_name[]"]').val();

			if(en===en_name){
				$(this).find('.btnDel').click();
				return false;
			}
		});
	}
};

//设置必显字段
var field_list_is_mustShow = function(){

	//当前选中行的数据
	var ch_name = $(this).parents('tr').find('input[name="field_list_ch_name[]"]').val();
	var en_name = $(this).parents('tr').find('input[name="field_list_en_name[]"]').val();

	//清掉没有内容的tr
	//console.log($($('.add_list_mustShow').find('tbody tr')[0]).find('input[name="list_must_show_ch[]"]').val()==='');
	$('.add_list_mustShow').find('tbody tr').each(function(i){

		var ch = $(this).find('input[name="list_must_show_ch[]"]').val();
		var en = $(this).find('input[name="list_must_show_en[]"]').val();

		if(ch===''&&en===''){
			$(this).find('.btnDel').click();
		}
	});

	if( $(this).val()==='1' ){ //选择了“是”

		//查找是否已经存在一样的数据，如果存在则不再额外增加
		var is_has = false;
		$('.add_list_mustShow').find('tbody tr').each(function(i){

			var ch = $(this).find('input[name="list_must_show_ch[]"]').val();
			var en = $(this).find('input[name="list_must_show_en[]"]').val();

			if(ch===ch_name&&en===en_name){
				is_has = true;
				return false;
			}
		});

		if(!is_has){
			//新增一条tr
			$('.add_list_mustShow').prev().prev().find('button').click();

			//给新增的tr填充数据
			$('.add_list_mustShow').find('tbody tr').last().find('input[name="list_must_show_ch[]"]').val(ch_name);
			$('.add_list_mustShow').find('tbody tr').last().find('input[name="list_must_show_en[]"]').val(en_name);
		}

	}else if( $(this).val()==='0' ){ //选择了“否”
		
		//删除与当前内容一致的行
		$('.add_list_mustShow').find('tbody tr').each(function(i){

			var ch = $(this).find('input[name="list_must_show_ch[]"]').val();
			var en = $(this).find('input[name="list_must_show_en[]"]').val();

			if(ch===ch_name&&en===en_name){
				$(this).find('.btnDel').click();
				return false;
			}
		});
	}
};

var clear_tr_no_content = function (table, type){

	//if(type==1)
}
</script>
