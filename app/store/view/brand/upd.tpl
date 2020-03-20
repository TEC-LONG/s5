<div class="pageContent">
	<form method="post" action="{$url.updh.url}?id={$row.id}" class="pageForm required-validate" onsubmit="return validateCallback(this, navTabAjaxDone);">
        <div class="pageFormContent" layoutH="56">
            <p>
				<label>品牌名称：</label>
				<input name="name" type="text" class="required" value="{$row.name}" />
			</p>
			<div class="divider"></div>
			<p class="nowrap">
				<label>logo图：</label>
				<div class="upload-wrap">
					<input type="file" name="logo_img" accept="image/*" class="valid" style="left: 0px;">
					<div class="thumbnail">
						<img src="aa.png" style="max-width: 80px; max-height: 80px">
						<a class="del-icon"></a>
					</div>
				</div>
			</p>
			<div class="divider"></div>
			<p class="nowrap">
				<label>品牌简介：</label>
				<textarea class="editor" name="descr" rows="20" cols="160"
				upLinkUrl="upload.php" upImgUrl="upload.php"
				upFlashUrl="upload.php" upMediaUrl="upload.php">
				</textarea>
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