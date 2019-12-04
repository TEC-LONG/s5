<?php

//功能所需的配置

$configs['tools']['AutoTb'] = array(

    ////WangXin2016/1/7.Autotb支持生成的mysql数据类型
    'fieldType' => [
        'varchar',
        'char',
        'tinyint',
        'smallint',
        'mediumint',
        'int',
        'bigint',
        'float',
        'double',
        'decimal',
        'mediumtext',
        'text'
    ],

    ////表管理  所属项目
    'COLUM_PRO' => [1=>'system', 2=>'funsens.fs_new', 3=>'funsens.fs_order', 4=>'fs_push', 5=>'blog']
);
