<?php
namespace model;
use \core\Model;

class ImagesModel extends Model{

    protected $table = 'images';

    const C_TYPE = ['editorMd', 'xheditor'];
    const C_IS_USE = ['未使用', '已使用'];
}