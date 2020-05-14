<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>编辑EXP【{$row.title}】</title>
	<link rel="shortcut icon" href="{$smarty.const.PUBLIC_TOOLS}/image/ico.ico" type="image/x-icon" />
	<link rel="stylesheet" href="{$smarty.const.BOOTSTRAP4}/css/bootstrap.min.css"/>
	<link rel="stylesheet" href="{$smarty.const.PUBLIC_TOOLS}/edmd/css/editormd.css"/>
	<!-- <script src="{$smarty.const.PUBLIC_TOOLS}/js/jquery-3.3.1.slim.min.js"></script> -->
	<script src="{$smarty.const.PUBLIC_TOOLS_JUI}/js/jquery-2.1.4.min.js"></script>
	<script src="{$smarty.const.PUBLIC_TOOLS_PRETTIFY}/src/run_prettify.js?autoload=true&amp;skin=sunburst&amp;lang=css"></script>
	<script src="{$smarty.const.PUBLIC_TOOLS}/js/popper.min.js"></script>
	<script src="{$smarty.const.BOOTSTRAP4}/js/bootstrap.min.js"></script>
	<script src="{$smarty.const.PUBLIC_TOOLS}/editor_md/editormd.js"></script>
</head>
<body>
	<!-- <div class="container">
		<div class="row d-flex mt-3">
			<div class="col-sm">
			aaa
			</div>
			<div class="col-sm">
			三分之一空间占位
			</div>
			<div class="col-sm">
			三分之一空间占位
			</div>
		</div>
		<div class="row no-gutters">
			<div class="col-sm">
			三分之一空间占位
			</div>
			<div class="col-sm">
			三分之一空间占位
			</div>
			<div class="col-sm">
			三分之一空间占位
			</div>
		</div>
	</div> -->

	<ul class="nav nav-tabs">
		<li class="nav-item">
			<a class="nav-link active">编辑EXP</a>
		</li>
	</ul>
	<form class="needs-validation" action="{$url.updh.url}?id={$row.id}" method="post">
		<div class="form-row d-flex mt-3">
			<div class="col-md-1"></div>
			<div class="col-md-2">
				<label for="tools_exp_add_title">EXP标题</label>
				<input type="text" class="form-control" id="tools_exp_add_title" name="title" placeholder="必填项" value="{$row.title}" required>
			</div>
			<div class="col-md-3">
				<label for="tools_exp_add_tags">EXP标签</label>
				<input type="text" class="form-control" id="tools_exp_add_tags" name="tags" value="{$row.tags}">
			</div>
			<div class="col-md-1">
				<label for="tools_exp_add_cat">所属EXP分类</label>
				<select class="form-control" id="tools_exp_add_cat" name="expcat1" onchange="cascade_this(this, 'lv1');">
					<option value="0">请选择...</option>
					{foreach $expcat_lv1 as $k=>$v}
					<option value="{$v.id}|{$v.name}" {if $v['id']==$row['crumbs_expcat_ids'][0]}selected{/if}>{$v.name}</option>
					{/foreach}
				</select>
			</div>
			<div class="col-md-1 mt-2">
				<label> </label>
				<select class="form-control tools_exp_add_cat_lv2" name="expcat2" onchange="cascade_this(this, 'lv2');" disabled>
					<option>请选择...</option>
				</select>
			</div>
			<div  class="col-md-1 mt-2">
				<label> </label>
				<select class="form-control tools_exp_add_cat_lv3" name="expcat3" disabled>
					<option>请选择...</option>
				</select>
			</div>
			<div class="col-md-1">
				<label> </label>
				<button class="btn btn-success" type="submit" style="margin-top:32px;">点击修改</button>
			</div>
		</div>
		<div class="form-row d-flex mt-3" id="editormd">
			<textarea style="display:none;" name="content">{$row.content}</textarea>
		</div>
	</form>
	
<script src="{$smarty.const.PUB_COMMON_JS}/cascade.js" type="text/javascript"></script>
<script type="text/javascript">

var expcat2 = "{$row['crumbs_expcat_ids'][1]}|{$row['crumbs_expcat_names'][1]}";
var expcat3 = "{$row['crumbs_expcat_ids'][2]}|{$row['crumbs_expcat_names'][2]}";

var url = '{L("/tools/expcat/getChild")}';
var cascade = new Cascade(url, 'tools_exp_add_cat_lv2', 'tools_exp_add_cat_lv3');

cascade_this($('select[name="expcat1"]')[0], 'lv1', function(){

	$('select[name="expcat2"]').val(expcat2);

	cascade_this($('select[name="expcat2"]')[0], 'lv2', function(){

		$('select[name="expcat3"]').val(expcat3);
	})
});


$(function() {
	var editor = editormd("editormd", {
		htmlDecode: "style,script,iframe",
		width: "95%",
		height:'640px',
		syncScrolling : "single",
		emoji:true,
		//启动本地图片上传功能
		imageUpload: true,
		watch:false,
		imageFormats   : ["jpg", "jpeg", "gif", "png", "bmp", "webp","zip","rar"],
		path   : "{$smarty.const.PUBLIC_TOOLS}/edmd/lib/",
		imageUploadURL : "{$url.imgupmd.url}", //文件提交请求路径
		saveHTMLToTextarea : true, //注意3：这个配置，方便post提交表单
		theme        : "default",
		// Preview container theme, added v1.5.0
		// You can also custom css class .editormd-preview-theme-xxxx
		previewTheme : "default", 
		// Added @v1.5.0 & after version is CodeMirror (editor area) theme
		editorTheme  : "blackboard", 
	});
});
</script>
</body>
</html>

