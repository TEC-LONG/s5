<div class="pageContent">
	<form method="post" action="{$url.adh}" class="pageForm required-validate" onsubmit="return validateCallback(this, navTabAjaxDone);">
		<div class="pageFormContent" layoutH="57">
			<dl class="nowrap">
				<dt>快捷键：</dt>
				<dd>
					<select name="first_key" class="required combox">
						<option value="0">leader</option>
						<option value="1">Ctrl</option>
						<option value="2">Shift</option>
						<option value="3">Alt</option>
						<option value="4">Ctrl-Shift</option>
						<option value="5">Ctrl-Alt</option>
						<option value="6">Shift-Alt</option>
					</select>
					<input name="second_key" type="text" size="30" />
				</dd>
			<dl class="nowrap">
				<dt>快捷键说明：</dt>
				<dd><textarea cols="135" rows="3" name="key_comment" class="required"></textarea></dd>
			</dl>
			<dl class="nowrap">
				<dt>是否为多环境快捷键：</dt>
				<dd>
					<select name="is_multipart" class="required combox" id="is_multipart">
						<option value="0">否</option>
						<option value="1">是</option>
					</select>
				</dd>
			</dl>
			<dl class="nowrap"  id="key_multi_comment" style="display:none">
				<dt>多环境快捷键说明：</dt>
				<dd>
					<textarea cols="135" rows="3" name="key_multi_comment"></textarea>
				</dd>
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
