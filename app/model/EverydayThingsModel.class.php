<?php
namespace model;
use \core\Model;

class EverydayThingsModel extends Model{

    protected $table = 'everyday_things';

    const C_STAT = ['未完成', '已完成'];
    const C_CHARACTE = ['不紧急-不重要', '不紧急-重要', '紧急-不重要', '紧急-重要'];
    const C_TYPE = ['工作', '学习', '生活'];
}