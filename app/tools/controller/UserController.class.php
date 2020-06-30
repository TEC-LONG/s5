<?php
namespace tools\controller;
use \core\controller;
use \model\MenuPermissionModel;

class UserController extends Controller {

    ##标准预定义属性
    protected $_datas = [];
    private $_init = [];
    private $_extra = [];
    protected $_navTab;

    public function __construct(){

        parent::__construct();

        $this->_navTab = 'tools_user';

        //非标准预定义属性赋值与转换
        $this->_init['level'] = '0:普通用户|1:管理员';
        $this->_init['status'] = '0:正常|1:禁用';
        $this->_init['ori'] = '0:注册|1:后台添加';
        $this->_init['is_online'] = '0:未知|1:在线|2:离线';
        handler_init_special_fields($this->_init);

        //扔进模板
        $this->_datas = $this->_init;

        $this->_datas['url'] = [
            'index' => ['url'=>L('/tools/user/index'), 'rel'=>$this->_navTab.'_index'],
            'ad'    => ['url'=>L('/tools/user/ad'), 'rel'=>$this->_navTab.'_ad'],
            'adh'   => ['url'=>L('/tools/user/adh')],
            'upd'   => ['url'=>L('/tools/user/upd'), 'rel'=>$this->_navTab.'_upd'],
            'updh'  => ['url'=>L('/tools/user/updh')],
            'del'   => ['url'=>L('/tools/user/del')],
            'group' => ['url'=>L('/tools/user/group'), 'rel'=>$this->_navTab.'_group'],
            'gAdUpd'=> ['url'=>L('/tools/user/gedit'), 'rel'=>$this->_navTab.'_edit'],
            'gPost' => ['url'=>L('/tools/user/gpost')],
            'gpermission' => ['url'=>L('/tools/user/gpermission'), 'rel'=>$this->_navTab.'_gpermission'],
            'gpPost' => ['url'=>L('/tools/user/gppost')]
        ];

        $this->_datas['mustShow'] = [
            'id'        => ['ch'=>'ID', 'width'=>30], 
            'acc'       => ['ch'=>'账号', 'width'=>120], 
            'nickname'  => ['ch'=>'用户昵称', 'width'=>120],
            'cell'      => ['ch'=>'手机号', 'width'=>100], 
            'email'     => ['ch'=>'邮箱', 'width'=>160], 
            'level'     => ['ch'=>'用户级别', 'width'=>60],
            'status'    => ['ch'=>'状态', 'width'=>100],
            'ori'       => ['ch'=>'新增来源', 'width'=>120],
            'gname'     => ['ch'=>'所属组', 'width'=>160]
        ];

        $this->_extra['form-elems'] = [
            'acc'       => ['ch'=>'账号', 'rule'=>'required||regex@:^[\w_]{6,20}$'],
            'pwd'       => ['ch'=>'密码', 'rule'=>'required||regex@:^[\w_]{6,15}$'],//6~15个英文字母或数字或下划线组合
            'nickname'  => ['ch'=>'昵称', 'rule'=>'required']
        ];

        $this->_datas['navTab'] = $this->_navTab;
    }

    public function index(){ 

        //接收数据
        $request = REQUEST()->all();

        //查询条件(融合搜索条件)
        $con_arr = [['is_del', 0], ['level', 1]];

        #需要搜索的字段
        $form_elems = [
            ['acc', 'like'],
            ['nickname', 'like']
        ];

        $con = $this->_condition_string($request, $form_elems, $con_arr);//将条件数组数据转换为条件字符串

        //将搜索的原始数据扔进模板
        $this->_datas['search'] = $this->_get_ori_search_datas($request, $form_elems);

        //分页参数
        $this->_datas['page'] = $page = $this->_page('user', $con, $request);

        //查询数据
        $this->_datas['rows'] = M()->table('user as u')->select('u.*, ug.name as gname')
        ->leftjoin('user_group as ug', 'ug.id=u.user_group__id')
        ->where($con)
        ->limit($page['limitM'] . ',' . $page['numPerPage'])
        ->get();

        //分配模板变量&渲染模板
        $this->assign($this->_datas);
        $this->display('user/index.tpl');
    }

    public function ad(){ 

        ///用户组数据
        $this->_datas['user_group'] = M('UserGroupModel')->getAll();

        $this->assign($this->_datas);

        $this->display('user/ad.tpl');
    }

    public function adh(){ 
        //接收数据
        $request = REQUEST()->all();

        //检查数据
        //check($request,  $this->_extra['form-elems'])

        //构建新增数据
        $insert = [
            'acc' => $request['acc'],
            'pwd' => M('UserModel')->make_pwd($request['pwd']),
            'nickname' => $request['nickname'],
            'cell' => $request['cell'],
            'email' => $request['email'],
            'salt' => M('UserModel')->make_salt(),
            'level' => 1,
            'ori' => 1,
            'user_group__id' => $request['user_group__id'],
            'post_date' => time()
        ];

        $re = M('UserModel')->insert($insert)->exec();

        //执行新增
        if( $re ){
            JSON()->navtab($this->_navTab.'_ad')->exec();
        }else{
            JSON()->stat(300)->msg('操作失败')->exec();
        }
    }

    public function upd(){ 
        
        //接收数据
        $request = REQUEST()->all();

        //检查数据
        //check($request,  $this->_extra['form-elems'])

        //查询数据
        $this->_datas['row'] = M('UserModel')->select('*')->where(['id', $request['id']])->find();

        ///查询所有的用户组
        $this->_datas['user_group'] = M('UserGroupModel')->getAll();

        //分配模板变量&渲染模板
        $this->assign($this->_datas);
        $this->display('user/upd.tpl');
    }

    public function updh(){ 

        //接收数据
        $request = REQUEST()->all();

        //检查数据
        // $this->_extra['form-elems']['id'] = ['ch'=>'菜品ID', 'rule'=>'required'];
        //check($request,  $this->_extra['form-elems'])

        //取出修改了的数据
        #查询已有数据
        $row = M('UserModel')->select('*')->where(['id', $request['id']])->find();
        $request['pwd'] = $request['pwd']=='' ? $row['pwd'] : M('UserModel')->make_pwd($request['pwd'], $row['salt']);
        $update_data = F()->compare($request, $row, ['acc', 'pwd', 'nickname', 'cell', 'email', 'user_group__id']);

        if( empty($update_data) ){
            JSON()->stat(300)->msg('您还没有修改任何数据！请先修改数据。')->exec();
        }

        $re = M('UserModel')
        ->update($update_data)
        ->where(['id', '=', $request['id']])
        ->exec();

        if( $re ){
            JSON()->navtab($this->_navTab.'_upd')->msg('修改用户成功！')->exec();
        }else{
            JSON()->stat(300)->msg('操作失败')->exec();
        }
    }

    public function del(){
    
        //接收数据
        $request = REQUEST()->all();

        //检查数据
        // $this->_extra['form-elems']['id'] = ['ch'=>'菜品ID', 'rule'=>'required'];
        //check($request,  $this->_extra['form-elems'])

        if( $request['tb']=='usergroup' ){
            $navtab = $this->_navTab.'_group';
            $re = M()->table('user_group')->where(['id', '=', $request['id']])->delete();
        }else{
            $navtab = $this->_navTab.'_index';
            //执行删除操作  将需要删除的数据 is_del字段设置为1
            $re = M('UserModel')->fields('is_del')->update([1])->where(['id', '=', $request['id']])->exec();
        }
        
        if( $re ){
            JSON()->navtab($navtab)->msg('删除成功！')->exec();
        }else{
            JSON()->stat(300)->msg('操作失败')->exec();
        }
    }

    public function groupList(){
    
        ///接收数据
        $request = REQUEST()->all();
        $this->_datas['search'] = $request;

        ///需要搜索的字段
        $search_form = [
            ['s_name', 'like']
        ];
        $condition = F()->S2C($request, $search_form);
        if(empty($condition)) $condition=1;

        ///构建查询对象
        $obj = M()->table('user_group')->select('*')->where($condition)->orderby('sort desc');

        #分页参数
        $nowPage = isset($request['pageNum']) ? intval($request['pageNum']) : (isset($_COOKIE['pageNum']) ? intval($_COOKIE['pageNum']) : 1);
        $this->_datas['page'] = $page = $obj->pagination($nowPage)->pagination;
        $page['numPerPageList'] = [20, 30, 40, 60, 80, 100, 120, 160, 200];

        #查询数据
        $this->_datas['rows'] = $obj->limit($page['limitM'] . ',' . $page['numPerPage'])->get();
        
        ///表头信息
        $this->_datas['thead'] = [
            ['ch'=>'组名', 'width'=>160],
            ['ch'=>'排序', 'width'=>120],
            ['ch'=>'ID', 'width'=>30]
        ];

        ///分配模板变量&渲染模板
        $this->assign($this->_datas);
        $this->display('user/group.tpl');
    }

    public function gAdUpd(){
    
        ///接收数据
        $request = REQUEST()->all();

        ///编辑部分
        if( isset($request['id']) ){
            $this->_datas['row'] = M()->table('user_group')->select('*')->where(['id', $request['id']])->find();
        }

        ///分配模板变量&渲染模板
        $this->assign($this->_datas);   
        $this->display('user/gedit.tpl');
    }

    public function gPost(){
        ///接收数据
        $request = REQUEST()->all();

        ///检查数据
        //check($request,  $this->_extra['form-elems'])

        ///模型对象
        $obj = M()->table('user_group');

        if( isset($request['id']) ){///编辑
            #查询已有数据
            $ori = $obj->select('*')->where(['id', $request['id']])->find();

            #新老数据对比，构建编辑数据
            $update = F()->compare($request, $ori, ['name', 'sort', 'comm']);

            if( empty($update) ) JSON()->stat(300)->msg('您还没有修改任何数据！请先修改数据。')->exec();
            $re = $obj->update($update)->where(['id', $request['id']])->exec();

        }else{///新增

            #数据是否重复，重复了没必要新增
            $duplicate = $obj->select('id')->where(['name', $request['name']])->limit(1)->find();
            if(!empty($duplicate)) JSON()->stat(300)->msg('用户组"'.$request['name'].'"已经存在！无需重复添加。')->exec();

            $insert = [
                'name' => $request['name'],
                'sort' => empty($request['sort']) ? 0 : $request['sort'],
                'comm' => $request['comm'],
                'post_date' => time()
            ];

            $re = $obj->insert($insert)->exec();
        }
        
        ///返回结果
        if( $re ){
            JSON()->navtab($this->_navTab.'_group')->exec();
        }else{
            JSON()->stat(300)->msg('操作失败')->exec();
        }
    }

    public function groupPermission(){
        ///接收数据
        $request = REQUEST()->all();
        $this->_datas['search'] = $request;

        ///查询当前组所具有的权限
        $power_arr = M()->table('user_group_permission')->select('menu_permission__id')
        ->where(['user_group__id', $request['id']])->get();

        $power = [];
        foreach( $power_arr as $k=>$v){
        
            $power[] = $v['menu_permission__id'];
        }
        $this->_datas['power'] = $power;

        ///查询所有的权限菜单
        $this->_datas['menu'] = M('MenuPermissionModel')->getAllLevelMenu();
        
        ///分配模板变量&渲染模板
        $this->assign($this->_datas);
        $this->display('user/gpermission.tpl');
    }

    public function groupPermissionPost(){
        ///接收数据
        $request = REQUEST()->all();

        ///检查数据
        //check($request,  $this->_extra['form-elems'])
        $mp_id = isset($request['mp_id']) ? $request['mp_id'] : [];
        
        ///模型对象
        $obj = M()->table('user_group_permission');

        ///调整数据
        #查询已有数据
        $ori = $obj->select('menu_permission__id')->where(['user_group__id', $request['user_group__id']])->get();
        $ori = empty($ori) ? [] : $ori;

        $ori_mp_id = [];
        foreach( $ori as $v){
        
            $ori_mp_id[] = $v['menu_permission__id'];
        }

        #比对数据
        ##交集 不变
        // $id_intersect = array_intersect($mp_id, $ori_mp_id);

        ##在提交中不在原始的 新增
        $id_ad = array_diff($mp_id, $ori_mp_id);

        ##在原始中不在提交的 删除
        $id_del = array_diff($ori_mp_id, $mp_id);

        ///操作数据表
        #新增
        $ad_flag = 0;
        if( !empty($id_ad) ){
        
            $data_ad = [];
            $post_date = time();
            foreach( $id_ad as $v){
                array_push($data_ad, [$v, $post_date, $request['user_group__id']]);
            }
            $re = M()->table('user_group_permission')
            ->fields('menu_permission__id, post_date, user_group__id')
            ->insert($data_ad)
            ->exec();

            if($re) $ad_flag=1;
        }

        #删除
        $del_flag = 0;
        if( !empty($id_del) ){

            $re = M()->table('user_group_permission')
            ->where([
                ['menu_permission__id', 'in', '('.implode(',', $id_del).')'],
                ['user_group__id', $request['user_group__id']]
            ])
            ->delete();

            if($re) $del_flag=1;
        }

        if( $ad_flag||$del_flag ){
            JSON()->navtab($this->_navTab.'_gpermission')->exec();
        }else{
            JSON()->stat(300)->msg('请先修改数据再提交！')->exec();
        }
    }


    /**
     * @method  _condition_string
     * 方法作用: 将符合要求的指定字段，处理为字符串类型的where条件
     * 
     * @param    $request       array    [表单传值的集合]
     * @param    $form_elems    array    [指定的条件字段及其规则，如：]
                $form_elems = [
                    ['acc',         'like'],
                    ['nickname',    'like']
                ];
     * @param    $con_arr       array    [默认的条件字段，如：$con_arr=['is_del', 0];]
     * 
     * @return    string    [字符串类型的条件语句]
     */
    protected function _condition_string($request, $form_elems, $con_arr){

        $con_search = $this->_condition($request, $form_elems);
        $con_default = $this->_condition($con_arr, [], 2);
        $con_arr = array_merge($con_default, $con_search);//将非查询的数据与查询的数据进行合并，形成完整的条件数组数据
        
        $con = [];
        /*
        $con_arr = [
            'name' => '="zhangsan"',
            'post_date' => [
                ['>=1234567'],
                ['<=7654321']
            ]
        ]
        */
        foreach( $con_arr as $field=>$val){
        
            if( is_array($val) ){
                $con[] = $field . $val[0];
                $con[] = $field . $val[1];
            }else{
                $con[] = $field . $val;
            }
        }

        $con = implode(' and ', $con);

        return $con;
    }
    /**
     * 方法名:_condition
     * 方法作用:处理条件初稿，得到可使用的条件数组集合
     * 参数：
     * $request
     * $form_elems
     * $type    处理方式，1=处理带限制规则的条件，当$type为1时，只需要传递第一个参数；2=处理不带限制规则的条件
     * return: array
     */
    protected function _condition($request, $form_elems=[], $type=1){
    
        $con = [];
        if( $type==1 ){

            foreach( $form_elems as $elem){

                if($elem[1]==='time-in'){
                    $has_begin = isset($request['b_'.$elem[0]])&&$request['b_'.$elem[0]]!=='';
                    $has_end = isset($request['e_'.$elem[0]])&&$request['e_'.$elem[0]]!=='';
                    if(!$has_begin&&!$has_end) continue;
                }else{
                    if(!isset($request[$elem[0]])||$request[$elem[0]]==='') continue;
                }
                
                if( isset($elem[1]) ){//y有特殊处理标记

                    if( $elem[1]==='mul' ){//数组
                        
                        $str_arr = [];
                        //        [1, 3, 4]
                        foreach( $request[$elem[0]] as $val){

                            $str_arr[] = $val;
                        }
                        //                             1|3|4
                        $con[$elem[0]] = ' REGEXP "' . implode('|', $str_arr) . '"';
                    }elseif( $elem[1]==='like' ){//模糊匹配

                        $con[$elem[0]] = ' like "%' . $request[$elem[0]] . '%"';
                    }elseif ( $elem[1]==='equal' ) {
                        
                        $con[$elem[0]] = '="' . $request[$elem[0]] . '"';
                    }elseif ( $elem[1]==='time-in' ) {
                        
                        $con[$elem[0]][0] = '>=' . strtotime($request['b_'.$elem[0]]);
                        $con[$elem[0]][1] = '<=' . strtotime($request['e_'.$elem[0]]);
                    }
                
                }else{//普通

                    //     'name'                     'name'
                    $con[$elem[0]] = '="' . $request[$elem[0]] . '"';
                }
            }
        }elseif ($type==2) {
            
            if( is_array($request[0]) ){
                    
                foreach( $request as $k=>$v){

                    if( count($v)==3 ){
                        $con[$v[0]] = $v[1] . '"' . $v[2] . '"';
                    }elseif( strpos($v[1], '=')!==false ){

                        // $con[$k][$v[0]] = $v[1];
                        $con[$v[0]] = $v[1];
                    }else{
                        // $con[$k][$v[0]] = '="' . $v[1] . '"';
                        $con[$v[0]] = '="' . $v[1] . '"';
                    }
                }
            }else{
                
                if( count($request)==3 ){

                    $con[$request[0]] = $request[1] . '"' . $request[2] . '"';
                }elseif( strpos($request[1], '=')!==false ){

                    $con[$request[0]] = $request[1];
                }else{
                    $con[$request[0]] = '="' . $request[1] . '"';
                }
            }
        }
        
        return $con;
    }

    protected function _get_ori_search_datas($request, $form_elems){
    
        $fields = [];
        foreach( $form_elems as $elem){
        
            if( isset($elem[1])&&$elem[1]==='time-in' ){

                $fields[] = 'b_'.$elem[0];
                $fields[] = 'e_'.$elem[0];
            }elseif( isset($elem[0]) ){

                $fields[] = $elem[0];
            }else{
                $fields[] = $elem;
            }
        }

        $ori_search_datas = [];
        foreach( $fields as $field){
            
            if( isset($request[$field]) ){

                $ori_search_datas[$field] = $request[$field];
            }
        }

        return $ori_search_datas;
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
