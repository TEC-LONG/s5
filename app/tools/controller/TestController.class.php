<?php
namespace tools\controller;
use \core\controller;

class TestController extends Controller {

    public function t(){
    
        // $row = M()->table('user')->select('name, age, height')
        // ->where(['id', '>', 10])
        // ->where("name='zhangsan'")
        // ->where([['age',12],['height', '<=', '2.0']])
        // ->find();

        // $row = M()->table('tb_record')->select('*')
        // ->where('id>0')
        // ->get();

        // $row = M()->table('tb_record as tr')
        // ->select('tr.id as tr_id, tr.en_name as tr_en_name, ts.en_name as ts_en_name, pr.title')
        // ->where('tr.id=1')
        // ->leftjoin('tb_special_field as ts', 'tr.id=ts.tb_record__id')
        // ->leftjoin('prorecord as pr', 'tr.id=pr.id')
        // ->get();

        // $row = M()->table('tb_record as tr');
        // $row = $row->select('tr.id as tr_id, tr.en_name as tr_en_name, ts.en_name as ts_en_name, pr.title');
        // $row = $row->where('tr.id=1');
        // $row = $row->leftjoin('tb_special_field as ts', 'tr.id=ts.tb_record__id');
        // $row = $row->leftjoin('prorecord as pr', 'tr.id=pr.id');
        // $row = $row->get();

        // echo '<pre>';
        
        // var_dump($row);
        // echo '<pre>';


        // $re = M()->table('menu')->fields('name, parent_id, post_date')
        // ->insert(['aa', 12, time()])
        // ->exec();

        // $re = M()->table('menu')
        // ->fields('name, parent_id, post_date')
        // ->insert('"bb", 12, '.time())
        // ->exec();

        // $re = M()->table('menu')
        // ->insert(['name'=>'ee', 'parent_id'=>17, 'post_date'=>time()])
        // ->exec();

        // $re = M()->table('menu')
        // ->fields('name, parent_id, post_date')
        // ->insert()
        // ->insert(['dd', 15, time()])
        // ->exec();

        // $re = M()->table('menu')
        // ->fields('name, parent_id, post_date')
        // ->insert([
        //     ['ff', 18, time()],
        //     ['gg', 14, time()],
        //     ['hh', 19, time()],
        //     ['ii', 21, time()]
        //     ])
        // ->exec();

        // $re = M()->table('menu')
        // ->fields('name, parent_id, post_date')
        // ->update(['aaab', 18, time()])
        // ->where(['id', '=', 1])
        // ->exec();


        // $re = M()->table('menu')
        // ->fields('name, parent_id, post_date')
        // ->update(['aaab', 18, time()])
        // ->where(['id', '=', 1])
        // ->fields('parent_id, post_date')
        // ->update([18, time()])
        // ->where([['id', 2],['age', '>=', '18']])
        // ->exec();

        $re = M()->table('menu')
        ->fields([
            ['name', 'parent_id', 'post_date'],
            ['name', 'parent_id'],
            ['parent_id', 'post_date']
        ])
        ->update([
            ['aaab', 18, time()],
            ['aaab', 18, time()],
            ['aaab', 18, time()]
        ])
        ->where(['id', 1])
        ->where(['age', '>=', 12])
        ->where(['height', '<', 2])
        ->exec();

        echo '<pre>';
        
        var_dump($re);
        echo '<pre>';
        

        
    }
}      
