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
            return URL_EDMD_FILE . '/' . $this->_file_name;
        }
    }

    /**
     * 方法名：getwname
     * 方法用途：get whole name  获取包括路径的完整文件名
     */
    public function getwname(){

        return $this->_path . '/' . $this->_file_name;
    }





    private $_textarea_name;
    private $_cookie_name;
    private $_type_key;
    private $_text_imgs;
    private $_cookie_imgs=[];
    private $_tb_name;
    private $_tb_id;
    private $_tb_field;

    public function textarea($name){
        $this->_textarea_name = $name;
        return $this;
    }

    public function cookie($name){
        $this->_cookie_name = $name;
        return $this;
    }

    public function type($name, $types){
        $this->_type_key = array_search($name, $types);
        return $this;
    }

    public function table($name){
        $this->_tb_name = $name;
        return $this;
    }

    public function id($id){
        $this->_tb_id = $id;
        return $this;
    }

    public function field($field){
        $this->_tb_field = $field;
        return $this;
    }

    private function textImgs($request){
        ///匹配出表单textarea文本中的所有图片
        if(!isset($this->_text_imgs[$this->_textarea_name]))
            $this->_text_imgs[$this->_textarea_name] = REGEX()->htmlImgSrc(htmlspecialchars_decode($request[$this->_textarea_name]));
    }

    private function cookieImgs(){
        ///获取富文本记录下的上传图片
        if(!isset($this->_cookie_imgs[$this->_cookie_name]))
            $this->_cookie_imgs[$this->_cookie_name] = unserialize(urldecode(trim($_COOKIE[$this->_cookie_name])));
    }

    public function editorimg($request){
    
        ///先删除
        $this->imgDel($request);
    
        ///再添加
        $this->imgAd($request);
    }

    public function clear(){
        
        ///获取数据表中现有的该内容的所有图片
        $rows = M('ImagesModel')->select('id, name, path')->where([
            ['type', $this->_type_key],
            ['tb_name', $this->_tb_name],
            ['tb_id', $this->_tb_id],
            ['tb_field', $this->_tb_field]
        ])->get();
        if(empty($rows)) return false;

        ///组装需要删除的
        $delete = [];
        foreach( $rows as $k=>$v){
            $delete[] = $v['id'];
            @unlink(ROOT.'/'.$v['path']);
        }

        ///删除图片数据
        if(!empty($delete))
            M('ImagesModel')->where(['id', 'in', '('.implode(',', $delete).')'])->delete();
    }

    private function imgAd($request){
        ///获取必要的图片数据
        $this->textImgs($request);#表单textarea文本中的所有图片
        $this->cookieImgs();#富文本记录下的上传图片

        ///符合条件的图片录入数据库
        $insert = [];
        foreach( $this->_cookie_imgs[$this->_cookie_name] as $k=>$v){
        
            if( in_array($v['name'], $this->_text_imgs[$this->_textarea_name]) ){
                $insert[] = [
                    'path' => $v['path'],
                    'uniqid' => $v['name'],
                    'name' => $v['name'],
                    'type' => $this->_type_key,
                    'post_date' => time(),
                    'tb_name' => $this->_tb_name,
                    'tb_id' => $this->_tb_id,
                    'tb_field' => $this->_tb_field,
                    'is_use' => 1
                ];
                unset($this->_cookie_imgs[$this->_cookie_name][$k]);
            }
        }

        if(!empty($insert)){
            M('ImagesModel')->fields(array_keys($insert[0]))->insert($insert)->exec();
            setcookie($this->_cookie_name, urlencode(serialize($this->_cookie_imgs[$this->_cookie_name])), time()+7200, '/');
        }
    }

    private function imgDel($request){
        ///匹配出表单textarea文本中的所有图片
        $this->textImgs($request);

        ///获取数据表中现有的该内容的所有图片
        $rows = M('ImagesModel')->select('id, name, path')->where([
            ['type', $this->_type_key],
            ['tb_name', $this->_tb_name],
            ['tb_id', $this->_tb_id],
            ['tb_field', $this->_tb_field]
        ])->get();
        if(empty($rows)) return false;

        ///组装需要删除的
        $delete = [];
        foreach( $rows as $k=>$v){
            
            if( !in_array($v['name'], $this->_text_imgs[$this->_textarea_name]) ){
                $delete[] = $v['id'];
                @unlink(ROOT.'/'.$v['path']);
            }
        }

        ///删除图片数据
        if(!empty($delete))
            M('ImagesModel')->where(['id', 'in', '('.implode(',', $delete).')'])->delete();
    }
}      
