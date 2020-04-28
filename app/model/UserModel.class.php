<?php
namespace model;
use \core\Model;

class UserModel extends Model{

    protected $table = 'user';
    private $_salt='';

    const C_LEVEL       = ['普通用户', '管理员'];
    const C_STATUS      = ['正常', '禁用'];
    const C_ORI         = ['注册', '后台添加'];
    const C_IS_ONLINE   = ['未知', '在线', '离线'];
    const C_USER_TYPE   = ['无', '供应商'];

    public function make_pwd($pwd, $salt=''){
    
        if($salt==='') $salt = $this->make_salt();
        return md5($salt . md5($pwd) . $salt);
    }

    public function make_salt(){

        if( $this->_salt==='' ){
            $this->_salt = F()->randStr();
        }

        return $this->_salt;
    }

    /**
     * 列表校验数据
     */
    public function checkRequest($request){
    
        //检查数据
        #必须先检查topic_id，没有这个参数，程序无法继续执行
        $msg = [//字段对应的提示信息
            'topic_id.required' => '缺少必要参数！',
            'topic_id.integer' => '非法的操作！'
        ];
        if($re = $this->checkRequests($arrData, ['topic_id'=>'required|integer'], $msg)) return $re;

        #然后再检查必须的topic_type和templ_type
        $fields = [//需检查的字段
            'topic_type'  => 'required|integer',
            'templ_type'  => 'required|integer'
        ];

        $msg = [//字段对应的提示信息
            'topic_type.required' => '缺少必要参数！',
            'topic_type.integer' => '非法的操作！',
            'templ_type.required' => '缺少必要参数！',
            'templ_type.integer' => '非法的操作！'
        ];

        if($re = $this->checkRequests($arrData, $fields, $msg, [], '/manage/topicModule/ad?topic_id='.$arrData['topic_id'])) return $re;

        if( $search['title']=='' ){
            
        }

        #必须要的数据
        $msg = [];
        $fields = [];
        if( !($arrData['topic_type']==2 && $arrData['templ_type']==2) ){//排除 商城--模板二 检查文字标题是否填写
            $fields['title'] = 'required|max:50';
            $msg['title.required'] = '请填写标题！';
            $msg['title.max'] = '标题字符数必须小于50！';
        }

        if( $arrData['topic_type']==1 && $arrData['templ_type']==2 ){//任务单--模板二

            $fields['person_nums'] = 'required|integer|min:0';
            $msg['person_nums.required'] = '请填写领取人数!';
            $msg['person_nums.integer'] = '领取人数必须为数字!';
            $msg['person_nums.min'] = '领取人数值必须大于0!';

            if( !empty($arrData['more_task']) ){    //“更多任务等你领”必须以特定字符开头

                preg_match_all ("/^(http://)|(https://)|(xm://)/", $arrData['more_task'], $pat_arr);
                if( empty($pat_arr[0]) )
                    return redirect()->to('/manage/topicModule/ad?topic_id='.$arrData['topic_id'])->with(['error'=>'“更多任务等你领”必须以http://或https://或xm://开头！']);
            }
        }

        ##开始检查
        if($re = $this->checkRequests($arrData, $fields, $msg, [], '/manage/topicModule/ad?topic_id='.$arrData['topic_id'])) return $re;
    }

    /**
     * [checkRequests 检查表单传的值]
     * @param  Request $request [description]
     * @param  array $fields [需要检查的字段]   例：
                                                     $fields = ['id' => 'required|integer'];
    * @param  array $msg [不同字段对应给出的提示信息]   例：
                                                    $msg = [
                                                        'id.required' => '缺少必要参数！',
                                                        'id.integer' => '非法的操作！'
                                                    ];
    * @param  array $urls [不同字段对应跳转的地址][选填]   例：
                                                    $urls = ['id' => '/manage/topicModule/list?topic_id=xxx'];
    * @param  string $defaultURL [默认跳转地址，当没有指定字段跳转地址时使用]
    * @return [bool]           [没有问题返回false，有问题返回跳转页面]
    */
    private function checkRequests($arrData, $fields, $msg, $urls=[], $defaultURL=''){

        //初始化参数
        // $arrData = $requests->all();
        $reData = [];
        $reData['url'] = empty($defaultURL) ? '/manage/activityTopic/index' : $defaultURL;
  
        //检查参数
        $validator = Validator::make($arrData, $fields, $msg);
        if ($validator->fails()){
  
            $err = $validator->errors();
            foreach( $fields as $k=>$v){
  
                if($err->has($k)){//存在错误，则跳转
  
                    if(isset($urls[$k])) $reData['url'] = $urls[$k];
                    return redirect()->to($reData['url'])->with( ['error'=>$err->first($k)] );
                }
            }
        }
  
        return false;//没有问题，返回false
    }
}