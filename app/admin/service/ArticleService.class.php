<?php
namespace admin\service;
use \Validator;

class ArticleService {

    /**
     * 获取文章列表
     */
    public function getArticleList($request, $controller){
    
        ///需要搜索的字段
        $search_form = [
            ['s_id', '=']
        ];
        $condition = F()->S2C($request, $search_form);
        $condition[] = ['is_del', 0];

        ///构建查询对象
        $obj = M('ArticleModel')->select('*')->where($condition);

        #分页参数
        $controller->_datas['page'] = $page = $controller->_paginate($request, $obj);

        #查询数据
        $controller->_datas['rows'] = $obj->limit($page['limitM'] . ',' . $page['numPerPage'])->get();
    }

    /**
     * 添加文章
     */
    public function insert($request, $urls){

        /// 分类数据初步处理
        $cate = $this->cateFirstH($request);
        
        ///构建新增数据
        $insert                         = [];
        $insert['title']                = $request['title'];
        $insert['tags']                 = empty($request['tags']) ? '' : $request['tags'];
        $insert['post_date']            = time();
        $insert['content']              = str_replace('"', '&quot;',str_replace('\\', '\\\\', $request['content']));
        $insert['content_html']         = $request['editormd-html-code'];
        $insert['article_category__id'] = $cate['three'][0];
        $insert['crumbs_cat_ids']       = $cate['one'][0] . '|' . $cate['two'][0] . '|' . $cate['three'][0];
        $insert['crumbs_cat_names']     = $cate['one'][1] . '|' . $cate['two'][1] . '|' . $cate['three'][1];

        ///执行新增
        $re = M('ArticleModel')->insert($insert)->exec();

        # 不成功，抛出异常
        if( !$re ) THROWE(JSON()->arr([
            'msg'   => '操作失败',
            'url'   => $urls['ad']['url']
        ])->exec('return'));
    }

    /**
     * 编辑文章
     */
    public function update($request, $urls){

        /// 分类数据初步处理
        $cate = $this->cateFirstH($request);

        /// 过滤出改变了的数据
        $request['content']                 = str_replace('"', '&quot;',str_replace('\\', '\\\\', $request['content']));
        $request['content_html']            = $request['editormd-html-code'];
        $request['article_category__id']    = $cate['three'][0];
        $request['crumbs_cat_ids']          = $cate['one'][0] . '|' . $cate['two'][0] . '|' . $cate['three'][0];
        $request['crumbs_cat_names']        = $cate['one'][1] . '|' . $cate['two'][1] . '|' . $cate['three'][1];
    
        # 对比新老数据
        ## 查询已有数据
        $row = M()->table('article')->select('*')->where(['id', $request['id']])->find();
        $update_data = F()->compare($request, $row, ['title', 'tags', 'content', 'crumbs_cat_names', 'crumbs_cat_ids', 'article_category__id', 'content_html']);

        // if( empty($update_data) ) THROWE('您还没有修改任何数据！请先修改数据。');
        if( empty($update_data) ) THROWE(JSON()->arr([
            'msg'   => '您还没有修改任何数据！请先修改数据',
            'url'   => $urls['upd']['url'].'?id='.$request['id']
        ])->exec('return'));

        ///更新数据
        $update_data['upd_time'] = time();

        $re = M()->table('article')
        ->fields(array_keys($update_data))
        ->update($update_data)
        ->where(['id', $request['id']])
        ->exec();

        # 不成功，抛出异常
        if( !$re ) THROWE(JSON()->arr([
            'msg'   => '修改失败！',
            'url'   => $urls['upd']['url'].'?id='.$request['id']
        ])->exec('return'));
    }

    /**
     * 分类数据初步处理
     */
    private function cateFirstH($request){

        $cate = [];
    
        $cate['one']    = explode('|', $request['cate1']);
        $cate['two']    = explode('|', $request['cate2']);
        $cate['three']  = explode('|', $request['cate3']);

        return $cate;
    }





    public function checkListRequest($request){
    
        ///需检查的搜索字段    UTF8编码下：/[x{4e00}-x{9fa5}]+/
        $fields = [
            's_id'         => 'int$|min&:1',
            // 's_'    => 'ch-utf8'
        ];

        ///字段排除检查值
        $excludes = [
            // 's_acc' => [''],
            // 's_nickname' => ['']
        ];

        ///字段对应的提示信息
        $msg = [
            's_id.int.min'   => 'ID值不能小于0'
        ];

        $obj = Validator::make($request, $fields, $msg, $excludes);

        if( !empty($obj->err) ){
            echo '<pre>';
            var_dump($obj->err);
            exit;
        }
    }

    public function upheadimg($input){
    
        ///以年份和月份分别来创建保存editor图片的一级和二级目录
        $first_folder = date('Y');
        $first_folder_path = USER_IMG . $first_folder;

        if (!is_dir($first_folder_path)) {
            mkdir($first_folder_path);
            chmod($first_folder_path, 0757);
        }

        $second_folder = date('m');
        $path = $first_folder_path . '/' . $second_folder;

        if (!is_dir($path)) {
            mkdir($path, 0757);
            chmod($path, 0757);
        }

        #图片的命名规则：前缀_随机字符串年月日时分秒.随机字符串.jpg
        $imgName = uniqid('user_') . date('YmdHis') . '.' . F()->randStr(6);

        if ($file = F()->file($input, $path)->up('editormd_', $imgName)) {
            //$wholePath = '/home/xx/xx/s5/upload/userimg/2019/11/xx.jpg';
            $wholePath = $path . '/' . $first_folder . '/' . $second_folder . '/' . $file->getNameWithExtension();
            $img = F()->path2src($wholePath);//$img = 'upload/userimg/2019/11/xx.jpg';

            return $img;
        }

        return false;
    }

    public function checkRequestTest($request){
        
        $fields = [//需检查的字段
            'media_link'    => 'regex',
            'media_surface' => 'regexx',
            'media_type'    => 'int$|',
            'media_type1'   => 'int$|minn&:10$|max&:20',
            'title'         => 'required',
            'topic_type'    => 'required$||int$|>&:10$|<&:20',
            'cell'          => 'required$||regex$|@&:/^[1]([3-9])[0-9]{9}$/',
            'phone'         => 'regex$|@&:/^[1]([3-9])[0-9]{9}$/'
        ];

        // $fields = [//需检查的字段
        //     'media_link'    => 'required',
        //     'media_surface' => 'required',
        //     'media_type'    => 'int$|min&:0',
        //     'media_type1'   => 'int$|min&:10$|max&:20',
        //     'title'         => 'required',
        //     'topic_type'    => 'required$||int$|>&:10$|<&:20',
        //     'cell'          => 'required$||regex$|@&:/^[1]([3-9])[0-9]{9}$/',
        //     'phone'         => 'required'
        // ];

        $msg = [//字段对应的提示信息
            'media_link.regex'      => '链接格式不正确',
            'media_surface.regex'   => '图片链接格式不正确',
            'media_type.int'        => '媒体类型值必须为整数',
            'media_type1.int.min'   => '媒体1类型值不能小于{min}',
            'media_type1.int.max'   => '媒体1类型值不能大于{max}',
            'title.required'        => '标题为必填参数',
            'topic_type.required'   => '话题类型为必填参数',
            'topic_type.int.>'      => '话题类型的值必须大于{>}',
            'topic_type.int.<'      => '话题类型的值必须小于{<}',
            'cell.required'         => '"手机号"为必填参数',
            'cell.regex'            => '"手机号"格式不正确',
            'phone.regex'           => '座机号格式不正确',
        ];

        $request = [
            'media_link'    => 'link',
            'media_surface' => 'link',
            'media_type'    => 2,
            'media_type1'   => 12,
            'title'         => '标题组',
            'topic_type'    => 16,
            'cell'          => '18502088664',
            'phone'         => '020-12345'
        ];

        $obj = Validator::make($request, $fields, $msg);

        echo '<pre>';
        var_dump($obj->err);
        
    }

    // /**
    //  * [checkRequests 检查表单传的值]
    //  * @param  Request $request [description]
    //  * @param  array $fields [需要检查的字段]   例：
    //                                                  $fields = ['id' => 'required|integer'];
    // * @param  array $msg [不同字段对应给出的提示信息]   例：
    //                                                 $msg = [
    //                                                     'id.required' => '缺少必要参数！',
    //                                                     'id.integer' => '非法的操作！'
    //                                                 ];
    // * @param  array $urls [不同字段对应跳转的地址][选填]   例：
    //                                                 $urls = ['id' => '/manage/topicModule/list?topic_id=xxx'];
    // * @param  string $defaultURL [默认跳转地址，当没有指定字段跳转地址时使用]
    // * @return [bool]           [没有问题返回false，有问题返回跳转页面]
    // */
    // private function checkRequests($arrData, $fields, $msg, $urls=[], $defaultURL=''){

    //     //初始化参数
    //     // $arrData = $requests->all();
    //     $reData = [];
    //     $reData['url'] = empty($defaultURL) ? '/manage/activityTopic/index' : $defaultURL;
  
    //     //检查参数
    //     $validator = Validator::make($arrData, $fields, $msg);
    //     if ($validator->fails()){
  
    //         $err = $validator->errors();
    //         foreach( $fields as $k=>$v){
  
    //             if($err->has($k)){//存在错误，则跳转
  
    //                 if(isset($urls[$k])) $reData['url'] = $urls[$k];
    //                 return redirect()->to($reData['url'])->with( ['error'=>$err->first($k)] );
    //             }
    //         }
    //     }
  
    //     return false;//没有问题，返回false
    // }
    
}      
