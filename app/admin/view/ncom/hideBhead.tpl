<div class="collapse" id="navbarToggleExternalContent">
	<nav class="nav">
	{foreach from=$tpl key='tpl_key' item='tpl_val'}
		<a class="nav-link active" href="#" stag="{$tpl_key}_{$tpl_val.gvar}" sson='{if isset($tpl_val["son"])}{json_encode($tpl_val["son"])}{/if}'>{$tpl_val.name}</a>
	{/foreach}
		<!-- <a class="nav-link" href="#" stag="user">用户管理系统</a> -->
	</nav>
</div>