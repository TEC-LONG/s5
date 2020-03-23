
<div class="pageHeader">
	<form onsubmit="return navTabSearch(this);" action="{$url.smenu.url}" method="post">
	<div class="searchBar">
		<table class="searchContent">
			<tr>
				<td>
					组名：<input type="text" name="s_name" value="{$search.s_name}" />
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
			<li><a class="add" href="{$url.smenuAdUpd.url}" target="dialog" rel="{$url.smenuAdUpd.rel}" minable="false" width="750" height="320"><span>新增子菜单</span></a></li>
		</ul>
	</div>
	<table class="table" width="100%" layoutH="138">
		<thead>
			<tr>
				<th width="30">序号</th>
				{foreach $thead as $col}
				<th {if !empty($col.width)}width="{$col.width}"{/if}>{$col.ch}</th>
				{/foreach}
				<th width="120">操作</th>
			</tr>
		</thead>
		<tbody>
			{foreach $rows as $k=>$row}
			<tr target="sid_{$navTab}" rel="{$row.id}">
				<td>{$k+1}</td>
				<td>{$row.name}</td>
				<td>{$row.route}</td>
				<td>{$request_type[$row.request_type]}</td>
				<td>{$row.navtab}</td>
				<td>{if $row.menu__id!=0}{$level3[$row['menu__id']]}{else} - {/if}</td>
				<td>{if $row.parent_id!=0}{$parent_names[$row['parent_id']]}{else} - {/if}</td>
				<td>{$row.link_href}</td>
				<td>{$row.id}</td>
				<td>
					<a title="确实要删除？" target="ajaxTodo" href="{$url.del.url}?tb=smenu&id={$row['id']}" class="btnDel">删除</a>
					<a title="编辑子菜单" target="dialog" href="{$url.smenuAdUpd.url}?id={$row['id']}" class="btnEdit" rel="{$url.smenuAdUpd.rel}"  minable="false" width="650" height="440">编辑</a>
				</td>
			</tr>
			{/foreach}
		</tbody>
	</table>

	<form id="pagerForm" method="get" action="{$url.group.url}">
		<input type="hidden" name="pageNum" value="1" />
		<input type="hidden" name="numPerPage" value="{$page.numPerPage}" />
		<input type="hidden" name="s_name" value="{$search.s_name}" />
		<!-- <input type="hidden" name="s_mem_acc" value="{$search.s_mem_acc}" />
		<input type="hidden" name="s_mem_pwd" value="{$search.s_mem_pwd}" /> -->
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