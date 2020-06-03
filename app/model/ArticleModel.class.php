<?php
namespace model;
use \core\Model;

class ArticleModel extends Model{

    protected $table = 'article';

    public function getArticleById($id){
    
        return $this->select('*')->where(['id', $id])->find();
    }
}