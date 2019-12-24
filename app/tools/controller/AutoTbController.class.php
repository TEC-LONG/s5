<?php
namespace tools\controller;
use \core\controller;

class AutoTbController extends Controller {

    private $_datas = [];
    private $_url = [];

    public function __construct(){

        parent::__construct();
        
        $this->_datas = [
            'engines' => ['INNODB', 'MyISAM'],
            'chars' => ['utf8', 'gbk', 'latin1']
        ];

        $this->_url = [
            'index' => L('tools', 'AutoTb', 'index')
        ];
    }

    public function index(){ 

        $params = [
            'step' => isset($_POST['step']) ? $_POST['step'] : 'zero',
            'structure' => isset($_POST['structure']) ? $_POST['structure'] : ''
        ];

        if( $params['step']=='one' ):
        
            $this->stepOne($params);

        elseif( $params['step']=='two' ):
        
            $this->stepTwo($params);

        else:
            
            $this->_datas['steps'] = ['one'=>'make tb options','two'=>'get tb structure','three'=>'make files'];

            $this->assign([
                'datas'=>$this->_datas,
                'url'=>$this->_url
            ]);

            $this->display('AutoTb/index.tpl');
            return;
        endif;
    }

    private function stepOne($params){ 

        $model = M('AutoTb', $params);
        $sino_j_stepOne = $model->FP_stepOne($_POST);

        $re = AJAXre();
        $re->exInfo = $sino_j_stepOne;

        echo json_encode($re);
        exit;
    }

    private function stepTwo($params){ 

        //$this->_model = new \Admin\Model\CAutotbModel($this->_post['step'], $this->_post['structure']);
        $model = M('AutoTb', $params);
        $sino_j_stepTwo = $model->FP_stepTwo($_POST);

        $re = AJAXre();
        $re->exInfo = $sino_j_stepTwo;

        //如果需要记录
        // if( $_POST['record']==1 ){
            
        //     $model->record_sql($sino_j_stepTwo, $_POST['belong_pro']);
        // }

        echo json_encode($re);
        exit;
    }

    //public function stepThree(){ 
        //$this->FT_autoStepThree();
    //}

}      
