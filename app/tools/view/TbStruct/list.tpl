<form id="pagerForm" method="post" action="#rel#">
	<input type="hidden" name="pageNum" value="{$pagination.now_page}" />
	<input type="hidden" name="numPerPage" value="{$pagination.numPerPage}" />
</form>

<div class="pageHeader">
	<form rel="pagerForm" onsubmit="return navTabSearch(this);" action="{$url.index}" method="post">
	<div class="searchBar">
		<ul class="searchContent">
			<li>
				<label>我的客户：</label>
				<input type="text" name="keywords" value=""/>
			</li>
			<li>
			<select class="combox" name="province">
				<option value="">所有省市</option>
				<option value="北京">北京</option>
			</select>
			</li>
		</ul>
		<div class="subBar">
			<ul>
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
			<li><a class="add" href="{$url.ad}" target="navTab" rel="{$navTab}_add"><span>添加基础表结构</span></a></li>
			<li><a class="add" href="{$url.robot}" target="navTab" rel="{$navTab}_robot"><span>智能后台</span></a></li>
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
					<a title="确实要删除？" target="ajaxTodo" href="{$url.del}&id={$row['id']}" class="btnDel">删除</a>
					<a title="表信息编辑【{$row['id']}】" target="navTab" href="{$url.upd}&id={$row['id']}" class="btnEdit" rel="{$navTab}_upd{$row['id']}">表信息编辑</a>
				</td>
			</tr>
			{/foreach}
		</tbody>
	</table>
	<div class="panelBar">
		<div class="pages">
			<span>显示</span>
			{literal}
			<select class="combox" name="numPerPage" onchange="navTabPageBreak({numPerPage:this.value})">
			{/literal}
			{$pagehtml}
			</select>
			<span>条，共{$pagination.total_rows}条，{$pagination.total_num_pagination}页</span>
		</div>
		
		<div class="pagination" targetType="navTab" totalCount="{$pagination.total_rows}" numPerPage="{$pagination.numPerPage}" pageNumShown="4" currentPage="{$pagination.now_page}"></div>

	</div>
</div>
        