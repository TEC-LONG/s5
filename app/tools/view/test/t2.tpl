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
</head>
<body class="line-numbers">
    {htmlspecialchars_decode($row.content_html)}
</body>
</html>