<?php

namespace admin\controller;
use \core\Controller;//引入空间类文件

class TestController extends Controller{

    private $_model;

    public function test(){ 
        
        $this->_model = M();

        if( $this->_model ){
            echo '部署成功！'; 
            echo '模型对象为：<br/>'; 
            var_dump( $this->_model ); 
        }else{
            echo '部署失败，请检查数据库配置是否正确！'; 
        }
        
    }
}

