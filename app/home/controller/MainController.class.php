<?php

namespace home\controller;
use \core\Controller;

class MainController extends Controller{


    public function showIndex(){ 
        
        $this->display('main/main.tpl');
    }
}