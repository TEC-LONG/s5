
<div class="pageHeader">
	<form onsubmit="return navTabSearch(this);" action="{$url.index.url}" method="get" onreset="$(this).find('select.combox').comboxReset()">
	<div class="searchBar">
		<table class="searchContent">
			<tr>
				<td>
					品牌名称：<input type="text" name="name" value="{$search.name}" />
				</td>
			</tr>
		</table>
		<div class="subBar">
			<ul>
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit">检索</button></div></div></li>
			</ul>
		</div>
	</div>
	</form>
</div>
<div class="pageContent">
	<div class="panelBar">
		<ul class="toolBar">
			<li><a class="add" href="{$url.ad.url}" target="navTab" rel="{$url.ad.rel}"><span>添加品牌</span></a></li>
			<li><a class="delete" href="{$url.del.url}?id={ldelim}sid_{$navTab}}" target="ajaxTodo" title="确定要删除吗?"><span>删除</span></a></li>
			<li><a class="edit" href="{$url.upd.url}?id={ldelim}sid_{$navTab}}" target="navTab"  rel="{$url.upd.rel}"><span>编辑品牌</span></a></li>
			<li class="line">line</li>
			<li><a class="icon" href="demo/common/dwz-team.xls" target="dwzExport" targetType="navTab" title="实要导出这些记录吗?"><span>导出EXCEL</span></a></li>
		</ul>
	</div>
	<table class="table" width="100%" layoutH="138">
		<thead>
			<tr>
				<th width="30"><input type="checkbox" group="ids" class="checkboxCtrl"></th>
				<th width="30">序号</th>
				<th width="30">品牌名称</th>
				<th width="30">logo图</th>
			</tr>
		</thead>
		<tbody>
			{foreach $rows as $k=>$row}
			<tr target="sid_{$navTab}" rel="{$row.id}">
				<td><input name="ids" value="{$row.id}" type="checkbox"></td>
				<td>{$k+1}</td>
				<td>{$row.name}</td>
				<td>{$row.logo_img}</td>
			</tr>
			{/foreach}
		</tbody>
	</table>

	<form id="pagerForm" method="get" action="{$url.index}">
		<input type="hidden" name="pageNum" value="1" />
		<input type="hidden" name="numPerPage" value="{$page.numPerPage}" />
		<input type="hidden" name="cai" value="" />
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