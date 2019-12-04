<!DOCTYPE html>
<html lang="zh">
    <head>
        <meta charset="utf-8" />
        <title>[ID:{$prorecord.id}].{$prorecord.title}</title>
        <link rel="stylesheet" href="{$smarty.const.PUBLIC_TOOLS}editor_md/examples/css/style.css" />
        <link rel="stylesheet" href="{$smarty.const.PUBLIC_TOOLS}editor_md/css/editormd.preview.css" />
		<script type="text/javascript" src="{$smarty.const.PUBLIC_TOOLS_PRETTIFY}src/run_prettify.js?autoload=true&amp;skin=sunburst&amp;lang=css"></script>
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
            
            #test-editormd-view, #test-editormd-view2 {
                padding-left: 0;
                padding-right: 430px;
                margin: 0;
            }
			.operative { font-weight: bold; border: 1px solid yellow; }
			pre { border: 4px solid #88c; }
        </style>
		{/literal}
    </head>
    <body>
        <div id="layout">
            <header>
                <h1>{$prorecord.title}</h1> 
                <p>所属工程： {$belong_pro[$prorecord.belong_pro]}</p>
                <p>{date('Y-m-d H:i:s', $prorecord['post_date'])}</p>  
            </header>
            <div id="sidebar">
                <h1>内容导航</h1>
                <div class="markdown-body editormd-preview-container" id="custom-toc-container">#custom-toc-container</div>
            </div>
            <div id="test-editormd-view">
               <textarea style="display:none;" name="test-editormd-markdown-doc"></textarea>               
            </div>
            <div id="test-editormd-view2">
                <textarea id="append-test" style="display:none;"></textarea>          
            </div>
        </div>
        <!-- <script src="/tempaltes/editor_md/examples/js/zepto.min.js"></script>
		<script>		
			var jQuery = Zepto;  // 为了避免修改flowChart.js和sequence-diagram.js的源码，所以使用Zepto.js时想支持flowChart/sequenceDiagram就得加上这一句
		</script> -->
        <script src="{$smarty.const.PUBLIC_TOOLS}editor_md/examples/js/jquery.min.js"></script>
        <script src="{$smarty.const.PUBLIC_TOOLS}editor_md/lib/marked.min.js"></script>
        <script src="{$smarty.const.PUBLIC_TOOLS}editor_md/lib/prettify.min.js"></script>

        <script src="{$smarty.const.PUBLIC_TOOLS}editor_md/lib/raphael.min.js"></script>
        <script src="{$smarty.const.PUBLIC_TOOLS}editor_md/lib/underscore.min.js"></script>
        <script src="{$smarty.const.PUBLIC_TOOLS}editor_md/lib/sequence-diagram.min.js"></script>
        <script src="{$smarty.const.PUBLIC_TOOLS}editor_md/lib/flowchart.min.js"></script>
        <script src="{$smarty.const.PUBLIC_TOOLS}editor_md/lib/jquery.flowchart.min.js"></script>

        <script src="{$smarty.const.PUBLIC_TOOLS}editor_md/editormd.js"></script>
        <script type="text/javascript">
            $(function() {
                var testEditormdView, testEditormdView2;
                
                $.get("{$smarty.const.PUBLIC_TOOLS}editor_md/examples/test.md", function(markdown) {
                    
				    testEditormdView = editormd.markdownToHTML("test-editormd-view", {
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
                    //console.log(testEditormdView.getMarkdown());
                    
                    //alert(testEditormdView.getMarkdown());
                });
                    
                testEditormdView2 = editormd.markdownToHTML("test-editormd-view2", {
                    htmlDecode      : "style,script,iframe",  // you can filter tags decode
                    emoji           : true,
                    taskList        : true,
                    tex             : true,  // 默认不解析
                    flowChart       : true,  // 默认不解析
                    sequenceDiagram : true,  // 默认不解析
                });
            });
        </script>
    </body>
</html>
