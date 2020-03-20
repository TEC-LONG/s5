<div class="pageHeader">
	<form rel="pagerForm" onsubmit="return navTabSearch(this);" action="{$url.index}" method="get">
	<div class="searchBar">
		<ul class="searchContent">
			<li>
				<label>表中文名：</label>
				<input type="text" name="ch_name" value="{$search.ch_name}"/>
			</li>
			<li>
				<label>表英文名：</label>
				<input type="text" name="en_name" value="{$search.en_name}"/>
			</li>
			<li>
				<label>包含字段：</label>
				<input type="text" name="en_fields" value="{$search.en_fields}"/>
			</li>
			<li>
			<select class="combox" name="belong_db">
				<option value="">所属库名称</option>
				{foreach $belong_db as $k=>$v}
				<option value="{$k}" {if $search.belong_db==(string)$k}selected{/if}>{$v}</option>
				{/foreach}
			</select>
			</li>
		</ul>
		<div class="subBar">
			<ul>
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit">检索</button></div></div></li>
				<!-- <li><a class="button" href="demo_page6.html" target="dialog" mask="true" title="查询框"><span>高级检索</span></a></li> -->
			</ul>
		</div>
	</div>
	</form>
</div>

<div class="pageContent">
	<div class="panelBar">
		<ul class="toolBar">
			<li><a class="add" href="{$url.ad}" target="navTab" rel="{$navTab}_add"><span>添加基础表结构</span></a></li>
			<li class="line">line</li>
			<li><a class="icon" href="demo/common/dwz-team.xls" target="dwzExport" targetType="navTab" title="确实要导出这些记录吗?"><span>导出EXCEL</span></a></li>
		</ul>
	</div>
	<table class="table" width="100%" layoutH="138">
		<thead>
			<tr>
				<th width="30"><input type="checkbox" group="ids" class="checkboxCtrl"></th>
				<th width="80">序号</th>
				{foreach $mustShow as $col}
				<th {if !empty($col.width)}width="{$col.width}"{/if}>{$col.ch}</th>
				{/foreach}
				<th width="70">操作</th>
			</tr>
		</thead>
		<tbody>
			{foreach $rows as $k=>$row}
			<tr target="sid_user" rel="{$row['id']}">
				<td><input name="ids" value="xxx" type="checkbox"></td>
				<td>{$k+1}</td>
				{foreach $mustShow as $mustShow_key=>$field}
				{if $mustShow_key=='belong_db'}
				<td>{$belong_db[$row[$mustShow_key]]}</td>
				{elseif $mustShow_key=='has_special_field'}
				<td>{$has_special_field[$row[$mustShow_key]]}</td>
				{elseif $mustShow_key=='has_relate_field'}
				<td>{$has_relate_field[$row[$mustShow_key]]}</td>
				{elseif $mustShow_key=='post_date'}
				<td>{date('Y-m-d H:i:s', $row[$mustShow_key])}</td>
				{else}
				<td>{$row[$mustShow_key]}</td>
				{/if}
				{/foreach}
				<td>
					<a title="确实要删除？" target="ajaxTodo" href="{$url.del}?id={$row['id']}" class="btnDel">删除</a>
					<a title="表信息编辑" target="navTab" href="{$url.upd}?id={$row['id']}" class="btnEdit" rel="{$navTab}_upd">表信息编辑</a>
				</td>
			</tr>
			{/foreach}
		</tbody>
	</table>
	<form id="pagerForm" method="get" action="{$url.index}">
		<input type="hidden" name="pageNum" value="1" />
		<input type="hidden" name="numPerPage" value="{$page.numPerPage}" />
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

		<div class="pagination" targetType="navTab" totalCount="{$page.totalNum}" numPerPage="{$page.numPerPage}" pageNumShown="10" currentPage="{$page.pageNum}" rel=""></div>

	</div>
</div>
        