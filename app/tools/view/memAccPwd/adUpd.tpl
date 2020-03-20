<div class="pageContent">
	<form method="post" action="{$url.post.url}" class="pageForm required-validate" onsubmit="return validateCallback(this, memAccPwdAjaxDone);">
		{if isset($id)}
		<input type="hidden" name="id" value="{$id}">
		{/if}
        <div class="pageFormContent" layoutH="56">
            <p>
				<label>归属方：</label>
				<input class="required" name="belongsToLookup.belongs_to" type="text" {if isset($row)}value="{$row.belongs_to}"{/if} readonly/>
				<input name="belongsToLookup.belongs_to__id" type="hidden" {if isset($row)}value="{$row.mem_belongs_to__id}"{/if} />
				<a class="btnLook" href="{$url.belongsToIndex.url}?type=lookup" lookupGroup="belongsToLookup">查找带回</a>
			</p>
            <p>
				<label>标签：</label>
				<input name="tags" type="text" {if isset($row)}value="{$row.tags}"{/if}/>
			</p>
            <p>
				<label>acc数据：</label>
				<input name="accLookup.mem_acc" type="text" {if isset($row)}value="{$row.mem_acc}"{/if} readonly/>
				<input name="accLookup.mem_acc__id" type="hidden" {if isset($row)}value="{$row.mem_acc__id}"{/if} />
				<a class="btnLook" href="{$url.accIndex.url}?type=lookup" lookupGroup="accLookup">查找带回</a>
			</p>
			<p>
				<label>pwd数据：</label>
				<input name="pwdLookup.mem_pwd" type="text" {if isset($row)}value="{$row.mem_pwd}"{/if} readonly/>
				<input name="pwdLookup.mem_pwd__id" type="hidden" {if isset($row)}value="{$row.mem_pwd__id}"{/if}/>
				<a class="btnLook" href="{$url.pwdIndex.url}?type=lookup" lookupGroup="pwdLookup">查找带回</a>
			</p>
			<div class="divider"></div>
			<p>
				<label>备注说明：</label>
				<textarea name="comm" cols="90" rows="10">{if isset($row)}{$row.comm}{/if}</textarea>
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