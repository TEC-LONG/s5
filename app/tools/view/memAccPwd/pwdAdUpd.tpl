<div class="pageContent">
	<form method="post" action="{$url.pwdPost.url}" class="pageForm required-validate" onsubmit="return validateCallback(this, mempwdAjaxDone);">
		{if isset($id)}
		<input type="hidden" name="id" value="{$id}">
		{/if}
        <div class="pageFormContent" layoutH="56">
            <p>
				<label>pwd数据：</label>
				<input class="required" name="mem_pwd" type="text" value="{if isset($row)&&!empty($row.mem_pwd)}{$row.mem_pwd}{/if}"/>
			</p>
			<div class="divider"></div>
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
var mempwdAjaxDone = function (re) {
	
	var tmp_url = '{$url.pwdIndex.url}';
	{literal}
	/// re = {statusCode: 200, message: "操作成功", navTabId: "tools_prorecord_detad"}
	if (re.statusCode==200) {
		alertMsg.correct(re.message);
		if (re.navTabId){
			$.pdialog.reload(tmp_url, {data:{}, dialogId:re.navTabId, callback:null}) 
		} else {
			navTabPageBreak();
		}
		$.pdialog.closeCurrent();
	}else{
		alertMsg.error(re.message);
	}
	{/literal}
}
</script>