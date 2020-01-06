<h2 class="contentTitle"></h2>
<form action="demo/common/ajaxDone.html?navTabId=masterList&callbackType=closeCurrent" method="post" class="pageForm required-validate" onsubmit="return validateCallback(this, navTabAjaxDone)">
<div class="pageContent">
	<div class="pageFormContent" layoutH="97">
		
		<dl class="nowrap">
			<dt>控制器名称：</dt>
			<dd>
				<input type="text" maxlength="20" name="controler_name" value="" class="required" />
				<span class="info">如"UserController.class.php"的"User"即可</span>
			</dd>
		</dl>

		<dl class="nowrap">
			<dt>主navtab：</dt>
			<dd>
				<input type="text" maxlength="20" name="navtab" value="" class="required" />
				<span class="info">如"user_add"的"user"即可</span>
			</dd>
		</dl>

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
				<a class="button key_val_add" onclick="key_val_add_f()"><span>添加字段</span></a>
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
		
		<h3 class="contentTitle">各页面页面参数</h3>
		<div class="tabs">
			<div class="tabsHeader">
				<div class="tabsHeaderContent">
					<ul>
					{foreach $major_acts as $major_acts_k=>$major_acts_val}
						<li class="{if $major_acts_k==0}selected{/if} major_acts_{$major_acts_k}"><a href="javascript:void(0)"><span>{$major_acts_val}</span></a></li>
					{/foreach}
					</ul>
				</div>
			</div>
			{* <div class="tabsContent" style="height: 150px;"> *}
			<div class="tabsContent">
				{foreach $major_acts as $major_acts_k=>$major_acts_val}
				{if $major_acts_val==='列表页'}
				<div>
					<dl class="nowrap">
						<dt>操作主表：</dt>
						<dd>
							<a class="btnLook" href="" lookupGroup="expcat">查找带回</a>
							<input class="required" name="list_major_table" type="text"/>
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
							<input type="text" maxlength="100" name="" value="" style="width:75%" readonly />
							<span class="info"></span>
						</dd>
					</dl>

					<dl class="nowrap">
						<dt>初始查询条件：</dt>
						<dd>
							<input type="text" maxlength="60" name="" value="is_del:0" class="required" style="width:75%" />
							<span class="info"></span>
						</dd>
					</dl>

					<dl class="nowrap">
						<dt>每页显示数据条数：</dt>
						<dd>
							<input type="text" name="" value="" style="width:75%" />
							<span class="info">不填写则表示列表页不构建分页！</span>
						</dd>
					</dl>

					<div class="divider"></div>

					<table class="list nowrap itemDetail" addButton="新增搜索查询条件" width="100%">
						<thead>
							<tr>
								<th type="text" name="items[#index#].itemString" size="12" fieldClass="required" fieldAttrs="{literal}{remote:'validate_remote.html', maxlength:10}{/literal}">字段名</th>
								<th type="text" name="items[#index#].itemInt" defaultVal="#index#" size="12" fieldClass="digits">条件拼接规则</th>
								<th type="del" width="60">操作</th>
							</tr>
						</thead>
						<tbody>
							<tr class="unitBox">
								<td><input type="text" name="items[0].itemString" value="" size="12" class="required" remote="validate_remote.html" maxlength="10"></td>
								<td><input type="text" name="items[0].itemInt" value="1" size="12" class="digits textInput"></td>
								<td><a href="javascript:void(0)" class="btnDel ">删除</a></td>
							</tr>
						</tbody>
					</table>

					<div class="divider"></div>

					<table class="list nowrap itemDetail" addButton="初始化列表页跳转链接" width="100%">
						<thead>
							<tr>
								<th type="text" name="list_url_plat[]" defaultVal="PLAT" size="12">平台参数</th>
								<th type="text" name="list_url_mod[]" defaultVal="MOD" size="12">模块参数</th>
								<th type="text" name="list_url_act[]" size="12">动作参数</th>
								<th type="text" name="list_url_navtab[]" size="12">本条链接对应的navtab</th>
								<th type="del" width="60">操作</th>
							</tr>
						</thead>
						<tbody>
							{for $i=0 to 3}
							<tr class="unitBox">
								<td><input type="text" name="list_url_plat[]" value="PLAT" size="12"></td>
								<td><input type="text" name="list_url_mod[]" value="MOD" size="12"></td>
								<td><input type="text" name="list_url_act[]" value="{$list_url_acts[$i]}" size="12"></td>
								<td><input type="text" name="list_url_navtab[]" value="" size="12"></td>
								<td><a href="javascript:void(0)" class="btnDel ">删除</a></td>
							</tr>
							{/for}
						</tbody>
					</table>

					<div class="divider"></div>
					
					<table class="list nowrap itemDetail" addButton="添加搜索查询条件" width="100%">
						<thead>
							<tr>
								<th type="text" name="list_url_plat[]" defaultVal="PLAT" size="12">字段名</th>
								<th type="text" name="list_url_mod[]" defaultVal="MOD" size="12">规则</th>
								<th type="del" width="60">操作</th>
							</tr>
						</thead>
						<tbody>
							<tr class="unitBox">
								<td><input type="text" name="list_url_plat[]" value="PLAT" size="12"></td>
								<td><input type="text" name="list_url_mod[]" value="MOD" size="12"></td>
								<td><a href="javascript:void(0)" class="btnDel ">删除</a></td>
							</tr>
						</tbody>
					</table>
				</div>
				{/if}
				{/foreach}

				<!-- <div>
					<table class="list nowrap itemDetail" addButton="新建从表2条目" width="100%">
						<thead>
							<tr>
								<th type="text" name="items.itemString[#index#]" size="12" fieldClass="required">从字符串</th>
								<th type="text" name="items.itemInt[#index#]" size="12" fieldClass="digits">从整数</th>
								<th type="text" name="items.itemFloat[#index#]" size="12" fieldClass="number">从浮点</th>
								<th type="date" name="items.itemDate[#index#]" size="12">从日期</th>
								<th type="date" format="yyyy-MM-dd HH:mm:ss" name="items.itemDataTime[#index#]" size="16">从日期时间</th>
								<th type="lookup" name="items.org.orgName[#index#]" lookupGroup="items.org" lookupUrl="demo/database/dwzOrgLookup.html" lookupPk="orgNum" suggestUrl="demo/database/db_lookupSuggest.html" suggestFields="orgNum,orgName" size="12">部门名称</th>
								<th type="enum" name="items.itemEnum[#index#]" enumUrl="demo/database/db_select.html" size="12">从枚举</th>
								<th type="attach" name="items.attachment.fileName[#index#]" lookupGroup="items.attachment" lookupUrl="demo/database/db_attachmentLookup.html" size="12">从附件</th>
								<th type="del" width="60">操作</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
				<div>
					<table class="list nowrap itemDetail" addButton="新建从表3条目" width="100%">
						<thead>
							<tr>
								<th type="text" name="items.itemString[]" size="12" fieldClass="required">从字符串</th>
								<th type="text" name="items.itemInt[]" size="12" fieldClass="digits">从整数</th>
								<th type="text" name="items.itemFloat[]" size="12" fieldClass="number">从浮点</th>
								<th type="date" name="items.itemDate[]" size="12">从日期</th>
								<th type="date" format="yyyy-MM-dd HH:mm:ss" name="items.itemDataTime[]" size="16">从日期时间</th>
								<th type="lookup" name="items.org.orgName[]" lookupGroup="items.org" lookupUrl="demo/database/dwzOrgLookup.html" suggestUrl="demo/database/db_lookupSuggest.html" suggestFields="orgName" size="12">部门名称</th>
								<th type="enum" name="items.itemEnum[]" enumUrl="demo/database/db_select.html" size="12">从枚举</th>
								<th type="attach" name="items.attachment.fileName[]" lookupGroup="items.attachment" lookupUrl="demo/database/db_attachmentLookup.html" size="12">从附件</th>
								<th type="del" width="60">操作</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div> -->
			</div>
			<div class="tabsFooter">
				<div class="tabsFooterContent"></div>
			</div>
		</div>
		
	</div>
	<div class="formBar">
		<ul>
			<li><div class="buttonActive"><div class="buttonContent"><button type="submit">保存</button></div></div></li>
			<li><div class="button"><div class="buttonContent"><button class="close" type="button">关闭</button></div></div></li>
		</ul>
	</div>
</div>
</form>
