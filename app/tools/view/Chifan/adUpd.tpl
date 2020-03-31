<div class="pageContent">
	<form method="post" action="{$url.post.url}" class="pageForm required-validate" onsubmit="return validateCallback(this, navTabAjaxDone);">
		{if isset($row.id)}
		<input type="hidden" name="id" value="{$row.id}">
		{/if}
		<div class="pageFormContent" layoutH="57">
			<dl class="nowrap">
				<dt>适用时段：</dt>
				<dd>
					{foreach $types as $key=>$val}
					<input type="checkbox" name="types[]" value="{$key}" {if isset($row)&&in_array($key, $row.types)}checked{/if} />{$val}&nbsp;&nbsp;&nbsp;&nbsp;
					{/foreach}
				</dd>
			</dl>
			<dl class="nowrap">
				<dt>主类型：</dt>
				<dd>
					{foreach $main_type as $key=>$val}
					<input type="checkbox" name="main_type[]" value="{$key}" {if isset($row)&&in_array($key, $row.main_type)}checked{/if}/>{$val}&nbsp;&nbsp;&nbsp;&nbsp;
					{/foreach}
				</dd>
			</dl>
			<dl class="nowrap">
				<dt>副类型：</dt>
				<dd>
					{foreach $second_type as $key=>$val}
					<input type="checkbox" name="second_type[]" value="{$key}" {if isset($row)&&in_array($key, $row.second_type)}checked{/if}/>{$val}&nbsp;&nbsp;&nbsp;&nbsp;
					{/foreach}
				</dd>
			</dl>
			<dl class="nowrap">
				<dt>菜品：</dt>
				<dd><input name="cai" type="text" size="30" class="required" value="{if isset($row)}{$row.cai}{/if}"/></dd>
			</dl>
			<dl class="nowrap">
				<dt>描述：</dt>
				<dd>
					<textarea class="editor" cols="135" rows="21" name="descr" id="chifan_descr">{if isset($row)}{$row.descr}{/if}</textarea>
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
					<input type="text" name="taste" size="50" value="{if isset($row)}{$row.taste}{/if}" />&nbsp;&nbsp;&nbsp;&nbsp;
				</dd>
			</dl>
			<dl class="nowrap">
				<dt>口感：</dt>
				<dd>
					<input type="text" name="mouthfeel" size="50" value="{if isset($row)}{$row.mouthfeel}{/if}" />&nbsp;&nbsp;&nbsp;&nbsp;
				</dd>
			</dl>
			<dl class="nowrap">
				<dt>功效：</dt>
				<dd>
					<input type="text" name="effects" size="50" value="{if isset($row)}{$row.effects}{/if}" />&nbsp;&nbsp;&nbsp;&nbsp;
				</dd>
			</dl>
			<dl class="nowrap">
				<dt>功效描述：</dt>
				<dd>
					<textarea class="editor" cols="135" rows="12" name="effects_comm" id="chifan_effects_comm">{if isset($row)}{$row.effects_comm}{/if}</textarea>
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
				<input type="text" name="byeffect" size="60" value="{if isset($row)}{$row.byeffect}{/if}" />&nbsp;&nbsp;&nbsp;&nbsp;
			</dl>
			<dl class="nowrap">
				<dt>&nbsp;</dt>
				<dd>
					<div class="buttonActive"><div class="buttonContent"><button type="submit">立即提交</button></div></div>
				</dd>
			</dl>
		</div>
	</form>
</div>
