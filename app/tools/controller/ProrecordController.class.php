<?php
namespace tools\controller;
use \core\controller;

class ProrecordController extends Controller {

    ##标准预定义属性
    private $_datas = [];
    private $_init = [];
    private $_url = [];
    private $_navTab;

    ##非标准预定义属性
    private $_belong_pro;


    public function __construct(){

        parent::__construct();

        $this->_datas['belong_pro'] = [0=>'exp', 1=>'玖富', 2=>'综合'];

        $this->_navTab = 'tools_prorecord';
        
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
            case 'everyday':
            case 'edad':
                $this->_init['stat'] = '0:未完成|2:已完成';
                $this->_init['character'] = '0:不紧急-不重要(灰色)|1:不紧急-重要(蓝色)|2:紧急-不重要(橙色)|3:紧急-重要(红色)';
                $this->_init['type'] = '0:工作|1:学习|2:生活';
                handler_init_special_fields($this->_init);
                $this->_datas = $this->_init;

                $this->_datas['url'] = [
                    'details' => ['url'=>L(PLAT, MOD, 'details'), 'rel'=>$this->_navTab.'_details'],
                    'everyday' => ['url'=>L(PLAT, MOD, 'everyday'), 'rel'=>$this->_navTab.'_everyday'],
                    'ad' => ['url'=>L(PLAT, MOD, 'edad'), 'rel'=>$this->_navTab.'_edad'],
                    'adh' => ['url'=>L(PLAT, MOD, 'edadh')],
                    'upd' => ['url'=>L(PLAT, MOD, 'edupd'), 'rel'=>$this->_navTab.'_edupd'],
                    'del' => ['url'=>L(PLAT, MOD, 'eddel')]
                ];
            break;
        }

        $this->_datas['navTab'] = $this->_navTab;
    }

    public function index(){ 

        //接收数据
        $request = REQUEST()->all();
        
        #分页参数
        $page = $this->_page('prorecord', ['is_del', 0], $request);
        
        //查询数据
        $sql = 'select id, belong_pro, title from prorecord where is_del=0 order by post_date desc limit ' . $page['limitM'] . ',' . $page['numPerPage'];
        $prorecords = M()->getRows($sql);

        //分配模板变量&渲染模板
        $this->assign([
            'prorecords'=>$prorecords,
            'belong_pro'=>$this->_datas['belong_pro'],
            'page'=>$page,
            'url'=>$this->_url
        ]);
        $this->display('Prorecord/index.tpl');
    }

    public function info(){ 

        ///接收数据
        $request = REQUEST()->all();
        
        ///查询数据
        $this->_datas['row'] = $row = M()->table('prorecord')->select('*')->where(['id', $request['id']])->find();

        ///获取md文件url
        $this->_datas['url_edmd_file'] =  M('EditorTool')->mkname(PLAT.'_'.MOD.'_'.ACT.'_'.$request['id'])->getfurl();

        ///如果md文件不在，还是需要创建出来
        $md_file =  M('EditorTool')->mkname(PLAT.'_'.MOD.'_'.ACT.'_'.$request['id'])->mkpath(STORAGE_PATH.'edmd')->getwname();
        if( !file_exists($md_file) ){

            file_put_contents($md_file, htmlspecialchars_decode($row['content']));
            $md_file_last_upd_time = filemtime($md_file);//获取文件最后修改时间
            M()->table('prorecord')->fields('upd_time')->update([$md_file_last_upd_time])->where(['id', $row['id']])->exec();
        }else{

            $md_file_last_upd_time = filemtime($md_file);//获取文件最后修改时间
            
            if( $md_file_last_upd_time!=$row['upd_time'] ){

                file_put_contents($md_file, htmlspecialchars_decode($row['content']));
                clearstatcache();//PHP会缓存之前的filemtime时间，所以要清除一下缓存
                $md_file_last_upd_time = filemtime($md_file);//重新获取文件最后修改时间
                M()->table('prorecord')->fields('upd_time')->update([$md_file_last_upd_time])->where(['id', $row['id']])->exec();
            }
        }

        $this->assign($this->_datas);
        $this->display('Prorecord/info.tpl');
    }

    public function ad(){ 

        $this->assign($this->_datas);
        $this->display('Prorecord/ad.tpl');
    }

    public function adh(){ 
        
        ///接收数据
        $request = REQUEST()->all('n');

        $datas = [
            'title' => $request['title'],
            'belong_pro' => $request['belong_pro'],
            'content' => str_replace('"', '&quot;',str_replace('\\', '\\\\', $request['content'])),
            'content_html' => $request['editormd-html-code'],
            'post_date' => time()
        ];

        ///录入数据
        if( M()->table('prorecord')->insert($datas)->exec() ){

            $this->jump('添加成功！', 'p=tools&m=prorecord&a=ad');
        }else{
            $this->jump('添加失败！', 'p=tools&m=prorecord&a=ad');
        }
    }

    public function upd(){ 
        
        ///接收参数
        $request = REQUEST()->all('n');

        ///查询数据
        $this->_datas['row'] = M()->table('prorecord')->select('*')->where(['id', $request['id']])->find();

        $this->assign($this->_datas);
        $this->display('Prorecord/upd.tpl');
    }

    public function updh(){ 
        ///接收数据
        $request = REQUEST()->all('n');
        $request['content_html'] = $request['editormd-html-code'];
        $request['content'] = str_replace('"', '&quot;',str_replace('\\', '\\\\', $request['content']));

        ///取出修改了的数据
        #查询已有数据
        $row = M()->table('prorecord')->select('*')->where(['id', $request['id']])->find();
        $update_data = F()->compare($request, $row, ['title', 'belong_pro', 'content', 'content_html']);

        if( empty($update_data) ){
            $this->jump('您还没有修改任何数据！请先修改数据。', 'p=tools&m=exp&a=upd&id='.$request['id']);
        }

        $update_data['upd_time'] = time();
        ///更新数据
        $re = M()->table('prorecord')
        ->fields(array_keys($update_data))
        ->update($update_data)
        ->where(['id', $request['id']])
        ->exec();

        if( $re ){

            $this->jump('修改成功！', 'p=tools&m=prorecord&a=upd&id='.$request['id']);
        }else{
            $this->jump('修改失败！', 'p=tools&m=prorecord&a=upd&id='.$request['id']);
        }
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

    public function everyday(){
        
       ///接收数据
        $request = REQUEST()->all();

        ///查询条件(融合搜索条件)
        $con_arr = [
            ['id', '>', 0],
            ['b_time', '<=', strtotime(date('Y-m-d').' 0:0:0')],
            ['e_time', '>=', strtotime(date('Y-m-d').' 23:59:59')]
        ];

        #需要搜索的字段
        $form_elems = [
            ['name', 'like']
        ];

        $con = $this->_condition_string($request, $form_elems, $con_arr);//将条件数组数据转换为条件字符串

        ///将搜索的原始数据扔进模板
        $this->_datas['search'] = $this->_get_ori_search_datas($request, $form_elems);

        ///分页参数
        $this->_datas['page'] = $page = $this->_page('everyday_things', $con, $request);

        ///查询数据
        $this->_datas['things'] = M()->table('everyday_things')->select('*')->where($con)
                // ->limit($page['limitM'] . ',' . $page['numPerPage'])
                ->get();

        ///分配模板变量&渲染模板
        $this->assign($this->_datas);
        $this->display('Prorecord/everyday.tpl');
    }

    public function edad(){
    
        $this->assign($this->_datas);
        $this->display('Prorecord/edad.tpl');
    }

    public function edadh(){
    
        ///接收数据
        $request = REQUEST()->all();

        ///检查数据
        //check($request,  $this->_extra['form-elems'])

        ///构建新增数据
        $now_time = time();
        $insert = [
            'title' => $request['title'],
            'character' => $request['character'],
            'type' => $request['type'],
            'b_time' => empty($request['b_time']) ? strtotime(date('Y-m-d').' 0:0:0') : strtotime($request['b_time']),
            'e_time' => empty($request['e_time']) ? strtotime(date('Y-m-d').' 23:59:59') : strtotime($request['e_time']),
            'post_date' => $now_time
        ];

        $re = M()->table('everyday_things')->insert($insert)->exec();

        ///执行新增
        if( $re ){
            JSON()->navtab($this->_navTab.'_everyday')->exec();
        }else{
            JSON()->stat(300)->msg('操作失败')->exec();
        }
    }

    public function details(){
        //接收数据
        $request = REQUEST()->all();
        #对时间数据进行补全
        if(isset($request['b_post_date'])&&!empty($request['b_post_date'])) $request['b_post_date'].=' 0:0:0';
        if(isset($request['e_post_date'])&&!empty($request['e_post_date'])) $request['e_post_date'].=' 23:59:59';
        if(isset($request['b_begin_time'])&&!empty($request['b_begin_time'])) $request['b_begin_time'].=' 0:0:0';
        if(isset($request['e_begin_time'])&&!empty($request['e_begin_time'])) $request['e_begin_time'].=' 23:59:59';
        if(isset($request['b_end_time'])&&!empty($request['b_end_time'])) $request['b_end_time'].=' 0:0:0';
        if(isset($request['e_end_time'])&&!empty($request['e_end_time'])) $request['e_end_time'].=' 23:59:59';

        // //查询条件(融合搜索条件)
        $con_arr = ['is_del', 0];

        // #需要搜索的字段
        $form_elems = [
            ['title', 'like'],
            ['post_date', 'time-in'],
            ['begin_time', 'time-in'],
            ['end_time', 'time-in']
        ];

        $con = $this->_condition_string($request, $form_elems, $con_arr);//将条件数组数据转换为条件字符串

        // //将搜索的原始数据扔进模板
        $this->_datas['search'] = $this->_get_ori_search_datas($request, $form_elems);

        //查询数据
        $this->_datas['rows'] = M()->table('event')->select('*')->where($con)->orderby('post_date desc')->get();

        //分配模板变量&渲染模板
        $this->assign($this->_datas);
        $this->display('Prorecord/details.tpl');
    }
    
}      
