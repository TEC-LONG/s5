<?php
namespace model;
use \core\Model;

class TbSpecialFieldModel extends Model{

    protected $table = 'tb_special_field';

    const C_FIELD_TYPE = ['普通字段', '关联字段'];
}