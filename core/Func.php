<?php

/**
 * 函数名: L
 * 函数作用: 根据参数返回项目页面的链接
 * 参数
 * 
 * @param    string    $p    平台参
 * @param    string    $m    模块参
 * @param    string    $a    动作参
 */
// function L($p='exp', $m='index', $a='index')
// {
//     return C('URL').'/index.php?p='.$p.'&m='.$m.'&a='.$a;
// }
function L($route)
{
    return C('URL').$route;
}

/**
 * 函数名: C
 * 函数作用: 根据配置项名称读取配置项值
 * 参数
 * @param  $str  string    读取的配置项，例：$str='pdo.mysql.host'
 *  TIPS: 返回配置文件mvc/config/conf.php  中的配置项的值
 */
function C($str){ 
    
    $arr = explode('.', $str);

    $configs = $GLOBALS['configs'];
    foreach( $arr as $configName ){ 
        $configs = $configs[$configName];
    }
    return $configs;
}

/**
 * 函数名: M
 * 函数作用: 返回单例对象
 * 参数
 * @param  string    $className   包含命名空间的类名，控制器类名、模型类名和系统工具类名可以不包含命名空间，例：$className = '\plugins\CaptchaTool';或$className = 'CaptchaTool';
 * @param  array    $params
 * @param  int    $type    $type='single'表示走单例，为默认值；$type='no_single'表示不走单例
 * @return    object    单例或非单例对象
 */
function M($className='Common', $params=array(), $type='single'){ 
    //Linux下不认“\”做目录分隔符，basename无效
    $t_className = explode('\\', $className);
    $arrNums = count($className);
    $t_className = $t_className[$arrNums-1];

    if( substr($t_className, -10)=='Controller' ){
        $className = '\\' . $GLOBALS['plat'] . '\\controller\\' . $t_className;
    }elseif( substr($t_className, -5)=='Model' ) {
        $className = '\\model\\' . $t_className;
    }elseif( substr($t_className, -4)=='Tool' ){
        $className = '\\plugins\\' . $t_className;
    }elseif( $className=='Common'||$className=='AutoTb' ){//针对Common的情况 和 老的AutoTbModel的情况
        $className = '\\model\\' . $t_className . 'Model';
    }

    return \core\App::single($className, $params, $type);
}

function F(){

    return M('FuncTool');
}

function JSON(){

    return M('JsonTool');
}

function REQUEST(){

    return M('RequestTool');
}

function R(){

    return M('LogTool');
}

/**
 * 排除数组元素
 * @param
 */
function AP($arr, $popKeys){ 
    
    $arr_keys = array_keys($arr);//所有元素下标组成的数组集合

    $newArr = array();
    foreach( $arr_keys as $keyName ){ //遍历需要排除的下标名称
         
        if( !in_array($keyName, $popKeys) ){//如果数组下标不在被排除的目标数组中，则保存
            $newArr[$keyName] = $arr[$keyName];
        }
    }
    return $newArr;//将排除元素后的数组返回
}

function handler_init_special_fields(&$init){
    
    /*
    $init = [
        'level'=>'0:大栏目级|1:小栏目级|2:选项卡级',
        'type'=>'0:否|1:是'
    ]
    */
    $init_bak = $init;
    $init = [];
    foreach( $init_bak as $k=>$v){

        $tmp_arr_1 = explode('|', trim($v));
        /*
        $tmp_arr_1 = ['0:大栏目级', '1:小栏目级', '2:选项卡级']
        */
        foreach( $tmp_arr_1 as $k1=>$v1){

            $tmp_arr_2 = explode(':', trim($v1));// $tmp_arr_2=['0', '大栏目级']
            $init[$k][$tmp_arr_2[0]] = $tmp_arr_2[1];
        }
    }
    /*
    最终形成：
    $init = [
        'level'=>[0=>'大栏目级', 1=>'小栏目级', 2=>'选项卡级'],
        'type'=>[0=>'否', 1=>'是']
    ]
    */
}

/**
  *@FUNC    T_createSelectHtml    
  *@PARAMS    array    $a_options    选项键值对
  *@PARAMS    string    $name    下拉列表的name属性名
  *@PARAMS    num    $type    1：以$a_options的value为option的value  2：以$a_options的key为option的value
  *@PARAMS    string    $selectTarget    选中目标option的value
  *@RETURN     string   $select    完整的select下拉列表
  */
 function T_createSelectHtml($a_options, $name='', $type=1, $selectTarget=''){ 

    $select = '<select class="combox" name="'.$name.'">';

    foreach( $a_options as $k=>$v ){ 
    
        //value值
        if ( $type==1 ){ 
            $s_value = $v;
        }elseif ( $type==2 ){ 
            $s_value = $k;
        }
        //是否选中
        if ( $s_value==$selectTarget ){ 
            $s_selected = 'selected="selected"';
        }else{ 
            $s_selected = '';
        }
        
        $select .= '<option value="'.$s_value.'" '.$s_selected.'>'.$v.'</option>';
    }

    $select .= '</select>';

    return $select;
}

function G($globalVarName='', $globalVarValue=NULL){

    if( $globalVarValue!==NULL ){#增加变量
        $GLOBALS[$globalVarName] = $globalVarValue;
    }

    return $GLOBALS[$globalVarName];
}

function J($msg='操作成功！', $route='default', $time=2){
    
    echo $msg; 

    if( $route==='default' ){///跳转到各平台下的默认页
    
        if(G('plat')=='tools'):
            $route_str = '/tools/login/index';
        elseif(G('plat')=='store'):
            $route_str = '';
        elseif(G('plat')=='home'):
            $route_str = '';
        endif;

    }else{
        $route_str = $route;
    }
    $url = C('URL') . $route_str;
    header("Refresh:{$time}; url={$url}");
    exit;
}

function REGEX(){
    return M('RegexTool');
}
































/**
  * --------------------s.WangXin2016/1/7
  *@FUNC    FN_AR    返回指定的ajax需要的return
  *@PARAMS    string    $tifa_n_args    参数数组，顺序固定array();
  *@RETURN     string   $re
  * ----------------------------------------------------------------------------e
  */
 function AJAXre($case=0, $tifa_n_args=[]){ 

    $re = json_decode('{}');

    //if ( !empty($tifa_n_args) ){ 
        //$case = 1;
    //}

    switch ( $case ){
        
        case 1:
            $re->statusCode = 300;
            $re->message = "操作失败";
        break;
        default:
            $re->statusCode = 200;
            $re->message = "操作成功";
        break;
    }

    return $re;
 }

 /**
 * 函数名: randStr    已转移到系统工具类FuncTool中
 * 函数作用: 生成指定个数的随机字符串
 * 参数
 * @param    int    $num    需要生成随机字符串的个数，$num默认值为6
 */
// function randStr($num=6){ 
    
//     $str = '';
//     for($i=0; $i<$num; $i++ ):
        
//         $seed = mt_rand(1, 10);
//         if( $seed<4 ){
//             $str .= chr(mt_rand(48, 57));
//         }elseif( $seed<7 ){
//             $str .= chr(mt_rand(65, 90));
//         }else{
//             $str .= chr(mt_rand(97, 122));
//         }
//     endfor;

//     return str_shuffle($str);
// }


/**
 *  过滤检查函数
 * @param   $target   mixed    需要检查的目标，可以是数组，也可以是单值，例：$target=$_POST;
 */
function T(&$target){ 
    
    switch ( is_array($target) ){
        case true://是数组
            foreach( $target as &$val ){
                T($val);
            }
        break;
        case false://不是数组
            $target = addslashes(trim($target));
        break;
    }
}

/**
 *  过滤检查是否为空函数
 * @param   $target   mixed    需要检查的目标，可以是数组，也可以是单值，例：$target=$_POST;
 * @param   $checkEmptyElements   mixed    $target需要检查是否为空的元素，以数组的形式构建，
            $checkEmptyElements=1，表示全部元素都检查，为默认值；
            $checkEmptyElements=array('acc', 'pwd')，表示只检查$target中下标为acc和pwd的元素；
            $checkEmptyElements=array(100, 'acc', 'pwd')，第一个元素值为100，表示不检查$target中下标为acc和pwd的元素；
 * @param   $msg   string    检查到某个不能为空的数据为空时，跳转前的提示信息
 * @param   $url   string    跳转的目标页面的URL链接p、m、a参数，默认为网站的默认页，例：$url = 'p=admin&m=user&a=userIndex';
 * @param   $level   int    
 */
function TE($target, $url='', $checkEmptyElements=1, $msg='您填写的参数不能为空！'){ 
    
    $url = empty($url) ? C('URL') : C('URL').'/index.php?'.$url;

    switch ( is_array($target) ){
        case true://检测的目标是一个数组
            if( is_array($checkEmptyElements) )://$checkEmptyElements是一个数组，表示不完全检查$target中的元素
                foreach( $target as $target_key=>$val ){ 
                    if( $checkEmptyElements[0]===100&&in_array($target_key, $checkEmptyElements) )://在$checkEmptyElements中则不用检查的元素
                        continue;
                    elseif( $checkEmptyElements[0]!==100&&!in_array($target_key, $checkEmptyElements) )://不在$checkEmptyElements中则不检查的元素
                        continue;
                    else://检查是否为空
                        if( empty($val) ){
                            echo $msg . '目标：' . $target_key; 
                            header("Refresh:2; url={$url}");
                            exit;
                        }
                    endif;
                }
            elseif($checkEmptyElements===1)://$checkEmptyElements的值为1，表示$target中的元素全部都要检查
                foreach( $target as $target_key=>$val ){ 
                    if( empty($val) ){
                        echo $msg . '目标：' . $target_key; 
                        header("Refresh:2; url={$url}");
                        exit;
                    }
                }
            endif;

        break;
        case false://检测的目标是一个单值
            if( empty($target) ){
                echo $msg; 
                header("Refresh:2; url={$url}");
                exit;
            }
        break;
    }
}

/**
 * 函数名: pageHtml
 * 函数作用: 返回分页HTML内容
 * 参数
 * @param  $nowPage  int  当前页
 * @param  $totalPage  int  总页数
 * @param  $url  string  跳转的连接，例：http://www.home.com/class/day2/code/page.php?xxx=xxx&xxx=xxx&page
 */
function pageHtml($nowPage, $totalPage, $url){ 
    
    #构建左半边部分
    //左半边需要的参数
    $preOnePage = $nowPage-1;//当前页的上一页
    $preTwoPage = $nowPage-2;//当前页的上上页

    if( $nowPage==1 ){//当前页为左边界
        $leftHtml = "";
    }elseif( $preOnePage==1 ) {//当前页的上一页为左边界
        $leftHtml = "<li><a href='$url=$preOnePage'>上一页</a></li> ";
        $leftHtml .= "<li><a href='$url=$preOnePage'>$preOnePage</a></li> ";
    }elseif( $preTwoPage==1 ) {//当前页的上上页为左边界
        $leftHtml = "<li><a href='$url=$preOnePage'>上一页</a></li> ";
        $leftHtml .= "<li><a href='$url=$preTwoPage'>$preTwoPage</a></li> ";
        $leftHtml .= "<li><a href='$url=$preOnePage'>$preOnePage</a></li> ";
    }else{//其他情况
        $leftHtml = "<li><a href='$url=$preOnePage'>上一页</a></li> ";
        $leftHtml .= "... ";
        $leftHtml .= "<li><a href='$url=$preTwoPage'>$preTwoPage</a></li> ";
        $leftHtml .= "<li><a href='$url=$preOnePage'>$preOnePage</a></li> ";
    }

    #构建当前页部分
    $nowHtml = "<li><a href='$url=$nowPage' style='color:red;'>$nowPage</a></li> ";

    #构建右半边的部分
    //右半边需要的参数
    $nextOnePage = $nowPage+1;//当前页的下一页
    $nextTwoPage = $nowPage+2;//当前页的下下页

    if( $nowPage==$totalPage ){//当前页为右边界
        $rightHtml = "";
    }elseif( $nextOnePage==$totalPage ) {//当前页的下一页为右边界
        $rightHtml = "<li><a href='$url=$nextOnePage'>$nextOnePage</a></li> ";
        $rightHtml .= "<li><a href='$url=$nextOnePage'>下一页</a></li> ";
    }elseif( $nextTwoPage==$totalPage ) {//当前页的下下页为右边界
        $rightHtml = "<li><a href='$url=$nextOnePage'>$nextOnePage</a></li> ";
        $rightHtml .= "<li><a href='$url=$nextTwoPage'>$nextTwoPage</a></li> ";
        $rightHtml .= "<li><a href='$url=$nextOnePage'>下一页</a></li> ";
    }else{//其他情况
        $rightHtml = "<li><a href='$url=$nextOnePage'>$nextOnePage</a></li> ";
        $rightHtml .= "<li><a href='$url=$nextTwoPage'>$nextTwoPage</a></li> ";
        $rightHtml .= "... ";
        $rightHtml .= "<li><a href='$url=$nextOnePage'>下一页</a></li> ";
    }

    //拼接分页HTML
    $pageHtml = $leftHtml . $nowHtml . $rightHtml;

    return $pageHtml;
}



