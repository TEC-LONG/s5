<div class="pageContent">
	<form method="post" action="{$url.adh.url}" class="pageForm required-validate" onsubmit="return validateCallback(this, navTabAjaxDone);">
        <div class="pageFormContent" layoutH="56">
            <p>
				<label>日程标题：</label>
				<input name="title" type="text" class="required" />
			</p>
			<p>
				<label>类型：</label>
				<select class="combox" name="type">
					{foreach $type as $k=>$v}
					<option value="{$k}">{$v}</option>
					{/foreach}
				</select>
			</p>
			<p>
				<label>性质：</label>
				<select class="combox" name="character">
					{foreach $character as $k=>$v}
					<option value="{$k}">{$v}</option>
					{/foreach}
				</select>
			</p>
			<div class="divider"></div>
			<p>
				<label>预期周期开始时间：</label>
				<input name="b_time" class="date readonly" readonly="readonly" type="text" value="">
			</p>
			<p>
				<label>预期周期结束时间：</label>
				<input name="e_time" class="date readonly" readonly="readonly" type="text" value="">
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