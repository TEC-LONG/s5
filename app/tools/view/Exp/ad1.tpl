<div class="pageContent">
	<form method="post" action="{$url.adh}" class="pageForm required-validate" onsubmit="return validateCallback(this, navTabAjaxDone);">
		<div class="pageFormContent" layoutH="57">
			<dl class="nowrap">
				<dt>EXP标题：</dt>
				<dd><input class="required" name="title" type="text" size="30" /></dd>
			</dl>
			<dl class="nowrap">
				<dt>EXP标签：</dt>
				<dd><textarea cols="135" rows="3" name="tags"></textarea></dd>
			</dl>
			<dl class="nowrap">
				<dt>所属EXP分类：</dt>
				<dd>
					<input class="required" name="expcat.cat1name" type="text" readonly/>
				</dd>
			</dl>
			<dl class="nowrap">
				<dt>&nbsp;</dt>
				<dd>
						<input class="required" name="expcat.cat2name" type="text" readonly/>
				</dd>
			</dl>
			<dl class="nowrap">
				<dt>&nbsp;</dt>
				<dd>
					<input name="expcat.cat3id" value="" type="hidden"/>
					<input name="expcat.cat2id" value="" type="hidden"/>
					<input name="expcat.cat1id" value="" type="hidden"/>
					<input class="required" name="expcat.cat3name" type="text" readonly/>
					<a class="btnLook" href="{$url.catLookup}" lookupGroup="expcat">查找带回</a>
				</dd>
			</dl>
			<input name="content_ad" id="con_ad" value="" type="hidden"/>
			<div class="formBar">
				<ul>
					<li><div class="buttonActive"><div class="buttonContent"><button type="submit">添加exp</button></div></div></li>
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
