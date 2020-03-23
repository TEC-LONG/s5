<div class="pageContent">
	<form method="post" action="{$url.smenuPost.url}" class="pageForm required-validate" onsubmit="return validateCallback(this, smenuAjaxDone);">
		{if isset($row.id)}
		<input type="hidden" name="id" value="{$row.id}">
		{/if}
        <div class="pageFormContent" layoutH="56">
            <p>
				<label>子菜单名称：</label>
				<input class="required" name="name" type="text" value="{if isset($row)}{$row.name}{/if}"/>
			</p>
            <p>
				<label>路由：</label>
				<input name="route" type="text" value="{if isset($row)}{$row.route}{/if}"/>
			</p>
			<p>
				<label>请求方式：</label>
				<select class="combox" name="request_type">
					{foreach $request_type as $k=>$v}
					<option value="{$k}" {if isset($row)&&$v==$row.request_type}selected{/if}>{$v}</option>
					{/foreach}
				</select>
			</p>
			<p>
				<label>navtab：</label>
				<input name="navtab" type="text" value="{if isset($row)}{$row.navtab}{/if}"/>
			</p>
            <p>
				<label>上级菜单：</label>
				<select class="combox" name="menu__id">
					<option value="0">请选择...</option>
					{foreach $level3 as $v}
					<option value="{$v.id}" {if isset($row)&&$v.id==$row.menu__id}selected{/if}>{$v.name}</option>
					{/foreach}
				</select>
			</p>
            <p>
				<label>上级子菜单ID：</label>
				<input class="digits" name="parent_id" type="text" value="{if isset($row)}{$row.parent_id}{else}0{/if}"/>
			</p>
            <p>
				<label>外部链接地址：</label>
				<input name="link_href" type="text" value="{if isset($row)}{$row.link_href}{/if}"/>
			</p>
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
<script>
var smenuAjaxDone = function (re) {
	
	var tmp_url = '{$url.smenu.url}';
	{literal}
	/// re = {statusCode: 200, message: "操作成功", navTabId: "tools_prorecord_detad"}
	if (re.statusCode==200) {
		alertMsg.correct(re.message);
		if (re.navTabId){
			navTab.reloadFlag(re.navTabId);
		}
		$.pdialog.closeCurrent();
	}else{
		alertMsg.error(re.message);
	}
	{/literal}
}
</script>