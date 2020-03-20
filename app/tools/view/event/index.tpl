
<div class="pageHeader tools_event_index_pageHeader">
	<form onsubmit="return navTabSearch(this);" action="{$url.index.url}" method="get" onreset="$(this).find('select.combox').comboxReset()">
	<div class="searchBar">
		<table class="searchContent">
			<tr>
				<td>
					事件标题关键字：<input type="text" name="title" value="{$search.title}" />
				</td>
				<td class="dateRange">
					创建时间:
					<input name="b_post_date" class="date readonly" readonly="readonly" type="text" value="{$search.b_post_date}">
					<span class="limit">-</span>
					<input name="e_post_date" class="date readonly" readonly="readonly" type="text" value="{$search.e_post_date}">
				</td>
				<td class="dateRange">
					事件开始时间:
					<input name="b_begin_time" class="date readonly" readonly="readonly" type="text" value="{$search.b_begin_time}">
					<span class="limit">-</span>
					<input name="e_begin_time" class="date readonly" readonly="readonly" type="text" value="{$search.e_begin_time}">
				</td>
				<td class="dateRange">
					事件结束时间:
					<input name="b_end_time" class="date readonly" readonly="readonly" type="text" value="{$search.b_end_time}">
					<span class="limit">-</span>
					<input name="e_end_time" class="date readonly" readonly="readonly" type="text" value="{$search.e_end_time}">
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
<div class="pageContent tools_event_index_pageContent">
	<div class="panelBar">
		<ul class="toolBar">
            <li><a class="add" href="{$url.ad.url}" target="dialog" rel="{$url.ad.rel}" minable="false" width="750" height="460"><span>添加事件</span></a></li>
			<li><a class="delete" href="{$url.del.url}?id={ldelim}sid_{$navTab}}" target="ajaxTodo" title="确定要删除吗?"><span>删除事件</span></a></li>
			<li><a class="edit" href="{$url.upd.url}?id={ldelim}sid_{$navTab}}" target="dialog"  rel="{$url.upd.rel}" minable="false" width="750" height="460"><span>修改事件</span></a></li>
		</ul>
	</div>
{literal}
<style>
	* {margin: 0;padding: 0;}

	.timeLine {margin: 20px auto 0;overflow: hidden;position: relative;margin-left: 200px;}
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
            {if !empty($row['begin_time'])}事件开始时间：{date('Y-m-d H:i', $row['begin_time'])}{/if}
            {if !empty($row['end_time'])} -- 事件结束时间：{date('Y-m-d H:i', $row['end_time'])}{/if}
            <br/>备注内容：{if !empty($row['descr'])}{htmlspecialchars_decode($row['descr'])}{else}无{/if}
        </div>
    </li>
    {/foreach}
<script>
$('.tools_event_index_pageContent').find('.timeLine').find('input[type="radio"]').bind('click', function(){
    $('.tools_event_index_pageContent').find('.edit').attr('href', '{$url.upd.url}?id='+$(this).val());
    $('.tools_event_index_pageContent').find('.delete').attr('href', '{$url.del.url}?id='+$(this).val());
});
</script>
</ul>
</div>