<div class="pageContent">
	<div class="pageFormContent" layoutH="58">
		<ul class="tree expand">
			{foreach $cats as $cat1}
			{if $cat1.level==1}
			<li><a href="javascript:">{$cat1.name}</a>
				<ul>
					{foreach $cats as $cat2}
					{if $cat2.level==2&&$cat2.pid==$cat1.id}
					<li><a href="javascript:">{$cat2.name}</a>
						<ul>
							{foreach $cats as $cat3}
							{if $cat3.level==3&&$cat3.pid==$cat2.id}
							<li><a href="javascript:" onclick="$.bringBack({ldelim}cat3id:{$cat3.id}, cat2id:{$cat2.id}, cat1id:{$cat1.id}, cat1name:'{$cat1.name}', cat2name:'{$cat2.name}', cat3name:'{$cat3.name}'{rdelim})">{$cat3.name}</a></li>
							{/if}
							{/foreach}
						</ul>
					</li>
					{/if}
					{/foreach}
				</ul>
			</li>
			{/if}
			{/foreach}
		</ul>
	</div>
	
	<div class="formBar">
		<ul>
			<li><div class="button"><div class="buttonContent"><button class="close" type="button">关闭</button></div></div></li>
		</ul>
	</div>
</div>
