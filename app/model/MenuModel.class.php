<?php
namespace model;
use \core\Model;

class MenuModel extends Model{

    protected $table = 'menu';

    const C_LEVEL = [1=>'1级节点', '2级节点', '3级节点'];
    const C_LEVEL3_TYPE = ['内部跳转链接', '外部跳转链接'];
}