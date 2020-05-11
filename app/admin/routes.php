<?php

///  admin/

    Route::get('user/index', 'User@index')->navtab('admin_user_index');
    Route::get('user/add', 'User@showEdit')->navtab('admin_user_add');
    Route::get('user/upd', 'User@showEdit')->navtab('admin_user_upd');
    Route::post('user/post', 'User@post');
