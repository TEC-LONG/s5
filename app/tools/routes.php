<?php

///  tools/

    #登录相关
    Route::get('login/index', 'Login@index');##登录页
    Route::get('login/capture', 'Login@showCheckcodeImg');##验证码
    Route::get('login/quit', 'Login@logout');##退出
    Route::post('login/check', 'Login@checklogin');##校验

    #后台页面
    Route::get('index', 'Index@index');##首页

    Route::request('tbIntelligence/index', 'AutoTb@index');
    Route::post('tbIntelligence/stepOne', 'AutoTb@stepOne');
    Route::post('tbIntelligence/stepTwo', 'AutoTb@stepTwo');

    Route::get('chifan/list', 'Chifan@index');
    Route::get('chifan/ad', 'Chifan@ad');
    Route::post('chifan/adh', 'Chifan@adh');
    Route::get('chifan/upd', 'Chifan@upd');
    Route::post('chifan/updh', 'Chifan@updh');
    Route::get('chifan/del', 'Chifan@del');

    Route::post('editormd/imgUp', 'Editor@imgupmd');

    Route::get('event/index', 'Event@index');
    Route::get('event/ad', 'Event@ad');
    Route::post('event/adh', 'Event@adh');
    Route::get('event/upd', 'Event@upd');
    Route::post('event/updh', 'Event@updh');
    Route::get('event/del', 'Event@del');

    Route::get('expcat/index', 'Expcat@index');
    Route::post('expcat/getChild', 'Expcat@getChild');
    Route::post('expcat/adh', 'Expcat@adh');
    Route::post('expcat/edith', 'Expcat@edith');
    Route::get('expcat/catLookup', 'Expcat@catLookup');

    Route::get('exp/index', 'Exp@index');
    Route::get('exp/info', 'Exp@info');
    Route::get('exp/ad', 'Exp@ad');
    Route::post('exp/adh', 'Exp@adh');
    Route::get('exp/upd', 'Exp@upd');
    Route::post('exp/updh', 'Exp@updh');
    Route::post('exp/imgupmd', 'Exp@imgupmd');

    Route::get('accPwd/index', 'MemAccPwd@index');
    Route::post('accPwd/edit', 'MemAccPwd@adUpd');
    Route::post('accPwd/post', 'MemAccPwd@post');
    Route::get('accPwd/del', 'MemAccPwd@del');
    Route::get('accPwd/accIndex', 'MemAccPwd@accIndex');
    Route::get('accPwd/accAdUpd', 'MemAccPwd@accAdUpd');
    Route::post('accPwd/accPost', 'MemAccPwd@accPost');
    // Route::get('accPwd/accDel', 'MemAccPwd@accDel');
    Route::get('accPwd/pwdIndex', 'MemAccPwd@pwdIndex');
    Route::get('accPwd/pwdAdUpd', 'MemAccPwd@pwdAdUpd');
    Route::post('accPwd/pwdPost', 'MemAccPwd@pwdPost');
    // Route::get('accPwd/pwdDel', 'MemAccPwd@pwdDel');
    Route::get('accPwd/belongsToIndex', 'MemAccPwd@belongsToIndex');
    Route::get('accPwd/belongsToAdUpd', 'MemAccPwd@belongsToAdUpd');
    Route::post('accPwd/belongsToPost', 'MemAccPwd@belongsToPost');
    // Route::get('accPwd/belongsToDel', 'MemAccPwd@belongsToDel');
    
    Route::get('menu/index', 'Menu@index');
    Route::post('menu/getChild', 'Menu@getChild');
    Route::post('menu/adh', 'Menu@adh');
    Route::post('menu/updh', 'Menu@updh');
    Route::get('menu/del', 'Menu@del');
    Route::get('smenu/index', 'Menu@smenuList');
    Route::get('smenu/edit', 'Menu@smenuAdUpd');
    Route::post('smenu/post', 'Menu@smenuPost');

    Route::get('prorecord/index', 'Prorecord@index');
    Route::get('prorecord/info', 'Prorecord@info');
    Route::get('prorecord/ad', 'Prorecord@ad');
    Route::post('prorecord/adh', 'Prorecord@adh');
    Route::get('prorecord/upd', 'Prorecord@upd');
    Route::post('prorecord/updh', 'Prorecord@updh');
    Route::get('prorecord/del', 'Prorecord@del');
    Route::get('everyday/index', 'Prorecord@everyday');
    Route::get('everyday/edad', 'Prorecord@edad');
    Route::post('everyday/edadh', 'Prorecord@edadh');
    Route::get('everyday/edupd', 'Prorecord@edupd');
    Route::post('everyday/edupdh', 'Prorecord@edupdh');
    Route::get('everyday/details', 'Prorecord@details');
    Route::get('everyday/detad', 'Prorecord@detad');
    Route::post('everyday/detadh', 'Prorecord@detadh');
    Route::get('everyday/detupd', 'Prorecord@detupd');
    Route::post('everyday/detupdh', 'Prorecord@detupdh');

    Route::get('robot/index', 'Robot@index');
    Route::post('robot/adh', 'Robot@adh');

    Route::get('tbRecord/index', 'TBRecord@index');
    Route::get('tbRecord/tbLookup', 'TBRecord@tbLookup');
    Route::get('tbRecord/kvLookup', 'TBRecord@kvLookup');
    Route::get('tbRecord/del', 'TBRecord@del');
    Route::get('tbRecord/upd', 'TBRecord@upd');
    Route::post('tbRecord/updh', 'TBRecord@updh');
    Route::get('tbRecord/ad', 'TBRecord@ad');
    Route::post('tbRecord/adh', 'TBRecord@adh');

    Route::get('user/index', 'User@index');
    Route::get('user/ad', 'User@ad');
    Route::post('user/adh', 'User@adh');
    Route::get('user/upd', 'User@upd');
    Route::post('user/updh', 'User@updh');
    Route::post('user/del', 'User@del');
    Route::get('user/group', 'User@groupList');
    Route::get('user/gedit', 'User@gAdUpd');
    Route::post('user/gpost', 'User@gpost');

    #
    Route::get('test/t1', 'Test@t1');