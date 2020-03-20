{literal}
<form id="pagerForm" method="get" action="demo_page1.html">
	<input type="hidden" name="status" value="${param.status}">
	<input type="hidden" name="keywords" value="${param.keywords}" />
	<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="${model.numPerPage}" />
	<input type="hidden" name="orderField" value="${param.orderField}" />
</form>
{/literal}

<div class="pageHeader">
	<form onsubmit="return navTabSearch(this);" action="demo_page1.html" method="get" onreset="$(this).find('select.combox').comboxReset()">
	<div class="searchBar">
		<table class="searchContent">
			<tr>
				<td>
					exp标题：<input type="text" name="keyword" />
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
			<li><a class="delete" href="{$url.del}?id={ldelim}sid_user}" target="ajaxTodo" title="确定要删除吗?"><span>删除</span></a></li>
			<li><a class="edit" href="{$url.edit}?id={ldelim}sid_user}" target="navTab"><span>修改</span></a></li>
			<li class="line">line</li>
			<li><a class="icon" href="demo/common/dwz-team.xls" target="dwzExport" targetType="navTab" title="实要导出这些记录吗?"><span>导出EXCEL</span></a></li>
		</ul>
	</div>
	<table class="table" width="100%" layoutH="138">
		<thead>
			<tr>
				<th width="80">#</th>
				<th width="120">快捷键</th>
				<th width="100">快捷键说明</th>
				<th width="100">是否为多环境快捷键</th>
				<th width="100">多环境快捷键说明</th>
				<th width="150">数据ID</th>
			</tr>
		</thead>
		<tbody>
		{foreach $keys as $keys_key=>$key_val}
			<tr target="sid_user" rel="{$key_val.id}">
				<td>{$keys_key+1}</td>
				<td>{$key_val.shortcut}</td>
				<td>{$key_val.key_comment}</td>
				<td>{$key_val.is_multipart}</td>
				<td>{$key_val.key_multi_comment}</td>
				<td>{$key_val.id}</td>
			</tr>
		{/foreach}
		</tbody>
	</table>
	<div class="panelBar">
		{literal}
		<div class="pages">
			<span>显示</span>
			<select class="combox" name="numPerPage" onchange="navTabPageBreak({numPerPage:this.value})">
				<option value="20">20</option>
				<option value="50">50</option>
				<option value="100">100</option>
				<option value="150">150</option>
				<option value="200">200</option>
				<option value="250">250</option>
			</select>
			<span>条，共xxx条</span>
		</div>
		{/literal}

		<div class="pagination" targetType="navTab" totalCount="200" numPerPage="20" pageNumShown="10" currentPage="1"></div>

	</div>
</div>