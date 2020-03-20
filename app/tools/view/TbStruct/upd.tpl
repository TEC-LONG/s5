<div class="pageContent tools_tbrecord_upd">
	<form method="post" action="{$url.updh}?id={$row.id}" class="pageForm required-validate" onsubmit="return validateCallback(this, navTabAjaxDone);">
        <div class="pageFormContent" layoutH="56">
            <p class="nowrap">
				<label>所属库名称：</label>
				{T_createSelectHtml($belong_db, 'belong_db', 2, $row['belong_db'])}
			</p>
			<p class="nowrap">
				<label>表基础结构：</label>
				<textarea name="ori_struct" class="required" cols="150" rows="8">{$row.ori_struct}</textarea>
			</p>
			<p class="nowrap">
				<label>特殊字段：</label>
				<textarea name="special_field" cols="150" rows="10">{$row.special_field}</textarea>
			</p>
			<p class="nowrap">
				<label>特别说明：</label>
				<textarea name="comm" rows="4" cols="150">{$row.comm}</textarea>
			</p>
			<p class="nowrap">
				<label>建表语句：</label>
				<textarea name="create_sql" cols="150" rows="20">{$row.create_sql}</textarea>
			</p>
		</div>
		<div class="formBar">
			<ul>
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit">保存</button></div></div></li>
				<li>
					<div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div>
				</li>
			</ul>
		</div>
	</form>
</div>
