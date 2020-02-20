<?php
namespace plugins;

class EditorTool {

    private $_file_name;
    private $_path;

    public function mkname($name, $type='edmd'){
    
        if( $type=='edmd' ){

            $this->_file_name = $name . '.md';
        }

        return $this;
    }

    public function mkpath($path){
        
        $this->_path = $path;

        return $this;
    }

    public function gtname(){
        return $this->_file_name;
    }

    public function gtpath(){
        return $this->_path;
    }

    public function getfurl($type='edmd'){
        
        if( $type=='edmd' ){
            return URL_EDMD_FILE . $this->_file_name;
        }
    }

    /**
     * 方法名：getwname
     * 方法用途：get whole name  获取包括路径的完整文件名
     */
    public function getwname(){

        return $this->_path . '/' . $this->_file_name;
    }

}      
