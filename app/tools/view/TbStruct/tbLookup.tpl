<div class="pageContent">
	<div class="pageFormContent" layoutH="58">
		<ul class="tree expand">
			{foreach $rows as $rows_k=>$rows_v}
			<li><a href="javascript:">{$rows_k}</a>
				<ul>
					{foreach $rows_v as $row}
					<li><a href="javascript:" onclick="$.bringBack({ldelim}'en_name':'{$row.en_name}','en_name[]':'{$row.en_name}',ch_name:'{$row.ch_name}',ch_fields:'{$row.ch_fields}',en_fields:'{$row.en_fields}'{rdelim})">{$row.en_name}</a></li>
					{/foreach}
				</ul>
			</li>
			{/foreach}
		</ul>
	</div>
	
	<div class="formBar">
		<ul>
			<li><div class="button"><div class="buttonContent"><button class="close" type="button">关闭</button></div></div></li>
		</ul>
	</div>
</div>
