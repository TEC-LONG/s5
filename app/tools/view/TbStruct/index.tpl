<form id="pagerForm" method="post" action="#rel#">
	<input type="hidden" name="pageNum" value="{$nowPage}" />
	<input type="hidden" name="numPerPage" value="{$numPerPage}" />
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
			<li><a class="add" href="{$addUrl}" target="navTab" rel="{$navTab}_add"><span>添加</span></a></li>
			<li class="line">line</li>
			<li><a class="icon" href="demo/common/dwz-team.xls" target="dwzExport" targetType="navTab" title="确实要导出这些记录吗?"><span>导出EXCEL</span></a></li>
		</ul>
	</div>
	<table class="table" width="1200" layoutH="138">
		<thead>
			<tr>
				<th width="10"><input type="checkbox" group="ids" class="checkboxCtrl"></th>
				<th width="20">序号</th>
				{foreach $mustShow as $col}
				<th width="{$col.width}">{$col.ch}</th>
				{/foreach}
				<th width="70">操作</th>
			</tr>
		</thead>
		<tbody>
			{foreach $data as $k=>$v}
			<tr target="sid_user" rel="{$v['id']}">
				<td><input name="ids" value="xxx" type="checkbox"></td>
				<td>{$k+1}</td>
				{$tbhtml}
				<td>
					<a title="确实要删除？" target="ajaxTodo" href="{$delUrl}/id/{$v['id']}" class="btnDel">删除</a>
					<a title="编辑【{$v['id']}】" target="navTab" href="{$editUrl}/id/{$v['id']}" class="btnEdit" rel="{$navTab}_edit{$v['id']}">编辑</a>
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
			<span>条，共{$totalCount}条，{$numPages}页</span>
		</div>
		
		<div class="pagination" targetType="navTab" totalCount="{$totalCount}" numPerPage="{$numPerPage}" pageNumShown="4" currentPage="{$nowPage}"></div>

	</div>
</div>
        