<?php
namespace model;
use \core\Model;

class MenuPermissionModel extends Model{

    protected $table = 'menu_permission';

    const C_REQUEST = ['无', 'GET', 'POST', 'REQUEST'];

    public function getAllLevelMenu(){
    
        ///查询一级、二级、三级菜单及其相关的权限菜单
        $lv1 = $this->table('menu_permission as mp')->select('m.name as mname, m.parent_id as pid, mp.*, p.name as pname, p.flag')
        ->leftjoin('menu as m', 'mp.menu__id=m.id')
        ->leftjoin('permission as p', 'mp.permission__id=p.id')->where([
            ['m.is_del', 0],
            ['m.level', 1]
        ])->get();

        $lv2 = $this->table('menu_permission as mp')->select('m.name as mname, m.parent_id as pid, mp.*, p.name as pname, p.flag')
        ->leftjoin('menu as m', 'mp.menu__id=m.id')
        ->leftjoin('permission as p', 'mp.permission__id=p.id')->where([
            ['m.is_del', 0],
            ['m.level', 2]
        ])->get();

        $lv3 = $this->table('menu_permission as mp')->select('m.name as mname, m.parent_id as pid, mp.*, p.name as pname, p.flag')
        ->leftjoin('menu as m', 'mp.menu__id=m.id')
        ->leftjoin('permission as p', 'mp.permission__id=p.id')->where([
            ['m.is_del', 0],
            ['m.level', 3],
            ['mp.parent_id', 0]
        ])->get();

        $lv4 = $this->table('menu_permission as mp')->select('m.name as mname, m.parent_id as pid, mp.*, p.name as pname, p.flag')
        ->leftjoin('menu as m', 'mp.menu__id=m.id')
        ->leftjoin('permission as p', 'mp.permission__id=p.id')->where([
            ['m.is_del', 0],
            ['m.level', 3],
            ['mp.parent_id', '<>', 0]
        ])->get();

        #组装数据
        $all = [];
        $count2 = 0;
        $count3 = 0;
        foreach( $lv1 as $k1=>$v1){
        
            $all[$k1]['lv1'] = $v1;
            foreach( $lv2 as $k2=>$v2){
                
                if( $v2['pid']==$v1['menu__id'] ){

                    $all[$k1]['lv2'][$count2]['menu'] = $v2;
                    unset($lv2[$k2]);
                    foreach( $lv3 as $k3=>$v3){
                
                        if( $v3['pid']==$v2['menu__id'] ){
                        
                            // $all[$k1]['lv3'][$count3]['menu'] = $v3;
                            $all[$k1]['lv2'][$count2]['son'][$count3] = $v3;
                            unset($lv3[$k3]);
                            foreach( $lv4 as $k4=>$v4){
                            
                                if( $v4['parent_id']==$v3['id'] ){
                                    // $all[$k1]['lv3'][$count3]['son'][] = $v4;
                                    $all[$k1]['lv2'][$count2]['son'][$count3]['son'][] = $v4;
                                    unset($lv4[$k4]);
                                }
                            }
                            $count3++;
                        }
                    }
                    $count2++;
                }
            }
        }
        
        return $all;
    }
}