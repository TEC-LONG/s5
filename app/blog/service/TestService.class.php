<?php
namespace blog\service;
use \Validator;

class TestService {

    public function checkRequest($request){
    
        $obj = Validator::make($request, [
            'goods_num'     => 'required$||int$|max&:100$|min&:10'
        ]);

        if( !empty($obj->err) ){
            JSON()->stat(300)->msg($obj->getErrMsg())->exec();
        }
    }
}      
