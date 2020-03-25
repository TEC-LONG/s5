
{literal}
<style>
label {padding-right: 35px;}
</style>
{/literal}
<div class="pageContent" layoutH="42">
{foreach $menu as $v1}
	<h1>{$v1.lv1.display_name}</h2>
	<div class="divider"></div>
	{foreach $v1.lv2 as $v2}
	<div class="panel collapse" minH="100" defH="{if isset($v2.son)}{count($v2.son)*66}{/if}">
		<h1>{$v2.menu.display_name}</h1>
		{if isset($v2.son)}
		<div>
			{foreach $v2.son as $v3}
			<h2>{$v3.display_name}</h2>
			<div class="divider"></div>
			{if isset($v3.son)}
				{foreach $v3.son as $v4}
			<label><input type="checkbox" name="c1" value="1" />{$v4.display_name}</label>
				{/foreach}
			{/if}
			<br/><br/><br/>
			{/foreach}
		</div>
		{/if}
	</div>
	{/foreach}
{/foreach}
</div>