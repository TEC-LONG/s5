<?php
namespace tools\controller;
use \core\controller;

class TestController extends Controller {

    public function t(){
    
        // 小内存型
        $pinyin = M('\Overtrue\Pinyin\Pinyin'); // 默认
        var_dump($pinyin);
        // 内存型
        // $pinyin = new Pinyin('Overtrue\Pinyin\MemoryFileDictLoader');
        // I/O型
        // $pinyin = new Pinyin('Overtrue\Pinyin\GeneratorFileDictLoader');

        // $pinyin->convert('带着希望去旅行，比到达终点更美好');
        // ["dai", "zhe", "xi", "wang", "qu", "lyu", "xing", "bi", "dao", "da", "zhong", "dian", "geng", "mei", "hao"]

        // $pinyin->convert('带着希望去旅行，比到达终点更美好', PINYIN_TONE);
        // ["dài","zhe","xī","wàng","qù","lǚ","xíng","bǐ","dào","dá","zhōng","diǎn","gèng","měi","hǎo"]

        // $pinyin->convert('带着希望去旅行，比到达终点更美好', PINYIN_ASCII_TONE);
        //["dai4","zhe","xi1","wang4","qu4","lyu3","xing2","bi3","dao4","da2","zhong1","dian3","geng4","mei3","hao3"]

        // $row = M()->table('user')->select('name, age, height')
        // ->where(['id', '>', 10])
        // ->where("name='zhangsan'")
        // ->where([['age',12],['height', '<=', '2.0']])
        // ->find();

        // $row = M()->table('tb_record')->select('*')
        // ->where('id=100')
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
        // exit;
        


        // $re = M()->table('menu')
        // ->fields('name, parent_id, post_date')
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

        // //批量更新
        // $re = M()->table('menu')
        // ->fields([
        //     ['name', 'parent_id', 'post_date'],
        //     ['name', 'parent_id'],
        //     ['parent_id', 'post_date']
        // ])
        // ->update([
        //     ['a', 18, time()],
        //     ['b', 18],
        //     ['c', time()]//字段和数据不一致，将会回滚
        // ])
        // ->where(['id', 1])
        // ->where(['id', 2])
        // ->where(['id', 3])
        // ->exec();

        // $re = M()->table('menu')
        // ->fields([
        //     ['name', 'parent_id', 'post_date'],
        //     ['name', 'parent_id'],
        //     ['parent_id', 'post_date']
        // ])
        // ->update([
        //     ['a', 18, time()],
        //     ['b', 18],
        //     [21, time()]//字段和数据不一致，将会回滚
        // ])
        // ->where(['id', 1])
        // ->where(['id', 2])
        // ->where(['id', 3])
        // ->exec();

        //删除操作
        // $re = M()->table('menu')
        // ->where(['id', 'in', '(1, 2, 3)'])
        // ->delete();

        // echo '<pre>';
        
        // var_dump($re);
        // echo '<pre>';
        

        
    }
}      
