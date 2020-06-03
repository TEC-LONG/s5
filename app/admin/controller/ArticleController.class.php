<?php
namespace admin\controller;
use \core\controller;
use \Validator;

class ArticleController extends Controller {

    ##标准预定义属性
    public $_datas = [];

    public function __construct(){

        parent::__construct();

        $this->_datas['url'] = [
            'index'     => $this->route('get',  '/admin/article'),
            'ad'        => $this->route('get',  '/admin/article/add'),
            'upd'       => $this->route('get',  '/admin/article/upd'),
            'post'      => $this->route('post', '/admin/article/post'),
            'del'       => $this->route('get',  '/admin/article/del'),
            'imgupmd'   => $this->route('post', '/tools/editormd/imgUp')
        ];

        $this->_datas['navtab'] = $this->navtab;
    }

    public function index(){

        ///初始化参数
        $request            = REQUEST()->all();
        $article_service    = M('ArticleService');

        ///校验数据
        $article_service->checkListRequest($request);
        
        ///获取列表数据
        $article_service->getArticleList($request, $this);

        ///额外的逻辑处理
        #表头信息
        $this->_datas['thead'] = [
            ['ch'=>'标题',          'width'=>160],
            ['ch'=>'添加时间',      'width'=>140],
            ['ch'=>'所属分类',      'width'=>120],
            ['ch'=>'标签',          'width'=>200],
            ['ch'=>'修改时间',      'width'=>140],
            ['ch'=>'是否关联EXP',   'width'=>120],
            ['ch'=>'EXP文章标题',   'width'=>160],
            ['ch'=>'状态',          'width'=>80],
            ['ch'=>'ID',            'width'=>30]
        ];

        //分配模板变量&渲染模板
        $this->assign($this->_datas);
        $this->display('article/index.tpl');
    }

    /**
     * 添加/编辑 页
     */
    public function showEdit(){
        ///初始化参数
        $request                    = REQUEST()->all();
        $this->_datas['cate_one']   = M('ArticleCategoryModel')->getCateOne();
        $this->_datas['html_title'] = '添加';
        
        ///编辑页需查询回显数据
        if( isset($request['id']) ){
            
            $this->_datas['html_title'] = '编辑';
            #根据id查询
            $this->_datas['row'] = M('ArticleModel')->getArticleById($request['id']);

            $this->_datas['row']['crumbs_cat_ids']      = explode('|', $this->_datas['row']['crumbs_cat_ids']);
            $this->_datas['row']['crumbs_cat_names']    = explode('|', $this->_datas['row']['crumbs_cat_names']);
        }
        
        $this->assign($this->_datas);
        $this->display('article/edit.tpl');
    }

    /**
     * 添加/编辑 文章
     */
    public function post(){
    
        ///初始化参数
        $request            = REQUEST()->all('n');
        $article_service    = M('ArticleService');

        ///检查数据
        $this->checkPostRequest($request);

        ///录入数据,如失败，在服务中拦截
        if( isset($request['id']) ){#编辑
            $article_service->update($request);
        }else{#新增
            $article_service->insert($request);
        }

        JSON()->navtab($this->navtab)->msg('操作成功！')->exec();
    }

    private function checkPostRequest($request){
    
        ///需检查的搜索字段
        $fields = [
            'title'     => 'required',
            'content'   => 'required'
        ];

        ///字段对应的提示信息
        $msg = [
            'title.required'    => '请填写标题',
            'content.required'  => '请填写内容'
        ];

        ///校验
        $obj = Validator::make($request, $fields, $msg);
        #有错误信息则返回给页面
        if( !empty($obj->err) ) JSON()->stat(300)->msg($obj->getErrMsg())->exec();
    }








    ###info综合  包括: info()
    public function info(){ 
        ///接收数据
        $request = REQUEST()->all();
        
        ///查询数据
        $this->_datas['row'] = M()->table('expnew')->select('*')->where(['id', $request['id']])->find();

        $this->assign($this->_datas);
        $this->display('Exp/newinfo.tpl');
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
        $datas['content_html'] = $request['editormd-html-code'];
        $datas['expcat__id'] = $expcat3_arr[0];
        $datas['expcat__name'] = $expcat3_arr[1];
        $datas['crumbs_expcat_ids'] = $expcat1_arr[0] . '|' . $expcat2_arr[0] . '|' . $expcat3_arr[0];
        $datas['crumbs_expcat_names'] = $expcat1_arr[1] . '|' . $expcat2_arr[1] . '|' . $expcat3_arr[1];

        #录入数据
        if( M()->table('expnew')->insert($datas)->exec() ){

            J('添加成功！', '/tools/exp/ad');
        }else{
            J('添加失败！', '/tools/exp/ad');
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
        $request['content_html'] = $request['editormd-html-code'];
        $request['content'] = str_replace('"', '&quot;',str_replace('\\', '\\\\', $request['content']));
        $request['crumbs_expcat_ids'] = $expcat1_arr[0] . '|' . $expcat2_arr[0] . '|' . $expcat3_arr[0];
        $request['crumbs_expcat_names'] = $expcat1_arr[1] . '|' . $expcat2_arr[1] . '|' . $expcat3_arr[1];

        ///取出修改了的数据
        #查询已有数据
        $row = M()->table('expnew')->select('*')->where(['id', $request['id']])->find();
        $update_data = F()->compare($request, $row, ['title', 'tags', 'content', 'crumbs_expcat_names', 'crumbs_expcat_ids', 'expcat__id', 'expcat__name', 'content_html']);

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

            J('修改成功！', '/tools/exp/upd?id='.$request['id']);
        }else{
            J('修改成功！', '/tools/exp/upd?id='.$request['id']);
        }
        
        // #接收数据
        // //条件
        // $con = ['id'=>$_GET['id']];
        // //数据
        // $datas = [];
        // $datas['title'] = $_POST['title'];
        // $datas['tags'] = $_POST['tags'];
        // $datas['post_date'] = time();
        // if(!empty($_POST['content_upd'])){

        //     $datas['content'] = str_replace('\\', '\\\\', $_POST['content_upd']);
        //     $datas['content'] = str_replace('"', '&quot;', $datas['content']);
        // } 
        // $datas['expcat__id'] = $_POST['expcat_cat1id'];
        // $datas['expcat__name'] = $_POST['expcat_cat1name'];
        // $datas['crumbs_expcat_ids'] = $_POST['expcat_cat1id'] . '|' . $_POST['expcat_cat2id'] . '|' . $_POST['expcat_cat3id'];
        // $datas['crumbs_expcat_names'] = $_POST['expcat_cat1name'] . '|' . $_POST['expcat_cat2name'] . '|' . $_POST['expcat_cat3name'];

        // //执行更新操作
        // if( M()->setData('expnew', $datas, 2, $con) ){
        //     $re = AJAXre();
        //     $re->navTabId = $this->_navTab.'_upd';
        //     $re->message = '更新成功！';
        // }else{
        //     $re = AJAXre(1);
        // }
        
        // #返回结果
        // echo json_encode($re); 
        // exit;
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
