<?php
namespace tools\controller;
use \core\controller;

class ProrecordController extends Controller {

    ##标准预定义属性
    private $_datas = [];
    private $_url = [];
    private $_navTab;

    ##非标准预定义属性
    private $_belong_pro = [0=>'exp', 1=>'玖富', 2=>'综合'];


    public function __construct(){

        parent::__construct();

        $this->_navTab = 'prorecord';
        
        switch ( ACT ){
            case 'index':
                $this->_url = [
                    'info' => L(PLAT, MOD, 'info'),
                    'index' => L(PLAT, MOD, 'index'),
                    'ad' => ['url'=>L(PLAT, MOD, 'ad'), 'rel'=>$this->_navTab.'_ad'],
                    'upd' => ['url'=>L(PLAT, MOD, 'upd'), 'rel'=>$this->_navTab.'_upd'],
                    'del' => L(PLAT, MOD, 'del')
                ];
            break;
            case 'ad':
                $this->_url = [
                    'adh' => L(PLAT, MOD, 'adh'),
                    'editormdImgUp' => L(PLAT, 'editor', 'imgupmd'),
                    'editormd' => L(PLAT, 'editor', 'editormd')
                ];
            break;
            case 'upd':
                $this->_url = [
                    'updh' => L(PLAT, MOD, 'updh'),
                    'editormdImgUp' => L(PLAT, 'editor', 'imgupmd'),
                    'editormd' => L(PLAT, 'editor', 'editormdupd')
                ];
            break;
        }
    }

    public function index(){ 

        #分页参数
        $page = $this->_page('prorecord', ['is_del'=>0]);
        
        //查询数据
        $sql = 'select id, belong_pro, title from prorecord where is_del=0 limit ' . $page['limitM'] . ',' . $page['numPerPage'];
        $prorecords = M()->getRows($sql);


        //分配模板变量&渲染模板
        $this->assign([
            'prorecords'=>$prorecords,
            'belong_pro'=>$this->_belong_pro,
            'page'=>$page,
            'url'=>$this->_url
        ]);
        $this->display('Prorecord/index.tpl');
    }

    public function info(){ 

        #接收数据
        $id = $_GET['id'];
        
        #查询数据
        $sql = 'select * from prorecord where id=' . $id;
        $prorecord = M()->getRow($sql);

        #将内容数据写入editormd读取的文件中，这里需要注意的是这么写只适用于单用户操作，如果有多用户操作，那么将会存在相互覆盖编辑或查看内容的风险
        file_put_contents(PUBLIC_PATH . 'tools/editor_md/examples/test.md', htmlspecialchars_decode($prorecord['content']));

        $this->assign([
            'prorecord'=>$prorecord,
            'belong_pro'=>$this->_belong_pro
        ]);

        $this->display('Prorecord/info.tpl');
    }

    public function ad(){ 

        $this->assign([
            'belong_pro'=>$this->_belong_pro,
            'url'=>$this->_url
        ]);

        $this->display('Prorecord/ad.tpl');
    }

    public function adh(){ 
        //接收数据
        $datas = [
            'title' => $_POST['title'],
            'belong_pro' => $_POST['belong_pro'],
            'content' => htmlspecialchars($_POST['content_ad']),
            'post_date' => time()
        ];

        //执行新增
        if( M()->setData('prorecord', $datas) ){
            $re = AJAXre();
            $re->navTabId = $this->_navTab.'_ad';
            $re->message = '添加成功！';
        }else{
            $re = AJAXre(1);
        }

        #返回结果
        echo json_encode($re); 
        exit;
    }

    public function upd(){ 
        
        //接收参数
        $id = $_GET['id'];

        //查询数据
        $sql = 'select * from prorecord where id=' . $id;
        $prorecord = M()->getRow($sql);

        $this->assign([
            'url'=>$this->_url,
            'belong_pro'=>$this->_belong_pro,
            'prorecord'=>$prorecord
        ]);

        $this->display('Prorecord/upd.tpl');
    }

    public function updh(){ 
        //接收数据
        $con = ['id'=>$_GET['id']];

        $datas = [
            'title' => $_POST['title'],
            'belong_pro' => $_POST['belong_pro'],
            'content' => htmlspecialchars($_POST['content_upd'])
        ];

        //执行更新操作
        if( M()->setData('prorecord', $datas, 2, $con) ){
            $re = AJAXre();
            $re->navTabId = $this->_navTab.'_upd';
            $re->message = '更新成功！';
        }else{
            $re = AJAXre(1);
        }

        #返回结果
        echo json_encode($re); 
        exit;
    }

    public function del(){

        $con = ['id'=>$_GET['id']];

        //将需要删除的数据 is_del字段设置为1
        if( M()->setData('prorecord', ['is_del'=>1], 2, $con) ){
            $re = AJAXre();
            $re->navTabId = $this->_navTab.'_index';
            $re->message = '删除成功！';
        }else{
            $re = AJAXre(1);
        }

        echo json_encode($re);
        exit;
    }

    
}      
