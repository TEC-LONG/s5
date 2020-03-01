<div class="pageContent">
	<form method="post" action="{$url.updh.url}&id={$row.id}" class="pageForm required-validate" onsubmit="return validateCallback(this, detupdAjaxDone);">
		<input type="hidden" name="everyday_things__id" value="{$everyday_things__id}"/>
        <div class="pageFormContent" layoutH="56">
			<p class="nowrap">
				<label>细节内容：</label>
					<textarea name="content" class="required" rows="15" cols="100">{str_replace('<br/>', PHP_EOL, $row.content)}</textarea>
			</p>
			<div class="divider"></div>
			<p class="nowrap">
				<label>执行开始时间：</label>
				<input name="b_time" class="date readonly" readonly="readonly" dateFmt="yyyy-MM-dd HH:mm:ss" type="text" value="{date('Y-m-d H:i:s', $row.b_time)}">
			</p>
			<p class="nowrap">
				<label>执行结束时间：</label>
				<input name="e_time" class="date readonly" readonly="readonly" dateFmt="yyyy-MM-dd HH:mm:ss" type="text" value="{date('Y-m-d H:i:s', $row.e_time)}">
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
var tmp_details_url = '{$url.details.url}&id={$everyday_things__id}';
{literal}
var detupdAjaxDone = function (re) {
	
	/// re = {statusCode: 200, message: "操作成功", navTabId: "tools_prorecord_detad"}
	if (re.statusCode==200) {
		alertMsg.correct(re.message);
		$("#tools_everyday_things_details").loadUrl(tmp_details_url,{}, function(){
			//回调
		});
		$.pdialog.closeCurrent();
	}else{
		alertMsg.error(re.message);
	}
}
{/literal}
</script>