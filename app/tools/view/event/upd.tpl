<div class="pageContent">
	<form method="post" action="{$url.updh.url}&id={$row.id}" class="pageForm required-validate" onsubmit="return validateCallback(this, navTabAjaxDone);">
        <div class="pageFormContent" layoutH="56">
            <p>
				<label>事件标题：</label>
				<input name="title" type="text" class="required" value="{$row.title}" size="35" />
			</p>
			<div class="divider"></div>
			<p>
				<label>事件开始事件：</label>
				<input name="begin_time" class="date readonly" readonly="readonly" type="text" value="{date('Y-m-d', $row['begin_time'])}">
			</p>
			<p>
				<label>事件结束事件：</label>
				<input name="end_time" class="date readonly" readonly="readonly" type="text" value="{date('Y-m-d', $row['end_time'])}">
			</p>
			<p>
				<label>备注说明：</label>
				<textarea name="descr" rows="14" cols="118">{$row.descr}</textarea>
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