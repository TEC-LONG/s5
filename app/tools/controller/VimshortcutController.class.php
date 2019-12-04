<?php
namespace tools\controller;
use \core\controller;

class VimshortcutController extends Controller {

    private $_datas = [];
    private $_url = [];
    private $_first_key = [];
    private $_navTab;

    public function __construct(){

        parent::__construct();

        $this->_navTab = 'vimshortcut';
        
        switch ( ACT ){
            case 'index':
                $this->_url = [
                    'ad' => ['url'=>L(PLAT, MOD, 'ad'), 'rel'=>$this->_navTab.'_ad'],
                    'edit' => L(PLAT, MOD, 'edit'),
                    'del' => L(PLAT, MOD, 'del')
                ];
            break;
            case 'ad':
                $this->_url = [
                    'adh' => L(PLAT, MOD, 'adh')
                ];
            break;
            case 'adh':
                $this->_first_key = ['leader', 'Ctrl', 'Shift', 'Alt', 'Ctrl-Shift', 'Ctrl-Alt', 'Shift-Alt'];
            break;
        }
    }

    public function index(){ 

        //查询数据
        $sql = 'select id, shortcut, key_comment, is_multipart, key_multi_comment from vimshortcut where 1 limit 10';
        $keys = M()->getRows($sql);

        //分配模板变量&渲染模板
        $this->assign([
            'keys'=>$keys,
            'url'=>$this->_url
        ]);
        $this->display('Vimshortcut/index.tpl');
    }

    public function ad(){ 

        $this->assign([
            'url'=>$this->_url
        ]);

        $this->display('Vimshortcut/ad.tpl');
    }

    public function adh(){ 
        //接收数据
        $datas = [
            'first_key' => $this->_first_key[intval($_POST['first_key'])],
            'second_key' => $_POST['second_key'],
            'shortcut' => $this->_first_key[intval($_POST['first_key'])] . '-' . $_POST['second_key'],
            'key_comment' => $_POST['key_comment'],
            'is_multipart' => $_POST['is_multipart']
        ];

        if( $datas['is_multipart']==1 ){
            $datas['key_multi_comment'] = $_POST['key_multi_comment'];
        }

        //执行新增
        if( M()->setData('vimshortcut', $datas) ){
            $re = AJAXre();
            $re->navTabId = $this->_navTab.'_ad';
            $re->message = '添加成功！';
        }else{
            $re = AJAXre(1);
        }

        #返回结果
        echo json_encode($re); 
        exit;
    }

    

    
}      
