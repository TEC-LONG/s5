<?php

define('URL', C('URL'));

define('_PUB_', C('URL').'/public');

define('PUBLIC_TOOLS',          _PUB_ . '/tools');// http://xxx.xxx.xxx/public/tools/
define('PUBLIC_TOOLS_EDITOR',   PUBLIC_TOOLS . '/froala_editor');// http://xxx.xxx.xxx/public/tools/
define('PUBLIC_TOOLS_JUI',      PUBLIC_TOOLS . '/jui/new');// http://xxx.xxx.xxx/public/tools/jui/new/
define('PUBLIC_TOOLS_PRETTIFY', PUBLIC_TOOLS . '/prettify');// http://xxx.xxx.xxx/public/tools/prettify/

define('PUB_FRONT',         _PUB_ . '/front');
define('PUB_FRONT_CSS',     PUB_FRONT . '/css');
define('PUB_FRONT_JS',      PUB_FRONT . '/js');
define('PUB_FRONT_FONT',    PUB_FRONT . '/font');
define('PUB_FRONT_IMG',     PUB_FRONT . '/img');

define('PUB_COMMON',        _PUB_ . '/common');
define('PUB_COMMON_JS',     PUB_COMMON . '/js');

if ( !defined('BOOTSTRAP4') )	    define('BOOTSTRAP4',    C('URL').'/vendor/twbs/bootstrap/dist');
if ( !defined('URL_EDMD_FILE') )	define('URL_EDMD_FILE', C('URL').'/storage/edmd');

