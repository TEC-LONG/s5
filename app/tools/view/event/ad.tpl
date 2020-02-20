<div class="pageContent">
	<form method="post" action="{$url.adh.url}" class="pageForm required-validate" onsubmit="return validateCallback(this, navTabAjaxDone);">
        <div class="pageFormContent" layoutH="56">
            <p>
				<label>事件标题：</label>
				<input name="title" type="text" class="required" />
			</p>
			<div class="divider"></div>
			<p>
				<label>事件开始事件：</label>
				<input name="begin_time" class="date readonly" readonly="readonly" type="text" value="">
			</p>
			<p>
				<label>事件结束事件：</label>
				<input name="end_time" class="date readonly" readonly="readonly" type="text" value="">
			</p>
			<p>
				<label>备注说明：</label>
				<textarea name="descr" rows="14" cols="118"></textarea>
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