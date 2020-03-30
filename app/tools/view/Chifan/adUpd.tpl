<div class="pageContent">
	<form method="post" action="{$url.adh}" class="pageForm required-validate" onsubmit="return validateCallback(this, navTabAjaxDone);">
		<div class="pageFormContent" layoutH="57">
			<dl class="nowrap">
				<dt>适用时段：</dt>
				<dd>
					{foreach $types as $key=>$val}
					<input type="checkbox" name="types[]" value="{$key}" />{$val}&nbsp;&nbsp;&nbsp;&nbsp;
					{/foreach}
				</dd>
			</dl>
			<dl class="nowrap">
				<dt>主类型：</dt>
				<dd>
					{foreach $main_type as $key=>$val}
					<input type="checkbox" name="main_type[]" value="{$key}" />{$val}&nbsp;&nbsp;&nbsp;&nbsp;
					{/foreach}
				</dd>
			</dl>
			<dl class="nowrap">
				<dt>副类型：</dt>
				<dd>
					{foreach $second_type as $key=>$val}
					<input type="checkbox" name="second_type[]" value="{$key}" />{$val}&nbsp;&nbsp;&nbsp;&nbsp;
					{/foreach}
				</dd>
			</dl>
			<dl class="nowrap">
				<dt>菜品：</dt>
				<dd><input name="cai" type="text" size="30" class="required" /></dd>
			</dl>
			<dl class="nowrap">
				<dt>描述：</dt>
				<dd>
					<textarea class="editor" cols="135" rows="21" name="descr" id="chifan_descr"></textarea>
				</dd>
			</dl>
<script>
var imgUrl = "{$url.editorImgUp.url}";
{literal}
$('#chifan_descr').xheditor({
	upImgUrl:imgUrl,
	upImgExt:"jpg,jpeg,gif,png",
	tools:'Cut,Copy,Paste,Pastetext,|,Blocktag,Fontface,FontSize,Bold,Italic,Underline,Strikethrough,FontColor,BackColor,SelectAll,Removeformat,|,Align,List,Outdent,Indent,|,Link,Unlink,Anchor,Img,Hr,Emot,Table,|,Source,Preview,Fullscreen,About',
	onUpload:function(re){
	// console.log(re);
}});
{/literal}
</script>
			<dl class="nowrap">
				<dt>口味：</dt>
				<dd>
					<input type="text" name="taste" size="50" value="" />&nbsp;&nbsp;&nbsp;&nbsp;
				</dd>
			</dl>
			<dl class="nowrap">
				<dt>口感：</dt>
				<dd>
					<input type="text" name="mouthfeel" size="50" value="" />&nbsp;&nbsp;&nbsp;&nbsp;
				</dd>
			</dl>
			<dl class="nowrap">
				<dt>功效：</dt>
				<dd>
					<input type="text" name="effects" size="50" value="" />&nbsp;&nbsp;&nbsp;&nbsp;
				</dd>
			</dl>
			<dl class="nowrap">
				<dt>功效描述：</dt>
				<dd>
					<textarea class="editor" cols="135" rows="12" name="effects_comm" id="chifan_effects_comm"></textarea>
				</dd>
			</dl>
<script>
{literal}
$('#chifan_effects_comm').xheditor({
	upImgUrl:imgUrl,
	upImgExt:"jpg,jpeg,gif,png",
	tools:'Cut,Copy,Paste,Pastetext,|,Blocktag,Fontface,FontSize,Bold,Italic,Underline,Strikethrough,FontColor,BackColor,SelectAll,Removeformat,|,Align,List,Outdent,Indent,|,Link,Unlink,Anchor,Img,Hr,Emot,Table,|,Source,Preview,Fullscreen,About',
	onUpload:function(re){
	// console.log(re);
}});
{/literal}
</script>
			<dl class="nowrap">
				<dt>副作用：</dt>
				<input type="text" name="byeffect" size="60" value="" />&nbsp;&nbsp;&nbsp;&nbsp;
			</dl>
			<dl class="nowrap">
				<dt>&nbsp;</dt>
				<dd>
					<div class="buttonActive"><div class="buttonContent"><button type="submit">立即添加</button></div></div>
				</dd>
			</dl>
		</div>
	</form>
</div>
