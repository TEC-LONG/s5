<?php
namespace model;
use \core\Model;

class MenuPermissionModel extends Model{

    protected $table = 'menu_permission';

    const C_REQUEST = ['无', 'GET', 'POST', 'REQUEST'];
}