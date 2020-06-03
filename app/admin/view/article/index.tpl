<form id="pagerForm" method="get" action="{$url.index}">
	<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="{$page.numPerPage}" />
</form>

<div class="pageHeader">
	<form onsubmit="return navTabSearch(this);" action="{$page.index}" method="get" onreset="$(this).find('select.combox').comboxReset()">
	<div class="searchBar">
		<table class="searchContent">
			<tr>
				<td>
					标题：<input type="text" name="title" />
				</td>
				<td>
					所属分类：
					<input class="required" name="expcat.cat1name" type="text" readonly/>
					<input class="required" name="expcat.cat2name" type="text" readonly/>
					<input class="required" name="expcat.cat3name" type="text" readonly/>
					<a class="btnLook" href="" lookupGroup="expcat">查找带回</a>
				</td>
				<td class="dateRange">
					建档日期:
					<input name="startDate" class="date readonly" readonly="readonly" type="text" value="">
					<span class="limit">-</span>
					<input name="endDate" class="date readonly" readonly="readonly" type="text" value="">
				</td>
				<td>
					<div class="buttonActive"><div class="buttonContent"><button type="submit">检索</button></div></div>
				</td>
			</tr>
		</table>
		<div class="subBar">
			<ul>
				<!-- <li><div class="button"><div class="buttonContent"><button type="reset">重置1</button></div></div></li> -->
				<li></li>
				<!-- <li><a class="button" href="demo_page6.html" target="dialog" mask="true" title="查询框"><span>高级检索</span></a></li> -->
			</ul>
		</div>
	</div>
	</form>
</div>
<div class="pageContent">
	<div class="panelBar">
		<ul class="toolBar">
			<li><a class="add" href="{$url.ad.url}" target="_blank"><span>添加文章</span></a></li>
			<li><a class="delete" href="{$url.del.url}?id={ldelim}sid_{$navTab}}" target="ajaxTodo" title="确定要删除吗?"><span>删除</span></a></li>
			<li><a class="edit" href="{$url.upd.url}?id={ldelim}sid_{$navTab}}" target="navTab"  rel="{$url.upd.rel}"><span>编辑文章</span></a></li>
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
				<td>{$row.title}</td>
				<td>{$row.post_date}</td>
				<td>{$row.article_category__id}</td>
				<td>{$row.tags}</td>
				<td>{$row.upd_time}</td>
				<td>{$row.expnew__id}</td>
				<td>{$row.expnew__id}</td>
				<td>{$row.id}</td>
			</tr>
			{/foreach}
		</tbody>
	</table>
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