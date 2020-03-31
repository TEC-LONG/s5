<?php

namespace plugins;

class FuncTool{


    /**
     * 方法名: randStr
     * 方法作用: 生成指定个数的随机字符串
     * 参数
     * @param    int    $num    需要生成随机字符串的个数，$num默认值为6
     * @return    string    随机生成的字符串
     */
    public function randStr($num=6){ 
        
        $str = '';
        for($i=0; $i<$num; $i++ ):
            
            $seed = mt_rand(1, 10);
            if( $seed<4 ){
                $str .= chr(mt_rand(48, 57));
            }elseif( $seed<7 ){
                $str .= chr(mt_rand(65, 90));
            }else{
                $str .= chr(mt_rand(97, 122));
            }
        endfor;

        return str_shuffle($str);
    }

    private $_file;
    private $_file_new_name='';
    private $_file_vars=[];
    /**
     * 方法名：file_arrange
     * 方法作用：将同名多文件的$_FILES元素的格式整理成单文件的格式，如：
       将 $_FILES=[
           'headimg' => [
               'name' => ['aa.jpg', 'bb.jpg'],
               'type' => ['image/jpeg', 'image/jpeg'],
               'tmp_name' => ['xx/xx/xxx/xx.tmp', 'xx/xx/xxx/xxxx.tmp],
               'error' => [0, 0],
               'size' => [12345, 34234]
           ]
       ]
       整理成 $_FILES=[
           'headimg_0' => [
               'name' => 'aa.jpg',
               'type' => 'image/jpeg',
               'tmp_name' => 'xx/xx/xxx/xx.tmp',
               'error' => 0,
               'size' => 12345
           ],
           'headimg_1' => [
               'name' => 'bb.jpg',
               'type' => 'image/jpeg',
               'tmp_name' => 'xx/xx/xxx/xxxx.tmp,
               'error' => 0,
               'size' => 34234
           ]
       ]
       但是最终返回数组，如：['headimg_0', 'headimg_1']
     * 参数：
     * @param    string    $input_name    某文件$_FILES的下标名（对应的是表单<input type="file" name="xxx" />的name值
     * @return    array    整理之后的虚拟表单file名
     */
    public function file_arrange($input_name){
    
        $tmp_arr = $_FILES[$input_name];
        unset($_FILES[$input_name]);
        
        $new_input_name_arr = [];
        foreach ($tmp_arr['name'] as $key => $name) {
            
            $tmp_new_key = $input_name . '_' . $key;
            $new_input_name_arr[$key] = $tmp_new_key;
            $_FILES[$tmp_new_key] = [
                'name' => $name,
                'type' => $tmp_arr['type'][$key],
                'tmp_name' => $tmp_arr['tmp_name'][$key],
                'size' => $tmp_arr['size'][$key],
                'error' => $tmp_arr['error'][$key]
            ];
        }

        return $new_input_name_arr;
    }
    /**
     * 方法名：file
     * 方法作用：初始化文件上传插件类对象
     * 参数：
     * @param    string    $input_name    某文件$_FILES的下标名（对应的是表单<input type="file" name="xxx" />的name值
     * @param    string    $save_path    文件的保存路径，可选参，不传则为常量UPLOAD_PATH所指定的路径（/upload/)
     * @return    object
     */
    public function file($input_name, $save_path=''){

        $this->_file_new_name = '';//每次进来，先将文件新名字初始化一下

        $this->_file_vars = [
            'mime' => ['image/jpeg', 'image/png', 'image/gif'],//如果是单个可以是字符串，如：'image/png'
            'size' => '5M'//单位可以是："B", "K", M", or "G"
        ];

        if($save_path==='') $save_path=UPLOAD_PATH;//保存路径

        $storage = M('\Upload\Storage\FileSystem', $save_path, 'no_single');
        $this->_file = M('\Upload\File', [$input_name, $storage], 'no_single');

        return $this;
    }
    /**
     * 方法名：file_set
     * 方法作用：设置上传文件的mime类型或size大小参数
     * 参数：
     * @param    array    $arr_key_val   参数数组，如：$arr_key_val=['mime'=>'image/jpeg', 'size'=>'200M']；文件大小单位可以是："B", "K", M", or "G"
     * @return    object
     */
    public function file_set($arr_key_val){
    
        $key_limit = ['mime', 'size'];
        $mime_limit = [];

        foreach( $arr_key_val as $key=>$val){

            if( in_array($key, $key_limit) ){
            
                $this->_file_vars[$key] = $val;
            }elseif ( $key==='name' ) {//文件上传后的名字，带后缀
                
                $this->_file_new_name = $val;
            }
        }
        
        return $this;
    }
    /**
     * 方法名：up
     * 方法作用：执行文件上传操作
     * 参数：
     * @param    string    $new_file_name_prefix    上传的文件新名字前缀，该参数与第二个参数互斥，若同时都指定了值，则优先用第二个参数；两个只需指定一个即可
     * @param    string    $new_file_name    新文件的全名，不包含后缀，该参数与第一个参数互斥
     * @return    false|文件上传插件类对象（假设为$obj，则$obj可以调用以下方法完成相应功能：
                                $obj->getNameWithExtension()     获得包含后缀的文件名
                                $obj->getExtension()     获得文件后缀
                                $obj->getMimetype()    获得文件的mime类型
                                $obj->getSize()      获得文件大小
                                $obj->getMd5()
                                $obj->getDimensions()    获得文件尺寸
                                $obj->getErrors()    获得上传出错信息
     */
    public function up($new_file_name_prefix='', $new_file_name=''){


        $this->_file_new_name = $new_file_name===''?($this->_file_new_name===''?(uniqid($new_file_name_prefix).$this->randStr(8).'_'.date('YmdHis')):$this->_file_new_name):$new_file_name;
        $this->_file->setName($this->_file_new_name);
    
        $this->_file->addValidations(array(
            M('\Upload\Validation\Mimetype', $this->_file_vars['mime'], 'no_single'),
            M('\Upload\Validation\Size', $this->_file_vars['size'], 'no_single')
        ));

        try {
            // Success!
            $re = $this->_file->upload();
        } catch (\Exception $e) {
            // Fail!
            // $errors = $this->_file->getErrors();//换成记录日志
            return false;
        }
        return $this->_file;
    }

    public function var_dump($var){
    
        echo '<pre>';
        var_dump($var);
        echo '<pre>';
        exit;
    }

    public function print_r($var){
    
        echo '<pre>';
        var_dump($var);
        echo '<pre>';
        exit;
    }

    public function compare($request, $row, $fields, $callback=''){
    
        $update_data = [];
        foreach( $row as $k=>$v){
        
            if( in_array($k, $fields) ){
                
                if( $request[$k]!=$v ){
                    $update_data[$k] = $request[$k];
                }
            }
        }
        return $update_data;
    }

    /**
     * 方法名：S2C
     * 方法作用：(search to condition)将搜索数据转化为查询的condition
     * 参数：
     * @param    array    $request    
     * @param    array    $search_form
     * @return    array
     */
    public function S2C($request, $search_form){
        
        // $search_form = [
        //     ['s_mem_acc', 'like']
        // ];
        // $search_form = [
        //     's_name',
        //     ['s_mem_acc', 'like']
        // ];

        $condition = [];
        foreach( $search_form as $k=>$v){
        
            if( is_string($v) ){#仅有一个值
                
                $name = substr($v, 2);
                if(isset($request[$v])) $condition[] = [$name, $request[$v]];
            }else{//数组

                // $counter = count($v);
                $name = substr($v[0], 2);
                if(isset($request[$v[0]])){

                    if( isset($v[2]) ){//user.name
                        $condition[] = [$v[2].$name, $v[1], $request[$v[0]]];
                    }else{
                        $condition[] = [$name, $v[1], $request[$v[0]]];
                    }
                    
                }
            }
        }
        return $condition;
    }

}