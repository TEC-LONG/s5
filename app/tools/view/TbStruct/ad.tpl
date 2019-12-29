<h2 class="contentTitle">表单验证</h2>

<div class="pageContent">
	
	<form enctype="multipart/form-data" method="post" action="{$url.adh}" class="pageForm required-validate"  onsubmit="return validateCallback(this, navTabAjaxDone);">
		<div class="pageFormContent nowrap" layoutH="97"  style="align:center;">
		
            <dl>
				<dt>所属库名称：</dt>
				<dd>
					{T_createSelectHtml($belong_db, 'belong_db', 2)}
				</dd>
			</dl>

            <dl>
				<dt style="color:red;">表结构：</dt>
				<dd><textarea name="ori_struct" class="required" cols="150" rows="7"></textarea></dd>
			</dl>
                
            <dl>
				<dt>建表语句：</dt>
				<dd><textarea name="create_sql" cols="150" rows="12"></textarea></dd>
			</dl>

            {* <dl>
				<dt>特殊字段值对信息：</dt>
				<dd><textarea name="special_fields" cols="150" rows="7"></textarea></dd>
			</dl> *}

			<dl>
				<dt>备注信息：</dt>
				<dd><textarea name="comm" cols="150" rows="7"></textarea></dd>
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
