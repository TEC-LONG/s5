<!DOCTYPE html>
<HTML>
<head>
	<meta charset="UTF-8">
	<title>XXXXX</title>
	<script type="text/javascript" src="{$smarty.const.PUBLIC_TOOLS_PRETTIFY}src/run_prettify.js?autoload=true&amp;skin=sunburst&amp;lang=css"></script>
	<script src="{$smarty.const.PUBLIC_TOOLS_JUI}js/jquery-2.1.4.min.js" type="text/javascript"></script>
</head>
<body>
<!-- wx.2019/11/25.编辑器.start -->
<!-- <link rel="stylesheet" href="{$smarty.const.PUBLIC_TOOLS}editor_md/examples/css/style.css" /> -->
<link rel="stylesheet" href="{$smarty.const.PUBLIC_TOOLS}editor_md/css/editormd.css" />
<div id="layout" style="height: 900px;background: #f6f6f6;">
	<header>
		<h1>内容</h1>
		<p></p>
	</header>
	<div id="test-editormd">
		<textarea style="display:none;" name="content" id="content"></textarea>
	</div>
</div>        
<script src="{$smarty.const.PUBLIC_TOOLS}editor_md/editormd.js"></script>
<script type="text/javascript">$(function() {                
		var testEditor = editormd("test-editormd", {
			width: "90%",
			height: 720,
			markdown : "",
			path : '{$smarty.const.PUBLIC_TOOLS}editor_md/lib/',
			//dialogLockScreen : false,   // 设置弹出层对话框不锁屏，全局通用，默认为 true
			//dialogShowMask : false,     // 设置弹出层对话框显示透明遮罩层，全局通用，默认为 true
			//dialogDraggable : false,    // 设置弹出层对话框不可拖动，全局通用，默认为 true
			//dialogMaskOpacity : 0.4,    // 设置透明遮罩层的透明度，全局通用，默认值为 0.1
			//dialogMaskBgColor : "#000", // 设置透明遮罩层的背景颜色，全局通用，默认为 #fff
			imageUpload : true,
			imageFormats : ["jpg", "jpeg", "gif", "png", "bmp", "webp"],
			imageUploadURL : "{$url.editormdImgUp}",
			onchange : function() {
				
				var con = $('#content').html();
				parent.setEditorMdCon(con);
			}

			/*
 上传的后台只需要返回一个 JSON 数据，结构如下：
 {
success : 0 | 1,           // 0 表示上传失败，1 表示上传成功
message : "提示的信息，上传成功或上传失败及错误信息等。",
url     : "图片地址"        // 上传成功时才返回
 }
			 */
		});
	});

</script>
<!-- wx.2019/11/25.编辑器.end -->

</body>
</HTML>