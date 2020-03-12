
<div class="pageHeader">
	<form onsubmit="return navTabSearch(this);" action="{$url.index.url}" method="post" onreset="$(this).find('select.combox').comboxReset()">
	<div class="searchBar">
		<table class="searchContent">
			<tr>
				<td>
					acc数据：<input type="text" name="s_mem_acc" value="{$search.s_mem_acc}" />
				</td>
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
			<li><a class="add" href="{$url.accAdUpd.url}" target="dialog" rel="{$url.accAdUpd.rel}" minable="false" width="750" height="160"><span>新增acc数据</span></a></li>
			<li><a class="edit" href="{$url.accIndex.url}" target="dialog" rel="{$url.accIndex.rel}" minable="false" width="750" height="600"><span>acc数据列表</span></a></li>
			<li class="line">line</li>
			<li><a class="add" href="{$url.pwdAdUpd.url}" target="dialog" rel="{$url.pwdAdUpd.rel}" minable="false" width="750" height="160"><span>新增pwd数据</span></a></li>
			<li><a class="edit" href="{$url.pwdIndex.url}" target="dialog" rel="{$url.pwdIndex.rel}" minable="false" width="750" height="600"><span>pwd数据列表</span></a></li>
			<li class="line">line</li>
			<li><a class="add" href="{$url.belongsToAdUpd.url}" target="dialog" rel="{$url.belongsToAdUpd.rel}" minable="false" width="750" height="160"><span>新增归属方</span></a></li>
			<li><a class="edit" href="{$url.belongsToIndex.url}" target="dialog" rel="{$url.belongsToIndex.rel}" minable="false" width="750" height="600"><span>归属方数据列表</span></a></li>
			<li class="line">line</li>
			<li><a class="add" href="{$url.adUpd.url}" target="dialog" rel="{$url.adUpd.rel}" minable="false" width="650" height="440"><span>新增acc-pwd映射</span></a></li>
		</ul>
	</div>
	<table class="table" width="100%" layoutH="138">
		<thead>
			<tr>
				<th width="30"><input type="checkbox" group="ids" class="checkboxCtrl"></th>
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
				<td><input name="ids" value="{$row.id}" type="checkbox"></td>
				<td>{$k+1}</td>
				<td>{$row.id}</td>
				<td>{$row.bt}</td>
				<td>{$row.mem_acc}</td>
				<td>{$row.mem_pwd}</td>
				<td>{$row.tags}</td>
				<td>
					<a title="确实要删除？" target="ajaxTodo" href="{$url.del.url}&id={$row['id']}" class="btnDel">删除</a>
					<a title="修改映射信息" target="dialog" href="{$url.adUpd.url}&id={$row['id']}" class="btnEdit" rel="{$url.adUpd.rel}"  minable="false" width="650" height="440">编辑</a>
				</td>
			</tr>
			{/foreach}
		</tbody>
	</table>

	<form id="pagerForm" method="post" action="{$url.index}">
		<input type="hidden" name="pageNum" value="1" />
		<input type="hidden" name="numPerPage" value="{$page.numPerPage}" />
		<input type="hidden" name="s_mem_acc" value="{$search.s_mem_acc}" />
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