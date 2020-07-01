<?php

///  blog/

    Route::get('index', 'Index@index');#首页
    Route::get('info', 'Index@info');#博文详情

    Route::get('test', 'Test@index');#测试页面