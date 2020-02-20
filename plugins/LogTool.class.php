<?php

namespace plugins;

class LogTool{

    private $_type;
    private $_limit_type=['all', 'upload', 'download', 'database'];

    private $_msg=[];
    private $_save_path;

    public function __construct(){

        $this->_type = 'all';
        $this->_save_path = STORAGE_LOG_PATH;
    }

    /**
     * 方法名：set
     * 方法作用：设置日志类型
     * @param    string    $name    类型名称，目前仅支持'type'一个值
     * @param    string    $val    类型名称，只有private $_limit_type内的元素之才有效
     * @return    object
     */
    public function set($name, $val){
    
        if( $name=='type' ){
            $this->_type = $val;
        }
        return $this;
    }

    /**
     * 方法名：msg
     * 方法作用：设置日志记录的内容
     * @param    string    $msg    日志内容
     * @return    object
     */
    public function msg($msg){
    
        $this->_msg[] = $msg;
        return $this;
    }

    /**
     * 方法名：clear
     * 方法作用：清空已有的缓存日志内容
     * @return    object
     */
    public function clear(){

        $this->_msg = [];
        return $this;
    }

    /**
     * 方法名：go
     * 方法作用：执行记录操作
     */
    public function go(){

        $time = date('Y-m-d H:i:s');
    
        $templ = <<<heredoc
{$this->_type}.start.log [{$time}]>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
%s
{$this->_type}.end.log [{$time}]>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
--------------------------------------------------------------------------------------------------------------------------{EOL}
heredoc;

        $templ = str_replace('{EOL}', PHP_EOL, $templ);
        $tmp_msg = implode(PHP_EOL, $this->_msg);

        $templ = sprintf($templ, $tmp_msg);

        //                               all_20200102
        $this->_file_name = $this->_type . '_' . date('Ymd') . '.log';
        file_put_contents($this->_save_path . $this->_file_name, $templ, FILE_APPEND);
        $this->clear();
    }
    

}