<?php
namespace model;
use \core\Model;

class ArticleCategoryModel extends Model{

    protected $table = 'expcat';

    const C_LEVEL = ['1级节点', '2级节点', '3级节点'];
}