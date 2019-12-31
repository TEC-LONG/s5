<h2 class="contentTitle">表单验证</h2>

<div class="pageContent">
	
	<form enctype="multipart/form-data" method="post" action="{$url.updh}/id/{$row.id}" class="pageForm required-validate" onsubmit="return iframeCallback(this, navTabAjaxDone)">
		<input type="hidden" name="step" value="two" />

		<div class="pageFormContent nowrap" layoutH="97"  style="align:center;">
		
        
			<dl>
				<dt>所属库名称：</dt>
				<dd>
					{:FN_createSelect($columExtra['belong_db'], 'belong_db', 2, $thisRow['belong_db'])}
					<input type="hidden" name="old_belong_db" value="{$thisRow['belong_db']}" />
					<span class="info"></span>
				</dd>
			</dl>
                
			<dl>
				<dt>表前缀：</dt>
				<dd>
					<input type="text" maxlength="10" name="tb_prefix" value="{$thisRow[tb_prefix]}" class="required" />
					<input type="hidden" name="old_tb_prefix" value="{$thisRow['tb_prefix']}" />
					<span class="info"></span>
				</dd>
			</dl>

			<dl>
				<dt>英文表名：</dt>
				<dd>
					<input type="text" maxlength="30" name="en_name" value="{$thisRow[en_name]}" class="required" />
					<input type="hidden" name="old_en_name" value="{$thisRow['en_name']}" />
					<span class="info"></span>
				</dd>
			</dl>

			<dl>
				<dt style="color:red;">中文表名：</dt>
				<dd>
					<input type="text" maxlength="20" name="ch_name" value="{$thisRow[ch_name]}" class="required" />
					<input type="hidden" name="old_ch_name" value="{$thisRow['ch_name']}" />
					<span class="info"></span>
				</dd>
			</dl>
                
			<!-- <dl>
				<dt>表结构：</dt>
				<dd>
					<textarea name="structure" class="required" cols="100" rows="9">{$thisRow[form_structure]}</textarea>
					<span class="info"></span>
				</dd>
			</dl> -->

			<div class="divider"></div>

	<table class="table">
	<thead>
		<tr>
			<th width="30">序号</th>
			<th width="240">en_colum</th>
			<th width="50">ch_colum</th>
			<th width="360">字段特性</th>
			<th width="370">特性描述</th>
		</tr>
	</thead>
	<tbody  class="columArea">
		<php>
		$a_enColums = unserialize($thisRow['en_colums']);
		$a_chColums = unserialize($thisRow['ch_colums']);
		foreach( $a_enColums as $k=>$v ){
			$tu_k = array_search($v, $a_tableOriColumEnColum);
			if ( $tu_k===false )	unset($tu_k);
		</php>
		<tr>
			<td>{$k+1}</td>
			<td><input type="text" name="en_colum[]" value="{$v}" style="width:210px;" /><input type="hidden" name="old_en_colum[]" value="{$v}" /></td>
			<td><input type="text" name="ch_colum[]" value="{$a_chColums[$k]}" /><input type="hidden" name="old_ch_colum[]" value="{$a_chColums[$k]}" /></td>
			<td><input type="text" name="charact[]" value="{$infosTableOriColum[$tu_k]['charact']}" style="width:330px;" /><input type="hidden" name="old_charact[]" value="{$infosTableOriColum[$tu_k]['charact']}" /></td>
			<td><input type="text" name="colum_des[]" value="{$infosTableOriColum[$tu_k]['des']}" style="width:340px;" /><input type="hidden" name="old_colum_des[]" value="{$infosTableOriColum[$tu_k]['des']}" /></td>
		</tr>
		<php>}</php>
	</tbody>
</table>

			<div class="divider"></div>
			<a title="添加字段" class="btnAdd btnAddColum" href="#">添加字段</a><font style="color:red;">【注：1. 一批次在原有字段数量基础上最多增加20个；2. en_colum与ch_colum如果都未填写，特性和描述填写了也无效；3. 若要删除一条记录，则清空该行的en_colum与ch_colum即可；4. 外联表字段的修改必须先删除后添加】</font>
			<div class="divider"></div>
<script type="text/javascript">
var l_counter = $('.columArea').find('tr').length;
var click_counter = l_counter;

var columAreaInit = function (){
	for(var a=0; a<20; a++){
		var addRow = '<tr style="display:none;">';
		addRow += '<td>'+(l_counter+a+1)+'</td>';
		addRow += '<td><input type="text" name="en_colum[]" /><input type="hidden" name="old_en_colum[]" /></td>';
		addRow += '<td><input type="text" name="ch_colum[]" /><input type="hidden" name="old_ch_colum[]" /></td>';
		addRow += '<td><input type="text" name="charact[]" style="width:330px;" /><input type="hidden" name="old_charact[]" /></td>';
		addRow += '<td><input type="text" name="colum_des[]" style="width:340px;" /><input type="hidden" name="old_colum_des[]" /></td>';
		addRow += '</tr>';
		$('.columArea').append(addRow);
	}
}

var btnAddColumClick = function (){
	var jqObj_tr = $('.columArea').find('tr');
	$(jqObj_tr[click_counter]).show();
	if ( click_counter<l_counter+20 )	click_counter++;
}

columAreaInit();
$('.btnAddColum').bind('click', btnAddColumClick);
</script>
			<!-- <dl>
				<dt>重要信息：</dt>
				<dd>
					<textarea name="infos" cols="100" rows="7">{$thisRow[form_infos]}</textarea>
					<span class="info"></span>
				</dd>
			</dl> -->

			<dl>
				<dt>建表语句：</dt>
				<dd>
					<textarea name="sqls" cols="100" rows="12">{$thisRow[sqls]}</textarea>
					<input type="hidden" name="old_sqls" value="{$thisRow['sqls']}" />
					<span class="info"></span>
				</dd>
			</dl>

			<dl>
				<dt>表特性描述：</dt>
				<dd>
					<textarea name="des" cols="100" rows="6">{$thisRow[des]}</textarea>
					<input type="hidden" name="old_des" value="{$thisRow['des']}" />
					<span class="info"></span>
				</dd>
			</dl>
                
			<div class="divider"></div>
			<p>自定义扩展请参照：dwz.validate.method.js</p>
			<p>错误提示信息国际化请参照：dwz.regional.zh.js</p>
		</div>
		<div class="formBar">
			<ul>
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit">提交</button></div></div></li>
				<li><div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div></li>
			</ul>
		</div>
	</form>
	
</div>


<script type="text/javascript">
function customvalidXxx(element){
	if ($(element).val() == "xxx") return false;
	return true;
}
</script>
        