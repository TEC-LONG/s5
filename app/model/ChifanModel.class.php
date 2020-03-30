<?php
namespace model;
use \core\Model;

class ChifanModel extends Model{

    protected $table = 'chifan';

    const C_TYPES = ['无','早餐','午餐','晚餐','睡前','休闲'];
    const C_MAIN_TYPE = ['无', '主食', '荤菜', '素菜', '均衡菜'];
    const C_SECOND_TYPE = ['无', '粥', '粉', '面', '饭', '汤', '点心', '菜'];
    // const C_TASTE = ['无', '酸', '甜', '苦', '辣', '咸', '香', '鲜', '无味', '辛辣'];
    // const C_MOUTHFEEL = ['软', '硬', '糯', '脆', 'Q弹', '丝滑', '入口即化', '嫩'];
    // effects = 0:温补|1:清热|2:解毒|3:去湿|4:安神|5:镇痛
}