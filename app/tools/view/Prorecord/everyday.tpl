<div class="pageContent">

	<div id="tools_everyday_things" class="unitBox" style="float:left; display:block; overflow:auto; width:714px;">
		<div class="pageHeader" style="border:1px #B8D0D6 solid">
			<form id="pagerForm" onsubmit="return divSearch(this, 'tools_everyday_things');" action="demo/pagination/list2.html" method="post">
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
		<div class="pageContent" style="border-left:1px #B8D0D6 solid;border-right:1px #B8D0D6 solid;height:900px;">
			<div class="panelBar">
				<ul class="toolBar">
					<li><a class="add" href="{$url.ad.url}" target="dialog" rel="{$url.ad.rel}" minable="false" width="750" height="270"><span>添加日程</span></a></li>
					<li class="line">line</li>
					<a class="delete" href="{$url.upd.url}&id={ldelim}sid_{$navTab}}"><span>删除日程</span></a>
					<li class="line">line</li>
					<a class="edit" href="{$url.upd.url}&id={ldelim}sid_{$navTab}}" target="dialog" rel="{$url.upd.rel}" minable="false" width="750" height="270"><span>编辑日程</span></a>
					<li class="line">line</li>
					<li><a class="add" href="{$url.ad.url}" target="dialog" rel="{$url.ad.rel}" minable="false" width="750" height="270"><span>尚未开始的日程</span></a></li>
					<li class="line">line</li>
					<li><a class="add" href="{$url.ad.url}" target="dialog" rel="{$url.ad.rel}" minable="false" width="750" height="270"><span>今日做完的日程</span></a></li>
				</ul>
			</div>
{literal}
<style type="text/css">
.tr0{background-color: rgb(49, 255, 142);}
.tr1{background-color: rgb(232, 157, 255);}
.tr2{background-color: rgb(255, 201, 85);}
.tr3{background-color: rgb(255, 110, 85);}
.tr4{background-color: rgb(114, 114, 114);}

tr.tools_prorecord_everyday_tr:hover
{
background-color:rgb(99, 98, 97)
}
</style>
{/literal}
			<table class="table" width="100%" layoutH="120" style="background-color: rgb(255, 110, 85)">
				<thead>
					<tr>
						<th width="50">#</th>
						<th width="56">完全做完</th>
						<th width="40">类型</th>
						<th>事情</th>
					</tr>
				</thead>
				<tbody>
					{foreach $things as $k=>$thing}
					<tr target="sid_{$navTab}" rel="{$thing.id}" class="tools_prorecord_everyday_tr {if !empty($thing.clock_in_time)}tr4{elseif $thing.characte==0}tr0{elseif $thing.characte==1}tr1{elseif $thing.characte==2}tr2{elseif $thing.characte==3}tr3{/if}">
						<td>{$thing.id}</td>
						<td><a href="{$url.everyday.url}&id={$thing.id}&stat=1" target="navTab" rel="{$url.everyday.rel}" class="btnSelect" title="每日日程安排"></a></td>
						<td>{$type[$thing.type]}</td>
						<td align="right">
							{if empty($thing.clock_in_time)}
							<a href="{$url.everyday.url}&id={$thing.id}" target="navTab" rel="{$url.everyday.rel}" class="btnSelect" title="每日日程安排"></a>
							{/if}
							<a href="{$url.details.url}&id={$thing.id}" target="ajax" rel="tools_everyday_things_details" style="font-size:medium; text-decoration:none;">
								{if !empty($thing.clock_in_time)}
								<s style="font-size:medium;">{$thing.title}</s>
								{else}
								{$thing.title}
								{/if}
							</a>
						</td>
					</tr>
					{/foreach}
				</tbody>
			</table>
			<div class="panelBar">
				<div class="pages">
					<span>显示</span>
					<select class="combox" name="numPerPage" onchange="navTabPageBreak(, 'tools_everyday_things')">
						<option value="20">20</option>
						<option value="50">50</option>
						<option value="100">100</option>
						<option value="200">200</option>
					</select>
					<span>条，共2条</span>
				</div>
				
				<div class="pagination" rel="tools_everyday_things" totalCount="200" numPerPage="20" pageNumShown="5" currentPage="1"></div>

			</div>
		</div>
	</div>
	
	<div id="tools_everyday_things_details" class="unitBox" style="margin-left:720px;">
		<div class="pageHeader" style="border:1px #B8D0D6 solid">
			<div class="searchBar">
				<table class="searchContent">
					<tr>
						<td>
							<span>颜色说明</span>
							<span style="background-color: rgb(255, 110, 85);">紧急-重要</span>
							<span style="background-color: rgb(255, 201, 85);">紧急-不重要</span>
							<span style="background-color: rgb(232, 157, 255);">不紧急-重要</span>
							<span style="background-color: rgb(49, 255, 142);">不紧急-不重要</span>
							<span style="background-color: rgb(114, 114, 114);">当日已完成</span>
							<!-- <span style="background-color: rgb(253, 255, 147);">已过期-未确认</span> -->
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>