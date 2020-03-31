
<div class="pageHeader">
	<form onsubmit="return navTabSearch(this);" action="{$url.index.url}" method="get">
	<div class="searchBar">
		<table class="searchContent">
			<tr>
				<td>
					菜品：<input type="text" name="s_cai" value="{if isset($search.s_cai)}{$search.s_cai}{/if}" />
				</td>
				<td>
					适用时段：
					{foreach $types as $key=>$val}
					<input type="checkbox" name="s_types[]" value="{$key}" {if in_array($key, $search.s_types)}checked{/if} />{$val}&nbsp;&nbsp;&nbsp;&nbsp;
					{/foreach}
				</td>
				<td>
					主类型：
					{foreach $main_type as $key=>$val}
					<input type="checkbox" name="s_main_type[]" value="{$key}" {if in_array($key, $search.s_main_type)}checked{/if} />{$val}&nbsp;&nbsp;&nbsp;&nbsp;
					{/foreach}
				</td>
				<td>
					<div class="buttonActive"><div class="buttonContent"><button type="submit">检索</button></div></div>
				</td>
			</tr>
		</table>
		<div class="subBar">
			<ul>
				<!-- <li><div class="buttonActive"><div class="buttonContent"><button type="submit">检索</button></div></div></li> -->
				<!-- <li><a class="button" href="demo_page6.html" target="dialog" mask="true" title="查询框"><span>高级检索</span></a></li> -->
			</ul>
		</div>
	</div>
	</form>
</div>
<div class="pageContent">
	<div class="panelBar">
		<ul class="toolBar">
			<li><a class="add" href="{$url.edit.url}" target="navTab" rel="{$url.edit.rel}"><span>添加菜品</span></a></li>
			<li><a class="delete" href="{$url.del.url}?id={ldelim}sid_{$navTab}}" target="ajaxTodo" title="确定要删除吗?"><span>删除</span></a></li>
			<li><a class="edit" href="{$url.edit.url}?id={ldelim}sid_{$navTab}}" target="navTab"  rel="{$url.edit.rel}"><span>修改菜品</span></a></li>
			<!-- <li class="line">line</li>
			<li><a class="icon" href="demo/common/dwz-team.xls" target="dwzExport" targetType="navTab" title="实要导出这些记录吗?"><span>导出EXCEL</span></a></li> -->
		</ul>
	</div>
	<table class="table" width="100%" layoutH="138">
		<thead>
			<tr>
				<th width="30">序号</th>
				{foreach $thead as $col}
				<th {if isset($col.width)}width="{$col.width}"{/if}>{$col.ch}</th>
				{/foreach}
			</tr>
		</thead>
		<tbody>
			{foreach $rows as $k=>$row}
			<tr target="sid_{$navTab}" rel="{$row.id}">
				<td>{$k+1}</td>
				<td>{$row.cai}</td>
				<td>{$row.types}</td>
				<td>{$row.main_type}</td>
				<td>{$row.second_type}</td>
				<td>{$row.taste}</td>
				<td>{$row.mouthfeel}</td>
				<td>{$row.effects}</td>
				<td>{$row.byeffect}</td>
				<td>{$row.id}</td>
			</tr>
			{/foreach}
		</tbody>
	</table>

	<form id="pagerForm" method="get" action="{$url.index.url}">
		<input type="hidden" name="pageNum" value="1" />
		<input type="hidden" name="numPerPage" value="{$page.numPerPage}" />
		<input type="hidden" name="cai" value="{$search.cai}" />
		{foreach $search.s_types as $val}
		<input type="hidden" name="s_types[]" value="{$val}"/>
		{/foreach}
		{foreach $search.s_main_type as $val}
		<input type="hidden" name="s_main_type[]" value="{$val}"/>
		{/foreach}
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