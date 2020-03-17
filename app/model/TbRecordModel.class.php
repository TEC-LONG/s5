<?php
namespace model;
use \core\Model;

class TbRecordModel extends Model{

    protected $table = 'tb_record';

    const C_BELONG_DB = ['exp', 'test', 'blog', 'store'];
}