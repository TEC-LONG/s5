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

<div class="pageContent" style="border-left:1px #B8D0D6 solid;border-right:1px #B8D0D6 solid">
<div class="panelBar">
		<ul class="toolBar">
			<li><a class="add" href="demo/pagination/dialog2.html" target="dialog" mask="true"><span>添加</span></a></li>
			<li><a class="delete" href="demo/pagination/ajaxDone3.html?uid=" target="ajaxTodo" title="确定要删除吗?"><span>删除</span></a></li>
			<li><a class="edit" href="demo/pagination/dialog2.html?uid=" target="dialog" mask="true"><span>修改</span></a></li>
			<li class="line">line</li>
			<li><a class="icon" href="demo/common/dwz-team.xls" target="dwzExport" title="实要导出这些记录吗?"><span>导出EXCEL</span></a></li>
		</ul>
	</div>
{literal}
<style>
* {margin: 0;padding: 0;}

.timeLine {margin: 20px auto 0;overflow: hidden;position: relative;}
.timeLine li {background: url(public/tools/cssjz/back1.png) repeat-y 179px 0;padding-bottom: 30px;zoom: 1;display: flex;}
.timeLine li:after {content:" ";display: block;height: 0;clear: both;visibility: hidden;}
.timeLine li:last-child {background:none !important;}
.timeLine li p {background:url(public/tools/cssjz/icon1.jpg) no-repeat 172px 0;display:inline-block;width:168px;font-size: 16px;text-align:right;padding-right:20px;color:#1296db;}
.timeLine li p span {display: block;color: #6fceff;font-size: 12px;}
.timeLine li .con {width: calc(100% - 230px);display:inline-block;padding-left: 30px;}
.timeLine li .con img{max-width: 100%;}

/* .on  */
.timeLine li.on{background: url(public/tools/cssjz/back2.png) repeat-y 179px 0;}
.timeLine li.on p {background:url(public/tools/cssjz/images/icon2.jpg) no-repeat 172px 0;color: #1db702;}
.timeLine li.on p span {color: #a8dda3;}

/* .on 下面的li  */
.timeLine li.on ~ li{background: url(public/tools/cssjz/back3.png) repeat-y 179px 0;}
.timeLine li.on ~ li p {background:url(public/tools/cssjz/icon3.jpg) no-repeat 172px 0;color: #c3c3c3;}
.timeLine li.on ~ li p span {color: #d0d0d0;}
</style>
{/literal}
	<ul class="timeLine" width="100%" layoutH="138">
		{foreach $rows as $k=>$row}
		<li>
			<p>{date('H:i', $row['post_date'])}<span>{date('Y年m月d日', $row['post_date'])}</span>{$row['title']}</p>
			<div class="con">
				<input type="radio" name="id" value="{$row.id}" />&nbsp;&nbsp;
				{if !empty($row['begin_time'])}事件开始时间：{date('Y-m-d H:i', $row['begin_time'])}<br/>{/if}
				{if !empty($row['end_time'])}事件结束时间：{date('Y-m-d H:i', $row['end_time'])}<br/>{/if}
				备注内容：{if !empty($row['descr'])}{htmlspecialchars_decode($row['descr'])}{else}无{/if}
			</div>
		</li>
		{/foreach}
	</ul>
<script>
$('.tools_event_index_pageContent').find('.timeLine').find('input[type="radio"]').bind('click', function(){
	$('.tools_event_index_pageContent').find('.edit').attr('href', '{$url.upd.url}&id='+$(this).val());
	$('.tools_event_index_pageContent').find('.delete').attr('href', '{$url.del.url}&id='+$(this).val());
});
</script>
	<div class="panelBar"></div>
</div>