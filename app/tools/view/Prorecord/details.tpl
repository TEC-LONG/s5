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
					<span style="background-color: rgb(114, 114, 114);">已完成</span>
					&nbsp;&nbsp;
					<span style="font-size: medium;">周期开始：{date('Y-m-d H:i', $this_everyday_things.b_time)}</span>
					<span style="font-size: medium;"> ~ 周期结束：{date('Y-m-d H:i', $this_everyday_things.e_time)}</span>
				</td>
			</tr>
		</table>
	</div>
</div>

<div class="tools_prorecord_everyday_details_pageContent" style="border-left:1px #B8D0D6 solid;border-right:1px #B8D0D6 solid">
	<div class="panelBar">
		<ul class="toolBar">
			<li><a class="add" href="{$url.ad.url}?edths_id={$everyday_things__id}" target="dialog" rel="{$url.ad.rel}" minable="false" width="650" height="440"><span>添加日程细节</span></a></li>
			<li class="line">line</li>
			<li><a class="delete" href="javacript:void(0);" title="确定要删除吗?"><span>删除细节点</span></a></li>
			<li class="line">line</li>
			<li><a class="edit" href="javacript:void(0);" title="编辑日程细节"><span>编辑日程细节</span></a></li>
		</ul>
	</div>
	
	<div class="container" style="background-color: #fbffbe;">
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
	<ul class="timeLine" width="100%" layoutH="117">
		{foreach $rows as $k=>$row}
		<li>
			<p>{date('H:i:s', $row['post_date'])}</p>
			<div class="con">
				<input type="radio" name="id" value="{$row.id}" />&nbsp;&nbsp;
				{if !empty($row['b_time'])}{date('m-d H:i', $row['b_time'])}{/if}
            	{if !empty($row['e_time'])} ~ {date('m-d H:i', $row['e_time'])}{/if}
				<br/>
				<div style="margin-top: 10px;">
					<strong style="color:rgb(255, 17, 148);">备注内容：</strong>{if !empty($row['content'])}<br/>
					<div style="margin-top: 5px;font-size: medium;">
						{htmlspecialchars_decode($row['content'])}{else}无{/if}
					</div>
				</div>
				
			</div>
		</li>
		{/foreach}
	</ul>
<script>
$('.tools_prorecord_everyday_details_pageContent').find('.timeLine').find('input[type="radio"]').bind('click', function(){
	$('.tools_prorecord_everyday_details_pageContent').find('.edit').attr('href', '{$url.upd.url}?id='+$(this).val()+'&edths_id={$everyday_things__id}');
	$('.tools_prorecord_everyday_details_pageContent').find('.edit').attr('rel', '{$url.upd.rel}');
	$('.tools_prorecord_everyday_details_pageContent').find('.delete').attr('href', '{$url.del.url}?id='+$(this).val());
});

{literal}
$('.tools_prorecord_everyday_details_pageContent').find('.edit').bind('click', function () {
	console.log(this.href)
	if (this.href!=='javacript:void(0);') {
		$.pdialog.open(this.href, this.rel, this.title, {'width':650,'height':440,'minable':false,'mask':true,'resizable':true,'drawable':true});
	}
	return false;
});
{/literal}
$('.tools_prorecord_everyday_details_pageContent').find('.delete').bind('click', function () {
	$(this).click(function(event){
		var $this = $(this);
		var title = $this.attr("title");
		if (title) {
			alertMsg.confirm(title, {
				okCall: function(){
					ajaxTodo($this.attr("href"));
				}
			});
		} else {
			ajaxTodo($this.attr("href"));
		}
		event.preventDefault();
	});
});
</script>
	</div>

	<div class="panelBar"></div>
</div>