<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
{include file="Index/head.tpl" }

<body scroll="no">
	<div id="layout">
		<div id="header">
			<!-- <div id="navMenu"> -->
				<!-- <ul> -->
					<!-- <li class="selected"><a href="sidebar_1.html"><span>商城系统</span></a></li> -->
					<!-- <!-- <li><a href="sidebar_2.html"><span>订单管理</span></a></li> --> -->
					<!-- <!-- <li><a href="sidebar_1.html"><span>产品管理</span></a></li> --> -->
				<!-- </ul> -->
				<!-- <ul style="float:right;"> -->
					<!-- <li><a class="loginOut"><span>退出</span></a></li> -->
				<!-- </ul> -->
			<!-- </div> -->
			<div class="headerNav">
				<a class="logo" href="http://j-ui.com">标志</a>
				<ul class="nav">
					<li id="switchEnvBox"><a href="javascript:">（<span>北京</span>）切换城市</a>
						<ul>
							<li><a href="sidebar_1.html">北京</a></li>
							<li><a href="sidebar_2.html">上海</a></li>
							<li><a href="sidebar_2.html">南京</a></li>
							<li><a href="sidebar_2.html">深圳</a></li>
							<li><a href="sidebar_2.html">广州</a></li>
							<li><a href="sidebar_2.html">天津</a></li>
							<li><a href="sidebar_2.html">杭州</a></li>
						</ul>
					</li>
					<li><a href="donation.html" target="dialog" height="400" title="捐赠 & DWZ学习视频">捐赠</a></li>
					<li><a href="changepwd.html" target="dialog" rel="changepwd" width="600">设置</a></li>
					<li><a href="http://www.cnblogs.com/dwzjs" target="_blank">博客</a></li>
					<li><a href="http://weibo.com/dwzui" target="_blank">微博</a></li>
					<li><a href="login.html">退出</a></li>
				</ul>
				<ul class="themeList" id="themeList">
					<li theme="default"><div class="selected">蓝色</div></li>
					<li theme="green"><div>绿色</div></li>
					<!--<li theme="red"><div>红色</div></li>-->
					<li theme="purple"><div>紫色</div></li>
					<li theme="silver"><div>银色</div></li>
					<li theme="azure"><div>天蓝</div></li>
				</ul>
			</div>
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
				{foreach $menu[0] as $k=>$v}
					<div class="accordionHeader">
						<h2><span>Folder</span>{$v}</h2>
					</div>
					<div class="accordionContent">
					{foreach $menu[1][$k] as $k1=>$v1}
						<ul class="tree <php>if($k1!=0) echo 'collapse';</php>">
							<li><a>{$v1}</a>
								<ul>
								{foreach $menu[2][$k][$k1] as $k2=>$v2}
									<li><a href="{L($menu[3][$k][$k1][$k2]['plat'], $menu[3][$k][$k1][$k2]['module'], $menu[3][$k][$k1][$k2]['act'])}" target="navTab" rel="{$menu[3][$k][$k1][$k2]['rel']}">{$v2}</a></li>
								{/foreach}
								</ul>
							</li>
						</ul>
					{/foreach}
					</div>
				{/foreach}

					<!-- <div class="accordionHeader"> -->
						<!-- <h2><span>Folder</span>典型页面</h2> -->
					<!-- </div> -->
					<!-- <div class="accordionContent"> -->
						<!-- <ul class="tree treeFolder treeCheck"> -->
							<!-- <li><a href="#" target="navTab" rel="demo_page1">查询我的客户</a></li> -->
							<!-- <li><a href="#" target="navTab" rel="demo_page2">表单查询页面</a></li> -->
							<!-- <li><a href="#" target="navTab" rel="demo_page4">表单录入页面</a></li> -->
							<!-- <li><a href="#" target="navTab" rel="demo_page5">有文本输入的表单</a></li> -->
							<!-- <li><a href="javascript:;">有提示的表单输入页面</a> -->
								<!-- <ul> -->
									<!-- <li><a href="javascript:;">页面一</a></li> -->
									<!-- <li><a href="javascript:;">页面二</a></li> -->
								<!-- </ul> -->
							<!-- </li> -->
						<!-- </ul> -->
					<!-- </div> -->

				</div>
			</div>
		</div>


		<!-- container -->
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

	<div id="footer">Copyright &copy; 2016 <a href="#" target="dialog">fires.wang</a></div>
</body>
</html>