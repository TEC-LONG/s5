<?php
namespace model;
use \core\Model;

class SmenuModel extends Model{

    protected $table = 'smenu';

    const C_LINK_TYPE = ['内部跳转链接', '外部跳转链接'];
    const C_REQUEST_TYPE = ['get', 'post', 'request'];
}