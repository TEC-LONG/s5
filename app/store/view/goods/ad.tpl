<div class="pageContent">
	<form method="post" action="{$url.adh.url}" class="pageForm required-validate" onsubmit="return validateCallback(this, navTabAjaxDone);">
        <div class="pageFormContent" layoutH="56">
            <p>
				<label>商品名称：</label>
				<input name="acc" type="text" class="required" />
			</p>
			<p>
				<label>标准价格：</label>
				<input name="pwd" type="text" class="required alphanumeric" minlength="6" maxlength="20" />
			</p>
			<p>
				<label>商品总数量：</label>
				<input name="pwd" type="text" class="required alphanumeric" minlength="6" maxlength="20" />
			</p>
			<p>
				<label>报警数量：</label>
				<input name="pwd" type="text" class="required alphanumeric" minlength="6" maxlength="20" />
			</p>
			<div class="divider"></div>
			<p>
				<label>所属分类：</label>
				<input name="nickname" type="text" class="required" />
			</p>
			<p>
				<label>所属品牌：</label>
				<input name="cell" type="text" class="phone" />
			</p>
			<p>
				<label>所属供应商：</label>
				<input name="email" type="text" class="email" />
			</p>
			<p>
				<label>排序：</label>
				<input name="email" type="text" class="email" />
			</p>
			<div class="divider"></div>
			<p class="nowrap">
				<label>所属类型：</label>
				<div class="upload-wrap">
					<input type="file" name="img" accept="image/*" class="valid" style="left: 0px;">
				</div>
			</p>
			<div class="divider"></div>
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