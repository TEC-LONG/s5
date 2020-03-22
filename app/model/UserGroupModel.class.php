<?php
namespace model;
use \core\Model;

class UserGroupModel extends Model{

    protected $table = 'user_group';

    public function getAll(){
    
        return $this->select('*')->where(1)->get();
    }

}