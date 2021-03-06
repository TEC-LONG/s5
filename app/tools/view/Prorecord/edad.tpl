<div class="pageContent">
	<form method="post" action="{$url.adh.url}" class="pageForm required-validate" onsubmit="return validateCallback(this, edadAjaxDone);">
        <div class="pageFormContent" layoutH="56">
            <p>
				<label>日程标题：</label>
				<input name="title" type="text" class="required" style="width:240px;" />
			</p>
			<p>
				<label>类型：</label>
				<select class="combox" name="type">
					{foreach $type as $k=>$v}
					<option value="{$k}">{$v}</option>
					{/foreach}
				</select>
			</p>
			<p>
				<label>性质：</label>
				<select class="combox" name="characte">
					{foreach $characte as $k=>$v}
					<option value="{$k}">{$v}</option>
					{/foreach}
				</select>
			</p>
			<div class="divider"></div>
			<p>
				<label>预期周期开始时间：</label>
				<input name="b_time" class="date readonly" readonly="readonly" dateFmt="yyyy-MM-dd HH:mm:ss" type="text" value="">
			</p>
			<p>
				<label>预期周期结束时间：</label>
				<input name="e_time" class="date readonly" readonly="readonly" dateFmt="yyyy-MM-dd HH:mm:ss" type="text" value="">
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
{literal}
var edadAjaxDone = function (re) {
	
	/// re = {statusCode: 200, message: "操作成功", navTabId: "tools_prorecord_detad"}
	if (re.statusCode==200) {
		alertMsg.correct(re.message);
		if (re.navTabId){ //把指定navTab页面标记为需要“重新载入”。注意navTabId不能是当前navTab页面的
			navTab.reloadFlag(re.navTabId);
		} else { //重新载入当前navTab页面
			navTabPageBreak();
		}
		$.pdialog.closeCurrent();
	}else{
		alertMsg.error(re.message);
	}
}
{/literal}
</script>