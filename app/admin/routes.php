<?php

///  admin/

    #用户管理
    Route::get('user/index', 'User@index')->navtab('admin_user_index');
    Route::get('user/add', 'User@showEdit')->navtab('admin_user_add');
    Route::get('user/upd', 'User@showEdit')->navtab('admin_user_upd');
    Route::get('user/delete', 'User@del');
    Route::post('user/post', 'User@post');

    #文章分类
    Route::get('article/cate', 'ArticleCategory@index')->navtab('admin_article_category_index');
    Route::post('article/cate/post', 'ArticleCategory@post');

    #文章
    Route::get('article', 'Article@index')->navtab('admin_article_index');
    Route::get('article/add', 'Article@showEdit')->navtab('admin_article_add');
    Route::get('article/upd', 'Article@showEdit')->navtab('admin_article_upd');
    Route::post('article/post', 'Article@post');

