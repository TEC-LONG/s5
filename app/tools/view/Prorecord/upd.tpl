<div class="pageContent">
	<form method="post" action="{$url.updh}&id={$prorecord.id}" class="pageForm required-validate" onsubmit="return validateCallback(this, navTabAjaxDone);">
		<div class="pageFormContent" layoutH="57">
			<dl class="nowrap">
				<dt>标题：</dt>
				<dd><input class="required" name="title" type="text" size="30" value="{$prorecord.title}" /></dd>
			</dl>
			<dl class="nowrap">
				<dt>所属工程：</dt>
				<dd>
					<select name="belong_pro" class="required combox">
						{foreach $belong_pro as $belong_pro_key=>$belong_pro_val}
						<option value="{$belong_pro_key}" {if $prorecord.belong_pro==$belong_pro_key}selected{/if}>{$belong_pro_val}</option>
						{/foreach}
					</select>
				</dd>
			</dl>
			<input name="content_upd" id="con_upd" value="{$prorecord.content}" type="hidden"/>
			<div class="formBar">
				<ul>
					<li><div class="buttonActive"><div class="buttonContent"><button type="submit">立即修改</button></div></div></li>
					<!-- <li><div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div></li> -->
				</ul>
			</div>
			<div class="divider"></div>
<script type="text/javascript">
/*编辑器editormd*/
//设置编辑器录入的内容
var setEditorMdConupd = function (co){
	$('#con_upd').val(co);
	//console.log($('#con_upd').val());
}
</script>
			<div>
				<iframe src="{$url.editormd}&id={$prorecord.id}&tbname=prorecord" frameborder="0" width="100%" height="1100"><iframe>
			</div>
		</div>
	</form>
</div>
