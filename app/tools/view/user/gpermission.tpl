
{literal}
<style>
label {padding-right: 35px;}
.gp_contro {vertical-align:middle;margin-left:4px;}
</style>
{/literal}
<form method="post" action="{$url.gpPost.url}" class="pageForm required-validate" onsubmit="return validateCallback(this, gpAjaxDone);">
	<input type="hidden" name="user_group__id" value="{$search.id}">
<div class="pageContent" layoutH="42" style="vertical-align:middle;">
{foreach $menu as $v1}
<div>
	<h1 style="margin-top:4px;margin-left:3px;">{$v1.lv1.display_name}<input type="checkbox" class="gp_contro gpc1"/></h1>
	<div class="divider"></div>
	{foreach $v1.lv2 as $v2}
	<div class="panel collapse" minH="100" defH="{if isset($v2.son)}{count($v2.son)*66}{/if}">
		<h1>{$v2.menu.display_name}<input type="checkbox" class="gp_contro gpc2"/></h1>
		{if isset($v2.son)}
		<div>
			{foreach $v2.son as $v3}
			<div>
				<h2>{$v3.display_name}<input type="checkbox" class="gp_contro gpc3"/></h2>
				<div class="divider"></div>
				{if isset($v3.son)}
					{foreach $v3.son as $v4}
				<label><input type="checkbox" name="mp_id[]" value="{$v4.id}" {if in_array($v4.id, $power)}checked{/if} />{$v4.display_name}</label>
					{/foreach}
				{/if}
				<br/><br/><br/>
			</div>
			{/foreach}
		</div>
		{/if}
	</div>
	{/foreach}
</div>
{/foreach}
</div>
<div class="formBar">
	<ul>
		<li><div class="buttonActive"><div class="buttonContent"><button type="submit">保存</button></div></div></li>
	</ul>
</div>
</form>

<script>
var gpAjaxDone = function (re) {
	
	var tmp_url = '{$url.gpermission.url}';
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

$('.gp_contro').bind('click', function () {
	console.log(123);
	if ($(this).hasClass('gpc2')) {
		var checkboxes = $(this).parent().parent().parent().parent().find('input[name="mp_id[]"]');
		var all_checkboxes = $(this).parent().parent().parent().parent().find('input[type="checkbox"]');
	}else{
		var checkboxes = $(this).parent().parent().find('input[name="mp_id[]"]');
		var all_checkboxes = $(this).parent().parent().find('input[type="checkbox"]');
	}
	
	
	var all_checked = true;//是否已全选
	checkboxes.each(function(){
		if (!$(this).is(":checked")) {
			return all_checked = false;
		}
	});
	if (all_checked) {
		checkboxes.prop("checked",false); 
		// gp_contro_checkboxes.prop("checked",false); 
		all_checkboxes.prop("checked",false); 
	}else{
		checkboxes.prop("checked",true);
		// gp_contro_checkboxes.prop("checked",true);
		all_checkboxes.prop("checked",true);
	}
});

var gpinit = function (class_name){
	
	var obj = $(class_name);

	obj.each(function(index1, this1){
		var checkboxes = $(this1).parent().parent().find('input[name="mp_id[]"]');
		var all_checked = true;//是否已全选
		checkboxes.each(function(index2, this2){
			if (!$(this2).is(":checked")) {
				return all_checked = false;
			}
		});

		if (all_checked) {
			$(this1).prop("checked",true); 
		}
	});
}

gpinit('.gpc3');
gpinit('.gpc2');
gpinit('.gpc1');
</script>