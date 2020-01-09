<h2 class="contentTitle">表单验证</h2>

<div class="pageContent">
	
	<form enctype="multipart/form-data" method="post" action="{$url.updh}&id={$row.id}" class="pageForm required-validate" onsubmit="return validateCallback(this, navTabAjaxDone)">

		<div class="pageFormContent nowrap" layoutH="97"  style="align:center;">
		
        
			<dl>
				<dt>所属库名称：</dt>
				<dd>
					{T_createSelectHtml($belong_db, 'belong_db', 2, $row['belong_db'])}
					<input type="hidden" name="old_belong_db" value="{$row['belong_db']}" />
					<span class="info"></span>
				</dd>
			</dl>

			<dl>
				<dt style="color:red;">中文表名：</dt>
				<dd>
					<input type="text" maxlength="20" name="ch_name" value="{$row['ch_name']}" class="required" />
					<input type="hidden" name="old_ch_name" value="{$row['ch_name']}" />
					<span class="info"></span>
				</dd>
			</dl>

			<dl>
				<dt style="color:red;">英文表名：</dt>
				<dd>
					<input type="text" maxlength="30" name="en_name" value="{$row['en_name']}" class="required" />
					<input type="hidden" name="old_en_name" value="{$row['en_name']}" />
					<span class="info"></span>
				</dd>
			</dl>

			{* <dl>
				<dt>表结构：</dt>
				<dd>
					<textarea name="structure" class="required" cols="100" rows="9">{$thisRow[form_structure]}</textarea>
					<span class="info"></span>
				</dd>
			</dl> *}

		<div class="divider"></div>

		<a title="添加字段" class="btnAdd btnAddColum" href="#">添加字段</a><font style="color:green;">【注：1. 一批次在原有字段数量基础上最多增加20个；2. field_ch_name与field_en_name如果都未填写，特性和描述填写了也无效；3. 若要删除一条记录，则清空该行的field_ch_name与field_en_name即可；4. 外联表字段的修改必须先删除后添加】</font>
		<div class="divider"></div>

	<table class="table" width="100%">
		<thead>
			<tr>
				<th width="30">序号</th>
				<th width="90">字段中文名</th>
				<th width="50">字段英文名</th>
				<th width="90">字段类型</th>
				<th width="360">字段原始值对信息</th>
				<th width="200">字段备注信息</th>
			</tr>
		</thead>
		<tbody  class="TBStruct_columArea">
		{foreach $tb_special_field_rows as $k=>$t_s_f_row}
			<tr>
				<td>{$k+1}<input type="hidden" name="ids[]" value="{$t_s_f_row['id']}" /></td>
				<td><input type="text" name="field_ch_name[]" value="{$t_s_f_row['field_ch_name']}" /><input type="hidden" name="old_field_ch_name[]" value="{$t_s_f_row['field_ch_name']}" /></td>
				<td><input type="text" name="field_en_name[]" value="{$t_s_f_row['field_en_name']}" /><input type="hidden" name="old_field_en_name[]" value="{$t_s_f_row['field_en_name']}" /></td>
				<td>{T_createSelectHtml($field_type, 'field_type[]', 2, $t_s_f_row['field_type'])}<input type="hidden" name="old_field_type[]" value="{$t_s_f_row['field_type']}" /></td>
				<td><input type="text" name="ori_key_val[]" value="{$t_s_f_row['ori_key_val']}" style="width:90%" /><input type="hidden" name="old_ori_key_val[]" value="{$t_s_f_row['ori_key_val']}" /></td>
				<td><input type="text" name="specification[]" value="{$t_s_f_row['specification']}"  style="width:90%" /><input type="hidden" name="old_specification[]" value="{$t_s_f_row['specification']}" /></td>
			</tr>
		{/foreach}
		</tbody>
	</table>

		<div class="divider"></div>
		
<script type="text/javascript">
var l_counter = $('.TBStruct_columArea').find('tr').length;
var click_counter = l_counter;

var columAreaInit = function (){
	for(var a=0; a<20; a++){
		var addRow = '<tr style="display:none;">';
		addRow += '<td>'+(l_counter+a+1)+'<input type="hidden" name="ids[]" value="0" /></td>';
		addRow += '<td><input type="text" name="field_ch_name[]" /><input type="hidden" name="old_field_ch_name[]" /></td>';
		addRow += '<td><input type="text" name="field_en_name[]" /><input type="hidden" name="old_field_en_name[]" /></td>';
		addRow += '<td>{T_createSelectHtml($field_type, "field_type[]", 2)}<input type="hidden" name="old_field_type[]" value="" /></td>';
		addRow += '<td><input type="text" name="ori_key_val[]" value=""  style="width:90%" /><input type="hidden" name="old_ori_key_val[]" value="" /></td>';
		addRow += '<td><input type="text" name="specification[]"  style="width:90%" /><input type="hidden" name="old_specification[]" /></td>';
		addRow += '</tr>';
		$('.TBStruct_columArea').append(addRow);
	}
}

var btnAddColumClick = function (){
	var jqObj_tr = $('.TBStruct_columArea').find('tr');
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
				<dt>建表草稿：</dt>
				<dd>
					<textarea cols="160" rows="5" name="ori_struct">{$row['ori_struct']}</textarea>
					<input type="hidden" name="old_ori_struct" value="{$row['ori_struct']}" />
					<span class="info"></span>
				</dd>
			</dl>

			<dl>
				<dt>建表语句：</dt>
				<dd>
					<textarea cols="160" rows="16" name="create_sql">{$row['create_sql']}</textarea>
					<input type="hidden" name="old_create_sql" value="{$row['create_sql']}" />
					<span class="info"></span>
				</dd>
			</dl>

			<dl>
				<dt>表特性描述：</dt>
				<dd>
					<textarea name="comm" cols="100" rows="6">{$row['comm']}</textarea>
					<input type="hidden" name="old_comm" value="{$row['comm']}" />
					<span class="info"></span>
				</dd>
			</dl>
                
			<div class="divider"></div>
			<p>自定义扩展请参照：dwz.validate.method.js</p>
			<p>错误提示信息国际化请参照：dwz.regional.zh.js</p>
		</div>
		<div class="formBar">
			<ul>
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit">保存</button></div></div></li>
				<li><div class="button"><div class="buttonContent"><button type="button" class="close">关闭</button></div></div></li>
			</ul>
		</div>
	</form>
	
</div>

        