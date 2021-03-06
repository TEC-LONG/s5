<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{$smarty.const.BOOTSTRAP4}/css/bootstrap.min.css"/>
    <script src="{$smarty.const.PUBLIC_TOOLS_JUI}/js/jquery-2.1.4.min.js"></script>
    <script src="{$smarty.const.BOOTSTRAP4}/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="{$smarty.const.PUBLIC_TOOLS}/css/prism.css"/>
    <script src="{$smarty.const.PUBLIC_TOOLS}/js/prism.js"></script>
    <link rel="stylesheet" href="{$smarty.const.PUBLIC_TOOLS}/css/jquery.autoMenu.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-1"></div>
            <div class="col-sm line-numbers content">
                {htmlspecialchars_decode($row.content_html)}
            </div>
            <div class="col-sm-1"></div>
          </div>
    </div>
    <div class="autoMenu" id="autoMenu" data-autoMenu> </div>
<script src="{$smarty.const.PUBLIC_TOOLS}/js/jquery.autoMenu.js"></script> 
<script>
var content = $('.content');
var table = content.find('table');

var setHn = function (tag, style, level_flag) {
    content.find(tag).each(function(index, elem){
        var this_new_html = '<span class="badge '+style+'"> '+level_flag+' '+$(elem).html()+'</span>';
        $(elem).html(this_new_html);
    });
};

$(function(){
        //$('#autoMenu').autoMenu();
        content.children().attr('style', 'margin-top:12px;');
        content.find('ol li').addClass('lead');
        content.find('p').addClass('alert-success');

        // content.find('h1').addClass('badge badge-secondary');

        // content.find('h1').each(function(index, elem){
        //     var this_new_html = '<span class="badge badge-info">'+$(elem).html()+'</span>';
        //     $(elem).html(this_new_html);
        // });
        setHn('h1', 'badge-info', '|-');
        setHn('h2', 'badge-warning', '||-');
        setHn('h3', 'badge-success', '|||-');
        setHn('h4', 'badge-danger', '||||-');

        table.addClass('table table-bordered table-hover table-striped table-dark');
        table.find('thead').addClass('bg-primary');
})
</script>
</body>
</html>