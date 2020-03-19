<?php
namespace tools\controller;
use \core\controller;

class ExpController extends Controller {

    ##标准预定义属性
    private $_datas = [];
    private $_url = [];
    private $_navTab;

    ##非标准预定义属性

    ##实现初始化各动作需要的不同数据
    public function __construct(){

        parent::__construct();

        #当前模块的导航标识前缀，用于拼接各页面完整的导航标识
        $this->_navTab = 'tools_exp';
        
        #执行各动作的初始化方法
        switch ( ACT ){
            case 'index':
                $this->_index();
            break;
            case 'ad':
                $this->_datas['url'] = [
                    'adh' => ['url'=>L(PLAT, MOD, 'adh')],
                    'imgupmd' => ['url'=>L(PLAT, 'editor', 'imgupmd')]
                ];
            break;
            case 'upd':
                $this->_datas['url'] = [
                    'updh' => ['url'=>L(PLAT, MOD, 'updh')],
                    'imgupmd' => ['url'=>L(PLAT, 'editor', 'imgupmd')]
                ];
            break;
            case 'editormd'://这个部分待优化，需要分离老的非markdown的富文本编辑器部分
                $this->_url = [
                    'editormdImgUp' => L(PLAT, MOD, 'imgupmd')
                ];
                // $this->_editormd();
            break;
        }
    }

    ###index综合  包括: _index(),index()
    ##_index初始化方法，只服务于index
    private function _index(){
        $this->_url = [
            'info' => L(PLAT, MOD, 'info'),
            'ad' => ['url'=>L(PLAT, MOD, 'ad'), 'rel'=>$this->_navTab.'_ad'],
            'index' => L(PLAT, MOD, 'index'),
            'upd' => ['url'=>L(PLAT, MOD, 'upd'), 'rel'=>$this->_navTab.'_upd'],
            'del' => L(PLAT, MOD, 'del'),
            'catLookup' => L(PLAT, 'expcat', 'catLookup')
        ];
    }

    public function index(){

        // if( !empty($_POST) ){
        //     var_dump($_POST);
        // }
        //接收数据
        $request = REQUEST()->all();

        #分页参数
        $page = $this->_page('expnew', ['is_del', 0], $request);
        
        //查询数据
        $sql = 'select id, title, tags, crumbs_expcat_names, post_date from expnew where is_del=0 order by post_date desc limit ' . $page['limitM'] . ',' . $page['numPerPage'];
        $exps = M()->getRows($sql);

        //分配模板变量&渲染模板
        $this->assign([
            'exps'=>$exps,
            'page'=>$page,
            'url'=>$this->_url
        ]);
        $this->display('Exp/index.tpl');
    }

    ###info综合  包括: info()
    public function info(){ 
        ///接收数据
        $request = REQUEST()->all();
        
        ///查询数据
        $this->_datas['row'] = $row = M()->table('expnew')->select('*')->where(['id', $request['id']])->find();

        ///获取md文件url
        $this->_datas['url_edmd_file'] =  M('EditorTool')->mkname(PLAT.'_'.MOD.'_'.ACT.'_'.$request['id'])->getfurl();

        ///如果md文件不在，还是需要创建出来
        $md_file =  M('EditorTool')->mkname(PLAT.'_'.MOD.'_'.ACT.'_'.$request['id'])->mkpath(STORAGE_PATH.'edmd')->getwname();
        if( !file_exists($md_file) ){

            file_put_contents($md_file, htmlspecialchars_decode($row['content']));
            $md_file_last_upd_time = filemtime($md_file);//获取文件最后修改时间
            M()->table('expnew')->fields('upd_time')->update([$md_file_last_upd_time])->where(['id', $row['id']])->exec();
        }else{

            $md_file_last_upd_time = filemtime($md_file);//获取文件最后修改时间
            if( $md_file_last_upd_time!=$row['upd_time'] ){

                file_put_contents($md_file, htmlspecialchars_decode($row['content']));
                clearstatcache();//PHP会缓存之前的filemtime时间，所以要清除一下缓存
                $md_file_last_upd_time = filemtime($md_file);//重新获取文件最后修改时间
                M()->table('expnew')->fields('upd_time')->update([$md_file_last_upd_time])->where(['id', $row['id']])->exec();
            }
        }

        $this->assign($this->_datas);
        $this->display('Exp/info.tpl');
    }

    private function get_expcat_lv1(){
    
        return M()->table('expcat')->select('id, name, level')->where(['pid', 0])->get();
    }
    public function ad(){

        //获得所有的一级分类
        $this->_datas['expcat_lv1'] = $this->get_expcat_lv1();

        $this->assign($this->_datas);
        $this->display('Exp/ad.tpl');
    }

    public function adh(){ 

        $request = REQUEST()->all('n');
        // F()->print_r($request);

        #个别数据处理
        $expcat1_arr = explode('|', $request['expcat1']);
        $expcat2_arr = explode('|', $request['expcat2']);
        $expcat3_arr = explode('|', $request['expcat3']);

        #接收数据
        $datas = [];
        $datas['title'] = $request['title'];
        $datas['tags'] = $request['tags'];
        $datas['post_date'] = time();
        $datas['content'] = str_replace('"', '&quot;',str_replace('\\', '\\\\', $request['content']));
        $datas['expcat__id'] = $expcat3_arr[0];
        $datas['expcat__name'] = $expcat3_arr[1];
        $datas['crumbs_expcat_ids'] = $expcat1_arr[0] . '|' . $expcat2_arr[0] . '|' . $expcat3_arr[0];
        $datas['crumbs_expcat_names'] = $expcat1_arr[1] . '|' . $expcat2_arr[1] . '|' . $expcat3_arr[1];

        #录入数据
        if( M()->table('expnew')->insert($datas)->exec() ){

            $this->jump('添加成功！', 'p=tools&m=exp&a=ad');
        }else{
            $this->jump('添加失败！', 'p=tools&m=exp&a=ad');
        }
    }

    ###ad综合  包括:upd(),updh()
    public function upd(){
        ///接收参数
        $request = REQUEST()->all('n');

        ///查询数据
        $this->_datas['row'] = M()->table('expnew')->select('id, title, tags, crumbs_expcat_ids, crumbs_expcat_names, content')->where(['id', $request['id']])->find();

        $this->_datas['row']['crumbs_expcat_ids'] = explode('|', $this->_datas['row']['crumbs_expcat_ids']);
        $this->_datas['row']['crumbs_expcat_names'] = explode('|', $this->_datas['row']['crumbs_expcat_names']);

        ///获得所有的一级分类
        $this->_datas['expcat_lv1'] = $this->get_expcat_lv1();

        $this->assign($this->_datas);
        $this->display('Exp/upd.tpl');
    }

    public function updh(){ 

        $request = REQUEST()->all('n');
        // F()->print_r($request);

        ///个别数据处理
        $expcat1_arr = explode('|', $request['expcat1']);
        $expcat2_arr = explode('|', $request['expcat2']);
        $expcat3_arr = explode('|', $request['expcat3']);

        $request['expcat__id'] = $expcat3_arr[0];
        $request['expcat__name'] = $expcat3_arr[1];
        $request['content'] = str_replace('"', '&quot;',str_replace('\\', '\\\\', $request['content']));
        $request['crumbs_expcat_ids'] = $expcat1_arr[0] . '|' . $expcat2_arr[0] . '|' . $expcat3_arr[0];
        $request['crumbs_expcat_names'] = $expcat1_arr[1] . '|' . $expcat2_arr[1] . '|' . $expcat3_arr[1];

        ///取出修改了的数据
        #查询已有数据
        $row = M()->table('expnew')->select('*')->where(['id', $request['id']])->find();
        $update_data = F()->compare($request, $row, ['title', 'tags', 'content', 'crumbs_expcat_names', 'crumbs_expcat_ids', 'expcat__id', 'expcat__name']);

        if( empty($update_data) ){
            $this->jump('您还没有修改任何数据！请先修改数据。', 'p=tools&m=exp&a=upd&id='.$request['id']);
        }

        $update_data['upd_time'] = time();
        ///更新数据
        $re = M()->table('expnew')
        ->fields(array_keys($update_data))
        ->update($update_data)
        ->where(['id', $request['id']])
        ->exec();

        if( $re ){

            $this->jump('修改成功！', 'p=tools&m=exp&a=upd&id='.$request['id']);
        }else{
            $this->jump('修改失败！', 'p=tools&m=exp&a=upd&id='.$request['id']);
        }
        
        #接收数据
        //条件
        $con = ['id'=>$_GET['id']];
        //数据
        $datas = [];
        $datas['title'] = $_POST['title'];
        $datas['tags'] = $_POST['tags'];
        $datas['post_date'] = time();
        if(!empty($_POST['content_upd'])){

            $datas['content'] = str_replace('\\', '\\\\', $_POST['content_upd']);
            $datas['content'] = str_replace('"', '&quot;', $datas['content']);
        } 
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

    ###del综合  包括: del()
    public function del(){ 
        
        #接收数据
        $con = ['id'=>$_GET['id']];

        //将需要删除的数据 is_del字段设置为1
        if( M()->setData('expnew', ['is_del'=>1], 2, $con) ){
            $re = AJAXre();
            $re->navTabId = $this->_navTab.'_index';
            $re->message = '删除成功！';
        }else{
            $re = AJAXre(1);
        }

        echo json_encode($re);
        exit;
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
