<?php

define('PUBLIC_TOOLS', C('URL') . '/public/tools/');// http://xxx.xxx.xxx/public/tools/
define('PUBLIC_TOOLS_EDITOR', C('URL') . '/public/tools/froala_editor/');// http://xxx.xxx.xxx/public/tools/
define('PUBLIC_TOOLS_JUI', PUBLIC_TOOLS . 'jui/new/');// http://xxx.xxx.xxx/public/tools/jui/new/
define('PUBLIC_TOOLS_PRETTIFY', PUBLIC_TOOLS . 'prettify/');// http://xxx.xxx.xxx/public/tools/prettify/

if ( !defined('BOOTSTRAP4') )	define('BOOTSTRAP4', C('URL').'/vendor/twbs/bootstrap/dist/');
if ( !defined('URL_EDMD_FILE') )	define('URL_EDMD_FILE', C('URL').'/storage/edmd/');
