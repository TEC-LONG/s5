<?php
namespace tools\controller;
use \core\controller;
use \Overtrue\Pinyin\Pinyin;
class TestController extends Controller {

    private $_datas=[];
    public function t2(){
    
        $this->_datas['row'] = $row = M()->table('prorecord')->select('*')->where(['id', 10])->find();
        // F()->print_r($this->_datas['row']['content_html']);
        $this->assign($this->_datas);
        $this->display('test/t2.tpl');
    }
    public function log(){
    
        // R()->msg('错误码：00x62')
        // ->msg('出错的行：235')
        // ->msg('文件路径：X/xx/xxxx/xxxxx/xx.xx')
        // ->msg('错误信息：阿发的手法都是谁打的舒服的')
        // ->go();

        M()->table('aabb')->select('*')->where(['id', '>', 1])->get();
    }

    public function upfile(){

        $this->display('test/upfile_index.tpl');
    
    }
    public function upfileh(){
    
        // echo '<pre>';
        
        // var_dump($_FILES);
        // echo '<pre>';

        // $storage = new \Upload\Storage\FileSystem(UPLOAD_PATH);
        // $storage = M('\Upload\Storage\FileSystem', UPLOAD_PATH);
        // $file = new \Upload\File('img', $storage);
        // $file = M('\Upload\File', ['img', $storage]);

        // $file_input_name_arr = F()->file_arrange('img');
        // var_dump($file_input_name_arr);
        // echo '<pre>';
        // print_r($_FILES);
        // echo '<pre>';

        // $file = [];
        // foreach( $file_input_name_arr as $k=>$v){
        //     $file[$k] = F()->file($v)->up('img_');
        //     var_dump($file[$k]->getNameWithExtension());
        //     echo '<hr/>';
            
        // }

        // echo '<pre>';
        // print_r($file);
        // echo '<pre>';

        $file = F()->file('img')->up('img_');
        echo '<pre>';
        
        var_dump($file->getErrors());
        echo '<pre>';
    }

    public function t(){
    
        // 小内存型
        $pinyin = M('\Overtrue\Pinyin\Pinyin'); // 默认
        // $pinyin1 = new Pinyin();
        // var_dump($pinyin1);
        var_dump($pinyin);
        // 内存型
        // $pinyin = new Pinyin('Overtrue\Pinyin\MemoryFileDictLoader');
        // I/O型
        // $pinyin = new Pinyin('Overtrue\Pinyin\GeneratorFileDictLoader');

        $re = $pinyin->convert('带着希望去旅行，比到达终点更美好');
        echo '<pre>';
        
        var_dump($re);
        echo '<pre>';
        // ["dai", "zhe", "xi", "wang", "qu", "lyu", "xing", "bi", "dao", "da", "zhong", "dian", "geng", "mei", "hao"]

        $re = $pinyin->convert('带着希望去旅行，比到达终点更美好', PINYIN_TONE);
        echo '<pre>';
        var_dump($re);
        echo '<pre>';
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
