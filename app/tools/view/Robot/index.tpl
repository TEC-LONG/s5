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
});
</script>

		<dl class="nowrap">
			<dt>生成页面：</dt>
			<dd>
				{foreach $major_acts as $key=>$val}
				<input type="checkbox" name="major_acts[]" value="{$key}" />{$val}&nbsp;&nbsp;&nbsp;&nbsp;
				{/foreach}
			</dd>
		</dl>
		
		<dl class="nowrap">
			<dt>表数据值对文案：</dt>
			<dd>
				<a class="button key_val_add" onclick="key_val_add_f()"><span>添加值对字段</span></a>
			</dd>
		</dl>

		<div class="divider"></div>

		<table class="table" width="100%">
			<thead>
				<tr>
					<th width="60">字段名称</th>
					<th width="75%">字段值对信息</th>
					<th width="100">操作</th>
				</tr>
			</thead>
			<tbody  class="columArea">
				<tr>
					<td><input type="text" name="names[]" style="width:90%" /></td>
					<td><input type="text" name="key_vals[]" style="width:75%"/></td>
					<td><a class="btnDel key_val_del_f" style="cursor:pointer;" onclick="key_val_del_f(this)">删除</a></td>
				</tr>
			</tbody>
		</table>

<script>
var key_val_num = 1;//填写值对信息的tr个数，初始状态下为1，删除到只剩1个时，不可继续删除
//var tmp_tr = $('.columArea').find('tr');

var key_val_add_f = function(){

	var tmp_tr = '';
	tmp_tr += '<tr>';
	tmp_tr += '<td><input type="text" name="names[]" style="width:90%" /></td>';
	tmp_tr += '<td><input type="text" name="key_vals[]" style="width:75%"/></td>';
	tmp_tr += '<td><a class="btnDel key_val_del_f" style="cursor:pointer;" onclick="key_val_del_f(this)">删除</a></td>';
	tmp_tr += '</tr>';

	$('.columArea').append(tmp_tr);
	key_val_num++;
};

var key_val_del_f = function(a){

	if(key_val_num!=1){
		$(a).parents('tr').remove();
		key_val_num--;
	}
};
</script>

		<div class="divider"></div>

		<div class="tabs" currentIndex="0" eventType="click">
			<div class="tabsHeader">
				<div class="tabsHeaderContent">
					<ul>
						{foreach $major_acts as $major_acts_k=>$major_acts_val}
							<li class="{if $major_acts_k==0}selected{/if} major_acts_{$major_acts_k}"><a href="javascript:void(0)"><span>{$major_acts_val}</span></a></li>
						{/foreach}
					</ul>
				</div>
			</div>
			<div class="tabsContent">
				{foreach $major_acts as $major_acts_k=>$major_acts_val}
				{if $major_acts_val==='列表页'}
				<div>
					<dl class="nowrap">
						<dt>操作主表：</dt>
						<dd>
							<a class="btnLook" href="" lookupGroup="expcat">查找带回</a>
							<input name="list_major_table" type="text"/>
						</dd>
					</dl>

					<dl class="nowrap">
						<dt>是否连表：</dt>
						<dd>
							{T_createSelectHtml(['否', '是'], 'list_is_leftjoin', 2)}
						</dd>
					</dl>

					<dl class="nowrap">
						<dt>连表集合：</dt>
						<dd>
							<input type="text" maxlength="100" name="list_leftjoin_table" value="" style="width:75%" readonly />
							<span class="info"></span>
						</dd>
					</dl>

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
							<input type="text" name="list_num_perpage" value="" style="width:75%" />
							<span class="info">不填写则表示列表页不构建分页</span>
						</dd>
					</dl>

					<dl class="nowrap">
						<dt>初始查询条件：</dt>
						<dd>
							<input type="text" maxlength="60" name="list_search_init" value="is_del:0" style="width:75%" />
							<span class="info"></span>
						</dd>
					</dl>

					<dl class="nowrap">
						<dt>模板文件名：</dt>
						<dd>
							<input type="text" name="list_tpl_name" value="" style="width:75%" />
							<span class="info">不填写则表示使用默认的"index.tpl"名称</span>
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
					
					<table class="list nowrap itemDetail" addButton="新增必显字段" width="100%">
						<thead>
							<tr>
								<th type="text" name="list_must_show_ch[]" size="12">中文字段名</th>
								<th type="text" name="list_must_show_en[]" size="12">英文字段名</th>
								<th type="text" name="list_must_show_width[]" defaultVal="70" size="12">列显示宽度</th>
								<th type="enum" name="list_must_show_is_set[]" enumUrl="{L(PLAT, MOD, 'enum')}&type=1" size="12">是否为集合类型字段(如："1,2,4,7")</th>
								<th type="del" width="60">操作</th>
							</tr>
						</thead>
						<tbody>
							<tr class="unitBox">
								<td><input type="text" name="list_must_show_ch[]" size="12"></td>
								<td><input type="text" name="list_must_show_en[]" size="12"></td>
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

					<table class="list nowrap itemDetail" addButton="添加搜索查询条件" width="100%">
						<thead>
							<tr>
								<th type="text" name="list_search_name[]" size="12">字段名</th>
								<th type="enum" name="list_search_rule[]" enumUrl="{L(PLAT, MOD, 'enum')}&type=2" size="12">条件拼接规则</th>
								<th type="del" width="60">操作</th>
							</tr>
						</thead>
						<tbody>
							<tr class="unitBox">
								<td><input type="text" name="list_search_name[]" value="" size="12" maxlength="30"></td>
								<td>{T_createSelectHtml($list_search_rule, 'list_search_rule[]', 2)}</td>
								<td><a href="javascript:void(0)" class="btnDel ">删除</a></td>
							</tr>
						</tbody>
					</table>

					<div class="divider"></div>

					<dl class="nowrap">
						<dt>列表页是否包含删除功能：</dt>
						<dd>
							{T_createSelectHtml(['否', '是'], 'list_is_has_delete', 2, 1)}
						</dd>
					</dl>

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
				{elseif $major_acts_val==='添加页'}
				<div>
					<dl class="nowrap">
						<dt>模板文件名：</dt>
						<dd>
							<input type="text" name="add_tpl_name" value="" style="width:75%" />
							<span class="info">不填写则表示使用默认的"ad.tpl"名称</span>
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
