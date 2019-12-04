<?php

namespace admin\controller;
use \core\Controller;//引入空间类文件

class IndexController extends Controller{

    private $_fields;

    public function __construct(){ 
        parent::__construct();

        //$this->_fields['level'] = array('普通用户', '管理员');
        //$this->_fields['status'] = array('正常', '禁用');
    }

    #框架页
    public function index(){ 

        //$this->assign('fields', $this->_fields);
        $this->assign('tpl', C('tpl'));

        $this->display('nindex/index.tpl');
    }

    #点击页卡全部都是先请求这个方法（渲染页卡模板方法）
    public function showTab(){ 
        
        $dts = $_POST['dts']!='no' ? json_decode($_POST['dts']) : $_POST['dts'];
        $this->assign('dts', $dts);

        $this->display('ntab/tab.tpl');
    }
}

