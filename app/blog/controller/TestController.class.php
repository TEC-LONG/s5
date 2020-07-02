<?php

namespace blog\controller;
use \core\Controller;
use \Validator;

class TestController extends Controller{


    public function index(){ 
        
        $obj = Validator::make([
            'mail'          => 'aaaa',
            'goods_num'     => '300个'
        ], [
            'mail'          => 'required$||email$||int',#  <=== 即便是矛盾的规则，也是允许的（警告：指定矛盾的规则，则该字段将永远存在违规）；如果违反了多个规则，则该字段违规信息将采用最后一个；
            'goods_num'     => 'required$||int'
        ],[
            'mail.required'         => 's511111111111',
            'goods_num.required'    => 's533333333333',
            'goods_num.int'         => 's544444444444'
        ]);

        echo '<pre>';
        print_r($obj->err);
        echo '<pre>';
    }

}