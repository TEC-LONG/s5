<div class="pageHeader">
	<form onsubmit="return dialogSearch(this);" action="{$url.pwdIndex.url}" method="get" onreset="$(this).find('select.combox').comboxReset()">
	<div class="searchBar">
		<table class="searchContent">
			<tr>
				<td>
					pwd数据：<input type="text" name="s_mem_pwd" value="{$search.s_mem_pwd}" />
				</td>
			</tr>
		</table>
		<div class="subBar">
			<ul>
				<li><div class="button"><div class="buttonContent"><button type="reset">重置</button></div></div></li>
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit">检索</button></div></div></li>
			</ul>
		</div>
	</div>
	</form>
</div>
<div class="pageContent">
	<div class="panelBar">
		<ul class="toolBar">
			<li><a class="add" href="{$url.pwdAdUpd.url}" target="dialog" rel="{$url.pwdAdUpd.rel}" minable="false" width="750" height="160"><span>新增pwd数据</span></a></li>
		</ul>
	</div>
	<table class="table" width="100%" layoutH="138">
		<thead>
			<tr>
				<th width="30">序号</th>
				{foreach $thead as $col}
				<th {if !empty($col.width)}width="{$col.width}"{/if}>{$col.ch}</th>
				{/foreach}
				<th width="120">操作</th>
			</tr>
		</thead>
		<tbody>
			{foreach $rows as $k=>$row}
			<tr target="sid_{$navTab}" rel="{$row.id}">
				<td>{$k+1}</td>
				<td>{$row.id}</td>
				<td>
					{if $pwdIndexType=='lookup'}
					<a href="javascript:" onclick="$.bringBack({ldelim}mem_pwd__id:{$row.id}, mem_pwd:'{$row.mem_pwd}'{rdelim})">{$row.mem_pwd}</a>
					{else}
					{$row.mem_pwd}
					{/if}
				</td>
				<td>
					<a title="确实要删除？" target="ajaxTodo" href="{$url.del.url}?id={$row['id']}" class="btnDel">删除</a>
					<a title="修改密码数据" href="{$url.pwdAdUpd.url}?id={$row['id']}" class="btnEdit"  target="dialog" rel="{$url.pwdAdUpd.rel}" minable="false" width="750" height="160">编辑</a>
				</td>
			</tr>
			{/foreach}
		</tbody>
	</table>

	<form id="pagerForm" method="get" action="{$url.index}">
		<input type="hidden" name="pageNum" value="1" />
		<input type="hidden" name="numPerPage" value="{$page.numPerPage}" />
		<input type="hidden" name="s_mem_pwd" value="{$search.s_mem_pwd}" />
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
