<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
{include file="Index/head.tpl"}

<body>
	<div id="layout">
		<div id="header">
			<div class="headerNav">
				<a class="logo" href="http://j-ui.com">标志</a>
				<ul class="nav">
					<!-- <li id="switchEnvBox"><a href="javascript:">（<span>北京</span>）切换城市</a>
						<ul>
							<li><a href="sidebar_1.html">北京</a></li>
							<li><a href="sidebar_2.html">上海</a></li>
						</ul>
					</li> -->
					<!-- <li><a href="donation.html" target="dialog" height="400" title="捐赠 & DWZ学习视频">捐赠</a></li>
					<li><a href="changepwd.html" target="dialog" rel="changepwd" width="600">设置</a></li>
					<li><a href="http://www.cnblogs.com/dwzjs" target="_blank">博客</a></li>
					<li><a href="http://weibo.com/dwzui" target="_blank">微博</a></li> -->
					<li><a href="{L(C('web.blog.index'))}" target="_blank">博客首页</a></li>
					<li><a href="{$url.login_out.url}">退出</a></li>
				</ul>
				<ul class="themeList" id="themeList">
					<li style="color:blanchedalmond;">欢迎你，{$manager.nickname}！</li>
				</ul>
			</div>

			<!-- navMenu -->

		</div>

		<!-- leftside -->
		<div id="leftside">
			<div id="sidebar_s">
				<div class="collapse">
					<div class="toggleCollapse"><div></div></div>
				</div>
			</div>
			<div id="sidebar">
				<div class="toggleCollapse"><h2>主菜单</h2><div>收缩</div></div>
				<div class="accordion" fillSpace="sidebar">
				{foreach $menu1 as $k1=>$v1}
				{if in_array($v1.id, $mp_ids)}
					<div class="accordionHeader">
						<h2><span>Folder</span>{$v1.display_name}</h2>
					</div>
					<div class="accordionContent">
						<ul class="tree">
							{foreach $menu2 as $k2=>$v2}
							{if in_array($v2.id, $mp_ids)}
							{if $v1.id==$v2.parent_id}
							<li><a>{$v2.display_name}</a>
								<ul>
								{foreach $menu3 as $k3=>$v3}
								{if in_array($v3.id, $mp_ids)}
								{if $v2.id==$v3.parent_id}
									<li><a href="{if $v3.level3_type==1}{$v3.level3_href}{else}{L($v3.route)}{/if}" target="navtab" rel="{$v3['navtab']}">{$v3.display_name}</a></li>
								{/if}
								{/if}
								{/foreach}
								</ul>
							</li>
							{/if}
							{/if}
							{/foreach}
						</ul>
					</div>
				{/if}
				{/foreach}
				</div>
			</div>
		</div>

		<div id="container">
			<div id="navTab" class="tabsPage">
				<div class="tabsPageHeader">
					<div class="tabsPageHeaderContent"><!-- 显示左右控制时添加 class="tabsPageHeaderMargin" -->
						<ul class="navTab-tab">
							<li tabid="main" class="main"><a href="javascript:;"><span><span class="home_icon">我的主页</span></span></a></li>
						</ul>
					</div>
					<div class="tabsLeft">left</div><!-- 禁用只需要添加一个样式 class="tabsLeft tabsLeftDisabled" -->
					<div class="tabsRight">right</div><!-- 禁用只需要添加一个样式 class="tabsRight tabsRightDisabled" -->
					<div class="tabsMore">more</div>
				</div>
				<ul class="tabsMoreList">
					<li><a href="javascript:;">我的主页</a></li>
				</ul>
				{include file="Index/main.tpl"}
			</div>
		</div>

	</div>

	<div id="footer">Copyright &copy; 2020 <a href="{L(C('web.blog.index'))}" target="dialog">Tec-Long</a> 京ICP备15053290号-2</div>

</body>
</html>