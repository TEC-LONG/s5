<?php

///  admin/

    Route::get('user/index', 'User@index')->navtab('admin_user_index');
    Route::get('user/add', 'User@adUpd')->navtab('admin_user_add');
    Route::get('user/upd', 'User@adUpd')->navtab('admin_user_upd');
    Route::get('user/post', 'User@post');
