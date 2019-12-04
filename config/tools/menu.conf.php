<?php

$configs['tools']['menu'] = array(
    'menu1'=>[ 
        '管理中心',
        //'我家庄园'
    ],
    'menu2'=>[  
        array( 
            0=>'帮助中心',
            1=>'建表工具',
            2=>'经验系统',
            3=>'vim快捷键',
            4=>'吃饭',
            5=>'工程管理系统'
        )
        //array(
            //0=>'首页',
            //1=>'产品详情页'
        //)
    ],
    'menu3'=>[ 
        array( 
            0=>[ '导航' ],
            1=>[ '表信息', '智能建表', '逆向分解' ],
            2=>[ 'exp列表', 'exp分类列表' ],
            3=>[ 'vim快捷键or操作列表', '模块列表' ],
            4=>[ '随机点餐' ],
            5=>[ '工程信息列表' ]
        )
        //array(
            //0=>array('顶部主要信息', '底部blog推荐'),
            //1=>array('顶部logo图', '导航菜单', '顶部banner图')
        //)
    ],
    'menu4'=>[
        array( 
            0=>[ 
                array( 'plat'=>'tools', 'module'=>'index', 'act'=>'selfmain', 'rel'=>'index_selfmain' )
            ],
            1=>[ 
                array( 'plat'=>'tools', 'module'=>'TbStruct', 'act'=>'index', 'rel'=>'TbStruct_index' ),
                array( 'plat'=>'tools', 'module'=>'AutoTb', 'act'=>'index', 'rel'=>'AutoTb_index' ),
                array( 'plat'=>'Apps', 'module'=>'Goods', 'act'=>'index', 'rel'=>'Goods' )
            ],
            2=>[ 
                array( 'plat'=>'tools', 'module'=>'exp', 'act'=>'index', 'rel'=>'exp_index' ),
                array( 'plat'=>'tools', 'module'=>'expcat', 'act'=>'index', 'rel'=>'expcat_index' )
                //array( 'plat'=>'tools', 'module'=>'expcat', 'act'=>'list', 'rel'=>'expcat', 'permission'=>6 )
            ],
            3=>[ 
                array( 'plat'=>'tools', 'module'=>'vimshortcut', 'act'=>'index', 'rel'=>'vimshortcut_index' ),
                array( 'plat'=>'tools', 'module'=>'vimshortcutmodule', 'act'=>'index', 'rel'=>'vimshortcutmodule_index' )
            ],
            4=>[ 
                array( 'plat'=>'tools', 'module'=>'chifan', 'act'=>'index', 'rel'=>'chifan_index' )
            ],
            5=>[ 
                array( 'plat'=>'tools', 'module'=>'prorecord', 'act'=>'index', 'rel'=>'prorecord_index' )
            ]
        )
        //array(
            //0=>array( 
                //array( 'plat'=>'Shop', 'module'=>'ManorPageHome', 'act'=>'index', 'rel'=>'ManorPageHome' ),
                //array( 'plat'=>'Shop', 'module'=>'ManorHomeBlog', 'act'=>'index', 'rel'=>'ManorHomeBlog' )
            //),
            //1=>array( 
                //array( 'plat'=>'Shop', 'module'=>'GoodsCat', 'act'=>'index', 'rel'=>'GoodsCat' ),
                //array( 'plat'=>'Shop', 'module'=>'GoodsBrand', 'act'=>'index', 'rel'=>'GoodsBrand' ),
                //array( 'plat'=>'Shop', 'module'=>'Index', 'act'=>'selfmain', 'rel'=>'main' )
            //)
        //)
    ]
);

