<div class="pageContent">
	<form method="post" action="{$url.adh.url}" class="pageForm required-validate" onsubmit="return validateCallback(this, memAccPwdAjaxDone);">
        <div class="pageFormContent" layoutH="56">
            <p>
				<label>acc数据：</label>
				<input class="required" name="accLookup.mem_acc" type="text" readonly/>
				<input name="accLookup.mem_acc__id" type="hidden"/>
				<a class="btnLook" href="{$url.accIndex.url}&type=lookup" lookupGroup="accLookup">查找带回</a>
			</p>
			<p>
				<label>pwd数据：</label>
				<input class="required" name="expcat.cat3name" type="text" readonly/>
				<a class="btnLook" href="{$url.pwdIndex.url}" lookupGroup="pwdLookup">查找带回</a>
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
{literal}
var memAccPwdAjaxDone = function (re) {
	
	/// re = {statusCode: 200, message: "操作成功", navTabId: "tools_prorecord_detad"}
	if (re.statusCode==200) {
		alertMsg.correct(re.message);
		if (re.navTabId){
			navTab.reloadFlag(re.navTabId);
		} else {
			navTabPageBreak();
		}
		$.pdialog.closeCurrent();
	}else{
		alertMsg.error(re.message);
	}
}
{/literal}
</script>