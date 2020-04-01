<?php
namespace blog\controller;
use \core\Controller;

class IndexController extends Controller {

    public function index(){

        $this->display('blog.tpl');
    }

    public function info(){
        $this->display('info.tpl');
    }
}
