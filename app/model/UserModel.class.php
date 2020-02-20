<?php
namespace model;
use \core\Model;

class UserModel extends Model{

    protected $table = 'user';
    private $_salt='';

    public function make_pwd($pwd, $salt=''){
    
        if($salt==='') $salt = $this->make_salt();
        return md5($salt . md5($pwd) . $salt);
    }

    public function make_salt(){
    

        if( $this->_salt==='' ){
            $this->_salt = F()->randStr();
        }

        return $this->_salt;
    }
}