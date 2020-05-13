<?php
namespace model;
use \core\Model;

class ArticleCategoryModel extends Model{

    protected $table = 'article_category';

    const C_LEVEL = ['1级节点', '2级节点', '3级节点'];
}