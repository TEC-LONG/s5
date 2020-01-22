
<div class="pageContent">
	<form method="post" action="{$url.adh}" class="pageForm required-validate" onsubmit="return validateCallback(this, navTabAjaxDone);">
        <div class="pageFormContent" layoutH="56">
            
<p>
    <label>栏目名称：</label>
    <input name="name" type="text" />
</p>
                        
<p>
    <label>父级id：</label>
    {T_createSelectHtml($parent_id, "parent_id", 2)}
</p>

<div class="divider"></div>
                        
<p>
    <label>平台：</label>
    <input name="plat" type="text" />
</p>
                        
<p>
    <label>模块：</label>
    <input name="module" type="text" />
</p>
                        
<p>
    <label>动作：</label>
    <input name="act" type="text" />
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
        