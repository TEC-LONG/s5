<?php
namespace tools\controller;
use \core\controller;

class EditorController extends Controller {

    private $_datas = [];
    private $_url = [];
    private $_navTab;

    public function __construct(){

        parent::__construct();

        $this->_navTab = 'Editor';
        
        switch ( ACT ){
            case 'editormd':
                $this->_url = [
                    'editormdImgUp' => L(PLAT, MOD, 'imgupmd')
                ];
            break;
            case 'editormdupd':
                $this->_url = [
                    'editormdImgUp' => L(PLAT, MOD, 'imgupmd')
                ];
            break;
        }
    }

    public function editormd(){ 

        $this->assign([
            'url'=>$this->_url
        ]);

        $this->display('Editor/editormd.tpl');
    }

    public function editormdupd(){ 

        $tbname = $_GET['tbname'];
        $id = $_GET['id'];

        #查询数据
        $sql = 'select content from ' . $tbname . ' where id=' . $id;
        $prorecord = M()->getRow($sql);

        $this->assign([
            'prorecord'=>$prorecord,
            'url'=>$this->_url
        ]);

        $this->display('Editor/editormdupd.tpl');
    }

    public function imgupmd(){ 
        #跨域传输
        //header( 'Access-Control-Allow-Origin:*' ); 

        $fileIMG = isset($_FILES['editormd-image-file']) ? $_FILES['editormd-image-file'] : 'none';
        //$token = isset($_GET['tk']) ? $_GET['tk'] : '';
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
