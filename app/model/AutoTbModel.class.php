<?php
namespace model;
use \core\Model;

class AutoTbModel extends Model{

	private $_structure = '';    //原始结构
    private $_step = '';   //步阶

    private $_chTbName = ''; //中文表名
    private $_enTbName = ''; //英文表名
    private $_chColumNames = '';  //中文字段数组 array('手机号','邮箱'.......);
    private $_enColumNames = ''; //英文字段数组 array('phone','email','password'.........);

    //public function __construct($sifs_n_step, $sifs_n_structure=''){
    public function __construct($params=[]){

        //if(empty($params)) exit;

        $this->_step = $params['step'];
        $this->_structure = trim($params['structure']);

        ////不同flag表单标签不同处理
		switch ( $this->_step ){
			
			default:
				$tina_n_firstExplodeStructure = explode("\r\n", $this->_structure);	//表结构第一次拆分形成的数组  array(表中文名, 表英文名, 表字段中文名, 表字段英文名);
		
                $this->_chTbName = $tina_n_firstExplodeStructure[0];
                $this->_enTbName = $tina_n_firstExplodeStructure[1];

                $this->_chColumNames = explode(',', $tina_n_firstExplodeStructure[2]);	
                $this->_enColumNames = explode(',', $tina_n_firstExplodeStructure[3]);	
			break;
		}
	}

    /**
     * --------------------s.WangXin2016/1/4
     *@FUNC     FP_stepOne    返回 步骤1 所需的返回值成员方法
     *@PARAMS array    $sifa_n_post    外围post
     *@RETURN  json   $sino_j_re    外围所需数据
     * ----------------------------------------------------------------------------e
     */
    public function FP_stepOne($sifa_n_post) {
    
        $sino_j_re = json_decode('{}');

        $sino_j_re->engine = $sifa_n_post['engine'];
        $sino_j_re->charset = $sifa_n_post['charset'];

        $sino_j_re->sql = $this->FT_stepOneSql($sifa_n_post);
        $sino_j_re->columList = $this->FT_createList();

        return $sino_j_re;
    }
    /**
     * --------------------s.WangXin2016/1/4
     *@FUNC     FT_stepOneSql    生成 步骤1 的sql语句
     *@PARAMS     string    $sifa_n_post    $_POST
     *@RETURN      string   $tins_sql_output
     * ----------------------------------------------------------------------------e
     */
    protected function FT_stepOneSql($sifa_n_post) {
    
        $tins_sql_output = "CREATE TABLE `".$this->_enTbName."` ( `id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ) ENGINE=".$sifa_n_post['engine']." DEFAULT CHARSET=".$sifa_n_post['charset'].";"."\r\n";
 
		$tins_sql_output .= "ALTER TABLE `".$this->_enTbName."` ADD `post_date` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0'; ALTER TABLE `".$this->_enTbName."` ADD INDEX ( `post_date` );\r\n";

		return $tins_sql_output;
    }
    /**
     * --------------------s.WangXin2016/1/7
     *@FUNC     createList    建立选项列表
     *@RETURN      string   $list    选项列表
     * ----------------------------------------------------------------------------e
     */
    protected function FT_createList() {
    
        $sina_n_columType = C('tools.AutoTb.fieldType');

        $list = '
<table class="list"  layoutH="200" width="100%">
    <thead>
        <tr>
            <th align="center" width="30">NB</th>
            <th align="center" width="120">Colum</th>
            <th align="center" width="90">Type</th>
            <th align="center" width="90">Length</th>
            <th align="center" width="90">Unsign</th>
            <th align="center" width="90">NotNULL</th>
            <th align="center" width="90">Default<br/>("no"表示默认空,无值表示不设置)</th>
            <th align="center" width="100">Comment</th>
            <th align="center" width="90">Index</th>
            <th align="center" width="90">mustShow?</th>
            <th align="center" width="90">mustWrite?</th>
            <th align="center" width="30">MC?</th>
            <th align="center" width="90">date?</th>
            <th align="center" width="90">editor?</th>
            <th align="center" width="90">upFile?</th>
            <th align="center" width="90">pic?</th>
            <th align="center" width="90">picNums&size</th>
            <th align="center" width="90">radio?</th>
            <th align="center" width="90">checkbox?</th>
            <th align="center" width="90">select?</th>
            <th align="center" width="90">text?</th>
        </tr>
    </thead>

    <tbody>
    ';

        $list .= '
        <style>
        .r3 input {width: 50px;}
        .r6 input, .r13 input {width: 90px;}
        .r7 input {width: 120px;}
        </style>';
        $tinu_counter = 1;
        foreach( $this->_enColumNames as $k=>$v ){ 

            $list .= '
        <tr';
            
            if ( $tinu_counter%2==0 ){ 
                $list .= ' style="background-color:#eee;"';
            }

            $list .='>
        <td title="NB">'.($k+1).'</td>
        <td title="Colum">'.$v.'<input type="hidden" name="r1[]" value="'.$v.'" /></td>
        <td title="Type">'.T_createSelectHtml($sina_n_columType, 'r2[]').'</td>
        <td title="Length" class="r3"><input type="text" name="r3[]" value="200" /></td>
        <td title="Unsign">No<input type="hidden" name="r4[]" value="2" /></td>
        <td title="NotNULL">'.T_createSelectHtml(array(1=>'Yes', 2=>'No'), 'r5[]', 2, 1).'</td>
        <td title="Default" class="r6"><input type="text" name="r6[]" value="no" /></td>
        <td title="Comment" class="r7"><input type="text" name="r7[]" value="'.$this->_chColumNames[$k].'" /></td>
        <td title="Index">'.T_createSelectHtml(array(1=>'Yes', 2=>'No'), 'r8[]', 2, 2).'</td>
        <td title="mustShow" class="r14">'.T_createSelectHtml(array(1=>'Yes', 2=>'No'), 'r14[]', 2, 2).'</td>
        <td title="mustWrite" class="r15">'.T_createSelectHtml(array(1=>'Yes', 2=>'No'), 'r15[]', 2, 2).'</td>
        <td title="'.$v.'"><input type="checkbox" class="machine" /></td>
        <td title="date" class="r9 con"><input type="hidden" name="r9[]" value="2" /></td>
        <td title="editor" class="r10 con"><input type="hidden" name="r10[]" value="2" /></td>
        <td title="upload" class="r11 con"><input type="hidden" name="r11[]" value="2" /></td>
        <td title="pic" class="r12 con"><input type="hidden" name="r12[]" value="2" /></td>
        <td title="picNums&size" class="r13"><input type="hidden" name="r13[]" value="no" /></td>
        <td title="radio" class="r16 con"><input type="hidden" name="r16[]" value="2" /></td>
        <td title="checkbox" class="r17 con"><input type="hidden" name="r17[]" value="2" /></td>
        <td title="select" class="r18 con"><input type="hidden" name="r18[]" value="2" /></td>
        <td title="text" class="r19 con"><input type="hidden" name="r19[]" value="1" /></td>
        </tr>
        ';
            $tinu_counter++;
        }

        $list .= '
    </tbody>
</table>
<script type="text/javascript">
$("select[name=\'r2[]\']").bind("change", function(){
    var obj = $(this);
    var parent_obj = obj.parent().siblings("td");
    var intRule = /int/;
    var floatRule = /float|double/;
    var decimalRule = /decimal/;
    var charRule = /varchar|char/;
    
    if( intRule.test(obj.val()) ){

        if( /tiny/.test(obj.val()) ){
            var lengthHtml = \'<input type="text" name="r3[]" value="1" />\';
        }else if( /small/.test(obj.val()) ){
            var lengthHtml = \'<input type="text" name="r3[]" value="2" />\';
        }else if( /medium/.test(obj.val()) ){
            var lengthHtml = \'<input type="text" name="r3[]" value="3" />\';
        }else if( /big/.test(obj.val()) ){
            var lengthHtml = \'<input type="text" name="r3[]" value="8" />\';
        }else{
            var lengthHtml = \'<input type="text" name="r3[]" value="4" />\';
        }
        var unsignHtml = \''.T_createSelectHtml(array(1=>'Yes', 2=>'No'), 'r4[]', 2, 1).'\';
        var notNULLHtml = \'Yes<input type="hidden" name="r5[]" value="Yes" />\';
        var defaultHtml = \'<input type="number" name="r6[]" value="0" />\';

    }else if( floatRule.test(obj.val()) ){
        if( /float/.test(obj.val()) ){
            var lengthHtml = \'<input type="text" name="r3[]" value="4" />\';
        }else{
            var lengthHtml = \'<input type="text" name="r3[]" value="8" />\';
        }
        var unsignHtml = \''.T_createSelectHtml(array(1=>'Yes', 2=>'No'), 'r4[]', 2, 1).'\';
        var notNULLHtml = \'Yes<input type="hidden" name="r5[]" value="Yes" />\';
        var defaultHtml = \'<input type="text" name="r6[]" value="0.00" />\';

    }else if( decimalRule.test(obj.val()) ){
        var lengthHtml = \'<input type="text" name="r3[]" value="10,2" />\';
        var unsignHtml = \''.T_createSelectHtml(array(1=>'Yes', 2=>'No'), 'r4[]', 2, 1).'\';
        var notNULLHtml = \'Yes<input type="hidden" name="r5[]" value="Yes" />\';
        var defaultHtml = \'<input type="text" name="r6[]" value="0.0000" />\';

    }else if( charRule.test(obj.val()) ){
        if( /var/.test(obj.val()) ){
            var lengthHtml = \'<input type="text" name="r3[]" value="200" />\';
        }else{
            var lengthHtml = \'<input type="text" name="r3[]" value="32" />\';
        }
        var unsignHtml = \'No<input type="hidden" name="r4[]" value="2" />\';
        var notNULLHtml = \''.T_createSelectHtml(array(1=>'Yes', 2=>'No'), 'r5[]', 2, 1).'\';
        var defaultHtml = \'<input type="text" name="r6[]" value="no" />\';

    }else{
        var lengthHtml = \'<input type="text" name="r3[]" value="" />\';
        var unsignHtml = \'No<input type="hidden" name="r4[]" value="2" />\';
        var notNULLHtml = \''.T_createSelectHtml(array(1=>'Yes', 2=>'No'), 'r5[]', 2, 1).'\';
        var defaultHtml = \'<input type="text" name="r6[]" value="" />\';
    }

    $(parent_obj[2]).html(lengthHtml);//Length
    $(parent_obj[3]).html(unsignHtml);//Unsign
    $(parent_obj[4]).html(notNULLHtml);//NotNULL
    $(parent_obj[5]).html(defaultHtml);//Default
});

$(".machine").bind("click", function(){

    if( $(this).is(":checked") ){
        $(this).parent().siblings(".r9").html(\''.T_createSelectHtml(array(1=>'Yes', 2=>'No'), 'r9[]', 2, 2).'\');
        $(this).parent().siblings(".r10").html(\''.T_createSelectHtml(array(1=>'Yes', 2=>'No'), 'r10[]', 2, 2).'\');
        $(this).parent().siblings(".r11").html(\''.T_createSelectHtml(array(1=>'Yes', 2=>'No'), 'r11[]', 2, 2).'\');
        $(this).parent().siblings(".r12").html(\''.T_createSelectHtml(array(1=>'Yes', 2=>'No'), 'r12[]', 2, 2).'\');
        $(this).parent().siblings(".r13").html(\'<input type="text" name="r13[]" />\');
        $(this).parent().siblings(".r16").html(\''.T_createSelectHtml(array(1=>'Yes', 2=>'No'), 'r16[]', 2, 2).'\');
        $(this).parent().siblings(".r17").html(\''.T_createSelectHtml(array(1=>'Yes', 2=>'No'), 'r17[]', 2, 2).'\');
        $(this).parent().siblings(".r18").html(\''.T_createSelectHtml(array(1=>'Yes', 2=>'No'), 'r18[]', 2, 2).'\');
        $(this).parent().siblings(".r19").html(\''.T_createSelectHtml(array(1=>'Yes', 2=>'No'), 'r19[]', 2, 1).'\');

        $(".con").find("select").bind("change", commonSelect);

    }else{
        $(this).parent().siblings(".r9").html(\'<input type="hidden" name="r9[]" value="2" />\');
        $(this).parent().siblings(".r10").html(\'<input type="hidden" name="r10[]" value="2" />\');
        $(this).parent().siblings(".r11").html(\'<input type="hidden" name="r11[]" value="2" />\');
        $(this).parent().siblings(".r12").html(\'<input type="hidden" name="r12[]" value="2" />\');
        $(this).parent().siblings(".r13").html(\'<input type="hidden" name="r13[]" value="no" />\');
        $(this).parent().siblings(".r16").html(\'<input type="hidden" name="r16[]" value="2" />\');
        $(this).parent().siblings(".r17").html(\'<input type="hidden" name="r17[]" value="2" />\');
        $(this).parent().siblings(".r18").html(\'<input type="hidden" name="r18[]" value="2" />\');
        $(this).parent().siblings(".r19").html(\'<input type="hidden" name="r18[]" value="1" />\');

        $(".con").find("select").unbind();
    }
});

var commonSelect = function(){
    if($(this).val()==1){
        $(this).parent().siblings(".con").find("select").find("option[value=\'2\']").attr("selected", "selected");
        $(this).parent().siblings(".con").find("select").hide(0);
    }else if($(this).val()==2){
        $(this).parent().siblings(".con").find("select").show(0);
    }
}
</script>
        ';
        return $list;
    }

    // public function record_sql($json, $belong_pro){
        
    //     $datas = [
    //         'belong_pro' => $belong_pro,
    //         'ch_name' => $this->_chTbName,
    //         'en_name' => $this->_enTbName,
    //         'ch_serial_fields' => serialize($this->_chColumNames),
    //         'en_serial_fields' => serialize($this->_enColumNames),
    //         'ori_struct' => $this->_structure,
    //         'create_sql' => $json->sql
    //     ];

    //     //执行新增
    //     if( M()->setData('prorecord', $datas) ){
    //         $re = AJAXre();
    //         $re->navTabId = $this->_navTab.'_ad';
    //         $re->message = '添加成功！';
    //     }else{
    //         $re = AJAXre(1);
    //     }
    // }

    /**
     * --------------------s.WangXin2016/1/7
     *@FUNC     FP_stepTwo    返回 步骤2 所需的返回值成员方法
     *@PARAMS array    $sifa_n_post    外围post
     *@RETURN  json   $sino_j_re    外围所需数据
     * ----------------------------------------------------------------------------e
     */
    public function FP_stepTwo($sifa_n_post) {
    
        $sino_j_re = json_decode('{}');

        $sino_j_re->sql = $this->FT_stepTwoSql($sifa_n_post);

        return $sino_j_re;
    }
    /**
     * --------------------s.WangXin2016/1/4
     *@FUNC     FT_stepTwoSql    生成 步骤2 的sql语句
     *@PARAMS     string    $sifa_n_post    $_POST
     *@RETURN      string   $tins_sql_output
     * ----------------------------------------------------------------------------e
     */
    protected function FT_stepTwoSql($sifa_n_post) {
    
        $tins_sql_output = $this->FT_stepOneSql($sifa_n_post);

        foreach( $sifa_n_post['r1'] as $k=>$v ){ 
        
            $tins_sql_output .= "ALTER TABLE `".$this->_enTbName."` ADD `".$v."` ";
            
            if ( !empty($sifa_n_post['r2'][$k]) ){ //type
                
                $tins_sql_output .= strtoupper($sifa_n_post['r2'][$k]);//"INT"
            }

            if ( !empty($sifa_n_post['r3'][$k]) ){ //length
            
                $tins_sql_output .= "( ".$sifa_n_post['r3'][$k]." ) ";
            }

            if ( !empty($sifa_n_post['r4'][$k])&&$sifa_n_post['r4'][$k]==1 ){ //unsign
            
                
                $tins_sql_output .= " UNSIGNED ";
            }

            if ( !empty($sifa_n_post['r5'][$k])&&$sifa_n_post['r5'][$k]==1 ){ //NULL
            
                $tins_sql_output .= " NOT NULL ";
            }elseif ( !empty($sifa_n_post['r5'][$k])&&$sifa_n_post['r5'][$k]==2 ){ 
                $tins_sql_output .= " NULL ";
            }

            if ( !empty($sifa_n_post['r6'][$k])||$sifa_n_post['r6'][$k]=='0' ){ //default
            
                if ( $sifa_n_post['r6'][$k]=='no' ){ 
                    $tins_sql_output .= "DEFAULT '' ";
                }else{ 
                    $tins_sql_output .= "DEFAULT '".$sifa_n_post['r6'][$k]."' ";
                }
            }

            if ( !empty($sifa_n_post['r7'][$k]) ){ //comment
            
                $tins_sql_output .= "COMMENT '".$sifa_n_post['r7'][$k]."';";
            }

            if ( !empty($sifa_n_post['r8'][$k])&&$sifa_n_post['r8'][$k]==1 ){ //index
            
                $tins_sql_output .= " ALTER TABLE `".$this->_enTbName."` ADD INDEX ( `$v` );";
            }
            $tins_sql_output .= "\r\n";
        }
        return $tins_sql_output;
    }
}