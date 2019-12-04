<?php

$t_configs = array(

    'HOME' => array(
        'name' => 'HOME',
        'gvar' => 'p=admin&m=index&a=showUser'
    ),
    'user' => array(
        'name' => '用户管理系统',
        'son' => array(
            'user_list' => array('name'=>'用户列表', 'gvar'=>'p=admin&m=user&a=showList'),
            'user_ad' => array('name'=>'添加用户', 'gvar'=>'p=admin&m=user&a=showAd')
        ),
        'gvar' => 'p=admin&m=index&a=showList'
    )
);

$configs['tpl'] = $t_configs;