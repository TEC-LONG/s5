<div class="pageContent">
	<form method="post" action="{$url.adh}" class="pageForm required-validate" onsubmit="return validateCallback(this, navTabAjaxDone);">
		<div class="pageFormContent" layoutH="57">
			<dl class="nowrap">
				<dt>所属类型：</dt>
				<dd>
					<select name="type" class="required combox">
						{foreach $type as $type_key=>$type_val}
						<option value="{$type_key}">{$type_val}</option>
						{/foreach}
					</select>
				</dd>
			</dl>
			<dl class="nowrap">
				<dt>食物性质：</dt>
				<dd>
					<select name="food_type" class="required combox">
						{foreach $food_type as $food_type_key=>$food_type_val}
						<option value="{$food_type_key}">{$food_type_val}</option>
						{/foreach}
					</select>
				</dd>
			</dl>
			<dl class="nowrap">
				<dt>菜品：</dt>
				<dd><input name="cai" type="text" size="30" /></dd>
			</dl>
			<dl class="nowrap">
				<dt>描述：</dt>
				<dd><textarea cols="135" rows="7" name="descr"></textarea></dd>
			</dl>
			<dl class="nowrap">
				<dt>&nbsp;</dt>
				<dd>
					<div class="buttonActive"><div class="buttonContent"><button type="submit">立即添加</button></div></div>
				</dd>
			</dl>
		</div>
	</form>
<script type="text/javascript">
$('#is_multipart').change(function(){
	
	if ( $(this).val()==1 ){

		$('#key_multi_comment').show();
	}else{
	
		$('#key_multi_comment').hide();
	}
});
</script>
</div>
