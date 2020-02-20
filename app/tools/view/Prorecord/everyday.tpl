<div class="pageContent">

	<div id="jbsxBox2" class="unitBox" style="float:left; display:block; overflow:auto; width:714px;">
		<div class="pageHeader" style="border:1px #B8D0D6 solid">
			<form id="pagerForm" onsubmit="return divSearch(this, 'jbsxBox2');" action="demo/pagination/list2.html" method="post">
				<input type="hidden" name="pageNum" value="1" />
				<input type="hidden" name="numPerPage" value="" />
				<div class="searchBar">
					<table class="searchContent">
						<tr>
							<td>
								起止周期:
								<input name="b_time" class="date readonly" readonly="readonly" dateFmt="yyyy-MM-dd HH:mm" type="text" value="">
								<span class="limit">-</span>
								<input name="e_time" class="date readonly" readonly="readonly" dateFmt="yyyy-MM-dd HH:mm" type="text" value="">
							</td>
							<td><div class="buttonActive"><div class="buttonContent"><button type="submit">检索</button></div></div></td>
						</tr>
					</table>
				</div>
			</form>
		</div>
		<div class="pageContent" style="border-left:1px #B8D0D6 solid;border-right:1px #B8D0D6 solid">
			<div class="panelBar">
				<ul class="toolBar">
					<li><a class="add" href="{$url.ad.url}" target="dialog" rel="{$url.ad.rel}" minable="false" width="750" height="270"><span>添加日程</span></a></li>
					<li class="line">line</li>
					<li><a class="delete" href="{$url.del.url}&id={ldelim}sid_{$navTab}}" target="ajaxTodo" title="确定要删除吗?"><span>删除</span></a></li>
					<li class="line">line</li>
					<li><a class="edit" href="{$url.upd.url}&id={ldelim}sid_{$navTab}}" target="dialog" mask="true"><span>编辑日程</span></a></li>
					<li class="line">line</li>
					<li><a class="add" href="{$url.ad.url}" target="dialog" rel="{$url.ad.rel}" minable="false" width="750" height="270"><span>查看尚未开始的日程</span></a></li>
					<li class="line">line</li>
					<li><a class="add" href="{$url.ad.url}" target="dialog" rel="{$url.ad.rel}" minable="false" width="750" height="270"><span>查看已过期未确认的日程</span></a></li>
				</ul>
			</div>
			<table class="table" width="100%" layoutH="138">
				<thead>
					<tr>
						<th width="40">状态</th>
						<th width="140">性质</th>
						<th width="40">类型</th>
						<th>事情标题</th>
					</tr>
				</thead>
				<tbody>
					{foreach $things as $k=>$thing}
					<tr target="sid_{$navTab}" rel="{$thing.id}">
						<td>{$stat[$thing.stat]}</td>
						<td>{$character[$thing.character]}</td>
						<td>{$type[$thing.type]}</td>
						<td><a href="{$url.details.url}" target="ajax" rel="jbsxBox3">{$thing.title}</a></td>
					</tr>
					{/foreach}
				</tbody>
			</table>
			<div class="panelBar">
				<div class="pages">
					<span>显示</span>
					<select class="combox" name="numPerPage" onchange="navTabPageBreak(, 'jbsxBox2')">
						<option value="20">20</option>
						<option value="50">50</option>
						<option value="100">100</option>
						<option value="200">200</option>
					</select>
					<span>条，共2条</span>
				</div>
				
				<div class="pagination" rel="jbsxBox2" totalCount="200" numPerPage="20" pageNumShown="5" currentPage="1"></div>

			</div>
		</div>
	</div>
	
	<div id="jbsxBox3" class="unitBox" style="margin-left:720px;">
		<div class="pageHeader" style="border:1px #B8D0D6 solid">
			<div class="searchBar">
				<table class="searchContent">
					<tr>
						<td>
							<h1>日程细节</h1>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>


	
	
</div>