<form id="pagerForm" method="post" action="{$url.index}">
	<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="{$page.numPerPage}" />
</form>

<div class="pageHeader">
	<form onsubmit="return navTabSearch(this);" action="demo_page1.html" method="post" onreset="$(this).find('select.combox').comboxReset()">
	<div class="searchBar">
		<table class="searchContent">
			<tr>
				<td>
					exp标题：<input type="text" name="keyword" />
				</td>
				<td>
					所属exp分类：
					<input class="required" name="expcat.cat1name" type="text" readonly/>
					<input class="required" name="expcat.cat2name" type="text" readonly/>
					<input class="required" name="expcat.cat3name" type="text" readonly/>
					<a class="btnLook" href="{$url.catLookup}" lookupGroup="expcat">查找带回</a>
				</td>
				<td class="dateRange">
					建档日期:
					<input name="startDate" class="date readonly" readonly="readonly" type="text" value="">
					<span class="limit">-</span>
					<input name="endDate" class="date readonly" readonly="readonly" type="text" value="">
				</td>
			</tr>
		</table>
		<div class="subBar">
			<ul>
				<li><div class="button"><div class="buttonContent"><button type="reset">重置1</button></div></div></li>
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit">检索</button></div></div></li>
				<li><a class="button" href="demo_page6.html" target="dialog" mask="true" title="查询框"><span>高级检索</span></a></li>
			</ul>
		</div>
	</div>
	</form>
</div>
<div class="pageContent">
	<div class="panelBar">
		<ul class="toolBar">
			<li><a class="add" href="{$url.ad.url}" target="navTab" rel="{$url.ad.rel}"><span>添加</span></a></li>
			<li><a class="delete" href="{$url.del}&id={ldelim}sid_user}" target="ajaxTodo" title="确定要删除吗?"><span>删除</span></a></li>
			<li><a class="edit" href="{$url.upd.url}&id={ldelim}sid_user}" target="navTab" rel="{$url.upd.rel}"><span>修改</span></a></li>
			<li class="line">line</li>
			<li><a class="icon" href="demo/common/dwz-team.xls" target="dwzExport" targetType="navTab" title="实要导出这些记录吗?"><span>导出EXCEL</span></a></li>
		</ul>
	</div>
	<table class="table" width="100%" layoutH="138">
		<thead>
			<tr>
				<th width="80">#</th>
				<th width="120">标题</th>
				<th width="100">所属工程</th>
				<th width="150">ID</th>
			</tr>
		</thead>
		<tbody>
		{foreach $prorecords as $prorecords_key=>$prorecord}
			<tr target="sid_user" rel="{$prorecord.id}">
				<td>{$prorecords_key+1}</td>
				<td><a href="{$url.info}&id={$prorecord.id}" target="_blank">{$prorecord.title}</a></td>
				<td>{$belong_pro[$prorecord.belong_pro]}</td>
				<td>{$prorecord.id}</td>
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