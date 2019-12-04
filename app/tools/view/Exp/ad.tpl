<script type="text/javascript">
var imgup = '{$url.editorImgUp}';
var imgdel = '{$url.editorImgDel}';
var imgload = '{$url.editorImgLoad}';
var tk = '{$tk}';
var act = '{$smarty.const.ACT}';
</script>
<div class="pageContent">
	<form method="post" action="{$url.adh}" class="pageForm required-validate" onsubmit="return validateCallback(this, navTabAjaxDone);">
		<div class="pageFormContent" layoutH="57">
			<dl>
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

			<div class="divider"></div>
			<dl>
				<dt>EXP内容：</dt>
				<dd>
<!-- wx.2015/7/21.新编辑器.start -->
<link href="{$smarty.const.PUBLIC_TOOLS}froala_editor/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="{$smarty.const.PUBLIC_TOOLS}froala_editor/css/froala_editor.min.css" rel="stylesheet" type="text/css">
<link href="{$smarty.const.PUBLIC_TOOLS}froala_editor/css/themes/royal.css" rel="stylesheet" type="text/css">
{literal}
<style>
section {
	width: 80%;
	height:100%;
	margin: auto;
	text-align: left;
}
</style>
{/literal}
		<textarea NAME="content" id="content" style="WIDTH:600px;HEIGHT:500px;"></textarea>
		<span id="span_content"></span>
<script src="{$smarty.const.PUBLIC_TOOLS}froala_editor/js/froala_editor.min.js"></script>
<!--[if lt IE 9]>
<script src="{$smarty.const.PUBLIC_TOOLS}froala_editor/js/froala_editor_ie8.min.js"></script>
<![endif]-->
<script src="{$smarty.const.PUBLIC_TOOLS}froala_editor/js/plugins/tables.min.js"></script>
<script src="{$smarty.const.PUBLIC_TOOLS}froala_editor/js/plugins/lists.min.js"></script>
<script src="{$smarty.const.PUBLIC_TOOLS}froala_editor/js/plugins/colors.min.js"></script>
<script src="{$smarty.const.PUBLIC_TOOLS}froala_editor/js/plugins/media_manager.min.js"></script>
<script src="{$smarty.const.PUBLIC_TOOLS}froala_editor/js/plugins/font_family.min.js"></script>
<script src="{$smarty.const.PUBLIC_TOOLS}froala_editor/js/plugins/font_size.min.js"></script>
<script src="{$smarty.const.PUBLIC_TOOLS}froala_editor/js/plugins/block_styles.min.js"></script>
<script src="{$smarty.const.PUBLIC_TOOLS}froala_editor/js/plugins/video.min.js"></script>
{literal}
<script>
$(function(){
	var win_ie_ver = parseFloat(navigator.appVersion.split("MSIE")[1]);
	
	$('textarea#content').editable({
		inlineMode: false, alwaysBlank: true, height: 500, width:900,
		//language: "zh_cn",
		imageUploadURL: imgup+'&tk='+tk,//上传到本地服务器
		//imageUploadParams: {id: "edit"},
		imageDeleteURL: imgdel+'&tk='+tk+'&nowact='+act,
		imagesLoadURL: imgload+'&tk='+tk
	}).on('editable.afterRemoveImage', function (e, editor, $img) {
		// Set the image source to the image delete params. 
		editor.options.imageDeleteParams = {src: $img.attr('src')};
		// Make the delete request
		//.editor.deleteImage($img);
		editor.deleteImage($img);
	});
});
</script>
{/literal}
<!-- wx.2015/7/21.新编辑器.end -->
				</dd>
			</dl>
		</div>
		<div class="formBar">
			<ul>
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit">保存</button></div></div></li>
				<li><div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div></li>
			</ul>
		</div>
	</form>
</div>
