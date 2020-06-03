<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>{$html_title}文章【{$row.title}】</title>
	<link rel="shortcut icon" href="{$smarty.const.PUBLIC_TOOLS}/image/ico.ico" type="image/x-icon" />
	<link rel="stylesheet" href="{$smarty.const.BOOTSTRAP4}/css/bootstrap.min.css"/>
	<link rel="stylesheet" href="{$smarty.const.PUBLIC_TOOLS}/edmd/css/editormd.css"/>
	<script src="{$smarty.const.PUBLIC_TOOLS_JUI}/js/jquery-2.1.4.min.js"></script>
	<script src="{$smarty.const.PUBLIC_TOOLS_PRETTIFY}/src/run_prettify.js?autoload=true&amp;skin=sunburst&amp;lang=css"></script>
	<script src="{$smarty.const.PUBLIC_TOOLS}/js/popper.min.js"></script>
	<script src="{$smarty.const.BOOTSTRAP4}/js/bootstrap.min.js"></script>
	<script src="{$smarty.const.PUBLIC_TOOLS}/editor_md/editormd.js"></script>
</head>
<body>
	<ul class="nav nav-tabs">
		<li class="nav-item">
			<a class="nav-link active">{$html_title}文章</a>
		</li>
	</ul>
	<form class="needs-validation" action="{$url.updh.url}?id={$row.id}" method="post">
		<div class="form-row d-flex mt-3">
			<div class="col-md-1"></div>
			<div class="col-md-2">
				<label for="admin_article_title">文章标题</label>
				<input type="text" class="form-control" name="title" placeholder="必填项" {if isset($row.title)}value="{$row.title}"{/if} required>
			</div>
			<div class="col-md-3">
				<label for="admin_article_tags">文章标签</label>
				<input type="text" class="form-control" name="tags" {if isset($row.tags)}value="{$row.tags}"{/if}>
			</div>
			<div class="col-md-1">
				<label for="admin_article_lv1">所属分类</label>
				<select class="form-control" id="admin_article_cat_lv1" name="cate1" onchange="cascade_this(this, 'lv1');">
					<option value="0">请选择...</option>
					{foreach $cate_one as $k=>$v}
					<option value="{$v.id}|{$v.name}" {if $v['id']==$row['crumbs_cat_ids'][0]}selected{/if}>{$v.name}</option>
					{/foreach}
				</select>
			</div>
			<div class="col-md-1 mt-2">
				<label> </label>
				<select class="form-control admin_article_cat_lv2" name="cate2" onchange="cascade_this(this, 'lv2');" disabled>
					<option>请选择...</option>
				</select>
			</div>
			<div  class="col-md-1 mt-2">
				<label> </label>
				<select class="form-control admin_article_cat_lv3" name="cate3" disabled>
					<option>请选择...</option>
				</select>
			</div>
			<div class="col-md-1">
				<label> </label>
				<button class="btn btn-success" type="submit" style="margin-top:32px;">点击{$html_title}</button>
			</div>
		</div>
		<div class="form-row d-flex mt-3" id="{$navtab}_editormd">
			<textarea style="display:none;" name="content">{$row.content}</textarea>
		</div>
	</form>
	
<script src="{$smarty.const.PUB_COMMON_JS}/cascade.js" type="text/javascript"></script>
<script type="text/javascript">
var url = '{L("/admin/article/cate/child")}';
var cascade = new Cascade(url, 'admin_article_cat_lv2', 'admin_article_cat_lv3');

$(function() {
	var editor = editormd("{$navtab}_editormd", {
		htmlDecode			:	"style,script,iframe",
		width				:	"95%",
		height				:	'640px',
		syncScrolling		:	"single",
		emoji				:	true,
		//启动本地图片上传功能
		imageUpload			:	true,
		watch				:	true,
		imageFormats		:	["jpg", "jpeg", "gif", "png", "bmp", "webp","zip","rar"],
		path				:	"{$smarty.const.PUBLIC_TOOLS}/edmd/lib/",
		imageUploadURL		:	"{$url.imgupmd.url}", //文件提交请求路径
		saveHTMLToTextarea	:	true, //注意3：这个配置，方便post提交表单
		theme				:	"default",
		// Preview container theme, added v1.5.0
		// You can also custom css class .editormd-preview-theme-xxxx
		previewTheme		:	"default", 
		// Added @v1.5.0 & after version is CodeMirror (editor area) theme
		editorTheme			:	"blackboard", 
	});
});
// 			/*
//  上传的后台只需要返回一个 JSON 数据，结构如下：
//  {
// success : 0 | 1,           // 0 表示上传失败，1 表示上传成功
// message : "提示的信息，上传成功或上传失败及错误信息等。",
// url     : "图片地址"        // 上传成功时才返回
//  }
// 			 */
//testEditor.getMarkdown();       // 获取 Markdown 源码
//testEditor.getHTML();           // 获取 Textarea 保存的 HTML 源码
//testEditor.getPreviewedHTML();  // 获取预览窗口里的 HTML，在开启 watch 且没有开启 saveHTMLToTextarea 时使用

{literal}
// jQuery.fn.extend({
//     is_wrong: 0,
//     checkMediaLink: function () {

//         var media_link = this.val().trim();
//         if (media_link=='') {
//             this.is_wrong = 1;
//         }else{
//             this.is_wrong = 0;
//         }
//         return this;
//     },
//     layerOut: function (msg) {
        
//         if ( this.is_wrong==1 ) {
//             layer.msg(msg,{icon:5});
//             return false;
//         }
//         return true;
//     }
// });
{/literal}
</script>
</body>
</html>

