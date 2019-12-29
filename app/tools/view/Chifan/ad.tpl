<div class="pageContent">
	<form method="post" action="{$url.adh}" class="pageForm required-validate" onsubmit="return validateCallback(this, navTabAjaxDone);">
		<div class="pageFormContent" layoutH="57">
			<dl class="nowrap">
				<dt>适用场景：</dt>
				<dd>
					{foreach $types as $key=>$val}
					<input type="checkbox" name="types[]" value="{$key}" />{$val}&nbsp;&nbsp;&nbsp;&nbsp;
					{/foreach}
				</dd>
			</dl>
			<dl class="nowrap">
				<dt>食物类型：</dt>
				<dd>
					{foreach $food_types as $key=>$val}
					<input type="checkbox" name="food_types[]" value="{$key}" />{$val}&nbsp;&nbsp;&nbsp;&nbsp;
					{/foreach}
				</dd>
			</dl>
			<dl class="nowrap">
				<dt>菜品：</dt>
				<dd><input name="cai" type="text" size="30" class="required" /></dd>
			</dl>
			<dl class="nowrap">
				<dt>描述：</dt>
				<dd><textarea cols="135" rows="12" name="descr"></textarea></dd>
			</dl>
			<dl class="nowrap">
				<dt>口味：</dt>
				<dd>
					{foreach $taste as $key=>$val}
					<input type="checkbox" name="taste[]" value="{$key}" />{$val}&nbsp;&nbsp;&nbsp;&nbsp;
					{/foreach}
				</dd>
			</dl>
			<dl class="nowrap">
				<dt>口感：</dt>
				<dd>
					{foreach $mouthfeel as $key=>$val}
					<input type="checkbox" name="mouthfeel[]" value="{$key}" />{$val}&nbsp;&nbsp;&nbsp;&nbsp;
					{/foreach}
				</dd>
			</dl>
			<dl class="nowrap">
				<dt>功效：</dt>
				<dd>
					{foreach $effects as $key=>$val}
					<input type="checkbox" name="effects[]" value="{$key}" />{$val}&nbsp;&nbsp;&nbsp;&nbsp;
					{/foreach}
				</dd>
			</dl>
			<dl class="nowrap">
				<dt>功效描述：</dt>
				<dd><textarea cols="135" rows="7" name="effects_comm"></textarea></dd>
			</dl>
			<dl class="nowrap">
				<dt>副作用：</dt>
				<dd><textarea cols="135" rows="7" name="byeffect"></textarea></dd>
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
