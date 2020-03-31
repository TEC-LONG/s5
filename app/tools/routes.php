<?php

///  tools/

    #登录相关
    Route::get('login/index', 'Login@index');##登录页
    Route::get('login/capture', 'Login@showCheckcodeImg');##验证码
    Route::get('login/quit', 'Login@logout');##退出
    Route::post('login/check', 'Login@checklogin');##校验

    #后台页面
    Route::get('index', 'Index@index');##首页

    #功能组
    Route::request('tbIntelligence/index', 'AutoTb@index')->navtab('AutoTb_index');##智能建表
    Route::post('tbIntelligence/stepOne', 'AutoTb@stepOne');
    Route::post('tbIntelligence/stepTwo', 'AutoTb@stepTwo');

    Route::get('tbRecord/index', 'TBRecord@index')->navtab('tools_TBRecord_index');##表信息管理列表
    Route::get('tbRecord/upd', 'TBRecord@upd')->navtab('tools_TBRecord_upd');
    Route::get('tbRecord/ad', 'TBRecord@ad')->navtab('tools_TBRecord_add');
    // Route::get('tbRecord/tbLookup', 'TBRecord@tbLookup');##智能后台使用到的查找带回    智能后台已搁置
    // Route::get('tbRecord/kvLookup', 'TBRecord@kvLookup');##智能后台使用到的查找带回    智能后台已搁置
    Route::post('tbRecord/del', 'TBRecord@del');
    Route::post('tbRecord/updh', 'TBRecord@updh');
    Route::post('tbRecord/adh', 'TBRecord@adh');

    #物料系统
    Route::get('chifan/list', 'Chifan@index')->navtab('tools_chifan_index');##菜品列表
    Route::get('chifan/edit', 'Chifan@adUpd')->navtab('tools_chifan_AdUpd');
    Route::post('chifan/del', 'Chifan@del');
    Route::post('chifan/post', 'Chifan@post');

    #富文本编辑器程序
    Route::post('editormd/imgUp', 'Editor@imgupmd');##editorMd
    Route::post('editorbd/imgUp', 'Editor@imgupbd');##xheditor

    #经验系统
    Route::get('exp/index', 'Exp@index')->navtab('tools_exp_index');##EXP管理
    Route::get('exp/info', 'Exp@info');##EXP详情
    Route::get('exp/ad', 'Exp@ad')->navtab('tools_exp_ad');
    Route::get('exp/upd', 'Exp@upd')->navtab('tools_exp_upd');
    Route::post('exp/adh', 'Exp@adh');
    Route::post('exp/updh', 'Exp@updh');
    // Route::post('exp/imgupmd', 'Exp@imgupmd');

    Route::get('expcat/index', 'Expcat@index')->navtab('tools_expcat_index');##EXP分类
    Route::post('expcat/getChild', 'Expcat@getChild');
    Route::post('expcat/adh', 'Expcat@adh');
    Route::post('expcat/edith', 'Expcat@edith');
    Route::get('expcat/catLookup', 'Expcat@catLookup');##分类查找带回

    Route::get('event/index', 'Event@index')->navtab('tools_event_index');##大事件
    Route::get('event/ad', 'Event@ad')->navtab('tools_event_ad');
    Route::get('event/upd', 'Event@upd')->navtab('tools_event_upd');
    Route::post('event/adh', 'Event@adh');
    Route::post('event/updh', 'Event@updh');
    Route::post('event/del', 'Event@del');

    #记忆系统
    Route::get('accPwd/index', 'MemAccPwd@index')->navtab('tools_memAccPwd_index');##工程信息管理
    Route::post('accPwd/edit', 'MemAccPwd@adUpd');
    Route::post('accPwd/post', 'MemAccPwd@post');
    Route::post('accPwd/del', 'MemAccPwd@del');
    Route::get('accPwd/accIndex', 'MemAccPwd@accIndex');##账号列表
    Route::get('accPwd/accAdUpd', 'MemAccPwd@accAdUpd');
    Route::post('accPwd/accPost', 'MemAccPwd@accPost');
    // Route::post('accPwd/accDel', 'MemAccPwd@accDel');
    Route::get('accPwd/pwdIndex', 'MemAccPwd@pwdIndex');##密码列表
    Route::get('accPwd/pwdAdUpd', 'MemAccPwd@pwdAdUpd');
    Route::post('accPwd/pwdPost', 'MemAccPwd@pwdPost');
    // Route::post('accPwd/pwdDel', 'MemAccPwd@pwdDel');
    Route::get('accPwd/belongsToIndex', 'MemAccPwd@belongsToIndex');##归属方列表
    Route::get('accPwd/belongsToAdUpd', 'MemAccPwd@belongsToAdUpd');
    Route::post('accPwd/belongsToPost', 'MemAccPwd@belongsToPost');
    // Route::post('accPwd/belongsToDel', 'MemAccPwd@belongsToDel');

    Route::get('prorecord/index', 'Prorecord@index')->navtab('tools_prorecord_index');##工程信息管理
    Route::get('prorecord/info', 'Prorecord@info');
    Route::get('prorecord/ad', 'Prorecord@ad');
    Route::post('prorecord/adh', 'Prorecord@adh');
    Route::get('prorecord/upd', 'Prorecord@upd');
    Route::post('prorecord/updh', 'Prorecord@updh');
    Route::post('prorecord/del', 'Prorecord@del');

    Route::get('everyday/index', 'Prorecord@everyday')->navtab('tools_prorecord_everyday');##每日日程安排
    Route::get('everyday/edad', 'Prorecord@edad');
    Route::post('everyday/edadh', 'Prorecord@edadh');
    Route::get('everyday/edupd', 'Prorecord@edupd');
    Route::post('everyday/edupdh', 'Prorecord@edupdh');
    Route::get('everyday/details', 'Prorecord@details');
    Route::get('everyday/detad', 'Prorecord@detad');
    Route::post('everyday/detadh', 'Prorecord@detadh');
    Route::get('everyday/detupd', 'Prorecord@detupd');
    Route::post('everyday/detupdh', 'Prorecord@detupdh');
    
    #后台设置
    Route::get('menu/index', 'Menu@index')->navtab('tools_menu_index');##后台菜单管理
    Route::post('menu/getChild', 'Menu@getChild');
    Route::post('menu/adh', 'Menu@adh');
    Route::post('menu/updh', 'Menu@updh');
    Route::post('menu/del', 'Menu@del');

    // Route::get('robot/index', 'Robot@index');
    // Route::post('robot/adh', 'Robot@adh');

    Route::get('user/index', 'User@index')->navtab('tools_user_index');##后台管理员
    Route::get('user/ad', 'User@ad')->navtab('tools_user_ad');
    Route::get('user/upd', 'User@upd')->navtab('tools_user_upd');
    Route::post('user/adh', 'User@adh');
    Route::post('user/updh', 'User@updh');
    Route::post('user/del', 'User@del');

    Route::get('user/group', 'User@groupList')->navtab('tools_user_group');##用户组管理
    Route::get('user/gedit', 'User@gAdUpd')->navtab('tools_user_edit');
    Route::post('user/gpost', 'User@gPost');

    Route::get('user/gpermission', 'User@groupPermission')->navtab('tools_user_gpermission');##用户组管理--设置用户组权限
    Route::get('user/gpedit', 'User@groupPermissionEdit')->navtab('tools_user_gpedit');
    Route::post('user/gppost', 'User@groupPermissionPost');

    Route::get('permission/index', 'Permission@index')->navtab('tools_permission_index');##权限管理列表
    Route::get('permission/pedit', 'Permission@pAdUpd')->navtab('tools_permission_pedit');
    Route::post('permission/ppost', 'Permission@pPost');
    Route::post('permission/del', 'Permission@del');

    Route::get('permission/mpindex', 'Permission@menuPermissionIndex')->navtab('tools_permission_mpindex');##菜单权限管理
    Route::get('permission/mpedit', 'Permission@menuPermissionEdit')->navtab('tools_permission_mpAdUpd');
    Route::post('permission/mppost', 'Permission@menuPermissionPost');

    #
    Route::get('test/t1', 'Test@t1');