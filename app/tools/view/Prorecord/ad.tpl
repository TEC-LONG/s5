<div class="pageContent">
	<form method="post" action="{$url.adh}" class="pageForm required-validate" onsubmit="return validateCallback(this, navTabAjaxDone);">
		<div class="pageFormContent" layoutH="57">
			<dl class="nowrap">
				<dt>标题：</dt>
				<dd><input class="required" name="title" type="text" size="30" /></dd>
			</dl>
			<dl class="nowrap">
				<dt>所属工程：</dt>
				<dd>
					<select name="belong_pro" class="required combox">
						{foreach $belong_pro as $belong_pro_key=>$belong_pro_val}
						<option value="{$belong_pro_key}">{$belong_pro_val}</option>
						{/foreach}
					</select>
				</dd>
			</dl>
			<input name="content_ad" id="con_ad" value="" type="hidden"/>
			<div class="formBar">
				<ul>
					<li><div class="buttonActive"><div class="buttonContent"><button type="submit">立即添加</button></div></div></li>
					<!-- <li><div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div></li> -->
				</ul>
			</div>
			<div class="divider"></div>
<script type="text/javascript">
/*编辑器editormd*/
//设置编辑器录入的内容
var setEditorMdConad = function (co){
	$('#con_ad').val(co);
}
</script>
			<div>
				<iframe src="{$url.editormd}" frameborder="0" width="100%" height="1100"><iframe>
			</div>
		</div>
	</form>
</div>
