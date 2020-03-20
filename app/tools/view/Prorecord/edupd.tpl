<div class="pageContent">
	<form method="post" action="{$url.updh.url}?id={$row.id}" class="pageForm required-validate" onsubmit="return validateCallback(this, edupdAjaxDone);">
        <div class="pageFormContent" layoutH="56">
            <p>
				<label>日程标题：</label>
				<input name="title" type="text" class="required" style="width:240px;" value="{$row.title}" />
			</p>
			<p>
				<label>类型：</label>
				<select class="combox" name="type">
					{foreach $type as $k=>$v}
					<option value="{$k}" {if $row.type==$k}selected{/if}>{$v}</option>
					{/foreach}
				</select>
			</p>
			<p>
				<label>性质：</label>
				<select class="combox" name="characte">
					{foreach $characte as $k=>$v}
					<option value="{$k}" {if $row.characte==$k}selected{/if}>{$v}</option>
					{/foreach}
				</select>
			</p>
			<div class="divider"></div>
			<p>
				<label>预期周期开始时间：</label>
				<input name="b_time" class="date" readonly="readonly" dateFmt="yyyy-MM-dd HH:mm:ss" type="text" value="{date('Y-m-d H:i:s', $row['b_time'])}">
			</p>
			<p>
				<label>预期周期结束时间：</label>
				<input name="e_time" class="date" readonly="readonly" dateFmt="yyyy-MM-dd HH:mm:ss" type="text" value="{date('Y-m-d H:i:s', $row['e_time'])}">
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
var edupdAjaxDone = function (re) {
	
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