<?php
namespace tools\controller;
use \core\Controller;

class IndexController extends Controller {

    protected $_datas = [];

    public function index(){

        $this->_datas['menu1'] = M()->table('menu')->select('id,name,parent_id,level')->where([['is_del', 0],['level', 1]])->get();
        $this->_datas['menu2'] = M()->table('menu')->select('id,name,parent_id,level')->where([['is_del', 0],['level', 2]])->get();
        $this->_datas['menu3'] = M()->table('menu')->select('id,name,parent_id,level,plat,module,act,navtab,level3_type,level3_href,route')->where([['is_del', 0],['level', 3]])->get();

        $this->_datas['url'] = [
            'login_out' => ['url'=>L('/tools/login/quit')]
        ];

        $this->_datas['nav_link'] = [//最多八个大数组，每个大数组中最多12个元素
            [
                '百度统计' => 'http://tongji.baidu.com/web/welcome/login',
                '百度站长平台' => 'http://zhanzhang.baidu.com',
                '百度移动统计' => 'https://mtj.baidu.com/web/welcome/login',
                'just-my-socks' => 'https://justmysocks1.net/members/clientarea.php?action=productdetails&id=107355',
                'bootstrap4' => 'https://code.z01.com/v4/',
                'editor.md' => 'http://editor.md.ipandao.com/',
                'png转ico' => 'https://www.easyicon.net/covert/',
                'php在线手册' => 'https://www.php.net/manual/zh/function.base64-encode.php'
            ],
            [
                '百度网盘' => 'http://pan.baidu.com',
                'jq22官网' => 'https://www.jq22.com',
                'editplus插件' => 'https://www.editplus.com/files.html',
                'vscode-extension官网' => 'https://marketplace.visualstudio.com/VSCode',
                'composer包下载' => 'https://packagist.org/'
            ],
            [
                '慕课网' => 'https://www.imooc.com/',
                'runoob菜鸟' => 'https://www.runoob.com/',
                '树莓派' => 'https://shumeipai.nxez.com/'
            ],
            [
                '博客园' => 'https://www.cnblogs.com/',
            ]
        ];

        $this->assign($this->_datas);

	    $this->display('Index/index.tpl');
    }

    // public function selfmain() {
    
    //     $this->display('Index/main.tpl');
    // }
}
