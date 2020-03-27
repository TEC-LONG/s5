
<div class="pageHeader">
	<form onsubmit="return navTabSearch(this);" action="{$url.mpindex.url}" method="get">
	<div class="searchBar">
		<table class="searchContent">
			<tr>
				<!-- <td>
					所属menu：<input type="text" name="s_menu_name" value="{$search.s_menu_name}" />
				</td> -->
				<input type="hidden" name="s_menu_name" value="" />
				<td>
					页面名称：<input type="text" name="s_display_name" value="{$search.s_display_name}" />
				</td>
				<td>
					路由：<input type="text" name="s_route" value="{$search.s_route}" />
				</td>
				<td>
					请求方式：
				</td>
				<td>
					<select class="combox" name="s_request">
						<option value="">请选择...</option>
					{foreach $request as $k=>$v}
						<option value="{$k}"{if isset($search.s_request)&&$search.s_request!==''&&$search.s_request==$k}selected{/if}>{$v}</option>
					{/foreach}
					</select>
				</td>
				<td>
					<div class="buttonActive"><div class="buttonContent"><button type="submit">检索</button></div></div>
				</td>
			</tr>
		</table>
		<div class="subBar">
			<ul>
				<li></li>
			</ul>
		</div>
	</div>
	</form>
</div>
<div class="pageContent">
	<div class="panelBar">
		<ul class="toolBar">
			<li><a class="add" href="{$url.mpAdUpd.url}" target="dialog" rel="{$url.mpAdUpd.rel}" minable="false" width="450" height="400"><span>新增权限菜单</span></a></li>
		</ul>
	</div>
	<table class="table" width="100%" layoutH="138">
		<thead>
			<tr>
				<th width="30">序号</th>
				{foreach $thead as $col}
				<th {if !empty($col.width)}width="{$col.width}"{/if}>{$col.ch}</th>
				{/foreach}
				<th width="70">操作</th>
			</tr>
		</thead>
		<tbody>
			{foreach $rows as $k=>$row}
			<tr target="sid_{$navTab}" rel="{$row.id}">
				<td>{$k+1}</td>
				<td>{$row.display_name}</td>
				<td>{$row.parent_name}</td>
				<td>{if empty($row.route)}无{else}{$row.route}{/if}</td>
				<td>{$request[$row.request]}</td>
				<td>{$row.navtab}</td>
				<td>{$row.name}</td>
				<td>{$flag[$row.flag]}</td>
				<td>{$level3_type[$row.level3_type]}</td>
				<td>{$row.level3_href}</td>
				<td>{$row.id}</td>
				<td>
					<a title="确实要删除？" target="ajaxTodo" href="{$url.del.url}?tb=mpermission&id={$row['id']}" class="btnDel">删除</a>
					<a title="编辑权限菜单" target="dialog" href="{$url.mpAdUpd.url}?id={$row['id']}" class="btnEdit" rel="{$url.mpAdUpd.rel}"  minable="false" width="450" height="400">编辑</a>
				</td>
			</tr>
			{/foreach}
		</tbody>
	</table>

	<form id="pagerForm" method="get" action="{$url.mpindex.url}">
		<input type="hidden" name="pageNum" value="1" />
		<input type="hidden" name="numPerPage" value="{$page.numPerPage}" />
		<!-- <input type="hidden" name="s_menu_name" value="{$search.s_menu_name}" /> -->
		<input type="hidden" name="s_display_name" value="{$search.s_display_name}" />
		<input type="hidden" name="s_route" value="{$search.s_route}" />
		<input type="hidden" name="s_request" value="{$search.s_request}" />
	</form>
	<div class="panelBar">
		<div class="pages">
			<span>显示</span>
			<select class="combox" name="numPerPage" {literal}onchange="navTabPageBreak({numPerPage:this.value})"{/literal}>
				<option value="{$page.numPerPage}">{$page.numPerPage}</option>
				{foreach $page.numPerPageList as $thisNumPerPage}
					{if $thisNumPerPage!=$page.numPerPage}
				<option value="{$thisNumPerPage}">{$thisNumPerPage}</option>
					{/if}
				{/foreach}
			</select>
			<span>条，总共{$page.totalNum}条记录，合计{$page.totalPageNum}页</span>
		</div>

		<div class="pagination" targetType="navTab" totalCount="{$page.totalNum}" numPerPage="{$page.numPerPage}" pageNumShown="10" currentPage="{$page.pageNum}"></div>

	</div>
</div>