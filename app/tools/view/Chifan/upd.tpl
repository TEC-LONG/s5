<div class="pageContent">
	<form method="post" action="{$url.updh}&id={$row.id}" class="pageForm required-validate" onsubmit="return validateCallback(this, navTabAjaxDone);">
		<div class="pageFormContent" layoutH="57">
			<dl class="nowrap">
				<dt>适用场景：</dt>
				<dd>
					{foreach $types as $key=>$val}
					<input type="checkbox" name="types[]" value="{$key}" {if in_array($key, $row['types'])}checked{/if} />{$val}&nbsp;&nbsp;&nbsp;&nbsp;
					{/foreach}
				</dd>
			</dl>
			<dl class="nowrap">
				<dt>食物类型：</dt>
				<dd>
					{foreach $food_types as $key=>$val}
					<input type="checkbox" name="food_types[]" value="{$key}" {if in_array($key, $row['food_types'])}checked{/if} />{$val}&nbsp;&nbsp;&nbsp;&nbsp;
					{/foreach}
				</dd>
			</dl>
			<dl class="nowrap">
				<dt>菜品：</dt>
				<dd><input name="cai" type="text" size="30" value="{$row['cai']}" /></dd>
			</dl>
			<dl class="nowrap">
				<dt>描述：</dt>
				<dd><textarea cols="135" rows="12" name="descr">{$row['descr']}</textarea></dd>
			</dl>
			<dl class="nowrap">
				<dt>口味：</dt>
				<dd>
					{foreach $taste as $key=>$val}
					<input type="checkbox" name="taste[]" value="{$key}" {if in_array($key, $row['taste'])}checked{/if} />{$val}&nbsp;&nbsp;&nbsp;&nbsp;
					{/foreach}
				</dd>
			</dl>
			<dl class="nowrap">
				<dt>口感：</dt>
				<dd>
					{foreach $mouthfeel as $key=>$val}
					<input type="checkbox" name="mouthfeel[]" value="{$key}" {if in_array($key, $row['mouthfeel'])}checked{/if} />{$val}&nbsp;&nbsp;&nbsp;&nbsp;
					{/foreach}
				</dd>
			</dl>
			<dl class="nowrap">
				<dt>功效：</dt>
				<dd>
					{foreach $effects as $key=>$val}
					<input type="checkbox" name="effects[]" value="{$key}" {if in_array($key, $row['effects'])}checked{/if} />{$val}&nbsp;&nbsp;&nbsp;&nbsp;
					{/foreach}
				</dd>
			</dl>
			<dl class="nowrap">
				<dt>功效描述：</dt>
				<dd><textarea cols="135" rows="7" name="effects_comm">{$row['effects_comm']}</textarea></dd>
			</dl>
			<dl class="nowrap">
				<dt>副作用：</dt>
				<dd><textarea cols="135" rows="7" name="byeffect">{$row['byeffect']}</textarea></dd>
			</dl>
			<dl class="nowrap">
				<dt>&nbsp;</dt>
				<dd>
					<div class="buttonActive"><div class="buttonContent"><button type="submit">立即修改</button></div></div>
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
