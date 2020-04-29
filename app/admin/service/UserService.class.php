<?php
namespace admin\service;
use \model\UserModel;
use \Validator;

class UserService {


    public function checkRequest($request){
        
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
            'media_link' => 'link',
            'media_surface' => 'link',
            'media_type' => 2,
            'media_type1' => 12,
            'title' => '标题组',
            'topic_type' => 16,
            'cell' => '18502088664',
            'phone' => '020-12345'
        ];

        $obj = Validator::make($request, $fields, $msg);
        echo '<pre>';
        var_dump($obj->err);
        var_dump($obj->sysErr);
        
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
