<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>{$row.title}</title>
	<link rel="shortcut icon" href="{$smarty.const.PUBLIC_TOOLS}/image/ico.ico" type="image/x-icon" />
	<link rel="stylesheet" href="{$smarty.const.BOOTSTRAP4}/css/bootstrap.min.css"/>
	<link rel="stylesheet" href="{$smarty.const.PUBLIC_TOOLS}/edmd/css/editormd.css"/>
	<script src="{$smarty.const.PUBLIC_TOOLS_JUI}/js/jquery-2.1.4.min.js"></script>
	<script src="{$smarty.const.PUBLIC_TOOLS_PRETTIFY}/src/run_prettify.js?autoload=true&amp;skin=doxy&amp;lang=basic"></script>
	<!-- <script src="{$smarty.const.PUBLIC_TOOLS}/js/popper.min.js"></script> -->
    <script src="{$smarty.const.BOOTSTRAP4}/js/bootstrap.min.js"></script>
    <!-- <link rel="stylesheet" href="{$smarty.const.PUBLIC_TOOLS}/css/prism.css"/>
    <script src="{$smarty.const.PUBLIC_TOOLS}/js/prism.js"></script> -->

{literal}
<style>
body {padding: 40px;}

#layout > header, .btns {
    width: auto;
}

#sidebar {
    width: 400px;
    height: 100%;
    position: fixed;
    top: 0;
    right: 0;
    overflow: hidden;
    background: #fff;
    z-index: 100;
    padding: 18px; 
    border: 1px solid #ddd;
    border-top: none;
    border-bottom: none;
}

#sidebar:hover {
    overflow: auto;
}

#sidebar h1 {
    font-size: 16px;
}

#custom-toc-container {
    padding-left: 0;
}

.operative { font-weight: bold; border: 1px solid yellow; }
pre { border: 4px solid #88c; }
</style>
{/literal}
</head>
<body>

<div id="layout">
    <header>
        <h1>{$row.title}</h1> 
        <p class="ml-4">所属工程： {$belong_pro[$row.belong_pro]}</p>
        <p class="ml-4">{date('Y-m-d H:i:s', $row['post_date'])}</p>   
    </header>
    <div id="sidebar">
        <h1>{$row.title}目录：</h1>
        <div class="markdown-body editormd-preview-container" id="custom-toc-container">#custom-toc-container</div>
    </div>
    <div id="editormd-view1">
        <textarea style="display:none;"></textarea>
    </div>
</div>
<script src="{$smarty.const.PUBLIC_TOOLS}/edmd/lib/marked.min.js"></script>
<script src="{$smarty.const.PUBLIC_TOOLS}/edmd/lib/prettify.min.js"></script>
<script src="{$smarty.const.PUBLIC_TOOLS}/edmd/lib/raphael.min.js"></script>
<script src="{$smarty.const.PUBLIC_TOOLS}/edmd/lib/underscore.min.js"></script>
<script src="{$smarty.const.PUBLIC_TOOLS}/edmd/lib/sequence-diagram.min.js"></script>
<script src="{$smarty.const.PUBLIC_TOOLS}/edmd/lib/flowchart.min.js"></script>
<script src="{$smarty.const.PUBLIC_TOOLS}/edmd/lib/jquery.flowchart.min.js"></script>
<script src="{$smarty.const.PUBLIC_TOOLS}/edmd/editormd.js"></script>
<script>
$(function() {

    var testEditormdView;
                
    $.get("{$url_edmd_file}", function(markdown) {
        
        testEditormdView = editormd.markdownToHTML("editormd-view1", {
            htmlDecode: "style,script,iframe",
            markdown        : markdown ,//+ "\r\n" + $("#append-test").text(),
            //htmlDecode      : true,       // 开启 HTML 标签解析，为了安全性，默认不开启
            htmlDecode      : "style,script,iframe",  // you can filter tags decode
            //toc             : false,
            tocm            : true,    // Using [TOCM]
            tocContainer    : "#custom-toc-container", // 自定义 ToC 容器层
            //gfm             : false,
            //tocDropdown     : true,
            // markdownSourceCode : true, // 是否保留 Markdown 源码，即是否删除保存源码的 Textarea 标签
            emoji           : true,
            taskList        : true,
            tex             : true,  // 默认不解析
            flowChart       : true,  // 默认不解析
            sequenceDiagram : true,  // 默认不解析
        });
        
        //console.log("返回一个 jQuery 实例 =>", testEditormdView);
        
        // 获取Markdown源码
        // console.log(testEditormdView.getMarkdown());
        
        //alert(testEditormdView.getMarkdown());
    });
});
</script>
</body>
</html>
