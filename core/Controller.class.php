<?php

namespace core;

class Controller extends \Smarty{

    //protected $smarty;

    public function __construct(){ 

        parent::__construct();//执行一次Smarty类的构造方法

        //指定模板文件存放的目录（如果是后台则目录应是blog/app/admin/view；如果是前台则目录应是blog/app/home/view）
        $path = APP_PATH . $GLOBALS['plat'] . '/';
        //$this->left_delimiter = '{#';
        //$this->right_delimiter = '#}';

        $this->setTemplateDir($path . 'view');
        $this->setCompileDir($path . 'view_c');

        //调用方法检查是否已经登陆
        $this->checkIsLogin();
    }

    protected function checkIsLogin(){ 
        //http://www.blog.com/index.php?p=home&m=index&a=showIndex
        @session_start();
        //检查之前是否已经登陆过
        //如果没有$_SESSION['user']数据，则说明之前没有登陆成功或者根本没有登陆过
        $LoginControler = PLAT=='tools'&& MOD=='Login';//表示登录模块，即LoginController中的所有方法
        if( !isset($_SESSION['admin'])&&!$LoginControler ){//没有登录信息，又不是登录模块中的某个页面，则需要重新登录
            
            //if( isset($_COOKIE['is_login']) ){//没有SESSION登陆信息，但是存在7天免登录信息，则重新找回之前点击7天免登录的用户信息
                //根据记录的COOKIE信息找回用户所有的信息
                //$userModel = M('\\model\\UserModel');
                //$acc = T($_COOKIE['is_login']);
                //$sql = "select * from bl_user where account='{$acc}'";
                //$user = $userModel->getRow($sql);
                //将找回的用户信息重新存储进SESSION名为user的元素中
                //$_SESSION['user'] = $user;

            //}else{//即不存在SESSION登陆信息，也没有之前记录的7天免登录信息，则重新登陆
                // $this->jump('请先登陆！', 'p=tools&m=login&a=index');
                J('请先登陆！', '/tools/login/index');
            //}
        }
    }

    /**
     * @method    _page
     * 方法作用: 构建分页参数
     * @param    $tb    string    需要统计总的记录条数的表其表名
     * @param    $condition    string    统计总记录条数的条件，直接传递给模型，故条件的格式与模型where方法所需的条件格式保持统一
     * @param    $request    array    表单传值的集合，包含了分页所需的表单参数
     * @param    $num_per_page    int    每页显示的数据条数，默认为31条
     * @return    array    包含分页各项数据的数组
     */
    protected function _page($tb, $condition, $request, $num_per_page=31){
        #分页参数
        $page = [];
        $page['numPerPageList'] = [20, 30, 40, 60, 80, 100, 120, 160, 200];
        $page['pageNum'] = $pageNum = isset($request['pageNum']) ? intval($request['pageNum']) : (isset($_COOKIE[$this->_navTab.'pageNum']) ? intval($_COOKIE[$this->_navTab.'pageNum']) : 1);
        setcookie($this->_navTab.'pageNum', $pageNum);
        $page['numPerPage'] = $numPerPage = isset($request['numPerPage']) ? intval($request['numPerPage']) : $num_per_page;
        $tmp_arr_totalNum = M()->table($tb)->select('count(*) as num')->where($condition)->find();
        $page['totalNum'] = $totalNum = $tmp_arr_totalNum['num'];
        $page['totalPageNum'] = intval(ceil(($totalNum/$numPerPage)));
        $page['limitM'] = ($pageNum-1)*$numPerPage;

        return $page;
    } 
    /**
     * @method    _pagination
     * 方法作用: 构建分页参数
     * @param    $request    array    控制器负责接收数据的$request
     * @param    $obj    object    查询数据的模型对象
     * @param    $$numPerPageList    array    每页展示数据条数列表
     * @return    array    包含分页各项数据的数组
     */
    protected function _paginate($request, $obj, $numPerPageList=[20, 30, 40, 60, 80, 100, 120, 160, 200]){

        $nowPage = isset($request['pageNum']) ? intval($request['pageNum']) : (isset($_COOKIE[$this->_navTab.'pageNum']) ? intval($_COOKIE[$this->_navTab.'pageNum']) : 1);
        $page = $obj->pagination($nowPage)->pagination;
        $page['numPerPageList'] = $numPerPageList;

        return $page;
    } 

    /**
     * @method    _condition_string
     * 方法作用: 将符合要求的指定字段，处理为字符串类型的where条件
     * @param    $request    array    表单传值的集合
     * @param    $form_elems    array    指定的条件字段及其规则，如：
                $form_elems = [
                    ['acc', 'like'],
                    ['nickname', 'like']
                ];
     * @param    $con_arr    array    默认的条件字段，如：$con_arr = ['is_del', 0];
     * @return    string    字符串类型的条件语句
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

    /**
     * 方法名: jump
     * 方法作用: 跳转页面
     * 参数
     * $msg    string    跳转前的提示信息
     * $urlP    string    跳转目标链接后的路由参数与传递的GET数据参数
     * $time    int    提示信息展示的时间
     */
    public function jump($msg='操作成功！', $urlP='p=admin&m=user&a=showIndex', $time=2){ 
        echo $msg; 
        $url = C('URL') . '/index.php?' . $urlP;
        header("Refresh:{$time}; url={$url}");
        exit;
    }




























    protected function JD(&$arr){
    
        foreach( $arr as $arr_key=>$json_str){
        
            $arr[$arr_key] = json_decode($json_str, true);
        }
    }

    protected function _special_fields($special_fields, $row){
        //                          types  arr:|
        foreach( $special_fields as $key=>$val){
            
            if($row[$key]==='') continue;
            
            $rule=explode(':', $val);//复合规则     ['arr', '|']

            if( $rule[0]=='arr' ){//需要转换为数组的
            
                $symbol = isset($rule[1]) ? $rule[1] : ',';
                $row[$key] = explode($symbol, $row[$key]);
            }
        }

        return $row;
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

    protected function _tbhtml($mustShow, $rows, $navtab, $init){

        $tbhtml = '';
        foreach ($rows as $rows_k => $row):

            $tbhtml .= '<tr target="sid_'.$navtab.'" rel="'.$row['id'].'">';
            $tbhtml .= '<td><input name="ids" value="'.$row['id'].'" type="checkbox"></td>';
            $tbhtml .= '<td>'.($rows_k+1).'</td>';
            
            foreach( $mustShow as $field=>$info ){// $field='food_type'   $info=['ch'=>'食物类型', 'width'=>100, 'is_set'=>1]
                
                if(isset($info['is_set']) && $info['is_set']==1){//    is_set表示是否为集合字段，如果是，则需要将集合代号转换为对应的文案值
                    
                    foreach( $init[$field] as $init_field_k=>$init_field_v){//$arr_set_val:3
                        //          '1,3'           3
                        if( strpos($row[$field], (string)$init_field_k)!==false ){//存在集合中的值，则替换为值对应的文案
                            // row['food_type']         3                '饭'        '1,3'
                            $row[$field] = str_replace($init_field_k, $init_field_v, $row[$field]);
                        }
                    }
                }elseif ($field=='post_date') {//如果是时间字段，则转换为对应的年月日时分秒

                    $row[$field] = date('Y-m-d H:i:s', $row[$field]);
                }

                $tbhtml .= '<td>'.$row[$field].'</td>';
            }

            // $tbhtml .= '<td>';
            // $tbhtml .= '<a title="确实要删除？" target="ajaxTodo" href="'.$this->_datas['_url']['del'].'/id/'.$row['id'].'" class="btnDel">删除</a>';
            // $tbhtml .= '<a title="编辑【'.$row['id'].'】" target="navTab" href="'.$this->_datas['_url']['upd'].'/id/'.$row['id'].'" class="btnEdit" rel="'.$navtab.'_edit'.$row['id'].'">编辑</a>';
            // $tbhtml .= '</td>';
        endforeach;

        return $tbhtml;
    }
}