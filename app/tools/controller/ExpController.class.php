<?php
namespace tools\controller;
use \core\controller;

class ExpController extends Controller {

    private $_datas = [];
    private $_url = [];
    private $_navTab;

    public function __construct(){

        parent::__construct();

        $this->_navTab = 'exp';
        
        switch ( ACT ){
            case 'index':
                $this->_url = [
                    'info' => L(PLAT, MOD, 'info'),
                    'ad' => ['url'=>L(PLAT, MOD, 'ad'), 'rel'=>$this->_navTab.'_ad'],
                    'upd' => ['url'=>L(PLAT, MOD, 'upd'), 'rel'=>$this->_navTab.'_upd'],
                    'del' => L(PLAT, MOD, 'del'),
                    'catLookup' => L(PLAT, 'expcat', 'catLookup')
                ];
            break;
            case 'ad':
                // $this->_url = [
                //     'adh' => L(PLAT, MOD, 'adh'),
                //     'editormdImgUp' => L(PLAT, 'editor', 'imgupmd'),
                //     'editormd' => L(PLAT, 'editor', 'editormd'),
                //     'editorImgUp' => L(PLAT, MOD, 'imgup'),
                //     'editorImgDel' => L(PLAT, MOD, 'imgdel'),
                //     'editorImgLoad' => L(PLAT, MOD, 'imgload'),
                //     'catLookup' => L(PLAT, 'expcat', 'catLookup')
                // ];
                $this->_url = [
                    'adh' => L(PLAT, MOD, 'adh'),
                    'editormdImgUp' => L(PLAT, 'editor', 'imgupmd'),
                    'editormd' => L(PLAT, 'editor', 'editormd'),
                    'catLookup' => L(PLAT, 'expcat', 'catLookup')
                ];
            break;
            case 'upd':
                $this->_url = [
                    'updh' => L(PLAT, MOD, 'updh'),
                    'editormdImgUp' => L(PLAT, 'editor', 'imgupmd'),
                    'editormd' => L(PLAT, 'editor', 'editormdupd'),
                    'catLookup' => L(PLAT, 'expcat', 'catLookup')
                ];
            break;
            case 'editormd':
                $this->_url = [
                    'editormdImgUp' => L(PLAT, MOD, 'imgupmd')
                ];
            break;
        }
    }

    public function index(){ 

        //查询数据
        $sql = 'select id, title, tags, crumbs_expcat_names, post_date from expnew where is_del=0';
        $exps = M()->getRows($sql);

        //分配模板变量&渲染模板
        $this->assign([
            'exps'=>$exps,
            'url'=>$this->_url
        ]);
        $this->display('Exp/index.tpl');
    }

    public function info(){ 

        #接收数据
        $id = $_GET['id'];
        
        #查询数据
        $sql = 'select * from expnew where id=' . $id;
        $exp = M()->getRow($sql);

        #将内容数据写入editormd读取的文件中
        file_put_contents(PUBLIC_PATH . 'tools/editor_md/examples/test.md', htmlspecialchars_decode($exp['content']));

        $this->assign('exp', $exp);
        
        $this->display('Exp/info.tpl');
    }

    /* public function ad(){ 

        $editor = isset($_GET['editor']) ? $_GET['editor'] : 'coding';//coding表示使用带markdown的editor;normal表示使用普通editor
        $token = isset($_COOKIE['tk']) ? $_COOKIE['tk'] : uniqid('bjq_') . mt_rand(0, 1000);
        setcookie('tk', $token, time()+3600);

        #每次进入都清掉未使用且过期的图片(1.清掉实际图片；2.清掉数据表中的记录)
        #这个操作应该使用额外的进程来执行，不要放在这里操作（当前我一个人使用就无所谓）
        //1. 清掉实际图片；
        $sql = 'select img from froala_edit_img where has_use=0 and post_date<='.(time()-7200);
        $arr_clearImgs = M()->getRows($sql);

        foreach( $arr_clearImgs as $arr_clearImg ){ 
            $t_path = ROOT . '/' . $arr_clearImg['img'];
            @unlink($t_path);
        }
        //2.清掉数据表中的记录
        $sql = 'delete from froala_edit_img where has_use=0 and post_date<='.(time()-7200);
        $re = M()->setData1($sql);

        $this->assign([
            'url'=>$this->_url,
            'tk'=>$token
        ]);

        if($editor=='coding') $this->display('Exp/ad1.tpl');
        elseif($editor=='normal') $this->display('Exp/ad.tpl');
    } */

    public function ad(){

        $this->assign([
            'url'=>$this->_url
        ]);

        $this->display('Exp/ad1.tpl');
    }

    public function adh(){ 
        #接收数据
        $datas = [];
        $datas['title'] = $_POST['title'];
        $datas['tags'] = $_POST['tags'];
        $datas['post_date'] = time();
        $datas['content'] = htmlspecialchars($_POST['content_ad']);
        $datas['expcat__id'] = $_POST['expcat_cat1id'];
        $datas['expcat__name'] = $_POST['expcat_cat1name'];
        $datas['crumbs_expcat_ids'] = $_POST['expcat_cat1id'] . '|' . $_POST['expcat_cat2id'] . '|' . $_POST['expcat_cat3id'];
        $datas['crumbs_expcat_names'] = $_POST['expcat_cat1name'] . '|' . $_POST['expcat_cat2name'] . '|' . $_POST['expcat_cat3name'];

        #录入数据
        if( M()->setData('expnew', $datas) ){
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
        $sql = 'select id, title, tags, crumbs_expcat_ids, crumbs_expcat_names from expnew where id=' . $id;
        
        if( $exp = M()->getRow($sql) ){
            $exp['crumbs_expcat_ids'] = explode('|', $exp['crumbs_expcat_ids']);
            $exp['crumbs_expcat_names'] = explode('|', $exp['crumbs_expcat_names']);
        }
        $this->assign([
            'url'=>$this->_url,
            'exp'=>$exp
        ]);

        $this->display('Exp/upd.tpl');
    }
    public function updh(){ 
        #接收数据
        //条件
        $con = ['id'=>$_GET['id']];
        //数据
        $datas = [];
        $datas['title'] = $_POST['title'];
        $datas['tags'] = $_POST['tags'];
        $datas['post_date'] = time();
        if(!empty($_POST['content_upd'])) $datas['content']=htmlspecialchars($_POST['content_upd']);;
        $datas['expcat__id'] = $_POST['expcat_cat1id'];
        $datas['expcat__name'] = $_POST['expcat_cat1name'];
        $datas['crumbs_expcat_ids'] = $_POST['expcat_cat1id'] . '|' . $_POST['expcat_cat2id'] . '|' . $_POST['expcat_cat3id'];
        $datas['crumbs_expcat_names'] = $_POST['expcat_cat1name'] . '|' . $_POST['expcat_cat2name'] . '|' . $_POST['expcat_cat3name'];

        //执行更新操作
        if( M()->setData('expnew', $datas, 2, $con) ){
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
        
        #接收数据
        $con = [];
        $con['id'] = $_GET['id'];

        #执行删除操作
        if( M()->setData('expnew', $con, 3) ){
            $re = AJAXre();
            $re->navTabId = $this->_navTab.'_index';
            $re->message = '删除成功！';
        }else{
            $re = AJAXre();
        }

        echo json_encode($re);
        exit;
    }

    public function test(){ 
        
        $this->display('Exp/test1.tpl');
    }

















    public function editormd(){ 

        $this->assign([
            'url'=>$this->_url
        ]);

        $this->display('Exp/editormd.tpl');
    }

    public function imgupmd(){ 
        #跨域传输
        //header( 'Access-Control-Allow-Origin:*' ); 

        $fileIMG = isset($_FILES['editormd-image-file']) ? $_FILES['editormd-image-file'] : 'none';
        $token = isset($_GET['tk']) ? $_GET['tk'] : '';
        $re = [];

        //没有令牌则需要记录到日志中
        //if ( !$token ) return;

        #以月份来创建保存editor图片的目录
        $path = EDITORMD_IMG . date('Ym') . '/';

        if ( !is_dir($path) ){
            mkdir($path, 0757);
            chmod($path, 0757);
        }

        #构建新图片的数据id
        $sql = 'select max(id) as maxid from editormd_img where 1 limit 1';
        $arr_maxid = M()->getRow($sql);
        if(!$arr_maxid = M()->getRow($sql)) $arr_maxid=['maxid'=>0];

        $imgName = uniqid('editormd_') . date('YmdHis') . '.' . ($arr_maxid['maxid']+1) . '.jpg';
        $path = $path . $imgName;

        if ( $isUp = move_uploaded_file($fileIMG['tmp_name'], $path) ){
            //$img = 'http://xx.xxxx.com/public/tools/editormdimg/201911/'.$imgName;
            $img = 'public/tools/editormdimg/' . date('Ym') . '/' . $imgName;

            #存储入库
            $sql = 'insert into editormd_img (`id`, `img`, `token`, `post_date`) values ('.($arr_maxid['maxid']+1).', "'.$img.'", "'.$token.'", "'.time().'")';
            M()->setData1($sql);

            //$re['sql'] = $query;
            $re['url'] = '/' . $img;
            $re['success'] = 1;
            $re['message'] = '上传成功！';
        }else{
            $re['success'] = 0;
            $re['message'] = '上传失败！';
        }
        echo json_encode($re);
        exit;
    }

    public function imgup(){ 
        #跨域传输
        //header( 'Access-Control-Allow-Origin:*' ); 

        $fileIMG = isset($_FILES['file']) ? $_FILES['file'] : 'none';
        $token = isset($_GET['tk']) ? $_GET['tk'] : '';
        $re = [];

        //没有令牌则需要记录到日志中
        if ( !$token ) return;

        #以月份来创建保存editor图片的目录
        $path = EDITOR_IMG . date('Ym') . '/';

        if ( !is_dir($path) ){
            mkdir($path, 0757);
            chmod($path, 0757);
        }

        #构建新图片的数据id
        $sql = 'select max(id) as maxid from froala_edit_img where 1 limit 1';
        $arr_maxid = M()->getRow($sql);
        if(!$arr_maxid = M()->getRow($sql)) $arr_maxid=['maxid'=>0];

        $imgName = uniqid('editor_') . date('YmdHis') . '.' . ($arr_maxid['maxid']+1) . '.jpg';
        $path = $path . $imgName;

        if ( $isUp = move_uploaded_file($fileIMG['tmp_name'], $path) ){
            //$img = 'http://xx.xxxx.com/public/tools/editorimg/201911/'.$imgName;
            $re['link'] = 'public/tools/editorimg/' . date('Ym') . '/' . $imgName;

            #存储入库
            $sql = 'insert into froala_edit_img (`id`, `img`, `token`, `post_date`) values ('.($arr_maxid['maxid']+1).', "'.$re['link'].'", "'.$token.'", "'.time().'")';
            M()->setData1($sql);

            //$re['sql'] = $query;
            echo json_encode($re);
        }
        exit;
    }

    public function imgdel(){ 
        #跨域传输
        //header( 'Access-Control-Allow-Origin:*' ); 

        $token = isset($_GET['tk']) ? $_GET['tk'] : '';
        $t_src = isset($_POST['src']) ? $_POST['src'] : '';
        $fromACT = isset($_GET['nowact']) ? $_GET['nowact'] : '';
        $re = [];

        //接收的值不能为空，如果为空则禁止往下继续执行

        #删除前需要先查询是否已经被使用 或者 实际存在的图片删除前是否已经被使用，（被使用则不删除实际图片但可以删除表里的记录（此处省略）（不做此步））
        switch ( $fromACT ){
            case 'ad'://如果是添加页，就不存在图片是否已经被使用了的问题(因为图片是跟着exp文章走的，文章已经存在才有图片存在)，所以直接可以删除图片
                //1. 删除文件
                $t_path = ROOT . '/' . $t_src;
                @unlink($t_path);
                //2. 删除数据
                $explode_src = explode('.', $t_src);//public/tools/editorimg/201911/editor_5ddbc5075699920191125121151.1.jpg
                //$sql = 'delete from froala_edit_img where token="'.$token.'" and img="'.$t_src.'"';
                $sql = 'delete from froala_edit_img where id='.$explode_src[1];
                
                if(M()->setData1($sql)) $re['stat']=1;
                else $re['stat']=0;
            break;
            case 'upd'://如果是编辑页，则需要判断图片是否已经被使用，如果被使用，则禁止删除
            
            break;
        }

        echo json_encode($re);
        exit;
    }

    public function imgload(){ 
        #跨域传输
        //header( 'Access-Control-Allow-Origin:*' ); 
        $token = isset($_GET['tk']) ? $_GET['tk'] : '';
        if ( !$token ) return;

        $sql = 'select * from froala_edit_img where token="'.$token.'" and post_date>='.(time()-7200);
        $infos = M()->getRows($sql);

        if ( !empty($infos) ){

            $re_arr = [];
            foreach( $infos as $k=>$v ){
                $re_arr[] = $v['img'];
            }
            echo json_encode($re_arr);
        }

        exit;
    }
}      
