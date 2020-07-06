<?php

namespace blog\controller;
use \core\Controller;
use \Validator;

class TestController extends Controller{


    public function index1(){ 
        
        $user_service   = M('TestService');
        $request        = [
            'goods_num'     => 300
        ];

        $user_service->checkRequest($request);
    }

    public function index(){ 
        
        $json = JSON()->arr(['name'=>'lisi', 'age'=>12])->vars([
            ['name', 'wangwu'],
            ['success', 1],
            ['message', '上传成功！']
        ])->exec('return');

        echo $json;
    }

}