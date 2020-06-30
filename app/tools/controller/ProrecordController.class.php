<?php
namespace tools\controller;
use \core\controller;

class ProrecordController extends Controller {

    ##标准预定义属性
    private $_datas = [];
    private $_init = [];
    private $_url = [];
    protected $_navTab;

    ##非标准预定义属性
    private $_belong_pro;


    public function __construct(){

        parent::__construct();

        $this->_datas['belong_pro'] = [0=>'exp', 1=>'玖富', 2=>'综合', 3=>'home'];

        $this->_navTab = 'tools_prorecord';
        
        switch ( ACT ){
            case 'index':
                $this->_url = [
                    'info' => L('/tools/prorecord/info'),
                    'index' => L('/tools/prorecord/index'),
                    'ad' => ['url'=>L('/tools/prorecord/ad'), 'rel'=>$this->_navTab.'_ad'],
                    'upd' => ['url'=>L('/tools/prorecord/upd'), 'rel'=>$this->_navTab.'_upd'],
                    'del' => L('/tools/prorecord/del')
                ];
            break;
            case 'ad':
                $this->_datas['url'] = [
                    'adh' => ['url'=>L('/tools/prorecord/adh')],
                    'imgupmd' => ['url'=>L('/tools/editormd/imgUp')]
                ];
            break;
            case 'upd':
                $this->_datas['url'] = [
                    'updh' => ['url'=>L('/tools/prorecord/updh')],
                    'imgupmd' => ['url'=>L('/tools/editormd/imgUp')]
                ];
            break;
            case 'everyday':
            case 'edad':
            case 'edupd':
                $this->_init['stat'] = '0:未完成|2:已完成';
                $this->_init['characte'] = '0:不紧急-不重要|1:不紧急-重要|2:紧急-不重要|3:紧急-重要';
                $this->_init['type'] = '0:工作|1:学习|2:生活';
                handler_init_special_fields($this->_init);
                $this->_datas = $this->_init;

                $this->_datas['url'] = [
                    'details' => ['url'=>L('/tools/everyday/details'), 'rel'=>$this->_navTab.'_details'],
                    'everyday' => ['url'=>L('/tools/everyday/index'), 'rel'=>$this->_navTab.'_everyday'],
                    'ad' => ['url'=>L('/tools/everyday/edad'), 'rel'=>$this->_navTab.'_edad'],
                    'adh' => ['url'=>L('/tools/everyday/edadh')],
                    'upd' => ['url'=>L('/tools/everyday/edupd'), 'rel'=>$this->_navTab.'_edupd'],
                    'updh' => ['url'=>L('/tools/everyday/edupdh')],
                    'del' => ['url'=>L('/tools/everyday/eddel')]
                ];
            break;
            case 'details':
            case 'detad':
            case 'detupd':
                $this->_datas['url'] = [
                    'details' => ['url'=>L('/tools/everyday/details'), 'rel'=>$this->_navTab.'_details'],
                    'ad' => ['url'=>L('/tools/everyday/detad'), 'rel'=>$this->_navTab.'_detad'],
                    'adh' => ['url'=>L('/tools/everyday/detadh')],
                    'upd' => ['url'=>L('/tools/everyday/detupd'), 'rel'=>$this->_navTab.'_detupd'],
                    'updh' => ['url'=>L('/tools/everyday/detupdh')],
                    'del' => ['url'=>L('/tools/everyday/detdel')]
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

    public function oldinfo(){ 

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
        $this->display('Prorecord/newinfo.tpl');
    }

    public function info(){ 

        ///接收数据
        $request = REQUEST()->all();
        
        ///查询数据
        $this->_datas['row'] = $row = M()->table('prorecord')->select('*')->where(['id', $request['id']])->find();

        $this->assign($this->_datas);
        $this->display('Prorecord/newinfo.tpl');
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

            J('添加成功！', '/tools/prorecord/ad');
        }else{
            J('添加失败！', '/tools/prorecord/ad');
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
            J('您还没有修改任何数据！请先修改数据。', '/tools/prorecord/upd?id='.$request['id']);
        }

        $update_data['upd_time'] = time();
        ///更新数据
        $re = M()->table('prorecord')
        ->update($update_data)
        ->where(['id', $request['id']])
        ->exec();

        if( $re ){
            J('修改成功！', '/tools/prorecord/upd?id='.$request['id']);
            
        }else{
            J('修改失败！', '/tools/prorecord/upd?id='.$request['id']);
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
        $tmp_today_b_time = strtotime(date('Y-m-d').' 0:0:0');
        $tmp_today_e_time = strtotime(date('Y-m-d').' 23:59:59');

        ///打卡
        if( isset($request['id']) ){
            
            ///查询今天打卡数据
            $tmp_today = M()->table('everyday_clockin')->select('*')->where([
                ['everyday_things__id', $request['id']],
                ['clock_in_time', 'between', strtotime(date('Y-m-d').' 0:0:0').' and '.strtotime(date('Y-m-d').' 23:59:59')]
            ])->find();

            ///没打卡，则打卡
            if( !$tmp_today ){
                M()->table('everyday_clockin')->insert(['clock_in_time'=>time(), 'everyday_things__id'=>$request['id']])->exec();
            }

            ///完全做完状态
            if( isset($request['stat'])&&$request['stat']==1 ){
                M()->table('everyday_things')->fields('stat')->update(['1'])->where(['id', $request['id']])->exec();
            }
        }

        ///查询条件(融合搜索条件)
        $con = [
            ['everyday_things.id', '>', 0],
            ['everyday_things.e_time', '>=', $tmp_today_b_time],
            ['stat', 0]
        ];

        ///分页参数
        $this->_datas['page'] = $page = $this->_page('everyday_things', $con, $request);

        ///查询数据
        #核心数据
        $this->_datas['things'] = M()->table('everyday_things')->select('*')->where($con)
        // ->limit($page['limitM'] . ',' . $page['numPerPage'])
        ->orderby('everyday_things.characte desc')
        ->get();

        if( !empty($this->_datas['things']) ){

            $arr_ids = [];
            foreach( $this->_datas['things'] as $k=>$v){
                $arr_ids[$k] = $v['id'];
            }
            $str_ids = implode(',', $arr_ids);

            $tmp_everyday_clockin = M()->table('everyday_clockin')->select('everyday_things__id,max(clock_in_time) as clock_in_time')->where(['everyday_things__id', 'in', '('.$str_ids.')'])
            ->groupby('everyday_things__id')
            ->get();

            $everyday_clockin = [];
            foreach( $tmp_everyday_clockin as $k=>$v){
                $everyday_clockin[$v['everyday_things__id']] = $v['clock_in_time'];
            }

            foreach( $this->_datas['things'] as $k=>$v){
                
                if( isset($everyday_clockin[$v['id']]) ){
                    if( !($everyday_clockin[$v['id']]>=$tmp_today_b_time&&$everyday_clockin[$v['id']]<=$tmp_today_e_time) ){//今日未打开则清除打卡时间，因为这个打卡时间是以前的
                        $this->_datas['things'][$k]['clock_in_time'] = 0;
                    }else{//今日已打卡，则保留打卡时间
                        $this->_datas['things'][$k]['clock_in_time'] = $everyday_clockin[$v['id']];
                    }
                }else{//不存在则认为是今日未打卡
                    $this->_datas['things'][$k]['clock_in_time'] = 0;
                }
                
            }
        }

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
            'characte' => $request['characte'],
            'type' => $request['type'],
            'b_time' => empty($request['b_time']) ? strtotime(date('Y-m-d').' 0:0:0') : strtotime($request['b_time']),
            'e_time' => empty($request['e_time']) ? (strtotime(date('Y-m-d').' 23:59:59')+7*24*3600) : strtotime($request['e_time']),
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
    public function edupd(){

        ///接收数据
        $request = REQUEST()->all();

        ///检查数据
        //check($request,  $this->_extra['form-elems'])

        ///查找回显数据
        $this->_datas['row'] = M()->table('everyday_things')->select('*')->where(['id', $request['id']])->find();
    
        $this->assign($this->_datas);
        $this->display('Prorecord/edupd.tpl');
    }

    public function edupdh(){

        $request = REQUEST()->all();

        ///检查数据
        //check($request,  $this->_extra['form-elems'])

        ///取出修改了的数据
        #查询已有数据
        $request['b_time'] = strtotime($request['b_time']);
        $request['e_time'] = strtotime($request['e_time']);
        $row = M()->table('everyday_things')->select('*')->where(['id', $request['id']])->find();
        $update_data = F()->compare($request, $row, ['title', 'b_time', 'e_time', 'characte', 'type']);

        if( empty($update_data) ){
            JSON()->stat(300)->msg('请先修改数据！')->exec();
        }

        ///更新数据
        $re = M()->table('everyday_things')
        ->update($update_data)
        ->where(['id', $request['id']])
        ->exec();

        if( $re ){
            JSON()->navtab($this->_navTab.'_everyday')->exec();
        }else{
            JSON()->stat(300)->msg('操作失败')->exec();
        }
    }

    public function details(){
        ///接收数据
        $request = REQUEST()->all();
        $this->_datas['everyday_things__id'] = $request['id'];

        ///查询条件
        $con = [
            ['everyday_things__id', $request['id']]
        ];

        //查询数据
        $this->_datas['this_everyday_things'] = M()->table('everyday_things')->select('b_time, e_time')->where(['id', $request['id']])->find();
        $this->_datas['rows'] = M()->table('everyday_things_details')->select('*')->where($con)->orderby('post_date desc')->get();

        //分配模板变量&渲染模板
        $this->assign($this->_datas);
        $this->display('Prorecord/details.tpl');
    }

    public function detad(){

        ///接收数据
        $request = REQUEST()->all();
        $this->_datas['everyday_things__id'] = $request['edths_id'];
    
        $this->assign($this->_datas);
        $this->display('Prorecord/detad.tpl');
    }

    public function detadh(){
    
        ///接收数据
        $request = REQUEST()->all();

        ///检查数据
        //check($request,  $this->_extra['form-elems'])

        ///构建新增数据
        $now_time = time();
        $b_time = empty($request['b_time']) ? ($now_time-3600*3) : strtotime($request['b_time']);
        $e_time = empty($request['e_time']) ? $now_time : strtotime($request['e_time']);
        $insert = [
            'content' => str_replace(PHP_EOL, '<br/>', $request['content']),
            'b_time' => $b_time,
            'e_time' => $e_time,
            'post_date' => $now_time,
            'everyday_things__id' => $request['everyday_things__id']
        ];

        $re = M()->table('everyday_things_details')->insert($insert)->exec();

        ///执行新增
        if( $re ){
            JSON()->navtab('tools_prorecord_detad')->exec();
        }else{
            JSON()->stat(300)->msg('操作失败')->exec();
        }
    }

    public function detupd(){

        ///接收数据
        $request = REQUEST()->all();
        $this->_datas['id'] = $request['id'];
        $this->_datas['everyday_things__id'] = $request['edths_id'];

        ///查找回显数据
        $this->_datas['row'] = M()->table('everyday_things_details')->select('*')->where(['id', $request['id']])->find();
    
        $this->assign($this->_datas);
        $this->display('Prorecord/detupd.tpl');
    }

    public function detupdh(){
    
        $request = REQUEST()->all();

        ///检查数据
        //check($request,  $this->_extra['form-elems'])

        ///取出修改了的数据
        #查询已有数据
        $request['b_time'] = strtotime($request['b_time']);
        $request['e_time'] = strtotime($request['e_time']);
        $request['content'] = str_replace(PHP_EOL, '<br/>', $request['content']);
        $row = M()->table('everyday_things_details')->select('*')->where(['id', $request['id']])->find();
        $update_data = F()->compare($request, $row, ['content', 'b_time', 'e_time']);
        
        if( empty($update_data) ){
            JSON()->stat(300)->msg('请先修改数据！')->exec();
        }

        ///更新数据
        $re = M()->table('everyday_things_details')
        ->update($update_data)
        ->where(['id', $request['id']])
        ->exec();

        if( $re ){
            JSON()->navtab('tools_prorecord_detupd')->exec();
        }else{
            JSON()->stat(300)->msg('操作失败')->exec();
        }
    }

    /**
     * @method  _page
     * 方法作用: 构建分页参数
     * 
     * @param    $tb            string      [需要统计总的记录条数的表其表名]
     * @param    $condition     string      [统计总记录条数的条件，直接传递给模型，故条件的格式与模型where方法所需的条件格式保持统一]
     * @param    $request       array       [表单传值的集合，包含了分页所需的表单参数]
     * @param    $num_per_page  int         [每页显示的数据条数，默认为31条]
     * 
     * @return  array           [包含分页各项数据的数组]
     */
    protected function _page($tb, $condition, $request, $num_per_page=31){
        #分页参数
        $page = [];
        $page['numPerPageList'] = [20, 30, 40, 60, 80, 100, 120, 160, 200];
        $page['pageNum'] = $pageNum = isset($request['pageNum']) ? intval($request['pageNum']) : (isset($_COOKIE[$this->navtab.'pageNum']) ? intval($_COOKIE[$this->navtab.'pageNum']) : 1);
        setcookie($this->navtab.'pageNum', $pageNum);
        $page['numPerPage'] = $numPerPage = isset($request['numPerPage']) ? intval($request['numPerPage']) : $num_per_page;
        $tmp_arr_totalNum = M()->table($tb)->select('count(*) as num')->where($condition)->find();
        $page['totalNum'] = $totalNum = $tmp_arr_totalNum['num'];
        $page['totalPageNum'] = intval(ceil(($totalNum/$numPerPage)));
        $page['limitM'] = ($pageNum-1)*$numPerPage;

        return $page;
    } 
}      
