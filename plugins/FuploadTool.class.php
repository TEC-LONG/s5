<?php

namespace plugins;

class FuploadTool{

    private $_maxSize;
    private $_allowType;
    private $_pre;
    private $_file;
    private $_path;

    private $_newFileName;

    private $_flag;

    /**
     * @param  array  $arr    
            $arr[0]    array    包含原文件名，文件格式类型，文件临时目录全路径，错误码值，文件大小信息的形参，例: $arr['file']=array('name'=>'xxx.jpg', 'type'=>'image/jpeg', 'tmp_name'=>'C:/window/xxx/xx.tmp', 'error'=>0, 'size'=>1234);
            $arr[1]    string    上传文件新名字的前缀，例：$arr[1]='bg_';
            $arr[2]    int    上传文件大小限定的极大值，例：$arr[2]=200*1024;
      * 
      * 备注：$file形参的错误码值error包括：0：没有错误，1：文件大小超出服务器限制，2：文件大小超出浏览器限制，3：文件上传不完整，4：没有选择上传的文件，6和7：服务器出现故障导致无法上传文件
     */
    public function __construct($arr){ 

        //检查是否为空
        if( empty($arr[0]) ){
            echo '请指定需要上传的文件！';
            return;
        }

        //初始化参数
        $this->_path = PUBLIC_PATH . '/' . $GLOBALS['plat'] . '/upload';

        $this->_pre = empty($arr[1]) ? 'bg_' : $arr[1];
        $this->_maxSize = empty($arr[2]) ? 200*1024 : $arr[2];//默认最大200K

        $this->_file = $arr[0];
        $this->_allowType = array('image/jpeg', 'image/png', 'image/gif');

        $this->_flag = 1;

        //检查系统错误
        if( !$this->checkError() ){
            $this->_flag = 0;
        }

        //检查逻辑错误
        if( $this->_flag==1&&!$this->checkLogicErr() ){
            $this->_flag = 0;
        }

        //给上传文件取名
        if( $this->_flag==1 ){
            $this->mkname();
        }
    }

    public function checkError(){ 
        #处理系统性质的错误
        switch ( $this->_file['error'] ){
            case 1:
                //echo '文件大小超出了系统限制！请重新上传～'; 
            return false;
            case 2:
                //echo '文件大小超出浏览器限制！'; 
            return false;
            case 3:
                //echo '文件上传不完整，请重新上传～'; 
            return false;
            case 4:
                //echo '您还没有选择上传的文件，您想干什么！'; 
            return false;
            case 6:
                case 7:
                    //echo '系统繁忙，请稍候再试！'; 
            return false;
        }

        return true;
    }

    public function checkLogicErr(){ 
        #处理逻辑性质的错误
        //检查文件的大小是否超过200K
        if( $this->_file['size']>=$this->_maxSize ){//上传文件的大小超过了逻辑限制的200K大小
            //echo '文件大小超过200K，请重新选择文件上传！'; 
            return false;
        }

        //检查文件的类型是否符合要求
        if( !in_array($this->_file['type'], $this->_allowType) ){//上传文件的格式类型不符合限定的要求
            //echo '您上传的文件格式类型不符合要求！'; 
            return false;
        }

        return true;
    }

    public function mkname(){ 
        #构建绝对不重复的文件名后保持原文件的后缀
        $this->_newFileName = uniqid($this->_pre) . date('YmdHis') . mt_rand(0, 100) . strchr($this->_file['name'], '.');
    }

    public function up(){ 

        if(!$this->_flag) return false;

        #转移临时文件到指定的目录中
        $wholeFileName = $this->_path . '/' . $this->_newFileName;
        if( move_uploaded_file($this->_file['tmp_name'], $wholeFileName) ){//文件上传成功
            //echo '文件上传成功！'; 
            return $this->_newFileName;
        }else{//文件上传失败
            //echo '请开通会员再上传文件！'; 
            return false;
        }
    }
}