<?php
namespace model;
use \core\Model;

class MenuModel extends Model{

    protected $table = 'menu';

    const C_LEVEL = [1=>'1级节点', '2级节点', '3级节点'];
}