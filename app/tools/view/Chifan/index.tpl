
<div class="pageHeader">
	<form onsubmit="return navTabSearch(this);" action="{$url.index}" method="get" onreset="$(this).find('select.combox').comboxReset()">
	<div class="searchBar">
		<table class="searchContent">
			<tr>
				<td>
					菜品：<input type="text" name="cai" value="{$search.cai}" />
				</td>
				<td>
					适用场景：
					{foreach $types as $key=>$val}
					<input type="checkbox" name="types[]" value="{$key}" {if in_array($key, $search.types)}checked{/if} />{$val}&nbsp;&nbsp;&nbsp;&nbsp;
					{/foreach}
				</td>
				<td>
					食物类型：
					{foreach $food_types as $key=>$val}
					<input type="checkbox" name="food_types[]" value="{$key}" {if in_array($key, $search.food_types)}checked{/if} />{$val}&nbsp;&nbsp;&nbsp;&nbsp;
					{/foreach}
				</td>
				{* <td>
					口味：
					{foreach $taste as $key=>$val}
					<input type="checkbox" name="taste[]" value="{$key}" />{$val}&nbsp;&nbsp;&nbsp;&nbsp;
					{/foreach}
				</td>
				<td>
					口感：
					{foreach $mouthfeel as $key=>$val}
					<input type="checkbox" name="mouthfeel[]" value="{$key}" />{$val}&nbsp;&nbsp;&nbsp;&nbsp;
					{/foreach}
				</td>
				<td>
					功效：
					{foreach $effects as $key=>$val}
					<input type="checkbox" name="effects[]" value="{$key}" />{$val}&nbsp;&nbsp;&nbsp;&nbsp;
					{/foreach}
				</td>
				<td class="dateRange">
					建档日期:
					<input name="startDate" class="date readonly" readonly="readonly" type="text" value="">
					<span class="limit">-</span>
					<input name="endDate" class="date readonly" readonly="readonly" type="text" value="">
				</td> *}
			</tr>
		</table>
		<div class="subBar">
			<ul>
				<li><div class="button"><div class="buttonContent"><button type="reset">重置</button></div></div></li>
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
			<li><a class="add" href="{$url.ad.url}" target="navTab" rel="{$url.ad.rel}"><span>添加菜品</span></a></li>
			<li><a class="delete" href="{$url.del}&id={ldelim}sid_{$navTab}}" target="ajaxTodo" title="确定要删除吗?"><span>删除</span></a></li>
			<li><a class="edit" href="{$url.upd.url}?id={ldelim}sid_{$navTab}}" target="navTab"  rel="{$url.upd.rel}"><span>修改菜品</span></a></li>
			<li class="line">line</li>
			<li><a class="icon" href="demo/common/dwz-team.xls" target="dwzExport" targetType="navTab" title="实要导出这些记录吗?"><span>导出EXCEL</span></a></li>
		</ul>
	</div>
	<table class="table" width="100%" layoutH="138">
		<thead>
			<tr>
				<th width="30"><input type="checkbox" group="ids" class="checkboxCtrl"></th>
				<th width="30">序号</th>
				{foreach $mustShow as $col}
				<th {if !empty($col.width)}width="{$col.width}"{/if}>{$col.ch}</th>
				{/foreach}
			</tr>
		</thead>
		<tbody>
			{$tbhtml}
		</tbody>
	</table>

	<form id="pagerForm" method="get" action="{$url.index}">
		<input type="hidden" name="pageNum" value="1" />
		<input type="hidden" name="numPerPage" value="{$page.numPerPage}" />
		<input type="hidden" name="cai" value="{$search.cai}" />
		{foreach $search.types as $val}
		<input type="hidden" name="types[]" value="{$val}"/>
		{/foreach}
		{foreach $search.food_types as $val}
		<input type="hidden" name="food_types[]" value="{$val}"/>
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