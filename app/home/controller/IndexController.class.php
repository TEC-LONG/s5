<?php

namespace home\controller;
use \core\Controller;

class IndexController extends Controller{


    public function showIndex(){ 
        
        $this->display('index/index.tpl');
    }

    public function test(){
        
        echo '<pre>';
        
        var_dump($_SERVER['REQUEST_URI']);
        echo '<pre>';
    }
}