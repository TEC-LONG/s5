<?php

namespace plugins;

class RegexTool{


    /**
     * 方法名：htmlImgSrc
     * 方法作用：返回富文本html内容的img中src的图片文件名
     * 参数：
     * @param    array    $target    
     * @return    array
     */
    public function htmlImgSrc($target){
        
        preg_match_all("/src=('|\")([^'\"]+)('|\")/", $target, $matches);
        $editorImages = $matches[0];
        $editorImages = array_map(function($elem){
            preg_match("/('|\")([^'\"]+)('|\")/", $elem, $tmp);
            return basename($tmp[2]);
        }, $editorImages);

        return $editorImages;
    }

}