<?php
namespace tools\controller;
use \core\controller;

class TbStructController extends Controller {

    private $_datas = [];
    private $_url = [];
    private $_pageIndex = [];

    public function __construct(){

        parent::__construct();
        
        $this->_datas = [
            'belong_db' => [1=>'blog','tools','manor'],
            'navTab' => 'TbStruct'
        ];

        $this->_url = [
            'index' => L(PLAT, MOD, 'index'),
            'ad' => L(PLAT, MOD, 'ad'),
            'adh' => L(PLAT, MOD, 'adh'),
            'edit' => L(PLAT, MOD, 'edit'),
            'del' => L(PLAT, MOD, 'del')
        ];

        $this->_pageIndex = [
            'numsPerPage'=>40,
            'nowPage'=>1,
            'defaultShowPageRows'=>[20, 40, 70]
        ];
    }

    
    public function ad(){ 
        var_dump(123);
        $this->assign([
            'datas'=>$this->_datas,
            'url'=>$this->_url
        ]);

        $this->display('TbStruct/ad.tpl');
        return;
    }

    public function adh(){ 
        

    }

    public function index(){ 
        //$this->r_attr['_listMustShow'] = array('id'=>'ID','ch_name'=>'中文表名','tb_prefix'=>'表前缀','en_name'=>'英文表名','belong_db'=>'所属库名称');
        //$this->r_attr['_listMustShowWidth'] = array('id'=>30,'ch_name'=>50,'tb_prefix'=>40,'en_name'=>60,'belong_db'=>50);
        
        $mustShow = [
            'id' => ['ch'=>'ID', 'width'=>30], 
            'ch_name' => ['ch'=>'中文表名', 'width'=>50], 
            'tb_prefix' => ['ch'=>'表前缀', 'width'=>40], 
            'en_name' => ['ch'=>'英文表名', 'width'=>60], 
            'belong_db' => ['ch'=>'所属库名称', 'width'=>50]
        ];


        //$this->r_attr['_pic'] = array();
        //$this->r_attr['_picNum'] = array();//各图片字段对应应生成的图片数量
        //$this->r_attr['_picSize'] = array(
            ////array('800_800', '25_25'),
            ////array('800_800', '25_25')
        //);//各图片字段对应需生成的图片尺寸

        //$pic = [
            //'headimg'=>['mkNum'=>2, 'size'=>['800*800', '25*25']], 
            //'goodsimg'=>['mkNum'=>3, 'size'=>['800*800', '600*600', '25*25']]
        //];
        $pic = [];


        ////分页
		$u_nowPage = isset($_POST['pageNum']) ? $_POST['pageNum'] : $this->_pageIndex['nowPage'];
        $this->_pageIndex['numsPerPage'] = isset($_POST['numPerPage']) ? $_POST['numPerPage'] : $this->_pageIndex['numsPerPage'];
		$u_showNumsFrom = ($u_nowPage-1)*$this->_pageIndex['numsPerPage'];

        //$u_totalNumsRow = $this->r_model->getField('count(*) as num');
        $u_totalNumsRow = 0;
		$u_totalNumsPage = (int)round(ceil($u_totalNumsRow/$this->_pageIndex['numsPerPage']));
        $limit = $u_showNumsFrom . ',' . $this->_pageIndex['numsPerPage'];

        //////获得显示列表数据
        ////$data = $this->r_model->getList('', array_keys($this->r_attr['_listMustShow']), $limit);
        $data = [];
        ////pic处理
        //$a_MustShowColNames = array_keys($mustShow);
        //foreach( $data as &$dataV ){ 
            //foreach( $this->r_attr['_pic'] as $picK=>$picColName ){ 
                //if ( in_array($picColName, $a_MustShowColNames) ){ 
                    //$dataV[$picColName] = htmlspecialchars_decode($dataV[$picColName], ENT_QUOTES);
                    //$a_thisPic = $this->_explodePic($dataV[$picColName], $this->r_attr['_picSize'][$k1]);
                    //$dataV[$picColName] = $a_thisPic;
                //}
            //}
        //}

        $tbhtml = '';
        foreach( $mustShow as $k1=>$v1 ){
					
            if ( in_array( $k1, array_keys($pic) ) ){ 
            
                //$tinm_key = array_search($k1, $this->r_attr["_pic"]);
                //$tbhtml .= '<td style="background-color: #aaa;">';
                //for($i=0; $i<$this->r_attr['_picNum'][$tinm_key]; $i++ ){ 
                    //if ( empty($v[$k1][$i]) ){ continue; }
                    //$tbhtml .= '<img src="xxxxxx" />&nbsp;';
                //}
                //$tbhtml .= "</td>";
            }elseif ( $k1=='belong_db' ){ 
                $tbhtml .= "<td>".$this->_datas['belong_db'][$v[$k1]]."</td>";
            }else{ 
                $tbhtml .= "<td>".$v[$k1]."</td>";
            }
        }

        $pagehtml = '';
        foreach( $this->_pageIndex['defaultShowPageRows'] as $v ){ 
			
            $pagehtml .= '<option value="'.$v.'" ';
            if ( $numPerPage==$v ){ 
           $pagehtml .= 'selected="selected"';
            }
            $pagehtml .= ">".$v."</option>";
        }

        
        ////输出变量
        $this->assign(array(
            'orderField'=>'id',
            'url' => $this->_url,
            'data'=>$data,
            'datas'=>$this->_datas,
            //'delUrl'=>$s_delUrl,
            //'editUrl'=>$s_editUrl,
            //'addUrl'=>$s_addUrl,
            //'listUrl'=>$s_listUrl,
            'nowPage'=>$u_nowPage,
            'totalCount'=>$u_totalNumsRow,
            'numPages'=>$u_totalNumsPage,
            //'columExtra'=>$this->r_columExtra,
            //'navTab' => $this->r_navTab,
            'numPerPage'=>$this->_pageIndex['numsPerPage'],
            '_defaultShowPageRows'=>$this->_pageIndex['defaultShowPageRows'],
            'mustShow'=>$mustShow,
            'tbhtml'=>$tbhtml,
            'pagehtml'=>$pagehtml
            //'attr'=>$this->r_attr
        ));

        $this->display('TbStruct/index.tpl');
    }
}      
