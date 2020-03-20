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
					exp标题：<input type="text" name="title" />
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
			<li><a class="add" href="{$url.ad.url}" target="_blank"><span>添加EXP</span></a></li>
			<li class="line">line</li>
			<li><a class="icon" href="demo/common/dwz-team.xls" target="dwzExport" targetType="navTab" title="实要导出这些记录吗?"><span>导出EXCEL</span></a></li>
		</ul>
	</div>
	<table class="table" width="100%" layoutH="138">
		<thead>
			<tr>
				<th width="80">#</th>
				<th width="120">标题</th>
				<th width="100">添加时间</th>
				<th width="100">标签</th>
				<th width="100">所属分类</th>
				<th width="150">文章id</th>
				<th width="150">操作</th>
			</tr>
		</thead>
		<tbody>
		{foreach $exps as $exps_key=>$exp}
			<tr target="sid_user" rel="{$exp.id}">
				<td>{$exps_key+1}</td>
				<td><a href="{$url.info}?id={$exp.id}" target="_blank">{$exp.title}</a></td>
				<td>{date('Y-m-d H:i', $exp.post_date)}</td>
				<td>{$exp.tags}</td>
				<td>{str_replace('|', ' >> ', $exp.crumbs_expcat_names)}</td>
				<td>{$exp.id}</td>
				<td>
					<a title="确实要删除？" target="ajaxTodo" href="{$url.del}?id={$exp['id']}" class="btnDel">删除</a>
					<a title="编辑EXP" target="_blank" href="{$url.upd.url}?id={$exp['id']}" class="btnEdit">编辑</a>
				</td>
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