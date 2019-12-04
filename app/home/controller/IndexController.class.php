<?php

namespace home\controller;
use \core\Controller;

class IndexController extends Controller{


    public function showIndex(){ 
        
        $this->display('index/index.tpl');
    }
}