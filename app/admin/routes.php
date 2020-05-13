<?php

///  admin/

    #用户管理
    Route::get('user/index', 'User@index')->navtab('admin_user_index')->name();
    Route::get('user/add', 'User@showEdit')->navtab('admin_user_add')->name('admin_user_index');
    Route::get('user/upd', 'User@showEdit')->navtab('admin_user_upd')->name('admin_user_index');
    Route::get('user/delete', 'User@del')->navtab('admin_user_index')->name('admin_user_index');
    Route::post('user/post', 'User@post')->name('admin_user_index');

    #文章分类
    Route::get('article/cate', 'ArticleCategory@index')->navtab('admin_article_category_index')->name();
    Route::post('article/cate/post', 'ArticleCategory@post')->navtab('admin_article_category_index')->name('admin_article_category_index');

    #文章
    Route::get('article', 'Article@index')->navtab('admin_article_index')->name();
    Route::get('article/add', 'Article@showEdit')->navtab('admin_article_add')->name('admin_article_index');
    Route::get('article/upd', 'Article@showEdit')->navtab('admin_article_upd')->name('admin_article_index');
    Route::post('article/post', 'Article@post')->name('admin_article_index');
    Route::get('article/delete', 'Article@del')->navtab('admin_article_index')->name('admin_article_index');

