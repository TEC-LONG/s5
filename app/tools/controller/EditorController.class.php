<?php

namespace tools\controller;

use \core\controller;

class EditorController extends Controller
{

    private $_datas = [];
    private $_url = [];
    private $_navTab;

    public function __construct()
    {

        parent::__construct();

        $this->_navTab = 'Editor';
        $this->_url = [
            'editormdImgUp' => L('/tools/editormd/imgUp')
        ];
    }

    public function imgupmd()
    {
        ///跨域传输
        //header( 'Access-Control-Allow-Origin:*' ); 

        // $fileIMG = isset($_FILES['editormd-image-file']) ? $_FILES['editormd-image-file'] : 'none';
        //$token = isset($_GET['tk']) ? $_GET['tk'] : '';
        // $re = [];

        //没有令牌则需要记录到日志中
        //if ( !$token ) return;

        ///以年份和月份分别来创建保存editor图片的一级和二级目录
        $first_folder = date('Y');
        $first_folder_path = EDITORMD_IMG . $first_folder;

        if (!is_dir($first_folder_path)) {
            mkdir($first_folder_path);
            chmod($first_folder_path, 0757);
        }

        $second_folder = date('m');
        $path = $first_folder_path . '/' . $second_folder;

        if (!is_dir($path)) {
            mkdir($path, 0757);
            chmod($path, 0757);
        }

        ///构建新图片的数据id
        $arr_maxid = M()->table('editormd_img')->select('max(id) as maxid')->where('1')->find();
        if (!$arr_maxid) $arr_maxid = ['maxid' => 0];
        #图片的命名规则：前缀_随机字符串年月日时分秒.editormd_img表ID.jpg
        $imgName = uniqid('editormd_') . date('YmdHis') . '.' . ($arr_maxid['maxid'] + 1);

        if ($file = F()->file('editormd-image-file', $path)->up('editormd_', $imgName)) {
            //$img = 'http://xx.xxxx.com/upload/editormdimg/2019/11/xx.jpg';
            $img = 'upload/editormdimg/' . $first_folder . '/' . $second_folder . '/' . $file->getNameWithExtension();

            #存储入editormd_img表
            M()->table('editormd_img')->insert([
                'id' => ($arr_maxid['maxid'] + 1),
                'img' => $img,
                'post_date' => time()
            ])->exec();

            JSON()->arr()->vars([
                ['url', '/' . $img],
                ['success', 1],
                ['message', '上传成功！']
            ])->exec();
        } else {
            JSON()->arr([
                'success' => 0,
                'message' => '上传失败！'
            ])->exec();
        }
    }

    public function imgupbd()
    {
        header('Content-Type: text/html; charset=UTF-8');

        $inputName = 'filedata'; //表单文件域name
        ///以年份和月份分别来创建保存editor图片的一级和二级目录
        $first_folder = date('Y');
        $first_folder_path = EDITORBD_IMG . $first_folder;

        if (!is_dir($first_folder_path)) {
            mkdir($first_folder_path);
            chmod($first_folder_path, 0757);
        }

        $second_folder = date('m');
        $path = $first_folder_path . '/' . $second_folder;

        if (!is_dir($path)) {
            mkdir($path, 0757);
            chmod($path, 0757);
        }
        $attachDir = $path; //上传文件保存路径，结尾不要带/
        $dirType = 1; //1:按天存入目录 2:按月存入目录 3:按扩展名存目录  建议使用按天存
        $maxAttachSize = 2097152; //最大上传大小，默认是2M
        $upExt = 'txt,rar,zip,jpg,jpeg,gif,png,swf,wmv,avi,wma,mp3,mid'; //上传扩展名
        $msgType = 2; //返回上传参数的格式：1，只返回url，2，返回参数数组
        // $immediate = isset($_GET['immediate']) ? $_GET['immediate'] : 0; //立即上传模式，仅为演示用
        $immediate = 0; 
        // ini_set('date.timezone', 'Asia/Shanghai'); //时区

        $err = "";
        $msg = "''";
        $tempPath = $attachDir . '/' . date("YmdHis") . mt_rand(10000, 99999) . '.tmp';
        $localName = '';

        if (isset($_SERVER['HTTP_CONTENT_DISPOSITION']) && preg_match('/attachment;\s+name="(.+?)";\s+filename="(.+?)"/i', $_SERVER['HTTP_CONTENT_DISPOSITION'], $info)) { //HTML5上传
            file_put_contents($tempPath, file_get_contents("php://input"));
            $localName = urldecode($info[2]);
        } else { //标准表单式上传
            $upfile = @$_FILES[$inputName];
            if (!isset($upfile)) $err = '文件域的name错误';
            elseif (!empty($upfile['error'])) {
                switch ($upfile['error']) {
                    case '1':
                        $err = '文件大小超过了php.ini定义的upload_max_filesize值';
                        break;
                    case '2':
                        $err = '文件大小超过了HTML定义的MAX_FILE_SIZE值';
                        break;
                    case '3':
                        $err = '文件上传不完全';
                        break;
                    case '4':
                        $err = '无文件上传';
                        break;
                    case '6':
                        $err = '缺少临时文件夹';
                        break;
                    case '7':
                        $err = '写文件失败';
                        break;
                    case '8':
                        $err = '上传被其它扩展中断';
                        break;
                    case '999':
                    default:
                        $err = '无有效错误代码';
                }
            } elseif (empty($upfile['tmp_name']) || $upfile['tmp_name'] == 'none') $err = '无文件上传';
            else {
                move_uploaded_file($upfile['tmp_name'], $tempPath);
                $localName = $upfile['name'];
            }
        }

        if ($err == '') {
            $fileInfo = pathinfo($localName);
            $extension = $fileInfo['extension'];
            if (preg_match('/^(' . str_replace(',', '|', $upExt) . ')$/i', $extension)) {
                $bytes = filesize($tempPath);
                if ($bytes > $maxAttachSize) $err = '请不要上传大小超过' . $this->formatBytes($maxAttachSize) . '的文件';
                else {
                    PHP_VERSION < '4.2.0' && mt_srand((float) microtime() * 1000000);
                    $newFilename = uniqid('editorbd_') . mt_rand(0, 100000) . '.' . date('YmdHis') . '.' . $extension;
                    $targetPath = $attachDir . '/' . $newFilename;

                    rename($tempPath, $targetPath);
                    @chmod($targetPath, 0755);
                    // $targetPath = $this->jsonString($targetPath);
                    // if ($immediate == '1') $targetPath = '!' . $targetPath;
                    $url = 'upload/editormdimg/' . $first_folder . '/' . $second_folder . '/' . $newFilename;
                    if ($msgType == 1) $msg = "'$url'";
                    else $msg = "{'url':'" . $url . "','localname':'" . $this->jsonString($localName) . "','id':'".mt_rand(0, 100000)."'}"; //id参数固定不变，仅供演示，实际项目中可以是数据库ID
                }
            } else $err = '上传文件扩展名必需为：' . $upExt;

            @unlink($tempPath);
        }

        echo "{'err':'" . $err . "','msg':" . $msg . "}";
    }

    private function jsonString($str)
    {
        return preg_replace("/([\\\\\/'])/", '\\\$1', $str);
    }

    private function formatBytes($bytes) {
        if($bytes >= 1073741824) {
            $bytes = round($bytes / 1073741824 * 100) / 100 . 'GB';
        } elseif($bytes >= 1048576) {
            $bytes = round($bytes / 1048576 * 100) / 100 . 'MB';
        } elseif($bytes >= 1024) {
            $bytes = round($bytes / 1024 * 100) / 100 . 'KB';
        } else {
            $bytes = $bytes . 'Bytes';
        }
        return $bytes;
    }

































    public function editormd()
    {

        $this->assign([
            'url' => $this->_url
        ]);

        $this->display('Editor/editormd.tpl');
    }

    public function editormdupd()
    {

        $tbname = $_GET['tbname'];
        $id = $_GET['id'];

        #查询数据
        $sql = 'select content from ' . $tbname . ' where id=' . $id;
        $prorecord = M()->getRow($sql);

        // var_dump($prorecord['content']);

        // exit;

        $this->assign([
            'prorecord' => $prorecord,
            'url' => $this->_url
        ]);

        $this->display('Editor/editormdupd.tpl');
    }




















    /*
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
    */
}
